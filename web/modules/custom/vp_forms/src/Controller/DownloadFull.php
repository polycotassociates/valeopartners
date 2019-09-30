<?php

namespace Drupal\vp_forms\Controller;

/**
 * @file
 * Contains \Drupal\vp_forms\Controller\DownloadFull.
 */

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


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

      // Make sure 'reports' subdirectory exists.
      $path = 'private://reports';
      file_prepare_directory($path, FILE_CREATE_DIRECTORY);

      // Get real path to private directory.
      $private = \Drupal::service('file_system')->realpath("private://");

      // Delete the previous xlsx export.
      if (file_exists($uri)) {
        $headers = [
          'Content-Type' => 'application/vnd.ms-excel',
          'Content-Description' => 'File Download',
          'Content-Disposition' => 'attachment;filename=Valeo_Full_Report.xlsx',
        ];

        // Return and trigger file donwload.
        return new BinaryFileResponse($uri, 200, $headers, TRUE);
      }
      else {
        throw new NotFoundHttpException();
      }

    }
    else {
      throw new AccessDeniedHttpException();
    }

  }

}
