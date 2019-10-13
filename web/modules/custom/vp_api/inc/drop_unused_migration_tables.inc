<?php

// Get table list
$result = db_query("SHOW TABLES LIKE :table", [':table' => 'migrate_%']);
// Init drop counter
$count = 0;
// Iterate and drop matched table
foreach ($result as $row) {
  // Get table name from row data
  $data = array_values((array)$row);
  $table_name = $data[0];
  // Validate table name again
  if (strpos($table_name, 'migrate_') === 0) {
    // Drop the table
    db_drop_table($table_name);
    // Increment drop counter
    $count++;
    // Log dropped table
    \Drupal::logger('my_module')->info('Dropped table: @table', ['@table' => $table_name]);
  }
}
// Log total dropped table count
\Drupal::logger('my_module')->info('Dropped @count migration tables', ['@count' => $count]);


// Get table list
$result = db_query("SHOW TABLES LIKE :table", [':table' => 'vw_%']);
// Init drop counter
$count = 0;
// Iterate and drop matched table
foreach ($result as $row) {
  // Get table name from row data
  $data = array_values((array)$row);
  $table_name = $data[0];
  // Validate table name again
  if (strpos($table_name, 'vw_') === 0) {
    // Drop the table
    db_drop_table($table_name);
    // Increment drop counter
    $count++;
    // Log dropped table
    \Drupal::logger('my_module')->info('Dropped table: @table', ['@table' => $table_name]);
  }
}
// Log total dropped table count
\Drupal::logger('my_module')->info('Dropped @count extra tables', ['@count' => $count]);