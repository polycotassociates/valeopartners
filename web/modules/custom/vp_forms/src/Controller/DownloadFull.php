<?php

namespace Drupal\vp_forms\Controller;

/**
 * @file
 * Contains \Drupal\vp_forms\Controller\DownloadFull.
 */

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Initialize class.
 */
class DownloadFull extends ControllerBase {

  /**
   * Download the private full database xls.
   */
  public function downloadFullXls() {

    $user = \Drupal::currentUser();
    if (in_array("download_add_on", $user->getRoles()) || in_array("administrator", $user->getRoles()) || in_array("superuser", $user->getRoles())) {

      $uri = 'private://reports/Valeo_Full_Report.xlsx';

      $headers = [
        'Content-Type' => 'application/vnd.ms-excel',
        'Content-Description' => 'File Download',
        'Content-Disposition' => 'attachment;filename=Valeo_Full_Report.xlsx',
      ];

      // Return and trigger file donwload.
      return new BinaryFileResponse($uri, 200, $headers, TRUE);
    }

  }

}
