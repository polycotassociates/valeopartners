<?php

  /**
     * @file
     * Definition of Drupal\vp_views\Plugin\views\filter\UserSelectedFirms.
     */

    namespace Drupal\vp_views\Plugin\views\filter;

    use Drupal\views\Plugin\views\display\DisplayPluginBase;
    use Drupal\views\Plugin\views\filter\StringFilter;
    use Drupal\views\ViewExecutable;

    /**
     * Filters by given list of node title options.
     *
     * @ingroup views_filter_handlers
     *
     * @ViewsFilter("vp_views_user_selected_firms")
     */
    class UserSelectedFirms extends FilterPluginBase {
      /**
       * {@inheritdoc}
       */
      public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = null) {
          parent::init($view, $display, $options);
          $this->valueTitle = t('User Selected Firms');
      }
  
  
      public function query() {
        $configuration = [
          'table' => 'node_access',
          'field' => 'nid',
          'left_table' => 'node_field_data',
          'left_field' => 'nid',
          'operator' => '='
        ];

        // $join = Views::pluginManager('join')->createInstance('standard', $configuration);


        // $this->query->addRelationship('node_access', $join, 'node_field_data');
        $this->query->addWhere('AND', 'previous_year_rate.value', '', '!=');
      }
    }