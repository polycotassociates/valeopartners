<?php

namespace Drupal\entity_activity\Plugin\views\field;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityMalformedException;
use Drupal\Core\Entity\Exception\UndefinedLinkTemplateException;
use Drupal\Core\Form\FormStateInterface;
use Drupal\entity_activity\Entity\LogInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * The log source entity plugin.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("entity_activity_log_reference_source_entity")
 */
class LogReferenceSourceEntity extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  /**
   * Define the available options.
   *
   * @return array
   *   The plugin options.
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['link_to_entity'] = ['default' => FALSE];
    return $options;
  }

  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['link_to_entity'] = [
      '#title' => $this->t('Link to entity'),
      '#description' => $this->t('Make entity label a link to entity page.'),
      '#type' => 'checkbox',
      '#default_value' => !empty($this->options['link_to_entity']),
    ];
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * Performs some cleanup tasks on the options array before saving it.
   */
  public function submitOptionsForm(&$form, FormStateInterface $form_state) {
    parent::submitOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $label = NULL;

    $log = $this->getEntity($values);
    if (!$log instanceof LogInterface) {
      return $label;
    }

    $reference_source_entity = $log->getReferenceSourceEntity();
    if (!$reference_source_entity instanceof ContentEntityInterface) {
      return $label;
    }
    if (!empty($this->options['link_to_entity'])) {
      try {
        $this->options['alter']['url'] = $reference_source_entity->toUrl();
        $this->options['alter']['make_link'] = TRUE;
      }
      catch (UndefinedLinkTemplateException $e) {
        $this->options['alter']['make_link'] = FALSE;
      }
      catch (EntityMalformedException $e) {
        $this->options['alter']['make_link'] = FALSE;
      }
    }
    $label = $this->sanitizeValue($reference_source_entity->label());
    return $label;
  }

}
