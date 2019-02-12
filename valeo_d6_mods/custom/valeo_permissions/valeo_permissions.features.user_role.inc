<?php

/**
 * Implementation of hook_user_default_roles().
 */
function valeo_permissions_user_default_roles() {
  $roles = array();

  // Exported role: Company/Industry Add-On
  $roles['Company/Industry Add-On'] = array(
    'name' => 'Company/Industry Add-On',
  );

  // Exported role: Full Database Download Add-On
  $roles['Full Database Download Add-On'] = array(
    'name' => 'Full Database Download Add-On',
  );

  return $roles;
}
