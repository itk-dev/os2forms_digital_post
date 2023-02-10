<?php

namespace Drupal\os2forms_digital_post\Helper;

use DigitalPost\MeMo\Message;
use Drupal\Core\Database\Connection;
use Drupal\Core\Datetime\DrupalDateTime;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * Beskedfordeler helper.
 */
class BeskedfordelerHelper {
  use LoggerAwareTrait;

  private const TABLE_NAME = 'os2forms_digital_post_beskedfordeler';

  /**
   * The database.
   *
   * @var \Drupal\Core\Database\Connection
   */
  private Connection $database;

  /**
   * The MeMo helper.
   *
   * @var MeMoHelper
   */
  private MeMoHelper $meMoHelper;

  /**
   * Constructor.
   */
  public function __construct(Connection $database, MeMoHelper $meMoHelper, LoggerInterface $logger) {
    $this->database = $database;
    $this->meMoHelper = $meMoHelper;
    $this->setLogger($logger);
  }

  /**
   * Save MeMo message in database.
   */
  public function saveMessage(Message $message) {
    $messageId = $message->getMessageHeader()->getMessageID();
    $message = $this->meMoHelper->message2dom($message)->saveXML();

    return $this->database
      ->insert(self::TABLE_NAME)
      ->fields([
        'created' => (new DrupalDateTime())->getTimestamp(),
        'message_id' => $messageId,
        'memo_message' => $message,
      ])
      ->execute();
  }

  /**
   * Implements hook_schema().
   *
   * @phpstan-return array<string, mixed>
   */
  public function schema(): array {
    return [
      self::TABLE_NAME => [
        'description' => 'OSForms digital post beskedfordeler',
        'fields' => [
          'message_id' => [
            'description' => 'The message identifier.',
            'type' => 'varchar',
            'length' => 255,
            'not null' => TRUE,
          ],
          'created' => [
            'description' => 'The Unix timestamp when the message was created.',
            'type' => 'int',
            'not null' => TRUE,
          ],
          'memo_message' => [
            'description' => 'The MeMo message (XML).',
            'type' => 'text',
            'size' => 'medium',
            'not null' => TRUE,
          ],
          'beskedfordeler_message' => [
            'description' => 'The Beskedfordeler message (XML).',
            'type' => 'text',
            'size' => 'medium',
            'not null' => FALSE,
          ],
          'beskedfordeler_message_received' => [
            'description' => 'The Unix timestamp when the Beskedfordeler message was received.',
            'type' => 'int',
            'not null' => FALSE,
          ],
        ],
        'primary key' => ['message_id'],
      ],
    ];
  }

}
