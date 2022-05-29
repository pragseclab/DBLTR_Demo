<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Recent and Favorite table list handling
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PMA\libraries\URL;
/**
 * Handles the recently used and favorite tables.
 *
 * @TODO Change the release version in table pma_recent
 * (#recent in documentation)
 *
 * @package PhpMyAdmin
 */
class RecentFavoriteTable
{
    /**
     * Reference to session variable containing recently used or favorite tables.
     *
     * @access private
     * @var array
     */
    private $_tables;
    /**
     * Defines type of action, Favorite or Recent table.
     *
     * @access private
     * @var string
     */
    private $_tableType;
    /**
     * RecentFavoriteTable instances.
     *
     * @access private
     * @var array
     */
    private static $_instances = array();
    /**
     * Creates a new instance of RecentFavoriteTable
     *
     * @param string $type the table type
     *
     * @access private
     */
    private function __construct($type)
    {
        $this->_tableType = $type;
        $server_id = $GLOBALS['server'];
        if (!isset($_SESSION['tmpval'][$this->_tableType . '_tables'][$server_id])) {
            $_SESSION['tmpval'][$this->_tableType . '_tables'][$server_id] = $this->_getPmaTable() ? $this->getFromDb() : array();
        }
        $this->_tables =& $_SESSION['tmpval'][$this->_tableType . '_tables'][$server_id];
    }
    /**
     * Returns class instance.
     *
     * @param string $type the table type
     *
     * @return RecentFavoriteTable
     */
    public static function getInstance($type)
    {
        if (!array_key_exists($type, self::$_instances)) {
            self::$_instances[$type] = new RecentFavoriteTable($type);
        }
        return self::$_instances[$type];
    }
    /**
     * Returns the recent/favorite tables array
     *
     * @return array
     */
    public function getTables()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTables") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php at line 88")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTables:88@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php');
        die();
    }
    /**
     * Returns recently used tables or favorite from phpMyAdmin database.
     *
     * @return array
     */
    public function getFromDb()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFromDb") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php at line 99")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFromDb:99@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php');
        die();
    }
    /**
     * Save recent/favorite tables into phpMyAdmin database.
     *
     * @return true|Message
     */
    public function saveToDb()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("saveToDb") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php at line 121")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called saveToDb:121@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php');
        die();
    }
    /**
     * Trim recent.favorite table according to the
     * NumRecentTables/NumFavoriteTables configuration.
     *
     * @return boolean True if trimming occurred
     */
    public function trim()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("trim") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php at line 162")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called trim:162@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php');
        die();
    }
    /**
     * Return HTML ul.
     *
     * @return string
     */
    public function getHtmlList()
    {
        $html = '';
        if (count($this->_tables)) {
            if ($this->_tableType == 'recent') {
                foreach ($this->_tables as $table) {
                    $html .= '<li class="warp_link">';
                    $recent_params = array('db' => $table['db'], 'table' => $table['table']);
                    $recent_url = 'tbl_recent_favorite.php' . URL::getCommon($recent_params);
                    $html .= '<a href="' . $recent_url . '">`' . htmlspecialchars($table['db']) . '`.`' . htmlspecialchars($table['table']) . '`</a>';
                    $html .= '</li>';
                }
            } else {
                foreach ($this->_tables as $table) {
                    $html .= '<li class="warp_link">';
                    $html .= '<a class="ajax favorite_table_anchor" ';
                    $fav_params = array('db' => $table['db'], 'ajax_request' => true, 'favorite_table' => $table['table'], 'remove_favorite' => true);
                    $fav_rm_url = 'db_structure.php' . URL::getCommon($fav_params);
                    $html .= 'href="' . $fav_rm_url . '" title="' . __("Remove from Favorites") . '" data-favtargetn="' . md5($table['db'] . "." . $table['table']) . '" >' . Util::getIcon('b_favorite.png') . '</a>';
                    $fav_params = array('db' => $table['db'], 'table' => $table['table']);
                    $table_url = 'tbl_recent_favorite.php' . URL::getCommon($fav_params);
                    $html .= '<a href="' . $table_url . '">`' . htmlspecialchars($table['db']) . '`.`' . htmlspecialchars($table['table']) . '`</a>';
                    $html .= '</li>';
                }
            }
        } else {
            $html .= '<li class="warp_link">' . ($this->_tableType == 'recent' ? __('There are no recent tables.') : __('There are no favorite tables.')) . '</li>';
        }
        return $html;
    }
    /**
     * Return HTML.
     *
     * @return string
     */
    public function getHtml()
    {
        $html = '<div class="drop_list">';
        if ($this->_tableType == 'recent') {
            $html .= '<span title="' . __('Recent tables') . '" class="drop_button">' . __('Recent') . '</span><ul id="pma_recent_list">';
        } else {
            $html .= '<span title="' . __('Favorite tables') . '" class="drop_button">' . __('Favorites') . '</span><ul id="pma_favorite_list">';
        }
        $html .= $this->getHtmlList();
        $html .= '</ul></div>';
        return $html;
    }
    /**
     * Add recently used or favorite tables.
     *
     * @param string $db    database name where the table is located
     * @param string $table table name
     *
     * @return true|Message True if success, Message if not
     */
    public function add($db, $table)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php at line 271")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add:271@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php');
        die();
    }
    /**
     * Removes recent/favorite tables that don't exist.
     *
     * @param string $db    database
     * @param string $table table
     *
     * @return boolean|Message True if invalid and removed, False if not invalid,
     *                            Message if error while removing
     */
    public function removeIfInvalid($db, $table)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("removeIfInvalid") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php at line 302")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called removeIfInvalid:302@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php');
        die();
    }
    /**
     * Remove favorite tables.
     *
     * @param string $db    database name where the table is located
     * @param string $table table name
     *
     * @return true|Message True if success, Message if not
     */
    public function remove($db, $table)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php at line 323")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove:323@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php');
        die();
    }
    /**
     * Generate Html for sync Favorite tables anchor. (from localStorage to pmadb)
     *
     * @return string
     */
    public function getHtmlSyncFavoriteTables()
    {
        $retval = '';
        $server_id = $GLOBALS['server'];
        if ($server_id == 0) {
            return '';
        }
        $cfgRelation = PMA_getRelationsParam();
        // Not to show this once list is synchronized.
        if ($cfgRelation['favoritework'] && !isset($_SESSION['tmpval']['favorites_synced'][$server_id])) {
            $params = array('ajax_request' => true, 'favorite_table' => true, 'sync_favorite_tables' => true);
            $url = 'db_structure.php' . URL::getCommon($params);
            $retval = '<a class="hide" id="sync_favorite_tables"';
            $retval .= ' href="' . $url . '"></a>';
        }
        return $retval;
    }
    /**
     * Generate Html to update recent tables.
     *
     * @return string html
     */
    public static function getHtmlUpdateRecentTables()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlUpdateRecentTables") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php at line 368")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlUpdateRecentTables:368@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/RecentFavoriteTable.php');
        die();
    }
    /**
     * Reutrn the name of the configuration storage table
     *
     * @return string pma table name
     */
    private function _getPmaTable()
    {
        $cfgRelation = PMA_getRelationsParam();
        if (!empty($cfgRelation['db']) && !empty($cfgRelation[$this->_tableType])) {
            return Util::backquote($cfgRelation['db']) . "." . Util::backquote($cfgRelation[$this->_tableType]);
        }
        return null;
    }
}