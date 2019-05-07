<?php

namespace Drupal\entity_activity;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Log entity.
 *
 * @see \Drupal\entity_activity\Entity\Log.
 */
class LogAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    if ($account->hasPermission($this->entityType->getAdminPermission())) {
      return AccessResult::allowed()->cachePerPermissions();
    }

    /** @var \Drupal\entity_activity\Entity\LogInterface $entity */
    $owner = $entity->getOwner();
    if (!$owner) {
      // The log is malformed.
      return AccessResult::forbidden()->addCacheableDependency($entity);
    }
    $result = AccessResult::allowedIf($owner->id() == $account->id());
    return $result;
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIf($account->isAuthenticated());
  }

}
