<?php

namespace Drupal\entity_activity\Plugin\LogGenerator;

use Drupal\entity_activity\Plugin\LogGeneratorBase;

/**
 * Plugin implementation for user entity type.
 *
 * @LogGenerator(
 *   id = "user",
 *   label = @Translation("User Log Generator"),
 *   description = @Translation("Generate log for the entity type User or for related entities referenced."),
 *   source_entity_type = "user",
 *   bundles = {}
 * )
 */
class UserLogGenerator extends LogGeneratorBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'log' => [
        'value' => '',
        'format' => 'plain_text',
      ],
    ] + parent::defaultConfiguration();
  }

}
