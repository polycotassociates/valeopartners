<?php

namespace Drupal\vp_views\Plugin\views\area;

use Drupal\views\Plugin\views\area\AreaPluginBase;

/**
 * Defines a views area plugin.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("print_button")
 */
class PrintButton extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    if (!$empty || !empty($this->options['empty'])) {

      return [
        '#markup' => "<a id='print-this-page'><span>&nbsp;</span><img src='/themes/custom/valeo_classic/images/print_icon.gif'/>&nbsp;</a>",
        '#attached' => [
          'library' => [
            'vp_api/vp_api_libraries',
          ],
        ],
      ];
    }
  }

}
