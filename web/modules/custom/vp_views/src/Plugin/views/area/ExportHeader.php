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

      $node = \Drupal::request()->attributes->get('node');

      if ($node && $node->bundle() == ('vp_type_saved_search')) {
        return ['#markup' => $this->makeLinksForSearch(1)];
      }
      else {
        return ['#markup' => $this->makeLinks()];
      }
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

  /**
   * {@inheritdoc}
   */
  private function makeLinksForSearch($nid) {

    // Get the query from the url.
    $q = $_GET;
    // Build the query from the query variables.
    $query = '?bar_year[0]=2012&bar_year[1]=2013&location[0]=580';
    // $query1 = $this->generateQueryFromNode();
    // Get the current path.
    $path = \Drupal::request()->getpathInfo();
    // Put them together with /export added to the path and format=xls at the end.
    $export_xls = "/saved/search/export?$query&_format=xls";
    // Create the html for the link.
    $export_xls_link = "$query<span id='export-xls-link'><span class='xls-icon'>&nbsp;</span><a href='$export_xls'><img src='/themes/custom/valeo_classic/images/xls-24.png' />Export Results as XLS</a></span>";
    // Return the link.

    // $node = Drupal::request()->attributes->get('node');

    // $firms = FALSE;
    // if ($node->get('field_vp_search_firms')) {
    //   $search_firms = $node->get('field_vp_search_firms')->getValue();
    //   foreach ($search_firms as $firm) {
    //     $firms[] = $firm['target_id'];
    //   }
    // }
    // $firm_query = '';
    // for ($x = 0; $x <= count($firms); $x++) {
    //   $firm_query .= "firm[$x]=" . $firms[$x] . '&';
    // }

    print_r($nid);
    return "$export_xls_link";

  }

  /**
   * {@inheritdoc}
   */
  private function generateQueryFromNode() {

    $node = Drupal::request()->attributes->get('node');

    $firms = FALSE;
    if ($node->get('field_vp_search_firms')) {
      $search_firms = $node->get('field_vp_search_firms')->getValue();
      foreach ($search_firms as $firm) {
        $firms[] = $firm['target_id'];
      }
    }
    $firm_query = '';
    for ($x = 0; $x <= count($firms); $x++) {
      $firm_query .= "firm[$x]=" . $firms[$x] . '&';
    }

    return $firm_query;

  }

}

