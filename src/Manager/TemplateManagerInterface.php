<?php

namespace Drupal\os2forms_digital_post\Manager;

interface TemplateManagerInterface {

  /**
   * Get list of available templates.
   *
   * @return array
   *   List of available templates.
   */
  public function getAvailableTemplates(): array;
}
