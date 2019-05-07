<?php

namespace Drupal\entity_activity\Plugin\LogGenerator;

use Drupal\entity_activity\Plugin\LogGeneratorBase;

/**
 * Defines a fallback plugin for missing log generators plugins.
 *
 * @LogGenerator(
 *   id = "broken",
 *   label = @Translation("Broken/Missing"),
 *   description = @Translation("Broken/missing log generator"),
 *   source_entity_type = "node",
 *   bundles = {}
 * )
 */
class BrokenLogGenerator extends LogGeneratorBase {

  /**
   * {@inheritdoc}
   */
  public function isEnabled() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getSummary() {
    $t_args = ['%plugin_id' => $this->getPluginId()];
    return [
      'message' => [
        '#markup' => $this->t('This %plugin_id log generator is broken or missing. You might need to enable the original module and/or clear the cache.', $t_args),
      ],
    ];
  }

  /**
   * Set a broken handler's plugin id.
   *
   * This allows broken log generator to preserve the original handler's
   * plugin ID.
   *
   * @param string $plugin_id
   *   The original handler's plugin ID.
   *
   * @see \Drupal\entity_activity\Plugin\LogGeneratorPluginCollection::initializePlugin
   */
  public function setPluginId($plugin_id) {
    $this->pluginId = $plugin_id;
  }

}
