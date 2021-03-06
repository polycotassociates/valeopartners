<?php

namespace Drupal\vp_views\Plugin\views\area;

use Drupal\views\Plugin\views\area\AreaPluginBase;
use Drupal\node\Entity\Node;

/**
 * Defines a views area plugin.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("export_rate_trending")
 */
class ExportRateTrendingAnalysis extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    if (!$empty || !empty($this->options['empty'])) {

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

  /**
   * {@inheritdoc}
   */
  private function makeLinks() {

    // Only display if the user has the download_add_on role.
    $user = \Drupal::currentUser();
    if (in_array("download_add_on", $user->getRoles()) || in_array("administrator", $user->getRoles()) || in_array("superuser", $user->getRoles())) {
      // Use the view description as the title for the XLS spreadsheet.
      $report_title = $this->view->storage->get('description');

      $export_xls = "/reports/export/rta?report_title=$report_title";
      // Create the html for the link.
      $export_xls_link = "<span id='export-xls-link'><span class='xls-icon'>&nbsp;</span><a href='$export_xls'><img src='/themes/custom/valeo_classic/images/xls-24.png' />Export Results as XLS</a></span>";
      // Get the modal text.
      $modal = $this->xlsModal();
      // Return the link.
      return "$modal $export_xls_link";

    }
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
