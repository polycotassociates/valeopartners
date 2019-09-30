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

    $config = \Drupal::service('config.factory')->getEditable('vp_api.settings');

    $email = $config->get('vp_api.report_email.emails');

    $form['#prefix'] = "Comma separated email list of those users to get a notification when a spreadsheet is generated.";

    $form['email_list'] = [
      '#type' => 'textfield',
      '#default_value' => $email,
      '#title' => $this
        ->t('Email:'),
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
    $email = $form['email_list']['#value'];
    $config = \Drupal::service('config.factory')->getEditable('vp_api.settings');

    $config->set('vp_api.report_email.emails', $email);

    // Save your data to the database.
    $config->save();

    drupal_set_message("Email address updated.");

  }

}
