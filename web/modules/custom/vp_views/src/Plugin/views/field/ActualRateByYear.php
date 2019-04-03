<?php

/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\field\ActualRateByYear.
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
   * Define the available options
   * @return array
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $current_year = format_date(time(), 'custom', 'Y');
    $options['actual_rate_year'] = ['default' => $current_year];

    return $options;
  }

  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {

    $form['actual_rate_year'] = [
      '#title' => $this->t('Year for this rate'),
      '#type' => 'text',
      '#required' => TRUE,
      '#default_value' => $this->options['text_css_content'],
    ];
    parent::buildOptionsForm($form, $form_state);

  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {

    // The rate node.
    $node = $values->_entity;

    if ($node->bundle() == 'vp_type_rate') {

      // Get Year's Actual Rate.
      $actual_rate = '9999';

      return $actual_rate;

    }
  }

}
