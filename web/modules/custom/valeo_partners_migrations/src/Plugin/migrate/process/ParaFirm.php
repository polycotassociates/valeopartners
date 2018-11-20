<?php

namespace Drupal\valeo_partners_migrations\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

/**
  * Provides a 'MmNodeBlogBodyToParagraph' migrate process plugin.
  *
  * @MigrateProcessPlugin(
  *  id = "para_firm",
  * )
  * *
  * To do create a paragraph type field_stories_text_formatted:
  *
  * @code
  * field_stories_text_formatted:
  *   plugin: para_firm
  *   source: 'field_body/0/format'
  * @endcode
  *
  */


class ParaFirm extends ProcessPluginBase  {
/**
 * {@inheritdoc}
 */
public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {  

  $is_new = 1;
  $paragraphs = [];
  $number_of_firms = count($row->getSourceProperty("field_individual_firm"));
  $nid = $row->getSource()['nid'];

  if ($number_of_firms > 0) {
      $node = Node::load($nid);
  }

  $field_type_paragraphs = [];

  if (!empty($node->field_vp_employment_history)) {
    $field_type_paragraphs = $node->field_vp_employment_history->getValue();
  }


  // Loop through all the paragraph types associated with the node.
  // foreach ($field_type_paragraphs as $paragraph_source) {

  //   $target_id_dest = $paragraph_source['target_id'];
  //   $target_revision_id_dest = $paragraph_source['target_revision_id'];
  //   $paragraph_data = Paragraph::load($target_id_dest);

  //   // print_r($paragraph_data);

  //   if ($paragraph_data->bundle() == 'employment_history') {
  //     $paragraph_data->set('field_firm', [$firm]);
  //     $paragraph_data->set('field_partner_date', substr($partner_date, 0, 4));
  //     $paragraph_data->set('field_firm_date', substr($firm_date, 0, 4));
  //     $paragraph_data->save();
  //     $is_new = 0;
  //   }
  //   // All the existing paragraphs types will be captured.
  //   // This is done to avoid removal of existing paragraphs types.
  //   $paragraphs[] = array('target_id' => $target_id_dest, 'target_revision_id' => $target_revision_id_dest);
  //   $node->field_vp_employment_history = array(
  //     array(
  //       'target_id' => $target_id_dest,
  //       'target_revision_id' => $target_revision_id_dest,
  //     )
  //   );
  //   $node->save();
  // }


    // Create new paragraphs for employment history
    for ($x=0; $x < $number_of_firms; $x++) {

      $firm = $row->getSourceProperty("field_individual_firm")[$x]["nid"];
      $partner_date = $row->getSourceProperty("field_individual_partnerdate")[$x]["value"];
      $firm_date = $row->getSourceProperty("field_individual_firmdate")[$x]["value"];

      $paragraph_data = [ 'type' => 'employment_history',
                          'field_firm' => $firm,
                          'field_partner_date' => $partner_date,
                          'field_firm_date' => $firm_date,
                        ];
  
      $paragraph = Paragraph::create($paragraph_data);
      $paragraph->save();
      $paragraphs[] = ['target_id' => $paragraph->Id(),'target_revision_id' => $paragraph->getRevisionId()];

    }

    if ($node->field_vp_employment_history) {
      $node->field_vp_employment_history = $paragraphs;
      $node->save();
    }

    print "Processed node: $nid\n";

  }
}

