<?php

/**
 * Implementation of hook_user_default_roles().
 */
function valeo_roles_user_default_roles() {
  $roles = array();

  // Exported role: Administrator
  $roles['Administrator'] = array(
    'name' => 'Administrator',
  );

  // Exported role: Alerts Add-On
  $roles['Alerts Add-On'] = array(
    'name' => 'Alerts Add-On',
  );

  // Exported role: Data Entry
  $roles['Data Entry'] = array(
    'name' => 'Data Entry',
  );

  // Exported role: Fee Search Add-On
  $roles['Fee Search Add-On'] = array(
    'name' => 'Fee Search Add-On',
  );

  // Exported role: Firm Rate Profile Add-On
  $roles['Firm Rate Profile Add-On'] = array(
    'name' => 'Firm Rate Profile Add-On',
  );

  // Exported role: Pilot Account
  $roles['Pilot Account'] = array(
    'name' => 'Pilot Account',
  );

  // Exported role: Rate Report User
  $roles['Rate Report User'] = array(
    'name' => 'Rate Report User',
  );

  // Exported role: SuperUser
  $roles['SuperUser'] = array(
    'name' => 'SuperUser',
  );

  // Exported role: anonymous user
  $roles['anonymous user'] = array(
    'name' => 'anonymous user',
  );

  // Exported role: authenticated user
  $roles['authenticated user'] = array(
    'name' => 'authenticated user',
  );

  return $roles;
}
