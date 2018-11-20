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
 *   id = "individual_practice_area_3"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * vp_location‎:
 *   plugin: individual_practice_area_3
 *   source: field_individual_pa3
 * @endcode
 *
 */


class IndividualPracticeAreaThree extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Value is nested in an array, value[''], delta['']
    return $value['value'];

  }
}