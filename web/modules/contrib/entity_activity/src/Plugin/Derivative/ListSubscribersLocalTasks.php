<?php

namespace Drupal\entity_activity\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\entity_activity\EntityActivityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Derivative class that provides menu local tasks to list subscribers.
 */
class ListSubscribersLocalTasks extends DeriverBase implements ContainerDeriverInterface {

  use StringTranslationTrait;

  /**
   * The entity activity manager service.
   *
   * @var \Drupal\entity_activity\EntityActivityManagerInterface
   */
  protected $entityActivityManager;

  /**
   * Drupal\Core\Routing\RouteMatchInterface definition.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * ListSubscribersLocalTasks constructor.
   *
   * @param $base_plugin_id
   *   The base plugin id.
   * @param \Drupal\entity_activity\EntityActivityManagerInterface $entity_activity_manager
   *   The entity activity manager service.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match service.
   */
  public function __construct($base_plugin_id, EntityActivityManagerInterface $entity_activity_manager, RouteMatchInterface $route_match) {
    $this->entityActivityManager = $entity_activity_manager;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $base_plugin_id,
      $container->get('entity_activity.manager'),
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $entity_type_ids = $this->entityActivityManager->getContentEntityTypesEnabled();
    if (empty($entity_type_ids)) {
      return $this->derivatives;
    }
    foreach ($entity_type_ids as $entity_type_id) {
      $this->derivatives[$entity_type_id . '.list_subscribers'] = $base_plugin_definition;
      $this->derivatives[$entity_type_id . '.list_subscribers']['id'] = 'entity_activity.' . $entity_type_id . '.list_subscribers';
      $this->derivatives[$entity_type_id . '.list_subscribers']['title'] = $this->t('Subscribers');
      $this->derivatives[$entity_type_id . '.list_subscribers']['route_name'] = 'entity_activity.' . $entity_type_id . '.list_subscribers';
      $this->derivatives[$entity_type_id . '.list_subscribers']['base_route'] = 'entity.' . $entity_type_id . '.canonical';
    }
    return $this->derivatives;
  }

}