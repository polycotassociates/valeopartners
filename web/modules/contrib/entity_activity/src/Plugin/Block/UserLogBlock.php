<?php

namespace Drupal\entity_activity\Plugin\Block;

use Drupal\Component\Utility\Html;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\Entity\EntityViewMode;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Provides a 'UserLogBlock' block.
 *
 * @Block(
 *  id = "entity_activity_user_log_block",
 *  admin_label = @Translation("User log block"),
 * )
 */
class UserLogBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The \Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The log storage.
   *
   * @var \Drupal\entity_activity\LogStorageInterface
   */
  protected $logStorage;

  /**
   * The minimum number of logs to embed.
   *
   * @var int
   */
  protected $minLog = 0;

  /**
   * The maximum number of logs to embed.
   *
   * @var int
   */
  protected $maxLog = 50;

  /**
   * Constructs a new UserLogBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, AccountProxyInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
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
      $container->get('entity_type.manager'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'total_unread_label' => '',
      'number' => 10,
      'link_page' => 1,
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form['total_unread_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Total label'),
      '#description' => $this->t('You can set a label which will be displayed near of the total unread logs for the current user.'),
      '#default_value' => $this->configuration['total_unread_label'],
      '#maxlength' => 128,
      '#size' => 64,
      '#weight' => 20,
    ];

    $form['total_unread_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Class'),
      '#description' => $this->t('You can set a class which will be displayed inside a <i> tag before the total. Useful with Font icons (example: fa fa-bell-o). For multiple CSS class, separate them with a space.'),
      '#default_value' => $this->configuration['total_unread_class'],
      '#maxlength' => 128,
      '#size' => 64,
      '#weight' => 22,
    ];

    $form['real_time'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Update total real time'),
      '#default_value' => $this->configuration['real_time'],
      '#weight' => 24,
      '#access' => FALSE,
    ];

    $options = [
      '300' => $this->t('5 min'),
      '600' => $this->t('10 min'),
      '900' => $this->t('15 min'),
      '1200' => $this->t('20 min'),
      '1800' => $this->t('30 min'),
      '3600' => $this->t('60 min'),
    ];
    $form['interval'] = [
      '#type' => 'select',
      '#title' => $this->t('Interval'),
      '#description' => $this->t('Select the interval for updating the total unread logs in real time'),
      '#options' => $options,
      '#default_value' => $this->configuration['interval'],
      '#weight' => 26,
      '#states' => [
        'visible' => [
          ':input[name="settings[real_time]"]' =>
            ['checked' => TRUE],
        ],
      ],
      '#access' => FALSE,
    ];

    $form['number'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of logs'),
      '#description' => $this->t('The number of logs to embed. Maximum : 50. Set 0 to not display any unread logs.'),
      '#default_value' => $this->configuration['number'],
      '#weight' => 30,
      '#size' => 20,
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 50,
    ];

    $form['view_mode'] = [
      '#type' => 'select',
      '#title' => $this->t('View mode'),
      '#description' => $this->t('The view mode to use for rendering logs'),
      '#options' => ['default' => 'Default'] + $this->getViewModeIds(TRUE),
      '#default_value' => $this->configuration['view_mode'] ?: 'default',
      '#weight' => 32,
      '#required' => TRUE,
    ];

    $form['logs_user_page_url'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Link user log page'),
      '#description' => $this->t("Add a link to the user's log page"),
      '#default_value' => $this->configuration['logs_user_page_url'],
      '#weight' => 34,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $number = $values['number'];
    if ($number < $this->minLog || $number > $this->maxLog) {
      $form_state->setError($form['number'], $this->t('The number must be an integer between @min nd @max',
        [
          '@min' => $this->minLog,
          '@max' => $this->maxLog,
        ]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['total_unread_label'] = $form_state->getValue('total_unread_label');
    $this->configuration['total_unread_class'] = $form_state->getValue('total_unread_class');
    // $this->configuration['real_time'] = $form_state->getValue('real_time');
    // $this->configuration['interval'] = $form_state->getValue('interval');.
    $this->configuration['number'] = $form_state->getValue('number');
    $this->configuration['view_mode'] = $form_state->getValue('view_mode');
    $this->configuration['logs_user_page_url'] = $form_state->getValue('logs_user_page_url');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    if ($this->currentUser->isAnonymous()) {
      return $build;
    }
    if (!$this->currentUser->hasPermission('view own logs')
      && !$this->currentUser->hasPermission('administer log entities')) {
      return $build;
    }

    $configuration = $this->getConfiguration();
    // Some attributes.
    $wrapper_attributes = new Attribute(['class' => ['js-user-log-block', 'js-user-log-' . $this->currentUser->id()]]);
    $wrapper_attributes->setAttribute('id', 'user-log-block-' . $this->currentUser->id());
    $total_attributes = new Attribute(['class' => ['js-user-log-block-counter']]);
    $logs_attributes = new Attribute(['class' => ['js-user-logs-wrapper']]);

    // The total unread with a js class mandatory, so hardcoded here.
    $total = $this->logStorage->totalUnreadByOwner($this->currentUser);
    $total_unread = [
      '#markup' => '<span class="js-log-unread-counter">' . $total . '</span>',
    ];

    // Total label and class.
    $total_unread_label = ['#plain_text' => $configuration['total_unread_label']];
    $total_unread_class = NULL;
    if (!empty($configuration['total_unread_class'])) {
      $total_unread_class = new Attribute();
      $classes = explode(' ', $configuration['total_unread_class']);
      foreach ($classes as $class) {
        $total_unread_class->addClass(Html::cleanCssIdentifier($class));
      }
    }

    // @Todo Implements a ajax callback to retrieve the logs.
    $logs = [];
    if (!empty($configuration['number'])) {
      $view_mode = $configuration['view_mode'] ?: 'default';
      $ids = $this->getUnreadLogs($this->currentUser, $configuration['number']);
      $entities = $this->logStorage->loadMultiple($ids);
      $view_builder = $this->entityTypeManager->getViewBuilder('entity_activity_log');
      $logs = $view_builder->viewMultiple($entities, $view_mode);
    }

    // The link to the user's log page.
    $url = NULL;
    if ($configuration['logs_user_page_url']) {
      $url = Url::fromRoute('view.user_logs.page_1', ['user' => $this->currentUser->id()]);
    }

    $build = [
      '#theme' => 'user_log_block',
      '#wrapper_attributes' => $wrapper_attributes,
      '#total_attributes' => $total_attributes,
      '#logs_attributes' => $logs_attributes,
      '#total_unread' => $total_unread,
      '#total_unread_label' => $total_unread_label,
      '#total_unread_class' => $total_unread_class,
      '#has_icon' => (bool) !empty($configuration['total_unread_class']),
      '#logs' => $logs,
      '#logs_user_page_url' => $url,
    ];

    $build['#cache']['contexts'][] = 'user';
    $build['#cache']['tags'][] = 'entity_activity_log:user:' . $this->currentUser->id();
    $build['#attached']['library'][] = 'entity_activity/user_log_unread_block';
    $build['#attached']['drupalSettings']['entity_activity']['user_log_total_unread']['real_time'] = (bool) $configuration['real_time'];
    $build['#attached']['drupalSettings']['entity_activity']['user_log_total_unread']['interval'] = (int) $configuration['interval'];
    return $build;
  }

  /**
   * Get an array of view mode.
   *
   * @param bool $value_is_label
   *   Return the label as value if TRUE, otherwise the id.
   * @param string $entity_type_id
   *   The entity type id related view modes.
   *
   * @return array
   *   An array keyed by view mode id.
   */
  protected function getViewModeIds($value_is_label = TRUE, $entity_type_id = 'entity_activity_log') {
    $list = [];
    $view_modes = EntityViewMode::loadMultiple();
    /** @var \Drupal\Core\Entity\EntityViewModeInterface $view_mode */
    foreach ($view_modes as $key => $view_mode) {
      if ($view_mode->getTargetType() == $entity_type_id) {
        $parts = explode('.', $key);
        $list[$parts[1]] = $value_is_label ? $view_mode->label() : $parts[1];
      }
    }

    $removed_view_modes = [
      'diff' => 'diff',
      'rss' => 'rss',
      'search_index' => 'search_index',
      'search_result' => 'search_result',
      'token' => 'token',
    ];

    $list = array_diff_key($list, $removed_view_modes);
    return $list;
  }

  /**
   * Gets the latest X logs unread for an account.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The log's owner.
   * @param int $length
   *   The number of logs to retrieve.
   *
   * @return array
   *   An array of logs id.
   */
  protected function getUnreadLogs(AccountProxyInterface $account, $length) {
    $query = $this->logStorage->getQuery()
      ->condition('uid', $account->id())
      ->condition('read', FALSE)
      ->sort('created', 'DESC')
      ->range(0, $length);
    $ids = $query->execute();
    return $ids;
  }

}
