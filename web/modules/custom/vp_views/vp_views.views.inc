<?php
// $Id$

/**
 * @file
 *   Hooks for Valeo Partners Views
 */
use Drupal\views\Views;

/**
 * Implements hook_preprocess_views_view_field().
 * @param $variables
 */
function vp_views_preprocess_views_view_field(&$variables) {

  if ($variables['view']->id() == 'search_rate_trending_analysis') {

    if ($variables['field']->realField == 'previous_year_rate') {
      $variables['output'] = '$' . $variables['output'];
    }

    if ($variables['field']->realField == 'field_vp_rate_hourly') {
      $variables['output'] = '$' . $variables['output'];
    }
  }
}

// function vp_views_views_post_render(\Drupal\views\ViewExecutable $view) {
//   if ($view->id() == 'test_search_rates_by_individual') {
//    // Set the view title.
//    $view->setTitle('NEW TITLE');
//   }
// }


/**
 * Implements hook_views_data_alter().
 */
function vp_views_views_data_alter(array &$data) {

    $data['node']['vp_views_previous_year_exists'] = array(
      'title' => t("Previous Rate Exists"),
      'filter' => [
        'title' => t('Previous Rate Exists'),
        'help' => 'Checkt to see if a previous rate exists',
        'field' => 'previous_year_rate',
        'id' => 'equality',
      ]
    );
    
    $data['node']['previous_year_rate'] = array(
        'title' => t("Previous Year's Rate"),
        'category' => 'Valeo Partners',
        'field' => array(
          'title' => t("Previous Year's Rate"),
          'help' => t("The rate from the previous year from a rate object"),
          'id' => 'previous_year_rate',
        ),
      );

    return $data;
  }

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Implements hook_form_FORM_ID_alter().
 */
function vp_views_form_views_exposed_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  
  // ksm ($form['#id']);
  if (isset($form['#id']) && $form['#id'] == 'views-exposed-form-search-rates-by-single-individual-default') {
    
    $options = [
      'all' => t('- All -'),
      '2015' => '2015',
      '2016' => '2016',
      '2017' => '2017',
      '2018' => '2018',
    ];

    $form['edit-year'] = [
      '#title' => new TranslatableMarkup('By year'),
      '#type' => 'select',
      '#options' => $options,
      '#size' => NULL,
      '#default_value' => 'all',
    ];
  }
}




/**
 * Implements hook_form_FORM_ID_alter(); alter views_exposed_form.
 */
function vp_forms_form_views_exposed_form_alter(&$form, &$form_state) {
	if( $form['#id'] == 'views-exposed-form-search-rates-by-single-individual-default') {
    // Switch date formatter to year only
    $form['field_vp_filing_fee_dates']['value']['#date_format'] = 'Y';
    // Add extra validator to handle filter submit
    $form['#validate'][] = 'vp_forms_views_exposed_form_validate';
  }
 
}

function vp_forms_views_exposed_form_validate(&$form, &$form_state) {
	$handlers = &$form_state['view']->filter;

  foreach ($handlers as $key => $handler) {
    if (!empty($handler->options['exposed'])
     && isset($form[$key]['value']['#type'])
     && $form[$key]['value']['#type'] == 'date_select'
     && $form[$key]['value']['#date_format'] == 'Y'){
      $handler->options['granularity'] = 'year';
      $handler->format = 'Y';
    }
  }
}