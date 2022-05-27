<?php

/**
 * Functionality for the navigation tree
 */
declare (strict_types=1);
namespace PhpMyAdmin\Navigation\Nodes;

use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Url;
/**
 * Represents a view node in the navigation tree
 */
class NodeView extends NodeDatabaseChild
{
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
        $this->icon = Generator::getImage('b_props', __('View'));
        $this->links = ['text' => Url::getFromRoute('/sql') . '&amp;server=' . $GLOBALS['server'] . '&amp;db=%2$s&amp;table=%1$s&amp;pos=0', 'icon' => Url::getFromRoute('/table/structure') . '&amp;server=' . $GLOBALS['server'] . '&amp;db=%2$s&amp;table=%1$s'];
        $this->classes = 'view';
    }
    /**
     * Returns the type of the item represented by the node.
     *
     * @return string type of the item
     */
    protected function getItemType()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getItemType") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Navigation/Nodes/NodeView.php at line 38")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getItemType:38@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Navigation/Nodes/NodeView.php');
        die();
    }
}