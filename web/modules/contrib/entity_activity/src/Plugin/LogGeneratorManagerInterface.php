<?php

namespace Drupal\entity_activity\Plugin;

use Drupal\Component\Plugin\Discovery\CachedDiscoveryInterface;
use Drupal\Component\Plugin\FallbackPluginManagerInterface;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Cache\CacheableDependencyInterface;

/**
 * Collects available log generators.
 */
interface LogGeneratorManagerInterface extends PluginManagerInterface, CachedDiscoveryInterface, CacheableDependencyInterface, FallbackPluginManagerInterface {

  /**
   * Remove excluded plugin definitions.
   *
   * @param array $definitions
   *   The plugin definitions to filter.
   *
   * @return array
   *   An array of plugin definitions with excluded plugins removed.
   */
  public function removeExcludeDefinitions(array $definitions);

}
