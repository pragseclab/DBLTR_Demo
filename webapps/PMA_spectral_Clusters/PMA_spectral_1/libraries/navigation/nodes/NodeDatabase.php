<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Functionality for the navigation tree
 *
 * @package PhpMyAdmin-Navigation
 */
namespace PMA\libraries\navigation\nodes;

use PMA\libraries\Util;
use PMA\libraries\URL;
/**
 * Represents a database node in the navigation tree
 *
 * @package PhpMyAdmin-Navigation
 */
class NodeDatabase extends Node
{
    /**
     * The number of hidden items in this database
     *
     * @var int
     */
    protected $hiddenCount = 0;
    /**
     * Initialises the class
     *
     * @param string $name     An identifier for the new node
     * @param int    $type     Type of node, may be one of CONTAINER or OBJECT
     * @param bool   $is_group Whether this object has been created
     *                         while grouping nodes
     */
    public function __construct($name, $type = Node::OBJECT, $is_group = false)
    {
        parent::__construct($name, $type, $is_group);
        $this->icon = Util::getImage('s_db.png', __('Database operations'));
        $script_name = Util::getScriptNameForOption($GLOBALS['cfg']['DefaultTabDatabase'], 'database');
        $this->links = array('text' => $script_name . '?server=' . $GLOBALS['server'] . '&amp;db=%1$s', 'icon' => 'db_operations.php?server=' . $GLOBALS['server'] . '&amp;db=%1$s&amp;', 'title' => __('Structure'));
        $this->classes = 'database';
    }
    /**
     * Returns the number of children of type $type present inside this container
     * This method is overridden by the PMA\libraries\navigation\nodes\NodeDatabase
     * and PMA\libraries\navigation\nodes\NodeTable classes
     *
     * @param string  $type         The type of item we are looking for
     *                              ('tables', 'views', etc)
     * @param string  $searchClause A string used to filter the results of
     *                              the query
     * @param boolean $singleItem   Whether to get presence of a single known
     *                              item or false in none
     *
     * @return int
     */
    public function getPresence($type = '', $searchClause = '', $singleItem = false)
    {
        $retval = 0;
        switch ($type) {
            case 'tables':
                $retval = $this->_getTableCount($searchClause, $singleItem);
                break;
            case 'views':
                $retval = $this->_getViewCount($searchClause, $singleItem);
                break;
            case 'procedures':
                $retval = $this->_getProcedureCount($searchClause, $singleItem);
                break;
            case 'functions':
                $retval = $this->_getFunctionCount($searchClause, $singleItem);
                break;
            case 'events':
                $retval = $this->_getEventCount($searchClause, $singleItem);
                break;
            default:
                break;
        }
        return $retval;
    }
    /**
     * Returns the number of tables or views present inside this database
     *
     * @param string  $which        tables|views
     * @param string  $searchClause A string used to filter the results of
     *                              the query
     * @param boolean $singleItem   Whether to get presence of a single known
     *                              item or false in none
     *
     * @return int
     */
    private function _getTableOrViewCount($which, $searchClause, $singleItem)
    {
        $db = $this->real_name;
        if ($which == 'tables') {
            $condition = '=';
        } else {
            $condition = '!=';
        }
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $db = $GLOBALS['dbi']->escapeString($db);
            $query = "SELECT COUNT(*) ";
            $query .= "FROM `INFORMATION_SCHEMA`.`TABLES` ";
            $query .= "WHERE `TABLE_SCHEMA`='{$db}' ";
            $query .= "AND `TABLE_TYPE`" . $condition . "'BASE TABLE' ";
            if (!empty($searchClause)) {
                $query .= "AND " . $this->_getWhereClauseForSearch($searchClause, $singleItem, 'TABLE_NAME');
            }
            $retval = (int) $GLOBALS['dbi']->fetchValue($query);
        } else {
            $query = "SHOW FULL TABLES FROM ";
            $query .= Util::backquote($db);
            $query .= " WHERE `Table_type`" . $condition . "'BASE TABLE' ";
            if (!empty($searchClause)) {
                $query .= "AND " . $this->_getWhereClauseForSearch($searchClause, $singleItem, 'Tables_in_' . $db);
            }
            $retval = $GLOBALS['dbi']->numRows($GLOBALS['dbi']->tryQuery($query));
        }
        return $retval;
    }
    /**
     * Returns the number of tables present inside this database
     *
     * @param string  $searchClause A string used to filter the results of
     *                              the query
     * @param boolean $singleItem   Whether to get presence of a single known
     *                              item or false in none
     *
     * @return int
     */
    private function _getTableCount($searchClause, $singleItem)
    {
        return $this->_getTableOrViewCount('tables', $searchClause, $singleItem);
    }
    /**
     * Returns the number of views present inside this database
     *
     * @param string  $searchClause A string used to filter the results of
     *                              the query
     * @param boolean $singleItem   Whether to get presence of a single known
     *                              item or false in none
     *
     * @return int
     */
    private function _getViewCount($searchClause, $singleItem)
    {
        return $this->_getTableOrViewCount('views', $searchClause, $singleItem);
    }
    /**
     * Returns the number of procedures present inside this database
     *
     * @param string  $searchClause A string used to filter the results of
     *                              the query
     * @param boolean $singleItem   Whether to get presence of a single known
     *                              item or false in none
     *
     * @return int
     */
    private function _getProcedureCount($searchClause, $singleItem)
    {
        $db = $this->real_name;
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $db = $GLOBALS['dbi']->escapeString($db);
            $query = "SELECT COUNT(*) ";
            $query .= "FROM `INFORMATION_SCHEMA`.`ROUTINES` ";
            $query .= "WHERE `ROUTINE_SCHEMA` " . Util::getCollateForIS() . "='{$db}'";
            $query .= "AND `ROUTINE_TYPE`='PROCEDURE' ";
            if (!empty($searchClause)) {
                $query .= "AND " . $this->_getWhereClauseForSearch($searchClause, $singleItem, 'ROUTINE_NAME');
            }
            $retval = (int) $GLOBALS['dbi']->fetchValue($query);
        } else {
            $db = $GLOBALS['dbi']->escapeString($db);
            $query = "SHOW PROCEDURE STATUS WHERE `Db`='{$db}' ";
            if (!empty($searchClause)) {
                $query .= "AND " . $this->_getWhereClauseForSearch($searchClause, $singleItem, 'Name');
            }
            $retval = $GLOBALS['dbi']->numRows($GLOBALS['dbi']->tryQuery($query));
        }
        return $retval;
    }
    /**
     * Returns the number of functions present inside this database
     *
     * @param string  $searchClause A string used to filter the results of
     *                              the query
     * @param boolean $singleItem   Whether to get presence of a single known
     *                              item or false in none
     *
     * @return int
     */
    private function _getFunctionCount($searchClause, $singleItem)
    {
        $db = $this->real_name;
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $db = $GLOBALS['dbi']->escapeString($db);
            $query = "SELECT COUNT(*) ";
            $query .= "FROM `INFORMATION_SCHEMA`.`ROUTINES` ";
            $query .= "WHERE `ROUTINE_SCHEMA` " . Util::getCollateForIS() . "='{$db}' ";
            $query .= "AND `ROUTINE_TYPE`='FUNCTION' ";
            if (!empty($searchClause)) {
                $query .= "AND " . $this->_getWhereClauseForSearch($searchClause, $singleItem, 'ROUTINE_NAME');
            }
            $retval = (int) $GLOBALS['dbi']->fetchValue($query);
        } else {
            $db = $GLOBALS['dbi']->escapeString($db);
            $query = "SHOW FUNCTION STATUS WHERE `Db`='{$db}' ";
            if (!empty($searchClause)) {
                $query .= "AND " . $this->_getWhereClauseForSearch($searchClause, $singleItem, 'Name');
            }
            $retval = $GLOBALS['dbi']->numRows($GLOBALS['dbi']->tryQuery($query));
        }
        return $retval;
    }
    /**
     * Returns the number of events present inside this database
     *
     * @param string  $searchClause A string used to filter the results of
     *                              the query
     * @param boolean $singleItem   Whether to get presence of a single known
     *                              item or false in none
     *
     * @return int
     */
    private function _getEventCount($searchClause, $singleItem)
    {
        $db = $this->real_name;
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $db = $GLOBALS['dbi']->escapeString($db);
            $query = "SELECT COUNT(*) ";
            $query .= "FROM `INFORMATION_SCHEMA`.`EVENTS` ";
            $query .= "WHERE `EVENT_SCHEMA` " . Util::getCollateForIS() . "='{$db}' ";
            if (!empty($searchClause)) {
                $query .= "AND " . $this->_getWhereClauseForSearch($searchClause, $singleItem, 'EVENT_NAME');
            }
            $retval = (int) $GLOBALS['dbi']->fetchValue($query);
        } else {
            $db = Util::backquote($db);
            $query = "SHOW EVENTS FROM {$db} ";
            if (!empty($searchClause)) {
                $query .= "WHERE " . $this->_getWhereClauseForSearch($searchClause, $singleItem, 'Name');
            }
            $retval = $GLOBALS['dbi']->numRows($GLOBALS['dbi']->tryQuery($query));
        }
        return $retval;
    }
    /**
     * Returns the WHERE clause for searching inside a database
     *
     * @param string  $searchClause A string used to filter the results of the query
     * @param boolean $singleItem   Whether to get presence of a single known item
     * @param string  $columnName   Name of the column in the result set to match
     *
     * @return string WHERE clause for searching
     */
    private function _getWhereClauseForSearch($searchClause, $singleItem, $columnName)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getWhereClauseForSearch") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php at line 340")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getWhereClauseForSearch:340@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns the names of children of type $type present inside this container
     * This method is overridden by the PMA\libraries\navigation\nodes\NodeDatabase
     * and PMA\libraries\navigation\nodes\NodeTable classes
     *
     * @param string $type         The type of item we are looking for
     *                             ('tables', 'views', etc)
     * @param int    $pos          The offset of the list within the results
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return array
     */
    public function getData($type, $pos, $searchClause = '')
    {
        $retval = array();
        switch ($type) {
            case 'tables':
                $retval = $this->_getTables($pos, $searchClause);
                break;
            case 'views':
                $retval = $this->_getViews($pos, $searchClause);
                break;
            case 'procedures':
                $retval = $this->_getProcedures($pos, $searchClause);
                break;
            case 'functions':
                $retval = $this->_getFunctions($pos, $searchClause);
                break;
            case 'events':
                $retval = $this->_getEvents($pos, $searchClause);
                break;
            default:
                break;
        }
        // Remove hidden items so that they are not displayed in navigation tree
        $cfgRelation = PMA_getRelationsParam();
        if ($cfgRelation['navwork']) {
            $hiddenItems = $this->getHiddenItems(substr($type, 0, -1));
            foreach ($retval as $key => $item) {
                if (in_array($item, $hiddenItems)) {
                    unset($retval[$key]);
                }
            }
        }
        return $retval;
    }
    /**
     * Return list of hidden items of given type
     *
     * @param string $type The type of items we are looking for
     *                     ('table', 'function', 'group', etc.)
     *
     * @return array Array containing hidden items of given type
     */
    public function getHiddenItems($type)
    {
        $db = $this->real_name;
        $cfgRelation = PMA_getRelationsParam();
        if (empty($cfgRelation['navigationhiding'])) {
            return array();
        }
        $navTable = Util::backquote($cfgRelation['db']) . "." . Util::backquote($cfgRelation['navigationhiding']);
        $sqlQuery = "SELECT `item_name` FROM " . $navTable . " WHERE `username`='" . $cfgRelation['user'] . "'" . " AND `item_type`='" . $type . "'" . " AND `db_name`='" . $GLOBALS['dbi']->escapeString($db) . "'";
        $result = PMA_queryAsControlUser($sqlQuery, false);
        $hiddenItems = array();
        if ($result) {
            while ($row = $GLOBALS['dbi']->fetchArray($result)) {
                $hiddenItems[] = $row[0];
            }
        }
        $GLOBALS['dbi']->freeResult($result);
        return $hiddenItems;
    }
    /**
     * Returns the list of tables or views inside this database
     *
     * @param string $which        tables|views
     * @param int    $pos          The offset of the list within the results
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return array
     */
    private function _getTablesOrViews($which, $pos, $searchClause)
    {
        if ($which == 'tables') {
            $condition = '=';
        } else {
            $condition = '!=';
        }
        $maxItems = $GLOBALS['cfg']['MaxNavigationItems'];
        $retval = array();
        $db = $this->real_name;
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $escdDb = $GLOBALS['dbi']->escapeString($db);
            $query = "SELECT `TABLE_NAME` AS `name` ";
            $query .= "FROM `INFORMATION_SCHEMA`.`TABLES` ";
            $query .= "WHERE `TABLE_SCHEMA`='{$escdDb}' ";
            $query .= "AND `TABLE_TYPE`" . $condition . "'BASE TABLE' ";
            if (!empty($searchClause)) {
                $query .= "AND `TABLE_NAME` LIKE '%";
                $query .= $GLOBALS['dbi']->escapeString($searchClause);
                $query .= "%'";
            }
            $query .= "ORDER BY `TABLE_NAME` ASC ";
            $query .= "LIMIT " . intval($pos) . ", {$maxItems}";
            $retval = $GLOBALS['dbi']->fetchResult($query);
        } else {
            $query = " SHOW FULL TABLES FROM ";
            $query .= Util::backquote($db);
            $query .= " WHERE `Table_type`" . $condition . "'BASE TABLE' ";
            if (!empty($searchClause)) {
                $query .= "AND " . Util::backquote("Tables_in_" . $db);
                $query .= " LIKE '%" . $GLOBALS['dbi']->escapeString($searchClause);
                $query .= "%'";
            }
            $handle = $GLOBALS['dbi']->tryQuery($query);
            if ($handle !== false) {
                $count = 0;
                if ($GLOBALS['dbi']->dataSeek($handle, $pos)) {
                    while ($arr = $GLOBALS['dbi']->fetchArray($handle)) {
                        if ($count < $maxItems) {
                            $retval[] = $arr[0];
                            $count++;
                        } else {
                            break;
                        }
                    }
                }
            }
        }
        return $retval;
    }
    /**
     * Returns the list of tables inside this database
     *
     * @param int    $pos          The offset of the list within the results
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return array
     */
    private function _getTables($pos, $searchClause)
    {
        return $this->_getTablesOrViews('tables', $pos, $searchClause);
    }
    /**
     * Returns the list of views inside this database
     *
     * @param int    $pos          The offset of the list within the results
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return array
     */
    private function _getViews($pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getViews") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php at line 524")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getViews:524@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns the list of procedures or functions inside this database
     *
     * @param string $routineType  PROCEDURE|FUNCTION
     * @param int    $pos          The offset of the list within the results
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return array
     */
    private function _getRoutines($routineType, $pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getRoutines") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php at line 538")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getRoutines:538@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns the list of procedures inside this database
     *
     * @param int    $pos          The offset of the list within the results
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return array
     */
    private function _getProcedures($pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getProcedures") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php at line 593")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getProcedures:593@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns the list of functions inside this database
     *
     * @param int    $pos          The offset of the list within the results
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return array
     */
    private function _getFunctions($pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getFunctions") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php at line 606")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getFunctions:606@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns the list of events inside this database
     *
     * @param int    $pos          The offset of the list within the results
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return array
     */
    private function _getEvents($pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getEvents") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php at line 619")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getEvents:619@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns HTML for control buttons displayed infront of a node
     *
     * @return String HTML for control buttons
     */
    public function getHtmlForControlButtons()
    {
        $ret = '';
        $cfgRelation = PMA_getRelationsParam();
        if ($cfgRelation['navwork']) {
            if ($this->hiddenCount > 0) {
                $params = array('showUnhideDialog' => true, 'dbName' => $this->real_name);
                $ret = '<span class="dbItemControls">' . '<a href="navigation.php' . URL::getCommon($params) . '"' . ' class="showUnhide ajax">' . Util::getImage('show.png', __('Show hidden items')) . '</a></span>';
            }
        }
        return $ret;
    }
    /**
     * Sets the number of hidden items in this database
     *
     * @param int $count hidden item count
     *
     * @return void
     */
    public function setHiddenCount($count)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setHiddenCount") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php at line 702")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setHiddenCount:702@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns the number of hidden items in this database
     *
     * @return int hidden item count
     */
    public function getHiddenCount()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHiddenCount") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php at line 712")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHiddenCount:712@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabase.php');
        die();
    }
}