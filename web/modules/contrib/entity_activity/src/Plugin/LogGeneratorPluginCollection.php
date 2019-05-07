<?php

namespace Drupal\entity_activity\Plugin;

use Drupal\Core\Plugin\DefaultLazyPluginCollection;
use Drupal\entity_activity\Plugin\LogGenerator\BrokenLogGenerator;

/**
 * A collection of entity activity log generators.
 */
class LogGeneratorPluginCollection extends DefaultLazyPluginCollection {

  /**
   * {@inheritdoc}
   */
  public function sortHelper($a_id, $b_id) {
    $a_weight = $this->get($a_id)->getWeight();
    $b_weight = $this->get($b_id)->getWeight();
    if ($a_weight == $b_weight) {
      return 0;
    }

    return ($a_weight < $b_weight) ? -1 : 1;
  }

  /**
   * {@inheritdoc}
   */
  protected function initializePlugin($instance_id) {
    parent::initializePlugin($instance_id);

    // If the initialized handler is broken preserve the original
    // handler's plugin ID.
    // @see \Drupal\webform\Plugin\WebformHandler\BrokenWebformHandler::setPluginId
    $plugin = $this->get($instance_id);
    if ($plugin instanceof BrokenLogGenerator) {
      $original_id = $this->configurations[$instance_id]['id'];
      $plugin->setPluginId($original_id);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    $configuration = parent::getConfiguration();

    // Remove configuration if not enabled.
    foreach ($configuration as $instance_id => $instance_config) {
      $instance_config['bundles'] = array_filter($instance_config['bundles']);
      $instance_config['referenced_by'] = array_filter($instance_config['referenced_by']);
      $default_config = [];
      $default_config['id'] = $instance_id;
      $default_config += $this->get($instance_id)->defaultConfiguration();
      // In order to determine if a plugin is configured, we must compare it to
      // its default configuration.
      if ($default_config === $instance_config) {
        unset($configuration[$instance_id]);
      }

    }
    return $configuration;
  }

}
