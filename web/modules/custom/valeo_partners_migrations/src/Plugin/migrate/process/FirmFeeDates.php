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
 *   id = "firm_fee_dates"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * field_vp_filing_fee_dates:
 *   plugin: firm_fee_dates
 *   source: field_case_feeappdates
 * @endcode
 *
 */


class FirmFeeDates extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    $values = $row->getSourceProperty('field_case_feeappdates');

    $start_date = substr($values[0]['value'], 0, 10);

    return $start_date;

  }
}