<?php

/**
 * Implementation of hook_fieldgroup_default_groups().
 */
function valeo_content_types_fieldgroup_default_groups() {
  $groups = array();

  // Exported group: group_company_group_contact
  $groups['company-group_company_group_contact'] = array(
    'group_type' => 'standard',
    'type_name' => 'company',
    'group_name' => 'group_company_group_contact',
    'label' => 'Company Contact',
    'settings' => array(
      'form' => array(
        'style' => 'fieldset',
        'description' => '',
      ),
      'display' => array(
        'description' => '',
        'label' => 'above',
        'teaser' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'full' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '4' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '5' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'token' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
      ),
    ),
    'weight' => '-3',
    'parent' => '',
    'fields' => array(
      '0' => 'field_company_firstname',
      '1' => 'field_company_middleinitial',
      '2' => 'field_company_lastname',
      '3' => 'field_company_position',
      '4' => 'field_company_address',
      '5' => 'field_company_phone',
      '6' => 'field_company_email',
    ),
    'depth' => 0,
    'parents' => array(
      '0' => '',
    ),
  );

  // Exported group: group_individual_employment
  $groups['individual-group_individual_employment'] = array(
    'group_type' => 'multigroup',
    'type_name' => 'individual',
    'group_name' => 'group_individual_employment',
    'label' => 'Employment History',
    'settings' => array(
      'form' => array(
        'style' => 'fieldset',
        'description' => '',
      ),
      'display' => array(
        'description' => '',
        'teaser' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'full' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '4' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'token' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'label' => NULL,
      ),
      'multigroup' => array(
        'multiple-columns' => 1,
        'required' => 0,
        'multiple' => '1',
        'labels' => array(
          '0' => 'Employer',
          '1' => 'Employer',
          '2' => 'Employer',
          '3' => 'Employer',
          '4' => 'Employer',
          '5' => 'Employer',
          '6' => 'Employer',
          '7' => 'Employer',
          '8' => 'Employer',
          '9' => 'Employer',
        ),
      ),
    ),
    'weight' => '6',
    'parent' => '',
    'fields' => array(
      '0' => 'field_individual_firm',
      '1' => 'field_individual_firmdate',
      '2' => 'field_individual_partnerdate',
    ),
    'depth' => 0,
    'parents' => array(
      '0' => '',
    ),
  );

  // Exported group: group_rate_group_company
  $groups['rate-group_rate_group_company'] = array(
    'group_type' => 'multigroup',
    'type_name' => 'rate',
    'group_name' => 'group_rate_group_company',
    'label' => 'Referenced Company',
    'settings' => array(
      'form' => array(
        'style' => 'fieldset',
        'description' => '',
      ),
      'display' => array(
        'description' => '',
        'teaser' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'full' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '4' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '5' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'token' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'label' => NULL,
      ),
      'multigroup' => array(
        'multiple-columns' => 1,
        'required' => 0,
        'multiple' => '1',
        'labels' => array(
          '0' => '',
          '1' => '',
          '2' => '',
          '3' => '',
          '4' => '',
          '5' => '',
          '6' => '',
          '7' => '',
          '8' => '',
          '9' => '',
        ),
      ),
    ),
    'weight' => '22',
    'parent' => '',
    'fields' => array(
      '0' => 'field_rate_refcompany',
      '1' => 'field_rate_refcompattorney',
    ),
    'depth' => 0,
    'parents' => array(
      '0' => '',
    ),
  );

  // Exported group: group_rate_group_fee
  $groups['rate-group_rate_group_fee'] = array(
    'group_type' => 'standard',
    'type_name' => 'rate',
    'group_name' => 'group_rate_group_fee',
    'label' => 'Fee Information',
    'settings' => array(
      'form' => array(
        'style' => 'fieldset',
        'description' => '',
      ),
      'display' => array(
        'weight' => '22',
        'parent' => '',
        'label' => 'above',
        'teaser' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'full' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'description' => '',
        '4' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '5' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'token' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
      ),
    ),
    'weight' => '24',
    'parent' => '',
    'fields' => array(
      '0' => 'field_rate_flatfee',
      '1' => 'field_rate_retainer',
      '2' => 'field_rate_transactional',
      '3' => 'field_rate_success',
      '4' => 'field_rate_totalfees',
      '5' => 'field_rate_secfiling',
      '6' => 'field_rate_totalfees_calc',
    ),
    'depth' => 0,
    'parents' => array(
      '0' => '',
    ),
  );

  // Exported group: group_rate_group_rate
  $groups['rate-group_rate_group_rate'] = array(
    'group_type' => 'standard',
    'type_name' => 'rate',
    'group_name' => 'group_rate_group_rate',
    'label' => 'Rate Information',
    'settings' => array(
      'form' => array(
        'style' => 'fieldset',
        'description' => '',
      ),
      'display' => array(
        'weight' => '21',
        'parent' => '',
        'label' => 'above',
        'teaser' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'full' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'description' => '',
        '4' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '5' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'token' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
      ),
    ),
    'weight' => '23',
    'parent' => '',
    'fields' => array(
      '0' => 'field_rate_hourly',
      '1' => 'field_rate_standard',
      '2' => 'field_rate_hours',
      '3' => 'field_rate_total',
      '4' => 'field_rate_discount',
    ),
    'depth' => 0,
    'parents' => array(
      '0' => '',
    ),
  );

  // Exported group: group_search_filters
  $groups['search-group_search_filters'] = array(
    'group_type' => 'standard',
    'type_name' => 'search',
    'group_name' => 'group_search_filters',
    'label' => 'Filters',
    'settings' => array(
      'form' => array(
        'style' => 'fieldset',
        'description' => '',
      ),
      'display' => array(
        'description' => 'Select the options that will limit your search.',
        'teaser' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'full' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '4' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'token' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'label' => 'above',
      ),
    ),
    'weight' => '-1',
    'parent' => '',
    'fields' => array(
      '0' => 'field_search_firms',
      '1' => 'field_search_industry',
      '2' => 'field_search_city',
      '3' => 'field_search_practicearea',
      '4' => 'field_search_position',
      '5' => 'field_search_gradyear',
      '6' => 'field_search_baryear',
      '7' => 'field_search_partneryear',
      '8' => 'field_search_rateyear',
    ),
    'depth' => 0,
    'parents' => array(
      '0' => '',
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Company Contact');
  t('Employment History');
  t('Fee Information');
  t('Filters');
  t('Rate Information');
  t('Referenced Company');

  return $groups;
}
