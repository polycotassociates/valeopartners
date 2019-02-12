<?php

/**
 * Implementation of hook_menu_default_menu_links().
 */
function valeo_menus_menu_default_menu_links() {
  $menu_links = array();

  // Exported menu link: menu-addnew:admin/user/user/create
  $menu_links['menu-addnew:admin/user/user/create'] = array(
    'menu_name' => 'menu-addnew',
    'link_path' => 'admin/user/user/create',
    'router_path' => 'admin/user/user/create',
    'link_title' => 'Site User',
    'options' => array(
      'attributes' => array(
        'title' => 'Add a new user to the website',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-43',
  );
  // Exported menu link: menu-addnew:node/add/case
  $menu_links['menu-addnew:node/add/case'] = array(
    'menu_name' => 'menu-addnew',
    'link_path' => 'node/add/case',
    'router_path' => 'node/add/case',
    'link_title' => 'Case',
    'options' => array(
      'attributes' => array(
        'title' => 'The central data on a case.',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-49',
  );
  // Exported menu link: menu-addnew:node/add/company
  $menu_links['menu-addnew:node/add/company'] = array(
    'menu_name' => 'menu-addnew',
    'link_path' => 'node/add/company',
    'router_path' => 'node/add/company',
    'link_title' => 'Company',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-45',
  );
  // Exported menu link: menu-addnew:node/add/filing
  $menu_links['menu-addnew:node/add/filing'] = array(
    'menu_name' => 'menu-addnew',
    'link_path' => 'node/add/filing',
    'router_path' => 'node/add/filing',
    'link_title' => 'Filing',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-48',
  );
  // Exported menu link: menu-addnew:node/add/firm
  $menu_links['menu-addnew:node/add/firm'] = array(
    'menu_name' => 'menu-addnew',
    'link_path' => 'node/add/firm',
    'router_path' => 'node/add/firm',
    'link_title' => 'Firm',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-46',
  );
  // Exported menu link: menu-addnew:node/add/individual
  $menu_links['menu-addnew:node/add/individual'] = array(
    'menu_name' => 'menu-addnew',
    'link_path' => 'node/add/individual',
    'router_path' => 'node/add/individual',
    'link_title' => 'Individual',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-47',
  );
  // Exported menu link: menu-addnew:node/add/page
  $menu_links['menu-addnew:node/add/page'] = array(
    'menu_name' => 'menu-addnew',
    'link_path' => 'node/add/page',
    'router_path' => 'node/add/page',
    'link_title' => 'Page',
    'options' => array(
      'attributes' => array(
        'title' => 'A <em>page</em>, similar in form to a <em>story</em>, is a simple method for creating and displaying information that rarely changes, such as an "About us" section of a website. By default, a <em>page</em> entry does not allow visitor comments and is not featured on the site\'s initial home page.',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-44',
  );
  // Exported menu link: menu-addnew:node/add/rate
  $menu_links['menu-addnew:node/add/rate'] = array(
    'menu_name' => 'menu-addnew',
    'link_path' => 'node/add/rate',
    'router_path' => 'node/add/rate',
    'link_title' => 'Rate',
    'options' => array(
      'attributes' => array(
        'title' => 'Attorney and Consultant Rates',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-50',
  );
  // Exported menu link: menu-compcircle-settings:http://reports.valeopartners.com/files/Valeo_User_Guide_August-2011.pdf
  $menu_links['menu-compcircle-settings:http://reports.valeopartners.com/files/Valeo_User_Guide_August-2011.pdf'] = array(
    'menu_name' => 'menu-compcircle-settings',
    'link_path' => 'http://reports.valeopartners.com/files/Valeo_User_Guide_August-2011.pdf',
    'router_path' => '',
    'link_title' => 'User Guide',
    'options' => array(
      'attributes' => array(
        'title' => 'Valeo User Guide',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '1',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-49',
  );
  // Exported menu link: menu-compcircle-settings:node/114164
  $menu_links['menu-compcircle-settings:node/114164'] = array(
    'menu_name' => 'menu-compcircle-settings',
    'link_path' => 'node/114164',
    'router_path' => 'node/%',
    'link_title' => 'Court Abbreviations',
    'options' => array(
      'attributes' => array(
        'title' => 'Valeo Court Abbreviations',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-47',
  );
  // Exported menu link: menu-compcircle-settings:node/124486
  $menu_links['menu-compcircle-settings:node/124486'] = array(
    'menu_name' => 'menu-compcircle-settings',
    'link_path' => 'node/124486',
    'router_path' => 'node/%',
    'link_title' => 'Request a Firm Update/Addition',
    'options' => array(
      'attributes' => array(
        'title' => 'Request an addition or update to a firm',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '0',
  );
  // Exported menu link: menu-compcircle-settings:rates/practicearea_abbr
  $menu_links['menu-compcircle-settings:rates/practicearea_abbr'] = array(
    'menu_name' => 'menu-compcircle-settings',
    'link_path' => 'rates/practicearea_abbr',
    'router_path' => 'rates/practicearea_abbr',
    'link_title' => 'Practice Area Abbreviations',
    'options' => array(
      'attributes' => array(
        'title' => 'Practice Area Abbreviations',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-48',
  );
  // Exported menu link: menu-compcircle-settings:user/me/edit/profile
  $menu_links['menu-compcircle-settings:user/me/edit/profile'] = array(
    'menu_name' => 'menu-compcircle-settings',
    'link_path' => 'user/me/edit/profile',
    'router_path' => 'user/%/edit/profile',
    'link_title' => 'Firm Pricing Patterns Set-Up',
    'options' => array(
      'attributes' => array(
        'title' => 'Choose the customized settings for your account',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-50',
  );
  // Exported menu link: menu-manage:admin/bulk
  $menu_links['menu-manage:admin/bulk'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/bulk',
    'router_path' => 'admin/bulk',
    'link_title' => 'Bulk Rates',
    'options' => array(
      'attributes' => array(
        'title' => 'Bulk Rates',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-38',
  );
  // Exported menu link: menu-manage:admin/content/taxonomy/1
  $menu_links['menu-manage:admin/content/taxonomy/1'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/content/taxonomy/1',
    'router_path' => 'admin/content/taxonomy/%',
    'link_title' => 'Practice Areas',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage the list of practice areas available.',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-42',
  );
  // Exported menu link: menu-manage:admin/content/taxonomy/14
  $menu_links['menu-manage:admin/content/taxonomy/14'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/content/taxonomy/14',
    'router_path' => 'admin/content/taxonomy/%',
    'link_title' => 'Industries',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage the list of industries used to categorize clients',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-44',
  );
  // Exported menu link: menu-manage:admin/content/taxonomy/6
  $menu_links['menu-manage:admin/content/taxonomy/6'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/content/taxonomy/6',
    'router_path' => 'admin/content/taxonomy/%',
    'link_title' => 'Regions / Cities',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage the list of regions and cities',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-43',
  );
  // Exported menu link: menu-manage:admin/content/taxonomy/8
  $menu_links['menu-manage:admin/content/taxonomy/8'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/content/taxonomy/8',
    'router_path' => 'admin/content/taxonomy/%',
    'link_title' => 'State Bar Locations',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage the list of state bar locations',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-41',
  );
  // Exported menu link: menu-manage:admin/manage/case
  $menu_links['menu-manage:admin/manage/case'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/manage/case',
    'router_path' => 'admin/manage/case',
    'link_title' => 'Cases',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage All Cases',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-48',
  );
  // Exported menu link: menu-manage:admin/manage/company
  $menu_links['menu-manage:admin/manage/company'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/manage/company',
    'router_path' => 'admin/manage/company',
    'link_title' => 'Companies',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage All Companies',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-45',
  );
  // Exported menu link: menu-manage:admin/manage/filing
  $menu_links['menu-manage:admin/manage/filing'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/manage/filing',
    'router_path' => 'admin/manage/filing',
    'link_title' => 'Filings',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage All Filings',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-49',
  );
  // Exported menu link: menu-manage:admin/manage/firm
  $menu_links['menu-manage:admin/manage/firm'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/manage/firm',
    'router_path' => 'admin/manage/firm',
    'link_title' => 'Firms',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage All Firms',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-47',
  );
  // Exported menu link: menu-manage:admin/manage/firm_ranking
  $menu_links['menu-manage:admin/manage/firm_ranking'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/manage/firm_ranking',
    'router_path' => 'admin/manage/firm_ranking',
    'link_title' => 'Firm Rankings',
    'options' => array(
      'attributes' => array(
        'title' => 'Set the ranking of firms in the database with drag-and-drop',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '0',
  );
  // Exported menu link: menu-manage:admin/manage/individual
  $menu_links['menu-manage:admin/manage/individual'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/manage/individual',
    'router_path' => 'admin/manage/individual',
    'link_title' => 'Individuals',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage All Individuals',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-46',
  );
  // Exported menu link: menu-manage:admin/manage/page
  $menu_links['menu-manage:admin/manage/page'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/manage/page',
    'router_path' => 'admin/manage/page',
    'link_title' => 'Pages',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage All Pages',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-40',
  );
  // Exported menu link: menu-manage:admin/manage/rate
  $menu_links['menu-manage:admin/manage/rate'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/manage/rate',
    'router_path' => 'admin/manage/rate',
    'link_title' => 'Rates',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage All Rates',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-50',
  );
  // Exported menu link: menu-manage:admin/manage/users
  $menu_links['menu-manage:admin/manage/users'] = array(
    'menu_name' => 'menu-manage',
    'link_path' => 'admin/manage/users',
    'router_path' => 'admin',
    'link_title' => 'Site Users',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage Website Users',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-39',
  );
  // Exported menu link: menu-qa:admin/qa/data_entry_details
  $menu_links['menu-qa:admin/qa/data_entry_details'] = array(
    'menu_name' => 'menu-qa',
    'link_path' => 'admin/qa/data_entry_details',
    'router_path' => 'admin',
    'link_title' => 'Data Entry Details',
    'options' => array(
      'attributes' => array(
        'title' => 'All the records entered by data entry personnel in a specified time period',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-49',
  );
  // Exported menu link: menu-qa:admin/qa/data_entry_summary
  $menu_links['menu-qa:admin/qa/data_entry_summary'] = array(
    'menu_name' => 'menu-qa',
    'link_path' => 'admin/qa/data_entry_summary',
    'router_path' => 'admin',
    'link_title' => 'Data Entry Summary',
    'options' => array(
      'attributes' => array(
        'title' => 'A summary of the number of records created by data entry personnel',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-48',
  );
  // Exported menu link: menu-qa:admin/qa/firmupdates
  $menu_links['menu-qa:admin/qa/firmupdates'] = array(
    'menu_name' => 'menu-qa',
    'link_path' => 'admin/qa/firmupdates',
    'router_path' => 'admin',
    'link_title' => 'Firms Last Updated',
    'options' => array(
      'attributes' => array(
        'title' => 'A list of the RAs assigned to firms and when the firms were last updated',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-47',
  );
  // Exported menu link: menu-qa:admin/qa/publish
  $menu_links['menu-qa:admin/qa/publish'] = array(
    'menu_name' => 'menu-qa',
    'link_path' => 'admin/qa/publish',
    'router_path' => 'admin',
    'link_title' => 'Approve New Records',
    'options' => array(
      'attributes' => array(
        'title' => 'Approve new records for publication to users',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-50',
  );
  // Exported menu link: menu-qa:node/124486/webform-results
  $menu_links['menu-qa:node/124486/webform-results'] = array(
    'menu_name' => 'menu-qa',
    'link_path' => 'node/124486/webform-results',
    'router_path' => 'node/%/webform-results',
    'link_title' => 'Firm Request Submissions',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '0',
  );
  // Exported menu link: menu-qa:rates/unpublished
  $menu_links['menu-qa:rates/unpublished'] = array(
    'menu_name' => 'menu-qa',
    'link_path' => 'rates/unpublished',
    'router_path' => 'rates/unpublished',
    'link_title' => 'Unpublished Rates',
    'options' => array(
      'attributes' => array(
        'title' => 'View and download unpublished rates',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-46',
  );
  // Exported menu link: menu-rate-reports:node/11317
  $menu_links['menu-rate-reports:node/11317'] = array(
    'menu_name' => 'menu-rate-reports',
    'link_path' => 'node/11317',
    'router_path' => 'node/%',
    'link_title' => 'Full Database Download',
    'options' => array(
      'attributes' => array(
        'title' => 'Download the complete database in Excel or CSV format',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-43',
  );
  // Exported menu link: menu-rate-reports:node/62096
  $menu_links['menu-rate-reports:node/62096'] = array(
    'menu_name' => 'menu-rate-reports',
    'link_path' => 'node/62096',
    'router_path' => 'node/%',
    'link_title' => 'New',
    'options' => array(
      'attributes' => array(
        'title' => 'Rate Changes - New',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-50',
    'parent_path' => 'node/62096',
  );
  // Exported menu link: menu-rate-reports:node/62097
  $menu_links['menu-rate-reports:node/62097'] = array(
    'menu_name' => 'menu-rate-reports',
    'link_path' => 'node/62097',
    'router_path' => 'node/%',
    'link_title' => 'YTD',
    'options' => array(
      'attributes' => array(
        'title' => 'Rate Changes - YTD',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-49',
    'parent_path' => 'node/62096',
  );
  // Exported menu link: menu-rate-reports:profile/firm
  $menu_links['menu-rate-reports:profile/firm'] = array(
    'menu_name' => 'menu-rate-reports',
    'link_path' => 'profile/firm',
    'router_path' => 'profile/firm',
    'link_title' => 'Firm Rate Profiles',
    'options' => array(
      'attributes' => array(
        'title' => 'Profiles of each firm showing minimum and maximum rates by position',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-46',
  );
  // Exported menu link: menu-rate-reports:rates/company
  $menu_links['menu-rate-reports:rates/company'] = array(
    'menu_name' => 'menu-rate-reports',
    'link_path' => 'rates/company',
    'router_path' => 'rates/company',
    'link_title' => 'Rates by Company / Industry',
    'options' => array(
      'attributes' => array(
        'title' => 'Hourly Rates by Company and Industry',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-45',
  );
  // Exported menu link: menu-rate-reports:rates/individual
  $menu_links['menu-rate-reports:rates/individual'] = array(
    'menu_name' => 'menu-rate-reports',
    'link_path' => 'rates/individual',
    'router_path' => 'rates/individual',
    'link_title' => 'Individual Rates Search',
    'options' => array(
      'attributes' => array(
        'title' => 'Hourly Rates by Individual',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-44',
  );
  // Exported menu link: menu-rate-reports:rates/report
  $menu_links['menu-rate-reports:rates/report'] = array(
    'menu_name' => 'menu-rate-reports',
    'link_path' => 'rates/report',
    'router_path' => 'rates/report',
    'link_title' => 'Rates by Firm - Detail',
    'options' => array(
      'attributes' => array(
        'title' => 'Shows All Actual and Standard Rates for All Years Available',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-49',
  );
  // Exported menu link: menu-rate-reports:rates/summary_search
  $menu_links['menu-rate-reports:rates/summary_search'] = array(
    'menu_name' => 'menu-rate-reports',
    'link_path' => 'rates/summary_search',
    'router_path' => 'rates/summary_search',
    'link_title' => 'Rates by Firm - Summary',
    'options' => array(
      'attributes' => array(
        'title' => 'Shows Only the Highest Actual and Standard Hourly Rates for the past 3 years (2011, 2010 and 2009)',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-50',
  );
  // Exported menu link: menu-user-activity:admin/activity/accessorder
  $menu_links['menu-user-activity:admin/activity/accessorder'] = array(
    'menu_name' => 'menu-user-activity',
    'link_path' => 'admin/activity/accessorder',
    'router_path' => 'admin',
    'link_title' => 'Oldest Logins',
    'options' => array(
      'attributes' => array(
        'title' => 'Site users ordered to show the oldest logins first',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '0',
  );
  // Exported menu link: menu-user-activity:admin/activity/lastmonth
  $menu_links['menu-user-activity:admin/activity/lastmonth'] = array(
    'menu_name' => 'menu-user-activity',
    'link_path' => 'admin/activity/lastmonth',
    'router_path' => 'admin',
    'link_title' => 'No Recent Login',
    'options' => array(
      'attributes' => array(
        'title' => 'Users that haven\'t logged into the site in the past month',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '0',
  );
  // Exported menu link: menu-user-activity:admin/activity/nologin
  $menu_links['menu-user-activity:admin/activity/nologin'] = array(
    'menu_name' => 'menu-user-activity',
    'link_path' => 'admin/activity/nologin',
    'router_path' => 'admin',
    'link_title' => 'No Login Accounts',
    'options' => array(
      'attributes' => array(
        'title' => 'User accounts that have been created but which have never been logged into',
      ),
    ),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '0',
  );
  // Exported menu link: navigation:http://reports.valeopartners.com/files/Valeo_CoverPage_RateSubmissions.pdf
  $menu_links['navigation:http://reports.valeopartners.com/files/Valeo_CoverPage_RateSubmissions.pdf'] = array(
    'menu_name' => 'navigation',
    'link_path' => 'http://reports.valeopartners.com/files/Valeo_CoverPage_RateSubmissions.pdf',
    'router_path' => '',
    'link_title' => 'Cover Page for Court Fee Submissions',
    'options' => array(
      'attributes' => array(
        'title' => 'Valeo Partners Cover Page',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '1',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '0',
    'parent_path' => 'menu-item-container/1',
  );
  // Exported menu link: navigation:http://reports.valeopartners.com/files/Valeo_Terms.pdf
  $menu_links['navigation:http://reports.valeopartners.com/files/Valeo_Terms.pdf'] = array(
    'menu_name' => 'navigation',
    'link_path' => 'http://reports.valeopartners.com/files/Valeo_Terms.pdf',
    'router_path' => '',
    'link_title' => 'Terms of Use',
    'options' => array(
      'attributes' => array(
        'title' => 'Valeo Partners Terms of Use',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '1',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-50',
    'parent_path' => 'menu-item-container/1',
  );
  // Exported menu link: navigation:logout
  $menu_links['navigation:logout'] = array(
    'menu_name' => 'navigation',
    'link_path' => 'logout',
    'router_path' => 'logout',
    'link_title' => 'Log out',
    'options' => array(),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-45',
  );
  // Exported menu link: navigation:menu-item-container/1
  $menu_links['navigation:menu-item-container/1'] = array(
    'menu_name' => 'navigation',
    'link_path' => 'menu-item-container/1',
    'router_path' => 'menu-item-container',
    'link_title' => 'Terms of Use',
    'options' => array(
      'attributes' => array(
        'title' => 'Valeo Terms of Use',
      ),
    ),
    'module' => 'menu_item_container',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '1',
    'expanded' => '1',
    'weight' => '-49',
  );
  // Exported menu link: navigation:user/%
  $menu_links['navigation:user/%'] = array(
    'menu_name' => 'navigation',
    'link_path' => 'user/%',
    'router_path' => 'user/%',
    'link_title' => 'My account',
    'options' => array(),
    'module' => 'system',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-47',
  );
  // Exported menu link: primary-links:contact
  $menu_links['primary-links:contact'] = array(
    'menu_name' => 'primary-links',
    'link_path' => 'contact',
    'router_path' => 'contact',
    'link_title' => 'Support',
    'options' => array(
      'attributes' => array(
        'title' => 'Contact Valeo Partners for Support',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-47',
  );
  // Exported menu link: primary-links:http://www.valeopartners.com
  $menu_links['primary-links:http://www.valeopartners.com'] = array(
    'menu_name' => 'primary-links',
    'link_path' => 'http://www.valeopartners.com',
    'router_path' => '',
    'link_title' => 'Valeo Partners Website',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '1',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-50',
  );
  // Exported menu link: primary-links:http://www.valeopartners.com/reports.html
  $menu_links['primary-links:http://www.valeopartners.com/reports.html'] = array(
    'menu_name' => 'primary-links',
    'link_path' => 'http://www.valeopartners.com/reports.html',
    'router_path' => '',
    'link_title' => 'Purchase Report Access',
    'options' => array(
      'attributes' => array(
        'title' => 'Purchase access to Valeo Partners\' reports',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '1',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-46',
  );
  // Exported menu link: primary-links:node/1
  $menu_links['primary-links:node/1'] = array(
    'menu_name' => 'primary-links',
    'link_path' => 'node/1',
    'router_path' => 'node/%',
    'link_title' => 'Rate Reports',
    'options' => array(
      'attributes' => array(
        'title' => 'Attorney and Consultant Rate Reports',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-48',
  );
  // Exported menu link: primary-links:node/3
  $menu_links['primary-links:node/3'] = array(
    'menu_name' => 'primary-links',
    'link_path' => 'node/3',
    'router_path' => 'node/%',
    'link_title' => 'Reports Home',
    'options' => array(
      'attributes' => array(
        'title' => 'Welcome',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '-49',
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Approve New Records');
  t('Bulk Rates');
  t('Case');
  t('Cases');
  t('Companies');
  t('Company');
  t('Court Abbreviations');
  t('Cover Page for Court Fee Submissions');
  t('Data Entry Details');
  t('Data Entry Summary');
  t('Filing');
  t('Filings');
  t('Firm');
  t('Firm Pricing Patterns Set-Up');
  t('Firm Rankings');
  t('Firm Rate Profiles');
  t('Firm Request Submissions');
  t('Firms');
  t('Firms Last Updated');
  t('Full Database Download');
  t('Individual');
  t('Individual Rates Search');
  t('Individuals');
  t('Industries');
  t('Log out');
  t('My account');
  t('New');
  t('No Login Accounts');
  t('No Recent Login');
  t('Oldest Logins');
  t('Page');
  t('Pages');
  t('Practice Area Abbreviations');
  t('Practice Areas');
  t('Purchase Report Access');
  t('Rate');
  t('Rate Reports');
  t('Rates');
  t('Rates by Company / Industry');
  t('Rates by Firm - Detail');
  t('Rates by Firm - Summary');
  t('Regions / Cities');
  t('Reports Home');
  t('Request a Firm Update/Addition');
  t('Site User');
  t('Site Users');
  t('State Bar Locations');
  t('Support');
  t('Terms of Use');
  t('Unpublished Rates');
  t('User Guide');
  t('Valeo Partners Website');
  t('YTD');


  return $menu_links;
}
