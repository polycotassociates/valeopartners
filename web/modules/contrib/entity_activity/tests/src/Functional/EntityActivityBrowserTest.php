<?php

namespace Drupal\Tests\entity_activity\Functional;

use Drupal\entity_activity\Entity\Generator;
use Drupal\node\Entity\Node;

/**
 * Provides a base test for Entity Activity entities.
 *
 * @group entity_activity
 */
class EntityActivityBrowserTest extends EntityActivityBrowserTestBase {

  /**
   * A subscription.
   *
   * @var \Drupal\entity_activity\Entity\SubscriptionInterface
   */
  protected $subscription1;

  /**
   * A subscription.
   *
   * @var \Drupal\entity_activity\Entity\SubscriptionInterface
   */
  protected $subscription2;

  /**
   * A subscription.
   *
   * @var \Drupal\entity_activity\Entity\SubscriptionInterface
   */
  protected $subscription3;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->subscription1 = $this->createSubscription($this->user1, $this->term1);
    $this->subscription2 = $this->createSubscription($this->user1, $this->user2);
    $this->subscription3 = $this->createSubscription($this->user2, $this->term2);
  }

  /**
   * Test permissions's module.
   *
   * @throws \Behat\Mink\Exception\ElementNotFoundException
   * @throws \Behat\Mink\Exception\ExpectationException
   * @throws \Drupal\Core\Entity\EntityMalformedException
   */
  public function testPermissions() {
    $this->drupalLogin($this->advancedUser);
    $this->drupalGet($this->article1->toUrl());
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->buttonExists('Subscribe');
    $this->assertText('Subscribe');

    $this->drupalGet('user/' . $this->user1->id() . '/subscriptions');
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalGet('user/' . $this->user1->id() . '/logs');
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalGet('user/' . $this->user2->id() . '/subscriptions');
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalGet('user/' . $this->user2->id() . '/logs');
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalLogout();
    $this->drupalLogin($this->user1);

    $this->drupalGet('user/' . $this->user1->id() . '/subscriptions');
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalGet('user/' . $this->user1->id() . '/logs');
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalGet('user/' . $this->user2->id() . '/subscriptions');
    $this->assertSession()->statusCodeEquals(403);

    $this->drupalGet('user/' . $this->user2->id() . '/logs');
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Test generation of logs from a reference field and with(out) a cron.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function testGenerationLogsByReference() {
    // User 1 has a subscription on User 2 and on Term 1.
    $subscriptions = $this->subscriptionStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(2, count($subscriptions));
    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(0, count($logs));

    $this->drupalLogin($this->user2);
    $new_article = Node::create([
        'type' => 'article',
        'uid' => $this->user2,
        'title' => 'New Article',
        'body' => ['value' => 'The body of the new article'],
      ]
    );
    $new_article->save();

    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(1, count($logs));

    $this->drupalLogout();
    $this->drupalLogin($this->user1);
    $this->drupalGet('user/' . $this->user1->id() . '/logs');
    $this->assertText('The content New Article has been created by ' . $this->user2->getDisplayName() . '. Log with the generator test_insert.');

    $this->drupalLogout();
    $this->drupalLogin($this->user2);
    $this->article1->set('field_term', $this->term1)->save();

    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(2, count($logs));

    $this->drupalLogout();
    $this->drupalLogin($this->user1);
    $this->drupalGet('user/' . $this->user1->id() . '/logs');
    $this->assertText('The content Article 1 has been updated by ' . $this->user2->getDisplayName() . '. Log with the generator test_update_term.');

    $this->drupalLogout();
    $this->drupalLogin($this->user2);
    $new_article->delete();

    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(3, count($logs));

    $this->drupalLogout();
    $this->drupalLogin($this->user1);
    $this->drupalGet('user/' . $this->user1->id() . '/logs');
    $this->assertText('The content New Article has been deleted by ' . $this->user2->getDisplayName() . '. Log with the generator test_delete.');

    $config = \Drupal::configFactory()->getEditable('entity_activity.generator.test_insert');
    $config->set('generators.node.use_cron', TRUE);
    $config->save(TRUE);

    $this->drupalLogout();
    $this->drupalLogin($this->user2);
    $another_article = Node::create([
        'type' => 'article',
        'uid' => $this->user2,
        'title' => 'Another Article',
        'body' => ['value' => 'The body of the another article'],
      ]
    );
    $another_article->save();

    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(3, count($logs));
    $this->assertEquals(1, \Drupal::queue('entity_activity_log_generator_worker')->numberOfItems());
    $this->container->get('cron')->run();

    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(4, count($logs));
    $this->assertEquals(0, \Drupal::queue('entity_activity_log_generator_worker')->numberOfItems());

    $this->drupalLogout();
    $this->drupalLogin($this->user1);
    $this->drupalGet('user/' . $this->user1->id() . '/logs');
    $this->assertText('The content Another Article has been created by ' . $this->user2->getDisplayName() . '. Log with the generator test_insert.');
  }

  /**
   * Test the purge Logs feature.
   */
  public function testPurgeLogs() {
    $config = \Drupal::configFactory()->getEditable('entity_activity.settings');
    $purge = [
      'method' => 'time',
      'read_only' => FALSE,
      'time' => [
        'number' => 2,
        'unit' => 'day',
      ],
    ];
    $config->set('purge', $purge);
    $config->save(TRUE);

    for ($i = 1; $i <= 5; $i++) {
      $this->article2->save();
    }

    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(5, count($logs));
    $time = $this->container->get('datetime.time');
    $tree_day_ago = $time->getRequestTime() - (86400 * 3);
    $log = reset($logs);
    $log->set('created', $tree_day_ago)->save();
    $this->container->get('cron')->run();
    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(4, count($logs));

    $purge = [
      'method' => 'time',
      'read_only' =>TRUE,
      'time' => [
        'number' => 2,
        'unit' => 'day',
      ],
    ];
    $config->set('purge', $purge);
    $config->save(TRUE);
    $log = reset($logs);
    $log->set('created', $tree_day_ago)->save();
    $this->container->get('cron')->run();
    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(4, count($logs));
    $log->set('read', TRUE)->save();
    $this->container->get('cron')->run();
    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(3, count($logs));

  }



}
