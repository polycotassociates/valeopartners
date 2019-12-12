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
 * Run the query and email on a schedule.
 */
function vp_api_cron_generate_daily_new_record_email() {
  // _vp_api_generate_daily_report_email();
  //       // Logger.
  //       \Drupal::logger('vp_api')->notice('vp_api cron ran, email nightly new record report');
  // Get values from database.
  $new_report_enable = \Drupal::config('vp_api.settings')->get('vp_api.report_email.new_report_enable');
  $new_report_cron_interval = \Drupal::config('vp_api.settings')->get('vp_api.report_email.new_report_cron_interval');

  // Only run if the config new_report_enable is TRUE.
  if ($new_report_enable) {

    // Default to an 24 Hour interval.
    $new_report_cron_interval = !empty($new_report_cron_interval) ? $new_report_cron_interval : 86400;

    // We usually don't want to act every time cron runs (which could be every
    // minute) so keep a time for the next run in the site state.
    $next_execution = \Drupal::state()->get('vp_api.new_report_cron_interval_next', 0);
    if (REQUEST_TIME >= $next_execution) {

      // Generate the report if 24 hours has passed.
      _vp_api_generate_daily_report_email();

      // Logger.
      \Drupal::logger('vp_api')->notice('vp_api cron ran, email nightly new record report');

      if (\Drupal::state()->get('vp_api_cron_show_status_message')) {
        \Drupal::messenger()->addMessage(t('vp_api cron executed at %time', ['%time' => date('c')]));
        \Drupal::state()->set('vp_api_cron_show_status_message', FALSE);
      }

      \Drupal::state()->set('vp_api.new_report_cron_interval_next', REQUEST_TIME + $new_report_cron_interval);
    }
  }

}

/**
 * Generate HTML email.
 */
function _vp_api_generate_daily_report_email() {

  // Get 'now'.
  $time = \Drupal::time()->getCurrentTime();
  // To retrieved from configuration settings.
  $to = \Drupal::config('vp_api.settings')->get('vp_api.report_email.new_record_emails');
  // Date.
  $date = format_date($time, 'custom', 'm/j/Y g:i a');
  // Email body.
  $params['message'] = "Report Email Test at $date";

  $params['subject'] = "testy_mc_testface";

  // Inject mail service manager.
  $mailManager = \Drupal::service('plugin.manager.mail');
  $module = 'vp_api';
  $key = 'report_downloaded';
  $langcode = 'en';
  $send = TRUE;

  // Email the message.
  $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
  if ($result['result'] !== TRUE) {
    \Drupal::logger('vp_api')->error("Email error, message not sent.");
  }
  else {
    \Drupal::logger('vp_api')->notice("Daily new record email sent.");
  }

}
