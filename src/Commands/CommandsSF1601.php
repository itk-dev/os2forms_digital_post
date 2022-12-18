<?php

namespace Drupal\os2forms_digital_post\Commands;

use Drupal\os2forms_digital_post\Helper\WebformHelperSF1601;
use Drush\Commands\DrushCommands;

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
   * @param array $options
   *   The command options.
   *
   * @option string handler-id
   *   The handler id.
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
  public function send(int $submissionId, array $options = [
    'handler-id' => NULL,
    'handler-settings' => NULL,
    'recipient-element' => NULL,
    'attachment-element' => NULL,
    'submission-data' => NULL,
  ]) {
    $submission = $this->helper->loadSubmission($submissionId);
    if (NULL === $submission) {
      throw new \InvalidArgumentException(sprintf('Cannot load submission %d', $submissionId));
    }

    $submissionData = [];
    if (isset($options['submission-data'])) {
      try {
        $submissionData = json_decode($options['submission-data'], TRUE, 512, JSON_THROW_ON_ERROR);
      }
      catch (\JsonException $exception) {
        throw new \InvalidArgumentException(sprintf('Submission data must be valid JSON.'));
      }
      if (!is_array($submissionData) || !$this->isAssoc($submissionData)) {
        throw new \InvalidArgumentException(sprintf('Submission data must be an associative array.'));
      }
    }

    $handlerSettings = [];
    if (isset($options['handler-id'])) {
      $handlerSettings = $submission->getWebform()->getHandler($options['handler-id'])->getSettings();
    }

    if (isset($options['handler-settings'])) {
      try {
        $settings = json_decode($options['handler-settings'], TRUE, 512, JSON_THROW_ON_ERROR);
      }
      catch (\JsonException $exception) {
        throw new \InvalidArgumentException(sprintf('Handler configuration must be valid JSON.'));
      }
      if (!is_array($settings) || !$this->isAssoc($settings)) {
        throw new \InvalidArgumentException(sprintf('Handler configuration must be an associative array.'));
      }
      $handlerSettings = array_merge($handlerSettings, $settings);
    }

    if (isset($options['recipient-element'])) {
      $handlerSettings['recipient_element'] = $options['recipient-element'];
    }
    if (isset($options['attachment-element'])) {
      $handlerSettings['attachment_element'] = $options['attachment-element'];
    }

    $this->helper->sendDigitalPost($submission->id(), $handlerSettings, $submissionData);
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
