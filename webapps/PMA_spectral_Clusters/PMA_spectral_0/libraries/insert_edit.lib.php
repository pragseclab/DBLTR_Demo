<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * set of functions with the insert/edit features in pma
 *
 * @package PhpMyAdmin
 */
use PMA\libraries\Message;
use PMA\libraries\plugins\TransformationsPlugin;
use PMA\libraries\Response;
use PMA\libraries\URL;
use PMA\libraries\Sanitize;
/**
 * Retrieve form parameters for insert/edit form
 *
 * @param string     $db                 name of the database
 * @param string     $table              name of the table
 * @param array|null $where_clauses      where clauses
 * @param array      $where_clause_array array of where clauses
 * @param string     $err_url            error url
 *
 * @return array $form_params array of insert/edit form parameters
 */
function PMA_getFormParametersForInsertForm($db, $table, $where_clauses, $where_clause_array, $err_url)
{
    $_form_params = array('db' => $db, 'table' => $table, 'goto' => $GLOBALS['goto'], 'err_url' => $err_url, 'sql_query' => $_REQUEST['sql_query']);
    if (isset($where_clauses)) {
        foreach ($where_clause_array as $key_id => $where_clause) {
            $_form_params['where_clause[' . $key_id . ']'] = trim($where_clause);
        }
    }
    if (isset($_REQUEST['clause_is_unique'])) {
        $_form_params['clause_is_unique'] = $_REQUEST['clause_is_unique'];
    }
    return $_form_params;
}
/**
 * Creates array of where clauses
 *
 * @param array|string|null $where_clause where clause
 *
 * @return array whereClauseArray array of where clauses
 */
function PMA_getWhereClauseArray($where_clause)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getWhereClauseArray") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 55")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getWhereClauseArray:55@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Analysing where clauses array
 *
 * @param array  $where_clause_array array of where clauses
 * @param string $table              name of the table
 * @param string $db                 name of the database
 *
 * @return array $where_clauses, $result, $rows
 */
function PMA_analyzeWhereClauses($where_clause_array, $table, $db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_analyzeWhereClauses") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 78")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_analyzeWhereClauses:78@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Show message for empty result or set the unique_condition
 *
 * @param array  $rows               MySQL returned rows
 * @param string $key_id             ID in current key
 * @param array  $where_clause_array array of where clauses
 * @param string $local_query        query performed
 * @param array  $result             MySQL result handle
 *
 * @return boolean $has_unique_condition
 */
function PMA_showEmptyResultMessageOrSetUniqueCondition($rows, $key_id, $where_clause_array, $local_query, $result)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_showEmptyResultMessageOrSetUniqueCondition") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 118")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_showEmptyResultMessageOrSetUniqueCondition:118@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * No primary key given, just load first row
 *
 * @param string $table name of the table
 * @param string $db    name of the database
 *
 * @return array                containing $result and $rows arrays
 */
function PMA_loadFirstRow($table, $db)
{
    $result = $GLOBALS['dbi']->query('SELECT * FROM ' . PMA\libraries\Util::backquote($db) . '.' . PMA\libraries\Util::backquote($table) . ' LIMIT 1;', null, PMA\libraries\DatabaseInterface::QUERY_STORE);
    $rows = array_fill(0, $GLOBALS['cfg']['InsertRows'], false);
    return array($result, $rows);
}
/**
 * Add some url parameters
 *
 * @param array  $url_params         containing $db and $table as url parameters
 * @param array  $where_clause_array where clauses array
 * @param string $where_clause       where clause
 *
 * @return array Add some url parameters to $url_params array and return it
 */
function PMA_urlParamsInEditMode($url_params, $where_clause_array, $where_clause)
{
    if (isset($where_clause)) {
        foreach ($where_clause_array as $where_clause) {
            $url_params['where_clause'] = trim($where_clause);
        }
    }
    if (!empty($_REQUEST['sql_query'])) {
        $url_params['sql_query'] = $_REQUEST['sql_query'];
    }
    return $url_params;
}
/**
 * Show type information or function selectors in Insert/Edit
 *
 * @param string  $which      function|type
 * @param array   $url_params containing url parameters
 * @param boolean $is_show    whether to show the element in $which
 *
 * @return string an HTML snippet
 */
function PMA_showTypeOrFunction($which, $url_params, $is_show)
{
    $params = array();
    switch ($which) {
        case 'function':
            $params['ShowFunctionFields'] = $is_show ? 0 : 1;
            $params['ShowFieldTypesInDataEditView'] = $GLOBALS['cfg']['ShowFieldTypesInDataEditView'];
            break;
        case 'type':
            $params['ShowFieldTypesInDataEditView'] = $is_show ? 0 : 1;
            $params['ShowFunctionFields'] = $GLOBALS['cfg']['ShowFunctionFields'];
            break;
    }
    $params['goto'] = 'sql.php';
    $this_url_params = array_merge($url_params, $params);
    if (!$is_show) {
        return ' : <a href="tbl_change.php' . URL::getCommon($this_url_params) . '">' . PMA_showTypeOrFunctionLabel($which) . '</a>';
    }
    return '<th><a href="tbl_change.php' . URL::getCommon($this_url_params) . '" title="' . __('Hide') . '">' . PMA_showTypeOrFunctionLabel($which) . '</a></th>';
}
/**
 * Show type information or function selectors labels in Insert/Edit
 *
 * @param string $which function|type
 *
 * @return string an HTML snippet
 */
function PMA_showTypeOrFunctionLabel($which)
{
    switch ($which) {
        case 'function':
            return __('Function');
        case 'type':
            return __('Type');
    }
    return null;
}
/**
 * Analyze the table column array
 *
 * @param array   $column         description of column in given table
 * @param array   $comments_map   comments for every column that has a comment
 * @param boolean $timestamp_seen whether a timestamp has been seen
 *
 * @return array                   description of column in given table
 */
function PMA_analyzeTableColumnsArray($column, $comments_map, $timestamp_seen)
{
    $column['Field_html'] = htmlspecialchars($column['Field']);
    $column['Field_md5'] = md5($column['Field']);
    // True_Type contains only the type (stops at first bracket)
    $column['True_Type'] = preg_replace('@\\(.*@s', '', $column['Type']);
    $column['len'] = preg_match('@float|double@', $column['Type']) ? 100 : -1;
    $column['Field_title'] = PMA_getColumnTitle($column, $comments_map);
    $column['is_binary'] = PMA_isColumn($column, array('binary', 'varbinary'));
    $column['is_blob'] = PMA_isColumn($column, array('blob', 'tinyblob', 'mediumblob', 'longblob'));
    $column['is_char'] = PMA_isColumn($column, array('char', 'varchar'));
    list($column['pma_type'], $column['wrap'], $column['first_timestamp']) = PMA_getEnumSetAndTimestampColumns($column, $timestamp_seen);
    return $column;
}
/**
 * Retrieve the column title
 *
 * @param array $column       description of column in given table
 * @param array $comments_map comments for every column that has a comment
 *
 * @return string              column title
 */
function PMA_getColumnTitle($column, $comments_map)
{
    if (isset($comments_map[$column['Field']])) {
        return '<span style="border-bottom: 1px dashed black;" title="' . htmlspecialchars($comments_map[$column['Field']]) . '">' . $column['Field_html'] . '</span>';
    } else {
        return $column['Field_html'];
    }
}
/**
 * check whether the column is of a certain type
 * the goal is to ensure that types such as "enum('one','two','binary',..)"
 * or "enum('one','two','varbinary',..)" are not categorized as binary
 *
 * @param array $column description of column in given table
 * @param array $types  the types to verify
 *
 * @return boolean whether the column's type if one of the $types
 */
function PMA_isColumn($column, $types)
{
    foreach ($types as $one_type) {
        if (mb_stripos($column['Type'], $one_type) === 0) {
            return true;
        }
    }
    return false;
}
/**
 * Retrieve set, enum, timestamp table columns
 *
 * @param array   $column         description of column in given table
 * @param boolean $timestamp_seen whether a timestamp has been seen
 *
 * @return array $column['pma_type'], $column['wrap'], $column['first_timestamp']
 */
function PMA_getEnumSetAndTimestampColumns($column, $timestamp_seen)
{
    $column['first_timestamp'] = false;
    switch ($column['True_Type']) {
        case 'set':
            $column['pma_type'] = 'set';
            $column['wrap'] = '';
            break;
        case 'enum':
            $column['pma_type'] = 'enum';
            $column['wrap'] = '';
            break;
        case 'timestamp':
            if (!$timestamp_seen) {
                // can only occur once per table
                $column['first_timestamp'] = true;
            }
            $column['pma_type'] = $column['Type'];
            $column['wrap'] = ' nowrap';
            break;
        default:
            $column['pma_type'] = $column['Type'];
            $column['wrap'] = ' nowrap';
            break;
    }
    return array($column['pma_type'], $column['wrap'], $column['first_timestamp']);
}
/**
 * The function column
 * We don't want binary data to be destroyed
 * Note: from the MySQL manual: "BINARY doesn't affect how the column is
 *       stored or retrieved" so it does not mean that the contents is binary
 *
 * @param array   $column                description of column in given table
 * @param boolean $is_upload             upload or no
 * @param string  $column_name_appendix  the name attribute
 * @param string  $onChangeClause        onchange clause for fields
 * @param array   $no_support_types      list of datatypes that are not (yet)
 *                                       handled by PMA
 * @param integer $tabindex_for_function +3000
 * @param integer $tabindex              tab index
 * @param integer $idindex               id index
 * @param boolean $insert_mode           insert mode or edit mode
 * @param boolean $readOnly              is column read only or not
 * @param array   $foreignData           foreign key data
 *
 * @return string                           an html snippet
 */
function PMA_getFunctionColumn($column, $is_upload, $column_name_appendix, $onChangeClause, $no_support_types, $tabindex_for_function, $tabindex, $idindex, $insert_mode, $readOnly, $foreignData)
{
    $html_output = '';
    if ($GLOBALS['cfg']['ProtectBinary'] === 'blob' && $column['is_blob'] && !$is_upload || $GLOBALS['cfg']['ProtectBinary'] === 'all' && $column['is_binary'] || $GLOBALS['cfg']['ProtectBinary'] === 'noblob' && $column['is_binary']) {
        $html_output .= '<td class="center">' . __('Binary') . '</td>' . "\n";
    } elseif ($readOnly || mb_strstr($column['True_Type'], 'enum') || mb_strstr($column['True_Type'], 'set') || in_array($column['pma_type'], $no_support_types)) {
        $html_output .= '<td class="center">--</td>' . "\n";
    } else {
        $html_output .= '<td>' . "\n";
        $html_output .= '<select name="funcs' . $column_name_appendix . '"' . ' ' . $onChangeClause . ' tabindex="' . ($tabindex + $tabindex_for_function) . '"' . ' id="field_' . $idindex . '_1">';
        $html_output .= PMA\libraries\Util::getFunctionsForField($column, $insert_mode, $foreignData) . "\n";
        $html_output .= '</select>' . "\n";
        $html_output .= '</td>' . "\n";
    }
    return $html_output;
}
/**
 * The null column
 *
 * @param array   $column               description of column in given table
 * @param string  $column_name_appendix the name attribute
 * @param boolean $real_null_value      is column value null or not null
 * @param integer $tabindex             tab index
 * @param integer $tabindex_for_null    +6000
 * @param integer $idindex              id index
 * @param string  $vkey                 [multi_edit]['row_id']
 * @param array   $foreigners           keys into foreign fields
 * @param array   $foreignData          data about the foreign keys
 * @param boolean $readOnly             is column read only or not
 *
 * @return string                       an html snippet
 */
function PMA_getNullColumn($column, $column_name_appendix, $real_null_value, $tabindex, $tabindex_for_null, $idindex, $vkey, $foreigners, $foreignData, $readOnly)
{
    if ($column['Null'] != 'YES' || $readOnly) {
        return "<td></td>\n";
    }
    $html_output = '';
    $html_output .= '<td>' . "\n";
    $html_output .= '<input type="hidden" name="fields_null_prev' . $column_name_appendix . '"';
    if ($real_null_value && !$column['first_timestamp']) {
        $html_output .= ' value="on"';
    }
    $html_output .= ' />' . "\n";
    $html_output .= '<input type="checkbox" class="checkbox_null" tabindex="' . ($tabindex + $tabindex_for_null) . '"' . ' name="fields_null' . $column_name_appendix . '"';
    if ($real_null_value) {
        $html_output .= ' checked="checked"';
    }
    $html_output .= ' id="field_' . $idindex . '_2" />';
    // nullify_code is needed by the js nullify() function
    $nullify_code = PMA_getNullifyCodeForNullColumn($column, $foreigners, $foreignData);
    // to be able to generate calls to nullify() in jQuery
    $html_output .= '<input type="hidden" class="nullify_code" name="nullify_code' . $column_name_appendix . '" value="' . $nullify_code . '" />';
    $html_output .= '<input type="hidden" class="hashed_field" name="hashed_field' . $column_name_appendix . '" value="' . $column['Field_md5'] . '" />';
    $html_output .= '<input type="hidden" class="multi_edit" name="multi_edit' . $column_name_appendix . '" value="' . Sanitize::escapeJsString($vkey) . '" />';
    $html_output .= '</td>' . "\n";
    return $html_output;
}
/**
 * Retrieve the nullify code for the null column
 *
 * @param array $column      description of column in given table
 * @param array $foreigners  keys into foreign fields
 * @param array $foreignData data about the foreign keys
 *
 * @return integer              $nullify_code
 */
function PMA_getNullifyCodeForNullColumn($column, $foreigners, $foreignData)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getNullifyCodeForNullColumn") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 495")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getNullifyCodeForNullColumn:495@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get the HTML elements for value column in insert form
 * (here, "column" is used in the sense of HTML column in HTML table)
 *
 * @param array   $column                description of column in given table
 * @param string  $backup_field          hidden input field
 * @param string  $column_name_appendix  the name attribute
 * @param string  $onChangeClause        onchange clause for fields
 * @param integer $tabindex              tab index
 * @param integer $tabindex_for_value    offset for the values tabindex
 * @param integer $idindex               id index
 * @param string  $data                  description of the column field
 * @param string  $special_chars         special characters
 * @param array   $foreignData           data about the foreign keys
 * @param array   $paramTableDbArray     array containing $table and $db
 * @param integer $rownumber             the row number
 * @param array   $titles                An HTML IMG tag for a particular icon from
 *                                       a theme, which may be an actual file or
 *                                       an icon from a sprite
 * @param string  $text_dir              text direction
 * @param string  $special_chars_encoded replaced char if the string starts
 *                                       with a \r\n pair (0x0d0a) add an extra \n
 * @param string  $vkey                  [multi_edit]['row_id']
 * @param boolean $is_upload             is upload or not
 * @param integer $biggest_max_file_size 0 integer
 * @param string  $default_char_editing  default char editing mode which is stored
 *                                       in the config.inc.php script
 * @param array   $no_support_types      list of datatypes that are not (yet)
 *                                       handled by PMA
 * @param array   $gis_data_types        list of GIS data types
 * @param array   $extracted_columnspec  associative array containing type,
 *                                       spec_in_brackets and possibly
 *                                       enum_set_values (another array)
 * @param boolean $readOnly              is column read only or not
 *
 * @return string an html snippet
 */
function PMA_getValueColumn($column, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $special_chars, $foreignData, $paramTableDbArray, $rownumber, $titles, $text_dir, $special_chars_encoded, $vkey, $is_upload, $biggest_max_file_size, $default_char_editing, $no_support_types, $gis_data_types, $extracted_columnspec, $readOnly)
{
    // HTML5 data-* attribute data-type
    $data_type = $GLOBALS['PMA_Types']->getTypeClass($column['True_Type']);
    $html_output = '';
    if ($foreignData['foreign_link'] == true) {
        $html_output .= PMA_getForeignLink($column, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $paramTableDbArray, $rownumber, $titles, $readOnly);
    } elseif (is_array($foreignData['disp_row'])) {
        $html_output .= PMA_dispRowForeignData($backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $foreignData, $readOnly);
    } elseif ($GLOBALS['cfg']['LongtextDoubleTextarea'] && mb_strstr($column['pma_type'], 'longtext')) {
        $html_output .= PMA_getTextarea($column, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $text_dir, $special_chars_encoded, $data_type, $readOnly);
    } elseif (mb_strstr($column['pma_type'], 'text')) {
        $html_output .= PMA_getTextarea($column, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $text_dir, $special_chars_encoded, $data_type, $readOnly);
        $html_output .= "\n";
        if (mb_strlen($special_chars) > 32000) {
            $html_output .= "</td>\n";
            $html_output .= '<td>' . __('Because of its length,<br /> this column might not be editable.');
        }
    } elseif ($column['pma_type'] == 'enum') {
        $html_output .= PMA_getPmaTypeEnum($column, $backup_field, $column_name_appendix, $extracted_columnspec, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $readOnly);
    } elseif ($column['pma_type'] == 'set') {
        $html_output .= PMA_getPmaTypeSet($column, $extracted_columnspec, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $readOnly);
    } elseif ($column['is_binary'] || $column['is_blob']) {
        $html_output .= PMA_getBinaryAndBlobColumn($column, $data, $special_chars, $biggest_max_file_size, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $text_dir, $special_chars_encoded, $vkey, $is_upload, $readOnly);
    } elseif (!in_array($column['pma_type'], $no_support_types)) {
        $html_output .= PMA_getValueColumnForOtherDatatypes($column, $default_char_editing, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $special_chars, $tabindex_for_value, $idindex, $text_dir, $special_chars_encoded, $data, $extracted_columnspec, $readOnly);
    }
    if (in_array($column['pma_type'], $gis_data_types)) {
        $html_output .= PMA_getHTMLforGisDataTypes();
    }
    return $html_output;
}
/**
 * Get HTML for foreign link in insert form
 *
 * @param array   $column               description of column in given table
 * @param string  $backup_field         hidden input field
 * @param string  $column_name_appendix the name attribute
 * @param string  $onChangeClause       onchange clause for fields
 * @param integer $tabindex             tab index
 * @param integer $tabindex_for_value   offset for the values tabindex
 * @param integer $idindex              id index
 * @param string  $data                 data to edit
 * @param array   $paramTableDbArray    array containing $table and $db
 * @param integer $rownumber            the row number
 * @param array   $titles               An HTML IMG tag for a particular icon from
 *                                      a theme, which may be an actual file or
 *                                      an icon from a sprite
 * @param boolean $readOnly             is column read only or not
 *
 * @return string                       an html snippet
 */
function PMA_getForeignLink($column, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $paramTableDbArray, $rownumber, $titles, $readOnly)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getForeignLink") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 671")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getForeignLink:671@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get HTML to display foreign data
 *
 * @param string  $backup_field         hidden input field
 * @param string  $column_name_appendix the name attribute
 * @param string  $onChangeClause       onchange clause for fields
 * @param integer $tabindex             tab index
 * @param integer $tabindex_for_value   offset for the values tabindex
 * @param integer $idindex              id index
 * @param string  $data                 data to edit
 * @param array   $foreignData          data about the foreign keys
 * @param boolean $readOnly             is display read only or not
 *
 * @return string                       an html snippet
 */
function PMA_dispRowForeignData($backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $foreignData, $readOnly)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_dispRowForeignData") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 719")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_dispRowForeignData:719@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get HTML textarea for insert form
 *
 * @param array   $column                column information
 * @param string  $backup_field          hidden input field
 * @param string  $column_name_appendix  the name attribute
 * @param string  $onChangeClause        onchange clause for fields
 * @param integer $tabindex              tab index
 * @param integer $tabindex_for_value    offset for the values tabindex
 * @param integer $idindex               id index
 * @param string  $text_dir              text direction
 * @param string  $special_chars_encoded replaced char if the string starts
 *                                       with a \r\n pair (0x0d0a) add an extra \n
 * @param string  $data_type             the html5 data-* attribute type
 * @param boolean $readOnly              is column read only or not
 *
 * @return string                       an html snippet
 */
function PMA_getTextarea($column, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $text_dir, $special_chars_encoded, $data_type, $readOnly)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getTextarea") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 769")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getTextarea:769@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get HTML for enum type
 *
 * @param array   $column               description of column in given table
 * @param string  $backup_field         hidden input field
 * @param string  $column_name_appendix the name attribute
 * @param array   $extracted_columnspec associative array containing type,
 *                                      spec_in_brackets and possibly
 *                                      enum_set_values (another array)
 * @param string  $onChangeClause       onchange clause for fields
 * @param integer $tabindex             tab index
 * @param integer $tabindex_for_value   offset for the values tabindex
 * @param integer $idindex              id index
 * @param mixed   $data                 data to edit
 * @param boolean $readOnly             is column read only or not
 *
 * @return string an html snippet
 */
function PMA_getPmaTypeEnum($column, $backup_field, $column_name_appendix, $extracted_columnspec, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $readOnly)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getPmaTypeEnum") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 831")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getPmaTypeEnum:831@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get column values
 *
 * @param array $column               description of column in given table
 * @param array $extracted_columnspec associative array containing type,
 *                                    spec_in_brackets and possibly enum_set_values
 *                                    (another array)
 *
 * @return array column values as an associative array
 */
function PMA_getColumnEnumValues($column, $extracted_columnspec)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getColumnEnumValues") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 869")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getColumnEnumValues:869@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get HTML drop down for more than 20 string length
 *
 * @param array   $column               description of column in given table
 * @param string  $column_name_appendix the name attribute
 * @param string  $onChangeClause       onchange clause for fields
 * @param integer $tabindex             tab index
 * @param integer $tabindex_for_value   offset for the values tabindex
 * @param integer $idindex              id index
 * @param string  $data                 data to edit
 * @param array   $column_enum_values   $column['values']
 * @param boolean $readOnly              is column read only or not
 *
 * @return string                       an html snippet
 */
function PMA_getDropDownDependingOnLength($column, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $column_enum_values, $readOnly)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDropDownDependingOnLength") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 899")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDropDownDependingOnLength:899@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get HTML radio button for less than 20 string length
 *
 * @param string  $column_name_appendix the name attribute
 * @param string  $onChangeClause       onchange clause for fields
 * @param integer $tabindex             tab index
 * @param array   $column               description of column in given table
 * @param integer $tabindex_for_value   offset for the values tabindex
 * @param integer $idindex              id index
 * @param string  $data                 data to edit
 * @param array   $column_enum_values   $column['values']
 * @param boolean $readOnly              is column read only or not
 *
 * @return string                       an html snippet
 */
function PMA_getRadioButtonDependingOnLength($column_name_appendix, $onChangeClause, $tabindex, $column, $tabindex_for_value, $idindex, $data, $column_enum_values, $readOnly)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getRadioButtonDependingOnLength") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 951")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getRadioButtonDependingOnLength:951@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get the HTML for 'set' pma type
 *
 * @param array   $column               description of column in given table
 * @param array   $extracted_columnspec associative array containing type,
 *                                      spec_in_brackets and possibly
 *                                      enum_set_values (another array)
 * @param string  $backup_field         hidden input field
 * @param string  $column_name_appendix the name attribute
 * @param string  $onChangeClause       onchange clause for fields
 * @param integer $tabindex             tab index
 * @param integer $tabindex_for_value   offset for the values tabindex
 * @param integer $idindex              id index
 * @param string  $data                 description of the column field
 * @param boolean $readOnly             is column read only or not
 *
 * @return string                       an html snippet
 */
function PMA_getPmaTypeSet($column, $extracted_columnspec, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $readOnly)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getPmaTypeSet") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 1002")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getPmaTypeSet:1002@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Retrieve column 'set' value and select size
 *
 * @param array $column               description of column in given table
 * @param array $extracted_columnspec associative array containing type,
 *                                    spec_in_brackets and possibly enum_set_values
 *                                    (another array)
 *
 * @return array $column['values'], $column['select_size']
 */
function PMA_getColumnSetValueAndSelectSize($column, $extracted_columnspec)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getColumnSetValueAndSelectSize") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 1049")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getColumnSetValueAndSelectSize:1049@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get HTML for binary and blob column
 *
 * @param array   $column                description of column in given table
 * @param string  $data                  data to edit
 * @param string  $special_chars         special characters
 * @param integer $biggest_max_file_size biggest max file size for uploading
 * @param string  $backup_field          hidden input field
 * @param string  $column_name_appendix  the name attribute
 * @param string  $onChangeClause        onchange clause for fields
 * @param integer $tabindex              tab index
 * @param integer $tabindex_for_value    offset for the values tabindex
 * @param integer $idindex               id index
 * @param string  $text_dir              text direction
 * @param string  $special_chars_encoded replaced char if the string starts
 *                                       with a \r\n pair (0x0d0a) add an extra \n
 * @param string  $vkey                  [multi_edit]['row_id']
 * @param boolean $is_upload             is upload or not
 * @param boolean $readOnly              is column read only or not
 *
 * @return string                           an html snippet
 */
function PMA_getBinaryAndBlobColumn($column, $data, $special_chars, $biggest_max_file_size, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $text_dir, $special_chars_encoded, $vkey, $is_upload, $readOnly)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getBinaryAndBlobColumn") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 1090")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getBinaryAndBlobColumn:1090@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get HTML input type
 *
 * @param array   $column               description of column in given table
 * @param string  $column_name_appendix the name attribute
 * @param string  $special_chars        special characters
 * @param integer $fieldsize            html field size
 * @param string  $onChangeClause       onchange clause for fields
 * @param integer $tabindex             tab index
 * @param integer $tabindex_for_value   offset for the values tabindex
 * @param integer $idindex              id index
 * @param string  $data_type            the html5 data-* attribute type
 * @param boolean $readOnly             is column read only or not
 *
 * @return string                       an html snippet
 */
function PMA_getHTMLinput($column, $column_name_appendix, $special_chars, $fieldsize, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data_type, $readOnly)
{
    $input_type = 'text';
    // do not use the 'date' or 'time' types here; they have no effect on some
    // browsers and create side effects (see bug #4218)
    $the_class = 'textfield';
    // verify True_Type which does not contain the parentheses and length
    if ($readOnly) {
        //NOOP. Disable date/timepicker
    } else {
        if ($column['True_Type'] === 'date') {
            $the_class .= ' datefield';
        } else {
            if ($column['True_Type'] === 'time') {
                $the_class .= ' timefield';
            } else {
                if ($column['True_Type'] === 'datetime' || $column['True_Type'] === 'timestamp') {
                    $the_class .= ' datetimefield';
                }
            }
        }
    }
    $input_min_max = false;
    if (in_array($column['True_Type'], $GLOBALS['PMA_Types']->getIntegerTypes())) {
        $extracted_columnspec = PMA\libraries\Util::extractColumnSpec($column['Type']);
        $is_unsigned = $extracted_columnspec['unsigned'];
        $min_max_values = $GLOBALS['PMA_Types']->getIntegerRange($column['True_Type'], !$is_unsigned);
        $input_min_max = 'min="' . $min_max_values[0] . '" ' . 'max="' . $min_max_values[1] . '"';
        $data_type = 'INT';
    }
    return '<input type="' . $input_type . '"' . ' name="fields' . $column_name_appendix . '"' . ' value="' . $special_chars . '" size="' . $fieldsize . '"' . (isset($column['is_char']) && $column['is_char'] ? ' data-maxlength="' . $fieldsize . '"' : '') . ($readOnly ? ' readonly="readonly"' : '') . ($input_min_max !== false ? ' ' . $input_min_max : '') . ' data-type="' . $data_type . '"' . ($input_type === 'time' ? ' step="1"' : '') . ' class="' . $the_class . '" ' . $onChangeClause . ' tabindex="' . ($tabindex + $tabindex_for_value) . '"' . ' id="field_' . $idindex . '_3" />';
}
/**
 * Get HTML select option for upload
 *
 * @param string $vkey   [multi_edit]['row_id']
 * @param array  $column description of column in given table
 *
 * @return string|void an html snippet
 */
function PMA_getSelectOptionForUpload($vkey, $column)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getSelectOptionForUpload") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 1227")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getSelectOptionForUpload:1227@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Retrieve the maximum upload file size
 *
 * @param array   $column                description of column in given table
 * @param integer $biggest_max_file_size biggest max file size for uploading
 *
 * @return array an html snippet and $biggest_max_file_size
 */
function PMA_getMaxUploadSize($column, $biggest_max_file_size)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getMaxUploadSize") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 1263")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getMaxUploadSize:1263@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get HTML for the Value column of other datatypes
 * (here, "column" is used in the sense of HTML column in HTML table)
 *
 * @param array   $column                description of column in given table
 * @param string  $default_char_editing  default char editing mode which is stored
 *                                       in the config.inc.php script
 * @param string  $backup_field          hidden input field
 * @param string  $column_name_appendix  the name attribute
 * @param string  $onChangeClause        onchange clause for fields
 * @param integer $tabindex              tab index
 * @param string  $special_chars         special characters
 * @param integer $tabindex_for_value    offset for the values tabindex
 * @param integer $idindex               id index
 * @param string  $text_dir              text direction
 * @param string  $special_chars_encoded replaced char if the string starts
 *                                       with a \r\n pair (0x0d0a) add an extra \n
 * @param string  $data                  data to edit
 * @param array   $extracted_columnspec  associative array containing type,
 *                                       spec_in_brackets and possibly
 *                                       enum_set_values (another array)
 * @param boolean $readOnly              is column read only or not
 *
 * @return string an html snippet
 */
function PMA_getValueColumnForOtherDatatypes($column, $default_char_editing, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $special_chars, $tabindex_for_value, $idindex, $text_dir, $special_chars_encoded, $data, $extracted_columnspec, $readOnly)
{
    // HTML5 data-* attribute data-type
    $data_type = $GLOBALS['PMA_Types']->getTypeClass($column['True_Type']);
    $fieldsize = PMA_getColumnSize($column, $extracted_columnspec);
    $html_output = $backup_field . "\n";
    if ($column['is_char'] && ($GLOBALS['cfg']['CharEditing'] == 'textarea' || mb_strpos($data, "\n") !== false)) {
        $html_output .= "\n";
        $GLOBALS['cfg']['CharEditing'] = $default_char_editing;
        $html_output .= PMA_getTextarea($column, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $text_dir, $special_chars_encoded, $data_type, $readOnly);
    } else {
        $html_output .= PMA_getHTMLinput($column, $column_name_appendix, $special_chars, $fieldsize, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data_type, $readOnly);
        $virtual = array('VIRTUAL', 'PERSISTENT', 'VIRTUAL GENERATED', 'STORED GENERATED');
        if (in_array($column['Extra'], $virtual)) {
            $html_output .= '<input type="hidden" name="virtual' . $column_name_appendix . '" value="1" />';
        }
        if ($column['Extra'] == 'auto_increment') {
            $html_output .= '<input type="hidden" name="auto_increment' . $column_name_appendix . '" value="1" />';
        }
        if (substr($column['pma_type'], 0, 9) == 'timestamp') {
            $html_output .= '<input type="hidden" name="fields_type' . $column_name_appendix . '" value="timestamp" />';
        }
        if (substr($column['pma_type'], 0, 8) == 'datetime') {
            $html_output .= '<input type="hidden" name="fields_type' . $column_name_appendix . '" value="datetime" />';
        }
        if ($column['True_Type'] == 'bit') {
            $html_output .= '<input type="hidden" name="fields_type' . $column_name_appendix . '" value="bit" />';
        }
        if ($column['pma_type'] == 'date' || $column['pma_type'] == 'datetime' || substr($column['pma_type'], 0, 9) == 'timestamp') {
            // the _3 suffix points to the date field
            // the _2 suffix points to the corresponding NULL checkbox
            // in dateFormat, 'yy' means the year with 4 digits
        }
    }
    return $html_output;
}
/**
 * Get the field size
 *
 * @param array $column               description of column in given table
 * @param array $extracted_columnspec associative array containing type,
 *                                    spec_in_brackets and possibly enum_set_values
 *                                    (another array)
 *
 * @return integer      field size
 */
function PMA_getColumnSize($column, $extracted_columnspec)
{
    if ($column['is_char']) {
        $fieldsize = $extracted_columnspec['spec_in_brackets'];
        if ($fieldsize > $GLOBALS['cfg']['MaxSizeForInputField']) {
            /**
             * This case happens for CHAR or VARCHAR columns which have
             * a size larger than the maximum size for input field.
             */
            $GLOBALS['cfg']['CharEditing'] = 'textarea';
        }
    } else {
        /**
         * This case happens for example for INT or DATE columns;
         * in these situations, the value returned in $column['len']
         * seems appropriate.
         */
        $fieldsize = $column['len'];
    }
    return min(max($fieldsize, $GLOBALS['cfg']['MinSizeForInputField']), $GLOBALS['cfg']['MaxSizeForInputField']);
}
/**
 * Get HTML for gis data types
 *
 * @return string an html snippet
 */
function PMA_getHTMLforGisDataTypes()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHTMLforGisDataTypes") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 1417")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHTMLforGisDataTypes:1417@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * get html for continue insertion form
 *
 * @param string $table              name of the table
 * @param string $db                 name of the database
 * @param array  $where_clause_array array of where clauses
 * @param string $err_url            error url
 *
 * @return string                   an html snippet
 */
function PMA_getContinueInsertionForm($table, $db, $where_clause_array, $err_url)
{
    $html_output = '<form id="continueForm" method="post"' . ' action="tbl_replace.php" name="continueForm">' . URL::getHiddenInputs($db, $table) . '<input type="hidden" name="goto"' . ' value="' . htmlspecialchars($GLOBALS['goto']) . '" />' . '<input type="hidden" name="err_url"' . ' value="' . htmlspecialchars($err_url) . '" />' . '<input type="hidden" name="sql_query"' . ' value="' . htmlspecialchars($_REQUEST['sql_query']) . '" />';
    if (isset($_REQUEST['where_clause'])) {
        foreach ($where_clause_array as $key_id => $where_clause) {
            $html_output .= '<input type="hidden"' . ' name="where_clause[' . $key_id . ']"' . ' value="' . htmlspecialchars(trim($where_clause)) . '" />' . "\n";
        }
    }
    $tmp = '<select name="insert_rows" id="insert_rows">' . "\n";
    $option_values = array(1, 2, 5, 10, 15, 20, 30, 40);
    foreach ($option_values as $value) {
        $tmp .= '<option value="' . $value . '"';
        if ($value == $GLOBALS['cfg']['InsertRows']) {
            $tmp .= ' selected="selected"';
        }
        $tmp .= '>' . $value . '</option>' . "\n";
    }
    $tmp .= '</select>' . "\n";
    $html_output .= "\n" . sprintf(__('Continue insertion with %s rows'), $tmp);
    unset($tmp);
    $html_output .= '</form>' . "\n";
    return $html_output;
}
/**
 * Get action panel
 *
 * @param array   $where_clause       where clause
 * @param string  $after_insert       insert mode, e.g. new_insert, same_insert
 * @param integer $tabindex           tab index
 * @param integer $tabindex_for_value offset for the values tabindex
 * @param boolean $found_unique_key   boolean variable for unique key
 *
 * @return string an html snippet
 */
function PMA_getActionsPanel($where_clause, $after_insert, $tabindex, $tabindex_for_value, $found_unique_key)
{
    $html_output = '<fieldset id="actions_panel">' . '<table cellpadding="5" cellspacing="0">' . '<tr>' . '<td class="nowrap vmiddle">' . PMA_getSubmitTypeDropDown($where_clause, $tabindex, $tabindex_for_value) . "\n";
    $html_output .= '</td>' . '<td class="vmiddle">' . '&nbsp;&nbsp;&nbsp;<strong>' . __('and then') . '</strong>&nbsp;&nbsp;&nbsp;' . '</td>' . '<td class="nowrap vmiddle">' . PMA_getAfterInsertDropDown($where_clause, $after_insert, $found_unique_key) . '</td>' . '</tr>';
    $html_output .= '<tr>' . PMA_getSubmitAndResetButtonForActionsPanel($tabindex, $tabindex_for_value) . '</tr>' . '</table>' . '</fieldset>';
    return $html_output;
}
/**
 * Get a HTML drop down for submit types
 *
 * @param array   $where_clause       where clause
 * @param integer $tabindex           tab index
 * @param integer $tabindex_for_value offset for the values tabindex
 *
 * @return string                       an html snippet
 */
function PMA_getSubmitTypeDropDown($where_clause, $tabindex, $tabindex_for_value)
{
    $html_output = '<select name="submit_type" class="control_at_footer" tabindex="' . ($tabindex + $tabindex_for_value + 1) . '">';
    if (isset($where_clause)) {
        $html_output .= '<option value="save">' . __('Save') . '</option>';
    }
    $html_output .= '<option value="insert">' . __('Insert as new row') . '</option>' . '<option value="insertignore">' . __('Insert as new row and ignore errors') . '</option>' . '<option value="showinsert">' . __('Show insert query') . '</option>' . '</select>';
    return $html_output;
}
/**
 * Get HTML drop down for after insert
 *
 * @param array   $where_clause     where clause
 * @param string  $after_insert     insert mode, e.g. new_insert, same_insert
 * @param boolean $found_unique_key boolean variable for unique key
 *
 * @return string                   an html snippet
 */
function PMA_getAfterInsertDropDown($where_clause, $after_insert, $found_unique_key)
{
    $html_output = '<select name="after_insert" class="control_at_footer">' . '<option value="back" ' . ($after_insert == 'back' ? 'selected="selected"' : '') . '>' . __('Go back to previous page') . '</option>' . '<option value="new_insert" ' . ($after_insert == 'new_insert' ? 'selected="selected"' : '') . '>' . __('Insert another new row') . '</option>';
    if (isset($where_clause)) {
        $html_output .= '<option value="same_insert" ' . ($after_insert == 'same_insert' ? 'selected="selected"' : '') . '>' . __('Go back to this page') . '</option>';
        // If we have just numeric primary key, we can also edit next
        // in 2.8.2, we were looking for `field_name` = numeric_value
        //if (preg_match('@^[\s]*`[^`]*` = [0-9]+@', $where_clause)) {
        // in 2.9.0, we are looking for `table_name`.`field_name` = numeric_value
        $is_numeric = false;
        if (!is_array($where_clause)) {
            $where_clause = array($where_clause);
        }
        for ($i = 0, $nb = count($where_clause); $i < $nb; $i++) {
            // preg_match() returns 1 if there is a match
            $is_numeric = preg_match('@^[\\s]*`[^`]*`[\\.]`[^`]*` = [0-9]+@', $where_clause[$i]) == 1;
            if ($is_numeric === true) {
                break;
            }
        }
        if ($found_unique_key && $is_numeric) {
            $html_output .= '<option value="edit_next" ' . ($after_insert == 'edit_next' ? 'selected="selected"' : '') . '>' . __('Edit next row') . '</option>';
        }
    }
    $html_output .= '</select>';
    return $html_output;
}
/**
 * get Submit button and Reset button for action panel
 *
 * @param integer $tabindex           tab index
 * @param integer $tabindex_for_value offset for the values tabindex
 *
 * @return string an html snippet
 */
function PMA_getSubmitAndResetButtonForActionsPanel($tabindex, $tabindex_for_value)
{
    return '<td>' . PMA\libraries\Util::showHint(__('Use TAB key to move from value to value,' . ' or CTRL+arrows to move anywhere.')) . '</td>' . '<td colspan="3" class="right vmiddle">' . '<input type="submit" class="control_at_footer" value="' . __('Go') . '"' . ' tabindex="' . ($tabindex + $tabindex_for_value + 6) . '" id="buttonYes" />' . '<input type="button" class="preview_sql" value="' . __('Preview SQL') . '"' . ' tabindex="' . ($tabindex + $tabindex_for_value + 7) . '" />' . '<input type="reset" class="control_at_footer" value="' . __('Reset') . '"' . ' tabindex="' . ($tabindex + $tabindex_for_value + 8) . '" />' . '</td>';
}
/**
 * Get table head and table foot for insert row table
 *
 * @param array $url_params url parameters
 *
 * @return string           an html snippet
 */
function PMA_getHeadAndFootOfInsertRowTable($url_params)
{
    $html_output = '<table class="insertRowTable topmargin">' . '<thead>' . '<tr>' . '<th>' . __('Column') . '</th>';
    if ($GLOBALS['cfg']['ShowFieldTypesInDataEditView']) {
        $html_output .= PMA_showTypeOrFunction('type', $url_params, true);
    }
    if ($GLOBALS['cfg']['ShowFunctionFields']) {
        $html_output .= PMA_showTypeOrFunction('function', $url_params, true);
    }
    $html_output .= '<th>' . __('Null') . '</th>' . '<th>' . __('Value') . '</th>' . '</tr>' . '</thead>' . ' <tfoot>' . '<tr>' . '<th colspan="5" class="tblFooters right">' . '<input type="submit" value="' . __('Go') . '" />' . '</th>' . '</tr>' . '</tfoot>';
    return $html_output;
}
/**
 * Prepares the field value and retrieve special chars, backup field and data array
 *
 * @param array   $current_row          a row of the table
 * @param array   $column               description of column in given table
 * @param array   $extracted_columnspec associative array containing type,
 *                                      spec_in_brackets and possibly
 *                                      enum_set_values (another array)
 * @param boolean $real_null_value      whether column value null or not null
 * @param array   $gis_data_types       list of GIS data types
 * @param string  $column_name_appendix string to append to column name in input
 * @param bool    $as_is                use the data as is, used in repopulating
 *
 * @return array $real_null_value, $data, $special_chars, $backup_field,
 *               $special_chars_encoded
 */
function PMA_getSpecialCharsAndBackupFieldForExistingRow($current_row, $column, $extracted_columnspec, $real_null_value, $gis_data_types, $column_name_appendix, $as_is)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getSpecialCharsAndBackupFieldForExistingRow") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 1679")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getSpecialCharsAndBackupFieldForExistingRow:1679@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * display default values
 *
 * @param array   $column          description of column in given table
 * @param boolean $real_null_value whether column value null or not null
 *
 * @return array $real_null_value, $data, $special_chars,
 *               $backup_field, $special_chars_encoded
 */
function PMA_getSpecialCharsAndBackupFieldForInsertingMode($column, $real_null_value)
{
    if (!isset($column['Default'])) {
        $column['Default'] = '';
        $real_null_value = true;
        $data = '';
    } else {
        $data = $column['Default'];
    }
    $trueType = $column['True_Type'];
    if ($trueType == 'bit') {
        $special_chars = PMA\libraries\Util::convertBitDefaultValue($column['Default']);
    } elseif (substr($trueType, 0, 9) == 'timestamp' || $trueType == 'datetime' || $trueType == 'time') {
        $special_chars = PMA\libraries\Util::addMicroseconds($column['Default']);
    } elseif ($trueType == 'binary' || $trueType == 'varbinary') {
        $special_chars = bin2hex($column['Default']);
    } else {
        $special_chars = htmlspecialchars($column['Default']);
    }
    $backup_field = '';
    $special_chars_encoded = PMA\libraries\Util::duplicateFirstNewline($special_chars);
    return array($real_null_value, $data, $special_chars, $backup_field, $special_chars_encoded);
}
/**
 * Prepares the update/insert of a row
 *
 * @return array     $loop_array, $using_key, $is_insert, $is_insertignore
 */
function PMA_getParamsForUpdateOrInsert()
{
    if (isset($_REQUEST['where_clause'])) {
        // we were editing something => use the WHERE clause
        $loop_array = is_array($_REQUEST['where_clause']) ? $_REQUEST['where_clause'] : array($_REQUEST['where_clause']);
        $using_key = true;
        $is_insert = isset($_REQUEST['submit_type']) && ($_REQUEST['submit_type'] == 'insert' || $_REQUEST['submit_type'] == 'showinsert' || $_REQUEST['submit_type'] == 'insertignore');
    } else {
        // new row => use indexes
        $loop_array = array();
        if (!empty($_REQUEST['fields'])) {
            foreach ($_REQUEST['fields']['multi_edit'] as $key => $dummy) {
                $loop_array[] = $key;
            }
        }
        $using_key = false;
        $is_insert = true;
    }
    $is_insertignore = isset($_REQUEST['submit_type']) && $_REQUEST['submit_type'] == 'insertignore';
    return array($loop_array, $using_key, $is_insert, $is_insertignore);
}
/**
 * Check wether insert row mode and if so include tbl_changen script and set
 * global variables.
 *
 * @return void
 */
function PMA_isInsertRow()
{
    if (isset($_REQUEST['insert_rows']) && is_numeric($_REQUEST['insert_rows']) && $_REQUEST['insert_rows'] != $GLOBALS['cfg']['InsertRows']) {
        $GLOBALS['cfg']['InsertRows'] = $_REQUEST['insert_rows'];
        $response = Response::getInstance();
        $header = $response->getHeader();
        $scripts = $header->getScripts();
        $scripts->addFile('tbl_change.js');
        if (!defined('TESTSUITE')) {
            include 'tbl_change.php';
            exit;
        }
    }
}
/**
 * set $_SESSION for edit_next
 *
 * @param string $one_where_clause one where clause from where clauses array
 *
 * @return void
 */
function PMA_setSessionForEditNext($one_where_clause)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_setSessionForEditNext") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 1874")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_setSessionForEditNext:1874@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * set $goto_include variable for different cases and retrieve like,
 * if $GLOBALS['goto'] empty, if $goto_include previously not defined
 * and new_insert, same_insert, edit_next
 *
 * @param string $goto_include store some script for include, otherwise it is
 *                             boolean false
 *
 * @return string               $goto_include
 */
function PMA_getGotoInclude($goto_include)
{
    $valid_options = array('new_insert', 'same_insert', 'edit_next');
    if (isset($_REQUEST['after_insert']) && in_array($_REQUEST['after_insert'], $valid_options)) {
        $goto_include = 'tbl_change.php';
    } elseif (!empty($GLOBALS['goto'])) {
        if (!preg_match('@^[a-z_]+\\.php$@', $GLOBALS['goto'])) {
            // this should NOT happen
            //$GLOBALS['goto'] = false;
            $goto_include = false;
        } else {
            $goto_include = $GLOBALS['goto'];
        }
        if ($GLOBALS['goto'] == 'db_sql.php' && strlen($GLOBALS['table']) > 0) {
            $GLOBALS['table'] = '';
        }
    }
    if (!$goto_include) {
        if (strlen($GLOBALS['table']) === 0) {
            $goto_include = 'db_sql.php';
        } else {
            $goto_include = 'tbl_sql.php';
        }
    }
    return $goto_include;
}
/**
 * Defines the url to return in case of failure of the query
 *
 * @param array $url_params url parameters
 *
 * @return string           error url for query failure
 */
function PMA_getErrorUrl($url_params)
{
    if (isset($_REQUEST['err_url'])) {
        return $_REQUEST['err_url'];
    } else {
        return 'tbl_change.php' . URL::getCommon($url_params);
    }
}
/**
 * Builds the sql query
 *
 * @param boolean $is_insertignore $_REQUEST['submit_type'] == 'insertignore'
 * @param array   $query_fields    column names array
 * @param array   $value_sets      array of query values
 *
 * @return array of query
 */
function PMA_buildSqlQuery($is_insertignore, $query_fields, $value_sets)
{
    if ($is_insertignore) {
        $insert_command = 'INSERT IGNORE ';
    } else {
        $insert_command = 'INSERT ';
    }
    $query = array($insert_command . 'INTO ' . PMA\libraries\Util::backquote($GLOBALS['table']) . ' (' . implode(', ', $query_fields) . ') VALUES (' . implode('), (', $value_sets) . ')');
    unset($insert_command, $query_fields);
    return $query;
}
/**
 * Executes the sql query and get the result, then move back to the calling page
 *
 * @param array $url_params url parameters array
 * @param array $query      built query from PMA_buildSqlQuery()
 *
 * @return array            $url_params, $total_affected_rows, $last_messages
 *                          $warning_messages, $error_messages, $return_to_sql_query
 */
function PMA_executeSqlQuery($url_params, $query)
{
    $return_to_sql_query = '';
    if (!empty($GLOBALS['sql_query'])) {
        $url_params['sql_query'] = $GLOBALS['sql_query'];
        $return_to_sql_query = $GLOBALS['sql_query'];
    }
    $GLOBALS['sql_query'] = implode('; ', $query) . ';';
    // to ensure that the query is displayed in case of
    // "insert as new row" and then "insert another new row"
    $GLOBALS['display_query'] = $GLOBALS['sql_query'];
    $total_affected_rows = 0;
    $last_messages = array();
    $warning_messages = array();
    $error_messages = array();
    foreach ($query as $single_query) {
        if ($_REQUEST['submit_type'] == 'showinsert') {
            $last_messages[] = Message::notice(__('Showing SQL query'));
            continue;
        }
        if ($GLOBALS['cfg']['IgnoreMultiSubmitErrors']) {
            $result = $GLOBALS['dbi']->tryQuery($single_query);
        } else {
            $result = $GLOBALS['dbi']->query($single_query);
        }
        if (!$result) {
            $error_messages[] = $GLOBALS['dbi']->getError();
        } else {
            // The next line contains a real assignment, it's not a typo
            if ($tmp = @$GLOBALS['dbi']->affectedRows()) {
                $total_affected_rows += $tmp;
            }
            unset($tmp);
            $insert_id = $GLOBALS['dbi']->insertId();
            if ($insert_id != 0) {
                // insert_id is id of FIRST record inserted in one insert, so if we
                // inserted multiple rows, we had to increment this
                if ($total_affected_rows > 0) {
                    $insert_id = $insert_id + $total_affected_rows - 1;
                }
                $last_message = Message::notice(__('Inserted row id: %1$d'));
                $last_message->addParam($insert_id);
                $last_messages[] = $last_message;
            }
            $GLOBALS['dbi']->freeResult($result);
        }
        $warning_messages = PMA_getWarningMessages();
    }
    return array($url_params, $total_affected_rows, $last_messages, $warning_messages, $error_messages, $return_to_sql_query);
}
/**
 * get the warning messages array
 *
 * @return array  $warning_essages
 */
function PMA_getWarningMessages()
{
    $warning_essages = array();
    foreach ($GLOBALS['dbi']->getWarnings() as $warning) {
        $warning_essages[] = Message::sanitize($warning['Level'] . ': #' . $warning['Code'] . ' ' . $warning['Message']);
    }
    return $warning_essages;
}
/**
 * Column to display from the foreign table?
 *
 * @param string $where_comparison string that contain relation field value
 * @param array  $map              all Relations to foreign tables for a given
 *                                 table or optionally a given column in a table
 * @param string $relation_field   relation field
 *
 * @return string $dispval display value from the foreign table
 */
function PMA_getDisplayValueForForeignTableColumn($where_comparison, $map, $relation_field)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDisplayValueForForeignTableColumn") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 2080")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDisplayValueForForeignTableColumn:2080@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Display option in the cell according to user choices
 *
 * @param array  $map                  all Relations to foreign tables for a given
 *                                     table or optionally a given column in a table
 * @param string $relation_field       relation field
 * @param string $where_comparison     string that contain relation field value
 * @param string $dispval              display value from the foreign table
 * @param string $relation_field_value relation field value
 *
 * @return string $output HTML <a> tag
 */
function PMA_getLinkForRelationalDisplayField($map, $relation_field, $where_comparison, $dispval, $relation_field_value)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getLinkForRelationalDisplayField") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 2123")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getLinkForRelationalDisplayField:2123@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Transform edited values
 *
 * @param string $db             db name
 * @param string $table          table name
 * @param array  $transformation mimetypes for all columns of a table
 *                               [field_name][field_key]
 * @param array  &$edited_values transform columns list and new values
 * @param string $file           file containing the transformation plugin
 * @param string $column_name    column name
 * @param array  $extra_data     extra data array
 * @param string $type           the type of transformation
 *
 * @return array $extra_data
 */
function PMA_transformEditedValues($db, $table, $transformation, &$edited_values, $file, $column_name, $extra_data, $type)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_transformEditedValues") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 2176")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_transformEditedValues:2176@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Get current value in multi edit mode
 *
 * @param array  $multi_edit_funcs        multiple edit functions array
 * @param array  $multi_edit_salt         multiple edit array with encryption salt
 * @param array  $gis_from_text_functions array that contains gis from text functions
 * @param string $current_value           current value in the column
 * @param array  $gis_from_wkb_functions  initially $val is $multi_edit_columns[$key]
 * @param array  $func_optional_param     array('RAND','UNIX_TIMESTAMP')
 * @param array  $func_no_param           array of set of string
 * @param string $key                     an md5 of the column name
 *
 * @return array $cur_value
 */
function PMA_getCurrentValueAsAnArrayForMultipleEdit($multi_edit_funcs, $multi_edit_salt, $gis_from_text_functions, $current_value, $gis_from_wkb_functions, $func_optional_param, $func_no_param, $key)
{
    if (empty($multi_edit_funcs[$key])) {
        return $current_value;
    } elseif ('UUID' === $multi_edit_funcs[$key]) {
        /* This way user will know what UUID new row has */
        $uuid = $GLOBALS['dbi']->fetchValue('SELECT UUID()');
        return "'" . $uuid . "'";
    } elseif (in_array($multi_edit_funcs[$key], $gis_from_text_functions) && substr($current_value, 0, 3) == "'''" || in_array($multi_edit_funcs[$key], $gis_from_wkb_functions)) {
        // Remove enclosing apostrophes
        $current_value = mb_substr($current_value, 1, -1);
        // Remove escaping apostrophes
        $current_value = str_replace("''", "'", $current_value);
        return $multi_edit_funcs[$key] . '(' . $current_value . ')';
    } elseif (!in_array($multi_edit_funcs[$key], $func_no_param) || $current_value != "''" && in_array($multi_edit_funcs[$key], $func_optional_param)) {
        if (isset($multi_edit_salt[$key]) && ($multi_edit_funcs[$key] == "AES_ENCRYPT" || $multi_edit_funcs[$key] == "AES_DECRYPT") || !empty($multi_edit_salt[$key]) && ($multi_edit_funcs[$key] == "DES_ENCRYPT" || $multi_edit_funcs[$key] == "DES_DECRYPT" || $multi_edit_funcs[$key] == "ENCRYPT")) {
            return $multi_edit_funcs[$key] . '(' . $current_value . ",'" . $GLOBALS['dbi']->escapeString($multi_edit_salt[$key]) . "')";
        } else {
            return $multi_edit_funcs[$key] . '(' . $current_value . ')';
        }
    } else {
        return $multi_edit_funcs[$key] . '()';
    }
}
/**
 * Get query values array and query fields array for insert and update in multi edit
 *
 * @param array   $multi_edit_columns_name      multiple edit columns name array
 * @param array   $multi_edit_columns_null      multiple edit columns null array
 * @param string  $current_value                current value in the column in loop
 * @param array   $multi_edit_columns_prev      multiple edit previous columns array
 * @param array   $multi_edit_funcs             multiple edit functions array
 * @param boolean $is_insert                    boolean value whether insert or not
 * @param array   $query_values                 SET part of the sql query
 * @param array   $query_fields                 array of query fields
 * @param string  $current_value_as_an_array    current value in the column
 *                                              as an array
 * @param array   $value_sets                   array of valu sets
 * @param string  $key                          an md5 of the column name
 * @param array   $multi_edit_columns_null_prev array of multiple edit columns
 *                                              null previous
 *
 * @return array ($query_values, $query_fields)
 */
function PMA_getQueryValuesForInsertAndUpdateInMultipleEdit($multi_edit_columns_name, $multi_edit_columns_null, $current_value, $multi_edit_columns_prev, $multi_edit_funcs, $is_insert, $query_values, $query_fields, $current_value_as_an_array, $value_sets, $key, $multi_edit_columns_null_prev)
{
    //  i n s e r t
    if ($is_insert) {
        // no need to add column into the valuelist
        if (strlen($current_value_as_an_array) > 0) {
            $query_values[] = $current_value_as_an_array;
            // first inserted row so prepare the list of fields
            if (empty($value_sets)) {
                $query_fields[] = PMA\libraries\Util::backquote($multi_edit_columns_name[$key]);
            }
        }
    } elseif (!empty($multi_edit_columns_null_prev[$key]) && !isset($multi_edit_columns_null[$key])) {
        //  u p d a t e
        // field had the null checkbox before the update
        // field no longer has the null checkbox
        $query_values[] = PMA\libraries\Util::backquote($multi_edit_columns_name[$key]) . ' = ' . $current_value_as_an_array;
    } elseif (empty($multi_edit_funcs[$key]) && isset($multi_edit_columns_prev[$key]) && ("'" . $GLOBALS['dbi']->escapeString($multi_edit_columns_prev[$key]) . "'" === $current_value || '0x' . $multi_edit_columns_prev[$key] === $current_value)) {
        // No change for this column and no MySQL function is used -> next column
    } elseif (!empty($current_value)) {
        // avoid setting a field to NULL when it's already NULL
        // (field had the null checkbox before the update
        //  field still has the null checkbox)
        if (empty($multi_edit_columns_null_prev[$key]) || empty($multi_edit_columns_null[$key])) {
            $query_values[] = PMA\libraries\Util::backquote($multi_edit_columns_name[$key]) . ' = ' . $current_value_as_an_array;
        }
    }
    return array($query_values, $query_fields);
}
/**
 * Get the current column value in the form for different data types
 *
 * @param string|false $possibly_uploaded_val        uploaded file content
 * @param string       $key                          an md5 of the column name
 * @param array        $multi_edit_columns_type      array of multi edit column types
 * @param string       $current_value                current column value in the form
 * @param array        $multi_edit_auto_increment    multi edit auto increment
 * @param integer      $rownumber                    index of where clause array
 * @param array        $multi_edit_columns_name      multi edit column names array
 * @param array        $multi_edit_columns_null      multi edit columns null array
 * @param array        $multi_edit_columns_null_prev multi edit columns previous null
 * @param boolean      $is_insert                    whether insert or not
 * @param boolean      $using_key                    whether editing or new row
 * @param string       $where_clause                 where clause
 * @param string       $table                        table name
 * @param array        $multi_edit_funcs             multiple edit functions array
 *
 * @return string $current_value  current column value in the form
 */
function PMA_getCurrentValueForDifferentTypes($possibly_uploaded_val, $key, $multi_edit_columns_type, $current_value, $multi_edit_auto_increment, $rownumber, $multi_edit_columns_name, $multi_edit_columns_null, $multi_edit_columns_null_prev, $is_insert, $using_key, $where_clause, $table, $multi_edit_funcs)
{
    // Fetch the current values of a row to use in case we have a protected field
    if ($is_insert && $using_key && isset($multi_edit_columns_type) && is_array($multi_edit_columns_type) && !empty($where_clause)) {
        $protected_row = $GLOBALS['dbi']->fetchSingleRow('SELECT * FROM ' . PMA\libraries\Util::backquote($table) . ' WHERE ' . $where_clause . ';');
    }
    if (false !== $possibly_uploaded_val) {
        $current_value = $possibly_uploaded_val;
    } else {
        if (!empty($multi_edit_funcs[$key])) {
            $current_value = "'" . $GLOBALS['dbi']->escapeString($current_value) . "'";
        } else {
            // c o l u m n    v a l u e    i n    t h e    f o r m
            if (isset($multi_edit_columns_type[$key])) {
                $type = $multi_edit_columns_type[$key];
            } else {
                $type = '';
            }
            if ($type != 'protected' && $type != 'set' && strlen($current_value) === 0) {
                // best way to avoid problems in strict mode
                // (works also in non-strict mode)
                if (isset($multi_edit_auto_increment) && isset($multi_edit_auto_increment[$key])) {
                    $current_value = 'NULL';
                } else {
                    $current_value = "''";
                }
            } elseif ($type == 'set') {
                if (!empty($_REQUEST['fields']['multi_edit'][$rownumber][$key])) {
                    $current_value = implode(',', $_REQUEST['fields']['multi_edit'][$rownumber][$key]);
                    $current_value = "'" . $GLOBALS['dbi']->escapeString($current_value) . "'";
                } else {
                    $current_value = "''";
                }
            } elseif ($type == 'protected') {
                // here we are in protected mode (asked in the config)
                // so tbl_change has put this special value in the
                // columns array, so we do not change the column value
                // but we can still handle column upload
                // when in UPDATE mode, do not alter field's contents. When in INSERT
                // mode, insert empty field because no values were submitted.
                // If protected blobs where set, insert original fields content.
                if (!empty($protected_row[$multi_edit_columns_name[$key]])) {
                    $current_value = '0x' . bin2hex($protected_row[$multi_edit_columns_name[$key]]);
                } else {
                    $current_value = '';
                }
            } elseif ($type === 'hex') {
                $current_value = '0x' . $current_value;
            } elseif ($type == 'bit') {
                $current_value = preg_replace('/[^01]/', '0', $current_value);
                $current_value = "b'" . $GLOBALS['dbi']->escapeString($current_value) . "'";
            } elseif (!($type == 'datetime' || $type == 'timestamp') || $current_value != 'CURRENT_TIMESTAMP') {
                $current_value = "'" . $GLOBALS['dbi']->escapeString($current_value) . "'";
            }
            // Was the Null checkbox checked for this field?
            // (if there is a value, we ignore the Null checkbox: this could
            // be possible if Javascript is disabled in the browser)
            if (!empty($multi_edit_columns_null[$key]) && ($current_value == "''" || $current_value == '')) {
                $current_value = 'NULL';
            }
            // The Null checkbox was unchecked for this field
            if (empty($current_value) && !empty($multi_edit_columns_null_prev[$key]) && !isset($multi_edit_columns_null[$key])) {
                $current_value = "''";
            }
        }
    }
    // end else (column value in the form)
    return $current_value;
}
/**
 * Check whether inline edited value can be truncated or not,
 * and add additional parameters for extra_data array  if needed
 *
 * @param string $db          Database name
 * @param string $table       Table name
 * @param string $column_name Column name
 * @param array  &$extra_data Extra data for ajax response
 *
 * @return void
 */
function PMA_verifyWhetherValueCanBeTruncatedAndAppendExtraData($db, $table, $column_name, &$extra_data)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_verifyWhetherValueCanBeTruncatedAndAppendExtraData") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php at line 2470")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_verifyWhetherValueCanBeTruncatedAndAppendExtraData:2470@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/insert_edit.lib.php');
    die();
}
/**
 * Function to get the columns of a table
 *
 * @param string $db    current db
 * @param string $table current table
 *
 * @return array
 */
function PMA_getTableColumns($db, $table)
{
    $GLOBALS['dbi']->selectDb($db);
    return array_values($GLOBALS['dbi']->getColumns($db, $table, null, true));
}
/**
 * Function to determine Insert/Edit rows
 *
 * @param string $where_clause where clause
 * @param string $db           current database
 * @param string $table        current table
 *
 * @return mixed
 */
function PMA_determineInsertOrEdit($where_clause, $db, $table)
{
    if (isset($_REQUEST['where_clause'])) {
        $where_clause = $_REQUEST['where_clause'];
    }
    if (isset($_SESSION['edit_next'])) {
        $where_clause = $_SESSION['edit_next'];
        unset($_SESSION['edit_next']);
        $after_insert = 'edit_next';
    }
    if (isset($_REQUEST['ShowFunctionFields'])) {
        $GLOBALS['cfg']['ShowFunctionFields'] = $_REQUEST['ShowFunctionFields'];
    }
    if (isset($_REQUEST['ShowFieldTypesInDataEditView'])) {
        $GLOBALS['cfg']['ShowFieldTypesInDataEditView'] = $_REQUEST['ShowFieldTypesInDataEditView'];
    }
    if (isset($_REQUEST['after_insert'])) {
        $after_insert = $_REQUEST['after_insert'];
    }
    if (isset($where_clause)) {
        // we are editing
        $insert_mode = false;
        $where_clause_array = PMA_getWhereClauseArray($where_clause);
        list($where_clauses, $result, $rows, $found_unique_key) = PMA_analyzeWhereClauses($where_clause_array, $table, $db);
    } else {
        // we are inserting
        $insert_mode = true;
        $where_clause = null;
        list($result, $rows) = PMA_loadFirstRow($table, $db);
        $where_clauses = null;
        $where_clause_array = array();
        $found_unique_key = false;
    }
    // Copying a row - fetched data will be inserted as a new row,
    // therefore the where clause is needless.
    if (isset($_REQUEST['default_action']) && $_REQUEST['default_action'] === 'insert') {
        $where_clause = $where_clauses = null;
    }
    return array($insert_mode, $where_clause, $where_clause_array, $where_clauses, $result, $rows, $found_unique_key, isset($after_insert) ? $after_insert : null);
}
/**
 * Function to get comments for the table columns
 *
 * @param string $db    current database
 * @param string $table current table
 *
 * @return array $comments_map comments for columns
 */
function PMA_getCommentsMap($db, $table)
{
    $comments_map = array();
    if ($GLOBALS['cfg']['ShowPropertyComments']) {
        $comments_map = PMA_getComments($db, $table);
    }
    return $comments_map;
}
/**
 * Function to get URL parameters
 *
 * @param string $db    current database
 * @param string $table current table
 *
 * @return array $url_params url parameters
 */
function PMA_getUrlParameters($db, $table)
{
    /**
     * @todo check if we could replace by "db_|tbl_" - please clarify!?
     */
    $url_params = array('db' => $db, 'sql_query' => $_REQUEST['sql_query']);
    if (preg_match('@^tbl_@', $GLOBALS['goto'])) {
        $url_params['table'] = $table;
    }
    return $url_params;
}
/**
 * Function to get html for the gis editor div
 *
 * @return string
 */
function PMA_getHtmlForGisEditor()
{
    return '<div id="gis_editor"></div>' . '<div id="popup_background"></div>' . '<br />';
}
/**
 * Function to get html for the ignore option in insert mode
 *
 * @param int  $row_id  row id
 * @param bool $checked ignore option is checked or not
 *
 * @return string
 */
function PMA_getHtmlForIgnoreOption($row_id, $checked = true)
{
    return '<input type="checkbox"' . ($checked ? ' checked="checked"' : '') . ' name="insert_ignore_' . $row_id . '"' . ' id="insert_ignore_' . $row_id . '" />' . '<label for="insert_ignore_' . $row_id . '">' . __('Ignore') . '</label><br />' . "\n";
}
/**
 * Function to get html for the function option
 *
 * @param array  $column               column
 * @param string $column_name_appendix column name appendix
 *
 * @return String
 */
function PMA_getHtmlForFunctionOption($column, $column_name_appendix)
{
    return '<tr class="noclick">' . '<td ' . 'class="center">' . $column['Field_title'] . '<input type="hidden" name="fields_name' . $column_name_appendix . '" value="' . $column['Field_html'] . '"/>' . '</td>';
}
/**
 * Function to get html for the column type
 *
 * @param array $column column
 *
 * @return string
 */
function PMA_getHtmlForInsertEditColumnType($column)
{
    return '<td class="center' . $column['wrap'] . '">' . '<span class="column_type" dir="ltr">' . $column['pma_type'] . '</span>' . '</td>';
}
/**
 * Function to get html for the insert edit form header
 *
 * @param bool $has_blob_field whether has blob field
 * @param bool $is_upload      whether is upload
 *
 * @return string
 */
function PMA_getHtmlForInsertEditFormHeader($has_blob_field, $is_upload)
{
    $html_output = '<form id="insertForm" class="lock-page ';
    if ($has_blob_field && $is_upload) {
        $html_output .= 'disableAjax';
    }
    $html_output .= '" method="post" action="tbl_replace.php" name="insertForm" ';
    if ($is_upload) {
        $html_output .= ' enctype="multipart/form-data"';
    }
    $html_output .= '>';
    return $html_output;
}
/**
 * Function to get html for each insert/edit column
 *
 * @param array  $table_columns         table columns
 * @param int    $column_number         column index in table_columns
 * @param array  $comments_map          comments map
 * @param bool   $timestamp_seen        whether timestamp seen
 * @param array  $current_result        current result
 * @param string $chg_evt_handler       javascript change event handler
 * @param string $jsvkey                javascript validation key
 * @param string $vkey                  validation key
 * @param bool   $insert_mode           whether insert mode
 * @param array  $current_row           current row
 * @param int    &$o_rows               row offset
 * @param int    &$tabindex             tab index
 * @param int    $columns_cnt           columns count
 * @param bool   $is_upload             whether upload
 * @param int    $tabindex_for_function tab index offset for function
 * @param array  $foreigners            foreigners
 * @param int    $tabindex_for_null     tab index offset for null
 * @param int    $tabindex_for_value    tab index offset for value
 * @param string $table                 table
 * @param string $db                    database
 * @param int    $row_id                row id
 * @param array  $titles                titles
 * @param int    $biggest_max_file_size biggest max file size
 * @param string $default_char_editing  default char editing mode which is stored
 *                                      in the config.inc.php script
 * @param string $text_dir              text direction
 * @param array  $repopulate            the data to be repopulated
 * @param array  $column_mime           the mime information of column
 * @param string $where_clause          the where clause
 *
 * @return string
 */
function PMA_getHtmlForInsertEditFormColumn($table_columns, $column_number, $comments_map, $timestamp_seen, $current_result, $chg_evt_handler, $jsvkey, $vkey, $insert_mode, $current_row, &$o_rows, &$tabindex, $columns_cnt, $is_upload, $tabindex_for_function, $foreigners, $tabindex_for_null, $tabindex_for_value, $table, $db, $row_id, $titles, $biggest_max_file_size, $default_char_editing, $text_dir, $repopulate, $column_mime, $where_clause)
{
    $column = $table_columns[$column_number];
    $readOnly = false;
    if (!PMA_userHasColumnPrivileges($column, $insert_mode)) {
        $readOnly = true;
    }
    if (!isset($column['processed'])) {
        $column = PMA_analyzeTableColumnsArray($column, $comments_map, $timestamp_seen);
    }
    $as_is = false;
    if (!empty($repopulate) && !empty($current_row)) {
        $current_row[$column['Field']] = $repopulate[$column['Field_md5']];
        $as_is = true;
    }
    $extracted_columnspec = PMA\libraries\Util::extractColumnSpec($column['Type']);
    if (-1 === $column['len']) {
        $column['len'] = $GLOBALS['dbi']->fieldLen($current_result, $column_number);
        // length is unknown for geometry fields,
        // make enough space to edit very simple WKTs
        if (-1 === $column['len']) {
            $column['len'] = 30;
        }
    }
    //Call validation when the form submitted...
    $onChangeClause = $chg_evt_handler . "=\"return verificationsAfterFieldChange('" . Sanitize::escapeJsString($column['Field_md5']) . "', '" . Sanitize::escapeJsString($jsvkey) . "','" . $column['pma_type'] . "')\"";
    // Use an MD5 as an array index to avoid having special characters
    // in the name attribute (see bug #1746964 )
    $column_name_appendix = $vkey . '[' . $column['Field_md5'] . ']';
    if ($column['Type'] === 'datetime' && !isset($column['Default']) && !is_null($column['Default']) && $insert_mode) {
        $column['Default'] = date('Y-m-d H:i:s', time());
    }
    $html_output = PMA_getHtmlForFunctionOption($column, $column_name_appendix);
    if ($GLOBALS['cfg']['ShowFieldTypesInDataEditView']) {
        $html_output .= PMA_getHtmlForInsertEditColumnType($column);
    }
    //End if
    // Get a list of GIS data types.
    $gis_data_types = PMA\libraries\Util::getGISDatatypes();
    // Prepares the field value
    $real_null_value = false;
    $special_chars_encoded = '';
    if (!empty($current_row)) {
        // (we are editing)
        list($real_null_value, $special_chars_encoded, $special_chars, $data, $backup_field) = PMA_getSpecialCharsAndBackupFieldForExistingRow($current_row, $column, $extracted_columnspec, $real_null_value, $gis_data_types, $column_name_appendix, $as_is);
    } else {
        // (we are inserting)
        // display default values
        $tmp = $column;
        if (isset($repopulate[$column['Field_md5']])) {
            $tmp['Default'] = $repopulate[$column['Field_md5']];
        }
        list($real_null_value, $data, $special_chars, $backup_field, $special_chars_encoded) = PMA_getSpecialCharsAndBackupFieldForInsertingMode($tmp, $real_null_value);
        unset($tmp);
    }
    $idindex = $o_rows * $columns_cnt + $column_number + 1;
    $tabindex = $idindex;
    // Get a list of data types that are not yet supported.
    $no_support_types = PMA\libraries\Util::unsupportedDatatypes();
    // The function column
    // -------------------
    $foreignData = PMA_getForeignData($foreigners, $column['Field'], false, '', '');
    if ($GLOBALS['cfg']['ShowFunctionFields']) {
        $html_output .= PMA_getFunctionColumn($column, $is_upload, $column_name_appendix, $onChangeClause, $no_support_types, $tabindex_for_function, $tabindex, $idindex, $insert_mode, $readOnly, $foreignData);
    }
    // The null column
    // ---------------
    $html_output .= PMA_getNullColumn($column, $column_name_appendix, $real_null_value, $tabindex, $tabindex_for_null, $idindex, $vkey, $foreigners, $foreignData, $readOnly);
    // The value column (depends on type)
    // ----------------
    // See bug #1667887 for the reason why we don't use the maxlength
    // HTML attribute
    //add data attributes "no of decimals" and "data type"
    $no_decimals = 0;
    $type = current(explode("(", $column['pma_type']));
    if (preg_match('/\\(([^()]+)\\)/', $column['pma_type'], $match)) {
        $match[0] = trim($match[0], '()');
        $no_decimals = $match[0];
    }
    $html_output .= '<td' . ' data-type="' . $type . '"' . ' data-decimals="' . $no_decimals . '">' . "\n";
    // Will be used by js/tbl_change.js to set the default value
    // for the "Continue insertion" feature
    $html_output .= '<span class="default_value hide">' . $special_chars . '</span>';
    // Check input transformation of column
    $transformed_html = '';
    if (!empty($column_mime['input_transformation'])) {
        $file = $column_mime['input_transformation'];
        $include_file = 'libraries/plugins/transformations/' . $file;
        if (is_file($include_file)) {
            include_once $include_file;
            $class_name = PMA_getTransformationClassName($include_file);
            $transformation_plugin = new $class_name();
            $transformation_options = PMA_Transformation_getOptions($column_mime['input_transformation_options']);
            $_url_params = array('db' => $db, 'table' => $table, 'transform_key' => $column['Field'], 'where_clause' => $where_clause);
            $transformation_options['wrapper_link'] = URL::getCommon($_url_params);
            $current_value = '';
            if (isset($current_row[$column['Field']])) {
                $current_value = $current_row[$column['Field']];
            }
            if (method_exists($transformation_plugin, 'getInputHtml')) {
                $transformed_html = $transformation_plugin->getInputHtml($column, $row_id, $column_name_appendix, $transformation_options, $current_value, $text_dir, $tabindex, $tabindex_for_value, $idindex);
            }
            if (method_exists($transformation_plugin, 'getScripts')) {
                $GLOBALS['plugin_scripts'] = array_merge($GLOBALS['plugin_scripts'], $transformation_plugin->getScripts());
            }
        }
    }
    if (!empty($transformed_html)) {
        $html_output .= $transformed_html;
    } else {
        $html_output .= PMA_getValueColumn($column, $backup_field, $column_name_appendix, $onChangeClause, $tabindex, $tabindex_for_value, $idindex, $data, $special_chars, $foreignData, array($table, $db), $row_id, $titles, $text_dir, $special_chars_encoded, $vkey, $is_upload, $biggest_max_file_size, $default_char_editing, $no_support_types, $gis_data_types, $extracted_columnspec, $readOnly);
    }
    return $html_output;
}
/**
 * Function to get html for each insert/edit row
 *
 * @param array  $url_params            url parameters
 * @param array  $table_columns         table columns
 * @param array  $comments_map          comments map
 * @param bool   $timestamp_seen        whether timestamp seen
 * @param array  $current_result        current result
 * @param string $chg_evt_handler       javascript change event handler
 * @param string $jsvkey                javascript validation key
 * @param string $vkey                  validation key
 * @param bool   $insert_mode           whether insert mode
 * @param array  $current_row           current row
 * @param int    &$o_rows               row offset
 * @param int    &$tabindex             tab index
 * @param int    $columns_cnt           columns count
 * @param bool   $is_upload             whether upload
 * @param int    $tabindex_for_function tab index offset for function
 * @param array  $foreigners            foreigners
 * @param int    $tabindex_for_null     tab index offset for null
 * @param int    $tabindex_for_value    tab index offset for value
 * @param string $table                 table
 * @param string $db                    database
 * @param int    $row_id                row id
 * @param array  $titles                titles
 * @param int    $biggest_max_file_size biggest max file size
 * @param string $text_dir              text direction
 * @param array  $repopulate            the data to be repopulated
 * @param array  $where_clause_array    the array of where clauses
 *
 * @return string
 */
function PMA_getHtmlForInsertEditRow($url_params, $table_columns, $comments_map, $timestamp_seen, $current_result, $chg_evt_handler, $jsvkey, $vkey, $insert_mode, $current_row, &$o_rows, &$tabindex, $columns_cnt, $is_upload, $tabindex_for_function, $foreigners, $tabindex_for_null, $tabindex_for_value, $table, $db, $row_id, $titles, $biggest_max_file_size, $text_dir, $repopulate, $where_clause_array)
{
    $html_output = PMA_getHeadAndFootOfInsertRowTable($url_params) . '<tbody>';
    //store the default value for CharEditing
    $default_char_editing = $GLOBALS['cfg']['CharEditing'];
    $mime_map = PMA_getMIME($db, $table);
    $where_clause = '';
    if (isset($where_clause_array[$row_id])) {
        $where_clause = $where_clause_array[$row_id];
    }
    for ($column_number = 0; $column_number < $columns_cnt; $column_number++) {
        $table_column = $table_columns[$column_number];
        $column_mime = array();
        if (isset($mime_map[$table_column['Field']])) {
            $column_mime = $mime_map[$table_column['Field']];
        }
        $html_output .= PMA_getHtmlForInsertEditFormColumn($table_columns, $column_number, $comments_map, $timestamp_seen, $current_result, $chg_evt_handler, $jsvkey, $vkey, $insert_mode, $current_row, $o_rows, $tabindex, $columns_cnt, $is_upload, $tabindex_for_function, $foreigners, $tabindex_for_null, $tabindex_for_value, $table, $db, $row_id, $titles, $biggest_max_file_size, $default_char_editing, $text_dir, $repopulate, $column_mime, $where_clause);
    }
    // end for
    $o_rows++;
    $html_output .= '  </tbody>' . '</table><br />' . '<div class="clearfloat"></div>';
    return $html_output;
}
/**
 * Returns whether the user has necessary insert/update privileges for the column
 *
 * @param array $table_column array of column details
 * @param bool  $insert_mode  whether on insert mode
 *
 * @return boolean whether user has necessary privileges
 */
function PMA_userHasColumnPrivileges($table_column, $insert_mode)
{
    $privileges = $table_column['Privileges'];
    return $insert_mode && strstr($privileges, 'insert') !== false || !$insert_mode && strstr($privileges, 'update') !== false;
}