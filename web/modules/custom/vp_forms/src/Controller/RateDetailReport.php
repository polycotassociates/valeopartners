<?php

namespace Drupal\vp_forms\Controller;

/**
 * @file
 * Contains \Drupal\vp_forms\Controller\RateDetailReport.
 */

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Settings;
use Cache\Adapter\Redis\RedisCachePool;
use Cache\Bridge\SimpleCache\SimpleCacheBridge;


use Cache\Adapter\Apcu\ApcuCachePool;

/**
 * Initialize class.
 */
class RateDetailReport extends ControllerBase {
  /**
   * Runs query based on $_GET string.
   */

  private function uniqueObjectList($objects) {

    $keys = [];
    foreach ($objects as $key => $obj) {

      if (in_array($obj->nid, $keys)) {
        unset($objects[$key]);
      }
      $keys[] = $obj->nid;
    }

    kint(array_unique($keys));
    return $objects;
  }

  /**
   * Export a report using phpSpreadsheet
   */
  public function export() {

    $client = new \Redis();
    $client->connect('cache', 6379);
    $pool = new RedisCachePool($client);
    $simpleCache = new SimpleCacheBridge($pool);

    Settings::setCache($simpleCache);

    // print_r($this->getFirstName('100825'));
    // print "<br>";
    //kint($_GET);
  //kint($this->uniqueObjectList($this->generateDynamicQuery()));

    // kint($this->getFirmName('257600'));

    // Generate and output code will be inserted here.

    //$response->setContent($content);
    $response = new Response();
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');
    $response->headers->set('Content-Type', 'application/vnd.ms-excel');
    $response->headers->set('Content-Disposition', 'attachment; filename=Fates_By_Firm_Detail.xlsx');

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
    $worksheet->setTitle('Rates by Firm - Detail');

    /*
    * TITLE
    */
    //Set style Title
    $styleArrayTitle = array(
      'font' => array(
        'bold' => true,
        'color' => array('rgb' => '161617'),
        'size' => 12,
        'name' => 'Verdana'
      ));

    $worksheet->getCell('A1')->setValue('Last Name');
    $worksheet->getCell('B1')->setValue('Middle Name');
    $worksheet->getCell('C1')->setValue('First Name');
    $worksheet->getCell('D1')->setValue('Firm');
    $worksheet->getCell('E1')->setValue('Position');
    $worksheet->getCell('F1')->setValue('Client Represented');
    $worksheet->getCell('G1')->setValue('Industry');
    $worksheet->getCell('H1')->setValue('Practice Area 1');
    $worksheet->getCell('I1')->setValue('Practice Area 2');
    $worksheet->getCell('J1')->setValue('Practice Area 3');
    $worksheet->getCell('K1')->setValue('Grad Year');
    $worksheet->getCell('L1')->setValue('Bar Year');
    $worksheet->getCell('M1')->setValue('Bar State');
    $worksheet->getCell('N1')->setValue('City');
    $worksheet->getCell('O1')->setValue('Actual Rate');
    $worksheet->getCell('P1')->setValue('Standard Rate');
    $worksheet->getCell('Q1')->setValue('Hours');
    $worksheet->getCell('R1')->setValue('Total');
    $worksheet->getCell('S1')->setValue('Flat Fee');
    $worksheet->getCell('T1')->setValue('Retainer Fee');
    $worksheet->getCell('U1')->setValue('Transaction Amount');
    $worksheet->getCell('V1')->setValue('Transactional Fee');
    $worksheet->getCell('W1')->setValue('Transaction Type');
    $worksheet->getCell('X1')->setValue('Case Name');
    $worksheet->getCell('Y1')->setValue('Case Number');
    $worksheet->getCell('Z1')->setValue('Court');
    $worksheet->getCell('AA1')->setValue('Date Filed');
    $worksheet->getCell('AB1')->setValue('Nature of Suit');
    $worksheet->getCell('AC1')->setValue('Filing Name');
    $worksheet->getCell('AD1')->setValue('Filing Description');
    $worksheet->getCell('AE1')->setValue('Filing Number');
    $worksheet->getCell('AF1')->setValue('Fee Date Range Begin');
    $worksheet->getCell('AG1')->setValue('Fee Date Range End');
    $spreadsheet->getActiveSheet()->freezePane('A2');


    // $worksheet->getStyle('A1')->applyFromArray($styleArrayTitle);

    /*
     * HEADER
     */
    //Set Background
    $worksheet->getStyle('A3:E3')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('085efd');

    //Set style Head
    $styleArrayHead = array(
      'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'ffffff'),
      ));

    // $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('W')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(TRUE);
    // $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(TRUE);

    $worksheet->getStyle('A3:E3')->applyFromArray($styleArrayHead);

    $i = 2;
    // Query loop.
    foreach ($this->generateDynamicQuery() as $result) {
      if ($result->field_vp_rate_hourly_value > 0) {
        // Last Name.
        $worksheet->setCellValue('A' . $i, '' . $this->getLastName($result->field_vp_rate_individual_target_id));
        // Middle Name.
        $worksheet->setCellValue('B' . $i, '' . $this->getMiddleName($result->field_vp_rate_individual_target_id));
        // First Name.
        $worksheet->setCellValue('C' . $i, '' . $this->getFirstName($result->field_vp_rate_individual_target_id));
        // Firm.
        $worksheet->setCellValue('D' . $i, '' . $this->getNodeTitle($result->field_vp_rate_firm_target_id));
        // Position.
        $worksheet->setCellValue('E' . $i, '' . $this->getTermName($result->field_vp_rate_position_target_id));
        // Client Name.
        $worksheet->setCellValue('F' . $i, '' . $this->getNodeTitle($result->field_vp_rate_company_target_id));
        // Industry.
        $worksheet->setCellValue('G' . $i, '' . $this->getTermName($result->field_vp_company_industry_target_id));
        // Practice Area 1.
        $worksheet->setCellValue('H' . $i, '' . $this->getTermName($result->field_vp_practice_area_1_target_id));
        // Practice Area 2.
        $worksheet->setCellValue('I' . $i, '' . $this->getTermName($result->field_vp_practice_area_2_target_id));
        // Practice Area 3.
        $worksheet->setCellValue('J' . $i, '' . $this->getTermName($result->field_vp_practice_area_3_target_id));
        // Grad Year.
        $worksheet->setCellValue('K' . $i, $result->field_vp_graduation_value);
        // Bar Year.
        $worksheet->setCellValue('L' . $i, $result->field_vp_bar_date_value);
        // Bar State.
        $worksheet->setCellValue('M' . $i, '' . $this->getTermName($result->field_vp_state_bar_target_id));
        // City.
        $worksheet->setCellValue('N' . $i, '' . $this->getTermName($result->field_vp_individual_location_target_id));
        // Actual Rate.
        $worksheet->setCellValue('O' . $i, $result->field_vp_rate_hourly_value);
        $spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        // Standard Rate.
        $worksheet->setCellValue('P' . $i, $result->field_vp_rate_standard_value);
        $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        // Hours.
        $worksheet->setCellValue('Q' . $i, $result->field_vp_rate_hours_value);
        // Total.
        $worksheet->setCellValue('R' . $i, $result->field_vp_rate_total_value);
        $spreadsheet->getActiveSheet()->getStyle('R' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        // Flat Fee.
        $worksheet->setCellValue('S' . $i, $result->field_vp_rate_flat_fee_value);
        $spreadsheet->getActiveSheet()->getStyle('S' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        // Retainer Fee.
        $worksheet->setCellValue('T' . $i, $result->field_vp_rate_retainer_value);
        $spreadsheet->getActiveSheet()->getStyle('T' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        // Transaction Amount.
        $worksheet->setCellValue('U' . $i, $result->field_vp_rate_transaction_amount_value);
        $spreadsheet->getActiveSheet()->getStyle('U' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        // Transactional Fee.
        $worksheet->setCellValue('V' . $i, $result->field_vp_rate_transactional_fee_value);
        $spreadsheet->getActiveSheet()->getStyle('V' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        // Transaction Type.
        $worksheet->setCellValue('W' . $i, '' . $this->getTermName($result->field_vp_rate_transaction_type_target_id));
        // Case Name.
        $worksheet->setCellValue('X' . $i, '' . $this->getNodeTitle($result->field_vp_filing_case_target_id));
        // Case Number.
        $worksheet->setCellValue('Y' . $i, '' . $this->getCaseNumber($result->field_vp_filing_case_target_id));
        // Court.
        $worksheet->setCellValue('Z' . $i, '' . $this->getCaseCourt($result->field_vp_filing_case_target_id));
        // Date Filed.
        $worksheet->setCellValue('AA' . $i, $this->getFilingDate($result->field_vp_filing_case_target_id));
        $spreadsheet->getActiveSheet()->getStyle('AA' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        // Nature of Suit.
        $worksheet->setCellValue('AB' . $i, '' . $this->getNatureOfSuit($result->field_vp_filing_case_target_id));
        // Filing Name.
        $worksheet->setCellValue('AC' . $i, '' . $this->getNodeTitle($result->field_vp_rate_filing_target_id));
        // Filing Description.
        $worksheet->setCellValue('AD' . $i, '' . $this->getFilingDescription($result->field_vp_rate_filing_target_id));
        // Filing Number.
        $worksheet->setCellValue('AE' . $i, '' . $this->getFilingNumber($result->field_vp_rate_filing_target_id));
        // Fee Date Range Begin.
        $worksheet->setCellValue('AF' . $i, $this->getFeeDateBegin($result->field_vp_rate_filing_target_id));
        $spreadsheet->getActiveSheet()->getStyle('AF' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        // Fee Date Range End.
        $worksheet->setCellValue('AG' . $i, $this->getFeeDateEnd($result->field_vp_rate_filing_target_id));
        $spreadsheet->getActiveSheet()->getStyle('AG' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

        $i++;
      }
    }

    // for ($i = 4; $i < 10; $i++) {
    //   $worksheet->setCellValue('A' . $i, $i);
    //   $worksheet->setCellValue('B' . $i, 'Test C2');
    //   $worksheet->setCellValue('C' . $i, 'Test C3');
    // }

    // // This inserts the SUM() formula with some styling.
    // $worksheet->setCellValue('A10', '=SUM(A4:A9)');
    // $worksheet->getStyle('A10')
    //   ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    // $worksheet->getStyle('A10')
    //   ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);

    // // This inserts the formula as text.
    // $worksheet->setCellValueExplicit(
    //   'A11',
    //   '=SUM(A4:A9)',
    //   DataType::TYPE_STRING
    // );

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
  public function generateDynamicQuery() {

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
    $query->join('node__field_vp_rate_company', 'company', 'node.nid = company.entity_id');
    $query->join('node__field_vp_rate_individual', 'individual', 'node.nid = individual.entity_id');
    $query->join('node__field_vp_rate_filing', 'filing', 'node.nid = filing.entity_id');
    $query->join('node__field_vp_filing_case', 'filing_case', 'filing_case.entity_id = filing.field_vp_rate_filing_target_id');

    // Joins for fields to query upon.
    $query->leftjoin('node__field_vp_rate_position', 'position', 'node.nid = position.entity_id');
    $query->leftjoin('node__field_vp_case_nature_of_suit', 'nature_of_suit', 'nature_of_suit.entity_id = filing_case.field_vp_filing_case_target_id');
    $query->leftjoin('node__field_vp_company_industry', 'industry', 'industry.entity_id = company.field_vp_rate_company_target_id');

    // Individual Joins.
    $query->leftjoin('node__field_vp_first_name', 'fname', 'fname.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_middle_name', 'mname', 'mname.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_last_name', 'lname', 'lname.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_bar_date', 'bar_year', 'bar_year.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_state_bar', 'bar_state', 'bar_state.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_practice_area_1', 'pa1', 'pa1.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_practice_area_2', 'pa2', 'pa2.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_practice_area_3', 'pa3', 'pa3.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_graduation', 'grad_year', 'grad_year.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_individual_location', 'location', 'location.entity_id = individual.field_vp_rate_individual_target_id');

    // Rate values.
    $query->leftjoin('node__field_vp_rate_standard', 'standard', 'node.nid = standard.entity_id');
    $query->leftjoin('node__field_vp_rate_hourly', 'actual', 'node.nid = actual.entity_id');
    $query->leftjoin('node__field_vp_rate_total', 'rate_total', 'node.nid = rate_total.entity_id');
    $query->leftjoin('node__field_vp_rate_flat_fee', 'flat_fee', 'node.nid = flat_fee.entity_id');
    $query->leftjoin('node__field_vp_rate_hours', 'hours', 'node.nid = hours.entity_id');
    $query->leftjoin('node__field_vp_rate_retainer', 'retainer', 'node.nid = retainer.entity_id');
    $query->leftjoin('node__field_vp_rate_transaction_amount', 'transaction_amount', 'node.nid = transaction_amount.entity_id');
    $query->leftjoin('node__field_vp_rate_transactional_fee', 'transaction_fee', 'node.nid = transaction_fee.entity_id');
    $query->leftjoin('node__field_vp_rate_transaction_type', 'transaction_type', 'node.nid = transaction_type.entity_id');
    $query->leftjoin('node__field_vp_filing_year_end', 'year', 'year.entity_id = filing.field_vp_rate_filing_target_id');

    // Filing, Case, Company, Individual, and Firm fields.
    $query->fields('firm', ['field_vp_rate_firm_target_id']);
    $query->fields('filing', ['field_vp_rate_filing_target_id']);
    $query->fields('filing_case', ['field_vp_filing_case_target_id']);
    $query->fields('company', ['field_vp_rate_company_target_id']);
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
    $query->fields('bar_year', ['field_vp_bar_date_value']);
    $query->fields('bar_state', ['field_vp_state_bar_target_id']);
    $query->fields('grad_year', ['field_vp_graduation_value']);

    // Fee fields.
    $query->fields('standard', ['field_vp_rate_standard_value']);
    $query->fields('actual', ['field_vp_rate_hourly_value']);
    $query->fields('rate_total', ['field_vp_rate_total_value']);
    $query->fields('flat_fee', ['field_vp_rate_flat_fee_value']);
    $query->fields('retainer', ['field_vp_rate_retainer_value']);
    $query->fields('hours', ['field_vp_rate_hours_value']);
    $query->fields('transaction_amount', ['field_vp_rate_transaction_amount_value']);
    $query->fields('transaction_fee', ['field_vp_rate_transactional_fee_value']);
    $query->fields('transaction_type', ['field_vp_rate_transaction_type_target_id']);
    $query->fields('year', ['field_vp_filing_year_end_value']);

    // Case/Filing Fields
    $query->fields('nature_of_suit', ['field_vp_case_nature_of_suit_target_id']);
    $query->fields('industry', ['field_vp_company_industry_target_id']);

    // Only if there's an actual rate.
    //$query->condition('actual.field_vp_rate_hourly_value', 0, '>');

    // Filter by Rate Year.
    if (isset($_GET['field_vp_filing_fee_dates_value']['min']) && $_GET['field_vp_filing_fee_dates_value']['min'] != '') {
      $query->condition('field_vp_filing_year_end_value', [$_GET['field_vp_filing_fee_dates_value']['min'], $_GET['field_vp_filing_fee_dates_value']['max']], 'BETWEEN');
    }

    // Filter by Bar Date.
    if (isset($_GET['field_vp_bar_date_value']['min']) && $_GET['field_vp_bar_date_value']['min'] != '') {
      $query->condition('field_vp_bar_date_value', [$_GET['field_vp_bar_date_value']['min'], $_GET['field_vp_bar_date_value']['max']], 'BETWEEN');
    }

    // Filter by Grad Date.
    if (isset($_GET['field_vp_graduation_value']['min']) && $_GET['field_vp_graduation_value']['min'] != '') {
      $query->condition('field_vp_graduation_value', [$_GET['field_vp_graduation_value']['min'], $_GET['field_vp_graduation_value']['max']], 'BETWEEN');
    }

    // Filter by firm ids.
    if (isset($_GET['field_vp_rate_firm_target_id_verf'])) {
      $query->condition('field_vp_rate_firm_target_id', $_GET['field_vp_rate_firm_target_id_verf'], 'IN');
    }

    // Filter by location ids.
    if (isset($_GET['term_node_tid_depth'])) {
      $query->condition('field_vp_individual_location_target_id', $_GET['term_node_tid_depth'], 'IN');
    }

    // Filter by position ids.
    if (isset($_GET['term_node_tid_depth_position'])) {
      $query->condition('field_vp_rate_position_target_id', $_GET['term_node_tid_depth_position'], 'IN');
    }

    // Filter by nature of suit ids.
    if (isset($_GET['field_vp_case_nature_of_suit_target_id_verf'])) {
      $query->condition('field_vp_case_nature_of_suit_target_id', $_GET['field_vp_case_nature_of_suit_target_id_verf'], 'IN');
    }

    // Filter by practice area ids.
    if (isset($_GET['field_vp_practice_area_1_target_id'])) {
      $group = $query->orConditionGroup()
        ->condition('field_vp_practice_area_1_target_id', $_GET['field_vp_practice_area_1_target_id'], 'IN')
        ->condition('field_vp_practice_area_2_target_id', $_GET['field_vp_practice_area_1_target_id'], 'IN')
        ->condition('field_vp_practice_area_3_target_id', $_GET['field_vp_practice_area_1_target_id'], 'IN');
      $query->condition($group);
    }

    // Maximum 50,000 records.
    $query->range(0, 50000);

    // Order by Actual Rate.
    $query->orderBy('actual.field_vp_rate_hourly_value', 'DESC');
    return $query->execute()->fetchAll();

  }

  /**
   * Get First Name Query.
   */
  private function getFirstName($id) {
    $query = db_select('node__field_vp_first_name', 'first_name');
    $query->condition('first_name.entity_id', $id, '=');
    $query->fields('first_name', ['field_vp_first_name_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Middle Name Query.
   */
  private function getMiddleName($id) {
    $query = db_select('node__field_vp_middle_name', 'middle_name');
    $query->condition('middle_name.entity_id', $id, '=');
    $query->fields('middle_name', ['field_vp_middle_name_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Last Name Query.
   */
  private function getLastName($id) {
    $query = db_select('node__field_vp_last_name', 'last_name');
    $query->condition('last_name.entity_id', $id, '=');
    $query->fields('last_name', ['field_vp_last_name_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Fiiling Number Query.
   */
  private function getFilingNumber($id) {
    $query = db_select('node__field_vp_filing_number', 'number');
    $query->condition('number.entity_id', $id, '=');
    $query->fields('number', ['field_vp_filing_number_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Fiiling Description Query.
   */
  private function getFilingDescription($id) {
    $query = db_select('node__field_vp_filing_description', 'description');
    $query->condition('description.entity_id', $id, '=');
    $query->fields('description', ['field_vp_filing_description_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Case Number Query.
   */
  private function getCaseNumber($id) {
    $query = db_select('node__field_vp_case_number', 'case_number');
    $query->condition('case_number.entity_id', $id, '=');
    $query->fields('case_number', ['field_vp_case_number_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Case Court Query.
   */
  private function getCaseCourt($id) {
    $query = db_select('node__field_vp_case_court', 'case_court');
    $query->join('taxonomy_term_field_data', 'term', 'case_court.field_vp_case_court_target_id = term.tid');
    $query->condition('case_court.entity_id', $id, '=');
    $query->fields('term', ['name']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Nature Of Suit Query.
   */
  private function getNatureOfSuit($id) {
    $query = db_select('node__field_vp_case_nature_of_suit', 'suit');
    $query->join('taxonomy_term_field_data', 'term', 'suit.field_vp_case_nature_of_suit_target_id = term.tid');
    $query->condition('suit.entity_id', $id, '=');
    $query->fields('term', ['name']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Date Filed Query.
   */
  private function getFilingDate($id) {
    $query = db_select('node__field_vp_case_date_filed', 'date_filed');
    $query->condition('date_filed.entity_id', $id, '=');
    $query->fields('date_filed', ['field_vp_case_date_filed_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Fee Date Begin Query.
   */
  private function getFeeDateBegin($id) {
    $query = db_select('node__field_vp_filing_fee_dates', 'date_begin');
    $query->condition('date_begin.entity_id', $id, '=');
    $query->fields('date_begin', ['field_vp_filing_fee_dates_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Fee Date End Query.
   */
  private function getFeeDateEnd($id) {
    $query = db_select('node__field_vp_filing_fee_dates', 'date_end');
    $query->condition('date_end.entity_id', $id, '=');
    $query->fields('date_end', ['field_vp_filing_fee_dates_end_value']);
    return $query->execute()->fetchField();
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
