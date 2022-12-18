<?php

namespace Drupal\os2forms_digital_post\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\os2forms_digital_post\Helper\SettingsInterface;
use Drupal\os2forms_digital_post\Helper\Settings;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Digital post settings form.
 */
final class SettingsForm extends FormBase {
  use StringTranslationTrait;

  /**
   * The settings.
   *
   * @var \Drupal\os2forms_digital_post\Helper\Settings
   */
  private SettingsInterface $settings;

  /**
   * Constructor.
   */
  public function __construct(SettingsInterface $settings) {
    $this->settings = $settings;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get(Settings::class)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'os2forms_digital_post_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $defaultValues = $this->settings->getAll();

    $form['test_mode'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Test mode'),
      '#default_value' => $defaultValues['test_mode'] ?? TRUE,
    ];

    $form['sender'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Sender'),
      '#tree' => TRUE,

      'identifier_type' => [
        '#type' => 'select',
        '#title' => $this->t('Identifier type'),
        '#options' => [
          'CVR' => $this->t('CVR'),
        ],
        '#default_value' => $defaultValues['sender']['identifier_type'] ?? 'CVR',
        '#required' => TRUE,
      ],

      'identifier' => [
        '#type' => 'textfield',
        '#title' => $this->t('Identifier'),
        '#default_value' => $defaultValues['sender']['identifier'] ?? NULL,
        '#required' => TRUE,
      ],
    ];

    $form['certificate'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Certificate'),
      '#tree' => TRUE,

      'locator_type' => [
        '#type' => 'select',
        '#title' => $this->t('Certificate locator type'),
        '#options' => [
          'azure_key_vault' => $this->t('Azure key vault'),
          'file_system' => $this->t('File system'),
        ],
        '#default_value' => $defaultValues['certificate']['locator_type'] ?? NULL,
      ],
    ];

    $form['certificate']['azure_key_vault'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Azure key vault'),
      '#states' => [
        'visible' => [':input[name="certificate[locator_type]"]' => ['value' => 'azure_key_vault']],
      ],
    ];

    $settings = [
      'tenant_id' => ['title' => $this->t('Tenant id')],
      'application_id' => ['title' => $this->t('Application id')],
      'client_secret' => ['title' => $this->t('Client secret')],
      'name' => ['title' => $this->t('Name')],
      'secret' => ['title' => $this->t('Secret')],
      'version' => ['title' => $this->t('Version')],
    ];

    foreach ($settings as $key => $info) {
      $form['certificate']['azure_key_vault'][$key] = [
        '#type' => 'textfield',
        '#title' => $info['title'],
        '#description' => $info['description'] ?? NULL,
        '#default_value' => $defaultValues['certificate']['azure_key_vault'][$key] ?? NULL,
        '#states' => [
          'required' => [':input[name="certificate[locator_type]"]' => ['value' => 'azure_key_vault']],
        ],
      ];
    }

    $form['certificate']['file_system'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('File system'),
      '#states' => [
        'visible' => [':input[name="certificate[locator_type]"]' => ['value' => 'file_system']],
      ],

      'path' => [
        '#type' => 'textfield',
        '#title' => $this->t('Path'),
        '#default_value' => $defaultValues['certificate']['file_system']['path'] ?? NULL,
        '#states' => [
          'required' => [':input[name="certificate[locator_type]"]' => ['value' => 'file_system']],
        ],
      ],
    ];

    $form['certificate']['passphrase'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Passphrase'),
      '#default_value' => $defaultValues['certificate']['passphrase'] ?? NULL,
    ];

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save settings'),
    ];

    if (0 === 1) {
      $form['actions']['testCertificate'] = [
        '#type' => 'submit',
        '#name' => 'testCertificate',
        '#value' => $this->t('Test certificate'),
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $formState) {
    $triggeringElement = $formState->getTriggeringElement();
    if ('testCertificate' === ($triggeringElement['#name'] ?? NULL)) {
      return;
    }

    $values = $formState->getValues();
    if ('file_system' === $values['certificate']['locator_type']) {
      $path = $values['certificate']['file_system']['path'] ?? NULL;
      if (!file_exists($path)) {
        $formState->setErrorByName('certificate][file_system][path', $this->t('Invalid certificate path: %path', ['%path' => $path]));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $formState) {
    $values = $formState->getValues();
    foreach ($this->settings->getKeys() as $key) {
      if (array_key_exists($key, $values)) {
        $this->settings->set($key, $values[$key]);
      }
    }

    $this->messenger()->addStatus($this->t('Settings saved'));

    $triggeringElement = $formState->getTriggeringElement();
    if ('testCertificate' === ($triggeringElement['#name'] ?? NULL)) {
      $this->testCertificate();
    }
  }

  /**
   * Test certificate.
   */
  private function testCertificate() {
    $this->messenger()->addWarning(__METHOD__, TRUE);
  }

}
