<?php

/**
 * @file
 * Functions to export to filesystem.
 */

ini_set('max_execution_time', 9999999);
ini_set('memory_limit', '16384M');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Symfony\Component\HttpFoundation\Response;
use Drupal\user\Entity\User;

/**
 * Run the query and export on a schedule.
 */
function vp_api_cron_export_xls() {

  _vp_api_generate_xls_sheet();

  // // We access our configuration.
  // $cron_config = \Drupal::configFactory()
  //   ->getEditable('vp_api.settings');

  // // Default to an 24 Hour interval.
  // $interval = $cron_config->get('interval');
  // $interval = !empty($interval) ? $interval : 86400;

  // // We usually don't want to act every time cron runs (which could be every
  // // minute) so keep a time for the next run in the site state.
  // $next_execution = \Drupal::state()->get('vp_api.next_execution', 0);
  // if (REQUEST_TIME >= $next_execution) {

  //   // Generate the spreadsheet if 24 hours has passed.
  //   _vp_api_generate_xls_sheet();
  //   \Drupal::logger('vp_api')->notice('vp_api cron ran');

  //   if (\Drupal::state()->get('vp_api_cron_show_status_message')) {
  //     \Drupal::messenger()->addMessage(t('vp_api cron executed at %time', ['%time' => date('c'),]));
  //     \Drupal::state()->set('vp_api_cron_show_status_message', FALSE);
  //   }

  //   \Drupal::state()->set('vp_api.next_execution', REQUEST_TIME + $interval);
  // }

}

/**
 * Generate the Dyamic Query based on GET variables.
 */
function _vp_api_generate_xls_query() {

  // Connect to the database.
  $db = \Drupal::database();
  $db->query("SET SESSION sql_mode = ''")->execute();

  // Query node data.
  $query = $db->select('node_field_data', 'node');
  $query->fields('node', ['nid', 'type', 'status', 'title', 'uid', 'created']);
  $query->condition('node.type', 'vp_type_rate', '=');

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
  $query->leftjoin('node__field_vp_filing_year', 'year', 'year.entity_id = filing.field_vp_rate_filing_target_id');

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
  $query->fields('primary_fee', ['field_vp_rate_primaryfee_calc_value']);
  $query->fields('retainer', ['field_vp_rate_retainer_value']);
  $query->fields('hours', ['field_vp_rate_hours_value']);
  $query->fields('transaction_amount', ['field_vp_rate_transaction_amount_value']);
  $query->fields('transaction_fee', ['field_vp_rate_transactional_fee_value']);
  $query->fields('transaction_type', ['field_vp_rate_transaction_type_target_id']);
  $query->fields('year', ['field_vp_filing_year_value']);

  // Case/Filing Fields.
  $query->fields('nature_of_suit', ['field_vp_case_nature_of_suit_target_id']);
  $query->fields('industry', ['field_vp_company_industry_target_id']);

  // No limit for full download.
  $query->range(0, 10000);

  // Order by Transaction Amount Rate.
  $query->orderBy('primary_fee.field_vp_rate_primaryfee_calc_value', 'DESC')->orderBy('lname.field_vp_last_name_value', 'ASC');

  return $query->execute()->fetchAll();

}

/**
 * Create spreadsheet and save.
 */
function _vp_api_generate_xls_sheet() {

  $response = new Response();
  $response->headers->set('Pragma', 'no-cache');
  $response->headers->set('Expires', '0');
  $response->headers->set('Content-Type', 'application/vnd.ms-excel');
  $response->headers->set('Content-Disposition', "attachment; filename=Valeo_Full_Report_cron_test.xlsx");

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
  $worksheet->setTitle('Valeo Master Search');

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
  $worksheet->getCell('AI1')->setValue('Publication Status');
  $worksheet->getCell('AJ1')->setValue('Created By');
  $worksheet->getCell('AK1')->setValue('On');
  $spreadsheet->getActiveSheet()->freezePane('A2');

  // Set default column width.
  // $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);

  // $spreadsheet->getDefaultStyle()->getAlignment()->setWrapText(true);

  // First name.
  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
  // Middle Name.
  $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
  // Last Name.
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
  // Court
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
  // Publication Status.
  $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
  // Created By.
  $spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
  // Created On.
  $spreadsheet->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);

  $i = 2;
  // Query loop.
  $query = _vp_api_generate_xls_query();
  $total = count($query);
  \Drupal::logger('vp_api')->notice( $total . ' total records in export. Generating spreadsheet.');

  foreach ($query as $result) {
    // Last Name.
    $worksheet->setCellValue('A' . $i, $result->field_vp_last_name_value);
    // Middle Name.
    $worksheet->setCellValue('B' . $i, '' . $result->field_vp_middle_name_value);
    // First Name.
    $worksheet->setCellValue('C' . $i, '' . $result->field_vp_first_name_value);
    // Firm.
    $worksheet->setCellValue('D' . $i, '' . getNodeTitle($result->field_vp_rate_firm_target_id));
    // Position.
    $worksheet->setCellValue('E' . $i, '' . getTermName($result->field_vp_rate_position_target_id));
    // Client Name.
    $worksheet->setCellValue('F' . $i, '' . getNodeTitle($result->field_vp_rate_company_target_id));
    // Industry.
    $worksheet->setCellValue('G' . $i, '' . getTermName($result->field_vp_company_industry_target_id));
    // Practice Area 1.
    $worksheet->setCellValue('H' . $i, '' . getTermName($result->field_vp_practice_area_1_target_id));
    // Practice Area 2.
    $worksheet->setCellValue('I' . $i, '' . getTermName($result->field_vp_practice_area_2_target_id));
    // Practice Area 3.
    $worksheet->setCellValue('J' . $i, '' . getTermName($result->field_vp_practice_area_3_target_id));
    // Grad Year.
    $worksheet->setCellValue('K' . $i, $result->field_vp_graduation_value);
    // Bar Year.
    $worksheet->setCellValue('L' . $i, $result->field_vp_bar_date_value);
    // Bar State.
    $worksheet->setCellValue('M' . $i, '' . getTermName($result->field_vp_state_bar_target_id));
    // City.
    $worksheet->setCellValue('N' . $i, '' . getTermName($result->field_vp_individual_location_target_id));
    // Actual Rate.
    $worksheet->setCellValue('O' . $i, $result->field_vp_rate_hourly_value);
    $spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
    // Standard Rate.
    $worksheet->setCellValue('P' . $i, $result->field_vp_rate_standard_value);
    $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
    // Filing Year.
    $worksheet->setCellValue('Q' . $i, $result->field_vp_filing_year_value);
    // Hours.
    $worksheet->setCellValue('R' . $i, $result->field_vp_rate_hours_value);
    // Total.
    $worksheet->setCellValue('S' . $i, $result->field_vp_rate_total_value);
    $spreadsheet->getActiveSheet()->getStyle('S' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
    // Flat Fee.
    $worksheet->setCellValue('T' . $i, $result->field_vp_rate_flat_fee_value);
    $spreadsheet->getActiveSheet()->getStyle('T' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
    // Retainer Fee.
    $worksheet->setCellValue('U' . $i, $result->field_vp_rate_retainer_value);
    $spreadsheet->getActiveSheet()->getStyle('U' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
    // Transaction Amount.
    $worksheet->setCellValue('V' . $i, $result->field_vp_rate_primaryfee_calc_value);
    $spreadsheet->getActiveSheet()->getStyle('V' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
    // Transactional Fee.
    $worksheet->setCellValue('W' . $i, $result->field_vp_rate_transactional_fee_value);
    $spreadsheet->getActiveSheet()->getStyle('W' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
    // Transaction Type.
    $worksheet->setCellValue('X' . $i, '' . getTermName($result->field_vp_rate_transaction_type_target_id));
    // Case Name.
    $worksheet->setCellValue('Y' . $i, '' . getNodeTitle($result->field_vp_filing_case_target_id));
    // Case Number.
    $worksheet->setCellValue('Z' . $i, '' . getCaseNumber($result->field_vp_filing_case_target_id));
    // Court.
    $worksheet->setCellValue('AA' . $i, '' . getCaseCourt($result->field_vp_filing_case_target_id));
    // Date Filed.
    $worksheet->setCellValue('AB' . $i, getFilingDate($result->field_vp_filing_case_target_id));
    $spreadsheet->getActiveSheet()->getStyle('AB' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
    // Nature of Suit.
    $worksheet->setCellValue('AC' . $i, '' . getNatureOfSuit($result->field_vp_filing_case_target_id));
    // Filing Name.
    $worksheet->setCellValue('AD' . $i, '' . getNodeTitle($result->field_vp_rate_filing_target_id));
    // Filing Description.
    $worksheet->setCellValue('AE' . $i, '' . getFilingDescription($result->field_vp_rate_filing_target_id));
    // Filing Number.
    $worksheet->setCellValue('AF' . $i, '' . getFilingNumber($result->field_vp_rate_filing_target_id));
    // Fee Date Range Begin.
    $worksheet->setCellValue('AG' . $i, getFeeDateBegin($result->field_vp_rate_filing_target_id));
    $spreadsheet->getActiveSheet()->getStyle('AG' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
    // Fee Date Range End.
    $worksheet->setCellValue('AH' . $i, getFeeDateEnd($result->field_vp_rate_filing_target_id));
    $spreadsheet->getActiveSheet()->getStyle('AH' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
    // Publication status.
    $worksheet->setCellValue('AI' . $i, $result->status ? 'Published' : 'Unpublished');
    // Author.
    $worksheet->setCellValue('AJ' . $i, getUserName($result->uid));
    // Created date.
    $worksheet->setCellValue('AK' . $i, format_date($result->created, 'custom', 'Y-m-d'));

    $i++;

  }

  // Get the writer and export in memory.
  $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
  ob_start();

  // Make sure 'reports' subdirectory exists.
  $path = 'private://reports';
  file_prepare_directory($path, FILE_CREATE_DIRECTORY);

  // Get real path to private directory.
  $private = \Drupal::service('file_system')->realpath("private://");

  // Delete the previous xlsx export.
  if (file_exists($private . '/reports/Valeo_Full_Report.xlsx')) {
    file_unmanaged_delete($private . '/reports/Valeo_Full_Report.xlsx');
  }

  // Save to private directory.
  $writer->save($private . '/reports/Valeo_Full_Report.xlsx');
  $content = ob_get_clean();

  // Memory cleanup.
  $spreadsheet->disconnectWorksheets();
  unset($spreadsheet);

  // Notice.
  \Drupal::logger('vp_api')->notice('Spreadsheet saved to '. $private . '/reports/Valeo_Full_Report.xlsx');
  $response->setContent($content);
  return $response;
}

  /**
   * Get Fiiling Number Query.
   */
  function getFilingNumber($id) {
    $query = db_select('node__field_vp_filing_number', 'number');
    $query->condition('number.entity_id', $id, '=');
    $query->fields('number', ['field_vp_filing_number_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Fiiling Description Query.
   */
  function getFilingDescription($id) {
    $query = db_select('node__field_vp_filing_description', 'description');
    $query->condition('description.entity_id', $id, '=');
    $query->fields('description', ['field_vp_filing_description_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Case Number Query.
   */
  function getCaseNumber($id) {
    $query = db_select('node__field_vp_case_number', 'case_number');
    $query->condition('case_number.entity_id', $id, '=');
    $query->fields('case_number', ['field_vp_case_number_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Case Court Query.
   */
  function getCaseCourt($id) {
    $query = db_select('node__field_vp_case_court', 'case_court');
    $query->join('taxonomy_term_field_data', 'term', 'case_court.field_vp_case_court_target_id = term.tid');
    $query->condition('case_court.entity_id', $id, '=');
    $query->fields('term', ['name']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Nature Of Suit Query.
   */
  function getNatureOfSuit($id) {
    $query = db_select('node__field_vp_case_nature_of_suit', 'suit');
    $query->join('taxonomy_term_field_data', 'term', 'suit.field_vp_case_nature_of_suit_target_id = term.tid');
    $query->condition('suit.entity_id', $id, '=');
    $query->fields('term', ['name']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Date Filed Query.
   */
  function getFilingDate($id) {
    $query = db_select('node__field_vp_case_date_filed', 'date_filed');
    $query->condition('date_filed.entity_id', $id, '=');
    $query->fields('date_filed', ['field_vp_case_date_filed_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Fee Date Begin Query.
   */
  function getFeeDateBegin($id) {
    $query = db_select('node__field_vp_filing_fee_dates', 'date_begin');
    $query->condition('date_begin.entity_id', $id, '=');
    $query->fields('date_begin', ['field_vp_filing_fee_dates_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Fee Date End Query.
   */
  function getFeeDateEnd($id) {
    $query = db_select('node__field_vp_filing_fee_dates', 'date_end');
    $query->condition('date_end.entity_id', $id, '=');
    $query->fields('date_end', ['field_vp_filing_fee_dates_end_value']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Node Title Query.
   */
  function getNodeTitle($id) {
    $query = db_select('node_field_data', 'node');
    $query->condition('node.nid', $id, '=');
    $query->fields('node', ['title']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Term Name Query.
   */
  function getTermName($id) {
    $query = db_select('taxonomy_term_field_data', 'term');
    $query->condition('term.tid', $id, '=');
    $query->fields('term', ['name']);
    return $query->execute()->fetchField();
  }

  /**
   * Get Term Parent IDs.
   */
  function getTermParentIds($ids) {
    // Create an array for the child term ids.
    $childTerms = [];

    // For each term_node_tid_depth get the children and
    // add them to the child terms array.
    foreach ($ids as $tid) {
      $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadChildren($tid);
      foreach ($terms as $term) {
        $childTerms[] = $term->get('tid')->value;
      }
    }
    return $childTerms;
  }

  /**
   * Get the title of the current page.
   */
  function getPageTitle() {
    $request = \Drupal::request();
    if ($route = $request->attributes->get(RouteObjectInterface::ROUTE_OBJECT)) {
      $title = \Drupal::service('title_resolver')->getTitle($request, $route);
    }
    //return $title;
    return "Valeo Rates Report";
  }

  /**
   * Get the username of the id.
   */
  function getUserName($uid) {
    $account = User::load($uid); // pass your uid
    $name = $account->getUsername();
    return $name;
  }
