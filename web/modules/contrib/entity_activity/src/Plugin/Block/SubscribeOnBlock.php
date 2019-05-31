<?php

namespace Drupal\entity_activity\Plugin\Block;

use Drupal\Component\Utility\Html;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Template\Attribute;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\entity_activity\EntityActivityManagerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Provides a 'SubscribeOnBlock' block.
 *
 * @Block(
 *  id = "subscribe_on_block",
 *  admin_label = @Translation("Subscribe on block"),
 * )
 */
class SubscribeOnBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\entity_activity\EntityActivityManagerInterface definition.
   *
   * @var \Drupal\entity_activity\EntityActivityManagerInterface
   */
  protected $entityActivityManager;

  /**
   * Drupal\Core\Routing\CurrentRouteMatch definition.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\Core\Language\LanguageManagerInterface definition.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;


  /**
   * Constructs a new SubscribeOnBlock object.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param $plugin_id
   *   The plugin id.
   * @param $plugin_definition
   *   The plugin definition.
   * @param \Drupal\entity_activity\EntityActivityManagerInterface $entity_activity_manager
   *   The entity activity manager.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $current_route_match
   *   The current route match.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory..
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityActivityManagerInterface $entity_activity_manager, CurrentRouteMatch $current_route_match, AccountProxyInterface $current_user, ConfigFactoryInterface $config_factory, LanguageManagerInterface $language_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityActivityManager = $entity_activity_manager;
    $this->currentRouteMatch = $current_route_match;
    $this->currentUser = $current_user;
    $this->configFactory = $config_factory;
    $this->languageManager = $language_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_activity.manager'),
      $container->get('current_route_match'),
      $container->get('current_user'),
      $container->get('config.factory'),
      $container->get('language_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['warning'] = [
      '#type' => 'markup',
      '#markup' => $this->t('Warning. This block can only expose a <em>Subscribe on</em> button for entities canonical page, i.e. when the entity is rendered on its own canonical page. Do not expose this block if you are using the extra field <em><b>Subscribe on</b></em>.'),
      '#prefix' => '<div class="messages messages--warning">',
      '#suffix' => '</div>',
      '#weight' => 90,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $cache_tags = $this->configFactory->get('entity_activity.settings')->getCacheTags();
    $build = [];
    $build['#cache']['contexts'][] = 'url';
    $build['#cache']['tags'] = $cache_tags;

    $keys = $this->currentRouteMatch->getParameters()->keys();
    $entity_type_id = isset($keys[0]) ? $keys[0] : '';
    if (empty($entity_type_id)) {
      return $build;
    }

    $entity = $this->currentRouteMatch->getParameter($entity_type_id);
    if (!$entity instanceof ContentEntityInterface) {
      return $build;
    }

    $entity_types_enabled = $this->entityActivityManager->getContentEntityTypesEnabled();
    $can_subscribe_all = $this->currentUser->hasPermission('subscribe all entities');

    if (in_array($entity->getEntityTypeId(), $entity_types_enabled)) {
      $entity_type_id = $entity->getEntityTypeId();
      $id = $entity->id();
      $entity_type_id_clean = Html::cleanCssIdentifier($entity_type_id);
      if ($entity->isTranslatable()) {
        $langcode = $entity->language()->getId();
      }
      else {
        $langcode = $this->languageManager->getDefaultLanguage()->getId();
      }

      $attributes = new Attribute([
        'class' => [
          'js-subscribe-on',
          'subscribe-on'
        ]
      ]);
      $attributes->setAttribute('id', 'subscribe-on-' . $entity_type_id_clean . '-' . $id);
      $attributes->setAttribute('data-entity-type', $entity_type_id);
      $attributes->setAttribute('data-entity-id', $id);
      $attributes->setAttribute('data-langcode', $langcode);

      $build['subscribe_on'] = [
        '#theme' => 'subscribe_on',
        '#attributes' => $attributes,
        '#entity' => $entity,
        '#view_mode' => 'full',
        '#attached' => [
          'library' => [
            'entity_activity/subscribe_on',
          ],
        ],
        '#access' => $can_subscribe_all,
      ];
    }

    return $build;
  }

}
