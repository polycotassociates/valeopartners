<?php

namespace Drupal\entity_activity\Form;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\entity_activity\EntityActivityManagerInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  use StringTranslationTrait;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Entity\EntityTypeBundleInfoInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  protected $entityTypeBundleInfo;

  /**
   * Drupal\entity_activity\EntityActivityManagerInterface definition.
   *
   * @var \Drupal\entity_activity\EntityActivityManagerInterface
   */
  protected $entityActivityManager;

  /**
   * Drupal\Core\Language\LanguageManagerInterface definition.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * An array of supported content entity type.
   *
   * @var array
   */
  protected $supportedContentEntityTypes;

  /**
   * SettingsForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle info.
   * @param \Drupal\entity_activity\EntityActivityManagerInterface $entity_activity_manager
   *   The entity activity manager.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, EntityTypeBundleInfoInterface $entity_type_bundle_info, EntityActivityManagerInterface $entity_activity_manager, LanguageManagerInterface $language_manager) {
    parent::__construct($config_factory);
    $this->entityTypeManager = $entity_type_manager;
    $this->entityTypeBundleInfo = $entity_type_bundle_info;
    $this->entityActivityManager = $entity_activity_manager;
    $this->languageManager = $language_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager'),
      $container->get('entity_type.bundle.info'),
      $container->get('entity_activity.manager'),
      $container->get('language_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'entity_activity.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'entity_activity_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('entity_activity.settings');

    $form['entity_type'] = [
      '#type' => 'fieldset',
      "#title" => $this->t('Entity types'),
      '#description' => $this->t('Enable the entity types on which you want allow users to subscribe on.'),
      '#tree' => TRUE,
    ];

    $entity_types = $this->entityActivityManager->getSupportedContentEntityTypes(TRUE);
    // We do not use here a checkboxes to be able later to
    // enable / disable per bundle too.
    /** @var \Drupal\Core\Entity\ContentEntityTypeInterface $entity_type */
    foreach ($entity_types as $entity_type_id => $entity_type) {
      $form['entity_type'][$entity_type_id]['enable'] = [
        '#type' => 'checkbox',
        '#title' => $entity_type->getLabel(),
        '#default_value' => $config->get('entity_type.' . $entity_type_id . '.enable'),
      ];
    }

    $form['purge'] = [
      '#type' => 'fieldset',
      "#title" => $this->t('Log purge settings'),
      '#tree' => TRUE,
    ];
    $methods = [
      '' => $this->t('None'),
      'time' => $this->t('Time'),
      'limit' => $this->t('Limit per user'),
    ];
    $form['purge']['method'] = [
      '#type' => 'select',
      '#title' => $this->t('Purge method'),
      '#options' => $methods,
      '#default_value' => $config->get('purge.method'),
    ];
    $form['purge']['read_only'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Purge only logs read'),
      '#default_value' => $config->get('purge.read_only'),
      '#states' => [
        'visible' => [
          ':input[name="purge[method]"]' =>
            ['value' => 'time'],
        ],
      ],
    ];
    $form['purge']['time'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['interval'],
      ],
      '#states' => [
        'visible' => [
          ':input[name="purge[method]"]' =>
            ['value' => 'time'],
        ],
      ],
      '#open' => TRUE,
    ];
    $form['purge']['time']['number'] = [
      '#type' => 'number',
      '#title' => $this->t('Interval'),
      '#default_value' => $config->get('purge.time.number'),
      '#min' => 1,
    ];

    $form['purge']['time']['unit'] = [
      '#type' => 'select',
      '#title' => $this->t('Unit'),
      '#title_display' => 'invisible',
      '#default_value' => $config->get('purge.time.unit') ?: 'day',
      '#options' => [
        'day' => $this->t('Day'),
        'month' => $this->t('Month'),
        'year' => $this->t('Year'),
      ],
    ];

    $form['purge']['limit'] = [
      '#type' => 'container',
      '#states' => [
        'visible' => [
          ':input[name="purge[method]"]' =>
            ['value' => 'limit'],
        ],
      ],
      '#open' => TRUE,
    ];
    $form['purge']['limit']['max'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximum'),
      '#default_value' => $config->get('purge.limit.max'),
      '#description' => $this->t('Set the maximum number of logs per user. Due to the fact that this method can be detrimental in terms of performance, purging is only carried out once a day. You can modify this behavior by adding in the settings.php file of the project the parameter $settings[\'entity_activity_purge_user_always\'] = TRUE;'),
      '#min' => 1,
    ];

    $form['language'] = [
      '#type' => 'fieldset',
      "#title" => $this->t('Language'),
      '#tree' => TRUE,
      '#access' => $this->languageManager->isMultilingual(),
    ];
    $form['language']['user'] = [
      '#type' => 'checkbox',
      '#title' => $this->t("Use the user's preferred language"),
      '#description' => $this->t("Check this option to always use the user's preferred language when generating log message.<br /><b>Warning</b>. <em>This option is costly in performance because each log message must be regenerated for each owner of a subscription. Use it only if you <b>really</b> need log messages to be generated in the user's preferred language.</em>"),
      '#default_value' => $config->get('language.user'),
    ];

    $form['#attached']['library'][] = 'entity_activity/settings';

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $values = $form_state->getValues();
    if ($values['purge']['method'] == 'time') {
      if (empty($values['purge']['time']['number']) || empty($values['purge']['time']['unit'])) {
        $form_state->setError($form['purge']['time']['number'], $this->t('Interval settings are mandatory.'));
      }
    }
    if ($values['purge']['method'] == 'limit') {
      if (empty($values['purge']['limit']['max'])) {
        $form_state->setError($form['purge']['limit']['max'], $this->t('The maximum of logs to kept is mandatory.'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $values = $form_state->getValues();
    $this->config('entity_activity.settings')
      ->set('entity_type', $values['entity_type'])
      ->set('purge', $values['purge'])
      ->set('language', $values['language'])
      ->save();
  }

}
