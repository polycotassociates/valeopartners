<?php

namespace Drupal\entity_activity\Plugin\views\area;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;
use Drupal\user\UserInterface;
use Drupal\views\Plugin\views\area\AreaPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a button to mark all logs entities as read.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("log_read_all")
 */
class LogReadAll extends AreaPluginBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new Log Read All instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    $build = [];
    $base_entity_type = $this->view->getBaseEntityType();
    if (!$base_entity_type instanceof ContentEntityTypeInterface) {
      return $build;
    }

    if ($base_entity_type->id() != 'entity_activity_log') {
      return $build;
    }

    // Display the button only on views with a %user argument.
    $user = NULL;
    $arguments = $this->view->argument;
    /** @var \Drupal\views\Plugin\views\argument\ArgumentPluginBase $argument */
    foreach ($arguments as $plugin_id => $argument) {
      $real_Field = $argument->realField;
      $entity_type = $argument->getEntityType();
      if ($real_Field === 'uid' && $entity_type === 'entity_activity_log') {
        $uid = $argument->getValue();
        if ($uid) {
          $user = $this->entityTypeManager->getStorage('user')->load($uid);
        }
        break;
      }
    }

    if (!$user instanceof UserInterface) {
      return $build;
    }

    if (!$empty || !empty($this->options['empty'])) {
      $admin_permission = $base_entity_type->getAdminPermission();
      if ($this->view->getUser()->hasPermission($admin_permission)
        || ($this->view->getUser()->id() == $user->id())) {
        $attributes = new Attribute(['class' => ['js-log-read-all']]);
        $attributes->setAttribute('data-entity-id', $user->id());
        $attributes->setAttribute('type', 'button');
        $attributes->setAttribute('id', 'log-read-all-user-' . $user->id());
        $wrapper_attributes = new Attribute(['class' => ['js-log-read-all-wrapper']]);
        $build = [
          '#theme' => 'log_read_all',
          '#attributes' => $attributes,
          '#wrapper_attributes' => $wrapper_attributes,
        ];
        $build['#attached']['library'][] = 'entity_activity/log_read_all';
      }
    }

    return $build;
  }

}
