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
  *  id = "para_firm_2",
  * )
  * *
  * To do create a paragraph type field_stories_text_formatted:
  *
  * @code
  * field_stories_text_formatted:
  *   plugin: para_firm_2
  *   source: 'field_body/0/format'
  * @endcode
  *
  */


class ParaFirm2 extends ProcessPluginBase  {
/**
 * {@inheritdoc}
 */
public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {  

  $number_of_firms = count($row->getSourceProperty("field_individual_firm"));
  $firm = $row->getSourceProperty("field_individual_firm")[0]["nid"];   
  $partner_date = $row->getSourceProperty("field_individual_partnerdate")[0]["value"]; 
  $firm_date = $row->getSourceProperty("field_individual_firmdate")[0]["value"]; 


  $x = 1;
  $firm = $row->getSourceProperty("field_individual_firm")[$x]["nid"];
  $partner_date = $row->getSourceProperty("field_individual_partnerdate")[$x]["value"];
  $firm_date = $row->getSourceProperty("field_individual_firmdate")[$x]["value"];

  // print "Firm ID: $firm, \nPartner Date: $partner_date, \nFirm Date: $firm_date \n";

  $ppt_values = array(
    'type' => 'employment_history',
    'field_firm' => $firm,
    'field_partner_date' => substr($partner_date, 0, 4),
    'field_firm_date' => substr($firm_date, 0, 4),
  );

  $ppt_paragraph = Paragraph::create($ppt_values);
  $ppt_paragraph->save();

  $target_id_dest = $ppt_paragraph->id();
  $target_revision_id_dest = $ppt_paragraph->getRevisionId();

  $paragraphs[] = [ 'entity_id' => $target_id_dest, 'revision_id' => $target_revision_id_dest, ];
    
  return $paragraphs;
  }
}
