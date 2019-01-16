<?php

namespace Drupal\vp_pages\Controller;

use Drupal\Core\Controller\ControllerBase;

/** 
 * Provides route responses for vp_pages Saved Search
 */

class SavedSearchController extends ControllerBase {

    /** 
     * Returns a test view
     */

    public function ssearch() {

        $element = ['#markup' => 'Test'];

        return $element;

    }
}