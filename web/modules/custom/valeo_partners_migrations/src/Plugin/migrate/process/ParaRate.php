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
  *  id = "para_rate",
  * )
  * *
  * To do create a paragraph type field_vp_employment_history:
  *
  * @code
  * field_vp_employment_history:
  *   plugin: para_rate
  *   source: 
  *   - field_rate_refcompany
  *   - field_rate_refcompattorney
  * @endcode
  *
  */


class ParaRate extends ProcessPluginBase  {
/**
 * {@inheritdoc}
 */
public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {  



  $number_of_companies = count($row->getSourceProperty("field_rate_refcompany"));

  
  if ($number_of_companies > 0) {
    $is_new = 1;
    $paragraphs = [];
    $nid = $row->getSource()['nid'];
    print "Loading ID: $nid\n";
    $node = Node::load($nid);

    $field_type_paragraphs = [];

    if (!empty($node->field_vp_rate_referenced_company	)) {
      $field_type_paragraphs = $node->field_vp_rate_referenced_company->getValue();
    }

    print "Number of companies: $number_of_companies\n";
    // Create new paragraphs for company/attorney
    for ($x=0; $x < $number_of_companies; $x++) {
        $field_company = $row->getSourceProperty("field_rate_refcompany")[$x]["nid"];
        $field_attorney = $row->getSourceProperty("field_rate_refcompattorney")[$x]["nid"];

        if ($field_company) {
            $paragraph_data = [ 'type' => 'referenced_company',
                          'field_attorney' => $field_attorney,
                          'field_company' => $field_company,
                        ];
  
            $paragraph = Paragraph::create($paragraph_data);
            //$paragraph->save();
            $paragraphs[] = ['target_id' => $paragraph->Id(),'target_revision_id' => $paragraph->getRevisionId()];
       
            print "Added paragraph $x to node $nid\n";
        }

    }

    if ($node->field_vp_rate_referenced_company) {
      $node->field_vp_rate_referenced_company = $paragraphs;
      $node->save();
    }

  }

  }
}

