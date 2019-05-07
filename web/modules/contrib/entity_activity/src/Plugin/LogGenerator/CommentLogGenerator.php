<?php

namespace Drupal\entity_activity\Plugin\LogGenerator;

use Drupal\entity_activity\Plugin\LogGeneratorBase;

/**
 * Plugin implementation for comment entity type.
 *
 * @LogGenerator(
 *   id = "comment",
 *   label = @Translation("Comment Log Generator"),
 *   description = @Translation("Generate log for the entity type Comment or for related entities referenced."),
 *   source_entity_type = "comment",
 *   bundles = {}
 * )
 */
class CommentLogGenerator extends LogGeneratorBase {

}
