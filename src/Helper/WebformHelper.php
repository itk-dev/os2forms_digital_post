<?php

namespace Drupal\os2forms_digital_post\Helper;

use Drupal\os2forms_cpr_lookup\CPR\CprServiceResult;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Webform helper.
 */
final class WebformHelper {

  /**
   * Get template context.
   */
  public function getTemplateContext(WebformSubmissionInterface $webformSubmission, CprServiceResult $cprServiceResult, array $configuration = []) {

    $elements = [];
    $blacklistedElements = $configuration['blacklist_elements_for_template'] ?? [];
    $submissionData = $webformSubmission->getData();
    $webform = $webformSubmission->getWebform();
    foreach ($submissionData as $key => $value) {
      if (array_key_exists($key, $blacklistedElements)) {
        continue;
      }

      $element = $webform->getElement($key);

      $elements[] = [
        'name' => $element['#title'],
        'value' => $element['#return_value'] ?? $value,
      ];
    }

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
      'elements' => $elements,
      'recipient' => $recipient,
    ];
  }

}
