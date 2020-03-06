<?php

namespace Drupal\entity_activity\Controller;

use Drupal\Component\Utility\Html;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Site\Settings;
use Drupal\Core\Template\Attribute;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ListSubscribers controller.
 */
class ListSubscribersController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The entity repository service.
   *
   * @var \Drupal\Core\Entity\EntityRepositoryInterface
   */
  protected $entityRepository;

  /**
   * Drupal\Core\Routing\RouteMatchInterface definition.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The subscription storage.
   *
   * @var \Drupal\entity_activity\SubscriptionStorageInterface
   */
  protected $storageSubscription;

  /**
   * The view mode used to render subscription entities.
   *
   * Can be override with the parameter
   * $settings['entity_activity']['list_subscribers_view_mode'] in the file
   * settings.php.
   *
   * @var string
   */
  protected $viewMode = 'default';


  /**
   * ListSubscribersController constructor.
   *
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   *   The entity repository.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match service.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(EntityRepositoryInterface $entity_repository, EntityTypeManagerInterface $entity_type_manager, RouteMatchInterface $route_match) {
    $this->entityRepository = $entity_repository;
    $this->entityTypeManager = $entity_type_manager;
    $this->routeMatch = $route_match;
    $this->storageSubscription = $this->entityTypeManager->getStorage('entity_activity_subscription');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.repository'),
      $container->get('entity_type.manager'),
      $container->get('current_route_match')
    );
  }

  public function list(EntityInterface $entity = NULL) {
    $build = [];
    if (!$entity instanceof ContentEntityInterface) {
      $entity = $this->getCurrentEntity();
    }
    if (!$entity instanceof ContentEntityInterface) {
      return $build;
    }
    $classes = [
      'class' => [
        'list_subscribers',
        'list_subscribers--' . Html::cleanCssIdentifier($entity->getEntityTypeId()),
        'list_subscribers--' . Html::cleanCssIdentifier($entity->getEntityTypeId()) . '--' . $entity->id(),
      ]
    ];
    $langcode = $entity->language()->getId();
    $subscriptions = $this->storageSubscription->loadMultipleByEntityTypeId($entity->getEntityTypeId(), $entity->id(), $langcode);
    $build = [
      '#theme' => 'list_subscribers',
      '#entity' => $entity,
      '#subscriptions' => $subscriptions,
      '#attributes' => new Attribute($classes)
    ];

    if (!empty($subscriptions)) {
      $settings = Settings::get('entity_activity');
      if ($settings && !empty($settings['list_subscribers_view_mode'])) {
        $this->viewMode = $settings['list_subscribers_view_mode'];
      }
      $viewBuilder = $this->entityTypeManager->getViewBuilder('entity_activity_subscription');
      $build['#content'] = $viewBuilder->viewMultiple($subscriptions, $this->viewMode);
    }
    else {
      $build['#content'] = $this->t('No subscribers available.');
    }

    if (!isset($build['#cache']['tags'])) {
      $build['#cache']['tags'] = [];
    }
    $cache_tag_subscription_node = ['entity_activity_subscription:' . $entity->getEntityTypeId() . ':' . $entity->id()];
    $build['#cache']['tags'] = Cache::mergeTags($build['#cache']['tags'], $cache_tag_subscription_node);
    return $build;
  }

  /**
   * The _title_callback for the node.add route.
   *
   * @param \Drupal\Core\Entity\EntityInterface
   *   The current entity.
   *
   * @return string
   *   The page title.
   */
  public function title(EntityInterface $entity = NULL) {
    if (!$entity instanceof ContentEntityInterface) {
      $entity = $this->getCurrentEntity();
    }
    if (!$entity instanceof ContentEntityInterface) {
      return '';
    }
    return $this->t('@label subscribers', ['@label' => $entity->label()]);
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
