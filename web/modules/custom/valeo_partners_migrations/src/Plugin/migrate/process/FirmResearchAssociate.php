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
 *   id = "firm_research_associate"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * 
 * vp_research_associate:
 *   plugin: firm_research_associate
 *   source: firm_ra
 * @endcode
 *
 */


class FirmResearchAssociate extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Get the protected property 'field_firm_ra' from the row object
    $field_firm_ra = $row->getSourceProperty('field_firm_ra');

    // Firm headquarters is one of a number of locations
    $firm_ra = $field_firm_ra[0]['uid'];

    // Return user id
    //print "Firm RA $firm_ra ";
    return $firm_ra;

  }
}