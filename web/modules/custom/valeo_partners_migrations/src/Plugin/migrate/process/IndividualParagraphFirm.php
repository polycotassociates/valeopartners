<?php

namespace Drupal\valeo_partners_migrations\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Create paragraph types out of group arrays.
 * 
 * @MigrateProcessPlugin(
 *   id = "individual_paragraph_firm"
 * )
 *
 */


class IndividualParagraphFirm extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

   //print_r($value);

    $field_individual_firm = $value[0];
    $field_individual_firmdate = $value[1];
    $field_individual_partnerdate = $value[2];

   // print "firm count " . count($field_individual_firm);

   $nid = $row->getSource()['nid'];
   $node = \Drupal::entityTypeManager()->getStorage("node")->load((int)$nid);


    print_r($node);

    $total_history_items = count($field_individual_firm);

    $field_type_paragraphs = [];
    if (!empty($node->field_paragraphs)) {
      $field_type_paragraphs = $node->field_vp_employment_history->getValue();
    }

    // Loop through all the paragraph types associated with the node.
    foreach ($field_type_paragraphs as $paragraph_source) {
      $target_id = $paragraph_source['target_id'];
      $target_revision_id = $paragraph_source['target_revision_id'];
      $paragraph_data = Paragraph::load($target_id);
      if ($paragraph_data->bundle() == 'entity_reference') {
        $paragraph_data->set('field_firm', $field_individual_firm);
        $paragraph_data->save();
        $is_new = 0;
      }
      // All the existing paragraphs types will be captured.
      // This is done to avoid removal of existing paragraphs types.
      $paragraphs[] = ['target_id' => $target_id, 'target_revision_id' => $target_revision_id];
    }

    // If no text is assigned to node, create a new paragraph.
    if ($is_new) {
      $ppt_values = array(
        'id' => NULL,
        'type' => 'entity_reference',
        'field_firm' => ['value'=> $field_individual_firm],
      );
      $ppt_paragraph = Paragraph::create($ppt_values);
      $ppt_paragraph->save();
      $target_id_dest = $ppt_paragraph->Id();
      $target_revision_id_dest = $ppt_paragraph->getRevisionId();
      $paragraphs[] = array('target_id' => $target_id_dest, 'target_revision_id' => $target_revision_id_dest);
    }

    // for($x; $x<= $total_history_items; $x++) {
    //   // print "---";
    //   // print $field_individual_firm[$x]['nid'];
    //   // print substr($field_individual_firmdate[$x]['value'], 0,4);
    //   // print substr($field_individual_partnerdate[$x]['value'], 0,4);
    //   // print "---";

    //   $paragraph = Paragraph::create([
    //     'type' => 'employment_history',
    //     'field_firm' => ['2'],
    //     'field_firm_date' => [substr($field_individual_firmdate[$x]['value'], 0,4)],
    //     'field_partner_date' => [substr($field_individual_partnerdate[$x]['value'], 0,4)],
    //   ]);
       
    //   $paragraph->save();
       
    //   $node->field_vp_employment_history->appendItem($paragraph);

    // }


    // return $value;
    //$node->save();

// lando drush config-import --partial --source=modules/custom/valeo_partners_migrate/config/install/
  return $paragraphs;
  }
}