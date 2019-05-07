<?php

namespace Drupal\entity_activity\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Subscription entities.
 *
 * @ingroup entity_activity
 */
interface SubscriptionInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Subscription creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Subscription.
   */
  public function getCreatedTime();

  /**
   * Sets the Subscription creation timestamp.
   *
   * @param int $timestamp
   *   The Subscription creation timestamp.
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface
   *   The called Subscription entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Subscription active status indicator.
   *
   * Inactive subscription do not generate logs.
   *
   * @return bool
   *   TRUE if the Subscription is active.
   */
  public function isActive();

  /**
   * Sets the active status of a Subscription.
   *
   * @param bool $active
   *   TRUE to set this Subscription to active, FALSE to set it to inactive.
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface
   *   The called Subscription entity.
   */
  public function setActive($active);

  /**
   * Gets the source entity ID.
   *
   * @return mixed
   *   The entity ID.
   */
  public function getSourceEntityId();

  /**
   * Gets the source entity type ID.
   *
   * @return string
   *   The entity type ID.
   */
  public function getSourceEntityTypeId();

  /**
   * Gets the langcode.
   *
   * @return string
   *   The langcode.
   */
  public function getLangcode();

  /**
   * Gets the source entity.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface
   *   The source entity.
   */
  public function getSourceEntity();

  /**
   * Gets the source entity's bundle readable label.
   *
   * @return string
   *   The source entity's bundle readable label.
   */
  public function getSourceEntityBundleLabel();

  /**
   * Gets additional parameters.
   *
   * @return array
   *   The parameters.
   */
  public function getParameters();

  /**
   * Sets additional parameters.
   *
   * @param array $parameters
   *   The parameters.
   *
   * @return $this
   */
  public function setParameters(array $parameters);

}
