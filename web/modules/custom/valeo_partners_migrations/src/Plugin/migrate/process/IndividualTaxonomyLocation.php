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
 *   id = "individual_taxonomy_location"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * field_vp_location‎:
 *   plugin: individual_taxonomy_location
 *   source: field_individual_city
 * @endcode
 *
 */


class IndividualTaxonomyLocation extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
// print_r($row);


    // Value is nested in an array, value[''], delta['']
    return $value['value'];

  }
}