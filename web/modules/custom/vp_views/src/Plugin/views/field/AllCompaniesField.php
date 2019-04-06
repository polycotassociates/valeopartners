<?php

/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\field\AllCompaniesField.
 */

namespace Drupal\vp_views\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\views\Views;

/**
 * Field handler show a rate value by given year.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("all_companies_field")
 */
class AllCompaniesField extends FieldPluginBase {

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
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['all_companies_field'] = ['default' => ''];

    return $options;
  }

  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {

    $types = NodeType::loadMultiple();
    $options = [];
    foreach ($types as $key => $type) {
      $options[$key] = $type->label();
    }

    $options = $this->getAllCompanies();

    $form['all_companies_field'] = array(
      '#title' => $this->t('Select companies'),
      '#type' => 'select',
      '#default_value' => $this->options['all_companies_field'],
      '#options' => $options,
    );
    parent::buildOptionsForm($form, $form_state);

  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {

    // The rate node.
    $node = $values->_entity;


    if ($node->bundle() == 'vp_type_rate') {
      $current_year = format_date(time(), 'custom', 'Y');
      return $node->id();
      //return $current_year - $this->options['actual_rate_year'];
    }
  }

  /**
   * @{inheritdoc}
   */
  private function getAllCompanies() {

    $bundle = 'vp_type_firm';
    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', $bundle);
    $entity_ids = $query->execute();

    $results = [1 => 'one', 2 => 'two'];

    return $results;
  }

}
