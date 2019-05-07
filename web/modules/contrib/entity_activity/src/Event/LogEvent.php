<?php

namespace Drupal\entity_activity\Event;

use Drupal\entity_activity\Entity\LogInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Defines the log event.
 */
class LogEvent extends Event {

  /**
   * The log.
   *
   * @var \Drupal\entity_activity\Entity\LogInterface
   */
  protected $log;

  /**
   * Constructs a new LogEvent.
   *
   * @param \Drupal\entity_activity\Entity\LogInterface $log
   *   The log entity.
   */
  public function __construct(LogInterface $log) {
    $this->log = $log;
  }

  /**
   * Gets the log.
   *
   * @return \Drupal\entity_activity\Entity\LogInterface
   *   Gets the log.
   */
  public function getLog() {
    return $this->log;
  }

}
