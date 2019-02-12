<?php

/**
 * Implementation of hook_user_default_permissions().
 */
function valeo_permissions_user_default_permissions() {
  $permissions = array();

  // Exported permission: Allow Reordering
  $permissions['Allow Reordering'] = array(
    'name' => 'Allow Reordering',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: Use PHP input for field settings (dangerous - grant with care)
  $permissions['Use PHP input for field settings (dangerous - grant with care)'] = array(
    'name' => 'Use PHP input for field settings (dangerous - grant with care)',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: access PDF version
  $permissions['access PDF version'] = array(
    'name' => 'access PDF version',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: access administration pages
  $permissions['access administration pages'] = array(
    'name' => 'access administration pages',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: access all views
  $permissions['access all views'] = array(
    'name' => 'access all views',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: access all webform results
  $permissions['access all webform results'] = array(
    'name' => 'access all webform results',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: access backup and migrate
  $permissions['access backup and migrate'] = array(
    'name' => 'access backup and migrate',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: access backup files
  $permissions['access backup files'] = array(
    'name' => 'access backup files',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: access content
  $permissions['access content'] = array(
    'name' => 'access content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'Pilot Account',
      '4' => 'Rate Report User',
      '5' => 'SuperUser',
      '6' => 'anonymous user',
      '7' => 'authenticated user',
    ),
  );

  // Exported permission: access own webform results
  $permissions['access own webform results'] = array(
    'name' => 'access own webform results',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: access own webform submissions
  $permissions['access own webform submissions'] = array(
    'name' => 'access own webform submissions',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: access print
  $permissions['access print'] = array(
    'name' => 'access print',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: access send to friend
  $permissions['access send to friend'] = array(
    'name' => 'access send to friend',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: access site reports
  $permissions['access site reports'] = array(
    'name' => 'access site reports',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: access site-wide contact form
  $permissions['access site-wide contact form'] = array(
    'name' => 'access site-wide contact form',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'Pilot Account',
      '4' => 'Rate Report User',
      '5' => 'SuperUser',
      '6' => 'authenticated user',
    ),
  );

  // Exported permission: access user profiles
  $permissions['access user profiles'] = array(
    'name' => 'access user profiles',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: administer actions
  $permissions['administer actions'] = array(
    'name' => 'administer actions',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer backup and migrate
  $permissions['administer backup and migrate'] = array(
    'name' => 'administer backup and migrate',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer blocks
  $permissions['administer blocks'] = array(
    'name' => 'administer blocks',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer content types
  $permissions['administer content types'] = array(
    'name' => 'administer content types',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer features
  $permissions['administer features'] = array(
    'name' => 'administer features',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer files
  $permissions['administer files'] = array(
    'name' => 'administer files',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer filters
  $permissions['administer filters'] = array(
    'name' => 'administer filters',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer form filters
  $permissions['administer form filters'] = array(
    'name' => 'administer form filters',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer google analytics
  $permissions['administer google analytics'] = array(
    'name' => 'administer google analytics',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer menu
  $permissions['administer menu'] = array(
    'name' => 'administer menu',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer nodes
  $permissions['administer nodes'] = array(
    'name' => 'administer nodes',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: administer pathauto
  $permissions['administer pathauto'] = array(
    'name' => 'administer pathauto',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer permissions
  $permissions['administer permissions'] = array(
    'name' => 'administer permissions',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: administer print
  $permissions['administer print'] = array(
    'name' => 'administer print',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer referential integrity
  $permissions['administer referential integrity'] = array(
    'name' => 'administer referential integrity',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer rules
  $permissions['administer rules'] = array(
    'name' => 'administer rules',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer site configuration
  $permissions['administer site configuration'] = array(
    'name' => 'administer site configuration',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: administer site-wide contact form
  $permissions['administer site-wide contact form'] = array(
    'name' => 'administer site-wide contact form',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: administer smtp module
  $permissions['administer smtp module'] = array(
    'name' => 'administer smtp module',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer taxonomy
  $permissions['administer taxonomy'] = array(
    'name' => 'administer taxonomy',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: administer url aliases
  $permissions['administer url aliases'] = array(
    'name' => 'administer url aliases',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: administer users
  $permissions['administer users'] = array(
    'name' => 'administer users',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: administer views
  $permissions['administer views'] = array(
    'name' => 'administer views',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: bypass requirement that fields are unique
  $permissions['bypass requirement that fields are unique'] = array(
    'name' => 'bypass requirement that fields are unique',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: change own username
  $permissions['change own username'] = array(
    'name' => 'change own username',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: collapse format fieldset by default
  $permissions['collapse format fieldset by default'] = array(
    'name' => 'collapse format fieldset by default',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'anonymous user',
      '2' => 'authenticated user',
    ),
  );

  // Exported permission: collapsible format selection
  $permissions['collapsible format selection'] = array(
    'name' => 'collapsible format selection',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'anonymous user',
      '2' => 'authenticated user',
    ),
  );

  // Exported permission: configure default number format
  $permissions['configure default number format'] = array(
    'name' => 'configure default number format',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: configure token settings
  $permissions['configure token settings'] = array(
    'name' => 'configure token settings',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: create case content
  $permissions['create case content'] = array(
    'name' => 'create case content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: create company content
  $permissions['create company content'] = array(
    'name' => 'create company content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: create customreport content
  $permissions['create customreport content'] = array(
    'name' => 'create customreport content',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: create filing content
  $permissions['create filing content'] = array(
    'name' => 'create filing content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: create firm content
  $permissions['create firm content'] = array(
    'name' => 'create firm content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: create individual content
  $permissions['create individual content'] = array(
    'name' => 'create individual content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: create page content
  $permissions['create page content'] = array(
    'name' => 'create page content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: create personal contact form
  $permissions['create personal contact form'] = array(
    'name' => 'create personal contact form',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: create profile content
  $permissions['create profile content'] = array(
    'name' => 'create profile content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
    ),
  );

  // Exported permission: create rate content
  $permissions['create rate content'] = array(
    'name' => 'create rate content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: create search content
  $permissions['create search content'] = array(
    'name' => 'create search content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'Pilot Account',
      '4' => 'Rate Report User',
      '5' => 'SuperUser',
    ),
  );

  // Exported permission: create url aliases
  $permissions['create url aliases'] = array(
    'name' => 'create url aliases',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: create webform content
  $permissions['create webform content'] = array(
    'name' => 'create webform content',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: delete all webform submissions
  $permissions['delete all webform submissions'] = array(
    'name' => 'delete all webform submissions',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: delete any case content
  $permissions['delete any case content'] = array(
    'name' => 'delete any case content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete any company content
  $permissions['delete any company content'] = array(
    'name' => 'delete any company content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete any customreport content
  $permissions['delete any customreport content'] = array(
    'name' => 'delete any customreport content',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: delete any filing content
  $permissions['delete any filing content'] = array(
    'name' => 'delete any filing content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete any firm content
  $permissions['delete any firm content'] = array(
    'name' => 'delete any firm content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete any individual content
  $permissions['delete any individual content'] = array(
    'name' => 'delete any individual content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete any page content
  $permissions['delete any page content'] = array(
    'name' => 'delete any page content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete any profile content
  $permissions['delete any profile content'] = array(
    'name' => 'delete any profile content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: delete any rate content
  $permissions['delete any rate content'] = array(
    'name' => 'delete any rate content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete any search content
  $permissions['delete any search content'] = array(
    'name' => 'delete any search content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: delete any webform content
  $permissions['delete any webform content'] = array(
    'name' => 'delete any webform content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete backup files
  $permissions['delete backup files'] = array(
    'name' => 'delete backup files',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: delete own case content
  $permissions['delete own case content'] = array(
    'name' => 'delete own case content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete own company content
  $permissions['delete own company content'] = array(
    'name' => 'delete own company content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete own customreport content
  $permissions['delete own customreport content'] = array(
    'name' => 'delete own customreport content',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: delete own filing content
  $permissions['delete own filing content'] = array(
    'name' => 'delete own filing content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete own firm content
  $permissions['delete own firm content'] = array(
    'name' => 'delete own firm content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete own individual content
  $permissions['delete own individual content'] = array(
    'name' => 'delete own individual content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete own page content
  $permissions['delete own page content'] = array(
    'name' => 'delete own page content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete own profile content
  $permissions['delete own profile content'] = array(
    'name' => 'delete own profile content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
    ),
  );

  // Exported permission: delete own rate content
  $permissions['delete own rate content'] = array(
    'name' => 'delete own rate content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete own search content
  $permissions['delete own search content'] = array(
    'name' => 'delete own search content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'Pilot Account',
      '4' => 'Rate Report User',
      '5' => 'SuperUser',
    ),
  );

  // Exported permission: delete own webform content
  $permissions['delete own webform content'] = array(
    'name' => 'delete own webform content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: delete own webform submissions
  $permissions['delete own webform submissions'] = array(
    'name' => 'delete own webform submissions',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: delete revisions
  $permissions['delete revisions'] = array(
    'name' => 'delete revisions',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: designate fields as unique
  $permissions['designate fields as unique'] = array(
    'name' => 'designate fields as unique',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: download saved searches
  $permissions['download saved searches'] = array(
    'name' => 'download saved searches',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'Pilot Account',
      '4' => 'Rate Report User',
      '5' => 'SuperUser',
    ),
  );

  // Exported permission: edit all webform submissions
  $permissions['edit all webform submissions'] = array(
    'name' => 'edit all webform submissions',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: edit any case content
  $permissions['edit any case content'] = array(
    'name' => 'edit any case content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit any company content
  $permissions['edit any company content'] = array(
    'name' => 'edit any company content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit any customreport content
  $permissions['edit any customreport content'] = array(
    'name' => 'edit any customreport content',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: edit any filing content
  $permissions['edit any filing content'] = array(
    'name' => 'edit any filing content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit any firm content
  $permissions['edit any firm content'] = array(
    'name' => 'edit any firm content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit any individual content
  $permissions['edit any individual content'] = array(
    'name' => 'edit any individual content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit any page content
  $permissions['edit any page content'] = array(
    'name' => 'edit any page content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit any profile content
  $permissions['edit any profile content'] = array(
    'name' => 'edit any profile content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: edit any rate content
  $permissions['edit any rate content'] = array(
    'name' => 'edit any rate content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit any search content
  $permissions['edit any search content'] = array(
    'name' => 'edit any search content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: edit any webform content
  $permissions['edit any webform content'] = array(
    'name' => 'edit any webform content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit custom reports
  $permissions['edit custom reports'] = array(
    'name' => 'edit custom reports',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_backref_117a8642a3448c6648
  $permissions['edit field_backref_117a8642a3448c6648'] = array(
    'name' => 'edit field_backref_117a8642a3448c6648',
    'roles' => array(),
  );

  // Exported permission: edit field_backref_2aea97edb04f0ed519
  $permissions['edit field_backref_2aea97edb04f0ed519'] = array(
    'name' => 'edit field_backref_2aea97edb04f0ed519',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_backref_2f69d1f84f8f3674f4
  $permissions['edit field_backref_2f69d1f84f8f3674f4'] = array(
    'name' => 'edit field_backref_2f69d1f84f8f3674f4',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_backref_5461abd5b4f3a38778
  $permissions['edit field_backref_5461abd5b4f3a38778'] = array(
    'name' => 'edit field_backref_5461abd5b4f3a38778',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_backref_cbf335fcbff2161996
  $permissions['edit field_backref_cbf335fcbff2161996'] = array(
    'name' => 'edit field_backref_cbf335fcbff2161996',
    'roles' => array(),
  );

  // Exported permission: edit field_backref_d6866cfb564dafb299
  $permissions['edit field_backref_d6866cfb564dafb299'] = array(
    'name' => 'edit field_backref_d6866cfb564dafb299',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_backref_e475abc38fa9939fb5
  $permissions['edit field_backref_e475abc38fa9939fb5'] = array(
    'name' => 'edit field_backref_e475abc38fa9939fb5',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_case1_court
  $permissions['edit field_case1_court'] = array(
    'name' => 'edit field_case1_court',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_case1_datefiled
  $permissions['edit field_case1_datefiled'] = array(
    'name' => 'edit field_case1_datefiled',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_case1_name
  $permissions['edit field_case1_name'] = array(
    'name' => 'edit field_case1_name',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_case1_natureofsuit
  $permissions['edit field_case1_natureofsuit'] = array(
    'name' => 'edit field_case1_natureofsuit',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_case1_number
  $permissions['edit field_case1_number'] = array(
    'name' => 'edit field_case1_number',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_case_feeappdates
  $permissions['edit field_case_feeappdates'] = array(
    'name' => 'edit field_case_feeappdates',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_case_filingdescription
  $permissions['edit field_case_filingdescription'] = array(
    'name' => 'edit field_case_filingdescription',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_case_filingnumber
  $permissions['edit field_case_filingnumber'] = array(
    'name' => 'edit field_case_filingnumber',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_client_industry
  $permissions['edit field_client_industry'] = array(
    'name' => 'edit field_client_industry',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_company_address
  $permissions['edit field_company_address'] = array(
    'name' => 'edit field_company_address',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_company_email
  $permissions['edit field_company_email'] = array(
    'name' => 'edit field_company_email',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_company_firstname
  $permissions['edit field_company_firstname'] = array(
    'name' => 'edit field_company_firstname',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_company_lastname
  $permissions['edit field_company_lastname'] = array(
    'name' => 'edit field_company_lastname',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_company_middleinitial
  $permissions['edit field_company_middleinitial'] = array(
    'name' => 'edit field_company_middleinitial',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_company_phone
  $permissions['edit field_company_phone'] = array(
    'name' => 'edit field_company_phone',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_company_position
  $permissions['edit field_company_position'] = array(
    'name' => 'edit field_company_position',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_filing_case
  $permissions['edit field_filing_case'] = array(
    'name' => 'edit field_filing_case',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_firm_headquarters
  $permissions['edit field_firm_headquarters'] = array(
    'name' => 'edit field_firm_headquarters',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_firm_ra
  $permissions['edit field_firm_ra'] = array(
    'name' => 'edit field_firm_ra',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_firm_type
  $permissions['edit field_firm_type'] = array(
    'name' => 'edit field_firm_type',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_bardate
  $permissions['edit field_individual_bardate'] = array(
    'name' => 'edit field_individual_bardate',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_city
  $permissions['edit field_individual_city'] = array(
    'name' => 'edit field_individual_city',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_firm
  $permissions['edit field_individual_firm'] = array(
    'name' => 'edit field_individual_firm',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_firmdate
  $permissions['edit field_individual_firmdate'] = array(
    'name' => 'edit field_individual_firmdate',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_firstname
  $permissions['edit field_individual_firstname'] = array(
    'name' => 'edit field_individual_firstname',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_graddate
  $permissions['edit field_individual_graddate'] = array(
    'name' => 'edit field_individual_graddate',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_lastname
  $permissions['edit field_individual_lastname'] = array(
    'name' => 'edit field_individual_lastname',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_middlename
  $permissions['edit field_individual_middlename'] = array(
    'name' => 'edit field_individual_middlename',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_pa1
  $permissions['edit field_individual_pa1'] = array(
    'name' => 'edit field_individual_pa1',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_pa2
  $permissions['edit field_individual_pa2'] = array(
    'name' => 'edit field_individual_pa2',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_pa3
  $permissions['edit field_individual_pa3'] = array(
    'name' => 'edit field_individual_pa3',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_partnerdate
  $permissions['edit field_individual_partnerdate'] = array(
    'name' => 'edit field_individual_partnerdate',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_individual_statebar
  $permissions['edit field_individual_statebar'] = array(
    'name' => 'edit field_individual_statebar',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_profile_compcircle
  $permissions['edit field_profile_compcircle'] = array(
    'name' => 'edit field_profile_compcircle',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_profile_email
  $permissions['edit field_profile_email'] = array(
    'name' => 'edit field_profile_email',
    'roles' => array(
      '0' => 'Alerts Add-On',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_profile_emailaddress
  $permissions['edit field_profile_emailaddress'] = array(
    'name' => 'edit field_profile_emailaddress',
    'roles' => array(
      '0' => 'Alerts Add-On',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_client
  $permissions['edit field_rate_client'] = array(
    'name' => 'edit field_rate_client',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_discount
  $permissions['edit field_rate_discount'] = array(
    'name' => 'edit field_rate_discount',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_feeslisted_calc
  $permissions['edit field_rate_feeslisted_calc'] = array(
    'name' => 'edit field_rate_feeslisted_calc',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_filing
  $permissions['edit field_rate_filing'] = array(
    'name' => 'edit field_rate_filing',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_firm
  $permissions['edit field_rate_firm'] = array(
    'name' => 'edit field_rate_firm',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_flatfee
  $permissions['edit field_rate_flatfee'] = array(
    'name' => 'edit field_rate_flatfee',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_hourly
  $permissions['edit field_rate_hourly'] = array(
    'name' => 'edit field_rate_hourly',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_hours
  $permissions['edit field_rate_hours'] = array(
    'name' => 'edit field_rate_hours',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_individual
  $permissions['edit field_rate_individual'] = array(
    'name' => 'edit field_rate_individual',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_notes
  $permissions['edit field_rate_notes'] = array(
    'name' => 'edit field_rate_notes',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_position1
  $permissions['edit field_rate_position1'] = array(
    'name' => 'edit field_rate_position1',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_refcompany
  $permissions['edit field_rate_refcompany'] = array(
    'name' => 'edit field_rate_refcompany',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_refcompattorney
  $permissions['edit field_rate_refcompattorney'] = array(
    'name' => 'edit field_rate_refcompattorney',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_referencedattorneys
  $permissions['edit field_rate_referencedattorneys'] = array(
    'name' => 'edit field_rate_referencedattorneys',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_retainer
  $permissions['edit field_rate_retainer'] = array(
    'name' => 'edit field_rate_retainer',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_secfiling
  $permissions['edit field_rate_secfiling'] = array(
    'name' => 'edit field_rate_secfiling',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_standard
  $permissions['edit field_rate_standard'] = array(
    'name' => 'edit field_rate_standard',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_success
  $permissions['edit field_rate_success'] = array(
    'name' => 'edit field_rate_success',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_total
  $permissions['edit field_rate_total'] = array(
    'name' => 'edit field_rate_total',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_totalfees
  $permissions['edit field_rate_totalfees'] = array(
    'name' => 'edit field_rate_totalfees',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_totalfees_calc
  $permissions['edit field_rate_totalfees_calc'] = array(
    'name' => 'edit field_rate_totalfees_calc',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_rate_transactional
  $permissions['edit field_rate_transactional'] = array(
    'name' => 'edit field_rate_transactional',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit field_search_baryear
  $permissions['edit field_search_baryear'] = array(
    'name' => 'edit field_search_baryear',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_city
  $permissions['edit field_search_city'] = array(
    'name' => 'edit field_search_city',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_columns
  $permissions['edit field_search_columns'] = array(
    'name' => 'edit field_search_columns',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_detail
  $permissions['edit field_search_detail'] = array(
    'name' => 'edit field_search_detail',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_firms
  $permissions['edit field_search_firms'] = array(
    'name' => 'edit field_search_firms',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_gradyear
  $permissions['edit field_search_gradyear'] = array(
    'name' => 'edit field_search_gradyear',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_industry
  $permissions['edit field_search_industry'] = array(
    'name' => 'edit field_search_industry',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_partneryear
  $permissions['edit field_search_partneryear'] = array(
    'name' => 'edit field_search_partneryear',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_position
  $permissions['edit field_search_position'] = array(
    'name' => 'edit field_search_position',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_practicearea
  $permissions['edit field_search_practicearea'] = array(
    'name' => 'edit field_search_practicearea',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit field_search_rateyear
  $permissions['edit field_search_rateyear'] = array(
    'name' => 'edit field_search_rateyear',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: edit own case content
  $permissions['edit own case content'] = array(
    'name' => 'edit own case content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit own company content
  $permissions['edit own company content'] = array(
    'name' => 'edit own company content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit own customreport content
  $permissions['edit own customreport content'] = array(
    'name' => 'edit own customreport content',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: edit own filing content
  $permissions['edit own filing content'] = array(
    'name' => 'edit own filing content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit own firm content
  $permissions['edit own firm content'] = array(
    'name' => 'edit own firm content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit own individual content
  $permissions['edit own individual content'] = array(
    'name' => 'edit own individual content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit own page content
  $permissions['edit own page content'] = array(
    'name' => 'edit own page content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit own profile content
  $permissions['edit own profile content'] = array(
    'name' => 'edit own profile content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
    ),
  );

  // Exported permission: edit own rate content
  $permissions['edit own rate content'] = array(
    'name' => 'edit own rate content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit own search content
  $permissions['edit own search content'] = array(
    'name' => 'edit own search content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'Pilot Account',
      '4' => 'Rate Report User',
      '5' => 'SuperUser',
    ),
  );

  // Exported permission: edit own webform content
  $permissions['edit own webform content'] = array(
    'name' => 'edit own webform content',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: edit own webform submissions
  $permissions['edit own webform submissions'] = array(
    'name' => 'edit own webform submissions',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: grant content access
  $permissions['grant content access'] = array(
    'name' => 'grant content access',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: grant own content access
  $permissions['grant own content access'] = array(
    'name' => 'grant own content access',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: manage features
  $permissions['manage features'] = array(
    'name' => 'manage features',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: manage statsbytime settings
  $permissions['manage statsbytime settings'] = array(
    'name' => 'manage statsbytime settings',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: node-specific print configuration
  $permissions['node-specific print configuration'] = array(
    'name' => 'node-specific print configuration',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: notify of path changes
  $permissions['notify of path changes'] = array(
    'name' => 'notify of path changes',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: opt-in or out of tracking
  $permissions['opt-in or out of tracking'] = array(
    'name' => 'opt-in or out of tracking',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: perform backup
  $permissions['perform backup'] = array(
    'name' => 'perform backup',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: restore from backup
  $permissions['restore from backup'] = array(
    'name' => 'restore from backup',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: revert revisions
  $permissions['revert revisions'] = array(
    'name' => 'revert revisions',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: select different theme
  $permissions['select different theme'] = array(
    'name' => 'select different theme',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: show format selection for blocks
  $permissions['show format selection for blocks'] = array(
    'name' => 'show format selection for blocks',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'anonymous user',
      '2' => 'authenticated user',
    ),
  );

  // Exported permission: show format selection for comments
  $permissions['show format selection for comments'] = array(
    'name' => 'show format selection for comments',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'anonymous user',
      '2' => 'authenticated user',
    ),
  );

  // Exported permission: show format selection for nodes
  $permissions['show format selection for nodes'] = array(
    'name' => 'show format selection for nodes',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'anonymous user',
      '2' => 'authenticated user',
    ),
  );

  // Exported permission: show format tips
  $permissions['show format tips'] = array(
    'name' => 'show format tips',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: show more format tips link
  $permissions['show more format tips link'] = array(
    'name' => 'show more format tips link',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: submit latitude/longitude
  $permissions['submit latitude/longitude'] = array(
    'name' => 'submit latitude/longitude',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: use PHP for block visibility
  $permissions['use PHP for block visibility'] = array(
    'name' => 'use PHP for block visibility',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: use PHP for link visibility
  $permissions['use PHP for link visibility'] = array(
    'name' => 'use PHP for link visibility',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: use PHP for me alias paths
  $permissions['use PHP for me alias paths'] = array(
    'name' => 'use PHP for me alias paths',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: use PHP for title patterns
  $permissions['use PHP for title patterns'] = array(
    'name' => 'use PHP for title patterns',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: use PHP for tracking visibility
  $permissions['use PHP for tracking visibility'] = array(
    'name' => 'use PHP for tracking visibility',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: use permission select
  $permissions['use permission select'] = array(
    'name' => 'use permission select',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: view advanced help index
  $permissions['view advanced help index'] = array(
    'name' => 'view advanced help index',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: view advanced help popup
  $permissions['view advanced help popup'] = array(
    'name' => 'view advanced help popup',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: view advanced help topic
  $permissions['view advanced help topic'] = array(
    'name' => 'view advanced help topic',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: view custom reports
  $permissions['view custom reports'] = array(
    'name' => 'view custom reports',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'Rate Report User',
      '3' => 'SuperUser',
    ),
  );

  // Exported permission: view date repeats
  $permissions['view date repeats'] = array(
    'name' => 'view date repeats',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_backref_117a8642a3448c6648
  $permissions['view field_backref_117a8642a3448c6648'] = array(
    'name' => 'view field_backref_117a8642a3448c6648',
    'roles' => array(),
  );

  // Exported permission: view field_backref_2aea97edb04f0ed519
  $permissions['view field_backref_2aea97edb04f0ed519'] = array(
    'name' => 'view field_backref_2aea97edb04f0ed519',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_backref_2f69d1f84f8f3674f4
  $permissions['view field_backref_2f69d1f84f8f3674f4'] = array(
    'name' => 'view field_backref_2f69d1f84f8f3674f4',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_backref_5461abd5b4f3a38778
  $permissions['view field_backref_5461abd5b4f3a38778'] = array(
    'name' => 'view field_backref_5461abd5b4f3a38778',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_backref_cbf335fcbff2161996
  $permissions['view field_backref_cbf335fcbff2161996'] = array(
    'name' => 'view field_backref_cbf335fcbff2161996',
    'roles' => array(),
  );

  // Exported permission: view field_backref_d6866cfb564dafb299
  $permissions['view field_backref_d6866cfb564dafb299'] = array(
    'name' => 'view field_backref_d6866cfb564dafb299',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_backref_e475abc38fa9939fb5
  $permissions['view field_backref_e475abc38fa9939fb5'] = array(
    'name' => 'view field_backref_e475abc38fa9939fb5',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_case1_court
  $permissions['view field_case1_court'] = array(
    'name' => 'view field_case1_court',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_case1_datefiled
  $permissions['view field_case1_datefiled'] = array(
    'name' => 'view field_case1_datefiled',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_case1_name
  $permissions['view field_case1_name'] = array(
    'name' => 'view field_case1_name',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_case1_natureofsuit
  $permissions['view field_case1_natureofsuit'] = array(
    'name' => 'view field_case1_natureofsuit',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_case1_number
  $permissions['view field_case1_number'] = array(
    'name' => 'view field_case1_number',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_case_feeappdates
  $permissions['view field_case_feeappdates'] = array(
    'name' => 'view field_case_feeappdates',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_case_filingdescription
  $permissions['view field_case_filingdescription'] = array(
    'name' => 'view field_case_filingdescription',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_case_filingnumber
  $permissions['view field_case_filingnumber'] = array(
    'name' => 'view field_case_filingnumber',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_client_industry
  $permissions['view field_client_industry'] = array(
    'name' => 'view field_client_industry',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_company_address
  $permissions['view field_company_address'] = array(
    'name' => 'view field_company_address',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_company_email
  $permissions['view field_company_email'] = array(
    'name' => 'view field_company_email',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_company_firstname
  $permissions['view field_company_firstname'] = array(
    'name' => 'view field_company_firstname',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_company_lastname
  $permissions['view field_company_lastname'] = array(
    'name' => 'view field_company_lastname',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_company_middleinitial
  $permissions['view field_company_middleinitial'] = array(
    'name' => 'view field_company_middleinitial',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_company_phone
  $permissions['view field_company_phone'] = array(
    'name' => 'view field_company_phone',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_company_position
  $permissions['view field_company_position'] = array(
    'name' => 'view field_company_position',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_filing_case
  $permissions['view field_filing_case'] = array(
    'name' => 'view field_filing_case',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_firm_headquarters
  $permissions['view field_firm_headquarters'] = array(
    'name' => 'view field_firm_headquarters',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_firm_ra
  $permissions['view field_firm_ra'] = array(
    'name' => 'view field_firm_ra',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_firm_type
  $permissions['view field_firm_type'] = array(
    'name' => 'view field_firm_type',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_bardate
  $permissions['view field_individual_bardate'] = array(
    'name' => 'view field_individual_bardate',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_city
  $permissions['view field_individual_city'] = array(
    'name' => 'view field_individual_city',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_firm
  $permissions['view field_individual_firm'] = array(
    'name' => 'view field_individual_firm',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_firmdate
  $permissions['view field_individual_firmdate'] = array(
    'name' => 'view field_individual_firmdate',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_firstname
  $permissions['view field_individual_firstname'] = array(
    'name' => 'view field_individual_firstname',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_graddate
  $permissions['view field_individual_graddate'] = array(
    'name' => 'view field_individual_graddate',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_lastname
  $permissions['view field_individual_lastname'] = array(
    'name' => 'view field_individual_lastname',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_middlename
  $permissions['view field_individual_middlename'] = array(
    'name' => 'view field_individual_middlename',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_pa1
  $permissions['view field_individual_pa1'] = array(
    'name' => 'view field_individual_pa1',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_pa2
  $permissions['view field_individual_pa2'] = array(
    'name' => 'view field_individual_pa2',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_pa3
  $permissions['view field_individual_pa3'] = array(
    'name' => 'view field_individual_pa3',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_partnerdate
  $permissions['view field_individual_partnerdate'] = array(
    'name' => 'view field_individual_partnerdate',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_individual_statebar
  $permissions['view field_individual_statebar'] = array(
    'name' => 'view field_individual_statebar',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_profile_compcircle
  $permissions['view field_profile_compcircle'] = array(
    'name' => 'view field_profile_compcircle',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_profile_email
  $permissions['view field_profile_email'] = array(
    'name' => 'view field_profile_email',
    'roles' => array(
      '0' => 'Alerts Add-On',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: view field_profile_emailaddress
  $permissions['view field_profile_emailaddress'] = array(
    'name' => 'view field_profile_emailaddress',
    'roles' => array(
      '0' => 'Alerts Add-On',
      '1' => 'SuperUser',
    ),
  );

  // Exported permission: view field_rate_client
  $permissions['view field_rate_client'] = array(
    'name' => 'view field_rate_client',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_discount
  $permissions['view field_rate_discount'] = array(
    'name' => 'view field_rate_discount',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_feeslisted_calc
  $permissions['view field_rate_feeslisted_calc'] = array(
    'name' => 'view field_rate_feeslisted_calc',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_rate_filing
  $permissions['view field_rate_filing'] = array(
    'name' => 'view field_rate_filing',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_firm
  $permissions['view field_rate_firm'] = array(
    'name' => 'view field_rate_firm',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_flatfee
  $permissions['view field_rate_flatfee'] = array(
    'name' => 'view field_rate_flatfee',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_rate_hourly
  $permissions['view field_rate_hourly'] = array(
    'name' => 'view field_rate_hourly',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_hours
  $permissions['view field_rate_hours'] = array(
    'name' => 'view field_rate_hours',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_individual
  $permissions['view field_rate_individual'] = array(
    'name' => 'view field_rate_individual',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_notes
  $permissions['view field_rate_notes'] = array(
    'name' => 'view field_rate_notes',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_position1
  $permissions['view field_rate_position1'] = array(
    'name' => 'view field_rate_position1',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_refcompany
  $permissions['view field_rate_refcompany'] = array(
    'name' => 'view field_rate_refcompany',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_refcompattorney
  $permissions['view field_rate_refcompattorney'] = array(
    'name' => 'view field_rate_refcompattorney',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_referencedattorneys
  $permissions['view field_rate_referencedattorneys'] = array(
    'name' => 'view field_rate_referencedattorneys',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_rate_retainer
  $permissions['view field_rate_retainer'] = array(
    'name' => 'view field_rate_retainer',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_secfiling
  $permissions['view field_rate_secfiling'] = array(
    'name' => 'view field_rate_secfiling',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_rate_standard
  $permissions['view field_rate_standard'] = array(
    'name' => 'view field_rate_standard',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_success
  $permissions['view field_rate_success'] = array(
    'name' => 'view field_rate_success',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_rate_total
  $permissions['view field_rate_total'] = array(
    'name' => 'view field_rate_total',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Alerts Add-On',
      '2' => 'Data Entry',
      '3' => 'SuperUser',
      '4' => 'authenticated user',
    ),
  );

  // Exported permission: view field_rate_totalfees
  $permissions['view field_rate_totalfees'] = array(
    'name' => 'view field_rate_totalfees',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_rate_totalfees_calc
  $permissions['view field_rate_totalfees_calc'] = array(
    'name' => 'view field_rate_totalfees_calc',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_rate_transactional
  $permissions['view field_rate_transactional'] = array(
    'name' => 'view field_rate_transactional',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view field_search_baryear
  $permissions['view field_search_baryear'] = array(
    'name' => 'view field_search_baryear',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_city
  $permissions['view field_search_city'] = array(
    'name' => 'view field_search_city',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_columns
  $permissions['view field_search_columns'] = array(
    'name' => 'view field_search_columns',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_detail
  $permissions['view field_search_detail'] = array(
    'name' => 'view field_search_detail',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_firms
  $permissions['view field_search_firms'] = array(
    'name' => 'view field_search_firms',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_gradyear
  $permissions['view field_search_gradyear'] = array(
    'name' => 'view field_search_gradyear',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_industry
  $permissions['view field_search_industry'] = array(
    'name' => 'view field_search_industry',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_partneryear
  $permissions['view field_search_partneryear'] = array(
    'name' => 'view field_search_partneryear',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_position
  $permissions['view field_search_position'] = array(
    'name' => 'view field_search_position',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_practicearea
  $permissions['view field_search_practicearea'] = array(
    'name' => 'view field_search_practicearea',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view field_search_rateyear
  $permissions['view field_search_rateyear'] = array(
    'name' => 'view field_search_rateyear',
    'roles' => array(
      '0' => 'SuperUser',
      '1' => 'authenticated user',
    ),
  );

  // Exported permission: view forms without filtering
  $permissions['view forms without filtering'] = array(
    'name' => 'view forms without filtering',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: view location directory
  $permissions['view location directory'] = array(
    'name' => 'view location directory',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: view node location table
  $permissions['view node location table'] = array(
    'name' => 'view node location table',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  // Exported permission: view revisions
  $permissions['view revisions'] = array(
    'name' => 'view revisions',
    'roles' => array(
      '0' => 'Administrator',
      '1' => 'Data Entry',
      '2' => 'SuperUser',
    ),
  );

  // Exported permission: view user location table
  $permissions['view user location table'] = array(
    'name' => 'view user location table',
    'roles' => array(
      '0' => 'SuperUser',
    ),
  );

  return $permissions;
}
