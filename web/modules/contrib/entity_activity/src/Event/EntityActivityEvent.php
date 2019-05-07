<?php

namespace Drupal\entity_activity\Event;

use Drupal\Core\Entity\ContentEntityInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Defines the log event.
 */
class EntityActivityEvent extends Event {

  /**
   * The content entity.
   *
   * @var \Drupal\Core\Entity\ContentEntityInterface
   */
  protected $entity;

  /**
   * A bool to track if the event has been processed.
   *
   * @var bool
   */
  protected $processed = FALSE;

  /**
   * Constructs a new EntityActivityEvent.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity.
   * @param bool $processed
   *   The tracker to know if the event has been processed.
   */
  public function __construct(ContentEntityInterface $entity, bool $processed = FALSE) {
    $this->entity = $entity;
    $this->processed = $processed;
  }

  /**
   * Gets the entity.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface
   *   Gets the entity.
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * Gets the processed status.
   *
   * @return bool
   *   The processed status.
   */
  public function isProcessed() {
    return $this->processed;
  }

  /**
   * Sets the processed status.
   *
   * @return $this
   */
  public function setProcessed($processed) {
    $this->processed = $processed;
    return $this;
  }

}
