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
 *   id = "individual_taxonomy_position"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * field_vp_position:
 *   plugin: individual_taxonomy_position
 *   source: field_individual_city
 * @endcode
 *
 */


class IndividualTaxonomyPosition extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    
    $nid = $row->getSource()['nid'];

    // Switch to external database
    \Drupal\Core\Database\Database::setActiveConnection('reports');

    // Get a connection going
    $db = \Drupal\Core\Database\Database::getConnection();

    $sql='SELECT * 
          FROM term_data 
          AS td 
          INNER JOIN term_node 
          AS tn 
          ON td.tid=tn.tid 
          WHERE tn.nid = :node_id and td.vid=:vocab';

    $params = array(':node_id'=>$nid, ':vocab'=>13);
    $query = $db->query($sql, $params);
    $result = $query->fetchCol();

    print $result[0];
    print "\n";

    // Switch back
    \Drupal\Core\Database\Database::setActiveConnection();

    return $result[0];

  }
}