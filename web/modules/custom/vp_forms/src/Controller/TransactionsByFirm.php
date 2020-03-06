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
    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    // Middle Name.
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    // First Name.
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    // Firm.
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    // Position.
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    // Client Represented.
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    // Industry.
    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    // Practice Area 1.
    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    // Practice Area 2.
    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    // Practice Area 3.
    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    // Grad Year.
    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    // Bar Year.
    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    // Bar State.
    $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    // City.
    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    // Actual Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    // Standard Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
    // Rate or Fee Year.
    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
    // Hours.
    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
    // Total.
    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
    // Flat Fee.
    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
    // Retainer Fee.
    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
    // Transaction Amount.
    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
    // Transactional Fee.
    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
    // Transaction Type.
    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
    // Case Name.
    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
    // Case Number.
    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
    // Court.
    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
    // Date Filed.
    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
    // Nature of Suit.
    $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
    // Filing Name.
    $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
    // Filing Description.
    $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
    // Filing Number.
    $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
    // Fee Date Range Begin.
    $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
    // Fee Date Range End.
    $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);

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
    vp_api_report_send($uid, $uri, $time);

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
    $query->leftjoin('node__field_vp_filing_year_end', 'year_end', 'year_end.entity_id = filing.field_vp_rate_filing_target_id');


    // Individual Node.
    $query->leftjoin('node_field_data', 'individual_node', 'individual_node.nid = individual.entity_id');

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
    $query->addField('year_end', 'field_vp_filing_year_end_value', 'filing_year_end');
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

    // Filter by Rate Year.
    if (isset($_GET['field_vp_filing_fee_dates_value_min']) && $_GET['field_vp_filing_fee_dates_value_min'] != '') {
      $query->condition('field_vp_filing_year_value', $_GET['field_vp_filing_fee_dates_value_min'], '>=');
      $query->condition('field_vp_filing_year_end_value', $_GET['field_vp_filing_fee_dates_value_max'], '<=');
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

    // Filter by firm industry.
    if (isset($_GET['field_vp_company_industry_target_id'])) {
      $query->condition('field_vp_company_industry_target_id', $_GET['field_vp_company_industry_target_id'], 'IN');
    }

    // Filter by firm company.
    if (isset($_GET['field_vp_rate_company_target_id_verf'])) {
      $query->condition('field_vp_rate_company_target_id', $_GET['field_vp_rate_company_target_id_verf'], 'IN');
    }

    // Filter by location ids (by parent).
    if (isset($_GET['term_node_tid_depth_location'])) {
      $nodes = $this->getTermTreeIds($_GET['term_node_tid_depth_location'], 'city');
      $query->condition('location.field_vp_individual_location_target_id', $nodes, 'IN');
    }

    // Filter by position ids (by parent).
    if (isset($_GET['term_node_tid_depth_position'])) {
      $nodes = $this->getTermTreeIds($_GET['term_node_tid_depth_position'], 'position');
      $query->condition('field_vp_rate_position_target_id', $nodes, 'IN');
    }

    // Filter by practice area ids.
    if (isset($_GET['field_vp_practice_area_1_target_id']) || isset($_GET['field_vp_practice_area_2_target_id']) || isset($_GET['field_vp_practice_area_3_target_id'])) {
      $group = $query->orConditionGroup()
        ->condition('field_vp_practice_area_1_target_id', $_GET['field_vp_practice_area_1_target_id'], 'IN')
        ->condition('field_vp_practice_area_2_target_id', $_GET['field_vp_practice_area_2_target_id'], 'IN')
        ->condition('field_vp_practice_area_3_target_id', $_GET['field_vp_practice_area_3_target_id'], 'IN');
      $query->condition($group);
    }

    $query->isNotNull('individual_node.title');

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

    foreach ($ids as $tid) {

      $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadChildren($tid);
      if (count($terms) === 0) {
        $childTerms[] = $tid;
      }
      else {
        foreach ($terms as $term) {
          $childTerms[] = $term->get('tid')->value;
          // Loop through again to get any children of children.
          $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadChildren($term->get('tid')->value);
          foreach ($terms as $term) {
            $childTerms[] = $term->get('tid')->value;
          }
        }
      }
    }
    return $childTerms;
  }

  /**
   * Get Term Parent location tree IDs.
   */
  private function getTermTreeIds($ids, $vid) {
    // Create an array for the child term ids.
    $childTerms = [];
    $all_terms = [];
    // Loop through the array of terms.
    foreach ($ids as $tid) {
      $childTerms[] = $tid;
      $child_ids = $this->getChildIds($tid, $vid);
    }
    $all_terms[] = array_merge($childTerms, $child_ids);
    return array_unique($all_terms[0]);
  }

  /**
   * Get Term Children Ids.
   */
  private function getChildIds($id, $vid) {
    $vocabulary_id = $vid;
    $parent_tid = $id; // the parent term id
    $depth = NULL; // 1 to get only immediate children, NULL to load entire tree
    $load_entities = FALSE; // True will return loaded entities rather than ids
    $child_tids = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vocabulary_id, $parent_tid, $depth, $load_entities);
    $ids = [];
    foreach ($child_tids as $tid) {
      $ids[] = $tid->tid;
    }
    return $ids;
  }

}
