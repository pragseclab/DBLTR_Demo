<?php

declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Database;

use PhpMyAdmin\Charsets;
use PhpMyAdmin\CheckUserPrivileges;
use PhpMyAdmin\Config\PageSettings;
use PhpMyAdmin\Core;
use PhpMyAdmin\Database\CentralColumns;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Message;
use PhpMyAdmin\Operations;
use PhpMyAdmin\RecentFavoriteTable;
use PhpMyAdmin\Relation;
use PhpMyAdmin\RelationCleanup;
use PhpMyAdmin\Replication;
use PhpMyAdmin\ReplicationInfo;
use PhpMyAdmin\Response;
use PhpMyAdmin\Sanitize;
use PhpMyAdmin\Sql;
use PhpMyAdmin\Table;
use PhpMyAdmin\Template;
use PhpMyAdmin\Tracker;
use PhpMyAdmin\Transformations;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use function array_search;
use function ceil;
use function count;
use function htmlspecialchars;
use function implode;
use function in_array;
use function is_string;
use function json_decode;
use function json_encode;
use function max;
use function mb_strlen;
use function mb_substr;
use function md5;
use function preg_match;
use function preg_quote;
use function sha1;
use function sprintf;
use function str_replace;
use function strlen;
use function strtotime;
use function urlencode;
/**
 * Handles database structure logic
 */
class StructureController extends AbstractController
{
    /** @var int Number of tables */
    protected $numTables;
    /** @var int Current position in the list */
    protected $position;
    /** @var bool DB is information_schema */
    protected $dbIsSystemSchema;
    /** @var int Number of tables */
    protected $totalNumTables;
    /** @var array Tables in the database */
    protected $tables;
    /** @var bool whether stats show or not */
    protected $isShowStats;
    /** @var Relation */
    private $relation;
    /** @var Replication */
    private $replication;
    /** @var RelationCleanup */
    private $relationCleanup;
    /** @var Operations */
    private $operations;
    /** @var ReplicationInfo */
    private $replicationInfo;
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param Response          $response
     * @param string            $db          Database name
     * @param Relation          $relation
     * @param Replication       $replication
     * @param DatabaseInterface $dbi
     */
    public function __construct($response, Template $template, $db, $relation, $replication, RelationCleanup $relationCleanup, Operations $operations, $dbi)
    {
        parent::__construct($response, $template, $db);
        $this->relation = $relation;
        $this->replication = $replication;
        $this->relationCleanup = $relationCleanup;
        $this->operations = $operations;
        $this->dbi = $dbi;
        $this->replicationInfo = new ReplicationInfo($this->dbi);
    }
    /**
     * Retrieves database information for further use
     *
     * @param string $subPart Page part name
     */
    private function getDatabaseInfo(string $subPart) : void
    {
        [$tables, $numTables, $totalNumTables, , $isShowStats, $dbIsSystemSchema, , , $position] = Util::getDbInfo($this->db, $subPart);
        $this->tables = $tables;
        $this->numTables = $numTables;
        $this->position = $position;
        $this->dbIsSystemSchema = $dbIsSystemSchema;
        $this->totalNumTables = $totalNumTables;
        $this->isShowStats = $isShowStats;
    }
    public function index() : void
    {
        global $cfg, $db, $err_url;
        $parameters = ['sort' => $_REQUEST['sort'] ?? null, 'sort_order' => $_REQUEST['sort_order'] ?? null];
        Util::checkParameters(['db']);
        $err_url = Util::getScriptNameForOption($cfg['DefaultTabDatabase'], 'database');
        $err_url .= Url::getCommon(['db' => $db], '&');
        if (!$this->hasDatabase()) {
            return;
        }
        $this->addScriptFiles(['database/structure.js', 'table/change.js']);
        // Gets the database structure
        $this->getDatabaseInfo('_structure');
        // Checks if there are any tables to be shown on current page.
        // If there are no tables, the user is redirected to the last page
        // having any.
        if ($this->totalNumTables > 0 && $this->position > $this->totalNumTables) {
            $uri = './index.php?route=/database/structure' . Url::getCommonRaw(['db' => $this->db, 'pos' => max(0, $this->totalNumTables - $cfg['MaxTableList']), 'reload' => 1], '&');
            Core::sendHeaderLocation($uri);
        }
        $this->replicationInfo->load($_POST['master_connection'] ?? null);
        $replicaInfo = $this->replicationInfo->getReplicaInfo();
        $pageSettings = new PageSettings('DbStructure');
        $this->response->addHTML($pageSettings->getErrorHTML());
        $this->response->addHTML($pageSettings->getHTML());
        if ($this->numTables > 0) {
            $urlParams = ['pos' => $this->position, 'db' => $this->db];
            if (isset($parameters['sort'])) {
                $urlParams['sort'] = $parameters['sort'];
            }
            if (isset($parameters['sort_order'])) {
                $urlParams['sort_order'] = $parameters['sort_order'];
            }
            $listNavigator = Generator::getListNavigator($this->totalNumTables, $this->position, $urlParams, Url::getFromRoute('/database/structure'), 'frame_content', $cfg['MaxTableList']);
            $tableList = $this->displayTableList($replicaInfo);
        }
        $createTable = '';
        if (empty($this->dbIsSystemSchema)) {
            $checkUserPrivileges = new CheckUserPrivileges($this->dbi);
            $checkUserPrivileges->getPrivileges();
            $createTable = $this->template->render('database/create_table', ['db' => $this->db]);
        }
        $this->render('database/structure/index', ['database' => $this->db, 'has_tables' => $this->numTables > 0, 'list_navigator_html' => $listNavigator ?? '', 'table_list_html' => $tableList ?? '', 'is_system_schema' => !empty($this->dbIsSystemSchema), 'create_table_html' => $createTable]);
    }
    public function addRemoveFavoriteTablesAction() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addRemoveFavoriteTablesAction") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 157")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addRemoveFavoriteTablesAction:157@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    /**
     * Handles request for real row count on database level view page.
     */
    public function handleRealRowCountRequestAction() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handleRealRowCountRequestAction") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 225")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handleRealRowCountRequestAction:225@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function copyTable() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("copyTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 253")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called copyTable:253@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    /**
     * @param array $replicaInfo
     */
    protected function displayTableList($replicaInfo) : string
    {
        global $PMA_Theme;
        $html = '';
        // filtering
        $html .= $this->template->render('filter', ['filter_value' => '']);
        $i = $sum_entries = 0;
        $overhead_check = false;
        $create_time_all = '';
        $update_time_all = '';
        $check_time_all = '';
        $num_columns = $GLOBALS['cfg']['PropertiesNumColumns'] > 1 ? ceil($this->numTables / $GLOBALS['cfg']['PropertiesNumColumns']) + 1 : 0;
        $row_count = 0;
        $sum_size = 0;
        $overhead_size = 0;
        $hidden_fields = [];
        $overall_approx_rows = false;
        $structure_table_rows = [];
        foreach ($this->tables as $keyname => $current_table) {
            // Get valid statistics whatever is the table type
            $drop_query = '';
            $drop_message = '';
            $overhead = '';
            $input_class = ['checkall'];
            // Sets parameters for links
            $tableUrlParams = ['db' => $this->db, 'table' => $current_table['TABLE_NAME']];
            // do not list the previous table's size info for a view
            [$current_table, $formatted_size, $unit, $formatted_overhead, $overhead_unit, $overhead_size, $table_is_view, $sum_size] = $this->getStuffForEngineTypeTable($current_table, $sum_size, $overhead_size);
            $curTable = $this->dbi->getTable($this->db, $current_table['TABLE_NAME']);
            if (!$curTable->isMerge()) {
                $sum_entries += $current_table['TABLE_ROWS'];
            }
            $collationDefinition = '---';
            if (isset($current_table['Collation'])) {
                $tableCollation = Charsets::findCollationByName($this->dbi, $GLOBALS['cfg']['Server']['DisableIS'], $current_table['Collation']);
                if ($tableCollation !== null) {
                    $collationDefinition = $this->template->render('database/structure/collation_definition', ['valueTitle' => $tableCollation->getDescription(), 'value' => $tableCollation->getName()]);
                }
            }
            if ($this->isShowStats) {
                $overhead = '-';
                if ($formatted_overhead != '') {
                    $overhead = $this->template->render('database/structure/overhead', ['table_url_params' => $tableUrlParams, 'formatted_overhead' => $formatted_overhead, 'overhead_unit' => $overhead_unit]);
                    $overhead_check = true;
                    $input_class[] = 'tbl-overhead';
                }
            }
            if ($GLOBALS['cfg']['ShowDbStructureCharset']) {
                $charset = '';
                if (isset($tableCollation)) {
                    $charset = $tableCollation->getCharset();
                }
            }
            if ($GLOBALS['cfg']['ShowDbStructureCreation']) {
                $create_time = $current_table['Create_time'] ?? '';
                if ($create_time && (!$create_time_all || $create_time < $create_time_all)) {
                    $create_time_all = $create_time;
                }
            }
            if ($GLOBALS['cfg']['ShowDbStructureLastUpdate']) {
                $update_time = $current_table['Update_time'] ?? '';
                if ($update_time && (!$update_time_all || $update_time < $update_time_all)) {
                    $update_time_all = $update_time;
                }
            }
            if ($GLOBALS['cfg']['ShowDbStructureLastCheck']) {
                $check_time = $current_table['Check_time'] ?? '';
                if ($check_time && (!$check_time_all || $check_time < $check_time_all)) {
                    $check_time_all = $check_time;
                }
            }
            $truename = $current_table['TABLE_NAME'];
            $i++;
            $row_count++;
            if ($table_is_view) {
                $hidden_fields[] = '<input type="hidden" name="views[]" value="' . htmlspecialchars($current_table['TABLE_NAME']) . '">';
            }
            /*
             * Always activate links for Browse, Search and Empty, even if
             * the icons are greyed, because
             * 1. for views, we don't know the number of rows at this point
             * 2. for tables, another source could have populated them since the
             *    page was generated
             *
             * I could have used the PHP ternary conditional operator but I find
             * the code easier to read without this operator.
             */
            $may_have_rows = $current_table['TABLE_ROWS'] > 0 || $table_is_view;
            if (!$this->dbIsSystemSchema) {
                $drop_query = sprintf('DROP %s %s', $table_is_view || $current_table['ENGINE'] == null ? 'VIEW' : 'TABLE', Util::backquote($current_table['TABLE_NAME']));
                $drop_message = sprintf($table_is_view || $current_table['ENGINE'] == null ? __('View %s has been dropped.') : __('Table %s has been dropped.'), str_replace(' ', '&nbsp;', htmlspecialchars($current_table['TABLE_NAME'])));
            }
            if ($num_columns > 0 && $this->numTables > $num_columns && $row_count % $num_columns == 0) {
                $row_count = 1;
                $html .= $this->template->render('database/structure/table_header', ['db' => $this->db, 'db_is_system_schema' => $this->dbIsSystemSchema, 'replication' => $replicaInfo['status'], 'properties_num_columns' => $GLOBALS['cfg']['PropertiesNumColumns'], 'is_show_stats' => $this->isShowStats, 'show_charset' => $GLOBALS['cfg']['ShowDbStructureCharset'], 'show_comment' => $GLOBALS['cfg']['ShowDbStructureComment'], 'show_creation' => $GLOBALS['cfg']['ShowDbStructureCreation'], 'show_last_update' => $GLOBALS['cfg']['ShowDbStructureLastUpdate'], 'show_last_check' => $GLOBALS['cfg']['ShowDbStructureLastCheck'], 'num_favorite_tables' => $GLOBALS['cfg']['NumFavoriteTables'], 'structure_table_rows' => $structure_table_rows]);
                $structure_table_rows = [];
            }
            [$approx_rows, $show_superscript] = $this->isRowCountApproximated($current_table, $table_is_view);
            [$do, $ignored] = $this->getReplicationStatus($replicaInfo, $truename);
            $structure_table_rows[] = ['table_name_hash' => md5($current_table['TABLE_NAME']), 'db_table_name_hash' => md5($this->db . '.' . $current_table['TABLE_NAME']), 'db' => $this->db, 'curr' => $i, 'input_class' => implode(' ', $input_class), 'table_is_view' => $table_is_view, 'current_table' => $current_table, 'may_have_rows' => $may_have_rows, 'browse_table_label_title' => htmlspecialchars($current_table['TABLE_COMMENT']), 'browse_table_label_truename' => $truename, 'empty_table_sql_query' => 'TRUNCATE ' . Util::backquote($current_table['TABLE_NAME']), 'empty_table_message_to_show' => urlencode(sprintf(__('Table %s has been emptied.'), htmlspecialchars($current_table['TABLE_NAME']))), 'tracking_icon' => $this->getTrackingIcon($truename), 'server_slave_status' => $replicaInfo['status'], 'table_url_params' => $tableUrlParams, 'db_is_system_schema' => $this->dbIsSystemSchema, 'drop_query' => $drop_query, 'drop_message' => $drop_message, 'collation' => $collationDefinition, 'formatted_size' => $formatted_size, 'unit' => $unit, 'overhead' => $overhead, 'create_time' => isset($create_time) && $create_time ? Util::localisedDate(strtotime($create_time)) : '-', 'update_time' => isset($update_time) && $update_time ? Util::localisedDate(strtotime($update_time)) : '-', 'check_time' => isset($check_time) && $check_time ? Util::localisedDate(strtotime($check_time)) : '-', 'charset' => $charset ?? '', 'is_show_stats' => $this->isShowStats, 'ignored' => $ignored, 'do' => $do, 'approx_rows' => $approx_rows, 'show_superscript' => $show_superscript, 'already_favorite' => $this->checkFavoriteTable($current_table['TABLE_NAME']), 'num_favorite_tables' => $GLOBALS['cfg']['NumFavoriteTables'], 'properties_num_columns' => $GLOBALS['cfg']['PropertiesNumColumns'], 'limit_chars' => $GLOBALS['cfg']['LimitChars'], 'show_charset' => $GLOBALS['cfg']['ShowDbStructureCharset'], 'show_comment' => $GLOBALS['cfg']['ShowDbStructureComment'], 'show_creation' => $GLOBALS['cfg']['ShowDbStructureCreation'], 'show_last_update' => $GLOBALS['cfg']['ShowDbStructureLastUpdate'], 'show_last_check' => $GLOBALS['cfg']['ShowDbStructureLastCheck']];
            $overall_approx_rows = $overall_approx_rows || $approx_rows;
        }
        $databaseCollation = [];
        $databaseCharset = '';
        $collation = Charsets::findCollationByName($this->dbi, $GLOBALS['cfg']['Server']['DisableIS'], $this->dbi->getDbCollation($this->db));
        if ($collation !== null) {
            $databaseCollation = ['name' => $collation->getName(), 'description' => $collation->getDescription()];
            $databaseCharset = $collation->getCharset();
        }
        return $html . $this->template->render('database/structure/table_header', ['db' => $this->db, 'db_is_system_schema' => $this->dbIsSystemSchema, 'replication' => $replicaInfo['status'], 'properties_num_columns' => $GLOBALS['cfg']['PropertiesNumColumns'], 'is_show_stats' => $this->isShowStats, 'show_charset' => $GLOBALS['cfg']['ShowDbStructureCharset'], 'show_comment' => $GLOBALS['cfg']['ShowDbStructureComment'], 'show_creation' => $GLOBALS['cfg']['ShowDbStructureCreation'], 'show_last_update' => $GLOBALS['cfg']['ShowDbStructureLastUpdate'], 'show_last_check' => $GLOBALS['cfg']['ShowDbStructureLastCheck'], 'num_favorite_tables' => $GLOBALS['cfg']['NumFavoriteTables'], 'structure_table_rows' => $structure_table_rows, 'body_for_table_summary' => ['num_tables' => $this->numTables, 'server_slave_status' => $replicaInfo['status'], 'db_is_system_schema' => $this->dbIsSystemSchema, 'sum_entries' => $sum_entries, 'database_collation' => $databaseCollation, 'is_show_stats' => $this->isShowStats, 'database_charset' => $databaseCharset, 'sum_size' => $sum_size, 'overhead_size' => $overhead_size, 'create_time_all' => $create_time_all ? Util::localisedDate(strtotime($create_time_all)) : '-', 'update_time_all' => $update_time_all ? Util::localisedDate(strtotime($update_time_all)) : '-', 'check_time_all' => $check_time_all ? Util::localisedDate(strtotime($check_time_all)) : '-', 'approx_rows' => $overall_approx_rows, 'num_favorite_tables' => $GLOBALS['cfg']['NumFavoriteTables'], 'db' => $GLOBALS['db'], 'properties_num_columns' => $GLOBALS['cfg']['PropertiesNumColumns'], 'dbi' => $this->dbi, 'show_charset' => $GLOBALS['cfg']['ShowDbStructureCharset'], 'show_comment' => $GLOBALS['cfg']['ShowDbStructureComment'], 'show_creation' => $GLOBALS['cfg']['ShowDbStructureCreation'], 'show_last_update' => $GLOBALS['cfg']['ShowDbStructureLastUpdate'], 'show_last_check' => $GLOBALS['cfg']['ShowDbStructureLastCheck']], 'check_all_tables' => ['theme_image_path' => $PMA_Theme->getImgPath(), 'text_dir' => $GLOBALS['text_dir'], 'overhead_check' => $overhead_check, 'db_is_system_schema' => $this->dbIsSystemSchema, 'hidden_fields' => $hidden_fields, 'disable_multi_table' => $GLOBALS['cfg']['DisableMultiTableMaintenance'], 'central_columns_work' => $GLOBALS['cfgRelation']['centralcolumnswork'] ?? null]]);
    }
    /**
     * Returns the tracking icon if the table is tracked
     *
     * @param string $table table name
     *
     * @return string HTML for tracking icon
     */
    protected function getTrackingIcon(string $table) : string
    {
        $tracking_icon = '';
        if (Tracker::isActive()) {
            $is_tracked = Tracker::isTracked($this->db, $table);
            if ($is_tracked || Tracker::getVersion($this->db, $table) > 0) {
                $tracking_icon = $this->template->render('database/structure/tracking_icon', ['db' => $this->db, 'table' => $table, 'is_tracked' => $is_tracked]);
            }
        }
        return $tracking_icon;
    }
    /**
     * Returns whether the row count is approximated
     *
     * @param array $current_table array containing details about the table
     * @param bool  $table_is_view whether the table is a view
     *
     * @return array
     */
    protected function isRowCountApproximated(array $current_table, bool $table_is_view) : array
    {
        $approx_rows = false;
        $show_superscript = '';
        // there is a null value in the ENGINE
        // - when the table needs to be repaired, or
        // - when it's a view
        //  so ensure that we'll display "in use" below for a table
        //  that needs to be repaired
        if (isset($current_table['TABLE_ROWS']) && ($current_table['ENGINE'] != null || $table_is_view)) {
            // InnoDB/TokuDB table: we did not get an accurate row count
            $approx_rows = !$table_is_view && in_array($current_table['ENGINE'], ['InnoDB', 'TokuDB']) && !$current_table['COUNTED'];
            if ($table_is_view && $current_table['TABLE_ROWS'] >= $GLOBALS['cfg']['MaxExactCountViews']) {
                $approx_rows = true;
                $show_superscript = Generator::showHint(Sanitize::sanitizeMessage(sprintf(__('This view has at least this number of ' . 'rows. Please refer to %sdocumentation%s.'), '[doc@cfg_MaxExactCountViews]', '[/doc]')));
            }
        }
        return [$approx_rows, $show_superscript];
    }
    /**
     * Returns the replication status of the table.
     *
     * @param array  $replicaInfo
     * @param string $table       table name
     *
     * @return array
     */
    protected function getReplicationStatus($replicaInfo, string $table) : array
    {
        $do = $ignored = false;
        if ($replicaInfo['status']) {
            $nbServSlaveDoDb = count($replicaInfo['Do_DB']);
            $nbServSlaveIgnoreDb = count($replicaInfo['Ignore_DB']);
            $searchDoDBInTruename = array_search($table, $replicaInfo['Do_DB']);
            $searchDoDBInDB = array_search($this->db, $replicaInfo['Do_DB']);
            $do = is_string($searchDoDBInTruename) && strlen($searchDoDBInTruename) > 0 || is_string($searchDoDBInDB) && strlen($searchDoDBInDB) > 0 || $nbServSlaveDoDb == 0 && $nbServSlaveIgnoreDb == 0 || $this->hasTable($replicaInfo['Wild_Do_Table'], $table);
            $searchDb = array_search($this->db, $replicaInfo['Ignore_DB']);
            $searchTable = array_search($table, $replicaInfo['Ignore_Table']);
            $ignored = is_string($searchTable) && strlen($searchTable) > 0 || is_string($searchDb) && strlen($searchDb) > 0 || $this->hasTable($replicaInfo['Wild_Ignore_Table'], $table);
        }
        return [$do, $ignored];
    }
    /**
     * Synchronize favorite tables
     *
     * @param RecentFavoriteTable $favoriteInstance Instance of this class
     * @param string              $user             The user hash
     * @param array               $favoriteTables   Existing favorites
     *
     * @return array
     */
    protected function synchronizeFavoriteTables(RecentFavoriteTable $favoriteInstance, string $user, array $favoriteTables) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("synchronizeFavoriteTables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 462")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called synchronizeFavoriteTables:462@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    /**
     * Function to check if a table is already in favorite list.
     *
     * @param string $currentTable current table
     */
    protected function checkFavoriteTable(string $currentTable) : bool
    {
        // ensure $_SESSION['tmpval']['favoriteTables'] is initialized
        RecentFavoriteTable::getInstance('favorite');
        $favoriteTables = $_SESSION['tmpval']['favoriteTables'][$GLOBALS['server']] ?? [];
        foreach ($favoriteTables as $value) {
            if ($value['db'] == $this->db && $value['table'] == $currentTable) {
                return true;
            }
        }
        return false;
    }
    /**
     * Find table with truename
     *
     * @param array  $db       DB to look into
     * @param string $truename Table name
     *
     * @return bool
     */
    protected function hasTable(array $db, $truename)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hasTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 502")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hasTable:502@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    /**
     * Get the value set for ENGINE table,
     *
     * @internal param bool $table_is_view whether table is view or not
     *
     * @param array $current_table current table
     * @param int   $sum_size      total table size
     * @param int   $overhead_size overhead size
     *
     * @return array
     */
    protected function getStuffForEngineTypeTable(array $current_table, $sum_size, $overhead_size)
    {
        $formatted_size = '-';
        $unit = '';
        $formatted_overhead = '';
        $overhead_unit = '';
        $table_is_view = false;
        switch ($current_table['ENGINE']) {
            // MyISAM, ISAM or Heap table: Row count, data size and index size
            // are accurate; data size is accurate for ARCHIVE
            case 'MyISAM':
            case 'ISAM':
            case 'HEAP':
            case 'MEMORY':
            case 'ARCHIVE':
            case 'Aria':
            case 'Maria':
                [$current_table, $formatted_size, $unit, $formatted_overhead, $overhead_unit, $overhead_size, $sum_size] = $this->getValuesForAriaTable($current_table, $sum_size, $overhead_size, $formatted_size, $unit, $formatted_overhead, $overhead_unit);
                break;
            case 'InnoDB':
            case 'PBMS':
            case 'TokuDB':
                // InnoDB table: Row count is not accurate but data and index sizes are.
                // PBMS table in Drizzle: TABLE_ROWS is taken from table cache,
                // so it may be unavailable
                [$current_table, $formatted_size, $unit, $sum_size] = $this->getValuesForInnodbTable($current_table, $sum_size);
                break;
            // Mysql 5.0.x (and lower) uses MRG_MyISAM
            // and MySQL 5.1.x (and higher) uses MRG_MYISAM
            // Both are aliases for MERGE
            case 'MRG_MyISAM':
            case 'MRG_MYISAM':
            case 'MERGE':
            case 'BerkeleyDB':
                // Merge or BerkleyDB table: Only row count is accurate.
                if ($this->isShowStats) {
                    $formatted_size = ' - ';
                    $unit = '';
                }
                break;
            // for a view, the ENGINE is sometimes reported as null,
            // or on some servers it's reported as "SYSTEM VIEW"
            case null:
            case 'SYSTEM VIEW':
                // possibly a view, do nothing
                break;
            default:
                // Unknown table type.
                if ($this->isShowStats) {
                    $formatted_size = __('unknown');
                    $unit = '';
                }
        }
        if ($current_table['TABLE_TYPE'] === 'VIEW' || $current_table['TABLE_TYPE'] === 'SYSTEM VIEW') {
            // countRecords() takes care of $cfg['MaxExactCountViews']
            $current_table['TABLE_ROWS'] = $this->dbi->getTable($this->db, $current_table['TABLE_NAME'])->countRecords(true);
            $table_is_view = true;
        }
        return [$current_table, $formatted_size, $unit, $formatted_overhead, $overhead_unit, $overhead_size, $table_is_view, $sum_size];
    }
    /**
     * Get values for ARIA/MARIA tables
     *
     * @param array  $current_table      current table
     * @param int    $sum_size           sum size
     * @param int    $overhead_size      overhead size
     * @param int    $formatted_size     formatted size
     * @param string $unit               unit
     * @param int    $formatted_overhead overhead formatted
     * @param string $overhead_unit      overhead unit
     *
     * @return array
     */
    protected function getValuesForAriaTable(array $current_table, $sum_size, $overhead_size, $formatted_size, $unit, $formatted_overhead, $overhead_unit)
    {
        if ($this->dbIsSystemSchema) {
            $current_table['Rows'] = $this->dbi->getTable($this->db, $current_table['Name'])->countRecords();
        }
        if ($this->isShowStats) {
            /** @var int $tblsize */
            $tblsize = $current_table['Data_length'] + $current_table['Index_length'];
            $sum_size += $tblsize;
            [$formatted_size, $unit] = Util::formatByteDown($tblsize, 3, $tblsize > 0 ? 1 : 0);
            if (isset($current_table['Data_free']) && $current_table['Data_free'] > 0) {
                [$formatted_overhead, $overhead_unit] = Util::formatByteDown($current_table['Data_free'], 3, $current_table['Data_free'] > 0 ? 1 : 0);
                $overhead_size += $current_table['Data_free'];
            }
        }
        return [$current_table, $formatted_size, $unit, $formatted_overhead, $overhead_unit, $overhead_size, $sum_size];
    }
    /**
     * Get values for InnoDB table
     *
     * @param array $current_table current table
     * @param int   $sum_size      sum size
     *
     * @return array
     */
    protected function getValuesForInnodbTable(array $current_table, $sum_size)
    {
        $formatted_size = $unit = '';
        if (in_array($current_table['ENGINE'], ['InnoDB', 'TokuDB']) && $current_table['TABLE_ROWS'] < $GLOBALS['cfg']['MaxExactCount'] || !isset($current_table['TABLE_ROWS'])) {
            $current_table['COUNTED'] = true;
            $current_table['TABLE_ROWS'] = $this->dbi->getTable($this->db, $current_table['TABLE_NAME'])->countRecords(true);
        } else {
            $current_table['COUNTED'] = false;
        }
        if ($this->isShowStats) {
            /** @var int $tblsize */
            $tblsize = $current_table['Data_length'] + $current_table['Index_length'];
            $sum_size += $tblsize;
            [$formatted_size, $unit] = Util::formatByteDown($tblsize, 3, $tblsize > 0 ? 1 : 0);
        }
        return [$current_table, $formatted_size, $unit, $sum_size];
    }
    public function showCreate() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("showCreate") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 637")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called showCreate:637@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    /**
     * @param string[] $selected Selected tables.
     *
     * @return array<string, array<int, array<string, string>>>
     */
    private function getShowCreateTables(array $selected) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getShowCreateTables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 654")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getShowCreateTables:654@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function copyForm() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("copyForm") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 663")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called copyForm:663@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function centralColumnsAdd() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("centralColumnsAdd") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 686")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called centralColumnsAdd:686@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function centralColumnsMakeConsistent() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("centralColumnsMakeConsistent") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 701")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called centralColumnsMakeConsistent:701@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function centralColumnsRemove() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("centralColumnsRemove") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 716")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called centralColumnsRemove:716@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function addPrefix() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addPrefix") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 731")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addPrefix:731@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function changePrefixForm() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("changePrefixForm") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 747")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called changePrefixForm:747@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function dropForm() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dropForm") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 768")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dropForm:768@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function emptyForm() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("emptyForm") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 803")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called emptyForm:803@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function dropTable() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dropTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 821")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dropTable:821@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function emptyTable() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("emptyTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 884")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called emptyTable:884@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function addPrefixTable() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addPrefixTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 920")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addPrefixTable:920@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function replacePrefix() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("replacePrefix") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 939")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called replacePrefix:939@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
    public function copyTableWithPrefix() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("copyTableWithPrefix") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php at line 966")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called copyTableWithPrefix:966@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/StructureController.php');
        die();
    }
}