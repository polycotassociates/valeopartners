<?php

/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\field\PreviousYearRateForFirm
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
 * @ViewsField("previous_year_rate_for_firm")
 */
class PreviousYearRateForFirm extends FieldPluginBase {

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

    $firm = $relationships['field_vp_rate_firm'];

    if ($node->bundle() == 'vp_type_rate') {

      // Get the node id for the individual
      $individual_nid = $individual->get('nid')->getValue()[0]['value'];

      $firm_nid = $firm->get('nid')->getValue()[0]['value'];

      // Get current year as 4 digit date
      $current_year = format_date(time(), 'custom', 'Y');

      // Get the year from the query string, else use above year
      $year = $current_year - 1;

      // Call getRateByYear method,
      return $this->getRateByYear($year, $firm_nid);

    }
  }


  /**
   * Get the latest rate from a user from last year
   */
  private function getRateByYear($year, $firm_id) {



    // Set the view arguments, the year and individual id
    $args = [$year, $firm_nid];

    // Get the specific view
    $view = Views::getView('search_rates_by_year_firm');

    // Pass the arguments
    $view->setArguments($args);

    // Execute
    $view->execute('rate_firm_year');

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