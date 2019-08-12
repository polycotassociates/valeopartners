<?php

/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\filter\HasActualRate.
 */

namespace Drupal\vp_views\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\ViewExecutable;

/**
 * Filters to see if an individual has a rate for a year.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("has_actual_rate_by_year")
 */
class HasActualRateByYear extends InOperator {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Year');
    $this->definition['options callback'] = array($this, 'generateOptions');
  }


  /**
   * Override the query so that no filtering takes place if the user doesn't
   * select any options.
   */
  public function query() {
    if (!empty($this->value)) {
      parent::query();
    }
  }

  /**
   * Skip validation if no options have been chosen so we can use it as a
   * non-filter.
   */
  public function validate() {
    if (!empty($this->value)) {
      parent::validate();
    }
  }

  /**
   * Helper function that generates the options.
   * @return array
   */
  public function generateOptions() {
    // Array keys are used to compare with the table field values.
    return array(
      '2019' => '2019',
      '2018' => '2018',
    );
  }

}
