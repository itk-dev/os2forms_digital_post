<?php

namespace Drupal\os2forms_digital_post\EventSubscriber;

use Drupal\beskedfordeler\Event\PostStatusBeskedModtagEvent;
use Drupal\beskedfordeler\EventSubscriber\AbstractBeskedfordelerEventSubscriber;

/**
 * Event subscriber for PostStatusBeskedModtagEvent.
 */
final class BeskedfordelerEventSubscriber extends AbstractBeskedfordelerEventSubscriber {

  /**
   * {@inheritdoc}
   */
  protected function processPostStatusBeskedModtag(PostStatusBeskedModtagEvent $event): void {
    $this->logger->debug(__METHOD__);
  }

}
