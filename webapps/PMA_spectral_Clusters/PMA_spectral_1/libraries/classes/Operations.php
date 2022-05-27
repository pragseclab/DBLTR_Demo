<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Engines\Innodb;
use PhpMyAdmin\Plugins\Export\ExportSql;
use function array_merge;
use function count;
use function explode;
use function implode;
use function mb_strtolower;
use function str_replace;
use function strlen;
use function strtolower;
use function urldecode;
/**
 * Set of functions with the operations section in phpMyAdmin
 */
class Operations
{
    /** @var Relation */
    private $relation;
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param DatabaseInterface $dbi      DatabaseInterface object
     * @param Relation          $relation Relation object
     */
    public function __construct(DatabaseInterface $dbi, Relation $relation)
    {
        $this->dbi = $dbi;
        $this->relation = $relation;
    }
    /**
     * Run the Procedure definitions and function definitions
     *
     * to avoid selecting alternatively the current and new db
     * we would need to modify the CREATE definitions to qualify
     * the db name
     *
     * @param string $db database name
     *
     * @return void
     */
    public function runProcedureAndFunctionDefinitions($db)
    {
        $procedure_names = $this->dbi->getProceduresOrFunctions($db, 'PROCEDURE');
        if ($procedure_names) {
            foreach ($procedure_names as $procedure_name) {
                $this->dbi->selectDb($db);
                $tmp_query = $this->dbi->getDefinition($db, 'PROCEDURE', $procedure_name);
                if ($tmp_query === null) {
                    continue;
                }
                // collect for later display
                $GLOBALS['sql_query'] .= "\n" . $tmp_query;
                $this->dbi->selectDb($_POST['newname']);
                $this->dbi->query($tmp_query);
            }
        }
        $function_names = $this->dbi->getProceduresOrFunctions($db, 'FUNCTION');
        if (!$function_names) {
            return;
        }
        foreach ($function_names as $function_name) {
            $this->dbi->selectDb($db);
            $tmp_query = $this->dbi->getDefinition($db, 'FUNCTION', $function_name);
            if ($tmp_query === null) {
                continue;
            }
            // collect for later display
            $GLOBALS['sql_query'] .= "\n" . $tmp_query;
            $this->dbi->selectDb($_POST['newname']);
            $this->dbi->query($tmp_query);
        }
    }
    /**
     * Create database before copy
     *
     * @return void
     */
    public function createDbBeforeCopy()
    {
        $local_query = 'CREATE DATABASE IF NOT EXISTS ' . Util::backquote($_POST['newname']);
        if (isset($_POST['db_collation'])) {
            $local_query .= ' DEFAULT' . Util::getCharsetQueryPart($_POST['db_collation'] ?? '');
        }
        $local_query .= ';';
        $GLOBALS['sql_query'] .= $local_query;
        // save the original db name because Tracker.php which
        // may be called under $this->dbi->query() changes $GLOBALS['db']
        // for some statements, one of which being CREATE DATABASE
        $original_db = $GLOBALS['db'];
        $this->dbi->query($local_query);
        $GLOBALS['db'] = $original_db;
        // Set the SQL mode to NO_AUTO_VALUE_ON_ZERO to prevent MySQL from creating
        // export statements it cannot import
        $sql_set_mode = "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO'";
        $this->dbi->query($sql_set_mode);
        // rebuild the database list because Table::moveCopy
        // checks in this list if the target db exists
        $GLOBALS['dblist']->databases->build();
    }
    /**
     * Get views as an array and create SQL view stand-in
     *
     * @param array     $tables_full       array of all tables in given db or dbs
     * @param ExportSql $export_sql_plugin export plugin instance
     * @param string    $db                database name
     *
     * @return array
     */
    public function getViewsAndCreateSqlViewStandIn(array $tables_full, $export_sql_plugin, $db)
    {
        $views = [];
        foreach ($tables_full as $each_table => $tmp) {
            // to be able to rename a db containing views,
            // first all the views are collected and a stand-in is created
            // the real views are created after the tables
            if (!$this->dbi->getTable($db, (string) $each_table)->isView()) {
                continue;
            }
            // If view exists, and 'add drop view' is selected: Drop it!
            if ($_POST['what'] !== 'nocopy' && isset($_POST['drop_if_exists']) && $_POST['drop_if_exists'] === 'true') {
                $drop_query = 'DROP VIEW IF EXISTS ' . Util::backquote($_POST['newname']) . '.' . Util::backquote($each_table);
                $this->dbi->query($drop_query);
                $GLOBALS['sql_query'] .= "\n" . $drop_query . ';';
            }
            $views[] = $each_table;
            // Create stand-in definition to resolve view dependencies
            $sql_view_standin = $export_sql_plugin->getTableDefStandIn($db, $each_table, "\n");
            $this->dbi->selectDb($_POST['newname']);
            $this->dbi->query($sql_view_standin);
            $GLOBALS['sql_query'] .= "\n" . $sql_view_standin;
        }
        return $views;
    }
    /**
     * Get sql query for copy/rename table and boolean for whether copy/rename or not
     *
     * @param array  $tables_full array of all tables in given db or dbs
     * @param bool   $move        whether database name is empty or not
     * @param string $db          database name
     *
     * @return array SQL queries for the constraints
     */
    public function copyTables(array $tables_full, $move, $db)
    {
        $sqlContraints = [];
        foreach ($tables_full as $each_table => $tmp) {
            // skip the views; we have created stand-in definitions
            if ($this->dbi->getTable($db, (string) $each_table)->isView()) {
                continue;
            }
            // value of $what for this table only
            $this_what = $_POST['what'];
            // do not copy the data from a Merge table
            // note: on the calling FORM, 'data' means 'structure and data'
            if ($this->dbi->getTable($db, (string) $each_table)->isMerge()) {
                if ($this_what === 'data') {
                    $this_what = 'structure';
                }
                if ($this_what === 'dataonly') {
                    $this_what = 'nocopy';
                }
            }
            if ($this_what === 'nocopy') {
                continue;
            }
            // keep the triggers from the original db+table
            // (third param is empty because delimiters are only intended
            //  for importing via the mysql client or our Import feature)
            $triggers = $this->dbi->getTriggers($db, (string) $each_table, '');
            if (!Table::moveCopy($db, $each_table, $_POST['newname'], $each_table, $this_what ?? 'data', $move, 'db_copy')) {
                $GLOBALS['_error'] = true;
                break;
            }
            // apply the triggers to the destination db+table
            if ($triggers) {
                $this->dbi->selectDb($_POST['newname']);
                foreach ($triggers as $trigger) {
                    $this->dbi->query($trigger['create']);
                    $GLOBALS['sql_query'] .= "\n" . $trigger['create'] . ';';
                }
            }
            // this does not apply to a rename operation
            if (!isset($_POST['add_constraints']) || empty($GLOBALS['sql_constraints_query'])) {
                continue;
            }
            $sqlContraints[] = $GLOBALS['sql_constraints_query'];
            unset($GLOBALS['sql_constraints_query']);
        }
        return $sqlContraints;
    }
    /**
     * Run the EVENT definition for selected database
     *
     * to avoid selecting alternatively the current and new db
     * we would need to modify the CREATE definitions to qualify
     * the db name
     *
     * @param string $db database name
     *
     * @return void
     */
    public function runEventDefinitionsForDb($db)
    {
        $event_names = $this->dbi->fetchResult('SELECT EVENT_NAME FROM information_schema.EVENTS WHERE EVENT_SCHEMA= \'' . $this->dbi->escapeString($db) . '\';');
        if (!$event_names) {
            return;
        }
        foreach ($event_names as $event_name) {
            $this->dbi->selectDb($db);
            $tmp_query = $this->dbi->getDefinition($db, 'EVENT', $event_name);
            // collect for later display
            $GLOBALS['sql_query'] .= "\n" . $tmp_query;
            $this->dbi->selectDb($_POST['newname']);
            $this->dbi->query($tmp_query);
        }
    }
    /**
     * Handle the views, return the boolean value whether table rename/copy or not
     *
     * @param array  $views views as an array
     * @param bool   $move  whether database name is empty or not
     * @param string $db    database name
     *
     * @return void
     */
    public function handleTheViews(array $views, $move, $db)
    {
        // temporarily force to add DROP IF EXIST to CREATE VIEW query,
        // to remove stand-in VIEW that was created earlier
        // ( $_POST['drop_if_exists'] is used in moveCopy() )
        if (isset($_POST['drop_if_exists'])) {
            $temp_drop_if_exists = $_POST['drop_if_exists'];
        }
        $_POST['drop_if_exists'] = 'true';
        foreach ($views as $view) {
            $copying_succeeded = Table::moveCopy($db, $view, $_POST['newname'], $view, 'structure', $move, 'db_copy');
            if (!$copying_succeeded) {
                $GLOBALS['_error'] = true;
                break;
            }
        }
        unset($_POST['drop_if_exists']);
        if (!isset($temp_drop_if_exists)) {
            return;
        }
        // restore previous value
        $_POST['drop_if_exists'] = $temp_drop_if_exists;
    }
    /**
     * Adjust the privileges after Renaming the db
     *
     * @param string $oldDb   Database name before renaming
     * @param string $newname New Database name requested
     *
     * @return void
     */
    public function adjustPrivilegesMoveDb($oldDb, $newname)
    {
        if (!$GLOBALS['db_priv'] || !$GLOBALS['table_priv'] || !$GLOBALS['col_priv'] || !$GLOBALS['proc_priv'] || !$GLOBALS['is_reload_priv']) {
            return;
        }
        $this->dbi->selectDb('mysql');
        $newname = str_replace('_', '\\_', $newname);
        $oldDb = str_replace('_', '\\_', $oldDb);
        // For Db specific privileges
        $query_db_specific = 'UPDATE ' . Util::backquote('db') . 'SET Db = \'' . $this->dbi->escapeString($newname) . '\' where Db = \'' . $this->dbi->escapeString($oldDb) . '\';';
        $this->dbi->query($query_db_specific);
        // For table specific privileges
        $query_table_specific = 'UPDATE ' . Util::backquote('tables_priv') . 'SET Db = \'' . $this->dbi->escapeString($newname) . '\' where Db = \'' . $this->dbi->escapeString($oldDb) . '\';';
        $this->dbi->query($query_table_specific);
        // For column specific privileges
        $query_col_specific = 'UPDATE ' . Util::backquote('columns_priv') . 'SET Db = \'' . $this->dbi->escapeString($newname) . '\' where Db = \'' . $this->dbi->escapeString($oldDb) . '\';';
        $this->dbi->query($query_col_specific);
        // For procedures specific privileges
        $query_proc_specific = 'UPDATE ' . Util::backquote('procs_priv') . 'SET Db = \'' . $this->dbi->escapeString($newname) . '\' where Db = \'' . $this->dbi->escapeString($oldDb) . '\';';
        $this->dbi->query($query_proc_specific);
        // Finally FLUSH the new privileges
        $flush_query = 'FLUSH PRIVILEGES;';
        $this->dbi->query($flush_query);
    }
    /**
     * Adjust the privileges after Copying the db
     *
     * @param string $oldDb   Database name before copying
     * @param string $newname New Database name requested
     *
     * @return void
     */
    public function adjustPrivilegesCopyDb($oldDb, $newname)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("adjustPrivilegesCopyDb") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php at line 296")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called adjustPrivilegesCopyDb:296@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php');
        die();
    }
    /**
     * Create all accumulated constraints
     *
     * @param array $sqlConstratints array of sql constraints for the database
     *
     * @return void
     */
    public function createAllAccumulatedConstraints(array $sqlConstratints)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("createAllAccumulatedConstraints") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php at line 347")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called createAllAccumulatedConstraints:347@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php');
        die();
    }
    /**
     * Duplicate the bookmarks for the db (done once for each db)
     *
     * @param bool   $_error whether table rename/copy or not
     * @param string $db     database name
     *
     * @return void
     */
    public function duplicateBookmarks($_error, $db)
    {
        if ($_error || $db == $_POST['newname']) {
            return;
        }
        $get_fields = ['user', 'label', 'query'];
        $where_fields = ['dbase' => $db];
        $new_fields = ['dbase' => $_POST['newname']];
        Table::duplicateInfo('bookmarkwork', 'bookmark', $get_fields, $where_fields, $new_fields);
    }
    /**
     * Get array of possible row formats
     *
     * @return array
     */
    public function getPossibleRowFormat()
    {
        // the outer array is for engines, the inner array contains the dropdown
        // option values as keys then the dropdown option labels
        $possible_row_formats = ['ARCHIVE' => ['COMPRESSED' => 'COMPRESSED'], 'ARIA' => ['FIXED' => 'FIXED', 'DYNAMIC' => 'DYNAMIC', 'PAGE' => 'PAGE'], 'MARIA' => ['FIXED' => 'FIXED', 'DYNAMIC' => 'DYNAMIC', 'PAGE' => 'PAGE'], 'MYISAM' => ['FIXED' => 'FIXED', 'DYNAMIC' => 'DYNAMIC'], 'PBXT' => ['FIXED' => 'FIXED', 'DYNAMIC' => 'DYNAMIC'], 'INNODB' => ['COMPACT' => 'COMPACT', 'REDUNDANT' => 'REDUNDANT']];
        /** @var Innodb $innodbEnginePlugin */
        $innodbEnginePlugin = StorageEngine::getEngine('Innodb');
        $innodbPluginVersion = $innodbEnginePlugin->getInnodbPluginVersion();
        if (!empty($innodbPluginVersion)) {
            $innodb_file_format = $innodbEnginePlugin->getInnodbFileFormat();
        } else {
            $innodb_file_format = '';
        }
        /**
         * Newer MySQL/MariaDB always return empty a.k.a '' on $innodb_file_format otherwise
         * old versions of MySQL/MariaDB must be returning something or not empty.
         * This patch is to support newer MySQL/MariaDB while also for backward compatibilities.
         */
        if ($innodb_file_format === 'Barracuda' || $innodb_file_format == '' && $innodbEnginePlugin->supportsFilePerTable()) {
            $possible_row_formats['INNODB']['DYNAMIC'] = 'DYNAMIC';
            $possible_row_formats['INNODB']['COMPRESSED'] = 'COMPRESSED';
        }
        return $possible_row_formats;
    }
    /**
     * @return array<string, string>
     */
    public function getPartitionMaintenanceChoices() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPartitionMaintenanceChoices") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php at line 406")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPartitionMaintenanceChoices:406@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php');
        die();
    }
    /**
     * @param array $urlParams          Array of url parameters.
     * @param bool  $hasRelationFeature If relation feature is enabled.
     *
     * @return array
     */
    public function getForeignersForReferentialIntegrityCheck(array $urlParams, $hasRelationFeature) : array
    {
        global $db, $table;
        if (!$hasRelationFeature) {
            return [];
        }
        $foreigners = [];
        $this->dbi->selectDb($db);
        $foreign = $this->relation->getForeigners($db, $table, '', 'internal');
        foreach ($foreign as $master => $arr) {
            $joinQuery = 'SELECT ' . Util::backquote($table) . '.*' . ' FROM ' . Util::backquote($table) . ' LEFT JOIN ' . Util::backquote($arr['foreign_db']) . '.' . Util::backquote($arr['foreign_table']);
            if ($arr['foreign_table'] == $table) {
                $foreignTable = $table . '1';
                $joinQuery .= ' AS ' . Util::backquote($foreignTable);
            } else {
                $foreignTable = $arr['foreign_table'];
            }
            $joinQuery .= ' ON ' . Util::backquote($table) . '.' . Util::backquote($master) . ' = ' . Util::backquote($arr['foreign_db']) . '.' . Util::backquote($foreignTable) . '.' . Util::backquote($arr['foreign_field']) . ' WHERE ' . Util::backquote($arr['foreign_db']) . '.' . Util::backquote($foreignTable) . '.' . Util::backquote($arr['foreign_field']) . ' IS NULL AND ' . Util::backquote($table) . '.' . Util::backquote($master) . ' IS NOT NULL';
            $thisUrlParams = array_merge($urlParams, ['sql_query' => $joinQuery, 'sql_signature' => Core::signSqlQuery($joinQuery)]);
            $foreigners[] = ['params' => $thisUrlParams, 'master' => $master, 'db' => $arr['foreign_db'], 'table' => $arr['foreign_table'], 'field' => $arr['foreign_field']];
        }
        return $foreigners;
    }
    /**
     * Reorder table based on request params
     *
     * @return array SQL query and result
     */
    public function getQueryAndResultForReorderingTable()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getQueryAndResultForReorderingTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php at line 453")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getQueryAndResultForReorderingTable:453@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php');
        die();
    }
    /**
     * Get table alters array
     *
     * @param Table  $pma_table           The Table object
     * @param string $pack_keys           pack keys
     * @param string $checksum            value of checksum
     * @param string $page_checksum       value of page checksum
     * @param string $delay_key_write     delay key write
     * @param string $row_format          row format
     * @param string $newTblStorageEngine table storage engine
     * @param string $transactional       value of transactional
     * @param string $tbl_collation       collation of the table
     *
     * @return array
     */
    public function getTableAltersArray($pma_table, $pack_keys, $checksum, $page_checksum, $delay_key_write, $row_format, $newTblStorageEngine, $transactional, $tbl_collation)
    {
        global $auto_increment;
        $table_alters = [];
        if (isset($_POST['comment']) && urldecode($_POST['prev_comment']) !== $_POST['comment']) {
            $table_alters[] = 'COMMENT = \'' . $this->dbi->escapeString($_POST['comment']) . '\'';
        }
        if (!empty($newTblStorageEngine) && mb_strtolower($newTblStorageEngine) !== mb_strtolower($GLOBALS['tbl_storage_engine'])) {
            $table_alters[] = 'ENGINE = ' . $newTblStorageEngine;
        }
        if (!empty($_POST['tbl_collation']) && $_POST['tbl_collation'] !== $tbl_collation) {
            $table_alters[] = 'DEFAULT ' . Util::getCharsetQueryPart($_POST['tbl_collation'] ?? '');
        }
        if ($pma_table->isEngine(['MYISAM', 'ARIA', 'ISAM']) && isset($_POST['new_pack_keys']) && $_POST['new_pack_keys'] != (string) $pack_keys) {
            $table_alters[] = 'pack_keys = ' . $_POST['new_pack_keys'];
        }
        $_POST['new_checksum'] = empty($_POST['new_checksum']) ? '0' : '1';
        if ($pma_table->isEngine(['MYISAM', 'ARIA']) && $_POST['new_checksum'] !== $checksum) {
            $table_alters[] = 'checksum = ' . $_POST['new_checksum'];
        }
        $_POST['new_transactional'] = empty($_POST['new_transactional']) ? '0' : '1';
        if ($pma_table->isEngine('ARIA') && $_POST['new_transactional'] !== $transactional) {
            $table_alters[] = 'TRANSACTIONAL = ' . $_POST['new_transactional'];
        }
        $_POST['new_page_checksum'] = empty($_POST['new_page_checksum']) ? '0' : '1';
        if ($pma_table->isEngine('ARIA') && $_POST['new_page_checksum'] !== $page_checksum) {
            $table_alters[] = 'PAGE_CHECKSUM = ' . $_POST['new_page_checksum'];
        }
        $_POST['new_delay_key_write'] = empty($_POST['new_delay_key_write']) ? '0' : '1';
        if ($pma_table->isEngine(['MYISAM', 'ARIA']) && $_POST['new_delay_key_write'] !== $delay_key_write) {
            $table_alters[] = 'delay_key_write = ' . $_POST['new_delay_key_write'];
        }
        if ($pma_table->isEngine(['MYISAM', 'ARIA', 'INNODB', 'PBXT', 'ROCKSDB']) && !empty($_POST['new_auto_increment']) && (!isset($auto_increment) || $_POST['new_auto_increment'] !== $auto_increment) && $_POST['new_auto_increment'] !== $_POST['hidden_auto_increment']) {
            $table_alters[] = 'auto_increment = ' . $this->dbi->escapeString($_POST['new_auto_increment']);
        }
        if (!empty($_POST['new_row_format'])) {
            $newRowFormat = $_POST['new_row_format'];
            $newRowFormatLower = mb_strtolower($newRowFormat);
            if ($pma_table->isEngine(['MYISAM', 'ARIA', 'INNODB', 'PBXT']) && (strlen($row_format) === 0 || $newRowFormatLower !== mb_strtolower($row_format))) {
                $table_alters[] = 'ROW_FORMAT = ' . $this->dbi->escapeString($newRowFormat);
            }
        }
        return $table_alters;
    }
    /**
     * Get warning messages array
     *
     * @return array
     */
    public function getWarningMessagesArray()
    {
        $warning_messages = [];
        foreach ($this->dbi->getWarnings() as $warning) {
            // In MariaDB 5.1.44, when altering a table from Maria to MyISAM
            // and if TRANSACTIONAL was set, the system reports an error;
            // I discussed with a Maria developer and he agrees that this
            // should not be reported with a Level of Error, so here
            // I just ignore it. But there are other 1478 messages
            // that it's better to show.
            if (isset($_POST['new_tbl_storage_engine']) && $_POST['new_tbl_storage_engine'] === 'MyISAM' && $warning['Code'] == '1478' && $warning['Level'] === 'Error') {
                continue;
            }
            $warning_messages[] = $warning['Level'] . ': #' . $warning['Code'] . ' ' . $warning['Message'];
        }
        return $warning_messages;
    }
    /**
     * Get SQL query and result after ran this SQL query for a partition operation
     * has been requested by the user
     *
     * @return array $sql_query, $result
     */
    public function getQueryAndResultForPartition()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getQueryAndResultForPartition") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php at line 552")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getQueryAndResultForPartition:552@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php');
        die();
    }
    /**
     * Adjust the privileges after renaming/moving a table
     *
     * @param string $oldDb    Database name before table renaming/moving table
     * @param string $oldTable Table name before table renaming/moving table
     * @param string $newDb    Database name after table renaming/ moving table
     * @param string $newTable Table name after table renaming/moving table
     *
     * @return void
     */
    public function adjustPrivilegesRenameOrMoveTable($oldDb, $oldTable, $newDb, $newTable)
    {
        if (!$GLOBALS['table_priv'] || !$GLOBALS['col_priv'] || !$GLOBALS['is_reload_priv']) {
            return;
        }
        $this->dbi->selectDb('mysql');
        // For table specific privileges
        $query_table_specific = 'UPDATE ' . Util::backquote('tables_priv') . 'SET Db = \'' . $this->dbi->escapeString($newDb) . '\', Table_name = \'' . $this->dbi->escapeString($newTable) . '\' where Db = \'' . $this->dbi->escapeString($oldDb) . '\' AND Table_name = \'' . $this->dbi->escapeString($oldTable) . '\';';
        $this->dbi->query($query_table_specific);
        // For column specific privileges
        $query_col_specific = 'UPDATE ' . Util::backquote('columns_priv') . 'SET Db = \'' . $this->dbi->escapeString($newDb) . '\', Table_name = \'' . $this->dbi->escapeString($newTable) . '\' where Db = \'' . $this->dbi->escapeString($oldDb) . '\' AND Table_name = \'' . $this->dbi->escapeString($oldTable) . '\';';
        $this->dbi->query($query_col_specific);
        // Finally FLUSH the new privileges
        $flush_query = 'FLUSH PRIVILEGES;';
        $this->dbi->query($flush_query);
    }
    /**
     * Adjust the privileges after copying a table
     *
     * @param string $oldDb    Database name before table copying
     * @param string $oldTable Table name before table copying
     * @param string $newDb    Database name after table copying
     * @param string $newTable Table name after table copying
     *
     * @return void
     */
    public function adjustPrivilegesCopyTable($oldDb, $oldTable, $newDb, $newTable)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("adjustPrivilegesCopyTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php at line 599")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called adjustPrivilegesCopyTable:599@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php');
        die();
    }
    /**
     * Change all collations and character sets of all columns in table
     *
     * @param string $db            Database name
     * @param string $table         Table name
     * @param string $tbl_collation Collation Name
     *
     * @return void
     */
    public function changeAllColumnsCollation($db, $table, $tbl_collation)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("changeAllColumnsCollation") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php at line 632")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called changeAllColumnsCollation:632@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php');
        die();
    }
    /**
     * Move or copy a table
     *
     * @param string $db    current database name
     * @param string $table current table name
     */
    public function moveOrCopyTable($db, $table) : Message
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("moveOrCopyTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php at line 649")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called moveOrCopyTable:649@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Operations.php');
        die();
    }
}