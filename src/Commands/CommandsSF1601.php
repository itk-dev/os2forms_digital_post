<?php

namespace Drupal\os2forms_digital_post\Commands;

use Drupal\os2forms_digital_post\Helper\WebformHelperSF1601;
use Drupal\os2forms_digital_post\Plugin\WebformHandler\WebformHandlerSF1601;
use Drush\Commands\DrushCommands;
use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * Drush commands file for commands related to os2forms_digital_post.
 */
class CommandsSF1601 extends DrushCommands {

  /**
   * The webform helper.
   *
   * @var \Drupal\os2forms_digital_post\WebformHelperSF1601
   */
  protected WebformHelperSF1601 $helper;

  /**
   * Constructor.
   */
  public function __construct(WebformHelperSF1601 $webformHelper) {
    parent::__construct();
    $this->helper = $webformHelper;
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
   */
  public function send(int $submissionId, string $handlerId, array $options = [
    'handler-settings' => NULL,
    'recipient-element' => NULL,
    'attachment-element' => NULL,
    'submission-data' => NULL,
  ]) {
    [$submission, $handlerSettings, $submissionData] = $this->getData($submissionId, $handlerId, $options);

    $this->helper->sendDigitalPost($submission->id(), $handlerSettings, $submissionData);
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
   * @option bool dump-content
   *   Dump content to stdout.
   *
   * @command os2forms_digital_post:digital-post:show-document
   * @usage os2forms_digital_post:digital-post:show-document --help
   */
  public function showDocument(int $submissionId, string $handlerId, array $options = [
    'handler-settings' => NULL,
    'recipient-element' => NULL,
    'attachment-element' => NULL,
    'submission-data' => NULL,
    'dump-content' => FALSE,
  ]) {
    [$submission, $handlerSettings] = $this->getData($submissionId, $handlerId, $options);

    $document = $this->helper->getMainDocument($submission, $handlerSettings);

    if ($options['dump-content']) {
      echo $document['content'];
      exit;
    }

    $document['content'] = '👻';
    $this->output()->writeln(json_encode($document, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
  }

  /**
   * Get data.
   */
  private function getData(int $submissionId, string $handlerId, array $options) {
    $submission = $this->helper->loadSubmission($submissionId);
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
      if (!is_array($submissionData) || !$this->isAssoc($submissionData)) {
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
      if (!is_array($settings) || !$this->isAssoc($settings)) {
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

  /**
   * Check if an array is an associative array.
   *
   * @see https://stackoverflow.com/a/173479/2502647
   */
  private function isAssoc(array $arr) {
    if ([] === $arr) {
      return FALSE;
    }
    return array_keys($arr) !== range(0, count($arr) - 1);
  }

}
