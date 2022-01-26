<?php

namespace Drupal\os2forms_digital_post\Commands;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\os2forms_cpr_lookup\CPR\CprServiceResult;
use Drush\Commands\DrushCommands;
use Drupal\os2forms_digital_post\Manager\TemplateManager;
use Drupal\os2forms_digital_post\Helper\WebformHelper;

/**
 * A drush command file for commands related to os2forms_digital_post.
 *
 * @package Drupal\event_database_pull\Commands
 */
class CreatePdf extends DrushCommands {

  /**
   * The os2forms_digital_post webform helper.
   *
   * @var \Drupal\os2forms_digital_post\WebformHelper
   */
  protected WebformHelper $webformHelper;

  /**
   * The os2forms_digital_post template manager.
   *
   * @var \Drupal\os2forms_digital_post\Manager\TemplateManager
   */
  protected TemplateManager $templateManager;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructor.
   */
  public function __construct(WebformHelper $webformHelper, TemplateManager $templateManager, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct();
    $this->webformHelper = $webformHelper;
    $this->templateManager = $templateManager;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Create PDF in directory relative to Drupal root directory.
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
  public function create($template, array $options = [
    'submission_id' => 0,
    'file_location' => '',
    'file_name' => 'test.pdf',
  ]) {
    $webform_submission = $this->entityTypeManager->getStorage('webform_submission')->load($options['submission_id']);

    if (!$webform_submission) {
      $this->output()->writeln(sprintf('Submission id %s not found.', $options['submission_id']));
      return;
    }

    $cprServiceResult = new CprServiceResult(json_decode(json_encode([
      'persondata' => [
        'navn' => [
          'fornavn' => 'Test',
          'efternavn' => 'Testersen',
        ],
      ],
      'adresse' => [
        'aktuelAdresse' => [
          'vejnavn' => 'Testervej',
          'husnummer' => '1',
          'etage' => '2',
          'sidedoer' => 'tv',
          'postnummer' => '8000',
          'postdistrikt' => 'Aarhus C',
        ],
      ],
    ])));

    $context = $this->webformHelper->getTemplateContext($webform_submission, $cprServiceResult, []);

    $pdf = $this->templateManager->renderPdf($template, $context);
    $filePath = dirname(DRUPAL_ROOT) . $options['file_location'] . '/' . $options['file_name'];
    file_put_contents($filePath, $pdf);
    $this->output()->writeln(sprintf('Pdf written to %s', $filePath));
  }

}
