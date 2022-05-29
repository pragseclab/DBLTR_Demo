<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Functionality for the navigation tree
 *
 * @package PhpMyAdmin-Navigation
 */
namespace PMA\libraries\navigation\nodes;

use PMA\libraries\Util;
/**
 * Represents a columns node in the navigation tree
 *
 * @package PhpMyAdmin-Navigation
 */
class NodeTable extends NodeDatabaseChild
{
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
        $this->icon = array();
        $this->_addIcon(Util::getScriptNameForOption($GLOBALS['cfg']['NavigationTreeDefaultTabTable'], 'table'));
        $this->_addIcon(Util::getScriptNameForOption($GLOBALS['cfg']['NavigationTreeDefaultTabTable2'], 'table'));
        $title = Util::getTitleForTarget($GLOBALS['cfg']['DefaultTabTable']);
        $this->title = $title;
        $script_name = Util::getScriptNameForOption($GLOBALS['cfg']['DefaultTabTable'], 'table');
        $this->links = array('text' => $script_name . '?server=' . $GLOBALS['server'] . '&amp;db=%2$s&amp;table=%1$s' . '&amp;pos=0', 'icon' => array(Util::getScriptNameForOption($GLOBALS['cfg']['NavigationTreeDefaultTabTable'], 'table') . '?server=' . $GLOBALS['server'] . '&amp;db=%2$s&amp;table=%1$s', Util::getScriptNameForOption($GLOBALS['cfg']['NavigationTreeDefaultTabTable2'], 'table') . '?server=' . $GLOBALS['server'] . '&amp;db=%2$s&amp;table=%1$s'), 'title' => $this->title);
        $this->classes = 'table';
    }
    /**
     * Returns the number of children of type $type present inside this container
     * This method is overridden by the PMA\libraries\navigation\nodes\NodeDatabase
     * and PMA\libraries\navigation\nodes\NodeTable classes
     *
     * @param string $type         The type of item we are looking for
     *                             ('columns' or 'indexes')
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return int
     */
    public function getPresence($type = '', $searchClause = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPresence") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/nodes/NodeTable.php at line 89")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPresence:89@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/nodes/NodeTable.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getData") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/nodes/NodeTable.php at line 160")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getData:160@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/nodes/NodeTable.php');
        die();
    }
    /**
     * Returns the type of the item represented by the node.
     *
     * @return string type of the item
     */
    protected function getItemType()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getItemType") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/nodes/NodeTable.php at line 270")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getItemType:270@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/nodes/NodeTable.php');
        die();
    }
    /**
     * Add an icon to navigation tree
     *
     * @param string $page Page name to redirect
     *
     * @return void
     */
    private function _addIcon($page)
    {
        if (empty($page)) {
            return;
        }
        switch ($page) {
            case 'tbl_structure.php':
                $this->icon[] = Util::getImage('b_props.png', __('Structure'));
                break;
            case 'tbl_select.php':
                $this->icon[] = Util::getImage('b_search.png', __('Search'));
                break;
            case 'tbl_change.php':
                $this->icon[] = Util::getImage('b_insrow.png', __('Insert'));
                break;
            case 'tbl_sql.php':
                $this->icon[] = Util::getImage('b_sql.png', __('SQL'));
                break;
            case 'sql.php':
                $this->icon[] = Util::getImage('b_browse.png', __('Browse'));
                break;
        }
    }
}