<?php

namespace Drupal\vefl_bef\Plugin\views\exposed_form;

use Drupal\better_exposed_filters\Plugin\views\exposed_form\BetterExposedFilters;
use Drupal\vefl\Plugin\views\exposed_form\VeflTrait;

/**
 * Exposed form plugin that provides a better exposed filters form with layout.
 *
 * @ingroup views_exposed_form_plugins
 *
 * @ViewsExposedForm(
 *   id = "vefl_bef",
 *   title = @Translation("Better Exposed Filters (with layout)"),
 *   help = @Translation("Adds layout settings for Better Exposed Filters")
 * )
 */
class VeflBef extends BetterExposedFilters {
  use VeflTrait;
}
