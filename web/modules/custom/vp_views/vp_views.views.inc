<?php
// $Id$

/**
 * @file
 *   Hooks for Valeo Partners Views.
 */
use Drupal\views\Views;
use Drupal\node\Entity\Node;
use Drupal\views\ViewExecutable;
use Drupal\user\Plugin\views\filter\Name;
use Drupal\taxonomy\Entity\Term;
use Drupal\user\Entity\User;

/**
 * Implements hook_views_data().
 */
function vp_views_views_data() {
  $data['views']['export_header'] = [
    'title' => t('Export Link Header'),
    'help' => t('An area containing links with current arguments.'),
    'area' => [
      'id' => 'export_header',
    ],
  ];

  $data['views']['actual_rate_by_year'] = [
    'title' => t('Actual Rate By Year'),
    'help' => t('Get actual rate by a given year, defaults to current year'),
    'area' => ['id' => 'actual_rate_by_year'],
  ];

  return $data;
}
