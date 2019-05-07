<?php

namespace Drupal\entity_activity\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Log generator item annotation object.
 *
 * @see \Drupal\entity_activity\Plugin\LogGeneratorManager
 * @see plugin_api
 *
 * @Annotation
 */
class LogGenerator extends Plugin {


  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * The plugin description.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

  /**
   * The source entity type on which the plugin applies.
   *
   * @var string
   */
  public $source_entity_type;

  /**
   * The bundles on which the plugin applies.
   *
   * Leave empty to apply the plugin on all bundles of an entity type.
   *
   * @var array
   */
  public $bundles = [];

}
