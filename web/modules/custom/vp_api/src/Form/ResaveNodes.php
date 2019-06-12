<?php
namespace Drupal\vp_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ResaveNodes.
 */
class ResaveNodes extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'resave_nodes_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#prefix'] = "WARNING. This will take a long time.";

    $form['actions'] = ['#type' => 'actions'];

    $form['actions']['cases'] = [
      '#type' => 'submit',
      '#value' => t('Refresh Cases'),
      '#submit' => ['::refreshCaseHandler'],
    ];

    $form['actions']['filings'] = [
      '#type' => 'submit',
      '#value' => t('Refresh Filings'),
      '#submit' => ['::refreshFilingHandler'],
    ];

    $form['actions']['individual'] = [
      '#type' => 'submit',
      '#value' => t('Refresh Individuals'),
      '#submit' => ['::refreshIndividualHandler'],
    ];

    $form['actions']['rates'] = [
      '#type' => 'submit',
      '#value' => t('Refresh Rates'),
      '#submit' => ['::refreshRateHandler'],
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }


  /**
   * Custom submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function refreshCaseHandler(array &$form, FormStateInterface $form_state) {
    $type = 'vp_type_case';
    $batch = [
      'init_message' => t('Executing a batch...'),
      'operations' => [
        [
          '_execute_batch',
          [$type],
        ],
      ],
      'file' => drupal_get_path('module', 'vp_api') . '/inc/batch_functions.inc',
    ];
    batch_set($batch);
  }

  /**
   * Custom submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function refreshRateHandler(array &$form, FormStateInterface $form_state) {
    $type = 'vp_type_rate';
    $batch = [
      'init_message' => t('Executing a batch...'),
      'operations' => [
        [
          '_execute_batch',
          [$type],
        ],
      ],
      'file' => drupal_get_path('module', 'vp_api') . '/inc/batch_functions.inc',
    ];
    batch_set($batch);
  }

  /**
   * Custom submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function refreshFilingHandler(array &$form, FormStateInterface $form_state) {
    $type = 'vp_type_filing';
    $batch = [
      'init_message' => t('Executing a batch...'),
      'operations' => [
        [
          '_execute_batch',
          [$type],
        ],
      ],
      'file' => drupal_get_path('module', 'vp_api') . '/inc/batch_functions.inc',
    ];
    batch_set($batch);
  }

  /**
   * Custom submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function refreshIndividualHandler(array &$form, FormStateInterface $form_state) {
    $type = 'vp_type_individual';
    $batch = [
      'init_message' => t('Executing a batch...'),
      'operations' => [
        [
          '_execute_batch',
          [$type],
        ],
      ],
      'file' => drupal_get_path('module', 'vp_api') . '/inc/batch_functions.inc',
    ];
    batch_set($batch);
  }

}
