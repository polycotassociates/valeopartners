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
 *   id = "individual_practice_area_1"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * field_vp_practice_area_1:
 *   plugin: individual_practice_area_1
 *   source: field_individual_pa1
 * @endcode
 *
 */


class IndividualPracticeAreaOne extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Value is nested in an array, value[''], delta['']
    return $value['value'];

  }
}