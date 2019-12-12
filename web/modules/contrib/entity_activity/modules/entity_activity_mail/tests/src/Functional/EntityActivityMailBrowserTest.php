<?php

namespace Drupal\Tests\entity_activity_mail\Functional;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Test\AssertMailTrait;
use Drupal\entity_activity_mail\ReportServiceInterface;
use Drupal\node\Entity\Node;
use Drupal\Tests\entity_activity\Functional\EntityActivityBrowserTestBase;

/**
 * Provides a base test for Entity Activity Mail.
 *
 * @group entity_activity
 */
class EntityActivityMailBrowserTest extends EntityActivityBrowserTestBase {

  use AssertMailTrait;

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
    'options',
    'entity_activity_mail',
  ];

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
   * The report service.
   *
   * @var \Drupal\entity_activity_mail\ReportServiceInterface
   */
  protected $reportService;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->reportService = $this->container->get('entity_activity_mail.report');
    // User 1 has a subscription on User 2 and on Term 1.
    // User 2 has a subscription on User 1.
    $this->subscription1 = $this->createSubscription($this->user1, $this->user2);
    $this->subscription2 = $this->createSubscription($this->user2, $this->user1);
    $this->subscription3 = $this->createSubscription($this->user1, $this->term1);
    // Set mail on user 1 and 2.
    $this->user1->set('mail', 'user1@example.fr')->save();
    $this->user2->set('mail', 'user2@example.fr')->save();
  }

  /**
   * Test immediately notifications mails.
   */
  public function testImmediatelyMails() {
    $this->user1->set('entity_activity_mail_frequency', 'immediately')->save();

    $this->drupalLogin($this->user2);
    $new_article = Node::create([
        'type' => 'article',
        'uid' => $this->user2,
        'title' => 'New Article',
        'body' => ['value' => 'The body of the new article'],
        'langcode' => $this->langcode,
      ]
    );
    $new_article->save();

    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(1, count($logs));
    $emails = $this->getMails();
    $this->assertCount(1, $emails);
    $email = end($emails);
    $this->assertEquals($this->user1->getEmail(), $email['to']);
    $this->assertEquals('Logs report', $email['subject']);
    $this->assertContains('Logs report for ' . $this->user1->getDisplayName(), $email['body']);
    $this->assertContains('The content New Article has been created by ' . $this->user2->getDisplayName() . '.', $email['body']);
    $this->assertContains('test_insert', $email['body']);

    $this->user1->set('entity_activity_mail_frequency', 'daily')->save();

    $this->drupalLogin($this->user2);
    $new_article = Node::create([
        'type' => 'article',
        'uid' => $this->user2,
        'title' => 'New Article',
        'body' => ['value' => 'The body of the new article'],
        'langcode' => $this->langcode,
      ]
    );
    $new_article->save();

    $logs = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(2, count($logs));
    $emails = $this->getMails();
    // No new email has been sent yet.
    $this->assertCount(1, $emails);
  }

  /**
   * Test daily logs report mails.
   */
  public function testDailyLogsReport() {
    $this->user1
      ->set('entity_activity_mail_frequency', 'daily')
      ->set('entity_activity_mail_last', 0)
      ->save();
    $this->user2
      ->set('entity_activity_mail_frequency', 'daily')
      ->set('entity_activity_mail_last', 0)
      ->save();

    $this->drupalLogin($this->user2);
    $new_article = Node::create([
        'type' => 'article',
        'uid' => $this->user2,
        'title' => 'New Article 1',
        'body' => ['value' => 'The body of the new article 1'],
        'langcode' => $this->langcode,
      ]
    );
    $new_article->save();
    $this->article2->save();

    $this->drupalLogout();
    $this->drupalLogin($this->user1);
    $another_article = Node::create([
        'type' => 'article',
        'uid' => $this->user1,
        'title' => 'Another Article 2',
        'body' => ['value' => 'The body of the another article 2'],
        'langcode' => $this->langcode,
      ]
    );
    $another_article->save();
    $this->article1->save();
    $this->drupalLogout();

    $logs1 = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(2, count($logs1));
    $logs1_unsent = $this->reportService->getUnsentLogsPerUserId($this->user1->id());
    $this->assertCount(2, $logs1_unsent);

    $logs2 = $this->logStorage->loadMultipleByOwner($this->user2);
    $this->assertEqual(2, count($logs2));
    $logs2_unsent = $this->reportService->getUnsentLogsPerUserId($this->user2->id());
    $this->assertCount(2, $logs2_unsent);

    $emails = $this->getMails();
    $this->assertCount(0, $emails);
    $timestamp = $this->container->get('datetime.time')->getRequestTime();
    $date = DrupalDateTime::createFromTimestamp($timestamp);
    $daily_users = $this->reportService->getUsersPerFrequency('daily', $date);
    $this->assertCount(2, $daily_users);

    $two_days_ago = $timestamp - (86400 * 2);
    // This service is called by the cron. We specifically call this service
    // because cron can launch the two QueueWorker in the same process
    // And we want test each QueueWorker.
    $this->reportService->sendLogsReportUsers($two_days_ago);
    $this->assertEquals(1, \Drupal::queue('entity_activity_mail_prepare_report')->numberOfItems());
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_report')->numberOfItems());

    $this->processQueue('entity_activity_mail_prepare_report');
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_prepare_report')->numberOfItems());
    $this->assertEquals(2, \Drupal::queue('entity_activity_mail_report')->numberOfItems());

    $this->processQueue('entity_activity_mail_report');
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_prepare_report')->numberOfItems());
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_report')->numberOfItems());

    $emails = $this->getMails();
    $this->assertCount(2, $emails);

    $user1_index = NULL;
    $user2_index = NULL;
    foreach ($emails as $index => $email) {
      if ($email['to'] == $this->user1->getEmail()) {
        $user1_index = $index;
      }
      elseif ($email['to'] == $this->user2->getEmail()) {
        $user2_index = $index;
      }
    }
    
    $this->assertNotNull($user1_index);
    $this->assertNotNull($user2_index);
    $email = $emails[$user1_index];
    $this->assertEquals($this->user1->getEmail(), $email['to']);
    $this->assertEquals('Logs report', $email['subject']);
    $this->assertContains('Logs report for ' . $this->user1->getDisplayName(), $email['body']);
    $this->assertContains('The content New Article 1 has been created by ' . $this->user2->getDisplayName() . '.', $email['body']);
    $this->assertContains('The content Article 2 has been updated by ' . $this->user2->getDisplayName() . '.', $email['body']);
    $this->assertContains('test_insert', $email['body']);

    $email = $emails[$user2_index];
    $this->assertEquals($this->user2->getEmail(), $email['to']);
    $this->assertEquals('Logs report', $email['subject']);
    $this->assertContains('Logs report for ' . $this->user2->getDisplayName(), $email['body']);
    $this->assertContains('The content Another Article 2 has been created by ' . $this->user1->getDisplayName() . '.', $email['body']);
    $this->assertContains('The content Article 1 has been updated by ' . $this->user1->getDisplayName() . '.', $email['body']);
    $this->assertContains('test_insert', $email['body']);

    $logs1_unsent = $this->reportService->getUnsentLogsPerUserId($this->user1->id());
    $this->assertCount(0, $logs1_unsent);
    $logs2_unsent = $this->reportService->getUnsentLogsPerUserId($this->user2->id());
    $this->assertCount(0, $logs2_unsent);
  }

  /**
   * Test daily and weekly logs report mails.
   */
  public function testDailyWeeklyLogsReport() {
    $timestamp = $this->container->get('datetime.time')->getRequestTime();
    $date = DrupalDateTime::createFromTimestamp($timestamp);
    $one_day_ago = $timestamp - (86400 * 1);
    $two_days_ago = $timestamp - (86400 * 2);
    $height_days_ago = $timestamp - (86400 * 8);

    $this->user1
      ->set('entity_activity_mail_frequency', 'daily')
      ->set('entity_activity_mail_last', $two_days_ago)
      ->save();
    $this->user2
      ->set('entity_activity_mail_frequency', 'weekly')
      ->set('entity_activity_mail_last', $two_days_ago)
      ->save();

    $this->drupalLogin($this->user2);
    $new_article = Node::create([
        'type' => 'article',
        'uid' => $this->user2,
        'title' => 'New Article 1',
        'body' => ['value' => 'The body of the new article 1'],
        'langcode' => $this->langcode,
      ]
    );
    $new_article->save();
    $this->article2->save();

    $this->drupalLogout();
    $this->drupalLogin($this->user1);
    $another_article = Node::create([
        'type' => 'article',
        'uid' => $this->user1,
        'title' => 'Another Article 2',
        'body' => ['value' => 'The body of the another article 2'],
        'langcode' => $this->langcode,
      ]
    );
    $another_article->save();
    $this->article1->save();
    $this->drupalLogout();

    $logs1 = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(2, count($logs1));
    $logs1_unsent = $this->reportService->getUnsentLogsPerUserId($this->user1->id());
    $this->assertCount(2, $logs1_unsent);

    $logs2 = $this->logStorage->loadMultipleByOwner($this->user2);
    $this->assertEqual(2, count($logs2));
    $logs2_unsent = $this->reportService->getUnsentLogsPerUserId($this->user2->id());
    $this->assertCount(2, $logs2_unsent);

    $emails = $this->getMails();
    $this->assertCount(0, $emails);

    $daily_users = $this->reportService->getUsersPerFrequency('daily', $date);
    $this->assertCount(1, $daily_users);

    $weekly_users = $this->reportService->getUsersPerFrequency('weekly', $date);
    $this->assertCount(0, $weekly_users);

    // This service is called by the cron. We specifically call this service
    // because cron can launch the two QueueWorker in the same process
    // And we want test each QueueWorker.
    $this->reportService->sendLogsReportUsers($one_day_ago);
    $this->assertEquals(1, \Drupal::queue('entity_activity_mail_prepare_report')->numberOfItems());
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_report')->numberOfItems());

    $this->processQueue('entity_activity_mail_prepare_report');
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_prepare_report')->numberOfItems());
    $this->assertEquals(1, \Drupal::queue('entity_activity_mail_report')->numberOfItems());

    $this->processQueue('entity_activity_mail_report');
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_report')->numberOfItems());

    $emails = $this->getMails();
    $this->assertCount(1, $emails);

    $email = end($emails);
    $this->assertEquals($this->user1->getEmail(), $email['to']);
    $this->assertEquals('Logs report', $email['subject']);
    $this->assertContains('Logs report for ' . $this->user1->getDisplayName(), $email['body']);
    $this->assertContains('The content New Article 1 has been created by ' . $this->user2->getDisplayName() . '.', $email['body']);
    $this->assertContains('The content Article 2 has been updated by ' . $this->user2->getDisplayName() . '.', $email['body']);
    $this->assertContains('test_insert', $email['body']);

    $this->user2
      ->set('entity_activity_mail_last', $height_days_ago)
      ->save();
    $weekly_users = $this->reportService->getUsersPerFrequency('weekly', $date);
    $this->assertCount(1, $weekly_users);

    // This service is called by the cron. We specifically call this service
    // because cron can launch the two QueueWorker in the same process
    // And we want test each QueueWorker.
    $this->reportService->sendLogsReportUsers($one_day_ago);
    $this->assertEquals(1, \Drupal::queue('entity_activity_mail_prepare_report')->numberOfItems());
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_report')->numberOfItems());

    $this->processQueue('entity_activity_mail_prepare_report');
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_prepare_report')->numberOfItems());
    $this->assertEquals(1, \Drupal::queue('entity_activity_mail_report')->numberOfItems());

    $this->processQueue('entity_activity_mail_report');
    $this->assertEquals(0, \Drupal::queue('entity_activity_mail_report')->numberOfItems());

    $emails = $this->getMails();
    $this->assertCount(2, $emails);

    $email = end($emails);
    $this->assertEquals($this->user2->getEmail(), $email['to']);
    $this->assertEquals('Logs report', $email['subject']);
    $this->assertContains('Logs report for ' . $this->user2->getDisplayName(), $email['body']);
    $this->assertContains('The content Another Article 2 has been created by ' . $this->user1->getDisplayName() . '.', $email['body']);
    $this->assertContains('The content Article 1 has been updated by ' . $this->user1->getDisplayName() . '.', $email['body']);
    $this->assertContains('test_insert', $email['body']);
  }

  /**
   * Test mark as read feature.
   */
  public function testMarkAsRead() {
    $timestamp = $this->container->get('datetime.time')->getRequestTime();
    $date = DrupalDateTime::createFromTimestamp($timestamp);
    $one_day_ago = $timestamp - (86400 * 1);
    $two_days_ago = $timestamp - (86400 * 2);
    $height_days_ago = $timestamp - (86400 * 8);

    $config = \Drupal::configFactory()->getEditable('entity_activity_mail.settings');
    $config->set('general.mark_read', TRUE);
    $config->save(TRUE);

    $this->user1
      ->set('entity_activity_mail_frequency', 'daily')
      ->set('entity_activity_mail_last', $two_days_ago)
      ->save();
    $this->user2
      ->set('entity_activity_mail_frequency', 'weekly')
      ->set('entity_activity_mail_last', $two_days_ago)
      ->save();

    $this->drupalLogin($this->user2);
    $new_article = Node::create([
        'type' => 'article',
        'uid' => $this->user2,
        'title' => 'New Article 1',
        'body' => ['value' => 'The body of the new article 1'],
        'langcode' => $this->langcode,
      ]
    );
    $new_article->save();
    $this->article2->save();

    $this->drupalLogout();
    $this->drupalLogin($this->user1);
    $another_article = Node::create([
        'type' => 'article',
        'uid' => $this->user1,
        'title' => 'Another Article 2',
        'body' => ['value' => 'The body of the another article 2'],
        'langcode' => $this->langcode,
      ]
    );
    $another_article->save();
    $this->article1->save();
    $this->drupalLogout();

    $logs1 = $this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertCount(2, $logs1);
    $logs1_unread = $this->logStorage->totalUnreadByOwner($this->user1);
    $this->assertEqual(2, $logs1_unread);

    $logs2 = $this->logStorage->loadMultipleByOwner($this->user2);
    $this->assertCount(2, $logs2);
    $logs2_unread = $this->logStorage->totalUnreadByOwner($this->user2);
    $this->assertEqual(2, $logs2_unread);

    $emails = $this->getMails();
    $this->assertCount(0, $emails);

    $daily_users = $this->reportService->getUsersPerFrequency('daily', $date);
    $this->assertCount(1, $daily_users);

    $weekly_users = $this->reportService->getUsersPerFrequency('weekly', $date);
    $this->assertCount(0, $weekly_users);

    // We want to run the cron always.
    \Drupal::state()->set(ReportServiceInterface::NEXT_CRON, $one_day_ago);
    entity_activity_mail_cron();
    $this->container->get('cron')->run();
    $this->container->get('cron')->run();

    $emails = $this->getMails();
    $this->assertCount(1, $emails);

    $this->user2
      ->set('entity_activity_mail_last', $height_days_ago)
      ->save();
    $weekly_users = $this->reportService->getUsersPerFrequency('weekly', $date);
    $this->assertCount(1, $weekly_users);

    // We want to run the cron always.
    \Drupal::state()->set(ReportServiceInterface::NEXT_CRON, $one_day_ago);
    entity_activity_mail_cron();
    $this->container->get('cron')->run();
    $this->container->get('cron')->run();

    $emails = $this->getMails();
    $this->assertCount(2, $emails);

    $logs1_unread = $this->logStorage->totalUnreadByOwner($this->user1);
    $this->assertEqual(0, $logs1_unread);

    $logs2_unread = $this->logStorage->totalUnreadByOwner($this->user2);
    $this->assertEqual(0, $logs2_unread);

  }

}
