<?php

declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Table;

use PhpMyAdmin\Core;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Index;
use PhpMyAdmin\Relation;
use PhpMyAdmin\Response;
use PhpMyAdmin\Table;
use PhpMyAdmin\Template;
use PhpMyAdmin\Util;
use function array_key_exists;
use function array_keys;
use function array_values;
use function htmlspecialchars;
use function mb_strtoupper;
use function md5;
use function strtoupper;
use function uksort;
use function usort;
/**
 * Display table relations for viewing and editing.
 *
 * Includes phpMyAdmin relations and InnoDB relations.
 */
final class RelationController extends AbstractController
{
    /** @var Relation */
    private $relation;
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param Response          $response
     * @param string            $db       Database name
     * @param string            $table    Table name
     * @param DatabaseInterface $dbi
     */
    public function __construct($response, Template $template, $db, $table, Relation $relation, $dbi)
    {
        parent::__construct($response, $template, $db, $table);
        $this->relation = $relation;
        $this->dbi = $dbi;
    }
    /**
     * Index
     */
    public function index() : void
    {
        global $route;
        $options = ['CASCADE' => 'CASCADE', 'SET_NULL' => 'SET NULL', 'NO_ACTION' => 'NO ACTION', 'RESTRICT' => 'RESTRICT'];
        $table = $this->dbi->getTable($this->db, $this->table);
        $storageEngine = mb_strtoupper((string) $table->getStatusInfo('Engine'));
        $cfgRelation = $this->relation->getRelationsParam();
        $relations = [];
        if ($cfgRelation['relwork']) {
            $relations = $this->relation->getForeigners($this->db, $this->table, '', 'internal');
        }
        $relationsForeign = [];
        if (Util::isForeignKeySupported($storageEngine)) {
            $relationsForeign = $this->relation->getForeigners($this->db, $this->table, '', 'foreign');
        }
        // Send table of column names to populate corresponding dropdowns depending
        // on the current selection
        if (isset($_POST['getDropdownValues']) && $_POST['getDropdownValues'] === 'true') {
            // if both db and table are selected
            if (isset($_POST['foreignTable'])) {
                $this->getDropdownValueForTable();
            } else {
                // if only the db is selected
                $this->getDropdownValueForDatabase($storageEngine);
            }
            return;
        }
        $this->addScriptFiles(['table/relation.js', 'indexes.js']);
        // Set the database
        $this->dbi->selectDb($this->db);
        // updates for Internal relations
        if (isset($_POST['destination_db']) && $cfgRelation['relwork']) {
            $this->updateForInternalRelation($table, $cfgRelation, $relations);
        }
        // updates for foreign keys
        $this->updateForForeignKeys($table, $options, $relationsForeign);
        // Updates for display field
        if ($cfgRelation['displaywork'] && isset($_POST['display_field'])) {
            $this->updateForDisplayField($table, $cfgRelation);
        }
        // If we did an update, refresh our data
        if (isset($_POST['destination_db']) && $cfgRelation['relwork']) {
            $relations = $this->relation->getForeigners($this->db, $this->table, '', 'internal');
        }
        if (isset($_POST['destination_foreign_db']) && Util::isForeignKeySupported($storageEngine)) {
            $relationsForeign = $this->relation->getForeigners($this->db, $this->table, '', 'foreign');
        }
        /**
         * Dialog
         */
        // Now find out the columns of our $table
        // need to use DatabaseInterface::QUERY_STORE with $this->dbi->numRows()
        // in mysqli
        $columns = $this->dbi->getColumns($this->db, $this->table);
        $column_array = [];
        $column_hash_array = [];
        $column_array[''] = '';
        foreach ($columns as $column) {
            if (strtoupper($storageEngine) !== 'INNODB' && empty($column['Key'])) {
                continue;
            }
            $column_array[$column['Field']] = $column['Field'];
            $column_hash_array[$column['Field']] = md5($column['Field']);
        }
        if ($GLOBALS['cfg']['NaturalOrder']) {
            uksort($column_array, 'strnatcasecmp');
        }
        // common form
        $engine = $this->dbi->getTable($this->db, $this->table)->getStorageEngine();
        $this->render('table/relation/common_form', ['is_foreign_key_supported' => Util::isForeignKeySupported($engine), 'db' => $this->db, 'table' => $this->table, 'cfg_relation' => $cfgRelation, 'tbl_storage_engine' => $storageEngine, 'existrel' => $relations, 'existrel_foreign' => array_key_exists('foreign_keys_data', $relationsForeign) ? $relationsForeign['foreign_keys_data'] : [], 'options_array' => $options, 'column_array' => $column_array, 'column_hash_array' => $column_hash_array, 'save_row' => array_values($columns), 'url_params' => $GLOBALS['url_params'], 'databases' => $GLOBALS['dblist']->databases, 'dbi' => $this->dbi, 'default_sliders_state' => $GLOBALS['cfg']['InitialSlidersState'], 'route' => $route]);
    }
    /**
     * Update for display field
     *
     * @param Table $table       table
     * @param array $cfgRelation relation parameters
     */
    private function updateForDisplayField(Table $table, array $cfgRelation) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updateForDisplayField") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Controllers/Table/RelationController.php at line 129")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updateForDisplayField:129@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Controllers/Table/RelationController.php');
        die();
    }
    /**
     * Update for FK
     *
     * @param Table $table            Table
     * @param array $options          Options
     * @param array $relationsForeign External relations
     */
    private function updateForForeignKeys(Table $table, array $options, array $relationsForeign) : void
    {
        $multi_edit_columns_name = $_POST['foreign_key_fields_name'] ?? null;
        $preview_sql_data = '';
        $seen_error = false;
        // (for now, one index name only; we keep the definitions if the
        // foreign db is not the same)
        if (isset($_POST['destination_foreign_db'], $_POST['destination_foreign_table']) && isset($_POST['destination_foreign_column'])) {
            [$html, $preview_sql_data, $display_query, $seen_error] = $table->updateForeignKeys($_POST['destination_foreign_db'], $multi_edit_columns_name, $_POST['destination_foreign_table'], $_POST['destination_foreign_column'], $options, $this->table, array_key_exists('foreign_keys_data', $relationsForeign) ? $relationsForeign['foreign_keys_data'] : []);
            $this->response->addHTML($html);
        }
        // If there is a request for SQL previewing.
        if (isset($_POST['preview_sql'])) {
            Core::previewSQL($preview_sql_data);
            exit;
        }
        if (empty($display_query) || $seen_error) {
            return;
        }
        $GLOBALS['display_query'] = $display_query;
        $this->response->addHTML(Generator::getMessage(__('Your SQL query has been executed successfully.'), null, 'success'));
    }
    /**
     * Update for internal relation
     *
     * @param Table $table       Table
     * @param array $cfgRelation Relation parameters
     * @param array $relations   Relations
     */
    private function updateForInternalRelation(Table $table, array $cfgRelation, array $relations) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updateForInternalRelation") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Controllers/Table/RelationController.php at line 172")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updateForInternalRelation:172@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Controllers/Table/RelationController.php');
        die();
    }
    /**
     * Send table columns for foreign table dropdown
     */
    public function getDropdownValueForTable() : void
    {
        $foreignTable = $_POST['foreignTable'];
        $table_obj = $this->dbi->getTable($_POST['foreignDb'], $foreignTable);
        // Since views do not have keys defined on them provide the full list of
        // columns
        if ($table_obj->isView()) {
            $columnList = $table_obj->getColumns(false, false);
        } else {
            $columnList = $table_obj->getIndexedColumns(false, false);
        }
        $columns = [];
        foreach ($columnList as $column) {
            $columns[] = htmlspecialchars($column);
        }
        if ($GLOBALS['cfg']['NaturalOrder']) {
            usort($columns, 'strnatcasecmp');
        }
        $this->response->addJSON('columns', $columns);
        // @todo should be: $server->db($db)->table($table)->primary()
        $primary = Index::getPrimary($foreignTable, $_POST['foreignDb']);
        if ($primary === false) {
            return;
        }
        $this->response->addJSON('primary', array_keys($primary->getColumns()));
    }
    /**
     * Send database selection values for dropdown
     *
     * @param string $storageEngine Storage engine.
     */
    public function getDropdownValueForDatabase(string $storageEngine) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDropdownValueForDatabase") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Controllers/Table/RelationController.php at line 214")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDropdownValueForDatabase:214@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Controllers/Table/RelationController.php');
        die();
    }
}