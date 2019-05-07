<?php

namespace Drupal\entity_activity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\SubformState;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Plugin\Context\ContextRepositoryInterface;
use Drupal\Core\Plugin\PluginFormFactoryInterface;
use Drupal\entity_activity\Plugin\LogGeneratorManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GeneratorForm.
 */
class GeneratorForm extends EntityForm {

  /**
   * A logger instance.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * The generator entity.
   *
   * @var \Drupal\entity_activity\Entity\GeneratorInterface
   */
  protected $entity;

  /**
   * The log generator plugin manager.
   *
   * @var \Drupal\entity_activity\Plugin\LogGeneratorManagerInterface
   */
  protected $manager;

  /**
   * The event dispatcher service.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $dispatcher;

  /**
   * The language manager service.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $language;

  /**
   * The theme handler.
   *
   * @var \Drupal\Core\Extension\ThemeHandler
   */
  protected $themeHandler;

  /**
   * The context repository service.
   *
   * @var \Drupal\Core\Plugin\Context\ContextRepositoryInterface
   */
  protected $contextRepository;

  /**
   * The plugin form manager.
   *
   * @var \Drupal\Core\Plugin\PluginFormFactoryInterface
   */
  protected $pluginFormFactory;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.factory')->get('asset_injector'),
      $container->get('plugin.manager.log_generator'),
      $container->get('context.repository'),
      $container->get('language_manager'),
      $container->get('theme_handler'),
      $container->get('plugin_form.factory')
    );
  }

  /**
   * GeneratorFormBase constructor.
   *
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\entity_activity\Plugin\LogGeneratorManagerInterface $log_generator_manager
   *   The LogGeneratorManager for building the generators UI.
   * @param \Drupal\Core\Plugin\Context\ContextRepositoryInterface $context_repository
   *   The lazy context repository service.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language
   *   The language manager.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler.
   * @param \Drupal\Core\Plugin\PluginFormFactoryInterface $plugin_form_manager
   *   The plugin form manager.
   */
  public function __construct(LoggerInterface $logger, LogGeneratorManagerInterface $log_generator_manager, ContextRepositoryInterface $context_repository, LanguageManagerInterface $language, ThemeHandlerInterface $theme_handler, PluginFormFactoryInterface $plugin_form_manager) {
    $this->logger = $logger;
    $this->manager = $log_generator_manager;
    $this->contextRepository = $context_repository;
    $this->language = $language;
    $this->themeHandler = $theme_handler;
    $this->pluginFormFactory = $plugin_form_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $form['#tree'] = TRUE;

    /** @var \Drupal\entity_activity\Entity\GeneratorInterface $entity */
    $entity = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $entity->label(),
      '#description' => $this->t("Label for the Generator."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\entity_activity\Entity\Generator::load',
      ],
      '#disabled' => !$entity->isNew(),
    ];

    $form['generators'] = $this->buildLogGeneratorsInterface([], $form_state);
    $form['generators']['#weight'] = 99;

    // $form['status'] = [];.
    return $form;
  }

  /**
   * Helper function for building the generators UI form.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form array with the generators UI added in.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  protected function buildLogGeneratorsInterface(array $form, FormStateInterface $form_state) {
    $form['generators_tabs'] = [
      '#type' => 'vertical_tabs',
      '#title' => $this->t('Generators'),
      '#parents' => ['generators_tabs'],
      '#attached' => [
        'library' => [
          'entity_activity/admin',
        ],
      ],
    ];

    $log_generators = $this->entity->getLogGenerators();
    $log_generators_definitions = $this->manager->getDefinitions();
    $log_generators_definitions = $this->manager->removeExcludeDefinitions($log_generators_definitions);
    foreach ($log_generators_definitions as $log_generator_id => $definition) {

      $log_generator_config = isset($log_generators[$log_generator_id]) ? $log_generators[$log_generator_id] : [];
      /** @var \Drupal\entity_activity\Plugin\LogGeneratorInterface $log_generator */
      $log_generator = $this->manager->createInstance($log_generator_id, $log_generator_config);
      $form_state->set(['generators', $log_generator_id], $log_generator);
      $log_generator_form = $log_generator->buildConfigurationForm([], $form_state);
      $log_generator_form['#type'] = 'details';
      $log_generator_form['#title'] = $log_generator->getPluginDefinition()['label'];
      $log_generator_form['#group'] = 'generators_tabs';

      $form[$log_generator_id] = $log_generator_form;
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function actionsElement(array $form, FormStateInterface $form_state) {
    $element = parent::actionsElement($form, $form_state);
    $element['saveContinue'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save and Continue Editing'),
      '#name' => 'save_continue',
      '#submit' => ['::submitForm', '::save'],
      '#weight' => 7,
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $generators = $form_state->getValue('generators');
    // Validate generators log generator settings.
    foreach ($generators as $log_generator_id => &$values) {
      // Allow the log generator to validate the form.
      $log_generator = $form_state->get(['generators', $log_generator_id]);
      $log_generator->validateConfigurationForm($form['generators'][$log_generator_id], SubformState::createForSubform($form['generators'][$log_generator_id], $form, $form_state));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $generators = $form_state->getValue('generators');
    foreach ($form_state->getValue('generators') as $log_generator_id => $values) {
      // Allow the log generator to submit the form.
      $log_generator = $form_state->get(['generators', $log_generator_id]);
      $log_generator->submitConfigurationForm($form['generators'][$log_generator_id], SubformState::createForSubform($form['generators'][$log_generator_id], $form, $form_state));
      $log_generator_configuration = $log_generator->getConfiguration();
      // Update the log generators generators on the entity.
      $this->entity->getLogGeneratorsCollection()
        ->addInstanceId($log_generator_id, $log_generator_configuration);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = $entity->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Generator.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Generator.', [
          '%label' => $entity->label(),
        ]));
    }
    $trigger = $form_state->getTriggeringElement();
    if (isset($trigger['#name']) && $trigger['#name'] != 'save_continue') {
      $form_state->setRedirectUrl($entity->toUrl('collection'));
    }
    else {
      $form_state->setRedirectUrl($entity->toUrl());
    }
  }

}
