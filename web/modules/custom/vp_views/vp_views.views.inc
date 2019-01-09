<?php
// $Id$

/**
 * @file
 *   Hooks for Valeo Partners Views
 */
use Drupal\views\Views;
use Drupal\node\Entity\Node;


/**
 * Implements template_preprocess_views_view_table().
 */
function vp_views_preprocess_views_view_table(&$variables) {
  // @TODO: You should use $variables['view']->name and $variables['view']->current_display to apply this only one specific view.

  print "<pre>";
  print_r($variables);
  print "</pre>";

  // unset($variables['rows'][0]);
  // unset($variables);
  // Let's assume your field name is node status.
  // Remove header label.
  // print_r($variables['rows']['title']);


  // You can always print_r($variables['rows']) to know what is exact field name that you need to delete.
  // print_r($variables['result']).
  // print_r($variables['header']).
}


// function vp_views_views_query_alter (&$view, &$query) {


// }


/**
 * Implements hook_views_pre_view().
 */
function vp_views_views_pre_view($view, $display_id, array &$args) {
  // if ($view->id() !== 'saved_search_detail') {
  //   return;
  // }

  // print "<pre>";
  // print "FUCK";
  // print($display_id);

  // print "</pre>";

  $view->removeHandler($display_id, 'field', 'title_1');
  $view->removeHandler($display_id, 'field', 'field_vp_rate_position');

  // unset($view->fields['title']);
  // $user_roles = \Drupal::currentUser()->getRoles();
  // if (!in_array('my-special-role', $user_roles)) {
  //   $view->removeHandler($display_id, 'field', 'name');
  // }
}

/**
 * Implements hook_pre_build().
 * @param $variables
 */
function vp_views_views_pre_build($view) {

  $route = \Drupal::routeMatch()->getRouteObject();


  if (!\Drupal::service('router.admin_context')->isAdminRoute($route)){
    unset($view->field['title']);

    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      $nid = $node->id();
    }
  
    print($nid);

  }



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
 * Implements hook_preprocess_views_view_field().
 * @param $variables
 */
function vp_views_preprocess_views_view_field(&$variables) {

  if ($variables['view']->id() == 'search_rate_trending_analysis') {

    if ($variables['field']->realField == 'previous_year_rate') {
      $variables['output'] = '$' . $variables['output'];
    }

    if ($variables['field']->realField == 'field_vp_rate_hourly') {
      $variables['output'] = '$' . $variables['output'];
    }
  }
}

// function vp_views_views_post_render(\Drupal\views\ViewExecutable $view) {
//   if ($view->id() == 'test_search_rates_by_individual') {
//    // Set the view title.
//    $view->setTitle('NEW TITLE');
//   }
// }


/**
 * Implements hook_views_data_alter().
 */
function vp_views_views_data_alter(array &$data) {

    $data['node']['vp_views_previous_year_exists'] = array(
      'title' => t("Previous Rate Exists"),
      'filter' => [
        'title' => t('Previous Rate Exists'),
        'help' => 'Checkt to see if a previous rate exists',
        'field' => 'previous_year_rate',
        'id' => 'equality',
      ]
    );
    
    $data['node']['previous_year_rate'] = array(
        'title' => t("Previous Year's Rate"),
        'category' => 'Valeo Partners',
        'field' => array(
          'title' => t("Previous Year's Rate"),
          'help' => t("The rate from the previous year from a rate object"),
          'id' => 'previous_year_rate',
        ),
      );

    return $data;
  }

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Implements hook_form_FORM_ID_alter().
 */
function vp_views_form_views_exposed_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  
  // ksm ($form['#id']);
  if (isset($form['#id']) && $form['#id'] == 'views-exposed-form-search-rates-by-single-individual-default') {
    
    $options = [
      'all' => t('- All -'),
      '2015' => '2015',
      '2016' => '2016',
      '2017' => '2017',
      '2018' => '2018',
    ];

    $form['edit-year'] = [
      '#title' => new TranslatableMarkup('By year'),
      '#type' => 'select',
      '#options' => $options,
      '#size' => NULL,
      '#default_value' => 'all',
    ];
  }
}




/**
 * Implements hook_form_FORM_ID_alter(); alter views_exposed_form.
 */
function vp_forms_form_views_exposed_form_alter(&$form, &$form_state) {
	if( $form['#id'] == 'views-exposed-form-search-rates-by-single-individual-default') {
    // Switch date formatter to year only
    $form['field_vp_filing_fee_dates']['value']['#date_format'] = 'Y';
    // Add extra validator to handle filter submit
    $form['#validate'][] = 'vp_forms_views_exposed_form_validate';
  }
 
}

function vp_forms_views_exposed_form_validate(&$form, &$form_state) {
	$handlers = &$form_state['view']->filter;

  foreach ($handlers as $key => $handler) {
    if (!empty($handler->options['exposed'])
     && isset($form[$key]['value']['#type'])
     && $form[$key]['value']['#type'] == 'date_select'
     && $form[$key]['value']['#date_format'] == 'Y'){
      $handler->options['granularity'] = 'year';
      $handler->format = 'Y';
    }
  }
}