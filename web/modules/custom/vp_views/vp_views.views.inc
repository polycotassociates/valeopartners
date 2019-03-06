<?php
// $Id$

/**
 * @file
 *   Hooks for Valeo Partners Views
 */
use Drupal\views\Views;
use Drupal\node\Entity\Node;
use Drupal\views\ViewExecutable;
use Drupal\user\Plugin\views\filter\Name;
use Drupal\taxonomy\Entity\Term;

/**
 * Implements hook_views_data().
 */
function vp_views_views_data() {
  $data['views']['export_header'] = array(
    'title' => t('Export Link Header'),
    'help' => t('An area containing links with current arguments.'),
    'area' => array(
      'id' => 'export_header',
    ),
  );
  return $data;
}

/**
 * Implements hook_views_pre_view().
 *
 * Removes columns from the view based on taxonomy selected in node.
 */
function vp_views_views_pre_view($view, $display_id, array &$args) {

  // If this view is saved_search_detail...
  if ($view->id() == 'saved_search_detail') {

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
    }

    // Get the current node.
    $node = Drupal::request()->attributes->get('node');

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

  }
}
