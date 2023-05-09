<?php

namespace Drupal\os2forms_digital_post\Helper;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\os2forms_digital_post\Consumer\PrintServiceConsumer;
use Drupal\os2forms_digital_post\Exception\CprElementNotFoundInSubmissionException;
use Drupal\os2forms_digital_post\Exception\RuntimeException;
use Drupal\os2forms_digital_post\Exception\SubmissionNotFoundException;
use Drupal\os2forms_digital_post\Manager\TemplateManager;
use Drupal\os2web_datalookup\LookupResult\CprLookupResult;
use Drupal\os2web_datalookup\Plugin\DataLookupManager;
use Drupal\os2web_datalookup\Plugin\os2web\DataLookup\DataLookupInterfaceCpr;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Webform helper.
 */
final class WebformHelper {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The drupal renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The data lookup manager.
   *
   * @var \Drupal\os2web_datalookup\Plugin\DataLookupManager
   */
  protected $dataLookupManager;

  /**
   * The print service consumer.
   *
   * @var \Drupal\os2forms_digital_post\Consumer\PrintServiceConsumer
   */
  protected $printServiceConsumer;

  /**
   * The template manager.
   *
   * @var \Drupal\os2forms_digital_post\Manager\TemplateManager
   */
  protected $templateManager;

  /**
   * The logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * Constructor.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, RendererInterface $renderer, DataLookupManager $dataLookupManager, PrintServiceConsumer $printServiceConsumer, TemplateManager $templateManager, LoggerChannelFactoryInterface $loggerChannelFactory) {
    $this->entityTypeManager = $entity_type_manager;
    $this->renderer = $renderer;
    $this->dataLookupManager = $dataLookupManager;
    $this->printServiceConsumer = $printServiceConsumer;
    $this->templateManager = $templateManager;
    $this->logger = $loggerChannelFactory->get('os2forms_digital_post');
  }

  /**
   * Get template context.
   *
   * @phpstan-return array<string, mixed>
   */
  public function getTemplateContext(WebformSubmissionInterface $webformSubmission, CprLookupResult $cprLookupResult): array {
    $webform = $webformSubmission->getWebform();

    $view_builder = $this->entityTypeManager->getViewBuilder('webform_submission');
    $pre_render = $view_builder->view($webformSubmission, 'HTML');
    $webformSubmissionRendered = $this->renderer->renderPlain($pre_render);

    // We cannot use “side” (from address lookup via cpr) as “suiteIdentifier”
    // when sending digital port. Therefore we append it to “floor” instead.
    $floor = $cprLookupResult->getFloor();
    if (!empty($cprLookupResult->getApartmentNr())) {
      $floor .= ' ' . $cprLookupResult->getApartmentNr();
    }

    $recipient = [
      'name' => $cprLookupResult->getName(),
      'streetName' => $cprLookupResult->getStreet(),
      'streetNumber' => $cprLookupResult->getHouseNr(),
      'floor' => $floor,
      'side' => NULL,
      'postalCode' => $cprLookupResult->getPostalCode(),
      'city' => $cprLookupResult->getCity(),
    ];

    return [
      'label' => $webform->label(),
      'recipient' => $recipient,
      'submission' => $webformSubmissionRendered,
    ];
  }

  /**
   * Send digital post.
   *
   * @param string $submissionId
   *   The submission ID.
   * @param array $handlerConfiguration
   *   Handler config.
   *
   * @throws \Drupal\os2forms_digital_post\Exception\CprElementNotFoundInSubmissionException
   *   An CprElementNotFoundInSubmissionException.
   * @throws \Drupal\os2forms_digital_post\Exception\SubmissionNotFoundException
   *   A SubmissionNotFoundException.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   *   An InvalidPluginDefinitionException.
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *   A PluginNotFoundException.
   * @throws \ItkDev\Serviceplatformen\Service\Exception\ServiceException
   *   A ServiceException.
   *
   * @phpstan-param array<string, mixed> $handlerConfiguration
   */
  public function sendDigitalPost(string $submissionId, array $handlerConfiguration): void {
    $webform_submission = $this->getSubmission($submissionId);
    if (empty($webform_submission)) {
      $this->logger->error(
        'Cannot load submission @submissionId',
        ['@submissionId' => $submissionId]
      );

      throw new SubmissionNotFoundException(sprintf('Submission %s not found', $submissionId));
    }

    $submissionData = $webform_submission->getData();

    if (!array_key_exists($handlerConfiguration['cpr_element'], $submissionData)) {
      $this->logger->error(
        'The chosen CPR element not found in submission!'
      );

      throw new CprElementNotFoundInSubmissionException();
    }

    $instance = $this->dataLookupManager->createDefaultInstanceByGroup('cpr_lookup');
    if (!($instance instanceof DataLookupInterfaceCpr)) {
      throw new RuntimeException('Cannot get CPR data lookup instance');
    }
    $cprLookupResult = $instance->lookup($submissionData[$handlerConfiguration['cpr_element']]);
    $context = $this->getTemplateContext($webform_submission, $cprLookupResult);
    $result = FALSE;

    switch ($handlerConfiguration['channel']) {
      case 'A':
        $result = $this->printServiceConsumer->afsendBrevPerson(
          $handlerConfiguration['channel'],
          $handlerConfiguration['priority'],
          $submissionData[$handlerConfiguration['cpr_element']],
          $cprLookupResult->getName(),
          NULL,
          $cprLookupResult->getStreet(),
          $cprLookupResult->getHouseNr(),
          $cprLookupResult->getFloor(),
          NULL,
          NULL,
          $cprLookupResult->getPostalCode(),
          NULL,
          NULL,
          'DK',
          'PDF',
          $this->templateManager->renderPdf($handlerConfiguration['template'], $context),
          $handlerConfiguration['document_title']
        );
        break;

      case 'D':
        $result = $this->printServiceConsumer->afsendDigitalPostPerson(
          $handlerConfiguration['channel'],
          $handlerConfiguration['priority'],
          $submissionData[$handlerConfiguration['cpr_element']],
          'PDF',
          $this->templateManager->renderPdf($handlerConfiguration['template'], $context),
          $handlerConfiguration['document_title']
        );
        break;
    }

    if (FALSE === $result) {
      // Throw an error?
    }
  }

  /**
   * Gets WebformSubmission from id.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  private function getSubmission(string $submissionId): ?WebformSubmissionInterface {
    $storage = $this->entityTypeManager->getStorage('webform_submission');
    return $storage->load($submissionId);
  }

}
