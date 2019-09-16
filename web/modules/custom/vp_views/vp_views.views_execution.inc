<?php

/**
 * @file
 * Executable hooks for Valeo Partners Views.
 */

use Drupal\views\Views;
use Drupal\node\Entity\Node;
use Drupal\views\ViewExecutable;
use Drupal\user\Entity\User;

/**
 * Implements template_views_pre_render().
 */
function vp_views_views_pre_render(ViewExecutable $view) {
  //  kint($view->id());
  switch ($view->id()) {

    // case 'search_by_firm':
    //   // If a year is passed as an argument, change the column lables to
    //   // reference that year.
    //   $view->exposed_data['field_vp_practice_area_2_target_id'] = $view->exposed_data['field_vp_practice_area_1_target_id'];
    //   break;

    case 'search_rate_trending_analysis':
      // Attach javascript.
      $view->element['#attached']['library'][] = 'vp_views/vp_views_library';

      // If a year is passed as an argument, change the column lables to
      // reference that year.
      $year = $view->argument['field_vp_filing_fee_dates_value_year']->argument;
      if ($year) {
        $view->field['field_vp_rate_hourly']->options['label'] = $year . " Rate";
        $view->field['field_vp_rate_previous']->options['label'] = $year - 1 . " Rate";
      }

      // If there is no change from year to year, remove the result.
      $result = [];
      $ids = [];
      foreach ($view->result as $key => $row) {

        $node = $row->_entity;
        $relationship = $row->_relationship_entities['field_vp_rate_individual'];
        $uid = $relationship->id();
        // kint($uid);
        $current = $node->get('field_vp_rate_hourly')->getValue()[0]['value'];
        $previous = $node->get('field_vp_rate_previous')->getValue()[0]['value'];

        if ($current !== $previous && !in_array($uid, $ids)) {
          $result[$key] = $row;
        }
        $ids[] = $uid;
      }

      // Adjust the results, count & pager of the view.
      $view->total_rows = count($result);
      $view->pager->total_items = count($result);
      $view->pager->updatePageInfo();
      $view->result = $result;

      break;
  }
}

/**
 * Implements hook_views_pre_view().
 */
function vp_views_views_pre_view(ViewExecutable $view, $display_id, array &$args) {

  $view_id = $view->id();

  switch ($view_id) {

    case 'saved_search_detail_block':
    case 'saved_search_summary_block':
      /*
       * Set arguments to the view equal to
       * whatever is selected in the saved search node
       * and render that view.
       */

      if ($display_id != 'saved_search_data_export') {
        // Get the current node.
        $node = \Drupal::routeMatch()->getParameter('node');

        if ($node) {

          $firms = [];
          if ($node->get('field_vp_search_firms')) {
            $search_firms = $node->get('field_vp_search_firms')->getValue();
            foreach ($search_firms as $firm) {
              $firms[] = $firm['target_id'];
            }
          }

          $positions = [];
          if ($node->get('field_vp_search_position')) {
            $search_positions = $node->get('field_vp_search_position')->getValue();
            foreach ($search_positions as $position) {
              $positions[] = $position['target_id'];
            }
          }

          $industries = [];
          if ($node->get('field_vp_search_industry')) {
            $search_industries = $node->get('field_vp_search_industry')->getValue();
            foreach ($search_industries as $industry) {
              $industries[] = $industry['target_id'];
            }
          }

          $cities = [];
          if ($node->get('field_vp_search_region_city')) {
            $search_cities = $node->get('field_vp_search_region_city')->getValue();
            foreach ($search_cities as $city) {
              $cities[] = $city['target_id'];
            }
          }

          $practice_areas = [];
          if ($node->get('field_vp_search_practice_area')) {
            $search_practice_areas = $node->get('field_vp_search_practice_area')->getValue();
            foreach ($search_practice_areas as $practice_area) {
              $practice_areas[] = $practice_area['target_id'];
            }
          }

          $grad_date_from = [];
          if ($grad_date_from = $node->get('field_vp_search_grad_date')->getValue()) {
            $grad_date_from = $node->get('field_vp_search_grad_date')->getValue()[0]['from'];
            $grad_date_to = $node->get('field_vp_search_grad_date')->getValue()[0]['to'];
            if (!$grad_date_to) {
              $grad_date_to = $grad_date_from;
            }
            $grad_range = range($grad_date_from, $grad_date_to);
          }

          $partner_date_from = [];
          if ($node->get('field_vp_search_partner_year')->getValue()) {
            $partner_date_from = $node->get('field_vp_search_partner_year')->getValue()[0]['from'];
            $partner_date_to = $node->get('field_vp_search_partner_year')->getValue()[0]['to'];
            if (!$partner_date_to) {
              $partner_date_to = $partner_date_from;
            }
            $partner_range = range($partner_date_from, $partner_date_to);
          }

          $bar_date_from = [];
          if ($node->get('field_vp_search_bar_year')->getValue()) {
            $bar_date_from = $node->get('field_vp_search_bar_year')->getValue()[0]['from'];
            $bar_date_to = $node->get('field_vp_search_bar_year')->getValue()[0]['to'];
            if (!$bar_date_to) {
              $bar_date_to = $bar_date_from;
            }
            $bar_range = range($bar_date_from, $bar_date_to);
          }

          $rate_date_from = [];
          $rate_range = [];
          if ($node->get('field_vp_search_rate_year')->getValue()) {
            $rate_date_from = $node->get('field_vp_search_rate_year')->getValue()[0]['from'];
            $rate_date_to = $node->get('field_vp_search_rate_year')->getValue()[0]['to'];
            if (!$rate_date_to) {
              $rate_date_to = $rate_date_from;
            }
            $rate_range = range($rate_date_from, $rate_date_to);
          }

          $args[0] = $firms ? implode(",", $firms) : 'all';
          $args[1] = $positions ? implode(",", $positions) : 'all';
          $args[2] = $industries ? implode("+", $industries) : 'all';
          $args[3] = $cities ? implode(",", $cities) : 'all';
          $args[4] = $practice_areas ? implode("+", $practice_areas) : 'all';
          $args[5] = $grad_date_from ? implode(",", $grad_range) : 'all';
          $args[6] = $partner_date_from ? implode(",", $partner_range) : 'all';
          $args[7] = $bar_date_from ? implode(",", $bar_range) : 'all';
          $args[8] = $rate_range ? implode("+", $rate_range) : 'all';

          // kint($args);
        }
      }

      break;

    case 'search_rate_trending_analysis':

      /* Submit the ids of the selected items in the user profile
       * as a contextual filter argument for the search_rate_trending_analysis
       * view.
       */

      $firms = [];
      // Get the current user.
      $user = User::load(\Drupal::currentUser()->id());

      // Get the pricing firms from the user profile.
      $pricing_firms = $user->get('field_user_pricing_alert_firms')->getValue();

      // Put the firm IDs into an array.
      foreach ($pricing_firms as $firm) {
        $firms[] = $firm['target_id'];
      }

      // Make a comma-separated list of the firms from the user profile.
      $firm_list = implode(",", $firms);

      // Args 0 is the year.
      // $current_year = date("Y");
      // $args[0] = $current_year;
      // Args 1 is the list of selected firms.
      $args[1] = $firm_list;

      if (!$firms) {
        $args[1] = FALSE;
      }

      break;

    case 'search_rates_by_individual':

      /* Submit the node id as a contextual filter argument.
       */

      // Get the current node.
      $node = Drupal::request()->attributes->get('node');
      // Assign the node id to the contextual filter argument.
      if ($node) {
        $args[0] = $node->id();
      }

      break;

    case 'saved_search_test':
      /*
       * Set arguments to the view equal to
       * whatever is selected in the saved search node
       * and render that view.
       */

      $node = \Drupal::routeMatch()->getParameter('node');

      if ($display_id != 'saved_search_data_export' && $node) {
        // Get the current node.


        $cities = [];
        if ($node->get('field_vp_search_region_city')) {
          $search_cities = $node->get('field_vp_search_region_city')->getValue();
          foreach ($search_cities as $city) {
            $cities[] = $city['target_id'];
          }
        }

        $rate_range = [];
        $rate_date_from = [];
        if ($node->get('field_vp_search_rate_year')->getValue()) {
          $rate_date_from = $node->get('field_vp_search_rate_year')->getValue()[0]['from'];
          $rate_date_to = $node->get('field_vp_search_rate_year')->getValue()[0]['to'];
          if (!$rate_date_to) {
            $rate_date_to = $rate_date_from;
          }
          $rate_range = range($rate_date_from, $rate_date_to);
        }

        $args[0] = $cities ? implode(",", $cities) : 'all';
        $args[1] = $rate_range ? implode("+", $rate_range) : 'all';

        //$args[1] = "1990--2010";
        //$args[8] = "20000101--20100101";
        //$args[8] = $rate_date_from ? implode(",", $rate_range) : 'all';

        //kint($args);
      }

      break;

  }

}
