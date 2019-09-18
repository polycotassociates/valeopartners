<?php

namespace Drupal\vp_forms\Controller;

/**
 * @file
 * Contains \Drupal\vp_forms\Controller\RateTrendingReport.
 */

use Drupal\user\Entity\User;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Settings;

/**
 * Initialize class.
 */
class RateTrendingReport extends ControllerBase {

  /**
   * Export a report using phpSpreadsheet.
   */
  public function export() {

    // Get current user.
    $user = User::load(\Drupal::currentUser()->id());
    $selected_firms_references = $user->get('field_user_pricing_alert_firms')->referencedEntities();
    $nids = [];
    foreach ($selected_firms_references as $reference) {
      $nids[] = $reference->id();
    }

    kint($this->generateDynamicQuery($nids));
    die();

    $response = new Response();
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');
    $response->headers->set('Content-Type', 'application/vnd.ms-excel');
    $response->headers->set('Content-Disposition', "attachment; filename=Rate_Trending_Analysis.xlsx");

    $spreadsheet = new Spreadsheet();

    //Set metadata.
    $spreadsheet->getProperties()
      ->setCreator('Valeo Partners')
      ->setLastModifiedBy('Valeo Partners')
      ->setTitle("Rates by Firm")
      ->setDescription('Rates by Firm')
      ->setSubject('Valeo Partners Rates By Firm')
      ->setKeywords('Valeo Rates')
      ->setCategory('legal');

    // Get the active sheet.
    $spreadsheet->setActiveSheetIndex(0);
    $worksheet = $spreadsheet->getActiveSheet();

    //Rename sheet
    $worksheet->setTitle('Valeo Reports');

    $worksheet->getCell('A1')->setValue('Firm');
    $worksheet->getCell('B1')->setValue('Individual');
    $worksheet->getCell('C1')->setValue('Position');
    $worksheet->getCell('D1')->setValue('Practice Area 1');
    $worksheet->getCell('E1')->setValue('Practice Area 2');
    $worksheet->getCell('F1')->setValue('Practice Area 3');
    $worksheet->getCell('G1')->setValue('City');
    $worksheet->getCell('H1')->setValue('Former Rate');
    $worksheet->getCell('I1')->setValue('New Rate');
    $worksheet->getCell('J1')->setValue('Percent Change');

    $spreadsheet->getActiveSheet()->freezePane('A2');

    //Set style Head
    $styleArrayHead = array(
      'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'ffffff'),
      ));

    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(TRUE);
    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(TRUE);

    $i = 2;
    // Query loop.
    foreach ($this->generateDynamicQuery($nids) as $result) {
      // Firm.
      $worksheet->setCellValue('A' . $i, '' . $this->getNodeTitle($result->field_vp_rate_firm_target_id));
      // Individual.
      $worksheet->setCellValue('B' . $i, $result->field_vp_last_name_value . ', ' . $result->field_vp_first_name_value . ' ' . $result->field_vp_middle_name_value);
      // Position.
      $worksheet->setCellValue('C' . $i, '' . $this->getTermName($result->field_vp_rate_position_target_id));
      // Practice Area 1.
      $worksheet->setCellValue('D' . $i, '' . $this->getTermName($result->field_vp_practice_area_1_target_id));
      // Practice Area 2.
      $worksheet->setCellValue('E' . $i, '' . $this->getTermName($result->field_vp_practice_area_2_target_id));
      // Practice Area 3.
      $worksheet->setCellValue('F' . $i, '' . $this->getTermName($result->field_vp_practice_area_3_target_id));
      // Grad Year.
      $worksheet->setCellValue('G' . $i, $result->field_vp_graduation_value);
      // 2018 Rate.
      $worksheet->setCellValue('H' . $i, $result->field_2018_actual_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2019 Rate.
      $worksheet->setCellValue('I' . $i, $result->field_2019_actual_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

      // Rate of Change.
      $worksheet->setCellValue('I' . $i, $this->percentChange($result->field_2018_actual_rate_value, $result->field_2019_actual_rate_value) . '%');

      $i++;

    }

    // Get the writer and export in memory.
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    ob_start();
    $writer->save('php://output');
    $content = ob_get_clean();

    // Memory cleanup.
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);

    $response->setContent($content);
    return $response;
  }

  /**
   * Generate the Dyamic Query based on GET variables.
   */
  public function generateDynamicQuery($ids) {

    // Connect to the database.
    $db = \Drupal::database();
    $db->query("SET SESSION sql_mode = ''")->execute();

    // Query node data.
    $query = $db->select('node_field_data', 'node');
    $query->fields('node', ['nid', 'type', 'status']);
    $query->condition('node.type', 'vp_type_rate', '=');
    $query->condition('node.status', 1);

    // Join Firm, Filing, Individual, Case to Rate.
    $query->join('node__field_vp_rate_firm', 'firm', 'node.nid = firm.entity_id');
    $query->join('node__field_vp_rate_individual', 'individual', 'node.nid = individual.entity_id');
    $query->join('node__field_vp_rate_filing', 'filing', 'node.nid = filing.entity_id');
    $query->join('node__field_vp_filing_case', 'filing_case', 'filing_case.entity_id = filing.field_vp_rate_filing_target_id');

    // Joins for fields to query upon.
    $query->leftjoin('node__field_vp_rate_position', 'position', 'node.nid = position.entity_id');

    // Individual Joins.
    $query->leftjoin('node__field_vp_individual_location', 'location', 'location.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_first_name', 'fname', 'fname.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_middle_name', 'mname', 'mname.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_last_name', 'lname', 'lname.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_practice_area_1', 'pa1', 'pa1.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_practice_area_2', 'pa2', 'pa2.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_practice_area_3', 'pa3', 'pa3.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_graduation', 'grad_year', 'grad_year.entity_id = individual.field_vp_rate_individual_target_id');

    // Rate values.
    $query->leftjoin('node__field_2018_actual_rate', 'rate_2018', 'node.nid = rate_2018.entity_id');
    $query->leftjoin('node__field_2019_actual_rate', 'rate_2019', 'node.nid = rate_2019.entity_id');

    // Filing, Case, Company, Individual, and Firm fields.
    $query->fields('firm', ['field_vp_rate_firm_target_id']);
    $query->fields('filing', ['field_vp_rate_filing_target_id']);
    $query->fields('filing_case', ['field_vp_filing_case_target_id']);
    $query->fields('individual', ['field_vp_rate_individual_target_id']);

    // Individual Fields.
    $query->fields('fname', ['field_vp_first_name_value']);
    $query->fields('mname', ['field_vp_middle_name_value']);
    $query->fields('lname', ['field_vp_last_name_value']);
    $query->fields('location', ['field_vp_individual_location_target_id']);
    $query->fields('pa1', ['field_vp_practice_area_1_target_id']);
    $query->fields('pa2', ['field_vp_practice_area_2_target_id']);
    $query->fields('pa3', ['field_vp_practice_area_3_target_id']);
    $query->fields('position', ['field_vp_rate_position_target_id']);
    $query->fields('grad_year', ['field_vp_graduation_value']);

    // Fee fields.
    $query->fields('rate_2018', ['field_2018_actual_rate_value']);
    $query->fields('rate_2019', ['field_2019_actual_rate_value']);

    // Get only selected ids.
    $query->condition('firm.field_vp_rate_firm_target_id', $ids, 'IN');

    // Maximum 50,000 records.
    $query->range(0, 50000);

    // Order by Transaction Amount Rate.
    $query->orderBy('lname.field_vp_last_name_value', 'ASC')->orderBy('firm.entity_id', 'ASC');

    return $query->execute()->fetchAll();

  }

  /**
   * Percent change between two rates.
   */
  private function percentChange($previous, $current) {

    if ($previous != NULL) {
      $difference = $current - $previous;
      $rate = $difference / $current * 100;
      return $rate;
    }
  }

  /**
   * Get Node Title Query.
   */
  private function getNodeTitle($id) {
    $query = db_select('node_field_data', 'node');
    $query->condition('node.nid', $id, '=');
    $query->fields('node', ['title']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Term Name Query.
   */
  private function getTermName($id) {
    $query = db_select('taxonomy_term_field_data', 'term');
    $query->condition('term.tid', $id, '=');
    $query->fields('term', ['name']);
    return $query->execute()->fetchField();
  }

}
