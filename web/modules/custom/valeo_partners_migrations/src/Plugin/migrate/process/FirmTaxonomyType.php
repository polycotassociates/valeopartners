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
 *   id = "firm_taxonomy_type"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * field_vp_firm_type:
 *   plugin: firm_taxonomy_type
 *   source: field_firm_type
 * @endcode
 *
 */


class FirmTaxonomyType extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Get the protected property 'field_firm_type' from the row object
    $field_firm_type = $row->getSourceProperty('field_firm_type');

    // Firm type is one of Law Firm (91) or Consulting Firm (92)
    $firm_type = $field_firm_type[0]['value'];

    // Return that number id as the firm type
    return $firm_type;

  }
}