<?php

/**
 * @file
 * Contains \Drupal\vp_rules\Plugin\RulesAction\SaveCSVToFilesystem.
 */

namespace Drupal\vp_rules\Plugin\RulesAction;

use Drupal\vp_rules\SaveCSVToFilesystemInterface;
use Drupal\rules\Core\RulesActionBase;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides an action to save a csv to the filesystem.
 *
 * @RulesAction(
 *   id = "save_csv_to_filesystem",
 *   label = @Translation("Save CSV to Filesystem"),
 *   category = @Translation("Valeo Partners"),
 * )
 */
class SaveCSVToFilesystem extends RulesActionBase {

  /**
   * Runs drupal view export.
   */
  protected function doExecute() {

    // $view = views_get_view_result('search_by_firm', 'search_by_firm_data_export_csv');

    $view = views_get_view_result('search_by_firm', 'master_search_by_firm_page');

    foreach ($view as $row) {
        print $row->_entity->in_preview->title;
        print "<br /><br/>";
    }

    print "<pre>";
    print_r($view);
    print "<pre>";


    die;


    file_unmanaged_save_data($view, 'public://display.xls', FILE_EXISTS_REPLACE);


  }
}

