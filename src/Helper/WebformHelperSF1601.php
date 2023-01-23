<?php

namespace Drupal\os2forms_digital_post\Helper;

use Drupal\advancedqueue\Entity\QueueInterface;
use Drupal\advancedqueue\Job;
use Drupal\advancedqueue\JobResult;
use Drupal\Core\Config\Entity\ConfigEntityStorage;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\os2forms_cpr_lookup\Service\CprServiceInterface;
use Drupal\os2forms_digital_post\Exception\InvalidRecipientIdentifierElementException;
use Drupal\os2forms_digital_post\Exception\RuntimeException;
use Drupal\os2forms_digital_post\Exception\SubmissionNotFoundException;
use Drupal\os2forms_digital_post\Form\SettingsForm;
use Drupal\os2forms_digital_post\Plugin\AdvancedQueue\JobType\SendDigitalPostSF1601;
use Drupal\os2forms_digital_post\Plugin\WebformHandler\WebformHandlerSF1601;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\WebformSubmissionStorageInterface;
use ItkDev\Serviceplatformen\Service\Exception\ServiceException;
use ItkDev\Serviceplatformen\Service\SF1601\Serializer;
use ItkDev\Serviceplatformen\Service\SF1601\SF1601;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * Webform helper.
 */
final class WebformHelperSF1601 implements LoggerInterface {
  use LoggerTrait;

  public const RECIPIENT_IDENTIFIER_TYPE = 'recipient_identifier_type';
  public const RECIPIENT_IDENTIFIER = 'recipient_identifier';

  /**
   * The settings.
   *
   * @var \Drupal\os2forms_digital_post\SettingsInterface|Settings
   */
  private SettingsInterface $settings;

  /**
   * The certificate locator helper.
   *
   * @var CertificateLocatorHelper
   */
  private CertificateLocatorHelper $certificateLocatorHelper;

  /**
   * The webform submission storage.
   *
   * @var \Drupal\webform\WebformSubmissionStorageInterface
   */
  protected WebformSubmissionStorageInterface $webformSubmissionStorage;

  /**
   * The queue storage.
   *
   * @var \Drupal\Core\Config\Entity\ConfigEntityStorage|\Drupal\Core\Entity\EntityStorageInterface
   */
  protected ConfigEntityStorage $queueStorage;

  /**
   * The CPR service.
   *
   * @var \Drupal\os2forms_cpr_lookup\Service\CprServiceInterface
   */
  protected CprServiceInterface $cprService;

  /**
   * The MeMo helper.
   *
   * @var MeMoHelper
   */
  protected MeMoHelper $meMoHelper;

  /**
   * The logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected LoggerChannelInterface $logger;

  /**
   * The submission logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected LoggerChannelInterface $submissionLogger;

  /**
   * Constructor.
   */
  public function __construct(
    SettingsInterface $settings,
    CertificateLocatorHelper $certificateLocatorHelper,
    EntityTypeManagerInterface $entityTypeManager,
    CprServiceInterface $cprService,
    MeMoHelper $meMoHelper,
    LoggerChannelFactoryInterface $loggerChannelFactory
  ) {
    $this->settings = $settings;
    $this->certificateLocatorHelper = $certificateLocatorHelper;
    $this->webformSubmissionStorage = $entityTypeManager->getStorage('webform_submission');
    $this->queueStorage = $entityTypeManager->getStorage('advancedqueue_queue');
    $this->cprService = $cprService;
    $this->meMoHelper = $meMoHelper;
    $this->logger = $loggerChannelFactory->get('os2forms_digital_post');
    $this->submissionLogger = $loggerChannelFactory->get('webform_submission');
  }

  /**
   * Send digital post.
   *
   * @param \Drupal\webform\WebformSubmissionInterface $submission
   *   The submission.
   * @param array $handlerSettings
   *   The Handler settings.
   * @param array $submissionData
   *   Submission data. Only for overriding during testing and development.
   *
   * @return array
   *   [The response, The MeMo message].
   */
  public function sendDigitalPost(WebformSubmissionInterface $submission, array $handlerSettings, array $submissionData = []): array {
    $logContext = [
      'webform_submission' => $submission,
    ];

    $submissionData = $submissionData + $submission->getData();

    $handlerMessageSettings = $handlerSettings[WebformHandlerSF1601::MEMO_MESSAGE];
    $recipientIdentifierKey = $handlerMessageSettings[WebformHandlerSF1601::RECIPIENT_ELEMENT] ?? NULL;
    if (NULL === $recipientIdentifierKey) {
      $message = 'Recipient identifier element (key: @element_key) not found in submission';
      $context = [
        '@element_key' => WebformHandlerSF1601::RECIPIENT_ELEMENT,
      ];

      $this->error($message, $context);
      throw new InvalidRecipientIdentifierElementException(str_replace(array_keys($context), array_values($context),
        $message));
    }

    // @todo handle CVR recipient
    $recipientIdentifierType = 'CPR';
    $recipientIdentifier = $submissionData[$recipientIdentifierKey] ?? NULL;
    if (NULL === $recipientIdentifier) {
      $message = 'Recipient identifier element (key: @element_key) not found in submission';
      $context = [
        '@element_key' => WebformHandlerSF1601::RECIPIENT_ELEMENT,
      ];

      $this->error($message, $context);
      throw new InvalidRecipientIdentifierElementException(str_replace(array_keys($context), array_values($context),
        $message));
    }

    try {
      // Validate recipient identifier.
      $cprServiceResult = $this->cprService->search($recipientIdentifier);
    }
    catch (ServiceException $serviceException) {
      throw new RuntimeException(sprintf('Cannot validate recepient identifier (%s:%s)', $recipientIdentifierType, $recipientIdentifier));
    }

    $senderSettings = $this->settings->get('sender');
    $messageOptions = [
      self::RECIPIENT_IDENTIFIER_TYPE => $recipientIdentifierType,
      self::RECIPIENT_IDENTIFIER => $recipientIdentifier,

      SettingsForm::SENDER_IDENTIFIER_TYPE => $senderSettings[SettingsForm::SENDER_IDENTIFIER_TYPE],
      SettingsForm::SENDER_IDENTIFIER => $senderSettings[SettingsForm::SENDER_IDENTIFIER],

      WebformHandlerSF1601::SENDER_LABEL => $handlerMessageSettings[WebformHandlerSF1601::SENDER_LABEL],
      WebformHandlerSF1601::MESSAGE_HEADER_LABEL => $handlerMessageSettings[WebformHandlerSF1601::MESSAGE_HEADER_LABEL],
    ];
    $message = $this->meMoHelper->buildMessage($submission, $messageOptions, $handlerSettings, $submissionData, $cprServiceResult);

    $options = [
      'test_mode' => (bool) $this->settings->get('test_mode'),
      'authority_cvr' => $senderSettings[SettingsForm::SENDER_IDENTIFIER],
      'certificate_locator' => $this->certificateLocatorHelper->getCertificateLocator(),
    ];
    $service = new SF1601($options);
    $transactionId = Serializer::createUuid();
    $type = $handlerMessageSettings[WebformHandlerSF1601::TYPE] ?? SF1601::TYPE_DIGITAL_POST;
    $response = $service->kombiPostAfsend($transactionId, $type, $message);

    $this->notice('Digital post sent to @type @id', $logContext + [
      'operation' => 'digital post sent',
      '@type' => $recipientIdentifierType,
      '@id' => $recipientIdentifier,
    ]
    );

    return [$response, $service->getLastKombiMeMoMessage()];
  }

  /**
   * Load webform submission by id.
   */
  public function loadSubmission(int $id): ?WebformSubmissionInterface {
    return $this->webformSubmissionStorage->load($id);
  }

  /**
   * Load queue.
   */
  private function loadQueue():QueueInterface {
    $processingSettings = $this->settings->get('processing');

    return $this->queueStorage->load($processingSettings['queue'] ?? 'os2forms_digital_post');
  }

  /**
   * {@inheritdoc}
   */
  public function log($level, $message, array $context = []) {
    $this->logger->log($level, $message, $context);
    // @see https://www.drupal.org/node/3020595
    if (isset($context['webform_submission']) && $context['webform_submission'] instanceof WebformSubmissionInterface) {
      $this->submissionLogger->log($level, $message, $context);
    }
  }

  /**
   * Create a job.
   *
   * @see self::processJob()
   */
  public function createJob(WebformSubmissionInterface $webformSubmission, array $handlerConfiguration): ?Job {
    $context = [
      'webform_submission' => $webformSubmission,
    ];

    try {
      $job = Job::create(SendDigitalPostSF1601::class, [
        'formId' => $webformSubmission->getWebform()->id(),
        'submissionId' => $webformSubmission->id(),
        'handlerConfiguration' => $handlerConfiguration,
      ]);
      $queue = $this->loadQueue();
      $queue->enqueueJob($job);
      $context['@queue'] = $queue->id();
      $this->notice('Job for sending digital post add to the queue @queue.', $context + [
        'operation' => 'digital post queued for sending',
      ]);

      return $job;
    }
    catch (\Exception $exception) {
      $this->error('Error creating job for sending digital post.', $context + [
        'operation' => 'digital post failed',
      ]);
      return NULL;
    }
  }

  /**
   * Process a job.
   *
   * @see self::createJob()
   */
  public function processJob(Job $job): JobResult {
    $payload = $job->getPayload();

    try {
      $submissionId = $payload['submissionId'];
      $submission = $this->loadSubmission($submissionId);
      if (NULL === $submission) {
        $message = 'Cannot load submission @submissionId';
        $context = [
          '@submissionId' => $submissionId,
        ];
        $this->error($message, $context);

        throw new SubmissionNotFoundException(str_replace(array_keys($context), array_values($context),
          $message));
      }

      $this->sendDigitalPost($submission, $payload['handlerConfiguration']);

      $this->notice('Digital post sent', [
        'handler_id' => 'os2forms_digital_post',
        'operation' => 'digital post send',
        'webform_submission' => $submission ?? NULL,
      ]);

      return JobResult::success();
    }
    catch (\Exception $e) {
      $this->error($e->getMessage(), [
        'handler_id' => 'os2forms_digital_post',
        'operation' => 'digital post send',
        'webform_submission' => $submission ?? NULL,
      ]);

      return JobResult::failure($e->getMessage());
    }
  }

}
