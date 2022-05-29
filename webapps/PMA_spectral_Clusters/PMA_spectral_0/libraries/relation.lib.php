<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Set of functions used with the relation and pdf feature
 *
 * @package PhpMyAdmin
 */
use PMA\libraries\Message;
use PMA\libraries\Table;
use PMA\libraries\RecentFavoriteTable;
use PMA\libraries\URL;
/**
 * Executes a query as controluser if possible, otherwise as normal user
 *
 * @param string  $sql        the query to execute
 * @param boolean $show_error whether to display SQL error messages or not
 * @param int     $options    query options
 *
 * @return resource|boolean the result set, or false if no result set
 *
 * @access  public
 *
 */
function PMA_queryAsControlUser($sql, $show_error = true, $options = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_queryAsControlUser") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 31")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_queryAsControlUser:31@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
// end of the "PMA_queryAsControlUser()" function
/**
 * Returns current relation parameters
 *
 * @return array   $cfgRelation
 */
function PMA_getRelationsParam()
{
    if (empty($_SESSION['relation'][$GLOBALS['server']]) || empty($_SESSION['relation'][$GLOBALS['server']]['PMA_VERSION']) || $_SESSION['relation'][$GLOBALS['server']]['PMA_VERSION'] != PMA_VERSION) {
        $_SESSION['relation'][$GLOBALS['server']] = PMA_checkRelationsParam();
    }
    // just for BC but needs to be before PMA_getRelationsParamDiagnostic()
    // which uses it
    $GLOBALS['cfgRelation'] = $_SESSION['relation'][$GLOBALS['server']];
    return $_SESSION['relation'][$GLOBALS['server']];
}
/**
 * prints out diagnostic info for pma relation feature
 *
 * @param array $cfgRelation Relation configuration
 *
 * @return string
 */
function PMA_getRelationsParamDiagnostic($cfgRelation)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getRelationsParamDiagnostic") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 86")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getRelationsParamDiagnostic:86@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * prints out one diagnostic message for a feature
 *
 * @param string  $feature_name       feature name in a message string
 * @param string  $relation_parameter the $GLOBALS['cfgRelation'] parameter to check
 * @param array   $messages           utility messages
 * @param boolean $skip_line          whether to skip a line after the message
 *
 * @return string
 */
function PMA_getDiagMessageForFeature($feature_name, $relation_parameter, $messages, $skip_line = true)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDiagMessageForFeature") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 399")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDiagMessageForFeature:399@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * prints out one diagnostic message for a configuration parameter
 *
 * @param string  $parameter            config parameter name to display
 * @param boolean $relationParameterSet whether this parameter is set
 * @param array   $messages             utility messages
 * @param string  $docAnchor            anchor in documentation
 *
 * @return string
 */
function PMA_getDiagMessageForParameter($parameter, $relationParameterSet, $messages, $docAnchor)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDiagMessageForParameter") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 427")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDiagMessageForParameter:427@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Defines the relation parameters for the current user
 * just a copy of the functions used for relations ;-)
 * but added some stuff to check what will work
 *
 * @access  protected
 * @return array    the relation parameters for the current user
 */
function PMA_checkRelationsParam()
{
    $cfgRelation = array();
    $cfgRelation['PMA_VERSION'] = PMA_VERSION;
    $workToTable = array('relwork' => 'relation', 'displaywork' => array('relation', 'table_info'), 'bookmarkwork' => 'bookmarktable', 'pdfwork' => array('table_coords', 'pdf_pages'), 'commwork' => 'column_info', 'mimework' => 'column_info', 'historywork' => 'history', 'recentwork' => 'recent', 'favoritework' => 'favorite', 'uiprefswork' => 'table_uiprefs', 'trackingwork' => 'tracking', 'userconfigwork' => 'userconfig', 'menuswork' => array('users', 'usergroups'), 'navwork' => 'navigationhiding', 'savedsearcheswork' => 'savedsearches', 'centralcolumnswork' => 'central_columns', 'designersettingswork' => 'designer_settings', 'exporttemplateswork' => 'export_templates');
    foreach ($workToTable as $work => $table) {
        $cfgRelation[$work] = false;
    }
    $cfgRelation['allworks'] = false;
    $cfgRelation['user'] = null;
    $cfgRelation['db'] = null;
    if ($GLOBALS['server'] == 0 || empty($GLOBALS['cfg']['Server']['pmadb']) || empty($GLOBALS['controllink']) || !$GLOBALS['dbi']->selectDb($GLOBALS['cfg']['Server']['pmadb'], $GLOBALS['controllink'])) {
        // No server selected -> no bookmark table
        // we return the array with the falses in it,
        // to avoid some 'Uninitialized string offset' errors later
        $GLOBALS['cfg']['Server']['pmadb'] = false;
        return $cfgRelation;
    }
    $cfgRelation['user'] = $GLOBALS['cfg']['Server']['user'];
    $cfgRelation['db'] = $GLOBALS['cfg']['Server']['pmadb'];
    //  Now I just check if all tables that i need are present so I can for
    //  example enable relations but not pdf...
    //  I was thinking of checking if they have all required columns but I
    //  fear it might be too slow
    $tab_query = 'SHOW TABLES FROM ' . PMA\libraries\Util::backquote($GLOBALS['cfg']['Server']['pmadb']);
    $tab_rs = PMA_queryAsControlUser($tab_query, false, PMA\libraries\DatabaseInterface::QUERY_STORE);
    if (!$tab_rs) {
        // query failed ... ?
        //$GLOBALS['cfg']['Server']['pmadb'] = false;
        return $cfgRelation;
    }
    while ($curr_table = @$GLOBALS['dbi']->fetchRow($tab_rs)) {
        if ($curr_table[0] == $GLOBALS['cfg']['Server']['bookmarktable']) {
            $cfgRelation['bookmark'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['relation']) {
            $cfgRelation['relation'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['table_info']) {
            $cfgRelation['table_info'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['table_coords']) {
            $cfgRelation['table_coords'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['column_info']) {
            $cfgRelation['column_info'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['pdf_pages']) {
            $cfgRelation['pdf_pages'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['history']) {
            $cfgRelation['history'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['recent']) {
            $cfgRelation['recent'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['favorite']) {
            $cfgRelation['favorite'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['table_uiprefs']) {
            $cfgRelation['table_uiprefs'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['tracking']) {
            $cfgRelation['tracking'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['userconfig']) {
            $cfgRelation['userconfig'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['users']) {
            $cfgRelation['users'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['usergroups']) {
            $cfgRelation['usergroups'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['navigationhiding']) {
            $cfgRelation['navigationhiding'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['savedsearches']) {
            $cfgRelation['savedsearches'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['central_columns']) {
            $cfgRelation['central_columns'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['designer_settings']) {
            $cfgRelation['designer_settings'] = $curr_table[0];
        } elseif ($curr_table[0] == $GLOBALS['cfg']['Server']['export_templates']) {
            $cfgRelation['export_templates'] = $curr_table[0];
        }
    }
    // end while
    $GLOBALS['dbi']->freeResult($tab_rs);
    if (isset($cfgRelation['relation'])) {
        $cfgRelation['relwork'] = true;
    }
    if (isset($cfgRelation['relation']) && isset($cfgRelation['table_info'])) {
        $cfgRelation['displaywork'] = true;
    }
    if (isset($cfgRelation['table_coords']) && isset($cfgRelation['pdf_pages'])) {
        $cfgRelation['pdfwork'] = true;
    }
    if (isset($cfgRelation['column_info'])) {
        $cfgRelation['commwork'] = true;
        // phpMyAdmin 4.3+
        // Check for input transformations upgrade.
        $cfgRelation['mimework'] = PMA_tryUpgradeTransformations();
    }
    if (isset($cfgRelation['history'])) {
        $cfgRelation['historywork'] = true;
    }
    if (isset($cfgRelation['recent'])) {
        $cfgRelation['recentwork'] = true;
    }
    if (isset($cfgRelation['favorite'])) {
        $cfgRelation['favoritework'] = true;
    }
    if (isset($cfgRelation['table_uiprefs'])) {
        $cfgRelation['uiprefswork'] = true;
    }
    if (isset($cfgRelation['tracking'])) {
        $cfgRelation['trackingwork'] = true;
    }
    if (isset($cfgRelation['userconfig'])) {
        $cfgRelation['userconfigwork'] = true;
    }
    if (isset($cfgRelation['bookmark'])) {
        $cfgRelation['bookmarkwork'] = true;
    }
    if (isset($cfgRelation['users']) && isset($cfgRelation['usergroups'])) {
        $cfgRelation['menuswork'] = true;
    }
    if (isset($cfgRelation['navigationhiding'])) {
        $cfgRelation['navwork'] = true;
    }
    if (isset($cfgRelation['savedsearches'])) {
        $cfgRelation['savedsearcheswork'] = true;
    }
    if (isset($cfgRelation['central_columns'])) {
        $cfgRelation['centralcolumnswork'] = true;
    }
    if (isset($cfgRelation['designer_settings'])) {
        $cfgRelation['designersettingswork'] = true;
    }
    if (isset($cfgRelation['export_templates'])) {
        $cfgRelation['exporttemplateswork'] = true;
    }
    $allWorks = true;
    foreach ($workToTable as $work => $table) {
        if (!$cfgRelation[$work]) {
            if (is_string($table)) {
                if (isset($GLOBALS['cfg']['Server'][$table]) && $GLOBALS['cfg']['Server'][$table] !== false) {
                    $allWorks = false;
                    break;
                }
            } else {
                if (is_array($table)) {
                    $oneNull = false;
                    foreach ($table as $t) {
                        if (isset($GLOBALS['cfg']['Server'][$t]) && $GLOBALS['cfg']['Server'][$t] === false) {
                            $oneNull = true;
                            break;
                        }
                    }
                    if (!$oneNull) {
                        $allWorks = false;
                        break;
                    }
                }
            }
        }
    }
    $cfgRelation['allworks'] = $allWorks;
    return $cfgRelation;
}
// end of the 'PMA_checkRelationsParam()' function
/**
 * Check whether column_info table input transformation
 * upgrade is required and try to upgrade silently
 *
 * @return bool false if upgrade failed
 *
 * @access  public
 */
function PMA_tryUpgradeTransformations()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_tryUpgradeTransformations") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 678")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_tryUpgradeTransformations:678@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Gets all Relations to foreign tables for a given table or
 * optionally a given column in a table
 *
 * @param string $db     the name of the db to check for
 * @param string $table  the name of the table to check for
 * @param string $column the name of the column to check for
 * @param string $source the source for foreign key information
 *
 * @return array    db,table,column
 *
 * @access  public
 */
function PMA_getForeigners($db, $table, $column = '', $source = 'both')
{
    $cfgRelation = PMA_getRelationsParam();
    $foreign = array();
    if ($cfgRelation['relwork'] && ($source == 'both' || $source == 'internal')) {
        $rel_query = '
            SELECT `master_field`,
                `foreign_db`,
                `foreign_table`,
                `foreign_field`
            FROM ' . PMA\libraries\Util::backquote($cfgRelation['db']) . '.' . PMA\libraries\Util::backquote($cfgRelation['relation']) . '
            WHERE `master_db`    = \'' . $GLOBALS['dbi']->escapeString($db) . '\'
                AND `master_table` = \'' . $GLOBALS['dbi']->escapeString($table) . '\' ';
        if (strlen($column) > 0) {
            $rel_query .= ' AND `master_field` = ' . '\'' . $GLOBALS['dbi']->escapeString($column) . '\'';
        }
        $foreign = $GLOBALS['dbi']->fetchResult($rel_query, 'master_field', null, $GLOBALS['controllink']);
    }
    if (($source == 'both' || $source == 'foreign') && strlen($table) > 0) {
        $tableObj = new Table($table, $db);
        $show_create_table = $tableObj->showCreate();
        if ($show_create_table) {
            $parser = new \PhpMyAdmin\SqlParser\Parser($show_create_table);
            /**
             * @var \PhpMyAdmin\SqlParser\Statements\CreateStatement $stmt
             */
            $stmt = $parser->statements[0];
            $foreign['foreign_keys_data'] = \PhpMyAdmin\SqlParser\Utils\Table::getForeignKeys($stmt);
        }
    }
    /**
     * Emulating relations for some information_schema tables
     */
    $isInformationSchema = mb_strtolower($db) == 'information_schema';
    $isMysql = mb_strtolower($db) == 'mysql';
    if (($isInformationSchema || $isMysql) && ($source == 'internal' || $source == 'both')) {
        if ($isInformationSchema) {
            $relations_key = 'information_schema_relations';
            include_once './libraries/information_schema_relations.lib.php';
        } else {
            $relations_key = 'mysql_relations';
            include_once './libraries/mysql_relations.lib.php';
        }
        if (isset($GLOBALS[$relations_key][$table])) {
            foreach ($GLOBALS[$relations_key][$table] as $field => $relations) {
                if ((strlen($column) === 0 || $column == $field) && (!isset($foreign[$field]) || strlen($foreign[$field]) === 0)) {
                    $foreign[$field] = $relations;
                }
            }
        }
    }
    return $foreign;
}
// end of the 'PMA_getForeigners()' function
/**
 * Gets the display field of a table
 *
 * @param string $db    the name of the db to check for
 * @param string $table the name of the table to check for
 *
 * @return string   field name
 *
 * @access  public
 */
function PMA_getDisplayField($db, $table)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDisplayField") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 828")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDisplayField:828@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
// end of the 'PMA_getDisplayField()' function
/**
 * Gets the comments for all columns of a table or the db itself
 *
 * @param string $db    the name of the db to check for
 * @param string $table the name of the table to check for
 *
 * @return array    [column_name] = comment
 *
 * @access  public
 */
function PMA_getComments($db, $table = '')
{
    $comments = array();
    if ($table != '') {
        // MySQL native column comments
        $columns = $GLOBALS['dbi']->getColumns($db, $table, null, true);
        if ($columns) {
            foreach ($columns as $column) {
                if (!empty($column['Comment'])) {
                    $comments[$column['Field']] = $column['Comment'];
                }
            }
        }
    } else {
        $comments[] = PMA_getDbComment($db);
    }
    return $comments;
}
// end of the 'PMA_getComments()' function
/**
 * Gets the comment for a db
 *
 * @param string $db the name of the db to check for
 *
 * @return string   comment
 *
 * @access  public
 */
function PMA_getDbComment($db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDbComment") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 923")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDbComment:923@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
// end of the 'PMA_getDbComment()' function
/**
 * Gets the comment for a db
 *
 * @access  public
 *
 * @return string   comment
 */
function PMA_getDbComments()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDbComments") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 959")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDbComments:959@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
// end of the 'PMA_getDbComments()' function
/**
 * Set a database comment to a certain value.
 *
 * @param string $db      the name of the db
 * @param string $comment the value of the column
 *
 * @return boolean  true, if comment-query was made.
 *
 * @access  public
 */
function PMA_setDbComment($db, $comment = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_setDbComment") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 997")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_setDbComment:997@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
// end of 'PMA_setDbComment()' function
/**
 * Set a SQL history entry
 *
 * @param string $db       the name of the db
 * @param string $table    the name of the table
 * @param string $username the username
 * @param string $sqlquery the sql query
 *
 * @return void
 *
 * @access  public
 */
function PMA_setHistory($db, $table, $username, $sqlquery)
{
    $maxCharactersInDisplayedSQL = $GLOBALS['cfg']['MaxCharactersInDisplayedSQL'];
    // Prevent to run this automatically on Footer class destroying in testsuite
    if (defined('TESTSUITE') || mb_strlen($sqlquery) > $maxCharactersInDisplayedSQL) {
        return;
    }
    $cfgRelation = PMA_getRelationsParam();
    if (!isset($_SESSION['sql_history'])) {
        $_SESSION['sql_history'] = array();
    }
    $_SESSION['sql_history'][] = array('db' => $db, 'table' => $table, 'sqlquery' => $sqlquery);
    if (count($_SESSION['sql_history']) > $GLOBALS['cfg']['QueryHistoryMax']) {
        // history should not exceed a maximum count
        array_shift($_SESSION['sql_history']);
    }
    if (!$cfgRelation['historywork'] || !$GLOBALS['cfg']['QueryHistoryDB']) {
        return;
    }
    PMA_queryAsControlUser('INSERT INTO ' . PMA\libraries\Util::backquote($cfgRelation['db']) . '.' . PMA\libraries\Util::backquote($cfgRelation['history']) . '
              (`username`,
                `db`,
                `table`,
                `timevalue`,
                `sqlquery`)
        VALUES
              (\'' . $GLOBALS['dbi']->escapeString($username) . '\',
               \'' . $GLOBALS['dbi']->escapeString($db) . '\',
               \'' . $GLOBALS['dbi']->escapeString($table) . '\',
               NOW(),
               \'' . $GLOBALS['dbi']->escapeString($sqlquery) . '\')');
    PMA_purgeHistory($username);
}
// end of 'PMA_setHistory()' function
/**
 * Gets a SQL history entry
 *
 * @param string $username the username
 *
 * @return array    list of history items
 *
 * @access  public
 */
function PMA_getHistory($username)
{
    $cfgRelation = PMA_getRelationsParam();
    if (!$cfgRelation['historywork']) {
        return false;
    }
    /**
     * if db-based history is disabled but there exists a session-based
     * history, use it
     */
    if (!$GLOBALS['cfg']['QueryHistoryDB']) {
        if (isset($_SESSION['sql_history'])) {
            return array_reverse($_SESSION['sql_history']);
        }
        return false;
    }
    $hist_query = '
         SELECT `db`,
                `table`,
                `sqlquery`,
                `timevalue`
           FROM ' . PMA\libraries\Util::backquote($cfgRelation['db']) . '.' . PMA\libraries\Util::backquote($cfgRelation['history']) . '
          WHERE `username` = \'' . $GLOBALS['dbi']->escapeString($username) . '\'
       ORDER BY `id` DESC';
    return $GLOBALS['dbi']->fetchResult($hist_query, null, null, $GLOBALS['controllink']);
}
// end of 'PMA_getHistory()' function
/**
 * purges SQL history
 *
 * deletes entries that exceeds $cfg['QueryHistoryMax'], oldest first, for the
 * given user
 *
 * @param string $username the username
 *
 * @return void
 *
 * @access  public
 */
function PMA_purgeHistory($username)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_purgeHistory") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1153")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_purgeHistory:1153@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
// end of 'PMA_purgeHistory()' function
/**
 * Prepares the dropdown for one mode
 *
 * @param array  $foreign the keys and values for foreigns
 * @param string $data    the current data of the dropdown
 * @param string $mode    the needed mode
 *
 * @return array   the <option value=""><option>s
 *
 * @access  protected
 */
function PMA_buildForeignDropdown($foreign, $data, $mode)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_buildForeignDropdown") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1197")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_buildForeignDropdown:1197@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
// end of 'PMA_buildForeignDropdown' function
/**
 * Outputs dropdown with values of foreign fields
 *
 * @param array  $disp_row        array of the displayed row
 * @param string $foreign_field   the foreign field
 * @param string $foreign_display the foreign field to display
 * @param string $data            the current data of the dropdown (field in row)
 * @param int    $max             maximum number of items in the dropdown
 *
 * @return string   the <option value=""><option>s
 *
 * @access  public
 */
function PMA_foreignDropdown($disp_row, $foreign_field, $foreign_display, $data, $max = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_foreignDropdown") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1271")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_foreignDropdown:1271@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
// end of 'PMA_foreignDropdown()' function
/**
 * Gets foreign keys in preparation for a drop-down selector
 *
 * @param array|boolean $foreigners     array of the foreign keys
 * @param string        $field          the foreign field name
 * @param bool          $override_total whether to override the total
 * @param string        $foreign_filter a possible filter
 * @param string        $foreign_limit  a possible LIMIT clause
 * @param bool          $get_total      optional, whether to get total num of rows
 *                                      in $foreignData['the_total;]
 *                                      (has an effect of performance)
 *
 * @return array    data about the foreign keys
 *
 * @access  public
 */
function PMA_getForeignData($foreigners, $field, $override_total, $foreign_filter, $foreign_limit, $get_total = false)
{
    // we always show the foreign field in the drop-down; if a display
    // field is defined, we show it besides the foreign field
    $foreign_link = false;
    do {
        if (!$foreigners) {
            break;
        }
        $foreigner = PMA_searchColumnInForeigners($foreigners, $field);
        if ($foreigner != false) {
            $foreign_db = $foreigner['foreign_db'];
            $foreign_table = $foreigner['foreign_table'];
            $foreign_field = $foreigner['foreign_field'];
        } else {
            break;
        }
        // Count number of rows in the foreign table. Currently we do
        // not use a drop-down if more than ForeignKeyMaxLimit rows in the
        // foreign table,
        // for speed reasons and because we need a better interface for this.
        //
        // We could also do the SELECT anyway, with a LIMIT, and ensure that
        // the current value of the field is one of the choices.
        // Check if table has more rows than specified by
        // $GLOBALS['cfg']['ForeignKeyMaxLimit']
        $moreThanLimit = $GLOBALS['dbi']->getTable($foreign_db, $foreign_table)->checkIfMinRecordsExist($GLOBALS['cfg']['ForeignKeyMaxLimit']);
        if ($override_total == true || !$moreThanLimit) {
            // foreign_display can be false if no display field defined:
            $foreign_display = PMA_getDisplayField($foreign_db, $foreign_table);
            $f_query_main = 'SELECT ' . PMA\libraries\Util::backquote($foreign_field) . ($foreign_display == false ? '' : ', ' . PMA\libraries\Util::backquote($foreign_display));
            $f_query_from = ' FROM ' . PMA\libraries\Util::backquote($foreign_db) . '.' . PMA\libraries\Util::backquote($foreign_table);
            $f_query_filter = empty($foreign_filter) ? '' : ' WHERE ' . PMA\libraries\Util::backquote($foreign_field) . ' LIKE "%' . $GLOBALS['dbi']->escapeString($foreign_filter) . '%"' . ($foreign_display == false ? '' : ' OR ' . PMA\libraries\Util::backquote($foreign_display) . ' LIKE "%' . $GLOBALS['dbi']->escapeString($foreign_filter) . '%"');
            $f_query_order = $foreign_display == false ? '' : ' ORDER BY ' . PMA\libraries\Util::backquote($foreign_table) . '.' . PMA\libraries\Util::backquote($foreign_display);
            $f_query_limit = !empty($foreign_limit) ? $foreign_limit : '';
            if (!empty($foreign_filter)) {
                $the_total = $GLOBALS['dbi']->fetchValue('SELECT COUNT(*)' . $f_query_from . $f_query_filter);
                if ($the_total === false) {
                    $the_total = 0;
                }
            }
            $disp = $GLOBALS['dbi']->tryQuery($f_query_main . $f_query_from . $f_query_filter . $f_query_order . $f_query_limit);
            if ($disp && $GLOBALS['dbi']->numRows($disp) > 0) {
                // If a resultset has been created, pre-cache it in the $disp_row
                // array. This helps us from not needing to use mysql_data_seek by
                // accessing a pre-cached PHP array. Usually those resultsets are
                // not that big, so a performance hit should not be expected.
                $disp_row = array();
                while ($single_disp_row = @$GLOBALS['dbi']->fetchAssoc($disp)) {
                    $disp_row[] = $single_disp_row;
                }
                @$GLOBALS['dbi']->freeResult($disp);
            } else {
                // Either no data in the foreign table or
                // user does not have select permission to foreign table/field
                // Show an input field with a 'Browse foreign values' link
                $disp_row = null;
                $foreign_link = true;
            }
        } else {
            $disp_row = null;
            $foreign_link = true;
        }
    } while (false);
    if ($get_total) {
        $the_total = $GLOBALS['dbi']->getTable($foreign_db, $foreign_table)->countRecords(true);
    }
    $foreignData = array();
    $foreignData['foreign_link'] = $foreign_link;
    $foreignData['the_total'] = isset($the_total) ? $the_total : null;
    $foreignData['foreign_display'] = isset($foreign_display) ? $foreign_display : null;
    $foreignData['disp_row'] = isset($disp_row) ? $disp_row : null;
    $foreignData['foreign_field'] = isset($foreign_field) ? $foreign_field : null;
    return $foreignData;
}
// end of 'PMA_getForeignData()' function
/**
 * Rename a field in relation tables
 *
 * usually called after a column in a table was renamed
 *
 * @param string $db       database name
 * @param string $table    table name
 * @param string $field    old field name
 * @param string $new_name new field name
 *
 * @return void
 */
function PMA_REL_renameField($db, $table, $field, $new_name)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_REL_renameField") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1482")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_REL_renameField:1482@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Performs SQL query used for renaming table.
 *
 * @param string $table        Relation table to use
 * @param string $source_db    Source database name
 * @param string $target_db    Target database name
 * @param string $source_table Source table name
 * @param string $target_table Target table name
 * @param string $db_field     Name of database field
 * @param string $table_field  Name of table field
 *
 * @return void
 */
function PMA_REL_renameSingleTable($table, $source_db, $target_db, $source_table, $target_table, $db_field, $table_field)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_REL_renameSingleTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1551")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_REL_renameSingleTable:1551@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Rename a table in relation tables
 *
 * usually called after table has been moved
 *
 * @param string $source_db    Source database name
 * @param string $target_db    Target database name
 * @param string $source_table Source table name
 * @param string $target_table Target table name
 *
 * @return void
 */
function PMA_REL_renameTable($source_db, $target_db, $source_table, $target_table)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_REL_renameTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1583")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_REL_renameTable:1583@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Create a PDF page
 *
 * @param string $newpage     name of the new PDF page
 * @param array  $cfgRelation Relation configuration
 * @param string $db          database name
 *
 * @return int $pdf_page_number
 */
function PMA_REL_createPage($newpage, $cfgRelation, $db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_REL_createPage") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1690")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_REL_createPage:1690@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Get child table references for a table column.
 * This works only if 'DisableIS' is false. An empty array is returned otherwise.
 *
 * @param string $db     name of master table db.
 * @param string $table  name of master table.
 * @param string $column name of master table column.
 *
 * @return array $child_references
 */
function PMA_getChildReferences($db, $table, $column = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getChildReferences") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1719")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getChildReferences:1719@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Check child table references and foreign key for a table column.
 *
 * @param string $db                    name of master table db.
 * @param string $table                 name of master table.
 * @param string $column                name of master table column.
 * @param array  $foreigners_full       foreiners array for the whole table.
 * @param array  $child_references_full child references for the whole table.
 *
 * @return array $column_status telling about references if foreign key.
 */
function PMA_checkChildForeignReferences($db, $table, $column, $foreigners_full = null, $child_references_full = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_checkChildForeignReferences") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1754")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_checkChildForeignReferences:1754@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Search a table column in foreign data.
 *
 * @param array  $foreigners Table Foreign data
 * @param string $column     Column name
 *
 * @return bool|array
 */
function PMA_searchColumnInForeigners($foreigners, $column)
{
    if (isset($foreigners[$column])) {
        return $foreigners[$column];
    } else {
        $foreigner = array();
        foreach ($foreigners['foreign_keys_data'] as $one_key) {
            $column_index = array_search($column, $one_key['index_list']);
            if ($column_index !== false) {
                $foreigner['foreign_field'] = $one_key['ref_index_list'][$column_index];
                $foreigner['foreign_db'] = isset($one_key['ref_db_name']) ? $one_key['ref_db_name'] : $GLOBALS['db'];
                $foreigner['foreign_table'] = $one_key['ref_table_name'];
                $foreigner['constraint'] = $one_key['constraint'];
                $foreigner['on_update'] = isset($one_key['on_update']) ? $one_key['on_update'] : 'RESTRICT';
                $foreigner['on_delete'] = isset($one_key['on_delete']) ? $one_key['on_delete'] : 'RESTRICT';
                return $foreigner;
            }
        }
    }
    return false;
}
/**
 * Returns default PMA table names and their create queries.
 *
 * @return array table name, create query
 */
function PMA_getDefaultPMATableNames()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDefaultPMATableNames") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1852")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDefaultPMATableNames:1852@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Create a table named phpmyadmin to be used as configuration storage
 *
 * @return bool
 */
function PMA_createPMADatabase()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_createPMADatabase") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1880")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_createPMADatabase:1880@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Creates PMA tables in the given db, updates if already exists.
 *
 * @param string  $db     database
 * @param boolean $create whether to create tables if they don't exist.
 *
 * @return void
 */
function PMA_fixPMATables($db, $create = true)
{
    $tablesToFeatures = array('pma__bookmark' => 'bookmarktable', 'pma__relation' => 'relation', 'pma__table_info' => 'table_info', 'pma__table_coords' => 'table_coords', 'pma__pdf_pages' => 'pdf_pages', 'pma__column_info' => 'column_info', 'pma__history' => 'history', 'pma__recent' => 'recent', 'pma__favorite' => 'favorite', 'pma__table_uiprefs' => 'table_uiprefs', 'pma__tracking' => 'tracking', 'pma__userconfig' => 'userconfig', 'pma__users' => 'users', 'pma__usergroups' => 'usergroups', 'pma__navigationhiding' => 'navigationhiding', 'pma__savedsearches' => 'savedsearches', 'pma__central_columns' => 'central_columns', 'pma__designer_settings' => 'designer_settings', 'pma__export_templates' => 'export_templates');
    $existingTables = $GLOBALS['dbi']->getTables($db, $GLOBALS['controllink']);
    $createQueries = null;
    $foundOne = false;
    foreach ($tablesToFeatures as $table => $feature) {
        if (!in_array($table, $existingTables)) {
            if ($create) {
                if ($createQueries == null) {
                    // first create
                    $createQueries = PMA_getDefaultPMATableNames();
                    $GLOBALS['dbi']->selectDb($db);
                }
                $GLOBALS['dbi']->tryQuery($createQueries[$table]);
                if ($error = $GLOBALS['dbi']->getError()) {
                    $GLOBALS['message'] = $error;
                    return;
                }
                $foundOne = true;
                $GLOBALS['cfg']['Server'][$feature] = $table;
            }
        } else {
            $foundOne = true;
            $GLOBALS['cfg']['Server'][$feature] = $table;
        }
    }
    if (!$foundOne) {
        return;
    }
    $GLOBALS['cfg']['Server']['pmadb'] = $db;
    $_SESSION['relation'][$GLOBALS['server']] = PMA_checkRelationsParam();
    $cfgRelation = PMA_getRelationsParam();
    if ($cfgRelation['recentwork'] || $cfgRelation['favoritework']) {
        // Since configuration storage is updated, we need to
        // re-initialize the favorite and recent tables stored in the
        // session from the current configuration storage.
        if ($cfgRelation['favoritework']) {
            $fav_tables = RecentFavoriteTable::getInstance('favorite');
            $_SESSION['tmpval']['favorite_tables'][$GLOBALS['server']] = $fav_tables->getFromDb();
        }
        if ($cfgRelation['recentwork']) {
            $recent_tables = RecentFavoriteTable::getInstance('recent');
            $_SESSION['tmpval']['recent_tables'][$GLOBALS['server']] = $recent_tables->getFromDb();
        }
        // Reload navi panel to update the recent/favorite lists.
        $GLOBALS['reload'] = true;
    }
}
/**
 * Get Html for PMA tables fixing anchor.
 *
 * @param boolean $allTables whether to create all tables
 * @param boolean $createDb  whether to create the pmadb also
 *
 * @return string Html
 */
function PMA_getHtmlFixPMATables($allTables, $createDb = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlFixPMATables") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 1991")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlFixPMATables:1991@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Gets the relations info and status, depending on the condition
 *
 * @param boolean $condition whether to look for foreigners or not
 * @param string  $db        database name
 * @param string  $table     table name
 *
 * @return array ($res_rel, $have_rel)
 */
function PMA_getRelationsAndStatus($condition, $db, $table)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getRelationsAndStatus") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 2037")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getRelationsAndStatus:2037@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}
/**
 * Verifies if all the pmadb tables are defined
 *
 * @return boolean
 */
function PMA_arePmadbTablesDefined()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_arePmadbTablesDefined") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php at line 2061")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_arePmadbTablesDefined:2061@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/relation.lib.php');
    die();
}