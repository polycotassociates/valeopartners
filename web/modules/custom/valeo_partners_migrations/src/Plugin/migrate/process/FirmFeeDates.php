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
    $dates = [];

    print "Value: ";
    print_r($value);

    $values = $row->getSourceProperty('field_case_feeappdates');

    if (count($values)) {
      $dates = ['date_start' => $values[0]['value'], 'date_end' => $values[0]['value2']];
    }


    $date_start = $values[0]['value'];
    print "Date Start: $date_start\n";

    // $dates = [];
    // $start = $row->getSourceProperty('date_start');
    // $end = $row->getSourceProperty('date_end');
    // print "START: $start\n";
    // print "END: $end\n";

    // $dates = ['date_start' => [$start], 'date_end' => [$end]];


    return $date_start;

  }
}