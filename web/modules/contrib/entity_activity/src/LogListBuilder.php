<?php

namespace Drupal\entity_activity;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Link;
use Drupal\Core\Render\Renderer;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a class to build a listing of Log entities.
 *
 * @ingroup entity_activity
 */
class LogListBuilder extends EntityListBuilder {

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Constructs a new NodeListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   * @param \Drupal\Core\Render\Renderer $renderer
   *   The renderer service.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, DateFormatterInterface $date_formatter, Renderer $renderer) {
    parent::__construct($entity_type, $storage);
    $this->dateFormatter = $date_formatter;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get('date.formatter'),
      $container->get('renderer')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Log ID');
    $header['uid'] = $this->t('Owner');
    $header['created'] = $this->t('Created');
    $header['read'] = $this->t('read');
    $header['source'] = $this->t('Source');
    $header['reference_source'] = $this->t('Reference source');
    $header['log'] = $this->t('Log');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\entity_activity\Entity\LogInterface $entity */
    $source = ($entity->getSourceEntity() instanceof ContentEntityInterface) ? $entity->getSourceEntity() : NULL;
    $reference_source = ($entity->getReferenceSourceEntity() instanceof ContentEntityInterface) ? $entity->getReferenceSourceEntity() : NULL;
    $log = [
      '#type' => 'processed_text',
      '#text' => $entity->get('log')->value,
      '#format' => $entity->get('log')->format,
    ];

    $row['id'] = $entity->id();
    $row['uid'] = Link::fromTextAndUrl(
      $entity->getOwner()->getDisplayName(),
      $entity->getOwner()->toUrl()
    );
    $row['created'] = $this->dateFormatter->format($entity->getCreatedTime(), 'short');
    $row['read'] = $entity->isRead() ? $this->t('Read') : $this->t('Not read');
    $row['source'] = $source ? Link::fromTextAndUrl($source->label(), $source->toUrl()) : '';
    $row['reference_source'] = $reference_source ? Link::fromTextAndUrl($reference_source->label(), $reference_source->toUrl()) : '';

    $row['log'] = $this->renderer->renderRoot($log);
    return $row + parent::buildRow($entity);
  }

  /**
   * Loads entity IDs using a pager sorted by the entity id.
   *
   * @return array
   *   An array of entity IDs.
   */
  protected function getEntityIds() {
    $query = $this->getStorage()->getQuery()
      ->sort($this->entityType->getKey('id'), 'DESC');

    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $query->pager($this->limit);
    }
    return $query->execute();
  }

}
