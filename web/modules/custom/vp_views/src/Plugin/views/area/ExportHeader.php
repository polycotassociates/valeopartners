<?php

namespace Drupal\vp_views\Plugin\views\area;

use Drupal\views\Plugin\views\area\AreaPluginBase;
use Drupal\node\Entity\Node;

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

      $node = \Drupal::routeMatch()->getParameter('node');

      if ($node && $node->bundle() == ('vp_type_saved_search')) {
        return [
          '#markup' => $this->makeLinksForSearch($node->id()),
          '#attached' => [
            'library' => [
              'vp_api/vp_api_libraries',
            ],
          ],
        ];
      }
      else {
        return [
          '#markup' => $this->makeLinks(),
          '#attached' => [
            'library' => [
              'vp_api/vp_api_libraries',
            ],
          ],
        ];
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
    $export_xls_link = "<span id='export-xls-link'><span class='xls-icon'>&nbsp;</span><a href='$export_xls'><img src='/themes/custom/valeo_classic/images/xls-24.png' />Export Results as XLS</a><br><i>(First 500 records)</i></span>";
    // Get the modal text.
    $modal = $this->xlsModal();
    // Return the link.
    return "$modal $export_xls_link";

  }

  /**
   * Create a link for the Saved Search content type.
   */
  private function makeLinksForSearch($nid) {

    // Build the query from the saved search items for the node $nid.
    $query = $this->generateQueryFromNode($nid);

    // $query = "firm=12857&";
    // Put them together with /export added to the path and format=xls at the end.
    $export_xls = "/saved/search/export?$query";
    $export_xls .= "_format=xls";
    // Create the html for the link.
    $export_xls_link = "<span id='export-xls-link'><span class='xls-icon'>&nbsp;</span><a href='$export_xls'><img src='/themes/custom/valeo_classic/images/xls-24.png' />Export Results as XLS</a><br><i>(First 500 records)</i></span>";
    // Get the modal text.
    $modal = $this->xlsModal();
    // Return the link.
    return "$modal $export_xls_link";

  }

  /**
   * Create the query string from the saved search node.
   */
  private function generateQueryFromNode($nid) {

    $query = '';
    $node = Node::load($nid);




    $firms = [];
    if ($node->get('field_vp_search_firms')) {
      $search_firms = $node->get('field_vp_search_firms')->getValue();
      foreach ($search_firms as $firm) {
        $firms[] = $firm['target_id'];
      }
    }

    $positions = [];
    if ($node->get('field_vp_search_position')) {
      $search_positions = $node->get('field_vp_search_position')->getValue();
      foreach ($search_positions as $position) {
        $positions[] = $position['target_id'];
      }
    }

    $industries = [];
    if ($node->get('field_vp_search_industry')) {
      $search_industries = $node->get('field_vp_search_industry')->getValue();
      foreach ($search_industries as $industry) {
        $industries[] = $industry['target_id'];
      }
    }

    $cities = [];
    if ($node->get('field_vp_search_region_city')) {
      $search_cities = $node->get('field_vp_search_region_city')->getValue();
      foreach ($search_cities as $city) {
        $cities[] = $city['target_id'];
      }
    }

    $practice_areas = [];
    if ($node->get('field_vp_search_practice_area')) {
      $search_practice_areas = $node->get('field_vp_search_practice_area')->getValue();
      foreach ($search_practice_areas as $practice_area) {
        $practice_areas[] = $practice_area['target_id'];
      }
    }

    $grad_date_from = FALSE;
    $grad_range = [];
    if ($grad_date_from = $node->get('field_vp_search_grad_date')->getValue()) {
      $grad_date_from = $node->get('field_vp_search_grad_date')->getValue()[0]['from'];
      $grad_date_to = $node->get('field_vp_search_grad_date')->getValue()[0]['to'];
      if (!$grad_date_to) {
        $grad_date_to = $grad_date_from;
      }
      $grad_range = range($grad_date_from, $grad_date_to);
    }

    $partner_date_from = FALSE;
    $partner_range = [];
    if ($node->get('field_vp_search_partner_year')->getValue()) {
      $partner_date_from = $node->get('field_vp_search_partner_year')->getValue()[0]['from'];
      $partner_date_to = $node->get('field_vp_search_partner_year')->getValue()[0]['to'];
      if (!$partner_date_to) {
        $partner_date_to = $partner_date_from;
      }
      $partner_range = range($partner_date_from, $partner_date_to);
    }

    $bar_date_from = FALSE;
    if ($node->get('field_vp_search_bar_year')->getValue()) {
      $bar_date_from = $node->get('field_vp_search_bar_year')->getValue()[0]['from'];
      $bar_date_to = $node->get('field_vp_search_bar_year')->getValue()[0]['to'];
      if (!$bar_date_to) {
        $bar_date_to = $bar_date_from;
      }
      $bar_range = range($bar_date_from, $bar_date_to);
    }

    $rate_date_from = FALSE;
    if ($node->get('field_vp_search_rate_year')->getValue()) {
      $rate_date_from = $node->get('field_vp_search_rate_year')->getValue()[0]['from'];
      $rate_date_to = $node->get('field_vp_search_rate_year')->getValue()[0]['to'];
      if (!$rate_date_to) {
        $rate_date_to = $rate_date_from;
      }
      $rate_range = range($rate_date_from, $rate_date_to);
    }

    // Create firms query string.
    // if (count($firms) > 1) {
    //   for ($x = 0; $x < count($firms); $x++) {
    //     $query .= "firm[$x]=" . $firms[$x] . '&';
    //   }
    // }
    // else {
    //   $query .= "firm=" . $firms[0] . '&';
    // }

    // if (count($positions) > 1) {
    //   for ($x = 0; $x < count($positions); $x++) {
    //     $query .= "position[$x]=" . $positions[$x] . '&';
    //   }
    // }
    // else {
    //   $query .= "position=" . $positions[0] . '&';
    // }

    // if (count($industries) > 1) {
    //   for ($x = 0; $x < count($industries); $x++) {
    //     $query .= "industry[$x]=" . $industries[$x] . '&';
    //   }
    // }
    // else {
    //   $query .= "industry=" . $industries[0] . '&';
    // }

    // if (count($cities) > 1) {
    //   for ($x = 0; $x < count($cities); $x++) {
    //     $query .= "location[$x]=" . $cities[$x] . '&';
    //   }
    // }
    // else {
    //   $query .= "location=" . $cities[0] . '&';
    // }

    // if (count($practice_areas) > 1) {
    //   for ($x = 0; $x < count($practice_areas); $x++) {
    //     $query .= "practice_area[$x]=" . $practice_areas[$x] . '&';
    //   }
    // }
    // else {
    //   $query .= "practice_area=" . $practice_areas[0] . '&';
    // }

    $firms_query = $firms ? implode(",", $firms) : 'all';
    $query .= "firm=$firms_query&";

    $positions_query = $positions ? implode(",", $positions) : 'all';
    $query .= "position=$positions_query&";

    $industries_query = $industries ? implode(",", $industries) : 'all';
    $query .= "industry=$industries_query&";

    $cities_query = $cities ? implode(",", $cities) : 'all';
    $query .= "location=$cities_query&";

    // $grad_date_query = $grad_date_from ? implode(",", $grad_range) : 'all';
    // $partner_date_query = $partner_date_from ? implode(",", $partner_range) : 'all';
    // $bar_date_query = $bar_date_from ? implode(",", $bar_range) : 'all';
    // $rate_date_query = $rate_date_from ? implode(",", $rate_range) : 'all';

    // $query .= "graduation_year=$grad_date_query&";
    // $query .= "partner=$partner_date_query&";
    // $query .= "bar_year=$bar_date_query&";
    // $query .= "rate=$rate_date_query&";

    // https://valeopartners.lndo.site/saved/search/export?firm[0]=12857&firm[1]=12858&position=2124&industry=2613&location=580&practice_area=4017&graduation_year=all&partner=all&bar_year=all&_format=xls

    // https://valeopartners.lndo.site/saved/search/export?firm=12857,12858&position=2111&industry=2613&location=580&practice_area=4017&_format=xls


    //https://valeopartners.lndo.site/saved/search/export?firm=12857,12858&position=2111&industry=2613&location=580&&graduation_year=2011+2012+2013&_format=xls
    // field_vp_rate_firm_target_id_verf[0]=257600&field_vp_graduation_value[min]=&field_vp_graduation_value[max]=&field_vp_bar_date_value[min]=&field_vp_bar_date_value[max]=&field_vp_filing_fee_dates_value[min]=&field_vp_filing_fee_dates_value[max]=&_format=xls
    return $query;

  }

  /**
   * Return html text for modal box.
   */
  private function xlsModal() {

    $html = "
<div id='xlsModal' title='Valeo Partners' style='display:none;'>
  <p>
    In accordance with the Valeo Terms of Use, the use of Valeo Data in court or mediation of any kind requires the prior consent of Valeo and a separate fee will be assessed.  Additional Expert Witness fees may also apply.  ​Please contact Chuck Chandler at <a href='mailto:cchandler@valeopartners.com'>cchandler@valeopartners.com</a>
  </p>
</div>
";

    return $html;
  }

}
