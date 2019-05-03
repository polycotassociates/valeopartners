<?php

namespace Drupal\vp_views\Plugin\views\field;

/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\field\PracticeAreas.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Field handler that returns the practice areas in one field.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("practice_areas")
 */
class PracticeAreas extends FieldPluginBase {

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
    return $options;
  }

  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {

    $bundle = $values->_entity->bundle();

    switch ($bundle) {

      case "vp_type_individual":

        // Get the practice area term ids.
        $practice_area_1_tid = $individual->get('field_vp_practice_area_1')->getValue()[0]['target_id'];
        $practice_area_2_tid = $individual->get('field_vp_practice_area_2')->getValue()[0]['target_id'];
        $practice_area_3_tid = $individual->get('field_vp_practice_area_3')->getValue()[0]['target_id'];

        // Get the terms.
        $term1 = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($practice_area_1_tid);
        $term2 = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($practice_area_2_tid);
        $term3 = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($practice_area_3_tid);

        // Get the names of the terms.
        $practice_area_1 = $term1 ? $term1->getName() : "";
        $practice_area_2 = $term2 ? $term2->getName() : "";
        $practice_area_3 = $term3 ? $term3->getName() : "";

        // Create a string of terms.
        $results = "$practice_area_1 $practice_area_2 $practice_area_3";

        break;

      case "vp_type_rate":

        // Relationships on the individual node.
        $relationships = $values->_relationship_entities;
        $individual = $relationships['field_vp_rate_individual'];
        // Get the practice area term ids.
        $practice_area_1_tid = $individual->get('field_vp_practice_area_1')->getValue()[0]['target_id'];
        $practice_area_2_tid = $individual->get('field_vp_practice_area_2')->getValue()[0]['target_id'];
        $practice_area_3_tid = $individual->get('field_vp_practice_area_3')->getValue()[0]['target_id'];

        // Get the terms.
        $term1 = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($practice_area_1_tid);
        $term2 = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($practice_area_2_tid);
        $term3 = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($practice_area_3_tid);

        // Get the names of the terms.
        $practice_area_1 = $term1 ? $term1->getName() : "";
        $practice_area_2 = $term2 ? $term2->getName() : "";
        $practice_area_3 = $term3 ? $term3->getName() : "";

        // Create a string of terms.
        $results = "$practice_area_1 $practice_area_2 $practice_area_3";

        break;

    }

    return $results;
  }

}
