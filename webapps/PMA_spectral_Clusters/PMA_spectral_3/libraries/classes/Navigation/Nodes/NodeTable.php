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
/**
 * Represents a columns node in the navigation tree
 */
class NodeTable extends NodeDatabaseChild
{
    /** @var array IMG tags, used when rendering the node */
    public $icon;
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
        $this->icon = [];
        $this->addIcon(Util::getScriptNameForOption($GLOBALS['cfg']['NavigationTreeDefaultTabTable'], 'table'));
        $this->addIcon(Util::getScriptNameForOption($GLOBALS['cfg']['NavigationTreeDefaultTabTable2'], 'table'));
        $title = (string) Util::getTitleForTarget($GLOBALS['cfg']['DefaultTabTable']);
        $this->title = $title;
        $scriptName = Util::getScriptNameForOption($GLOBALS['cfg']['DefaultTabTable'], 'table');
        $firstIconLink = Util::getScriptNameForOption($GLOBALS['cfg']['NavigationTreeDefaultTabTable'], 'table');
        $secondIconLink = Util::getScriptNameForOption($GLOBALS['cfg']['NavigationTreeDefaultTabTable2'], 'table');
        $this->links = ['text' => $scriptName . (strpos($scriptName, '?') === false ? '?' : '&') . 'server=' . $GLOBALS['server'] . '&amp;db=%2$s&amp;table=%1$s' . '&amp;pos=0', 'icon' => [$firstIconLink . (strpos($firstIconLink, '?') === false ? '?' : '&') . 'server=' . $GLOBALS['server'] . '&amp;db=%2$s&amp;table=%1$s', $secondIconLink . (strpos($secondIconLink, '?') === false ? '?' : '&') . 'server=' . $GLOBALS['server'] . '&amp;db=%2$s&amp;table=%1$s'], 'title' => $this->title];
        $this->classes = 'table';
    }
    /**
     * Returns the number of children of type $type present inside this container
     * This method is overridden by the PhpMyAdmin\Navigation\Nodes\NodeDatabase
     * and PhpMyAdmin\Navigation\Nodes\NodeTable classes
     *
     * @param string $type         The type of item we are looking for
     *                             ('columns' or 'indexes')
     * @param string $searchClause A string used to filter the results of the query
     *
     * @return int
     */
    public function getPresence($type = '', $searchClause = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPresence") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Navigation/Nodes/NodeTable.php at line 57")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPresence:57@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Navigation/Nodes/NodeTable.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getData") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Navigation/Nodes/NodeTable.php at line 119")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getData:119@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Navigation/Nodes/NodeTable.php');
        die();
    }
    /**
     * Returns the type of the item represented by the node.
     *
     * @return string type of the item
     */
    protected function getItemType()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getItemType") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Navigation/Nodes/NodeTable.php at line 223")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getItemType:223@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Navigation/Nodes/NodeTable.php');
        die();
    }
    /**
     * Add an icon to navigation tree
     *
     * @param string $page Page name to redirect
     *
     * @return void
     */
    private function addIcon($page)
    {
        if (empty($page)) {
            return;
        }
        switch ($page) {
            case Url::getFromRoute('/table/structure'):
                $this->icon[] = Generator::getImage('b_props', __('Structure'));
                break;
            case Url::getFromRoute('/table/search'):
                $this->icon[] = Generator::getImage('b_search', __('Search'));
                break;
            case Url::getFromRoute('/table/change'):
                $this->icon[] = Generator::getImage('b_insrow', __('Insert'));
                break;
            case Url::getFromRoute('/table/sql'):
                $this->icon[] = Generator::getImage('b_sql', __('SQL'));
                break;
            case Url::getFromRoute('/sql'):
                $this->icon[] = Generator::getImage('b_browse', __('Browse'));
                break;
        }
    }
}