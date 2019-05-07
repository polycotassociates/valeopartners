<?php

/**
 * @file
 * Builds placeholder replacement tokens for current-* related data.
 */

use Drupal\Core\Render\BubbleableMetadata;
use Drupal\user\Entity\User;


/**
 * Implements hook_tokens().
 */
function entity_activity_tokens($type, $tokens, array $data, array $options, BubbleableMetadata $bubbleable_metadata) {
  $token_service = \Drupal::token();
  $replacements = [];
  // This hook ran the latest, so we can replace current-* like tokens with
  // the settings saved during the preGenerateLog().
  if ($type == 'current-user') {
    if (!empty($options['log_generator']) && !empty($options['current_user_id'])) {
      $account = User::load($options['current_user_id']);
      $bubbleable_metadata->addCacheContexts(['user']);
      $replacements += $token_service->generate('user', $tokens, ['user' => $account], $options, $bubbleable_metadata);
    }
  }

  if ($type == 'current-date') {
    if (!empty($options['log_generator']) && !empty($options['current_date'])) {
      $date = $options['current_date'];
      $replacements += $token_service->generate('date', $tokens, ['date' => $date], $options, $bubbleable_metadata);
    }
  }

  return $replacements;
}
