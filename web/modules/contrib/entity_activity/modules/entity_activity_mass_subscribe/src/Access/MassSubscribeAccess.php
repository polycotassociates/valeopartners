<?php

namespace Drupal\entity_activity_mass_subscribe\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;

/**
 * Check access on mass subscribe routes.
 */
class MassSubscribeAccess {

  /**
   * Checks access to the entity operation on the given route.
   *
   * @param \Symfony\Component\Routing\Route $route
   *   The route to check against.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The parametrized route.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The currently logged in account.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The node on which check access.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(Route $route, RouteMatchInterface $route_match, AccountInterface $account, EntityInterface $entity = NULL) {
    $access = AccessResult::forbidden('Mass subscribe forbidden by default');
    if (!$entity instanceof ContentEntityInterface) {
      $entity = $this->getCurrentEntity($route_match);
    }
    if (!$entity instanceof ContentEntityInterface) {
      return $access->addCacheableDependency($entity)->cachePerPermissions()->cachePerUser()->addCacheContexts(['url.path', 'user']);
    }

    if ($account->hasPermission('mass subscribe users')) {
      $access = AccessResult::allowed();
    }
    elseif ($account->hasPermission('mass subscribe users on editable entities')) {
      if ($entity->access('update', $account)) {
        $access = AccessResult::allowed();
      }
    }

    return $access->addCacheableDependency($entity)->cachePerPermissions()->cachePerUser()->addCacheContexts(['url.path', 'user']);
  }

  /**
   * Get the current entity from the route.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match service.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null
   *   The current entity found on the route.
   */
  protected function getCurrentEntity(RouteMatchInterface $route_match) {
    $entity = NULL;
    $keys = $route_match->getParameters()->keys();
    $entity_type_id = isset($keys[0]) ? $keys[0] : '';
    if (empty($entity_type_id)) {
      return $entity;
    }
    $entity = $route_match->getParameter($entity_type_id);
    return $entity;
  }

}
