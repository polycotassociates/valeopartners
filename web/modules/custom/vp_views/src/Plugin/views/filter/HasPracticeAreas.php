<?php

namespace Drupal\vp_views\Plugin\views\filter;

/**
 * @file
 * Definition of Drupal\vp_views\Plugin\views\filter\HasPracticeAreas.
 */

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\ViewExecutable;

/**
 * Filters by given list of vocabulary terms (practice area).
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("vp_views_has_practice_areas")
 */
class HasPracticeAreas extends FilterPluginBase {
  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Practice Area filter');
  }

  /**
   * {@inheritdoc}
   */
  public function query() {

    $configuration = [
      'table' => 'node_access',
      'field' => 'nid',
      'left_table' => 'node_field_data',
      'left_field' => 'nid',
      'operator' => '=',
    ];
    $join = Views::pluginManager('join')->createInstance('standard', $configuration);

    $this->query->addRelationship('node_access', $join, 'node_field_data');
    $this->query->addWhere('AND', 'node_access.gid', $domain->getDomainId());
  }

}
