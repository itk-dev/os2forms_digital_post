<?php

namespace Drupal\os2forms_digital_post\Plugin\WebformHandler;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Render\Markup;
use Drupal\os2forms_digital_post\Manager\TemplateManager;
use Drupal\webform\Annotation\WebformHandler;
use Drupal\webform\Plugin\WebformElementManagerInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformInterface;
use Drupal\webform\WebformSubmissionConditionsValidatorInterface;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\WebformTokenManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Digital Post Webform Handler.
 *
 * @WebformHandler(
 *   id = "digital_post",
 *   label = @Translation("Digital Post"),
 *   category = @Translation("Web services"),
 *   description = @Translation("Sends webform submission as Digital Post."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_IGNORED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
class DigitalPostWebformHandler extends WebformHandlerBase
{
  /**
   * The token manager.
   *
   * @var \Drupal\webform\WebformTokenManagerInterface
   */
  protected $tokenManager;

  /**
   * The webform element plugin manager.
   *
   * @var \Drupal\webform\Plugin\WebformElementManagerInterface
   */
  protected $elementManager;

  private $templateManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LoggerChannelFactoryInterface $logger_factory, ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, WebformSubmissionConditionsValidatorInterface $conditions_validator, WebformTokenManagerInterface $token_manager, WebformElementManagerInterface $element_manager, TemplateManager $templateManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $logger_factory, $config_factory, $entity_type_manager, $conditions_validator);
    $this->tokenManager = $token_manager;
    $this->elementManager = $element_manager;
    $this->templateManager = $templateManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('logger.factory'),
      $container->get('config.factory'),
      $container->get('entity_type.manager'),
      $container->get('webform_submission.conditions_validator'),
      $container->get('webform.token_manager'),
      $container->get('plugin.manager.webform.element'),
      $container->get('os2forms_digital_post.template_manager'),
    );
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
    $this->getLogger()->debug('This was the form: ' . print_r($this->getWebform()->getElementsDecoded(), true));

    $allElements = $this->getWebform()->getElementsDecoded();
    $availableElements = [];

    foreach ($allElements as $key => $element) {
      $availableElements[$key] = $element['#title'];
    }

    $form['blacklist_elements_for_template'] = [
      '#type' => 'select',
      '#title' => $this->t('Prevent elements displayed in template'),
      '#options' => $availableElements,
      '#default_value' => $this->configuration['blacklist_elements_for_template'],
      '#multiple' => true,
      '#size' => 10,
    ];

    $listOfTemplates = $this->templateManager->getAvailableTemplates();

    $form['template'] = [
      '#type' => 'select',
      '#title' => $this->t('Select template'),
      '#options' => $listOfTemplates,
      '#default_value' => $this->configuration['template'],
      '#required' => true,
    ];

    // The channels available here are required by the
    // Digital Post service. For more information see the
    // specification for the PrintService (SF1600) on
    // Serviceplatformen.
    $form['channel'] = [
      '#type' => 'select',
      '#title' => $this->t('Select channel'),
      '#options' => [
        'D' => $this->t('Digital Post'),
//        'F' => $this->t('Fysisk post'),
//        'A' => $this->t('Automatisk på SP'),
//        'P' => $this->t('Automatisk på Fjern-print'),
//        'S' => $this->t('Nem SMS'),
      ],
      '#default_value' => $this->configuration['channel'],
    ];

    $form['priority'] = [
      '#type' => 'select',
      '#title' => $this->t('Priority'),
      '#options' => [
        'D' => $this->t('Direkte'),
//        'M' => $this->t('Masseforsendelse')
      ],
      '#default_value' => $this->configuration['priority'],
    ];

    $form['cpr_element'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Element in form that contains the CPR number of the recipient'),
      '#required' => TRUE,
      '#default_value' => $this->configuration['cpr_element'],
    ];

    $form['document_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title of document'),
      '#required' => TRUE,
      '#default_value' => $this->configuration['document_title'],
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
//    $message = $this->configuration['message'];
//    $message = $this->replaceTokens($message, $this->getWebformSubmission());
//    $this->messenger()->addStatus(Markup::create(Xss::filter($message)), FALSE);
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
    $this->debug(__FUNCTION__, $update ? 'update' : 'insert');

    $elements = [];
    $blacklistedElements = $this->configuration['blacklist_elements_for_template'];
    $submissionData = $webform_submission->getData();
    foreach ($submissionData as $key => $value) {

      if (array_key_exists($key, $blacklistedElements)) {
        continue;
      }

      $element = $this->webform->getElement($key);

      $elements[] = [
        'name' => $element['#title'],
        'value' => $value,
      ];
    }

    $context = [
      'elements' => $elements,
    ];

    if (true === $this->configuration['debug']) {
      $this->templateManager->renderPdf($this->configuration['template'], $context, true);
      return;
    }

    $pdf = $this->templateManager->renderPdf($this->configuration['template'], $context);

    // Base64 encode pdf for digital post service
    // Invoke the service
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
