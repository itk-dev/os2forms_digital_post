<?php

namespace Drupal\os2forms_digital_post\Helper;

use DataGovDk\Model\Core\Address;
use DigitalPost\MeMo\Action;
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
use Drupal\os2forms_digital_post\Exception\InvalidRecipientDataException;
use Drupal\os2forms_digital_post\Form\SettingsForm;
use Drupal\os2forms_digital_post\Plugin\WebformHandler\WebformHandlerSF1601;
use Drupal\os2web_datalookup\LookupResult\CompanyLookupResult;
use Drupal\os2web_datalookup\LookupResult\CprLookupResult;
use Drupal\webform\WebformSubmissionInterface;
use ItkDev\Serviceplatformen\Service\SF1601\Serializer;
use ItkDev\Serviceplatformen\Service\SF1601\SF1601;

/**
 * MeMo helper.
 */
class MeMoHelper extends AbstractMessageHelper {

  /**
   * Build MeMo message.
   */
  public function buildMessage(WebformSubmissionInterface $submission, array $options, array $handlerSettings, array $submissionData = [], CprLookupResult|CompanyLookupResult|null $recipientData = NULL): Message {
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

    $this->enrichRecipient($recipient, $recipientData);

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

    $message->setMessageBody($body);

    return $message;
  }

  /**
   * Enrich recipient with additional data from a lookup.
   */
  private function enrichRecipient(Recipient $recipient, $recipientData = NULL): Recipient {
    if ($recipientData instanceof CprLookupResult) {
      $name = $recipientData->getName();
      $recipient->setLabel($name);
      $address = (new Address())
        ->setCo('')
        ->setAddressLabel($recipientData->getStreet() ?: '')
        ->setHouseNumber($recipientData->getHouseNr() ?: '')
        ->setFloor($recipientData->getFloor() ?: '')
        ->setDoor($recipientData->getApartmentNr() ?: '')
        ->setZipCode($recipientData->getPostalCode() ?: '')
        ->setCity($recipientData->getCity() ?: '')
        ->setCountry('DA');
      $attentionData = (new AttentionData())
        ->setAttentionPerson((new AttentionPerson())
          ->setLabel($recipient->getLabel())
          ->setPersonID($recipient->getRecipientID())
        )
        ->setAddress($address);

      $recipient->setAttentionData($attentionData);
    }
    elseif ($recipientData instanceof CompanyLookupResult) {
      $name = $recipientData->getName();

      $recipient->setLabel($name);
      $address = (new Address())
        ->setCo('')
        ->setAddressLabel($recipientData->getStreet() ?: '')
        ->setHouseNumber($recipientData->getHouseNr() ?: '')
        ->setFloor($recipientData->getFloor() ?: '')
        ->setDoor($recipientData->getApartmentNr() ?: '')
        ->setZipCode($recipientData->getPostalCode() ?: '')
        ->setCity($recipientData->getCity() ?: '')
        ->setCountry('DA');
      $attentionData = (new AttentionData())
        ->setAttentionPerson((new AttentionPerson())
          ->setLabel($recipient->getLabel())
          ->setPersonID($recipient->getRecipientID())
        )
        ->setAddress($address);

      $recipient->setAttentionData($attentionData);
    }
    elseif (NULL !== $recipientData) {
      throw new InvalidRecipientDataException(sprintf('Cannot handle recipient data of type %s', is_scalar($recipientData) ? gettype($recipientData) : get_class($recipientData)));
    }

    return $recipient;
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

}
