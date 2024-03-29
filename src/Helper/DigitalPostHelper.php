<?php

namespace Drupal\os2forms_digital_post\Helper;

use DigitalPost\MeMo\Message;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\os2forms_digital_post\Exception\RuntimeException;
use Drupal\os2web_datalookup\LookupResult\CompanyLookupResult;
use Drupal\os2web_datalookup\LookupResult\CprLookupResult;
use Drupal\os2web_datalookup\Plugin\DataLookupManager;
use Drupal\os2web_datalookup\Plugin\os2web\DataLookup\DataLookupInterfaceCompany;
use Drupal\os2web_datalookup\Plugin\os2web\DataLookup\DataLookupInterfaceCpr;
use Drupal\webform\WebformSubmissionInterface;
use ItkDev\Serviceplatformen\Service\SF1601\Serializer;
use ItkDev\Serviceplatformen\Service\SF1601\SF1601;
use Oio\Fjernprint\ForsendelseI;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * Webform helper.
 */
final class DigitalPostHelper implements LoggerInterface {
  use LoggerTrait;

  /**
   * Constructor.
   */
  public function __construct(
    readonly private Settings $settings,
    readonly private CertificateLocatorHelper $certificateLocatorHelper,
    readonly private DataLookupManager $dataLookupManager,
    readonly private MeMoHelper $meMoHelper,
    readonly private ForsendelseHelper $forsendelseHelper,
    readonly private BeskedfordelerHelper $beskedfordelerHelper,
    readonly private LoggerChannelInterface $logger,
    readonly private LoggerChannelInterface $submissionLogger
  ) {
  }

  /**
   * Send digital post.
   *
   * @param string $type
   *   The digital post type.
   * @param \DigitalPost\MeMo\Message $message
   *   The MeMo message.
   * @param \Oio\Fjernprint\ForsendelseI|null $forsendelse
   *   The forsendelse if any.
   * @param \Drupal\webform\WebformSubmissionInterface $submission
   *   The submission.
   *
   * @return array
   *   [The response, The kombi post message].
   *
   * @phpstan-param array<string, mixed> $handlerSettings
   * @phpstan-param array<string, mixed> $submissionData
   * @phpstan-return array<int, mixed>
   */
  public function sendDigitalPost(string $type, Message $message, ?ForsendelseI $forsendelse, WebformSubmissionInterface $submission): array {
    $senderSettings = $this->settings->getSender();
    $options = [
      'test_mode' => (bool) $this->settings->getTestMode(),
      'authority_cvr' => $senderSettings[Settings::SENDER_IDENTIFIER],
      'certificate_locator' => $this->certificateLocatorHelper->getCertificateLocator(),
    ];
    $service = new SF1601($options);
    $transactionId = Serializer::createUuid();
    $response = $service->kombiPostAfsend($transactionId, $type, $message, $forsendelse);

    $this->beskedfordelerHelper->createMessage($submission->id(), $message, (string) $response->getContent());

    return [$response, $service->getLastKombiMeMoMessage()];
  }

  /**
   * {@inheritdoc}
   */
  public function log($level, $message, array $context = []): void {
    $this->logger->log($level, $message, $context);
    // @see https://www.drupal.org/node/3020595
    if (isset($context['webform_submission']) && $context['webform_submission'] instanceof WebformSubmissionInterface) {
      $this->submissionLogger->log($level, $message, $context);
    }
  }

  /**
   * Look up CPR.
   */
  public function lookupCpr(string $cpr): CprLookupResult {
    $instance = $this->dataLookupManager->createDefaultInstanceByGroup('cpr_lookup');
    if (!($instance instanceof DataLookupInterfaceCpr)) {
      throw new RuntimeException('Cannot get CPR data lookup instance');
    }
    $lookupResult = $instance->lookup($cpr);
    if (!$lookupResult->isSuccessful()) {
      throw new RuntimeException('Cannot lookup CPR');
    }

    return $lookupResult;
  }

  /**
   * Look up CVR.
   */
  public function lookupCvr(string $cvr): CompanyLookupResult {
    $instance = $this->dataLookupManager->createDefaultInstanceByGroup('cvr_lookup');
    if (!($instance instanceof DataLookupInterfaceCompany)) {
      throw new RuntimeException('Cannot get CVR data lookup instance');
    }
    $lookupResult = $instance->lookup($cvr);
    if (!$lookupResult->isSuccessful()) {
      throw new RuntimeException('Cannot lookup CVR');
    }

    return $lookupResult;
  }

  /**
   * Look up recipient.
   */
  public function lookupRecipient(string $recipient): CprLookupResult|CompanyLookupResult {
    try {
      return preg_match('/^\d{8}$/', $recipient)
        ? $this->lookupCvr($recipient)
        : $this->lookupCpr($recipient);
    }
    catch (\Exception) {
      throw new RuntimeException('Cannot lookup recipient');
    }
  }

  /**
   * Get MeMeHelper.
   */
  public function getMeMoHelper(): MeMoHelper {
    return $this->meMoHelper;
  }

  /**
   * Get ForsendelseHelper.
   */
  public function getForsendelseHelper(): ForsendelseHelper {
    return $this->forsendelseHelper;
  }

}
