<?php

namespace Drupal\entity_activity;

use Drupal\Component\Datetime\Time;
use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Site\Settings;
use Drupal\Core\State\StateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\entity_activity\Event\EntityActivityEvent;
use Drupal\entity_activity\Event\EntityActivityEvents;
use Drupal\entity_activity\Event\EntityActivitySupportEntityTypeEvent;
use Drupal\entity_activity\Plugin\LogGeneratorInterface;
use Drupal\entity_activity\Plugin\LogGeneratorManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class EntityActivityManager.
 */
class EntityActivityManager implements EntityActivityManagerInterface {

  use StringTranslationTrait;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * The entity repository.
   *
   * @var \Drupal\Core\Entity\EntityRepositoryInterface
   */
  protected $entityRepository;

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The current route match service.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * The log generator manager.
   *
   * @var \Drupal\entity_activity\Plugin\LogGeneratorManagerInterface
   */
  protected $logManager;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The entity type bundle info service.
   *
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  protected $entityTypeBundleInfo;

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * Queue factory.
   *
   * @var \Drupal\Core\Queue\QueueFactory
   */
  protected $queueFactory;

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\Time
   */
  protected $time;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * The subscription storage.
   *
   * @var \Drupal\entity_activity\SubscriptionStorageInterface
   */
  protected $subscriptionStorage;

  /**
   * The log storage.
   *
   * @var \Drupal\entity_activity\LogStorageInterface
   */
  protected $logStorage;

  /**
   * EntityActivityManager constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   *   The entity repository.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager.
   * @param |Drupal\entity_activity\Plugin\LogGeneratorManagerInterface $manager
   *   The log generator manager.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle info service.
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $event_dispatcher
   *   The event dispatcher.
   * @param \Drupal\Core\Queue\QueueFactory $queue
   *   The queue factory.
   * @param \Drupal\Component\Datetime\Time $time
   *   The time service.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, EntityRepositoryInterface $entity_repository, LanguageManagerInterface $language_manager, EntityFieldManagerInterface $entity_field_manager, LogGeneratorManagerInterface $manager, AccountProxyInterface $current_user, EntityTypeBundleInfoInterface $entity_type_bundle_info, EventDispatcherInterface $event_dispatcher, QueueFactory $queue, Time $time, StateInterface $state) {
    $this->configFactory = $config_factory;
    $this->entityTypeManager = $entity_type_manager;
    $this->entityRepository = $entity_repository;
    $this->languageManager = $language_manager;
    $this->entityFieldManager = $entity_field_manager;
    $this->logManager = $manager;
    $this->currentUser = $current_user;
    $this->entityTypeBundleInfo = $entity_type_bundle_info;
    $this->eventDispatcher = $event_dispatcher;
    $this->queueFactory = $queue;
    $this->time = $time;
    $this->state = $state;
    $this->subscriptionStorage = $this->entityTypeManager->getStorage('entity_activity_subscription');
    $this->logStorage = $this->entityTypeManager->getStorage('entity_activity_log');
  }

  /**
   * {@inheritdoc}
   */
  public function getSupportedContentEntityTypes($return_object = FALSE) {
    /** @var \Drupal\Core\Entity\ContentEntityTypeInterface[] $entity_types */
    $entity_types = $this->entityTypeManager->getDefinitions();
    foreach ($entity_types as $entity_type_id => $entity_type) {
      if (!$entity_type instanceof ContentEntityTypeInterface) {
        unset($entity_types[$entity_type_id]);
        continue;
      }
      if (!method_exists($entity_type, 'getBundleEntityType')
        || !$entity_type->hasLinkTemplate('canonical')) {
        // Custom modules can want to support content entity type without a
        // canonical link template, and then they must manage programmatically
        // subscriptions to these entities which can not have a "subscribe on"
        // button.
        $support_entity_type = new EntityActivitySupportEntityTypeEvent($entity_type_id);
        $this->eventDispatcher->dispatch(EntityActivityEvents::ENTITY_ACTIVITY_SUPPORT_ENTITY_TYPE, $support_entity_type);
        if ($support_entity_type->isSupported()) {
          continue;
        }
        unset($entity_types[$entity_type_id]);
      }
    }
    if ($return_object) {
      return $entity_types;
    }
    else {
      return array_keys($entity_types);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getContentEntityTypesEnabled() {
    $entity_types = [];
    $entity_type_settings = $this->configFactory->get('entity_activity.settings')->get('entity_type');
    foreach ($entity_type_settings as $entity_type_id => $value) {
      if ($value['enable']) {
        $entity_types[] = $entity_type_id;
      }
    }
    return $entity_types;
  }

  /**
   * {@inheritdoc}
   */
  public function getBundlesPerEntityType($entity_type_id) {
    $bundles = $this->entityTypeBundleInfo->getBundleInfo($entity_type_id);
    return $bundles;
  }

  /**
   * {@inheritdoc}
   */
  public function dispatch($event_name, ContentEntityInterface $entity) {
    $entity_type_enabled = $this->getContentEntityTypesEnabled();
    $is_enabled = in_array($entity->getEntityTypeId(), $entity_type_enabled);
    if ($is_enabled) {
      $event = new EntityActivityEvent($entity);
      $this->eventDispatcher->dispatch($event_name, $event);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getLogGenerators($entity_type_id, $langcode = NULL) {
    $log_generator_instances = [];
    $generators = $this->entityTypeManager->getStorage('entity_activity_generator')->loadMultiple();
    /** @var \Drupal\entity_activity\Entity\GeneratorInterface $generator */
    foreach ($generators as $generator) {
      $generator = $this->entityRepository->getTranslationFromContext($generator, $langcode);
      if (!$generator->status()) {
        continue;
      }
      $log_generators = $generator->getLogGenerators();
      foreach ($log_generators as $plugin_id => $log_generator_config) {
        try {
          $log_generator = $this->logManager->createInstance($plugin_id, $log_generator_config);
        }
        catch (PluginException $e) {
          $log_generator = NULL;
          // @todo log the error.
        }
        if ($log_generator instanceof LogGeneratorInterface
          && $log_generator->getSourceEntityType() == $entity_type_id) {
          $log_generator_instances[$generator->id()][$plugin_id] = $log_generator;
        }
      }
    }
    return $log_generator_instances;
  }

  /**
   * {@inheritdoc}
   */
  public function deleteSubscriptions(ContentEntityInterface $entity) {
    $subscriptions = $this->subscriptionStorage->loadMultipleByEntityAnyLangcode($entity);
    foreach ($subscriptions as $subscription) {
      $subscription->delete();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityLangcode(ContentEntityInterface $entity) {
    if ($entity->isTranslatable()) {
      $langcode = $entity->language()->getId();
    }
    else {
      $langcode = $this->languageManager->getDefaultLanguage()->getId();
    }
    return $langcode;
  }

  /**
   * {@inheritdoc}
   */
  public function purgeLog() {
    $queue = $this->queueFactory->get('entity_activity_purge_log_worker');
    $config = $this->configFactory->get('entity_activity.settings')->get('purge');

    if (empty($config['method'])) {
      return;
    }

    elseif ($config['method'] == 'time' && !empty($config['time']['number']) && !empty($config['time']['unit'])) {
      $current_date = new DrupalDateTime('now');
      $interval = new Interval($config['time']['number'], $config['time']['unit']);
      $expiration_date = $interval->subtract($current_date);
      $expiration = $expiration_date->getTimestamp();
      // Logs to be purged in groups of 50.
      $query = $this->logStorage->getQuery()
        ->accessCheck(FALSE)
        ->condition('created', $expiration, '<=')
        ->sort('created', 'ASC')
        ->range(0, 200);
      if ($config['read_only']) {
        $query->condition('read', TRUE);
      }
      $ids = $query->execute();

      if (!empty($ids)) {
        $data = array_chunk($ids, 50);
        foreach ($data as $chunk) {
          $queue->createItem($chunk);
        }

      }
    }

    elseif ($config['method'] == 'limit' && !empty($config['limit']['max'])) {
      // Heavy process. We run it only once per day.
      // @todo make this configurable.
      $request_time = $this->time->getCurrentTime();
      $next_process = $this->state->get('entity_activity.next_purge_log', 0);
      $purge_user_always = Settings::get('entity_activity_purge_user_always');
      if ($purge_user_always) {
        $next_process = 0;
      }
      if ($next_process < $request_time) {
        $tomorrow = strtotime('tomorrow 0:59:00');
        $this->state->set('entity_activity.next_purge_log', $tomorrow);

        // Let's go !
        $max = $config['limit']['max'];
        $users = $this->entityTypeManager->getStorage('user')->loadMultiple();
        /** @var \Drupal\user\UserInterface $user */
        foreach ($users as $user) {
          $data = [];
          $query = $this->logStorage->getQuery()
            ->accessCheck(FALSE)
            ->condition('uid', $user->id())
            ->sort('created', 'DESC')
            ->range($max, 200);
          $ids = $query->execute();

          if (!empty($ids)) {
            $data = array_chunk($ids, 50);
            foreach ($data as $chunk) {
              $queue->createItem($chunk);
            }
          }
        }
      }
    }
  }

}
