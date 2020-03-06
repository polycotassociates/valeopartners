<?php

namespace Drupal\entity_activity\Routing;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\entity_activity\EntityActivityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class EntityActivityRoutes implements ContainerInjectionInterface{

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\entity_activity\EntityActivityManagerInterface definition.
   *
   * @var \Drupal\entity_activity\EntityActivityManagerInterface
   */
  protected $entityActivityManager;

  /**
   * An array of enabled content entity type id.
   *
   * @var array
   */
  protected $enabledContentEntityTypes;

  /**
   * An array of ContentEntityType supported by entity_activity.
   *
   * @var \Drupal\Core\Entity\ContentEntityTypeInterface[]
   */
  protected $supportedContentEntityTypes;

  /**
   * EntityActivityRoutes Constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\entity_activity\EntityActivityManagerInterface $entity_activity_manager
   *   The entity activity manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, EntityFieldManagerInterface $entity_field_manager, ConfigFactoryInterface $config_factory, EntityActivityManagerInterface $entity_activity_manager) {
    $this->entityTypeManager = $entity_type_manager;
    $this->entityFieldManager = $entity_field_manager;
    $this->configFactory = $config_factory;
    $this->entityActivityManager = $entity_activity_manager;
    $this->enabledContentEntityTypes = $this->entityActivityManager->getContentEntityTypesEnabled();
    $this->supportedContentEntityTypes = $this->entityActivityManager->getSupportedContentEntityTypes(TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('entity_field.manager'),
      $container->get('config.factory'),
      $container->get('entity_activity.manager')
    );
  }

  public function routes() {
    $collection = new RouteCollection();
    if (empty($this->enabledContentEntityTypes)) {
      return $collection;
    }

    foreach ($this->enabledContentEntityTypes as $entity_type_id) {
      $entity_type = isset($this->supportedContentEntityTypes[$entity_type_id]) ? $this->supportedContentEntityTypes[$entity_type_id] : NULL;
      if ($entity_type && $list_subscribers_route = $this->getListSubscribersRoute($entity_type)) {
        $collection->add("entity_activity.{$entity_type_id}.list_subscribers", $list_subscribers_route);
      }
    }
    return $collection;
  }

  /**
   * Gets the list subscribers route.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type.
   *
   * @return \Symfony\Component\Routing\Route|null
   *   The generated route, if available.
   */
  protected function getListSubscribersRoute(EntityTypeInterface $entity_type) {
    if ($entity_type->hasLinkTemplate('canonical') && $entity_type->hasViewBuilderClass()) {
      $entity_type_id = $entity_type->id();
      $path = $entity_type->getLinkTemplate('canonical');
      $route = new Route($path . '/list-subscribers');
      $route
        ->addDefaults([
          '_controller' => '\Drupal\entity_activity\Controller\ListSubscribersController::list',
          '_title_callback' => '\Drupal\entity_activity\Controller\ListSubscribersController::title',
        ])
        ->setRequirement('_custom_access', '\Drupal\entity_activity\Access\ListSubscribersAccess::access')
        ->setOption('parameters', [
          $entity_type_id => ['type' => 'entity:' . $entity_type_id],
        ]);

      // Entity types with serial IDs can specify this in their route
      // requirements, improving the matching process.
      if ($this->getEntityTypeIdKeyType($entity_type) === 'integer') {
        $route->setRequirement($entity_type_id, '\d+');
      }
      return $route;
    }
  }

  /**
   * Gets the type of the ID key for a given entity type.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   An entity type.
   *
   * @return string|null
   *   The type of the ID key for a given entity type, or NULL if the entity
   *   type does not support fields.
   */
  protected function getEntityTypeIdKeyType(EntityTypeInterface $entity_type) {
    if (!$entity_type->entityClassImplements(FieldableEntityInterface::class)) {
      return NULL;
    }

    $field_storage_definitions = $this->entityFieldManager->getFieldStorageDefinitions($entity_type->id());
    return $field_storage_definitions[$entity_type->getKey('id')]->getType();
  }

}
