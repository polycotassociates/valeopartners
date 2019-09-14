<?php

namespace Drupal\entity_activity_mail\Plugin\QueueWorker;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\entity_activity_mail\ReportServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Prepare logs report email per user on CRON run.
 *
 * @QueueWorker(
 *   id = "entity_activity_mail_prepare_report",
 *   title = @Translation("Prepare report worker"),
 *   cron = {"time" = 60}
 * )
 */
class PrepareReportWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager..
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The report service.
   *
   * @var \Drupal\entity_activity_mail\ReportServiceInterface
   */
  protected $report;

  /**
   * Queue factory.
   *
   * @var \Drupal\Core\Queue\QueueFactory
   */
  protected $queueFactory;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Construct the PrepareReportWorker.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\entity_activity_mail\ReportServiceInterface $report
   *   The report service.
   * @param \Drupal\Core\Queue\QueueFactory $queue_factory
   *   The queue factory.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, ReportServiceInterface $report, QueueFactory $queue_factory, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->report = $report;
    $this->queueFactory = $queue_factory;
    $this->configFactory = $config_factory;
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
      $container->get('entity_activity_mail.report'),
      $container->get('queue'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    if (!$this->report->isEnabled()) {
      return;
    }
    $get_only_unread_logs = (bool) $this->configFactory->get('entity_activity_mail.settings')->get('general.only_unread') ?: FALSE;
    $uids = $data['uids'];
    $frequency = $data['frequency'];
    $current_timestamp = $data['current_timestamp'];
    foreach ($uids as $uid) {
      if ($this->report->userIsProcessing($uid)) {
        return;
      }
      $log_ids = $this->report->getUnsentLogsPerUserId($uid, $get_only_unread_logs);
      if (!empty($log_ids)) {
        $queue = $this->queueFactory->get('entity_activity_mail_report');
        $report = [];
        $report['uid'] = $uid;
        $report['frequency'] = $frequency;
        $report['current_timestamp'] = $current_timestamp;
        $report['log_ids'] = $log_ids;
        $queue->createItem($report);
        $this->report->addUserIdsToProcessing([$uid => $uid]);
      }
    }
  }

}
