<?php

namespace Drupal\entity_activity\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;

/**
 * Check access on list subscribers routes.
 */
class ListSubscribersAccess implements ContainerInjectionInterface {

  /**
   * Drupal\Core\Routing\RouteMatchInterface definition.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Constructs a ListSubscribersAccess object.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match service.
   */
  function __construct(RouteMatchInterface $route_match) {
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_route_match')
    );
  }

  /**
   * Checks access to the entity operation on the given route.
   *
   * @param \Symfony\Component\Routing\Route $route
   *   The route to check against.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The parametrized route
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The currently logged in account.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The node on which check access.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(Route $route, RouteMatchInterface $route_match, AccountInterface $account, EntityInterface $entity = NULL) {
    $access = AccessResult::forbidden('Forbidden by default');
    if (!$entity instanceof ContentEntityInterface) {
      $entity = $this->getCurrentEntity();
    }
    if (!$entity instanceof ContentEntityInterface) {
      return $access->addCacheableDependency($entity)->cachePerPermissions()->cachePerUser()->addCacheContexts(['url.path', 'user']);
    }

    if ($account->hasPermission('view entities subscribers')) {
      $access = AccessResult::allowed();
    }
    elseif ($account->hasPermission('view entities subscribers on editable entities')) {
      if ($entity->access('update', $account)) {
        $access = AccessResult::allowed();
      }
    }

    return $access->addCacheableDependency($entity)->cachePerPermissions()->cachePerUser()->addCacheContexts(['url.path', 'user']);
  }

  /**
   * Get the current entity from the route.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null
   */
  protected function getCurrentEntity() {
    $entity = NULL;
    $keys = $this->routeMatch->getParameters()->keys();
    $entity_type_id = isset($keys[0]) ? $keys[0] : '';
    if (empty($entity_type_id)) {
      return $entity;
    }
    $entity = $this->routeMatch->getParameter($entity_type_id);
    return $entity;
  }

}
