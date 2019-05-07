<?php

namespace Drupal\entity_activity\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\user\UserInterface;

/**
 * Provides an interface for defining Log entities.
 *
 * @ingroup entity_activity
 */
interface LogInterface extends ContentEntityInterface, EntityOwnerInterface {

  /**
   * Gets the Log creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Log.
   */
  public function getCreatedTime();

  /**
   * Sets the Log creation timestamp.
   *
   * @param int $timestamp
   *   The Log creation timestamp.
   *
   * @return \Drupal\entity_activity\Entity\LogInterface
   *   The called Log entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Log read status indicator.
   *
   * @return bool
   *   TRUE if the Log is read.
   */
  public function isRead();

  /**
   * Sets the read status of a Log.
   *
   * @param bool $read
   *   TRUE to set this Log to read, FALSE to set it to unread.
   *
   * @return \Drupal\entity_activity\Entity\LogInterface
   *   The called Log entity.
   */
  public function setRead($read);

  /**
   * Returns the entity subscription.
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface
   *   The subscription entity.
   */
  public function getSubscription();

  /**
   * Sets the entity subscription.
   *
   * @param \Drupal\entity_activity\Entity\SubscriptionInterface $subscription
   *   The subscription entity.
   *
   * @return $this
   */
  public function setSubscription(SubscriptionInterface $subscription);

  /**
   * Returns the entity subscription ID.
   *
   * @return int|null
   *   The subscription ID, or NULL in case the subscription ID field has not
   *   been set on the entity or has been deleted.
   */
  public function getSubscriptionId();

  /**
   * Sets the entity subscription ID.
   *
   * @param int $subscription_id
   *   The subscription id.
   *
   * @return $this
   */
  public function setSubscriptionId($subscription_id);

  /**
   * Gets the log generator ID.
   *
   * @return string
   *   The generator ID.
   */
  public function getLogGeneratorId();

  /**
   * Gets the log generator.
   *
   * @return \Drupal\entity_activity\Plugin\LogGeneratorInterface
   *   The log generator.
   */
  public function getLogGenerator();

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
   * Gets the source entity.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface
   *   The source entity.
   */
  public function getSourceEntity();

  /**
   * Gets the reference source entity ID.
   *
   * @return mixed
   *   The reference entity ID.
   */
  public function getReferenceSourceEntityId();

  /**
   * Gets the reference source entity type ID.
   *
   * @return string
   *   The reference entity type ID.
   */
  public function getReferenceSourceEntityTypeId();

  /**
   * Gets the reference source entity.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface
   *   The reference source entity.
   */
  public function getReferenceSourceEntity();

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

  /**
   * Returns the entity current user's user entity.
   *
   * @return \Drupal\user\UserInterface
   *   The current user entity.
   */
  public function getCurrentUser();

  /**
   * Sets the entity current user's user entity.
   *
   * @param \Drupal\user\UserInterface $account
   *   The current user entity.
   *
   * @return $this
   */
  public function setCurrentUser(UserInterface $account);

  /**
   * Returns the entity current user's user entity ID.
   *
   * @return int|null
   *   The current user ID, or NULL in case the current user ID field has not
   *   been set on the entity.
   */
  public function getCurrentUserId();

  /**
   * Sets the entity current user's user entity ID.
   *
   * @param int $uid
   *   The current user id.
   *
   * @return $this
   */
  public function setCurrentUserId($uid);

}
