<?php

namespace Drupal\entity_activity\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\BooleanFormatter;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;
use Drupal\entity_activity\Entity\LogInterface;

/**
 * Plugin implementation of the 'log read boolean' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_activity_log_read_unread",
 *   label = @Translation("Log read / unread"),
 *   field_types = {
 *     "boolean",
 *   }
 * )
 */
class LogReadFormatter extends BooleanFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $settings = parent::defaultSettings();
    $settings['enable_update_read_status'] = FALSE;

    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);
    $form['enable_update_read_status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow the log owner to update the read status form the rendered entity.'),
      '#default_value' => $this->getSetting('enable_update_read_status'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $enable_update_read_status = $this->getSetting('enable_update_read_status');
    if ($enable_update_read_status) {
      $summary[] = $this->t('Update read status enabled for log owner.');
    }
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $enable_update_read_status = $this->getSetting('enable_update_read_status');
    if (!$enable_update_read_status) {
      return parent::viewElements($items, $langcode);
    }
    $entity = $items->getEntity();
    if (!$entity instanceof LogInterface) {
      return parent::viewElements($items, $langcode);
    }

    $current_user = \Drupal::currentUser();
    if ($current_user->id() != $entity->getOwnerId()
      && !$current_user->hasPermission('administer log entities')) {
      return parent::viewElements($items, $langcode);
    }

    $elements = [];
    $formats = $this->getOutputFormats();
    foreach ($items as $delta => $item) {
      $format = $this->getSetting('format');
      if ($format == 'custom') {
        $read = $this->getSetting('format_custom_true');
        $unread = $this->getSetting('format_custom_false');
        $read_unread = ['#markup' => $item->value ? $this->getSetting('format_custom_true') : $this->getSetting('format_custom_false')];
      }
      else {
        $read = $formats[$format][0];
        $unread = $formats[$format][1];
        $read_unread = ['#markup' => $item->value ? $formats[$format][0] : $formats[$format][1]];
      }

      $status = $item->value ? 'read' : 'unread';
      $title = $item->value ? $this->t('Mark as @unread', ['@unread' => $unread]) : $this->t('Mark as @read', ['@read' => $read]);
      $attributes = new Attribute(['class' => 'js-log-read-unread log-read-unread']);
      $attributes->setAttribute('type', 'button');
      $attributes->setAttribute('id', 'log-read-unread-' . $entity->id());
      $attributes->setAttribute('data-entity-id', $entity->id());
      $attributes->setAttribute('title', $title);
      $attributes->addClass($status);
      $elements[$delta] = [
        '#theme' => 'log_read_unread',
        '#read_unread' => $read_unread,
        '#attributes' => $attributes,
        '#entity' => $entity,
        '#view_mode' => $this->viewMode,
      ];
      $elements[$delta]['#attached']['library'][] = 'entity_activity/log_read_unread';
      $elements[$delta]['#attached']['drupalSettings']['entity_activity']['log_read_unread']['read'] = $read;
      $elements[$delta]['#attached']['drupalSettings']['entity_activity']['log_read_unread']['unread'] = $unread;
    }

    return $elements;
  }

}
