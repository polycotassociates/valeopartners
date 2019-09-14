<?php

namespace Drupal\entity_activity_mail;

use Drupal\Component\Utility\EmailValidatorInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\State\StateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Utility\Token;
use Drupal\entity_activity\Interval;
use Drupal\user\UserInterface;

/**
 * Class CollectService.
 */
class ReportService implements ReportServiceInterface {

  use StringTranslationTrait;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Component\Utility\EmailValidatorInterface definition.
   *
   * @var \Drupal\Component\Utility\EmailValidatorInterface
   */
  protected $emailValidator;

  /**
   * Queue factory.
   *
   * @var \Drupal\Core\Queue\QueueFactory
   */
  protected $queueFactory;

  /**
   * The mail handler service.
   *
   * @var \drupal\entity_activity_mail\MailHandlerInterface
   */
  protected $mailHandler;

  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * Drupal\Core\State\StateInterface definition.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Drupal\user\UserStorageInterface definition.
   *
   * @var \Drupal\user\UserStorageInterface
   */
  protected $userStorage;

  /**
   * Drupal\entity_activity\LogStorageInterface definition.
   *
   * @var \Drupal\entity_activity\LogStorageInterface
   */
  protected $logStorage;

  /**
   * CollectService constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Component\Utility\EmailValidatorInterface $email_validator
   *   The email validator service.
   * @param \Drupal\Core\Queue\QueueFactory $queue_factory
   *   The queue factory.
   * @param \Drupal\entity_activity_mail\MailHandlerInterface $mail_handler
   *   The mail handler service.
   * @param \Drupal\Core\Utility\Token $token
   *   The token service.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, EmailValidatorInterface $email_validator, QueueFactory $queue_factory, MailHandlerInterface $mail_handler, Token $token, LanguageManagerInterface $language_manager, StateInterface $state) {
    $this->configFactory = $config_factory;
    $this->entityTypeManager = $entity_type_manager;
    $this->emailValidator = $email_validator;
    $this->queueFactory = $queue_factory;
    $this->mailHandler = $mail_handler;
    $this->token = $token;
    $this->languageManager = $language_manager;
    $this->state = $state;
    $this->userStorage = $entity_type_manager->getStorage('user');
    $this->logStorage = $entity_type_manager->getStorage('entity_activity_log');
  }

  /**
   * Check if sending logs report is enabled.
   *
   * @return bool
   *   TRUE if sending logs report is enabled. Otherwise FALSE.
   */
  public function isEnabled() {
    $enabled = (bool) $this->configFactory->get('entity_activity_mail.settings')->get('general.enabled');
    return $enabled;
  }

  /**
   * {@inheritdoc}
   */
  public function sendLogsReportUsers($timestamp, array $frequencies = ['daily', 'weekly', 'monthly']) {
    if (!$this->isEnabled()) {
      return;
    }
    $current_date = DrupalDateTime::createFromTimestamp($timestamp);
    foreach ($frequencies as $frequency) {
      $ids = $this->getUsersPerFrequency($frequency, $current_date);
      if (!empty($ids)) {
        $queue = $this->queueFactory->get('entity_activity_mail_prepare_report');
        $chunks = array_chunk($ids, 10, TRUE);
        foreach ($chunks as $chunk) {
          $data = [];
          $data['frequency'] = $frequency;
          $data['current_timestamp'] = $current_date->getTimestamp();
          $data['uids'] = $chunk;
          $queue->createItem($data);
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getUsersPerFrequency($frequency, DrupalDateTime $date) {
    $last_sent = $this->getLastSentTimestamp($frequency, $date);
    $query = $this->userStorage->getQuery();
    $query->accessCheck(FALSE)
      ->condition('status', 1)
      ->condition('entity_activity_mail_frequency', $frequency);

    $condition_or = $query->orConditionGroup();
    $condition_or->notExists('entity_activity_mail_last');
    $condition_or->condition('entity_activity_mail_last', $last_sent, '<=');
    $query->condition($condition_or);
    // Exclude users who doesn't have a mail. We can't send then any report.
    $query->exists('mail');
    $query->sort('entity_activity_mail_last', 'ASC');
    $ids = $query->execute();
    return !empty($ids) ? array_combine($ids, $ids) : [];
  }

  /**
   * {@inheritdoc}
   */
  public function getUnsentLogsPerUserId($uid, $get_only_unread_logs = FALSE) {
    $query = $this->logStorage->getQuery();
    $query->condition('uid', $uid);
    $condition_or = $query->orConditionGroup();
    $condition_or->notExists('sent');
    $condition_or->condition('sent', 0);
    $query->condition($condition_or);
    if ($get_only_unread_logs) {
      $query->condition('read', 0);
    }
    $ids = $query->execute();
    return !empty($ids) ? $ids : [];
  }

  /**
   * {@inheritdoc}
   */
  public function getLastSentTimestamp($frequency, DrupalDateTime $date) {
    $units = $this->getMapFrequencyUnit();
    if (!isset($units[$frequency])) {
      throw new \InvalidArgumentException(sprintf('The provided frequency "%s" is not a valid value.', $frequency));
    }
    $unit = $units[$frequency];
    $interval = new Interval(1, $unit);
    $last_sent_date = $interval->subtract($date);
    $last_sent = $last_sent_date->getTimestamp();
    return $last_sent;
  }

  /**
   * {@inheritdoc}
   */
  public function sendReport(UserInterface $user, array $logs, array $logs_content, $frequency, $current_timestamp = '') {
    $user_langcode = $user->getPreferredLangcode();
    $current_langcode = $this->languageManager->getCurrentLanguage()->getId();
    $original_language = NULL;
    if ($user_langcode !== $current_langcode) {
      // We need to load configuration in the user preferred language.
      $language = $this->languageManager->getLanguage($user_langcode);
      $original_language = $this->languageManager->getConfigOverrideLanguage();
      $this->languageManager->setConfigOverrideLanguage($language);
    }

    $subject = $this->getMailSubject();
    $subject = $this->replaceToken($subject, $user);
    $body = $this->getMailBody();
    $body['value'] = $this->replaceToken($body['value'], $user);
    $footer = $this->getMailFooter();
    $footer['value'] = $this->replaceToken($footer['value'], $user);
    $params = ['from' => $this->getMailFrom()];

    if ($user_langcode !== $current_langcode && $original_language instanceof LanguageInterface) {
      $this->languageManager->setConfigOverrideLanguage($original_language);
    }

    $body_array = [
      '#type' => 'processed_text',
      '#text' => $body['value'],
      '#format' => $body['format'],
    ];

    $footer_array = [
      '#type' => 'processed_text',
      '#text' => $footer['value'],
      '#format' => $footer['format'],
    ];

    $body_mail = [
      '#theme' => 'entity_activity_mail_report',
      '#logs' => $logs,
      '#logs_content' => $logs_content,
      '#user' => $user,
      '#body' => $body_array,
      '#footer' => $footer_array,
      '#report_timestamp' => $current_timestamp,
      '#frequency' => $frequency,
    ];

    return $this->mailHandler->sendMail($user->getEmail(), $subject, $body_mail, $params);
  }

  /**
   * {@inheritdoc}
   */
  public function getMapFrequencyUnit() {
    return [
      'daily' => 'day',
      'weekly' => 'week',
      'monthly' => 'month',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function replaceToken($string, UserInterface $user) {
    $data = [];
    $data['user'] = $user;
    $string = $this->token->replace($string, $data, ['clear' => TRUE]);
    return $string;
  }

  /**
   * {@inheritdoc}
   */
  public function getMailSubject() {
    $config = $this->configFactory->get('entity_activity_mail.settings');
    return $config->get('mail.subject') ?: $this->t('Logs report');
  }

  /**
   * {@inheritdoc}
   */
  public function getMailBody() {
    $default_body = ['value' => '', 'format' => filter_fallback_format()];
    $config = $this->configFactory->get('entity_activity_mail.settings');
    $body = $config->get('mail.body') ?: [];
    return $body + $default_body;
  }

  /**
   * {@inheritdoc}
   */
  public function getMailFooter() {
    $default_footer = ['value' => '', 'format' => filter_fallback_format()];
    $config = $this->configFactory->get('entity_activity_mail.settings');
    $footer = $config->get('mail.footer') ?: [];
    return $footer + $default_footer;
  }

  /**
   * {@inheritdoc}
   */
  public function getMailFrom() {
    $site_mail = $this->configFactory->get('system.site')->get('mail');
    $config = $this->configFactory->get('entity_activity_mail.settings');
    $mail = $config->get('mail.from') ?: $site_mail;
    return $mail;
  }

  /**
   * {@inheritdoc}
   */
  public function getUserIdsProcessing() {
    return $this->state->get(ReportServiceInterface::STATE_PROCESSING_KEY, []);
  }

  /**
   * {@inheritdoc}
   */
  public function addUserIdsToProcessing(array $uids) {
    $uids_already_processing = $this->getUserIdsProcessing();
    $uids_processing = $uids_already_processing + $uids;
    $this->state->set(ReportServiceInterface::STATE_PROCESSING_KEY, $uids_processing);
  }

  /**
   * {@inheritdoc}
   */
  public function removeUserIdsFromProcessing(array $uids) {
    $uids_already_processing = $this->getUserIdsProcessing();
    $uids_processing = array_diff_assoc($uids_already_processing, $uids);
    $this->state->set(ReportServiceInterface::STATE_PROCESSING_KEY, $uids_processing);
  }

  /**
   * {@inheritdoc}
   */
  public function userIsProcessing($uid) {
    $uids_already_processing = $this->getUserIdsProcessing();
    return (bool) in_array($uid, $uids_already_processing);
  }

  /**
   * {@inheritdoc}
   */
  public function shouldLog() {
    $should_log = (bool) $this->configFactory->get('entity_activity_mail.settings')->get('general.log_report');
    return $should_log;
  }

  /**
   * {@inheritdoc}
   */
  public function updateNextCronTimestamp($time) {
    $default_timestamp = strtotime($time);
    $next_cron = $this->state->get(ReportServiceInterface::NEXT_CRON, $default_timestamp);
    $next_date = DrupalDateTime::createFromTimestamp($next_cron);
    $next_time = $next_date->format('H:i:s');
    if ($time !== $next_time) {
      $new_date = DrupalDateTime::createFromTimestamp(strtotime($time));
      $hour = (int) $new_date->format('H');
      $min = (int) $new_date->format('i');
      $second = (int) $new_date->format('s');
      $next_date->setTime($hour, $min, $second);
      $next_timestamp = $next_date->getTimestamp();
      $this->state->set(ReportServiceInterface::NEXT_CRON, $next_timestamp);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCronTime() {
    $cron_time = $this->configFactory->get('entity_activity_mail.settings')->get('general.cron_time');
    return $cron_time;
  }

}
