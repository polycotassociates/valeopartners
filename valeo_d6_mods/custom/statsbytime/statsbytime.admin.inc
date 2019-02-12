<?php
// $Id$

/**
 * @file
 *   Provide the admin related functions for the Stats By Time module.
 */


function statsbytime_settings_form() {
	$form = array();
	$form['statsbytime_fields'] = array(
		'#title' => t("Fields Requiring Statistics"),
		'#description' => t('Put a checkmark by those fields that need to have calculated statistics.'),
		'#type' => 'checkboxes',
		'#default_value' => variable_get('statsbytime_fields', ''),
		'#options' => statsbytime_get_contentfields(),
	);
	$form['statsbytime_stats'] = array(
		'#title' => t("Statistics to be Calculated"),
		'#description' => t('Put a checkmark by those statistics to be generated.'),
		'#type' => 'checkboxes',
		'#default_value' => variable_get('statsbytime_stats', ''),
		'#options' => array(
			'min' => statsbytime_lookup_stat('min'),
			'max' => statsbytime_lookup_stat('max'),
			'avg' => statsbytime_lookup_stat('avg'),
			'med' => statsbytime_lookup_stat('med'),
			'std' => statsbytime_lookup_stat('std'),
		),
	);
	$form['statsbytime_years'] = array(
		'#title' => t("Years Calculated"),
		'#description' => t('Select the earliest year for which statistics should be calculated.'),
		'#type' => 'select',
		'#default_value' => variable_get('statsbytime_years', ''),
		'#options' => statsbytime_get_years(),
	);
	$form['statsbytime_yearsdisplay'] = array(
		'#title' => t("Years Displayed"),
		'#description' => t('Select the last year for which statistics should be displayed (in most cases this year and the 2 preceding it will be shown).'),
		'#type' => 'select',
		'#default_value' => variable_get('statsbytime_yearsdisplay', ''),
		'#options' => statsbytime_get_years(),
	);
	$form['statsbytime_reset'] = array(
		'#title' => t("Reset all statistics"),
		'#description' => t('Check this box to delete and recalculate ALL statistics. WARNING: this can take an hour or more!'),
		'#type' => 'checkboxes',
		'#default_value' => 0,
		'#options' => array(
			'1' => t('Reset All Statistics'),
		),
	);
	$form['statsbytime_resetrates'] = array(
		'#title' => t("Reset all Most Current Rate data"),
		'#description' => t('Check this box to delete and recalculate ALL current rates. WARNING: this can take several minutes!'),
		'#type' => 'checkboxes',
		'#default_value' => 0,
		'#options' => array(
			'1' => t('Reset All Current Rates'),
		),
	);
	$form['statsbytime_missing'] = array(
		'#title' => t("Fill in all missing statistics"),
		'#description' => t('Check this box to find and fill in any missing statistics.'),
		'#type' => 'checkboxes',
		'#default_value' => 0,
		'#options' => array(
			'1' => t('Fill in Missing Statistics'),
		),
	);
	$form['#submit'][] = 'statsbytime_settings_form_submit';
	return system_settings_form($form);
}


function statsbytime_settings_form_submit($form, &$form_state) {
	// Recalculate all statistics if requested.
	if ($form_state['values']['statsbytime_reset'] && $form_state['values']['statsbytime_reset'][1] == 1) {
		statsbytime_generate_all_stats();
		drupal_set_message(t('All statistics are being recalculated.'));
	} else {
		// if not recalculating all statistics, see if missing statistics should be filled in.
		if ($form_state['values']['statsbytime_missing'] && $form_state['values']['statsbytime_missing'][1] == 1) {
			statsbytime_generate_missing_stats();
			drupal_set_message(t('Any missing statistics are being calculated.'));
		}
		// if not recalculating all statistics, see if we should recalculate current rates
		if ($form_state['values']['statsbytime_resetrates'] && $form_state['values']['statsbytime_resetrates'][1] == 1) {
			statsbytime_generate_all_currentrates();
			drupal_set_message(t('All Most Current Rates are being recalculated.'));
		}
	}
	// Create the Views needed to access the data from the statsbytime table
	if ($form_state['values']['statsbytime_fields'] && $form_state['values']['statsbytime_stats'] && $form_state['values']['statsbytime_years']) {
		$query = "
			CREATE ALGORITHM = MERGE VIEW vw_%d_%s AS 
			SELECT statsbytime.nid AS nid, 
				statsbytime.stat_max AS %d_stat_max, 
				statsbytime.stat_avg AS %d_stat_avg, 
				statsbytime.stat_min AS %d_stat_min, 
				statsbytime.stat_med AS %d_stat_med, 
				statsbytime.stat_std AS %d_stat_std, 
				statsbytime.stat_count AS %d_stat_count
			FROM {statsbytime}
			WHERE ((statsbytime.field = '%s') AND 
				(statsbytime.year = '%d'))
			ORDER BY statsbytime.nid";
		$dropquery = "DROP VIEW IF EXISTS vw_%d_%s";
		/* Drop all possible views */
		foreach(statsbytime_get_years() AS $year) {
			foreach(statsbytime_get_contentfields() AS $field => $value) {
				$args = array($year,$field);
				$result = db_query($dropquery, $args);
			}
		}
		/* Loop through the years selected */
		for ($year = $form_state['values']['statsbytime_years']; $year <= date('Y'); $year++) {
			/* Loop through each field to be calculated */
			foreach($form_state['values']['statsbytime_fields'] AS $field) {
				if ($field != '0') {
					$args = array($year,$field,$year,$year,$year,$year,$year,$year,$field,$year);
					$result = db_query($query, $args);
				}
			}
		}
	}
	/* Clear out the views cache to reset the hooks */
	cache_clear_all('*', 'cache_views', TRUE);
}
