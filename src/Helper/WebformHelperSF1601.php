<?php

namespace Drupal\os2forms_digital_post\Helper;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\os2forms_cpr_lookup\Service\CprServiceInterface;
use Drupal\os2forms_digital_post\Exception\InvalidRecipientIdentifierElementException;
use Drupal\os2forms_digital_post\Exception\SubmissionNotFoundException;
use Drupal\os2forms_digital_post\Form\SettingsForm;
use Drupal\os2forms_digital_post\Plugin\WebformHandler\WebformHandlerSF1601;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\WebformSubmissionStorageInterface;
use ItkDev\Serviceplatformen\Service\SF1601\Serializer;
use ItkDev\Serviceplatformen\Service\SF1601\SF1601;

/**
 * Webform helper.
 */
final class WebformHelperSF1601 {
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
   * Constructor.
   */
  public function __construct(
    SettingsInterface $settings,
    CertificateLocatorHelper $certificateLocatorHelper,
    EntityTypeManagerInterface $entity_type_manager,
    CprServiceInterface $cprService,
    MeMoHelper $meMoHelper,
    LoggerChannelFactoryInterface $loggerChannelFactory
  ) {
    $this->settings = $settings;
    $this->certificateLocatorHelper = $certificateLocatorHelper;
    $this->webformSubmissionStorage = $entity_type_manager->getStorage('webform_submission');
    $this->cprService = $cprService;
    $this->meMoHelper = $meMoHelper;
    $this->logger = $loggerChannelFactory->get('os2forms_digital_post');
  }

  /**
   * Send digital post.
   *
   * @param string $submissionId
   *   The submission ID.
   * @param array $handlerSettings
   *   The Handler settings.
   * @param array $submissionData
   *   Submission data. Only for overriding during testing and development.
   */
  public function sendDigitalPost(string $submissionId, array $handlerSettings, array $submissionData = []) {
    $submission = $this->loadSubmission($submissionId);
    if (NULL === $submission) {
      $this->logger->error(
        'Cannot load submission @submissionId',
        ['@submissionId' => $submissionId]
      );

      throw new SubmissionNotFoundException(sprintf('Submission %s not found', $submissionId));
    }

    $submissionData = $submissionData + $submission->getData();

    $handlerMessageSettings = $handlerSettings[WebformHandlerSF1601::MEMO_MESSAGE];
    $recipientIdentifierKey = $handlerMessageSettings[WebformHandlerSF1601::RECIPIENT_ELEMENT] ?? NULL;
    if (NULL === $recipientIdentifierKey) {
      $message = 'Recipient identifier element (key: %element_key) not found in submission';
      $context = [
        '%element_key' => WebformHandlerSF1601::RECIPIENT_ELEMENT,
      ];

      $this->logger->error($message, $context);
      throw new InvalidRecipientIdentifierElementException(str_replace(array_keys($context), array_values($context),
        $message));
    }

    // @todo handle CVR recipient
    $recipientIdentifierType = 'CPR';
    $recipientIdentifier = $submissionData[$recipientIdentifierKey] ?? NULL;
    if (NULL === $recipientIdentifier) {
      $message = 'Recipient identifier element (key: %element_key) not found in submission';
      $context = [
        '%element_key' => WebformHandlerSF1601::RECIPIENT_ELEMENT,
      ];

      $this->logger->error($message, $context);
      throw new InvalidRecipientIdentifierElementException(str_replace(array_keys($context), array_values($context),
        $message));
    }

    // Validate recipient identifier.
    // @todo Use this for building physical post address.
    $this->cprService->search($recipientIdentifier);

    $senderSettings = $this->settings->get('sender');
    $messageOptions = [
      self::RECIPIENT_IDENTIFIER_TYPE => $recipientIdentifierType,
      self::RECIPIENT_IDENTIFIER => $recipientIdentifier,

      SettingsForm::SENDER_IDENTIFIER_TYPE => $senderSettings[SettingsForm::SENDER_IDENTIFIER_TYPE],
      SettingsForm::SENDER_IDENTIFIER => $senderSettings[SettingsForm::SENDER_IDENTIFIER],

      WebformHandlerSF1601::SENDER_LABEL => $handlerMessageSettings[WebformHandlerSF1601::SENDER_LABEL],
      WebformHandlerSF1601::MESSAGE_HEADER_LABEL => $handlerMessageSettings[WebformHandlerSF1601::MESSAGE_HEADER_LABEL],
    ];
    $message = $this->meMoHelper->buildMessage($submission, $messageOptions, $handlerSettings, $submissionData);

    $options = [
      'test_mode' => (bool) $this->settings->get('test_mode'),
      'authority_cvr' => $senderSettings[SettingsForm::SENDER_IDENTIFIER],
      'certificate_locator' => $this->certificateLocatorHelper->getCertificateLocator(),
    ];
    $service = new SF1601($options);
    $transactionId = Serializer::createUuid();
    $type = $handlerMessageSettings[WebformHandlerSF1601::TYPE] ?? SF1601::TYPE_DIGITAL_POST;
    $response = $service->kombiPostAfsend($transactionId, $type, $message);

    // DEBUG.
    $meMoMessage = $service->getLastKombiMeMoMessage();
    echo $meMoMessage->ownerDocument->saveXML($meMoMessage);
    // DEBUG.
    // @todo What to return?
    return $response;
  }

  /**
   * Load webform submission by id.
   */
  public function loadSubmission(int $id): ?WebformSubmissionInterface {
    return $this->webformSubmissionStorage->load($id);
  }

}
