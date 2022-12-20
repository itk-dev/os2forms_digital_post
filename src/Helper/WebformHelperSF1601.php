<?php

namespace Drupal\os2forms_digital_post\Helper;

use DigitalPost\MeMo\AdditionalDocument;
use DigitalPost\MeMo\File;
use DigitalPost\MeMo\MainDocument;
use DigitalPost\MeMo\Message;
use DigitalPost\MeMo\MessageBody;
use DigitalPost\MeMo\MessageHeader;
use DigitalPost\MeMo\Recipient;
use DigitalPost\MeMo\Sender;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Render\ElementInfoManagerInterface;
use Drupal\os2forms_cpr_lookup\Service\CprServiceInterface;
use Drupal\os2forms_digital_post\Exception\InvalidAttachmentElementException;
use Drupal\os2forms_digital_post\Exception\InvalidRecipientIdentifierElementException;
use Drupal\os2forms_digital_post\Exception\SubmissionNotFoundException;
use Drupal\os2forms_digital_post\Form\SettingsForm;
use Drupal\os2forms_digital_post\Plugin\WebformHandler\WebformHandlerSF1601;
use Drupal\webform\Plugin\WebformElementManagerInterface;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\WebformSubmissionStorageInterface;
use Drupal\webform_attachment\Element\WebformAttachmentBase;
use ItkDev\Serviceplatformen\Service\SF1601\Serializer;
use ItkDev\Serviceplatformen\Service\SF1601\SF1601;

/**
 * Webform helper.
 */
final class WebformHelperSF1601 {
  private const RECIPIENT_IDENTIFIER_TYPE = 'recipient_identifier_type';
  private const RECIPIENT_IDENTIFIER = 'recipient_identifier';

  /**
   * The settings.
   *
   * @var \Drupal\os2forms_digital_post\SettingsInterface|Settings
   */
  private SettingsInterface $settings;

  /**
   * The certificate locator helper.
   *
   * @var CertificateLocatorHelper
   */
  private CertificateLocatorHelper $certificateLocatorHelper;

  /**
   * The webform submission storage.
   *
   * @var \Drupal\webform\WebformSubmissionStorageInterface
   */
  protected WebformSubmissionStorageInterface $webformSubmissionStorage;

  /**
   * The CPR service.
   *
   * @var \Drupal\os2forms_cpr_lookup\Service\CprServiceInterface
   */
  protected CprServiceInterface $cprService;

  /**
   * The webform element plugin manager.
   *
   * @var \Drupal\webform\Plugin\WebformElementManagerInterface
   */
  protected $webformElementManager;

  /**
   * Element info.
   *
   * @var \Drupal\Core\Render\ElementInfoManagerInterface
   */
  protected $elementInfoManager;

  /**
   * The logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected LoggerChannelInterface $logger;

  /**
   * Constructor.
   */
  public function __construct(
    SettingsInterface $settings,
    CertificateLocatorHelper $certificateLocatorHelper,
    EntityTypeManagerInterface $entity_type_manager,
    CprServiceInterface $cprService,
    WebformElementManagerInterface $webformElementManager,
    ElementInfoManagerInterface $elementInfoManager,
    LoggerChannelFactoryInterface $loggerChannelFactory
  ) {
    $this->settings = $settings;
    $this->certificateLocatorHelper = $certificateLocatorHelper;
    $this->webformSubmissionStorage = $entity_type_manager->getStorage('webform_submission');
    $this->cprService = $cprService;
    $this->webformElementManager = $webformElementManager;
    $this->elementInfoManager = $elementInfoManager;
    $this->logger = $loggerChannelFactory->get('os2forms_digital_post');
  }

  /**
   * Send digital post.
   *
   * @param string $submissionId
   *   The submission ID.
   * @param array $handlerSettings
   *   The Handler settings.
   * @param array $submissionData
   *   Submission data. Only for overriding during testing and development.
   */
  public function sendDigitalPost(string $submissionId, array $handlerSettings, array $submissionData = []) {
    $submission = $this->loadSubmission($submissionId);
    if (NULL === $submission) {
      $this->logger->error(
        'Cannot load submission @submissionId',
        ['@submissionId' => $submissionId]
      );

      throw new SubmissionNotFoundException(sprintf('Submission %s not found', $submissionId));
    }

    $submissionData = $submissionData + $submission->getData();

    $recipientIdentifierKey = $handlerSettings[WebformHandlerSF1601::RECIPIENT_ELEMENT] ?? NULL;
    if (NULL === $recipientIdentifierKey) {
      $message = 'Recipient identifier element (key: %element_key) not found in submission';
      $context = [
        '%element_key' => WebformHandlerSF1601::RECIPIENT_ELEMENT,
      ];

      $this->logger->error($message, $context);
      throw new InvalidRecipientIdentifierElementException(str_replace(array_keys($context), array_values($context),
        $message));
    }

    // @todo handle CVR recipient
    $recipientIdentifierType = 'CPR';
    $recipientIdentifier = $submissionData[$recipientIdentifierKey] ?? NULL;
    if (NULL === $recipientIdentifier) {
      $message = 'Recipient identifier element (key: %element_key) not found in submission';
      $context = [
        '%element_key' => WebformHandlerSF1601::RECIPIENT_ELEMENT,
      ];

      $this->logger->error($message, $context);
      throw new InvalidRecipientIdentifierElementException(str_replace(array_keys($context), array_values($context),
        $message));
    }

    // Validate recipient identifier.
    // @todo Use this for building physical post address.
    $this->cprService->search($recipientIdentifier);

    $senderSettings = $this->settings->get('sender');
    $messageOptions = [
      self::RECIPIENT_IDENTIFIER_TYPE => $recipientIdentifierType,
      self::RECIPIENT_IDENTIFIER => $recipientIdentifier,

      SettingsForm::SENDER_IDENTIFIER_TYPE => $senderSettings[SettingsForm::SENDER_IDENTIFIER_TYPE],
      SettingsForm::SENDER_IDENTIFIER => $senderSettings[SettingsForm::SENDER_IDENTIFIER],

      WebformHandlerSF1601::SENDER_LABEL => $handlerSettings[WebformHandlerSF1601::SENDER_LABEL],
      WebformHandlerSF1601::MESSAGE_HEADER_LABEL => $handlerSettings[WebformHandlerSF1601::MESSAGE_HEADER_LABEL],
    ];
    $message = $this->buildMessage($submission, $messageOptions, $handlerSettings, $submissionData);

    $options = [
      'test_mode' => (bool) $this->settings->get('test_mode'),
      'authority_cvr' => $senderSettings[SettingsForm::SENDER_IDENTIFIER],
      'certificate_locator' => $this->certificateLocatorHelper->getCertificateLocator(),
    ];
    $service = new SF1601($options);
    $transactionId = Serializer::createUuid();
    $type = $handlerSettings[WebformHandlerSF1601::TYPE] ?? SF1601::TYPE_DIGITAL_POST;
    $response = $service->kombiPostAfsend($transactionId, $type, $message);

    // DEBUG.
    $meMoMessage = $service->getLastKombiMeMoMessage();
    echo $meMoMessage->ownerDocument->saveXML($meMoMessage);
    // DEBUG.
    // @todo What to return?
    return $response;
  }

  /**
   * Load webform submission by id.
   */
  public function loadSubmission(int $id): ?WebformSubmissionInterface {
    return $this->webformSubmissionStorage->load($id);
  }

  /**
   * Build MEMO message.
   */
  private function buildMessage(WebformSubmissionInterface $submission, array $options, array $handlerSettings, array $submissionData = []): Message {
    $messageUUID = Serializer::createUuid();
    $messageID = Serializer::createUuid();

    $message = new Message();

    $sender = (new Sender())
      ->setIdType($options[SettingsForm::SENDER_IDENTIFIER_TYPE])
      ->setSenderID($options[SettingsForm::SENDER_IDENTIFIER])
      ->setLabel($options[WebformHandlerSF1601::SENDER_LABEL]);

    $recipient = (new Recipient())
      ->setIdType($options[self::RECIPIENT_IDENTIFIER_TYPE])
      ->setRecipientID($options[self::RECIPIENT_IDENTIFIER]);

    $messageHeader = (new MessageHeader())
      ->setMessageType($options[WebformHandlerSF1601::MESSAGE_TYPE] ?? SF1601::MESSAGE_TYPE_DIGITAL_POST)
      ->setMessageUUID($messageUUID)
      ->setMessageID($messageID)
      ->setLabel($options[WebformHandlerSF1601::MESSAGE_HEADER_LABEL])
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
          ->setEncodingFormat($document['mime-type'])
          ->setLanguage($document['language'] ?? 'da')
          ->setFilename($document['filename'])
          ->setContent($document['content']),
      ]);
    $body->setMainDocument($mainDocument);

    foreach ($attachments as $attachment) {
      $additionalDocument = (new AdditionalDocument())
        ->setLabel($attachment['label'] ?? $attachment['filename'])
        ->setFile([
          (new File())
            ->setEncodingFormat($attachment['mime-type'])
            ->setLanguage($attachment['language'] ?? 'da')
            ->setFilename($attachment['filename'])
            ->setContent($attachment['content']),
        ]);
      $body->addToAdditionalDocument($additionalDocument);
    }

    $message->setMessageBody($body);

    return $message;
  }

  /**
   * Get main document.
   *
   * @see WebformAttachmentController::download()
   */
  public function getMainDocument(WebformSubmissionInterface $submission, array $handlerSettings): array {
    // Lifted from Drupal\webform_attachment\Controller\WebformAttachmentController::download.
    $element = $handlerSettings[WebformHandlerSF1601::ATTACHMENT_ELEMENT];
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
      'content' => $content,
      'size' => strlen($content),
      'mime-type' => $mimeType,
      'filename' => $fileName,
    ];
  }

  /**
   * Get attachments.
   */
  private function getAttachments(WebformSubmissionInterface $submission, array $handlerSettings): array {
    return [];
  }

}
