<?php
// $Id$

/**
 * @file
 *   Provides views integration for Firm Updates
 */

/**
 * Implementation of hook_views_data().
 *
 * Exposes all Firm Updates data to the views system.
 */
function valeofirmupdates_views_data() {
	$data['vw_firm_updates']['table']['group']  = t('Firm Updated Data');
	$data['vw_firm_updates']['table']['base'] = array(
		'field' => 'firm_nid',
		'title' => t('Firm Updated Data'),
		'help' => t('The dates firms were most recently updated in the system.'),
	);
	$data['vw_firm_updates']['table']['join'] = array(
		'node' => array(
			'left_field' => 'nid',
			'field' => 'firm_nid',
		),
	);
	$data['vw_firm_updates']['firm_nid'] = array(
		'title' => t('A Related Firm'),
		'help' => t('A relationship to a related firm.'), // The help that appears on the UI,
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
	$data['vw_firm_updates']['node_updated'] = array(
		'title' => t('Firm Last Updated'),
		'help' => t('The Date the Firm was Last Updated'),
		'field' => array(
			'handler' => 'views_handler_field_date',
			'click sortable' => TRUE,
		),
		'sort' => array(
			'handler' => 'views_handler_sort_date',
		),
		'filter' => array(
			'handler' => 'views_handler_filter_date',
		),
	);
	return $data;
}