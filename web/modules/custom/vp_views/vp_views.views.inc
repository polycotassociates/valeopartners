<?php

/**
 * @file
 * Views Data configurations.
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

  // Add an export header with a link to the xls export for Summary View.
  $data['views']['export_summary_header'] = [
    'title' => t('Export Summary Link Header'),
    'help' => t('An area containing links with current arguments (For Summary)'),
    'area' => [
      'id' => 'export_summary_header',
    ],
  ];

  // Add an export header with a link to the xls export for Master Search View.
  $data['views']['export_master_header'] = [
    'title' => t('Export Master Search Link Header'),
    'help' => t('An area containing links with current arguments (For Master Search)'),
    'area' => [
      'id' => 'export_master_header',
    ],
  ];

  // Add an export header with a link to the xls export for Rate Trending Analysys.
  $data['views']['export_rate_trending'] = [
    'title' => t('Export Rate Trending Analysis Link Header'),
    'help' => t('An area containing links to export page (For Rate Trending Analysis)'),
    'area' => [
      'id' => 'export_rate_trending',
    ],
  ];

  // Add an export header with a link to the xls export for Transactions By Firm.
  $data['views']['export_transactions_by_firm'] = [
    'title' => t('Export Transactions By Firm Link Header'),
    'help' => t('An area containing links to export page (For Transactions By Firm)'),
    'area' => [
      'id' => 'export_transactions_by_firm',
    ],
  ];

  // Add an export header with a link to the xls export for Saved Search Summary Block.
  $data['views']['export_saved_search_summary_block'] = [
    'title' => t('Export Transactions For Saved Search Summary'),
    'help' => t('An area containing links to export page (Saved Search Summary)'),
    'area' => [
      'id' => 'export_saved_search_summary_block',
    ],
  ];


  // Add a simple print button.
  $data['views']['print_button'] = [
    'title' => t('Simple Print Button'),
    'help' => t('A link that invokes the "print page" dialog'),
    'area' => [
      'id' => 'print_button',
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

  $data['node']['actual_rate_by_year_paragraph'] = array(
    'field' => array(
      'id' => 'actual_rate_by_year_paragraph',
      'title' => t('Actual Rate By Year (Paragraph)'),
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


  $data['node_field_data']['has_actual_rate'] = array(
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

  $data['node']['practice_areas'] = array(
    'field' => array(
      'id' => 'practice_areas',
      'title' => t('Practice Areas'),
      'help' => t('Gets all the practice areas for a person.'),
    ),
  );

  $data['node_field_data']['field_paragraph_actual_rate_year_value'] = array(
    'title' => t('Has Rate Year'),
    'filter' => array(
      'title' => t('Has Rate Year'),
      'help' => t('Check to see if this year exists and has a rate.'),
      'field' => 'title',
      'id' => 'has_actual_rate_by_year',
    ),
  );

  // $data['node_field_data_node__field_vp_rate_individual']['node__field_vp_practice_area_3']['relationship'] = [
  //   'id' => 'standard',
  //   'base' => 'node__field_vp_practice_area_3',
  //   'base field' => 'entity_id',
  //   'field' => 'nid',
  // ];

}
