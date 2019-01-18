<?php

/**
 * A plugin to add some header export-to-xls links to a view
 */

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
      return array(
        '#markup' => $this->make_links(),
      );
    }

    return array();
  }


  private function make_links(){

    // Get the query from the url
    $q = $_GET;
    // Build the query from the query variables
    $query = http_build_query($q);
    // Get the current path
    $path = \Drupal::request()->getpathInfo();
    //Put them together with /export added to the path and format=xls at the end
    $export_xls = "$path/export?$query&_format=xls";
    $export_csv = "$path/export?$query&_format=csv";
    // html for link
    // $export_xls_link = "<span id='export-xls-link'><span class='xls-icon'>&nbsp;</span><a href='$export_xls'><img src='/themes/custom/valeo_classic/images/xls-24.png' />Export XLS</a></span>";
    $export_csv_link = "<span id='export-csv-link'><span class='csv-icon'>&nbsp;</span><a href='$export_csv'><img src='/themes/custom/valeo_classic/images/csv-24.png' />Export CSV</a></span>";

    // return link
    return "$export_csv_link $export_xls_link";

    
  }
}