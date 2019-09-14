<?php

namespace Drupal\entity_activity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;
use Drupal\entity_activity\Plugin\LogGeneratorPluginCollection;

/**
 * Defines the Generator entity.
 *
 * @ConfigEntityType(
 *   id = "entity_activity_generator",
 *   label = @Translation("Generator"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_activity\GeneratorListBuilder",
 *     "form" = {
 *       "add" = "Drupal\entity_activity\Form\GeneratorForm",
 *       "edit" = "Drupal\entity_activity\Form\GeneratorForm",
 *       "delete" = "Drupal\entity_activity\Form\GeneratorDeleteForm",
 *       "enable" = "Drupal\entity_activity\Form\GeneratorEnableForm",
 *       "disable" = "Drupal\entity_activity\Form\GeneratorDisableForm",
 *       "duplicate" = "Drupal\entity_activity\Form\GeneratorDuplicateForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\entity_activity\GeneratorHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "generator",
 *   admin_permission = "administer log generators",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "status" = "status"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/content/entity-activity/generators/{entity_activity_generator}",
 *     "add-form" = "/admin/config/content/entity-activity/generators/add",
 *     "edit-form" = "/admin/config/content/entity-activity/generators/{entity_activity_generator}/edit",
 *     "delete-form" = "/admin/config/content/entity-activity/generators/{entity_activity_generator}/delete",
 *     "enable" = "/admin/config/content/entity-activity/generators/{entity_activity_generator}/enable",
 *     "disable" = "/admin/config/content/entity-activity/generators/{entity_activity_generator}/disable",
 *     "duplicate" = "/admin/config/content/entity-activity/generators/{entity_activity_generator}/duplicate",
 *     "collection" = "/admin/config/content/entity-activity/generators"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *     "status",
 *     "langcode",
 *     "generators",
 *   }
 * )
 */
class Generator extends ConfigEntityBase implements GeneratorInterface, EntityWithPluginCollectionInterface {

  /**
   * The Generator ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Generator label.
   *
   * @var string
   */
  protected $label;

  /**
   * The log generators plugin configurations.
   *
   * @var array
   */
  protected $generators = [];

  /**
   * The log generators collection.
   *
   * @var \Drupal\entity_activity\Plugin\LogGeneratorPluginCollection
   */
  protected $logGeneratorsCollection;

  /**
   * The log generator plugin manager.
   *
   * @var \Drupal\entity_activity\Plugin\LogGeneratorManager
   */
  protected $logGeneratorManager;

  /**
   * {@inheritdoc}
   */
  public function getPluginCollections() {
    return ['generators' => $this->getLogGeneratorsCollection()];
  }

  /**
   * {@inheritdoc}
   */
  public function getLogGenerators() {
    return $this->getLogGeneratorsCollection()->getConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function setLogGeneratorsConfig($instance_id, array $configuration) {
    $log_generators = $this->getLogGeneratorsCollection();
    if (!$log_generators->has($instance_id)) {
      $configuration['id'] = $instance_id;
      $log_generators->addInstanceId($instance_id, $configuration);
    }
    else {
      $log_generators->setInstanceConfiguration($instance_id, $configuration);
    }
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getLogGeneratorsCollection() {
    if (!isset($this->logGeneratorsCollection)) {
      $this->logGeneratorsCollection = new LogGeneratorPluginCollection($this->logGeneratorPluginManager(), $this->get('generators'));
    }
    return $this->logGeneratorsCollection;
  }

  /**
   * {@inheritdoc}
   */
  public function setLogGeneratorsCollection(LogGeneratorPluginCollection $log_generators) {
    $this->logGeneratorsCollection = $log_generators;
  }

  /**
   * {@inheritdoc}
   */
  public function getLogGeneratorsInstance($instance_id) {
    return $this->getLogGeneratorsCollection()->get($instance_id);
  }

  /**
   * Gets the log generator plugin manager.
   *
   * @return \Drupal\Core\Executable\ExecutableManagerInterface
   *   The log generator plugin manager.
   */
  protected function logGeneratorPluginManager() {
    if (!isset($this->logGeneratorManager)) {
      $this->logGeneratorManager = \Drupal::service('plugin.manager.log_generator');
    }
    return $this->logGeneratorManager;
  }

}
