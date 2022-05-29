<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * set of functions for the sql executor
 *
 * @package PhpMyAdmin
 */
use PMA\libraries\DisplayResults;
use PMA\libraries\Message;
use PMA\libraries\Table;
use PMA\libraries\Response;
use PMA\libraries\URL;
use PMA\libraries\Bookmark;
/**
 * Parses and analyzes the given SQL query.
 *
 * @param string $sql_query SQL query
 * @param string $db        DB name
 *
 * @return mixed
 */
function PMA_parseAndAnalyze($sql_query, $db = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_parseAndAnalyze") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 25")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_parseAndAnalyze:25@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Handle remembered sorting order, only for single table query
 *
 * @param string $db                    database name
 * @param string $table                 table name
 * @param array  &$analyzed_sql_results the analyzed query results
 * @param string &$full_sql_query       SQL query
 *
 * @return void
 */
function PMA_handleSortOrder($db, $table, &$analyzed_sql_results, &$full_sql_query)
{
    $pmatable = new Table($table, $db);
    if (empty($analyzed_sql_results['order'])) {
        // Retrieving the name of the column we should sort after.
        $sortCol = $pmatable->getUiProp(Table::PROP_SORTED_COLUMN);
        if (empty($sortCol)) {
            return;
        }
        // Remove the name of the table from the retrieved field name.
        $sortCol = str_replace(PMA\libraries\Util::backquote($table) . '.', '', $sortCol);
        // Create the new query.
        $full_sql_query = PhpMyAdmin\SqlParser\Utils\Query::replaceClause($analyzed_sql_results['statement'], $analyzed_sql_results['parser']->list, 'ORDER BY ' . $sortCol);
        // TODO: Avoid reparsing the query.
        $analyzed_sql_results = PhpMyAdmin\SqlParser\Utils\Query::getAll($full_sql_query);
    } else {
        // Store the remembered table into session.
        $pmatable->setUiProp(Table::PROP_SORTED_COLUMN, PhpMyAdmin\SqlParser\Utils\Query::getClause($analyzed_sql_results['statement'], $analyzed_sql_results['parser']->list, 'ORDER BY'));
    }
}
/**
 * Append limit clause to SQL query
 *
 * @param array &$analyzed_sql_results the analyzed query results
 *
 * @return string limit clause appended SQL query
 */
function PMA_getSqlWithLimitClause(&$analyzed_sql_results)
{
    return PhpMyAdmin\SqlParser\Utils\Query::replaceClause($analyzed_sql_results['statement'], $analyzed_sql_results['parser']->list, 'LIMIT ' . $_SESSION['tmpval']['pos'] . ', ' . $_SESSION['tmpval']['max_rows']);
}
/**
 * Verify whether the result set has columns from just one table
 *
 * @param array $fields_meta meta fields
 *
 * @return boolean whether the result set has columns from just one table
 */
function PMA_resultSetHasJustOneTable($fields_meta)
{
    $just_one_table = true;
    $prev_table = '';
    foreach ($fields_meta as $one_field_meta) {
        if ($one_field_meta->table != '' && $prev_table != '' && $one_field_meta->table != $prev_table) {
            $just_one_table = false;
        }
        if ($one_field_meta->table != '') {
            $prev_table = $one_field_meta->table;
        }
    }
    return $just_one_table && $prev_table != '';
}
/**
 * Verify whether the result set contains all the columns
 * of at least one unique key
 *
 * @param string $db          database name
 * @param string $table       table name
 * @param array  $fields_meta meta fields
 *
 * @return boolean whether the result set contains a unique key
 */
function PMA_resultSetContainsUniqueKey($db, $table, $fields_meta)
{
    $resultSetColumnNames = array();
    foreach ($fields_meta as $oneMeta) {
        $resultSetColumnNames[] = $oneMeta->name;
    }
    foreach (PMA\libraries\Index::getFromTable($table, $db) as $index) {
        if ($index->isUnique()) {
            $indexColumns = $index->getColumns();
            $numberFound = 0;
            foreach ($indexColumns as $indexColumnName => $dummy) {
                if (in_array($indexColumnName, $resultSetColumnNames)) {
                    $numberFound++;
                }
            }
            if ($numberFound == count($indexColumns)) {
                return true;
            }
        }
    }
    return false;
}
/**
 * Get the HTML for relational column dropdown
 * During grid edit, if we have a relational field, returns the html for the
 * dropdown
 *
 * @param string $db         current database
 * @param string $table      current table
 * @param string $column     current column
 * @param string $curr_value current selected value
 *
 * @return string $dropdown html for the dropdown
 */
function PMA_getHtmlForRelationalColumnDropdown($db, $table, $column, $curr_value)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForRelationalColumnDropdown") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 176")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForRelationalColumnDropdown:176@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Get the HTML for the profiling table and accompanying chart if profiling is set.
 * Otherwise returns null
 *
 * @param string $url_query         url query
 * @param string $db                current database
 * @param array  $profiling_results array containing the profiling info
 *
 * @return string $profiling_table html for the profiling table and chart
 */
function PMA_getHtmlForProfilingChart($url_query, $db, $profiling_results)
{
    if (!empty($profiling_results)) {
        $pma_token = $_SESSION[' PMA_token '];
        $url_query = isset($url_query) ? $url_query : URL::getCommon(array('db' => $db));
        $profiling_table = '';
        $profiling_table .= '<fieldset><legend>' . __('Profiling') . '</legend>' . "\n";
        $profiling_table .= '<div class="floatleft">';
        $profiling_table .= '<h3>' . __('Detailed profile') . '</h3>';
        $profiling_table .= '<table id="profiletable"><thead>' . "\n";
        $profiling_table .= ' <tr>' . "\n";
        $profiling_table .= '  <th>' . __('Order') . '<div class="sorticon"></div></th>' . "\n";
        $profiling_table .= '  <th>' . __('State') . PMA\libraries\Util::showMySQLDocu('general-thread-states') . '<div class="sorticon"></div></th>' . "\n";
        $profiling_table .= '  <th>' . __('Time') . '<div class="sorticon"></div></th>' . "\n";
        $profiling_table .= ' </tr></thead><tbody>' . "\n";
        list($detailed_table, $chart_json, $profiling_stats) = PMA_analyzeAndGetTableHtmlForProfilingResults($profiling_results);
        $profiling_table .= $detailed_table;
        $profiling_table .= '</tbody></table>' . "\n";
        $profiling_table .= '</div>';
        $profiling_table .= '<div class="floatleft">';
        $profiling_table .= '<h3>' . __('Summary by state') . '</h3>';
        $profiling_table .= '<table id="profilesummarytable"><thead>' . "\n";
        $profiling_table .= ' <tr>' . "\n";
        $profiling_table .= '  <th>' . __('State') . PMA\libraries\Util::showMySQLDocu('general-thread-states') . '<div class="sorticon"></div></th>' . "\n";
        $profiling_table .= '  <th>' . __('Total Time') . '<div class="sorticon"></div></th>' . "\n";
        $profiling_table .= '  <th>' . __('% Time') . '<div class="sorticon"></div></th>' . "\n";
        $profiling_table .= '  <th>' . __('Calls') . '<div class="sorticon"></div></th>' . "\n";
        $profiling_table .= '  <th>' . __('ø Time') . '<div class="sorticon"></div></th>' . "\n";
        $profiling_table .= ' </tr></thead><tbody>' . "\n";
        $profiling_table .= PMA_getTableHtmlForProfilingSummaryByState($profiling_stats);
        $profiling_table .= '</tbody></table>' . "\n";
        $profiling_table .= <<<EOT
<script type="text/javascript">
    pma_token = '{$pma_token}';
    url_query = '{$url_query}';
</script>
EOT;
        $profiling_table .= "</div>";
        $profiling_table .= "<div class='clearfloat'></div>";
        //require_once 'libraries/chart.lib.php';
        $profiling_table .= '<div id="profilingChartData" style="display:none;">';
        $profiling_table .= json_encode($chart_json);
        $profiling_table .= '</div>';
        $profiling_table .= '<div id="profilingchart" style="display:none;">';
        $profiling_table .= '</div>';
        $profiling_table .= '<script type="text/javascript">';
        $profiling_table .= "AJAX.registerOnload('sql.js', function () {";
        $profiling_table .= 'makeProfilingChart();';
        $profiling_table .= 'initProfilingTables();';
        $profiling_table .= '});';
        $profiling_table .= '</script>';
        $profiling_table .= '</fieldset>' . "\n";
    } else {
        $profiling_table = null;
    }
    return $profiling_table;
}
/**
 * Function to get HTML for detailed profiling results table, profiling stats, and
 * $chart_json for displaying the chart.
 *
 * @param array $profiling_results profiling results
 *
 * @return mixed
 */
function PMA_analyzeAndGetTableHtmlForProfilingResults($profiling_results)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_analyzeAndGetTableHtmlForProfilingResults") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 310")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_analyzeAndGetTableHtmlForProfilingResults:310@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to get HTML for summary by state table
 *
 * @param array $profiling_stats profiling stats
 *
 * @return string $table html for the table
 */
function PMA_getTableHtmlForProfilingSummaryByState($profiling_stats)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getTableHtmlForProfilingSummaryByState") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 359")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getTableHtmlForProfilingSummaryByState:359@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Get the HTML for the enum column dropdown
 * During grid edit, if we have a enum field, returns the html for the
 * dropdown
 *
 * @param string $db         current database
 * @param string $table      current table
 * @param string $column     current column
 * @param string $curr_value currently selected value
 *
 * @return string $dropdown html for the dropdown
 */
function PMA_getHtmlForEnumColumnDropdown($db, $table, $column, $curr_value)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForEnumColumnDropdown") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 401")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForEnumColumnDropdown:401@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Get value of a column for a specific row (marked by $where_clause)
 *
 * @param string $db           current database
 * @param string $table        current table
 * @param string $column       current column
 * @param string $where_clause where clause to select a particular row
 *
 * @return string with value
 */
function PMA_getFullValuesForSetColumn($db, $table, $column, $where_clause)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getFullValuesForSetColumn") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 420")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getFullValuesForSetColumn:420@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Get the HTML for the set column dropdown
 * During grid edit, if we have a set field, returns the html for the
 * dropdown
 *
 * @param string $db         current database
 * @param string $table      current table
 * @param string $column     current column
 * @param string $curr_value currently selected value
 *
 * @return string $dropdown html for the set column
 */
function PMA_getHtmlForSetColumn($db, $table, $column, $curr_value)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForSetColumn") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 441")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForSetColumn:441@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Get all the values for a enum column or set column in a table
 *
 * @param string $db     current database
 * @param string $table  current table
 * @param string $column current column
 *
 * @return array $values array containing the value list for the column
 */
function PMA_getValuesForColumn($db, $table, $column)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getValuesForColumn") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 483")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getValuesForColumn:483@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Get HTML for options list
 *
 * @param array $values          set of values
 * @param array $selected_values currently selected values
 *
 * @return string $options HTML for options list
 */
function PMA_getHtmlForOptionsList($values, $selected_values)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForOptionsList") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 508")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForOptionsList:508@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to get html for bookmark support if bookmarks are enabled. Else will
 * return null
 *
 * @param array  $displayParts   the parts to display
 * @param array  $cfgBookmark    configuration setting for bookmarking
 * @param string $sql_query      sql query
 * @param string $db             current database
 * @param string $table          current table
 * @param string $complete_query complete query
 * @param string $bkm_user       bookmarking user
 *
 * @return string $html
 */
function PMA_getHtmlForBookmark($displayParts, $cfgBookmark, $sql_query, $db, $table, $complete_query, $bkm_user)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForBookmark") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 536")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForBookmark:536@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to check whether to remember the sorting order or not
 *
 * @param array $analyzed_sql_results the analyzed query and other variables set
 *                                    after analyzing the query
 *
 * @return boolean
 */
function PMA_isRememberSortingOrder($analyzed_sql_results)
{
    return $GLOBALS['cfg']['RememberSorting'] && !($analyzed_sql_results['is_count'] || $analyzed_sql_results['is_export'] || $analyzed_sql_results['is_func'] || $analyzed_sql_results['is_analyse']) && $analyzed_sql_results['select_from'] && (empty($analyzed_sql_results['select_expr']) || count($analyzed_sql_results['select_expr'] == 1) && $analyzed_sql_results['select_expr'][0] == '*') && count($analyzed_sql_results['select_tables']) == 1;
}
/**
 * Function to check whether the LIMIT clause should be appended or not
 *
 * @param array $analyzed_sql_results the analyzed query and other variables set
 *                                    after analyzing the query
 *
 * @return boolean
 */
function PMA_isAppendLimitClause($analyzed_sql_results)
{
    // Assigning LIMIT clause to an syntactically-wrong query
    // is not needed. Also we would want to show the true query
    // and the true error message to the query executor
    return isset($analyzed_sql_results['parser']) && count($analyzed_sql_results['parser']->errors) === 0 && $_SESSION['tmpval']['max_rows'] != 'all' && !($analyzed_sql_results['is_export'] || $analyzed_sql_results['is_analyse']) && ($analyzed_sql_results['select_from'] || $analyzed_sql_results['is_subquery']) && empty($analyzed_sql_results['limit']);
}
/**
 * Function to check whether this query is for just browsing
 *
 * @param array   $analyzed_sql_results the analyzed query and other variables set
 *                                      after analyzing the query
 * @param boolean $find_real_end        whether the real end should be found
 *
 * @return boolean
 */
function PMA_isJustBrowsing($analyzed_sql_results, $find_real_end)
{
    return !$analyzed_sql_results['is_group'] && !$analyzed_sql_results['is_func'] && empty($analyzed_sql_results['union']) && empty($analyzed_sql_results['distinct']) && $analyzed_sql_results['select_from'] && count($analyzed_sql_results['select_tables']) === 1 && (empty($analyzed_sql_results['statement']->where) || count($analyzed_sql_results['statement']->where) == 1 && $analyzed_sql_results['statement']->where[0]->expr === '1') && empty($analyzed_sql_results['group']) && !isset($find_real_end) && !$analyzed_sql_results['is_subquery'] && !$analyzed_sql_results['join'] && empty($analyzed_sql_results['having']);
}
/**
 * Function to check whether the related transformation information should be deleted
 *
 * @param array $analyzed_sql_results the analyzed query and other variables set
 *                                    after analyzing the query
 *
 * @return boolean
 */
function PMA_isDeleteTransformationInfo($analyzed_sql_results)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_isDeleteTransformationInfo") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 681")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_isDeleteTransformationInfo:681@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to check whether the user has rights to drop the database
 *
 * @param array   $analyzed_sql_results  the analyzed query and other variables set
 *                                       after analyzing the query
 * @param boolean $allowUserDropDatabase whether the user is allowed to drop db
 * @param boolean $is_superuser          whether this user is a superuser
 *
 * @return boolean
 */
function PMA_hasNoRightsToDropDatabase($analyzed_sql_results, $allowUserDropDatabase, $is_superuser)
{
    return !$allowUserDropDatabase && isset($analyzed_sql_results['drop_database']) && $analyzed_sql_results['drop_database'] && !$is_superuser;
}
/**
 * Function to set a column property
 *
 * @param Table  $pmatable      Table instance
 * @param string $request_index col_order|col_visib
 *
 * @return boolean $retval
 */
function PMA_setColumnProperty($pmatable, $request_index)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_setColumnProperty") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 715")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_setColumnProperty:715@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to check the request for setting the column order or visibility
 *
 * @param String $table the current table
 * @param String $db    the current database
 *
 * @return void
 */
function PMA_setColumnOrderOrVisibility($table, $db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_setColumnOrderOrVisibility") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 751")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_setColumnOrderOrVisibility:751@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to add a bookmark
 *
 * @param String $goto goto page URL
 *
 * @return void
 */
function PMA_addBookmark($goto)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_addBookmark") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 778")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_addBookmark:778@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to find the real end of rows
 *
 * @param String $db    the current database
 * @param String $table the current table
 *
 * @return mixed the number of rows if "retain" param is true, otherwise true
 */
function PMA_findRealEndOfRows($db, $table)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_findRealEndOfRows") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 819")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_findRealEndOfRows:819@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to get values for the relational columns
 *
 * @param String $db    the current database
 * @param String $table the current table
 *
 * @return void
 */
function PMA_getRelationalValues($db, $table)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getRelationalValues") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 835")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getRelationalValues:835@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to get values for Enum or Set Columns
 *
 * @param String $db         the current database
 * @param String $table      the current table
 * @param String $columnType whether enum or set
 *
 * @return void
 */
function PMA_getEnumOrSetValues($db, $table, $columnType)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getEnumOrSetValues") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 863")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getEnumOrSetValues:863@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to get the default sql query for browsing page
 *
 * @param String $db    the current database
 * @param String $table the current table
 *
 * @return String $sql_query the default $sql_query for browse page
 */
function PMA_getDefaultSqlQueryForBrowse($db, $table)
{
    $bookmark = Bookmark::get($db, $table, 'label', false, true);
    if (!empty($bookmark) && !empty($bookmark->getQuery())) {
        $GLOBALS['using_bookmark_message'] = Message::notice(__('Using bookmark "%s" as default browse query.'));
        $GLOBALS['using_bookmark_message']->addParam($table);
        $GLOBALS['using_bookmark_message']->addHtml(PMA\libraries\Util::showDocu('faq', 'faq6-22'));
        $sql_query = $bookmark->getQuery();
    } else {
        $defaultOrderByClause = '';
        if (isset($GLOBALS['cfg']['TablePrimaryKeyOrder']) && $GLOBALS['cfg']['TablePrimaryKeyOrder'] !== 'NONE') {
            $primaryKey = null;
            $primary = PMA\libraries\Index::getPrimary($table, $db);
            if ($primary !== false) {
                $primarycols = $primary->getColumns();
                foreach ($primarycols as $col) {
                    $primaryKey = $col->getName();
                    break;
                }
                if ($primaryKey != null) {
                    $defaultOrderByClause = ' ORDER BY ' . PMA\libraries\Util::backquote($table) . '.' . PMA\libraries\Util::backquote($primaryKey) . ' ' . $GLOBALS['cfg']['TablePrimaryKeyOrder'];
                }
            }
        }
        $sql_query = 'SELECT * FROM ' . PMA\libraries\Util::backquote($table) . $defaultOrderByClause;
    }
    return $sql_query;
}
/**
 * Responds an error when an error happens when executing the query
 *
 * @param boolean $is_gotofile    whether goto file or not
 * @param String  $error          error after executing the query
 * @param String  $full_sql_query full sql query
 *
 * @return void
 */
function PMA_handleQueryExecuteError($is_gotofile, $error, $full_sql_query)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_handleQueryExecuteError") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 957")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_handleQueryExecuteError:957@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to store the query as a bookmark
 *
 * @param String  $db                     the current database
 * @param String  $bkm_user               the bookmarking user
 * @param String  $sql_query_for_bookmark the query to be stored in bookmark
 * @param String  $bkm_label              bookmark label
 * @param boolean $bkm_replace            whether to replace existing bookmarks
 *
 * @return void
 */
function PMA_storeTheQueryAsBookmark($db, $bkm_user, $sql_query_for_bookmark, $bkm_label, $bkm_replace)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_storeTheQueryAsBookmark") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 982")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_storeTheQueryAsBookmark:982@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Executes the SQL query and measures its execution time
 *
 * @param String $full_sql_query the full sql query
 *
 * @return array ($result, $querytime)
 */
function PMA_executeQueryAndMeasureTime($full_sql_query)
{
    // close session in case the query takes too long
    session_write_close();
    // Measure query time.
    $querytime_before = array_sum(explode(' ', microtime()));
    $result = @$GLOBALS['dbi']->tryQuery($full_sql_query, null, PMA\libraries\DatabaseInterface::QUERY_STORE);
    $querytime_after = array_sum(explode(' ', microtime()));
    // reopen session
    session_start();
    return array($result, $querytime_after - $querytime_before);
}
/**
 * Function to get the affected or changed number of rows after executing a query
 *
 * @param boolean $is_affected whether the query affected a table
 * @param mixed   $result      results of executing the query
 *
 * @return int    $num_rows    number of rows affected or changed
 */
function PMA_getNumberOfRowsAffectedOrChanged($is_affected, $result)
{
    if (!$is_affected) {
        $num_rows = $result ? @$GLOBALS['dbi']->numRows($result) : 0;
    } else {
        $num_rows = @$GLOBALS['dbi']->affectedRows();
    }
    return $num_rows;
}
/**
 * Checks if the current database has changed
 * This could happen if the user sends a query like "USE `database`;"
 *
 * @param String $db the database in the query
 *
 * @return int $reload whether to reload the navigation(1) or not(0)
 */
function PMA_hasCurrentDbChanged($db)
{
    if (strlen($db) > 0) {
        $current_db = $GLOBALS['dbi']->fetchValue('SELECT DATABASE()');
        // $current_db is false, except when a USE statement was sent
        return $current_db != false && $db !== $current_db;
    }
    return false;
}
/**
 * If a table, database or column gets dropped, clean comments.
 *
 * @param String $db     current database
 * @param String $table  current table
 * @param String $column current column
 * @param bool   $purge  whether purge set or not
 *
 * @return array $extra_data
 */
function PMA_cleanupRelations($db, $table, $column, $purge)
{
    include_once 'libraries/relation_cleanup.lib.php';
    if (!empty($purge) && strlen($db) > 0) {
        if (strlen($table) > 0) {
            if (isset($column) && strlen($column) > 0) {
                PMA_relationsCleanupColumn($db, $table, $column);
            } else {
                PMA_relationsCleanupTable($db, $table);
            }
        } else {
            PMA_relationsCleanupDatabase($db);
        }
    }
}
/**
 * Function to count the total number of rows for the same 'SELECT' query without
 * the 'LIMIT' clause that may have been programatically added
 *
 * @param int    $num_rows             number of rows affected/changed by the query
 * @param bool   $justBrowsing         whether just browsing or not
 * @param string $db                   the current database
 * @param string $table                the current table
 * @param array  $analyzed_sql_results the analyzed query and other variables set
 *                                     after analyzing the query
 *
 * @return int $unlim_num_rows unlimited number of rows
 */
function PMA_countQueryResults($num_rows, $justBrowsing, $db, $table, $analyzed_sql_results)
{
    /* Shortcut for not analyzed/empty query */
    if (empty($analyzed_sql_results)) {
        return 0;
    }
    if (!PMA_isAppendLimitClause($analyzed_sql_results)) {
        // if we did not append a limit, set this to get a correct
        // "Showing rows..." message
        // $_SESSION['tmpval']['max_rows'] = 'all';
        $unlim_num_rows = $num_rows;
    } elseif ($analyzed_sql_results['querytype'] == 'SELECT' || $analyzed_sql_results['is_subquery']) {
        //    c o u n t    q u e r y
        // If we are "just browsing", there is only one table (and no join),
        // and no WHERE clause (or just 'WHERE 1 '),
        // we do a quick count (which uses MaxExactCount) because
        // SQL_CALC_FOUND_ROWS is not quick on large InnoDB tables
        // However, do not count again if we did it previously
        // due to $find_real_end == true
        if ($justBrowsing) {
            // Get row count (is approximate for InnoDB)
            $unlim_num_rows = $GLOBALS['dbi']->getTable($db, $table)->countRecords();
            /**
             * @todo Can we know at this point that this is InnoDB,
             *       (in this case there would be no need for getting
             *       an exact count)?
             */
            if ($unlim_num_rows < $GLOBALS['cfg']['MaxExactCount']) {
                // Get the exact count if approximate count
                // is less than MaxExactCount
                /**
                 * @todo In countRecords(), MaxExactCount is also verified,
                 *       so can we avoid checking it twice?
                 */
                $unlim_num_rows = $GLOBALS['dbi']->getTable($db, $table)->countRecords(true);
            }
        } else {
            // The SQL_CALC_FOUND_ROWS option of the SELECT statement is used.
            // For UNION statements, only a SQL_CALC_FOUND_ROWS is required
            // after the first SELECT.
            $count_query = PhpMyAdmin\SqlParser\Utils\Query::replaceClause($analyzed_sql_results['statement'], $analyzed_sql_results['parser']->list, 'SELECT SQL_CALC_FOUND_ROWS', null, true);
            // Another LIMIT clause is added to avoid long delays.
            // A complete result will be returned anyway, but the LIMIT would
            // stop the query as soon as the result that is required has been
            // computed.
            if (empty($analyzed_sql_results['union'])) {
                $count_query .= ' LIMIT 1';
            }
            // Running the count query.
            $GLOBALS['dbi']->tryQuery($count_query);
            $unlim_num_rows = $GLOBALS['dbi']->fetchValue('SELECT FOUND_ROWS()');
        }
        // end else "just browsing"
    } else {
        // not $is_select
        $unlim_num_rows = 0;
    }
    return $unlim_num_rows;
}
/**
 * Function to handle all aspects relating to executing the query
 *
 * @param array   $analyzed_sql_results   analyzed sql results
 * @param String  $full_sql_query         full sql query
 * @param boolean $is_gotofile            whether to go to a file
 * @param String  $db                     current database
 * @param String  $table                  current table
 * @param boolean $find_real_end          whether to find the real end
 * @param String  $sql_query_for_bookmark sql query to be stored as bookmark
 * @param array   $extra_data             extra data
 *
 * @return mixed
 */
function PMA_executeTheQuery($analyzed_sql_results, $full_sql_query, $is_gotofile, $db, $table, $find_real_end, $sql_query_for_bookmark, $extra_data)
{
    $response = Response::getInstance();
    $response->getHeader()->getMenu()->setTable($table);
    // Only if we ask to see the php code
    if (isset($GLOBALS['show_as_php'])) {
        $result = null;
        $num_rows = 0;
        $unlim_num_rows = 0;
    } else {
        // If we don't ask to see the php code
        if (isset($_SESSION['profiling']) && PMA\libraries\Util::profilingSupported()) {
            $GLOBALS['dbi']->query('SET PROFILING=1;');
        }
        list($result, $GLOBALS['querytime']) = PMA_executeQueryAndMeasureTime($full_sql_query);
        // Displays an error message if required and stop parsing the script
        $error = $GLOBALS['dbi']->getError();
        if ($error && $GLOBALS['cfg']['IgnoreMultiSubmitErrors']) {
            $extra_data['error'] = $error;
        } elseif ($error) {
            PMA_handleQueryExecuteError($is_gotofile, $error, $full_sql_query);
        }
        // If there are no errors and bookmarklabel was given,
        // store the query as a bookmark
        if (!empty($_POST['bkm_label']) && !empty($sql_query_for_bookmark)) {
            $cfgBookmark = Bookmark::getParams();
            PMA_storeTheQueryAsBookmark($db, $cfgBookmark['user'], $sql_query_for_bookmark, $_POST['bkm_label'], isset($_POST['bkm_replace']) ? $_POST['bkm_replace'] : null);
        }
        // end store bookmarks
        // Gets the number of rows affected/returned
        // (This must be done immediately after the query because
        // mysql_affected_rows() reports about the last query done)
        $num_rows = PMA_getNumberOfRowsAffectedOrChanged($analyzed_sql_results['is_affected'], $result);
        // Grabs the profiling results
        if (isset($_SESSION['profiling']) && PMA\libraries\Util::profilingSupported()) {
            $profiling_results = $GLOBALS['dbi']->fetchResult('SHOW PROFILE;');
        }
        $justBrowsing = PMA_isJustBrowsing($analyzed_sql_results, isset($find_real_end) ? $find_real_end : null);
        $unlim_num_rows = PMA_countQueryResults($num_rows, $justBrowsing, $db, $table, $analyzed_sql_results);
        PMA_cleanupRelations(isset($db) ? $db : '', isset($table) ? $table : '', isset($_REQUEST['dropped_column']) ? $_REQUEST['dropped_column'] : null, isset($_REQUEST['purge']) ? $_REQUEST['purge'] : null);
        if (isset($_REQUEST['dropped_column']) && strlen($db) > 0 && strlen($table) > 0) {
            // to refresh the list of indexes (Ajax mode)
            $extra_data['indexes_list'] = PMA\libraries\Index::getHtmlForIndexes($table, $db);
        }
    }
    return array($result, $num_rows, $unlim_num_rows, isset($profiling_results) ? $profiling_results : null, $extra_data);
}
/**
 * Delete related tranformation information
 *
 * @param String $db                   current database
 * @param String $table                current table
 * @param array  $analyzed_sql_results analyzed sql results
 *
 * @return void
 */
function PMA_deleteTransformationInfo($db, $table, $analyzed_sql_results)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_deleteTransformationInfo") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 1300")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_deleteTransformationInfo:1300@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to get the message for the no rows returned case
 *
 * @param string $message_to_show      message to show
 * @param array  $analyzed_sql_results analyzed sql results
 * @param int    $num_rows             number of rows
 *
 * @return string $message
 */
function PMA_getMessageForNoRowsReturned($message_to_show, $analyzed_sql_results, $num_rows)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getMessageForNoRowsReturned") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 1331")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getMessageForNoRowsReturned:1331@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to respond back when the query returns zero rows
 * This method is called
 * 1-> When browsing an empty table
 * 2-> When executing a query on a non empty table which returns zero results
 * 3-> When executing a query on an empty table
 * 4-> When executing an INSERT, UPDATE, DELETE query from the SQL tab
 * 5-> When deleting a row from BROWSE tab
 * 6-> When searching using the SEARCH tab which returns zero results
 * 7-> When changing the structure of the table except change operation
 *
 * @param array          $analyzed_sql_results analyzed sql results
 * @param string         $db                   current database
 * @param string         $table                current table
 * @param string         $message_to_show      message to show
 * @param int            $num_rows             number of rows
 * @param DisplayResults $displayResultsObject DisplayResult instance
 * @param array          $extra_data           extra data
 * @param string         $pmaThemeImage        uri of the theme image
 * @param object         $result               executed query results
 * @param string         $sql_query            sql query
 * @param string         $complete_query       complete sql query
 *
 * @return string html
 */
function PMA_getQueryResponseForNoResultsReturned($analyzed_sql_results, $db, $table, $message_to_show, $num_rows, $displayResultsObject, $extra_data, $pmaThemeImage, $result, $sql_query, $complete_query)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getQueryResponseForNoResultsReturned") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 1423")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getQueryResponseForNoResultsReturned:1423@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to send response for ajax grid edit
 *
 * @param object $result result of the executed query
 *
 * @return void
 */
function PMA_sendResponseForGridEdit($result)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_sendResponseForGridEdit") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 1509")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_sendResponseForGridEdit:1509@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to get html for the sql query results div
 *
 * @param string  $previous_update_query_html html for the previously executed query
 * @param string  $profiling_chart_html       html for profiling
 * @param Message $missing_unique_column_msg  message for the missing unique column
 * @param Message $bookmark_created_msg       message for bookmark creation
 * @param string  $table_html                 html for the table for displaying sql
 *                                            results
 * @param string  $indexes_problems_html      html for displaying errors in indexes
 * @param string  $bookmark_support_html      html for displaying bookmark form
 *
 * @return string $html_output
 */
function PMA_getHtmlForSqlQueryResults($previous_update_query_html, $profiling_chart_html, $missing_unique_column_msg, $bookmark_created_msg, $table_html, $indexes_problems_html, $bookmark_support_html)
{
    //begin the sqlqueryresults div here. container div
    $html_output = '<div class="sqlqueryresults ajax">';
    $html_output .= isset($previous_update_query_html) ? $previous_update_query_html : '';
    $html_output .= isset($profiling_chart_html) ? $profiling_chart_html : '';
    $html_output .= isset($missing_unique_column_msg) ? $missing_unique_column_msg->getDisplay() : '';
    $html_output .= isset($bookmark_created_msg) ? $bookmark_created_msg->getDisplay() : '';
    $html_output .= $table_html;
    $html_output .= isset($indexes_problems_html) ? $indexes_problems_html : '';
    $html_output .= isset($bookmark_support_html) ? $bookmark_support_html : '';
    $html_output .= '</div>';
    // end sqlqueryresults div
    return $html_output;
}
/**
 * Returns a message for successful creation of a bookmark or null if a bookmark
 * was not created
 *
 * @return Message $bookmark_created_msg
 */
function PMA_getBookmarkCreatedMessage()
{
    if (isset($_GET['label'])) {
        $bookmark_created_msg = Message::success(__('Bookmark %s has been created.'));
        $bookmark_created_msg->addParam($_GET['label']);
    } else {
        $bookmark_created_msg = null;
    }
    return $bookmark_created_msg;
}
/**
 * Function to get html for the sql query results table
 *
 * @param DisplayResults $displayResultsObject instance of DisplayResult
 * @param string         $pmaThemeImage        theme image uri
 * @param string         $url_query            url query
 * @param array          $displayParts         the parts to display
 * @param bool           $editable             whether the result table is
 *                                             editable or not
 * @param int            $unlim_num_rows       unlimited number of rows
 * @param int            $num_rows             number of rows
 * @param bool           $showtable            whether to show table or not
 * @param object         $result               result of the executed query
 * @param array          $analyzed_sql_results analyzed sql results
 * @param bool           $is_limited_display   Show only limited operations or not
 *
 * @return String
 */
function PMA_getHtmlForSqlQueryResultsTable($displayResultsObject, $pmaThemeImage, $url_query, $displayParts, $editable, $unlim_num_rows, $num_rows, $showtable, $result, $analyzed_sql_results, $is_limited_display = false)
{
    $printview = isset($_REQUEST['printview']) && $_REQUEST['printview'] == '1' ? '1' : null;
    $table_html = '';
    $browse_dist = !empty($_REQUEST['is_browse_distinct']);
    if ($analyzed_sql_results['is_procedure']) {
        do {
            if (!isset($result)) {
                $result = $GLOBALS['dbi']->storeResult();
            }
            $num_rows = $GLOBALS['dbi']->numRows($result);
            if ($result !== false && $num_rows > 0) {
                $fields_meta = $GLOBALS['dbi']->getFieldsMeta($result);
                $fields_cnt = count($fields_meta);
                $displayResultsObject->setProperties($num_rows, $fields_meta, $analyzed_sql_results['is_count'], $analyzed_sql_results['is_export'], $analyzed_sql_results['is_func'], $analyzed_sql_results['is_analyse'], $num_rows, $fields_cnt, $GLOBALS['querytime'], $pmaThemeImage, $GLOBALS['text_dir'], $analyzed_sql_results['is_maint'], $analyzed_sql_results['is_explain'], $analyzed_sql_results['is_show'], $showtable, $printview, $url_query, $editable, $browse_dist);
                $displayParts = array('edit_lnk' => $displayResultsObject::NO_EDIT_OR_DELETE, 'del_lnk' => $displayResultsObject::NO_EDIT_OR_DELETE, 'sort_lnk' => '1', 'nav_bar' => '1', 'bkm_form' => '1', 'text_btn' => '1', 'pview_lnk' => '1');
                $table_html .= $displayResultsObject->getTable($result, $displayParts, $analyzed_sql_results, $is_limited_display);
            }
            $GLOBALS['dbi']->freeResult($result);
            unset($result);
        } while ($GLOBALS['dbi']->moreResults() && $GLOBALS['dbi']->nextResult());
    } else {
        if (isset($result) && $result) {
            $fields_meta = $GLOBALS['dbi']->getFieldsMeta($result);
            $fields_cnt = count($fields_meta);
        }
        $_SESSION['is_multi_query'] = false;
        $displayResultsObject->setProperties($unlim_num_rows, $fields_meta, $analyzed_sql_results['is_count'], $analyzed_sql_results['is_export'], $analyzed_sql_results['is_func'], $analyzed_sql_results['is_analyse'], $num_rows, $fields_cnt, $GLOBALS['querytime'], $pmaThemeImage, $GLOBALS['text_dir'], $analyzed_sql_results['is_maint'], $analyzed_sql_results['is_explain'], $analyzed_sql_results['is_show'], $showtable, $printview, $url_query, $editable, $browse_dist);
        $table_html .= $displayResultsObject->getTable($result, $displayParts, $analyzed_sql_results, $is_limited_display);
        $GLOBALS['dbi']->freeResult($result);
    }
    return $table_html;
}
/**
 * Function to get html for the previous query if there is such. If not will return
 * null
 *
 * @param string $disp_query   display query
 * @param bool   $showSql      whether to show sql
 * @param array  $sql_data     sql data
 * @param string $disp_message display message
 *
 * @return string $previous_update_query_html
 */
function PMA_getHtmlForPreviousUpdateQuery($disp_query, $showSql, $sql_data, $disp_message)
{
    // previous update query (from tbl_replace)
    if (isset($disp_query) && $showSql == true && empty($sql_data)) {
        $previous_update_query_html = PMA\libraries\Util::getMessage($disp_message, $disp_query, 'success');
    } else {
        $previous_update_query_html = null;
    }
    return $previous_update_query_html;
}
/**
 * To get the message if a column index is missing. If not will return null
 *
 * @param string  $table      current table
 * @param string  $db         current database
 * @param boolean $editable   whether the results table can be editable or not
 * @param boolean $has_unique whether there is a unique key
 *
 * @return Message $message
 */
function PMA_getMessageIfMissingColumnIndex($table, $db, $editable, $has_unique)
{
    if (!empty($table) && ($GLOBALS['dbi']->isSystemSchema($db) || !$editable)) {
        $missing_unique_column_msg = Message::notice(sprintf(__('Current selection does not contain a unique column.' . ' Grid edit, checkbox, Edit, Copy and Delete features' . ' are not available. %s'), PMA\libraries\Util::showDocu('config', 'cfg_RowActionLinksWithoutUnique')));
    } elseif (!empty($table) && !$has_unique) {
        $missing_unique_column_msg = Message::notice(sprintf(__('Current selection does not contain a unique column.' . ' Grid edit, Edit, Copy and Delete features may result in' . ' undesired behavior. %s'), PMA\libraries\Util::showDocu('config', 'cfg_RowActionLinksWithoutUnique')));
    } else {
        $missing_unique_column_msg = null;
    }
    return $missing_unique_column_msg;
}
/**
 * Function to get html to display problems in indexes
 *
 * @param string     $query_type     query type
 * @param array|null $selectedTables array of table names selected from the
 *                                   database structure page, for an action
 *                                   like check table, optimize table,
 *                                   analyze table or repair table
 * @param string     $db             current database
 *
 * @return string
 */
function PMA_getHtmlForIndexesProblems($query_type, $selectedTables, $db)
{
    // BEGIN INDEX CHECK See if indexes should be checked.
    if (isset($query_type) && $query_type == 'check_tbl' && isset($selectedTables) && is_array($selectedTables)) {
        $indexes_problems_html = '';
        foreach ($selectedTables as $tbl_name) {
            $check = PMA\libraries\Index::findDuplicates($tbl_name, $db);
            if (!empty($check)) {
                $indexes_problems_html .= sprintf(__('Problems with indexes of table `%s`'), $tbl_name);
                $indexes_problems_html .= $check;
            }
        }
    } else {
        $indexes_problems_html = null;
    }
    return $indexes_problems_html;
}
/**
 * Function to display results when the executed query returns non empty results
 *
 * @param object         $result               executed query results
 * @param array          $analyzed_sql_results analysed sql results
 * @param string         $db                   current database
 * @param string         $table                current table
 * @param string         $message              message to show
 * @param array          $sql_data             sql data
 * @param DisplayResults $displayResultsObject Instance of DisplayResults
 * @param string         $pmaThemeImage        uri of the theme image
 * @param int            $unlim_num_rows       unlimited number of rows
 * @param int            $num_rows             number of rows
 * @param string         $disp_query           display query
 * @param string         $disp_message         display message
 * @param array          $profiling_results    profiling results
 * @param string         $query_type           query type
 * @param array|null     $selectedTables       array of table names selected
 *                                             from the database structure page, for
 *                                             an action like check table,
 *                                             optimize table, analyze table or
 *                                             repair table
 * @param string         $sql_query            sql query
 * @param string         $complete_query       complete sql query
 *
 * @return string html
 */
function PMA_getQueryResponseForResultsReturned($result, $analyzed_sql_results, $db, $table, $message, $sql_data, $displayResultsObject, $pmaThemeImage, $unlim_num_rows, $num_rows, $disp_query, $disp_message, $profiling_results, $query_type, $selectedTables, $sql_query, $complete_query)
{
    // If we are retrieving the full value of a truncated field or the original
    // value of a transformed field, show it here
    if (isset($_REQUEST['grid_edit']) && $_REQUEST['grid_edit'] == true) {
        PMA_sendResponseForGridEdit($result);
        // script has exited at this point
    }
    // Gets the list of fields properties
    if (isset($result) && $result) {
        $fields_meta = $GLOBALS['dbi']->getFieldsMeta($result);
    }
    // Should be initialized these parameters before parsing
    $showtable = isset($showtable) ? $showtable : null;
    $url_query = isset($url_query) ? $url_query : null;
    $response = Response::getInstance();
    $header = $response->getHeader();
    $scripts = $header->getScripts();
    $just_one_table = PMA_resultSetHasJustOneTable($fields_meta);
    // hide edit and delete links:
    // - for information_schema
    // - if the result set does not contain all the columns of a unique key
    //   (unless this is an updatable view)
    // - if the SELECT query contains a join or a subquery
    $updatableView = false;
    $statement = $analyzed_sql_results['statement'];
    if ($statement instanceof PhpMyAdmin\SqlParser\Statements\SelectStatement) {
        if (!empty($statement->expr)) {
            if ($statement->expr[0]->expr === '*') {
                $_table = new Table($table, $db);
                $updatableView = $_table->isUpdatableView();
            }
        }
        if ($analyzed_sql_results['join'] || $analyzed_sql_results['is_subquery'] || count($analyzed_sql_results['select_tables']) !== 1) {
            $just_one_table = false;
        }
    }
    $has_unique = PMA_resultSetContainsUniqueKey($db, $table, $fields_meta);
    $editable = ($has_unique || $GLOBALS['cfg']['RowActionLinksWithoutUnique'] || $updatableView) && $just_one_table;
    $displayParts = array('edit_lnk' => $displayResultsObject::UPDATE_ROW, 'del_lnk' => $displayResultsObject::DELETE_ROW, 'sort_lnk' => '1', 'nav_bar' => '1', 'bkm_form' => '1', 'text_btn' => '0', 'pview_lnk' => '1');
    if ($GLOBALS['dbi']->isSystemSchema($db) || !$editable) {
        $displayParts = array('edit_lnk' => $displayResultsObject::NO_EDIT_OR_DELETE, 'del_lnk' => $displayResultsObject::NO_EDIT_OR_DELETE, 'sort_lnk' => '1', 'nav_bar' => '1', 'bkm_form' => '1', 'text_btn' => '1', 'pview_lnk' => '1');
    }
    if (isset($_REQUEST['printview']) && $_REQUEST['printview'] == '1') {
        $displayParts = array('edit_lnk' => $displayResultsObject::NO_EDIT_OR_DELETE, 'del_lnk' => $displayResultsObject::NO_EDIT_OR_DELETE, 'sort_lnk' => '0', 'nav_bar' => '0', 'bkm_form' => '0', 'text_btn' => '0', 'pview_lnk' => '0');
    }
    if (isset($_REQUEST['table_maintenance'])) {
        $scripts->addFile('makegrid.js');
        $scripts->addFile('sql.js');
        $table_maintenance_html = '';
        if (isset($message)) {
            $message = Message::success($message);
            $table_maintenance_html = PMA\libraries\Util::getMessage($message, $GLOBALS['sql_query'], 'success');
        }
        $table_maintenance_html .= PMA_getHtmlForSqlQueryResultsTable($displayResultsObject, $pmaThemeImage, $url_query, $displayParts, false, $unlim_num_rows, $num_rows, $showtable, $result, $analyzed_sql_results);
        if (empty($sql_data) || ($sql_data['valid_queries'] = 1)) {
            $response->addHTML($table_maintenance_html);
            exit;
        }
    }
    if (!isset($_REQUEST['printview']) || $_REQUEST['printview'] != '1') {
        $scripts->addFile('makegrid.js');
        $scripts->addFile('sql.js');
        unset($GLOBALS['message']);
        //we don't need to buffer the output in getMessage here.
        //set a global variable and check against it in the function
        $GLOBALS['buffer_message'] = false;
    }
    $previous_update_query_html = PMA_getHtmlForPreviousUpdateQuery(isset($disp_query) ? $disp_query : null, $GLOBALS['cfg']['ShowSQL'], isset($sql_data) ? $sql_data : null, isset($disp_message) ? $disp_message : null);
    $profiling_chart_html = PMA_getHtmlForProfilingChart($url_query, $db, isset($profiling_results) ? $profiling_results : array());
    $missing_unique_column_msg = PMA_getMessageIfMissingColumnIndex($table, $db, $editable, $has_unique);
    $bookmark_created_msg = PMA_getBookmarkCreatedMessage();
    $table_html = PMA_getHtmlForSqlQueryResultsTable($displayResultsObject, $pmaThemeImage, $url_query, $displayParts, $editable, $unlim_num_rows, $num_rows, $showtable, $result, $analyzed_sql_results);
    $indexes_problems_html = PMA_getHtmlForIndexesProblems(isset($query_type) ? $query_type : null, isset($selectedTables) ? $selectedTables : null, $db);
    $cfgBookmark = Bookmark::getParams();
    if ($cfgBookmark) {
        $bookmark_support_html = PMA_getHtmlForBookmark($displayParts, $cfgBookmark, $sql_query, $db, $table, isset($complete_query) ? $complete_query : $sql_query, $cfgBookmark['user']);
    } else {
        $bookmark_support_html = '';
    }
    $html_output = isset($table_maintenance_html) ? $table_maintenance_html : '';
    $html_output .= PMA_getHtmlForSqlQueryResults($previous_update_query_html, $profiling_chart_html, $missing_unique_column_msg, $bookmark_created_msg, $table_html, $indexes_problems_html, $bookmark_support_html);
    return $html_output;
}
/**
 * Function to execute the query and send the response
 *
 * @param array      $analyzed_sql_results   analysed sql results
 * @param bool       $is_gotofile            whether goto file or not
 * @param string     $db                     current database
 * @param string     $table                  current table
 * @param bool|null  $find_real_end          whether to find real end or not
 * @param string     $sql_query_for_bookmark the sql query to be stored as bookmark
 * @param array|null $extra_data             extra data
 * @param string     $message_to_show        message to show
 * @param string     $message                message
 * @param array|null $sql_data               sql data
 * @param string     $goto                   goto page url
 * @param string     $pmaThemeImage          uri of the PMA theme image
 * @param string     $disp_query             display query
 * @param string     $disp_message           display message
 * @param string     $query_type             query type
 * @param string     $sql_query              sql query
 * @param array|null $selectedTables         array of table names selected from the
 *                                           database structure page, for an action
 *                                           like check table, optimize table,
 *                                           analyze table or repair table
 * @param string     $complete_query         complete query
 *
 * @return void
 */
function PMA_executeQueryAndSendQueryResponse($analyzed_sql_results, $is_gotofile, $db, $table, $find_real_end, $sql_query_for_bookmark, $extra_data, $message_to_show, $message, $sql_data, $goto, $pmaThemeImage, $disp_query, $disp_message, $query_type, $sql_query, $selectedTables, $complete_query)
{
    if ($analyzed_sql_results == null) {
        // Parse and analyze the query
        include_once 'libraries/parse_analyze.lib.php';
        list($analyzed_sql_results, $db, $table_from_sql) = PMA_parseAnalyze($sql_query, $db);
        // @todo: possibly refactor
        extract($analyzed_sql_results);
        if ($table != $table_from_sql && !empty($table_from_sql)) {
            $table = $table_from_sql;
        }
    }
    $html_output = PMA_executeQueryAndGetQueryResponse(
        $analyzed_sql_results,
        // analyzed_sql_results
        $is_gotofile,
        // is_gotofile
        $db,
        // db
        $table,
        // table
        $find_real_end,
        // find_real_end
        $sql_query_for_bookmark,
        // sql_query_for_bookmark
        $extra_data,
        // extra_data
        $message_to_show,
        // message_to_show
        $message,
        // message
        $sql_data,
        // sql_data
        $goto,
        // goto
        $pmaThemeImage,
        // pmaThemeImage
        $disp_query,
        // disp_query
        $disp_message,
        // disp_message
        $query_type,
        // query_type
        $sql_query,
        // sql_query
        $selectedTables,
        // selectedTables
        $complete_query
    );
    $response = Response::getInstance();
    $response->addHTML($html_output);
}
/**
 * Function to execute the query and send the response
 *
 * @param array      $analyzed_sql_results   analysed sql results
 * @param bool       $is_gotofile            whether goto file or not
 * @param string     $db                     current database
 * @param string     $table                  current table
 * @param bool|null  $find_real_end          whether to find real end or not
 * @param string     $sql_query_for_bookmark the sql query to be stored as bookmark
 * @param array|null $extra_data             extra data
 * @param string     $message_to_show        message to show
 * @param string     $message                message
 * @param array|null $sql_data               sql data
 * @param string     $goto                   goto page url
 * @param string     $pmaThemeImage          uri of the PMA theme image
 * @param string     $disp_query             display query
 * @param string     $disp_message           display message
 * @param string     $query_type             query type
 * @param string     $sql_query              sql query
 * @param array|null $selectedTables         array of table names selected from the
 *                                           database structure page, for an action
 *                                           like check table, optimize table,
 *                                           analyze table or repair table
 * @param string     $complete_query         complete query
 *
 * @return string html
 */
function PMA_executeQueryAndGetQueryResponse($analyzed_sql_results, $is_gotofile, $db, $table, $find_real_end, $sql_query_for_bookmark, $extra_data, $message_to_show, $message, $sql_data, $goto, $pmaThemeImage, $disp_query, $disp_message, $query_type, $sql_query, $selectedTables, $complete_query)
{
    // Handle disable/enable foreign key checks
    $default_fk_check = PMA\libraries\Util::handleDisableFKCheckInit();
    // Handle remembered sorting order, only for single table query.
    // Handling is not required when it's a union query
    // (the parser never sets the 'union' key to 0).
    // Handling is also not required if we came from the "Sort by key"
    // drop-down.
    if (!empty($analyzed_sql_results) && PMA_isRememberSortingOrder($analyzed_sql_results) && empty($analyzed_sql_results['union']) && !isset($_REQUEST['sort_by_key'])) {
        if (!isset($_SESSION['sql_from_query_box'])) {
            PMA_handleSortOrder($db, $table, $analyzed_sql_results, $sql_query);
        } else {
            unset($_SESSION['sql_from_query_box']);
        }
    }
    $displayResultsObject = new PMA\libraries\DisplayResults($GLOBALS['db'], $GLOBALS['table'], $goto, $sql_query);
    $displayResultsObject->setConfigParamsForDisplayTable();
    // assign default full_sql_query
    $full_sql_query = $sql_query;
    // Do append a "LIMIT" clause?
    if (PMA_isAppendLimitClause($analyzed_sql_results)) {
        $full_sql_query = PMA_getSqlWithLimitClause($analyzed_sql_results);
    }
    $GLOBALS['reload'] = PMA_hasCurrentDbChanged($db);
    $GLOBALS['dbi']->selectDb($db);
    // Execute the query
    list($result, $num_rows, $unlim_num_rows, $profiling_results, $extra_data) = PMA_executeTheQuery($analyzed_sql_results, $full_sql_query, $is_gotofile, $db, $table, isset($find_real_end) ? $find_real_end : null, isset($sql_query_for_bookmark) ? $sql_query_for_bookmark : null, isset($extra_data) ? $extra_data : null);
    // No rows returned -> move back to the calling page
    if (0 == $num_rows && 0 == $unlim_num_rows || $analyzed_sql_results['is_affected']) {
        $html_output = PMA_getQueryResponseForNoResultsReturned($analyzed_sql_results, $db, $table, isset($message_to_show) ? $message_to_show : null, $num_rows, $displayResultsObject, $extra_data, $pmaThemeImage, isset($result) ? $result : null, $sql_query, isset($complete_query) ? $complete_query : null);
    } else {
        // At least one row is returned -> displays a table with results
        $html_output = PMA_getQueryResponseForResultsReturned(isset($result) ? $result : null, $analyzed_sql_results, $db, $table, isset($message) ? $message : null, isset($sql_data) ? $sql_data : null, $displayResultsObject, $pmaThemeImage, $unlim_num_rows, $num_rows, isset($disp_query) ? $disp_query : null, isset($disp_message) ? $disp_message : null, $profiling_results, isset($query_type) ? $query_type : null, isset($selectedTables) ? $selectedTables : null, $sql_query, isset($complete_query) ? $complete_query : null);
    }
    // Handle disable/enable foreign key checks
    PMA\libraries\Util::handleDisableFKCheckCleanup($default_fk_check);
    return $html_output;
}
/**
 * Function to define pos to display a row
 *
 * @param Int $number_of_line Number of the line to display
 * @param Int $max_rows       Number of rows by page
 *
 * @return Int Start position to display the line
 */
function PMA_getStartPosToDisplayRow($number_of_line, $max_rows = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getStartPosToDisplayRow") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 2219")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getStartPosToDisplayRow:2219@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}
/**
 * Function to calculate new pos if pos is higher than number of rows
 * of displayed table
 *
 * @param String   $db    Database name
 * @param String   $table Table name
 * @param Int|null $pos   Initial position
 *
 * @return Int Number of pos to display last page
 */
function PMA_calculatePosForLastPage($db, $table, $pos)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_calculatePosForLastPage") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php at line 2238")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_calculatePosForLastPage:2238@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/sql.lib.php');
    die();
}