<?php

namespace Drupal\entity_activity\Plugin\LogGenerator;

use Drupal\entity_activity\Plugin\LogGeneratorBase;

/**
 * Plugin implementation for node entity type.
 *
 * @LogGenerator(
 *   id = "node",
 *   label = @Translation("Node Log Generator"),
 *   description = @Translation("Generate log for the entity type Node or for related entities referenced."),
 *   source_entity_type = "node",
 *   bundles = {}
 * )
 */
class NodeLogGenerator extends LogGeneratorBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'log' => [
        'value' => 'The content [node:title] has been updated by [current-user:display-name] on [current-date:medium].',
        'format' => 'plain_text',
      ],
    ] + parent::defaultConfiguration();
  }

}
