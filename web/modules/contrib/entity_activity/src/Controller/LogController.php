<?php

namespace Drupal\entity_activity\Controller;

use Drupal\Core\Site\Settings;
use Drupal\entity_activity\Entity\LogInterface;
use Drupal\user\UserInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LogController.
 */
class LogController extends EntityActivityBaseController {

  /**
   * A hard limit which set the maximum logs entities we can mass update once.
   *
   * This settings can be overrode using the setting in the settings.php
   * $settings['entity_activity_max_log'] = MAX_LOG;
   * where MAX_LOG is an integer to change according your needs.
   *
   * @var int
   */
  protected $maxLog = 50;

  /**
   * Delete a Log entity.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The response.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function remove(Request $request) {
    $data = $this->getPostData($request);
    $response = $this->defaultResponse($data);
    if (!$this->dataIsValid(['element_id', 'entity_id'], $data)) {
      return $this->notValidRequest($data);
    }

    // Get the log entity requested.
    $log = $this->getEntity('entity_activity_log', $data['entity_id']);
    if (!$log instanceof LogInterface) {
      return $response;
    }
    if ($this->isAdmin($log) || ($this->isOwner($log) && $this->currentUser->hasPermission('remove own logs'))) {
      $unread = (bool) !$log->isRead();
      $log->delete();
      $response = $this->getResponse(200, 'Log deleted.', $data, TRUE, ['action' => 'removal-done', 'unread' => $unread]);
    }
    else {
      $response = $this->accessDeniedResponse($data);
    }

    return $response;
  }

  /**
   * Switch the read /unread status of a log.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The response.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function readUnread(Request $request) {
    $data = $this->getPostData($request);
    $response = $this->defaultResponse($data);
    if (!$this->dataIsValid(['element_id', 'entity_id'], $data)) {
      return $this->notValidRequest($data);
    }

    // Get the log entity requested.
    $log = $this->getEntity('entity_activity_log', $data['entity_id']);
    if (!$log instanceof LogInterface) {
      return $response;
    }

    if ($this->isAdmin($log) || $this->isOwner($log)) {
      $read = $log->isRead();
      if ($read) {
        // Mark as unread.
        $log->set('read', FALSE);
        $log->save();
        $response = $this->getResponse(200, 'Marked as unread', $data, TRUE, ['action' => 'mark-unread', 'class' => 'unread']);
      }
      else {
        // Mark as read.
        $log->set('read', TRUE);
        $log->save();
        $response = $this->getResponse(200, 'Marked as read.', $data, TRUE, ['action' => 'mark-read', 'class' => 'read']);
      }
    }

    return $response;
  }

  /**
   * Mark as read all the logs for a user.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The response.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function readAll(Request $request) {
    $data = $this->getPostData($request);
    $response = $this->defaultResponse($data);
    if (!$this->dataIsValid(['entity_id'], $data)) {
      return $this->notValidRequest($data);
    }

    // Get the user entity.
    $user = $this->getEntity('user', $data['entity_id']);
    if (!$user instanceof UserInterface) {
      return $response;
    }

    // Allow only the current user to mark as read all its own logs, or an
    // admin.
    if ($this->currentUser->id() != $user->id()) {
      if (!$this->currentUser->hasPermission('administer log entities')) {
        return $this->accessDeniedResponse($data);
      }
    }

    $logs = $this->logStorage()->loadMultipleUnreadByOwner($user);
    $total_logs = count($logs);
    // Currently we hard code a limit for the number of logs we can mark as read
    // otherwise there is a probability that the request encounter a fatal error
    // because the time limit or max memory PHP settings. If the hard limit is
    // used, then the response give this info on the callback and the ajax
    // request is relaunched to process remaining logs.
    if ($max_log = Settings::get('entity_activity_max_log')) {
      $this->maxLog = $max_log;
    }
    $max_log_used = FALSE;
    if ($total_logs > $this->maxLog) {
      $logs = array_slice($logs, 0, $this->maxLog, TRUE);
      $max_log_used = TRUE;
    }
    $count = isset($data['count']) ? $data['count'] : 0;
    foreach ($logs as $log) {
      // Check again permissions. This could be removed as we checked before.
      // But two security measures are best than only one.
      if ($this->isAdmin($log) || $this->isOwner($log)) {
        $log->set('read', TRUE);
        $log->save();
        $count++;
      }
    }
    $result = [
      'action' => 'mark-all-read',
      'count' => $count,
      'max_log_used' => $max_log_used,
    ];
    // Pass on the first request the total logs in the data.
    if (!isset($data['total'])) {
      $data['total'] = $total_logs;
    }
    $response = $this->getResponse(200, 'All logs marked as read', $data, TRUE, $result);
    return $response;
  }

  /**
   * Get the total unread for a user.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The response.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getTotalUnread(Request $request) {
    $data = $this->getPostData($request);
    $response = $this->defaultResponse($data);

    if ($this->currentUser->hasPermission('view own logs')
      || $this->currentUser->hasPermission('administer log entities')) {
      $total_unread = $this->logStorage()->totalUnreadByOwner($this->currentUser);
      $result = [
        'action' => 'total-unread',
        'total_unread' => $total_unread,
      ];
      $response = $this->getResponse(200, 'All logs marked as read', $data, TRUE, $result);
    }
    return $response;
  }

  /**
   * Get the log storage.
   *
   * @return \Drupal\entity_activity\LogStorageInterface
   *   The log storage.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function logStorage() {
    return $this->entityTypeManager->getStorage('entity_activity_log');
  }

}
