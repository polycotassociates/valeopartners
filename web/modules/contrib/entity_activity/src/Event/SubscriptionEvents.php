<?php

namespace Drupal\entity_activity\Event;

/**
 * Define the subscription event name dispatched.
 */
final class SubscriptionEvents {

  /**
   * Name of the event fired after loading a subscription.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\SubscriptionEvent
   */
  const SUBSCRIPTION_LOAD = 'entity_activity.entity_activity_subscription.load';

  /**
   * Name of the event fired before creating a new subscription.
   *
   * Fired before the subscription is saved.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\SubscriptionEvent
   */
  const SUBSCRIPTION_CREATE = 'entity_activity.entity_activity_subscription.create';

  /**
   * Name of the event fired before saving a subscription.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\SubscriptionEvent
   */
  const SUBSCRIPTION_PRESAVE = 'entity_activity.entity_activity_subscription.presave';

  /**
   * Name of the event fired after saving a new subscription.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\SubscriptionEvent
   */
  const SUBSCRIPTION_INSERT = 'entity_activity.entity_activity_subscription.insert';

  /**
   * Name of the event fired after saving an existing subscription.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\SubscriptionEvent
   */
  const SUBSCRIPTION_UPDATE = 'entity_activity.entity_activity_subscription.update';

  /**
   * Name of the event fired before deleting a subscription.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\SubscriptionEvent
   */
  const SUBSCRIPTION_PREDELETE = 'entity_activity.entity_activity_subscription.predelete';

  /**
   * Name of the event fired after deleting a subscription.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\SubscriptionEvent
   */
  const SUBSCRIPTION_DELETE = 'entity_activity.entity_activity_subscription.delete';

}
