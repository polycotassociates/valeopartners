<?php

namespace Drupal\entity_activity;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Interface EntityActivityManagerInterface.
 */
interface EntityActivityManagerInterface {

  /**
   * Returns objects of content entity types supported by Log generators.
   *
   * @return array
   *   Objects of entity types that can generate log.
   */
  public function getSupportedContentEntityTypes();

  /**
   * Returns an array of content entity types ID enabled.
   *
   * @return array
   *   Objects of entity types that can generate log.
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

}
