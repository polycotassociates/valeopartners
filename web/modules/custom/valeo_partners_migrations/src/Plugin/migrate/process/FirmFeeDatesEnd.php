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
 *   id = "firm_fee_dates_end"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * field_vp_filing_fee_dates/end_value:
 *   plugin: firm_fee_dates_end
 * @endcode
 *
 */


class FirmFeeDatesEnd extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    $values = $row->getSourceProperty('field_case_feeappdates');

    $end_date = substr($values[0]['value'], 0, 10);

    return $end_date;

  }
}