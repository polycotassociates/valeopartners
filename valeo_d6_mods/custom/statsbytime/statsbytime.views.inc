<?php
// $Id$

/**
 * @file
 *   Provides views integration for StatsByTime
 */

/**
 * Implementation of hook_views_data().
 *
 * Exposes all StatsByTime data to the views system.
 */
function statsbytime_views_data() {
	$contentfields = statsbytime_get_contentfields();
	for ($year = variable_get('statsbytime_years', ''); $year <= date('Y'); $year++) {
		/* Loop through each field to be calculated */
		foreach(variable_get('statsbytime_fields', '') AS $field) {
			if ($field != '0') {
				$data['vw_' . $year . '_' . $field]['table']['group']  = t("Stat By Time - $year - $contentfields[$field]");
				$data['vw_' . $year . '_' . $field]['table']['base'] = array(
					'field' => 'nid',
					'title' => t("Stats by Time - $year - $contentfields[$field]"),
					'help' => t("Calculated Statistics for $year, field $field Over Time."),
				);
				$data['vw_' . $year . '_' . $field]['table']['join'] = array(
					'node' => array(
						'left_field' => 'nid',
						'field' => 'nid',
					),
				);
				$data['vw_' . $year . '_' . $field][$year . '_stat_count'] = array(
					'title' => $year . ' ' . $contentfields[$field] . ' ' . statsbytime_lookup_stat('count'), // The item it appears as on the UI,
					'help' => t('The ' . statsbytime_lookup_stat('count') . ' of rates for an individual for ' . $field . ' for ' . $year), // The help that appears on the UI,
					'field' => array(
						'handler' => 'views_handler_field',
						'click sortable' => TRUE,
					),
					'sort' => array(
						'handler' => 'views_handler_sort',
					),
					'filter' => array(
						'handler' => 'views_handler_filter_numeric',
					),
				);
				foreach(variable_get('statsbytime_stats', '') AS $stat) {
					if ($stat != '0') {
						$data['vw_' . $year . '_' . $field][$year . '_stat_' . $stat] = array(
							'title' => $year . ' ' . $contentfields[$field] . ' ' . statsbytime_lookup_stat($stat), // The item it appears as on the UI,
							'help' => t('The ' . statsbytime_lookup_stat($stat) . ' for an individual for ' . $contentfields[$field] . ' for ' . $year), // The help that appears on the UI,
							'field' => array(
								'handler' => 'views_handler_field',
								'click sortable' => TRUE,
							),
							'sort' => array(
								'handler' => 'views_handler_sort',
							),
							'filter' => array(
								'handler' => 'views_handler_filter_numeric',
							),
						);	
					}
				}
			}
		}
	}
	$data['current_rate']['table']['group']  = t('Current Attorney Data');
	$data['current_rate']['table']['base'] = array(
		'field' => 'nid',
		'title' => t('Current Attorney Data'),
		'help' => t('The most current information recorded for a given attorney.'),
	);
	$data['current_rate']['table']['join'] = array(
		'node' => array(
			'left_field' => 'nid',
			'field' => 'nid',
		),
	);
	$data['current_rate']['nid'] = array(
		'title' => t('Most Current Related Rate'),
		'help' => t('A relationship to the most current related rate.'), // The help that appears on the UI,
		'field' => array(
			'handler' => 'views_handler_field',
			'click sortable' => TRUE,
		),
		'sort' => array(
			'handler' => 'views_handler_sort',
		),
		'filter' => array(
			'handler' => 'views_handler_filter_numeric',
		),
	);
	$data['current_rate']['rate_nid'] = array(
		'title' => t('Rate ID'), // The item it appears as on the UI,
		'help' => t('The ID of the most recent rate recorded for this attorney.'), // The help that appears on the UI,
		'relationship' => array(
			'base' => 'node',
			'field' => 'nid',
			'handler' => 'views_handler_relationship',
			'label' => t('Rate'),
		),
		'field' => array(
			'handler' => 'views_handler_field',
			'click sortable' => TRUE,
		),
		'sort' => array(
			'handler' => 'views_handler_sort',
		),
		'filter' => array(
			'handler' => 'views_handler_filter_numeric',
		),
	);
	return $data;
}