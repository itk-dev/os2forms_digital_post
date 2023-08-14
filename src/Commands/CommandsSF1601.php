<?php

namespace Drupal\os2forms_digital_post\Commands;

use DigitalPost\MeMo\Message;
use Drupal\os2forms_digital_post\Helper\ForsendelseHelper;
use Drupal\os2forms_digital_post\Helper\MeMoHelper;
use Drupal\os2forms_digital_post\Helper\Settings;
use Drupal\os2forms_digital_post\Helper\WebformHelperSF1601;
use Drupal\os2forms_digital_post\Plugin\WebformHandler\WebformHandlerSF1601;
use Drush\Commands\DrushCommands;
use Oio\Fjernprint\ForsendelseI;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Yaml\Yaml;

/**
 * Drush commands file for commands related to os2forms_digital_post.
 */
final class CommandsSF1601 extends DrushCommands {
  private const HIDDEN_CONTENT = '👻';
  private const MEMO_DUMP_OPTION_VALUES = [
    'main-document-file-info',
    'main-document-file-content',
  ];
  private const FORSENDELSE_DUMP_OPTION_VALUES = [];

  /**
   * Constructor.
   */
  public function __construct(
    readonly private WebformHelperSF1601 $webformHelper,
    readonly private MeMoHelper $meMoHelper,
    readonly private ForsendelseHelper $forsendelseHelper,
  ) {
    parent::__construct();
  }

  /**
   * Send digital post for a submission.
   *
   * @param int $submissionId
   *   The submission id.
   * @param string $handlerId
   *   The handler id.
   * @param array $options
   *   The command options.
   *
   * @option array handler-settings
   *  The handler settings (JSON).
   * @option string recipient-element
   *   The recipient element key.
   * @option string attachment-element
   *   The attachment element key.
   * @option array submission-data
   *   The submission data (overwriting actual submission data).
   *
   * @command os2forms_digital_post:digital-post:send
   * @usage os2forms_digital_post:digital-post:send --help
   *
   * @phpstan-param array<string, mixed> $options
   */
  public function send(int $submissionId, string $handlerId, array $options = [
    'handler-settings' => NULL,
    'recipient-element' => NULL,
    'attachment-element' => NULL,
    'submission-data' => NULL,
  ]): void {
    [$submission, $handlerSettings, $submissionData] = $this->getData($submissionId, $handlerId, $options);

    $this->webformHelper->sendDigitalPost($submission, $handlerSettings, $submissionData);
  }

  /**
   * Show MeMo message for a submission.
   *
   * @param int $submissionId
   *   The submission id.
   * @param string $handlerId
   *   The handler id.
   * @param array $options
   *   The command options.
   *
   * @option array handler-settings
   *  The handler settings (JSON).
   * @option string recipient-element
   *   The recipient element key.
   * @option string attachment-element
   *   The attachment element key.
   * @option string dump
   *   Dump content to stdout.
   *
   * @command os2forms_digital_post:digital-post:memo-show
   * @usage os2forms_digital_post:digital-post:memo-show --help
   *
   * @phpstan-param array<string, mixed> $options
   */
  public function meMoShow(int $submissionId, string $handlerId, array $options = [
    'handler-settings' => NULL,
    'recipient-element' => NULL,
    'attachment-element' => NULL,
    'submission-data' => NULL,
    'dump' => NULL,
  ]): void {
    [$submission, $handlerSettings] = $this->getData($submissionId, $handlerId, $options);

    $handlerMessageSettings = $handlerSettings[WebformHandlerSF1601::MEMO_MESSAGE];
    $messageOptions = [
      WebformHelperSF1601::RECIPIENT_IDENTIFIER_TYPE => 'test',
      WebformHelperSF1601::RECIPIENT_IDENTIFIER => 'test',

      Settings::SENDER_IDENTIFIER_TYPE => 'test',
      Settings::SENDER_IDENTIFIER => 'test',

      WebformHandlerSF1601::SENDER_LABEL => $handlerMessageSettings[WebformHandlerSF1601::SENDER_LABEL],
      WebformHandlerSF1601::MESSAGE_HEADER_LABEL => $handlerMessageSettings[WebformHandlerSF1601::MESSAGE_HEADER_LABEL],
    ];
    $message = $this->meMoHelper->buildWebformSubmissionMessage($submission, $messageOptions, $handlerSettings);

    if (isset($options['dump'])) {
      if (TRUE === $options['dump']) {
        throw new InvalidOptionException('Missing dump option value');
      }
      $this->meMoDump((string) $options['dump'], $message);
      return;
    }

    $document = $this->meMoHelper->message2dom($message);

    $this->output()->writeln($document->saveXML());
  }

  /**
   * Show forsendelse for a submission.
   *
   * @param int $submissionId
   *   The submission id.
   * @param string $handlerId
   *   The handler id.
   * @param array $options
   *   The command options.
   *
   * @option array handler-settings
   *  The handler settings (JSON).
   * @option string recipient-element
   *   The recipient element key.
   * @option string attachment-element
   *   The attachment element key.
   * @option string dump
   *   Dump content to stdout.
   *
   * @command os2forms_digital_post:digital-post:forsendelse-show
   * @usage os2forms_digital_post:digital-post:forsendelse-show --help
   *
   * @phpstan-param array<string, mixed> $options
   */
  public function forsendelseShow(int $submissionId, string $handlerId, array $options = [
    'handler-settings' => NULL,
    'recipient-element' => NULL,
    'attachment-element' => NULL,
    'submission-data' => NULL,
    'dump' => NULL,
  ]): void {
    [$submission, $handlerSettings] = $this->getData($submissionId, $handlerId, $options);

    $handlerMessageSettings = $handlerSettings[WebformHandlerSF1601::MEMO_MESSAGE];
    $messageOptions = [
      WebformHandlerSF1601::SENDER_LABEL => $handlerMessageSettings[WebformHandlerSF1601::SENDER_LABEL],
      WebformHandlerSF1601::MESSAGE_HEADER_LABEL => $handlerMessageSettings[WebformHandlerSF1601::MESSAGE_HEADER_LABEL],
      Settings::FORSENDELSES_TYPE_IDENTIFIKATOR => 'test',
    ];
    $message = $this->forsendelseHelper->buildSubmissionForsendelse($submission, $messageOptions, $handlerSettings);

    if (isset($options['dump'])) {
      if (TRUE === $options['dump']) {
        throw new InvalidOptionException('Missing dump option value');
      }
      $this->forsendelseDump((string) $options['dump'], $message);
      return;
    }

    $document = $this->forsendelseHelper->message2dom($message);

    $this->output()->writeln($document->saveXML());
  }

  /**
   * Dump MeMo message stuff.
   */
  private function meMoDump(string $dump, Message $message): void {
    switch ($dump) {
      case 'main-document-file-info':
        foreach ($message->getMessageBody()->getMainDocument()->getFile() as $file) {
          $this->output()->writeln(Yaml::dump([
            MeMoHelper::DOCUMENT_FILENAME => $file->getFilename(),
            MeMoHelper::DOCUMENT_MIME_TYPE => $file->getEncodingFormat(),
            MeMoHelper::DOCUMENT_LANGUAGE => $file->getLanguage(),
            MeMoHelper::DOCUMENT_CONTENT => self::HIDDEN_CONTENT,
          ]));
        }
        return;

      case 'main-document-file-content':
        foreach ($message->getMessageBody()->getMainDocument()->getFile() as $file) {
          $this->output()->write($file->getContent());
          break;
        }
        return;

      default:
        throw new InvalidOptionException(sprintf(
          'Invalid dump option %s. Must be one of %s',
          json_encode($dump),
          implode(', ', array_map('json_encode', self::MEMO_DUMP_OPTION_VALUES))
        ));
    }
  }

  /**
   * Dump forsendelse stuff.
   */
  private function forsendelseDump(string $dump, ForsendelseI $forsendelse): void {
    switch ($dump) {
      case self::HIDDEN_CONTENT:
        // @todo What does really make sense to dump?
        break;

      default:
        throw new InvalidOptionException(sprintf(
          'Invalid dump option %s. Must be one of %s',
          json_encode($dump),
          implode(', ', array_map('json_encode', self::FORSENDELSE_DUMP_OPTION_VALUES))
        ));
    }
  }

  /**
   * Get data.
   *
   * @return array
   *   [submission, handlerSettings, submissionData]
   *
   * @phpstan-param array<string, mixed> $options
   * @phpstan-return array<int, mixed>
   */
  private function getData(int $submissionId, string $handlerId, array $options): array {
    $submission = $this->webformHelper->loadSubmission($submissionId);
    if (NULL === $submission) {
      throw new InvalidArgumentException(sprintf('Cannot load submission %d', $submissionId));
    }

    $submissionData = [];
    if (isset($options['submission-data'])) {
      try {
        $submissionData = json_decode($options['submission-data'], TRUE, 512, JSON_THROW_ON_ERROR);
      }
      catch (\JsonException $exception) {
        throw new InvalidArgumentException(sprintf('Submission data must be valid JSON.'));
      }
      if (!is_array($submissionData) || array_is_list($submissionData)) {
        throw new InvalidArgumentException(sprintf('Submission data must be an associative array.'));
      }
    }

    $handlerSettings = $submission->getWebform()->getHandler($handlerId)->getSettings();

    if (isset($options['handler-settings'])) {
      try {
        $settings = json_decode($options['handler-settings'], TRUE, 512, JSON_THROW_ON_ERROR);
      }
      catch (\JsonException $exception) {
        throw new InvalidArgumentException(sprintf('Handler configuration must be valid JSON.'));
      }
      if (!is_array($settings) || array_is_list($settings)) {
        throw new InvalidArgumentException(sprintf('Handler configuration must be an associative array.'));
      }
      $handlerSettings = array_merge($handlerSettings, $settings);
    }

    if (isset($options['recipient-element'])) {
      $handlerSettings[WebformHandlerSF1601::RECIPIENT_ELEMENT] = $options['recipient-element'];
    }
    if (isset($options['attachment-element'])) {
      $handlerSettings[WebformHandlerSF1601::ATTACHMENT_ELEMENT] = $options['attachment-element'];
    }

    return [$submission, $handlerSettings, $submissionData];
  }

}
