<?php

namespace Drupal\os2forms_digital_post\Plugin\WebformHandler;

use Drupal\advancedqueue\Job;
use Drupal\Core\Form\FormStateInterface;
use Drupal\os2forms_digital_post\Plugin\AdvancedQueue\JobType\SendDigitalPostSF1601;
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
 *   description = @Translation("Sends webform submission as pigital post."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_IGNORED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
final class WebformHandlerSF1601 extends WebformHandlerBase {
  public const TYPE = 'type';
  public const MESSAGE_TYPE = 'message_type';
  public const SENDER_LABEL = 'sender_label';
  public const HEADER_LABEL = 'header_label';
  public const RECIPIENT_ELEMENT = 'recipient_element';
  public const ATTACHMENT_ELEMENT = 'attachment_element';

  /**
   * Maximum length of sender label.
   */
  private const SENDER_LABEL_MAX_LENGTH = 64;

  /**
   * Maximum length of header label.
   */
  private const HEADER_LABEL_MAX_LENGTH = 128;

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

    $instance->setConfiguration($configuration);

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'message' => 'This is a custom message.',
      'debug' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $this->getLogger()->debug('This was the form: ' . print_r($this->getWebform()->getElementsDecoded(), TRUE));

    $form[self::TYPE] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#required' => TRUE,
      '#options' => [
        SF1601::TYPE_AUTOMATISK_VALG => SF1601::TYPE_AUTOMATISK_VALG,
        SF1601::TYPE_DIGITAL_POST => SF1601::TYPE_DIGITAL_POST,
        SF1601::TYPE_FYSISK_POST => SF1601::TYPE_FYSISK_POST,
      ],
      '#default_value' => $this->configuration[self::TYPE] ?? SF1601::TYPE_AUTOMATISK_VALG,
    ];

    $form[self::MESSAGE_TYPE] = [
      '#type' => 'select',
      '#title' => $this->t('Message type'),
      '#required' => TRUE,
      '#options' => [
        SF1601::MESSAGE_TYPE_DIGITAL_POST => SF1601::MESSAGE_TYPE_DIGITAL_POST,
        SF1601::MESSAGE_TYPE_NEM_SMS => SF1601::MESSAGE_TYPE_NEM_SMS,
      ],
      '#default_value' => $this->configuration[self::MESSAGE_TYPE] ?? SF1601::MESSAGE_TYPE_DIGITAL_POST,
    ];

    $availableElements = $this->getRecipientElements();
    $form[static::RECIPIENT_ELEMENT] = [
      '#type' => 'select',
      '#title' => $this->t('Element that contains the identifier (CPR or CVR) of the recipient'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[static::RECIPIENT_ELEMENT] ?? NULL,
      '#options' => $availableElements,
    ];

    $availableElements = $this->getAttachmentElements();
    $form[static::ATTACHMENT_ELEMENT] = [
      '#type' => 'select',
      '#title' => $this->t('Element that contains the document to send'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[static::ATTACHMENT_ELEMENT] ?? NULL,
      '#options' => $availableElements,
    ];

    $form[self::SENDER_LABEL] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sender label'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[self::SENDER_LABEL] ?? NULL,
      '#maxlength' => self::SENDER_LABEL_MAX_LENGTH,
    ];

    $form[self::HEADER_LABEL] = [
      '#type' => 'textfield',
      '#title' => $this->t('Header label'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[self::HEADER_LABEL] ?? NULL,
      '#maxlength' => self::HEADER_LABEL_MAX_LENGTH,
    ];

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
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    foreach ([
      self::TYPE,
      self::MESSAGE_TYPE,
      self::SENDER_LABEL,
      self::HEADER_LABEL,
      self::RECIPIENT_ELEMENT,
      self::ATTACHMENT_ELEMENT,
    ] as $key) {
      $this->configuration[$key] = $form_state->getValue($key);
    }

    $this->configuration['debug'] = (bool) $form_state->getValue('debug');
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    $queueStorage = $this->entityTypeManager->getStorage('advancedqueue_queue');
    /** @var \Drupal\advancedqueue\Entity\Queue $queue */
    $queue = $queueStorage->load('send_digital_post');
    $job = Job::create(SendDigitalPostSF1601::class, [
      'formId' => $webform_submission->getWebform()->id(),
      'submissionId' => $webform_submission->id(),
      'handlerConfiguration' => $this->configuration,
    ]);
    $queue->enqueueJob($job);
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

}
