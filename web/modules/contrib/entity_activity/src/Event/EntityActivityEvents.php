<?php

namespace Drupal\entity_activity\Event;

/**
 * Define the event names for entity activity operations.
 */
final class EntityActivityEvents {

  /**
   * Name of the event fired after saving a new entity.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\EntityActivityEvent
   */
  const ENTITY_ACTIVITY_INSERT = 'entity_activity.entity.insert';

  /**
   * Name of the event fired after saving an existing entity.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\EntityActivityEvent
   */
  const ENTITY_ACTIVITY_UPDATE = 'entity_activity.entity.update';

  /**
   * Name of the event fired after deleting a entity.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\EntityActivityEvent
   */
  const ENTITY_ACTIVITY_DELETE = 'entity_activity.entity.delete';

}
