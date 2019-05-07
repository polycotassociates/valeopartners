<?php

namespace Drupal\entity_activity;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Link;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a class to build a listing of Subscription entities.
 *
 * @ingroup entity_activity
 */
class SubscriptionListBuilder extends EntityListBuilder {

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs a new NodeListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, DateFormatterInterface $date_formatter) {
    parent::__construct($entity_type, $storage);
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get('date.formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Subscription ID');
    $header['uid'] = $this->t('Owner');
    $header['created'] = $this->t('Created');
    $header['status'] = $this->t('Status');
    $header['subscribed_on'] = $this->t('Subscribed on');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\entity_activity\Entity\Subscription */
    $row['id'] = $entity->id();
    $row['uid'] = Link::fromTextAndUrl(
      $entity->getOwner()->getDisplayName(),
      $entity->getOwner()->toUrl()
    );
    $row['created'] = $this->dateFormatter->format($entity->getChangedTime(), 'short');
    $row['status'] = $entity->isActive() ? $this->t('Active') : $this->t('Inactive');
    $row['subscribed_on'] = Link::fromTextAndUrl(
      $entity->getSourceEntity()->label(),
      $entity->getSourceEntity()->toUrl()
    );
    return $row + parent::buildRow($entity);
  }

}
