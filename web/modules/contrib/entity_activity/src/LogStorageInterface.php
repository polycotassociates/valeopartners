<?php

namespace Drupal\entity_activity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\entity_activity\Entity\SubscriptionInterface;

/**
 * The log storage interface.
 */
interface LogStorageInterface extends ContentEntityStorageInterface {

  /**
   * Generates a log.
   *
   * @param \Drupal\entity_activity\Entity\SubscriptionInterface $subscription
   *   The subscription entity.
   * @param array $log
   *   The log message array with value and format as the array keys.
   * @param string $log_generator_id
   *   The plugin log generator ID.
   * @param int $current_user_id
   *   The current user id who made the action.
   * @param string $langcode
   *   The langcode used for generating the log message.
   * @param \Drupal\Core\Entity\ContentEntityInterface $source
   *   The source entity.
   * @param \Drupal\Core\Entity\ContentEntityInterface $reference_source
   *   The reference source entity.
   * @param array $parameters
   *   An array of additional parameters for the log.
   *
   * @return \Drupal\entity_activity\Entity\LogInterface
   *   The generated log, unsaved.
   */
  public function generate(SubscriptionInterface $subscription, array $log, $log_generator_id, $current_user_id, $langcode, ContentEntityInterface $source = NULL, ContentEntityInterface $reference_source = NULL, array $parameters = []);

  /**
   * Loads all logs for a source entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity.
   *
   * @return \Drupal\entity_activity\Entity\LogInterface[]
   *   The logs.
   */
  public function loadMultipleByEntity(ContentEntityInterface $entity);

  /**
   * Loads all logs for a given owner.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account.
   *
   * @return \Drupal\entity_activity\Entity\LogInterface[]
   *   The logs.
   */
  public function loadMultipleByOwner(AccountInterface $account);

  /**
   * Loads all unread logs for a given owner.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account.
   *
   * @return \Drupal\entity_activity\Entity\LogInterface[]
   *   The logs.
   */
  public function loadMultipleUnreadByOwner(AccountInterface $account);

  /**
   * Get the total of all unread logs for a given owner.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account.
   *
   * @return \Drupal\entity_activity\Entity\LogInterface[]
   *   The logs.
   */
  public function totalUnreadByOwner(AccountInterface $account);

}
