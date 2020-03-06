<?php

namespace Drupal\Tests\entity_activity\Functional;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Queue\RequeueException;
use Drupal\Core\Queue\SuspendQueueException;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Tests\block\Traits\BlockCreationTrait;
use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\entity_activity\Traits\EntityActivityBrowserTestTrait;
use Drupal\Tests\field\Traits\EntityReferenceTestTrait;
use Drupal\Tests\node\Traits\NodeCreationTrait;
use Drupal\Tests\taxonomy\Functional\TaxonomyTestTrait;
use Drupal\user\UserInterface;

/**
 * Provides a base class for Entity Activity functional tests.
 */
abstract class EntityActivityBrowserTestBase extends BrowserTestBase {

  use BlockCreationTrait;
  use EntityReferenceTestTrait;
  use TaxonomyTestTrait;
  use NodeCreationTrait;
  use EntityActivityBrowserTestTrait;

  /**
   * Modules to enable.
   *
   * Note that when a child class declares its own $modules list, that list
   * doesn't override this one, it just extends it.
   *
   * @see \Drupal\simpletest\WebTestBase::installModulesFromClassProperty()
   *
   * @var array
   */
  public static $modules = [
    'system',
    'block',
    'field',
    'entity_activity',
    'node',
    'user',
    'taxonomy',
    'token',
    'text',
    'views',
    'entity_activity_test',
    'language',
    'locale',
    'content_translation'
  ];

  /**
   * A test user with administrative privileges.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * A test user with advanced privileges.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $advancedUser;

  /**
   * A test user with normal privileges.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user1;

  /**
   * A test user with normal privileges.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user2;

  /**
   * The vocabulary used for creating terms.
   *
   * @var \Drupal\taxonomy\VocabularyInterface
   */
  protected $vocabulary;

  /**
   * Stores the first term used in the different tests.
   *
   * @var \Drupal\taxonomy\TermInterface
   */
  protected $term1;

  /**
   * Stores the second term used in the different tests.
   *
   * @var \Drupal\taxonomy\TermInterface
   */
  protected $term2;

  /**
   * Store the first article.
   *
   * @var \Drupal\node\NodeInterface
   */
  protected $article1;

  /**
   * Store the second article.
   *
   * @var \Drupal\node\NodeInterface
   */
  protected $article2;

  /**
   * Store the first page.
   *
   * @var \Drupal\node\NodeInterface
   */
  protected $page1;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\entity_activity\SubscriptionStorageInterface definition.
   *
   * @var \Drupal\entity_activity\SubscriptionStorageInterface
   */
  protected $subscriptionStorage;

  /**
   * Drupal\entity_activity\LogStorageInterface definition.
   *
   * @var \Drupal\entity_activity\LogStorageInterface
   */
  protected $logStorage;

  /**
   * The default langcode.
   *
   * @var string
   */
  protected $langcode;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->entityTypeManager = $this->container->get('entity_type.manager');
    $this->subscriptionStorage = $this->entityTypeManager->getStorage('entity_activity_subscription');
    $this->logStorage = $this->entityTypeManager->getStorage('entity_activity_log');
    $this->langcode = \Drupal::languageManager()->getDefaultLanguage()->getId();

    $this->placeBlock('local_tasks_block');
    $this->placeBlock('local_actions_block');
    $this->placeBlock('page_title_block');
//    $this->placeBlock('entity_activity_user_log_block');
    $this->installEntityViewDisplayMode();

    // Create Basic page and Article node types.
    if ($this->profile != 'standard') {
      $this->drupalCreateContentType(['type' => 'article', 'name' => 'Article']);
      $this->drupalCreateContentType(['type' => 'page', 'name' => 'Page']);
    }

    $this->adminUser = $this->drupalCreateUser($this->getAdministratorPermissions());
    $this->advancedUser = $this->drupalCreateUser($this->getAdvancedPermissions());
    $this->user1 = $this->drupalCreateUser($this->getNormalPermissions());
    $this->user2 = $this->drupalCreateUser($this->getNormalPermissions());

    $view_modes = [
      'default',
      'teaser',
    ];
    foreach ($view_modes as $view_mode) {
      $this->entityTypeManager
        ->getStorage('entity_view_display')
        ->load("node.article.{$view_mode}")
        ->setComponent('subscribe_on', [
          'weight' => -100,
        ])
        ->save();

      $this->entityTypeManager
        ->getStorage('entity_view_display')
        ->load("node.page.{$view_mode}")
        ->setComponent('subscribe_on', [
          'weight' => -100,
        ])
        ->save();
    }

    $this->vocabulary = $this->createVocabulary();
    $this->term1 = $this->createTerm($this->vocabulary, ['name' => 'Tag term1', 'langcode' => $this->langcode]);
    $this->term2 = $this->createTerm($this->vocabulary, ['name' => 'Tag term2', 'langcode' => $this->langcode]);

    $handler_settings = [
      'target_bundles' => [
        $this->vocabulary->id() => $this->vocabulary->id(),
      ],
      'auto_create' => TRUE,
    ];
    $field_name = 'field_term';
    $this->createEntityReferenceField('node', 'article', $field_name, 'Tags', 'taxonomy_term', 'default', $handler_settings, FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED);
    $this->entityTypeManager
      ->getStorage('entity_form_display')
      ->load('node.article.default')
      ->setComponent($field_name, [
        'type' => 'entity_reference_autocomplete_tags',
        'weight' => -4,
      ])
      ->save();
    foreach ($view_modes as $view_mode) {
      $this->entityTypeManager
        ->getStorage('entity_view_display')
        ->load("node.article.{$view_mode}")
        ->setComponent($field_name, [
          'type' => 'entity_reference_label',
          'weight' => 10,
        ])
        ->save();
    }

    $settings = [
      'type' => 'article',
      'title' => 'Article 1',
      'uid' => $this->user1->id(),
      'langcode' => $this->langcode,
    ];
    $this->article1 = $this->createNode($settings);

    $settings = [
      'type' => 'article',
      'title' => 'Article 2',
      'uid' => $this->user2->id(),
      'langcode' => $this->langcode,
    ];
    $this->article2 = $this->createNode($settings);

    $settings = [
      'type' => 'page',
      'title' => 'Page 1',
      'uid' => $this->advancedUser->id(),
      'langcode' => $this->langcode,
    ];
    $this->page1 = $this->createNode($settings);
  }

  /**
   * Gets the permissions for the admin user.
   *
   * @return string[]
   *   The permissions.
   */
  protected function getAdministratorPermissions() {
    return [
      'administer users',
      'access user profiles',
      'view the administration theme',
      'access administration pages',
      'administer log entities',
      'administer subscription entities',
      'administer entity activity',
      'administer log generators',
      'subscribe all entities',
      'view own subscriptions',
      'view any subscriptions',
      'remove own subscriptions',
      'view own logs',
      'view any logs',
      'remove own logs',
      'view entities subscribers',
    ];
  }

  /**
   * Gets the permissions for the advanced user.
   *
   * @return string[]
   *   The permissions.
   */
  protected function getAdvancedPermissions() {
    return [
      'access user profiles',
      'view the administration theme',
      'access administration pages',
      'subscribe all entities',
      'view own subscriptions',
      'view any subscriptions',
      'remove own subscriptions',
      'view own logs',
      'view any logs',
      'remove own logs',
      'view entities subscribers on editable entities',
      'administer taxonomy',
    ];
  }

  /**
   * Gets the permissions for the normal user.
   *
   * @return string[]
   *   The permissions.
   */
  protected function getNormalPermissions() {
    return [
      'access user profiles',
      'subscribe all entities',
      'view own subscriptions',
      'remove own subscriptions',
      'view own logs',
      'remove own logs',
      'view entities subscribers on editable entities',
      'access content',
      'create article content',
    ];
  }

  /**
   * Install and set component for view display subscription and log entities.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function installEntityViewDisplayMode() {
    $view_display = $this->entityTypeManager
      ->getStorage('entity_view_display')
      ->load("entity_activity_subscription.entity_activity_subscription.default");
    if (!$view_display instanceof EntityViewDisplayInterface) {
      $values = [
        'id' => 'entity_activity_subscription.entity_activity_subscription.default',
        'bundle' => 'entity_activity_subscription',
        'targetEntityType' => 'entity_activity_subscription',
        'status' => TRUE,
        'mode' => 'default',
      ];
      $view_display = $this->entityTypeManager
        ->getStorage('entity_view_display')
        ->create($values)
        ->save();
    }
    $view_display = $this->entityTypeManager
      ->getStorage('entity_view_display')
      ->load("entity_activity_subscription.entity_activity_subscription.default");
    $view_display->setComponent('subscription_remove', [
      'weight' => -100,
    ])
      ->save();

    $view_display = $this->entityTypeManager
      ->getStorage('entity_view_display')
      ->load("entity_activity_log.entity_activity_log.default");
    if (!$view_display instanceof EntityViewDisplayInterface) {
      $values = [
        'id' => 'entity_activity_log.entity_activity_log.default',
        'bundle' => 'entity_activity_log',
        'targetEntityType' => 'entity_activity_log',
        'status' => TRUE,
        'mode' => 'default',
      ];
      $view_display = $this->entityTypeManager
        ->getStorage('entity_view_display')
        ->create($values)
        ->save();
    }
    $view_display = $this->entityTypeManager
      ->getStorage('entity_view_display')
      ->load("entity_activity_log.entity_activity_log.default");
    $view_display->setComponent('log_remove', [
      'weight' => -100,
    ])
      ->save();
  }

  /**
   * Create a subscription.
   *
   * @param \Drupal\user\UserInterface $user
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *
   * @return \Drupal\entity_activity\Entity\SubscriptionInterface
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createSubscription(UserInterface $user, ContentEntityInterface $entity) {
    $values = [
      'uid' => $user->id(),
      'status' => TRUE,
      'source_entity_type' => $entity->getEntityTypeId(),
      'source_entity_id' => $entity->id(),
      'langcode' => $this->langcode,
    ];
    /** @var \Drupal\entity_activity\Entity\SubscriptionInterface $subscription */
    $subscription = $this->subscriptionStorage->create($values);
    $subscription->save();
    return $subscription;
  }

  /**
   * Processes a cron queue.
   *
   * @param string $queue_name
   *   The queue name.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  protected function processQueue($queue_name) {
    // Grab the defined cron queues.
    /** @var \Drupal\Core\Queue\QueueFactory $queue_factory */
    $queue_factory = \Drupal::service('queue');
    /** @var \Drupal\Core\Queue\QueueWorkerManagerInterface $queue_manager */
    $queue_manager = \Drupal::service('plugin.manager.queue_worker');
    $queues = $queue_manager->getDefinitions();
    if (!isset($queues[$queue_name])) {
      return;
    }
    $info = $queues[$queue_name];
    if (isset($info['cron'])) {
      // Make sure every queue exists. There is no harm in trying to recreate
      // an existing queue.
      $queue_factory->get($queue_name)->createQueue();

      $queue_worker = $queue_manager->createInstance($queue_name);
      $end = time() + (isset($info['cron']['time']) ? $info['cron']['time'] : 15);
      $queue = $queue_factory->get($queue_name);
      $lease_time = isset($info['cron']['time']) ?: NULL;
      while (time() < $end && ($item = $queue->claimItem($lease_time))) {
        try {
          $queue_worker->processItem($item->data);
          $queue->deleteItem($item);
        }
        catch (RequeueException $e) {
          // The worker requested the task be immediately requeued.
          $queue->releaseItem($item);
        }
        catch (SuspendQueueException $e) {
          // If the worker indicates there is a problem with the whole queue,
          // release the item and skip to the next queue.
          $queue->releaseItem($item);

          watchdog_exception('cron', $e);
        }
        catch (\Exception $e) {
          // In case of any other kind of exception, log it and leave the item
          // in the queue to be processed again later.
          watchdog_exception('cron', $e);
        }
      }
    }
  }
}
