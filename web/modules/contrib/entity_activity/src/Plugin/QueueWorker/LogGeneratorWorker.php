<?php

namespace Drupal\entity_activity\Plugin\QueueWorker;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\entity_activity\Plugin\LogGeneratorInterface;
use Drupal\entity_activity\Plugin\LogGeneratorManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Create logs on CRON run.
 *
 * @QueueWorker(
 *   id = "entity_activity_log_generator_worker",
 *   title = @Translation("Log generator worker"),
 *   cron = {"time" = 30}
 * )
 */
class LogGeneratorWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * The log generator manager.
   *
   * @var \Drupal\entity_activity\Plugin\LogGeneratorManagerInterface
   */
  protected $logManager;

  /**
   * Construct the worker.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\entity_activity\Plugin\LogGeneratorManagerInterface $log_manager
   *   The log generator manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LogGeneratorManagerInterface $log_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->logManager = $log_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.log_generator')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $plugin_id = $data['plugin_id'];
    $configuration = $data['configuration'];
    $settings = $data['settings'];

    try {
      $log_generator = $this->logManager->createInstance($plugin_id, $configuration);
    }
    catch (\Exception $e) {
      $log_generator = NULL;
    }

    if ($log_generator instanceof LogGeneratorInterface) {
      $log_generator->generateLog($settings);
    }

  }

}
