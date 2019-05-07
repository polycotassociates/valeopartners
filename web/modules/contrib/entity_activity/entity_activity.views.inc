<?php

/**
 * @file
 * Provide views data that isn't tied to any other module.
 */

/**
 * Implements hook_views_data().
 */
function entity_activity_views_data() {
  $data['views']['log_read_all'] = [
    'title' => t('Mark all logs as read'),
    'help' => t('Add a button to mark all logs entities as read.'),
    'area' => [
      'id' => 'log_read_all',
    ],
  ];
  $data['views']['log_total_unread'] = [
    'title' => t('Total unread logs'),
    'help' => t('Display the total unread logs.'),
    'area' => [
      'id' => 'log_total_unread',
    ],
  ];
  return $data;
}
