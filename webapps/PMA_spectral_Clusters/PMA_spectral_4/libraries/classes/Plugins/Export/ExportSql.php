<?php

/**
 * Set of functions used to build SQL dumps of tables
 */
declare (strict_types=1);
namespace PhpMyAdmin\Plugins\Export;

use PhpMyAdmin\Charsets;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Plugins\ExportPlugin;
use PhpMyAdmin\Properties\Options\Groups\OptionsPropertyMainGroup;
use PhpMyAdmin\Properties\Options\Groups\OptionsPropertyRootGroup;
use PhpMyAdmin\Properties\Options\Groups\OptionsPropertySubgroup;
use PhpMyAdmin\Properties\Options\Items\BoolPropertyItem;
use PhpMyAdmin\Properties\Options\Items\MessageOnlyPropertyItem;
use PhpMyAdmin\Properties\Options\Items\NumberPropertyItem;
use PhpMyAdmin\Properties\Options\Items\RadioPropertyItem;
use PhpMyAdmin\Properties\Options\Items\SelectPropertyItem;
use PhpMyAdmin\Properties\Options\Items\TextPropertyItem;
use PhpMyAdmin\Properties\Plugins\ExportPluginProperties;
use PhpMyAdmin\SqlParser\Components\CreateDefinition;
use PhpMyAdmin\SqlParser\Context;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statements\CreateStatement;
use PhpMyAdmin\SqlParser\Token;
use PhpMyAdmin\Util;
use const E_USER_ERROR;
use const PHP_VERSION;
use function bin2hex;
use function count;
use function defined;
use function explode;
use function implode;
use function in_array;
use function intval;
use function is_array;
use function mb_strlen;
use function mb_strpos;
use function mb_substr;
use function preg_quote;
use function preg_replace;
use function preg_split;
use function sprintf;
use function str_repeat;
use function str_replace;
use function stripos;
use function strtotime;
use function strtoupper;
use function trigger_error;
/**
 * Handles the export for the SQL class
 */
class ExportSql extends ExportPlugin
{
    /**
     * Whether charset header was sent.
     *
     * @var bool
     */
    private $sentCharset = false;
    public function __construct()
    {
        parent::__construct();
        $this->setProperties();
        // Avoids undefined variables, use NULL so isset() returns false
        if (isset($GLOBALS['sql_backquotes'])) {
            return;
        }
        $GLOBALS['sql_backquotes'] = null;
    }
    /**
     * Sets the export SQL properties
     *
     * @return void
     */
    protected function setProperties()
    {
        global $plugin_param, $dbi;
        $hide_sql = false;
        $hide_structure = false;
        if ($plugin_param['export_type'] === 'table' && !$plugin_param['single_table']) {
            $hide_structure = true;
            $hide_sql = true;
        }
        // In case we have `raw_query` parameter set,
        // we initialize SQL option
        if (isset($_REQUEST['raw_query'])) {
            $hide_structure = false;
            $hide_sql = false;
        }
        if ($hide_sql) {
            return;
        }
        $exportPluginProperties = new ExportPluginProperties();
        $exportPluginProperties->setText('SQL');
        $exportPluginProperties->setExtension('sql');
        $exportPluginProperties->setMimeType('text/x-sql');
        $exportPluginProperties->setOptionsText(__('Options'));
        // create the root group that will be the options field for
        // $exportPluginProperties
        // this will be shown as "Format specific options"
        $exportSpecificOptions = new OptionsPropertyRootGroup('Format Specific Options');
        // general options main group
        $generalOptions = new OptionsPropertyMainGroup('general_opts');
        // comments
        $subgroup = new OptionsPropertySubgroup('include_comments');
        $leaf = new BoolPropertyItem('include_comments', __('Display comments <i>(includes info such as export' . ' timestamp, PHP version, and server version)</i>'));
        $subgroup->setSubgroupHeader($leaf);
        $leaf = new TextPropertyItem('header_comment', __('Additional custom header comment (\\n splits lines):'));
        $subgroup->addProperty($leaf);
        $leaf = new BoolPropertyItem('dates', __('Include a timestamp of when databases were created, last' . ' updated, and last checked'));
        $subgroup->addProperty($leaf);
        if (!empty($GLOBALS['cfgRelation']['relation'])) {
            $leaf = new BoolPropertyItem('relation', __('Display foreign key relationships'));
            $subgroup->addProperty($leaf);
        }
        if (!empty($GLOBALS['cfgRelation']['mimework'])) {
            $leaf = new BoolPropertyItem('mime', __('Display media types'));
            $subgroup->addProperty($leaf);
        }
        $generalOptions->addProperty($subgroup);
        // enclose in a transaction
        $leaf = new BoolPropertyItem('use_transaction', __('Enclose export in a transaction'));
        $leaf->setDoc(['programs', 'mysqldump', 'option_mysqldump_single-transaction']);
        $generalOptions->addProperty($leaf);
        // disable foreign key checks
        $leaf = new BoolPropertyItem('disable_fk', __('Disable foreign key checks'));
        $leaf->setDoc(['manual_MySQL_Database_Administration', 'server-system-variables', 'sysvar_foreign_key_checks']);
        $generalOptions->addProperty($leaf);
        // export views as tables
        $leaf = new BoolPropertyItem('views_as_tables', __('Export views as tables'));
        $generalOptions->addProperty($leaf);
        // export metadata
        $leaf = new BoolPropertyItem('metadata', __('Export metadata'));
        $generalOptions->addProperty($leaf);
        // compatibility maximization
        $compats = $dbi->getCompatibilities();
        if (count($compats) > 0) {
            $values = [];
            foreach ($compats as $val) {
                $values[$val] = $val;
            }
            $leaf = new SelectPropertyItem('compatibility', __('Database system or older MySQL server to maximize output' . ' compatibility with:'));
            $leaf->setValues($values);
            $leaf->setDoc(['manual_MySQL_Database_Administration', 'Server_SQL_mode']);
            $generalOptions->addProperty($leaf);
            unset($values);
        }
        // what to dump (structure/data/both)
        $subgroup = new OptionsPropertySubgroup('dump_table', __('Dump table'));
        $leaf = new RadioPropertyItem('structure_or_data');
        $leaf->setValues(['structure' => __('structure'), 'data' => __('data'), 'structure_and_data' => __('structure and data')]);
        $subgroup->setSubgroupHeader($leaf);
        $generalOptions->addProperty($subgroup);
        // add the main group to the root group
        $exportSpecificOptions->addProperty($generalOptions);
        // structure options main group
        if (!$hide_structure) {
            $structureOptions = new OptionsPropertyMainGroup('structure', __('Object creation options'));
            $structureOptions->setForce('data');
            // begin SQL Statements
            $subgroup = new OptionsPropertySubgroup();
            $leaf = new MessageOnlyPropertyItem('add_statements', __('Add statements:'));
            $subgroup->setSubgroupHeader($leaf);
            // server export options
            if ($plugin_param['export_type'] === 'server') {
                $leaf = new BoolPropertyItem('drop_database', sprintf(__('Add %s statement'), '<code>DROP DATABASE IF EXISTS</code>'));
                $subgroup->addProperty($leaf);
            }
            if ($plugin_param['export_type'] === 'database') {
                $create_clause = '<code>CREATE DATABASE / USE</code>';
                $leaf = new BoolPropertyItem('create_database', sprintf(__('Add %s statement'), $create_clause));
                $subgroup->addProperty($leaf);
            }
            if ($plugin_param['export_type'] === 'table') {
                $drop_clause = $dbi->getTable($GLOBALS['db'], $GLOBALS['table'])->isView() ? '<code>DROP VIEW</code>' : '<code>DROP TABLE</code>';
            } else {
                $drop_clause = '<code>DROP TABLE / VIEW / PROCEDURE' . ' / FUNCTION / EVENT</code>';
            }
            $drop_clause .= '<code> / TRIGGER</code>';
            $leaf = new BoolPropertyItem('drop_table', sprintf(__('Add %s statement'), $drop_clause));
            $subgroup->addProperty($leaf);
            $subgroup_create_table = new OptionsPropertySubgroup();
            // Add table structure option
            $leaf = new BoolPropertyItem('create_table', sprintf(__('Add %s statement'), '<code>CREATE TABLE</code>'));
            $subgroup_create_table->setSubgroupHeader($leaf);
            $leaf = new BoolPropertyItem('if_not_exists', '<code>IF NOT EXISTS</code> ' . __('(less efficient as indexes will be generated during table ' . 'creation)'));
            $subgroup_create_table->addProperty($leaf);
            $leaf = new BoolPropertyItem('auto_increment', sprintf(__('%s value'), '<code>AUTO_INCREMENT</code>'));
            $subgroup_create_table->addProperty($leaf);
            $subgroup->addProperty($subgroup_create_table);
            // Add view option
            $subgroup_create_view = new OptionsPropertySubgroup();
            $leaf = new BoolPropertyItem('create_view', sprintf(__('Add %s statement'), '<code>CREATE VIEW</code>'));
            $subgroup_create_view->setSubgroupHeader($leaf);
            $leaf = new BoolPropertyItem(
                'simple_view_export',
                /* l10n: Allow simplifying exported view syntax to only "CREATE VIEW" */
                __('Use simple view export')
            );
            $subgroup_create_view->addProperty($leaf);
            $leaf = new BoolPropertyItem('view_current_user', __('Exclude definition of current user'));
            $subgroup_create_view->addProperty($leaf);
            $leaf = new BoolPropertyItem('or_replace_view', sprintf(__('%s view'), '<code>OR REPLACE</code>'));
            $subgroup_create_view->addProperty($leaf);
            $subgroup->addProperty($subgroup_create_view);
            $leaf = new BoolPropertyItem('procedure_function', sprintf(__('Add %s statement'), '<code>CREATE PROCEDURE / FUNCTION / EVENT</code>'));
            $subgroup->addProperty($leaf);
            // Add triggers option
            $leaf = new BoolPropertyItem('create_trigger', sprintf(__('Add %s statement'), '<code>CREATE TRIGGER</code>'));
            $subgroup->addProperty($leaf);
            $structureOptions->addProperty($subgroup);
            $leaf = new BoolPropertyItem('backquotes', __('Enclose table and column names with backquotes ' . '<i>(Protects column and table names formed with' . ' special characters or keywords)</i>'));
            $structureOptions->addProperty($leaf);
            // add the main group to the root group
            $exportSpecificOptions->addProperty($structureOptions);
        }
        // begin Data options
        $dataOptions = new OptionsPropertyMainGroup('data', __('Data creation options'));
        $dataOptions->setForce('structure');
        $leaf = new BoolPropertyItem('truncate', __('Truncate table before insert'));
        $dataOptions->addProperty($leaf);
        // begin SQL Statements
        $subgroup = new OptionsPropertySubgroup();
        $leaf = new MessageOnlyPropertyItem(__('Instead of <code>INSERT</code> statements, use:'));
        $subgroup->setSubgroupHeader($leaf);
        $leaf = new BoolPropertyItem('delayed', __('<code>INSERT DELAYED</code> statements'));
        $leaf->setDoc(['manual_MySQL_Database_Administration', 'insert_delayed']);
        $subgroup->addProperty($leaf);
        $leaf = new BoolPropertyItem('ignore', __('<code>INSERT IGNORE</code> statements'));
        $leaf->setDoc(['manual_MySQL_Database_Administration', 'insert']);
        $subgroup->addProperty($leaf);
        $dataOptions->addProperty($subgroup);
        // Function to use when dumping dat
        $leaf = new SelectPropertyItem('type', __('Function to use when dumping data:'));
        $leaf->setValues(['INSERT' => 'INSERT', 'UPDATE' => 'UPDATE', 'REPLACE' => 'REPLACE']);
        $dataOptions->addProperty($leaf);
        /* Syntax to use when inserting data */
        $subgroup = new OptionsPropertySubgroup();
        $leaf = new MessageOnlyPropertyItem(null, __('Syntax to use when inserting data:'));
        $subgroup->setSubgroupHeader($leaf);
        $leaf = new RadioPropertyItem('insert_syntax', __('<code>INSERT IGNORE</code> statements'));
        $leaf->setValues(['complete' => __('include column names in every <code>INSERT</code> statement' . ' <br> &nbsp; &nbsp; &nbsp; Example: <code>INSERT INTO' . ' tbl_name (col_A,col_B,col_C) VALUES (1,2,3)</code>'), 'extended' => __('insert multiple rows in every <code>INSERT</code> statement' . '<br> &nbsp; &nbsp; &nbsp; Example: <code>INSERT INTO' . ' tbl_name VALUES (1,2,3), (4,5,6), (7,8,9)</code>'), 'both' => __('both of the above<br> &nbsp; &nbsp; &nbsp; Example:' . ' <code>INSERT INTO tbl_name (col_A,col_B,col_C) VALUES' . ' (1,2,3), (4,5,6), (7,8,9)</code>'), 'none' => __('neither of the above<br> &nbsp; &nbsp; &nbsp; Example:' . ' <code>INSERT INTO tbl_name VALUES (1,2,3)</code>')]);
        $subgroup->addProperty($leaf);
        $dataOptions->addProperty($subgroup);
        // Max length of query
        $leaf = new NumberPropertyItem('max_query_size', __('Maximal length of created query'));
        $dataOptions->addProperty($leaf);
        // Dump binary columns in hexadecimal
        $leaf = new BoolPropertyItem('hex_for_binary', __('Dump binary columns in hexadecimal notation' . ' <i>(for example, "abc" becomes 0x616263)</i>'));
        $dataOptions->addProperty($leaf);
        // Dump time in UTC
        $leaf = new BoolPropertyItem('utc_time', __('Dump TIMESTAMP columns in UTC <i>(enables TIMESTAMP columns' . ' to be dumped and reloaded between servers in different' . ' time zones)</i>'));
        $dataOptions->addProperty($leaf);
        // add the main group to the root group
        $exportSpecificOptions->addProperty($dataOptions);
        // set the options for the export plugin property item
        $exportPluginProperties->setOptions($exportSpecificOptions);
        $this->properties = $exportPluginProperties;
    }
    /**
     * Generates SQL for routines export
     *
     * @param string $db        Database
     * @param array  $aliases   Aliases of db/table/columns
     * @param string $type      Type of exported routine
     * @param string $name      Verbose name of exported routine
     * @param array  $routines  List of routines to export
     * @param string $delimiter Delimiter to use in SQL
     *
     * @return string SQL query
     */
    protected function exportRoutineSQL($db, array $aliases, $type, $name, array $routines, $delimiter)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportRoutineSQL") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 276")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportRoutineSQL:276@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Exports routines (procedures and functions)
     *
     * @param string $db      Database
     * @param array  $aliases Aliases of db/table/columns
     *
     * @return bool Whether it succeeded
     */
    public function exportRoutines($db, array $aliases = [])
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportRoutines") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 307")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportRoutines:307@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Possibly outputs comment
     *
     * @param string $text Text of comment
     *
     * @return string The formatted comment
     */
    private function exportComment($text = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportComment") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 338")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportComment:338@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Possibly outputs CRLF
     *
     * @return string crlf or nothing
     */
    private function possibleCRLF()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("possibleCRLF") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 359")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called possibleCRLF:359@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Outputs export footer
     *
     * @return bool Whether it succeeded
     */
    public function exportFooter()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportFooter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 371")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportFooter:371@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Outputs export header. It is the first method to be called, so all
     * the required variables are initialized here.
     *
     * @return bool Whether it succeeded
     */
    public function exportHeader()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportHeader") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 398")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportHeader:398@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Outputs CREATE DATABASE statement
     *
     * @param string $db          Database name
     * @param string $export_type 'server', 'database', 'table'
     * @param string $db_alias    Aliases of db
     *
     * @return bool Whether it succeeded
     */
    public function exportDBCreate($db, $export_type, $db_alias = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportDBCreate") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 472")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportDBCreate:472@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Outputs USE statement
     *
     * @param string $db     db to use
     * @param string $compat sql compatibility
     *
     * @return bool Whether it succeeded
     */
    private function exportUseStatement($db, $compat)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportUseStatement") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 512")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportUseStatement:512@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Outputs database header
     *
     * @param string $db       Database name
     * @param string $db_alias Alias of db
     *
     * @return bool Whether it succeeded
     */
    public function exportDBHeader($db, $db_alias = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportDBHeader") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 530")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportDBHeader:530@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Outputs database footer
     *
     * @param string $db Database name
     *
     * @return bool Whether it succeeded
     */
    public function exportDBFooter($db)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportDBFooter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 550")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportDBFooter:550@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Exports events
     *
     * @param string $db Database
     *
     * @return bool Whether it succeeded
     */
    public function exportEvents($db)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportEvents") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 578")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportEvents:578@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Exports metadata from Configuration Storage
     *
     * @param string       $db            database being exported
     * @param string|array $tables        table(s) being exported
     * @param array        $metadataTypes types of metadata to export
     *
     * @return bool Whether it succeeded
     */
    public function exportMetadata($db, $tables, array $metadataTypes)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportMetadata") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 609")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportMetadata:609@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Exports metadata from Configuration Storage
     *
     * @param string      $db            database being exported
     * @param string|null $table         table being exported
     * @param array       $metadataTypes types of metadata to export
     *
     * @return bool Whether it succeeded
     */
    private function exportConfigurationMetadata($db, $table, array $metadataTypes)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportConfigurationMetadata") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 645")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportConfigurationMetadata:645@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Returns a stand-in CREATE definition to resolve view dependencies
     *
     * @param string $db      the database name
     * @param string $view    the view name
     * @param string $crlf    the end of line sequence
     * @param array  $aliases Aliases of db/table/columns
     *
     * @return string resulting definition
     */
    public function getTableDefStandIn($db, $view, $crlf, $aliases = [])
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTableDefStandIn") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 723")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTableDefStandIn:723@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Returns CREATE definition that matches $view's structure
     *
     * @param string $db            the database name
     * @param string $view          the view name
     * @param string $crlf          the end of line sequence
     * @param bool   $add_semicolon whether to add semicolon and end-of-line at
     *                              the end
     * @param array  $aliases       Aliases of db/table/columns
     *
     * @return string resulting schema
     */
    private function getTableDefForView($db, $view, $crlf, $add_semicolon = true, array $aliases = [])
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTableDefForView") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 761")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTableDefForView:761@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Returns $table's CREATE definition
     *
     * @param string $db                        the database name
     * @param string $table                     the table name
     * @param string $crlf                      the end of line sequence
     * @param string $error_url                 the url to go back in case
     *                                          of error
     * @param bool   $show_dates                whether to include creation/
     *                                          update/check dates
     * @param bool   $add_semicolon             whether to add semicolon and
     *                                          end-of-line at the end
     * @param bool   $view                      whether we're handling a view
     * @param bool   $update_indexes_increments whether we need to update
     *                                          two global variables
     * @param array  $aliases                   Aliases of db/table/columns
     *
     * @return string resulting schema
     */
    public function getTableDef($db, $table, $crlf, $error_url, $show_dates = false, $add_semicolon = true, $view = false, $update_indexes_increments = true, array $aliases = [])
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTableDef") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 833")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTableDef:833@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Returns $table's comments, relations etc.
     *
     * @param string $db          database name
     * @param string $table       table name
     * @param string $crlf        end of line sequence
     * @param bool   $do_relation whether to include relation comments
     * @param bool   $do_mime     whether to include mime comments
     * @param array  $aliases     Aliases of db/table/columns
     *
     * @return string resulting comments
     */
    private function getTableComments($db, $table, $crlf, $do_relation = false, $do_mime = false, array $aliases = [])
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTableComments") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 1154")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTableComments:1154@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Outputs a raw query
     *
     * @param string $err_url   the url to go back in case of error
     * @param string $sql_query the rawquery to output
     * @param string $crlf      the seperator for a file
     *
     * @return bool if succeeded
     */
    public function exportRawQuery(string $err_url, string $sql_query, string $crlf) : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportRawQuery") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 1204")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportRawQuery:1204@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Outputs table's structure
     *
     * @param string $db          database name
     * @param string $table       table name
     * @param string $crlf        the end of line sequence
     * @param string $error_url   the url to go back in case of error
     * @param string $export_mode 'create_table','triggers','create_view',
     *                            'stand_in'
     * @param string $export_type 'server', 'database', 'table'
     * @param bool   $relation    whether to include relation comments
     * @param bool   $comments    whether to include the pmadb-style column
     *                            comments as comments in the structure; this is
     *                            deprecated but the parameter is left here
     *                            because /export calls exportStructure()
     *                            also for other export types which use this
     *                            parameter
     * @param bool   $mime        whether to include mime comments
     * @param bool   $dates       whether to include creation/update/check dates
     * @param array  $aliases     Aliases of db/table/columns
     *
     * @return bool Whether it succeeded
     */
    public function exportStructure($db, $table, $crlf, $error_url, $export_mode, $export_type, $relation = false, $comments = false, $mime = false, $dates = false, array $aliases = [])
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportStructure") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 1231")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportStructure:1231@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Outputs the content of a table in SQL format
     *
     * @param string $db        database name
     * @param string $table     table name
     * @param string $crlf      the end of line sequence
     * @param string $error_url the url to go back in case of error
     * @param string $sql_query SQL query for obtaining data
     * @param array  $aliases   Aliases of db/table/columns
     *
     * @return bool Whether it succeeded
     */
    public function exportData($db, $table, $crlf, $error_url, $sql_query, array $aliases = [])
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportData") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 1316")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportData:1316@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Make a create table statement compatible with MSSQL
     *
     * @param string $create_query MySQL create table statement
     *
     * @return string MSSQL compatible create table statement
     */
    private function makeCreateTableMSSQLCompatible($create_query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("makeCreateTableMSSQLCompatible") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 1543")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called makeCreateTableMSSQLCompatible:1543@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * replaces db/table/column names with their aliases
     *
     * @param string $sql_query SQL query in which aliases are to be substituted
     * @param array  $aliases   Alias information for db/table/column
     * @param string $db        the database name
     * @param string $table     the tablename
     * @param string $flag      the flag denoting whether any replacement was done
     *
     * @return string query replaced with aliases
     */
    public function replaceWithAliases($sql_query, array $aliases, $db, $table = '', &$flag = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("replaceWithAliases") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 1585")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called replaceWithAliases:1585@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
    /**
     * Generate comment
     *
     * @param string      $crlf          Carriage return character
     * @param string|null $sql_statement SQL statement
     * @param string      $comment1      Comment for dumped table
     * @param string      $comment2      Comment for current table
     * @param string      $table_alias   Table alias
     * @param string      $compat        Compatibility mode
     *
     * @return string
     */
    protected function generateComment($crlf, ?string $sql_statement, $comment1, $comment2, $table_alias, $compat)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("generateComment") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php at line 1744")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called generateComment:1744@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Plugins/Export/ExportSql.php');
        die();
    }
}