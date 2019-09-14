<?php

namespace Drupal\Tests\entity_activity\FunctionalJavascript;

/**
 * Provides a base test for Entity Activity entities.
 *
 * @group entity_activity
 */
class EntityActivityWebDriverTest extends EntityActivityWebDriverTestBase {

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->drupalLogin($this->advancedUser);
  }

  public function testAjaxButtons() {
    $this->drupalGet($this->article1->toUrl());
    $this->waitForAjaxToFinish();

    $page = $this->getSession()->getPage();
    $subscribe = $page->findButton('Subscribe');
    $this->assertNotEmpty($subscribe);
    $unsubscribe = $page->findButton('Unsubscribe');
    $this->assertNotTrue($unsubscribe->isVisible());

    $subscriptions = $this->subscriptionStorage->loadMultipleByOwner($this->advancedUser);
    $this->assertEquals(0, count($subscriptions));

    $page->pressButton('Subscribe');
    $this->waitForAjaxToFinish();

    $subscribe = $page->findButton('Subscribe');
    $this->assertNotTrue($subscribe->isVisible());
    $unsubscribe = $page->findButton('Unsubscribe');
    $this->assertNotEmpty($unsubscribe);

    $subscriptions = $this->subscriptionStorage->loadMultipleByOwner($this->advancedUser);
    $this->assertEquals(1, count($subscriptions));

    // Generate a log and check remove and read/unread buttons.
    $this->article1->set('body', 'This is the value of Article 1 body')->save();

    $logs =$this->logStorage->loadMultipleUnreadByOwner($this->advancedUser);
    $this->assertEqual(1, count($logs));

    $this->drupalGet('user/' . $this->advancedUser->id() . '/logs');
    $this->waitForAjaxToFinish();
    $page = $this->getSession()->getPage();
    $page->hasContent('The content Article 1 has been updated');
    $page->hasContent('Log with the generator test_update_source.');
    $remove = $page->findButton('Remove');
    $this->assertNotEmpty($remove);
    $unread = $page->findButton('Unread');
    $this->assertNotEmpty($unread);
    $page->pressButton('Unread');
    $this->waitForAjaxToFinish();

    $logs =$this->logStorage->loadMultipleUnreadByOwner($this->advancedUser);
    $this->assertEqual(0, count($logs));

    $logs =$this->logStorage->loadMultipleByOwner($this->advancedUser);
    $this->assertEqual(1, count($logs));

    $page->pressButton('Remove');
    $this->waitForAjaxToFinish();

    $page = $this->getSession()->getPage();
    $this->assertNotTrue($page->hasContent('The content Article 1 has been updated'));
    $logs =$this->logStorage->loadMultipleByOwner($this->advancedUser);
    $this->assertEqual(0, count($logs));

    // Check subscriptions page and Remove button.
    $this->drupalGet('user/' . $this->advancedUser->id() . '/subscriptions');
    $this->waitForAjaxToFinish();

    $page = $this->getSession()->getPage();
    $page->hasContent('Subscription on Article Article 1');
    $remove = $page->findButton('Remove');
    $this->assertNotEmpty($remove);
    $page->pressButton('Remove');
    $this->waitForAjaxToFinish();

    $this->assertNotTrue($page->hasContent('Subscription on Article Article 1'));
    $subscriptions = $this->subscriptionStorage->loadMultipleByOwner($this->advancedUser);
    $this->assertEquals(0, count($subscriptions));

    // With normal user.
    $this->drupalLogout();
    $this->drupalLogin($this->user1);

    $this->drupalGet($this->article1->toUrl());
    $this->waitForAjaxToFinish();

    $page = $this->getSession()->getPage();
    $subscribe = $page->findButton('Subscribe');
    $this->assertNotEmpty($subscribe);
    $unsubscribe = $page->findButton('Unsubscribe');
    $this->assertNotTrue($unsubscribe->isVisible());

    $subscriptions = $this->subscriptionStorage->loadMultipleByOwner($this->user1);
    $this->assertEquals(0, count($subscriptions));

    $page->pressButton('Subscribe');
    $this->waitForAjaxToFinish();

    $subscribe = $page->findButton('Subscribe');
    $this->assertNotTrue($subscribe->isVisible());
    $unsubscribe = $page->findButton('Unsubscribe');
    $this->assertNotEmpty($unsubscribe);

    $subscriptions = $this->subscriptionStorage->loadMultipleByOwner($this->user1);
    $this->assertEquals(1, count($subscriptions));

    // Generate a log and check remove and read/unread buttons.
    $this->article1->set('body', 'This is the value of Article 1 body')->save();

    $logs =$this->logStorage->loadMultipleUnreadByOwner($this->user1);
    $this->assertEqual(1, count($logs));

    $this->drupalGet('user/' . $this->user1->id() . '/logs');
    $this->waitForAjaxToFinish();
    $page = $this->getSession()->getPage();
    $page->hasContent('The content Article 1 has been updated');
    $page->hasContent('Log with the generator test_update_source.');
    $remove = $page->findButton('Remove');
    $this->assertNotEmpty($remove);
    $unread = $page->findButton('Unread');
    $this->assertNotEmpty($unread);
    $page->pressButton('Unread');
    $this->waitForAjaxToFinish();

    $logs =$this->logStorage->loadMultipleUnreadByOwner($this->user1);
    $this->assertEqual(0, count($logs));

    $logs =$this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(1, count($logs));

    $page->pressButton('Remove');
    $this->waitForAjaxToFinish();

    $page = $this->getSession()->getPage();
    $this->assertNotTrue($page->hasContent('The content Article 1 has been updated'));
    $logs =$this->logStorage->loadMultipleByOwner($this->user1);
    $this->assertEqual(0, count($logs));

    // Check subscriptions page and Remove button.
    $this->drupalGet('user/' . $this->user1->id() . '/subscriptions');
    $this->waitForAjaxToFinish();

    $page = $this->getSession()->getPage();
    $this->assertTrue($page->hasContent('Subscription on Article Article 1'));
    $remove = $page->findButton('Remove');
    $this->assertNotEmpty($remove);
    $page->pressButton('Remove');
    $this->waitForAjaxToFinish();

    $this->assertNotTrue($page->hasContent('Subscription on Article Article 1'));
    $subscriptions = $this->subscriptionStorage->loadMultipleByOwner($this->advancedUser);
    $this->assertEquals(0, count($subscriptions));
  }



}
