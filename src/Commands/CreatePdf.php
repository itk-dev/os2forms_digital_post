<?php

namespace Drupal\os2forms_digital_post\Commands;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drush\Commands\DrushCommands;
use Drupal\os2forms_digital_post\Manager\TemplateManager;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * A drush command file.
 *
 * @package Drupal\event_database_pull\Commands
 */
class CreatePdf extends DrushCommands {

  /**
   * The os2forms_digital_post template manager.
   *
   * @var TemplateManager
   */
  protected TemplateManager $templateManager;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  public function __construct(TemplateManager $templateManager, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct();
    $this->templateManager = $templateManager;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Create PDF named test.pdf in current directory.
   *
   * @param string $template
   *   The template name to use.
   * @param array $options
   *   An option that takes multiple values.
   *
   * @command os2forms_digital_post:create_pdf
   * @aliases create-pdf
   * @usage os2forms_digital_post:create_pdf default --submission_id=12345
   *   Create PDF using default template with data from set submission.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function create($template, $options = ['submission_id'=> 0]) {
    $elements[] = [];
    $webformLabel = '';
    if (0 < $options['submission_id']) {
      $webform_submission = $this->entityTypeManager->getStorage('webform_submission')->load($options['submission_id']);
      if ($webform_submission) {
        $webform = $webform_submission->getWebform();
        $webformLabel = $webform->label();
        $submissionData = $webform_submission->getData();
        foreach ($submissionData as $key => $value) {
          $element = $webform->getElement($key, TRUE);
          $elements[] = [
            'name' => $element['#title'],
            'value' => isset($element['#return_value']) ? $element['#return_value'] : $value,
          ];
        }
      }
      else {
        $this->output()->writeln('Submission id: ' . $options['submission_id'] . ' not found. An empty ' . $template . ' template was created.');
      }
    }

    $recipient = [
      'name' => 'Test testersen',
      'streetName' => 'Testervej',
      'streetNumber' => '1',
      'floor' => '2',
      'side' => 'tv',
      'postalCode' => '8000',
      'city' => 'Aarhus C.',
    ];

    $context = [
      'label' => $webformLabel,
      'elements' => $elements,
      'recipient' => $recipient,
    ];

    $pathToTemplate = $template;
    $pdf = $this->templateManager->renderPdf($pathToTemplate, $context);
    file_put_contents('test.pdf', $pdf);
  }
}
