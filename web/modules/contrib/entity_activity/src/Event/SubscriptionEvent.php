<?php

namespace Drupal\entity_activity\Event;

use Drupal\entity_activity\Entity\SubscriptionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Defines the log event.
 */
class SubscriptionEvent extends Event {

  /**
   * The subscription.
   *
   * @var \Drupal\entity_activity\Entity\SubscriptionInterface
   */
  protected $subscription;

  /**
   * Constructs a new SubscriptionEvent.
   *
   * @param \Drupal\entity_activity\Entity\SubscriptionInterface $subscription
   *   The subscription entity.
   */
  public function __construct(SubscriptionInterface $subscription) {
    $this->subscription = $subscription;
  }

  /**
   * Gets the subscription.
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface
   *   Gets the subscription.
   */
  public function getSubscription() {
    return $this->subscription;
  }

}
