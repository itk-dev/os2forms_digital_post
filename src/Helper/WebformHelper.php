<?php

namespace Drupal\os2forms_digital_post\Helper;

use Drupal\os2forms_cpr_lookup\CPR\CprServiceResult;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Render\Renderer;

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
   * @var Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Constructor.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, Renderer $renderer) {
    $this->entityTypeManager = $entity_type_manager;
    $this->renderer = $renderer;
  }

  /**
   * Get template context.
   */
  public function getTemplateContext(WebformSubmissionInterface $webformSubmission, CprServiceResult $cprServiceResult, array $configuration = []) {
    $webform = $webformSubmission->getWebform();

    $view_builder = $this->entityTypeManager->getViewBuilder('webform_submission');
    $pre_render = $view_builder->view($webformSubmission, 'HTML');
    $webformSubmissionRendered = $this->renderer->renderPlain($pre_render);

    // We cannot use “side” (from address lookup via cpr) as “suiteIdentifier”
    // when sending digital port. Therefore we append it to “floor” instead.
    $floor = $cprServiceResult->getFloor();
    if (!empty($cprServiceResult->getSide())) {
      $floor .= ' ' . $cprServiceResult->getSide();
    }

    $recipient = [
      'name' => $cprServiceResult->getName(),
      'streetName' => $cprServiceResult->getStreetName(),
      'streetNumber' => $cprServiceResult->getHouseNumber(),
      'floor' => $floor,
      'side' => NULL,
      'postalCode' => $cprServiceResult->getPostalCode(),
      'city' => $cprServiceResult->getCity(),
    ];

    return [
      'label' => $webform->label(),
      'recipient' => $recipient,
      'submission' => $webformSubmissionRendered
    ];
  }

}
