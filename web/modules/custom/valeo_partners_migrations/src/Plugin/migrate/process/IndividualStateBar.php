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
 *   id = "individual_state_bar"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * field_vp_state_bar:
 *   plugin: individual_state_bar
 *   source: field_individual_statebar
 * @endcode
 *
 */


class IndividualStateBar extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Value is nested in an array, value[''], delta['']
    return $value['value'];

  }
}