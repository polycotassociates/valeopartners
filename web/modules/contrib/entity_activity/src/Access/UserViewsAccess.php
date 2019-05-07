<?php

namespace Drupal\entity_activity\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\Routing\Route;

/**
 * Check access on the user views related (logs and subscriptions).
 */
class UserViewsAccess {

  /**
   * Checks access on view user_logs.
   *
   * @param \Symfony\Component\Routing\Route $route
   *   The route object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match service.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current user.
   * @param \Drupal\user\UserInterface|null $user
   *   The user related logs.
   *
   * @return \Drupal\Core\Access\AccessResultAllowed|\Drupal\Core\Access\AccessResultForbidden
   *   The access result.
   */
  public function accessLogs(Route $route, RouteMatchInterface $route_match, AccountInterface $account, UserInterface $user = NULL) {
    $access = AccessResult::forbidden('Deny access per default.')->cachePerPermissions();
    if (!$user instanceof UserInterface) {
      $user = $route_match->getParameter('user');
      if (!$user instanceof UserInterface) {
        return $access;
      }
    }

    if ($account->hasPermission('administer logs entities')) {
      $access = AccessResult::allowed()->cachePerPermissions();
    }
    elseif ($account->hasPermission('view any logs')) {
      $access = AccessResult::allowed()->cachePerPermissions();
    }
    elseif ($account->hasPermission('view own logs') && $account->id() == $user->id()) {
      $access = AccessResult::allowed()->cachePerPermissions();
    }
    return $access;
  }

  /**
   * Checks access on view user_subscriptions.
   *
   * @param \Symfony\Component\Routing\Route $route
   *   The route object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match service.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current user.
   * @param \Drupal\user\UserInterface|null $user
   *   The user related subscriptions.
   *
   * @return \Drupal\Core\Access\AccessResultAllowed|\Drupal\Core\Access\AccessResultForbidden
   *   The access result.
   */
  public function accessSubscriptions(Route $route, RouteMatchInterface $route_match, AccountInterface $account, UserInterface $user = NULL) {
    $access = AccessResult::forbidden('Deny access per default.')->cachePerPermissions();
    if (!$user instanceof UserInterface) {
      $user = $route_match->getParameter('user');
      if (!$user instanceof UserInterface) {
        return $access;
      }
    }

    if ($account->hasPermission('administer subscriptions entities')) {
      $access = AccessResult::allowed()->cachePerPermissions();
    }
    elseif ($account->hasPermission('view any subscriptions')) {
      $access = AccessResult::allowed()->cachePerPermissions();
    }
    elseif ($account->hasPermission('view own subscriptions') && $account->id() == $user->id()) {
      $access = AccessResult::allowed()->cachePerPermissions();
    }

    return $access;
  }

}
