<?php

namespace Drupal\entity_activity_mail\Plugin\QueueWorker;

use Drupal\Component\Utility\EmailValidatorInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Utility\Token;
use Drupal\entity_activity_mail\MailHandlerInterface;
use Drupal\entity_activity_mail\ReportServiceInterface;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Send logs report email per user on CRON run.
 *
 * @QueueWorker(
 *   id = "entity_activity_mail_report",
 *   title = @Translation("Report worker"),
 *   cron = {"time" = 60}
 * )
 */
class ReportWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  use StringTranslationTrait;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\Component\Utility\EmailValidatorInterface definition.
   *
   * @var \Drupal\Component\Utility\EmailValidatorInterface
   */
  protected $emailValidator;

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
   * The report service.
   *
   * @var \Drupal\entity_activity_mail\ReportServiceInterface
   */
  protected $report;

  /**
   * Drupal\Core\Logger\LoggerChannelFactoryInterface definition.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

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
   * ReportWorker constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Component\Utility\EmailValidatorInterface $email_validator
   *   The email validator service.
   * @param \Drupal\entity_activity_mail\MailHandlerInterface $mail_handler
   *   The mail handler service.
   * @param \Drupal\Core\Utility\Token $token
   *   The token service.
   * @param \Drupal\entity_activity_mail\ReportServiceInterface $report
   *   The report service.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger factory.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, ConfigFactoryInterface $config_factory, EmailValidatorInterface $email_validator, MailHandlerInterface $mail_handler, Token $token, ReportServiceInterface $report, LoggerChannelFactoryInterface $logger_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->configFactory = $config_factory;
    $this->emailValidator = $email_validator;
    $this->mailHandler = $mail_handler;
    $this->token = $token;
    $this->report = $report;
    $this->loggerFactory = $logger_factory;
    $this->userStorage = $entity_type_manager->getStorage('user');
    $this->logStorage = $entity_type_manager->getStorage('entity_activity_log');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('config.factory'),
      $container->get('email.validator'),
      $container->get('entity_activity_mail.mail_handler'),
      $container->get('token'),
      $container->get('entity_activity_mail.report'),
      $container->get('logger.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    if (!$this->report->isEnabled()) {
      return;
    }
    $uid = $data['uid'];
    $frequency = $data['frequency'];
    $current_timestamp = $data['current_timestamp'];
    $log_ids = $data['log_ids'];
    $user = $this->userStorage->load($uid);

    // The user could have been deleted or blocked.
    if (!$user instanceof UserInterface) {
      $this->report->removeUserIdsFromProcessing([$uid => $uid]);
      return;
    }
    if ($user->isBlocked()) {
      $this->report->removeUserIdsFromProcessing([$uid => $uid]);
      return;
    }
    if (!$this->emailValidator->isValid($user->getEmail())) {
      $this->report->removeUserIdsFromProcessing([$uid => $uid]);
      return;
    }
    $logs = $this->logStorage->loadMultiple($log_ids);
    $view_builder = $this->entityTypeManager->getViewBuilder('entity_activity_log');
    $logs_content = $view_builder->viewMultiple($logs, 'mail');
    if (!empty($logs)) {
      $result = $this->report->sendReport($user, $logs, $logs_content, $frequency, $current_timestamp);
      if ($result) {
        try {
          $user->set('entity_activity_mail_last', $current_timestamp);
          $user->save();
          // Should we mark as read logs sent ?
          $mark_read = $this->configFactory->get('entity_activity_mail.settings')->get('general.mark_read');
          // Mark all logs as sent.
          /** @var \Drupal\entity_activity\Entity\LogInterface $log */
          foreach ($logs as $log) {
            $log->set('sent', TRUE);
            if ($mark_read) {
              $log->set('read', TRUE);
            }
            $log->save();
          }
        }
        catch (\Exception $e) {
          $this->report->removeUserIdsFromProcessing([$uid => $uid]);
          $this->loggerFactory->get('entity_activity_mail')->error($this->t('An error occurs when updating user @username and their logs entities sent with the message @message.'), ['@username' => $user->getDisplayName(), '@message' => $e->getMessage()]);
        }

        if ($this->report->shouldLog()) {
          $this->loggerFactory->get('entity_activity_mail')->info($this->t('Logs report successfully sent to user @username with mail @email'), ['@username' => $user->getDisplayName(), '@email' => $user->getEmail()]);
        }
      }
      else {
        $this->loggerFactory->get('entity_activity_mail')->error($this->t('An error occurs when sending Logs report to user @username with mail @email'), ['@username' => $user->getDisplayName(), '@email' => $user->getEmail()]);
      }
    }
    $this->report->removeUserIdsFromProcessing([$uid => $uid]);
  }

}
