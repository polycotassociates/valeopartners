<?php

namespace Drupal\entity_activity;

use Drupal\Core\Cache\MemoryCache\MemoryCacheInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\entity_activity\Entity\SubscriptionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * The log storage class.
 */
class LogStorage extends EntityActivityContentEntityStorage implements LogStorageInterface {

  /**
   * Constructs a new EntityActivityContentEntityStorage object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection to be used.
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache backend to be used.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   * @param \Drupal\Core\Cache\MemoryCache\MemoryCacheInterface $memory_cache
   *   The memory cache.
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $event_dispatcher
   *   The event dispatcher.
   */
  public function __construct(EntityTypeInterface $entity_type, Connection $database, EntityManagerInterface $entity_manager, CacheBackendInterface $cache, LanguageManagerInterface $language_manager, MemoryCacheInterface $memory_cache, EventDispatcherInterface $event_dispatcher) {
    parent::__construct($entity_type, $database, $entity_manager, $cache, $language_manager, $memory_cache, $event_dispatcher);
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('database'),
      $container->get('entity.manager'),
      $container->get('cache.entity'),
      $container->get('language_manager'),
      $container->get('entity.memory_cache'),
      $container->get('event_dispatcher')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function generate(SubscriptionInterface $subscription, array $log, $log_generator_id, $current_user_id, $langcode, ContentEntityInterface $source = NULL, ContentEntityInterface $reference_source = NULL, array $parameters = []) {
    $values = [
      'langcode' => $langcode,
      'uid' => $subscription->getOwner()->id(),
      'subscription' => $subscription->id(),
      'log_generator_id' => $log_generator_id,
      'log' => $log,
      'parameters' => $parameters,
      'current_user_id' => $current_user_id,
    ];

    if ($source instanceof ContentEntityInterface) {
      $values['source_entity_id'] = $source->id();
      $values['source_entity_type'] = $source->getEntityTypeId();
    }
    elseif (isset($parameters['source_entity_id']) && isset($parameters['source_entity_type'])) {
      $values['source_entity_id'] = $parameters['source_entity_id'];
      $values['source_entity_type'] = $parameters['source_entity_type'];
    }

    if ($reference_source instanceof ContentEntityInterface) {
      $values['reference_source_entity_id'] = $reference_source->id();
      $values['reference_source_entity_type'] = $reference_source->getEntityTypeId();
    }
    elseif (isset($parameters['reference_source_entity_id']) && isset($parameters['reference_source_entity_type'])) {
      $values['reference_source_entity_id'] = $parameters['reference_source_entity_id'];
      $values['reference_source_entity_type'] = $parameters['reference_source_entity_type'];
    }
    $log = $this->create($values);
    return $log;
  }

  /**
   * {@inheritdoc}
   */
  public function loadMultipleByEntity(ContentEntityInterface $entity) {
    return $this->loadByProperties([
      'source_entity_id' => $entity->id(),
      'source_entity_type' => $entity->getEntityTypeId(),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function loadMultipleByOwner(AccountInterface $account) {
    return $this->loadByProperties([
      'uid' => $account->id(),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function loadMultipleUnreadByOwner(AccountInterface $account) {
    return $this->loadByProperties([
      'uid' => $account->id(),
      'read' => FALSE,
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function totalUnreadByOwner(AccountInterface $account) {
    $count = $this->getQuery()
      ->condition('uid', $account->id())
      ->condition('read', FALSE)
      ->count()
      ->execute();
    return $count;
  }

}
