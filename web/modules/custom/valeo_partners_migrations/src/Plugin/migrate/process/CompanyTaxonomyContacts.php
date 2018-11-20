<?php

namespace Drupal\valeo_partners_migrations\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;
use Drupal\node\Entity\Node;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\Plugin\MigrationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Perform custom value transformations.
 *
 * @MigrateProcessPlugin(
 *   id = "company_taxonomy_contacts"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * field_vp_company_contact:
 *   plugin: company_taxonomy_contacts
 *   source: field_company_contact
 * @endcode
 *
 */


class CompanyTaxonomyContacts extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Get the protected property 'field_client_industry' from the row object
    $result = $row->getSourceProperty('field_company_contact');

    $contacts = [];
    foreach ($result as $item) {
      $nid = $item['nid'];
      $contacts[] = $nid;
    }

    return $contacts;

  }
}