<?php
// $Id$

/**
 * @file
 *   Hooks for Valeo Partners Views
 */


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
        'field' => 'nid',
        'id' => 'vp_views_previous_year_exists',
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