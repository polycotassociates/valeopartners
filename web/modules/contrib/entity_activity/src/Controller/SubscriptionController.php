<?php

namespace Drupal\entity_activity\Controller;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\entity_activity\Entity\SubscriptionInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SubscriptionController.
 */
class SubscriptionController extends EntityActivityBaseController {

  /**
   * Check if an entity has a subscription for the current user.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The Json response.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function haveSubscription(Request $request) {
    $data = $this->getPostData($request);
    $response = $this->defaultResponse($data);
    if (!$this->dataIsValid(['entity_type', 'entity_id', 'langcode'], $data)) {
      return $this->notValidRequest($data);
    }

    // Get the entity to check if there is a subscription related for the
    // current user.
    $entity = $this->getEntity($data['entity_type'], $data['entity_id']);
    if (!$entity instanceof ContentEntityInterface) {
      return $response;
    }

    $subscriptions = $this->subscriptionStorage()->loadMultipleByEntityAndOwner($entity, $this->currentUser, $data['langcode']);
    if ($subscriptions) {
      $response = $this->getResponse(200, 'Current user has a subscription.', $data, TRUE);
    }
    else {
      $response = $this->getResponse(200, 'Current user has not a subscription.', $data, FALSE);
    }

    return $response;
  }

  /**
   * Create or delete a subscription for an entity and the current user.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The response.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function addRemove(Request $request) {
    $data = $this->getPostData($request);
    $response = $this->defaultResponse($data);
    if (!$this->dataIsValid(['entity_type', 'entity_id', 'langcode'], $data)) {
      return $this->notValidRequest($data);
    }

    // Get the entity to check if there is a subscription related for the
    // current user.
    $entity = $this->getEntity($data['entity_type'], $data['entity_id']);
    if (!$entity instanceof ContentEntityInterface) {
      return $response;
    }

    $subscriptions = $this->subscriptionStorage()->loadMultipleByEntityAndOwner($entity, $this->currentUser, $data['langcode']);
    if ($subscriptions) {
      /** @var \Drupal\entity_activity\Entity\SubscriptionInterface $subscription */
      $subscription = reset($subscriptions);
      if ($this->isAdmin($subscription) || $this->isOwner($subscription)) {
        $subscription->delete();
        $response = $this->getResponse(200, 'Subscription removed.', $data, TRUE, ['action' => 'unsubscribe-done']);
      }
      else {
        $response = $this->getResponse(200, 'Access denied.', $data, FALSE, ['action' => 'access-denied']);
      }
    }
    else {
      $subscription = $this->subscriptionStorage()->create([
        'uid' => $this->currentUser->id(),
        'langcode' => $data['langcode'],
        'source_entity_type' => $data['entity_type'],
        'source_entity_id' => $data['entity_id'],
        'status' => TRUE,
      ]);
      $result = $subscription->save();
      if ($result) {
        $response = $this->getResponse(200, 'Subscription created.', $data, TRUE, ['action' => 'subscribe-done']);
      }
    }

    return $response;
  }

  /**
   * Remove a subscription with the subscription ID given.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The response.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function remove(Request $request) {
    $data = $this->getPostData($request);
    $response = $this->defaultResponse($data);
    if (!$this->dataIsValid(['element_id', 'entity_id'], $data)) {
      return $this->notValidRequest($data);
    }

    // Get the subscription related for the current user.
    $entity = $this->getEntity('entity_activity_subscription', $data['entity_id']);
    if (!$entity instanceof SubscriptionInterface) {
      return $response;
    }

    if ($this->isAdmin($entity) || $this->isOwner($entity)) {
      $entity->delete();
      $response = $this->getResponse(200, 'Subscription removed.', $data, TRUE, ['action' => 'removal-done']);
    }
    else {
      $response = $this->getResponse(200, 'Subscription not removed. Access denied.', $data, TRUE, ['action' => 'removal-cancelled']);
    }

    return $response;
  }

  /**
   * Check if a subscription is enable.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The response.
   */
  public function status(Request $request) {
    // @TODO to implement. Currently all subscriptions are enable per default.
    $data = $this->getPostData($request);
    $response = $this->defaultResponse($data);
    return $response;
  }

  /**
   * Enable or disable a subscription.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The response.
   */
  public function enableDisable(Request $request) {
    // @TODO to implement. Currently all subscriptions are enable per default.
    $data = $this->getPostData($request);
    $response = $this->defaultResponse($data);
    return $response;
  }

  /**
   * Get the subscription storage.
   *
   * @return \Drupal\entity_activity\SubscriptionStorageInterface
   *   The subscription storage.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function subscriptionStorage() {
    return $this->entityTypeManager->getStorage('entity_activity_subscription');
  }

}
