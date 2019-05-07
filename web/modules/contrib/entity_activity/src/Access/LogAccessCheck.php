<?php

namespace Drupal\entity_activity\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;

/**
 * Access check for the log api.
 *
 * General Check if a user can view the logs page. Users without theses
 * permissions will receive immediately a 403 response.
 *
 * An additional control access is done at the API level, log entity by log
 * entity, to check if the user is the log's owner or admin.
 */
class LogAccessCheck implements AccessInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new SubscriptionAccessCheck object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Basic checks access to the API log.
   *
   * More advanced access checks are done by the API itself.
   *
   * @param \Symfony\Component\Routing\Route $route
   *   The route to check against.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The currently logged in account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(Route $route, RouteMatchInterface $route_match, AccountInterface $account) {
    if ($account->isAnonymous()) {
      return AccessResult::forbidden('Anonymous can not have logs')
        ->cachePerPermissions();
    }

    if ($account->hasPermission('view any logs') || $account->hasPermission('view own logs')) {
      return AccessResult::allowed()
        ->cachePerPermissions();
    }

    return AccessResult::forbidden('Forbidden by default.')
      ->cachePerPermissions();
  }

}
