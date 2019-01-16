<?php

namespace Drupal\vefl\Plugin\views\exposed_form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\vefl\Vefl;

/**
 * Trait for vefl.
 */
trait VeflTrait {

  /**
   * The vefl layout helper.
   *
   * @var \Drupal\vefl\Vefl
   */
  protected $vefl;

  /**
   * Constructs a PluginBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\vefl\Vefl $vefl
   *   The vefl layout helper.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Vefl $vefl) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->vefl = $vefl;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('vefl.layout')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['layout'] = [
      'contains' => [
        'layout_id' => ['default' => 'vefl_onecol'],
        'regions' => ['default' => []],
        'widget_region' => ['default' => []],
      ],
    ];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $layout_id = $this->options['layout']['layout_id'];
    $layouts = $this->vefl->getLayouts();

    // Outputs layout selectbox.
    $form['layout'] = [
      '#type' => 'details',
      '#title' => $this->t('Layout settings'),
    ];
    $form['layout']['layout_id'] = [
      '#prefix' => '<div class="container-inline">',
      '#type' => 'select',
      '#options' => $this->vefl->getLayoutOptions($layouts),
      '#title' => $this->t('Layout'),
      '#default_value' => $layout_id,
    ];
    $form['layout']['change'] = [
      '#type' => 'submit',
      '#value' => $this->t('Change'),
      '#submit' => [[$this, 'updateRegions']],
      '#suffix' => '</div>',
    ];
    $form['layout']['widget_region'] = $this->getRegionElements($layout_id, $layouts);
  }

  /**
   * @param $layout_id
   * @param array $layouts
   * @return array
   */
  private function getRegionElements($layout_id, $layouts = []) {
    $element = [
      '#prefix' => '<div id="edit-block-region-wrapper">',
      '#suffix' => '</div>',
    ];
    // Outputs regions selectbox for each filter.
    $types = [
      'filters' => $this->view->display_handler->getHandlers('filter'),
      'actions' => $this->vefl->getFormActions(),
    ];

    // Adds additional action for BEF combined sort. @todo
//    if (!empty($vars['widgets']['sort-sort_bef_combine'])) {
//      $actions[] = 'sort-sort_bef_combine';
//    }

    $regions = [];
    foreach ($layouts[$layout_id]->getRegions() as $region_id => $region) {
      $regions[$region_id] = $region['label'];
    }

    foreach ($types as $type => $fields) {
      foreach ($fields as $id => $filter) {
        if ($type == 'filters') {
          if (!$filter->options['exposed']) {
            continue;
          }
          $filter = $filter->definition['title'];
        }

        $element[$id] = [
          '#type' => 'select',
          '#title' => $filter,
          '#options' => $regions,
        ];

        // Set default region for chosen layout.
        if (!empty($this->options['layout']['widget_region'][$id]) && !empty($regions[$this->options['layout']['widget_region'][$id]])) {
          $element[$id]['#default_value'] = $this->options['layout']['widget_region'][$id];
        }
      }
    }

    return $element;
  }

  /**
   * Form submission handler for ContentTranslationHandler::entityFormAlter().
   *
   * Takes care of content translation deletion.
   */
  public function updateRegions($form, FormStateInterface $form_state) {
    $view = $form_state->get('view');
    $display_id = $form_state->get('display_id');

    $display = &$view->getExecutable()->displayHandlers->get($display_id);
    // optionsOverride toggles the override of this section.
    $display->optionsOverride($form, $form_state);
    $display->submitOptionsForm($form, $form_state);

    $view->cacheSet();
    $form_state->set('rerender', TRUE);
    $form_state->setRebuild();
  }

  /**
   * @inheritdoc
   */
  public function exposedFormAlter(&$form, FormStateInterface $form_state) {
    parent::exposedFormAlter($form, $form_state);

    $view = $form_state->get('view');
    $layout_id = $this->options['layout']['layout_id'];
    $widget_region = $this->options['layout']['widget_region'];

    $form['#vefl_configuration'] = [
      'layout' => [
        'id' => $layout_id,
        'settings' => [],
      ],
      'regions' => []
    ];

    foreach ($widget_region as $field_name => $region) {
      $form['#vefl_configuration']['regions'][$region][] = $field_name;

      // Provides default wrapper settings for Display suite layout.
      if (substr($layout_id, 0, 3) == 'ds_') {
        $form['#vefl_configuration']['layout']['settings']['wrappers'][$region] = 'div';
      }
    }

    $form['#theme'] = $view->buildThemeFunctions('vefl_views_exposed_form');
  }

}
