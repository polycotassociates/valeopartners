<?php

namespace Drupal\entity_activity\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Log generator plugin manager.
 */
class LogGeneratorManager extends DefaultPluginManager implements LogGeneratorManagerInterface {

  /**
   * Constructs a new LogGeneratorManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/LogGenerator', $namespaces, $module_handler, 'Drupal\entity_activity\Plugin\LogGeneratorInterface', 'Drupal\entity_activity\Annotation\LogGenerator');

    $this->alterInfo('entity_activity_log_generator_info');
    $this->setCacheBackend($cache_backend, 'entity_activity_log_generator_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function removeExcludeDefinitions(array $definitions) {
    $definitions = isset($definitions) ? $definitions : $this->getDefinitions();
    // Exclude 'broken' fallback plugin.
    unset($definitions['broken']);
    return $definitions;
  }

  /**
   * {@inheritdoc}
   */
  public function getFallbackPluginId($plugin_id, array $configuration = []) {
    return 'broken';
  }

}
