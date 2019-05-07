<?php

namespace Drupal\entity_activity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * The subscription storage.
 */
interface SubscriptionStorageInterface extends ContentEntityStorageInterface {

  /**
   * Generates a subscription.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $source
   *   The source entity.
   * @param \Drupal\Core\Session\AccountInterface $owner
   *   The current user account owner of the subscription.
   * @param string $langcode
   *   The langcode.
   * @param array $parameters
   *   An array of additional parameters for the log.
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface
   *   The subscription entity, unsaved.
   */
  public function generate(ContentEntityInterface $source, AccountInterface $owner = NULL, $langcode = NULL,  array $parameters = []);

  /**
   * Loads all subscriptions for a source entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity.
   * @param string $langcode
   *   The langcode.
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface[]
   *   The subscriptions.
   */
  public function loadMultipleByEntity(ContentEntityInterface $entity, $langcode);

  /**
   * Loads all subscriptions for a source entity.
   *
   * @param string $entity_type_id
   *   The entity type id.
   * @param int $entity_id
   *   The entity ID.
   * @param string $langcode
   *   The langcode.
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface[]
   *   The subscriptions.
   */
  public function loadMultipleByEntityTypeId($entity_type_id, $entity_id, $langcode);

  /**
   * Loads all subscriptions for a given owner.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account.
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface[]
   *   The subscriptions.
   */
  public function loadMultipleByOwner(AccountInterface $account);

  /**
   * Loads all subscriptions for a source entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account.
   * @param string $langcode
   *   The langcode.
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface[]
   *   The subscriptions.
   */
  public function loadMultipleByEntityAndOwner(ContentEntityInterface $entity, AccountInterface $account, $langcode);

}
