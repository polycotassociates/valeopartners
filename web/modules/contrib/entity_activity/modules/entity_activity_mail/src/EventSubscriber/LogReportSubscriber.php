<?php

namespace Drupal\entity_activity_mail\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\entity_activity\Event\LogEvent;
use Drupal\entity_activity\Event\LogEvents;
use Drupal\entity_activity_mail\ReportServiceInterface;
use Drupal\user\UserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Send a mail to the owner if this option has been selected.
 */
class LogReportSubscriber implements EventSubscriberInterface {

  /**
   * The entity type manager.
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
   * Constructs a new EntityActivitySubscriber object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\entity_activity_mail\ReportServiceInterface $report
   *   The report service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, ReportServiceInterface $report) {
    $this->entityTypeManager = $entity_type_manager;
    $this->report = $report;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [
      LogEvents::LOG_INSERT => ['sendLogReport', 0],
    ];
    return $events;
  }

  /**
   * Send a log report if owner has subscribed to this option.
   *
   * @param \Drupal\entity_activity\Event\LogEvent $event
   *   The entity activity log event.
   */
  public function sendLogReport(LogEvent $event) {
    $log = $event->getLog();
    $owner = $log->getOwner();
    if (!$owner instanceof UserInterface) {
      return;
    }
    $frequency_base_field = 'entity_activity_mail_frequency';
    if ($owner->hasField($frequency_base_field) && !$owner->get($frequency_base_field)->isEmpty()) {
      $frequency = $owner->{$frequency_base_field}->value;
      if ($frequency === 'immediately') {
        $view_builder = $this->entityTypeManager->getViewBuilder('entity_activity_log');
        $logs_content = $view_builder->viewMultiple([$log], 'mail');
        $this->report->sendReport($owner, [$log], $logs_content, $frequency, $log->getCreatedTime());
      }
    }
  }

}
