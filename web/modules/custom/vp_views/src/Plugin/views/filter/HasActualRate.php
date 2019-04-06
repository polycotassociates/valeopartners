<?php

/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\filter\HasActualRate.
 */

namespace Drupal\vp_views\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\StringFilter;
use Drupal\views\ViewExecutable;

/**
 * Filters if a field has an actual rate.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("has_actual_rate")
 */
class HasActualRate extends StringFilter {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
  }

  /**
   * Override the query so that no filtering takes place if the user doesn't
   *  select any options.
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


  public function addWhere($group, $field, $value = NULL, $operator = NULL) {
    // Ensure all variants of 0 are actually 0. Thus '', 0 and NULL are all
    // the default group.
    if (empty($group)) {
      $group = 0;
    }
    // Check for a group.
    if (!isset($this->where[$group])) {
      $this->setWhereGroup('AND', $group);
    }
    $this->where[$group]['conditions'][] = [
      'field' => 'field_vp_rate_hourly_value',
      'value' => NULL,
      'operator' => '=',
    ];
  }


  /**
   * {@inheritdoc}
   */
  // public function execute(ViewExecutable $view) {
  //   // Clip ...
  //   if (isset($this->where)) {
  //     foreach ($this->where as $where_group => $where) {
  //       foreach ($where['conditions'] as $condition) {
  //         // Remove dot from beginning of the string.
  //         $field_name = ltrim($condition['field'], '.');
  //         $filters[$field_name] = $condition['value'];
  //       }
  //     }
  //   }
  //   // We currently only support uid, ignore any other filters that may be
  //   // configured.
  //   $uid = isset($filters['uid']) ? $filters['uid'] : NULL;
  //   if ($access_tokens = $this->fitbitAccessTokenManager->loadMultipleAccessToken([$uid])) {
  //     // Query remote API and return results ...
  //   }
  // }

}