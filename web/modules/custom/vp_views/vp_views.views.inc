<?php
// $Id$

/**
 * @file
 *   Hooks for Valeo Partners Views
 */
use Drupal\views\Views;
use Drupal\node\Entity\Node;
use Drupal\views\ViewExecutable;

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
 * Implements hook_pre_build().
 * @param $variables
 */
function vp_views_views_pre_build($view) {


  // $route = \Drupal::routeMatch()->getRouteObject();
  // if (!\Drupal::service('router.admin_context')->isAdminRoute($route)) {

  //   // unset($view->field['title']);

  //   print "Pre build in .inc";
  //   print "<pre>";
  //   print "view_id: " . $view->id();
  //   print " - view_current_display: " . $view->current_display;
  //   print "</pre>";

  // }



  // if ($view->name == 'saved_search_detail'
  //     && $view->current_display == 'saved_search_detail_page') {

  //       $node = menu_get_object();

  //       \Drupal::service()->getPath();


  //   // // You'll have your own list of fields to remove that you create somehow...
  //   // $fields_to_remove = array('field_name_to_remove_1','field_name_to_remove_2');

  //   // foreach ($fields_to_remove as $field_name) {
  //   //   unset($view->field[$field_name]);            
  //   //   unset($view->display_handler->handlers['field'][$field_name]);  
  //   // }
  // }
}

/**
 * implements hook_views_post_execute($view)
 */

function vp_views_views_post_execute($view) {

  // print "post execute in .inc";



  // $route = \Drupal::routeMatch()->getRouteObject();

  // if (!\Drupal::service('router.admin_context')->isAdminRoute($route)) {

  //   print "Post Execute In INC";
  // // print "<pre>";
  // // print_r($variables);
  // // print "</pre>";
  //   // $view->removeHandler($display_id, 'field', 'title_1');

  // }

}



/**
 * Implements hook_views_pre_render().
 */
function vp_views_views_pre_render(ViewExecutable $view) {
  // if ($view->id() !== 'saved_search_detail') {
  //   return;
  // }


  // print "<pre>";
  // print_r($view);
  // print "</pre>";
  // dpm($view);
  //$view->header['area']->options['content']['value'] = t('My custom header text');
  // $view->removeHandler($display_id, 'field', 'title_1');
  // $view->removeHandler($display_id, 'field', 'field_vp_rate_position');

  // unset($view->fields['title']);
  // $user_roles = \Drupal::currentUser()->getRoles();
  // if (!in_array('my-special-role', $user_roles)) {
  //   $view->removeHandler($display_id, 'field', 'name');
  // }
}

//view_id: search_by_firm - view_current_display: master_search_by_firm_page

//view_id: my_saved_searches - view_current_display: block_1

function vp_views_views_pre_view(ViewExecutable $view, $display_id, array &$args) {
    // $options = array(
    //   'id' => 'area_text_custom',
    //   'table' => 'views',
    //   'field' => 'area_text_custom',
    //   'relationship' => 'none',
    //   'group_type' => 'none',
    //   'admin_label' => '',
    //   'empty' => TRUE,
    //   'tokenize' => FALSE,
    //   'content' => 'Footer content is great.',
    //   'plugin_id' => 'text_custom',
    // );
    // $view->setHandler('view_display', 'footer', 'area_text_custom', $options);
}