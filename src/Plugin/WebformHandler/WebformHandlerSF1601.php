<?php

namespace Drupal\os2forms_digital_post\Plugin\WebformHandler;

use Drupal\advancedqueue\Job;
use Drupal\Core\Form\FormStateInterface;
use Drupal\os2forms_digital_post\Plugin\AdvancedQueue\JobType\SendDigitalPostSF1601;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;
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
  public const RECIPIENT_ELEMENT_KEY = 'recipient_element';
  public const ATTACHMENT_ELEMENT_KEY = 'attachment_element';

  /**
   * Maximum length of title on digital post document.
   *
   * It's not obvious, i.e. clearly documented, what the maximum length actually
   * is, but it's less than 34.
   */
  private const DOCUMENT_TITLE_MAX_LENGTH = 32;

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

    // The channels available here are required by the
    // Digital Post service. For more information see the
    // specification for the PrintService (SF1600) on
    // Serviceplatformen.
    $form['channel'] = [
      '#type' => 'select',
      '#title' => $this->t('Select channel'),
      '#options' => [
        // Only send the letter as Digital Post.
        'D' => $this->t('Digital Post'),
        // Serviceplatformen decides if a citizen should have digital or
        // physical mail based on the citizens registration.
        'A' => $this->t('Automatisk'),
      ],
      '#default_value' => $this->configuration['channel'],
    ];

    $form['priority'] = [
      '#type' => 'select',
      '#title' => $this->t('Priority'),
      '#options' => [
        'D' => $this->t('Direkte'),
      ],
      '#default_value' => $this->configuration['priority'] ?? NULL,
    ];

    $availableElements = $this->getRecipientElements();
    $form[static::RECIPIENT_ELEMENT_KEY] = [
      '#type' => 'select',
      '#title' => $this->t('Element that contains the identifier (CPR or CVR) of the recipient'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[static::RECIPIENT_ELEMENT_KEY] ?? NULL,
      '#options' => $availableElements,
    ];

    $availableElements = $this->getAttachmentElements();
    $form[static::ATTACHMENT_ELEMENT_KEY] = [
      '#type' => 'select',
      '#title' => $this->t('Element that contains the document to send'),
      '#required' => TRUE,
      '#default_value' => $this->configuration[static::ATTACHMENT_ELEMENT_KEY] ?? NULL,
      '#options' => $availableElements,
    ];

    $form['document_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Document title'),
      '#required' => TRUE,
      '#default_value' => $this->configuration['document_title'] ?? NULL,
      '#maxlength' => self::DOCUMENT_TITLE_MAX_LENGTH,
      '#description' => $this->t('Note that the document title can contain at most @max_length characters.', ['@max_length' => self::DOCUMENT_TITLE_MAX_LENGTH]),
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
    $this->configuration['channel'] = $form_state->getValue('channel');
    $this->configuration['priority'] = $form_state->getValue('priority');
    $this->configuration[static::RECIPIENT_ELEMENT_KEY] = $form_state->getValue(static::RECIPIENT_ELEMENT_KEY);
    $this->configuration[static::ATTACHMENT_ELEMENT_KEY] = $form_state->getValue(static::ATTACHMENT_ELEMENT_KEY);
    $this->configuration['document_title'] = $form_state->getValue('document_title');
    $this->configuration['template'] = $form_state->getValue('template');
    $this->configuration['blacklist_elements_for_template'] = $form_state->getValue('blacklist_elements_for_template');
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
