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
 *   id = "contact_phone_import_extension"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * field_vp_contact_phone:
 *   plugin: contact_phone_import_extension
 *   source: field_contact_phone
 * @endcode
 *
 */


class ContactPhoneImportExtension extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    return $value['extension'];

  }

}