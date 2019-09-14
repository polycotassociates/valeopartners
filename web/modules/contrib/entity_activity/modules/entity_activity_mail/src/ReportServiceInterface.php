<?php

namespace Drupal\entity_activity_mail;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\user\UserInterface;

/**
 * Interface CollectServiceInterface.
 */
interface ReportServiceInterface {

  /**
   * The key used with the state api to store users ID being processed.
   */
  const STATE_PROCESSING_KEY = 'entity_activity_mail_processing';

  /**
   * The key used to store the timestamp for the next cron.
   */
  const NEXT_CRON = 'entity_activity_mail_next_cron';

  /**
   * Check if sending logs report is enabled.
   *
   * @return bool
   *   TRUE if sending logs report is enabled. Otherwise FALSE.
   */
  public function isEnabled();

  /**
   * Collect users given their logs report frequencies.
   *
   * @param string $timestamp
   *   The timestamp which trigger the cron run.
   * @param array $frequencies
   *   An array of frequency for which get the corresponding users.
   */
  public function sendLogsReportUsers($timestamp, array $frequencies = ['daily', 'weekly', 'monthly']);

  /**
   * Get the users for which we must send a logs report.
   *
   * @param string $frequency
   *   The frequency, i.e. daily, weekly, monthly.
   * @param \Drupal\Core\Datetime\DrupalDateTime $date
   *   The date (generally the current date).
   *
   * @return array
   *   An array of user ID.
   */
  public function getUsersPerFrequency($frequency, DrupalDateTime $date);

  /**
   * Gets log IDs not sent given a user ID.
   *
   * @param int $uid
   *   The user ID.
   * @param bool $get_only_unread_logs
   *   If set to TRUE, collect only unread (and not sent) logs.
   *
   * @return array
   *   An array of Logs ID.
   */
  public function getUnsentLogsPerUserId($uid, $get_only_unread_logs = FALSE);

  /**
   * Get the last sent timestamp to compare for users given a frequency.
   *
   * @param string $frequency
   *   The frequency, i.e. daily, weekly, monthly.
   * @param \Drupal\Core\Datetime\DrupalDateTime $date
   *   The date (generally the current date).
   *
   * @return int
   *   The last sent timestamp to compare for users who must have a last sent
   *   value inferior to this or NULL if not supported frequency passed.
   */
  public function getLastSentTimestamp($frequency, DrupalDateTime $date);

  /**
   * Get an array with unit corresponding to a frequency.
   *
   * @return array
   *   An array of units with the corresponding frequency as key.
   */
  public function getMapFrequencyUnit();

  /**
   * Send a logs report to a user.
   *
   * @param \Drupal\user\UserInterface $user
   *   The user whom logs are related.
   * @param \Drupal\entity_activity\Entity\LogInterface[] $logs
   *   An array of logs entities.
   * @param array $logs_content
   *   An array of renderable array of log entity for the view mode ID 'mail'.
   * @param string $frequency
   *   The frequency at the origin of the process.
   * @param int $current_timestamp
   *   The timestamp when the process has started.
   *
   * @return bool
   *   return TRUE if the mail has been sent.
   */
  public function sendReport(UserInterface $user, array $logs, array $logs_content, $frequency, $current_timestamp = 0);

  /**
   * Replace token in a string given a user.
   *
   * @param string $string
   *   The string on which replace tokens.
   * @param \Drupal\user\UserInterface $user
   *   The related user entity.
   *
   * @return string
   *   The string with tokens replaced.
   */
  public function replaceToken($string, UserInterface $user);

  /**
   * Get the mail subject.
   *
   * @return string
   *   The mail subject.
   */
  public function getMailSubject();

  /**
   * Get the mail body.
   *
   * @return array
   *   The mail body with the value and format as key.
   */
  public function getMailBody();

  /**
   * Get the mail footer.
   *
   * @return array
   *   The mail footer with the value and format as key.
   */
  public function getMailFooter();

  /**
   * Get the mail from.
   *
   * @return string
   *   The mail from email.
   */
  public function getMailFrom();

  /**
   * Get the user Ids being processed by the worker.
   *
   * @return array
   *   An array of user ID keyed by the user ID.
   */
  public function getUserIdsProcessing();

  /**
   * Add user IDs to the state processing values.
   *
   * @param array $uids
   *   An array of user IDs.
   */
  public function addUserIdsToProcessing(array $uids);

  /**
   * Remove user IDs to the state processing values.
   *
   * @param array $uids
   *   An array of user IDs.
   */
  public function removeUserIdsFromProcessing(array $uids);

  /**
   * Check if a user ID is currently processed.
   *
   * @param int $uid
   *   The user ID.
   *
   * @return bool
   *   TRUE if the user ID is currently processed by a worker.
   */
  public function userIsProcessing($uid);

  /**
   * Should we log every logs report sent.
   *
   * @return bool
   *   TRUE if we should log.
   */
  public function shouldLog();

  /**
   * Update the time of the next cron date given a time.
   *
   * @param string $time
   *   A time under the format 'H:i:s', for example '00:59:00'.
   */
  public function updateNextCronTimestamp($time);

  /**
   * Get the time for the next daily cron run.
   *
   * @return string
   *   The time for the next daily cron run.
   */
  public function getCronTime();

}
