<?php

/**
 * Functionality for the navigation tree
 */
declare (strict_types=1);
namespace PhpMyAdmin\Navigation\Nodes;

use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use function in_array;
use function intval;
use function strpos;
use function substr;
/**
 * Represents a database node in the navigation tree
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
     * @param string $name    An identifier for the new node
     * @param int    $type    Type of node, may be one of CONTAINER or OBJECT
     * @param bool   $isGroup Whether this object has been created
     *                        while grouping nodes
     */
    public function __construct($name, $type = Node::OBJECT, $isGroup = false)
    {
        parent::__construct($name, $type, $isGroup);
        $this->icon = Generator::getImage('s_db', __('Database operations'));
        $scriptName = Util::getScriptNameForOption($GLOBALS['cfg']['DefaultTabDatabase'], 'database');
        $hasRoute = strpos($scriptName, '?');
        $this->links = ['text' => $scriptName . ($hasRoute === false ? '?' : '&') . 'server=' . $GLOBALS['server'] . '&amp;db=%1$s', 'icon' => Url::getFromRoute('/database/operations') . '&amp;server=' . $GLOBALS['server'] . '&amp;db=%1$s&amp;', 'title' => __('Structure')];
        $this->classes = 'database';
    }
    /**
     * Returns the number of children of type $type present inside this container
     * This method is overridden by the PhpMyAdmin\Navigation\Nodes\NodeDatabase
     * and PhpMyAdmin\Navigation\Nodes\NodeTable classes
     *
     * @param string $type         The type of item we are looking for
     *                             ('tables', 'views', etc)
     * @param string $searchClause A string used to filter the results of
     *                             the query
     * @param bool   $singleItem   Whether to get presence of a single known
     *                             item or false in none
     *
     * @return int
     */
    public function getPresence($type = '', $searchClause = '', $singleItem = false)
    {
        $retval = 0;
        switch ($type) {
            case 'tables':
                $retval = $this->getTableCount($searchClause, $singleItem);
                break;
            case 'views':
                $retval = $this->getViewCount($searchClause, $singleItem);
                break;
            case 'procedures':
                $retval = $this->getProcedureCount($searchClause, $singleItem);
                break;
            case 'functions':
                $retval = $this->getFunctionCount($searchClause, $singleItem);
                break;
            case 'events':
                $retval = $this->getEventCount($searchClause, $singleItem);
                break;
            default:
                break;
        }
        return $retval;
    }
    /**
     * Returns the number of tables or views present inside this database
     *
     * @param string $which        tables|views
     * @param string $searchClause A string used to filter the results of
     *                             the query
     * @param bool   $singleItem   Whether to get presence of a single known
     *                             item or false in none
     *
     * @return int
     */
    private function getTableOrViewCount($which, $searchClause, $singleItem)
    {
        global $dbi;
        $db = $this->realName;
        if ($which === 'tables') {
            $condition = 'IN';
        } else {
            $condition = 'NOT IN';
        }
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $db = $dbi->escapeString($db);
            $query = 'SELECT COUNT(*) ';
            $query .= 'FROM `INFORMATION_SCHEMA`.`TABLES` ';
            $query .= "WHERE `TABLE_SCHEMA`='" . $db . "' ";
            $query .= 'AND `TABLE_TYPE`' . $condition . "('BASE TABLE', 'SYSTEM VERSIONED') ";
            if (!empty($searchClause)) {
                $query .= 'AND ' . $this->getWhereClauseForSearch($searchClause, $singleItem, 'TABLE_NAME');
            }
            $retval = (int) $dbi->fetchValue($query);
        } else {
            $query = 'SHOW FULL TABLES FROM ';
            $query .= Util::backquote($db);
            $query .= ' WHERE `Table_type`' . $condition . "('BASE TABLE', 'SYSTEM VERSIONED') ";
            if (!empty($searchClause)) {
                $query .= 'AND ' . $this->getWhereClauseForSearch($searchClause, $singleItem, 'Tables_in_' . $db);
            }
            $retval = $dbi->numRows($dbi->tryQuery($query));
        }
        return $retval;
    }
    /**
     * Returns the number of tables present inside this database
     *
     * @param string $searchClause A string used to filter the results of
     *                             the query
     * @param bool   $singleItem   Whether to get presence of a single known
     *                             item or false in none
     *
     * @return int
     */
    private function getTableCount($searchClause, $singleItem)
    {
        return $this->getTableOrViewCount('tables', $searchClause, $singleItem);
    }
    /**
     * Returns the number of views present inside this database
     *
     * @param string $searchClause A string used to filter the results of
     *                             the query
     * @param bool   $singleItem   Whether to get presence of a single known
     *                             item or false in none
     *
     * @return int
     */
    private function getViewCount($searchClause, $singleItem)
    {
        return $this->getTableOrViewCount('views', $searchClause, $singleItem);
    }
    /**
     * Returns the number of procedures present inside this database
     *
     * @param string $searchClause A string used to filter the results of
     *                             the query
     * @param bool   $singleItem   Whether to get presence of a single known
     *                             item or false in none
     *
     * @return int
     */
    private function getProcedureCount($searchClause, $singleItem)
    {
        global $dbi;
        $db = $this->realName;
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $db = $dbi->escapeString($db);
            $query = 'SELECT COUNT(*) ';
            $query .= 'FROM `INFORMATION_SCHEMA`.`ROUTINES` ';
            $query .= 'WHERE `ROUTINE_SCHEMA` ' . Util::getCollateForIS() . "='" . $db . "'";
            $query .= "AND `ROUTINE_TYPE`='PROCEDURE' ";
            if (!empty($searchClause)) {
                $query .= 'AND ' . $this->getWhereClauseForSearch($searchClause, $singleItem, 'ROUTINE_NAME');
            }
            $retval = (int) $dbi->fetchValue($query);
        } else {
            $db = $dbi->escapeString($db);
            $query = "SHOW PROCEDURE STATUS WHERE `Db`='" . $db . "' ";
            if (!empty($searchClause)) {
                $query .= 'AND ' . $this->getWhereClauseForSearch($searchClause, $singleItem, 'Name');
            }
            $retval = $dbi->numRows($dbi->tryQuery($query));
        }
        return $retval;
    }
    /**
     * Returns the number of functions present inside this database
     *
     * @param string $searchClause A string used to filter the results of
     *                             the query
     * @param bool   $singleItem   Whether to get presence of a single known
     *                             item or false in none
     *
     * @return int
     */
    private function getFunctionCount($searchClause, $singleItem)
    {
        global $dbi;
        $db = $this->realName;
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $db = $dbi->escapeString($db);
            $query = 'SELECT COUNT(*) ';
            $query .= 'FROM `INFORMATION_SCHEMA`.`ROUTINES` ';
            $query .= 'WHERE `ROUTINE_SCHEMA` ' . Util::getCollateForIS() . "='" . $db . "' ";
            $query .= "AND `ROUTINE_TYPE`='FUNCTION' ";
            if (!empty($searchClause)) {
                $query .= 'AND ' . $this->getWhereClauseForSearch($searchClause, $singleItem, 'ROUTINE_NAME');
            }
            $retval = (int) $dbi->fetchValue($query);
        } else {
            $db = $dbi->escapeString($db);
            $query = "SHOW FUNCTION STATUS WHERE `Db`='" . $db . "' ";
            if (!empty($searchClause)) {
                $query .= 'AND ' . $this->getWhereClauseForSearch($searchClause, $singleItem, 'Name');
            }
            $retval = $dbi->numRows($dbi->tryQuery($query));
        }
        return $retval;
    }
    /**
     * Returns the number of events present inside this database
     *
     * @param string $searchClause A string used to filter the results of
     *                             the query
     * @param bool   $singleItem   Whether to get presence of a single known
     *                             item or false in none
     *
     * @return int
     */
    private function getEventCount($searchClause, $singleItem)
    {
        global $dbi;
        $db = $this->realName;
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $db = $dbi->escapeString($db);
            $query = 'SELECT COUNT(*) ';
            $query .= 'FROM `INFORMATION_SCHEMA`.`EVENTS` ';
            $query .= 'WHERE `EVENT_SCHEMA` ' . Util::getCollateForIS() . "='" . $db . "' ";
            if (!empty($searchClause)) {
                $query .= 'AND ' . $this->getWhereClauseForSearch($searchClause, $singleItem, 'EVENT_NAME');
            }
            $retval = (int) $dbi->fetchValue($query);
        } else {
            $db = Util::backquote($db);
            $query = 'SHOW EVENTS FROM ' . $db . ' ';
            if (!empty($searchClause)) {
                $query .= 'WHERE ' . $this->getWhereClauseForSearch($searchClause, $singleItem, 'Name');
            }
            $retval = $dbi->numRows($dbi->tryQuery($query));
        }
        return $retval;
    }
    /**
     * Returns the WHERE clause for searching inside a database
     *
     * @param string $searchClause A string used to filter the results of the query
     * @param bool   $singleItem   Whether to get presence of a single known item
     * @param string $columnName   Name of the column in the result set to match
     *
     * @return string WHERE clause for searching
     */
    private function getWhereClauseForSearch($searchClause, $singleItem, $columnName)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getWhereClauseForSearch") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php at line 263")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getWhereClauseForSearch:263@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns the names of children of type $type present inside this container
     * This method is overridden by the PhpMyAdmin\Navigation\Nodes\NodeDatabase
     * and PhpMyAdmin\Navigation\Nodes\NodeTable classes
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
        $pos = (int) $pos;
        $retval = [];
        switch ($type) {
            case 'tables':
                $retval = $this->getTables($pos, $searchClause);
                break;
            case 'views':
                $retval = $this->getViews($pos, $searchClause);
                break;
            case 'procedures':
                $retval = $this->getProcedures($pos, $searchClause);
                break;
            case 'functions':
                $retval = $this->getFunctions($pos, $searchClause);
                break;
            case 'events':
                $retval = $this->getEvents($pos, $searchClause);
                break;
            default:
                break;
        }
        // Remove hidden items so that they are not displayed in navigation tree
        $cfgRelation = $this->relation->getRelationsParam();
        if ($cfgRelation['navwork']) {
            $hiddenItems = $this->getHiddenItems(substr($type, 0, -1));
            foreach ($retval as $key => $item) {
                if (!in_array($item, $hiddenItems)) {
                    continue;
                }
                unset($retval[$key]);
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
        global $dbi;
        $db = $this->realName;
        $cfgRelation = $this->relation->getRelationsParam();
        if (!$cfgRelation['navwork']) {
            return [];
        }
        $navTable = Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['navigationhiding']);
        $sqlQuery = 'SELECT `item_name` FROM ' . $navTable . " WHERE `username`='" . $cfgRelation['user'] . "'" . " AND `item_type`='" . $type . "' AND `db_name`='" . $dbi->escapeString($db) . "'";
        $result = $this->relation->queryAsControlUser($sqlQuery, false);
        $hiddenItems = [];
        if ($result) {
            while ($row = $dbi->fetchArray($result)) {
                $hiddenItems[] = $row[0];
            }
        }
        $dbi->freeResult($result);
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
    private function getTablesOrViews($which, int $pos, $searchClause)
    {
        global $dbi;
        if ($which === 'tables') {
            $condition = 'IN';
        } else {
            $condition = 'NOT IN';
        }
        $maxItems = $GLOBALS['cfg']['MaxNavigationItems'];
        $retval = [];
        $db = $this->realName;
        if (!$GLOBALS['cfg']['Server']['DisableIS']) {
            $escdDb = $dbi->escapeString($db);
            $query = 'SELECT `TABLE_NAME` AS `name` ';
            $query .= 'FROM `INFORMATION_SCHEMA`.`TABLES` ';
            $query .= "WHERE `TABLE_SCHEMA`='" . $escdDb . "' ";
            $query .= 'AND `TABLE_TYPE`' . $condition . "('BASE TABLE', 'SYSTEM VERSIONED') ";
            if (!empty($searchClause)) {
                $query .= "AND `TABLE_NAME` LIKE '%";
                $query .= $dbi->escapeString($searchClause);
                $query .= "%'";
            }
            $query .= 'ORDER BY `TABLE_NAME` ASC ';
            $query .= 'LIMIT ' . $pos . ', ' . $maxItems;
            $retval = $dbi->fetchResult($query);
        } else {
            $query = ' SHOW FULL TABLES FROM ';
            $query .= Util::backquote($db);
            $query .= ' WHERE `Table_type`' . $condition . "('BASE TABLE', 'SYSTEM VERSIONED') ";
            if (!empty($searchClause)) {
                $query .= 'AND ' . Util::backquote('Tables_in_' . $db);
                $query .= " LIKE '%" . $dbi->escapeString($searchClause);
                $query .= "%'";
            }
            $handle = $dbi->tryQuery($query);
            if ($handle !== false) {
                $count = 0;
                if ($dbi->dataSeek($handle, $pos)) {
                    while ($arr = $dbi->fetchArray($handle)) {
                        if ($count >= $maxItems) {
                            break;
                        }
                        $retval[] = $arr[0];
                        $count++;
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
    private function getTables(int $pos, $searchClause)
    {
        return $this->getTablesOrViews('tables', $pos, $searchClause);
    }
    /**
     * Returns the list of views inside this database
     *
     * @param int    $pos          The offset of the list within the results
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return array
     */
    private function getViews(int $pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getViews") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php at line 431")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getViews:431@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php');
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
    private function getRoutines($routineType, $pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getRoutines") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php at line 444")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getRoutines:444@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php');
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
    private function getProcedures($pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getProcedures") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php at line 496")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getProcedures:496@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php');
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
    private function getFunctions($pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFunctions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php at line 508")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFunctions:508@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php');
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
    private function getEvents($pos, $searchClause)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEvents") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php at line 520")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getEvents:520@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns HTML for control buttons displayed infront of a node
     *
     * @return string HTML for control buttons
     */
    public function getHtmlForControlButtons() : string
    {
        $ret = '';
        $cfgRelation = $this->relation->getRelationsParam();
        if ($cfgRelation['navwork']) {
            if ($this->hiddenCount > 0) {
                $params = ['showUnhideDialog' => true, 'dbName' => $this->realName];
                $ret = '<span class="dbItemControls">' . '<a href="' . Url::getFromRoute('/navigation') . '" data-post="' . Url::getCommon($params, '') . '"' . ' class="showUnhide ajax">' . Generator::getImage('show', __('Show hidden items')) . '</a></span>';
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setHiddenCount") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php at line 587")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setHiddenCount:587@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Navigation/Nodes/NodeDatabase.php');
        die();
    }
    /**
     * Returns the number of hidden items in this database
     *
     * @return int hidden item count
     */
    public function getHiddenCount()
    {
        return $this->hiddenCount;
    }
}