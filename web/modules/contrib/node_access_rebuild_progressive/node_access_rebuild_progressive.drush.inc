<?php

/**
 * Implements of hook_drush_command().
 */
function node_access_rebuild_progressive_drush_command() {

  $items['node-access-rebuild-progressive'] = array(
    'description' => "Fully rebuild node access.",
    'callback' => 'drush_node_access_rebuild_progressive_rebuild',
  );

  return $items;
}

/**
 * Rebuilds the node access grants table.
 */
function drush_node_access_rebuild_progressive_rebuild() {
  node_access_rebuild_progressive_trigger();
  $batch_def = array(
    'title' => t('Node access rebuild'),
    'operations' => array(
      array('node_access_rebuild_progressive_process_drush', array()),
    ),
    'file' => 'node_access_rebuild_progressive.drush.inc',
    'finished' => 'node_access_rebuild_progressive_finished',
  );

  batch_set($batch_def);
  $batch = & batch_get();
  $batch['progressive'] = FALSE;
  drush_backend_batch_process();
}

function node_access_rebuild_progressive_process_drush(&$context) {
  if (!isset($context['sandbox']['total'])) {
    $context['sandbox']['total'] = 0;
    $context['sandbox']['processed'] = 0;
    $context['sandbox']['nodes'] = db_query("SELECT count(nid) FROM {node}")->fetchField();
  }
  $pass = node_access_rebuild_progressive_process_chunk();
  $context['sandbox']['total'] += $pass['total'];
  $context['sandbox']['processed'] += $pass['processed'];
  $numbers = array(
    '@processed' => $pass['total'],
    '@total' => $pass['processed'],
    '@grand_processed' => $context['sandbox']['processed'],
    '@grand_total' => $context['sandbox']['total'],
    '@nodes' => $context['sandbox']['nodes'],
  );
  $context['finished'] = empty($pass['total']) ? 1 : 0;
  if (!$context['finished']) {
    drush_print(dt('Processed @processed of @total nodes - Total: @grand_processed/@grand_total (@nodes)', $numbers));
  }
}
