<?php

/**
 * Set of functions used with the relation and PDF feature
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Html\MySQLDocumentation;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statements\CreateStatement;
use PhpMyAdmin\SqlParser\Utils\Table as TableUtils;
use function array_reverse;
use function array_search;
use function array_shift;
use function asort;
use function bin2hex;
use function count;
use function defined;
use function explode;
use function file_get_contents;
use function htmlspecialchars;
use function implode;
use function in_array;
use function is_array;
use function is_bool;
use function is_string;
use function ksort;
use function mb_check_encoding;
use function mb_strlen;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_substr;
use function natcasesort;
use function preg_match;
use function sprintf;
use function str_replace;
use function strlen;
use function strpos;
use function trim;
use function uksort;
use function usort;
/**
 * Set of functions used with the relation and PDF feature
 */
class Relation
{
    /** @var DatabaseInterface */
    public $dbi;
    /** @var Template */
    public $template;
    /**
     * @param DatabaseInterface|null $dbi      Database interface
     * @param Template|null          $template Template instance
     */
    public function __construct(?DatabaseInterface $dbi, ?Template $template = null)
    {
        $this->dbi = $dbi;
        $this->template = $template ?? new Template();
    }
    /**
     * Executes a query as controluser if possible, otherwise as normal user
     *
     * @param string $sql        the query to execute
     * @param bool   $show_error whether to display SQL error messages or not
     * @param int    $options    query options
     *
     * @return mixed|bool the result set, or false if no result set
     *
     * @access public
     */
    public function queryAsControlUser($sql, $show_error = true, $options = 0)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("queryAsControlUser") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 78")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called queryAsControlUser:78@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Returns current relation parameters
     *
     * @return string[]
     */
    public function getRelationsParam() : array
    {
        if (empty($_SESSION['relation'][$GLOBALS['server']]) || empty($_SESSION['relation'][$GLOBALS['server']]['PMA_VERSION']) || $_SESSION['relation'][$GLOBALS['server']]['PMA_VERSION'] != PMA_VERSION) {
            $_SESSION['relation'][$GLOBALS['server']] = $this->checkRelationsParam();
        }
        // just for BC but needs to be before getRelationsParamDiagnostic()
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
    public function getRelationsParamDiagnostic(array $cfgRelation)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getRelationsParamDiagnostic") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 113")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getRelationsParamDiagnostic:113@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * prints out one diagnostic message for a feature
     *
     * @param string $feature_name       feature name in a message string
     * @param string $relation_parameter the $GLOBALS['cfgRelation'] parameter to check
     * @param array  $messages           utility messages
     * @param bool   $skip_line          whether to skip a line after the message
     *
     * @return string
     */
    public function getDiagMessageForFeature($feature_name, $relation_parameter, array $messages, $skip_line = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDiagMessageForFeature") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDiagMessageForFeature:197@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * prints out one diagnostic message for a configuration parameter
     *
     * @param string $parameter            config parameter name to display
     * @param bool   $relationParameterSet whether this parameter is set
     * @param array  $messages             utility messages
     * @param string $docAnchor            anchor in documentation
     *
     * @return string
     */
    public function getDiagMessageForParameter($parameter, $relationParameterSet, array $messages, $docAnchor)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDiagMessageForParameter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 221")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDiagMessageForParameter:221@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    private function checkTableAccess(array $cfgRelation) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkTableAccess") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 234")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkTableAccess:234@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    private function fillCfgRelationWithTableNames(array $cfgRelation) : ?array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fillCfgRelationWithTableNames") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 275")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fillCfgRelationWithTableNames:275@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Defines the relation parameters for the current user
     * just a copy of the functions used for relations ;-)
     * but added some stuff to check what will work
     *
     * @return string[]    the relation parameters for the current user
     *
     * @access protected
     */
    public function checkRelationsParam() : array
    {
        $cfgRelation = [];
        $cfgRelation['PMA_VERSION'] = PMA_VERSION;
        $workToTable = ['relwork' => 'relation', 'displaywork' => ['relation', 'table_info'], 'bookmarkwork' => 'bookmarktable', 'pdfwork' => ['table_coords', 'pdf_pages'], 'commwork' => 'column_info', 'mimework' => 'column_info', 'historywork' => 'history', 'recentwork' => 'recent', 'favoritework' => 'favorite', 'uiprefswork' => 'table_uiprefs', 'trackingwork' => 'tracking', 'userconfigwork' => 'userconfig', 'menuswork' => ['users', 'usergroups'], 'navwork' => 'navigationhiding', 'savedsearcheswork' => 'savedsearches', 'centralcolumnswork' => 'central_columns', 'designersettingswork' => 'designer_settings', 'exporttemplateswork' => 'export_templates'];
        foreach ($workToTable as $work => $table) {
            $cfgRelation[$work] = false;
        }
        $cfgRelation['allworks'] = false;
        $cfgRelation['user'] = null;
        $cfgRelation['db'] = null;
        if ($GLOBALS['server'] == 0 || empty($GLOBALS['cfg']['Server']['pmadb']) || !$this->dbi->selectDb($GLOBALS['cfg']['Server']['pmadb'], DatabaseInterface::CONNECT_CONTROL)) {
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
        $cfgRelationFilled = $this->fillCfgRelationWithTableNames($cfgRelation);
        if ($cfgRelationFilled === null) {
            // query failed ... ?
            //$GLOBALS['cfg']['Server']['pmadb'] = false;
            return $cfgRelation;
        }
        // Filling did success
        $cfgRelation = $cfgRelationFilled;
        $cfgRelation = $this->checkTableAccess($cfgRelation);
        $allWorks = true;
        foreach ($workToTable as $work => $table) {
            if ($cfgRelation[$work]) {
                continue;
            }
            if (is_string($table)) {
                if (isset($GLOBALS['cfg']['Server'][$table]) && $GLOBALS['cfg']['Server'][$table] !== false) {
                    $allWorks = false;
                    break;
                }
            } elseif (is_array($table)) {
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
        $cfgRelation['allworks'] = $allWorks;
        return $cfgRelation;
    }
    /**
     * Check if the table is accessible
     *
     * @param string $tableDbName The table or table.db
     *
     * @return bool The table is accessible
     */
    public function canAccessStorageTable(string $tableDbName) : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("canAccessStorageTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 402")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called canAccessStorageTable:402@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Check whether column_info table input transformation
     * upgrade is required and try to upgrade silently
     *
     * @return bool false if upgrade failed
     *
     * @access public
     */
    public function tryUpgradeTransformations()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("tryUpgradeTransformations") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 417")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called tryUpgradeTransformations:417@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
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
     * @access public
     */
    public function getForeigners($db, $table, $column = '', $source = 'both')
    {
        $cfgRelation = $this->getRelationsParam();
        $foreign = [];
        if ($cfgRelation['relwork'] && ($source === 'both' || $source === 'internal')) {
            $rel_query = '
                SELECT `master_field`,
                    `foreign_db`,
                    `foreign_table`,
                    `foreign_field`
                FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['relation']) . '
                WHERE `master_db`    = \'' . $this->dbi->escapeString($db) . '\'
                    AND `master_table` = \'' . $this->dbi->escapeString($table) . '\' ';
            if (strlen($column) > 0) {
                $rel_query .= ' AND `master_field` = ' . '\'' . $this->dbi->escapeString($column) . '\'';
            }
            $foreign = $this->dbi->fetchResult($rel_query, 'master_field', null, DatabaseInterface::CONNECT_CONTROL);
        }
        if (($source === 'both' || $source === 'foreign') && strlen($table) > 0) {
            $tableObj = new Table($table, $db);
            $show_create_table = $tableObj->showCreate();
            if ($show_create_table) {
                $parser = new Parser($show_create_table);
                /**
                 * @var CreateStatement $stmt
                 */
                $stmt = $parser->statements[0];
                $foreign['foreign_keys_data'] = TableUtils::getForeignKeys($stmt);
            }
        }
        /**
         * Emulating relations for some information_schema tables
         */
        $isInformationSchema = mb_strtolower($db) === 'information_schema';
        $isMysql = mb_strtolower($db) === 'mysql';
        if (($isInformationSchema || $isMysql) && ($source === 'internal' || $source === 'both')) {
            if ($isInformationSchema) {
                $internalRelations = InternalRelations::getInformationSchema();
            } else {
                $internalRelations = InternalRelations::getMySql();
            }
            if (isset($internalRelations[$table])) {
                foreach ($internalRelations[$table] as $field => $relations) {
                    if (strlen($column) !== 0 && $column != $field || isset($foreign[$field]) && strlen($foreign[$field]) !== 0) {
                        continue;
                    }
                    $foreign[$field] = $relations;
                }
            }
        }
        return $foreign;
    }
    /**
     * Gets the display field of a table
     *
     * @param string $db    the name of the db to check for
     * @param string $table the name of the table to check for
     *
     * @return string|false field name or false
     *
     * @access public
     */
    public function getDisplayField($db, $table)
    {
        $cfgRelation = $this->getRelationsParam();
        /**
         * Try to fetch the display field from DB.
         */
        if ($cfgRelation['displaywork']) {
            $disp_query = '
                SELECT `display_field`
                FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['table_info']) . '
                WHERE `db_name`    = \'' . $this->dbi->escapeString((string) $db) . '\'
                    AND `table_name` = \'' . $this->dbi->escapeString((string) $table) . '\'';
            $row = $this->dbi->fetchSingleRow($disp_query, 'ASSOC', DatabaseInterface::CONNECT_CONTROL);
            if (isset($row['display_field'])) {
                return $row['display_field'];
            }
        }
        /**
         * Emulating the display field for some information_schema tables.
         */
        if ($db === 'information_schema') {
            switch ($table) {
                case 'CHARACTER_SETS':
                    return 'DESCRIPTION';
                case 'TABLES':
                    return 'TABLE_COMMENT';
            }
        }
        /**
         * Pick first char field
         */
        $columns = $this->dbi->getColumnsFull($db, $table);
        if ($columns) {
            foreach ($columns as $column) {
                if ($this->dbi->types->getTypeClass($column['DATA_TYPE']) === 'CHAR') {
                    return $column['COLUMN_NAME'];
                }
            }
        }
        return false;
    }
    /**
     * Gets the comments for all columns of a table or the db itself
     *
     * @param string $db    the name of the db to check for
     * @param string $table the name of the table to check for
     *
     * @return array    [column_name] = comment
     *
     * @access public
     */
    public function getComments($db, $table = '')
    {
        $comments = [];
        if ($table != '') {
            // MySQL native column comments
            $columns = $this->dbi->getColumns($db, $table, null, true);
            if ($columns) {
                foreach ($columns as $column) {
                    if (empty($column['Comment'])) {
                        continue;
                    }
                    $comments[$column['Field']] = $column['Comment'];
                }
            }
        } else {
            $comments[] = $this->getDbComment($db);
        }
        return $comments;
    }
    /**
     * Gets the comment for a db
     *
     * @param string $db the name of the db to check for
     *
     * @return string   comment
     *
     * @access public
     */
    public function getDbComment($db)
    {
        $cfgRelation = $this->getRelationsParam();
        $comment = '';
        if ($cfgRelation['commwork']) {
            // pmadb internal db comment
            $com_qry = '
                SELECT `comment`
                FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['column_info']) . "\n                WHERE db_name     = '" . $this->dbi->escapeString($db) . "'\n                    AND table_name  = ''\n                    AND column_name = '(db_comment)'";
            $com_rs = $this->queryAsControlUser($com_qry, false, DatabaseInterface::QUERY_STORE);
            if ($com_rs && $this->dbi->numRows($com_rs) > 0) {
                $row = $this->dbi->fetchAssoc($com_rs);
                $comment = $row['comment'];
            }
            $this->dbi->freeResult($com_rs);
        }
        return $comment;
    }
    /**
     * Gets the comment for a db
     *
     * @return array comments
     *
     * @access public
     */
    public function getDbComments()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDbComments") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 629")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDbComments:629@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Set a database comment to a certain value.
     *
     * @param string $db      the name of the db
     * @param string $comment the value of the column
     *
     * @return bool true, if comment-query was made.
     *
     * @access public
     */
    public function setDbComment($db, $comment = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setDbComment") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 658")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setDbComment:658@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
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
     * @access public
     */
    public function setHistory($db, $table, $username, $sqlquery)
    {
        $maxCharactersInDisplayedSQL = $GLOBALS['cfg']['MaxCharactersInDisplayedSQL'];
        // Prevent to run this automatically on Footer class destroying in testsuite
        if (defined('TESTSUITE') || mb_strlen($sqlquery) > $maxCharactersInDisplayedSQL) {
            return;
        }
        $cfgRelation = $this->getRelationsParam();
        if (!isset($_SESSION['sql_history'])) {
            $_SESSION['sql_history'] = [];
        }
        $_SESSION['sql_history'][] = ['db' => $db, 'table' => $table, 'sqlquery' => $sqlquery];
        if (count($_SESSION['sql_history']) > $GLOBALS['cfg']['QueryHistoryMax']) {
            // history should not exceed a maximum count
            array_shift($_SESSION['sql_history']);
        }
        if (!$cfgRelation['historywork'] || !$GLOBALS['cfg']['QueryHistoryDB']) {
            return;
        }
        $this->queryAsControlUser('INSERT INTO ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['history']) . '
                  (`username`,
                    `db`,
                    `table`,
                    `timevalue`,
                    `sqlquery`)
            VALUES
                  (\'' . $this->dbi->escapeString($username) . '\',
                   \'' . $this->dbi->escapeString($db) . '\',
                   \'' . $this->dbi->escapeString($table) . '\',
                   NOW(),
                   \'' . $this->dbi->escapeString($sqlquery) . '\')');
        $this->purgeHistory($username);
    }
    /**
     * Gets a SQL history entry
     *
     * @param string $username the username
     *
     * @return array|bool list of history items
     *
     * @access public
     */
    public function getHistory($username)
    {
        $cfgRelation = $this->getRelationsParam();
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
               FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['history']) . '
              WHERE `username` = \'' . $this->dbi->escapeString($username) . '\'
           ORDER BY `id` DESC';
        return $this->dbi->fetchResult($hist_query, null, null, DatabaseInterface::CONNECT_CONTROL);
    }
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
     * @access public
     */
    public function purgeHistory($username)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("purgeHistory") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 765")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called purgeHistory:765@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Prepares the dropdown for one mode
     *
     * @param array  $foreign the keys and values for foreigns
     * @param string $data    the current data of the dropdown
     * @param string $mode    the needed mode
     *
     * @return array   the <option value=""><option>s
     *
     * @access protected
     */
    public function buildForeignDropdown(array $foreign, $data, $mode)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("buildForeignDropdown") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 799")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called buildForeignDropdown:799@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
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
     * @access public
     */
    public function foreignDropdown(array $disp_row, $foreign_field, $foreign_display, $data, $max = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("foreignDropdown") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 878")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called foreignDropdown:878@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Gets foreign keys in preparation for a drop-down selector
     *
     * @param array|bool $foreigners     array of the foreign keys
     * @param string     $field          the foreign field name
     * @param bool       $override_total whether to override the total
     * @param string     $foreign_filter a possible filter
     * @param string     $foreign_limit  a possible LIMIT clause
     * @param bool       $get_total      optional, whether to get total num of rows
     *                                   in $foreignData['the_total;]
     *                                   (has an effect of performance)
     *
     * @return array    data about the foreign keys
     *
     * @access public
     */
    public function getForeignData($foreigners, $field, $override_total, $foreign_filter, $foreign_limit, $get_total = false)
    {
        // we always show the foreign field in the drop-down; if a display
        // field is defined, we show it besides the foreign field
        $foreign_link = false;
        do {
            if (!$foreigners) {
                break;
            }
            $foreigner = $this->searchColumnInForeigners($foreigners, $field);
            if ($foreigner == false) {
                break;
            }
            $foreign_db = $foreigner['foreign_db'];
            $foreign_table = $foreigner['foreign_table'];
            $foreign_field = $foreigner['foreign_field'];
            // Count number of rows in the foreign table. Currently we do
            // not use a drop-down if more than ForeignKeyMaxLimit rows in the
            // foreign table,
            // for speed reasons and because we need a better interface for this.
            //
            // We could also do the SELECT anyway, with a LIMIT, and ensure that
            // the current value of the field is one of the choices.
            // Check if table has more rows than specified by
            // $GLOBALS['cfg']['ForeignKeyMaxLimit']
            $moreThanLimit = $this->dbi->getTable($foreign_db, $foreign_table)->checkIfMinRecordsExist($GLOBALS['cfg']['ForeignKeyMaxLimit']);
            if ($override_total === true || !$moreThanLimit) {
                // foreign_display can be false if no display field defined:
                $foreign_display = $this->getDisplayField($foreign_db, $foreign_table);
                $f_query_main = 'SELECT ' . Util::backquote($foreign_field) . ($foreign_display === false ? '' : ', ' . Util::backquote($foreign_display));
                $f_query_from = ' FROM ' . Util::backquote($foreign_db) . '.' . Util::backquote($foreign_table);
                $f_query_filter = empty($foreign_filter) ? '' : ' WHERE ' . Util::backquote($foreign_field) . ' LIKE "%' . $this->dbi->escapeString($foreign_filter) . '%"' . ($foreign_display === false ? '' : ' OR ' . Util::backquote($foreign_display) . ' LIKE "%' . $this->dbi->escapeString($foreign_filter) . '%"');
                $f_query_order = $foreign_display === false ? '' : ' ORDER BY ' . Util::backquote($foreign_table) . '.' . Util::backquote($foreign_display);
                $f_query_limit = !empty($foreign_limit) ? $foreign_limit : '';
                if (!empty($foreign_filter)) {
                    $the_total = $this->dbi->fetchValue('SELECT COUNT(*)' . $f_query_from . $f_query_filter);
                    if ($the_total === false) {
                        $the_total = 0;
                    }
                }
                $disp = $this->dbi->tryQuery($f_query_main . $f_query_from . $f_query_filter . $f_query_order . $f_query_limit);
                if ($disp && $this->dbi->numRows($disp) > 0) {
                    // If a resultset has been created, pre-cache it in the $disp_row
                    // array. This helps us from not needing to use mysql_data_seek by
                    // accessing a pre-cached PHP array. Usually those resultsets are
                    // not that big, so a performance hit should not be expected.
                    $disp_row = [];
                    while ($single_disp_row = @$this->dbi->fetchAssoc($disp)) {
                        $disp_row[] = $single_disp_row;
                    }
                    @$this->dbi->freeResult($disp);
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
        if ($get_total && isset($foreign_db, $foreign_table)) {
            $the_total = $this->dbi->getTable($foreign_db, $foreign_table)->countRecords(true);
        }
        $foreignData = [];
        $foreignData['foreign_link'] = $foreign_link;
        $foreignData['the_total'] = $the_total ?? null;
        $foreignData['foreign_display'] = $foreign_display ?? null;
        $foreignData['disp_row'] = $disp_row ?? null;
        $foreignData['foreign_field'] = $foreign_field ?? null;
        return $foreignData;
    }
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
    public function renameField($db, $table, $field, $new_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("renameField") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1031")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called renameField:1031@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
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
     */
    public function renameSingleTable(string $table, string $source_db, string $target_db, string $source_table, string $target_table, string $db_field, string $table_field) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("renameSingleTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1057")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called renameSingleTable:1057@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
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
    public function renameTable($source_db, $target_db, $source_table, $target_table)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("renameTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1075")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called renameTable:1075@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Create a PDF page
     *
     * @param string|null $newpage     name of the new PDF page
     * @param array       $cfgRelation Relation configuration
     * @param string      $db          database name
     *
     * @return int
     */
    public function createPage(?string $newpage, array $cfgRelation, $db)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("createPage") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1121")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called createPage:1121@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
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
     * @return array
     */
    public function getChildReferences($db, $table, $column = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getChildReferences") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1140")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getChildReferences:1140@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Check child table references and foreign key for a table column.
     *
     * @param string     $db                    name of master table db.
     * @param string     $table                 name of master table.
     * @param string     $column                name of master table column.
     * @param array|null $foreigners_full       foreigners array for the whole table.
     * @param array|null $child_references_full child references for the whole table.
     *
     * @return array telling about references if foreign key.
     */
    public function checkChildForeignReferences($db, $table, $column, $foreigners_full = null, $child_references_full = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkChildForeignReferences") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1163")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkChildForeignReferences:1163@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Search a table column in foreign data.
     *
     * @param array  $foreigners Table Foreign data
     * @param string $column     Column name
     *
     * @return array|false
     */
    public function searchColumnInForeigners(array $foreigners, $column)
    {
        if (isset($foreigners[$column])) {
            return $foreigners[$column];
        }
        $foreigner = [];
        foreach ($foreigners['foreign_keys_data'] as $one_key) {
            $column_index = array_search($column, $one_key['index_list']);
            if ($column_index !== false) {
                $foreigner['foreign_field'] = $one_key['ref_index_list'][$column_index];
                $foreigner['foreign_db'] = $one_key['ref_db_name'] ?? $GLOBALS['db'];
                $foreigner['foreign_table'] = $one_key['ref_table_name'];
                $foreigner['constraint'] = $one_key['constraint'];
                $foreigner['on_update'] = $one_key['on_update'] ?? 'RESTRICT';
                $foreigner['on_delete'] = $one_key['on_delete'] ?? 'RESTRICT';
                return $foreigner;
            }
        }
        return false;
    }
    /**
     * Returns default PMA table names and their create queries.
     *
     * @return array table name, create query
     */
    public function getDefaultPmaTableNames()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDefaultPmaTableNames") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1238")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDefaultPmaTableNames:1238@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Create a table named phpmyadmin to be used as configuration storage
     *
     * @return bool
     */
    public function createPmaDatabase()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("createPmaDatabase") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1256")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called createPmaDatabase:1256@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Creates PMA tables in the given db, updates if already exists.
     *
     * @param string $db     database
     * @param bool   $create whether to create tables if they don't exist.
     *
     * @return void
     */
    public function fixPmaTables($db, $create = true)
    {
        $tablesToFeatures = ['pma__bookmark' => 'bookmarktable', 'pma__relation' => 'relation', 'pma__table_info' => 'table_info', 'pma__table_coords' => 'table_coords', 'pma__pdf_pages' => 'pdf_pages', 'pma__column_info' => 'column_info', 'pma__history' => 'history', 'pma__recent' => 'recent', 'pma__favorite' => 'favorite', 'pma__table_uiprefs' => 'table_uiprefs', 'pma__tracking' => 'tracking', 'pma__userconfig' => 'userconfig', 'pma__users' => 'users', 'pma__usergroups' => 'usergroups', 'pma__navigationhiding' => 'navigationhiding', 'pma__savedsearches' => 'savedsearches', 'pma__central_columns' => 'central_columns', 'pma__designer_settings' => 'designer_settings', 'pma__export_templates' => 'export_templates'];
        $existingTables = $this->dbi->getTables($db, DatabaseInterface::CONNECT_CONTROL);
        $createQueries = null;
        $foundOne = false;
        foreach ($tablesToFeatures as $table => $feature) {
            if (!in_array($table, $existingTables)) {
                if ($create) {
                    if ($createQueries == null) {
                        // first create
                        $createQueries = $this->getDefaultPmaTableNames();
                        $this->dbi->selectDb($db);
                    }
                    $this->dbi->tryQuery($createQueries[$table]);
                    $error = $this->dbi->getError();
                    if ($error) {
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
        $_SESSION['relation'][$GLOBALS['server']] = $this->checkRelationsParam();
        $cfgRelation = $this->getRelationsParam();
        if (!$cfgRelation['recentwork'] && !$cfgRelation['favoritework']) {
            return;
        }
        // Since configuration storage is updated, we need to
        // re-initialize the favorite and recent tables stored in the
        // session from the current configuration storage.
        if ($cfgRelation['favoritework']) {
            $fav_tables = RecentFavoriteTable::getInstance('favorite');
            $_SESSION['tmpval']['favoriteTables'][$GLOBALS['server']] = $fav_tables->getFromDb();
        }
        if ($cfgRelation['recentwork']) {
            $recent_tables = RecentFavoriteTable::getInstance('recent');
            $_SESSION['tmpval']['recentTables'][$GLOBALS['server']] = $recent_tables->getFromDb();
        }
        // Reload navi panel to update the recent/favorite lists.
        $GLOBALS['reload'] = true;
    }
    /**
     * Get Html for PMA tables fixing anchor.
     *
     * @param bool $allTables whether to create all tables
     * @param bool $createDb  whether to create the pmadb also
     *
     * @return string Html
     */
    public function getHtmlFixPmaTables($allTables, $createDb = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlFixPmaTables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1336")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlFixPmaTables:1336@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Gets the relations info and status, depending on the condition
     *
     * @param bool   $condition whether to look for foreigners or not
     * @param string $db        database name
     * @param string $table     table name
     *
     * @return array ($res_rel, $have_rel)
     */
    public function getRelationsAndStatus($condition, $db, $table)
    {
        if ($condition) {
            // Find which tables are related with the current one and write it in
            // an array
            $res_rel = $this->getForeigners($db, $table);
            if (count($res_rel) > 0) {
                $have_rel = true;
            } else {
                $have_rel = false;
            }
        } else {
            $have_rel = false;
            $res_rel = [];
        }
        return [$res_rel, $have_rel];
    }
    /**
     * Verifies if all the pmadb tables are defined
     *
     * @return bool
     */
    public function arePmadbTablesDefined()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("arePmadbTablesDefined") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1387")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called arePmadbTablesDefined:1387@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
    /**
     * Get tables for foreign key constraint
     *
     * @param string $foreignDb        Database name
     * @param string $tblStorageEngine Table storage engine
     *
     * @return array Table names
     */
    public function getTables($foreignDb, $tblStorageEngine)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php at line 1399")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTables:1399@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Relation.php');
        die();
    }
}