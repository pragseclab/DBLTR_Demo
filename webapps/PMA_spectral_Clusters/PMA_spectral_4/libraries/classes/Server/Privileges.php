<?php

/**
 * set of functions with the Privileges section in pma
 */
declare (strict_types=1);
namespace PhpMyAdmin\Server;

use PhpMyAdmin\Core;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Html\MySQLDocumentation;
use PhpMyAdmin\Message;
use PhpMyAdmin\Query\Compatibility;
use PhpMyAdmin\Relation;
use PhpMyAdmin\RelationCleanup;
use PhpMyAdmin\Response;
use PhpMyAdmin\Template;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use function array_map;
use function array_merge;
use function array_unique;
use function count;
use function explode;
use function htmlspecialchars;
use function implode;
use function in_array;
use function is_array;
use function ksort;
use function max;
use function mb_chr;
use function mb_strpos;
use function mb_strrpos;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_substr;
use function preg_match;
use function preg_replace;
use function sprintf;
use function str_replace;
use function strlen;
use function strpos;
use function trim;
use function uksort;
/**
 * Privileges class
 */
class Privileges
{
    /** @var Template */
    public $template;
    /** @var RelationCleanup */
    private $relationCleanup;
    /** @var DatabaseInterface */
    public $dbi;
    /** @var Relation */
    public $relation;
    /**
     * @param Template          $template        Template object
     * @param DatabaseInterface $dbi             DatabaseInterface object
     * @param Relation          $relation        Relation object
     * @param RelationCleanup   $relationCleanup RelationCleanup object
     */
    public function __construct(Template $template, $dbi, Relation $relation, RelationCleanup $relationCleanup)
    {
        $this->template = $template;
        $this->dbi = $dbi;
        $this->relation = $relation;
        $this->relationCleanup = $relationCleanup;
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
    public function wildcardEscapeForGrant(string $dbname, string $tablename) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wildcardEscapeForGrant") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 89")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wildcardEscapeForGrant:89@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Generates a condition on the user name
     *
     * @param string $initial the user's initial
     *
     * @return string   the generated condition
     */
    public function rangeOfUsers($initial = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("rangeOfUsers") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 108")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called rangeOfUsers:108@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Parses privileges into an array, it modifies the array
     *
     * @param array $row Results row from
     *
     * @return void
     */
    public function fillInTablePrivileges(array &$row)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fillInTablePrivileges") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 122")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fillInTablePrivileges:122@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Extracts the privilege information of a priv table row
     *
     * @param array|null $row        the row
     * @param bool       $enableHTML add <dfn> tag with tooltips
     * @param bool       $tablePrivs whether row contains table privileges
     *
     * @return array
     *
     * @global resource $user_link the database connection
     */
    public function extractPrivInfo($row = null, $enableHTML = false, $tablePrivs = false)
    {
        if ($tablePrivs) {
            $grants = $this->getTableGrantsArray();
        } else {
            $grants = $this->getGrantsArray();
        }
        if ($row !== null && isset($row['Table_priv'])) {
            $this->fillInTablePrivileges($row);
        }
        $privs = [];
        $allPrivileges = true;
        foreach ($grants as $current_grant) {
            if (($row === null || !isset($row[$current_grant[0]])) && ($row !== null || !isset($GLOBALS[$current_grant[0]]))) {
                continue;
            }
            if ($row !== null && $row[$current_grant[0]] === 'Y' || $row === null && ($GLOBALS[$current_grant[0]] === 'Y' || is_array($GLOBALS[$current_grant[0]]) && count($GLOBALS[$current_grant[0]]) == $_REQUEST['column_count'] && empty($GLOBALS[$current_grant[0] . '_none']))) {
                if ($enableHTML) {
                    $privs[] = '<dfn title="' . $current_grant[2] . '">' . $current_grant[1] . '</dfn>';
                } else {
                    $privs[] = $current_grant[1];
                }
            } elseif (!empty($GLOBALS[$current_grant[0]]) && is_array($GLOBALS[$current_grant[0]]) && empty($GLOBALS[$current_grant[0] . '_none'])) {
                // Required for proper escaping of ` (backtick) in a column name
                $grant_cols = array_map(
                    /** @param string $val */
                    static function ($val) {
                        return Util::backquote($val);
                    },
                    $GLOBALS[$current_grant[0]]
                );
                if ($enableHTML) {
                    $privs[] = '<dfn title="' . $current_grant[2] . '">' . $current_grant[1] . '</dfn>' . ' (' . implode(', ', $grant_cols) . ')';
                } else {
                    $privs[] = $current_grant[1] . ' (' . implode(', ', $grant_cols) . ')';
                }
            } else {
                $allPrivileges = false;
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
                $privs = ['<dfn title="' . __('Includes all privileges except GRANT.') . '">ALL PRIVILEGES</dfn>'];
            } else {
                $privs = ['ALL PRIVILEGES'];
            }
        }
        return $privs;
    }
    /**
     * Returns an array of table grants and their descriptions
     *
     * @return array array of table grants
     */
    public function getTableGrantsArray()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTableGrantsArray") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 207")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTableGrantsArray:207@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get the grants array which contains all the privilege types
     * and relevant grant messages
     *
     * @return array
     */
    public function getGrantsArray()
    {
        return [
            ['Select_priv', 'SELECT', __('Allows reading data.')],
            ['Insert_priv', 'INSERT', __('Allows inserting and replacing data.')],
            ['Update_priv', 'UPDATE', __('Allows changing data.')],
            ['Delete_priv', 'DELETE', __('Allows deleting data.')],
            ['Create_priv', 'CREATE', __('Allows creating new databases and tables.')],
            ['Drop_priv', 'DROP', __('Allows dropping databases and tables.')],
            ['Reload_priv', 'RELOAD', __('Allows reloading server settings and flushing the server\'s caches.')],
            ['Shutdown_priv', 'SHUTDOWN', __('Allows shutting down the server.')],
            ['Process_priv', 'PROCESS', __('Allows viewing processes of all users.')],
            ['File_priv', 'FILE', __('Allows importing data from and exporting data into files.')],
            ['References_priv', 'REFERENCES', __('Has no effect in this MySQL version.')],
            ['Index_priv', 'INDEX', __('Allows creating and dropping indexes.')],
            ['Alter_priv', 'ALTER', __('Allows altering the structure of existing tables.')],
            ['Show_db_priv', 'SHOW DATABASES', __('Gives access to the complete list of databases.')],
            ['Super_priv', 'SUPER', __('Allows connecting, even if maximum number of connections ' . 'is reached; required for most administrative operations ' . 'like setting global variables or killing threads of other users.')],
            ['Create_tmp_table_priv', 'CREATE TEMPORARY TABLES', __('Allows creating temporary tables.')],
            ['Lock_tables_priv', 'LOCK TABLES', __('Allows locking tables for the current thread.')],
            ['Repl_slave_priv', 'REPLICATION SLAVE', __('Needed for the replication slaves.')],
            ['Repl_client_priv', 'REPLICATION CLIENT', __('Allows the user to ask where the slaves / masters are.')],
            ['Create_view_priv', 'CREATE VIEW', __('Allows creating new views.')],
            ['Event_priv', 'EVENT', __('Allows to set up events for the event scheduler.')],
            ['Trigger_priv', 'TRIGGER', __('Allows creating and dropping triggers.')],
            // for table privs:
            ['Create View_priv', 'CREATE VIEW', __('Allows creating new views.')],
            ['Show_view_priv', 'SHOW VIEW', __('Allows performing SHOW CREATE VIEW queries.')],
            // for table privs:
            ['Show view_priv', 'SHOW VIEW', __('Allows performing SHOW CREATE VIEW queries.')],
            [
                'Delete_history_priv',
                'DELETE HISTORY',
                // phpcs:ignore Generic.Files.LineLength.TooLong
                /* l10n: https://mariadb.com/kb/en/library/grant/#table-privileges "Remove historical rows from a table using the DELETE HISTORY statement" */
                __('Allows deleting historical rows.'),
            ],
            [
                'Delete versioning rows_priv',
                'DELETE HISTORY',
                // phpcs:ignore Generic.Files.LineLength.TooLong
                /* l10n: https://mariadb.com/kb/en/library/grant/#table-privileges "Remove historical rows from a table using the DELETE HISTORY statement" */
                __('Allows deleting historical rows.'),
            ],
            ['Create_routine_priv', 'CREATE ROUTINE', __('Allows creating stored routines.')],
            ['Alter_routine_priv', 'ALTER ROUTINE', __('Allows altering and dropping stored routines.')],
            ['Create_user_priv', 'CREATE USER', __('Allows creating, dropping and renaming user accounts.')],
            ['Execute_priv', 'EXECUTE', __('Allows executing stored routines.')],
        ];
    }
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
    public function getSqlQueryForDisplayPrivTable($db, $table, $username, $hostname)
    {
        if ($db === '*') {
            return 'SELECT * FROM `mysql`.`user`' . " WHERE `User` = '" . $this->dbi->escapeString($username) . "'" . " AND `Host` = '" . $this->dbi->escapeString($hostname) . "';";
        }
        if ($table === '*') {
            return 'SELECT * FROM `mysql`.`db`' . " WHERE `User` = '" . $this->dbi->escapeString($username) . "'" . " AND `Host` = '" . $this->dbi->escapeString($hostname) . "'" . " AND '" . $this->dbi->escapeString(Util::unescapeMysqlWildcards($db)) . "'" . ' LIKE `Db`;';
        }
        return 'SELECT `Table_priv`' . ' FROM `mysql`.`tables_priv`' . " WHERE `User` = '" . $this->dbi->escapeString($username) . "'" . " AND `Host` = '" . $this->dbi->escapeString($hostname) . "'" . " AND `Db` = '" . $this->dbi->escapeString(Util::unescapeMysqlWildcards($db)) . "'" . " AND `Table_name` = '" . $this->dbi->escapeString($table) . "';";
    }
    /**
     * Displays a dropdown to select the user group
     * with menu items configured to each of them.
     *
     * @param string $username username
     *
     * @return string html to select the user group
     */
    public function getHtmlToChooseUserGroup($username)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlToChooseUserGroup") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 295")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlToChooseUserGroup:295@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
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
    public function setUserGroup($username, $userGroup)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setUserGroup") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 324")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setUserGroup:324@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Displays the privileges form table
     *
     * @param string $db     the database
     * @param string $table  the table
     * @param bool   $submit whether to display the submit button or not
     *
     * @return string html snippet
     *
     * @global array     $cfg         the phpMyAdmin configuration
     * @global resource  $user_link   the database connection
     */
    public function getHtmlToDisplayPrivilegesTable($db = '*', $table = '*', $submit = true)
    {
        $sql_query = '';
        if ($db === '*') {
            $table = '*';
        }
        $username = '';
        $hostname = '';
        $row = [];
        if (isset($GLOBALS['username'])) {
            $username = $GLOBALS['username'];
            $hostname = $GLOBALS['hostname'];
            $sql_query = $this->getSqlQueryForDisplayPrivTable($db, $table, $username, $hostname);
            $row = $this->dbi->fetchSingleRow($sql_query);
        }
        if (empty($row)) {
            if ($table === '*' && $this->dbi->isSuperUser()) {
                $row = [];
                if ($db === '*') {
                    $sql_query = 'SHOW COLUMNS FROM `mysql`.`user`;';
                } elseif ($table === '*') {
                    $sql_query = 'SHOW COLUMNS FROM `mysql`.`db`;';
                }
                $res = $this->dbi->query($sql_query);
                while ($row1 = $this->dbi->fetchRow($res)) {
                    if (mb_substr($row1[0], 0, 4) === 'max_') {
                        $row[$row1[0]] = 0;
                    } elseif (mb_substr($row1[0], 0, 5) === 'x509_' || mb_substr($row1[0], 0, 4) === 'ssl_') {
                        $row[$row1[0]] = '';
                    } else {
                        $row[$row1[0]] = 'N';
                    }
                }
                $this->dbi->freeResult($res);
            } elseif ($table === '*') {
                $row = [];
            } else {
                $row = ['Table_priv' => ''];
            }
        }
        if (isset($row['Table_priv'])) {
            $this->fillInTablePrivileges($row);
            // get columns
            $res = $this->dbi->tryQuery('SHOW COLUMNS FROM ' . Util::backquote(Util::unescapeMysqlWildcards($db)) . '.' . Util::backquote($table) . ';');
            $columns = [];
            if ($res) {
                while ($row1 = $this->dbi->fetchRow($res)) {
                    $columns[$row1[0]] = ['Select' => false, 'Insert' => false, 'Update' => false, 'References' => false];
                }
                $this->dbi->freeResult($res);
            }
        }
        if (!empty($columns)) {
            $res = $this->dbi->query('SELECT `Column_name`, `Column_priv`' . ' FROM `mysql`.`columns_priv`' . ' WHERE `User`' . ' = \'' . $this->dbi->escapeString($username) . "'" . ' AND `Host`' . ' = \'' . $this->dbi->escapeString($hostname) . "'" . ' AND `Db`' . ' = \'' . $this->dbi->escapeString(Util::unescapeMysqlWildcards($db)) . "'" . ' AND `Table_name`' . ' = \'' . $this->dbi->escapeString($table) . '\';');
            while ($row1 = $this->dbi->fetchRow($res)) {
                $row1[1] = explode(',', $row1[1]);
                foreach ($row1[1] as $current) {
                    $columns[$row1[0]][$current] = true;
                }
            }
            $this->dbi->freeResult($res);
        }
        return $this->template->render('server/privileges/privileges_table', ['is_global' => $db === '*', 'is_database' => $table === '*', 'row' => $row, 'columns' => $columns ?? [], 'has_submit' => $submit, 'supports_references_privilege' => Compatibility::supportsReferencesPrivilege($this->dbi), 'is_mariadb' => $this->dbi->isMariaDB()]);
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
     * @return string
     */
    public function getHtmlForRoutineSpecificPrivileges($username, $hostname, $db, $routine, $url_dbname)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForRoutineSpecificPrivileges") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 435")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForRoutineSpecificPrivileges:435@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Gets the currently active authentication plugins
     *
     * @return array  array of plugin names and descriptions
     */
    public function getActiveAuthPlugins()
    {
        $get_plugins_query = 'SELECT `PLUGIN_NAME`, `PLUGIN_DESCRIPTION`' . ' FROM `information_schema`.`PLUGINS` ' . "WHERE `PLUGIN_TYPE` = 'AUTHENTICATION';";
        $resultset = $this->dbi->query($get_plugins_query);
        $result = [];
        while ($row = $this->dbi->fetchAssoc($resultset)) {
            // if description is known, enable its translation
            if ($row['PLUGIN_NAME'] === 'mysql_native_password') {
                $row['PLUGIN_DESCRIPTION'] = __('Native MySQL authentication');
            } elseif ($row['PLUGIN_NAME'] === 'sha256_password') {
                $row['PLUGIN_DESCRIPTION'] = __('SHA256 password authentication');
            }
            $result[$row['PLUGIN_NAME']] = $row['PLUGIN_DESCRIPTION'];
        }
        return $result;
    }
    /**
     * Displays the fields used by the "new user" form as well as the
     * "change login information / copy user" form.
     *
     * @param string $mode are we creating a new user or are we just
     *                     changing  one? (allowed values: 'new', 'change')
     * @param string $user User name
     * @param string $host Host name
     *
     * @return string  a HTML snippet
     */
    public function getHtmlForLoginInformationFields($mode = 'new', $user = null, $host = null)
    {
        global $pred_username, $pred_hostname, $username, $hostname, $new_username;
        [$usernameLength, $hostnameLength] = $this->getUsernameAndHostnameLength();
        if (isset($username) && strlen($username) === 0) {
            $pred_username = 'any';
        }
        $currentUser = $this->dbi->fetchValue('SELECT USER();');
        $thisHost = null;
        if (!empty($currentUser)) {
            $thisHost = str_replace('\'', '', mb_substr($currentUser, mb_strrpos($currentUser, '@') + 1));
        }
        if (!isset($pred_hostname) && isset($hostname)) {
            switch (mb_strtolower($hostname)) {
                case 'localhost':
                case '127.0.0.1':
                    $pred_hostname = 'localhost';
                    break;
                case '%':
                    $pred_hostname = 'any';
                    break;
                default:
                    $pred_hostname = 'userdefined';
                    break;
            }
        }
        $serverType = Util::getServerType();
        $serverVersion = $this->dbi->getVersion();
        $authPlugin = $this->getCurrentAuthenticationPlugin($mode, $user, $host);
        $isNew = $serverType === 'MySQL' && $serverVersion >= 50507 || $serverType === 'MariaDB' && $serverVersion >= 50200;
        $activeAuthPlugins = ['mysql_native_password' => __('Native MySQL authentication')];
        if ($isNew) {
            $activeAuthPlugins = $this->getActiveAuthPlugins();
            if (isset($activeAuthPlugins['mysql_old_password'])) {
                unset($activeAuthPlugins['mysql_old_password']);
            }
        }
        return $this->template->render('server/privileges/login_information_fields', ['pred_username' => $pred_username ?? null, 'pred_hostname' => $pred_hostname ?? null, 'username_length' => $usernameLength, 'hostname_length' => $hostnameLength, 'username' => $username ?? null, 'new_username' => $new_username ?? null, 'hostname' => $hostname ?? null, 'this_host' => $thisHost, 'is_change' => $mode === 'change', 'auth_plugin' => $authPlugin, 'active_auth_plugins' => $activeAuthPlugins, 'is_new' => $isNew]);
    }
    /**
     * Get username and hostname length
     *
     * @return array username length and hostname length
     */
    public function getUsernameAndHostnameLength()
    {
        /* Fallback values */
        $username_length = 16;
        $hostname_length = 41;
        /* Try to get real lengths from the database */
        $fields_info = $this->dbi->fetchResult('SELECT COLUMN_NAME, CHARACTER_MAXIMUM_LENGTH ' . 'FROM information_schema.columns ' . "WHERE table_schema = 'mysql' AND table_name = 'user' " . "AND COLUMN_NAME IN ('User', 'Host')");
        foreach ($fields_info as $val) {
            if ($val['COLUMN_NAME'] === 'User') {
                $username_length = $val['CHARACTER_MAXIMUM_LENGTH'];
            } elseif ($val['COLUMN_NAME'] === 'Host') {
                $hostname_length = $val['CHARACTER_MAXIMUM_LENGTH'];
            }
        }
        return [$username_length, $hostname_length];
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
    public function getCurrentAuthenticationPlugin($mode = 'new', $username = null, $hostname = null)
    {
        global $dbi;
        /* Fallback (standard) value */
        $authentication_plugin = 'mysql_native_password';
        $serverVersion = $this->dbi->getVersion();
        if (isset($username, $hostname) && $mode === 'change') {
            $row = $this->dbi->fetchSingleRow('SELECT `plugin` FROM `mysql`.`user` WHERE `User` = "' . $dbi->escapeString($username) . '" AND `Host` = "' . $dbi->escapeString($hostname) . '" LIMIT 1');
            // Table 'mysql'.'user' may not exist for some previous
            // versions of MySQL - in that case consider fallback value
            if (is_array($row) && isset($row['plugin'])) {
                $authentication_plugin = $row['plugin'];
            }
        } elseif ($mode === 'change') {
            [$username, $hostname] = $this->dbi->getCurrentUserAndHost();
            $row = $this->dbi->fetchSingleRow('SELECT `plugin` FROM `mysql`.`user` WHERE `User` = "' . $dbi->escapeString($username) . '" AND `Host` = "' . $dbi->escapeString($hostname) . '"');
            if (is_array($row) && isset($row['plugin'])) {
                $authentication_plugin = $row['plugin'];
            }
        } elseif ($serverVersion >= 50702) {
            $row = $this->dbi->fetchSingleRow('SELECT @@default_authentication_plugin');
            $authentication_plugin = is_array($row) ? $row['@@default_authentication_plugin'] : null;
        }
        return $authentication_plugin;
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
    public function getGrants($user, $host)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getGrants") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 576")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getGrants:576@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Update password and get message for password updating
     *
     * @param string $err_url  error url
     * @param string $username username
     * @param string $hostname hostname
     *
     * @return Message success or error message after updating password
     */
    public function updatePassword($err_url, $username, $hostname)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updatePassword") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 594")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updatePassword:594@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
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
    public function getMessageAndSqlQueryForPrivilegesRevoke(string $dbname, string $tablename, $username, $hostname, $itemType)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getMessageAndSqlQueryForPrivilegesRevoke") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 689")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getMessageAndSqlQueryForPrivilegesRevoke:689@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get REQUIRE clause
     *
     * @return string REQUIRE clause
     */
    public function getRequireClause()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getRequireClause") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 709")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getRequireClause:709@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get a WITH clause for 'update privileges' and 'add user'
     *
     * @return string
     */
    public function getWithClauseForAddUserAndUpdatePrivs()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getWithClauseForAddUserAndUpdatePrivs") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 742")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getWithClauseForAddUserAndUpdatePrivs:742@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get HTML for addUsersForm, This function call if isset($_GET['adduser'])
     *
     * @param string $dbname database name
     *
     * @return string HTML for addUserForm
     */
    public function getHtmlForAddUser($dbname)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForAddUser") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 777")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForAddUser:777@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * @param string $db    database name
     * @param string $table table name
     *
     * @return array
     */
    public function getAllPrivileges(string $db, string $table = '') : array
    {
        $databasePrivileges = $this->getGlobalAndDatabasePrivileges($db);
        $tablePrivileges = [];
        if ($table !== '') {
            $tablePrivileges = $this->getTablePrivileges($db, $table);
        }
        $routinePrivileges = $this->getRoutinesPrivileges($db);
        $allPrivileges = array_merge($databasePrivileges, $tablePrivileges, $routinePrivileges);
        $privileges = [];
        foreach ($allPrivileges as $privilege) {
            $userHost = $privilege['User'] . '@' . $privilege['Host'];
            $privileges[$userHost] = $privileges[$userHost] ?? [];
            $privileges[$userHost]['user'] = (string) $privilege['User'];
            $privileges[$userHost]['host'] = (string) $privilege['Host'];
            $privileges[$userHost]['privileges'] = $privileges[$userHost]['privileges'] ?? [];
            $privileges[$userHost]['privileges'][] = $this->getSpecificPrivilege($privilege);
        }
        return $privileges;
    }
    /**
     * @param array $row Array with user privileges
     *
     * @return array
     */
    private function getSpecificPrivilege(array $row) : array
    {
        $privilege = ['type' => $row['Type'], 'database' => $row['Db']];
        if ($row['Type'] === 'r') {
            $privilege['routine'] = $row['Routine_name'];
            $privilege['has_grant'] = strpos($row['Proc_priv'], 'Grant') !== false;
            $privilege['privileges'] = explode(',', $row['Proc_priv']);
        } elseif ($row['Type'] === 't') {
            $privilege['table'] = $row['Table_name'];
            $privilege['has_grant'] = strpos($row['Table_priv'], 'Grant') !== false;
            $tablePrivs = explode(',', $row['Table_priv']);
            $specificPrivileges = [];
            $grantsArr = $this->getTableGrantsArray();
            foreach ($grantsArr as $grant) {
                $specificPrivileges[$grant[0]] = 'N';
                foreach ($tablePrivs as $tablePriv) {
                    if ($grant[0] != $tablePriv) {
                        continue;
                    }
                    $specificPrivileges[$grant[0]] = 'Y';
                }
            }
            $privilege['privileges'] = $this->extractPrivInfo($specificPrivileges, true, true);
        } else {
            $privilege['has_grant'] = $row['Grant_priv'] === 'Y';
            $privilege['privileges'] = $this->extractPrivInfo($row, true);
        }
        return $privilege;
    }
    /**
     * @param string $db database name
     *
     * @return array
     */
    private function getGlobalAndDatabasePrivileges(string $db) : array
    {
        $listOfPrivileges = '`Select_priv`,
            `Insert_priv`,
            `Update_priv`,
            `Delete_priv`,
            `Create_priv`,
            `Drop_priv`,
            `Grant_priv`,
            `Index_priv`,
            `Alter_priv`,
            `References_priv`,
            `Create_tmp_table_priv`,
            `Lock_tables_priv`,
            `Create_view_priv`,
            `Show_view_priv`,
            `Create_routine_priv`,
            `Alter_routine_priv`,
            `Execute_priv`,
            `Event_priv`,
            `Trigger_priv`,';
        $listOfComparedPrivileges = 'BINARY `Select_priv` = \'N\' AND
            BINARY `Insert_priv` = \'N\' AND
            BINARY `Update_priv` = \'N\' AND
            BINARY `Delete_priv` = \'N\' AND
            BINARY `Create_priv` = \'N\' AND
            BINARY `Drop_priv` = \'N\' AND
            BINARY `Grant_priv` = \'N\' AND
            BINARY `References_priv` = \'N\' AND
            BINARY `Create_tmp_table_priv` = \'N\' AND
            BINARY `Lock_tables_priv` = \'N\' AND
            BINARY `Create_view_priv` = \'N\' AND
            BINARY `Show_view_priv` = \'N\' AND
            BINARY `Create_routine_priv` = \'N\' AND
            BINARY `Alter_routine_priv` = \'N\' AND
            BINARY `Execute_priv` = \'N\' AND
            BINARY `Event_priv` = \'N\' AND
            BINARY `Trigger_priv` = \'N\'';
        $query = '
            (
                SELECT `User`, `Host`, ' . $listOfPrivileges . ' \'*\' AS `Db`, \'g\' AS `Type`
                FROM `mysql`.`user`
                WHERE NOT (' . $listOfComparedPrivileges . ')
            )
            UNION
            (
                SELECT `User`, `Host`, ' . $listOfPrivileges . ' `Db`, \'d\' AS `Type`
                FROM `mysql`.`db`
                WHERE \'' . $this->dbi->escapeString($db) . '\' LIKE `Db` AND NOT (' . $listOfComparedPrivileges . ')
            )
            ORDER BY `User` ASC, `Host` ASC, `Db` ASC;
        ';
        $result = $this->dbi->query($query);
        if ($result === false) {
            return [];
        }
        $privileges = [];
        while ($row = $this->dbi->fetchAssoc($result)) {
            $privileges[] = $row;
        }
        return $privileges;
    }
    /**
     * @param string $db    database name
     * @param string $table table name
     *
     * @return array
     */
    private function getTablePrivileges(string $db, string $table) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTablePrivileges") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 920")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTablePrivileges:920@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * @param string $db database name
     *
     * @return array
     */
    private function getRoutinesPrivileges(string $db) : array
    {
        $query = '
            SELECT *, \'r\' AS `Type`
            FROM `mysql`.`procs_priv`
            WHERE Db = \'' . $this->dbi->escapeString($db) . '\';
        ';
        $result = $this->dbi->query($query);
        if ($result === false) {
            return [];
        }
        $privileges = [];
        while ($row = $this->dbi->fetchAssoc($result)) {
            $privileges[] = $row;
        }
        return $privileges;
    }
    /**
     * Get HTML error for View Users form
     * For non superusers such as grant/create users
     *
     * @return string
     */
    public function getHtmlForViewUsersError()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForViewUsersError") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 974")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForViewUsersError:974@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
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
    public function getUserLink($linktype, $username, $hostname, $dbname = '', $tablename = '', $routinename = '', $initial = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUserLink") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 991")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUserLink:991@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Returns number of defined user groups
     *
     * @return int
     */
    public function getUserGroupCount()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUserGroupCount") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1045")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUserGroupCount:1045@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Returns name of user group that user is part of
     *
     * @param string $username User name
     *
     * @return mixed|null usergroup if found or null if not found
     */
    public function getUserGroupForUser($username)
    {
        $cfgRelation = $this->relation->getRelationsParam();
        if (empty($cfgRelation['db']) || empty($cfgRelation['users'])) {
            return null;
        }
        $user_table = Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['users']);
        $sql_query = 'SELECT `usergroup` FROM ' . $user_table . ' WHERE `username` = \'' . $username . '\'' . ' LIMIT 1';
        $usergroup = $this->dbi->fetchValue($sql_query, 0, 0, DatabaseInterface::CONNECT_CONTROL);
        if ($usergroup === false) {
            return null;
        }
        return $usergroup;
    }
    /**
     * This function return the extra data array for the ajax behavior
     *
     * @param string $password  password
     * @param string $sql_query sql query
     * @param string $hostname  hostname
     * @param string $username  username
     *
     * @return array
     */
    public function getExtraDataForAjaxBehavior($password, $sql_query, $hostname, $username)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getExtraDataForAjaxBehavior") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1083")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getExtraDataForAjaxBehavior:1083@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
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
     * @return array database rights
     */
    public function getUserSpecificRights($username, $hostname, $type, $dbname = '')
    {
        $user_host_condition = ' WHERE `User`' . " = '" . $this->dbi->escapeString($username) . "'" . ' AND `Host`' . " = '" . $this->dbi->escapeString($hostname) . "'";
        if ($type === 'database') {
            $tables_to_search_for_users = ['tables_priv', 'columns_priv', 'procs_priv'];
            $dbOrTableName = 'Db';
        } elseif ($type === 'table') {
            $user_host_condition .= " AND `Db` LIKE '" . $this->dbi->escapeString($dbname) . "'";
            $tables_to_search_for_users = ['columns_priv'];
            $dbOrTableName = 'Table_name';
        } else {
            // routine
            $user_host_condition .= " AND `Db` LIKE '" . $this->dbi->escapeString($dbname) . "'";
            $tables_to_search_for_users = ['procs_priv'];
            $dbOrTableName = 'Routine_name';
        }
        // we also want privileges for this user not in table `db` but in other table
        $tables = $this->dbi->fetchResult('SHOW TABLES FROM `mysql`;');
        $db_rights_sqls = [];
        foreach ($tables_to_search_for_users as $table_search_in) {
            if (!in_array($table_search_in, $tables)) {
                continue;
            }
            $db_rights_sqls[] = '
                SELECT DISTINCT `' . $dbOrTableName . '`
                FROM `mysql`.' . Util::backquote($table_search_in) . $user_host_condition;
        }
        $user_defaults = [$dbOrTableName => '', 'Grant_priv' => 'N', 'privs' => ['USAGE'], 'Column_priv' => true];
        // for the rights
        $db_rights = [];
        $db_rights_sql = '(' . implode(') UNION (', $db_rights_sqls) . ')' . ' ORDER BY `' . $dbOrTableName . '` ASC';
        $db_rights_result = $this->dbi->query($db_rights_sql);
        while ($db_rights_row = $this->dbi->fetchAssoc($db_rights_result)) {
            $db_rights_row = array_merge($user_defaults, $db_rights_row);
            if ($type === 'database') {
                // only Db names in the table `mysql`.`db` uses wildcards
                // as we are in the db specific rights display we want
                // all db names escaped, also from other sources
                $db_rights_row['Db'] = Util::escapeMysqlWildcards($db_rights_row['Db']);
            }
            $db_rights[$db_rights_row[$dbOrTableName]] = $db_rights_row;
        }
        $this->dbi->freeResult($db_rights_result);
        if ($type === 'database') {
            $sql_query = 'SELECT * FROM `mysql`.`db`' . $user_host_condition . ' ORDER BY `Db` ASC';
        } elseif ($type === 'table') {
            $sql_query = 'SELECT `Table_name`,' . ' `Table_priv`,' . ' IF(`Column_priv` = _latin1 \'\', 0, 1)' . ' AS \'Column_priv\'' . ' FROM `mysql`.`tables_priv`' . $user_host_condition . ' ORDER BY `Table_name` ASC;';
        } else {
            $sql_query = 'SELECT `Routine_name`, `Proc_priv`' . ' FROM `mysql`.`procs_priv`' . $user_host_condition . ' ORDER BY `Routine_name`';
        }
        $result = $this->dbi->query($sql_query);
        while ($row = $this->dbi->fetchAssoc($result)) {
            if (isset($db_rights[$row[$dbOrTableName]])) {
                $db_rights[$row[$dbOrTableName]] = array_merge($db_rights[$row[$dbOrTableName]], $row);
            } else {
                $db_rights[$row[$dbOrTableName]] = $row;
            }
            if ($type !== 'database') {
                continue;
            }
            // there are db specific rights for this user
            // so we can drop this db rights
            $db_rights[$row['Db']]['can_delete'] = true;
        }
        $this->dbi->freeResult($result);
        return $db_rights;
    }
    /**
     * Parses Proc_priv data
     *
     * @param string $privs Proc_priv
     *
     * @return array
     */
    public function parseProcPriv($privs)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parseProcPriv") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1224")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parseProcPriv:1224@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
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
     * @return string
     */
    public function getHtmlForAllTableSpecificRights($username, $hostname, $type, $dbname = '')
    {
        $uiData = ['database' => ['form_id' => 'database_specific_priv', 'sub_menu_label' => __('Database'), 'legend' => __('Database-specific privileges'), 'type_label' => __('Database')], 'table' => ['form_id' => 'table_specific_priv', 'sub_menu_label' => __('Table'), 'legend' => __('Table-specific privileges'), 'type_label' => __('Table')], 'routine' => ['form_id' => 'routine_specific_priv', 'sub_menu_label' => __('Routine'), 'legend' => __('Routine-specific privileges'), 'type_label' => __('Routine')]];
        /**
         * no db name given, so we want all privs for the given user
         * db name was given, so we want all user specific rights for this db
         */
        $db_rights = $this->getUserSpecificRights($username, $hostname, $type, $dbname);
        ksort($db_rights);
        $foundRows = [];
        $privileges = [];
        foreach ($db_rights as $row) {
            $onePrivilege = [];
            $paramTableName = '';
            $paramRoutineName = '';
            if ($type === 'database') {
                $name = $row['Db'];
                $onePrivilege['grant'] = $row['Grant_priv'] === 'Y';
                $onePrivilege['table_privs'] = !empty($row['Table_priv']) || !empty($row['Column_priv']);
                $onePrivilege['privileges'] = implode(',', $this->extractPrivInfo($row, true));
                $paramDbName = $row['Db'];
            } elseif ($type === 'table') {
                $name = $row['Table_name'];
                $onePrivilege['grant'] = in_array('Grant', explode(',', $row['Table_priv']));
                $onePrivilege['column_privs'] = !empty($row['Column_priv']);
                $onePrivilege['privileges'] = implode(',', $this->extractPrivInfo($row, true));
                $paramDbName = $dbname;
                $paramTableName = $row['Table_name'];
            } else {
                // routine
                $name = $row['Routine_name'];
                $onePrivilege['grant'] = in_array('Grant', explode(',', $row['Proc_priv']));
                $privs = $this->parseProcPriv($row['Proc_priv']);
                $onePrivilege['privileges'] = implode(',', $this->extractPrivInfo($privs, true));
                $paramDbName = $dbname;
                $paramRoutineName = $row['Routine_name'];
            }
            $foundRows[] = $name;
            $onePrivilege['name'] = $name;
            $onePrivilege['edit_link'] = '';
            if ($this->dbi->isGrantUser()) {
                $onePrivilege['edit_link'] = $this->getUserLink('edit', $username, $hostname, $paramDbName, $paramTableName, $paramRoutineName);
            }
            $onePrivilege['revoke_link'] = '';
            if ($type !== 'database' || !empty($row['can_delete'])) {
                $onePrivilege['revoke_link'] = $this->getUserLink('revoke', $username, $hostname, $paramDbName, $paramTableName, $paramRoutineName);
            }
            $privileges[] = $onePrivilege;
        }
        $data = $uiData[$type];
        $data['privileges'] = $privileges;
        $data['username'] = $username;
        $data['hostname'] = $hostname;
        $data['database'] = $dbname;
        $data['type'] = $type;
        if ($type === 'database') {
            // we already have the list of databases from libraries/common.inc.php
            // via $pma = new PMA;
            $pred_db_array = $GLOBALS['dblist']->databases;
            $databases_to_skip = ['information_schema', 'performance_schema'];
            $databases = [];
            $escaped_databases = [];
            if (!empty($pred_db_array)) {
                foreach ($pred_db_array as $current_db) {
                    if (in_array($current_db, $databases_to_skip)) {
                        continue;
                    }
                    $current_db_escaped = Util::escapeMysqlWildcards($current_db);
                    // cannot use array_diff() once, outside of the loop,
                    // because the list of databases has special characters
                    // already escaped in $foundRows,
                    // contrary to the output of SHOW DATABASES
                    if (in_array($current_db_escaped, $foundRows)) {
                        continue;
                    }
                    $databases[] = $current_db;
                    $escaped_databases[] = $current_db_escaped;
                }
            }
            $data['databases'] = $databases;
            $data['escaped_databases'] = $escaped_databases;
        } elseif ($type === 'table') {
            $result = @$this->dbi->tryQuery('SHOW TABLES FROM ' . Util::backquote($dbname), DatabaseInterface::CONNECT_USER, DatabaseInterface::QUERY_STORE);
            $tables = [];
            if ($result) {
                while ($row = $this->dbi->fetchRow($result)) {
                    if (in_array($row[0], $foundRows)) {
                        continue;
                    }
                    $tables[] = $row[0];
                }
                $this->dbi->freeResult($result);
            }
            $data['tables'] = $tables;
        } else {
            // routine
            $routineData = $this->dbi->getRoutines($dbname);
            $routines = [];
            foreach ($routineData as $routine) {
                if (in_array($routine['name'], $foundRows)) {
                    continue;
                }
                $routines[] = $routine['name'];
            }
            $data['routines'] = $routines;
        }
        return $this->template->render('server/privileges/privileges_summary', $data);
    }
    /**
     * Get HTML for display the users overview
     * (if less than 50 users, display them immediately)
     *
     * @param array  $result         ran sql query
     * @param array  $db_rights      user's database rights array
     * @param string $themeImagePath a image source link
     * @param string $text_dir       text directory
     *
     * @return string HTML snippet
     */
    public function getUsersOverview($result, array $db_rights, $themeImagePath, $text_dir)
    {
        $cfgRelation = $this->relation->getRelationsParam();
        while ($row = $this->dbi->fetchAssoc($result)) {
            $row['privs'] = $this->extractPrivInfo($row, true);
            $db_rights[$row['User']][$row['Host']] = $row;
        }
        $this->dbi->freeResult($result);
        $user_group_count = 0;
        if ($cfgRelation['menuswork']) {
            $sql_query = 'SELECT * FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['users']);
            $result = $this->relation->queryAsControlUser($sql_query, false);
            $group_assignment = [];
            if ($result) {
                while ($row = $this->dbi->fetchAssoc($result)) {
                    $group_assignment[$row['username']] = $row['usergroup'];
                }
            }
            $this->dbi->freeResult($result);
            $user_group_count = $this->getUserGroupCount();
        }
        $hosts = [];
        foreach ($db_rights as $user) {
            ksort($user);
            foreach ($user as $host) {
                $check_plugin_query = 'SELECT * FROM `mysql`.`user` WHERE ' . "`User` = '" . $host['User'] . "' AND `Host` = '" . $host['Host'] . "'";
                $res = $this->dbi->fetchSingleRow($check_plugin_query);
                $hasPassword = false;
                if (isset($res['authentication_string']) && !empty($res['authentication_string']) || isset($res['Password']) && !empty($res['Password'])) {
                    $hasPassword = true;
                }
                $hosts[] = ['user' => $host['User'], 'host' => $host['Host'], 'has_password' => $hasPassword, 'has_select_priv' => isset($host['Select_priv']), 'privileges' => $host['privs'], 'group' => $group_assignment[$host['User']] ?? '', 'has_grant' => $host['Grant_priv'] === 'Y'];
            }
        }
        return $this->template->render('server/privileges/users_overview', ['menus_work' => $cfgRelation['menuswork'], 'user_group_count' => $user_group_count, 'theme_image_path' => $themeImagePath, 'text_dir' => $text_dir, 'initial' => $_GET['initial'] ?? '', 'hosts' => $hosts, 'is_grantuser' => $this->dbi->isGrantUser(), 'is_createuser' => $this->dbi->isCreateUser()]);
    }
    /**
     * Get HTML for Displays the initials
     *
     * @param array $array_initials array for all initials, even non A-Z
     *
     * @return string HTML snippet
     */
    public function getHtmlForInitials(array $array_initials)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForInitials") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1409")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForInitials:1409@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get the database rights array for Display user overview
     *
     * @return array    database rights array
     */
    public function getDbRightsForUserOverview()
    {
        // we also want users not in table `user` but in other table
        $tables = $this->dbi->fetchResult('SHOW TABLES FROM `mysql`;');
        $tablesSearchForUsers = ['user', 'db', 'tables_priv', 'columns_priv', 'procs_priv'];
        $db_rights_sqls = [];
        foreach ($tablesSearchForUsers as $table_search_in) {
            if (!in_array($table_search_in, $tables)) {
                continue;
            }
            $db_rights_sqls[] = 'SELECT DISTINCT `User`, `Host` FROM `mysql`.`' . $table_search_in . '` ' . (isset($_GET['initial']) ? $this->rangeOfUsers($_GET['initial']) : '');
        }
        $user_defaults = ['User' => '', 'Host' => '%', 'Password' => '?', 'Grant_priv' => 'N', 'privs' => ['USAGE']];
        // for the rights
        $db_rights = [];
        $db_rights_sql = '(' . implode(') UNION (', $db_rights_sqls) . ')' . ' ORDER BY `User` ASC, `Host` ASC';
        $db_rights_result = $this->dbi->query($db_rights_sql);
        while ($db_rights_row = $this->dbi->fetchAssoc($db_rights_result)) {
            $db_rights_row = array_merge($user_defaults, $db_rights_row);
            $db_rights[$db_rights_row['User']][$db_rights_row['Host']] = $db_rights_row;
        }
        $this->dbi->freeResult($db_rights_result);
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
    public function deleteUser(array $queries)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("deleteUser") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1466")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called deleteUser:1466@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Update the privileges and return the success or error message
     *
     * @return array success message or error message for update
     */
    public function updatePrivileges(string $username, string $hostname, string $tablename, string $dbname, string $itemType) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updatePrivileges") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1502")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updatePrivileges:1502@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Generate the query for the GRANTS and requirements + limits
     *
     * @return array<int,string|null>
     */
    private function generateQueriesForUpdatePrivileges(string $itemType, string $db_and_table, string $username, string $hostname, string $dbname) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("generateQueriesForUpdatePrivileges") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1548")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called generateQueriesForUpdatePrivileges:1548@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get List of information: Changes / copies a user
     *
     * @return array
     */
    public function getDataForChangeOrCopyUser()
    {
        $queries = null;
        $password = null;
        if (isset($_POST['change_copy'])) {
            $user_host_condition = ' WHERE `User` = ' . "'" . $this->dbi->escapeString($_POST['old_username']) . "'" . ' AND `Host` = ' . "'" . $this->dbi->escapeString($_POST['old_hostname']) . "';";
            $row = $this->dbi->fetchSingleRow('SELECT * FROM `mysql`.`user` ' . $user_host_condition);
            if (!$row) {
                $response = Response::getInstance();
                $response->addHTML(Message::notice(__('No user found.'))->getDisplay());
                unset($_POST['change_copy']);
            } else {
                foreach ($row as $key => $value) {
                    $GLOBALS[$key] = $value;
                }
                $serverVersion = $this->dbi->getVersion();
                // Recent MySQL versions have the field "Password" in mysql.user,
                // so the previous extract creates $row['Password'] but this script
                // uses $password
                if (!isset($row['password']) && isset($row['Password'])) {
                    $row['password'] = $row['Password'];
                }
                if (Util::getServerType() === 'MySQL' && $serverVersion >= 50606 && $serverVersion < 50706 && (isset($row['authentication_string']) && empty($row['password']) || isset($row['plugin']) && $row['plugin'] === 'sha256_password')) {
                    $row['password'] = $row['authentication_string'];
                }
                if (Util::getServerType() === 'MariaDB' && $serverVersion >= 50500 && isset($row['authentication_string']) && empty($row['password'])) {
                    $row['password'] = $row['authentication_string'];
                }
                // Always use 'authentication_string' column
                // for MySQL 5.7.6+ since it does not have
                // the 'password' column at all
                if (in_array(Util::getServerType(), ['MySQL', 'Percona Server']) && $serverVersion >= 50706 && isset($row['authentication_string'])) {
                    $row['password'] = $row['authentication_string'];
                }
                $password = $row['password'];
                $queries = [];
            }
        }
        return [$queries, $password];
    }
    /**
     * Update Data for information: Deletes users
     *
     * @param array $queries queries array
     *
     * @return array
     */
    public function getDataForDeleteUsers($queries)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDataForDeleteUsers") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1630")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDataForDeleteUsers:1630@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * update Message For Reload
     */
    public function updateMessageForReload() : ?Message
    {
        $message = null;
        if (isset($_GET['flush_privileges'])) {
            $sql_query = 'FLUSH PRIVILEGES;';
            $this->dbi->query($sql_query);
            $message = Message::success(__('The privileges were reloaded successfully.'));
        }
        if (isset($_GET['validate_username'])) {
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
     * @return array
     */
    public function getDataForQueries(array $queries, $queries_for_display)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDataForQueries") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1680")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDataForQueries:1680@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * update Data for information: Adds a user
     *
     * @param string|array|null $dbname      db name
     * @param string            $username    user name
     * @param string            $hostname    host name
     * @param string|null       $password    password
     * @param bool              $is_menuwork is_menuwork set?
     *
     * @return array
     */
    public function addUser($dbname, $username, $hostname, ?string $password, $is_menuwork)
    {
        $_add_user_error = false;
        $message = null;
        $queries = null;
        $queries_for_display = null;
        $sql_query = null;
        if (!isset($_POST['adduser_submit']) && !isset($_POST['change_copy'])) {
            return [$message, $queries, $queries_for_display, $sql_query, $_add_user_error];
        }
        $sql_query = '';
        if ($_POST['pred_username'] === 'any') {
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
                $_user_name = $this->dbi->fetchValue('SELECT USER()');
                $hostname = mb_substr($_user_name, mb_strrpos($_user_name, '@') + 1);
                unset($_user_name);
                break;
        }
        $sql = "SELECT '1' FROM `mysql`.`user`" . " WHERE `User` = '" . $this->dbi->escapeString($username) . "'" . " AND `Host` = '" . $this->dbi->escapeString($hostname) . "';";
        if ($this->dbi->fetchValue($sql) == 1) {
            $message = Message::error(__('The user %s already exists!'));
            $message->addParam('[em]\'' . $username . '\'@\'' . $hostname . '\'[/em]');
            $_GET['adduser'] = true;
            $_add_user_error = true;
            return [$message, $queries, $queries_for_display, $sql_query, $_add_user_error];
        }
        [$create_user_real, $create_user_show, $real_sql_query, $sql_query, $password_set_real, $password_set_show, $alter_real_sql_query, $alter_sql_query] = $this->getSqlQueriesForDisplayAndAddUser($username, $hostname, $password ?? '');
        if (empty($_POST['change_copy'])) {
            $_error = false;
            if ($create_user_real !== null) {
                if (!$this->dbi->tryQuery($create_user_real)) {
                    $_error = true;
                }
                if (isset($password_set_real, $_POST['authentication_plugin']) && !empty($password_set_real)) {
                    $this->setProperPasswordHashing($_POST['authentication_plugin']);
                    if ($this->dbi->tryQuery($password_set_real)) {
                        $sql_query .= $password_set_show;
                    }
                }
                $sql_query = $create_user_show . $sql_query;
            }
            [$sql_query, $message] = $this->addUserAndCreateDatabase($_error, $real_sql_query, $sql_query, $username, $hostname, $dbname, $alter_real_sql_query, $alter_sql_query);
            if (!empty($_POST['userGroup']) && $is_menuwork) {
                $this->setUserGroup($GLOBALS['username'], $_POST['userGroup']);
            }
            return [$message, $queries, $queries_for_display, $sql_query, $_add_user_error];
        }
        // Copy the user group while copying a user
        $old_usergroup = $_POST['old_usergroup'] ?? null;
        $this->setUserGroup($_POST['username'], $old_usergroup);
        if ($create_user_real !== null) {
            $queries[] = $create_user_real;
        }
        $queries[] = $real_sql_query;
        if (isset($password_set_real, $_POST['authentication_plugin']) && !empty($password_set_real)) {
            $this->setProperPasswordHashing($_POST['authentication_plugin']);
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
        return [$message, $queries, $queries_for_display, $sql_query, $_add_user_error];
    }
    /**
     * Sets proper value of `old_passwords` according to
     * the authentication plugin selected
     *
     * @param string $auth_plugin authentication plugin selected
     *
     * @return void
     */
    public function setProperPasswordHashing($auth_plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setProperPasswordHashing") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1803")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setProperPasswordHashing:1803@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Update DB information: DB, Table, isWildcard
     *
     * @return array
     */
    public function getDataForDBInfo()
    {
        $username = null;
        $hostname = null;
        $dbname = null;
        $tablename = null;
        $routinename = null;
        $return_db = null;
        if (isset($_REQUEST['username'])) {
            $username = (string) $_REQUEST['username'];
        }
        if (isset($_REQUEST['hostname'])) {
            $hostname = (string) $_REQUEST['hostname'];
        }
        /**
         * Checks if a dropdown box has been used for selecting a database / table
         */
        if (Core::isValid($_POST['pred_tablename'])) {
            $tablename = $_POST['pred_tablename'];
        } elseif (Core::isValid($_REQUEST['tablename'])) {
            $tablename = $_REQUEST['tablename'];
        } else {
            unset($tablename);
        }
        if (Core::isValid($_POST['pred_routinename'])) {
            $routinename = $_POST['pred_routinename'];
        } elseif (Core::isValid($_REQUEST['routinename'])) {
            $routinename = $_REQUEST['routinename'];
        } else {
            unset($routinename);
        }
        if (isset($_POST['pred_dbname'])) {
            $is_valid_pred_dbname = true;
            foreach ($_POST['pred_dbname'] as $key => $db_name) {
                if (!Core::isValid($db_name)) {
                    $is_valid_pred_dbname = false;
                    break;
                }
            }
        }
        if (isset($_REQUEST['dbname'])) {
            $is_valid_dbname = true;
            if (is_array($_REQUEST['dbname'])) {
                foreach ($_REQUEST['dbname'] as $key => $db_name) {
                    if (!Core::isValid($db_name)) {
                        $is_valid_dbname = false;
                        break;
                    }
                }
            } else {
                if (!Core::isValid($_REQUEST['dbname'])) {
                    $is_valid_dbname = false;
                }
            }
        }
        if (isset($is_valid_pred_dbname) && $is_valid_pred_dbname) {
            $dbname = $_POST['pred_dbname'];
            // If dbname contains only one database.
            if (count($dbname) === 1) {
                $dbname = $dbname[0];
            }
        } elseif (isset($is_valid_dbname) && $is_valid_dbname) {
            $dbname = $_REQUEST['dbname'];
        } else {
            unset($dbname, $tablename);
        }
        if (isset($dbname)) {
            if (is_array($dbname)) {
                $db_and_table = $dbname;
                $return_db = $dbname;
                foreach ($db_and_table as $key => $db_name) {
                    $db_and_table[$key] .= '.';
                }
            } else {
                $unescaped_db = Util::unescapeMysqlWildcards($dbname);
                $db_and_table = Util::backquote($unescaped_db) . '.';
                $return_db = $unescaped_db;
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
        $databaseNameIsWildcard = !is_array($dbname ?? '') && preg_match('/(?<!\\\\)(?:_|%)/', $dbname ?? '');
        return [$username, $hostname, $return_db, $tablename ?? null, $routinename ?? null, $db_and_table, $databaseNameIsWildcard];
    }
    /**
     * Get title and textarea for export user definition in Privileges
     *
     * @param string $username username
     * @param string $hostname host name
     *
     * @return array ($title, $export)
     */
    public function getListForExportUserDefinition($username, $hostname)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getListForExportUserDefinition") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1922")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getListForExportUserDefinition:1922@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
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
    public function getAddUserHtmlFieldset($db = '', $table = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getAddUserHtmlFieldset") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 1954")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getAddUserHtmlFieldset:1954@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get HTML snippet for display user overview page
     *
     * @param string $themeImagePath a image source link
     * @param string $text_dir       text directory
     *
     * @return string
     */
    public function getHtmlForUserOverview($themeImagePath, $text_dir)
    {
        $password_column = 'Password';
        $server_type = Util::getServerType();
        $serverVersion = $this->dbi->getVersion();
        if (($server_type === 'MySQL' || $server_type === 'Percona Server') && $serverVersion >= 50706) {
            $password_column = 'authentication_string';
        }
        // $sql_query is for the initial-filtered,
        // $sql_query_all is for counting the total no. of users
        $sql_query = $sql_query_all = 'SELECT *,' . ' IF(`' . $password_column . "` = _latin1 '', 'N', 'Y') AS 'Password'" . ' FROM `mysql`.`user`';
        $sql_query .= isset($_GET['initial']) ? $this->rangeOfUsers($_GET['initial']) : '';
        $sql_query .= ' ORDER BY `User` ASC, `Host` ASC;';
        $sql_query_all .= ' ;';
        $res = $this->dbi->tryQuery($sql_query, DatabaseInterface::CONNECT_USER, DatabaseInterface::QUERY_STORE);
        $res_all = $this->dbi->tryQuery($sql_query_all, DatabaseInterface::CONNECT_USER, DatabaseInterface::QUERY_STORE);
        $errorMessages = '';
        if (!$res) {
            // the query failed! This may have two reasons:
            // - the user does not have enough privileges
            // - the privilege tables use a structure of an earlier version.
            // so let's try a more simple query
            $this->dbi->freeResult($res);
            $this->dbi->freeResult($res_all);
            $sql_query = 'SELECT * FROM `mysql`.`user`';
            $res = $this->dbi->tryQuery($sql_query, DatabaseInterface::CONNECT_USER, DatabaseInterface::QUERY_STORE);
            if (!$res) {
                $errorMessages .= $this->getHtmlForViewUsersError();
                $errorMessages .= $this->getAddUserHtmlFieldset();
            } else {
                // This message is hardcoded because I will replace it by
                // a automatic repair feature soon.
                $raw = 'Your privilege table structure seems to be older than' . ' this MySQL version!<br>' . 'Please run the <code>mysql_upgrade</code> command' . ' that should be included in your MySQL server distribution' . ' to solve this problem!';
                $errorMessages .= Message::rawError($raw)->getDisplay();
            }
            $this->dbi->freeResult($res);
        } else {
            $db_rights = $this->getDbRightsForUserOverview();
            // for all initials, even non A-Z
            $array_initials = [];
            foreach ($db_rights as $right) {
                foreach ($right as $account) {
                    if (empty($account['User']) && $account['Host'] === 'localhost') {
                        $emptyUserNotice = Message::notice(__('A user account allowing any user from localhost to ' . 'connect is present. This will prevent other users ' . 'from connecting if the host part of their account ' . 'allows a connection from any (%) host.') . MySQLDocumentation::show('problems-connecting'))->getDisplay();
                        break 2;
                    }
                }
            }
            /**
             * Displays the initials
             * Also not necessary if there is less than 20 privileges
             */
            if ($this->dbi->numRows($res_all) > 20) {
                $initials = $this->getHtmlForInitials($array_initials);
            }
            /**
             * Display the user overview
             * (if less than 50 users, display them immediately)
             */
            if (isset($_GET['initial']) || isset($_GET['showall']) || $this->dbi->numRows($res) < 50) {
                $usersOverview = $this->getUsersOverview($res, $db_rights, $themeImagePath, $text_dir);
            }
            $response = Response::getInstance();
            if (!$response->isAjax() || !empty($_REQUEST['ajax_page_request'])) {
                if ($GLOBALS['is_reload_priv']) {
                    $flushnote = new Message(__('Note: phpMyAdmin gets the users’ privileges directly ' . 'from MySQL’s privilege tables. The content of these ' . 'tables may differ from the privileges the server uses, ' . 'if they have been changed manually. In this case, ' . 'you should %sreload the privileges%s before you continue.'), Message::NOTICE);
                    $flushnote->addParamHtml('<a href="' . Url::getFromRoute('/server/privileges', ['flush_privileges' => 1]) . '" id="reload_privileges_anchor">');
                    $flushnote->addParamHtml('</a>');
                } else {
                    $flushnote = new Message(__('Note: phpMyAdmin gets the users’ privileges directly ' . 'from MySQL’s privilege tables. The content of these ' . 'tables may differ from the privileges the server uses, ' . 'if they have been changed manually. In this case, ' . 'the privileges have to be reloaded but currently, you ' . 'don\'t have the RELOAD privilege.') . MySQLDocumentation::show('privileges-provided', false, null, null, 'priv_reload'), Message::NOTICE);
                }
                $flushNotice = $flushnote->getDisplay();
            }
        }
        return $this->template->render('server/privileges/user_overview', ['error_messages' => $errorMessages, 'empty_user_notice' => $emptyUserNotice ?? '', 'initials' => $initials ?? '', 'users_overview' => $usersOverview ?? '', 'is_createuser' => $this->dbi->isCreateUser(), 'flush_notice' => $flushNotice ?? '']);
    }
    /**
     * Get HTML snippet for display user properties
     *
     * @param bool         $dbname_is_wildcard whether database name is wildcard or not
     * @param string       $url_dbname         url database name that urlencode() string
     * @param string       $username           username
     * @param string       $hostname           host name
     * @param string|array $dbname             database name
     * @param string       $tablename          table name
     *
     * @return string
     */
    public function getHtmlForUserProperties($dbname_is_wildcard, $url_dbname, $username, $hostname, $dbname, $tablename)
    {
        global $cfg;
        $sql = "SELECT '1' FROM `mysql`.`user`" . " WHERE `User` = '" . $this->dbi->escapeString($username) . "'" . " AND `Host` = '" . $this->dbi->escapeString($hostname) . "';";
        $user_does_not_exists = (bool) (!$this->dbi->fetchValue($sql));
        $loginInformationFields = '';
        if ($user_does_not_exists) {
            $loginInformationFields = $this->getHtmlForLoginInformationFields();
        }
        $_params = ['username' => $username, 'hostname' => $hostname];
        if (!is_array($dbname) && strlen($dbname) > 0) {
            $_params['dbname'] = $dbname;
            if (strlen($tablename) > 0) {
                $_params['tablename'] = $tablename;
            }
        } else {
            $_params['dbname'] = $dbname;
        }
        $privilegesTable = $this->getHtmlToDisplayPrivilegesTable(
            // If $dbname is an array, pass any one db as all have same privs.
            Core::ifSetOr($dbname, is_array($dbname) ? $dbname[0] : '*', 'length'),
            Core::ifSetOr($tablename, '*', 'length')
        );
        $tableSpecificRights = '';
        if (!is_array($dbname) && strlen($tablename) === 0 && empty($dbname_is_wildcard)) {
            // no table name was given, display all table specific rights
            // but only if $dbname contains no wildcards
            if (strlen($dbname) === 0) {
                $tableSpecificRights .= $this->getHtmlForAllTableSpecificRights($username, $hostname, 'database');
            } else {
                // unescape wildcards in dbname at table level
                $unescaped_db = Util::unescapeMysqlWildcards($dbname);
                $tableSpecificRights .= $this->getHtmlForAllTableSpecificRights($username, $hostname, 'table', $unescaped_db);
                $tableSpecificRights .= $this->getHtmlForAllTableSpecificRights($username, $hostname, 'routine', $unescaped_db);
            }
        }
        $databaseUrl = Util::getScriptNameForOption($cfg['DefaultTabDatabase'], 'database');
        $databaseUrlTitle = Util::getTitleForTarget($cfg['DefaultTabDatabase']);
        $tableUrl = Util::getScriptNameForOption($cfg['DefaultTabTable'], 'table');
        $tableUrlTitle = Util::getTitleForTarget($cfg['DefaultTabTable']);
        $changePassword = '';
        $userGroup = '';
        $changeLoginInfoFields = '';
        if (!is_array($dbname) && strlen($dbname) === 0 && !$user_does_not_exists) {
            //change login information
            $changePassword = $this->getFormForChangePassword($username, $hostname, true);
            $userGroup = $this->getUserGroupForUser($username);
            $changeLoginInfoFields = $this->getHtmlForLoginInformationFields('change', $username, $hostname);
        }
        return $this->template->render('server/privileges/user_properties', ['user_does_not_exists' => $user_does_not_exists, 'login_information_fields' => $loginInformationFields, 'params' => $_params, 'privileges_table' => $privilegesTable, 'table_specific_rights' => $tableSpecificRights, 'change_password' => $changePassword, 'database' => $dbname, 'dbname' => $url_dbname, 'username' => $username, 'hostname' => $hostname, 'is_databases' => $dbname_is_wildcard || is_array($dbname) && count($dbname) > 1, 'is_wildcard' => $dbname_is_wildcard, 'table' => $tablename, 'current_user' => $this->dbi->getCurrentUser(), 'user_group' => $userGroup, 'change_login_info_fields' => $changeLoginInfoFields, 'database_url' => $databaseUrl, 'database_url_title' => $databaseUrlTitle, 'table_url' => $tableUrl, 'table_url_title' => $tableUrlTitle]);
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
     * @return array
     */
    public function getTablePrivsQueriesForChangeOrCopyUser($user_host_condition, array $queries, $username, $hostname)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTablePrivsQueriesForChangeOrCopyUser") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 2127")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTablePrivsQueriesForChangeOrCopyUser:2127@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get queries for database specific privileges for change or copy user
     *
     * @param array  $queries  queries array with string
     * @param string $username username
     * @param string $hostname host name
     *
     * @return array
     */
    public function getDbSpecificPrivsQueriesForChangeOrCopyUser(array $queries, $username, $hostname)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDbSpecificPrivsQueriesForChangeOrCopyUser") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 2175")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDbSpecificPrivsQueriesForChangeOrCopyUser:2175@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Prepares queries for adding users and
     * also create database and return query and message
     *
     * @param bool   $_error               whether user create or not
     * @param string $real_sql_query       SQL query for add a user
     * @param string $sql_query            SQL query to be displayed
     * @param string $username             username
     * @param string $hostname             host name
     * @param string $dbname               database name
     * @param string $alter_real_sql_query SQL query for ALTER USER
     * @param string $alter_sql_query      SQL query for ALTER USER to be displayed
     *
     * @return array<int,string|Message>
     */
    public function addUserAndCreateDatabase($_error, $real_sql_query, $sql_query, $username, $hostname, $dbname, $alter_real_sql_query, $alter_sql_query) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addUserAndCreateDatabase") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 2201")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addUserAndCreateDatabase:2201@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get the hashed string for password
     *
     * @param string $password password
     *
     * @return string
     */
    public function getHashedPassword($password)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHashedPassword") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 2256")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHashedPassword:2256@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Check if MariaDB's 'simple_password_check'
     * OR 'cracklib_password_check' is ACTIVE
     *
     * @return bool if atleast one of the plugins is ACTIVE
     */
    public function checkIfMariaDBPwdCheckPluginActive()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkIfMariaDBPwdCheckPluginActive") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 2268")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkIfMariaDBPwdCheckPluginActive:2268@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * Get SQL queries for Display and Add user
     *
     * @param string $username username
     * @param string $hostname host name
     * @param string $password password
     *
     * @return array ($create_user_real, $create_user_show, $real_sql_query, $sql_query
     *                $password_set_real, $password_set_show, $alter_real_sql_query, $alter_sql_query)
     */
    public function getSqlQueriesForDisplayAndAddUser($username, $hostname, $password)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getSqlQueriesForDisplayAndAddUser") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 2296")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getSqlQueriesForDisplayAndAddUser:2296@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
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
    public function getRoutineType($dbname, $routineName)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getRoutineType") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 2440")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getRoutineType:2440@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    /**
     * @param string $username User name
     * @param string $hostname Host name
     * @param string $database Database name
     * @param string $routine  Routine name
     *
     * @return array
     */
    private function getRoutinePrivileges(string $username, string $hostname, string $database, string $routine) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getRoutinePrivileges") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php at line 2458")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getRoutinePrivileges:2458@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Server/Privileges.php');
        die();
    }
    public function getFormForChangePassword(string $username, string $hostname, bool $editOthers) : string
    {
        global $route;
        $isPrivileges = $route === '/server/privileges';
        $serverType = Util::getServerType();
        $serverVersion = $this->dbi->getVersion();
        $origAuthPlugin = $this->getCurrentAuthenticationPlugin('change', $username, $hostname);
        $isNew = $serverType === 'MySQL' && $serverVersion >= 50507 || $serverType === 'MariaDB' && $serverVersion >= 50200;
        $hasMoreAuthPlugins = $serverType === 'MySQL' && $serverVersion >= 50706 || $this->dbi->isSuperUser() && $editOthers;
        $activeAuthPlugins = ['mysql_native_password' => __('Native MySQL authentication')];
        if ($isNew && $hasMoreAuthPlugins) {
            $activeAuthPlugins = $this->getActiveAuthPlugins();
            if (isset($activeAuthPlugins['mysql_old_password'])) {
                unset($activeAuthPlugins['mysql_old_password']);
            }
        }
        return $this->template->render('server/privileges/change_password', ['username' => $username, 'hostname' => $hostname, 'is_privileges' => $isPrivileges, 'is_new' => $isNew, 'has_more_auth_plugins' => $hasMoreAuthPlugins, 'active_auth_plugins' => $activeAuthPlugins, 'orig_auth_plugin' => $origAuthPlugin]);
    }
}