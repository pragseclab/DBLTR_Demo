<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds the Table class
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PMA\libraries\plugins\export\ExportSql;
use PhpMyAdmin\SqlParser\Components\Expression;
use PhpMyAdmin\SqlParser\Components\OptionsArray;
use PhpMyAdmin\SqlParser\Context;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statements\DropStatement;
/**
 * Handles everything related to tables
 *
 * @todo make use of Message and Error
 * @package PhpMyAdmin
 */
class Table
{
    /**
     * UI preferences properties
     */
    const PROP_SORTED_COLUMN = 'sorted_col';
    const PROP_COLUMN_ORDER = 'col_order';
    const PROP_COLUMN_VISIB = 'col_visib';
    /**
     * @var string  engine (innodb, myisam, bdb, ...)
     */
    var $engine = '';
    /**
     * @var string  type (view, base table, system view)
     */
    var $type = '';
    /**
     * @var array UI preferences
     */
    var $uiprefs;
    /**
     * @var array errors occurred
     */
    var $errors = array();
    /**
     * @var array messages
     */
    var $messages = array();
    /**
     * @var string  table name
     */
    protected $_name = '';
    /**
     * @var string  database name
     */
    protected $_db_name = '';
    /**
     * @var DatabaseInterface
     */
    protected $_dbi;
    /**
     * Constructor
     *
     * @param string            $table_name table name
     * @param string            $db_name    database name
     * @param DatabaseInterface $dbi        database interface for the table
     */
    public function __construct($table_name, $db_name, DatabaseInterface $dbi = null)
    {
        if (empty($dbi)) {
            $dbi = $GLOBALS['dbi'];
        }
        $this->_dbi = $dbi;
        $this->_name = $table_name;
        $this->_db_name = $db_name;
    }
    /**
     * returns table name
     *
     * @see Table::getName()
     * @return string  table name
     */
    public function __toString()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__toString") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 97")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __toString:97@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * return the last error
     *
     * @return string the last error
     */
    public function getLastError()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getLastError") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 107")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getLastError:107@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * return the last message
     *
     * @return string the last message
     */
    public function getLastMessage()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getLastMessage") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 117")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getLastMessage:117@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * returns table name
     *
     * @param boolean $backquoted whether to quote name with backticks ``
     *
     * @return string  table name
     */
    public function getName($backquoted = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 129")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getName:129@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * returns database name for this table
     *
     * @param boolean $backquoted whether to quote name with backticks ``
     *
     * @return string  database name for this table
     */
    public function getDbName($backquoted = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDbName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 144")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDbName:144@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * returns full name for table, including database name
     *
     * @param boolean $backquoted whether to quote name with backticks ``
     *
     * @return string
     */
    public function getFullName($backquoted = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFullName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 159")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFullName:159@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Checks the storage engine used to create table
     *
     * @param array or string $engine Checks the table engine against an
     * array of engine strings or a single string, should be uppercase
     *
     * @return bool True, if $engine matches the storage engine for the table,
     * False otherwise.
     */
    public function isEngine($engine)
    {
        $tbl_storage_engine = strtoupper($this->getStatusInfo('ENGINE', null, true));
        if (is_array($engine)) {
            foreach ($engine as $e) {
                if ($e == $tbl_storage_engine) {
                    return true;
                }
            }
            return false;
        } else {
            return $tbl_storage_engine == $engine;
        }
    }
    /**
     * returns whether the table is actually a view
     *
     * @return boolean whether the given is a view
     */
    public function isView()
    {
        $db = $this->_db_name;
        $table = $this->_name;
        if (empty($db) || empty($table)) {
            return false;
        }
        // use cached data or load information with SHOW command
        if ($this->_dbi->getCachedTableContent(array($db, $table)) != null || $GLOBALS['cfg']['Server']['DisableIS']) {
            $type = $this->getStatusInfo('TABLE_TYPE');
            return $type == 'VIEW' || $type == 'SYSTEM VIEW';
        }
        // information_schema tables are 'SYSTEM VIEW's
        if ($db == 'information_schema') {
            return true;
        }
        // query information_schema
        $result = $this->_dbi->fetchResult("SELECT TABLE_NAME\n            FROM information_schema.VIEWS\n            WHERE TABLE_SCHEMA = '" . $GLOBALS['dbi']->escapeString($db) . "'\n                AND TABLE_NAME = '" . $GLOBALS['dbi']->escapeString($table) . "'");
        return $result ? true : false;
    }
    /**
     * Returns whether the table is actually an updatable view
     *
     * @return boolean whether the given is an updatable view
     */
    public function isUpdatableView()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isUpdatableView") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 234")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isUpdatableView:234@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Checks if this is a merge table
     *
     * If the ENGINE of the table is MERGE or MRG_MYISAM (alias),
     * this is a merge table.
     *
     * @return boolean  true if it is a merge table
     */
    public function isMerge()
    {
        return $this->isEngine(array('MERGE', 'MRG_MYISAM'));
    }
    /**
     * Returns full table status info, or specific if $info provided
     * this info is collected from information_schema
     *
     * @param string  $info          specific information to be fetched
     * @param boolean $force_read    read new rather than serving from cache
     * @param boolean $disable_error if true, disables error message
     *
     * @todo DatabaseInterface::getTablesFull needs to be merged
     * somehow into this class or at least better documented
     *
     * @return mixed
     */
    public function getStatusInfo($info = null, $force_read = false, $disable_error = false)
    {
        $db = $this->_db_name;
        $table = $this->_name;
        if (!empty($_SESSION['is_multi_query'])) {
            $disable_error = true;
        }
        // sometimes there is only one entry (ExactRows) so
        // we have to get the table's details
        if ($this->_dbi->getCachedTableContent(array($db, $table)) == null || $force_read || count($this->_dbi->getCachedTableContent(array($db, $table))) == 1) {
            $this->_dbi->getTablesFull($db, $table);
        }
        if ($this->_dbi->getCachedTableContent(array($db, $table)) == null) {
            // happens when we enter the table creation dialog
            // or when we really did not get any status info, for example
            // when $table == 'TABLE_NAMES' after the user tried SHOW TABLES
            return '';
        }
        if (null === $info) {
            return $this->_dbi->getCachedTableContent(array($db, $table));
        }
        // array_key_exists allows for null values
        if (!array_key_exists($info, $this->_dbi->getCachedTableContent(array($db, $table)))) {
            if (!$disable_error) {
                trigger_error(__('Unknown table status:') . ' ' . $info, E_USER_WARNING);
            }
            return false;
        }
        return $this->_dbi->getCachedTableContent(array($db, $table, $info));
    }
    /**
     * generates column specification for ALTER or CREATE TABLE syntax
     *
     * @param string      $name          name
     * @param string      $type          type ('INT', 'VARCHAR', 'BIT', ...)
     * @param string      $length        length ('2', '5,2', '', ...)
     * @param string      $attribute     attribute
     * @param string      $collation     collation
     * @param bool|string $null          with 'NULL' or 'NOT NULL'
     * @param string      $default_type  whether default is CURRENT_TIMESTAMP,
     *                                   NULL, NONE, USER_DEFINED
     * @param string      $default_value default value for USER_DEFINED
     *                                   default type
     * @param string      $extra         'AUTO_INCREMENT'
     * @param string      $comment       field comment
     * @param string      $virtuality    virtuality of the column
     * @param string      $expression    expression for the virtual column
     * @param string      $move_to       new position for column
     *
     * @todo    move into class PMA_Column
     * @todo on the interface, some js to clear the default value when the
     * default current_timestamp is checked
     *
     * @return string  field specification
     */
    static function generateFieldSpec($name, $type, $length = '', $attribute = '', $collation = '', $null = false, $default_type = 'USER_DEFINED', $default_value = '', $extra = '', $comment = '', $virtuality = '', $expression = '', $move_to = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("generateFieldSpec") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 353")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called generateFieldSpec:353@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    // end function
    /**
     * Checks if the number of records in a table is at least equal to
     * $min_records
     *
     * @param int $min_records Number of records to check for in a table
     *
     * @return bool True, if at least $min_records exist, False otherwise.
     */
    public function checkIfMinRecordsExist($min_records = 0)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkIfMinRecordsExist") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 484")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkIfMinRecordsExist:484@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Counts and returns (or displays) the number of records in a table
     *
     * @param bool $force_exact whether to force an exact count
     *
     * @return mixed the number of records if "retain" param is true,
     *               otherwise true
     */
    public function countRecords($force_exact = false)
    {
        $is_view = $this->isView();
        $db = $this->_db_name;
        $table = $this->_name;
        if ($this->_dbi->getCachedTableContent(array($db, $table, 'ExactRows')) != null) {
            $row_count = $this->_dbi->getCachedTableContent(array($db, $table, 'ExactRows'));
            return $row_count;
        }
        $row_count = false;
        if (!$force_exact) {
            if ($this->_dbi->getCachedTableContent(array($db, $table, 'Rows')) == null && !$is_view) {
                $tmp_tables = $this->_dbi->getTablesFull($db, $table);
                if (isset($tmp_tables[$table])) {
                    $this->_dbi->cacheTableContent(array($db, $table), $tmp_tables[$table]);
                }
            }
            if ($this->_dbi->getCachedTableContent(array($db, $table, 'Rows')) != null) {
                $row_count = $this->_dbi->getCachedTableContent(array($db, $table, 'Rows'));
            } else {
                $row_count = false;
            }
        }
        // for a VIEW, $row_count is always false at this point
        if (false !== $row_count && $row_count >= $GLOBALS['cfg']['MaxExactCount']) {
            return $row_count;
        }
        if (!$is_view) {
            $row_count = $this->_dbi->fetchValue('SELECT COUNT(*) FROM ' . Util::backquote($db) . '.' . Util::backquote($table));
        } else {
            // For complex views, even trying to get a partial record
            // count could bring down a server, so we offer an
            // alternative: setting MaxExactCountViews to 0 will bypass
            // completely the record counting for views
            if ($GLOBALS['cfg']['MaxExactCountViews'] == 0) {
                $row_count = false;
            } else {
                // Counting all rows of a VIEW could be too long,
                // so use a LIMIT clause.
                // Use try_query because it can fail (when a VIEW is
                // based on a table that no longer exists)
                $result = $this->_dbi->tryQuery('SELECT 1 FROM ' . Util::backquote($db) . '.' . Util::backquote($table) . ' LIMIT ' . $GLOBALS['cfg']['MaxExactCountViews'], null, DatabaseInterface::QUERY_STORE);
                if (!$this->_dbi->getError()) {
                    $row_count = $this->_dbi->numRows($result);
                    $this->_dbi->freeResult($result);
                }
            }
        }
        if ($row_count) {
            $this->_dbi->cacheTableContent(array($db, $table, 'ExactRows'), $row_count);
        }
        return $row_count;
    }
    // end of the 'Table::countRecords()' function
    /**
     * Generates column specification for ALTER syntax
     *
     * @param string      $oldcol        old column name
     * @param string      $newcol        new column name
     * @param string      $type          type ('INT', 'VARCHAR', 'BIT', ...)
     * @param string      $length        length ('2', '5,2', '', ...)
     * @param string      $attribute     attribute
     * @param string      $collation     collation
     * @param bool|string $null          with 'NULL' or 'NOT NULL'
     * @param string      $default_type  whether default is CURRENT_TIMESTAMP,
     *                                   NULL, NONE, USER_DEFINED
     * @param string      $default_value default value for USER_DEFINED default
     *                                   type
     * @param string      $extra         'AUTO_INCREMENT'
     * @param string      $comment       field comment
     * @param string      $virtuality    virtuality of the column
     * @param string      $expression    expression for the virtual column
     * @param string      $move_to       new position for column
     *
     * @see Table::generateFieldSpec()
     *
     * @return string  field specification
     */
    public static function generateAlter($oldcol, $newcol, $type, $length, $attribute, $collation, $null, $default_type, $default_value, $extra, $comment, $virtuality, $expression, $move_to)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("generateAlter") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 632")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called generateAlter:632@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    // end function
    /**
     * Inserts existing entries in a PMA_* table by reading a value from an old
     * entry
     *
     * @param string $work         The array index, which Relation feature to
     *                             check ('relwork', 'commwork', ...)
     * @param string $pma_table    The array index, which PMA-table to update
     *                             ('bookmark', 'relation', ...)
     * @param array  $get_fields   Which fields will be SELECT'ed from the old entry
     * @param array  $where_fields Which fields will be used for the WHERE query
     *                             (array('FIELDNAME' => 'FIELDVALUE'))
     * @param array  $new_fields   Which fields will be used as new VALUES.
     *                             These are the important keys which differ
     *                             from the old entry
     *                             (array('FIELDNAME' => 'NEW FIELDVALUE'))
     *
     * @global relation variable
     *
     * @return int|boolean
     */
    public static function duplicateInfo($work, $pma_table, $get_fields, $where_fields, $new_fields)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("duplicateInfo") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 663")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called duplicateInfo:663@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    // end of 'Table::duplicateInfo()' function
    /**
     * Copies or renames table
     *
     * @param string $source_db    source database
     * @param string $source_table source table
     * @param string $target_db    target database
     * @param string $target_table target table
     * @param string $what         what to be moved or copied (data, dataonly)
     * @param bool   $move         whether to move
     * @param string $mode         mode
     *
     * @return bool true if success, false otherwise
     */
    public static function moveCopy($source_db, $source_table, $target_db, $target_table, $what, $move, $mode)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("moveCopy") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 743")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called moveCopy:743@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * checks if given name is a valid table name,
     * currently if not empty, trailing spaces, '.', '/' and '\'
     *
     * @param string  $table_name    name to check
     * @param boolean $is_backquoted whether this name is used inside backquotes or not
     *
     * @todo add check for valid chars in filename on current system/os
     * @see  https://dev.mysql.com/doc/refman/5.0/en/legal-names.html
     *
     * @return boolean whether the string is valid or not
     */
    static function isValidName($table_name, $is_backquoted = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isValidName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1272")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isValidName:1272@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * renames table
     *
     * @param string $new_name new table name
     * @param string $new_db   new database name
     *
     * @return bool success
     */
    public function rename($new_name, $new_db = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("rename") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1310")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called rename:1310@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Get all unique columns
     *
     * returns an array with all columns with unique content, in fact these are
     * all columns being single indexed in PRIMARY or UNIQUE
     *
     * e.g.
     *  - PRIMARY(id) // id
     *  - UNIQUE(name) // name
     *  - PRIMARY(fk_id1, fk_id2) // NONE
     *  - UNIQUE(x,y) // NONE
     *
     * @param bool $backquoted whether to quote name with backticks ``
     * @param bool $fullName   whether to include full name of the table as a prefix
     *
     * @return array
     */
    public function getUniqueColumns($backquoted = true, $fullName = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUniqueColumns") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1414")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUniqueColumns:1414@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Formats lists of columns
     *
     * returns an array with all columns that make use of an index
     *
     * e.g. index(col1, col2) would return col1, col2
     *
     * @param array $indexed    column data
     * @param bool  $backquoted whether to quote name with backticks ``
     * @param bool  $fullName   whether to include full name of the table as a prefix
     *
     * @return array
     */
    private function _formatColumns($indexed, $backquoted, $fullName)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_formatColumns") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1464")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _formatColumns:1464@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Get all indexed columns
     *
     * returns an array with all columns that make use of an index
     *
     * e.g. index(col1, col2) would return col1, col2
     *
     * @param bool $backquoted whether to quote name with backticks ``
     * @param bool $fullName   whether to include full name of the table as a prefix
     *
     * @return array
     */
    public function getIndexedColumns($backquoted = true, $fullName = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getIndexedColumns") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1487")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getIndexedColumns:1487@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Get all columns
     *
     * returns an array with all columns
     *
     * @param bool $backquoted whether to quote name with backticks ``
     * @param bool $fullName   whether to include full name of the table as a prefix
     *
     * @return array
     */
    public function getColumns($backquoted = true, $fullName = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getColumns") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1509")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getColumns:1509@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Get meta info for fields in table
     *
     * @return mixed
     */
    public function getColumnsMeta()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getColumnsMeta") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1522")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getColumnsMeta:1522@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Get non-generated columns in table
     *
     * @param bool $backquoted whether to quote name with backticks ``
     *
     * @return array
     */
    public function getNonGeneratedColumns($backquoted = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getNonGeneratedColumns") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1545")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getNonGeneratedColumns:1545@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Return UI preferences for this table from phpMyAdmin database.
     *
     * @return array
     */
    protected function getUiPrefsFromDb()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUiPrefsFromDb") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1577")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUiPrefsFromDb:1577@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Save this table's UI preferences into phpMyAdmin database.
     *
     * @return true|Message
     */
    protected function saveUiPrefsToDb()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("saveUiPrefsToDb") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1602")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called saveUiPrefsToDb:1602@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Loads the UI preferences for this table.
     * If pmadb and table_uiprefs is set, it will load the UI preferences from
     * phpMyAdmin database.
     *
     * @return void
     */
    protected function loadUiPrefs()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("loadUiPrefs") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1677")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called loadUiPrefs:1677@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Get a property from UI preferences.
     * Return false if the property is not found.
     * Available property:
     * - PROP_SORTED_COLUMN
     * - PROP_COLUMN_ORDER
     * - PROP_COLUMN_VISIB
     *
     * @param string $property property
     *
     * @return mixed
     */
    public function getUiProp($property)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUiProp") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1706")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUiProp:1706@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Set a property from UI preferences.
     * If pmadb and table_uiprefs is set, it will save the UI preferences to
     * phpMyAdmin database.
     * Available property:
     * - PROP_SORTED_COLUMN
     * - PROP_COLUMN_ORDER
     * - PROP_COLUMN_VISIB
     *
     * @param string $property          Property
     * @param mixed  $value             Value for the property
     * @param string $table_create_time Needed for PROP_COLUMN_ORDER
     *                                  and PROP_COLUMN_VISIB
     *
     * @return boolean|Message
     */
    public function setUiProp($property, $value, $table_create_time = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setUiProp") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1782")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setUiProp:1782@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Remove a property from UI preferences.
     *
     * @param string $property the property
     *
     * @return true|Message
     */
    public function removeUiProp($property)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("removeUiProp") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1831")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called removeUiProp:1831@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Get all column names which are MySQL reserved words
     *
     * @return array
     * @access public
     */
    public function getReservedColumnNames()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getReservedColumnNames") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1854")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getReservedColumnNames:1854@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Function to get the name and type of the columns of a table
     *
     * @return array
     */
    public function getNameAndTypeOfTheColumns()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getNameAndTypeOfTheColumns") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1873")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getNameAndTypeOfTheColumns:1873@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Get index with index name
     *
     * @param string $index Index name
     *
     * @return Index
     */
    public function getIndex($index)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getIndex") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1899")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getIndex:1899@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Function to get the sql query for index creation or edit
     *
     * @param Index $index  current index
     * @param bool  &$error whether error occurred or not
     *
     * @return string
     */
    public function getSqlQueryForIndexCreateOrEdit($index, &$error)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getSqlQueryForIndexCreateOrEdit") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 1913")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getSqlQueryForIndexCreateOrEdit:1913@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Function to handle update for display field
     *
     * @param string $disp          current display field
     * @param string $display_field display field
     * @param array  $cfgRelation   configuration relation
     *
     * @return boolean True on update succeed or False on failure
     */
    public function updateDisplayField($disp, $display_field, $cfgRelation)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updateDisplayField") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 2025")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updateDisplayField:2025@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Function to get update query for updating internal relations
     *
     * @param array      $multi_edit_columns_name multi edit column names
     * @param array      $destination_db          destination tables
     * @param array      $destination_table       destination tables
     * @param array      $destination_column      destination columns
     * @param array      $cfgRelation             configuration relation
     * @param array|null $existrel                db, table, column
     *
     * @return boolean
     */
    public function updateInternalRelations($multi_edit_columns_name, $destination_db, $destination_table, $destination_column, $cfgRelation, $existrel)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updateInternalRelations") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 2084")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updateInternalRelations:2084@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Function to handle foreign key updates
     *
     * @param array  $destination_foreign_db     destination foreign database
     * @param array  $multi_edit_columns_name    multi edit column names
     * @param array  $destination_foreign_table  destination foreign table
     * @param array  $destination_foreign_column destination foreign column
     * @param array  $options_array              options array
     * @param string $table                      current table
     * @param array  $existrel_foreign           db, table, column
     *
     * @return array
     */
    public function updateForeignKeys($destination_foreign_db, $multi_edit_columns_name, $destination_foreign_table, $destination_foreign_column, $options_array, $table, $existrel_foreign)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updateForeignKeys") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 2171")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updateForeignKeys:2171@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Returns the SQL query for foreign key constraint creation
     *
     * @param string $table        table name
     * @param array  $field        field names
     * @param string $foreignDb    foreign database name
     * @param string $foreignTable foreign table name
     * @param array  $foreignField foreign field names
     * @param string $name         name of the constraint
     * @param string $onDelete     on delete action
     * @param string $onUpdate     on update action
     *
     * @return string SQL query for foreign key constraint creation
     */
    private function _getSQLToCreateForeignKey($table, $field, $foreignDb, $foreignTable, $foreignField, $name = null, $onDelete = null, $onUpdate = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getSQLToCreateForeignKey") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 2369")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getSQLToCreateForeignKey:2369@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Returns the generation expression for virtual columns
     *
     * @param string $column name of the column
     *
     * @return array|boolean associative array of column name and their expressions
     *                       or false on failure
     */
    public function getColumnGenerationExpression($column = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getColumnGenerationExpression") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 2408")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getColumnGenerationExpression:2408@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Returns the CREATE statement for this table
     *
     * @return mixed
     */
    public function showCreate()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("showCreate") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 2463")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called showCreate:2463@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Returns the real row count for a table
     *
     * @return number
     */
    public function getRealRowCountTable()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getRealRowCountTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 2478")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getRealRowCountTable:2478@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
    /**
     * Get columns with indexes
     *
     * @param int $types types bitmask
     *
     * @return array an array of columns
     */
    public function getColumnsWithIndex($types)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getColumnsWithIndex") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php at line 2498")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getColumnsWithIndex:2498@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Table.php');
        die();
    }
}