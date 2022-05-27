<?php

/**
 * Recent and Favorite table list handling
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Html\Generator;
use const SORT_REGULAR;
use function array_key_exists;
use function array_merge;
use function array_pop;
use function array_unique;
use function array_unshift;
use function count;
use function htmlspecialchars;
use function json_decode;
use function json_encode;
use function max;
use function md5;
use function ucfirst;
/**
 * Handles the recently used and favorite tables.
 *
 * @TODO Change the release version in table pma_recent
 * (#recent in documentation)
 */
class RecentFavoriteTable
{
    /**
     * Reference to session variable containing recently used or favorite tables.
     *
     * @access private
     * @var array
     */
    private $tables;
    /**
     * Defines type of action, Favorite or Recent table.
     *
     * @access private
     * @var string
     */
    private $tableType;
    /**
     * RecentFavoriteTable instances.
     *
     * @access private
     * @var array
     */
    private static $instances = [];
    /** @var Relation */
    private $relation;
    /**
     * Creates a new instance of RecentFavoriteTable
     *
     * @param string $type the table type
     *
     * @access private
     */
    private function __construct($type)
    {
        global $dbi;
        $this->relation = new Relation($dbi);
        $this->tableType = $type;
        $server_id = $GLOBALS['server'];
        if (!isset($_SESSION['tmpval'][$this->tableType . 'Tables'][$server_id])) {
            $_SESSION['tmpval'][$this->tableType . 'Tables'][$server_id] = $this->getPmaTable() ? $this->getFromDb() : [];
        }
        $this->tables =& $_SESSION['tmpval'][$this->tableType . 'Tables'][$server_id];
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
        if (!array_key_exists($type, self::$instances)) {
            self::$instances[$type] = new RecentFavoriteTable($type);
        }
        return self::$instances[$type];
    }
    /**
     * Returns the recent/favorite tables array
     *
     * @return array
     */
    public function getTables()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php at line 93")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTables:93@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php');
        die();
    }
    /**
     * Returns recently used tables or favorite from phpMyAdmin database.
     *
     * @return array
     */
    public function getFromDb()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFromDb") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php at line 102")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFromDb:102@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php');
        die();
    }
    /**
     * Save recent/favorite tables into phpMyAdmin database.
     *
     * @return true|Message
     */
    public function saveToDb()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("saveToDb") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php at line 122")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called saveToDb:122@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php');
        die();
    }
    /**
     * Trim recent.favorite table according to the
     * NumRecentTables/NumFavoriteTables configuration.
     *
     * @return bool True if trimming occurred
     */
    public function trim()
    {
        $max = max($GLOBALS['cfg']['Num' . ucfirst($this->tableType) . 'Tables'], 0);
        $trimming_occurred = count($this->tables) > $max;
        while (count($this->tables) > $max) {
            array_pop($this->tables);
        }
        return $trimming_occurred;
    }
    /**
     * Return HTML ul.
     *
     * @return string
     */
    public function getHtmlList()
    {
        $html = '';
        if (count($this->tables)) {
            if ($this->tableType === 'recent') {
                foreach ($this->tables as $table) {
                    $html .= '<li class="warp_link">';
                    $recent_url = Url::getFromRoute('/table/recent-favorite', ['db' => $table['db'], 'table' => $table['table']]);
                    $html .= '<a href="' . $recent_url . '">`' . htmlspecialchars($table['db']) . '`.`' . htmlspecialchars($table['table']) . '`</a>';
                    $html .= '</li>';
                }
            } else {
                foreach ($this->tables as $table) {
                    $html .= '<li class="warp_link">';
                    $html .= '<a class="ajax favorite_table_anchor" ';
                    $fav_rm_url = Url::getFromRoute('/database/structure/favorite-table', ['db' => $table['db'], 'ajax_request' => true, 'favorite_table' => $table['table'], 'remove_favorite' => true]);
                    $html .= 'href="' . $fav_rm_url . '" title="' . __('Remove from Favorites') . '" data-favtargetn="' . md5($table['db'] . '.' . $table['table']) . '" >' . Generator::getIcon('b_favorite') . '</a>';
                    $table_url = Url::getFromRoute('/table/recent-favorite', ['db' => $table['db'], 'table' => $table['table']]);
                    $html .= '<a href="' . $table_url . '">`' . htmlspecialchars($table['db']) . '`.`' . htmlspecialchars($table['table']) . '`</a>';
                    $html .= '</li>';
                }
            }
        } else {
            $html .= '<li class="warp_link">' . ($this->tableType === 'recent' ? __('There are no recent tables.') : __('There are no favorite tables.')) . '</li>';
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
        if ($this->tableType === 'recent') {
            $html .= '<button title="' . __('Recent tables') . '" class="drop_button btn">' . __('Recent') . '</button><ul id="pma_recent_list">';
        } else {
            $html .= '<button title="' . __('Favorite tables') . '" class="drop_button btn">' . __('Favorites') . '</button><ul id="pma_favorite_list">';
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
        global $dbi;
        // If table does not exist, do not add._getPmaTable()
        if (!$dbi->getColumns($db, $table)) {
            return true;
        }
        $table_arr = [];
        $table_arr['db'] = $db;
        $table_arr['table'] = $table;
        // add only if this is new table
        if (!isset($this->tables[0]) || $this->tables[0] != $table_arr) {
            array_unshift($this->tables, $table_arr);
            $this->tables = array_merge(array_unique($this->tables, SORT_REGULAR));
            $this->trim();
            if ($this->getPmaTable()) {
                return $this->saveToDb();
            }
        }
        return true;
    }
    /**
     * Removes recent/favorite tables that don't exist.
     *
     * @param string $db    database
     * @param string $table table
     *
     * @return bool|Message True if invalid and removed, False if not invalid,
     * Message if error while removing
     */
    public function removeIfInvalid($db, $table)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("removeIfInvalid") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php at line 246")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called removeIfInvalid:246@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php at line 268")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove:268@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/RecentFavoriteTable.php');
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
        $cfgRelation = $this->relation->getRelationsParam();
        // Not to show this once list is synchronized.
        if ($cfgRelation['favoritework'] && !isset($_SESSION['tmpval']['favorites_synced'][$server_id])) {
            $url = Url::getFromRoute('/database/structure/favorite-table', ['ajax_request' => true, 'favorite_table' => true, 'sync_favorite_tables' => true]);
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
        $retval = '<a class="hide" id="update_recent_tables" href="';
        $retval .= Url::getFromRoute('/recent-table', ['ajax_request' => true, 'recent_table' => true]);
        $retval .= '"></a>';
        return $retval;
    }
    /**
     * Return the name of the configuration storage table
     *
     * @return string|null pma table name
     */
    private function getPmaTable() : ?string
    {
        $cfgRelation = $this->relation->getRelationsParam();
        if (!$cfgRelation['recentwork']) {
            return null;
        }
        if (!empty($cfgRelation['db']) && !empty($cfgRelation[$this->tableType])) {
            return Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation[$this->tableType]);
        }
        return null;
    }
}