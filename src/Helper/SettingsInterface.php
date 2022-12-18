<?php

namespace Drupal\os2forms_digital_post\Helper;

/**
 * Settings interface.
 */
interface SettingsInterface {

  /**
   * Get all settings.
   */
  public function getAll(): array;

  /**
   * Get keys.
   */
  public function getKeys(): array;

  /**
   * Get setting.
   */
  public function get(string $key, $default = NULL);

  /**
   * Set setting.
   */
  public function set(string $key, $value);

}
