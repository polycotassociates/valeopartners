<?php

namespace Drupal\valeo_partners_migrations\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Process date range fields.
 * from https://www.drupal.org/files/issues/datetime_range-migrate-process-2813539-7.patch
 *
 * @MigrateProcessPlugin(
 *   id = "daterange",
 *   handle_multiples = TRUE
 * )
 *
 * @todo Support no end date.
 * @todo Account for field definition configurations.
 * @todo Account for variations of date format.
 */
class DateRangeProcess extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   *
   * Processes start and end times into a datetime range field.
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    
    
    print_r($value);



    if (!is_array($value)) {
      throw new MigrateException(sprintf('%s is not an array', var_export($value, TRUE)));
    }

    if (empty($value[0]) || empty($value[1])) {
      throw new MigrateException(sprintf('%s does not have two elements in the array', var_export($value, TRUE)));
    }

    $date_format = 'Y-m-d';
    $start_date = new \DateTime($value[0]);
    $end_date = new \DateTime($value[1]);

    return [
      'value' => $start_date->format($date_format),
      'end_value' => $end_date->format($date_format),
    ];
  }

}