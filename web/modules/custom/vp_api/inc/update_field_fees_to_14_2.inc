<?php

use Drupal\field\Entity\FieldStorageConfig;


/*
 * Update database fields.
 * see: https://www.drupal.org/project/drupal/issues/2843108#comment-12332317
 */

$fields = [
  'field_vp_rate_primaryfee_calc' => [
    'table' => 'node__field_vp_rate_primaryfee_calc',
    'revision_table' => 'node_revision__field_vp_rate_primaryfee_calc',
  ],
  'field_vp_rate_total_fees' => [
    'table' => 'node__field_vp_rate_total_fees',
    'revision_table' => 'node_revision__field_vp_rate_total_fees',
  ],
];

$database = \Drupal::database();

foreach ($fields as $field_name => $f) {
  $table = $f['table'];
  $revision_table = $f['revision_table'];
  // Entity type here.
  $entity_type = 'node';

  // Step 1: Get field storage.
  $field_storage = FieldStorageConfig::loadByName($entity_type, $field_name);
  // Check if field not found.
  if (is_null($field_storage)) {
    continue;
  }

  // Step 2: Store data.
  $rows = NULL;
  $revision_rows = NULL;
  if ($database->schema()->tableExists($table)) {
    // The table data to restore after the update is completed.
    $rows = $database->select($table, 'n')->fields('n')->execute()
      ->fetchAll();
    $revision_rows = $database->select($revision_table, 'n')
      ->fields('n')
      ->execute()
      ->fetchAll();
  }

  // Step 3: Empty the tables.
  db_truncate($table)->execute();
  db_truncate($revision_table)->execute();

  // Step 4: Update the storage config.
  $field_storage->set('settings', ['precision' => 14, 'scale' => 2]);
  $field_storage->save();

  // Step 5: Restore existing data in fields & revision tables.
  if (!is_null($rows)) {
    foreach ($rows as $row) {
      $row = (array) $row;
      try {
        $database->insert($table)->fields($row)->execute();
      }
      catch (Exception $exception) {
        watchdog_exception('vp_api', $exception);
      }
    }
  }
  if (!is_null($revision_rows)) {
    foreach ($revision_rows as $row) {
      $row = (array) $row;
      try {
        $database->insert($revision_table)->fields($row)->execute();
      }
      catch (Exception $exception) {
        watchdog_exception('vp_api', $exception);
      }
    }
  }
}
