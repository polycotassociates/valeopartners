<?php

namespace Drupal\entity_activity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\entity_activity\Plugin\LogGeneratorPluginCollection;

/**
 * Provides an interface for defining Generator entities.
 */
interface GeneratorInterface extends ConfigEntityInterface {

  /**
   * Returns an array of log generators configurations.
   *
   * @return array
   *   An array of log generator configuration keyed by the log generator ID.
   */
  public function getLogGenerators();

  /**
   * Gets log generators for this entity.
   *
   * @return \Drupal\entity_activity\Plugin\LogGeneratorInterface[]|\Drupal\entity_activity\Plugin\LogGeneratorPluginCollection
   *   An array or collection of configured log generators plugins.
   */
  public function getLogGeneratorsCollection();

  /**
   * Set new log generators on the entity.
   *
   * @param \Drupal\entity_activity\Plugin\LogGeneratorPluginCollection $log_generators
   *   Log generators to set.
   */
  public function setLogGeneratorsCollection(LogGeneratorPluginCollection $log_generators);

  /**
   * Gets a log generator plugin instance.
   *
   * @param string $instance_id
   *   The log generator plugin instance ID.
   *
   * @return \Drupal\entity_activity\Plugin\LogGeneratorInterface
   *   A log generator plugin.
   */
  public function getLogGeneratorsInstance($instance_id);

  /**
   * Sets the generators log generator configuration.
   *
   * @param string $instance_id
   *   The log generator instance ID.
   * @param array $configuration
   *   The log generator configuration.
   *
   * @return $this
   */
  public function setLogGeneratorsConfig($instance_id, array $configuration);

}
