<?php

namespace Drupal\vp_forms\Controller;

ini_set('max_execution_time', 9999999);
ini_set('memory_limit', '16384M');

/**
 * @file
 * Contains \Drupal\vp_forms\Controller\RateSummaryReport.
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
class RateSummaryReport extends ControllerBase {
  /**
   * Runs query based on $_GET string.
   */

  /**
   * Export a report using phpSpreadsheet.
   */
  public function export() {

    $title = $_GET['report_title'] ? $_GET['report_title'] : 'Summary Report';

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

    // Rename sheet.
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
    $worksheet->getCell('O1')->setValue('2020 Actual Rate');
    $worksheet->getCell('P1')->setValue('2020 Standard Rate');
    $worksheet->getCell('Q1')->setValue('2019 Actual Rate');
    $worksheet->getCell('R1')->setValue('2019 Standard Rate');
    $worksheet->getCell('S1')->setValue('2018 Actual Rate');
    $worksheet->getCell('T1')->setValue('2018 Standard Rate');
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
    // 2020 Actual Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    // 2020 Standard Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
    // 2019 Actual Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
    // 2019 Standard Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
    // 2018 Actual Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
    // 2018 Standard Rate.
    $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);

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
      $worksheet->setCellValue('K' . $i, $result->field_vp_graduation_value);
      // Bar Year.
      $worksheet->setCellValue('L' . $i, $result->field_vp_bar_date_value);
      // Bar State.
      $worksheet->setCellValue('M' . $i, '' . $result->state_bar);
      // City.
      $worksheet->setCellValue('N' . $i, '' . $result->location_name);
      // 2020 Actual Rate.
      $worksheet->setCellValue('O' . $i, $result->field_2020_actual_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('N' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2020 Standard Rate.
      $worksheet->setCellValue('P' . $i, $result->field_2020_standard_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2019 Actual Rate.
      $worksheet->setCellValue('Q' . $i, $result->field_2019_actual_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2019 Standard Rate.
      $worksheet->setCellValue('R' . $i, $result->field_2019_standard_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('Q' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2018 Actual Rate.
      $worksheet->setCellValue('S' . $i, $result->field_2018_actual_rate_value);
      $spreadsheet->getActiveSheet()->getStyle('R' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      // 2018 Standard Rate.
      $worksheet->setCellValue('T' . $i, $result->field_2018_standard_rate_value);
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
    vp_api_report_send($uid, $uri, $time);

    $response->setContent($content);
    $spreadsheet_end_time = microtime(TRUE);
    $seconds = round($spreadsheet_end_time - $spreadsheet_start_time, 2);
    \Drupal::logger('vp_api')->notice("Rate Summary Report Spreadsheet generated in $seconds seconds by user #$uid.");
    return $response;

  }

  /**
   * Generate the Dyamic Query based on GET variables.
   */
  public function generateDynamicQuery() {

    $query_start_time = microtime(TRUE);

    // Connect to the database.
    $db = \Drupal::database();

    // Set SQL mode to allow standard "GroupBy" clause below.
    $db->query("SET SESSION sql_mode = ''")->execute();

    // Query node data.
    $query = $db->select('node_field_data', 'node');

    $query->fields('node', ['nid', 'type', 'status', 'title']);
    $query->condition('node.type', 'vp_type_individual', '=');
    $query->condition('node.status', 1);
    $query->isNotNull('node.title');

    // Join Firm, Filing, Individual, Case to Rate.
    $query->leftjoin('node__field_vp_rate_individual', 'rate', 'node.nid = rate.field_vp_rate_individual_target_id');
    $query->leftjoin('node__field_vp_rate_firm', 'firm', 'rate.entity_id = firm.entity_id');
    $query->leftjoin('node__field_vp_rate_company', 'company', 'firm.entity_id = company.entity_id');
    $query->leftjoin('node__field_vp_company_industry', 'industry', 'industry.entity_id = company.field_vp_rate_company_target_id');

    // Rates from individual record.
    $query->leftjoin('node__field_2018_actual_rate', '2018_actual_rate', '2018_actual_rate.entity_id = node.nid');
    $query->leftjoin('node__field_2018_standard_rate', '2018_standard_rate', '2018_standard_rate.entity_id = node.nid');
    $query->leftjoin('node__field_2019_actual_rate', '2019_actual_rate', '2019_actual_rate.entity_id = node.nid');
    $query->leftjoin('node__field_2019_standard_rate', '2019_standard_rate', '2019_standard_rate.entity_id = node.nid');
    $query->leftjoin('node__field_2020_actual_rate', '2020_actual_rate', '2020_actual_rate.entity_id = node.nid');
    $query->leftjoin('node__field_2020_standard_rate', '2020_standard_rate', '2020_standard_rate.entity_id = node.nid');

    // Individual Joins.
    $query->leftjoin('node__field_vp_rate_position', 'position', 'rate.entity_id = position.entity_id');
    $query->leftjoin('node__field_vp_first_name', 'fname', 'fname.entity_id = node.nid');
    $query->leftjoin('node__field_vp_middle_name', 'mname', 'mname.entity_id = node.nid');
    $query->leftjoin('node__field_vp_last_name', 'lname', 'lname.entity_id = node.nid');
    $query->leftjoin('node__field_vp_bar_date', 'bar_year', 'bar_year.entity_id = node.nid');
    $query->leftjoin('node__field_vp_state_bar', 'bar_state', 'bar_state.entity_id = node.nid');
    $query->leftjoin('node__field_vp_practice_area_1', 'pa1', 'pa1.entity_id = node.nid');
    $query->leftjoin('node__field_vp_practice_area_2', 'pa2', 'pa2.entity_id = node.nid');
    $query->leftjoin('node__field_vp_practice_area_3', 'pa3', 'pa3.entity_id = node.nid');
    $query->leftjoin('node__field_vp_graduation', 'grad_year', 'grad_year.entity_id = node.nid');
    $query->leftjoin('node__field_vp_individual_location', 'location', 'location.entity_id = node.nid');
    $query->leftjoin('node__field_most_recent_firm', 'employment', 'employment.entity_id = node.nid');

    // $query->leftjoin('node__field_vp_employment_history', 'history', 'history.entity_id = node.nid');
    // $query->leftjoin('paragraph__field_firm', 'employment', 'employment.entity_id = history.field_vp_employment_history_target_id');

    // Company (client) node join.
    $query->leftjoin('node_field_data', 'company_node', 'company_node.nid = field_vp_rate_company_target_id');

    // Most recent Firm node join.
    $query->leftjoin('node_field_data', 'firm_node', 'firm_node.nid = field_most_recent_firm_target_id');

    // State bar join.
    $query->leftjoin('taxonomy_term_field_data', 'state_bar', 'state_bar.tid = field_vp_state_bar_target_id');

    // Practice Area joins.
    $query->leftjoin('taxonomy_term_field_data', 'pa1_term', 'pa1_term.tid = field_vp_practice_area_1_target_id');
    $query->leftjoin('taxonomy_term_field_data', 'pa2_term', 'pa2_term.tid = field_vp_practice_area_2_target_id');
    $query->leftjoin('taxonomy_term_field_data', 'pa3_term', 'pa3_term.tid = field_vp_practice_area_3_target_id');

    // Industry term join.
    $query->leftjoin('taxonomy_term_field_data', 'industry_term', 'industry_term.tid = field_vp_company_industry_target_id');

    // Position term join.
    $query->leftjoin('taxonomy_term_field_data', 'position_term', 'position_term.tid = field_vp_rate_position_target_id');

    // Location join.
    $query->leftjoin('taxonomy_term_field_data', 'location_term', 'location_term.tid = field_vp_individual_location_target_id');

    // Industry title.
    $query->addField('industry_term', 'name', 'industry_name');

    // Company (client) title.
    $query->addField('company_node', 'title', 'company_title');

    // Bar State.
    $query->addField('state_bar', 'name', 'state_bar');

    // Practice area titles.
    $query->addField('pa1_term', 'name', 'pa1_name');
    $query->addField('pa2_term', 'name', 'pa2_name');
    $query->addField('pa3_term', 'name', 'pa3_name');

    // Position title.
    $query->addField('position_term', 'name', 'position_name');

    // Firm title.
    $query->addField('firm_node', 'title', 'firm_title');

    // City.
    $query->addField('location_term', 'name', 'location_name');

    // Individual Fields.
    $query->fields('employment', ['field_most_recent_firm_target_id']);
    $query->fields('fname', ['field_vp_first_name_value']);
    $query->fields('mname', ['field_vp_middle_name_value']);
    $query->fields('lname', ['field_vp_last_name_value']);
    $query->fields('location', ['field_vp_individual_location_target_id']);
    $query->fields('company', ['field_vp_rate_company_target_id']);
    $query->fields('bar_year', ['field_vp_bar_date_value']);
    $query->fields('grad_year', ['field_vp_graduation_value']);
    $query->fields('2018_actual_rate', ['field_2018_actual_rate_value']);
    $query->fields('2018_standard_rate', ['field_2018_standard_rate_value']);
    $query->fields('2019_actual_rate', ['field_2019_actual_rate_value']);
    $query->fields('2019_standard_rate', ['field_2019_standard_rate_value']);
    $query->fields('2020_actual_rate', ['field_2020_actual_rate_value']);
    $query->fields('2020_standard_rate', ['field_2020_standard_rate_value']);

    // Filter by Bar Date.
    if (isset($_GET['field_vp_bar_date_value']['min']) && $_GET['field_vp_bar_date_value']['min'] != '') {
      $query->condition('field_vp_bar_date_value', [$_GET['field_vp_bar_date_value']['min'], $_GET['field_vp_bar_date_value']['max']], 'BETWEEN');
    }

    // Filter by Grad Date.
    if (isset($_GET['field_vp_graduation_value']['min']) && $_GET['field_vp_graduation_value']['min'] != '') {
      $query->condition('field_vp_graduation_value', [$_GET['field_vp_graduation_value']['min'], $_GET['field_vp_graduation_value']['max']], 'BETWEEN');
    }

    // Filter by firm ids.
    if (isset($_GET['field_most_recent_firm_target_id'])) {
      $query->condition('field_most_recent_firm_target_id', $_GET['field_most_recent_firm_target_id'], 'IN');
      // kint($_GET['field_firm_target_id_verf']);
      // die();
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
    if (isset($_GET['field_vp_practice_area_1_target_id'])) {
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

    // Ensure the results have an actual rate.
    $hasRategroup = $query->orConditionGroup()
      ->condition('field_2020_actual_rate_value', 0.01, '>')
      ->condition('field_2019_actual_rate_value', 0.01, '>')
      ->condition('field_2018_actual_rate_value', 0.01, '>');
    $query->condition($hasRategroup);

    // Group By Node ID.
    $query->groupBy('nid');

    // Maximum 50,000 records.
    $query->range(0, 50000);

    // Order by Actual Rate.
    $query->orderBy('2020_actual_rate.field_2020_actual_rate_value', 'DESC')->orderBy('title', 'ASC');

    $results = $query->execute()->fetchAll();

    $query_end_time = microtime(TRUE);
    $seconds = round($query_end_time - $query_start_time, 2);
    \Drupal::logger('vp_api')->notice("Summary report query took $seconds.");

    return $results;

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
