<?php

namespace Drupal\entity_activity\Plugin\LogGenerator;

use Drupal\entity_activity\Plugin\LogGeneratorBase;

/**
 * Plugin implementation for taxonomy term entity type.
 *
 * @LogGenerator(
 *   id = "taxonomy_term",
 *   label = @Translation("Term Log Generator"),
 *   description = @Translation("Generate log for the entity type Taxonomy Term or for related entities referenced."),
 *   source_entity_type = "taxonomy_term",
 *   bundles = {}
 * )
 */
class TermLogGenerator extends LogGeneratorBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'log' => [
        'value' => 'The term [term:name] has been updated by [current-user:display-name] on [current-date:medium].',
        'format' => 'plain_text',
      ],
    ] + parent::defaultConfiguration();
  }

}
