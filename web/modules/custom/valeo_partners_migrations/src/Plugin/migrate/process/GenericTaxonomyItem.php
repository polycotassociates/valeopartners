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
 *   id = "generic_taxonomy_item"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * my_field:
 *   plugin: generic_taxonomy_item
 *   source: my_source
 * @endcode
 *
 */


class GenericTaxonomyItem extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Value is nested in an array, value[''], delta['']
    return $value['value'];

  }
}