<?php

declare (strict_types=1);
namespace PhpMyAdmin\Query;

use PhpMyAdmin\Util;
use function count;
use function implode;
use function is_array;
use function sprintf;
/**
 * Handles generating SQL queries
 */
class Generator
{
    /**
     * returns a segment of the SQL WHERE clause regarding table name and type
     *
     * @param array|string $escapedTableOrTables table(s)
     * @param bool         $tblIsGroup           $table is a table group
     * @param string       $tableType            whether table or view
     *
     * @return string a segment of the WHERE clause
     */
    public static function getTableCondition($escapedTableOrTables, bool $tblIsGroup, ?string $tableType) : string
    {
        // get table information from information_schema
        if ($escapedTableOrTables) {
            if (is_array($escapedTableOrTables)) {
                $sqlWhereTable = 'AND t.`TABLE_NAME` ' . Util::getCollateForIS() . ' IN (\'' . implode('\', \'', $escapedTableOrTables) . '\')';
            } elseif ($tblIsGroup === true) {
                $sqlWhereTable = 'AND t.`TABLE_NAME` LIKE \'' . Util::escapeMysqlWildcards($escapedTableOrTables) . '%\'';
            } else {
                $sqlWhereTable = 'AND t.`TABLE_NAME` ' . Util::getCollateForIS() . ' = \'' . $escapedTableOrTables . '\'';
            }
        } else {
            $sqlWhereTable = '';
        }
        if ($tableType) {
            if ($tableType === 'view') {
                $sqlWhereTable .= " AND t.`TABLE_TYPE` NOT IN ('BASE TABLE', 'SYSTEM VERSIONED')";
            } elseif ($tableType === 'table') {
                $sqlWhereTable .= " AND t.`TABLE_TYPE` IN ('BASE TABLE', 'SYSTEM VERSIONED')";
            }
        }
        return $sqlWhereTable;
    }
    /**
     * returns the beginning of the SQL statement to fetch the list of tables
     *
     * @param string[] $thisDatabases databases to list
     * @param string   $sqlWhereTable additional condition
     *
     * @return string the SQL statement
     */
    public static function getSqlForTablesFull(array $thisDatabases, string $sqlWhereTable) : string
    {
        return 'SELECT *,' . ' `TABLE_SCHEMA`       AS `Db`,' . ' `TABLE_NAME`         AS `Name`,' . ' `TABLE_TYPE`         AS `TABLE_TYPE`,' . ' `ENGINE`             AS `Engine`,' . ' `ENGINE`             AS `Type`,' . ' `VERSION`            AS `Version`,' . ' `ROW_FORMAT`         AS `Row_format`,' . ' `TABLE_ROWS`         AS `Rows`,' . ' `AVG_ROW_LENGTH`     AS `Avg_row_length`,' . ' `DATA_LENGTH`        AS `Data_length`,' . ' `MAX_DATA_LENGTH`    AS `Max_data_length`,' . ' `INDEX_LENGTH`       AS `Index_length`,' . ' `DATA_FREE`          AS `Data_free`,' . ' `AUTO_INCREMENT`     AS `Auto_increment`,' . ' `CREATE_TIME`        AS `Create_time`,' . ' `UPDATE_TIME`        AS `Update_time`,' . ' `CHECK_TIME`         AS `Check_time`,' . ' `TABLE_COLLATION`    AS `Collation`,' . ' `CHECKSUM`           AS `Checksum`,' . ' `CREATE_OPTIONS`     AS `Create_options`,' . ' `TABLE_COMMENT`      AS `Comment`' . ' FROM `information_schema`.`TABLES` t' . ' WHERE `TABLE_SCHEMA` ' . Util::getCollateForIS() . ' IN (\'' . implode("', '", $thisDatabases) . '\')' . ' ' . $sqlWhereTable;
    }
    /**
     * Returns SQL for fetching information on table indexes (SHOW INDEXES)
     *
     * @param string $database name of database
     * @param string $table    name of the table whose indexes are to be retrieved
     * @param string $where    additional conditions for WHERE
     *
     * @return string SQL for getting indexes
     */
    public static function getTableIndexesSql(string $database, string $table, ?string $where = null) : string
    {
        $sql = 'SHOW INDEXES FROM ' . Util::backquote($database) . '.' . Util::backquote($table);
        if ($where) {
            $sql .= ' WHERE (' . $where . ')';
        }
        return $sql;
    }
    /**
     * Returns SQL query for fetching columns for a table
     *
     * @param string      $database      name of database
     * @param string      $table         name of table to retrieve columns from
     * @param string|null $escapedColumn name of column, null to show all columns
     * @param bool        $full          whether to return full info or only column names
     */
    public static function getColumnsSql(string $database, string $table, ?string $escapedColumn = null, bool $full = false) : string
    {
        return 'SHOW ' . ($full ? 'FULL' : '') . ' COLUMNS FROM ' . Util::backquote($database) . '.' . Util::backquote($table) . ($escapedColumn !== null ? " LIKE '" . $escapedColumn . "'" : '');
    }
    public static function getInformationSchemaRoutinesRequest(string $escapedDb, ?string $routineType, ?string $escapedRoutineName) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getInformationSchemaRoutinesRequest") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Query/Generator.php at line 91")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getInformationSchemaRoutinesRequest:91@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Query/Generator.php');
        die();
    }
    public static function getInformationSchemaEventsRequest(string $escapedDb, ?string $escapedEventName) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getInformationSchemaEventsRequest") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Query/Generator.php at line 102")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getInformationSchemaEventsRequest:102@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Query/Generator.php');
        die();
    }
    public static function getInformationSchemaTriggersRequest(string $escapedDb, ?string $escapedTable) : string
    {
        $query = 'SELECT TRIGGER_SCHEMA, TRIGGER_NAME, EVENT_MANIPULATION' . ', EVENT_OBJECT_TABLE, ACTION_TIMING, ACTION_STATEMENT' . ', EVENT_OBJECT_SCHEMA, EVENT_OBJECT_TABLE, DEFINER' . ' FROM information_schema.TRIGGERS' . ' WHERE EVENT_OBJECT_SCHEMA ' . Util::getCollateForIS() . '=' . ' \'' . $escapedDb . '\'';
        if ($escapedTable !== null) {
            $query .= ' AND EVENT_OBJECT_TABLE ' . Util::getCollateForIS() . " = '" . $escapedTable . "';";
        }
        return $query;
    }
    public static function getInformationSchemaDataForCreateRequest(string $user, string $host) : string
    {
        return 'SELECT 1 FROM `INFORMATION_SCHEMA`.`USER_PRIVILEGES` ' . "WHERE `PRIVILEGE_TYPE` = 'CREATE USER' AND " . "'''" . $user . "''@''" . $host . "''' LIKE `GRANTEE` LIMIT 1";
    }
    public static function getInformationSchemaDataForGranteeRequest(string $user, string $host) : string
    {
        return 'SELECT 1 FROM (' . 'SELECT `GRANTEE`, `IS_GRANTABLE` FROM ' . '`INFORMATION_SCHEMA`.`COLUMN_PRIVILEGES` UNION ' . 'SELECT `GRANTEE`, `IS_GRANTABLE` FROM ' . '`INFORMATION_SCHEMA`.`TABLE_PRIVILEGES` UNION ' . 'SELECT `GRANTEE`, `IS_GRANTABLE` FROM ' . '`INFORMATION_SCHEMA`.`SCHEMA_PRIVILEGES` UNION ' . 'SELECT `GRANTEE`, `IS_GRANTABLE` FROM ' . '`INFORMATION_SCHEMA`.`USER_PRIVILEGES`) t ' . "WHERE `IS_GRANTABLE` = 'YES' AND " . "'''" . $user . "''@''" . $host . "''' LIKE `GRANTEE` LIMIT 1";
    }
    public static function getInformationSchemaForeignKeyConstraintsRequest(string $escapedDatabase, string $tablesListForQueryCsv) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getInformationSchemaForeignKeyConstraintsRequest") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Query/Generator.php at line 126")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getInformationSchemaForeignKeyConstraintsRequest:126@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Query/Generator.php');
        die();
    }
    public static function getInformationSchemaDatabasesFullRequest(bool $forceStats, string $sqlWhereSchema, string $sortBy, string $sortOrder, string $limit) : string
    {
        $sql = 'SELECT *, ' . 'CAST(BIN_NAME AS CHAR CHARACTER SET utf8) AS SCHEMA_NAME' . ' FROM (';
        $sql .= 'SELECT' . ' BINARY s.SCHEMA_NAME AS BIN_NAME,' . ' s.DEFAULT_COLLATION_NAME';
        if ($forceStats) {
            $sql .= ',' . ' COUNT(t.TABLE_SCHEMA)  AS SCHEMA_TABLES,' . ' SUM(t.TABLE_ROWS)      AS SCHEMA_TABLE_ROWS,' . ' SUM(t.DATA_LENGTH)     AS SCHEMA_DATA_LENGTH,' . ' SUM(t.MAX_DATA_LENGTH) AS SCHEMA_MAX_DATA_LENGTH,' . ' SUM(t.INDEX_LENGTH)    AS SCHEMA_INDEX_LENGTH,' . ' SUM(t.DATA_LENGTH + t.INDEX_LENGTH) AS SCHEMA_LENGTH,' . ' SUM(IF(t.ENGINE <> \'InnoDB\', t.DATA_FREE, 0)) AS SCHEMA_DATA_FREE';
        }
        $sql .= ' FROM `information_schema`.SCHEMATA s ';
        if ($forceStats) {
            $sql .= ' LEFT JOIN `information_schema`.TABLES t' . ' ON BINARY t.TABLE_SCHEMA = BINARY s.SCHEMA_NAME';
        }
        $sql .= $sqlWhereSchema . ' GROUP BY BINARY s.SCHEMA_NAME, s.DEFAULT_COLLATION_NAME' . ' ORDER BY ';
        if ($sortBy === 'SCHEMA_NAME' || $sortBy === 'DEFAULT_COLLATION_NAME') {
            $sql .= 'BINARY ';
        }
        $sql .= Util::backquote($sortBy) . ' ' . $sortOrder . $limit;
        $sql .= ') a';
        return $sql;
    }
    public static function getInformationSchemaColumnsFullRequest(?string $escapedDatabase, ?string $escapedTable, ?string $escapedColumn) : array
    {
        $sqlWheres = [];
        $arrayKeys = [];
        // get columns information from information_schema
        if ($escapedDatabase !== null) {
            $sqlWheres[] = '`TABLE_SCHEMA` = \'' . $escapedDatabase . '\' ';
        } else {
            $arrayKeys[] = 'TABLE_SCHEMA';
        }
        if ($escapedTable !== null) {
            $sqlWheres[] = '`TABLE_NAME` = \'' . $escapedTable . '\' ';
        } else {
            $arrayKeys[] = 'TABLE_NAME';
        }
        if ($escapedColumn !== null) {
            $sqlWheres[] = '`COLUMN_NAME` = \'' . $escapedColumn . '\' ';
        } else {
            $arrayKeys[] = 'COLUMN_NAME';
        }
        // for PMA bc:
        // `[SCHEMA_FIELD_NAME]` AS `[SHOW_FULL_COLUMNS_FIELD_NAME]`
        $sql = 'SELECT *,' . ' `COLUMN_NAME`       AS `Field`,' . ' `COLUMN_TYPE`       AS `Type`,' . ' `COLLATION_NAME`    AS `Collation`,' . ' `IS_NULLABLE`       AS `Null`,' . ' `COLUMN_KEY`        AS `Key`,' . ' `COLUMN_DEFAULT`    AS `Default`,' . ' `EXTRA`             AS `Extra`,' . ' `PRIVILEGES`        AS `Privileges`,' . ' `COLUMN_COMMENT`    AS `Comment`' . ' FROM `information_schema`.`COLUMNS`';
        if (count($sqlWheres)) {
            $sql .= "\n" . ' WHERE ' . implode(' AND ', $sqlWheres);
        }
        return [$sql, $arrayKeys];
    }
    /**
     * Function to get sql query for renaming the index using SQL RENAME INDEX Syntax
     */
    public static function getSqlQueryForIndexRename(string $dbName, string $tableName, string $oldIndexName, string $newIndexName) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getSqlQueryForIndexRename") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Query/Generator.php at line 180")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getSqlQueryForIndexRename:180@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Query/Generator.php');
        die();
    }
}