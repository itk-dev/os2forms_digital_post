<?php

namespace Drupal\os2forms_digital_post\Plugin\WebformHandler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\os2forms_digital_post\Helper\WebformHelperSF1601;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;
use ItkDev\Serviceplatformen\Service\SF1601\SF1601;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Digital Post Webform Handler.
 *
 * @WebformHandler(
 *   id = "digital_post_sf1601",
 *   label = @Translation("Digital post (sf1601)"),
 *   category = @Translation("Web services"),
 *   description = @Translation("Sends webform submission as digital post."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_IGNORED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
final class WebformHandlerSF1601 extends WebformHandlerBase {
  public const MEMO_MESSAGE = 'memo_message';
  public const MEMO_ACTIONS = 'memo_actions';
  public const TYPE = 'type';
  public const MESSAGE_TYPE = 'message_type';
  public const SENDER_LABEL = 'sender_label';
  public const MESSAGE_HEADER_LABEL = 'message_header_label';
  public const RECIPIENT_ELEMENT = 'recipient_element';
  public const ATTACHMENT_ELEMENT = 'attachment_element';

  /**
   * Maximum length of sender label.
   */
  private const SENDER_LABEL_MAX_LENGTH = 64;

  /**
   * Maximum length of header label.
   */
  private const MESSAGE_HEADER_LABEL_MAX_LENGTH = 128;

  /**
   * The token manager.
   *
   * @var \Drupal\webform\WebformTokenManagerInterface
   */
  protected $tokenManager;

  /**
   * The webform helper.
   *
   * @var \Drupal\os2forms_digital_post\WebformHelper
   */
  protected $webformHelper;

  /**
   * The template manager.
   *
   * @var \Drupal\os2forms_digital_post\Manager\TemplateManager
   */
  protected $templateManager;

  /**
   * The print service consumer.
   *
   * @var \Drupal\os2forms_digital_post\Consumer\PrintServiceConsumer
   */
  protected $printServiceConsumer;

  /**
   * The cpr service.
   *
   * @var \Drupal\os2forms_cpr_lookup\Service\CprServiceInterface
   */
  protected $cprService;

  /**
   * The webform helper.
   *
   * @var \Drupal\os2forms_digital_post\Helper\WebformHelperSF1601
   */
  protected WebformHelperSF1601 $helper;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);

    $instance->loggerFactory = $container->get('logger.factory');
    $instance->configFactory = $container->get('config.factory');
    $instance->renderer = $container->get('renderer');
    $instance->entityTypeManager = $container->get('entity_type.manager');
    $instance->conditionsValidator = $container->get('webform_submission.conditions_validator');
    $instance->tokenManager = $container->get('webform.token_manager');
    $instance->webformHelper = $container->get('os2forms_digital_post.webform_helper');
    $instance->templateManager = $container->get('os2forms_digital_post.template_manager');
    $instance->printServiceConsumer = $container->get('os2forms_digital_post.print_service_consumer');
    $instance->cprService = $container->get('os2forms_cpr_lookup.service');
    $instance->helper = $container->get(WebformHelperSF1601::class);

    $instance->setConfiguration($configuration);

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'debug' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $formState) {
    $form[self::MEMO_MESSAGE] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Message'),
    ];

    $form[self::MEMO_MESSAGE][self::TYPE] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#required' => TRUE,
      '#options' => [
        SF1601::TYPE_AUTOMATISK_VALG => SF1601::TYPE_AUTOMATISK_VALG,
        SF1601::TYPE_DIGITAL_POST => SF1601::TYPE_DIGITAL_POST,
        SF1601::TYPE_FYSISK_POST => SF1601::TYPE_FYSISK_POST,
      ],
      '#default_value' => $this->configuration[self::MEMO_MESSAGE][self::TYPE] ?? SF1601::TYPE_AUTOMATISK_VALG,
    ];

    $form[self::MEMO_MESSAGE][self::MESSAGE_TYPE] = [
      '#type' => 'select',
      '#title' => $this->t('Message type'),
      '#required' => TRUE,
      '#options' => [
        SF1601::MESSAGE_TYPE_DIGITAL_POST => SF1601::MESSAGE_TYPE_DIGITAL_POST,
        SF1601::MESSAGE_TYPE_NEM_SMS => SF1601::MESSAGE_TYPE_NEM_SMS,
      ],
      '#default_value' => $this->configuration[self::MEMO_MESSAGE][self::MESSAGE_TYPE] ?? SF1601::MESSAGE_TYPE_DIGITAL_POST,
    ];

    $availableElements = $this->getRecipientElements();
    $form[self::MEMO_MESSAGE][static::RECIPIENT_ELEMENT] = [
      '#type' => 'select',
      '#title' => $this->t('Element that contains the identifier (CPR or CVR) of the recipient'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[self::MEMO_MESSAGE][static::RECIPIENT_ELEMENT] ?? NULL,
      '#options' => $availableElements,
    ];

    $availableElements = $this->getAttachmentElements();
    $form[self::MEMO_MESSAGE][static::ATTACHMENT_ELEMENT] = [
      '#type' => 'select',
      '#title' => $this->t('Element that contains the document to send'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[self::MEMO_MESSAGE][static::ATTACHMENT_ELEMENT] ?? NULL,
      '#options' => $availableElements,
    ];

    $form[self::MEMO_MESSAGE][self::SENDER_LABEL] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sender label'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[self::MEMO_MESSAGE][self::SENDER_LABEL] ?? NULL,
      '#maxlength' => self::SENDER_LABEL_MAX_LENGTH,
    ];

    $form[self::MEMO_MESSAGE][self::MESSAGE_HEADER_LABEL] = [
      '#type' => 'textfield',
      '#title' => $this->t('Message header label'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[self::MEMO_MESSAGE][self::MESSAGE_HEADER_LABEL] ?? NULL,
      '#maxlength' => self::MESSAGE_HEADER_LABEL_MAX_LENGTH,
    ];

    $form[self::MEMO_ACTIONS] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Actions'),
      '#description' => $this->t('Remove an action by clearing %action and saving.', ['%action' => (string) $this->t('Action')]),
    ];

    $form[self::MEMO_ACTIONS]['actions'] = [
      '#type' => 'table',
    ];

    $actionOptions = [
      // @todo Handle SF1601::ACTION_AFTALE.
      SF1601::ACTION_BEKRAEFT => $this->getTranslatedActionName(SF1601::ACTION_BEKRAEFT),
      SF1601::ACTION_BETALING => $this->getTranslatedActionName(SF1601::ACTION_BETALING),
      SF1601::ACTION_FORBEREDELSE => $this->getTranslatedActionName(SF1601::ACTION_FORBEREDELSE),
      SF1601::ACTION_INFORMATION => $this->getTranslatedActionName(SF1601::ACTION_INFORMATION),
      SF1601::ACTION_SELVBETJENING => $this->getTranslatedActionName(SF1601::ACTION_SELVBETJENING),
      SF1601::ACTION_TILMELDING => $this->getTranslatedActionName(SF1601::ACTION_TILMELDING),
      SF1601::ACTION_UNDERSKRIV => $this->getTranslatedActionName(SF1601::ACTION_UNDERSKRIV),
    ];
    $actions = $this->configuration[self::MEMO_ACTIONS]['actions'] ?? [];
    for ($i = 0; $i <= count($actions); $i++) {
      $action = $actions[$i];
      $form[self::MEMO_ACTIONS]['actions'][$i]['action'] = [
        '#type' => 'select',
        '#title' => $this->t('Action'),
        '#options' => $actionOptions,
        '#default_value' => $action['action'] ?? NULL,
        '#empty_value' => '',
      ];
      $form[self::MEMO_ACTIONS]['actions'][$i]['url'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Url'),
        '#default_value' => $action['url'] ?? NULL,
        '#states' => [
          'required' => [sprintf(':input[name="settings[memo_actions][actions][%d][action]"]', $i) => ['filled' => TRUE]],
        ],
      ];
      $form[self::MEMO_ACTIONS]['actions'][$i]['label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Label'),
        '#default_value' => $action['label'] ?? NULL,
        '#states' => [
          'required' => [sprintf(':input[name="settings[memo_actions][actions][%d][action]"]', $i) => ['filled' => TRUE]],
        ],
      ];
    }

    // Development.
    $form['development'] = [
      '#type' => 'details',
      '#title' => $this->t('Development settings'),
    ];

    $form['development']['debug'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable debugging'),
      '#description' => $this->t('If checked, every handler method invoked will be displayed onscreen to all users.'),
      '#return_value' => TRUE,
      '#default_value' => $this->configuration['debug'] ?? NULL,
    ];

    return $this->setSettingsParents($form);
  }

  /**
   * Get recipient elements.
   */
  private function getRecipientElements(): array {
    $elements = $this->getWebform()->getElementsDecodedAndFlattened();

    $elements = array_filter(
      $elements,
      static function (array $element) {
        return in_array($element['#type'], ['textfield'], TRUE);
      }
    );

    return array_map(static function (array $element) {
      return $element['#title'];
    }, $elements);
  }

  /**
   * Get attachment elements.
   */
  private function getAttachmentElements(): array {
    $elements = $this->getWebform()->getElementsDecodedAndFlattened();

    $elements = array_filter(
      $elements,
      static function (array $element) {
        return preg_match('/^webform_entity_print_attachment:(pdf)$/', $element['#type'] ?? NULL);
      }
    );

    return array_map(static function (array $element) {
      return $element['#title'];
    }, $elements);
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $formState) {
    $actions = $formState->getValue(self::MEMO_ACTIONS)['actions'] ?? [];

    $definedActions = [];
    foreach ($actions as $index => $action) {
      if (!empty($action['action'])) {
        if (empty($action['url'])) {
          $formState->setErrorByName(
            self::MEMO_ACTIONS . '][actions][' . $index . '][url',
            $this->t('Url for action %action is required.', [
              '%action' => $this->getTranslatedActionName($action['action']),
              '%url' => $action['url'] ?? '',
            ])
          );
        }
        if (isset($definedActions[$action['action']])) {
          $formState->setErrorByName(
            self::MEMO_ACTIONS . '][actions][' . $index . '][action',
            $this->t('Action %action already defined.', [
              '%action' => $this->getTranslatedActionName($action['action']),
            ])
          );
        }
        $definedActions[$action['action']] = $action;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $formState) {
    parent::submitConfigurationForm($form, $formState);

    $this->configuration[self::MEMO_MESSAGE] = $formState->getValue(self::MEMO_MESSAGE);
    // Filter out actions with no action set.
    $actions = $formState->getValue(self::MEMO_ACTIONS);
    $actions['actions'] = array_values(array_filter(
      $actions['actions'],
      static function (array $action) {
        return !empty($action['action']);
      }
    ));
    $this->configuration[self::MEMO_ACTIONS] = $actions;

    $this->configuration['debug'] = (bool) $formState->getValue('debug');
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(WebformSubmissionInterface $webformSubmission, $update = TRUE) {
    $this->helper->createJob($webformSubmission, $this->configuration);
  }

  /**
   * Display the invoked plugin method to end user.
   *
   * @param string $method_name
   *   The invoked method name.
   * @param string $context1
   *   Additional parameter passed to the invoked method name.
   */
  protected function debug($method_name, $context1 = NULL) {
    if (!empty($this->configuration['debug'])) {
      $t_args = [
        '@id' => $this->getHandlerId(),
        '@class_name' => get_class($this),
        '@method_name' => $method_name,
        '@context1' => $context1,
      ];
      $this->messenger()->addWarning($this->t('Invoked @id: @class_name:@method_name @context1', $t_args), TRUE);
    }
  }

  /**
   * Translated action names.
   *
   * @var array|null
   */
  private ?array $translatedActionNames = NULL;

  /**
   * Get translated action name.
   */
  private function getTranslatedActionName(string $action) {
    if (NULL === $this->translatedActionNames) {
      $this->translatedActionNames = [
        SF1601::ACTION_AFTALE => $this->t('Aftale', [], ['context' => 'memo action']),
        SF1601::ACTION_BEKRAEFT => $this->t('Bekræft', [], ['context' => 'memo action']),
        SF1601::ACTION_BETALING => $this->t('Betaling', [], ['context' => 'memo action']),
        SF1601::ACTION_FORBEREDELSE => $this->t('Forberedelse', [], ['context' => 'memo action']),
        SF1601::ACTION_INFORMATION => $this->t('Information', [], ['context' => 'memo action']),
        SF1601::ACTION_SELVBETJENING => $this->t('Selvbetjening', [], ['context' => 'memo action']),
        SF1601::ACTION_TILMELDING => $this->t('Tilmelding', [], ['context' => 'memo action']),
        SF1601::ACTION_UNDERSKRIV => $this->t('Underskriv', [], ['context' => 'memo action']),
      ];
    }

    return $this->translatedActionNames[$action] ?? $action;
  }

}
