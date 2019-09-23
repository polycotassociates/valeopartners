<?php

namespace Drupal\vp_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

use Drupal\views\Views;

/**
 * Provides a block that renders a view contextually.
 *
 * @Block(
 *   id = "saved_search_view_block",
 *   admin_label = @Translation("Saved Search Block"),
 * )
 */
class SavedSearchViewBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $node = \Drupal::routeMatch()->getParameter('node');

    // 0 = detailed results, 1 = summary results.
    $search_type = $node->get('field_vp_search_type')->getValue()[0]['value'];

    switch ($search_type) {

      case 0:
        $view = Views::getView('saved_search_detail');
        return [
          '#type' => 'view',
          '#name' => 'saved_search_detail',
          '#view' => $view,
          '#display_id' => 'saved_search_detail_block',
          '#embed' => TRUE,
        ];

      case 1:
        $view = Views::getView('saved_search_summary');
        return [
          '#type' => 'view',
          '#name' => 'saved_search_summary',
          '#view' => $view,
          '#display_id' => 'saved_search_summary_page',
          '#embed' => TRUE,
        ];
    }

  }

}
