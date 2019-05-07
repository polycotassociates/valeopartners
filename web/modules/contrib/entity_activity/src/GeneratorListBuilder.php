<?php

namespace Drupal\entity_activity;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of Generator entities.
 */
class GeneratorListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Generator');
    $header['id'] = $this->t('Machine name');
    $header['generators'] = $this->t('Generators');
    $header['status'] = $this->t('Status');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {

    $row['label'] = $entity->label();
    $row['id'] = $entity->id();

    $data['generators'] = [];

    /** @var \Drupal\entity_activity\Entity\GeneratorInterface $entity */
    /** @var \Drupal\entity_activity\Plugin\LogGeneratorInterface $log_generator */
    foreach ($entity->getLogGeneratorsCollection() as $log_generator_id => $log_generator) {
      /** @var \Drupal\Core\StringTranslation\TranslatableMarkup $summary */
      if ($summary = $log_generator->summary()) {
        $data['generators'][$log_generator_id] = ['#markup' => $summary->render()];
      }
    }

    $data['generators'] = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#items' => empty($data['generators']) ? [$this->t('None')] : $data['generators'],
    ];

    $row['generators'] = render($data['generators']);
    $row['status'] = $entity->status() ? $this->t('Enabled') : $this->t('Disabled');

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultOperations(EntityInterface $entity) {
    $operations = parent::getDefaultOperations($entity);

    if ($entity->hasLinkTemplate('duplicate')) {
      $operations['duplicate'] = [
        'title' => $this->t('Duplicate'),
        'weight' => 15,
        'url' => $entity->toUrl('duplicate'),
      ];
    }

    // Remove query option to allow the save and continue to correctly function.
    $options = $operations['edit']['url']->getOptions();
    unset($options['query']);
    $operations['edit']['url']->setOptions($options);
    return $operations;
  }

}
