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
 *   id = "company_taxonomy_industry"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * field_vp_company_industry:
 *   plugin: company_taxonomy_industry
 *   source: field_client_industry
 * @endcode
 *
 */


class CompanyTaxonomyIndustry extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Get the protected property 'field_client_industry' from the row object
    $result = $row->getSourceProperty('field_client_industry');

    // Industry
    $industry = $result[0]['value'];

    // Return that number id as the firm type
    return $industry;

  }
}