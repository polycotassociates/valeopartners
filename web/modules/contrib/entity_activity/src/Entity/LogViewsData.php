<?php

namespace Drupal\entity_activity\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Log entities.
 */
class LogViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();
    $data['entity_activity_log']['source_entity'] = [
      'title' => t('Source Entity'),
      'field' => [
        'title' => t('Source Entity'),
        'help' => t('The entity which has generated the log.'),
        'id' => 'entity_activity_log_source_entity',
      ],
    ];
    $data['entity_activity_log']['reference_source_entity'] = [
      'title' => t('Reference source Entity'),
      'field' => [
        'title' => t('Reference Source Entity'),
        'help' => t('The entity which hold the subscription at the origin of the log.'),
        'id' => 'entity_activity_log_reference_source_entity',
      ],
    ];
    return $data;
  }

}
