<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Generates and renders the top menu
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PMA\libraries\URL;
/**
 * Class for generating the top menu
 *
 * @package PhpMyAdmin
 */
class Menu
{
    /**
     * Server id
     *
     * @access private
     * @var int
     */
    private $_server;
    /**
     * Database name
     *
     * @access private
     * @var string
     */
    private $_db;
    /**
     * Table name
     *
     * @access private
     * @var string
     */
    private $_table;
    /**
     * Creates a new instance of Menu
     *
     * @param int    $server Server id
     * @param string $db     Database name
     * @param string $table  Table name
     */
    public function __construct($server, $db, $table)
    {
        $this->_server = $server;
        $this->_db = $db;
        $this->_table = $table;
    }
    /**
     * Prints the menu and the breadcrumbs
     *
     * @return void
     */
    public function display()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("display") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Menu.php at line 62")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called display:62@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Menu.php');
        die();
    }
    /**
     * Returns the menu and the breadcrumbs as a string
     *
     * @return string
     */
    public function getDisplay()
    {
        $retval = $this->_getBreadcrumbs();
        $retval .= $this->_getMenu();
        return $retval;
    }
    /**
     * Returns hash for the menu and the breadcrumbs
     *
     * @return string
     */
    public function getHash()
    {
        return substr(md5($this->_getMenu() . $this->_getBreadcrumbs()), 0, 8);
    }
    /**
     * Returns the menu as HTML
     *
     * @return string HTML formatted menubar
     */
    private function _getMenu()
    {
        $url_params = array('db' => $this->_db);
        if (strlen($this->_table) > 0) {
            $tabs = $this->_getTableTabs();
            $url_params['table'] = $this->_table;
            $level = 'table';
        } else {
            if (strlen($this->_db) > 0) {
                $tabs = $this->_getDbTabs();
                $level = 'db';
            } else {
                $tabs = $this->_getServerTabs();
                $level = 'server';
            }
        }
        $allowedTabs = $this->_getAllowedTabs($level);
        foreach ($tabs as $key => $value) {
            if (!array_key_exists($key, $allowedTabs)) {
                unset($tabs[$key]);
            }
        }
        return Util::getHtmlTabs($tabs, $url_params, 'topmenu', true);
    }
    /**
     * Returns a list of allowed tabs for the current user for the given level
     *
     * @param string $level 'server', 'db' or 'table' level
     *
     * @return array list of allowed tabs
     */
    private function _getAllowedTabs($level)
    {
        $cache_key = 'menu-levels-' . $level;
        if (Util::cacheExists($cache_key)) {
            return Util::cacheGet($cache_key);
        }
        $allowedTabs = Util::getMenuTabList($level);
        $cfgRelation = PMA_getRelationsParam();
        if ($cfgRelation['menuswork']) {
            $groupTable = Util::backquote($cfgRelation['db']) . "." . Util::backquote($cfgRelation['usergroups']);
            $userTable = Util::backquote($cfgRelation['db']) . "." . Util::backquote($cfgRelation['users']);
            $sql_query = "SELECT `tab` FROM " . $groupTable . " WHERE `allowed` = 'N'" . " AND `tab` LIKE '" . $level . "%'" . " AND `usergroup` = (SELECT usergroup FROM " . $userTable . " WHERE `username` = '" . $GLOBALS['dbi']->escapeString($GLOBALS['cfg']['Server']['user']) . "')";
            $result = PMA_queryAsControlUser($sql_query, false);
            if ($result) {
                while ($row = $GLOBALS['dbi']->fetchAssoc($result)) {
                    $tabName = mb_substr($row['tab'], mb_strpos($row['tab'], '_') + 1);
                    unset($allowedTabs[$tabName]);
                }
            }
        }
        Util::cacheSet($cache_key, $allowedTabs);
        return $allowedTabs;
    }
    /**
     * Returns the breadcrumbs as HTML
     *
     * @return string HTML formatted breadcrumbs
     */
    private function _getBreadcrumbs()
    {
        $retval = '';
        $tbl_is_view = $GLOBALS['dbi']->getTable($this->_db, $this->_table)->isView();
        if (empty($GLOBALS['cfg']['Server']['host'])) {
            $GLOBALS['cfg']['Server']['host'] = '';
        }
        $server_info = !empty($GLOBALS['cfg']['Server']['verbose']) ? $GLOBALS['cfg']['Server']['verbose'] : $GLOBALS['cfg']['Server']['host'];
        $server_info .= empty($GLOBALS['cfg']['Server']['port']) ? '' : ':' . $GLOBALS['cfg']['Server']['port'];
        $separator = "<span class='separator item'>&nbsp;»</span>";
        $item = '<a href="%1$s%2$s" class="item">';
        if (Util::showText('TabsMode')) {
            $item .= '%4$s: ';
        }
        $item .= '%3$s</a>';
        $retval .= "<div id='floating_menubar'></div>";
        $retval .= "<div id='serverinfo'>";
        if (Util::showIcons('TabsMode')) {
            $retval .= Util::getImage('s_host.png', '', array('class' => 'item'));
        }
        $retval .= sprintf($item, Util::getScriptNameForOption($GLOBALS['cfg']['DefaultTabServer'], 'server'), URL::getCommon(), htmlspecialchars($server_info), __('Server'));
        if (strlen($this->_db) > 0) {
            $retval .= $separator;
            if (Util::showIcons('TabsMode')) {
                $retval .= Util::getImage('s_db.png', '', array('class' => 'item'));
            }
            $retval .= sprintf($item, Util::getScriptNameForOption($GLOBALS['cfg']['DefaultTabDatabase'], 'database'), URL::getCommon(array('db' => $this->_db)), htmlspecialchars($this->_db), __('Database'));
            // if the table is being dropped, $_REQUEST['purge'] is set to '1'
            // so do not display the table name in upper div
            if (strlen($this->_table) > 0 && !(isset($_REQUEST['purge']) && $_REQUEST['purge'] == '1')) {
                include './libraries/tbl_info.inc.php';
                $retval .= $separator;
                if (Util::showIcons('TabsMode')) {
                    $icon = $tbl_is_view ? 'b_views.png' : 's_tbl.png';
                    $retval .= Util::getImage($icon, '', array('class' => 'item'));
                }
                $retval .= sprintf($item, Util::getScriptNameForOption($GLOBALS['cfg']['DefaultTabTable'], 'table'), URL::getCommon(array('db' => $this->_db, 'table' => $this->_table)), str_replace(' ', '&nbsp;', htmlspecialchars($this->_table)), $tbl_is_view ? __('View') : __('Table'));
                /**
                 * Displays table comment
                 */
                if (!empty($show_comment) && !isset($GLOBALS['avoid_show_comment'])) {
                    if (mb_strstr($show_comment, '; InnoDB free')) {
                        $show_comment = preg_replace('@; InnoDB free:.*?$@', '', $show_comment);
                    }
                    $retval .= '<span class="table_comment"';
                    $retval .= ' id="span_table_comment">&quot;';
                    $retval .= htmlspecialchars($show_comment);
                    $retval .= '&quot;</span>';
                }
                // end if
            } else {
                // no table selected, display database comment if present
                $cfgRelation = PMA_getRelationsParam();
                // Get additional information about tables for tooltip is done
                // in Util::getDbInfo() only once
                if ($cfgRelation['commwork']) {
                    $comment = PMA_getDbComment($this->_db);
                    /**
                     * Displays table comment
                     */
                    if (!empty($comment)) {
                        $retval .= '<span class="table_comment"' . ' id="span_table_comment">&quot;' . htmlspecialchars($comment) . '&quot;</span>';
                    }
                    // end if
                }
            }
        }
        $retval .= '<div class="clearfloat"></div>';
        $retval .= '</div>';
        return $retval;
    }
    /**
     * Returns the table tabs as an array
     *
     * @return array Data for generating table tabs
     */
    private function _getTableTabs()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getTableTabs") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Menu.php at line 309")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getTableTabs:309@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Menu.php');
        die();
    }
    /**
     * Returns the db tabs as an array
     *
     * @return array Data for generating db tabs
     */
    private function _getDbTabs()
    {
        $db_is_system_schema = $GLOBALS['dbi']->isSystemSchema($this->_db);
        $num_tables = count($GLOBALS['dbi']->getTables($this->_db));
        $is_superuser = $GLOBALS['dbi']->isSuperuser();
        $isCreateOrGrantUser = $GLOBALS['dbi']->isUserType('grant') || $GLOBALS['dbi']->isUserType('create');
        /**
         * Gets the relation settings
         */
        $cfgRelation = PMA_getRelationsParam();
        $tabs = array();
        $tabs['structure']['link'] = 'db_structure.php';
        $tabs['structure']['text'] = __('Structure');
        $tabs['structure']['icon'] = 'b_props.png';
        $tabs['sql']['link'] = 'db_sql.php';
        $tabs['sql']['text'] = __('SQL');
        $tabs['sql']['icon'] = 'b_sql.png';
        $tabs['search']['text'] = __('Search');
        $tabs['search']['icon'] = 'b_search.png';
        $tabs['search']['link'] = 'db_search.php';
        if ($num_tables == 0) {
            $tabs['search']['warning'] = __('Database seems to be empty!');
        }
        $tabs['qbe']['text'] = __('Query');
        $tabs['qbe']['icon'] = 's_db.png';
        $tabs['qbe']['link'] = 'db_qbe.php';
        if ($num_tables == 0) {
            $tabs['qbe']['warning'] = __('Database seems to be empty!');
        }
        $tabs['export']['text'] = __('Export');
        $tabs['export']['icon'] = 'b_export.png';
        $tabs['export']['link'] = 'db_export.php';
        if ($num_tables == 0) {
            $tabs['export']['warning'] = __('Database seems to be empty!');
        }
        if (!$db_is_system_schema) {
            $tabs['import']['link'] = 'db_import.php';
            $tabs['import']['text'] = __('Import');
            $tabs['import']['icon'] = 'b_import.png';
            $tabs['operation']['link'] = 'db_operations.php';
            $tabs['operation']['text'] = __('Operations');
            $tabs['operation']['icon'] = 'b_tblops.png';
            if ($is_superuser || $isCreateOrGrantUser) {
                $tabs['privileges']['link'] = 'server_privileges.php';
                $tabs['privileges']['args']['checkprivsdb'] = $this->_db;
                // stay on database view
                $tabs['privileges']['args']['viewing_mode'] = 'db';
                $tabs['privileges']['text'] = __('Privileges');
                $tabs['privileges']['icon'] = 's_rights.png';
            }
            $tabs['routines']['link'] = 'db_routines.php';
            $tabs['routines']['text'] = __('Routines');
            $tabs['routines']['icon'] = 'b_routines.png';
            if (Util::currentUserHasPrivilege('EVENT', $this->_db)) {
                $tabs['events']['link'] = 'db_events.php';
                $tabs['events']['text'] = __('Events');
                $tabs['events']['icon'] = 'b_events.png';
            }
            if (Util::currentUserHasPrivilege('TRIGGER', $this->_db)) {
                $tabs['triggers']['link'] = 'db_triggers.php';
                $tabs['triggers']['text'] = __('Triggers');
                $tabs['triggers']['icon'] = 'b_triggers.png';
            }
        }
        if (Tracker::isActive() && !$db_is_system_schema) {
            $tabs['tracking']['text'] = __('Tracking');
            $tabs['tracking']['icon'] = 'eye.png';
            $tabs['tracking']['link'] = 'db_tracking.php';
        }
        if (!$db_is_system_schema) {
            $tabs['designer']['text'] = __('Designer');
            $tabs['designer']['icon'] = 'b_relations.png';
            $tabs['designer']['link'] = 'db_designer.php';
            $tabs['designer']['id'] = 'designer_tab';
        }
        if (!$db_is_system_schema && $cfgRelation['centralcolumnswork']) {
            $tabs['central_columns']['text'] = __('Central columns');
            $tabs['central_columns']['icon'] = 'centralColumns.png';
            $tabs['central_columns']['link'] = 'db_central_columns.php';
        }
        return $tabs;
    }
    /**
     * Returns the server tabs as an array
     *
     * @return array Data for generating server tabs
     */
    private function _getServerTabs()
    {
        $is_superuser = $GLOBALS['dbi']->isSuperuser();
        $isCreateOrGrantUser = $GLOBALS['dbi']->isUserType('grant') || $GLOBALS['dbi']->isUserType('create');
        if (Util::cacheExists('binary_logs')) {
            $binary_logs = Util::cacheGet('binary_logs');
        } else {
            $binary_logs = $GLOBALS['dbi']->fetchResult('SHOW MASTER LOGS', 'Log_name', null, null, DatabaseInterface::QUERY_STORE);
            Util::cacheSet('binary_logs', $binary_logs);
        }
        $tabs = array();
        $tabs['databases']['icon'] = 's_db.png';
        $tabs['databases']['link'] = 'server_databases.php';
        $tabs['databases']['text'] = __('Databases');
        $tabs['sql']['icon'] = 'b_sql.png';
        $tabs['sql']['link'] = 'server_sql.php';
        $tabs['sql']['text'] = __('SQL');
        $tabs['status']['icon'] = 's_status.png';
        $tabs['status']['link'] = 'server_status.php';
        $tabs['status']['text'] = __('Status');
        $tabs['status']['active'] = in_array(basename($GLOBALS['PMA_PHP_SELF']), array('server_status.php', 'server_status_advisor.php', 'server_status_monitor.php', 'server_status_queries.php', 'server_status_variables.php', 'server_status_processes.php'));
        if ($is_superuser || $isCreateOrGrantUser) {
            $tabs['rights']['icon'] = 's_rights.png';
            $tabs['rights']['link'] = 'server_privileges.php';
            $tabs['rights']['text'] = __('User accounts');
            $tabs['rights']['active'] = in_array(basename($GLOBALS['PMA_PHP_SELF']), array('server_privileges.php', 'server_user_groups.php'));
            $tabs['rights']['args']['viewing_mode'] = 'server';
        }
        $tabs['export']['icon'] = 'b_export.png';
        $tabs['export']['link'] = 'server_export.php';
        $tabs['export']['text'] = __('Export');
        $tabs['import']['icon'] = 'b_import.png';
        $tabs['import']['link'] = 'server_import.php';
        $tabs['import']['text'] = __('Import');
        $tabs['settings']['icon'] = 'b_tblops.png';
        $tabs['settings']['link'] = 'prefs_manage.php';
        $tabs['settings']['text'] = __('Settings');
        $tabs['settings']['active'] = in_array(basename($GLOBALS['PMA_PHP_SELF']), array('prefs_forms.php', 'prefs_manage.php'));
        if (!empty($binary_logs)) {
            $tabs['binlog']['icon'] = 's_tbl.png';
            $tabs['binlog']['link'] = 'server_binlog.php';
            $tabs['binlog']['text'] = __('Binary log');
        }
        if ($is_superuser) {
            $tabs['replication']['icon'] = 's_replication.png';
            $tabs['replication']['link'] = 'server_replication.php';
            $tabs['replication']['text'] = __('Replication');
        }
        $tabs['vars']['icon'] = 's_vars.png';
        $tabs['vars']['link'] = 'server_variables.php';
        $tabs['vars']['text'] = __('Variables');
        $tabs['charset']['icon'] = 's_asci.png';
        $tabs['charset']['link'] = 'server_collations.php';
        $tabs['charset']['text'] = __('Charsets');
        $tabs['engine']['icon'] = 'b_engine.png';
        $tabs['engine']['link'] = 'server_engines.php';
        $tabs['engine']['text'] = __('Engines');
        $tabs['plugins']['icon'] = 'b_plugin.png';
        $tabs['plugins']['link'] = 'server_plugins.php';
        $tabs['plugins']['text'] = __('Plugins');
        return $tabs;
    }
    /**
     * Set current table
     *
     * @param string $table Current table
     *
     * @return $this
     */
    public function setTable($table)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Menu.php at line 638")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setTable:638@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Menu.php');
        die();
    }
}