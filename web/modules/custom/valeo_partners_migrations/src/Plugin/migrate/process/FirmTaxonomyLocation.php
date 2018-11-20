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
 *   id = "firm_taxonomy_location"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * vp_location‎:
 *   plugin: firm_taxonomy_location
 *   source: firm_headquarters
 * @endcode
 *
 */


class FirmTaxonomyLocation extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Get the protected property 'field_firm_type' from the row object
    $field_firm_location = $row->getSourceProperty('field_firm_headquarters');

    // Firm headquarters is one of a number of locations
    $firm_location = $field_firm_location[0]['value'];

    // Return that number id as the firm type
    //print "Firm Location ID: $firm_location ";
    return $firm_location;

  }
}