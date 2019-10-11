<?php

namespace Drupal\vp_forms\Controller;

ini_set('max_execution_time', 9999999);
ini_set('memory_limit', '16384M');

/**
 * @file
 * Contains \Drupal\vp_forms\Controller\SavedSearchSummaryReport.
 */

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Initialize class.
 */
class SavedSearchSummaryReport extends ControllerBase {
  /**
   * Runs query based on $_GET string.
   */

  /**
   * Export a report using phpSpreadsheet.
   */
  public function export() {

    $response = new Response();
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');
    $response->headers->set('Content-Type', 'application/vnd.ms-excel');
    $response->headers->set('Content-Disposition', "attachment; filename=Saved_Search_Summary.xlsx");

    $spreadsheet_start_time = microtime(TRUE);
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

    //Rename sheet.
    $worksheet->setTitle('Valeo Summary Search');

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
    $worksheet->getCell('N1')->setValue('2019 Actual Rate');
    $worksheet->getCell('O1')->setValue('2019 Standard Rate');
    $worksheet->getCell('P1')->setValue('2018 Actual Rate');
    $worksheet->getCell('Q1')->setValue('2018 Standard Rate');
    $worksheet->getCell('R1')->setValue('2017 Actual Rate');
    $worksheet->getCell('S1')->setValue('2017 Standard Rate');
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
    // 2019 Actual Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(25);
    // 2019 Standard Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(25);
    // 2018 Actual Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(25);
    // 2018 Standard Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
    // 2017 Actual Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(25);
    // 2017 Standard Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(25);

    // Query loop.
    $i = 2;
    foreach ($this->generateDynamicQuery() as $result) {

      // Last Name.
      $worksheet->setCellValue('A' . $i, $result->field_vp_last_name_value);
      // Middle Name.
      $worksheet->setCellValue('B' . $i, '' . $result->field_vp_middle_name_value);
      // First Name.
      $worksheet->setCellValue('C' . $i, '' . $result->field_vp_first_name_value);
      // Firm.
      $worksheet->setCellValue('D' . $i, '' . $this->getNodeTitle($result->field_firm_target_id));
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
      // 2019 Actual Rate.
      $worksheet->setCellValue('N' . $i, $result->field_2019_actual_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('N' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2019 Standard Rate.
      $worksheet->setCellValue('O' . $i, $result->field_2019_standard_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2018 Actual Rate.
      $worksheet->setCellValue('P' . $i, $result->field_2018_actual_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2018 Standard Rate.
      $worksheet->setCellValue('Q' . $i, $result->field_2018_standard_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('Q' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2017 Actual Rate.
      $worksheet->setCellValue('R' . $i, $result->field_2017_actual_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('R' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2017 Standard Rate.
      $worksheet->setCellValue('S' . $i, $result->field_2017_standard_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('S' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

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
    \Drupal::logger('vp_api')->notice("Saved Search Summary Report Spreadsheet generated in $seconds seconds by user #$uid.");
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
    $query->fields('node', ['nid', 'type', 'status', 'title']);
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

    // Rates from individual record.
    $query->leftjoin('node__field_2017_actual_rate', '2017_actual_rate', '2017_actual_rate.entity_id = individual.entity_id');
    $query->leftjoin('node__field_2017_standard_rate', '2017_standard_rate', '2017_standard_rate.entity_id = individual.entity_id');
    $query->leftjoin('node__field_2018_actual_rate', '2018_actual_rate', '2018_actual_rate.entity_id = individual.entity_id');
    $query->leftjoin('node__field_2018_standard_rate', '2018_standard_rate', '2018_standard_rate.entity_id = individual.entity_id');
    $query->leftjoin('node__field_2019_actual_rate', '2019_actual_rate', '2019_actual_rate.entity_id = individual.entity_id');
    $query->leftjoin('node__field_2019_standard_rate', '2019_standard_rate', '2019_standard_rate.entity_id = individual.entity_id');
    $query->leftjoin('node__field_vp_employment_history', 'history', 'history.entity_id = individual.entity_id');
    $query->leftjoin('paragraph__field_firm', 'employment', 'employment.entity_id = history.field_vp_employment_history_target_id');

    // Filing, Case, Company, Individual, and Firm fields.
    $query->fields('employment', ['field_firm_target_id']);
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

    $query->fields('2017_actual_rate', ['field_2017_actual_rate_value']);
    $query->fields('2017_standard_rate', ['field_2017_standard_rate_value']);
    $query->fields('2018_actual_rate', ['field_2018_actual_rate_value']);
    $query->fields('2018_standard_rate', ['field_2018_standard_rate_value']);
    $query->fields('2019_actual_rate', ['field_2019_actual_rate_value']);
    $query->fields('2019_standard_rate', ['field_2019_standard_rate_value']);

    // Only if there's an actual rate.
    //$query->condition('field_vp_rate_hourly_value', 0, '>');

    // Filter by title.
    if (isset($_GET['title'])) {
      $query->join('node_field_data', 'individual_title', 'individual_title.nid = individual.field_vp_rate_individual_target_id');
      $query->addField('individual_title', 'title', 'individual_title');
    }

    // Filter by Rate Year.
    if (isset($_GET['field_vp_filing_fee_dates_value']['min']) && $_GET['field_vp_filing_fee_dates_value']['min'] != '') {
      $query->condition('field_vp_filing_year_value', [$_GET['field_vp_filing_fee_dates_value']['min'], $_GET['field_vp_filing_fee_dates_value']['max']], 'BETWEEN');
    }

    // Filter by Bar Date.
    if (isset($_GET['field_vp_bar_date_value']['min']) && $_GET['field_vp_bar_date_value']['min'] != '') {
      $query->condition('field_vp_bar_date_value', [$_GET['field_vp_bar_date_value']['min'], $_GET['field_vp_bar_date_value']['max']], 'BETWEEN');
    }

    // Filter by Grad Date.
    if (isset($_GET['field_vp_graduation_value']['min']) && $_GET['field_vp_graduation_value']['min'] != '') {
      $query->condition('field_vp_graduation_value', [$_GET['field_vp_graduation_value']['min'], $_GET['field_vp_graduation_value']['max']], 'BETWEEN');
    }

    // Filter by Partner Date.
    if (isset($_GET['field_vp_partner_date_value']['min']) && $_GET['field_vp_partner_date_value']['min'] != '') {
      $query->condition('field_vp_partner_date_value', [$_GET['field_vp_partner_date_value']['min'], $_GET['field_vp_partner_date_value']['max']], 'BETWEEN');
    }

    // Filter by firm ids.
    if (isset($_GET['field_vp_rate_firm_target_id_verf'])) {
      $query->condition('field_vp_rate_firm_target_id', $_GET['field_vp_rate_firm_target_id_verf'], 'IN');
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

    // Filter by nature of suit ids.
    if (isset($_GET['field_vp_case_nature_of_suit_target_id_verf'])) {
      $query->condition('field_vp_case_nature_of_suit_target_id', $_GET['field_vp_case_nature_of_suit_target_id_verf'], 'IN');
    }

    // Filter by target industry.
    if (isset($_GET['field_vp_company_industry_target_id'])) {
      $query->condition('field_vp_company_industry_target_id', $_GET['field_vp_company_industry_target_id'], 'IN');
    }

    // Filter by title.
    if (isset($_GET['title'])) {
      $query->condition('individual_title.title', '%' . db_like($_GET['title']) . '%', 'LIKE');
    }

    // Filter by practice area ids.
    if (isset($_GET['field_vp_practice_area_1_target_id']) || isset($_GET['field_vp_practice_area_2_target_id']) || isset($_GET['field_vp_practice_area_3_target_id'])) {
      $group = $query->orConditionGroup()
        ->condition('field_vp_practice_area_1_target_id', $_GET['field_vp_practice_area_1_target_id'], 'IN')
        ->condition('field_vp_practice_area_2_target_id', $_GET['field_vp_practice_area_1_target_id'], 'IN')
        ->condition('field_vp_practice_area_3_target_id', $_GET['field_vp_practice_area_1_target_id'], 'IN');
      $query->condition($group);
    }

    // Filter by practice range.
    if (isset($_GET['field_vp_practice_area_range'])) {
      $group = $query->orConditionGroup()
        ->condition('field_vp_practice_area_1_target_id', $_GET['field_vp_practice_area_range'], 'IN')
        ->condition('field_vp_practice_area_2_target_id', $_GET['field_vp_practice_area_range'], 'IN')
        ->condition('field_vp_practice_area_3_target_id', $_GET['field_vp_practice_area_range'], 'IN');
      $query->condition($group);
    }

    // Maximum 50,000 records.
    $query->range(0, 50000);

    // Order by Transaction Amount Rate.
    $query->orderBy('primary_fee.field_vp_rate_primaryfee_calc_value', 'DESC')->orderBy('lname.field_vp_last_name_value', 'ASC');

    return $query->execute()->fetchAll();

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

}
