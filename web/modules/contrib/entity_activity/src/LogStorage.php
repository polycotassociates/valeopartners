<?php

namespace Drupal\entity_activity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\entity_activity\Entity\SubscriptionInterface;

/**
 * The log storage class.
 */
class LogStorage extends EntityActivityContentEntityStorage implements LogStorageInterface {

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
