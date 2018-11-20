<?php

namespace Drupal\valeo_partners_migrations\Plugin\migrate\process;

use Drupal\Core\Database\Database;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Maps D7 location values to D8 address values.
 *
 * Example:
 *
 * @code
 * process:
 *   field_address:
 *     plugin: location_to_address
 *     source: field_location
 * @endcode
 *
 * @MigrateProcessPlugin(
 *   id = "location_to_address"
 * )
 */
class LocationToAddress extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // $value is the array containing the lid for this location.
    $lid = $value['lid'];

    // Switch to external database
    \Drupal\Core\Database\Database::setActiveConnection('reports');

    // Get a connection going
    $db = \Drupal\Core\Database\Database::getConnection();

    $location = $db->select('location', 'l')
      ->where('l.lid = ' . $lid)
      ->fields('l', [
        'name',
        'street',
        'additional',
        'city',
        'province',
        'postal_code',
        'country',
      ])
      ->execute()
      ->fetchAssoc();
    $address = [
      'given_name' => '',
      'additional_name' => '',
      'family_name' => '',
      'organization' => $location['name'],
      'address_line1' => $location['street'],
      'address_line2' => $location['additional'],
      'postal_code' => $location['postal_code'],
      'sorting_code' => '',
      'dependent_locality' => '',
      'locality' => $location['city'],
      'administrative_area' => $location['province'],
      'country_code' => strtoupper($location['country']),
    ];

    // Switch back
    \Drupal\Core\Database\Database::setActiveConnection();
    return $address;
  }

}