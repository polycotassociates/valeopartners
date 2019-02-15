<?php

/**
 * Implementation of hook_content_default_fields().
 */
function valeo_content_types_content_default_fields() {
  $fields = array();

  // Exported field: field_backref_2f69d1f84f8f3674f4
  $fields['case-field_backref_2f69d1f84f8f3674f4'] = array(
    'field_name' => 'field_backref_2f69d1f84f8f3674f4',
    'type_name' => 'case',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'noderelationships_backref',
    'required' => '0',
    'multiple' => '0',
    'module' => 'noderelationships',
    'active' => '1',
    'referrer_type' => 'filing',
    'referrer_field' => 'field_filing_case',
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Filings Associated with this Case',
      'weight' => '1',
      'description' => '',
      'type' => 'noderelationships_backref',
      'module' => 'noderelationships',
    ),
  );

  // Exported field: field_case1_court
  $fields['case-field_case1_court'] = array(
    'field_name' => 'field_case1_court',
    'type_name' => 'case',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '2',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => NULL,
      'default_value_php' => NULL,
      'new_terms' => 'insert',
      'extra_parent' => '0',
      'maxlength' => '255',
      'label' => 'Court',
      'weight' => '-2',
      'description' => 'Start typing the name of the court to find it in the database.',
      'type' => 'content_taxonomy_autocomplete',
      'module' => 'content_taxonomy_autocomplete',
    ),
  );

  // Exported field: field_case1_datefiled
  $fields['case-field_case1_datefiled'] = array(
    'field_name' => 'field_case1_datefiled',
    'type_name' => 'case',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '0',
    'multiple' => '0',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
      'month' => 'month',
      'day' => 'day',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => '',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'short',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - H:i',
      'input_format_custom' => '',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-20:+0',
      'label_position' => 'above',
      'label' => 'Date Filed',
      'weight' => '-1',
      'description' => '',
      'type' => 'date_popup',
      'module' => 'date',
    ),
  );

  // Exported field: field_case1_name
  $fields['case-field_case1_name'] = array(
    'field_name' => 'field_case1_name',
    'type_name' => 'case',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '1',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_case1_name][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Case Name',
      'weight' => '-3',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_case1_natureofsuit
  $fields['case-field_case1_natureofsuit'] = array(
    'field_name' => 'field_case1_natureofsuit',
    'type_name' => 'case',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '19',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        '0' => array(
          'value' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Nature of Suit',
      'weight' => 0,
      'description' => '',
      'type' => 'content_taxonomy_select',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_case1_number
  $fields['case-field_case1_number'] = array(
    'field_name' => 'field_case1_number',
    'type_name' => 'case',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '1',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_case1_number][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Case Number',
      'weight' => '-4',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_client_industry
  $fields['company-field_client_industry'] = array(
    'field_name' => 'field_client_industry',
    'type_name' => 'company',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '14',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 0,
      'default_value' => array(
        '0' => array(
          'value' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Industry',
      'weight' => '-4',
      'description' => 'Select the industry with which this client is primarily involved.',
      'type' => 'content_taxonomy_select',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_company_address
  $fields['company-field_company_address'] = array(
    'field_name' => 'field_company_address',
    'type_name' => 'company',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'location',
    'required' => '0',
    'multiple' => '0',
    'module' => 'location_cck',
    'active' => '1',
    'location_settings' => array(
      'form' => array(
        'fields' => array(
          'name' => array(
            'collect' => '0',
            'default' => '',
            'weight' => '2',
          ),
          'street' => array(
            'collect' => '1',
            'default' => '',
            'weight' => '4',
          ),
          'additional' => array(
            'collect' => '1',
            'default' => '',
            'weight' => '6',
          ),
          'city' => array(
            'collect' => '1',
            'default' => '',
            'weight' => '8',
          ),
          'province' => array(
            'collect' => '1',
            'widget' => 'select',
            'default' => '',
            'weight' => '10',
          ),
          'postal_code' => array(
            'collect' => '1',
            'default' => '',
            'weight' => '12',
          ),
          'country' => array(
            'collect' => '1',
            'default' => 'us',
            'weight' => '14',
          ),
          'locpick' => array(
            'collect' => '0',
            'weight' => '20',
          ),
        ),
      ),
      'display' => array(
        'hide' => array(
          'name' => 'name',
          'locpick' => 'locpick',
          'province_name' => 'province_name',
          'country_name' => 'country_name',
          'map_link' => 'map_link',
          'coords' => 'coords',
          'street' => 0,
          'additional' => 0,
          'city' => 0,
          'province' => 0,
          'postal_code' => 0,
          'country' => 0,
        ),
      ),
    ),
    'gmap_macro' => '[gmap ]',
    'gmap_marker' => 'drupal',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'name' => '',
          'street' => '',
          'additional' => '',
          'country' => 'us',
          'locpick' => array(
            'user_latitude' => '',
            'user_longitude' => '',
          ),
          'cck_preview_in_progress' => TRUE,
          'location_settings' => array(
            'form' => array(
              'fields' => array(
                'lid' => array(
                  'default' => FALSE,
                ),
                'name' => array(
                  'default' => '',
                  'collect' => 1,
                  'weight' => 2,
                ),
                'street' => array(
                  'default' => '',
                  'collect' => 1,
                  'weight' => 4,
                ),
                'additional' => array(
                  'default' => '',
                  'collect' => 1,
                  'weight' => 6,
                ),
                'city' => array(
                  'default' => '',
                  'collect' => 0,
                  'weight' => 8,
                ),
                'province' => array(
                  'default' => '',
                  'collect' => 0,
                  'weight' => 10,
                  'widget' => 'autocomplete',
                ),
                'postal_code' => array(
                  'default' => '',
                  'collect' => 0,
                  'weight' => 12,
                ),
                'country' => array(
                  'default' => 'us',
                  'collect' => 1,
                  'weight' => 14,
                ),
                'locpick' => array(
                  'default' => FALSE,
                  'collect' => 1,
                  'weight' => 20,
                  'nodiff' => TRUE,
                ),
                'latitude' => array(
                  'default' => 0,
                ),
                'longitude' => array(
                  'default' => 0,
                ),
                'source' => array(
                  'default' => 0,
                ),
                'is_primary' => array(
                  'default' => 0,
                ),
                'delete_location' => array(
                  'default' => FALSE,
                  'nodiff' => TRUE,
                ),
              ),
            ),
          ),
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Address',
      'weight' => '9',
      'description' => '',
      'type' => 'location',
      'module' => 'location_cck',
    ),
  );

  // Exported field: field_company_email
  $fields['company-field_company_email'] = array(
    'field_name' => 'field_company_email',
    'type_name' => 'company',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'email',
    'required' => '0',
    'multiple' => '0',
    'module' => 'email',
    'active' => '1',
    'widget' => array(
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'email' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Email',
      'weight' => '11',
      'description' => '',
      'type' => 'email_textfield',
      'module' => 'email',
    ),
  );

  // Exported field: field_company_firstname
  $fields['company-field_company_firstname'] = array(
    'field_name' => 'field_company_firstname',
    'type_name' => 'company',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_company_firstname][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'First Name',
      'weight' => '5',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_company_lastname
  $fields['company-field_company_lastname'] = array(
    'field_name' => 'field_company_lastname',
    'type_name' => 'company',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_company_lastname][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Last Name',
      'weight' => '7',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_company_middleinitial
  $fields['company-field_company_middleinitial'] = array(
    'field_name' => 'field_company_middleinitial',
    'type_name' => 'company',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '5',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_company_middleinitial][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Middle Initial',
      'weight' => '6',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_company_phone
  $fields['company-field_company_phone'] = array(
    'field_name' => 'field_company_phone',
    'type_name' => 'company',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'phone_number',
    'required' => '0',
    'multiple' => '0',
    'module' => 'cck_phone',
    'active' => '1',
    'default_country' => 'us',
    'all_country_codes' => 1,
    'country_selection' => array(
      'af' => 'af',
      'us' => 'us',
      'al' => 0,
      'dz' => 0,
      'as' => 0,
      'ad' => 0,
      'ao' => 0,
      'ai' => 0,
      'ag' => 0,
      'ar' => 0,
      'am' => 0,
      'aw' => 0,
      'au' => 0,
      'at' => 0,
      'az' => 0,
      'bs' => 0,
      'bh' => 0,
      'bd' => 0,
      'bb' => 0,
      'by' => 0,
      'be' => 0,
      'bz' => 0,
      'bj' => 0,
      'bm' => 0,
      'bt' => 0,
      'bo' => 0,
      'ba' => 0,
      'bw' => 0,
      'br' => 0,
      'io' => 0,
      'vg' => 0,
      'bn' => 0,
      'bg' => 0,
      'bf' => 0,
      'bi' => 0,
      'kh' => 0,
      'cm' => 0,
      'ca' => 0,
      'cv' => 0,
      'ky' => 0,
      'cf' => 0,
      'td' => 0,
      'cl' => 0,
      'cn' => 0,
      'cx' => 0,
      'cc' => 0,
      'co' => 0,
      'km' => 0,
      'cg' => 0,
      'cd' => 0,
      'ck' => 0,
      'cr' => 0,
      'hr' => 0,
      'cu' => 0,
      'cy' => 0,
      'cz' => 0,
      'dk' => 0,
      'dj' => 0,
      'dm' => 0,
      'do' => 0,
      'tp' => 0,
      'ec' => 0,
      'eg' => 0,
      'sv' => 0,
      'gq' => 0,
      'er' => 0,
      'ee' => 0,
      'et' => 0,
      'fk' => 0,
      'fo' => 0,
      'fj' => 0,
      'fi' => 0,
      'fr' => 0,
      'gf' => 0,
      'pf' => 0,
      'ga' => 0,
      'gm' => 0,
      'ge' => 0,
      'de' => 0,
      'gh' => 0,
      'gi' => 0,
      'gr' => 0,
      'gl' => 0,
      'gd' => 0,
      'gp' => 0,
      'gu' => 0,
      'gt' => 0,
      'gn' => 0,
      'gw' => 0,
      'gy' => 0,
      'ht' => 0,
      'hn' => 0,
      'hk' => 0,
      'hu' => 0,
      'is' => 0,
      'in' => 0,
      'id' => 0,
      'ir' => 0,
      'iq' => 0,
      'ie' => 0,
      'il' => 0,
      'it' => 0,
      'ci' => 0,
      'jm' => 0,
      'jp' => 0,
      'jo' => 0,
      'kz' => 0,
      'ke' => 0,
      'ki' => 0,
      'kw' => 0,
      'kg' => 0,
      'la' => 0,
      'lv' => 0,
      'lb' => 0,
      'ls' => 0,
      'lr' => 0,
      'ly' => 0,
      'li' => 0,
      'lt' => 0,
      'lu' => 0,
      'mo' => 0,
      'mk' => 0,
      'mg' => 0,
      'mw' => 0,
      'my' => 0,
      'mv' => 0,
      'ml' => 0,
      'mt' => 0,
      'mh' => 0,
      'mq' => 0,
      'mr' => 0,
      'mu' => 0,
      'yt' => 0,
      'mx' => 0,
      'fm' => 0,
      'md' => 0,
      'mc' => 0,
      'mn' => 0,
      'me' => 0,
      'ms' => 0,
      'ma' => 0,
      'mz' => 0,
      'mm' => 0,
      'na' => 0,
      'nr' => 0,
      'np' => 0,
      'nl' => 0,
      'an' => 0,
      'nc' => 0,
      'nz' => 0,
      'ni' => 0,
      'ne' => 0,
      'ng' => 0,
      'nu' => 0,
      'nf' => 0,
      'kp' => 0,
      'mp' => 0,
      'no' => 0,
      'om' => 0,
      'pk' => 0,
      'pw' => 0,
      'ps' => 0,
      'pa' => 0,
      'pg' => 0,
      'py' => 0,
      'pe' => 0,
      'ph' => 0,
      'pl' => 0,
      'pt' => 0,
      'pr' => 0,
      'qa' => 0,
      'ro' => 0,
      'ru' => 0,
      'rw' => 0,
      'sh' => 0,
      'kn' => 0,
      'lc' => 0,
      'pm' => 0,
      'vc' => 0,
      'ws' => 0,
      'sm' => 0,
      'st' => 0,
      'sa' => 0,
      'sn' => 0,
      'rs' => 0,
      'sc' => 0,
      'sl' => 0,
      'sg' => 0,
      'sk' => 0,
      'si' => 0,
      'sb' => 0,
      'so' => 0,
      'za' => 0,
      'kr' => 0,
      'ss' => 0,
      'es' => 0,
      'lk' => 0,
      'sd' => 0,
      'sr' => 0,
      'sz' => 0,
      'se' => 0,
      'ch' => 0,
      'sy' => 0,
      'tw' => 0,
      'tj' => 0,
      'tz' => 0,
      'th' => 0,
      'tg' => 0,
      'tk' => 0,
      'to' => 0,
      'tt' => 0,
      'tn' => 0,
      'tr' => 0,
      'tm' => 0,
      'tc' => 0,
      'tv' => 0,
      'ug' => 0,
      'ua' => 0,
      'ae' => 0,
      'gb' => 0,
      'uy' => 0,
      'vi' => 0,
      'uz' => 0,
      'vu' => 0,
      'va' => 0,
      've' => 0,
      'vn' => 0,
      'wf' => 0,
      'ye' => 0,
      'zm' => 0,
      'zw' => 0,
    ),
    'enable_custom_country' => 1,
    'enable_extension' => 1,
    'enable_mobile' => 0,
    'widget' => array(
      'size' => '15',
      'default_value' => array(
        '0' => array(
          'number' => '',
          'country_codes' => 'af',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Phone',
      'weight' => '10',
      'description' => '',
      'type' => 'phone_number',
      'module' => 'cck_phone',
    ),
  );

  // Exported field: field_company_position
  $fields['company-field_company_position'] = array(
    'field_name' => 'field_company_position',
    'type_name' => 'company',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_company_position][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Position',
      'weight' => '8',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_backref_5461abd5b4f3a38778
  $fields['filing-field_backref_5461abd5b4f3a38778'] = array(
    'field_name' => 'field_backref_5461abd5b4f3a38778',
    'type_name' => 'filing',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'noderelationships_backref',
    'required' => '0',
    'multiple' => '0',
    'module' => 'noderelationships',
    'active' => '1',
    'referrer_type' => 'rate',
    'referrer_field' => 'field_rate_filing',
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Rates & Fees Associated with this Filing',
      'weight' => 0,
      'description' => '',
      'type' => 'noderelationships_backref',
      'module' => 'noderelationships',
    ),
  );

  // Exported field: field_case_feeappdates
  $fields['filing-field_case_feeappdates'] = array(
    'field_name' => 'field_case_feeappdates',
    'type_name' => 'filing',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '1',
    'multiple' => '0',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
      'month' => 'month',
      'day' => 'day',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => 'optional',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'short',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - g:ia',
      'input_format_custom' => '',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-20:+0',
      'label_position' => 'above',
      'label' => 'Fee Date Range',
      'weight' => '-3',
      'description' => '',
      'type' => 'date_popup',
      'module' => 'date',
    ),
  );

  // Exported field: field_case_filingdescription
  $fields['filing-field_case_filingdescription'] = array(
    'field_name' => 'field_case_filingdescription',
    'type_name' => 'filing',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => '5',
      'size' => 60,
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_case_filingdescription][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Filing Description',
      'weight' => '-1',
      'description' => '',
      'type' => 'text_textarea',
      'module' => 'text',
    ),
  );

  // Exported field: field_case_filingnumber
  $fields['filing-field_case_filingnumber'] = array(
    'field_name' => 'field_case_filingnumber',
    'type_name' => 'filing',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_case_filingnumber][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Filing Number',
      'weight' => '-2',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_filing_case
  $fields['filing-field_filing_case'] = array(
    'field_name' => 'field_filing_case',
    'type_name' => 'filing',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '1',
    'multiple' => '0',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'case' => 'case',
      'customreport' => 0,
      'filing' => 0,
      'firm' => 0,
      'individual' => 0,
      'page' => 0,
      'rate' => 0,
      'company' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'contains',
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
          '_error_element' => 'default_value_widget][field_filing_case][0][nid][nid',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Case',
      'weight' => '-4',
      'description' => '',
      'type' => 'nodereference_autocomplete',
      'module' => 'nodereference',
    ),
  );

  // Exported field: field_backref_2aea97edb04f0ed519
  $fields['firm-field_backref_2aea97edb04f0ed519'] = array(
    'field_name' => 'field_backref_2aea97edb04f0ed519',
    'type_name' => 'firm',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'noderelationships_backref',
    'required' => '0',
    'multiple' => '0',
    'module' => 'noderelationships',
    'active' => '1',
    'referrer_type' => 'individual',
    'referrer_field' => 'field_individual_firm',
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Individuals with an Employment History at this Firm',
      'weight' => 0,
      'description' => '',
      'type' => 'noderelationships_backref',
      'module' => 'noderelationships',
    ),
  );

  // Exported field: field_backref_d6866cfb564dafb299
  $fields['firm-field_backref_d6866cfb564dafb299'] = array(
    'field_name' => 'field_backref_d6866cfb564dafb299',
    'type_name' => 'firm',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'noderelationships_backref',
    'required' => '0',
    'multiple' => '0',
    'module' => 'noderelationships',
    'active' => '1',
    'referrer_type' => 'rate',
    'referrer_field' => 'field_rate_firm',
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Rates & Fees Recorded for this Firm',
      'weight' => '1',
      'description' => '',
      'type' => 'noderelationships_backref',
      'module' => 'noderelationships',
    ),
  );

  // Exported field: field_firm_headquarters
  $fields['firm-field_firm_headquarters'] = array(
    'field_name' => 'field_firm_headquarters',
    'type_name' => 'firm',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '6',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        'field_firm_headquarters' => array(
          'tids' => NULL,
        ),
      ),
      'default_value_php' => NULL,
      'new_terms' => 'insert',
      'extra_parent' => '0',
      'maxlength' => '60',
      'label' => 'Headquarters',
      'weight' => '-4',
      'description' => '',
      'type' => 'content_taxonomy_hs',
      'module' => 'hs_content_taxonomy',
    ),
  );

  // Exported field: field_firm_ra
  $fields['firm-field_firm_ra'] = array(
    'field_name' => 'field_firm_ra',
    'type_name' => 'firm',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'userreference',
    'required' => '0',
    'multiple' => '0',
    'module' => 'userreference',
    'active' => '1',
    'referenceable_roles' => array(
      '7' => 7,
      '2' => 0,
      '3' => 0,
      '8' => 0,
      '9' => 0,
      '11' => 0,
      '10' => 0,
      '6' => 0,
      '4' => 0,
      '5' => 0,
    ),
    'referenceable_status' => '1',
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'contains',
      'size' => 60,
      'reverse_link' => 0,
      'default_value' => array(
        '0' => array(
          'uid' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Research Associate',
      'weight' => '-2',
      'description' => 'Select the RA who is responsible for updating this firm.',
      'type' => 'userreference_select',
      'module' => 'userreference',
    ),
  );

  // Exported field: field_firm_type
  $fields['firm-field_firm_type'] = array(
    'field_name' => 'field_firm_type',
    'type_name' => 'firm',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '9',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        '0' => array(
          'value' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Type',
      'weight' => '-3',
      'description' => '',
      'type' => 'content_taxonomy_select',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_backref_117a8642a3448c6648
  $fields['individual-field_backref_117a8642a3448c6648'] = array(
    'field_name' => 'field_backref_117a8642a3448c6648',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'noderelationships_backref',
    'required' => '0',
    'multiple' => '0',
    'module' => 'noderelationships',
    'active' => '1',
    'referrer_type' => 'rate',
    'referrer_field' => 'field_rate_referencedattorneys',
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Referenced Attorneys in Rate and Fees',
      'weight' => '10',
      'description' => '',
      'type' => 'noderelationships_backref',
      'module' => 'noderelationships',
    ),
  );

  // Exported field: field_backref_cbf335fcbff2161996
  $fields['individual-field_backref_cbf335fcbff2161996'] = array(
    'field_name' => 'field_backref_cbf335fcbff2161996',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'noderelationships_backref',
    'required' => '0',
    'multiple' => '0',
    'module' => 'noderelationships',
    'active' => '1',
    'referrer_type' => 'rate',
    'referrer_field' => 'field_rate_refcompattorney',
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Referenced Company Attorney in Rate and Fees',
      'weight' => '11',
      'description' => '',
      'type' => 'noderelationships_backref',
      'module' => 'noderelationships',
    ),
  );

  // Exported field: field_backref_e475abc38fa9939fb5
  $fields['individual-field_backref_e475abc38fa9939fb5'] = array(
    'field_name' => 'field_backref_e475abc38fa9939fb5',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'noderelationships_backref',
    'required' => '0',
    'multiple' => '0',
    'module' => 'noderelationships',
    'active' => '1',
    'referrer_type' => 'rate',
    'referrer_field' => 'field_rate_individual',
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Rates & Fees Recorded for this Individual',
      'weight' => '7',
      'description' => '',
      'type' => 'noderelationships_backref',
      'module' => 'noderelationships',
    ),
  );

  // Exported field: field_individual_bardate
  $fields['individual-field_individual_bardate'] = array(
    'field_name' => 'field_individual_bardate',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '0',
    'multiple' => '0',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => '',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'year_only',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - g:i:sa',
      'input_format_custom' => 'Y',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-80:+0',
      'label_position' => 'above',
      'label' => 'Bar Date',
      'weight' => '5',
      'description' => '',
      'type' => 'date_select',
      'module' => 'date',
    ),
  );

  // Exported field: field_individual_city
  $fields['individual-field_individual_city'] = array(
    'field_name' => 'field_individual_city',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '6',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => NULL,
      'default_value_php' => NULL,
      'new_terms' => 'insert',
      'extra_parent' => '0',
      'maxlength' => '255',
      'label' => 'Country / Region / State / City',
      'weight' => '-1',
      'description' => '',
      'type' => 'content_taxonomy_hs',
      'module' => 'hs_content_taxonomy',
    ),
  );

  // Exported field: field_individual_firm
  $fields['individual-field_individual_firm'] = array(
    'field_name' => 'field_individual_firm',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '0',
    'multiple' => '1',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'firm' => 'firm',
      'customreport' => 0,
      'individual' => 0,
      'page' => 0,
      'rate' => 0,
      'filing' => 0,
      'company' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'starts_with',
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
          '_error_element' => 'default_value_widget][field_individual_firm][0][nid][nid',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Firm',
      'weight' => '6',
      'description' => 'To locate a firm, start typing the name or click the magnifying glass icon to search. If the firm isn\'t already in the database, click the plus sign to add it.',
      'type' => 'nodereference_autocomplete',
      'module' => 'nodereference',
    ),
  );

  // Exported field: field_individual_firmdate
  $fields['individual-field_individual_firmdate'] = array(
    'field_name' => 'field_individual_firmdate',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '0',
    'multiple' => '1',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => '',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'year_only',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - g:i:sa',
      'input_format_custom' => 'Y',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-80:+0',
      'label_position' => 'above',
      'label' => 'Firm Date',
      'weight' => '8',
      'description' => '',
      'type' => 'date_select',
      'module' => 'date',
    ),
  );

  // Exported field: field_individual_firstname
  $fields['individual-field_individual_firstname'] = array(
    'field_name' => 'field_individual_firstname',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '1',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_individual_firstname][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'First Name',
      'weight' => '-4',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_individual_graddate
  $fields['individual-field_individual_graddate'] = array(
    'field_name' => 'field_individual_graddate',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '0',
    'multiple' => '0',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => '',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'year_only',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - g:i:sa',
      'input_format_custom' => 'Y',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-80:+0',
      'label_position' => 'above',
      'label' => 'Graduation Date',
      'weight' => '3',
      'description' => '',
      'type' => 'date_select',
      'module' => 'date',
    ),
  );

  // Exported field: field_individual_lastname
  $fields['individual-field_individual_lastname'] = array(
    'field_name' => 'field_individual_lastname',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '1',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_individual_lastname][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Last Name',
      'weight' => '-2',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_individual_middlename
  $fields['individual-field_individual_middlename'] = array(
    'field_name' => 'field_individual_middlename',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_individual_middlename][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Middle Name',
      'weight' => '-3',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_individual_pa1
  $fields['individual-field_individual_pa1'] = array(
    'field_name' => 'field_individual_pa1',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '1',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        '0' => array(
          'value' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Practice Area 1',
      'weight' => 0,
      'description' => '',
      'type' => 'content_taxonomy_select',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_individual_pa2
  $fields['individual-field_individual_pa2'] = array(
    'field_name' => 'field_individual_pa2',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '1',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        '0' => array(
          'value' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Practice Area 2',
      'weight' => '1',
      'description' => '',
      'type' => 'content_taxonomy_select',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_individual_pa3
  $fields['individual-field_individual_pa3'] = array(
    'field_name' => 'field_individual_pa3',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '1',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        '0' => array(
          'value' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Practice Area 3',
      'weight' => '2',
      'description' => '',
      'type' => 'content_taxonomy_select',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_individual_partnerdate
  $fields['individual-field_individual_partnerdate'] = array(
    'field_name' => 'field_individual_partnerdate',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '0',
    'multiple' => '1',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => '',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'year_only',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - g:i:sa',
      'input_format_custom' => 'Y',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-80:+0',
      'label_position' => 'above',
      'label' => 'Partner Date',
      'weight' => '9',
      'description' => '',
      'type' => 'date_select',
      'module' => 'date',
    ),
  );

  // Exported field: field_individual_statebar
  $fields['individual-field_individual_statebar'] = array(
    'field_name' => 'field_individual_statebar',
    'type_name' => 'individual',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '1',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '8',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        '0' => array(
          'value' => '178',
        ),
      ),
      'default_value_php' => NULL,
      'new_terms' => 'insert',
      'extra_parent' => '0',
      'maxlength' => '255',
      'label' => 'State Bar',
      'weight' => '4',
      'description' => '',
      'type' => 'content_taxonomy_select',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_profile_compcircle
  $fields['profile-field_profile_compcircle'] = array(
    'field_name' => 'field_profile_compcircle',
    'type_name' => 'profile',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '0',
    'multiple' => '10',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'firm' => 'firm',
      'case' => 0,
      'customreport' => 0,
      'filing' => 0,
      'individual' => 0,
      'page' => 0,
      'profile' => 0,
      'rate' => 0,
      'company' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'contains',
      'size' => 60,
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Pricing Alert Firms',
      'weight' => '-4',
      'description' => 'Move the firms you want to monitor into the left column (maximum of 10).',
      'type' => 'multiselect_select',
      'module' => 'multiselect',
    ),
  );

  // Exported field: field_profile_email
  $fields['profile-field_profile_email'] = array(
    'field_name' => 'field_profile_email',
    'type_name' => 'profile',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => 'off
Email an Alert every 2 weeks',
    'allowed_values_php' => '',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => 'off',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Email Alerts',
      'weight' => '-3',
      'description' => 'Check this box to have Valeo Partners email the addresses set below every 2 weeks with the latest rate increases in your Competitor Circle firms.',
      'type' => 'optionwidgets_onoff',
      'module' => 'optionwidgets',
    ),
  );

  // Exported field: field_profile_emailaddress
  $fields['profile-field_profile_emailaddress'] = array(
    'field_name' => 'field_profile_emailaddress',
    'type_name' => 'profile',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'email',
    'required' => '0',
    'multiple' => '5',
    'module' => 'email',
    'active' => '1',
    'widget' => array(
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'email' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Email Alert Addresses',
      'weight' => '-2',
      'description' => 'Enter the email addresses here (up to 5) that will receive the bi-weekly Rate Change Alerts',
      'type' => 'email_textfield',
      'module' => 'email',
    ),
  );

  // Exported field: field_rate_client
  $fields['rate-field_rate_client'] = array(
    'field_name' => 'field_rate_client',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '20',
      'parent' => '',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '0',
    'multiple' => '0',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'company' => 'company',
      'case' => 0,
      'customreport' => 0,
      'filing' => 0,
      'firm' => 0,
      'individual' => 0,
      'page' => 0,
      'profile' => 0,
      'rate' => 0,
      'search' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'contains',
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
          '_error_element' => 'default_value_widget][field_rate_client][0][nid][nid',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Company',
      'weight' => '20',
      'description' => 'To locate a client, start typing the client\'s name or click the magnifying glass icon to search. If the client isn\'t already in the database, click the plus sign to add it.',
      'type' => 'nodereference_autocomplete',
      'module' => 'nodereference',
    ),
  );

  // Exported field: field_rate_discount
  $fields['rate-field_rate_discount'] = array(
    'field_name' => 'field_rate_discount',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '26',
      'parent' => 'group_rate_group_rate',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'number_decimal',
    'required' => '0',
    'multiple' => '0',
    'module' => 'number',
    'active' => '1',
    'prefix' => '',
    'suffix' => '%',
    'min' => '',
    'max' => '100',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'precision' => '10',
    'scale' => '1',
    'decimal' => '.',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_discount][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Discount',
      'weight' => '26',
      'description' => 'Enter the percentage the Standard Rate is discounted to create the Market Rate.',
      'type' => 'number',
      'module' => 'number',
    ),
  );

  // Exported field: field_rate_feeslisted_calc
  $fields['rate-field_rate_feeslisted_calc'] = array(
    'field_name' => 'field_rate_feeslisted_calc',
    'type_name' => 'rate',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'computed',
    'required' => '1',
    'multiple' => '0',
    'module' => 'computed_field',
    'active' => '1',
    'code' => '$list = array();
if ($node->field_rate_flatfee[0][\'value\'] || $node->field_rate_retainer[0][\'value\'] || $node->field_rate_transactional[0][\'value\'] || $node->field_rate_success[0][\'value\']) {
    if ($node->field_rate_flatfee[0][\'value\'] && $node->field_rate_flatfee[0][\'value\'] > 0) {
        $list[] = \'Flat Fee\';
    }
    if ($node->field_rate_retainer[0][\'value\'] && $node->field_rate_retainer[0][\'value\'] > 0) {
        $list[] = \'Retainer\';
    }
    if ($node->field_rate_transactional[0][\'value\'] && $node->field_rate_transactional[0][\'value\'] > 0) {
        $list[] = \'Transactional Fee\';
    }
    if ($node->field_rate_success[0][\'value\'] && $node->field_rate_success[0][\'value\'] > 0) {
        $list[] = \'Success Fee\';
    }
}
if (count($list)) {
    $node_field[0][\'value\'] = implode(\', \',$list);
} else {
    $node_field[0][\'value\'] = \'\';
}
',
    'display_format' => '$display = $node_field_item[\'value\'];',
    'store' => 1,
    'data_type' => 'varchar',
    'data_length' => '255',
    'data_not_NULL' => 0,
    'data_default' => '',
    'data_sortable' => 1,
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Fees Listed (Calculated)',
      'weight' => '26',
      'description' => '',
      'type' => 'computed',
      'module' => 'computed_field',
    ),
  );

  // Exported field: field_rate_filing
  $fields['rate-field_rate_filing'] = array(
    'field_name' => 'field_rate_filing',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '19',
      'parent' => '',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '1',
    'multiple' => '0',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'filing' => 'filing',
      'case' => 0,
      'company' => 0,
      'customreport' => 0,
      'firm' => 0,
      'individual' => 0,
      'page' => 0,
      'profile' => 0,
      'rate' => 0,
      'search' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'contains',
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
          '_error_element' => 'default_value_widget][field_rate_filing][0][nid][nid',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Case / Filing',
      'weight' => '19',
      'description' => '',
      'type' => 'nodereference_autocomplete',
      'module' => 'nodereference',
    ),
  );

  // Exported field: field_rate_firm
  $fields['rate-field_rate_firm'] = array(
    'field_name' => 'field_rate_firm',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '18',
      'parent' => '',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '0',
    'multiple' => '0',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'firm' => 'firm',
      'case' => 0,
      'company' => 0,
      'customreport' => 0,
      'filing' => 0,
      'individual' => 0,
      'page' => 0,
      'profile' => 0,
      'rate' => 0,
      'search' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'contains',
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
          '_error_element' => 'default_value_widget][field_rate_firm][0][nid][nid',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Firm',
      'weight' => '18',
      'description' => 'To locate a firm, start typing the firm name or click the magnifying glass icon to search. If the firm isn\'t already in the database, click the plus sign to add it.',
      'type' => 'nodereference_autocomplete',
      'module' => 'nodereference',
    ),
  );

  // Exported field: field_rate_flatfee
  $fields['rate-field_rate_flatfee'] = array(
    'field_name' => 'field_rate_flatfee',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '23',
      'parent' => 'group_rate_group_fee',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'number_decimal',
    'required' => '0',
    'multiple' => '0',
    'module' => 'number',
    'active' => '1',
    'prefix' => '$',
    'suffix' => '',
    'min' => '',
    'max' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'precision' => '10',
    'scale' => '2',
    'decimal' => '.',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_flatfee][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Flat Fee',
      'weight' => '23',
      'description' => '',
      'type' => 'number',
      'module' => 'number',
    ),
  );

  // Exported field: field_rate_hourly
  $fields['rate-field_rate_hourly'] = array(
    'field_name' => 'field_rate_hourly',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '22',
      'parent' => 'group_rate_group_rate',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'number_decimal',
    'required' => '0',
    'multiple' => '0',
    'module' => 'number',
    'active' => '1',
    'prefix' => '$',
    'suffix' => '',
    'min' => '10.00',
    'max' => '1700.00',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'precision' => '10',
    'scale' => '2',
    'decimal' => '.',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_hourly][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Actual Rate',
      'weight' => '22',
      'description' => '',
      'type' => 'number',
      'module' => 'number',
    ),
  );

  // Exported field: field_rate_hours
  $fields['rate-field_rate_hours'] = array(
    'field_name' => 'field_rate_hours',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '24',
      'parent' => 'group_rate_group_rate',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'number_decimal',
    'required' => '0',
    'multiple' => '0',
    'module' => 'number',
    'active' => '1',
    'prefix' => '',
    'suffix' => '',
    'min' => '',
    'max' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'precision' => '10',
    'scale' => '2',
    'decimal' => '.',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_hours][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Hours',
      'weight' => '24',
      'description' => '',
      'type' => 'number',
      'module' => 'number',
    ),
  );

  // Exported field: field_rate_individual
  $fields['rate-field_rate_individual'] = array(
    'field_name' => 'field_rate_individual',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '16',
      'parent' => '',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '1',
    'multiple' => '0',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'individual' => 'individual',
      'case' => 0,
      'company' => 0,
      'customreport' => 0,
      'filing' => 0,
      'firm' => 0,
      'page' => 0,
      'profile' => 0,
      'rate' => 0,
      'search' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'starts_with',
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
          '_error_element' => 'default_value_widget][field_rate_individual][0][nid][nid',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Individual',
      'weight' => '16',
      'description' => 'To locate an individual, start typing their last name or click the magnifying glass icon to search. If this person isn\'t already in the database, click the plus sign to add them.',
      'type' => 'nodereference_autocomplete',
      'module' => 'nodereference',
    ),
  );

  // Exported field: field_rate_notes
  $fields['rate-field_rate_notes'] = array(
    'field_name' => 'field_rate_notes',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '23',
      'parent' => '',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => '5',
      'size' => 60,
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_notes][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Notes',
      'weight' => '25',
      'description' => '',
      'type' => 'text_textarea',
      'module' => 'text',
    ),
  );

  // Exported field: field_rate_position1
  $fields['rate-field_rate_position1'] = array(
    'field_name' => 'field_rate_position1',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '17',
      'parent' => '',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 1,
    'vid' => '13',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        'field_rate_position1' => array(
          'tids' => NULL,
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Position',
      'weight' => '17',
      'description' => '',
      'type' => 'content_taxonomy_hs',
      'module' => 'hs_content_taxonomy',
    ),
  );

  // Exported field: field_rate_refcompany
  $fields['rate-field_rate_refcompany'] = array(
    'field_name' => 'field_rate_refcompany',
    'type_name' => 'rate',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '0',
    'multiple' => '1',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'company' => 'company',
      'case' => 0,
      'customreport' => 0,
      'filing' => 0,
      'firm' => 0,
      'individual' => 0,
      'page' => 0,
      'profile' => 0,
      'rate' => 0,
      'search' => 0,
      'webform' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'contains',
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
          '_error_element' => 'default_value_widget][field_rate_refcompany][0][nid][nid',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Referenced Company',
      'weight' => '33',
      'description' => '',
      'type' => 'nodereference_autocomplete',
      'module' => 'nodereference',
    ),
  );

  // Exported field: field_rate_refcompattorney
  $fields['rate-field_rate_refcompattorney'] = array(
    'field_name' => 'field_rate_refcompattorney',
    'type_name' => 'rate',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '0',
    'multiple' => '1',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'individual' => 'individual',
      'case' => 0,
      'company' => 0,
      'customreport' => 0,
      'filing' => 0,
      'firm' => 0,
      'page' => 0,
      'profile' => 0,
      'rate' => 0,
      'search' => 0,
      'webform' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'contains',
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
          '_error_element' => 'default_value_widget][field_rate_refcompattorney][0][nid][nid',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Referenced Attorney',
      'weight' => '34',
      'description' => '',
      'type' => 'nodereference_autocomplete',
      'module' => 'nodereference',
    ),
  );

  // Exported field: field_rate_referencedattorneys
  $fields['rate-field_rate_referencedattorneys'] = array(
    'field_name' => 'field_rate_referencedattorneys',
    'type_name' => 'rate',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '0',
    'multiple' => '1',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'individual' => 'individual',
      'case' => 0,
      'company' => 0,
      'customreport' => 0,
      'filing' => 0,
      'firm' => 0,
      'page' => 0,
      'profile' => 0,
      'rate' => 0,
      'search' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'autocomplete_match' => 'contains',
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
          '_error_element' => 'default_value_widget][field_rate_referencedattorneys][0][nid][nid',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Referenced Attorneys',
      'weight' => '21',
      'description' => 'Indicate other attorneys besides the primary one listed in the filing.',
      'type' => 'nodereference_autocomplete',
      'module' => 'nodereference',
    ),
  );

  // Exported field: field_rate_retainer
  $fields['rate-field_rate_retainer'] = array(
    'field_name' => 'field_rate_retainer',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '27',
      'parent' => 'group_rate_group_rate',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'number_decimal',
    'required' => '0',
    'multiple' => '0',
    'module' => 'number',
    'active' => '1',
    'prefix' => '$',
    'suffix' => '',
    'min' => '',
    'max' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'precision' => '10',
    'scale' => '2',
    'decimal' => '.',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_retainer][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Retainer',
      'weight' => '24',
      'description' => '',
      'type' => 'number',
      'module' => 'number',
    ),
  );

  // Exported field: field_rate_secfiling
  $fields['rate-field_rate_secfiling'] = array(
    'field_name' => 'field_rate_secfiling',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '26',
      'parent' => 'group_rate_group_fee',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '0',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => 5,
      'size' => '60',
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_secfiling][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'SEC Filing',
      'weight' => '28',
      'description' => '',
      'type' => 'text_textfield',
      'module' => 'text',
    ),
  );

  // Exported field: field_rate_standard
  $fields['rate-field_rate_standard'] = array(
    'field_name' => 'field_rate_standard',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '23',
      'parent' => 'group_rate_group_rate',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'plain',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'plain',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'computed',
    'required' => '0',
    'multiple' => '0',
    'module' => 'computed_field',
    'active' => '1',
    'code' => 'if ($node->field_rate_hourly[0][\'value\']) {
	if ($node->field_rate_discount[0][\'value\']) {
	        if (is_numeric($node->field_rate_discount[0][\'value\'])) {
	             $discount = 1 - ($node->field_rate_discount[0][\'value\']/100);
	             $node_field[0][\'value\'] = $node->field_rate_hourly[0][\'value\'] / $discount;
	        } else {
                        $node_field[0][\'value\'] = \'\';
                }
        } else {
	        if (is_numeric($node->field_rate_discount[0][\'value\'])) {
	                $node_field[0][\'value\'] = $node->field_rate_hourly[0][\'value\'];
	        } else {
                        $node_field[0][\'value\'] = \'\';
                }
        }
} else {
	$node_field[0][\'value\'] = \'\';
}',
    'display_format' => 'if ($node_field_item[\'value\'] == 0) {
$display = \'\';
} else {
$display = \'$\' . number_format($node_field_item[\'value\'], 2, \'.\', \',\');
}',
    'store' => 1,
    'data_type' => 'float',
    'data_length' => '10',
    'data_not_NULL' => 0,
    'data_default' => '',
    'data_sortable' => 1,
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Standard Rate',
      'weight' => '23',
      'description' => 'The Standard Rate is calculated automatically from the Market Rate and the Discount',
      'type' => 'computed',
      'module' => 'computed_field',
    ),
  );

  // Exported field: field_rate_success
  $fields['rate-field_rate_success'] = array(
    'field_name' => 'field_rate_success',
    'type_name' => 'rate',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'number_decimal',
    'required' => '0',
    'multiple' => '0',
    'module' => 'number',
    'active' => '1',
    'prefix' => '$',
    'suffix' => '',
    'min' => '',
    'max' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'precision' => '10',
    'scale' => '2',
    'decimal' => '.',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_success][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Success Fee',
      'weight' => '26',
      'description' => '',
      'type' => 'number',
      'module' => 'number',
    ),
  );

  // Exported field: field_rate_total
  $fields['rate-field_rate_total'] = array(
    'field_name' => 'field_rate_total',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '25',
      'parent' => 'group_rate_group_rate',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'computed',
    'required' => '1',
    'multiple' => '0',
    'module' => 'computed_field',
    'active' => '1',
    'code' => 'if ($node->field_rate_hourly[0][\'value\'] && $node-> field_rate_hours[0][\'value\']) {
	$node_field[0][\'value\'] = $node->field_rate_hourly[0][\'value\'] * $node-> field_rate_hours[0][\'value\'];
} else {
	$node_field[0][\'value\'] = 0;
}',
    'display_format' => 'setlocale(LC_MONETARY, \'en_US\');
$display = money_format(\'%n\',$node_field_item[\'value\']);',
    'store' => 1,
    'data_type' => 'float',
    'data_length' => '10,2',
    'data_not_NULL' => 1,
    'data_default' => '0',
    'data_sortable' => 1,
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Total',
      'weight' => '25',
      'description' => '',
      'type' => 'computed',
      'module' => 'computed_field',
    ),
  );

  // Exported field: field_rate_totalfees
  $fields['rate-field_rate_totalfees'] = array(
    'field_name' => 'field_rate_totalfees',
    'type_name' => 'rate',
    'display_settings' => array(
      'weight' => '25',
      'parent' => 'group_rate_group_fee',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'number_decimal',
    'required' => '0',
    'multiple' => '0',
    'module' => 'number',
    'active' => '1',
    'prefix' => '$',
    'suffix' => '',
    'min' => '',
    'max' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'precision' => '10',
    'scale' => '2',
    'decimal' => '.',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_totalfees][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Total Fees',
      'weight' => '27',
      'description' => '',
      'type' => 'number',
      'module' => 'number',
    ),
  );

  // Exported field: field_rate_totalfees_calc
  $fields['rate-field_rate_totalfees_calc'] = array(
    'field_name' => 'field_rate_totalfees_calc',
    'type_name' => 'rate',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'computed',
    'required' => '1',
    'multiple' => '0',
    'module' => 'computed_field',
    'active' => '1',
    'code' => 'if ($node->field_rate_flatfee[0][\'value\'] || $node->field_rate_retainer[0][\'value\'] || $node->field_rate_transactional[0][\'value\'] || $node->field_rate_success[0][\'value\']) {
	$node_field[0][\'value\'] = $node->field_rate_flatfee[0][\'value\'] + $node->field_rate_retainer[0][\'value\'] + $node->field_rate_transactional[0][\'value\'] + $node->field_rate_success[0][\'value\'];
} else {
	$node_field[0][\'value\'] = 0;
}',
    'display_format' => 'setlocale(LC_MONETARY, \'en_US\');
$display = money_format(\'%n\',$node_field_item[\'value\']);',
    'store' => 1,
    'data_type' => 'float',
    'data_length' => '10,2',
    'data_not_NULL' => 1,
    'data_default' => '0',
    'data_sortable' => 1,
    'widget' => array(
      'default_value' => NULL,
      'default_value_php' => NULL,
      'label' => 'Total Fees (Calculated)',
      'weight' => '29',
      'description' => '',
      'type' => 'computed',
      'module' => 'computed_field',
    ),
  );

  // Exported field: field_rate_transactional
  $fields['rate-field_rate_transactional'] = array(
    'field_name' => 'field_rate_transactional',
    'type_name' => 'rate',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'number_decimal',
    'required' => '0',
    'multiple' => '0',
    'module' => 'number',
    'active' => '1',
    'prefix' => '$',
    'suffix' => '',
    'min' => '',
    'max' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'precision' => '10',
    'scale' => '2',
    'decimal' => '.',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => '',
          '_error_element' => 'default_value_widget][field_rate_transactional][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Transactional Fee',
      'weight' => '25',
      'description' => '',
      'type' => 'number',
      'module' => 'number',
    ),
  );

  // Exported field: field_search_baryear
  $fields['search-field_search_baryear'] = array(
    'field_name' => 'field_search_baryear',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '0',
    'multiple' => '0',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => 'required',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'medium',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - g:i:sa',
      'input_format_custom' => 'Y',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-50:+0',
      'label_position' => 'none',
      'label' => 'Bar Year',
      'weight' => '6',
      'description' => 'Limit your search to attorneys passing the bar in the date range selected.',
      'type' => 'date_select',
      'module' => 'date',
    ),
  );

  // Exported field: field_search_city
  $fields['search-field_search_city'] = array(
    'field_name' => 'field_search_city',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '0',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 0,
    'vid' => '6',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'default_value' => array(
        'field_search_city' => array(
          'tids' => NULL,
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Region / City',
      'weight' => '2',
      'description' => 'Limit your search to those attorneys whose most recent rate was recorded at firms in the selecte regions.',
      'type' => 'content_taxonomy_hs',
      'module' => 'hs_content_taxonomy',
    ),
  );

  // Exported field: field_search_columns
  $fields['search-field_search_columns'] = array(
    'field_name' => 'field_search_columns',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '1',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 0,
    'vid' => '18',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        '0' => array(
          'value' => '',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Display Columns',
      'weight' => '-2',
      'description' => 'Select the columns you would like in your saved search. The attorney\'s name and the most recent 3 years of rate data will appear automatically.',
      'type' => 'content_taxonomy_options',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_search_detail
  $fields['search-field_search_detail'] = array(
    'field_name' => 'field_search_detail',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '1',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '0|Detail Results
1|Summary Results',
    'allowed_values_php' => '',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'value' => '0',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Detail or Summary Data',
      'weight' => '-3',
      'description' => 'Select the data you wish to display: individual rates (Detail) or rates summarized by attorney (Summary).',
      'type' => 'optionwidgets_buttons',
      'module' => 'optionwidgets',
    ),
  );

  // Exported field: field_search_firms
  $fields['search-field_search_firms'] = array(
    'field_name' => 'field_search_firms',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'nodereference',
    'required' => '0',
    'multiple' => '1',
    'module' => 'nodereference',
    'active' => '1',
    'referenceable_types' => array(
      'firm' => 'firm',
      'case' => 0,
      'customreport' => 0,
      'filing' => 0,
      'individual' => 0,
      'page' => 0,
      'profile' => 0,
      'rate' => 0,
      'search' => 0,
      'company' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'widget' => array(
      'default_value' => array(
        '0' => array(
          'nid' => NULL,
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Firms',
      'weight' => 0,
      'description' => 'Limit your search to the specific firms selected.',
      'type' => 'multiselect_select',
      'module' => 'multiselect',
    ),
  );

  // Exported field: field_search_gradyear
  $fields['search-field_search_gradyear'] = array(
    'field_name' => 'field_search_gradyear',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '0',
    'multiple' => '0',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => 'required',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'medium',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - g:i:sa',
      'input_format_custom' => 'Y',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-50:+0',
      'label_position' => 'none',
      'label' => 'Graduation Year',
      'weight' => '5',
      'description' => 'Limit your search to only attorneys with a graduation date in the selected range.',
      'type' => 'date_select',
      'module' => 'date',
    ),
  );

  // Exported field: field_search_industry
  $fields['search-field_search_industry'] = array(
    'field_name' => 'field_search_industry',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '1',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 0,
    'vid' => '14',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        '0' => array(
          'value' => NULL,
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Industry',
      'weight' => '1',
      'description' => 'Limit your search to only the selected industries.',
      'type' => 'content_taxonomy_select',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_search_partneryear
  $fields['search-field_search_partneryear'] = array(
    'field_name' => 'field_search_partneryear',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '0',
    'multiple' => '0',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => 'required',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'medium',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - g:i:sa',
      'input_format_custom' => 'Y',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-50:+0',
      'label_position' => 'none',
      'label' => 'Partner Year',
      'weight' => '7',
      'description' => 'Limit your search to attorneys making partner in the date range selected',
      'type' => 'date_select',
      'module' => 'date',
    ),
  );

  // Exported field: field_search_position
  $fields['search-field_search_position'] = array(
    'field_name' => 'field_search_position',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '1',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 0,
    'vid' => '13',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        'field_search_position' => array(
          'tids' => NULL,
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Position',
      'weight' => '4',
      'description' => 'Limit your search to only the selected attorney positions.',
      'type' => 'content_taxonomy_hs',
      'module' => 'hs_content_taxonomy',
    ),
  );

  // Exported field: field_search_practicearea
  $fields['search-field_search_practicearea'] = array(
    'field_name' => 'field_search_practicearea',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'content_taxonomy',
    'required' => '0',
    'multiple' => '1',
    'module' => 'content_taxonomy',
    'active' => '1',
    'save_term_node' => 0,
    'vid' => '1',
    'parent' => '0',
    'parent_php_code' => '',
    'depth' => '',
    'widget' => array(
      'group_parent' => '0',
      'show_depth' => 1,
      'default_value' => array(
        '0' => array(
          'value' => NULL,
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Practice Area',
      'weight' => '3',
      'description' => 'Limit your search to only the selected attorney practice areas.',
      'type' => 'content_taxonomy_select',
      'module' => 'content_taxonomy_options',
    ),
  );

  // Exported field: field_search_rateyear
  $fields['search-field_search_rateyear'] = array(
    'field_name' => 'field_search_rateyear',
    'type_name' => 'search',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'date',
    'required' => '0',
    'multiple' => '0',
    'module' => 'date',
    'active' => '1',
    'granularity' => array(
      'year' => 'year',
    ),
    'timezone_db' => '',
    'tz_handling' => 'none',
    'todate' => 'required',
    'repeat' => 0,
    'repeat_collapsed' => '',
    'default_format' => 'year_only',
    'widget' => array(
      'default_value' => 'blank',
      'default_value_code' => '',
      'default_value2' => 'same',
      'default_value_code2' => '',
      'input_format' => 'm/d/Y - g:i:sa',
      'input_format_custom' => 'Y',
      'increment' => '1',
      'text_parts' => array(),
      'year_range' => '-10:+0',
      'label_position' => 'above',
      'label' => 'Rate Year',
      'weight' => '8',
      'description' => 'Limit your search to rates recorded during the date range selected. Empty \'To date\' values will use the \'From date\' values.
<b>Note:</b> this filter only applies to Detail search results; Summary results always display the 3 most recent years\' rate data.',
      'type' => 'date_select',
      'module' => 'date',
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Actual Rate');
  t('Address');
  t('Bar Date');
  t('Bar Year');
  t('Case');
  t('Case / Filing');
  t('Case Name');
  t('Case Number');
  t('Company');
  t('Country / Region / State / City');
  t('Court');
  t('Date Filed');
  t('Detail or Summary Data');
  t('Discount');
  t('Display Columns');
  t('Email');
  t('Email Alert Addresses');
  t('Email Alerts');
  t('Fee Date Range');
  t('Fees Listed (Calculated)');
  t('Filing Description');
  t('Filing Number');
  t('Filings Associated with this Case');
  t('Firm');
  t('Firm Date');
  t('Firms');
  t('First Name');
  t('Flat Fee');
  t('Graduation Date');
  t('Graduation Year');
  t('Headquarters');
  t('Hours');
  t('Individual');
  t('Individuals with an Employment History at this Firm');
  t('Industry');
  t('Last Name');
  t('Middle Initial');
  t('Middle Name');
  t('Nature of Suit');
  t('Notes');
  t('Partner Date');
  t('Partner Year');
  t('Phone');
  t('Position');
  t('Practice Area');
  t('Practice Area 1');
  t('Practice Area 2');
  t('Practice Area 3');
  t('Pricing Alert Firms');
  t('Rate Year');
  t('Rates & Fees Associated with this Filing');
  t('Rates & Fees Recorded for this Firm');
  t('Rates & Fees Recorded for this Individual');
  t('Referenced Attorney');
  t('Referenced Attorneys');
  t('Referenced Attorneys in Rate and Fees');
  t('Referenced Company');
  t('Referenced Company Attorney in Rate and Fees');
  t('Region / City');
  t('Research Associate');
  t('Retainer');
  t('SEC Filing');
  t('Standard Rate');
  t('State Bar');
  t('Success Fee');
  t('Total');
  t('Total Fees');
  t('Total Fees (Calculated)');
  t('Transactional Fee');
  t('Type');

  return $fields;
}
