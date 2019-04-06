<?php

/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\field\ActualRateByYear.
 */

namespace Drupal\vp_views\Plugin\views\field;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Field handler show a rate value by given year.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("actual_rate_by_year")
 */
class ActualRateByYear extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  /**
   * Define the available options.
   * @return array
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $year = format_date(time(), 'custom', 'Y');
    $options['year'] = ['default' => $year];
    return $options;
  }

  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    // Get current year as 4 digit date.

    $form['year'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Year'),
      '#description' => $this->t('The 4 digit year for this rate.'),
      '#default_value' => $this->options['year'],

    ];

    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {

    $bundle = $values->_entity->bundle();

    switch ($bundle) {

      case "vp_type_individual":

        // Relationships on the individual node.
        $relationships = $values->_relationship_entities;
        $firm = $relationships['field_vp_employment_history'];
        // Get the individual id.
        $individual_nid = $values->_entity->get('nid')->getValue()[0]['value'];
        // Get the firm id.
        // $firm_nid = $firm->get('field_firm')->getValue()[0]['target_id'];
        // Get the year from the form.
        $year = $this->options['year'];
        // Call getRateByYear method.
        $results = $this->getRateByYear($year, $individual_nid);

        break;

      case "vp_type_rate":

        // Relationships on the individual node.
        $relationships = $values->_relationship_entities;
        $individual = $relationships['field_vp_rate_individual'];
        // Get the node id for the individual.
        $individual_nid = $individual->get('nid')->getValue()[0]['value'];
        // Get the firm id.
        // $firm_nid = $values->_entity->field_vp_rate_firm->getValue()[0]['target_id'];
        // Get the year from the form.
        $year = $this->options['year'];
        // Call getRateByYear method.
        $results = $this->getRateByYear($year, $individual_nid);

        break;

    }

    return $results;
  }

  /**
   * Get the highest hourly rate from an attorney for a particular year.
   */
  private function getRateByYear($year, $individual_nid) {

    $db = \Drupal::database();

    $query = $db->select('node', 'node')->fields('node');
    $query->join('node__field_vp_rate_hourly', 'hourly', 'node.nid = hourly.entity_id');
    $query->join('node__field_vp_rate_filing', 'filing', 'node.nid = filing.entity_id');
    $query->join('node__field_vp_rate_individual', 'individual', 'node.nid = individual.entity_id');
    $query->join('node__field_vp_filing_year_end', 'year', 'year.entity_id = filing.field_vp_rate_filing_target_id');
    $query->fields('node', ['nid']);
    $query->fields('hourly', ['field_vp_rate_hourly_value']);
    $query->fields('year', ['field_vp_filing_year_end_value']);
    $query->fields('individual', ['field_vp_rate_individual_target_id']);
    $group = $query->andConditionGroup()
      ->condition('field_vp_filing_year_end_value', $year, '=')
      ->condition('field_vp_rate_individual_target_id', $individual_nid, '=');
    $query->orderBy('field_vp_rate_hourly_value', 'DESC');
    $query->range(0, 1);
    $result = $query->condition($group)->execute()->fetchAll();

    if ($result) {
      $rate = $result[0]->field_vp_rate_hourly_value;
      return $rate;
    }
  }

}
