<?php

/**
 * @file
 * Tests for optimizedb module.
 */

namespace Drupal\optimizedb\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Testing the performance of operations on tables.
 *
 * @link admin/config/development/optimizedb/list_tables @endlink
 *
 * @group optimizedb
 */
class OptimizedbListTablesOperationExecuteTest extends WebTestBase {

  /**
   * Disabled config schema checking temporarily until all errors are resolved.
   */
  protected $strictConfigSchema = FALSE;

  /**
   * Modules to enable.
   *
   * @var array.
   */
  public static $modules = array('optimizedb');

  /**
   * A user with permission the settings module.
   *
   * @var object
   */
  protected $web_user;

  public function setUp() {
    parent::setUp();

    $this->web_user = $this->drupalCreateUser(array('administer optimizedb settings'));
    $this->drupalLogin($this->web_user);
  }

  /**
   * Performing operations on tables.
   */
  public function testListTablesOperationExecute() {
    $this->drupalPostForm('admin/config/development/optimizedb/list_tables', array(), t('Check tables'));
    $this->assertText(t('To execute, you must select at least one table from the list.'));

    // Output all database tables.
    $tables = _optimizedb_tables_list();
    $table_name = key($tables);

    $edit = array();
    // Selected first table in list.
    $edit['tables[' . $table_name . ']'] = $table_name;

    $this->drupalPostForm('admin/config/development/optimizedb/list_tables', $edit, t('Check tables'));
    $this->assertText(t('The operation completed successfully.'));
  }

}
