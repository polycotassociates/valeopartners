<?php

namespace Drupal\entity_activity\Event;

/**
 * Define the log event name dispatched.
 */
final class LogEvents {

  /**
   * Name of the event fired after loading a log.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\LogEvent
   */
  const LOG_LOAD = 'entity_activity.entity_activity_log.load';

  /**
   * Name of the event fired before creating a new log.
   *
   * Fired before the log is saved.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\LogEvent
   */
  const LOG_CREATE = 'entity_activity.entity_activity_log.create';

  /**
   * Name of the event fired before saving a log.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\LogEvent
   */
  const LOG_PRESAVE = 'entity_activity.entity_activity_log.presave';

  /**
   * Name of the event fired after saving a new log.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\LogEvent
   */
  const LOG_INSERT = 'entity_activity.entity_activity_log.insert';

  /**
   * Name of the event fired after saving an existing log.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\LogEvent
   */
  const LOG_UPDATE = 'entity_activity.entity_activity_log.update';

  /**
   * Name of the event fired before deleting a log.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\LogEvent
   */
  const LOG_PREDELETE = 'entity_activity.entity_activity_log.predelete';

  /**
   * Name of the event fired after deleting a log.
   *
   * @Event
   *
   * @see \Drupal\entity_activity\Event\LogEvent
   */
  const LOG_DELETE = 'entity_activity.entity_activity_log.delete';

}
