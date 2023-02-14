<?php

namespace Drupal\os2forms_digital_post\EventSubscriber;

use Drupal\beskedfordeler\Event\PostStatusBeskedModtagEvent;
use Drupal\beskedfordeler\EventSubscriber\AbstractBeskedfordelerEventSubscriber;
use Drupal\beskedfordeler\Helper\MessageHelper;
use Drupal\os2forms_digital_post\Helper\BeskedfordelerHelper;
use Drupal\os2forms_digital_post\Helper\WebformHelperSF1601;
use Psr\Log\LoggerInterface;

/**
 * Event subscriber for PostStatusBeskedModtagEvent.
 */
final class BeskedfordelerEventSubscriber extends AbstractBeskedfordelerEventSubscriber {
  private const KANAL_KODE = 'Digital Post';
  private const MESSAGE_UUID_KEY = 'MessageUUID';

  /**
   * The Beskedfordeler helper.
   *
   * @var \Drupal\os2forms_digital_post\Helper\BeskedfordelerHelper
   */
  private BeskedfordelerHelper $beskedfordelerHelper;

  /**
   * The message helper.
   *
   * @var \Drupal\beskedfordeler\Helper\MessageHelper
   */
  private MessageHelper $messageHelper;

  /**
   * The webform helper.
   *
   * @var \Drupal\os2forms_digital_post\Helper\WebformHelperSF1601
   */
  private WebformHelperSF1601 $webformHelper;

  /**
   * Constructor.
   */
  public function __construct(BeskedfordelerHelper $beskedfordelerHelper, MessageHelper $messageHelper, WebformHelperSF1601 $webformHelper, LoggerInterface $logger) {
    parent::__construct($logger);
    $this->beskedfordelerHelper = $beskedfordelerHelper;
    $this->messageHelper = $messageHelper;
    $this->webformHelper = $webformHelper;
  }

  /**
   * {@inheritdoc}
   */
  protected function processPostStatusBeskedModtag(PostStatusBeskedModtagEvent $event): void {
    $message = $event->getDocument()->saveXML();
    try {
      $data = $this->messageHelper->getBeskeddata($message);

      $channel = $data['KanalKode'] ?? NULL;
      if (self::KANAL_KODE !== $channel) {
        $this->logger->debug('Ignoring message data on channel @channel', [
          '@channel' => $channel ?? '(null)',
        ]);
        return;
      }

      $messageUUID = $data[self::MESSAGE_UUID_KEY] ?? NULL;
      if (NULL === $messageUUID) {
        $this->logger->debug('Missing message UUID (@message_uuid_key) in data on channel @channel: @data', [
          '@message_uuid_key' => self::MESSAGE_UUID_KEY,
          '@channel' => $channel,
          '@data' => json_encode($data),
        ]);
        return;
      }

      if ($this->beskedfordelerHelper->addBeskedfordelerMessage($messageUUID, $message)) {
        $message = $this->beskedfordelerHelper->loadMessage($messageUUID);
        $this->webformHelper->processBeskedfordelerData($message->submissionId, $data);
      }
    }
    catch (\Exception $exception) {
      $this->logger->error('Error processing message: @exception_message', [
        '@exception_message' => $exception->getMessage(),
        'message' => $message,
      ]);
    }
  }

}
