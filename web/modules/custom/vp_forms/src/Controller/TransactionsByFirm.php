<?php

namespace Drupal\vp_forms\Controller;

ini_set('max_execution_time', 9999999);
ini_set('memory_limit', '16384M');

/**
 * @file
 * Contains \Drupal\vp_forms\Controller\TransactionsByFirm.
 */

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Initialize class.
 */
class TransactionsByFirm extends ControllerBase {
  /**
   * Runs query based on $_GET string.
   */

  /**
   * Export a report using phpSpreadsheet.
   */
  public function export() {

    $title = $_GET['report_title'] ? $_GET['report_title'] : 'Transactional Report';

    $response = new Response();
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');
    $response->headers->set('Content-Type', 'application/vnd.ms-excel');
    $response->headers->set('Content-Disposition', "attachment; filename=$title.xlsx");

    $spreadsheet_start_time = microtime(TRUE);
    $spreadsheet = new Spreadsheet();

    // Set metadata.
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

    //Rename sheet.
    $worksheet->setTitle('Valeo Reports');

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
    $worksheet->getCell('Q1')->setValue('Rate or Fee Year');
    $worksheet->getCell('R1')->setValue('Hours');
    $worksheet->getCell('S1')->setValue('Total');
    $worksheet->getCell('T1')->setValue('Flat Fee');
    $worksheet->getCell('U1')->setValue('Retainer Fee');
    $worksheet->getCell('V1')->setValue('Transaction Amount');
    $worksheet->getCell('W1')->setValue('Transactional Fee');
    $worksheet->getCell('X1')->setValue('Transaction Type');
    $worksheet->getCell('Y1')->setValue('Case Name');
    $worksheet->getCell('Z1')->setValue('Case Number');
    $worksheet->getCell('AA1')->setValue('Court');
    $worksheet->getCell('AB1')->setValue('Date Filed');
    $worksheet->getCell('AC1')->setValue('Nature of Suit');
    $worksheet->getCell('AD1')->setValue('Filing Name');
    $worksheet->getCell('AE1')->setValue('Filing Description');
    $worksheet->getCell('AF1')->setValue('Filing Number');
    $worksheet->getCell('AG1')->setValue('Fee Date Range Begin');
    $worksheet->getCell('AH1')->setValue('Fee Date Range End');
    $spreadsheet->getActiveSheet()->freezePane('A2');

    // Last name.
    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
    // Middle Name.
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    // First Name.
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    // Firm.
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    // Position.
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    // Client Represented.
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    // Industry.
    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    // Practice Area 1.
    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    // Practice Area 2.
    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
    // Practice Area 3.
    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(25);
    // Grad Year.
    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(25);
    // Bar Year.
    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(25);
    // Bar State.
    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25);
    // City.
    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(25);
    // Actual Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(25);
    // Standard Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(25);
    // Rate or Fee Year.
    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
    // Hours.
    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(25);
    // Total.
    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(25);
    // Flat Fee.
    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(25);
    // Retainer Fee.
    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(25);
    // Transaction Amount.
    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(25);
    // Transactional Fee.
    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(25);
    // Transaction Type.
    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(25);
    // Case Name.
    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(25);
    // Case Number.
    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(25);
    // Court.
    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(25);
    // Date Filed.
    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(25);
    // Nature of Suit.
    $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(25);
    // Filing Name.
    $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(25);
    // Filing Description.
    $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(25);
    // Filing Number.
    $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(25);
    // Fee Date Range Begin.
    $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(25);
    // Fee Date Range End.
    $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(25);

    $i = 2;

    // Query loop.
    foreach ($this->generateDynamicQuery() as $result) {
      // Last Name.
      $worksheet->setCellValue('A' . $i, $result->last_name);
      // Middle Name.
      $worksheet->setCellValue('B' . $i, '' . $result->middle_name);
      // First Name.
      $worksheet->setCellValue('C' . $i, '' . $result->first_name);
      // Firm.
      $worksheet->setCellValue('D' . $i, '' . $result->firm_title);
      // Position.
      $worksheet->setCellValue('E' . $i, '' . $result->position_name);
      // Client Name.
      $worksheet->setCellValue('F' . $i, '' . $result->company_title);
      // Industry.
      $worksheet->setCellValue('G' . $i, '' . $result->industry_name);
      // Practice Area 1.
      $worksheet->setCellValue('H' . $i, '' . $result->pa1_name);
      // Practice Area 2.
      $worksheet->setCellValue('I' . $i, '' . $result->pa2_name);
      // Practice Area 3.
      $worksheet->setCellValue('J' . $i, '' . $result->pa3_name);
      // Grad Year.
      $worksheet->setCellValue('K' . $i, $result->grad_year);
      // Bar Year.
      $worksheet->setCellValue('L' . $i, $result->bar_year);
      // Bar State.
      $worksheet->setCellValue('M' . $i, '' . $result->state_bar);
      // City.
      $worksheet->setCellValue('N' . $i, '' . $result->location_name);
      // Actual Rate.
      $worksheet->setCellValue('O' . $i, $result->actual_rate);
      $spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // Standard Rate.
      $worksheet->setCellValue('P' . $i, $result->standard_rate);
      $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // Filing Year.
      $worksheet->setCellValue('Q' . $i, $result->filing_year);
      // Hours.
      $worksheet->setCellValue('R' . $i, $result->hours_total);
      // Total.
      $worksheet->setCellValue('S' . $i, $result->total_rate);
      $spreadsheet->getActiveSheet()->getStyle('S' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // Flat Fee.
      $worksheet->setCellValue('T' . $i, $result->flat_fee);
      $spreadsheet->getActiveSheet()->getStyle('T' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // Retainer Fee.
      $worksheet->setCellValue('U' . $i, $result->retainer_fee);
      $spreadsheet->getActiveSheet()->getStyle('U' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // Transaction Amount.
      $worksheet->setCellValue('V' . $i, $result->transaction_amount);
      $spreadsheet->getActiveSheet()->getStyle('V' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // Transactional Fee.
      $worksheet->setCellValue('W' . $i, $result->transaction_fee);
      $spreadsheet->getActiveSheet()->getStyle('W' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // Transaction Type.
      $worksheet->setCellValue('X' . $i, '' . $result->transaction_type);
      // Case Name.
      $worksheet->setCellValue('Y' . $i, '' . $result->case_title);
      // Case Number.
      $worksheet->setCellValue('Z' . $i, '' . $result->case_number);
      // Court.
      $worksheet->setCellValue('AA' . $i, '' . $result->case_court);
      // Date Filed.
      $worksheet->setCellValue('AB' . $i, $this->getFormattedDate($result->date_filed));
      $spreadsheet->getActiveSheet()->getStyle('AB' . $i)->getNumberFormat()->setFormatCode('MM-DD-YYYY');
      // Nature of Suit.
      $worksheet->setCellValue('AC' . $i, '' . $result->nature_of_suit);
      // Filing Name.
      $worksheet->setCellValue('AD' . $i, '' . $result->filing_name);
      // Filing Description.
      $worksheet->setCellValue('AE' . $i, '' . $result->filing_description);
      // Filing Number.
      $worksheet->setCellValue('AF' . $i, '' . $result->filing_number);
      // Fee Date Range Begin.
      $worksheet->setCellValue('AG' . $i, $this->getFormattedDate($result->fee_date_begin));
      $spreadsheet->getActiveSheet()->getStyle('AG' . $i)->getNumberFormat()->setFormatCode('MM-DD-YYYY');
      // Fee Date Range End.
      $worksheet->setCellValue('AH' . $i, $this->getFormattedDate($result->fee_date_end));
      $spreadsheet->getActiveSheet()->getStyle('AH' . $i)->getNumberFormat()->setFormatCode('MM-DD-YYYY');

      $i++;

    }

    // Get the writer and export in memory.
    // $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer = new Xlsx($spreadsheet);
    $writer->setPreCalculateFormulas(FALSE);
    ob_start();
    $writer->save('php://output');
    $content = ob_get_clean();

    // Memory cleanup.
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);

    // Send a report to an administrator with the user ID, the
    // uri, and time of export.
    $uid = \Drupal::currentUser()->id();
    $uri = "$_SERVER[HTTP_REFERER]";
    $time = \Drupal::time()->getCurrentTime();
    //vp_api_report_send($uid, $uri, $time);

    $response->setContent($content);
    $spreadsheet_end_time = microtime(TRUE);
    $seconds = round($spreadsheet_end_time - $spreadsheet_start_time, 2);
    \Drupal::logger('vp_api')->notice("Transactions By Firm Report generated in $seconds seconds by user #$uid.");
    return $response;
  }

  /**
   * Generate the Dyamic Query based on GET variables.
   */
  public function generateDynamicQuery() {

    $query_start_time = microtime(TRUE);

    // Connect to the database.
    $db = \Drupal::database();
    $db->query("SET SESSION sql_mode = ''")->execute();

    // Query node data.
    $query = $db->select('node_field_data', 'node');
    $query->fields('node', ['nid', 'type', 'status']);
    $query->condition('node.type', 'vp_type_rate', '=');
    $query->condition('node.status', 1);

    // Join Firm, Filing, Individual, Case to Rate.
    $query->leftjoin('node__field_vp_rate_firm', 'firm', 'node.nid = firm.entity_id');
    $query->leftjoin('node__field_vp_rate_company', 'company', 'node.nid = company.entity_id');
    $query->leftjoin('node__field_vp_rate_individual', 'individual', 'node.nid = individual.entity_id');
    $query->leftjoin('node__field_vp_rate_filing', 'filing', 'node.nid = filing.entity_id');
    $query->leftjoin('node__field_vp_filing_case', 'filing_case', 'filing_case.entity_id = filing.field_vp_rate_filing_target_id');

    // Position ID, nature of suit ID, company_industry ID.
    $query->leftjoin('node__field_vp_rate_position', 'position', 'node.nid = position.entity_id');
    $query->leftjoin('node__field_vp_case_nature_of_suit', 'nature_of_suit', 'nature_of_suit.entity_id = filing_case.field_vp_filing_case_target_id');
    $query->leftjoin('node__field_vp_company_industry', 'industry', 'industry.entity_id = company.field_vp_rate_company_target_id');

    // Individual Joins.
    $query->leftjoin('node__field_vp_individual_location', 'location', 'location.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_first_name', 'fname', 'fname.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_middle_name', 'mname', 'mname.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_last_name', 'lname', 'lname.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_bar_date', 'bar_year', 'bar_year.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_state_bar', 'bar_state', 'bar_state.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_practice_area_1', 'pa1', 'pa1.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_practice_area_2', 'pa2', 'pa2.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_practice_area_3', 'pa3', 'pa3.entity_id = individual.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_graduation', 'grad_year', 'grad_year.entity_id = individual.field_vp_rate_individual_target_id');

    // Rate values.
    $query->leftjoin('node__field_vp_rate_standard', 'standard', 'node.nid = standard.entity_id');
    $query->leftjoin('node__field_vp_rate_hourly', 'actual', 'node.nid = actual.entity_id');
    $query->leftjoin('node__field_vp_rate_total', 'rate_total', 'node.nid = rate_total.entity_id');
    $query->leftjoin('node__field_vp_rate_flat_fee', 'flat_fee', 'node.nid = flat_fee.entity_id');
    $query->leftjoin('node__field_vp_rate_primaryfee_calc', 'primary_fee', 'node.nid = primary_fee.entity_id');
    $query->leftjoin('node__field_vp_rate_hours', 'hours', 'node.nid = hours.entity_id');
    $query->leftjoin('node__field_vp_rate_retainer', 'retainer', 'node.nid = retainer.entity_id');
    $query->leftjoin('node__field_vp_rate_transaction_amount', 'transaction_amount', 'node.nid = transaction_amount.entity_id');
    $query->leftjoin('node__field_vp_rate_transactional_fee', 'transaction_fee', 'node.nid = transaction_fee.entity_id');
    $query->leftjoin('node__field_vp_rate_transaction_type', 'transaction_type', 'node.nid = transaction_type.entity_id');
    $query->leftjoin('node__field_vp_rate_success_fee', 'success_fee', 'node.nid = success_fee.entity_id');
    $query->leftjoin('node__field_vp_filing_year', 'year', 'year.entity_id = filing.field_vp_rate_filing_target_id');

    // Firm node join.
    $query->leftjoin('node_field_data', 'firm_node', 'firm_node.nid = firm.field_vp_rate_firm_target_id');

    // Company (client) node join.
    $query->leftjoin('node_field_data', 'company_node', 'company_node.nid = field_vp_rate_company_target_id');

    // Case node join.
    $query->leftjoin('node_field_data', 'case_node', 'case_node.nid = field_vp_filing_case_target_id');

    // Case number join.
    $query->leftjoin('node__field_vp_case_number', 'case_number', 'case_number.entity_id = field_vp_filing_case_target_id');

    // Case court joins.
    $query->leftjoin('node__field_vp_case_court', 'case_court', 'case_court.entity_id = field_vp_filing_case_target_id');
    $query->leftjoin('taxonomy_term_field_data', 'case_court_term', 'case_court_term.tid = case_court.field_vp_case_court_target_id');

    // Filing joins.
    $query->leftjoin('node_field_data', 'filing_node', 'filing_node.nid = field_vp_rate_filing_target_id');
    $query->leftjoin('node__field_vp_filing_description', 'filing_description', 'filing_description.entity_id = field_vp_rate_filing_target_id');
    $query->leftjoin('node__field_vp_filing_number', 'filing_number', 'filing_number.entity_id = field_vp_rate_filing_target_id');

    // Industry term join.
    $query->leftjoin('taxonomy_term_field_data', 'industry_term', 'industry_term.tid = field_vp_company_industry_target_id');

    // Position term join.
    $query->leftjoin('taxonomy_term_field_data', 'position_term', 'position_term.tid = field_vp_rate_position_target_id');

    // Practice Area joins.
    $query->leftjoin('taxonomy_term_field_data', 'pa1_term', 'pa1_term.tid = field_vp_practice_area_1_target_id');
    $query->leftjoin('taxonomy_term_field_data', 'pa2_term', 'pa2_term.tid = field_vp_practice_area_2_target_id');
    $query->leftjoin('taxonomy_term_field_data', 'pa3_term', 'pa3_term.tid = field_vp_practice_area_3_target_id');

    // Transaction type join.
    $query->leftjoin('taxonomy_term_field_data', 'transaction_type_term', 'transaction_type_term.tid = field_vp_rate_transaction_type_target_id');

    // State bar join.
    $query->leftjoin('taxonomy_term_field_data', 'state_bar', 'state_bar.tid = field_vp_state_bar_target_id');

    // Location join.
    $query->leftjoin('taxonomy_term_field_data', 'location_term', 'location_term.tid = field_vp_individual_location_target_id');

    // Nature of suit join.
    $query->leftjoin('taxonomy_term_field_data', 'suit_type_term', 'suit_type_term.tid = field_vp_case_nature_of_suit_target_id');

    // Date filed join.
    $query->leftjoin('node__field_vp_case_date_filed', 'date_filed', 'date_filed.entity_id = field_vp_filing_case_target_id');

    // Fee date range join.
    $query->leftjoin('node__field_vp_filing_fee_dates', 'fee_date', 'fee_date.entity_id = field_vp_rate_filing_target_id');

    /* Fields */

    // Individual values.
    $query->addField('lname', 'field_vp_last_name_value', 'last_name');
    $query->addField('fname', 'field_vp_first_name_value', 'first_name');
    $query->addField('mname', 'field_vp_middle_name_value', 'middle_name');

    // Position title.
    $query->addField('position_term', 'name', 'position_name');

    // Company (client) title.
    $query->addField('company_node', 'title', 'company_title');

    // Industry title.
    $query->addField('industry_term', 'name', 'industry_name');

    // Practice area titles.
    $query->addField('pa1_term', 'name', 'pa1_name');
    $query->addField('pa2_term', 'name', 'pa2_name');
    $query->addField('pa3_term', 'name', 'pa3_name');

    // Grad date.
    $query->addField('bar_year', 'field_vp_bar_date_value', 'bar_year');
    // Bar date.
    $query->addField('grad_year', 'field_vp_graduation_value', 'grad_year');

    // Bar State.
    $query->addField('state_bar', 'name', 'state_bar');

    // City.
    $query->addField('location_term', 'name', 'location_name');

    // Fee date range.
    $query->addField('fee_date', 'field_vp_filing_fee_dates_value', 'fee_date_begin');
    $query->addField('fee_date', 'field_vp_filing_fee_dates_end_value', 'fee_date_end');

    // Fee fields.
    $query->addField('actual', 'field_vp_rate_hourly_value', 'actual_rate');
    $query->addField('standard', 'field_vp_rate_standard_value', 'standard_rate');
    $query->addField('year', 'field_vp_filing_year_value', 'filing_year');
    $query->addField('hours', 'field_vp_rate_hours_value', 'hours_total');
    $query->addField('rate_total', 'field_vp_rate_total_value', 'total_rate');
    $query->addField('flat_fee', 'field_vp_rate_flat_fee_value', 'flat_fee');
    $query->addField('retainer', 'field_vp_rate_retainer_value', 'retainer_fee');
    $query->addField('transaction_amount', 'field_vp_rate_transaction_amount_value', 'transaction_amount');
    $query->addField('transaction_fee', 'field_vp_rate_transactional_fee_value', 'transaction_fee');
    $query->addField('primary_fee', 'field_vp_rate_primaryfee_calc_value', 'primary_fee');
    $query->addField('transaction_type_term', 'name', 'transaction_type');

    // Filing fields.
    $query->addField('filing_node', 'title', 'filing_name');

    $query->addField('filing_description', 'field_vp_filing_description_value', 'filing_description');

    $query->addField('filing_number', 'field_vp_filing_number_value', 'filing_number');

    // Date filed value.
    $query->addField('date_filed', 'field_vp_case_date_filed_value', 'date_filed');

    // Firm title.
    $query->addField('firm_node', 'title', 'firm_title');

    // Case fields.
    $query->addField('case_node', 'title', 'case_title');
    $query->addField('case_court_term', 'name', 'case_court');
    $query->addField('case_number', 'field_vp_case_number_value', 'case_number');

    // Nature of suit title.
    $query->addField('suit_type_term', 'name', 'nature_of_suit');

    //
    $query->fields('transaction_fee', ['field_vp_rate_transactional_fee_value']);
    $query->fields('success_fee', ['field_vp_rate_success_fee_value']);
    $query->fields('flat_fee', ['field_vp_rate_flat_fee_value']);
    $query->fields('retainer', ['field_vp_rate_retainer_value']);

    $fee_group = $query->orConditionGroup()
      ->condition('field_vp_rate_transactional_fee_value', 0, '>')
      ->condition('field_vp_rate_success_fee_value', 0, '>')
      ->condition('field_vp_rate_flat_fee_value', 0, '>')
      ->condition('field_vp_rate_retainer_value', 0, '>');
    $query->condition($fee_group);

    // Filter by firm ids.
    if (isset($_GET['field_vp_rate_firm_target_id_verf'])) {
      $query->condition('field_vp_rate_firm_target_id', $_GET['field_vp_rate_firm_target_id_verf'], 'IN');
    }

    // Search by individual name.
    if (isset($_GET['combine'])) {
      $group = $query->orConditionGroup()
        ->condition('field_vp_first_name_value', '%' . db_like($_GET['combine']) . '%', 'LIKE')
        ->condition('field_vp_last_name_value', '%' . db_like($_GET['combine']) . '%', 'LIKE');
      $query->condition($group);
    }

    // Filter by Bar Date.
    if (isset($_GET['field_vp_bar_date_value']['min']) && $_GET['field_vp_bar_date_value']['min'] != '') {
      $query->condition('field_vp_bar_date_value', [$_GET['field_vp_bar_date_value']['min'], $_GET['field_vp_bar_date_value']['max']], 'BETWEEN');
    }

    // Filter by Grad Date.
    if (isset($_GET['field_vp_graduation_value']['min']) && $_GET['field_vp_graduation_value']['min'] != '') {

      if (isset($_GET['field_vp_graduation_value']['max'])) {
        $range = range($_GET['field_vp_graduation_value']['min'], $_GET['field_vp_graduation_value']['max']);
      }
      else {
        $range = range($_GET['field_vp_graduation_value']['min'], $_GET['field_vp_graduation_value']['min']);
      }
      //$query->condition('field_vp_graduation_value', $range, 'IN');

      $query->condition('field_vp_graduation_value', [$_GET['field_vp_graduation_value']['min'], $_GET['field_vp_graduation_value']['max']], 'BETWEEN');
    }

    // Filter by firm company.
    if (isset($_GET['field_vp_company_industry_target_id'])) {
      $query->condition('field_vp_company_industry_target_id', $_GET['field_vp_company_industry_target_id'], 'IN');
    }

    // Filter by firm company.
    if (isset($_GET['field_vp_rate_company_target_id_verf'])) {
      $query->condition('field_vp_rate_company_target_id', $_GET['field_vp_rate_company_target_id_verf'], 'IN');
    }

    // Filter by location ids (by parent).
    if (isset($_GET['term_node_tid_depth_location'])) {
      $nodes = $this->getTermParentIds($_GET['term_node_tid_depth_location']);
      $query->condition('location.field_vp_individual_location_target_id', $nodes, 'IN');
    }

    // Filter by position ids.
    if (isset($_GET['term_node_tid_depth_position'])) {
      $query->condition('field_vp_rate_position_target_id', $_GET['term_node_tid_depth_position'], 'IN');
    }

    // Filter by practice area ids.
    if (isset($_GET['field_vp_practice_area_1_target_id']) || isset($_GET['field_vp_practice_area_2_target_id']) || isset($_GET['field_vp_practice_area_3_target_id'])) {
      $group = $query->orConditionGroup()
        ->condition('field_vp_practice_area_1_target_id', $_GET['field_vp_practice_area_1_target_id'], 'IN')
        ->condition('field_vp_practice_area_2_target_id', $_GET['field_vp_practice_area_2_target_id'], 'IN')
        ->condition('field_vp_practice_area_3_target_id', $_GET['field_vp_practice_area_3_target_id'], 'IN');
      $query->condition($group);
    }

    // Maximum 50,000 records.
    $query->range(0, 50000);

    // Order by Transaction Amount Rate.
    $query->orderBy('actual.field_vp_rate_hourly_value', 'DESC')->orderBy('lname.field_vp_last_name_value', 'ASC');

    $results = $query->execute()->fetchAll();

    $query_end_time = microtime(TRUE);
    $seconds = round($query_end_time - $query_start_time, 2);
    \Drupal::logger('vp_api')->notice("Transactions by firm report query took $seconds.");

    return $results;

  }

  /**
   * Get Filing Number Query.
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
    $date = $query->execute()->fetchField();
    if ($date) {
      $timestamp = strtotime($date);
      $formatted_date = \Drupal::service('date.formatter')->format($timestamp, 'custom', 'm-d-Y');
      return $formatted_date;
    }

  }

  /**
   * Get Fee Date Begin Query.
   */
  private function getFeeDateBegin($id) {
    $query = db_select('node__field_vp_filing_fee_dates', 'date_begin');
    $query->condition('date_begin.entity_id', $id, '=');
    $query->fields('date_begin', ['field_vp_filing_fee_dates_value']);
    $date = $query->execute()->fetchField();
    if ($date) {
      $timestamp = strtotime($date);
      $formatted_date = \Drupal::service('date.formatter')->format($timestamp, 'custom', 'm-d-Y');
      return $formatted_date;
    }

  }

  /**
   * Get Fee Date End Query.
   */
  private function getFeeDateEnd($id) {
    $query = db_select('node__field_vp_filing_fee_dates', 'date_end');
    $query->condition('date_end.entity_id', $id, '=');
    $query->fields('date_end', ['field_vp_filing_fee_dates_end_value']);
    $date = $query->execute()->fetchField();
    if ($date) {
      $timestamp = strtotime($date);
      $formatted_date = \Drupal::service('date.formatter')->format($timestamp, 'custom', 'm-d-Y');
      return $formatted_date;
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


  /**
   * Format date M-D-Y.
   */
  private function getFormattedDate($date) {
    if ($date) {
      $timestamp = strtotime($date);
      $formatted_date = \Drupal::service('date.formatter')->format($timestamp, 'custom', 'm-d-Y');
      return $formatted_date;
    }
  }

  /**
   * Get Term Parent IDs.
   */
  private function getTermParentIds($ids) {
    // Create an array for the child term ids.
    $childTerms = [];

    // For each term_node_tid_depth get the children and
    // add them to the child terms array.
    foreach ($ids as $tid) {
      $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadChildren($tid);
      foreach ($terms as $term) {
        $childTerms[] = $term->get('tid')->value;
        // Loop through again to get any children of children.
        $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadChildren($term->get('tid')->value);
        foreach ($terms as $term) {
          $childTerms[] = $term->get('tid')->value;
        }
      }
    }
    if (count($childTerms) == 0) {
      $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tid);
      return $term->get('tid')->value;
    }
    return $childTerms;
  }

  /**
   * Get the title of the current page.
   */
  private function getPageTitle() {
    $request = \Drupal::request();
    if ($route = $request->attributes->get(RouteObjectInterface::ROUTE_OBJECT)) {
      $title = \Drupal::service('title_resolver')->getTitle($request, $route);
    }
    //return $title;
    return "Rates By Firm - Detail";
  }

}
