<?php

namespace Drupal\entity_activity\Entity;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\user\UserInterface;

/**
 * Defines the Log entity.
 *
 * @ingroup entity_activity
 *
 * @ContentEntityType(
 *   id = "entity_activity_log",
 *   label = @Translation("Log"),
 *   label_singular = @Translation("log"),
 *   label_plural = @Translation("logs"),
 *   label_count = @PluralTranslation(
 *     singular = "@count log",
 *     plural = "@count logs",
 *   ),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_activity\LogListBuilder",
 *     "views_data" = "Drupal\entity_activity\Entity\LogViewsData",
 *     "storage" = "Drupal\entity_activity\LogStorage",
 *     "access" = "Drupal\entity_activity\LogAccessControlHandler",
 *     "event" = "Drupal\entity_activity\Event\LogEvent",
 *     "route_provider" = {
 *       "html" = "Drupal\entity_activity\LogHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "entity_activity_log",
 *   internal = TRUE,
 *   admin_permission = "administer log entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "uid" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/config/content/entity-activity/logs",
 *   },
 *   field_ui_base_route = "entity_activity_log.settings"
 * )
 */
class Log extends ContentEntityBase implements LogInterface {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'current_user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function label() {
    return $this->t('Log #@id', ['@id' => $this->id()]);
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
  public function getCurrentUser() {
    return $this->get('current_user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getCurrentUserId() {
    return $this->get('current_user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setCurrentUserId($uid) {
    $this->set('current_user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCurrentUser(UserInterface $account) {
    $this->set('current_user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isRead() {
    return (bool) $this->get('read')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setRead($read) {
    $this->set('read', $read ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getSubscriptionId() {
    return $this->get('subscription')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function getSubscription() {
    return $this->get('subscription')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setSubscriptionId($subscription_id) {
    $this->set('subscription', $subscription_id);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setSubscription(SubscriptionInterface $subscription) {
    $this->set('subscription', $subscription->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getLogGeneratorId() {
    return $this->get('log_generator_id')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getLogGenerator() {
    $log_generator_manager = \Drupal::service('plugin.manager.entity_activity_log_generator');
    return $log_generator_manager->createInstance($this->getLogGeneratorId());
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
  public function getSourceEntity() {
    $source_entity = NULL;
    if ($this->getSourceEntityId() && $this->getSourceEntityTypeId()) {
      $source_entity = \Drupal::entityTypeManager()
        ->getStorage($this->getSourceEntityTypeId())
        ->load($this->getSourceEntityId());
    }
    return $source_entity;

  }

  /**
   * {@inheritdoc}
   */
  public function getReferenceSourceEntityId() {
    return $this->get('reference_source_entity_id')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getReferenceSourceEntityTypeId() {
    return $this->get('reference_source_entity_type')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getReferenceSourceEntity() {
    $reference_source_entity = NULL;
    if ($this->getReferenceSourceEntityId() && $this->getReferenceSourceEntityTypeId()) {
      $reference_source_entity = \Drupal::entityTypeManager()
        ->getStorage($this->getReferenceSourceEntityTypeId())
        ->load($this->getReferenceSourceEntityId());
    }
    return $reference_source_entity;
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
  public function getCacheTagsToInvalidate() {
    $cacheTags = parent::getCacheTagsToInvalidate();
    // We add a cache tag based on the log owner. We don't remove the global
    // list cache tags, but we don't want to use it because then all user's logs
    // views will be invalidated every time a log is created / updated. Instead
    // we remove this global list cache tags from our views and we can manage
    // user'log views cache with our custom list cache tag per user.
    // @TODO Should be best to create our own Plugin views cache
    // or use the views_custom_cache_tag module. Currently we remove this
    // listCacheTag from a basic hook_views_post_render().
    // @See entity_activity_views_post_render()
    $cacheTags = Cache::mergeTags($cacheTags, ['entity_activity_log:user:' . $this->getOwnerId()]);
    return $cacheTags;
  }

  /**
   * {@inheritdoc}
   */
  public function postCreate(EntityStorageInterface $storage) {
    Cache::invalidateTags(['entity_activity_log:user:' . $this->getOwnerId()]);
    parent::postCreate($storage);
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Owner'))
      ->setDescription(t('The user ID to whom the log entity is addressed.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['subscription'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Subscription'))
      ->setDescription(t('The subscription at the origin of the log entity.'))
      ->setSetting('target_type', 'entity_activity_subscription')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'entity_reference_label',
        'settings' => [
          'link' => 'false',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['read'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Read'))
      ->setDescription(t('A boolean indicating whether the Log is read.'))
      ->setDefaultValue(FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'entity_activity_log_read_unread',
        'settings' => [
          'format' => 'custom',
          'format_custom_false' => 'Unread',
          'format_custom_true' => 'Read',
          'enable_update_read_status' => TRUE,
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'))
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'timestamp',
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['log'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Log'))
      ->setDisplayOptions('view', [
        'type' => 'text_default',
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['current_user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User'))
      ->setDescription(t('The user which has generated the log.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\entity_activity\Entity\Log::getDefaultCurrentUserId');

    $fields['log_generator_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('The log generator plugin id.'))
      ->setDescription(t('The log generator plugin which has generated the entity.'));

    $fields['source_entity_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Source entity ID'))
      ->setDescription(t('The source entity ID'));

    $fields['source_entity_type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Source entity type'))
      ->setDescription(t('The source entity type'));

    $fields['reference_source_entity_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Reference source entity ID'))
      ->setDescription(t('The reference source entity ID'));

    $fields['reference_source_entity_type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Reference source entity type'))
      ->setDescription(t('The reference source entity type'));

    $fields['parameters'] = BaseFieldDefinition::create('map')
      ->setLabel(t('Parameters'))
      ->setDescription(t('A serialized array of additional parameters.'));

    return $fields;
  }

  /**
   * Default value callback for 'current_user_id' base field definition.
   *
   * @see ::baseFieldDefinitions()
   *
   * @return array
   *   An array of default values.
   */
  public static function getDefaultCurrentUserId() {
    return [\Drupal::currentUser()->id()];
  }

}
