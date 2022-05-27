<?php

declare (strict_types=1);
namespace PhpMyAdmin\Database\Designer;

use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Index;
use PhpMyAdmin\Query\Generator as QueryGenerator;
use PhpMyAdmin\Relation;
use PhpMyAdmin\Table;
use PhpMyAdmin\Util;
use function count;
use function explode;
use function in_array;
use function intval;
use function is_array;
use function is_string;
use function json_decode;
use function json_encode;
use function mb_strtoupper;
use function rawurlencode;
/**
 * Common functions for Designer
 */
class Common
{
    /** @var Relation */
    private $relation;
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param DatabaseInterface $dbi      DatabaseInterface object
     * @param Relation          $relation Relation instance
     */
    public function __construct(DatabaseInterface $dbi, Relation $relation)
    {
        $this->dbi = $dbi;
        $this->relation = $relation;
    }
    /**
     * Retrieves table info and returns it
     *
     * @param string $db    (optional) Filter only a DB ($table is required if you use $db)
     * @param string $table (optional) Filter only a table ($db is now required)
     *
     * @return DesignerTable[] with table info
     */
    public function getTablesInfo(?string $db = null, ?string $table = null) : array
    {
        $designerTables = [];
        $db = $db ?? $GLOBALS['db'];
        // seems to be needed later
        $this->dbi->selectDb($db);
        if ($table === null) {
            $tables = $this->dbi->getTablesFull($db);
        } else {
            $tables = $this->dbi->getTablesFull($db, $table);
        }
        foreach ($tables as $one_table) {
            $DF = $this->relation->getDisplayField($db, $one_table['TABLE_NAME']);
            $DF = is_string($DF) ? $DF : '';
            $DF = $DF !== '' ? $DF : null;
            $designerTables[] = new DesignerTable($db, $one_table['TABLE_NAME'], is_string($one_table['ENGINE']) ? $one_table['ENGINE'] : '', $DF);
        }
        return $designerTables;
    }
    /**
     * Retrieves table column info
     *
     * @param DesignerTable[] $designerTables The designer tables
     *
     * @return array table column nfo
     */
    public function getColumnsInfo(array $designerTables) : array
    {
        //$this->dbi->selectDb($GLOBALS['db']);
        $tabColumn = [];
        foreach ($designerTables as $designerTable) {
            $fieldsRs = $this->dbi->query(QueryGenerator::getColumnsSql($designerTable->getDatabaseName(), $designerTable->getTableName()), DatabaseInterface::CONNECT_USER, DatabaseInterface::QUERY_STORE);
            $j = 0;
            while ($row = $this->dbi->fetchAssoc($fieldsRs)) {
                if (!isset($tabColumn[$designerTable->getDbTableString()])) {
                    $tabColumn[$designerTable->getDbTableString()] = [];
                }
                $tabColumn[$designerTable->getDbTableString()]['COLUMN_ID'][$j] = $j;
                $tabColumn[$designerTable->getDbTableString()]['COLUMN_NAME'][$j] = $row['Field'];
                $tabColumn[$designerTable->getDbTableString()]['TYPE'][$j] = $row['Type'];
                $tabColumn[$designerTable->getDbTableString()]['NULLABLE'][$j] = $row['Null'];
                $j++;
            }
        }
        return $tabColumn;
    }
    /**
     * Returns JavaScript code for initializing vars
     *
     * @param DesignerTable[] $designerTables The designer tables
     *
     * @return array JavaScript code
     */
    public function getScriptContr(array $designerTables) : array
    {
        $this->dbi->selectDb($GLOBALS['db']);
        $con = [];
        $con['C_NAME'] = [];
        $i = 0;
        $alltab_rs = $this->dbi->query('SHOW TABLES FROM ' . Util::backquote($GLOBALS['db']), DatabaseInterface::CONNECT_USER, DatabaseInterface::QUERY_STORE);
        while ($val = @$this->dbi->fetchRow($alltab_rs)) {
            $row = $this->relation->getForeigners($GLOBALS['db'], $val[0], '', 'internal');
            foreach ($row as $field => $value) {
                $con['C_NAME'][$i] = '';
                $con['DTN'][$i] = rawurlencode($GLOBALS['db'] . '.' . $val[0]);
                $con['DCN'][$i] = rawurlencode((string) $field);
                $con['STN'][$i] = rawurlencode($value['foreign_db'] . '.' . $value['foreign_table']);
                $con['SCN'][$i] = rawurlencode($value['foreign_field']);
                $i++;
            }
            $row = $this->relation->getForeigners($GLOBALS['db'], $val[0], '', 'foreign');
            // We do not have access to the foreign keys if the user has partial access to the columns
            if (!isset($row['foreign_keys_data'])) {
                continue;
            }
            foreach ($row['foreign_keys_data'] as $one_key) {
                foreach ($one_key['index_list'] as $index => $one_field) {
                    $con['C_NAME'][$i] = rawurlencode($one_key['constraint']);
                    $con['DTN'][$i] = rawurlencode($GLOBALS['db'] . '.' . $val[0]);
                    $con['DCN'][$i] = rawurlencode($one_field);
                    $con['STN'][$i] = rawurlencode(($one_key['ref_db_name'] ?? $GLOBALS['db']) . '.' . $one_key['ref_table_name']);
                    $con['SCN'][$i] = rawurlencode($one_key['ref_index_list'][$index]);
                    $i++;
                }
            }
        }
        $tableDbNames = [];
        foreach ($designerTables as $designerTable) {
            $tableDbNames[] = rawurlencode($designerTable->getDbTableString());
        }
        $ti = 0;
        $retval = [];
        for ($i = 0, $cnt = count($con['C_NAME']); $i < $cnt; $i++) {
            $c_name_i = $con['C_NAME'][$i];
            $dtn_i = $con['DTN'][$i];
            $retval[$ti] = [];
            $retval[$ti][$c_name_i] = [];
            if (in_array($dtn_i, $tableDbNames) && in_array($con['STN'][$i], $tableDbNames)) {
                $retval[$ti][$c_name_i][$dtn_i] = [];
                $retval[$ti][$c_name_i][$dtn_i][$con['DCN'][$i]] = [0 => $con['STN'][$i], 1 => $con['SCN'][$i]];
            }
            $ti++;
        }
        return $retval;
    }
    /**
     * Returns UNIQUE and PRIMARY indices
     *
     * @param DesignerTable[] $designerTables The designer tables
     *
     * @return array unique or primary indices
     */
    public function getPkOrUniqueKeys(array $designerTables) : array
    {
        return $this->getAllKeys($designerTables, true);
    }
    /**
     * Returns all indices
     *
     * @param DesignerTable[] $designerTables The designer tables
     * @param bool            $unique_only    whether to include only unique ones
     *
     * @return array indices
     */
    public function getAllKeys(array $designerTables, bool $unique_only = false) : array
    {
        $keys = [];
        foreach ($designerTables as $designerTable) {
            $schema = $designerTable->getDatabaseName();
            // for now, take into account only the first index segment
            foreach (Index::getFromTable($designerTable->getTableName(), $schema) as $index) {
                if ($unique_only && !$index->isUnique()) {
                    continue;
                }
                $columns = $index->getColumns();
                foreach ($columns as $column_name => $dummy) {
                    $keys[$schema . '.' . $designerTable->getTableName() . '.' . $column_name] = 1;
                }
            }
        }
        return $keys;
    }
    /**
     * Return j_tab and h_tab arrays
     *
     * @param DesignerTable[] $designerTables The designer tables
     *
     * @return array
     */
    public function getScriptTabs(array $designerTables) : array
    {
        $retval = ['j_tabs' => [], 'h_tabs' => []];
        foreach ($designerTables as $designerTable) {
            $key = rawurlencode($designerTable->getDbTableString());
            $retval['j_tabs'][$key] = $designerTable->supportsForeignkeys() ? 1 : 0;
            $retval['h_tabs'][$key] = 1;
        }
        return $retval;
    }
    /**
     * Returns table positions of a given pdf page
     *
     * @param int $pg pdf page id
     *
     * @return array|null of table positions
     */
    public function getTablePositions($pg) : ?array
    {
        $cfgRelation = $this->relation->getRelationsParam();
        if (!$cfgRelation['pdfwork']) {
            return [];
        }
        $query = "\n            SELECT CONCAT_WS('.', `db_name`, `table_name`) AS `name`,\n                `db_name` as `dbName`, `table_name` as `tableName`,\n                `x` AS `X`,\n                `y` AS `Y`,\n                1 AS `V`,\n                1 AS `H`\n            FROM " . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['table_coords']) . '
            WHERE pdf_page_number = ' . intval($pg);
        return $this->dbi->fetchResult($query, 'name', null, DatabaseInterface::CONNECT_CONTROL, DatabaseInterface::QUERY_STORE);
    }
    /**
     * Returns page name of a given pdf page
     *
     * @param int $pg pdf page id
     *
     * @return string|null table name
     */
    public function getPageName($pg)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPageName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php at line 233")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPageName:233@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php');
        die();
    }
    /**
     * Deletes a given pdf page and its corresponding coordinates
     *
     * @param int $pg page id
     *
     * @return bool success/failure
     */
    public function deletePage($pg)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("deletePage") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php at line 250")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called deletePage:250@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php');
        die();
    }
    /**
     * Returns the id of the default pdf page of the database.
     * Default page is the one which has the same name as the database.
     *
     * @param string $db database
     *
     * @return int|null id of the default pdf page for the database
     */
    public function getDefaultPage($db) : ?int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDefaultPage") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php at line 272")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDefaultPage:272@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php');
        die();
    }
    /**
     * Get the status if the page already exists
     * If no such exists, returns negative index.
     *
     * @param string $pg name
     *
     * @return bool if the page already exists
     */
    public function getPageExists(string $pg) : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPageExists") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php at line 293")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPageExists:293@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php');
        die();
    }
    /**
     * Get the id of the page to load. If a default page exists it will be returned.
     * If no such exists, returns the id of the first page of the database.
     *
     * @param string $db database
     *
     * @return int id of the page to load
     */
    public function getLoadingPage($db)
    {
        $cfgRelation = $this->relation->getRelationsParam();
        if (!$cfgRelation['pdfwork']) {
            return -1;
        }
        $page_no = -1;
        $default_page_no = $this->getDefaultPage($db);
        if ($default_page_no != -1) {
            $page_no = $default_page_no;
        } else {
            $query = 'SELECT MIN(`page_nr`)' . ' FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['pdf_pages']) . " WHERE `db_name` = '" . $this->dbi->escapeString($db) . "'";
            $min_page_no = $this->dbi->fetchResult($query, null, null, DatabaseInterface::CONNECT_CONTROL, DatabaseInterface::QUERY_STORE);
            if (is_array($min_page_no) && isset($min_page_no[0])) {
                $page_no = $min_page_no[0];
            }
        }
        return intval($page_no);
    }
    /**
     * Creates a new page and returns its auto-incrementing id
     *
     * @param string $pageName name of the page
     * @param string $db       name of the database
     *
     * @return int|null
     */
    public function createNewPage($pageName, $db)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("createNewPage") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php at line 338")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called createNewPage:338@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php');
        die();
    }
    /**
     * Saves positions of table(s) of a given pdf page
     *
     * @param int $pg pdf page id
     *
     * @return bool success/failure
     */
    public function saveTablePositions($pg)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("saveTablePositions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php at line 353")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called saveTablePositions:353@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php');
        die();
    }
    /**
     * Saves the display field for a table.
     *
     * @param string $db    database name
     * @param string $table table name
     * @param string $field display field name
     *
     * @return array<int,string|bool|null>
     */
    public function saveDisplayField($db, $table, $field) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("saveDisplayField") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php at line 385")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called saveDisplayField:385@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php');
        die();
    }
    /**
     * Adds a new foreign relation
     *
     * @param string $db        database name
     * @param string $T1        foreign table
     * @param string $F1        foreign field
     * @param string $T2        master table
     * @param string $F2        master field
     * @param string $on_delete on delete action
     * @param string $on_update on update action
     * @param string $DB1       database
     * @param string $DB2       database
     *
     * @return array<int,string|bool> array of success/failure and message
     */
    public function addNewRelation($db, $T1, $F1, $T2, $F2, $on_delete, $on_update, $DB1, $DB2) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addNewRelation") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php at line 410")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addNewRelation:410@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php');
        die();
    }
    /**
     * Removes a foreign relation
     *
     * @param string $T1 foreign db.table
     * @param string $F1 foreign field
     * @param string $T2 master db.table
     * @param string $F2 master field
     *
     * @return array array of success/failure and message
     */
    public function removeRelation($T1, $F1, $T2, $F2)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("removeRelation") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php at line 481")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called removeRelation:481@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Designer/Common.php');
        die();
    }
    /**
     * Save value for a designer setting
     *
     * @param string $index setting
     * @param string $value value
     *
     * @return bool whether the operation succeeded
     */
    public function saveSetting($index, $value)
    {
        $cfgRelation = $this->relation->getRelationsParam();
        $success = true;
        if ($cfgRelation['designersettingswork']) {
            $cfgDesigner = ['user' => $GLOBALS['cfg']['Server']['user'], 'db' => $cfgRelation['db'], 'table' => $cfgRelation['designer_settings']];
            $orig_data_query = 'SELECT settings_data' . ' FROM ' . Util::backquote($cfgDesigner['db']) . '.' . Util::backquote($cfgDesigner['table']) . " WHERE username = '" . $this->dbi->escapeString($cfgDesigner['user']) . "';";
            $orig_data = $this->dbi->fetchSingleRow($orig_data_query, 'ASSOC', DatabaseInterface::CONNECT_CONTROL);
            if (!empty($orig_data)) {
                $orig_data = json_decode($orig_data['settings_data'], true);
                $orig_data[$index] = $value;
                $orig_data = json_encode($orig_data);
                $save_query = 'UPDATE ' . Util::backquote($cfgDesigner['db']) . '.' . Util::backquote($cfgDesigner['table']) . " SET settings_data = '" . $orig_data . "'" . " WHERE username = '" . $this->dbi->escapeString($cfgDesigner['user']) . "';";
                $success = $this->relation->queryAsControlUser($save_query);
            } else {
                $save_data = [$index => $value];
                $query = 'INSERT INTO ' . Util::backquote($cfgDesigner['db']) . '.' . Util::backquote($cfgDesigner['table']) . ' (username, settings_data)' . " VALUES('" . $this->dbi->escapeString($cfgDesigner['user']) . "', '" . json_encode($save_data) . "');";
                $success = $this->relation->queryAsControlUser($query);
            }
        }
        return (bool) $success;
    }
}