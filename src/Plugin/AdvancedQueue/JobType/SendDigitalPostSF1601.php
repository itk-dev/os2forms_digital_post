<?php

namespace Drupal\os2forms_digital_post\Plugin\AdvancedQueue\JobType;

use Drupal\advancedqueue\Job;
use Drupal\advancedqueue\JobResult;
use Drupal\advancedqueue\Plugin\AdvancedQueue\JobType\JobTypeBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\os2forms_digital_post\Helper\WebformHelper;
use Drupal\os2forms_digital_post\Helper\WebformHelperSF1601;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Send digital post.
 *
 * @AdvancedQueueJobType(
 *   id = "Drupal\os2forms_digital_post\Plugin\AdvancedQueue\JobType\SendDigitalPostSF1601",
 *   label = @Translation("Send digital post (sf1601)"),
 * )
 */
final class SendDigitalPostSF1601 extends JobTypeBase implements ContainerFactoryPluginInterface {
  /**
   * The webform helper.
   *
   * @var \Drupal\os2forms_digital_post\Helper\WebformHelper
   */
  private WebformHelper $helper;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get(WebformHelperSF1601::class)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    WebformHelper $helper
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->helper = $helper;
  }

  /**
   * Processes the send digital post job.
   */
  public function process(Job $job): JobResult {
    $payload = $job->getPayload();

    try {
      $this->helper->sendDigitalPost($payload['submissionId'], $payload['handlerConfiguration']);

      return JobResult::success();
    }
    catch (\Exception $e) {
      return JobResult::failure($e->getMessage());
    }
  }

}
