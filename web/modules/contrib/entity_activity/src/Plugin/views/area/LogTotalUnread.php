<?php

namespace Drupal\entity_activity\Plugin\views\area;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\UserInterface;
use Drupal\views\Plugin\views\area\AreaPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Gets the total unread logs entities for a user.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("log_total_unread")
 */
class LogTotalUnread extends AreaPluginBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The Log storage.
   *
   * @var \Drupal\entity_activity\LogStorageInterface
   */
  protected $logStorage;

  /**
   * Constructs a new Log Total Unread instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->logStorage = $this->entityTypeManager->getStorage('entity_activity_log');
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
    $options['content'] = ['default' => '@total_unread logs unread.'];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $form['content'] = [
      '#title' => $this->t('Content'),
      '#type' => 'textarea',
      '#default_value' => $this->options['content'],
      '#rows' => 6,
      '#description' => $this->t('Use the token @total_unread to display the total unread logs for the user set as argument in the view.'),
    ];
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
      $total_unread = $this->logStorage->totalUnreadByOwner($user);
      $build = [
        '#markup' => $this->renderTextarea($this->options['content'], $total_unread),
        '#prefix' => '<div class="log-total-unread-wrapper">',
        '#suffix' => '</div>',
      ];
    }

    return $build;
  }

  /**
   * Render a text area with \Drupal\Component\Utility\Xss::filterAdmin().
   */
  public function renderTextarea($value, $total_unread) {
    if ($value) {
      $total_unread = '<span class="js-log-unread-counter">' . $total_unread . '</span>';
      $content = str_replace('@total_unread', $total_unread, $value);
      return $this->sanitizeValue($content, 'xss_admin');
    }
  }

}
