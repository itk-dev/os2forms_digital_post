<?php

namespace Drupal\os2forms_digital_post\Plugin\AdvancedQueue\JobType;

use Drupal\advancedqueue\Job;
use Drupal\advancedqueue\JobResult;
use Drupal\advancedqueue\Plugin\AdvancedQueue\JobType\JobTypeBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\os2forms_digital_post\Helper\WebformHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Archive document job.
 *
 * @AdvancedQueueJobType(
 *   id = "Drupal\os2forms_digital_post\Plugin\AdvancedQueue\JobType\SendDigitalPost",
 *   label = @Translation("Send digital post"),
 * )
 */
class SendDigitalPost extends JobTypeBase implements ContainerFactoryPluginInterface {
  /**
   * The archiving helper.
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
      $container->get('os2forms_digital_post.webform_helper')
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
   * Processes the ArchiveDocument job.
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

