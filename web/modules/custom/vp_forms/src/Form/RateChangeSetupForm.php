<?php
namespace Drupal\vp_forms\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Class RateChangeSetupForm.
 */
class RateChangeSetupForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'rate_change_setup_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get current user.
    $user = User::load(\Drupal::currentUser()->id());

    $options = [];

    $result = \Drupal::entityQuery('node')
      ->condition('type', 'vp_type_firm')
      ->sort('title')->execute();
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($result);

    foreach ($nodes as $firm) {
      $options[$firm->id()] = $firm->get('title')->value;
    }

    $selected_firms_references = $user->get('field_user_pricing_alert_firms')->referencedEntities();
    $selected = [];
    foreach ($selected_firms_references as $reference) {
      $selected[] = $reference->id();
    }

    // Form Title.
    $form_title = $user->get('field_pricing_alert_firms_title')->value;

    $form['#prefix'] = "";

    $form['actions'] = ['#type' => 'actions'];

    $form['field_pricing_alert_firms_title'] = [
      '#type' => 'textfield',
      '#default_value' => $form_title,
      '#title' => $this
        ->t('Report Title:'),
    ];

    $form['field_user_pricing_alert_firms'] = [
      '#type' => 'multiselect',
      '#title' => $this
        ->t('Select Firms:'),
      '#default_value' => $selected,
      '#options' => $options,
      '#multiple' => TRUE,
      '#process' => array(
        array('Drupal\multiselect\Element\MultiSelect', 'processSelect'),
      ),
    ];

    $form['actions']['save'] = [
      '#type' => 'submit',
      '#value' => t('Save'),
      '#submit' => ['::saveRateChangeHandler'],
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
  public function saveRateChangeHandler(array &$form, FormStateInterface $form_state) {

    // Get the form values.
    $firms = $form['field_user_pricing_alert_firms']['#value'];
    $title = $form['field_pricing_alert_firms_title']['#value'];

    // Get the current user.
    $user = User::load(\Drupal::currentUser()->id());

    // Set the target ids for the field_user_pricing_alert_firms.
    $user->set('field_user_pricing_alert_firms', $firms);

    $user->set('field_pricing_alert_firms_title', $title);

    // Save updated user.
    $user->save();
    drupal_set_message("Rate change form updated.");

  }

}
