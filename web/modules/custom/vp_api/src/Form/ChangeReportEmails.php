<?php
namespace Drupal\vp_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Class RateChangeSetupForm.
 */
class ChangeReportEmails extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'change_report_emails';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Get the configuration settings.
    $config = \Drupal::service('config.factory')->getEditable('vp_api.settings');

    // Set the configuration settings to variables.
    $email = $config->get('vp_api.report_email.emails');
    $email_list_enable = $config->get('vp_api.report_email.email_list_enable');
    $new_report_enable = $config->get('vp_api.report_email.new_report_enable');


    // Create form.
    $form['spreadsheet_emails'] = [
      '#type' => 'fieldset',
      '#title' => $this
        ->t('Emails when reports are generated'),
    ];

    $form['spreadsheet_emails']['email_list_enable'] = [
      '#type' => 'checkbox',
      '#default_value' => $email_list_enable,
      '#title' => $this
        ->t('Enable email spreadsheet reports:'),
    ];

    $form['spreadsheet_emails']['email_list'] = [
      '#type' => 'textfield',
      '#default_value' => $email,
      '#title' => $this
        ->t('Email List:'),
      '#description' => $this
        ->t('Comma separated email list of those users to get a notification when a spreadsheet is generated'),
      '#states' => [
        'visible' => [
          ':input[name="email_list_enable"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['new_record_report'] = [
      '#type' => 'fieldset',
      '#title' => $this
        ->t('Daily report of new records'),
    ];

    $form['new_record_report']['new_report_enable'] = [
      '#type' => 'checkbox',
      '#default_value' => $new_report_enable,
      '#title' => $this
        ->t('Enable daily new record email:'),
    ];

    $form['new_record_report']['new_record_emails'] = [
      '#type' => 'textfield',
      '#default_value' => $new_report_enable,
      '#title' => $this
        ->t('Email List:'),
      '#description' => $this
        ->t('Comma separated email list of those users to get a daily notification of new records'),
      '#states' => [
        'visible' => [
          ':input[name="new_report_enable"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['actions']['save'] = [
      '#type' => 'submit',
      '#value' => t('Save'),
      '#submit' => ['::saveReportEmails'],
    ];


    return $form;
  }

  /**
   * Required submitForm function.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {}

  /**
   * Custom submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function saveReportEmails(array &$form, FormStateInterface $form_state) {

    // Get the form values.
    $email = $form['spreadsheet_emails']['email_list']['#value'];
    $email_list_enable = $form['spreadsheet_emails']['email_list_enable']['#value'];

    // Get the editable configuration settings.
    $config = \Drupal::service('config.factory')->getEditable('vp_api.settings');

    // Set the config settings based on the form values.
    $config->set('vp_api.report_email.email_list_enable', $email_list_enable);
    $config->set('vp_api.report_email.emails', $email);

    // Save data to the database.
    $config->save();

    drupal_set_message("Email address info updated.");

  }

}
