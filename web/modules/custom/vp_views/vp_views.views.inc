<?php
// $Id$

/**
 * @file
 * Hooks for Valeo Partners Views.
 */

/**
 * Implements hook_views_data().
 */
function vp_views_views_data() {
  // Add an export header with a link to the xls export.
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
 *
 * Register custom views fields.
 */
function vp_views_views_data_alter(&$data) {

  $data['views']['array_combine'] = [
    'title' => t('Combine fields filter (for select)'),
    'help' => t('Combine multiple fields together and search by them.'),
    'filter' => [
      'id' => 'array_combine',
    ],
  ];

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

  $data['node']['low_actual_rate'] = array(
    'field' => array(
      'id' => 'low_actual_rate',
      'title' => t('Low Actual Rate'),
      'help' => t('Gets the lowest rate given a position/rate/firm.'),
    ),
  );

  $data['node']['high_actual_rate'] = array(
    'field' => array(
      'id' => 'high_actual_rate',
      'title' => t('High Actual Rate'),
      'help' => t('Gets the highest rate given a position/rate/firm.'),
    ),
  );

  $data['node']['average_actual_rate'] = array(
    'field' => array(
      'id' => 'average_actual_rate',
      'title' => t('Avg Actual Rate'),
      'help' => t('Gets the average rate given a position/rate/firm.'),
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

