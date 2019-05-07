<?php

namespace Drupal\entity_activity\Form;

use Drupal\Core\Form\FormStateInterface;

/**
 * Class GeneratorDuplicateForm.
 *
 * @package Drupal\entity_activity\Form
 */
class GeneratorDuplicateForm extends GeneratorForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\entity_activity\Entity\GeneratorInterface $entity */
    $entity = $this->entity->createDuplicate();
    $entity->set('label', $this->t('Duplicate of @label', ['@label' => $this->entity->label()]));
    $this->entity = $entity;
    return parent::form($form, $form_state);
  }

}
