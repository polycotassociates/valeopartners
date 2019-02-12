<?php

/**
 * Implementation of hook_views_api().
 */
function valeo_views_views_api() {
  return array(
    'api' => '2',
  );
}

function valeo_views_views_query_alter(&$view, &$query){
		if ($view->name == 'rates_by_reportbuilder' && $view->current_display == 'feed_1') {
		//Let's examine the where clause
		$foundkey = -1;
		$neededstring = '';
		if (!empty($query->where)) {
			$currentWhere = $query->where;
			//All the where info
			$matches = 0;
			foreach ($currentWhere as $whereKey => $whereFilters) {
				//Clause layer
				if (!empty($whereFilters['clauses'])){
					$currentClause = $whereFilters['clauses'];

					//We need to see if there are 3, if not we will add them
					foreach ($currentClause as $clauseKey => $clauseValue){
						if (strpos($clauseValue,'node_node_data_field_rate_individual_node_data_field_individual_pa1.field_individual_pa1_value') !== false){
							$matches++;
							$foundkey = $whereKey;
							$neededstring = $clauseValue;
						}

						if (strpos($clauseValue,'node_node_data_field_rate_individual_node_data_field_individual_pa2.field_individual_pa2_value') !== false){
							$matches++;
						}

						if (strpos($clauseValue,'node_node_data_field_rate_individual_node_data_field_individual_pa3.field_individual_pa3_value') !== false){
							$matches++;
						}
					}
				}
			}

			if ($matches == 1 && $foundkey != -1){
				//Let's create the where array we want to add
				$clauses = array();
				$clauses[0] = $neededstring;

				$fixedclause01_part_one = str_replace('field_individual_pa1_value','field_individual_pa2_value',$neededstring);
				$fixedclause01_part_two = str_replace('field_individual_pa1','field_individual_pa2',$fixedclause01_part_one);
				$clauses[1] = $fixedclause01_part_two;

				$fixedclause02_part_one = str_replace('field_individual_pa1_value','field_individual_pa3_value',$neededstring);
				$fixedclause02_part_two = str_replace('field_individual_pa1','field_individual_pa3',$fixedclause02_part_one);
				$clauses[2] = $fixedclause02_part_two;

				$currentArgs = $currentWhere[$foundkey]['args'];
				$args = array();
				for ($x = 0; $x < 9; $x++){
					foreach ($currentArgs as $singleArgs){
						$args[] = $singleArgs;
					}
				}


				$type = $currentWhere[$foundkey]['type'];

				$newWhere = array();
				$newWhere['clauses'] = $clauses;
				$newWhere['args'] = $args;
				$newWhere['type'] = $type;

				$query->where[$foundkey] = $newWhere;

				//Add 2 tables to table_queue
				$pa2 = array();

				$pa2['table'] = 'node_data_field_individual_pa2';
				$pa2['num'] = 1;
				$pa2['alias'] = 'node_node_data_field_rate_individual_node_data_field_individual_pa2';
				$pa2['join'] = new views_join();
					$pa2['join']->definition = array();
					$pa2['join']->definition['table'] = 'content_type_individual';
					$pa2['join']->definition['left_field'] = 'vid';
					$pa2['join']->definition['field'] = 'vid';
					$pa2['join']->definition['left_table'] = 'node';
					$pa2['join']->extra_type = 'AND';
					$pa2['join']->table = 'content_type_individual';
					$pa2['join']->left_table = 'node_node_data_field_rate_individual';
					$pa2['join']->left_field = 'vid';
					$pa2['join']->field = 'vid';
					$pa2['join']->type = 'LEFT';
					$pa2['join']->adjusted = '1';
				$pa2['relationship'] = 'node_node_data_field_rate_individual';

				$pa3 = array();

				$pa3['table'] = 'node_data_field_individual_pa3';
				$pa3['num'] = 1;
				$pa3['alias'] = 'node_node_data_field_rate_individual_node_data_field_individual_pa3';
				$pa3['join'] = new views_join();
				$pa3['join']->definition = array();
				$pa3['join']->definition['table'] = 'content_type_individual';
				$pa3['join']->definition['left_field'] = 'vid';
				$pa3['join']->definition['field'] = 'vid';
				$pa3['join']->definition['left_table'] = 'node';
				$pa3['join']->extra_type = 'AND';
				$pa3['join']->table = 'content_type_individual';
				$pa3['join']->left_table = 'node_node_data_field_rate_individual';
				$pa3['join']->left_field = 'vid';
				$pa3['join']->field = 'vid';
				$pa3['join']->type = 'LEFT';
				$pa3['join']->adjusted = '1';
				$pa3['relationship'] = 'node_node_data_field_rate_individual';

				$query->table_queue['node_node_data_field_rate_individual_node_data_field_individual_pa2'] = $pa2;
				$query->table_queue['node_node_data_field_rate_individual_node_data_field_individual_pa3'] = $pa3;
			}
		}
	}
}
