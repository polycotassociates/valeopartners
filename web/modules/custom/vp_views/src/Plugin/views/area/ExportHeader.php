<?php

namespace Drupal\vp_views\Plugin\views\area;

use Drupal\views\Plugin\views\area\AreaPluginBase;

/**
 * Defines a views area plugin.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("export_header")
 */
class ExportHeader extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    if (!$empty || !empty($this->options['empty'])) {
      return ['#markup' => $this->makeLinks()];
    }
  }

  /**
   * {@inheritdoc}
   */
  private function makeLinks() {

    // Get the query from the url.
    $q = $_GET;
    // Build the query from the query variables.
    $query = http_build_query($q);
    // Get the current path.
    $path = \Drupal::request()->getpathInfo();
    // Put them together with /export added to the path and format=xls at the end.
    $export_xls = "$path/export?$query&_format=xls";
    // Create the html for the link.
    $export_xls_link = "<span id='export-xls-link'><span class='xls-icon'>&nbsp;</span><a href='$export_xls'><img src='/themes/custom/valeo_classic/images/xls-24.png' />Export Results as XLS</a></span>";
    // Return the link.
    return "$export_xls_link";

  }

}
