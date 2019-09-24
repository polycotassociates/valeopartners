<?php

namespace Drupal\vp_views\Plugin\views\field;

/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\field\HighActualRate.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\node\Entity\Node;

/**
 * Gets the highest rate given a position/rate/firm.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("high_actual_rate")
 */
class HighActualRate extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {

    $bundle = $values->_entity->bundle();

    switch ($bundle) {
      case "vp_type_rate":

        // Get the relationships from the value.
        $relationships = $values->_relationship_entities;
        // Get the position id.
        $position = $values->_entity->field_vp_rate_position->getValue()[0]['target_id'];
        // Get the firm id.
        $firm = $values->_entity->field_vp_rate_firm->getValue()[0]['target_id'];
        // Get the related filing.
        $filing = $relationships['field_vp_rate_filing'];
        // Get the end year from the rate.
        if ($filing) {
          $rate_year = $filing->get('field_vp_filing_year_end')->getValue()[0]['value'];
          // Get the results from the method.
          $results = $this->getHighActualRate($rate_year, $position, $firm);
        }
        else {
          $results = 0;
        }
        break;

    }

    return $results;
  }

  /**
   * Get the low actual rate from a rate year, position and firm.
   */
  private function getHighActualRate($rate_year, $position, $firm) {

    $db = \Drupal::database();

    // Get low actual rate by year/position/firm. Lowest is first result sorted by ASC.

    $query = $db->select('node', 'node')->fields('node');
    $query->join('node__field_vp_rate_hourly', 'hourly', 'node.nid = hourly.entity_id');
    $query->join('node__field_vp_rate_filing', 'filing', 'node.nid = filing.entity_id');
    $query->join('node__field_vp_rate_position', 'position', 'node.nid = position.entity_id');
    $query->join('node__field_vp_rate_firm', 'firm', 'node.nid = firm.entity_id');
    $query->join('node__field_vp_filing_year_end', 'year', 'year.entity_id = filing.field_vp_rate_filing_target_id');
    $query->fields('node', ['nid']);
    $query->fields('hourly', ['field_vp_rate_hourly_value']);
    $query->fields('year', ['field_vp_filing_year_end_value']);
    $query->fields('position', ['field_vp_rate_position_target_id']);
    $query->fields('firm', ['field_vp_rate_firm_target_id']);
    $group = $query->andConditionGroup()
      ->condition('field_vp_filing_year_end_value', $rate_year, '=')
      ->condition('field_vp_rate_position_target_id', $position, '=')
      ->condition('field_vp_rate_firm_target_id', $firm, '=');
    $query->orderBy('field_vp_rate_hourly_value', 'DESC');

    $result = $query->condition($group)->execute()->fetchAll();

    if ($result) {
      $rate = $result[0]->field_vp_rate_hourly_value;
      return $rate;
    }
  }

}
