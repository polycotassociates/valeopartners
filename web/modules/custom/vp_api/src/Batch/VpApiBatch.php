<?php

namespace Drupal\vp_api\Batch;

/**
 * @file
 * Contains \Drupal\vp_api\Batch\VpApiBatch.
 */

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Component\Utility\Html;

/**
 * Initialize class.
 */
class VpApiBatch {
  /**
   * Methods for batch processing.
   */

  /**
   * Peforms the saving on each case.
   */
  public static function refreshCases($operations = [], &$context) {

    foreach ($operations as $nid) {
      $node = Node::load($nid);
      $node->save();

      $context['message'] = "Migrated node $nid<br/>\n" . $context['message'];
    }
  }

}
