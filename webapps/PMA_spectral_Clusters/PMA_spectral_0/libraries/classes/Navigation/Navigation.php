<?php

/**
 * This class is responsible for instantiating
 * the various components of the navigation panel
 */
declare (strict_types=1);
namespace PhpMyAdmin\Navigation;

use PhpMyAdmin\Config\PageSettings;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Relation;
use PhpMyAdmin\Response;
use PhpMyAdmin\Sanitize;
use PhpMyAdmin\Server\Select;
use PhpMyAdmin\Template;
use PhpMyAdmin\Theme;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use const PHP_URL_HOST;
use function count;
use function defined;
use function file_exists;
use function is_bool;
use function parse_url;
use function strpos;
use function trim;
/**
 * The navigation panel - displays server, db and table selection tree
 */
class Navigation
{
    /** @var Template */
    private $template;
    /** @var Relation */
    private $relation;
    /** @var DatabaseInterface */
    private $dbi;
    /** @var NavigationTree */
    private $tree;
    /**
     * @param Template          $template Template instance
     * @param Relation          $relation Relation instance
     * @param DatabaseInterface $dbi      DatabaseInterface instance
     */
    public function __construct($template, $relation, $dbi)
    {
        $this->template = $template;
        $this->relation = $relation;
        $this->dbi = $dbi;
        $this->tree = new NavigationTree($this->template, $this->dbi);
    }
    /**
     * Renders the navigation tree, or part of it
     *
     * @return string The navigation tree
     */
    public function getDisplay() : string
    {
        global $cfg;
        $logo = ['is_displayed' => $cfg['NavigationDisplayLogo'], 'has_link' => false, 'link' => '#', 'attributes' => ' target="_blank" rel="noopener noreferrer"', 'source' => ''];
        $response = Response::getInstance();
        if (!$response->isAjax()) {
            $logo['source'] = $this->getLogoSource();
            $logo['has_link'] = (string) $cfg['NavigationLogoLink'] !== '';
            $logo['link'] = trim((string) $cfg['NavigationLogoLink']);
            if (!Sanitize::checkLink($logo['link'], true)) {
                $logo['link'] = 'index.php';
            }
            if ($cfg['NavigationLogoLinkWindow'] === 'main') {
                if (empty(parse_url($logo['link'], PHP_URL_HOST))) {
                    $hasStartChar = strpos($logo['link'], '?');
                    $logo['link'] .= Url::getCommon([], is_bool($hasStartChar) ? '?' : Url::getArgSeparator());
                }
                $logo['attributes'] = '';
            }
            if ($cfg['NavigationDisplayServers'] && count($cfg['Servers']) > 1) {
                $serverSelect = Select::render(true, true);
            }
            if (!defined('PMA_DISABLE_NAVI_SETTINGS')) {
                $pageSettings = new PageSettings('Navi', 'pma_navigation_settings');
                $response->addHTML($pageSettings->getErrorHTML());
                $navigationSettings = $pageSettings->getHTML();
            }
        }
        if (!$response->isAjax() || !empty($_POST['full']) || !empty($_POST['reload'])) {
            if ($cfg['ShowDatabasesNavigationAsTree']) {
                // provide database tree in navigation
                $navRender = $this->tree->renderState();
            } else {
                // provide legacy pre-4.0 navigation
                $navRender = $this->tree->renderDbSelect();
            }
        } else {
            $navRender = $this->tree->renderPath();
        }
        return $this->template->render('navigation/main', ['is_ajax' => $response->isAjax(), 'logo' => $logo, 'is_synced' => $cfg['NavigationLinkWithMainPanel'], 'is_highlighted' => $cfg['NavigationTreePointerEnable'], 'is_autoexpanded' => $cfg['NavigationTreeAutoexpandSingleDb'], 'server' => $GLOBALS['server'], 'auth_type' => $cfg['Server']['auth_type'], 'is_servers_displayed' => $cfg['NavigationDisplayServers'], 'servers' => $cfg['Servers'], 'server_select' => $serverSelect ?? '', 'navigation_tree' => $navRender, 'is_navigation_settings_enabled' => !defined('PMA_DISABLE_NAVI_SETTINGS'), 'navigation_settings' => $navigationSettings ?? '', 'is_drag_drop_import_enabled' => $cfg['enable_drag_drop_import'] === true, 'is_mariadb' => $this->dbi->isMariaDB()]);
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hideNavigationItem") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Navigation/Navigation.php at line 111")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hideNavigationItem:111@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Navigation/Navigation.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unhideNavigationItem") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Navigation/Navigation.php at line 128")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called unhideNavigationItem:128@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Navigation/Navigation.php');
        die();
    }
    /**
     * Returns HTML for the dialog to show hidden navigation items.
     *
     * @param string $database database name
     * @param string $itemType type of the items to include
     * @param string $table    table name
     *
     * @return string HTML for the dialog to show hidden navigation items
     */
    public function getItemUnhideDialog($database, $itemType = null, $table = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getItemUnhideDialog") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Navigation/Navigation.php at line 143")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getItemUnhideDialog:143@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Navigation/Navigation.php');
        die();
    }
    /**
     * @param string      $database Database name
     * @param string|null $table    Table name
     *
     * @return array
     */
    private function getHiddenItems(string $database, ?string $table) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHiddenItems") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Navigation/Navigation.php at line 155")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHiddenItems:155@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Navigation/Navigation.php');
        die();
    }
    /**
     * @return string Logo source
     */
    private function getLogoSource() : string
    {
        /** @var Theme|null $PMA_Theme */
        global $PMA_Theme;
        if ($PMA_Theme !== null) {
            if (@file_exists($PMA_Theme->getFsPath() . 'img/logo_left.png')) {
                return $PMA_Theme->getPath() . '/img/logo_left.png';
            }
            if (@file_exists($PMA_Theme->getFsPath() . 'img/pma_logo2.png')) {
                return $PMA_Theme->getPath() . '/img/pma_logo2.png';
            }
        }
        return '';
    }
}