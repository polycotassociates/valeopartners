<?php

namespace Drupal\vp_api\Controller;

/**
 * @file
 * Contains \Drupal\vp_api\Controller\ResaveNodes.
 */

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Component\Utility\Html;

/**
 * Initialize class.
 */
class ResaveNodes extends ControllerBase {
  /**
   * Loads and saves each case node in a batch.
   */

  public function caseRefresh() {

    // Get the Node IDs.
    $ids = $this->getEntityIds('vp_type_case');
    $batch = [
      'title' => t('Refreshing Cases'),
      'operations' => [],
      'finished' => $this->finishedCallback($success, $results),
      'progress_message' => t('Saved @current out of @total nodes.'),
    ];

    foreach ($ids as $nid) {
      $batch['operations'][] = [
        '\Drupal\vp_api\Batch\VpApiBatch::refreshCases',
        [$nid],
      ];
    }

    batch_set($batch);

  }


  /**
   * Callback function.
   */
  private function finishedCallback($success, $results) {

    // The 'success' parameter means no fatal PHP errors were detected. All
    // other error management should be handled using 'results'.
    if ($success) {
      $message = \Drupal::translation()->formatPlural(count($results), 'One post processed.', '@count posts processed.');
    }
    else {
      $message = t('Finished with an error.');
    }
    \Drupal::messenger()->addMessage($message);

    // Providing data for the redirected page is done through $_SESSION.
    foreach ($results as $result) {
      $items[] = t('Loaded node %title.', array(
        '%title' => $result,
      ));
    }
    $_SESSION['my_batch_results'] = $items;
  }

  /**
   * Get the node ids for a particular type.
   */
  private function getEntityIds($type) {
    $bundle = $type;
    $query = \Drupal::entityQuery('node');
    $query->condition('type', $bundle);
    $entity_ids = $query->execute();
    return $entity_ids;
  }

}
