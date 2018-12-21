<?php
 
/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\field\PreviousYearRate
 */
 
namespace Drupal\vp_views\Plugin\views\field;
 
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\views\Views;
 
/**
 * Field handler to flag the node type.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("previous_year_rate")
 */
class PreviousYearRate extends FieldPluginBase {
 
  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }
 
  /**
   * Define the available options
   * @return array
   */
  // protected function defineOptions() {
  //   // $options = parent::defineOptions();
  //   // // $options['node_type'] = array('default' => 'article');
 
  //   // return $options;
  // }
 
  /**
   * Provide the options form.
   */
  // public function buildOptionsForm(&$form, FormStateInterface $form_state) {
  //   // $types = NodeType::loadMultiple();
  //   // $options = [];
  //   // foreach ($types as $key => $type) {
  //   //   $options[$key] = $type->label();
  //   // }
  //   // $form['node_type'] = array(
  //   //   '#title' => $this->t('Which node type should be flagged?'),
  //   //   '#type' => 'select',
  //   //   '#default_value' => $this->options['node_type'],
  //   //   '#options' => $options,
  //   // );
 
  //   // parent::buildOptionsForm($form, $form_state);
  // }
 
  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    // The rate node
    $node = $values->_entity;
    // Relationships on the rate node
    $relationships = $values->_relationship_entities;
    // Individual relationship
    $individual = $relationships['field_vp_rate_individual'];
    
    if ($node->bundle() == 'vp_type_rate') {

      // Get the node id for the individual
      $individual_nid = $individual->get('nid')->getValue()[0]['value'];

      // Get current year as 4 digit date
      $current_year = format_date(time(), 'custom', 'Y');

      // Get the year from the query string, else use above year
      $year = isset($_GET['year']) ? $_GET['year'] : $current_year;

      // Call getRateByYear method,
      return $this->getRateByYear($year, $individual_nid);

    }
  }


  /**
   * Get the latest rate from a user from last year
   */
  private function getRateByYear($year, $individual_nid) {


    // Get the last year
    $year = $year-1;

    // Set the view arguments, the year and individual id
    $args = [$year, $individual_nid];

    // Get the specific view
    $view = Views::getView('search_rates_by_single_individual');

    // Pass the arguments
    $view->setArguments($args);

    // Execute
    $view->execute();

    // If there are results, return the hourly rate
    if ($view->result) {
      $node = $view->result[0]->_entity;
      $rate = $node->get('field_vp_rate_hourly')->getValue()[0]['value'];
      return $rate;
    }

    // Else, return default value
    return 0;

  }

}