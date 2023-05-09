<?php

namespace Drupal\os2forms_digital_post\Manager;

/**
 * Template manager interface.
 */
interface TemplateManagerInterface {

  /**
   * Get list of available templates.
   *
   * @return array
   *   List of available templates.
   *
   * @phpstan-return array<string, string>
   */
  public function getAvailableTemplates(): array;

}
