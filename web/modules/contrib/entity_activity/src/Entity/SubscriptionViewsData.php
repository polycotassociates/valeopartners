<?php

namespace Drupal\entity_activity\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Subscription entities.
 */
class SubscriptionViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();
    $data['entity_activity_subscription']['source_entity'] = [
      'title' => t('Source Entity'),
      'field' => [
        'title' => t('Source Entity'),
        'help' => t('The entity the subscription is related.'),
        'id' => 'entity_activity_subscription_source_entity',
      ],
    ];
    return $data;
  }

}
