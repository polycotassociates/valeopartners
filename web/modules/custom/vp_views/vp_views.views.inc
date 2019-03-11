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
use Drupal\user\Entity\User;

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
 * Implements hook_views_pre_execute().
 */
function vp_views_views_pre_execute(ViewExecutable $view) {


}

// /**
//  * Implements hook_views_pre_execute().
//  */
// function vp_views_views_pre_execute($view) {

//   $view_id = $view->id();
//   switch ($view_id) {

//     case 'saved_search_detail':

//       // If this view is saved_search_detail,
//       // Remove columns from the view based on taxonomy selected in node.
//       $term_data = [];
//       $display_term_data = [];

//       // Get the vocabulary name.
//       $vid = 'search_columns';

//       // Use the entity manager to load that taxonomy tree.
//       $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);

//       // Loop through the terms, load each object to get the field
//       // field_search_column_key and add it to an array.
//       foreach ($terms as $term) {
//         $term_object = Term::load($term->tid);
//         $term_data[] = $term_object->field_search_column_key->value;
//         $term_data[] = $term_object->field_search_column_key->value;
//       }

//       // Get the current node.
//       $node = Drupal::request()->attributes->get('node');

//       // Get the display term taxonomy referenced entities.
//       $display_terms_entities = $node->get('field_vp_search_display_columns')->referencedEntities();

//       // Loop through the entities referred in the node and assign those values
//       // to an array.
//       foreach ($display_terms_entities as $term) {
//         $display_term_object = Term::load($term->id());
//         $display_term_data[] = $display_term_object->field_search_column_key->value;
//       }

//       // The columns to view are the difference between the two arrays.
//       $view_columns = array_diff($term_data, $display_term_data);

//       $view_filters = $view->display_handler->get_option('filters');

//       // ...
//       // $views_filters contains an array of all filters, modify as needed.
//       // ...

//       $view->display_handler->override_option('filters', $view_filters);

//       $filters = $view->getExposedInput();
//       // Sort by title if there are no keywords or user sort.
//       if (empty($filters['keys']) && empty($filters['sort_by'])) {
//         $filters['sort_by'] = 'title';
//         $view->setExposedInput($filters);
//       }

//       // Loop through each column in the difference array and remove it.
//       foreach ($view_columns as $v) {
//         if (in_array($v, $view_columns)) {
//           $view->removeHandler(NULL, 'field', $v);
//         }
//       }
//       break;
//   }
// }

// /**
//  * Implements hook_ENTITY_TYPE_presave().
//  */
// function vp_views_node_presave(EntityInterface $entity) {
//   $bundle = $entity->bundle();
//   if ($bundle == 'vp_type_saved_search') {
//     // Check if a bulletin updated has a new year, and invalidate the
//     // options cached used in the custom views filter for filtering by year.
//     $cid = 'vp_views:saved_search:field_vp_search_bar_year';
//     $data = \Drupal::cache()->get($cid);
//     if ($data) {
//       $options = $data->data;
//       $date = $entity->field_date->value;
//       if ($date) {
//         $date = new DrupalDateTime($date, new DateTimeZone('UTC'));
//         $year = $date->format('Y');
//         if (!isset($options[$year])) {
//           Cache::invalidateTags(['node:saved_search:field_vp_search_bar_year']);
//         }
//       }
//     }
//   }
// }
