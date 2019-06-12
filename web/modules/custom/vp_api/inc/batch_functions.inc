<?php

use Drupal\paragraphs\Entity\Paragraph;
use Drupal\node\Entity\Node;
use Drupal\Core\Database\Database;

/**
 * Batch execution.
 *
 * @param $number
 *   Number of times to execute.
 * @param array $context
 *   An array of contextual key/value information for rebuild batch process.
 */
function _execute_batch($type, array &$context) {

  Database::setActiveConnection('pantheon');
  $database = Database::getConnection();

  switch ($type) {

    case 'vp_type_case':
      $query = $database->query("SELECT nid FROM node WHERE type='vp_type_case'");
      $type_title = "Case";
      break;

    case 'vp_type_filing':
      $query = $database->query("SELECT nid FROM node WHERE type='vp_type_filing'");
      $type_title = "Filing";
      break;

    case 'vp_type_rate':
      $query = $database->query("SELECT nid FROM node WHERE type='vp_type_rate'");
      $type_title = "Rate";
      break;

    case 'vp_type_individual':
      $query = $database->query("SELECT nid FROM node WHERE type='vp_type_individual'");
      $type_title = "Individual";
      $standard_rate_paragraphs = generate_standard_rate_paragraphs();
      $actual_rate_paragraphs = generate_actual_rate_paragraphs();
      break;

  }

  $ids = $query->fetchCol();
  $total = count($ids);
  $counter = 0;


  // Initiate multistep processing.
  if (empty($context['sandbox'])) {
    $context['sandbox']['progress'] = 0;
    $context['sandbox']['max'] = $total;
  }

  $progress = $context['sandbox']['progress'];
  $message = \Drupal::translation()->formatPlural(
    $progress,
    'One node of type ' . $type_title . ' has been saved:', '@count These nodes of type ' . $type_title . ' have been saved:');

  drupal_set_message($message);

  // Process the next 1000 if there are at least 1000 left. Otherwise,
  // we process the remaining number.
  $batch_size = 1000;
  $max = $context['sandbox']['progress'] + $batch_size;
  if ($max > $context['sandbox']['max']) {
    $max = $context['sandbox']['max'];
  }
  // Start where we left off last time.
  $start = $context['sandbox']['progress'];
  for ($i = $start; $i < $max; $i++) {

    switch ($type) {
      case 'vp_type_individual':
        $code = load_and_save_individual($ids[$i], $actual_rate_paragraphs, $standard_rate_paragraphs);
        break;

      default:
        $code = load_and_save($ids[$i]);
    }

    // We want to display the counter 1-based, not 0-based.
    $counter = $i + 1;
    drupal_set_message($counter . '. ' . $code);
    // Update our progress!
    $context['sandbox']['progress']++;
  }
  // Multistep processing : report progress.
  if ($context['sandbox']['progress'] != $context['sandbox']['max']) {
    $context['finished'] = $context['sandbox']['progress'] / $context['sandbox']['max'];
  }

}


/**
 * @return string
 */
function load_and_save($nid) {
  $node = Node::load($nid);
  $node->save();
  return $node->getTitle();
}

/**
 * @return string
 */
function generate_actual_rate_paragraphs() {

  for ($x = 2019; $x >= 2009; $x--) {

    $paragraph_actual_rate_data = [
      'type' => 'actual_rate_by_year',
      'field_paragraph_actual_rate_year' => (string)$x,
      'field_paragraph_actual_rate' => 0,
    ];

    $actual_rate_paragraph = Paragraph::create($paragraph_actual_rate_data);
    $actual_rate_paragraph->save();
    $actual_rate_paragraphs[] = ['target_id' => $actual_rate_paragraph->Id(),'target_revision_id' => $actual_rate_paragraph->getRevisionId()];

  }
  return $actual_rate_paragraphs;
}

/**
 * @return string
 */
function generate_standard_rate_paragraphs() {

  for ($x = 2019; $x >= 2009; $x--) {

    $paragraph_standard_rate_data = [
      'type' => 'standard_rate_by_year',
      'field_paragraph_standard_rate_yr' => (string)$x,
      'field_paragraph_standard_rate' => 0,
    ];

    $standard_rate_paragraph = Paragraph::create($paragraph_standard_rate_data);
    $standard_rate_paragraph->save();
    $standard_rate_paragraphs[] = ['target_id' => $standard_rate_paragraph->Id(),'target_revision_id' => $standard_rate_paragraph->getRevisionId()];

  }
  return $standard_rate_paragraphs;
}


/**
 * @return string
 */
function load_and_save_individual($nid, $actual_rate_paragraphs, $standard_rate_paragraphs) {
  $node = Node::load($nid);
  $node->field_actual_rate_by_year = $actual_rate_paragraphs;
  $node->field_standard_rate_by_year = $standard_rate_paragraphs;
  $node->save();
  return $node->getTitle();
}
