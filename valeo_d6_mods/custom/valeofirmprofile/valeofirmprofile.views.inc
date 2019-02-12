<?php
// $Id$

/**
 * @file
 *   Provides views integration for Firm Profile
 */

/**
 * Implementation of hook_views_data().
 *
 * Exposes all StatsByTime data to the views system.
 */
function valeofirmprofile_views_data() {
	$data['vw_rate_firm_position']['table']['group']  = t('Rate/Firm/Position Data');
	$data['vw_rate_firm_position']['table']['base'] = array(
		'field' => 'rate_nid',
		'title' => t('Rate/Firm/Position Data'),
		'help' => t('Summary data on rates by firm and position.'),
	);
	$data['vw_rate_firm_position']['table']['join'] = array(
		'node' => array(
			'left_field' => 'nid',
			'field' => 'rate_nid',
		),
		'term_data' => array(
			'left_field' => 'tid',
			'field' => 'position_tid',
    	),
	);
	$data['vw_rate_firm_position']['rate_nid'] = array(
		'title' => t('A Related Rate'),
		'help' => t('A relationship to a related rate.'), // The help that appears on the UI,
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
	$data['vw_rate_firm_position']['individual_nid'] = array(
		'title' => t('Individual ID'), // The item it appears as on the UI,
		'help' => t('The ID of the attorney for this rate.'), // The help that appears on the UI,
		'relationship' => array(
			'base' => 'node',
			'field' => 'nid',
			'handler' => 'views_handler_relationship',
			'label' => t('Individual'),
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
	$data['vw_rate_firm_position']['firm_nid'] = array(
		'title' => t('Firm ID'), // The item it appears as on the UI,
		'help' => t('The ID of the firm for this rate.'), // The help that appears on the UI,
		'relationship' => array(
			'base' => 'node',
			'field' => 'nid',
			'handler' => 'views_handler_relationship',
			'label' => t('Firm'),
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
	$data['vw_rate_firm_position']['filing_nid'] = array(
		'title' => t('Filing ID'), // The item it appears as on the UI,
		'help' => t('The ID of the filing for this rate.'), // The help that appears on the UI,
		'relationship' => array(
			'base' => 'node',
			'field' => 'nid',
			'handler' => 'views_handler_relationship',
			'label' => t('Filing'),
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
	$data['vw_rate_firm_position']['position_tid'] = array(
		'title' => t('Position ID'), // The item it appears as on the UI,
		'help' => t('The ID of the position for this rate.'), // The help that appears on the UI,
		'relationship' => array(
			'base' => 'term_data',
			'field' => 'tid',
			'handler' => 'views_handler_relationship',
			'label' => t('Position'),
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
	$data['vw_rate_firm_position']['market_rate'] = array(
		'title' => t('Actual Rate'),
		'help' => t('The Actual Rate'),
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
	$data['vw_rate_firm_position']['standard_rate'] = array(
		'title' => t('Standard Rate'),
		'help' => t('The Standard Rate'),
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
	$data['vw_rate_firm_position']['feeappdate'] = array(
		'title' => t('Fee Date'),
		'help' => t('The Fee Date (Ending)'),
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
	$data['vw_rate_firm_position_actual']['table'] = array(
		'group' => t('Firm/Position Maximum and Minimum Rate Data'),
		'base' => array(
			'field' => 'firm_nid',
			'title' => t('Firm/Position Maximum and Minimum Actual Rate Data'),
			'help' => t('Maximum and Minimum Actual Rate data by firm and position.'),
		),
		'join' => array(
			'node' => array(
				'left_field' => 'nid',
				'field' => 'firm_nid',
			),
		),
	);
	$data['vw_rate_firm_position_actual']['firm_nid'] = array(
		'title' => t('Firm ID'), // The item it appears as on the UI,
		'help' => t('The ID of the firm for this rate.'), // The help that appears on the UI,
		'argument' => array(
			'handler' => 'views_handler_argument_node_nid',
			'name field' => 'title', 
			'numeric' => TRUE,
			'validate type' => 'nid',
		),
		'relationship' => array(
			'handler' => 'views_handler_relationship',
			'label' => t('Firm'),
			'base' => 'node',
			'base field' => 'nid',
			'skip base' => array(),
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
	$data['vw_rate_firm_position_actual']['rate_nid'] = array(
		'title' => t('Rate ID'), // The item it appears as on the UI,
		'help' => t('The ID of a representative rate for this firm.'), // The help that appears on the UI,
		'argument' => array(
			'handler' => 'views_handler_argument_node_nid',
			'name field' => 'title', 
			'numeric' => TRUE,
			'validate type' => 'nid',
		),
		'relationship' => array(
			'handler' => 'views_handler_relationship',
			'label' => t('Rate'),
			'base' => 'node',
			'base field' => 'nid',
			'skip base' => array(),
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
	$data['vw_rate_firm_position_actual']['position_tid'] = array(
		'title' => t('Position ID'), // The item it appears as on the UI,
		'help' => t('The ID of the position for this rate.'), // The help that appears on the UI,
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
	$data['vw_rate_firm_position_actual']['position_name'] = array(
		'title' => t('Position Name'), // The item it appears as on the UI,
		'help' => t('The name of the position for this rate.'), // The help that appears on the UI,
		'field' => array(
			'handler' => 'views_handler_field',
			'click sortable' => TRUE,
		),
		'sort' => array(
			'handler' => 'views_handler_sort',
		),
		'filter' => array(
			'handler' => 'views_handler_filter_string',
		),
	);
	$data['vw_rate_firm_position_actual']['position_weight'] = array(
		'title' => t('Position Weight'), // The item it appears as on the UI,
		'help' => t('The weight of the position for this rate.'), // The help that appears on the UI,
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
	$data['vw_rate_firm_position_actual']['position_lineage'] = array(
		'title' => t('Position Lineage'), // The item it appears as on the UI,
		'help' => t('The lineage of this position.'), // The help that appears on the UI,
		'field' => array(
			'handler' => 'views_handler_field',
			'click sortable' => TRUE,
		),
		'sort' => array(
			'handler' => 'views_handler_sort',
		),
		'filter' => array(
			'handler' => 'views_handler_filter_string',
		),
	);
	$data['vw_rate_firm_position_actual']['position_depth'] = array(
		'title' => t('Position Depth'), // The item it appears as on the UI,
		'help' => t('The depth of the position in the hierarchy.'), // The help that appears on the UI,
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
	$data['vw_rate_firm_position_actual']['feeappdate'] = array(
		'title' => t('Fee Date'),
		'help' => t('The Fee Date (Ending Date)'),
		'argument' => array(
			'handler' => 'views_handler_argument_numeric',
			'name field' => 'title', 
			'numeric' => TRUE,
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
	$data['vw_rate_firm_position_actual']['count_rate'] = array(
		'title' => t('Number of Rates'),
		'help' => t('The Number of Rates'),
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
	$data['vw_rate_firm_position_actual']['max_market_rate'] = array(
		'title' => t('High Actual Rate'),
		'help' => t('The Maximum Actual Rate'),
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
	$data['vw_rate_firm_position_actual']['min_market_rate'] = array(
		'title' => t('Low Actual Rate'),
		'help' => t('The Minimum Actual Rate'),
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
	$data['vw_rate_firm_position_actual']['avg_market_rate'] = array(
		'title' => t('Avg Actual Rate'),
		'help' => t('The Average Actual Rate'),
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
	$data['vw_rate_firm_position_actual']['parent_tid'] = array(
		'title' => t('Parent Position ID'),
		'help' => t('Parent Position ID'),
		'argument' => array(
			'handler' => 'views_handler_argument_numeric',
			'name field' => 'title', 
			'numeric' => TRUE,
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
	$data['vw_rate_firm_position_standard']['table'] = array(
		'group' => t('Firm/Position Maximum and Minimum Rate Data'),
		'join'  => array(
			'node' => array(
				'left_table' => 'vw_rate_firm_position_actual',
				'left_field' => 'firm_nid',
				'field' => 'firm_nid',
				'extra' => array(
					array(
						'field' => 'position_tid',
						'value' => 'vw_rate_firm_position_actual.position_tid',
						'operator' => '=',
						'numeric' => true,
					),
					array(
						'field' => 'feeappdate',
						'value' => 'vw_rate_firm_position_actual.feeappdate',
						'operator' => '=',
						'numeric' => true,
					),
				)
			),
		),
	);
	$data['vw_rate_firm_position_standard']['count_rate'] = array(
		'title' => t('Number of Standard Rates'),
		'help' => t('The Number of Standard Rates'),
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
	$data['vw_rate_firm_position_standard']['max_standard_rate'] = array(
		'title' => t('High Standard Rate'),
		'help' => t('The Maximum Standard Rate'),
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
	$data['vw_rate_firm_position_standard']['min_standard_rate'] = array(
		'title' => t('Low Standard Rate'),
		'help' => t('The Minimum Standard Rate'),
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
	$data['vw_rate_firm_position_standard']['avg_standard_rate'] = array(
		'title' => t('Avg Standard Rate'),
		'help' => t('The Average Standard Rate'),
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
	$data['vw_rate_firm_position_actual_parent']['table'] = array(
		'group' => t('Firm/Position Maximum and Minimum Rate Data for Parent Positions'),
		'base' => array(
			'field' => 'firm_nid',
			'title' => t('Firm/Position Maximum and Minimum Actual Rate Data for Parent Positions'),
			'help' => t('Maximum and Minimum Actual Rate data by firm and position.'),
		),
		'join' => array(
			'node' => array(
				'left_field' => 'nid',
				'field' => 'firm_nid',
			),
		),
	);
	$data['vw_rate_firm_position_actual_parent']['firm_nid'] = array(
		'title' => t('Firm ID'), // The item it appears as on the UI,
		'help' => t('The ID of the firm for this rate.'), // The help that appears on the UI,
		'argument' => array(
			'handler' => 'views_handler_argument_node_nid',
			'name field' => 'title', 
			'numeric' => TRUE,
			'validate type' => 'nid',
		),
		'relationship' => array(
			'handler' => 'views_handler_relationship',
			'label' => t('Firm'),
			'base' => 'node',
			'base field' => 'nid',
			'skip base' => array(),
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
	$data['vw_rate_firm_position_actual_parent']['position_tid'] = array(
		'title' => t('Position ID'), // The item it appears as on the UI,
		'help' => t('The ID of the position for this rate.'), // The help that appears on the UI,
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
	$data['vw_rate_firm_position_actual_parent']['position_name'] = array(
		'title' => t('Position Name'), // The item it appears as on the UI,
		'help' => t('The name of the position for this rate.'), // The help that appears on the UI,
		'field' => array(
			'handler' => 'views_handler_field',
			'click sortable' => TRUE,
		),
		'sort' => array(
			'handler' => 'views_handler_sort',
		),
		'filter' => array(
			'handler' => 'views_handler_filter_string',
		),
	);
	$data['vw_rate_firm_position_actual_parent']['position_lineage'] = array(
		'title' => t('Position Lineage'), // The item it appears as on the UI,
		'help' => t('The lineage of this position.'), // The help that appears on the UI,
		'field' => array(
			'handler' => 'views_handler_field',
			'click sortable' => TRUE,
		),
		'sort' => array(
			'handler' => 'views_handler_sort',
		),
		'filter' => array(
			'handler' => 'views_handler_filter_string',
		),
	);
	$data['vw_rate_firm_position_actual_parent']['position_depth'] = array(
		'title' => t('Position Depth'), // The item it appears as on the UI,
		'help' => t('The depth of the position in the hierarchy.'), // The help that appears on the UI,
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
	$data['vw_rate_firm_position_actual_parent']['feeappdate'] = array(
		'title' => t('Fee Date'),
		'help' => t('The Fee Date (Ending Date)'),
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
	$data['vw_rate_firm_position_actual_parent']['count_rate'] = array(
		'title' => t('Number of Rates'),
		'help' => t('The Number of Rates'),
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
	$data['vw_rate_firm_position_actual_parent']['max_market_rate'] = array(
		'title' => t('High Actual Rate'),
		'help' => t('The Maximum Actual Rate'),
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
	$data['vw_rate_firm_position_actual_parent']['min_market_rate'] = array(
		'title' => t('Low Actual Rate'),
		'help' => t('The Minimum Actual Rate'),
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
	$data['vw_rate_firm_position_actual_parent']['avg_market_rate'] = array(
		'title' => t('Avg Actual Rate'),
		'help' => t('The Average Actual Rate'),
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
	$data['vw_rate_firm_position_standard_parent']['table'] = array(
		'group' => t('Firm/Position Maximum and Minimum Rate Data for Parent Positions'),
		'join'  => array(
			'node' => array(
				'left_table' => 'vw_rate_firm_position_actual_parent',
				'left_field' => 'firm_nid',
				'field' => 'firm_nid',
				'extra' => array(
					array(
						'field' => 'position_tid',
						'value' => 'vw_rate_firm_position_actual_parent.position_tid',
						'operator' => '=',
						'numeric' => true,
					),
					array(
						'field' => 'feeappdate',
						'value' => 'vw_rate_firm_position_actual_parent.feeappdate',
						'operator' => '=',
						'numeric' => true,
					),
				)
			),
		),
	);
	$data['vw_rate_firm_position_standard_parent']['count_rate'] = array(
		'title' => t('Number of Standard Rates'),
		'help' => t('The Number of Standard Rates'),
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
	$data['vw_rate_firm_position_standard_parent']['max_standard_rate'] = array(
		'title' => t('High Standard Rate'),
		'help' => t('The Maximum Standard Rate'),
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
	$data['vw_rate_firm_position_standard_parent']['min_standard_rate'] = array(
		'title' => t('Low Standard Rate'),
		'help' => t('The Minimum Standard Rate'),
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
	$data['vw_rate_firm_position_standard_parent']['avg_standard_rate'] = array(
		'title' => t('Avg Standard Rate'),
		'help' => t('The Average Standard Rate'),
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