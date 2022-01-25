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
   * Get template context.
   */
  public function getTemplateContext(WebformSubmissionInterface $webformSubmission, CprServiceResult $cprServiceResult, EntityTypeManagerInterface $entity_type_manager, Renderer $renderer, array $configuration = []) {
    $webform = $webformSubmission->getWebform();
    $view_builder = $entity_type_manager->getViewBuilder('webform_submission');
    $pre_render = $view_builder->view($webformSubmission, 'HTML');
    $webformSubmissionRendered = $renderer->renderPlain($pre_render);

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
