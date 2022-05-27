<?php

declare (strict_types=1);
namespace PhpMyAdmin\Table;

use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Util;
use function count;
use function explode;
use function implode;
use function in_array;
use function is_array;
use function mb_strpos;
use function preg_match;
use function str_replace;
use function strlen;
use function strncasecmp;
use function strpos;
use function trim;
final class Search
{
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param DatabaseInterface $dbi A DatabaseInterface instance.
     */
    public function __construct($dbi)
    {
        $this->dbi = $dbi;
    }
    /**
     * Builds the sql search query from the post parameters
     *
     * @return string the generated SQL query
     */
    public function buildSqlQuery() : string
    {
        $sql_query = 'SELECT ';
        // If only distinct values are needed
        $is_distinct = isset($_POST['distinct']) ? 'true' : 'false';
        if ($is_distinct === 'true') {
            $sql_query .= 'DISTINCT ';
        }
        // if all column names were selected to display, we do a 'SELECT *'
        // (more efficient and this helps prevent a problem in IE
        // if one of the rows is edited and we come back to the Select results)
        if (isset($_POST['zoom_submit']) || !empty($_POST['displayAllColumns'])) {
            $sql_query .= '* ';
        } else {
            $sql_query .= implode(', ', Util::backquote($_POST['columnsToDisplay']));
        }
        $sql_query .= ' FROM ' . Util::backquote($_POST['table']);
        $whereClause = $this->generateWhereClause();
        $sql_query .= $whereClause;
        // if the search results are to be ordered
        if (isset($_POST['orderByColumn']) && $_POST['orderByColumn'] !== '--nil--') {
            $sql_query .= ' ORDER BY ' . Util::backquote($_POST['orderByColumn']) . ' ' . $_POST['order'];
        }
        return $sql_query;
    }
    /**
     * Generates the where clause for the SQL search query to be executed
     *
     * @return string the generated where clause
     */
    private function generateWhereClause() : string
    {
        if (isset($_POST['customWhereClause']) && trim($_POST['customWhereClause']) != '') {
            return ' WHERE ' . $_POST['customWhereClause'];
        }
        // If there are no search criteria set or no unary criteria operators,
        // return
        if (!isset($_POST['criteriaValues']) && !isset($_POST['criteriaColumnOperators']) && !isset($_POST['geom_func'])) {
            return '';
        }
        // else continue to form the where clause from column criteria values
        $fullWhereClause = [];
        foreach ($_POST['criteriaColumnOperators'] as $column_index => $operator) {
            $unaryFlag = $this->dbi->types->isUnaryOperator($operator);
            $tmp_geom_func = $_POST['geom_func'][$column_index] ?? null;
            $whereClause = $this->getWhereClause($_POST['criteriaValues'][$column_index], $_POST['criteriaColumnNames'][$column_index], $_POST['criteriaColumnTypes'][$column_index], $operator, $unaryFlag, $tmp_geom_func);
            if (!$whereClause) {
                continue;
            }
            $fullWhereClause[] = $whereClause;
        }
        if (!empty($fullWhereClause)) {
            return ' WHERE ' . implode(' AND ', $fullWhereClause);
        }
        return '';
    }
    /**
     * Return the where clause for query generation based on the inputs provided.
     *
     * @param mixed       $criteriaValues Search criteria input
     * @param string      $names          Name of the column on which search is submitted
     * @param string      $types          Type of the field
     * @param string      $func_type      Search function/operator
     * @param bool        $unaryFlag      Whether operator unary or not
     * @param string|null $geom_func      Whether geometry functions should be applied
     *
     * @return string generated where clause.
     */
    private function getWhereClause($criteriaValues, $names, $types, $func_type, $unaryFlag, $geom_func = null) : string
    {
        // If geometry function is set
        if (!empty($geom_func)) {
            return $this->getGeomWhereClause($criteriaValues, $names, $func_type, $types, $geom_func);
        }
        $backquoted_name = Util::backquote($names);
        $where = '';
        if ($unaryFlag) {
            $where = $backquoted_name . ' ' . $func_type;
        } elseif (strncasecmp($types, 'enum', 4) == 0 && (!empty($criteriaValues) || $criteriaValues[0] === '0')) {
            $where = $backquoted_name;
            $where .= $this->getEnumWhereClause($criteriaValues, $func_type);
        } elseif ($criteriaValues != '') {
            // For these types we quote the value. Even if it's another type
            // (like INT), for a LIKE we always quote the value. MySQL converts
            // strings to numbers and numbers to strings as necessary
            // during the comparison
            if (preg_match('@char|binary|blob|text|set|date|time|year@i', $types) || mb_strpos(' ' . $func_type, 'LIKE')) {
                $quot = '\'';
            } else {
                $quot = '';
            }
            // LIKE %...%
            if ($func_type === 'LIKE %...%') {
                $func_type = 'LIKE';
                $criteriaValues = '%' . $criteriaValues . '%';
            }
            if ($func_type === 'REGEXP ^...$') {
                $func_type = 'REGEXP';
                $criteriaValues = '^' . $criteriaValues . '$';
            }
            if ($func_type !== 'IN (...)' && $func_type !== 'NOT IN (...)' && $func_type !== 'BETWEEN' && $func_type !== 'NOT BETWEEN') {
                return $backquoted_name . ' ' . $func_type . ' ' . $quot . $this->dbi->escapeString($criteriaValues) . $quot;
            }
            $func_type = str_replace(' (...)', '', $func_type);
            //Don't explode if this is already an array
            //(Case for (NOT) IN/BETWEEN.)
            if (is_array($criteriaValues)) {
                $values = $criteriaValues;
            } else {
                $values = explode(',', $criteriaValues);
            }
            // quote values one by one
            $emptyKey = false;
            foreach ($values as $key => &$value) {
                if ($value === '') {
                    $emptyKey = $key;
                    $value = 'NULL';
                    continue;
                }
                $value = $quot . $this->dbi->escapeString(trim($value)) . $quot;
            }
            if ($func_type === 'BETWEEN' || $func_type === 'NOT BETWEEN') {
                $where = $backquoted_name . ' ' . $func_type . ' ' . ($values[0] ?? '') . ' AND ' . ($values[1] ?? '');
            } else {
                //[NOT] IN
                if ($emptyKey !== false) {
                    unset($values[$emptyKey]);
                }
                $wheres = [];
                if (!empty($values)) {
                    $wheres[] = $backquoted_name . ' ' . $func_type . ' (' . implode(',', $values) . ')';
                }
                if ($emptyKey !== false) {
                    $wheres[] = $backquoted_name . ' IS NULL';
                }
                $where = implode(' OR ', $wheres);
                if (1 < count($wheres)) {
                    $where = '(' . $where . ')';
                }
            }
        }
        return $where;
    }
    /**
     * Return the where clause for a geometrical column.
     *
     * @param mixed       $criteriaValues Search criteria input
     * @param string      $names          Name of the column on which search is submitted
     * @param string      $func_type      Search function/operator
     * @param string      $types          Type of the field
     * @param string|null $geom_func      Whether geometry functions should be applied
     *
     * @return string part of where clause.
     */
    private function getGeomWhereClause($criteriaValues, $names, $func_type, $types, $geom_func = null) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getGeomWhereClause") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Table/Search.php at line 192")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getGeomWhereClause:192@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Table/Search.php');
        die();
    }
    /**
     * Return the where clause in case column's type is ENUM.
     *
     * @param mixed  $criteriaValues Search criteria input
     * @param string $func_type      Search function/operator
     *
     * @return string part of where clause.
     */
    private function getEnumWhereClause($criteriaValues, $func_type) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEnumWhereClause") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Table/Search.php at line 230")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getEnumWhereClause:230@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Table/Search.php');
        die();
    }
}