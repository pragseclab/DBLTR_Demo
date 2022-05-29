<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds the PMA\libraries\controllers\database\DatabaseStructureController
 *
 * @package PMA
 */
namespace PMA\libraries\controllers\database;

use PMA\libraries\config\PageSettings;
use PMA\libraries\controllers\DatabaseController;
use PMA\libraries\Charsets;
use PMA\libraries\Message;
use PMA\libraries\RecentFavoriteTable;
use PMA\libraries\Response;
use PMA\libraries\Template;
use PMA\libraries\Tracker;
use PMA\libraries\Util;
use PMA\libraries\URL;
use PMA\libraries\Sanitize;
require_once 'libraries/display_create_table.lib.php';
require_once 'libraries/config/messages.inc.php';
require_once 'libraries/config/user_preferences.forms.php';
require_once 'libraries/config/page_settings.forms.php';
/**
 * Handles database structure logic
 *
 * @package PhpMyAdmin
 */
class DatabaseStructureController extends DatabaseController
{
    /**
     * @var string  The URL query string
     */
    protected $_url_query;
    /**
     * @var int Number of tables
     */
    protected $_num_tables;
    /**
     * @var int Current position in the list
     */
    protected $_pos;
    /**
     * @var bool DB is information_schema
     */
    protected $_db_is_system_schema;
    /**
     * @var int Number of tables
     */
    protected $_total_num_tables;
    /**
     * @var array Tables in the database
     */
    protected $_tables;
    /**
     * @var bool whether stats show or not
     */
    protected $_is_show_stats;
    /**
     * DatabaseStructureController constructor
     *
     * @param string $url_query URL query
     */
    public function __construct($url_query)
    {
        parent::__construct();
        $this->_url_query = $url_query;
    }
    /**
     * Retrieves databse information for further use
     *
     * @param string $sub_part Page part name
     *
     * @return void
     */
    private function _getDbInfo($sub_part)
    {
        list($tables, $num_tables, $total_num_tables, , $is_show_stats, $db_is_system_schema, , , $pos) = Util::getDbInfo($this->db, $sub_part);
        $this->_tables = $tables;
        $this->_num_tables = $num_tables;
        $this->_pos = $pos;
        $this->_db_is_system_schema = $db_is_system_schema;
        $this->_total_num_tables = $total_num_tables;
        $this->_is_show_stats = $is_show_stats;
    }
    /**
     * Index action
     *
     * @return void
     */
    public function indexAction()
    {
        $response = Response::getInstance();
        // Add/Remove favorite tables using Ajax request.
        if ($response->isAjax() && !empty($_REQUEST['favorite_table'])) {
            $this->addRemoveFavoriteTablesAction();
            return;
        }
        // If there is an Ajax request for real row count of a table.
        if ($response->isAjax() && isset($_REQUEST['real_row_count']) && $_REQUEST['real_row_count'] == true) {
            $this->handleRealRowCountRequestAction();
            return;
        }
        // Drops/deletes/etc. multiple tables if required
        if (!empty($_POST['submit_mult']) && isset($_POST['selected_tbl']) || isset($_POST['mult_btn'])) {
            $this->multiSubmitAction();
        }
        $this->response->getHeader()->getScripts()->addFiles(array('db_structure.js', 'tbl_change.js', 'jquery/jquery-ui-timepicker-addon.js'));
        $this->_url_query .= '&amp;goto=db_structure.php';
        // Gets the database structure
        $this->_getDbInfo('_structure');
        include_once 'libraries/replication.inc.php';
        PageSettings::showGroup('DbStructure');
        // 1. No tables
        if ($this->_num_tables == 0) {
            $this->response->addHTML(Message::notice(__('No tables found in database.')));
            if (empty($this->_db_is_system_schema)) {
                $this->response->addHTML(PMA_getHtmlForCreateTable($this->db));
            }
            return;
        }
        // else
        // 2. Shows table information
        /**
         * Displays the tables list
         */
        $this->response->addHTML('<div id="tableslistcontainer">');
        $_url_params = array('pos' => $this->_pos, 'db' => $this->db);
        // Add the sort options if they exists
        if (isset($_REQUEST['sort'])) {
            $_url_params['sort'] = $_REQUEST['sort'];
        }
        if (isset($_REQUEST['sort_order'])) {
            $_url_params['sort_order'] = $_REQUEST['sort_order'];
        }
        $this->response->addHTML(Util::getListNavigator($this->_total_num_tables, $this->_pos, $_url_params, 'db_structure.php', 'frame_content', $GLOBALS['cfg']['MaxTableList']));
        $this->displayTableList();
        // display again the table list navigator
        $this->response->addHTML(Util::getListNavigator($this->_total_num_tables, $this->_pos, $_url_params, 'db_structure.php', 'frame_content', $GLOBALS['cfg']['MaxTableList']));
        $this->response->addHTML('</div><hr />');
        /**
         * Work on the database
         */
        /* DATABASE WORK */
        /* Printable view of a table */
        $this->response->addHTML(Template::get('database/structure/print_view_data_dictionary_link')->render(array('url_query' => $this->_url_query)));
        if (empty($this->_db_is_system_schema)) {
            $this->response->addHTML(PMA_getHtmlForCreateTable($this->db));
        }
    }
    /**
     * Add or remove favorite tables
     *
     * @return void
     */
    public function addRemoveFavoriteTablesAction()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addRemoveFavoriteTablesAction") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php at line 225")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addRemoveFavoriteTablesAction:225@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php');
        die();
    }
    /**
     * Handles request for real row count on database level view page.
     *
     * @return boolean true
     */
    public function handleRealRowCountRequestAction()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handleRealRowCountRequestAction") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php at line 307")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handleRealRowCountRequestAction:307@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php');
        die();
    }
    /**
     * Handles actions related to multiple tables
     *
     * @return void
     */
    public function multiSubmitAction()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("multiSubmitAction") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php at line 346")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called multiSubmitAction:346@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php');
        die();
    }
    /**
     * Displays the list of tables
     *
     * @return void
     */
    protected function displayTableList()
    {
        // filtering
        $this->response->addHTML(Template::get('filter')->render(array('filterValue' => '')));
        // table form
        $this->response->addHTML(Template::get('database/structure/table_header')->render(array('db' => $this->db, 'db_is_system_schema' => $this->_db_is_system_schema, 'replication' => $GLOBALS['replication_info']['slave']['status'])));
        $i = $sum_entries = 0;
        $overhead_check = '';
        $create_time_all = '';
        $update_time_all = '';
        $check_time_all = '';
        $num_columns = $GLOBALS['cfg']['PropertiesNumColumns'] > 1 ? ceil($this->_num_tables / $GLOBALS['cfg']['PropertiesNumColumns']) + 1 : 0;
        $row_count = 0;
        $sum_size = 0;
        $overhead_size = 0;
        $hidden_fields = array();
        $overall_approx_rows = false;
        foreach ($this->_tables as $keyname => $current_table) {
            // Get valid statistics whatever is the table type
            $drop_query = '';
            $drop_message = '';
            $overhead = '';
            $table_is_view = false;
            $table_encoded = urlencode($current_table['TABLE_NAME']);
            // Sets parameters for links
            $tbl_url_query = $this->_url_query . '&amp;table=' . $table_encoded;
            // do not list the previous table's size info for a view
            list($current_table, $formatted_size, $unit, $formatted_overhead, $overhead_unit, $overhead_size, $table_is_view, $sum_size) = $this->getStuffForEngineTypeTable($current_table, $sum_size, $overhead_size);
            $curTable = $this->dbi->getTable($this->db, $current_table['TABLE_NAME']);
            if (!$curTable->isMerge()) {
                $sum_entries += $current_table['TABLE_ROWS'];
            }
            if (isset($current_table['Collation'])) {
                $collation = '<dfn title="' . Charsets::getCollationDescr($current_table['Collation']) . '">' . $current_table['Collation'] . '</dfn>';
            } else {
                $collation = '---';
            }
            if ($this->_is_show_stats) {
                if ($formatted_overhead != '') {
                    $overhead = '<a href="tbl_structure.php' . $tbl_url_query . '#showusage">' . '<span>' . $formatted_overhead . '</span>&nbsp;' . '<span class="unit">' . $overhead_unit . '</span>' . '</a>' . "\n";
                    $overhead_check .= "markAllRows('row_tbl_" . ($i + 1) . "');";
                } else {
                    $overhead = '-';
                }
            }
            // end if
            if ($GLOBALS['cfg']['ShowDbStructureCharset']) {
                if (isset($current_table['Collation'])) {
                    $charset = mb_substr($collation, 0, mb_strpos($collation, "_"));
                } else {
                    $charset = '';
                }
            }
            if ($GLOBALS['cfg']['ShowDbStructureCreation']) {
                $create_time = isset($current_table['Create_time']) ? $current_table['Create_time'] : '';
                if ($create_time && (!$create_time_all || $create_time < $create_time_all)) {
                    $create_time_all = $create_time;
                }
            }
            if ($GLOBALS['cfg']['ShowDbStructureLastUpdate']) {
                $update_time = isset($current_table['Update_time']) ? $current_table['Update_time'] : '';
                if ($update_time && (!$update_time_all || $update_time < $update_time_all)) {
                    $update_time_all = $update_time;
                }
            }
            if ($GLOBALS['cfg']['ShowDbStructureLastCheck']) {
                $check_time = isset($current_table['Check_time']) ? $current_table['Check_time'] : '';
                if ($check_time && (!$check_time_all || $check_time < $check_time_all)) {
                    $check_time_all = $check_time;
                }
            }
            $truename = htmlspecialchars(!empty($tooltip_truename) && isset($tooltip_truename[$current_table['TABLE_NAME']]) ? $tooltip_truename[$current_table['TABLE_NAME']] : $current_table['TABLE_NAME']);
            $truename = str_replace(' ', '&nbsp;', $truename);
            $i++;
            $row_count++;
            if ($table_is_view) {
                $hidden_fields[] = '<input type="hidden" name="views[]" value="' . htmlspecialchars($current_table['TABLE_NAME']) . '" />';
            }
            /*
             * Always activate links for Browse, Search and Empty, even if
             * the icons are greyed, because
             * 1. for views, we don't know the number of rows at this point
             * 2. for tables, another source could have populated them since the
             *    page was generated
             *
             * I could have used the PHP ternary conditional operator but I find
             * the code easier to read without this operator.
             */
            $may_have_rows = $current_table['TABLE_ROWS'] > 0 || $table_is_view;
            $titles = Util::buildActionTitles();
            $browse_table = Template::get('database/structure/browse_table')->render(array('tbl_url_query' => $tbl_url_query, 'title' => $may_have_rows ? $titles['Browse'] : $titles['NoBrowse']));
            $search_table = Template::get('database/structure/search_table')->render(array('tbl_url_query' => $tbl_url_query, 'title' => $may_have_rows ? $titles['Search'] : $titles['NoSearch']));
            $browse_table_label = Template::get('database/structure/browse_table_label')->render(array('tbl_url_query' => $tbl_url_query, 'title' => htmlspecialchars($current_table['TABLE_COMMENT']), 'truename' => $truename));
            $empty_table = '';
            if (!$this->_db_is_system_schema) {
                $empty_table = '&nbsp;';
                if (!$table_is_view) {
                    $empty_table = Template::get('database/structure/empty_table')->render(array('tbl_url_query' => $tbl_url_query, 'sql_query' => urlencode('TRUNCATE ' . Util::backquote($current_table['TABLE_NAME'])), 'message_to_show' => urlencode(sprintf(__('Table %s has been emptied.'), htmlspecialchars($current_table['TABLE_NAME']))), 'title' => $may_have_rows ? $titles['Empty'] : $titles['NoEmpty']));
                }
                $drop_query = sprintf('DROP %s %s', $table_is_view || $current_table['ENGINE'] == null ? 'VIEW' : 'TABLE', Util::backquote($current_table['TABLE_NAME']));
                $drop_message = sprintf($table_is_view || $current_table['ENGINE'] == null ? __('View %s has been dropped.') : __('Table %s has been dropped.'), str_replace(' ', '&nbsp;', htmlspecialchars($current_table['TABLE_NAME'])));
            }
            if ($num_columns > 0 && $this->_num_tables > $num_columns && $row_count % $num_columns == 0) {
                $row_count = 1;
                $this->response->addHTML('</tr></tbody></table></form>');
                $this->response->addHTML(Template::get('database/structure/table_header')->render(array('db' => $this->db, 'db_is_system_schema' => $this->_db_is_system_schema, 'replication' => $GLOBALS['replication_info']['slave']['status'])));
            }
            list($approx_rows, $show_superscript) = $this->isRowCountApproximated($current_table, $table_is_view);
            list($do, $ignored) = $this->getReplicationStatus($truename);
            $this->response->addHTML(Template::get('database/structure/structure_table_row')->render(array('db' => $this->db, 'curr' => $i, 'table_is_view' => $table_is_view, 'current_table' => $current_table, 'browse_table_label' => $browse_table_label, 'tracking_icon' => $this->getTrackingIcon($truename), 'server_slave_status' => $GLOBALS['replication_info']['slave']['status'], 'browse_table' => $browse_table, 'tbl_url_query' => $tbl_url_query, 'search_table' => $search_table, 'db_is_system_schema' => $this->_db_is_system_schema, 'titles' => $titles, 'empty_table' => $empty_table, 'drop_query' => $drop_query, 'drop_message' => $drop_message, 'collation' => $collation, 'formatted_size' => $formatted_size, 'unit' => $unit, 'overhead' => $overhead, 'create_time' => isset($create_time) ? $create_time : '', 'update_time' => isset($update_time) ? $update_time : '', 'check_time' => isset($check_time) ? $check_time : '', 'charset' => isset($charset) ? $charset : '', 'is_show_stats' => $this->_is_show_stats, 'ignored' => $ignored, 'do' => $do, 'colspan_for_structure' => $GLOBALS['colspan_for_structure'], 'approx_rows' => $approx_rows, 'show_superscript' => $show_superscript, 'already_favorite' => $this->checkFavoriteTable($current_table['TABLE_NAME']))));
            $overall_approx_rows = $overall_approx_rows || $approx_rows;
        }
        // end foreach
        $this->response->addHTML('</tbody>');
        $db_collation = $this->dbi->getDbCollation($this->db);
        $db_charset = mb_substr($db_collation, 0, mb_strpos($db_collation, "_"));
        // Show Summary
        $this->response->addHTML(Template::get('database/structure/body_for_table_summary')->render(array('num_tables' => $this->_num_tables, 'server_slave_status' => $GLOBALS['replication_info']['slave']['status'], 'db_is_system_schema' => $this->_db_is_system_schema, 'sum_entries' => $sum_entries, 'db_collation' => $db_collation, 'is_show_stats' => $this->_is_show_stats, 'db_charset' => $db_charset, 'sum_size' => $sum_size, 'overhead_size' => $overhead_size, 'create_time_all' => $create_time_all, 'update_time_all' => $update_time_all, 'check_time_all' => $check_time_all, 'approx_rows' => $overall_approx_rows)));
        $this->response->addHTML('</table>');
        //check all
        $this->response->addHTML(Template::get('database/structure/check_all_tables')->render(array('pmaThemeImage' => $GLOBALS['pmaThemeImage'], 'text_dir' => $GLOBALS['text_dir'], 'overhead_check' => $overhead_check, 'db_is_system_schema' => $this->_db_is_system_schema, 'hidden_fields' => $hidden_fields)));
        $this->response->addHTML('</form>');
        //end of form
    }
    /**
     * Returns the tracking icon if the table is tracked
     *
     * @param string $table table name
     *
     * @return string HTML for tracking icon
     */
    protected function getTrackingIcon($table)
    {
        $tracking_icon = '';
        if (Tracker::isActive()) {
            $is_tracked = Tracker::isTracked($this->db, $table);
            if ($is_tracked || Tracker::getVersion($this->db, $table) > 0) {
                $tracking_icon = Template::get('database/structure/tracking_icon')->render(array('url_query' => $this->_url_query, 'truename' => $table, 'is_tracked' => $is_tracked));
            }
        }
        return $tracking_icon;
    }
    /**
     * Returns whether the row count is approximated
     *
     * @param array   $current_table array containing details about the table
     * @param boolean $table_is_view whether the table is a view
     *
     * @return array
     */
    protected function isRowCountApproximated($current_table, $table_is_view)
    {
        $approx_rows = false;
        $show_superscript = '';
        // there is a null value in the ENGINE
        // - when the table needs to be repaired, or
        // - when it's a view
        //  so ensure that we'll display "in use" below for a table
        //  that needs to be repaired
        if (isset($current_table['TABLE_ROWS']) && ($current_table['ENGINE'] != null || $table_is_view)) {
            // InnoDB/TokuDB table: we did not get an accurate row count
            $approx_rows = !$table_is_view && in_array($current_table['ENGINE'], array('InnoDB', 'TokuDB')) && !$current_table['COUNTED'];
            if ($table_is_view && $current_table['TABLE_ROWS'] >= $GLOBALS['cfg']['MaxExactCountViews']) {
                $approx_rows = true;
                $show_superscript = Util::showHint(Sanitize::sanitize(sprintf(__('This view has at least this number of ' . 'rows. Please refer to %sdocumentation%s.'), '[doc@cfg_MaxExactCountViews]', '[/doc]')));
            }
        }
        return array($approx_rows, $show_superscript);
    }
    /**
     * Returns the replication status of the table.
     *
     * @param string $table table name
     *
     * @return array
     */
    protected function getReplicationStatus($table)
    {
        $do = $ignored = false;
        if ($GLOBALS['replication_info']['slave']['status']) {
            $nbServSlaveDoDb = count($GLOBALS['replication_info']['slave']['Do_DB']);
            $nbServSlaveIgnoreDb = count($GLOBALS['replication_info']['slave']['Ignore_DB']);
            $searchDoDBInTruename = array_search($table, $GLOBALS['replication_info']['slave']['Do_DB']);
            $searchDoDBInDB = array_search($this->db, $GLOBALS['replication_info']['slave']['Do_DB']);
            $do = strlen($searchDoDBInTruename) > 0 || strlen($searchDoDBInDB) > 0 || $nbServSlaveDoDb == 0 && $nbServSlaveIgnoreDb == 0 || $this->hasTable($GLOBALS['replication_info']['slave']['Wild_Do_Table'], $table);
            $searchDb = array_search($this->db, $GLOBALS['replication_info']['slave']['Ignore_DB']);
            $searchTable = array_search($table, $GLOBALS['replication_info']['slave']['Ignore_Table']);
            $ignored = strlen($searchTable) > 0 || strlen($searchDb) > 0 || $this->hasTable($GLOBALS['replication_info']['slave']['Wild_Ignore_Table'], $table);
        }
        return array($do, $ignored);
    }
    /**
     * Synchronize favorite tables
     *
     *
     * @param RecentFavoriteTable $fav_instance    Instance of this class
     * @param string              $user            The user hash
     * @param array               $favorite_tables Existing favorites
     *
     * @return void
     */
    protected function synchronizeFavoriteTables($fav_instance, $user, $favorite_tables)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("synchronizeFavoriteTables") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php at line 853")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called synchronizeFavoriteTables:853@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php');
        die();
    }
    /**
     * Function to check if a table is already in favorite list.
     *
     * @param string $current_table current table
     *
     * @return true|false
     */
    protected function checkFavoriteTable($current_table)
    {
        // ensure $_SESSION['tmpval']['favorite_tables'] is initialized
        RecentFavoriteTable::getInstance('favorite');
        foreach ($_SESSION['tmpval']['favorite_tables'][$GLOBALS['server']] as $value) {
            if ($value['db'] == $this->db && $value['table'] == $current_table) {
                return true;
            }
        }
        return false;
    }
    /**
     * Find table with truename
     *
     * @param array  $db       DB to look into
     * @param string $truename Table name
     *
     * @return bool
     */
    protected function hasTable($db, $truename)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hasTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php at line 906")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hasTable:906@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php');
        die();
    }
    /**
     * Get the value set for ENGINE table,
     *
     * @param array   $current_table current table
     * @param integer $sum_size      total table size
     * @param integer $overhead_size overhead size
     *
     * @return array
     * @internal param bool $table_is_view whether table is view or not
     */
    protected function getStuffForEngineTypeTable($current_table, $sum_size, $overhead_size)
    {
        $formatted_size = '-';
        $unit = '';
        $formatted_overhead = '';
        $overhead_unit = '';
        $table_is_view = false;
        switch ($current_table['ENGINE']) {
            // MyISAM, ISAM or Heap table: Row count, data size and index size
            // are accurate; data size is accurate for ARCHIVE
            case 'MyISAM':
            case 'ISAM':
            case 'HEAP':
            case 'MEMORY':
            case 'ARCHIVE':
            case 'Aria':
            case 'Maria':
                list($current_table, $formatted_size, $unit, $formatted_overhead, $overhead_unit, $overhead_size, $sum_size) = $this->getValuesForAriaTable($current_table, $sum_size, $overhead_size, $formatted_size, $unit, $formatted_overhead, $overhead_unit);
                break;
            case 'InnoDB':
            case 'PBMS':
            case 'TokuDB':
                // InnoDB table: Row count is not accurate but data and index sizes are.
                // PBMS table in Drizzle: TABLE_ROWS is taken from table cache,
                // so it may be unavailable
                list($current_table, $formatted_size, $unit, $sum_size) = $this->getValuesForInnodbTable($current_table, $sum_size);
                break;
            // Mysql 5.0.x (and lower) uses MRG_MyISAM
            // and MySQL 5.1.x (and higher) uses MRG_MYISAM
            // Both are aliases for MERGE
            case 'MRG_MyISAM':
            case 'MRG_MYISAM':
            case 'MERGE':
            case 'BerkeleyDB':
                // Merge or BerkleyDB table: Only row count is accurate.
                if ($this->_is_show_stats) {
                    $formatted_size = ' - ';
                    $unit = '';
                }
                break;
            // for a view, the ENGINE is sometimes reported as null,
            // or on some servers it's reported as "SYSTEM VIEW"
            case null:
            case 'SYSTEM VIEW':
                // possibly a view, do nothing
                break;
            default:
                // Unknown table type.
                if ($this->_is_show_stats) {
                    $formatted_size = __('unknown');
                    $unit = '';
                }
        }
        // end switch
        if ($current_table['TABLE_TYPE'] == 'VIEW' || $current_table['TABLE_TYPE'] == 'SYSTEM VIEW') {
            // countRecords() takes care of $cfg['MaxExactCountViews']
            $current_table['TABLE_ROWS'] = $this->dbi->getTable($this->db, $current_table['TABLE_NAME'])->countRecords(true);
            $table_is_view = true;
        }
        return array($current_table, $formatted_size, $unit, $formatted_overhead, $overhead_unit, $overhead_size, $table_is_view, $sum_size);
    }
    /**
     * Get values for ARIA/MARIA tables
     *
     * @param array   $current_table      current table
     * @param integer $sum_size           sum size
     * @param integer $overhead_size      overhead size
     * @param integer $formatted_size     formatted size
     * @param string  $unit               unit
     * @param integer $formatted_overhead overhead formatted
     * @param string  $overhead_unit      overhead unit
     *
     * @return array
     */
    protected function getValuesForAriaTable($current_table, $sum_size, $overhead_size, $formatted_size, $unit, $formatted_overhead, $overhead_unit)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getValuesForAriaTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php at line 1026")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getValuesForAriaTable:1026@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/database/DatabaseStructureController.php');
        die();
    }
    /**
     * Get values for InnoDB table
     *
     * @param array   $current_table current table
     * @param integer $sum_size      sum size
     *
     * @return array
     */
    protected function getValuesForInnodbTable($current_table, $sum_size)
    {
        $formatted_size = $unit = '';
        if (in_array($current_table['ENGINE'], array('InnoDB', 'TokuDB')) && $current_table['TABLE_ROWS'] < $GLOBALS['cfg']['MaxExactCount'] || !isset($current_table['TABLE_ROWS'])) {
            $current_table['COUNTED'] = true;
            $current_table['TABLE_ROWS'] = $this->dbi->getTable($this->db, $current_table['TABLE_NAME'])->countRecords(true);
        } else {
            $current_table['COUNTED'] = false;
        }
        if ($this->_is_show_stats) {
            $tblsize = $current_table['Data_length'] + $current_table['Index_length'];
            $sum_size += $tblsize;
            list($formatted_size, $unit) = Util::formatByteDown($tblsize, 3, $tblsize > 0 ? 1 : 0);
        }
        return array($current_table, $formatted_size, $unit, $sum_size);
    }
}