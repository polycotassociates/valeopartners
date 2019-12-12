<?php

namespace Drupal\entity_activity_mass_subscribe;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\PluralTranslatableMarkup;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\user\UserInterface;

/**
 * Define mass subscribe batch.
 */
class MassSubscribeBatch {

  /**
   * Numbers of user per chunk processed.
   *
   * @var int
   */
  const CHUNK = 10;

  /**
   * Mass subscribe users batch.
   *
   * @param array $user_ids
   *   An array of user ID.
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current user.
   * @param bool $unsubscribe
   *   Bool which indicate if we must unsubscribe users.
   * @param array $context
   *   The batch context.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public static function subscribe($user_ids, ContentEntityInterface $entity, AccountInterface $account, $unsubscribe, array &$context) {
    /** @var \Drupal\user\UserStorageInterface $userStorage */
    $userStorage = self::entityTypeManager()->getStorage('user');
    /** @var \Drupal\entity_activity\SubscriptionStorageInterface $subscriptionStorage */
    $subscriptionStorage = self::entityTypeManager()->getStorage('entity_activity_subscription');

    if (empty($context['results'])) {
      $context['results']['total'] = count($user_ids);
      $context['results']['label'] = $entity->label();
      $context['results']['entity_id'] = $entity->id();
      $context['results']['entity_type_id'] = $entity->getEntityTypeId();
      $context['results']['account'] = $account->getDisplayName() . ' (ID: ' . $account->id() . ')';
      $context['results']['unsubscribe'] = $unsubscribe;
      $context['results']['users'] = [];
      $context['results']['processed'] = 0;
      $context['results']['skipped'] = 0;
    }
    if (empty($context['sandbox'])) {
      $chunks = array_chunk($user_ids, self::CHUNK, TRUE);
      $context['sandbox'] = [];
      $context['sandbox']['chunks'] = $chunks;
      $context['sandbox']['chunk_index'] = 0;
      $context['sandbox']['iterations'] = count($chunks);
    }
    $chunk_index = &$context['sandbox']['chunk_index'];
    $iterations = $context['sandbox']['iterations'];
    $ids = $context['sandbox']['chunks'][$chunk_index];

    $current_count = &$context['results']['processed'];
    $current_skipped = &$context['results']['skipped'];

    foreach ($ids as $id) {
      $user = $userStorage->load($id);
      if ($user instanceof UserInterface && $entity instanceof ContentEntityInterface) {
        $subscriptions = $subscriptionStorage->loadMultipleByEntityAndOwner($entity, $user, $entity->language()->getId());
        if (!$unsubscribe) {
          if (!empty($subscriptions)) {
            $current_skipped++;
            continue;
          }
          try {
            $subscription = $subscriptionStorage->generate($entity, $user, $entity->language()->getId());
            $subscription->save();
            $current_count++;
            $context['results']['users'][] = $id;
          }
          catch (\Exception $e) {
            \Drupal::logger('entity_activity_mass_subscribe')->error(t('Error when <b>subscribing</b> user @uid on entity type @type ID @id. Error message: @error.', [
              '@uid' => $user->id(),
              '@type' => $entity->getEntityTypeId(),
              '@id' => $entity->id(),
              '@error' => $e->getMessage(),
            ]));
          }
        }
        // We want to unsubscribe user.
        else {
          if (empty($subscriptions)) {
            $current_skipped++;
            continue;
          }
          try {
            $subscription = reset($subscriptions);
            $subscription->delete();
            $context['results']['users'][] = $id;
            $current_count++;
          }
          catch (\Exception $e) {
            \Drupal::logger('entity_activity_mass_subscribe')->error(t('Error when <b>unsubscribing</b> user @uid on entity type @type ID @id. Error message: @error.', [
              '@uid' => $user->id(),
              '@type' => $entity->getEntityTypeId(),
              '@id' => $entity->id(),
              '@error' => $e->getMessage(),
            ]));
          }
        }

      }
    }

    $context['message'] = new TranslatableMarkup(
      'Subscribing users (@chunk_index/@iterations step).', [
        '@chunk_index' => $chunk_index + 1,
        '@iterations' => $iterations,
      ]
    );
    $chunk_index++;

    if ($chunk_index != $iterations) {
      $context['finished'] = $chunk_index / $iterations;
    }
  }

  /**
   * The finished callback for the mass subscribe batch.
   *
   * @param bool $success
   *   A boolean if the batch process was successful.
   * @param array $results
   *   An array of results for the given batch process.
   * @param array $operations
   *   An array of batch operations that were performed.
   */
  public static function finished($success, $results, $operations) {
    if ($success) {
      $subscribed_mode = $results['unsubscribe'] ? t('unsubscribed') : t('subscribed');
      $subscribed_message = new PluralTranslatableMarkup($results['processed'], '1 user @subscribed on entity @label for a total given of @total users.', '@count users @subscribed on entity @label for a total given of @total users.', [
        '@count' => $results['processed'],
        '@label' => $results['label'],
        '@total' => $results['total'],
        '@subscribed' => $subscribed_mode,
      ]);
      \Drupal::messenger()->addStatus($subscribed_message);

      if (!empty($results['skipped'])) {
        $skipped_mode = $results['unsubscribe'] ? t('not subscribed') : t('subscribed');
        $skipped_message = new PluralTranslatableMarkup($results['skipped'], '1 user skipped because already @subscribed.', '@skipped users skipped because already @subscribed.', [
          '@skipped' => $results['skipped'],
          '@subscribed' => $skipped_mode,
        ]);
        \Drupal::messenger()->addStatus($skipped_message);
      }
      $args = [
        '@account' => $results['account'],
        '@count' => $results['processed'],
        '@label' => $results['label'],
        '@entity_type_id' => $results['entity_type_id'],
        '@id' => $results['entity_id'],
        '@subscribed' => $subscribed_mode,
        '@users' => implode(', ', $results['users']),
      ];
      $log = t('Account @account has @subscribed @count users on entity @entity_type_id @label (ID: @id). User IDs @subscribed are : @users', $args);
      \Drupal::logger('entity_activity_mass_subscribe')->info($log);
    }
  }

  /**
   * Get the entity type manager service.
   *
   * @return \Drupal\Core\Entity\EntityTypeManagerInterface
   *   The entity manager service.
   */
  public static function entityTypeManager() {
    return \Drupal::entityTypeManager();
  }

}
