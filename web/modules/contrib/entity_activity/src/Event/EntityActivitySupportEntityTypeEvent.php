<?php

namespace Drupal\entity_activity\Event;

use Drupal\Core\Entity\ContentEntityInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Defines the log event.
 */
class EntityActivitySupportEntityTypeEvent extends Event {

  /**
   * The entity type id.
   *
   * @var string
   */
  protected $entity_type_id;

  /**
   * A boolean to specify if the entity type id is supported.
   *
   * @var bool
   */
  protected $supported = FALSE;

  /**
   * Constructs a new EntityActivityEvent.
   *
   * @param string $entity_type_id
   *   The entity.
   * @param bool $supported
   *   The tracker to specify if the entity type id is supported.
   */
  public function __construct($entity_type_id, bool $supported = FALSE) {
    $this->entity_type_id = $entity_type_id;
    $this->supported = $supported;
  }

  /**
   * Gets the entity.
   *
   * @return string
   *   Gets the entity.
   */
  public function getEntityTypeId() {
    return $this->entity_type_id;
  }

  /**
   * Gets the supported status.
   *
   * @return bool
   *   The supported status.
   */
  public function isSupported() {
    return $this->supported;
  }

  /**
   * Sets the supported status.
   *
   * @param bool $supported
   *   The boolean to support or not the entity type id.
   *
   * @return $this
   */
  public function setSupported($supported) {
    $this->supported = $supported;
    return $this;
  }

}
