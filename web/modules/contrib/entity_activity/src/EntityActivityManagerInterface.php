<?php

namespace Drupal\entity_activity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\UserInterface;

/**
 * Interface EntityActivityManagerInterface.
 */
interface EntityActivityManagerInterface {

  /**
   * Returns objects or id of content entity types supported by Log generators.
   *
   * @param bool $return_object
   *   Should we return an array of object ?
   *
   * @return array
   *   Id or Objects of entity types that can generate log.
   */
  public function getSupportedContentEntityTypes($return_object = FALSE);

  /**
   * Returns an array of content entity types ID enabled.
   *
   * @return array
   *   An array of entity type id that can generate log and/or on which we can
   *   subscribe.
   */
  public function getContentEntityTypesEnabled();

  /**
   * Gets the bundles of an entity type.
   *
   * @param string $entity_type_id
   *   The entity type id.
   *
   * @return array
   *   An array of bundles.
   */
  public function getBundlesPerEntityType($entity_type_id);

  /**
   * Dispatch an entity for an event name.
   *
   * @param string $event_name
   *   The event name.
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The content entity.
   */
  public function dispatch($event_name, ContentEntityInterface $entity);

  /**
   * Collect Log generator plugin instances given an entity type id.
   *
   * @param string $entity_type_id
   *   The entity type id for which we want log generators.
   * @paran string $langcode
   *   The optional langcode.
   *
   * @return \Drupal\entity_activity\Plugin\LogGeneratorInterface[][]
   *   An array keyed by the config entity id with as value an array of
   *   LogGenerator plugin instance keyed by their plugin_id.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getLogGenerators($entity_type_id, $langcode = NULL);

  /**
   * Delete subscriptions done on an entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The content entity.
   */
  public function deleteSubscriptions(ContentEntityInterface $entity);

  /**
   * Delete the user subscriptions.
   *
   * @param \Drupal\user\UserInterface $user
   *   The user entity.
   */
  public function deleteUserSubscriptions(UserInterface $user);

  /**
   * Delete the user logs.
   *
   * @param \Drupal\user\UserInterface $user
   *   The user entity.
   */
  public function deleteUserLogs(UserInterface $user);

  /**
   * Get the entity's langcode or the default langcode as fallback.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The content entity.
   *
   * @return string
   */
  public function getEntityLangcode(ContentEntityInterface $entity);

  /**
   * Purge log given the global settings.
   */
  public function purgeLog();

  /**
   * Invalidate cache tags given an content entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The content entity.
   */
  public function invalidateCache(ContentEntityInterface $entity);

}
