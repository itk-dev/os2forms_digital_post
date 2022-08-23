<?php

namespace Drupal\os2forms_digital_post\Plugin\WebformHandler;

use Drupal\advancedqueue\Job;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\os2forms_digital_post\Plugin\AdvancedQueue\JobType\SendDigitalPost;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformInterface;
use Drupal\webform\WebformSubmissionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Digital Post Webform Handler.
 *
 * @WebformHandler(
 *   id = "digital_post",
 *   label = @Translation("Digital Post"),
 *   category = @Translation("Web services"),
 *   description = @Translation("Sends webform submission as Digital Post."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_IGNORED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
class DigitalPostWebformHandler extends WebformHandlerBase {
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

    $availableElements = $this->getAvailableElements($this->getWebform()->getElementsDecoded());

    $form['blacklist_elements_for_template'] = [
      '#type' => 'select',
      '#title' => $this->t('Prevent elements displayed in template'),
      '#options' => $availableElements,
      '#default_value' => $this->configuration['blacklist_elements_for_template'],
      '#multiple' => TRUE,
      '#size' => 10,
    ];

    $listOfTemplates = $this->templateManager->getAvailableTemplates();

    $form['template'] = [
      '#type' => 'select',
      '#title' => $this->t('Select template'),
      '#options' => $listOfTemplates,
      '#default_value' => $this->configuration['template'],
      '#required' => TRUE,
    ];

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
      '#default_value' => $this->configuration['priority'],
    ];

    $form['cpr_element'] = [
      '#type' => 'select',
      '#title' => $this->t('Element in form that contains the CPR number of the recipient'),
      '#required' => TRUE,
      '#default_value' => $this->configuration['cpr_element'],
      '#options' => $availableElements,
    ];

    $form['document_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title of document'),
      '#required' => TRUE,
      '#default_value' => $this->configuration['document_title'],
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
      '#default_value' => $this->configuration['debug'],
    ];

    return $this->setSettingsParents($form);
  }

  /**
   * Get available elements.
   */
  private function getAvailableElements(array $elements): array {
    $availableElements = [];

    foreach ($elements as $key => $element) {

      $children = Element::children($element);

      if (!empty($children)) {

        $availableElements = array_merge($availableElements, $this->getAvailableElements(array_intersect_key($element, array_flip($children))));
        continue;
      }

      $availableElements[$key] = $element['#title'];
    }

    return $availableElements;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    $this->configuration['channel'] = $form_state->getValue('channel');
    $this->configuration['priority'] = $form_state->getValue('priority');
    $this->configuration['cpr_element'] = $form_state->getValue('cpr_element');
    $this->configuration['document_title'] = $form_state->getValue('document_title');
    $this->configuration['template'] = $form_state->getValue('template');
    $this->configuration['blacklist_elements_for_template'] = $form_state->getValue('blacklist_elements_for_template');
    $this->configuration['debug'] = (bool) $form_state->getValue('debug');
  }

  /**
   * {@inheritdoc}
   */
  public function alterElements(array &$elements, WebformInterface $webform) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function overrideSettings(array &$settings, WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function alterForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
    if ($value = $form_state->getValue('element')) {
      $form_state->setErrorByName('element', $this->t('The element must be empty. You entered %value.', ['%value' => $value]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function confirmForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function preCreate(array &$values) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function postCreate(WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function postLoad(WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function preDelete(WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function postDelete(WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(WebformSubmissionInterface $webform_submission) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    $queueStorage = $this->entityTypeManager->getStorage('advancedqueue_queue');
    /** @var \Drupal\advancedqueue\Entity\Queue $queue */
    $queue = $queueStorage->load('send_digital_post');
    $job = Job::create(SendDigitalPost::class, [
      'formId' => $webform_submission->getWebform()->id(),
      'submissionId' => $webform_submission->id(),
      'handlerConfiguration' => $this->configuration,
    ]);
    $queue->enqueueJob($job);
  }

  /**
   * {@inheritdoc}
   */
  public function preprocessConfirmation(array &$variables) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function createHandler() {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function updateHandler() {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function deleteHandler() {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function createElement($key, array $element) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function updateElement($key, array $element, array $original_element) {
    $this->debug(__FUNCTION__);
  }

  /**
   * {@inheritdoc}
   */
  public function deleteElement($key, array $element) {
    $this->debug(__FUNCTION__);
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
