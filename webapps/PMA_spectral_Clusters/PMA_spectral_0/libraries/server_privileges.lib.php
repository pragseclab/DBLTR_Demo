<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * set of functions with the Privileges section in pma
 *
 * @package PhpMyAdmin
 */
use PMA\libraries\DatabaseInterface;
use PMA\libraries\Message;
use PMA\libraries\Response;
use PMA\libraries\Template;
use PMA\libraries\Util;
use PMA\libraries\URL;
/**
 * Get Html for User Group Dialog
 *
 * @param string $username     username
 * @param bool   $is_menuswork Is menuswork set in configuration
 *
 * @return string html
 */
function PMA_getHtmlForUserGroupDialog($username, $is_menuswork)
{
    $html = '';
    if (!empty($_REQUEST['edit_user_group_dialog']) && $is_menuswork) {
        $dialog = PMA_getHtmlToChooseUserGroup($username);
        $response = Response::getInstance();
        if ($response->isAjax()) {
            $response->addJSON('message', $dialog);
            exit;
        } else {
            $html .= $dialog;
        }
    }
    return $html;
}
/**
 * Escapes wildcard in a database+table specification
 * before using it in a GRANT statement.
 *
 * Escaping a wildcard character in a GRANT is only accepted at the global
 * or database level, not at table level; this is why I remove
 * the escaping character. Internally, in mysql.tables_priv.Db there are
 * no escaping (for example test_db) but in mysql.db you'll see test\_db
 * for a db-specific privilege.
 *
 * @param string $dbname    Database name
 * @param string $tablename Table name
 *
 * @return string the escaped (if necessary) database.table
 */
function PMA_wildcardEscapeForGrant($dbname, $tablename)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_wildcardEscapeForGrant") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 57")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_wildcardEscapeForGrant:57@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Generates a condition on the user name
 *
 * @param string $initial the user's initial
 *
 * @return string   the generated condition
 */
function PMA_rangeOfUsers($initial = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_rangeOfUsers") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 83")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_rangeOfUsers:83@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
// end function
/**
 * Formats privilege name for a display
 *
 * @param array   $privilege Privilege information
 * @param boolean $html      Whether to use HTML
 *
 * @return string
 */
function PMA_formatPrivilege($privilege, $html)
{
    if ($html) {
        return '<dfn title="' . $privilege[2] . '">' . $privilege[1] . '</dfn>';
    } else {
        return $privilege[1];
    }
}
/**
 * Parses privileges into an array, it modifies the array
 *
 * @param array &$row Results row from
 *
 * @return void
 */
function PMA_fillInTablePrivileges(&$row)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_fillInTablePrivileges") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 122")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_fillInTablePrivileges:122@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Extracts the privilege information of a priv table row
 *
 * @param array|null $row        the row
 * @param boolean    $enableHTML add <dfn> tag with tooltips
 * @param boolean    $tablePrivs whether row contains table privileges
 *
 * @global  resource $user_link the database connection
 *
 * @return array
 */
function PMA_extractPrivInfo($row = null, $enableHTML = false, $tablePrivs = false)
{
    if ($tablePrivs) {
        $grants = PMA_getTableGrantsArray();
    } else {
        $grants = PMA_getGrantsArray();
    }
    if (!is_null($row) && isset($row['Table_priv'])) {
        PMA_fillInTablePrivileges($row);
    }
    $privs = array();
    $allPrivileges = true;
    foreach ($grants as $current_grant) {
        if (!is_null($row) && isset($row[$current_grant[0]]) || is_null($row) && isset($GLOBALS[$current_grant[0]])) {
            if (!is_null($row) && $row[$current_grant[0]] == 'Y' || is_null($row) && ($GLOBALS[$current_grant[0]] == 'Y' || is_array($GLOBALS[$current_grant[0]]) && count($GLOBALS[$current_grant[0]]) == $_REQUEST['column_count'] && empty($GLOBALS[$current_grant[0] . '_none']))) {
                $privs[] = PMA_formatPrivilege($current_grant, $enableHTML);
            } elseif (!empty($GLOBALS[$current_grant[0]]) && is_array($GLOBALS[$current_grant[0]]) && empty($GLOBALS[$current_grant[0] . '_none'])) {
                // Required for proper escaping of ` (backtick) in a column name
                $grant_cols = array_map(function ($val) {
                    return Util::backquote($val);
                }, $GLOBALS[$current_grant[0]]);
                $privs[] = PMA_formatPrivilege($current_grant, $enableHTML) . ' (' . join(', ', $grant_cols) . ')';
            } else {
                $allPrivileges = false;
            }
        }
    }
    if (empty($privs)) {
        if ($enableHTML) {
            $privs[] = '<dfn title="' . __('No privileges.') . '">USAGE</dfn>';
        } else {
            $privs[] = 'USAGE';
        }
    } elseif ($allPrivileges && (!isset($_POST['grant_count']) || count($privs) == $_POST['grant_count'])) {
        if ($enableHTML) {
            $privs = array('<dfn title="' . __('Includes all privileges except GRANT.') . '">ALL PRIVILEGES</dfn>');
        } else {
            $privs = array('ALL PRIVILEGES');
        }
    }
    return $privs;
}
// end of the 'PMA_extractPrivInfo()' function
/**
 * Returns an array of table grants and their descriptions
 *
 * @return array array of table grants
 */
function PMA_getTableGrantsArray()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getTableGrantsArray") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 235")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getTableGrantsArray:235@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the grants array which contains all the privilege types
 * and relevant grant messages
 *
 * @return array
 */
function PMA_getGrantsArray()
{
    return array(
        array('Select_priv', 'SELECT', __('Allows reading data.')),
        array('Insert_priv', 'INSERT', __('Allows inserting and replacing data.')),
        array('Update_priv', 'UPDATE', __('Allows changing data.')),
        array('Delete_priv', 'DELETE', __('Allows deleting data.')),
        array('Create_priv', 'CREATE', __('Allows creating new databases and tables.')),
        array('Drop_priv', 'DROP', __('Allows dropping databases and tables.')),
        array('Reload_priv', 'RELOAD', __('Allows reloading server settings and flushing the server\'s caches.')),
        array('Shutdown_priv', 'SHUTDOWN', __('Allows shutting down the server.')),
        array('Process_priv', 'PROCESS', __('Allows viewing processes of all users.')),
        array('File_priv', 'FILE', __('Allows importing data from and exporting data into files.')),
        array('References_priv', 'REFERENCES', __('Has no effect in this MySQL version.')),
        array('Index_priv', 'INDEX', __('Allows creating and dropping indexes.')),
        array('Alter_priv', 'ALTER', __('Allows altering the structure of existing tables.')),
        array('Show_db_priv', 'SHOW DATABASES', __('Gives access to the complete list of databases.')),
        array('Super_priv', 'SUPER', __('Allows connecting, even if maximum number of connections ' . 'is reached; required for most administrative operations ' . 'like setting global variables or killing threads of other users.')),
        array('Create_tmp_table_priv', 'CREATE TEMPORARY TABLES', __('Allows creating temporary tables.')),
        array('Lock_tables_priv', 'LOCK TABLES', __('Allows locking tables for the current thread.')),
        array('Repl_slave_priv', 'REPLICATION SLAVE', __('Needed for the replication slaves.')),
        array('Repl_client_priv', 'REPLICATION CLIENT', __('Allows the user to ask where the slaves / masters are.')),
        array('Create_view_priv', 'CREATE VIEW', __('Allows creating new views.')),
        array('Event_priv', 'EVENT', __('Allows to set up events for the event scheduler.')),
        array('Trigger_priv', 'TRIGGER', __('Allows creating and dropping triggers.')),
        // for table privs:
        array('Create View_priv', 'CREATE VIEW', __('Allows creating new views.')),
        array('Show_view_priv', 'SHOW VIEW', __('Allows performing SHOW CREATE VIEW queries.')),
        // for table privs:
        array('Show view_priv', 'SHOW VIEW', __('Allows performing SHOW CREATE VIEW queries.')),
        array('Create_routine_priv', 'CREATE ROUTINE', __('Allows creating stored routines.')),
        array('Alter_routine_priv', 'ALTER ROUTINE', __('Allows altering and dropping stored routines.')),
        array('Create_user_priv', 'CREATE USER', __('Allows creating, dropping and renaming user accounts.')),
        array('Execute_priv', 'EXECUTE', __('Allows executing stored routines.')),
    );
}
/**
 * Displays on which column(s) a table-specific privilege is granted
 *
 * @param array  $columns          columns array
 * @param array  $row              first row from result or boolean false
 * @param string $name_for_select  privilege types - Select_priv, Insert_priv
 *                                 Update_priv, References_priv
 * @param string $priv_for_header  privilege for header
 * @param string $name             privilege name: insert, select, update, references
 * @param string $name_for_dfn     name for dfn
 * @param string $name_for_current name for current
 *
 * @return string $html_output html snippet
 */
function PMA_getHtmlForColumnPrivileges($columns, $row, $name_for_select, $priv_for_header, $name, $name_for_dfn, $name_for_current)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForColumnPrivileges") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 459")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForColumnPrivileges:459@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
// end function
/**
 * Get sql query for display privileges table
 *
 * @param string $db       the database
 * @param string $table    the table
 * @param string $username username for database connection
 * @param string $hostname hostname for database connection
 *
 * @return string sql query
 */
function PMA_getSqlQueryForDisplayPrivTable($db, $table, $username, $hostname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getSqlQueryForDisplayPrivTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 487")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getSqlQueryForDisplayPrivTable:487@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Displays a dropdown to select the user group
 * with menu items configured to each of them.
 *
 * @param string $username username
 *
 * @return string html to select the user group
 */
function PMA_getHtmlToChooseUserGroup($username)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlToChooseUserGroup") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 516")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlToChooseUserGroup:516@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Sets the user group from request values
 *
 * @param string $username  username
 * @param string $userGroup user group to set
 *
 * @return void
 */
function PMA_setUserGroup($username, $userGroup)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_setUserGroup") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 563")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_setUserGroup:563@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Displays the privileges form table
 *
 * @param string  $db     the database
 * @param string  $table  the table
 * @param boolean $submit whether to display the submit button or not
 *
 * @global  array     $cfg         the phpMyAdmin configuration
 * @global  resource  $user_link   the database connection
 *
 * @return string html snippet
 */
function PMA_getHtmlToDisplayPrivilegesTable($db = '*', $table = '*', $submit = true)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlToDisplayPrivilegesTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 611")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlToDisplayPrivilegesTable:611@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
// end of the 'PMA_displayPrivTable()' function
/**
 * Get HTML for "Require"
 *
 * @param array $row privilege array
 *
 * @return string html snippet
 */
function PMA_getHtmlForRequires($row)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForRequires") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 707")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForRequires:707@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML for "Resource limits"
 *
 * @param array $row first row from result or boolean false
 *
 * @return string html snippet
 */
function PMA_getHtmlForResourceLimits($row)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForResourceLimits") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 818")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForResourceLimits:818@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the HTML snippet for routine specific privileges
 *
 * @param string $username   username for database connection
 * @param string $hostname   hostname for database connection
 * @param string $db         the database
 * @param string $routine    the routine
 * @param string $url_dbname url encoded db name
 *
 * @return string $html_output
 */
function PMA_getHtmlForRoutineSpecificPrivilges($username, $hostname, $db, $routine, $url_dbname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForRoutineSpecificPrivilges") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 878")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForRoutineSpecificPrivilges:878@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get routine privilege table as an array
 *
 * @return privilege type array
 */
function PMA_getTriggerPrivilegeTable()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getTriggerPrivilegeTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 922")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getTriggerPrivilegeTable:922@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the HTML snippet for table specific privileges
 *
 * @param string $username username for database connection
 * @param string $hostname hostname for database connection
 * @param string $db       the database
 * @param string $table    the table
 * @param array  $columns  columns array
 * @param array  $row      current privileges row
 *
 * @return string $html_output
 */
function PMA_getHtmlForTableSpecificPrivileges($username, $hostname, $db, $table, $columns, $row)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForTableSpecificPrivileges") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 960")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForTableSpecificPrivileges:960@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML snippet for privileges that are attached to a specific column
 *
 * @param array $columns columns array
 * @param array $row     first row from result or boolean false
 *
 * @return string $html_output
 */
function PMA_getHtmlForAttachedPrivilegesToTableSpecificColumn($columns, $row)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForAttachedPrivilegesToTableSpecificColumn") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1021")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForAttachedPrivilegesToTableSpecificColumn:1021@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML for privileges that are not attached to a specific column
 *
 * @param array $row first row from result or boolean false
 *
 * @return string $html_output
 */
function PMA_getHtmlForNotAttachedPrivilegesToTableSpecificColumn($row)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForNotAttachedPrivilegesToTableSpecificColumn") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1052")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForNotAttachedPrivilegesToTableSpecificColumn:1052@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML for global or database specific privileges
 *
 * @param string $db    the database
 * @param string $table the table
 * @param array  $row   first row from result or boolean false
 *
 * @return string $html_output
 */
function PMA_getHtmlForGlobalOrDbSpecificPrivs($db, $table, $row)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForGlobalOrDbSpecificPrivs") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1130")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForGlobalOrDbSpecificPrivs:1130@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get data privilege table as an array
 *
 * @param string $db the database
 *
 * @return string data privilege table
 */
function PMA_getDataPrivilegeTable($db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDataPrivilegeTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1196")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDataPrivilegeTable:1196@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get structure privilege table as an array
 *
 * @param string $table the table
 * @param array  $row   first row from result or boolean false
 *
 * @return string structure privilege table
 */
function PMA_getStructurePrivilegeTable($table, $row)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getStructurePrivilegeTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1222")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getStructurePrivilegeTable:1222@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get administration privilege table as an array
 *
 * @param string $db the table
 *
 * @return string administration privilege table
 */
function PMA_getAdministrationPrivilegeTable($db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getAdministrationPrivilegeTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1297")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getAdministrationPrivilegeTable:1297@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML snippet for global privileges table with check boxes
 *
 * @param array $privTable       privileges table array
 * @param array $privTable_names names of the privilege tables
 *                               (Data, Structure, Administration)
 * @param array $row             first row from result or boolean false
 *
 * @return string $html_output
 */
function PMA_getHtmlForGlobalPrivTableWithCheckboxes($privTable, $privTable_names, $row)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForGlobalPrivTableWithCheckboxes") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1382")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForGlobalPrivTableWithCheckboxes:1382@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Gets the currently active authentication plugins
 *
 * @param string $orig_auth_plugin Default Authentication plugin
 * @param string $mode             are we creating a new user or are we just
 *                                 changing  one?
 *                                 (allowed values: 'new', 'edit', 'change_pw')
 * @param string $versions         Is MySQL version newer or older than 5.5.7
 *
 * @return string $html_output
 */
function PMA_getHtmlForAuthPluginsDropdown($orig_auth_plugin, $mode = 'new', $versions = 'new')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForAuthPluginsDropdown") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1411")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForAuthPluginsDropdown:1411@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Gets the currently active authentication plugins
 *
 * @return array $result  array of plugin names and descriptions
 */
function PMA_getActiveAuthPlugins()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getActiveAuthPlugins") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1443")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getActiveAuthPlugins:1443@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Displays the fields used by the "new user" form as well as the
 * "change login information / copy user" form.
 *
 * @param string $mode     are we creating a new user or are we just
 *                         changing  one? (allowed values: 'new', 'change')
 * @param string $username User name
 * @param string $hostname Host name
 *
 * @global  array      $cfg     the phpMyAdmin configuration
 * @global  resource   $user_link the database connection
 *
 * @return string $html_output  a HTML snippet
 */
function PMA_getHtmlForLoginInformationFields($mode = 'new', $username = null, $hostname = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForLoginInformationFields") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1483")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForLoginInformationFields:1483@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
// end of the 'PMA_getHtmlForLoginInformationFields()' function
/**
 * Get username and hostname length
 *
 * @return array username length and hostname length
 */
function PMA_getUsernameAndHostnameLength()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getUsernameAndHostnameLength") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1753")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getUsernameAndHostnameLength:1753@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get current authentication plugin in use - for a user or globally
 *
 * @param string $mode     are we creating a new user or are we just
 *                         changing  one? (allowed values: 'new', 'change')
 * @param string $username User name
 * @param string $hostname Host name
 *
 * @return string authentication plugin in use
 */
function PMA_getCurrentAuthenticationPlugin($mode = 'new', $username = null, $hostname = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getCurrentAuthenticationPlugin") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1789")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getCurrentAuthenticationPlugin:1789@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Returns all the grants for a certain user on a certain host
 * Used in the export privileges for all users section
 *
 * @param string $user User name
 * @param string $host Host name
 *
 * @return string containing all the grants text
 */
function PMA_getGrants($user, $host)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getGrants") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1834")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getGrants:1834@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
// end of the 'PMA_getGrants()' function
/**
 * Update password and get message for password updating
 *
 * @param string $err_url  error url
 * @param string $username username
 * @param string $hostname hostname
 *
 * @return string $message  success or error message after updating password
 */
function PMA_updatePassword($err_url, $username, $hostname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_updatePassword") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 1858")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_updatePassword:1858@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Revokes privileges and get message and SQL query for privileges revokes
 *
 * @param string $dbname    database name
 * @param string $tablename table name
 * @param string $username  username
 * @param string $hostname  host name
 * @param string $itemType  item type
 *
 * @return array ($message, $sql_query)
 */
function PMA_getMessageAndSqlQueryForPrivilegesRevoke($dbname, $tablename, $username, $hostname, $itemType)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getMessageAndSqlQueryForPrivilegesRevoke") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2021")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getMessageAndSqlQueryForPrivilegesRevoke:2021@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get REQUIRE cluase
 *
 * @return string REQUIRE clause
 */
function PMA_getRequireClause()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getRequireClause") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2053")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getRequireClause:2053@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get a WITH clause for 'update privileges' and 'add user'
 *
 * @return string $sql_query
 */
function PMA_getWithClauseForAddUserAndUpdatePrivs()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getWithClauseForAddUserAndUpdatePrivs") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2091")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getWithClauseForAddUserAndUpdatePrivs:2091@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML for addUsersForm, This function call if isset($_REQUEST['adduser'])
 *
 * @param string $dbname database name
 *
 * @return string HTML for addUserForm
 */
function PMA_getHtmlForAddUser($dbname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForAddUser") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2136")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForAddUser:2136@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the list of privileges and list of compared privileges as strings
 * and return a array that contains both strings
 *
 * @return array $list_of_privileges, $list_of_compared_privileges
 */
function PMA_getListOfPrivilegesAndComparedPrivileges()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getListOfPrivilegesAndComparedPrivileges") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2210")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getListOfPrivilegesAndComparedPrivileges:2210@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the HTML for routine based privileges
 *
 * @param string $db             database name
 * @param string $index_checkbox starting index for rows to be added
 *
 * @return string $html_output
 */
function PMA_getHtmlTableBodyForSpecificDbRoutinePrivs($db, $index_checkbox)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlTableBodyForSpecificDbRoutinePrivs") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2267")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlTableBodyForSpecificDbRoutinePrivs:2267@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the HTML for user form and check the privileges for a particular database.
 *
 * @param string $db database name
 *
 * @return string $html_output
 */
function PMA_getHtmlForSpecificDbPrivileges($db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForSpecificDbPrivileges") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2328")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForSpecificDbPrivileges:2328@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the HTML for user form and check the privileges for a particular table.
 *
 * @param string $db    database name
 * @param string $table table name
 *
 * @return string $html_output
 */
function PMA_getHtmlForSpecificTablePrivileges($db, $table)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForSpecificTablePrivileges") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2400")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForSpecificTablePrivileges:2400@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * gets privilege map
 *
 * @param string $db the database
 *
 * @return array $privMap the privilege map
 */
function PMA_getPrivMap($db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getPrivMap") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2472")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getPrivMap:2472@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * merge privilege map and rows from resultset
 *
 * @param array  &$privMap the privilege map reference
 * @param object $result   the resultset of query
 *
 * @return void
 */
function PMA_mergePrivMapFromResult(&$privMap, $result)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_mergePrivMapFromResult") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2504")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_mergePrivMapFromResult:2504@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML snippet for privileges table head
 *
 * @return string $html_output
 */
function PMA_getHtmlForPrivsTableHead()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForPrivsTableHead") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2524")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForPrivsTableHead:2524@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML error for View Users form
 * For non superusers such as grant/create users
 *
 * @return string $html_output
 */
function PMA_getHtmlForViewUsersError()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForViewUsersError") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2545")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForViewUsersError:2545@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML snippet for table body of specific database or table privileges
 *
 * @param array  $privMap privilege map
 * @param string $db      database
 *
 * @return string $html_output
 */
function PMA_getHtmlTableBodyForSpecificDbOrTablePrivs($privMap, $db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlTableBodyForSpecificDbOrTablePrivs") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2560")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlTableBodyForSpecificDbOrTablePrivs:2560@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML to display privileges
 *
 * @param string  $db                 Database name
 * @param array   $current_privileges List of privileges
 * @param string  $current_user       Current user
 * @param string  $current_host       Current host
 *
 * @return string HTML to display privileges
 */
function PMA_getHtmlListOfPrivs($db, $current_privileges, $current_user, $current_host)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlListOfPrivs") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2639")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlListOfPrivs:2639@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Returns edit, revoke or export link for a user.
 *
 * @param string $linktype    The link type (edit | revoke | export)
 * @param string $username    User name
 * @param string $hostname    Host name
 * @param string $dbname      Database name
 * @param string $tablename   Table name
 * @param string $routinename Routine name
 * @param string $initial     Initial value
 *
 * @return string HTML code with link
 */
function PMA_getUserLink($linktype, $username, $hostname, $dbname = '', $tablename = '', $routinename = '', $initial = '')
{
    $html = '<a';
    switch ($linktype) {
        case 'edit':
            $html .= ' class="edit_user_anchor"';
            break;
        case 'export':
            $html .= ' class="export_user_anchor ajax"';
            break;
    }
    $params = array('username' => $username, 'hostname' => $hostname);
    switch ($linktype) {
        case 'edit':
            $params['dbname'] = $dbname;
            $params['tablename'] = $tablename;
            $params['routinename'] = $routinename;
            break;
        case 'revoke':
            $params['dbname'] = $dbname;
            $params['tablename'] = $tablename;
            $params['routinename'] = $routinename;
            $params['revokeall'] = 1;
            break;
        case 'export':
            $params['initial'] = $initial;
            $params['export'] = 1;
            break;
    }
    $html .= ' href="server_privileges.php' . URL::getCommon($params) . '">';
    switch ($linktype) {
        case 'edit':
            $html .= Util::getIcon('b_usredit.png', __('Edit privileges'));
            break;
        case 'revoke':
            $html .= Util::getIcon('b_usrdrop.png', __('Revoke'));
            break;
        case 'export':
            $html .= Util::getIcon('b_tblexport.png', __('Export'));
            break;
    }
    $html .= '</a>';
    return $html;
}
/**
 * Returns user group edit link
 *
 * @param string $username User name
 *
 * @return string HTML code with link
 */
function PMA_getUserGroupEditLink($username)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getUserGroupEditLink") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2811")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getUserGroupEditLink:2811@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Returns number of defined user groups
 *
 * @return integer $user_group_count
 */
function PMA_getUserGroupCount()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getUserGroupCount") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2826")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getUserGroupCount:2826@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Returns name of user group that user is part of
 *
 * @param string $username User name
 *
 * @return mixed usergroup if found or null if not found
 */
function PMA_getUserGroupForUser($username)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getUserGroupForUser") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2846")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getUserGroupForUser:2846@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * This function return the extra data array for the ajax behavior
 *
 * @param string $password  password
 * @param string $sql_query sql query
 * @param string $hostname  hostname
 * @param string $username  username
 *
 * @return array $extra_data
 */
function PMA_getExtraDataForAjaxBehavior($password, $sql_query, $hostname, $username)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getExtraDataForAjaxBehavior") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 2884")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getExtraDataForAjaxBehavior:2884@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the HTML snippet for change user login information
 *
 * @param string $username username
 * @param string $hostname host name
 *
 * @return string HTML snippet
 */
function PMA_getChangeLoginInformationHtmlForm($username, $hostname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getChangeLoginInformationHtmlForm") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 3029")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getChangeLoginInformationHtmlForm:3029@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Provide a line with links to the relevant database and table
 *
 * @param string $url_dbname url database name that urlencode() string
 * @param string $dbname     database name
 * @param string $tablename  table name
 *
 * @return string HTML snippet
 */
function PMA_getLinkToDbAndTable($url_dbname, $dbname, $tablename)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getLinkToDbAndTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 3094")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getLinkToDbAndTable:3094@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * no db name given, so we want all privs for the given user
 * db name was given, so we want all user specific rights for this db
 * So this function returns user rights as an array
 *
 * @param string $username username
 * @param string $hostname host name
 * @param string $type     database or table
 * @param string $dbname   database name
 *
 * @return array $db_rights database rights
 */
function PMA_getUserSpecificRights($username, $hostname, $type, $dbname = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getUserSpecificRights") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 3146")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getUserSpecificRights:3146@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Parses Proc_priv data
 *
 * @param string $privs Proc_priv
 *
 * @return array
 */
function PMA_parseProcPriv($privs)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_parseProcPriv") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 3258")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_parseProcPriv:3258@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get a HTML table for display user's tabel specific or database specific rights
 *
 * @param string $username username
 * @param string $hostname host name
 * @param string $type     database, table or routine
 * @param string $dbname   database name
 *
 * @return array $html_output
 */
function PMA_getHtmlForAllTableSpecificRights($username, $hostname, $type, $dbname = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForAllTableSpecificRights") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 3286")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForAllTableSpecificRights:3286@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML for display the users overview
 * (if less than 50 users, display them immediately)
 *
 * @param array  $result        ran sql query
 * @param array  $db_rights     user's database rights array
 * @param string $pmaThemeImage a image source link
 * @param string $text_dir      text directory
 *
 * @return string HTML snippet
 */
function PMA_getUsersOverview($result, $db_rights, $pmaThemeImage, $text_dir)
{
    while ($row = $GLOBALS['dbi']->fetchAssoc($result)) {
        $row['privs'] = PMA_extractPrivInfo($row, true);
        $db_rights[$row['User']][$row['Host']] = $row;
    }
    $GLOBALS['dbi']->freeResult($result);
    $user_group_count = 0;
    if ($GLOBALS['cfgRelation']['menuswork']) {
        $user_group_count = PMA_getUserGroupCount();
    }
    $html_output = '<form name="usersForm" id="usersForm" action="server_privileges.php" ' . 'method="post">' . "\n" . URL::getHiddenInputs('', '') . '<table id="tableuserrights" class="data">' . "\n" . '<thead>' . "\n" . '<tr><th></th>' . "\n" . '<th>' . __('User name') . '</th>' . "\n" . '<th>' . __('Host name') . '</th>' . "\n" . '<th>' . __('Password') . '</th>' . "\n" . '<th>' . __('Global privileges') . ' ' . Util::showHint(__('Note: MySQL privilege names are expressed in English.')) . '</th>' . "\n";
    if ($GLOBALS['cfgRelation']['menuswork']) {
        $html_output .= '<th>' . __('User group') . '</th>' . "\n";
    }
    $html_output .= '<th>' . __('Grant') . '</th>' . "\n" . '<th colspan="' . ($user_group_count > 0 ? '3' : '2') . '">' . __('Action') . '</th>' . "\n" . '</tr>' . "\n" . '</thead>' . "\n";
    $html_output .= '<tbody>' . "\n";
    $html_output .= PMA_getHtmlTableBodyForUserRights($db_rights);
    $html_output .= '</tbody>' . '</table>' . "\n";
    $html_output .= '<div class="floatleft">' . Template::get('select_all')->render(array('pmaThemeImage' => $pmaThemeImage, 'text_dir' => $text_dir, 'formName' => 'usersForm')) . "\n";
    $html_output .= Util::getButtonOrImage('submit_mult', 'mult_submit', __('Export'), 'b_tblexport.png', 'export');
    $html_output .= '<input type="hidden" name="initial" ' . 'value="' . (isset($_GET['initial']) ? htmlspecialchars($_GET['initial']) : '') . '" />';
    $html_output .= '</div>' . '<div class="clear_both" style="clear:both"></div>';
    // add/delete user fieldset
    $html_output .= PMA_getFieldsetForAddDeleteUser();
    $html_output .= '</form>' . "\n";
    return $html_output;
}
/**
 * Get table body for 'tableuserrights' table in userform
 *
 * @param array $db_rights user's database rights array
 *
 * @return string HTML snippet
 */
function PMA_getHtmlTableBodyForUserRights($db_rights)
{
    $cfgRelation = PMA_getRelationsParam();
    if ($cfgRelation['menuswork']) {
        $users_table = Util::backquote($cfgRelation['db']) . "." . Util::backquote($cfgRelation['users']);
        $sql_query = 'SELECT * FROM ' . $users_table;
        $result = PMA_queryAsControlUser($sql_query, false);
        $group_assignment = array();
        if ($result) {
            while ($row = $GLOBALS['dbi']->fetchAssoc($result)) {
                $group_assignment[$row['username']] = $row['usergroup'];
            }
        }
        $GLOBALS['dbi']->freeResult($result);
        $user_group_count = PMA_getUserGroupCount();
    }
    $index_checkbox = 0;
    $html_output = '';
    foreach ($db_rights as $user) {
        ksort($user);
        foreach ($user as $host) {
            $index_checkbox++;
            $html_output .= '<tr>' . "\n";
            $html_output .= '<td>' . '<input type="checkbox" class="checkall" name="selected_usr[]" ' . 'id="checkbox_sel_users_' . $index_checkbox . '" value="' . htmlspecialchars($host['User'] . '&amp;#27;' . $host['Host']) . '"' . ' /></td>' . "\n";
            $html_output .= '<td><label ' . 'for="checkbox_sel_users_' . $index_checkbox . '">' . (empty($host['User']) ? '<span style="color: #FF0000">' . __('Any') . '</span>' : htmlspecialchars($host['User'])) . '</label></td>' . "\n" . '<td>' . htmlspecialchars($host['Host']) . '</td>' . "\n";
            $html_output .= '<td>';
            $password_column = 'Password';
            $check_plugin_query = "SELECT * FROM `mysql`.`user` WHERE " . "`User` = '" . $host['User'] . "' AND `Host` = '" . $host['Host'] . "'";
            $res = $GLOBALS['dbi']->fetchSingleRow($check_plugin_query);
            if (isset($res['authentication_string']) && !empty($res['authentication_string']) || isset($res['Password']) && !empty($res['Password'])) {
                $host[$password_column] = 'Y';
            } else {
                $host[$password_column] = 'N';
            }
            switch ($host[$password_column]) {
                case 'Y':
                    $html_output .= __('Yes');
                    break;
                case 'N':
                    $html_output .= '<span style="color: #FF0000">' . __('No') . '</span>';
                    break;
                // this happens if this is a definition not coming from mysql.user
                default:
                    $html_output .= '--';
                    // in future version, replace by "not present"
                    break;
            }
            // end switch
            $html_output .= '</td>' . "\n";
            $html_output .= '<td><code>' . "\n" . '' . implode(',' . "\n" . '            ', $host['privs']) . "\n" . '</code></td>' . "\n";
            if ($cfgRelation['menuswork']) {
                $html_output .= '<td class="usrGroup">' . "\n" . (isset($group_assignment[$host['User']]) ? htmlspecialchars($group_assignment[$host['User']]) : '') . '</td>' . "\n";
            }
            $html_output .= '<td>' . ($host['Grant_priv'] == 'Y' ? __('Yes') : __('No')) . '</td>' . "\n";
            if ($GLOBALS['is_grantuser']) {
                $html_output .= '<td class="center">' . PMA_getUserLink('edit', $host['User'], $host['Host']) . '</td>';
            }
            if ($cfgRelation['menuswork'] && $user_group_count > 0) {
                if (empty($host['User'])) {
                    $html_output .= '<td class="center"></td>';
                } else {
                    $html_output .= '<td class="center">' . PMA_getUserGroupEditLink($host['User']) . '</td>';
                }
            }
            $html_output .= '<td class="center">' . PMA_getUserLink('export', $host['User'], $host['Host'], '', '', '', isset($_GET['initial']) ? $_GET['initial'] : '') . '</td>';
            $html_output .= '</tr>';
        }
    }
    return $html_output;
}
/**
 * Get HTML fieldset for Add/Delete user
 *
 * @return string HTML snippet
 */
function PMA_getFieldsetForAddDeleteUser()
{
    $html_output = PMA_getAddUserHtmlFieldset();
    $html_output .= Template::get('privileges/delete_user_fieldset')->render(array());
    return $html_output;
}
/**
 * Get HTML for Displays the initials
 *
 * @param array $array_initials array for all initials, even non A-Z
 *
 * @return string HTML snippet
 */
function PMA_getHtmlForInitials($array_initials)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForInitials") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 3694")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForInitials:3694@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the database rights array for Display user overview
 *
 * @return array  $db_rights    database rights array
 */
function PMA_getDbRightsForUserOverview()
{
    // we also want users not in table `user` but in other table
    $tables = $GLOBALS['dbi']->fetchResult('SHOW TABLES FROM `mysql`;');
    $tablesSearchForUsers = array('user', 'db', 'tables_priv', 'columns_priv', 'procs_priv');
    $db_rights_sqls = array();
    foreach ($tablesSearchForUsers as $table_search_in) {
        if (in_array($table_search_in, $tables)) {
            $db_rights_sqls[] = 'SELECT DISTINCT `User`, `Host` FROM `mysql`.`' . $table_search_in . '` ' . (isset($_GET['initial']) ? PMA_rangeOfUsers($_GET['initial']) : '');
        }
    }
    $user_defaults = array('User' => '', 'Host' => '%', 'Password' => '?', 'Grant_priv' => 'N', 'privs' => array('USAGE'));
    // for the rights
    $db_rights = array();
    $db_rights_sql = '(' . implode(') UNION (', $db_rights_sqls) . ')' . ' ORDER BY `User` ASC, `Host` ASC';
    $db_rights_result = $GLOBALS['dbi']->query($db_rights_sql);
    while ($db_rights_row = $GLOBALS['dbi']->fetchAssoc($db_rights_result)) {
        $db_rights_row = array_merge($user_defaults, $db_rights_row);
        $db_rights[$db_rights_row['User']][$db_rights_row['Host']] = $db_rights_row;
    }
    $GLOBALS['dbi']->freeResult($db_rights_result);
    ksort($db_rights);
    return $db_rights;
}
/**
 * Delete user and get message and sql query for delete user in privileges
 *
 * @param array $queries queries
 *
 * @return array Message
 */
function PMA_deleteUser($queries)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_deleteUser") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 3788")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_deleteUser:3788@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Update the privileges and return the success or error message
 *
 * @param string $username  username
 * @param string $hostname  host name
 * @param string $tablename table name
 * @param string $dbname    database name
 * @param string $itemType  item type
 *
 * @return Message success message or error message for update
 */
function PMA_updatePrivileges($username, $hostname, $tablename, $dbname, $itemType)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_updatePrivileges") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 3832")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_updatePrivileges:3832@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get List of information: Changes / copies a user
 *
 * @return array
 */
function PMA_getDataForChangeOrCopyUser()
{
    $queries = null;
    $password = null;
    if (isset($_REQUEST['change_copy'])) {
        $user_host_condition = ' WHERE `User` = ' . "'" . $GLOBALS['dbi']->escapeString($_REQUEST['old_username']) . "'" . ' AND `Host` = ' . "'" . $GLOBALS['dbi']->escapeString($_REQUEST['old_hostname']) . "';";
        $row = $GLOBALS['dbi']->fetchSingleRow('SELECT * FROM `mysql`.`user` ' . $user_host_condition);
        if (!$row) {
            $response = Response::getInstance();
            $response->addHTML(Message::notice(__('No user found.'))->getDisplay());
            unset($_REQUEST['change_copy']);
        } else {
            extract($row, EXTR_OVERWRITE);
            foreach ($row as $key => $value) {
                $GLOBALS[$key] = $value;
            }
            // Recent MySQL versions have the field "Password" in mysql.user,
            // so the previous extract creates $Password but this script
            // uses $password
            if (!isset($password) && isset($Password)) {
                $password = $Password;
            }
            if (Util::getServerType() == 'MySQL' && PMA_MYSQL_INT_VERSION >= 50606 && PMA_MYSQL_INT_VERSION < 50706 && (isset($authentication_string) && empty($password) || isset($plugin) && $plugin == 'sha256_password')) {
                $password = $authentication_string;
            }
            if (Util::getServerType() == 'MariaDB' && PMA_MYSQL_INT_VERSION >= 50500 && isset($authentication_string) && empty($password)) {
                $password = $authentication_string;
            }
            // Always use 'authentication_string' column
            // for MySQL 5.7.6+ since it does not have
            // the 'password' column at all
            if (Util::getServerType() == 'MySQL' && PMA_MYSQL_INT_VERSION >= 50706 && isset($authentication_string)) {
                $password = $authentication_string;
            }
            $queries = array();
        }
    }
    return array($queries, $password);
}
/**
 * Update Data for information: Deletes users
 *
 * @param array $queries queries array
 *
 * @return array
 */
function PMA_getDataForDeleteUsers($queries)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDataForDeleteUsers") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 3973")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDataForDeleteUsers:3973@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * update Message For Reload
 *
 * @return array
 */
function PMA_updateMessageForReload()
{
    $message = null;
    if (isset($_REQUEST['flush_privileges'])) {
        $sql_query = 'FLUSH PRIVILEGES;';
        $GLOBALS['dbi']->query($sql_query);
        $message = Message::success(__('The privileges were reloaded successfully.'));
    }
    if (isset($_REQUEST['validate_username'])) {
        $message = Message::success();
    }
    return $message;
}
/**
 * update Data For Queries from queries_for_display
 *
 * @param array      $queries             queries array
 * @param array|null $queries_for_display queries array for display
 *
 * @return null
 */
function PMA_getDataForQueries($queries, $queries_for_display)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDataForQueries") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 4042")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDataForQueries:4042@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * update Data for information: Adds a user
 *
 * @param string $dbname      db name
 * @param string $username    user name
 * @param string $hostname    host name
 * @param string $password    password
 * @param bool   $is_menuwork is_menuwork set?
 *
 * @return array
 */
function PMA_addUser($dbname, $username, $hostname, $password, $is_menuwork)
{
    $_add_user_error = false;
    $message = null;
    $queries = null;
    $queries_for_display = null;
    $sql_query = null;
    if (!isset($_REQUEST['adduser_submit']) && !isset($_REQUEST['change_copy'])) {
        return array($message, $queries, $queries_for_display, $sql_query, $_add_user_error);
    }
    $sql_query = '';
    if ($_POST['pred_username'] == 'any') {
        $username = '';
    }
    switch ($_POST['pred_hostname']) {
        case 'any':
            $hostname = '%';
            break;
        case 'localhost':
            $hostname = 'localhost';
            break;
        case 'hosttable':
            $hostname = '';
            break;
        case 'thishost':
            $_user_name = $GLOBALS['dbi']->fetchValue('SELECT USER()');
            $hostname = mb_substr($_user_name, mb_strrpos($_user_name, '@') + 1);
            unset($_user_name);
            break;
    }
    $sql = "SELECT '1' FROM `mysql`.`user`" . " WHERE `User` = '" . $GLOBALS['dbi']->escapeString($username) . "'" . " AND `Host` = '" . $GLOBALS['dbi']->escapeString($hostname) . "';";
    if ($GLOBALS['dbi']->fetchValue($sql) == 1) {
        $message = Message::error(__('The user %s already exists!'));
        $message->addParam('[em]\'' . $username . '\'@\'' . $hostname . '\'[/em]');
        $_REQUEST['adduser'] = true;
        $_add_user_error = true;
        return array($message, $queries, $queries_for_display, $sql_query, $_add_user_error);
    }
    list($create_user_real, $create_user_show, $real_sql_query, $sql_query, $password_set_real, $password_set_show) = PMA_getSqlQueriesForDisplayAndAddUser($username, $hostname, isset($password) ? $password : '');
    if (empty($_REQUEST['change_copy'])) {
        $_error = false;
        if (isset($create_user_real)) {
            if (!$GLOBALS['dbi']->tryQuery($create_user_real)) {
                $_error = true;
            }
            if (isset($password_set_real) && !empty($password_set_real) && isset($_REQUEST['authentication_plugin'])) {
                PMA_setProperPasswordHashing($_REQUEST['authentication_plugin']);
                if ($GLOBALS['dbi']->tryQuery($password_set_real)) {
                    $sql_query .= $password_set_show;
                }
            }
            $sql_query = $create_user_show . $sql_query;
        }
        list($sql_query, $message) = PMA_addUserAndCreateDatabase($_error, $real_sql_query, $sql_query, $username, $hostname, isset($dbname) ? $dbname : null);
        if (!empty($_REQUEST['userGroup']) && $is_menuwork) {
            PMA_setUserGroup($GLOBALS['username'], $_REQUEST['userGroup']);
        }
        return array($message, $queries, $queries_for_display, $sql_query, $_add_user_error);
    }
    // Copy the user group while copying a user
    $old_usergroup = isset($_REQUEST['old_usergroup']) ? $_REQUEST['old_usergroup'] : null;
    PMA_setUserGroup($_REQUEST['username'], $old_usergroup);
    if (isset($create_user_real)) {
        $queries[] = $create_user_real;
    }
    $queries[] = $real_sql_query;
    if (isset($password_set_real) && !empty($password_set_real) && isset($_REQUEST['authentication_plugin'])) {
        PMA_setProperPasswordHashing($_REQUEST['authentication_plugin']);
        $queries[] = $password_set_real;
    }
    // we put the query containing the hidden password in
    // $queries_for_display, at the same position occupied
    // by the real query in $queries
    $tmp_count = count($queries);
    if (isset($create_user_real)) {
        $queries_for_display[$tmp_count - 2] = $create_user_show;
    }
    if (isset($password_set_real) && !empty($password_set_real)) {
        $queries_for_display[$tmp_count - 3] = $create_user_show;
        $queries_for_display[$tmp_count - 2] = $sql_query;
        $queries_for_display[$tmp_count - 1] = $password_set_show;
    } else {
        $queries_for_display[$tmp_count - 1] = $sql_query;
    }
    return array($message, $queries, $queries_for_display, $sql_query, $_add_user_error);
}
/**
 * Sets proper value of `old_passwords` according to
 * the authentication plugin selected
 *
 * @param string $auth_plugin authentication plugin selected
 *
 * @return void
 */
function PMA_setProperPasswordHashing($auth_plugin)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_setProperPasswordHashing") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 4225")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_setProperPasswordHashing:4225@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Update DB information: DB, Table, isWildcard
 *
 * @return array
 */
function PMA_getDataForDBInfo()
{
    $username = null;
    $hostname = null;
    $dbname = null;
    $tablename = null;
    $routinename = null;
    $dbname_is_wildcard = null;
    if (isset($_REQUEST['username'])) {
        $username = $_REQUEST['username'];
    }
    if (isset($_REQUEST['hostname'])) {
        $hostname = $_REQUEST['hostname'];
    }
    /**
     * Checks if a dropdown box has been used for selecting a database / table
     */
    if (PMA_isValid($_REQUEST['pred_tablename'])) {
        $tablename = $_REQUEST['pred_tablename'];
    } elseif (PMA_isValid($_REQUEST['tablename'])) {
        $tablename = $_REQUEST['tablename'];
    } else {
        unset($tablename);
    }
    if (PMA_isValid($_REQUEST['pred_routinename'])) {
        $routinename = $_REQUEST['pred_routinename'];
    } elseif (PMA_isValid($_REQUEST['routinename'])) {
        $routinename = $_REQUEST['routinename'];
    } else {
        unset($routinename);
    }
    if (isset($_REQUEST['pred_dbname'])) {
        $is_valid_pred_dbname = true;
        foreach ($_REQUEST['pred_dbname'] as $key => $db_name) {
            if (!PMA_isValid($db_name)) {
                $is_valid_pred_dbname = false;
                break;
            }
        }
    }
    if (isset($_REQUEST['dbname'])) {
        $is_valid_dbname = true;
        if (is_array($_REQUEST['dbname'])) {
            foreach ($_REQUEST['dbname'] as $key => $db_name) {
                if (!PMA_isValid($db_name)) {
                    $is_valid_dbname = false;
                    break;
                }
            }
        } else {
            if (!PMA_isValid($_REQUEST['dbname'])) {
                $is_valid_dbname = false;
            }
        }
    }
    if (isset($is_valid_pred_dbname) && $is_valid_pred_dbname) {
        $dbname = $_REQUEST['pred_dbname'];
        // If dbname contains only one database.
        if (count($dbname) == 1) {
            $dbname = $dbname[0];
        }
    } elseif (isset($is_valid_dbname) && $is_valid_dbname) {
        $dbname = $_REQUEST['dbname'];
    } else {
        unset($dbname);
        unset($tablename);
    }
    if (isset($dbname)) {
        if (is_array($dbname)) {
            $db_and_table = $dbname;
            foreach ($db_and_table as $key => $db_name) {
                $db_and_table[$key] .= '.';
            }
        } else {
            $unescaped_db = Util::unescapeMysqlWildcards($dbname);
            $db_and_table = Util::backquote($unescaped_db) . '.';
        }
        if (isset($tablename)) {
            $db_and_table .= Util::backquote($tablename);
        } else {
            if (is_array($db_and_table)) {
                foreach ($db_and_table as $key => $db_name) {
                    $db_and_table[$key] .= '*';
                }
            } else {
                $db_and_table .= '*';
            }
        }
    } else {
        $db_and_table = '*.*';
    }
    // check if given $dbname is a wildcard or not
    if (isset($dbname)) {
        //if (preg_match('/\\\\(?:_|%)/i', $dbname)) {
        if (!is_array($dbname) && preg_match('/(?<!\\\\)(?:_|%)/i', $dbname)) {
            $dbname_is_wildcard = true;
        } else {
            $dbname_is_wildcard = false;
        }
    }
    return array($username, $hostname, isset($dbname) ? $dbname : null, isset($tablename) ? $tablename : null, isset($routinename) ? $routinename : null, $db_and_table, $dbname_is_wildcard);
}
/**
 * Get title and textarea for export user definition in Privileges
 *
 * @param string $username username
 * @param string $hostname host name
 *
 * @return array ($title, $export)
 */
function PMA_getListForExportUserDefinition($username, $hostname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getListForExportUserDefinition") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 4367")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getListForExportUserDefinition:4367@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML for display Add userfieldset
 *
 * @param string $db    the database
 * @param string $table the table name
 *
 * @return string html output
 */
function PMA_getAddUserHtmlFieldset($db = '', $table = '')
{
    if (!$GLOBALS['is_createuser']) {
        return '';
    }
    $rel_params = array();
    $url_params = array('adduser' => 1);
    if (!empty($db)) {
        $url_params['dbname'] = $rel_params['checkprivsdb'] = $db;
    }
    if (!empty($table)) {
        $url_params['tablename'] = $rel_params['checkprivstable'] = $table;
    }
    return Template::get('privileges/add_user_fieldset')->render(array('url_params' => $url_params, 'rel_params' => $rel_params));
}
/**
 * Get HTML header for display User's properties
 *
 * @param boolean $dbname_is_wildcard whether database name is wildcard or not
 * @param string  $url_dbname         url database name that urlencode() string
 * @param string  $dbname             database name
 * @param string  $username           username
 * @param string  $hostname           host name
 * @param string  $entity_name        entity (table or routine) name
 * @param string  $entity_type        optional, type of entity ('table' or 'routine')
 *
 * @return string $html_output
 */
function PMA_getHtmlHeaderForUserProperties($dbname_is_wildcard, $url_dbname, $dbname, $username, $hostname, $entity_name, $entity_type = 'table')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlHeaderForUserProperties") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 4460")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlHeaderForUserProperties:4460@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get HTML snippet for display user overview page
 *
 * @param string $pmaThemeImage a image source link
 * @param string $text_dir      text directory
 *
 * @return string $html_output
 */
function PMA_getHtmlForUserOverview($pmaThemeImage, $text_dir)
{
    $html_output = '<h2>' . "\n" . Util::getIcon('b_usrlist.png') . __('User accounts overview') . "\n" . '</h2>' . "\n";
    $password_column = 'Password';
    $server_type = Util::getServerType();
    if (($server_type == 'MySQL' || $server_type == 'Percona Server') && PMA_MYSQL_INT_VERSION >= 50706) {
        $password_column = 'authentication_string';
    }
    // $sql_query is for the initial-filtered,
    // $sql_query_all is for counting the total no. of users
    $sql_query = $sql_query_all = 'SELECT *,' . " IF(`" . $password_column . "` = _latin1 '', 'N', 'Y') AS 'Password'" . ' FROM `mysql`.`user`';
    $sql_query .= isset($_REQUEST['initial']) ? PMA_rangeOfUsers($_REQUEST['initial']) : '';
    $sql_query .= ' ORDER BY `User` ASC, `Host` ASC;';
    $sql_query_all .= ' ;';
    $res = $GLOBALS['dbi']->tryQuery($sql_query, null, PMA\libraries\DatabaseInterface::QUERY_STORE);
    $res_all = $GLOBALS['dbi']->tryQuery($sql_query_all, null, PMA\libraries\DatabaseInterface::QUERY_STORE);
    if (!$res) {
        // the query failed! This may have two reasons:
        // - the user does not have enough privileges
        // - the privilege tables use a structure of an earlier version.
        // so let's try a more simple query
        $GLOBALS['dbi']->freeResult($res);
        $GLOBALS['dbi']->freeResult($res_all);
        $sql_query = 'SELECT * FROM `mysql`.`user`';
        $res = $GLOBALS['dbi']->tryQuery($sql_query, null, PMA\libraries\DatabaseInterface::QUERY_STORE);
        if (!$res) {
            $html_output .= PMA_getHtmlForViewUsersError();
            $html_output .= PMA_getAddUserHtmlFieldset();
        } else {
            // This message is hardcoded because I will replace it by
            // a automatic repair feature soon.
            $raw = 'Your privilege table structure seems to be older than' . ' this MySQL version!<br />' . 'Please run the <code>mysql_upgrade</code> command' . ' that should be included in your MySQL server distribution' . ' to solve this problem!';
            $html_output .= Message::rawError($raw)->getDisplay();
        }
        $GLOBALS['dbi']->freeResult($res);
    } else {
        $db_rights = PMA_getDbRightsForUserOverview();
        // for all initials, even non A-Z
        $array_initials = array();
        foreach ($db_rights as $right) {
            foreach ($right as $account) {
                if (empty($account['User']) && $account['Host'] == 'localhost') {
                    $html_output .= Message::notice(__('A user account allowing any user from localhost to ' . 'connect is present. This will prevent other users ' . 'from connecting if the host part of their account ' . 'allows a connection from any (%) host.') . Util::showMySQLDocu('problems-connecting'))->getDisplay();
                    break 2;
                }
            }
        }
        /**
         * Displays the initials
         * Also not necessary if there is less than 20 privileges
         */
        if ($GLOBALS['dbi']->numRows($res_all) > 20) {
            $html_output .= PMA_getHtmlForInitials($array_initials);
        }
        /**
         * Display the user overview
         * (if less than 50 users, display them immediately)
         */
        if (isset($_REQUEST['initial']) || isset($_REQUEST['showall']) || $GLOBALS['dbi']->numRows($res) < 50) {
            $html_output .= PMA_getUsersOverview($res, $db_rights, $pmaThemeImage, $text_dir);
        } else {
            $html_output .= PMA_getAddUserHtmlFieldset();
        }
        // end if (display overview)
        $response = Response::getInstance();
        if (!$response->isAjax() || !empty($_REQUEST['ajax_page_request'])) {
            if ($GLOBALS['is_reload_priv']) {
                $flushnote = new Message(__('Note: phpMyAdmin gets the users\' privileges directly ' . 'from MySQL\'s privilege tables. The content of these ' . 'tables may differ from the privileges the server uses, ' . 'if they have been changed manually. In this case, ' . 'you should %sreload the privileges%s before you continue.'), Message::NOTICE);
                $flushnote->addParamHtml('<a href="server_privileges.php' . URL::getCommon(array('flush_privileges' => 1)) . '" id="reload_privileges_anchor">');
                $flushnote->addParamHtml('</a>');
            } else {
                $flushnote = new Message(__('Note: phpMyAdmin gets the users\' privileges directly ' . 'from MySQL\'s privilege tables. The content of these ' . 'tables may differ from the privileges the server uses, ' . 'if they have been changed manually. In this case, ' . 'the privileges have to be reloaded but currently, you ' . 'don\'t have the RELOAD privilege.') . Util::showMySQLDocu('privileges-provided', false, 'priv_reload'), Message::NOTICE);
            }
            $html_output .= $flushnote->getDisplay();
        }
    }
    return $html_output;
}
/**
 * Get HTML snippet for display user properties
 *
 * @param boolean $dbname_is_wildcard whether database name is wildcard or not
 * @param string  $url_dbname         url database name that urlencode() string
 * @param string  $username           username
 * @param string  $hostname           host name
 * @param string  $dbname             database name
 * @param string  $tablename          table name
 *
 * @return string $html_output
 */
function PMA_getHtmlForUserProperties($dbname_is_wildcard, $url_dbname, $username, $hostname, $dbname, $tablename)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForUserProperties") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 4721")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForUserProperties:4721@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get queries for Table privileges to change or copy user
 *
 * @param string $user_host_condition user host condition to
 *                                    select relevant table privileges
 * @param array  $queries             queries array
 * @param string $username            username
 * @param string $hostname            host name
 *
 * @return array  $queries
 */
function PMA_getTablePrivsQueriesForChangeOrCopyUser($user_host_condition, $queries, $username, $hostname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getTablePrivsQueriesForChangeOrCopyUser") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 4820")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getTablePrivsQueriesForChangeOrCopyUser:4820@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get queries for database specific privileges for change or copy user
 *
 * @param array  $queries  queries array with string
 * @param string $username username
 * @param string $hostname host name
 *
 * @return array $queries
 */
function PMA_getDbSpecificPrivsQueriesForChangeOrCopyUser($queries, $username, $hostname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDbSpecificPrivsQueriesForChangeOrCopyUser") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 4907")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDbSpecificPrivsQueriesForChangeOrCopyUser:4907@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Prepares queries for adding users and
 * also create database and return query and message
 *
 * @param boolean $_error         whether user create or not
 * @param string  $real_sql_query SQL query for add a user
 * @param string  $sql_query      SQL query to be displayed
 * @param string  $username       username
 * @param string  $hostname       host name
 * @param string  $dbname         database name
 *
 * @return array  $sql_query, $message
 */
function PMA_addUserAndCreateDatabase($_error, $real_sql_query, $sql_query, $username, $hostname, $dbname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_addUserAndCreateDatabase") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 4948")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_addUserAndCreateDatabase:4948@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get the hashed string for password
 *
 * @param string $password password
 *
 * @return string $hashedPassword
 */
function PMA_getHashedPassword($password)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHashedPassword") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 5030")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHashedPassword:5030@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Check if MariaDB's 'simple_password_check'
 * OR 'cracklib_password_check' is ACTIVE
 *
 * @return boolean if atleast one of the plugins is ACTIVE
 */
function PMA_checkIfMariaDBPwdCheckPluginActive()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_checkIfMariaDBPwdCheckPluginActive") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 5047")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_checkIfMariaDBPwdCheckPluginActive:5047@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Get SQL queries for Display and Add user
 *
 * @param string $username username
 * @param string $hostname host name
 * @param string $password password
 *
 * @return array ($create_user_real, $create_user_show,$real_sql_query, $sql_query
 *                $password_set_real, $password_set_show)
 */
function PMA_getSqlQueriesForDisplayAndAddUser($username, $hostname, $password)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getSqlQueriesForDisplayAndAddUser") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 5082")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getSqlQueriesForDisplayAndAddUser:5082@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}
/**
 * Returns the type ('PROCEDURE' or 'FUNCTION') of the routine
 *
 * @param string $dbname      database
 * @param string $routineName routine
 *
 * @return string type
 */
function PMA_getRoutineType($dbname, $routineName)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getRoutineType") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php at line 5289")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getRoutineType:5289@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/server_privileges.lib.php');
    die();
}