<?php

namespace Drupal\entity_activity\EventSubscriber;

use Drupal\Core\Queue\QueueFactory;
use Drupal\entity_activity\EntityActivityManagerInterface;
use Drupal\entity_activity\Event\EntityActivityEvent;
use Drupal\entity_activity\Event\EntityActivityEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Generate or queues logs for entity activity.
 *
 * Modules wishing to provide their own logic should register
 * an event subscriber with a higher priority (for example, 100). And then
 * can set the processed status to TRUE to stop this EventSubscriber.
 */
class EntityActivitySubscriber implements EventSubscriberInterface {

  /**
   * The entity activity manager.
   *
   * @var \Drupal\entity_activity\EntityActivityManagerInterface
   */
  protected $entityActivityManager;

  /**
   * Queue factory.
   *
   * @var \Drupal\Core\Queue\QueueFactory
   */
  protected $queueFactory;

  /**
   * Constructs a new EntityActivitySubscriber object.
   *
   * @param \Drupal\entity_activity\EntityActivityManagerInterface $entity_activity_manager
   *   The entity type manager.
   * @param \Drupal\Core\Queue\QueueFactory $queue_factory
   *   The queue factory.
   */
  public function __construct(EntityActivityManagerInterface $entity_activity_manager, QueueFactory $queue_factory) {
    $this->entityActivityManager = $entity_activity_manager;
    $this->queueFactory = $queue_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [
      EntityActivityEvents::ENTITY_ACTIVITY_INSERT => ['insertGenerateLog', 0],
      EntityActivityEvents::ENTITY_ACTIVITY_UPDATE => ['updateGenerateLog', 0],
      EntityActivityEvents::ENTITY_ACTIVITY_DELETE => ['deleteGenerateLog', 0],
    ];
    return $events;
  }

  /**
   * Generate logs for the insert operation.
   *
   * @param \Drupal\entity_activity\Event\EntityActivityEvent $event
   *   The entity activity event.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function insertGenerateLog(EntityActivityEvent $event) {
    $this->generateLog($event, 'insert');
  }

  /**
   * Generate logs for the update operation.
   *
   * @param \Drupal\entity_activity\Event\EntityActivityEvent $event
   *   The entity activity event.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function updateGenerateLog(EntityActivityEvent $event) {
    $this->generateLog($event, 'update');
  }

  /**
   * Generate logs for the delete operation.
   *
   * @param \Drupal\entity_activity\Event\EntityActivityEvent $event
   *   The entity activity event.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function deleteGenerateLog(EntityActivityEvent $event) {
    $this->generateLog($event, 'delete');
  }

  /**
   * Generate logs for a given operation.
   *
   * @param \Drupal\entity_activity\Event\EntityActivityEvent $event
   *   The entity activity event.
   * @param string $operation
   *   The operation.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function generateLog(EntityActivityEvent $event, $operation) {
    if (!$event->isProcessed()) {
      /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
      $entity = $event->getEntity();
      $langcode = NULL;
      if ($language = $entity->language()) {
        $langcode = $language->getId();
      }
      $entity_type_id = $entity->getEntityTypeId();
      $log_generators_per_config = $this->entityActivityManager->getLogGenerators($entity_type_id, $langcode);
      /** @var \Drupal\entity_activity\Plugin\LogGeneratorInterface $log_generator */
      foreach ($log_generators_per_config as $generator_id => $log_generators) {
        foreach ($log_generators as $plugin_id => $log_generator) {
          if ($log_generator->isEnabled() && $log_generator->getOperation() == $operation) {
            $settings = $log_generator->preGenerateLog($entity, $generator_id);
            if ($log_generator->useCron()) {
              $data = [
                'plugin_id' => $log_generator->getPluginId(),
                'configuration' => $log_generator->getConfiguration(),
                'settings' => $settings,
              ];
              $this->queueFactory->get('entity_activity_log_generator_worker')->createItem($data);
            }
            else {
              $log_generator->generateLog($settings);
            }
          }
        }

      }
    }
  }

}
