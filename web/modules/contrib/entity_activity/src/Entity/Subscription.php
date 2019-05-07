<?php

namespace Drupal\entity_activity\Entity;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\user\UserInterface;

/**
 * Defines the Subscription entity.
 *
 * @ingroup entity_activity
 *
 * @ContentEntityType(
 *   id = "entity_activity_subscription",
 *   label = @Translation("Subscription"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_activity\SubscriptionListBuilder",
 *     "views_data" = "Drupal\entity_activity\Entity\SubscriptionViewsData",
 *     "storage" = "Drupal\entity_activity\SubscriptionStorage",
 *     "access" = "Drupal\entity_activity\SubscriptionAccessControlHandler",
 *     "event" = "Drupal\entity_activity\Event\SubscriptionEvent",
 *     "route_provider" = {
 *       "html" = "Drupal\entity_activity\SubscriptionHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "entity_activity_subscription",
 *   admin_permission = "administer subscription entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "collection" = "/admin/config/content/entity-activity/subscriptions",
 *   },
 *   field_ui_base_route = "entity_activity_subscription.settings"
 * )
 */
class Subscription extends ContentEntityBase implements SubscriptionInterface {

  use EntityChangedTrait;
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'uid' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function label() {
    return $this->t('Subscription on @bundle @label', [
      '@bundle' => $this->getSourceEntityBundleLabel(),
      '@label' => $this->getSourceEntity()->label(),
    ])->render();
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isActive() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setActive($active) {
    $this->set('status', $active ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceEntityId() {
    return $this->get('source_entity_id')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceEntityTypeId() {
    return $this->get('source_entity_type')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getLangcode() {
    return $this->get('langcode')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceEntity() {
    $entity = \Drupal::entityTypeManager()
      ->getStorage($this->getSourceEntityTypeId())
      ->load($this->getSourceEntityId());
    if ($entity->hasTranslation($this->getLangcode())) {
      $entity = $entity->getTranslation($this->getLangcode());
    }
    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceEntityBundleLabel() {
    $bundle = $this->getSourceEntity()->bundle();
    $source_entity = $this->getSourceEntity();
    if ($source_entity instanceof ContentEntityInterface) {
      $entity_type_id = $source_entity->getEntityType()->getBundleEntityType();
      try {
        $bundle = $this->entityTypeManager()->getStorage($entity_type_id)->load($source_entity->bundle())->label();
      }
      catch (\Exception $e) {
        // Keep the bundle machine name.
      }
    }
    return $bundle;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTagsToInvalidate() {
    $cacheTags = parent::getCacheTagsToInvalidate();
    // We add a cache tag based on the subscription owner. We don't remove the
    // global list cache tags, but we don't want to use it because then all
    // user's subscriptions views will be invalidated every time a subscription
    // is created / updated / deleted. Instead we remove this global list cache
    // tags from our views and we can manage user's subscriptions views cache
    // with our custom list cache tag per user.
    // @TODO Should be best to create our own Plugin views cache
    // or use the views_custom_cache_tag module. Currently we remove this
    // listCacheTag from a basic hook_views_post_render().
    // @See entity_activity_views_post_render()
    $cacheTags = Cache::mergeTags($cacheTags, ['entity_activity_subscription:user:' . $this->getOwnerId()]);
    return $cacheTags;
  }

  /**
   * {@inheritdoc}
   */
  public function postCreate(EntityStorageInterface $storage) {
    Cache::invalidateTags(['entity_activity_subscription:user:' . $this->getOwnerId()]);
    parent::postCreate($storage);
  }

  /**
   * {@inheritdoc}
   */
  public function getParameters() {
    return $this->get('parameters')->first()->getValue();
  }

  /**
   * {@inheritdoc}
   */
  public function setParameters(array $parameters) {
    $this->set('parameters', $parameters);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Owner'))
      ->setDescription(t('The user ID owner of the Subscription entity.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Active status'))
      ->setDescription(t('A boolean indicating whether the Subscription is active or not.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['source_entity_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Source entity ID'))
      ->setDescription(t('The source entity ID'));

    $fields['source_entity_type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Source entity type'))
      ->setDescription(t('The source entity type'));

    $fields['parameters'] = BaseFieldDefinition::create('map')
      ->setLabel(t('Parameters'))
      ->setDescription(t('A serialized array of additional parameters.'));

    return $fields;
  }

}
