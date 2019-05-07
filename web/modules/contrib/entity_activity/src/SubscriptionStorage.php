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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * The subscription storage.
 */
class SubscriptionStorage extends EntityActivityContentEntityStorage implements SubscriptionStorageInterface {

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
  public function generate(ContentEntityInterface $source, AccountInterface $owner = NULL, $langcode = NULL, array $parameters = []) {
    $values = [
      'source_entity_id' => $source->id(),
      'source_entity_type' => $source->getEntityTypeId(),
      'parameters' => $parameters,
    ];

    if ($langcode) {
      $values['langcode'] = $langcode;
    }

    if ($owner instanceof AccountInterface) {
      $values['uid'] = $owner->id();
    }

    $subscription = $this->create($values);
    return $subscription;
  }

  /**
   * {@inheritdoc}
   */
  public function loadMultipleByEntity(ContentEntityInterface $entity, $langcode) {
    return $this->loadByProperties([
      'langcode' => $langcode,
      'source_entity_id' => $entity->id(),
      'source_entity_type' => $entity->getEntityTypeId(),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function loadMultipleByEntityTypeId($entity_type_id, $entity_id, $langcode) {
    return $this->loadByProperties([
      'langcode' => $langcode,
      'source_entity_id' => $entity_id,
      'source_entity_type' => $entity_type_id,
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
  public function loadMultipleByEntityAndOwner(ContentEntityInterface $entity, AccountInterface $account, $langcode) {;
    return $this->loadByProperties([
      'langcode' => $langcode,
      'uid' => $account->id(),
      'source_entity_id' => $entity->id(),
      'source_entity_type' => $entity->getEntityTypeId(),
    ]);
  }

}
