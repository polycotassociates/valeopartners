<?php

namespace Drupal\entity_activity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * The subscription storage.
 */
class SubscriptionStorage extends EntityActivityContentEntityStorage implements SubscriptionStorageInterface {

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
  public function loadMultipleByEntityAnyLangcode(ContentEntityInterface $entity) {
    return $this->loadByProperties([
      'source_entity_id' => $entity->id(),
      'source_entity_type' => $entity->getEntityTypeId(),
    ]);
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
