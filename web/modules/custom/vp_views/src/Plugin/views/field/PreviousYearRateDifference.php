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
 * @ViewsField("vp_views_previous_year_rate_difference")
 */
class PreviousYearRateDifference extends FieldPluginBase {
 
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
    // The rate node
    $node = $values->_entity;
    // Relationships on the rate node
    $relationships = $values->_relationship_entities;
    // Individual relationship
    $individual = $relationships['field_vp_rate_individual'];
    
    if ($node->bundle() == 'vp_type_rate') {


      // Get the node id for the individual
      $individual_nid = $individual->get('nid')->getValue()[0]['value'];

      $rate = "";
      $previous = "";

      // Call getRateByYear method,
      return $this->getPercentDifference($rate, $previous);

    }
  }


  /**
   * Get the latest rate from a user from last year
   */
  private function getPercentDifference($rate, $previous) {


    return "test";

  }

}