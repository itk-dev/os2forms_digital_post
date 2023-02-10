<?php

namespace Drupal\os2forms_digital_post\Helper;

use DataGovDk\Model\Core\Address;
use DigitalPost\MeMo\Action;
use DigitalPost\MeMo\AdditionalDocument;
use DigitalPost\MeMo\AttentionData;
use DigitalPost\MeMo\AttentionPerson;
use DigitalPost\MeMo\EntryPoint;
use DigitalPost\MeMo\File;
use DigitalPost\MeMo\MainDocument;
use DigitalPost\MeMo\Message;
use DigitalPost\MeMo\MessageBody;
use DigitalPost\MeMo\MessageHeader;
use DigitalPost\MeMo\Recipient;
use DigitalPost\MeMo\Sender;
use Drupal\Core\Render\ElementInfoManagerInterface;
use Drupal\os2forms_cpr_lookup\CPR\CprServiceResult;
use Drupal\os2forms_digital_post\Exception\InvalidAttachmentElementException;
use Drupal\os2forms_digital_post\Form\SettingsForm;
use Drupal\os2forms_digital_post\Plugin\WebformHandler\WebformHandlerSF1601;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\WebformTokenManagerInterface;
use Drupal\webform_attachment\Element\WebformAttachmentBase;
use ItkDev\Serviceplatformen\Service\SF1601\Serializer;
use ItkDev\Serviceplatformen\Service\SF1601\SF1601;

/**
 * MeMo helper.
 */
class MeMoHelper {
  public const DOCUMENT_CONTENT = 'content';
  public const DOCUMENT_SIZE = 'size';
  public const DOCUMENT_MIME_TYPE = 'mime-type';
  public const DOCUMENT_FILENAME = 'filename';
  public const DOCUMENT_LANGUAGE = 'language';
  public const DOCUMENT_LANGUAGE_DEFAULT = 'da';

  /**
   * Element info.
   *
   * @var \Drupal\Core\Render\ElementInfoManagerInterface
   */
  protected $elementInfoManager;

  /**
   * The webform token manager.
   *
   * @var \Drupal\webform\WebformTokenManagerInterface
   */
  protected $webformTokenManager;

  /**
   * Constructor.
   */
  public function __construct(ElementInfoManagerInterface $elementInfoManager, WebformTokenManagerInterface $webformTokenManager) {
    $this->elementInfoManager = $elementInfoManager;
    $this->webformTokenManager = $webformTokenManager;
  }

  /**
   * Build MeMo message.
   */
  public function buildMessage(WebformSubmissionInterface $submission, array $options, array $handlerSettings, array $submissionData = [], CprServiceResult $cprServiceResult = NULL): Message {
    $messageUUID = Serializer::createUuid();
    $messageID = Serializer::createUuid();

    $message = new Message();

    $label = $this->replaceTokens($options[WebformHandlerSF1601::SENDER_LABEL], $submission);
    $sender = (new Sender())
      ->setIdType($options[SettingsForm::SENDER_IDENTIFIER_TYPE])
      ->setSenderID($options[SettingsForm::SENDER_IDENTIFIER])
      ->setLabel($label);

    $recipient = (new Recipient())
      ->setIdType($options[WebformHelperSF1601::RECIPIENT_IDENTIFIER_TYPE])
      ->setRecipientID($options[WebformHelperSF1601::RECIPIENT_IDENTIFIER]);

    if (NULL !== $cprServiceResult) {
      $name = implode(' ', array_filter([
        $cprServiceResult->getFirstName(),
        $cprServiceResult->getMiddleName(),
        $cprServiceResult->getLastName(),
      ]));

      $recipient->setLabel($name);
      $address = (new Address())
        ->setCo('')
        ->setAddressLabel($cprServiceResult->getStreetName() ?: '')
        ->setHouseNumber($cprServiceResult->getHouseNumber() ?: '')
        ->setFloor($cprServiceResult->getFloor() ?: '')
        ->setDoor($cprServiceResult->getSide() ?: '')
        ->setZipCode($cprServiceResult->getPostalCode() ?: '')
        ->setCity($cprServiceResult->getCity() ?: '')
        ->setCountry('DA');
      $attentionData = (new AttentionData())
        ->setAttentionPerson((new AttentionPerson())
          ->setLabel($recipient->getLabel())
          ->setPersonID($recipient->getRecipientID())
        )
        ->setAddress($address);

      $recipient->setAttentionData($attentionData);
    }

    $label = $this->replaceTokens($options[WebformHandlerSF1601::MESSAGE_HEADER_LABEL], $submission);
    $messageHeader = (new MessageHeader())
      ->setMessageType(SF1601::MESSAGE_TYPE_DIGITAL_POST)
      ->setMessageUUID($messageUUID)
      ->setMessageID($messageID)
      ->setLabel($label)
      ->setMandatory(FALSE)
      ->setLegalNotification(FALSE)
      ->setSender($sender)
      ->setRecipient($recipient);

    $message->setMessageHeader($messageHeader);

    $body = (new MessageBody())
      ->setCreatedDateTime(new \DateTime());

    $document = $this->getMainDocument($submission, $handlerSettings);
    $attachments = $this->getAttachments($submission, $handlerSettings);

    $mainDocument = (new MainDocument())
      ->setFile([
        (new File())
          ->setEncodingFormat($document[self::DOCUMENT_MIME_TYPE])
          ->setLanguage($document[self::DOCUMENT_LANGUAGE])
          ->setFilename($document[self::DOCUMENT_FILENAME])
          ->setContent($document[self::DOCUMENT_CONTENT]),
      ]);

    if (isset($handlerSettings[WebformHandlerSF1601::MEMO_ACTIONS]['actions'])) {
      foreach ($handlerSettings[WebformHandlerSF1601::MEMO_ACTIONS]['actions'] as $spec) {
        $mainDocument->addToAction($this->buildAction($spec, $submission));
      }
    }

    $body->setMainDocument($mainDocument);

    foreach ($attachments as $attachment) {
      $additionalDocument = (new AdditionalDocument())
        ->setLabel($attachment['label'] ?? $attachment['filename'])
        ->setFile([
          (new File())
            ->setEncodingFormat($attachment[self::DOCUMENT_MIME_TYPE])
            ->setLanguage($attachment[self::DOCUMENT_LANGUAGE])
            ->setFilename($attachment[self::DOCUMENT_FILENAME])
            ->setContent($attachment[self::DOCUMENT_CONTENT]),
        ]);
      $body->addToAdditionalDocument($additionalDocument);
    }

    $message->setMessageBody($body);

    return $message;
  }

  /**
   * Convert MeMo message to DOM document.
   */
  public function message2dom(Message $message): \DOMDocument {
    $document = new \DOMDocument();
    $document->loadXML((new Serializer())->serialize($message));

    return $document;
  }

  /**
   * Build action.
   */
  private function buildAction(array $options, WebformSubmissionInterface $submission): Action {
    $label = $this->replaceTokens($options['label'], $submission);
    $action = (new Action())
      ->setActionCode($options['action'])
      ->setLabel($label);
    if (SF1601::ACTION_AFTALE === $options['action']) {
      throw new \RuntimeException(sprintf('Cannot handle action %s', $options['action']));
    }
    elseif ($options['url']) {
      $url = $this->replaceTokens($options['url'], $submission);
      $action->setEntryPoint(
        (new EntryPoint())
          ->setUrl($url)
          );
    }

    return $action;
  }

  /**
   * Get main document.
   *
   * @see WebformAttachmentController::download()
   */
  private function getMainDocument(WebformSubmissionInterface $submission, array $handlerSettings): array {
    // Lifted from Drupal\webform_attachment\Controller\WebformAttachmentController::download.
    $element = $handlerSettings[WebformHandlerSF1601::MEMO_MESSAGE][WebformHandlerSF1601::ATTACHMENT_ELEMENT];
    $element = $submission->getWebform()->getElement($element) ?: [];
    [$type] = explode(':', $element['#type']);
    $instance = $this->elementInfoManager->createInstance($type);
    if (!$instance instanceof WebformAttachmentBase) {
      throw new InvalidAttachmentElementException(sprintf('Attachment element must be an instance of %s. Found %s.', WebformAttachmentBase::class, get_class($instance)));
    }

    $fileName = $instance::getFileName($element, $submission);
    $mimeType = $instance::getFileMimeType($element, $submission);
    $content = $instance::getFileContent($element, $submission);

    return [
      self::DOCUMENT_CONTENT => $content,
      self::DOCUMENT_SIZE => strlen($content),
      self::DOCUMENT_MIME_TYPE => $mimeType,
      self::DOCUMENT_FILENAME => $fileName,
      self::DOCUMENT_LANGUAGE => self::DOCUMENT_LANGUAGE_DEFAULT,
    ];
  }

  /**
   * Get attachments.
   */
  private function getAttachments(WebformSubmissionInterface $submission, array $handlerSettings): array {
    return [];
  }

  /**
   * Replace tokens.
   */
  private function replaceTokens(string $text, WebformSubmissionInterface $submission): string {
    return $this->webformTokenManager->replace($text, $submission);
  }

}
