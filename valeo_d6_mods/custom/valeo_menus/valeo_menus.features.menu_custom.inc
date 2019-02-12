<?php

/**
 * Implementation of hook_menu_default_menu_custom().
 */
function valeo_menus_menu_default_menu_custom() {
  $menus = array();

  // Exported menu: menu-addnew
  $menus['menu-addnew'] = array(
    'menu_name' => 'menu-addnew',
    'title' => 'Add New Record',
    'description' => '',
  );
  // Exported menu: menu-compcircle-settings
  $menus['menu-compcircle-settings'] = array(
    'menu_name' => 'menu-compcircle-settings',
    'title' => 'Admin Section',
    'description' => 'Set your website preferences',
  );
  // Exported menu: menu-manage
  $menus['menu-manage'] = array(
    'menu_name' => 'menu-manage',
    'title' => 'Manage',
    'description' => '',
  );
  // Exported menu: menu-qa
  $menus['menu-qa'] = array(
    'menu_name' => 'menu-qa',
    'title' => 'QA Management',
    'description' => 'Approve items for publication, review data entry statistics, look for bad records in the system',
  );
  // Exported menu: menu-rate-reports
  $menus['menu-rate-reports'] = array(
    'menu_name' => 'menu-rate-reports',
    'title' => 'Rate Searches',
    'description' => '',
  );
  // Exported menu: menu-user-activity
  $menus['menu-user-activity'] = array(
    'menu_name' => 'menu-user-activity',
    'title' => 'User Activity',
    'description' => 'Monitor the activity of site users.',
  );
  // Exported menu: navigation
  $menus['navigation'] = array(
    'menu_name' => 'navigation',
    'title' => 'Navigation',
    'description' => 'The navigation menu is provided by Drupal and is the main interactive menu for any site. It is usually the only menu that contains personalized links for authenticated users, and is often not even visible to anonymous users.',
  );
  // Exported menu: primary-links
  $menus['primary-links'] = array(
    'menu_name' => 'primary-links',
    'title' => 'Primary links',
    'description' => 'Primary links are often used at the theme layer to show the major sections of a site. A typical representation for primary links would be tabs along the top.',
  );
  // Exported menu: secondary-links
  $menus['secondary-links'] = array(
    'menu_name' => 'secondary-links',
    'title' => 'Secondary links',
    'description' => 'Secondary links are often used for pages like legal notices, contact details, and other secondary navigation items that play a lesser role than primary links',
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Add New Record');
  t('Admin Section');
  t('Approve items for publication, review data entry statistics, look for bad records in the system');
  t('Manage');
  t('Monitor the activity of site users.');
  t('Navigation');
  t('Primary links');
  t('Primary links are often used at the theme layer to show the major sections of a site. A typical representation for primary links would be tabs along the top.');
  t('QA Management');
  t('Rate Searches');
  t('Secondary links');
  t('Secondary links are often used for pages like legal notices, contact details, and other secondary navigation items that play a lesser role than primary links');
  t('Set your website preferences');
  t('The navigation menu is provided by Drupal and is the main interactive menu for any site. It is usually the only menu that contains personalized links for authenticated users, and is often not even visible to anonymous users.');
  t('User Activity');


  return $menus;
}
