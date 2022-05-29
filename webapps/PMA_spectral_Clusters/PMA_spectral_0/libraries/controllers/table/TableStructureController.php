<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds the PMA\TableStructureController
 *
 * @package PMA
 */
namespace PMA\libraries\controllers\table;

use PMA\libraries\config\PageSettings;
use PMA\libraries\Index;
use PMA\libraries\Message;
use PMA\libraries\Template;
use PMA\libraries\Util;
use PMA\Util as Util_lib;
use PhpMyAdmin\SqlParser;
use PhpMyAdmin\SqlParser\Statements\CreateStatement;
use PhpMyAdmin\SqlParser\Utils\Table as SqlTable;
use PMA\libraries\Table;
use PMA\libraries\controllers\TableController;
use PMA\libraries\URL;
require_once 'libraries/transformations.lib.php';
require_once 'libraries/util.lib.php';
require_once 'libraries/config/messages.inc.php';
require_once 'libraries/config/user_preferences.forms.php';
require_once 'libraries/config/page_settings.forms.php';
/**
 * Handles table structure logic
 *
 * @package PhpMyAdmin
 */
class TableStructureController extends TableController
{
    /**
     * @var Table  The table object
     */
    protected $table_obj;
    /**
     * @var string  The URL query string
     */
    protected $_url_query;
    /**
     * @var bool DB is information_schema
     */
    protected $_db_is_system_schema;
    /**
     * @var bool Table is a view
     */
    protected $_tbl_is_view;
    /**
     * @var string Table storage engine
     */
    protected $_tbl_storage_engine;
    /**
     * @var int Number of rows
     */
    protected $_table_info_num_rows;
    /**
     * @var string Table collation
     */
    protected $_tbl_collation;
    /**
     * @var array Show table info
     */
    protected $_showtable;
    /**
     * TableStructureController constructor
     *
     * @param string $type                Indicate the db_structure or tbl_structure
     * @param string $db                  DB name
     * @param string $table               Table name
     * @param string $url_query           URL query
     * @param int    $num_tables          Number of tables
     * @param int    $pos                 Current position in the list
     * @param bool   $db_is_system_schema DB is information_schema
     * @param int    $total_num_tables    Number of tables
     * @param array  $tables              Tables in the DB
     * @param bool   $is_show_stats       Whether stats show or not
     * @param bool   $tbl_is_view         Table is a view
     * @param string $tbl_storage_engine  Table storage engine
     * @param int    $table_info_num_rows Number of rows
     * @param string $tbl_collation       Table collation
     * @param array  $showtable           Show table info
     */
    public function __construct($type, $db, $table, $url_query, $num_tables, $pos, $db_is_system_schema, $total_num_tables, $tables, $is_show_stats, $tbl_is_view, $tbl_storage_engine, $table_info_num_rows, $tbl_collation, $showtable)
    {
        parent::__construct();
        $this->_db_is_system_schema = $db_is_system_schema;
        $this->_url_query = $url_query;
        $this->_tbl_is_view = $tbl_is_view;
        $this->_tbl_storage_engine = $tbl_storage_engine;
        $this->_table_info_num_rows = $table_info_num_rows;
        $this->_tbl_collation = $tbl_collation;
        $this->_showtable = $showtable;
        $this->table_obj = $this->dbi->getTable($this->db, $this->table);
    }
    /**
     * Index action
     *
     * @return void
     */
    public function indexAction()
    {
        PageSettings::showGroup('TableStructure');
        /**
         * Function implementations for this script
         */
        include_once 'libraries/check_user_privileges.lib.php';
        include_once 'libraries/index.lib.php';
        include_once 'libraries/sql.lib.php';
        $this->response->getHeader()->getScripts()->addFiles(array('tbl_structure.js', 'indexes.js'));
        /**
         * Handle column moving
         */
        if (isset($_REQUEST['move_columns']) && is_array($_REQUEST['move_columns']) && $this->response->isAjax()) {
            $this->moveColumns();
            return;
        }
        /**
         * handle MySQL reserved words columns check
         */
        if (isset($_REQUEST['reserved_word_check'])) {
            if ($GLOBALS['cfg']['ReservedWordDisableWarning'] === false) {
                $columns_names = $_REQUEST['field_name'];
                $reserved_keywords_names = array();
                foreach ($columns_names as $column) {
                    if (\PhpMyAdmin\SqlParser\Context::isKeyword(trim($column), true)) {
                        $reserved_keywords_names[] = trim($column);
                    }
                }
                if (\PhpMyAdmin\SqlParser\Context::isKeyword(trim($this->table), true)) {
                    $reserved_keywords_names[] = trim($this->table);
                }
                if (count($reserved_keywords_names) == 0) {
                    $this->response->setRequestStatus(false);
                }
                $this->response->addJSON('message', sprintf(_ngettext('The name \'%s\' is a MySQL reserved keyword.', 'The names \'%s\' are MySQL reserved keywords.', count($reserved_keywords_names)), implode(',', $reserved_keywords_names)));
            } else {
                $this->response->setRequestStatus(false);
            }
            return;
        }
        /**
         * A click on Change has been made for one column
         */
        if (isset($_REQUEST['change_column'])) {
            $this->displayHtmlForColumnChange(null, 'tbl_structure.php');
            return;
        }
        /**
         * Adding or editing partitioning of the table
         */
        if (isset($_REQUEST['edit_partitioning']) && !isset($_REQUEST['save_partitioning'])) {
            $this->displayHtmlForPartitionChange();
            return;
        }
        /**
         * handle multiple field commands if required
         *
         * submit_mult_*_x comes from IE if <input type="img" ...> is used
         */
        $submit_mult = $this->getMultipleFieldCommandType();
        if (!empty($submit_mult)) {
            if (isset($_REQUEST['selected_fld'])) {
                if ($submit_mult == 'browse') {
                    // browsing the table displaying only selected columns
                    $this->displayTableBrowseForSelectedColumns($GLOBALS['goto'], $GLOBALS['pmaThemeImage']);
                } else {
                    // handle multiple field commands
                    // handle confirmation of deleting multiple columns
                    $action = 'tbl_structure.php';
                    $GLOBALS['selected'] = $_REQUEST['selected_fld'];
                    list($what_ret, $query_type_ret, $is_unset_submit_mult, $mult_btn_ret, $centralColsError) = $this->getDataForSubmitMult($submit_mult, $_REQUEST['selected_fld'], $action);
                    //update the existing variables
                    // todo: refactor mult_submits.inc.php such as
                    // below globals are not needed anymore
                    if (isset($what_ret)) {
                        $GLOBALS['what'] = $what_ret;
                        global $what;
                    }
                    if (isset($query_type_ret)) {
                        $GLOBALS['query_type'] = $query_type_ret;
                        global $query_type;
                    }
                    if ($is_unset_submit_mult) {
                        unset($submit_mult);
                    }
                    if (isset($mult_btn_ret)) {
                        $GLOBALS['mult_btn'] = $mult_btn_ret;
                        global $mult_btn;
                    }
                    include 'libraries/mult_submits.inc.php';
                    /**
                     * if $submit_mult == 'change', execution will have stopped
                     * at this point
                     */
                    if (empty($message)) {
                        $message = Message::success();
                    }
                    $this->response->addHTML(Util::getMessage($message, $sql_query));
                }
            } else {
                $this->response->setRequestStatus(false);
                $this->response->addJSON('message', __('No column selected.'));
            }
        }
        // display secondary level tabs if necessary
        $engine = $this->table_obj->getStatusInfo('ENGINE');
        $this->response->addHTML(Template::get('table/secondary_tabs')->render(array('url_params' => array('db' => $this->db, 'table' => $this->table), 'engine' => $engine)));
        $this->response->addHTML('<div id="structure_content">');
        /**
         * Modifications have been submitted -> updates the table
         */
        if (isset($_REQUEST['do_save_data'])) {
            $regenerate = $this->updateColumns();
            if ($regenerate) {
                // This happens when updating failed
                // @todo: do something appropriate
            } else {
                // continue to show the table's structure
                unset($_REQUEST['selected']);
            }
        }
        /**
         * Modifications to the partitioning have been submitted -> updates the table
         */
        if (isset($_REQUEST['save_partitioning'])) {
            $this->updatePartitioning();
        }
        /**
         * Adding indexes
         */
        if (isset($_REQUEST['add_key']) || isset($_REQUEST['partition_maintenance'])) {
            //todo: set some variables for sql.php include, to be eliminated
            //after refactoring sql.php
            $db = $this->db;
            $table = $this->table;
            $cfg = $GLOBALS['cfg'];
            $is_superuser = $GLOBALS['dbi']->isSuperuser();
            $pmaThemeImage = $GLOBALS['pmaThemeImage'];
            include 'sql.php';
            $GLOBALS['reload'] = true;
        }
        /**
         * Gets the relation settings
         */
        $cfgRelation = PMA_getRelationsParam();
        /**
         * Runs common work
         */
        // set db, table references, for require_once that follows
        // got to be eliminated in long run
        $db =& $this->db;
        $table =& $this->table;
        $url_params = array();
        include_once 'libraries/tbl_common.inc.php';
        $this->_db_is_system_schema = $db_is_system_schema;
        $this->_url_query = $url_query . '&amp;goto=tbl_structure.php&amp;back=tbl_structure.php';
        /* The url_params array is initialized in above include */
        $url_params['goto'] = 'tbl_structure.php';
        $url_params['back'] = 'tbl_structure.php';
        /**
         * Gets tables information
         */
        include_once 'libraries/tbl_info.inc.php';
        // 2. Gets table keys and retains them
        // @todo should be: $server->db($db)->table($table)->primary()
        $primary = Index::getPrimary($this->table, $this->db);
        $columns_with_index = $this->dbi->getTable($this->db, $this->table)->getColumnsWithIndex(Index::UNIQUE | Index::INDEX | Index::SPATIAL | Index::FULLTEXT);
        $columns_with_unique_index = $this->dbi->getTable($this->db, $this->table)->getColumnsWithIndex(Index::UNIQUE);
        // 3. Get fields
        $fields = (array) $this->dbi->getColumns($this->db, $this->table, null, true);
        //display table structure
        $this->response->addHTML($this->displayStructure($cfgRelation, $columns_with_unique_index, $url_params, $primary, $fields, $columns_with_index));
        $this->response->addHTML('</div>');
    }
    /**
     * Moves columns in the table's structure based on $_REQUEST
     *
     * @return void
     */
    protected function moveColumns()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("moveColumns") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 369")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called moveColumns:369@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Displays HTML for changing one or more columns
     *
     * @param array  $selected the selected columns
     * @param string $action   target script to call
     *
     * @return boolean $regenerate true if error occurred
     *
     */
    protected function displayHtmlForColumnChange($selected, $action)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("displayHtmlForColumnChange") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 484")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called displayHtmlForColumnChange:484@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Displays HTML for partition change
     *
     * @return string HTML for partition change
     */
    protected function displayHtmlForPartitionChange()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("displayHtmlForPartitionChange") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 522")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called displayHtmlForPartitionChange:522@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Extracts partition details from CREATE TABLE statement
     *
     * @return array[] array of partition details
     */
    private function _extractPartitionDetails()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_extractPartitionDetails") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 547")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _extractPartitionDetails:547@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Update the table's partitioning based on $_REQUEST
     *
     * @return void
     */
    protected function updatePartitioning()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updatePartitioning") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 708")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updatePartitioning:708@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Function to get the type of command for multiple field handling
     *
     * @return string
     */
    protected function getMultipleFieldCommandType()
    {
        $types = array('change', 'drop', 'primary', 'index', 'unique', 'spatial', 'fulltext', 'browse');
        foreach ($types as $type) {
            if (isset($_REQUEST['submit_mult_' . $type . '_x'])) {
                return $type;
            }
        }
        if (isset($_REQUEST['submit_mult'])) {
            return $_REQUEST['submit_mult'];
        } elseif (isset($_REQUEST['mult_btn']) && $_REQUEST['mult_btn'] == __('Yes')) {
            if (isset($_REQUEST['selected'])) {
                $_REQUEST['selected_fld'] = $_REQUEST['selected'];
            }
            return 'row_delete';
        }
        return null;
    }
    /**
     * Function to display table browse for selected columns
     *
     * @param string $goto          goto page url
     * @param string $pmaThemeImage URI of the pma theme image
     *
     * @return void
     */
    protected function displayTableBrowseForSelectedColumns($goto, $pmaThemeImage)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("displayTableBrowseForSelectedColumns") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 778")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called displayTableBrowseForSelectedColumns:778@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Update the table's structure based on $_REQUEST
     *
     * @return boolean $regenerate              true if error occurred
     *
     */
    protected function updateColumns()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updateColumns") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 834")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updateColumns:834@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Adjusts the Privileges for all the columns whose names have changed
     *
     * @param array $adjust_privileges assoc array of old col names mapped to new
     *                                 cols
     *
     * @return boolean $changed  boolean whether at least one column privileges
     * adjusted
     */
    protected function adjustColumnPrivileges($adjust_privileges)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("adjustColumnPrivileges") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 1070")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called adjustColumnPrivileges:1070@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Verifies if some elements of a column have changed
     *
     * @param integer $i column index in the request
     *
     * @return boolean $alterTableNeeded true if we need to generate ALTER TABLE
     *
     */
    protected function columnNeedsAlterTable($i)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("columnNeedsAlterTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 1116")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called columnNeedsAlterTable:1116@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Displays the table structure ('show table' works correct since 3.23.03)
     *
     * @param array       $cfgRelation               current relation parameters
     * @param array       $columns_with_unique_index Columns with unique index
     * @param mixed       $url_params                Contains an associative
     *                                               array with url params
     * @param Index|false $primary_index             primary index or false if
     *                                               no one exists
     * @param array       $fields                    Fields
     * @param array       $columns_with_index        Columns with index
     *
     * @return string
     */
    protected function displayStructure($cfgRelation, $columns_with_unique_index, $url_params, $primary_index, $fields, $columns_with_index)
    {
        /* TABLE INFORMATION */
        $HideStructureActions = '';
        if ($GLOBALS['cfg']['HideStructureActions'] === true) {
            $HideStructureActions .= ' HideStructureActions';
        }
        // prepare comments
        $comments_map = array();
        $mime_map = array();
        if ($GLOBALS['cfg']['ShowPropertyComments']) {
            include_once 'libraries/transformations.lib.php';
            $comments_map = PMA_getComments($this->db, $this->table);
            if ($cfgRelation['mimework'] && $GLOBALS['cfg']['BrowseMIME']) {
                $mime_map = PMA_getMIME($this->db, $this->table, true);
            }
        }
        include_once 'libraries/central_columns.lib.php';
        $central_list = PMA_getCentralColumnsFromTable($this->db, $this->table);
        $columns_list = array();
        $titles = array('Change' => Util::getIcon('b_edit.png', __('Change')), 'Drop' => Util::getIcon('b_drop.png', __('Drop')), 'NoDrop' => Util::getIcon('b_drop.png', __('Drop')), 'Primary' => Util::getIcon('b_primary.png', __('Primary')), 'Index' => Util::getIcon('b_index.png', __('Index')), 'Unique' => Util::getIcon('b_unique.png', __('Unique')), 'Spatial' => Util::getIcon('b_spatial.png', __('Spatial')), 'IdxFulltext' => Util::getIcon('b_ftext.png', __('Fulltext')), 'NoPrimary' => Util::getIcon('bd_primary.png', __('Primary')), 'NoIndex' => Util::getIcon('bd_index.png', __('Index')), 'NoUnique' => Util::getIcon('bd_unique.png', __('Unique')), 'NoSpatial' => Util::getIcon('bd_spatial.png', __('Spatial')), 'NoIdxFulltext' => Util::getIcon('bd_ftext.png', __('Fulltext')), 'DistinctValues' => Util::getIcon('b_browse.png', __('Distinct values')));
        /**
         * Work on the table
         */
        if ($this->_tbl_is_view && !$this->_db_is_system_schema) {
            $item = $this->dbi->fetchSingleRow(sprintf("SELECT `VIEW_DEFINITION`, `CHECK_OPTION`, `DEFINER`,\n                      `SECURITY_TYPE`\n                    FROM `INFORMATION_SCHEMA`.`VIEWS`\n                    WHERE TABLE_SCHEMA='%s'\n                    AND TABLE_NAME='%s';", $GLOBALS['dbi']->escapeString($this->db), $GLOBALS['dbi']->escapeString($this->table)));
            $createView = $this->dbi->getTable($this->db, $this->table)->showCreate();
            // get algorithm from $createView of the form
            // CREATE ALGORITHM=<ALGORITHM> DE...
            $parts = explode(" ", substr($createView, 17));
            $item['ALGORITHM'] = $parts[0];
            $view = array('operation' => 'alter', 'definer' => $item['DEFINER'], 'sql_security' => $item['SECURITY_TYPE'], 'name' => $this->table, 'as' => $item['VIEW_DEFINITION'], 'with' => $item['CHECK_OPTION'], 'algorithm' => $item['ALGORITHM']);
            $edit_view_url = 'view_create.php' . URL::getCommon($url_params) . '&amp;' . implode('&amp;', array_map(function ($key, $val) {
                return 'view[' . urlencode($key) . ']=' . urlencode($val);
            }, array_keys($view), $view));
        }
        /**
         * Displays Space usage and row statistics
         */
        // BEGIN - Calc Table Space
        // Get valid statistics whatever is the table type
        if ($GLOBALS['cfg']['ShowStats']) {
            //get table stats in HTML format
            $tablestats = $this->getTableStats();
            //returning the response in JSON format to be used by Ajax
            $this->response->addJSON('tableStat', $tablestats);
        }
        // END - Calc Table Space
        return Template::get('table/structure/display_structure')->render(array('HideStructureActions' => $HideStructureActions, 'db' => $this->db, 'table' => $this->table, 'db_is_system_schema' => $this->_db_is_system_schema, 'tbl_is_view' => $this->_tbl_is_view, 'mime_map' => $mime_map, 'url_query' => $this->_url_query, 'titles' => $titles, 'tbl_storage_engine' => $this->_tbl_storage_engine, 'primary' => $primary_index, 'columns_with_unique_index' => $columns_with_unique_index, 'edit_view_url' => isset($edit_view_url) ? $edit_view_url : null, 'columns_list' => $columns_list, 'tablestats' => isset($tablestats) ? $tablestats : null, 'fields' => $fields, 'columns_with_index' => $columns_with_index, 'central_list' => $central_list, 'comments_map' => $comments_map));
    }
    /**
     * Get HTML snippet for display table statistics
     *
     * @return string $html_output
     */
    protected function getTableStats()
    {
        if (empty($this->_showtable)) {
            $this->_showtable = $this->dbi->getTable($this->db, $this->table)->getStatusInfo(null, true);
        }
        if (empty($this->_showtable['Data_length'])) {
            $this->_showtable['Data_length'] = 0;
        }
        if (empty($this->_showtable['Index_length'])) {
            $this->_showtable['Index_length'] = 0;
        }
        $is_innodb = isset($this->_showtable['Type']) && $this->_showtable['Type'] == 'InnoDB';
        $mergetable = $this->table_obj->isMerge();
        // this is to display for example 261.2 MiB instead of 268k KiB
        $max_digits = 3;
        $decimals = 1;
        list($data_size, $data_unit) = Util::formatByteDown($this->_showtable['Data_length'], $max_digits, $decimals);
        if ($mergetable == false) {
            list($index_size, $index_unit) = Util::formatByteDown($this->_showtable['Index_length'], $max_digits, $decimals);
        }
        // InnoDB returns a huge value in Data_free, do not use it
        if (!$is_innodb && isset($this->_showtable['Data_free']) && $this->_showtable['Data_free'] > 0) {
            list($free_size, $free_unit) = Util::formatByteDown($this->_showtable['Data_free'], $max_digits, $decimals);
            list($effect_size, $effect_unit) = Util::formatByteDown($this->_showtable['Data_length'] + $this->_showtable['Index_length'] - $this->_showtable['Data_free'], $max_digits, $decimals);
        } else {
            list($effect_size, $effect_unit) = Util::formatByteDown($this->_showtable['Data_length'] + $this->_showtable['Index_length'], $max_digits, $decimals);
        }
        list($tot_size, $tot_unit) = Util::formatByteDown($this->_showtable['Data_length'] + $this->_showtable['Index_length'], $max_digits, $decimals);
        if ($this->_table_info_num_rows > 0) {
            list($avg_size, $avg_unit) = Util::formatByteDown(($this->_showtable['Data_length'] + $this->_showtable['Index_length']) / $this->_showtable['Rows'], 6, 1);
        } else {
            $avg_size = $avg_unit = '';
        }
        return Template::get('table/structure/display_table_stats')->render(array('showtable' => $this->_showtable, 'table_info_num_rows' => $this->_table_info_num_rows, 'tbl_is_view' => $this->_tbl_is_view, 'db_is_system_schema' => $this->_db_is_system_schema, 'tbl_storage_engine' => $this->_tbl_storage_engine, 'url_query' => $this->_url_query, 'tbl_collation' => $this->_tbl_collation, 'is_innodb' => $is_innodb, 'mergetable' => $mergetable, 'avg_size' => isset($avg_size) ? $avg_size : null, 'avg_unit' => isset($avg_unit) ? $avg_unit : null, 'data_size' => $data_size, 'data_unit' => $data_unit, 'index_size' => isset($index_size) ? $index_size : null, 'index_unit' => isset($index_unit) ? $index_unit : null, 'free_size' => isset($free_size) ? $free_size : null, 'free_unit' => isset($free_unit) ? $free_unit : null, 'effect_size' => $effect_size, 'effect_unit' => $effect_unit, 'tot_size' => $tot_size, 'tot_unit' => $tot_unit));
    }
    /**
     * Gets table primary key
     *
     * @return string
     */
    protected function getKeyForTablePrimary()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getKeyForTablePrimary") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 1391")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getKeyForTablePrimary:1391@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
    /**
     * Get List of information for Submit Mult
     *
     * @param string $submit_mult mult_submit type
     * @param array  $selected    the selected columns
     * @param string $action      action type
     *
     * @return array
     */
    protected function getDataForSubmitMult($submit_mult, $selected, $action)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDataForSubmitMult") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php at line 1418")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDataForSubmitMult:1418@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableStructureController.php');
        die();
    }
}