<?php

/**
 * Implementation of hook_rules_defaults().
 */
function valeo_rules_rules_defaults() {
  return array(
    'rules' => array(
      'rules_run_firm_update_alert' => array(
        '#type' => 'rule',
        '#set' => 'rules_send_firm_update_alert',
        '#label' => 'Run Firm Update Alert',
        '#active' => 1,
        '#weight' => '0',
        '#categories' => array(
          '0' => 'alerts',
          'valeo_rules' => 'valeo_rules',
        ),
        '#status' => 'default',
        '#conditions' => array(),
        '#actions' => array(
          '0' => array(
            '#type' => 'action',
            '#settings' => array(
              'code' => 'send_firm_update_alert();',
              'vars' => array(),
              '#eval input' => array(
                'token_rules_input_evaluator' => array(
                  'code' => array(
                    '0' => ':global',
                  ),
                ),
              ),
            ),
            '#name' => 'rules_action_custom_php',
            '#info' => array(
              'label' => 'Execute custom PHP code',
              'module' => 'PHP',
              'eval input' => array(
                '0' => 'code',
              ),
            ),
            '#weight' => 0,
          ),
          '1' => array(
            '#weight' => 9,
            '#info' => array(
              'arguments' => array(
                'task_identifier' => array(
                  'type' => 'string',
                  'label' => 'Identifier',
                  'description' => 'User provided string to identify the task. Existing tasks for this rule set with the same identifier will be replaced.',
                ),
                'task_date' => array(
                  'type' => 'date',
                  'label' => 'Scheduled evaluation date',
                ),
              ),
              'label' => 'Schedule "Send Firm Update Alert"',
              'status' => 'custom',
              'categories' => array(
                '0' => 'alerts',
              ),
              'module' => 'Rule Scheduler',
              'base' => 'rules_scheduler_action',
              'set' => 'rules_send_firm_update_alert',
            ),
            '#name' => 'rules_action_schedule_set_rules_send_firm_update_alert',
            '#settings' => array(
              'task_identifier' => 'Next Firm Alert Scheduled',
              'task_date' => '+1 day 09:00',
              '#eval input' => array(
                'token_rules_input_evaluator' => array(
                  'task_identifier' => array(
                    '0' => ':global',
                  ),
                  'task_date' => array(
                    '0' => ':global',
                  ),
                ),
              ),
            ),
            '#type' => 'action',
          ),
        ),
        '#version' => 6003,
      ),
      'valeo_rules_1' => array(
        '#type' => 'rule',
        '#set' => 'rules_send_alerts',
        '#label' => 'Send Email Alert',
        '#active' => 0,
        '#weight' => '0',
        '#categories' => array(
          '0' => 'alerts',
          '1' => 'valeo_rules',
        ),
        '#status' => 'default',
        '#conditions' => array(),
        '#actions' => array(
          '0' => array(
            '#type' => 'action',
            '#settings' => array(
              'code' => 'send_alerts();',
              'vars' => array(),
            ),
            '#name' => 'rules_action_custom_php',
            '#info' => array(
              'label' => 'Execute custom PHP code',
              'module' => 'PHP',
              'eval input' => array(
                '0' => 'code',
              ),
            ),
            '#weight' => 0,
          ),
        ),
        '#version' => 6003,
      ),
      'valeo_rules_2' => array(
        '#type' => 'rule',
        '#set' => 'rules_send_alerts',
        '#label' => 'Schedule Next Alert',
        '#active' => 0,
        '#weight' => '0',
        '#categories' => array(
          '0' => 'alerts',
          '1' => 'valeo_rules',
        ),
        '#status' => 'default',
        '#conditions' => array(),
        '#actions' => array(
          '0' => array(
            '#weight' => 0,
            '#info' => array(
              'arguments' => array(
                'task_identifier' => array(
                  'type' => 'string',
                  'label' => 'Identifier',
                  'description' => 'User provided string to identify the task. Existing tasks for this rule set with the same identifier will be replaced.',
                ),
                'task_date' => array(
                  'type' => 'date',
                  'label' => 'Scheduled evaluation date',
                ),
              ),
              'label' => 'Schedule "Send Alerts"',
              'status' => 'custom',
              'categories' => array(
                '0' => 'alerts',
              ),
              'module' => 'Rule Scheduler',
              'base' => 'rules_scheduler_action',
              'set' => 'rules_send_alerts',
            ),
            '#name' => 'rules_action_schedule_set_rules_send_alerts',
            '#settings' => array(
              'task_identifier' => 'Next Alert Scheduled',
              'task_date' => '+15 minutes',
            ),
            '#type' => 'action',
          ),
        ),
        '#version' => 6003,
      ),
      'valeo_rules_3' => array(
        '#type' => 'rule',
        '#set' => 'rules_send_alerts',
        '#label' => 'Send Email Alert',
        '#active' => 1,
        '#weight' => '0',
        '#categories' => array(
          '0' => 'alerts',
          '1' => 'valeo_rules',
        ),
        '#status' => 'default',
        '#conditions' => array(),
        '#actions' => array(
          '0' => array(
            '#type' => 'action',
            '#settings' => array(
              'code' => 'send_alerts();',
              'vars' => array(),
            ),
            '#name' => 'rules_action_custom_php',
            '#info' => array(
              'label' => 'Execute custom PHP code',
              'module' => 'PHP',
              'eval input' => array(
                '0' => 'code',
              ),
            ),
            '#weight' => 0,
          ),
        ),
        '#version' => 6003,
      ),
      'valeo_rules_4' => array(
        '#type' => 'rule',
        '#set' => 'rules_send_alerts',
        '#label' => 'Schedule Next Alert',
        '#active' => 1,
        '#weight' => '0',
        '#categories' => array(
          '0' => 'alerts',
          'valeo_rules' => 'valeo_rules',
        ),
        '#status' => 'default',
        '#conditions' => array(),
        '#actions' => array(
          '0' => array(
            '#weight' => 0,
            '#type' => 'action',
            '#settings' => array(
              'task_identifier' => 'Next Alert Scheduled',
              'task_date' => '+2 weeks 09:00',
              '#eval input' => array(
                'token_rules_input_evaluator' => array(
                  'task_identifier' => array(
                    '0' => ':global',
                  ),
                  'task_date' => array(
                    '0' => ':global',
                  ),
                ),
              ),
            ),
            '#name' => 'rules_action_schedule_set_rules_send_alerts',
            '#info' => array(
              'arguments' => array(
                'task_identifier' => array(
                  'type' => 'string',
                  'label' => 'Identifier',
                  'description' => 'User provided string to identify the task. Existing tasks for this rule set with the same identifier will be replaced.',
                ),
                'task_date' => array(
                  'type' => 'date',
                  'label' => 'Scheduled evaluation date',
                ),
              ),
              'label' => 'Schedule "Send Alerts"',
              'status' => 'custom',
              'categories' => array(
                '0' => 'alerts',
              ),
              'module' => 'Rule Scheduler',
              'base' => 'rules_scheduler_action',
              'set' => 'rules_send_alerts',
            ),
          ),
        ),
        '#version' => 6003,
      ),
    ),
    'rule_sets' => array(
      'rules_send_firm_update_alert' => array(
        'arguments' => array(),
        'label' => 'Send Firm Update Alert',
        'status' => 'default',
        'categories' => array(
          '0' => 'alerts',
          'valeo_rules' => 'valeo_rules',
        ),
      ),
      'rules_send_alerts' => array(
        'arguments' => array(),
        'label' => 'Send Alerts',
        'status' => 'default',
        'categories' => array(
          '0' => 'alerts',
          'valeo_rules' => 'valeo_rules',
        ),
      ),
    ),
  );
}
