<?php

namespace Drupal\valeo_partners_migrations\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;


/**
 * Perform custom value transformations.
 *
 * @MigrateProcessPlugin(
 *   id = "search_bar_year_to"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * my_field:
 *   plugin: search_bar_year_to
 *   source: my_source
 * @endcode
 *
 */


class SearchBarYearTo extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    $values = $row->getSourceProperty('field_search_baryear');

    $start_date = substr($values[0]['value2'], 0, 4);

    return $start_date;
  }
}