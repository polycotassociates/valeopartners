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
 *   id = "contact_email_import"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * field_vp_contact_email:
 *   plugin: contact_email_import
 *   source: field_contact_email
 * @endcode
 *
 */


class ContactEmailImport extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    return $value['email'];

  }
}