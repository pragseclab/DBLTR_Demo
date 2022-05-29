<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * This class is responsible for instantiating
 * the various components of the navigation panel
 *
 * @package PhpMyAdmin-navigation
 */
namespace PMA\libraries\navigation;

use PMA\libraries\config\PageSettings;
use PMA\libraries\Message;
use PMA\libraries\Response;
use PMA\libraries\Util;
use PMA\libraries\URL;
/**
 * The navigation panel - displays server, db and table selection tree
 *
 * @package PhpMyAdmin-Navigation
 */
class Navigation
{
    /**
     * Renders the navigation tree, or part of it
     *
     * @return string The navigation tree
     */
    public function getDisplay()
    {
        /* Init */
        $retval = '';
        $response = Response::getInstance();
        if (!$response->isAjax()) {
            $header = new NavigationHeader();
            $retval = $header->getDisplay();
        }
        $tree = new NavigationTree();
        if (!$response->isAjax() || !empty($_REQUEST['full']) || !empty($_REQUEST['reload'])) {
            if ($GLOBALS['cfg']['ShowDatabasesNavigationAsTree']) {
                // provide database tree in navigation
                $navRender = $tree->renderState();
            } else {
                // provide legacy pre-4.0 navigation
                $navRender = $tree->renderDbSelect();
            }
        } else {
            $navRender = $tree->renderPath();
        }
        if (!$navRender) {
            $retval .= Message::error(__('An error has occurred while loading the navigation display'))->getDisplay();
        } else {
            $retval .= $navRender;
        }
        if (!$response->isAjax()) {
            // closes the tags that were opened by the navigation header
            $retval .= '</div>';
            // pma_navigation_tree
            $retval .= '<div id="pma_navi_settings_container">';
            if (!defined('PMA_DISABLE_NAVI_SETTINGS')) {
                $retval .= PageSettings::getNaviSettings();
            }
            $retval .= '</div>';
            //pma_navi_settings_container
            $retval .= '</div>';
            // pma_navigation_content
            $retval .= $this->_getDropHandler();
            $retval .= '</div>';
            // pma_navigation
        }
        return $retval;
    }
    /**
     * Add an item of navigation tree to the hidden items list in PMA database.
     *
     * @param string $itemName  name of the navigation tree item
     * @param string $itemType  type of the navigation tree item
     * @param string $dbName    database name
     * @param string $tableName table name if applicable
     *
     * @return void
     */
    public function hideNavigationItem($itemName, $itemType, $dbName, $tableName = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hideNavigationItem") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/Navigation.php at line 90")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hideNavigationItem:90@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/Navigation.php');
        die();
    }
    /**
     * Inserts Drag and Drop Import handler
     *
     * @return string html code for drop handler
     */
    private function _getDropHandler()
    {
        $retval = '';
        $retval .= '<div class="pma_drop_handler">' . __('Drop files here') . '</div>';
        $retval .= '<div class="pma_sql_import_status">';
        $retval .= '<h2>SQL upload ( ';
        $retval .= '<span class="pma_import_count">0</span> ';
        $retval .= ') <span class="close">x</span>';
        $retval .= '<span class="minimize">-</span></h2>';
        $retval .= '<div></div>';
        $retval .= '</div>';
        return $retval;
    }
    /**
     * Remove a hidden item of navigation tree from the
     * list of hidden items in PMA database.
     *
     * @param string $itemName  name of the navigation tree item
     * @param string $itemType  type of the navigation tree item
     * @param string $dbName    database name
     * @param string $tableName table name if applicable
     *
     * @return void
     */
    public function unhideNavigationItem($itemName, $itemType, $dbName, $tableName = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unhideNavigationItem") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/Navigation.php at line 139")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called unhideNavigationItem:139@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/Navigation.php');
        die();
    }
    /**
     * Returns HTML for the dialog to show hidden navigation items.
     *
     * @param string $dbName    database name
     * @param string $itemType  type of the items to include
     * @param string $tableName table name
     *
     * @return string HTML for the dialog to show hidden navigation items
     */
    public function getItemUnhideDialog($dbName, $itemType = null, $tableName = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getItemUnhideDialog") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/Navigation.php at line 166")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getItemUnhideDialog:166@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/navigation/Navigation.php');
        die();
    }
}