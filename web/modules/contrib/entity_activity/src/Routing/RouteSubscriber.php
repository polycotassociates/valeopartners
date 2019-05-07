<?php

namespace Drupal\entity_activity\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Add custom access on user related views (logs and subscriptions).
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    $route = $collection->get('view.user_logs.page_1');
    if ($route) {
      $route->addRequirements([
        '_custom_access' => '\Drupal\entity_activity\Access\UserViewsAccess:accessLogs',
      ]);
      $options = [
        'parameters' => [
          'user' => [
            'type' => 'entity:user',
          ],
        ],
      ];
      $route->addOptions($options);
    }

    $route = $collection->get('view.user_subscriptions.page_1');
    if ($route) {
      $route->addRequirements([
        '_custom_access' => '\Drupal\entity_activity\Access\UserViewsAccess:accessSubscriptions',
      ]);
      $options = [
        'parameters' => [
          'user' => [
            'type' => 'entity:user',
          ],
        ],
      ];
      $route->addOptions($options);
    }

  }

}
