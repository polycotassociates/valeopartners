<?php
// $Id$

/**
 * @file
 *   Hooks for Valeo Partners Views.
 */



/**
 * Implements hook_views_data().
 */
function vp_views_views_data() {
  $data['views']['export_header'] = [
    'title' => t('Export Link Header'),
    'help' => t('An area containing links with current arguments.'),
    'area' => [
      'id' => 'export_header',
    ],
  ];
  return $data;
}

/**
 * Implements hook_views_data_alter().
 */
function vp_views_views_data_alter(&$data) {
  //Add to Node views
  $data['node']['actual_rate_by_year'] = array(
    'field' => array(
      'id' => 'actual_rate_by_year',
      'title' => t('Actual Rate By Year'),
      'help' => t('Get actual rate by a given year, defaults to current year'),
    ),
  );

  $data['node']['standard_rate_by_year'] = array(
    'field' => array(
      'id' => 'standard_rate_by_year',
      'title' => t('Standard Rate By Year'),
      'help' => t('Get standard rate by a given year, defaults to current year'),
    ),
  );

  $data['node__field_vp_rate_hourly']['has_actual_rate'] = array(
    'title' => t('Has rate'),
    'filter' => array(
      'title' => t('Has a rate'),
      'field' => 'field_vp_rate_hourly_value',
      'id' => 'has_actual_rate',
    ),
  );

  //Add to Node views
  $data['node_field_data']['all_companies_filter'] = array(
    'title' => t('List Of Companies'),
    'filter' => array(
      'title' => t('Companies'),
      'help' => t('Specify a list of all companies'),
      'field' => 'title',
      'id' => 'all_companies_filter',
    ),
  );

}

