<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Represents container node that carries children of a database
 *
 * @package PhpMyAdmin-Navigation
 */
namespace PMA\libraries\navigation\nodes;

/**
 * Represents container node that carries children of a database
 *
 * @package PhpMyAdmin-Navigation
 */
abstract class NodeDatabaseChildContainer extends NodeDatabaseChild
{
    /**
     * Initialises the class by setting the common variables
     *
     * @param string $name An identifier for the new node
     * @param int    $type Type of node, may be one of CONTAINER or OBJECT
     */
    public function __construct($name, $type = Node::OBJECT)
    {
        parent::__construct($name, $type);
        if ($GLOBALS['cfg']['NavigationTreeEnableGrouping']) {
            $this->separator = $GLOBALS['cfg']['NavigationTreeTableSeparator'];
            $this->separator_depth = (int) $GLOBALS['cfg']['NavigationTreeTableLevel'];
        }
    }
    /**
     * Returns the type of the item represented by the node.
     *
     * @return string type of the item
     */
    protected function getItemType()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getItemType") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabaseChildContainer.php at line 41")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getItemType:41@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/navigation/nodes/NodeDatabaseChildContainer.php');
        die();
    }
}