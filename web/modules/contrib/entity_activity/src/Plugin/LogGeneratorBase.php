<?php

namespace Drupal\entity_activity\Plugin;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\DependencyTrait;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\SubformStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Utility\Token;
use Drupal\entity_activity\Entity\GeneratorInterface;
use Drupal\entity_activity\EntityActivityManagerInterface;
use Drupal\token\TokenEntityMapperInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Base class for Log generator plugins.
 */
abstract class LogGeneratorBase extends PluginBase implements LogGeneratorInterface, ContainerFactoryPluginInterface {

  use DependencyTrait;
  use StringTranslationTrait;
  use DependencySerializationTrait;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Datetime\DateFormatterInterface definition.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Drupal\Core\Utility\Token definition.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * Drupal\Core\Extension\ModuleHandlerInterface definition.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Drupal\Core\Entity\EntityRepositoryInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityRepositoryInterface
   */
  protected $entityRepository;

  /**
   * Drupal\Core\Entity\EntityFieldManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * The token entity mapper service.
   *
   * @var \Drupal\token\TokenEntityMapperInterface
   */
  protected $tokenEntityMapper;

  /**
   * The entity type bundle info service.
   *
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  protected $entityTypeBundleInfo;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The language manager service.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * The serializer service.
   *
   * @var \Symfony\Component\Serializer\SerializerInterface
   */
  protected $serializer;

  /**
   * The global entity activity manager.
   *
   * @var \Drupal\entity_activity\EntityActivityManagerInterface
   */
  protected $entityActivityManager;

  /**
   * An array of entity type id supported by entity activity.
   *
   * @var array
   */
  protected $supportedContentEntityType;

  /**
   * The subscription storage.
   *
   * @var \Drupal\entity_activity\SubscriptionStorageInterface
   */
  protected $subscriptionStorage;

  /**
   * The log storage.
   *
   * @var \Drupal\entity_activity\LogStorageInterface
   */
  protected $logStorage;

  /**
   * The taxonomy term storage.
   *
   * @var \Drupal\taxonomy\TermStorageInterface
   */
  protected $termStorage;

  /**
   * LogGeneratorBase constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter.
   * @param \Drupal\Core\Utility\Token $token
   *   The token service.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   *   The entity repository.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager.
   * @param \Drupal\Token\TokenEntityMapperInterface $token_entity_mapper
   *   The token entity mapper.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle info service.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   * @param \Symfony\Component\Serializer\SerializerInterface $serializer
   *   The serializer service.
   * @param \Drupal\entity_activity\EntityActivityManagerInterface $entity_activity_manager
   *   The global entity activity manager.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, DateFormatterInterface $date_formatter, Token $token, ModuleHandlerInterface $module_handler, EntityRepositoryInterface $entity_repository, EntityFieldManagerInterface $entity_field_manager, TokenEntityMapperInterface $token_entity_mapper, EntityTypeBundleInfoInterface $entity_type_bundle_info, AccountProxyInterface $current_user, LanguageManagerInterface $language_manager, ConfigFactoryInterface $config_factory, TimeInterface $time, SerializerInterface $serializer, EntityActivityManagerInterface $entity_activity_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->dateFormatter = $date_formatter;
    $this->token = $token;
    $this->moduleHandler = $module_handler;
    $this->entityRepository = $entity_repository;
    $this->entityFieldManager = $entity_field_manager;
    $this->tokenEntityMapper = $token_entity_mapper;
    $this->entityTypeBundleInfo = $entity_type_bundle_info;
    $this->currentUser = $current_user;
    $this->languageManager = $language_manager;
    $this->configFactory = $config_factory;
    $this->time = $time;
    $this->serializer = $serializer;
    $this->entityActivityManager = $entity_activity_manager;
    $this->subscriptionStorage = $this->entityTypeManager->getStorage('entity_activity_subscription');
    $this->logStorage = $this->entityTypeManager->getStorage('entity_activity_log');
    $this->termStorage = $this->entityTypeManager->getStorage('taxonomy_term');
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
      $container->get('date.formatter'),
      $container->get('token'),
      $container->get('module_handler'),
      $container->get('entity.repository'),
      $container->get('entity_field.manager'),
      $container->get('token.entity_mapper'),
      $container->get('entity_type.bundle.info'),
      $container->get('current_user'),
      $container->get('language_manager'),
      $container->get('config.factory'),
      $container->get('datetime.time'),
      $container->get('serializer'),
      $container->get('entity_activity.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();
    $default_bundles = $this->getDefaultBundles(TRUE);
    $bundles = array_keys($default_bundles);

    if (!empty($config['bundles'])) {
      $bundles = array_filter($config['bundles']);
    }
    $entity_reference_fields = $this->getEntityReferenceFieldsOnMultipleBundles($this->getSourceEntityType(), $bundles);

    $build['status'] = [
      '#title' => $this->t('Enable'),
      '#type' => 'checkbox',
      '#default_value' => $config['status'],
      '#description' => $this->t('Enable the generator.'),
    ];

    $build['published'] = [
      '#title' => $this->t('Published'),
      '#type' => 'checkbox',
      '#default_value' => $config['published'],
      '#description' => $this->t('Generate the log only if the entity is published.'),
    ];

    $build['operation'] = [
      '#title' => $this->t('Operation'),
      '#type' => 'select',
      '#options' => $this->getOperations(),
      '#default_value' => $config['operation'],
      '#description' => $this->t('Select an operation from which a log will be generated.'),
      '#required' => TRUE,
    ];

    $build['bundles'] = [
      '#title' => $this->t('Bundles'),
      '#type' => 'checkboxes',
      '#options' => $this->getDefaultBundles(TRUE),
      '#default_value' => $config['bundles'],
      '#description' => $this->t('Select the bundles on which apply the generator. Leave empty to apply on all bundles.'),
    ];

    $options = [
      'source_entity_type' => $this->t('Current entity'),
    ];
    if (!empty($entity_reference_fields)) {
      $options['reference'] = $this->t('Entity referenced');
    }

    $build['subscribed_on'] = [
      '#title' => $this->t('Subscribed on'),
      '#type' => 'select',
      '#options' => $options,
      '#default_value' => $config['subscribed_on'],
      '#description' => $this->t('Choose from which entity fetch subscriptions and generate logs for subscribers.'),
      '#required' => TRUE,
    ];

    // @TODO update this element by Ajax when bundles are updated.
    $build['referenced_by'] = [
      '#title' => $this->t('Entity referenced by'),
      '#type' => 'checkboxes',
      '#options' => $entity_reference_fields,
      '#default_value' => $config['referenced_by'],
      '#description' => $this->t('Select the fields referencing the entities on which you want get the subscriptions.'),
      '#states' => [
        'visible' => [
          ':input[name="generators[' . $this->pluginId . '][subscribed_on]"]' => ['value' => 'reference'],
        ],
        'required' => [
          ':input[name="generators[' . $this->pluginId . '][subscribed_on]"]' => ['value' => 'reference'],
        ],
      ],
    ];

    $build['include_parents_term'] = [
      '#title' => $this->t('Include parents term'),
      '#type' => 'checkbox',
      '#default_value' => $config['include_parents_term'],
      '#description' => $this->t('Include parents term if the entity subscribed on (or referenced) is a taxonomy term.'),
    ];

    $build['log'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Log message'),
      '#description' => $this->t('Enter the text to use to generate the log. You can use token related to the entity.'),
      '#default_value' => $config['log']['value'],
      '#format' => $config['log']['format'],
    ];

    $build['use_cron'] = [
      '#title' => $this->t('Use cron'),
      '#type' => 'checkbox',
      '#default_value' => $config['use_cron'],
      '#description' => $this->t('Check this option to use cron to generate the logs. Otherwise logs will be generate immediately.'),
    ];

    // Show the token help relevant to this log generator.
    $build['token_help'] = [
      '#theme' => 'token_tree_link',
      '#token_types' => $this->getTokenTypes(),
    ];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array $form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    if ($values['subscribed_on'] == 'reference') {
      $referenced_by = array_filter($values['referenced_by']);
      if (empty($referenced_by)) {
        $form_state->setError($form['referenced_by'], $this->t('You must select at least one field name referencing the source entity. Please select an option for the setting <b>Entity referenced by</b>'));
      }
    }

    if (empty(trim($values['log']['value'])) && $this->isEnabled()) {
      $form_state->setError($form['log'], $this->t('The <b>log message</b> can not be an empty string.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array $form, FormStateInterface $form_state) {
    if (!($form_state instanceof SubformStateInterface)) {
      $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
      trigger_error(sprintf('%s::%s() SHOULD receive %s on line %d, but %s was given. More information is available at https://www.drupal.org/node/2774077.', $trace[1]['class'], $trace[1]['function'], SubformStateInterface::class, $trace[1]['line'], get_class($form_state)), E_USER_DEPRECATED);
    }
    $this->setConfiguration($form_state->getValues());
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    $plugin_definition = $this->getPluginDefinition();
    return isset($plugin_definition['description']) ? $plugin_definition['description'] : '';
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    $plugin_definition = $this->getPluginDefinition();
    return isset($plugin_definition['label']) ? $plugin_definition['label'] : '';
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    $summary = NULL;
    $configuration = $this->getConfiguration();
    $bundles = array_filter($configuration['bundles']);
    $bundles = !empty($bundles) ? implode(', ', $bundles) : $this->t('All');
    $subscribed_on = $this->t('Source entity');
    if ($configuration['subscribed_on'] == 'reference') {
      $subscribed_on = $this->t('Entity referenced by field @field_name', ['@field_name' => implode(', ', array_filter($configuration['referenced_by']))]);
    }
    if (!empty($this->configuration['status'])) {
      $summary = $this->t('The Log generator <em><b>@label</b></em> is enabled with the following settings : <br /><b>Operation</b>: @operation<br /><b>Bundles</b>: @bundles<br /><b>Subscription on</b>: @subscribed_on<br /><b>Include parents term</b>: @include_parents_term<br /><b>Log</b>: @log<br /><b>Use cron</b>: @use_cron',
        [
          '@label' => $this->getLabel(),
          '@operation' => $configuration['operation'],
          '@bundles' => $bundles,
          '@subscribed_on' => $subscribed_on,
          '@include_parents_term' => $configuration['include_parents_term'] ? $this->t('Yes') : $this->t('No'),
          '@log' => $configuration['log']['value'],
          '@use_cron' => $configuration['use_cron'] ? $this->t('Yes') : $this->t('No'),
        ]);
    }
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceEntityType() {
    $plugin_definition = $this->getPluginDefinition();
    return isset($plugin_definition['source_entity_type']) ? $plugin_definition['source_entity_type'] : '';
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultBundles($with_label = FALSE) {
    $bundles = [];
    $entity_type_bundles = $this->entityTypeBundleInfo->getBundleInfo($this->getSourceEntityType());
    $plugin_definition = $this->getPluginDefinition();

    if (!empty($plugin_definition['bundles'])) {
      $bundles = $plugin_definition['bundles'];
    }
    else {
      foreach ($entity_type_bundles as $name => $value) {
        $bundles[] = $name;
      }
    }

    foreach ($bundles as $key => $name) {
      if (!isset($entity_type_bundles[$name])) {
        unset($bundles[$key]);
      }
    }

    if ($with_label) {
      $bundle_names = $bundles;
      $bundles = [];
      foreach ($bundle_names as $key => $name) {
        $bundles[$name] = $entity_type_bundles[$name]['label'];
      }
    }

    return $bundles;
  }

  /**
   * {@inheritdoc}
   */
  public function getBundles() {
    $bundles = array_filter($this->getConfiguration()['bundles']);
    return $bundles;
  }

  /**
   * {@inheritdoc}
   */
  public function getOperation() {
    return $this->getConfiguration()['operation'];
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'status' => 0,
      'published' => 1,
      'operation' => 'insert',
      'bundles' => $this->getPluginDefinition()['bundles'],
      'subscribed_on' => 'source_entity_type',
      'referenced_by' => [],
      'include_parents_term' => 0,
      'log' => [
        'value' => '',
        'format' => 'plain_text',
      ],
      'use_cron' => 1,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getReferencedByFields() {
    $configuration = $this->getConfiguration();
    return array_filter($configuration['referenced_by']);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    $merged_array = NestedArray::mergeDeepArray([$this->defaultConfiguration(), $this->configuration], TRUE);
    return ['id' => $this->getPluginId()] + $merged_array;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration) {
    $this->configuration = $configuration + $this->defaultConfiguration();
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function calculateDependencies() {
    // @TODO Add dependencies on the source entity type.
    // And the field names if selected.
    $this->addDependency('module', $this->getPluginDefinition()['provider']);
    return $this->dependencies;
  }

  /**
   * {@inheritdoc}
   */
  public function useCron() {
    return (bool) $this->configuration['use_cron'];
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled() {
    return (bool) $this->configuration['status'];
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->configuration['published'];
  }

  /**
   * {@inheritdoc}
   */
  public function getTokenTypes() {
    $entity_type = $this->getSourceEntityType();
    $token_type = $this->tokenEntityMapper->getTokenTypeForEntityType($entity_type);
    return [$token_type];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityReferenceFields($entity_type, $bundle) {
    $options = [];
    $fields = $this->entityFieldManager->getFieldDefinitions($entity_type, $bundle);
    $supported_entity_types = $this->getSupportedEntityTypes();
    foreach ($fields as $field_name => $field_definition) {
      if ($field_definition->getType() == 'entity_reference') {
        $settings = $field_definition->getFieldStorageDefinition()->getSettings();
        if (isset($settings['target_type']) && in_array($settings['target_type'], $supported_entity_types)) {
          $options[$field_name] = $field_definition->getLabel();
        }
      }
    }
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityReferenceFieldsOnMultipleBundles($entity_type, array $bundles = []) {
    $fields = [];
    if (empty($bundles)) {
      $bundles = $this->getDefaultBundles();
    }
    foreach ($bundles as $bundle) {
      $fields = $fields + $this->getEntityReferenceFields($entity_type, $bundle);
    }
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntitiesSubscribedOn(ContentEntityInterface $entity) {
    $ids = [];
    $subscribed_on = $this->getConfiguration()['subscribed_on'];
    $include_parents_term = $this->getConfiguration()['include_parents_term'];
    if ($subscribed_on == 'source_entity_type') {
      $ids[$entity->getEntityTypeId()][] = $entity->id();
      if ($include_parents_term && $entity->getEntityTypeId() == 'taxonomy_term') {
        $this->addParentsTerm($ids[$entity->getEntityTypeId()], $entity->id());
      }
    }
    elseif ($subscribed_on == 'reference') {
      $fields = $this->getReferencedByFields();
      foreach ($fields as $field_name) {
        if ($entity->hasField($field_name) && !$entity->get($field_name)->isEmpty()) {
          $referenced_entities = $entity->get($field_name)->referencedEntities();
          foreach ($referenced_entities as $referenced_entity) {
            if (!$referenced_entity instanceof ContentEntityInterface) {
              continue;
            }
            $ids[$referenced_entity->getEntityTypeId()][] = $referenced_entity->id();
            if ($include_parents_term && $referenced_entity->getEntityTypeId() == 'taxonomy_term') {
              $this->addParentsTerm($ids[$referenced_entity->getEntityTypeId()], $referenced_entity->id());
            }
          }
        }
      }
    }
    return $ids;
  }

  /**
   * Add parents term to an array.
   *
   * @param array $ids
   *   An array of ids.
   * @param int $tid
   *   The term id for which we add parents to $ids.
   */
  protected function addParentsTerm(array &$ids, $tid) {
    $parents = $this->termStorage->loadAllParents($tid);
    foreach ($parents as $tid => $term) {
      if (!in_array($tid, $ids)) {
        $ids[] = $tid;
      }
    }
  }

  /**
   * Gets the operations available.
   *
   * @TODO make this dependent of the entity type (ex. register for user).
   *
   * @return array
   *   An array of operations the module tracks.
   */
  protected function getOperations() {
    $operations = [
      'insert' => $this->t('Insert'),
      'update' => $this->t('Update'),
      'delete' => $this->t('Delete'),
    ];
    return $operations;
  }

  /**
   * Gets the content entity type supported.
   *
   * @return array
   *   An array of entity type id supported.
   */
  protected function getSupportedEntityTypes() {
    if (!$this->supportedContentEntityType) {
      $this->supportedContentEntityType = $this->entityActivityManager->getSupportedContentEntityTypes();
    }
    return $this->supportedContentEntityType;
  }

  /**
   * Get the class name of the entity to use it with the serializer service.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The content entity.
   *
   * @return string
   *   The class name, ready to be used with the serializer service for the
   *   deserialize() method which expect for example for Node the string class :
   *   'Drupal\node\Entity\Node'
   */
  protected function getClassName(ContentEntityInterface $entity) {
    $class = $entity->getEntityType()->getClass();
    return $class;
  }

  /**
   * {@inheritdoc}
   */
  public function preGenerateLog(ContentEntityInterface $entity, $generator_id, AccountProxyInterface $current_user = NULL) {
    $settings = [];
    $settings['bundle'] = $entity->bundle();
    // We assume that entities which are not an instance of
    // EntityPublishedInterface are always published.
    if ($entity instanceof EntityPublishedInterface) {
      $source_published = (bool) $entity->isPublished();
    }
    else {
      $source_published = TRUE;
    }

    if ($entity->isTranslatable()) {
      $langcode = $entity->language()->getId();
    }
    else {
      $langcode = $this->languageManager->getDefaultLanguage()->getId();
    }
    $settings['langcode'] = $langcode;
    $settings['source_published'] = $source_published;
    $settings['source_entity_id'] = $entity->id();
    $settings['source_entity_type'] = $entity->getEntityTypeId();
    $settings['log_message'] = $this->getFinalLog($entity);
    $settings['entities_subscribed'] = $this->getEntitiesSubscribedOn($entity);
    $settings['current_user_id'] = $current_user ? $current_user->id() : $this->currentUser->id();
    $settings['generator_id'] = $generator_id;
    $settings['current_date'] = $this->time->getRequestTime();
    $settings['source_entity_serialized'] = $this->serializer->serialize($entity, 'json');
    $settings['source_entity_class'] = $this->getClassName($entity);
    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function generateLog(array $settings) {
    $count = 0;
    $bundle = $settings['bundle'];
    $source_published = (bool) $settings['source_published'];
    $source_entity_id = $settings['source_entity_id'];
    $source_entity_type = $settings['source_entity_type'];
    $log_message = $settings['log_message'];
    $entities_subscribed = $settings['entities_subscribed'];
    $current_user_id = $settings['current_user_id'];
    $langcode = $settings['langcode'];
    $generator_id = $settings['generator_id'];
    $current_date = $settings['current_date'];
    $source_entity_serialized = $settings['source_entity_serialized'];
    $source_entity_class = $settings['source_entity_class'];

    // The log generator could have been disabled after an item has been added
    // to the queue if using cron.
    if (!$this->isEnabled()) {
      return $count;
    }

    if (!empty($this->getBundles()) && !in_array($bundle, $this->getBundles())) {
      return $count;
    }

    if (!$source_published && $this->isPublished()) {
      return $count;
    }

    $use_user_preferred_language = $this->configFactory->get('entity_activity.settings')->get('language.user');
    /** @var \Drupal\Core\Entity\ContentEntityInterface $source_entity */
    $source_entity = $this->entityTypeManager->getStorage($source_entity_type)->load($source_entity_id);
    // The source entity has been deleted. Load it from the serialized entity stored in the settings.
    // @TODO use always this entity serialized instead of reloading the source entity.
    if (!$source_entity) {
      $source_entity = $this->serializer->deserialize($source_entity_serialized, $source_entity_class, 'json');
    }
    if ($source_entity) {
      $source_entity = $source_entity->hasTranslation($langcode) ? $source_entity->getTranslation($langcode) : $source_entity;
    }

    foreach ($entities_subscribed as $entity_type_id => $ids) {
      foreach ($ids as $id) {
        try {
          $reference_source = $this->entityTypeManager->getStorage($entity_type_id)->load($id);
        }
        catch (\Exception $e) {
          $reference_source = NULL;
        }
        $subscriptions = $this->subscriptionStorage->loadMultipleByEntityTypeId($entity_type_id, $id, $langcode);
        foreach ($subscriptions as $subscription_id => $subscription) {
          // If the subscription owner has a preferred language we need to
          // regenerate the log message according to its langcode.
          $user_langcode = '';
          if ($use_user_preferred_language && $this->languageManager->isMultilingual()) {
            $owner = $subscription->getOwner();
            $user_langcode = $owner->getPreferredLangcode(FALSE);
          }
          if ($user_langcode && $user_langcode != $langcode && $source_entity instanceof ContentEntityInterface) {
            $original_langcode = $langcode;
            $langcode = $user_langcode;

            // We need to reload the generator in the user preferred language.
            $language = $this->languageManager->getLanguage($user_langcode);
            $original_language = $this->languageManager->getConfigOverrideLanguage();
            $this->languageManager->setConfigOverrideLanguage($language);
            /** @var \Drupal\entity_activity\Entity\GeneratorInterface $generator */
            $generator = $this->entityTypeManager->getStorage('entity_activity_generator')->load($generator_id);
            $this->languageManager->setConfigOverrideLanguage($original_language);

            if ($generator instanceof GeneratorInterface) {
              $log_generators = $generator->getLogGenerators();
              if (isset($log_generators[$this->pluginId])) {
                $log_message = $log_generators[$this->pluginId]['log'];
                // As we rewrite the log message, we are not sure to have the
                // good context, if using cron, so we need to pass the current
                // user id and the current date stored to retrieve right values
                // for tokens.
                // @See entity_activity_tokens().
                $log_message = $this->rewriteFinalLog($source_entity, $log_message, $current_user_id, $current_date, $original_langcode);
              }
            }
          }

          $log = $this->logStorage->generate($subscription, $log_message, $this->pluginId, $current_user_id, $langcode, $source_entity, $reference_source, [$this->pluginId => $this->getConfiguration()]);
          $result = $log->save();
          if ($result) {
            $count++;
          }
        }
      }
    }

    return $count;
  }

  /**
   * {@inheritdoc}
   */
  public function rewriteFinalLog(ContentEntityInterface $entity, array $log_message, $current_user_id, $current_date, $langcode) {
    $options = [
      'clear' => TRUE,
      'langcode' => $langcode,
      'log_generator' => TRUE,
      'current_user_id' => $current_user_id,
      'current_date' => $current_date,
    ];
    $log_message['value'] = $this->token->replace($log_message['value'], [$entity->getEntityTypeId() => $entity], $options);
    return $log_message;
  }

  /**
   * {@inheritdoc}
   */
  public function getFinalLog(ContentEntityInterface $entity) {
    $log_message = $this->getConfiguration()['log'];
    $log_message['value'] = $this->token->replace($log_message['value'], [$entity->getEntityTypeId() => $entity], ['clear' => TRUE, 'log_generator' => TRUE]);
    return $log_message;
  }

}
