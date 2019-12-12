<?php

namespace Drupal\entity_activity_mail\Form;

use Drupal\Component\Utility\EmailValidatorInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\entity_activity_mail\ReportServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * Drupal\entity_activity_mail\ReportServiceInterface definition.
   *
   * @var \Drupal\entity_activity_mail\ReportServiceInterface
   */
  protected $report;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Component\Utility\EmailValidatorInterface definition.
   *
   * @var \Drupal\Component\Utility\EmailValidatorInterface
   */
  protected $emailValidator;

  /**
   * Drupal\Core\Extension\ModuleHandlerInterface definition.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Drupal\Core\Entity\EntityFieldManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * SettingsForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\entity_activity_mail\ReportServiceInterface $report
   *   The log report service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Component\Utility\EmailValidatorInterface $email_validator
   *   The email validator service.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ReportServiceInterface $report, EntityTypeManagerInterface $entity_type_manager, EmailValidatorInterface $email_validator, ModuleHandlerInterface $module_handler, EntityFieldManagerInterface $entity_field_manager) {
    parent::__construct($config_factory);
    $this->report = $report;
    $this->entityTypeManager = $entity_type_manager;
    $this->emailValidator = $email_validator;
    $this->moduleHandler = $module_handler;
    $this->entityFieldManager = $entity_field_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_activity_mail.report'),
      $container->get('entity_type.manager'),
      $container->get('email.validator'),
      $container->get('module_handler'),
      $container->get('entity_field.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'entity_activity_mail.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'entity_activity_mail_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('entity_activity_mail.settings');

    $form['help'] = [
      '#type' => 'item',
      '#markup' => $this->t('It is highly recommended to configure the site cron at least every hour, and to run the cron from your server. Cron jobs launched can be costly in performance.'),
      '#wrapper_attributes' => ['class' => ['messages', 'messages--warning']],
      '#access' => (bool) !$config->get('general.hide_message'),
    ];

    $form['general'] = [
      '#type' => 'details',
      '#title' => $this->t('General settings'),
      '#tree' => TRUE,
      '#open' => TRUE,
    ];

    $form['general']['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Entity Activity Mail'),
      '#description' => $this->t('Uncheck this option will stop sending logs report to users.'),
      '#default_value' => $config->get('general.enabled'),
    ];

    $form['general']['only_unread'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Include only unread logs in report'),
      '#description' => $this->t('Check this option to exclude <strong>read</strong> logs from the report sent by mail.'),
      '#default_value' => $config->get('general.only_unread'),
    ];

    $form['general']['mark_read'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Mark as read logs sent by mail'),
      '#description' => $this->t('Check this option to mark as <strong>read</strong> the logs sent by mail.'),
      '#default_value' => $config->get('general.mark_read'),
    ];

    $time = $config->get('general.cron_time') ?: '01:00:00';
    $time = strtotime($time);
    $form['general']['cron_time'] = [
      '#type' => 'datetime',
      '#title' => $this->t('Cron time'),
      '#description' => $this->t('The time when cron will run every days'),
      '#size' => 20,
      '#required' => TRUE,
      '#date_date_element' => 'none',
      '#date_time_element' => 'time',
      '#date_time_format' => 'H:i:s',
      '#default_value' => DrupalDateTime::createFromTimestamp($time),
    ];

    $form['general']['log_report'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Log the logs report sent'),
      '#description' => $this->t('Check this option to log every logs report sent by mail.'),
      '#default_value' => $config->get('general.log_report'),
    ];

    $form['general']['hide_message'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Stop displaying the message about the Cron configuration. I understood.'),
      '#default_value' => $config->get('general.hide_message'),
    ];

    if (!$this->moduleHandler->moduleExists('swiftmailer')) {
      $form['advice'] = [
        '#type' => 'item',
        '#markup' => $this->t('You should consider to install the <a href="@url" target="_blank" rel="noopener noreferrer">Swiftmailer</a> module to send logs report with HTML mail. Otherwise logs report mails will be sent as plain text.', ['@url' => 'https://www.drupal.org/project/swiftmailer']),
        '#wrapper_attributes' => ['class' => ['messages', 'messages--warning']],
      ];
    }

    $form['user'] = [
      '#type' => 'details',
      '#title' => $this->t('User settings'),
      '#tree' => TRUE,
      '#open' => TRUE,
    ];

    $form['user']['default_frequency'] = [
      '#type' => 'select',
      '#title' => $this->t('Default frequency'),
      '#options' => ['' => $this->t('None')] + $this->getFrequencies(),
      '#description' => $this->t('Select the default frequency to apply when a new user is created. This can always be changed by the user.'),
      '#default_value' => $config->get('user.default_frequency'),
    ];

    $form['mail'] = [
      '#type' => 'details',
      '#title' => $this->t('Mail settings'),
      '#tree' => TRUE,
      '#open' => TRUE,
    ];

    $form['mail']['from'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email From'),
      '#description' => $this->t('The Email used as the sender for emails sent. Leave empty to use the default site mail.'),
      '#default_value' => $config->get('mail.from'),
    ];

    $form['mail']['subject'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Mail subject'),
      '#default_value' => $config->get('mail.subject'),
    ];

    $form['mail']['body'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Mail body'),
      '#default_value' => $config->get('mail.body.value'),
      '#format' => $config->get('mail.body.format') ?: filter_fallback_format(),
    ];

    $form['mail']['footer'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Mail footer'),
      '#default_value' => $config->get('mail.footer.value'),
      '#format' => $config->get('mail.footer.format') ?: filter_fallback_format(),
    ];

    $form['mail']['token_help'] = [
      '#theme' => 'token_tree_link',
      '#token_types' => ['user' => 'user'],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    if (!empty($values['mail']['from'])) {
      if (!$this->emailValidator->isValid($values['mail']['from'])) {
        $form_state->setError($form['mail']['from'], $this->t('The email provided is not valid.'));
      }
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    /** @var \Drupal\Core\Datetime\DrupalDateTime $date */
    $date = $values['general']['cron_time'];
    $time = $date->format('H:i:s');
    $values['general']['cron_time'] = $time;
    $this->config('entity_activity_mail.settings')
      ->set('general', $values['general'])
      ->set('user', $values['user'])
      ->set('mail', $values['mail'])
      ->save();
    $this->report->updateNextCronTimestamp($time);
    parent::submitForm($form, $form_state);
  }

  /**
   * Get the allowed values from the user frequency field.
   *
   * @return array
   *   The allowed values.
   */
  protected function getFrequencies() {
    $allowed_values = [];
    $fields = $this->entityFieldManager->getFieldStorageDefinitions('user');
    if (isset($fields['entity_activity_mail_frequency'])) {
      $allowed_values = $fields['entity_activity_mail_frequency']->getSetting('allowed_values');
    }
    return $allowed_values;
  }

}
