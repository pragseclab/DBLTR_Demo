<?php

declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Table;

use PhpMyAdmin\Core;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\DbTableExists;
use PhpMyAdmin\Operations;
use PhpMyAdmin\Relation;
use PhpMyAdmin\RelationCleanup;
use PhpMyAdmin\Response;
use PhpMyAdmin\Sql;
use PhpMyAdmin\Table\Search;
use PhpMyAdmin\Template;
use PhpMyAdmin\Transformations;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use function in_array;
use function intval;
use function mb_strtolower;
use function md5;
use function preg_match;
use function preg_replace;
use function str_ireplace;
use function str_replace;
use function strncasecmp;
use function strtoupper;
/**
 * Handles table search tab.
 *
 * Display table search form, create SQL query from form data
 * and call Sql::executeQueryAndSendQueryResponse() to execute it.
 */
class SearchController extends AbstractController
{
    /**
     * Names of columns
     *
     * @access private
     * @var array
     */
    private $columnNames;
    /**
     * Types of columns
     *
     * @access private
     * @var array
     */
    private $columnTypes;
    /**
     * Types of columns without any replacement
     *
     * @access private
     * @var array
     */
    private $originalColumnTypes;
    /**
     * Collations of columns
     *
     * @access private
     * @var array
     */
    private $columnCollations;
    /**
     * Null Flags of columns
     *
     * @access private
     * @var array
     */
    private $columnNullFlags;
    /**
     * Whether a geometry column is present
     *
     * @access private
     * @var bool
     */
    private $geomColumnFlag;
    /**
     * Foreign Keys
     *
     * @access private
     * @var array
     */
    private $foreigners;
    /** @var Search */
    private $search;
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
    public function __construct($response, Template $template, $db, $table, Search $search, Relation $relation, $dbi)
    {
        parent::__construct($response, $template, $db, $table);
        $this->search = $search;
        $this->relation = $relation;
        $this->dbi = $dbi;
        $this->columnNames = [];
        $this->columnTypes = [];
        $this->originalColumnTypes = [];
        $this->columnCollations = [];
        $this->columnNullFlags = [];
        $this->geomColumnFlag = false;
        $this->foreigners = [];
        $this->loadTableInfo();
    }
    /**
     * Gets all the columns of a table along with their types, collations
     * and whether null or not.
     */
    private function loadTableInfo() : void
    {
        // Gets the list and number of columns
        $columns = $this->dbi->getColumns($this->db, $this->table, null, true);
        // Get details about the geometry functions
        $geom_types = Util::getGISDatatypes();
        foreach ($columns as $row) {
            // set column name
            $this->columnNames[] = $row['Field'];
            $type = (string) $row['Type'];
            // before any replacement
            $this->originalColumnTypes[] = mb_strtolower($type);
            // check whether table contains geometric columns
            if (in_array($type, $geom_types)) {
                $this->geomColumnFlag = true;
            }
            // reformat mysql query output
            if (strncasecmp($type, 'set', 3) == 0 || strncasecmp($type, 'enum', 4) == 0) {
                $type = str_replace(',', ', ', $type);
            } else {
                // strip the "BINARY" attribute, except if we find "BINARY(" because
                // this would be a BINARY or VARBINARY column type
                if (!preg_match('@BINARY[\\(]@i', $type)) {
                    $type = str_ireplace('BINARY', '', $type);
                }
                $type = str_ireplace('ZEROFILL', '', $type);
                $type = str_ireplace('UNSIGNED', '', $type);
                $type = mb_strtolower($type);
            }
            if (empty($type)) {
                $type = '&nbsp;';
            }
            $this->columnTypes[] = $type;
            $this->columnNullFlags[] = $row['Null'];
            $this->columnCollations[] = !empty($row['Collation']) && $row['Collation'] !== 'NULL' ? $row['Collation'] : '';
        }
        // Retrieve foreign keys
        $this->foreigners = $this->relation->getForeigners($this->db, $this->table);
    }
    /**
     * Index action
     */
    public function index() : void
    {
        global $db, $table, $url_params, $cfg, $err_url;
        Util::checkParameters(['db', 'table']);
        $url_params = ['db' => $db, 'table' => $table];
        $err_url = Util::getScriptNameForOption($cfg['DefaultTabTable'], 'table');
        $err_url .= Url::getCommon($url_params, '&');
        DbTableExists::check();
        $this->addScriptFiles(['makegrid.js', 'vendor/stickyfill.min.js', 'sql.js', 'table/select.js', 'table/change.js', 'vendor/jquery/jquery.uitablefilter.js', 'gis_data_editor.js']);
        if (isset($_POST['range_search'])) {
            $this->rangeSearchAction();
            return;
        }
        /**
         * No selection criteria received -> display the selection form
         */
        if (!isset($_POST['columnsToDisplay']) && !isset($_POST['displayAllColumns'])) {
            $this->displaySelectionFormAction();
        } else {
            $this->doSelectionAction();
        }
    }
    /**
     * Get data row action
     *
     * @return void
     */
    public function getDataRowAction()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDataRowAction") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Controllers/Table/SearchController.php at line 188")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDataRowAction:188@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Controllers/Table/SearchController.php');
        die();
    }
    /**
     * Do selection action
     *
     * @return void
     */
    public function doSelectionAction()
    {
        global $PMA_Theme;
        /**
         * Selection criteria have been submitted -> do the work
         */
        $sql_query = $this->search->buildSqlQuery();
        /**
         * Add this to ensure following procedures included running correctly.
         */
        $sql = new Sql($this->dbi, $this->relation, new RelationCleanup($this->dbi, $this->relation), new Operations($this->dbi, $this->relation), new Transformations(), $this->template);
        $this->response->addHTML($sql->executeQueryAndSendQueryResponse(
            null,
            // analyzed_sql_results
            false,
            // is_gotofile
            $this->db,
            // db
            $this->table,
            // table
            null,
            // find_real_end
            null,
            // sql_query_for_bookmark
            null,
            // extra_data
            null,
            // message_to_show
            null,
            // sql_data
            $GLOBALS['goto'],
            // goto
            $PMA_Theme->getImgPath(),
            null,
            // disp_query
            null,
            // disp_message
            $sql_query,
            // sql_query
            null
        ));
    }
    /**
     * Display selection form action
     */
    public function displaySelectionFormAction() : void
    {
        global $goto, $cfg;
        if (!isset($goto)) {
            $goto = Util::getScriptNameForOption($cfg['DefaultTabTable'], 'table');
        }
        $this->render('table/search/index', ['db' => $this->db, 'table' => $this->table, 'goto' => $goto, 'self' => $this, 'geom_column_flag' => $this->geomColumnFlag, 'column_names' => $this->columnNames, 'column_types' => $this->columnTypes, 'column_collations' => $this->columnCollations, 'default_sliders_state' => $cfg['InitialSlidersState'], 'max_rows' => intval($cfg['MaxRows'])]);
    }
    /**
     * Range search action
     *
     * @return void
     */
    public function rangeSearchAction()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("rangeSearchAction") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Controllers/Table/SearchController.php at line 273")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called rangeSearchAction:273@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Controllers/Table/SearchController.php');
        die();
    }
    /**
     * Finds minimum and maximum value of a given column.
     *
     * @param string $column Column name
     *
     * @return array
     */
    public function getColumnMinMax($column)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getColumnMinMax") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Controllers/Table/SearchController.php at line 285")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getColumnMinMax:285@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Controllers/Table/SearchController.php');
        die();
    }
    /**
     * Provides a column's type, collation, operators list, and criteria value
     * to display in table search form
     *
     * @param int $search_index Row number in table search form
     * @param int $column_index Column index in ColumnNames array
     *
     * @return array Array containing column's properties
     */
    public function getColumnProperties($search_index, $column_index)
    {
        $selected_operator = $_POST['criteriaColumnOperators'][$search_index] ?? '';
        $entered_value = $_POST['criteriaValues'] ?? '';
        //Gets column's type and collation
        $type = $this->columnTypes[$column_index];
        $collation = $this->columnCollations[$column_index];
        $cleanType = preg_replace('@\\(.*@s', '', $type);
        //Gets column's comparison operators depending on column type
        $typeOperators = $this->dbi->types->getTypeOperatorsHtml($cleanType, $this->columnNullFlags[$column_index], $selected_operator);
        $func = $this->template->render('table/search/column_comparison_operators', ['search_index' => $search_index, 'type_operators' => $typeOperators]);
        //Gets link to browse foreign data(if any) and criteria inputbox
        $foreignData = $this->relation->getForeignData($this->foreigners, $this->columnNames[$column_index], false, '', '');
        $htmlAttributes = '';
        if (in_array($cleanType, $this->dbi->types->getIntegerTypes())) {
            $extractedColumnspec = Util::extractColumnSpec($this->originalColumnTypes[$column_index]);
            $is_unsigned = $extractedColumnspec['unsigned'];
            $minMaxValues = $this->dbi->types->getIntegerRange($cleanType, !$is_unsigned);
            $htmlAttributes = 'data-min="' . $minMaxValues[0] . '" ' . 'data-max="' . $minMaxValues[1] . '"';
        }
        $htmlAttributes .= ' onfocus="return ' . 'verifyAfterSearchFieldChange(' . $search_index . ', \'#tbl_search_form\')"';
        $value = $this->template->render('table/search/input_box', ['str' => '', 'column_type' => (string) $type, 'column_data_type' => strtoupper($cleanType), 'html_attributes' => $htmlAttributes, 'column_id' => 'fieldID_', 'in_zoom_search_edit' => false, 'foreigners' => $this->foreigners, 'column_name' => $this->columnNames[$column_index], 'column_name_hash' => md5($this->columnNames[$column_index]), 'foreign_data' => $foreignData, 'table' => $this->table, 'column_index' => $search_index, 'foreign_max_limit' => $GLOBALS['cfg']['ForeignKeyMaxLimit'], 'criteria_values' => $entered_value, 'db' => $this->db, 'in_fbs' => true]);
        return ['type' => $type, 'collation' => $collation, 'func' => $func, 'value' => $value];
    }
}