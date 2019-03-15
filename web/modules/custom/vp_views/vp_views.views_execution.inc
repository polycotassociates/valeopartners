<?php

/**
 * @file
 * Executable hooks for Valeo Partners Views.
 */

use Drupal\views\Views;
use Drupal\node\Entity\Node;
use Drupal\views\ViewExecutable;
use Drupal\user\Plugin\views\filter\Name;
use Drupal\taxonomy\Entity\Term;
use Drupal\user\Entity\User;

/**
 * Implements hook_views_pre_view().
 */
function vp_views_views_pre_view(ViewExecutable $view, $display_id, array &$args) {

  $view_id = $view->id();

  switch ($view_id) {

    case 'saved_search_detail':

      // Get the current node.
      $node = Drupal::request()->attributes->get('node');

      $firms = FALSE;
      if ($node->get('field_vp_search_firms')) {
        $search_firms = $node->get('field_vp_search_firms')->getValue();
        foreach ($search_firms as $firm) {
          $firms[] = $firm['target_id'];
        }
      }

      $positions = FALSE;
      if ($node->get('field_vp_search_position')) {
        $search_positions = $node->get('field_vp_search_position')->getValue();
        foreach ($search_positions as $position) {
          $positions[] = $position['target_id'];
        }
      }

      $industries = FALSE;
      if ($node->get('field_vp_search_industry')) {
        $search_industries = $node->get('field_vp_search_industry')->getValue();
        foreach ($search_industries as $industry) {
          $industries[] = $industry['target_id'];
        }
      }

      $cities = FALSE;
      if ($node->get('field_vp_search_region_city')) {
        $search_cities = $node->get('field_vp_search_region_city')->getValue();
        foreach ($search_cities as $city) {
          $cities[] = $city['target_id'];
        }
      }

      $practice_areas = FALSE;
      if ($node->get('field_vp_search_practice_area')) {
        $search_practice_areas = $node->get('field_vp_search_practice_area')->getValue();
        foreach ($search_practice_areas as $practice_area) {
          $practice_areas[] = $practice_area['target_id'];
        }
      }

      $grad_date_from = FALSE;
      if ($grad_date_from = $node->get('field_vp_search_grad_date')->getValue()) {
        $grad_date_from = $node->get('field_vp_search_grad_date')->getValue()[0]['from'];
        $grad_date_to = $node->get('field_vp_search_grad_date')->getValue()[0]['to'];
        if (!$grad_date_to) {
          $grad_date_to = $grad_date_from;
        }
        $grad_range = range($grad_date_from, $grad_date_to);
      }

      $partner_date_from = FALSE;
      if ($node->get('field_vp_search_partner_year')->getValue()) {
        $partner_date_from = $node->get('field_vp_search_partner_year')->getValue()[0]['from'];
        $partner_date_to = $node->get('field_vp_search_partner_year')->getValue()[0]['to'];
        if (!$partner_date_to) {
          $partner_date_to = $partner_date_from;
        }
        $partner_range = range($partner_date_from, $partner_date_to);
      }

      $bar_date_from = FALSE;
      if ($node->get('field_vp_search_bar_year')->getValue()) {
        $bar_date_from = $node->get('field_vp_search_bar_year')->getValue()[0]['from'];
        $bar_date_to = $node->get('field_vp_search_bar_year')->getValue()[0]['to'];
        if (!$bar_date_to) {
          $bar_date_to = $bar_date_from;
        }
        $bar_range = range($bar_date_from, $bar_date_to);
      }

      $rate_date_from = FALSE;
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
      $args[2] = $industries ? implode(",", $industries) : 'all';
      $args[3] = $cities ? implode("+", $cities) : 'all';
      $args[4] = $practice_areas ? implode("+", $practice_areas) : 'all';
      $args[5] = $grad_date_from ? implode(",", $grad_range) : 'all';
      $args[6] = $partner_date_from ? implode(",", $partner_range) : 'all';
      $args[7] = $bar_date_from ? implode(",", $bar_range) : 'all';
      //$args[8] = "1990--2010";
      //$args[8] = "20000101--20100101";
     // $args[8] = $rate_date_from ? implode(",", $rate_range) : 'all';
      // $args[8] = $rate_date_from ? implode(',', $rate_range) : 'all';

      // // If this view is saved_search_detail,
      // // Remove columns from the view based on taxonomy selected in node.
      $term_data = [];
      $display_term_data = [];

      // Get the vocabulary name.
      $vid = 'search_columns';

      // Use the entity manager to load that taxonomy tree.
      $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);

      // Loop through the terms, load each object to get the field
      // field_search_column_key and add it to an array.
      foreach ($terms as $term) {
        $term_object = Term::load($term->tid);
        $term_data[] = $term_object->field_search_column_key->value;
        $term_data[] = $term_object->field_search_column_key->value;
      }

      // Get the display term taxonomy referenced entities.
      $display_terms_entities = $node->get('field_vp_search_display_columns')->referencedEntities();

      // Loop through the entities referred in the node and assign those values
      // to an array.
      foreach ($display_terms_entities as $term) {
        $display_term_object = Term::load($term->id());
        $display_term_data[] = $display_term_object->field_search_column_key->value;
      }

      // The columns to view are the difference between the two arrays.
      $view_columns = array_diff($term_data, $display_term_data);

      // Loop through each column in the difference array and remove it.
      foreach ($view_columns as $v) {
        if (in_array($v, $view_columns)) {
          $view->removeHandler($display_id, 'field', $v);
        }
      }
      break;

    case 'search_rate_trending_analysis':

      /* Submit the ids of the selected items in the user profile
       * as a contextual filter argument for the search_rate_trending_analysis
       * view.
       */

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
  }

}
