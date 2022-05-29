<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Library that provides common import functions that are used by import plugins
 *
 * @package PhpMyAdmin-Import
 */
use PMA\libraries\Encoding;
use PMA\libraries\Message;
use PMA\libraries\Response;
use PMA\libraries\Table;
use PMA\libraries\Util;
use PMA\libraries\URL;
if (!defined('PHPMYADMIN')) {
    exit;
}
/**
 * We need to know something about user
 */
require_once './libraries/check_user_privileges.lib.php';
/**
 * Checks whether timeout is getting close
 *
 * @return boolean true if timeout is close
 * @access public
 */
function PMA_checkTimeout()
{
    global $timestamp, $maximum_time, $timeout_passed;
    if ($maximum_time == 0) {
        return false;
    } elseif ($timeout_passed) {
        return true;
        /* 5 in next row might be too much */
    } elseif (time() - $timestamp > $maximum_time - 5) {
        $timeout_passed = true;
        return true;
    } else {
        return false;
    }
}
/**
 * Runs query inside import buffer. This is needed to allow displaying
 * of last SELECT, SHOW or HANDLER results and similar nice stuff.
 *
 * @param string $sql       query to run
 * @param string $full      query to display, this might be commented
 * @param array  &$sql_data SQL parse data storage
 *
 * @return void
 * @access public
 */
function PMA_executeQuery($sql, $full, &$sql_data)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_executeQuery") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 59")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_executeQuery:59@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Runs query inside import buffer. This is needed to allow displaying
 * of last SELECT, SHOW or HANDLER results and similar nice stuff.
 *
 * @param string $sql       query to run
 * @param string $full      query to display, this might be commented
 * @param array  &$sql_data SQL parse data storage
 *
 * @return void
 * @access public
 */
function PMA_importRunQuery($sql = '', $full = '', &$sql_data = array())
{
    global $import_run_buffer, $go_sql, $complete_query, $display_query, $sql_query, $error, $reload, $result, $msg, $skip_queries, $executed_queries, $max_sql_len, $read_multiply, $cfg, $sql_query_disabled, $db, $run_query, $is_superuser;
    $read_multiply = 1;
    if (!isset($import_run_buffer)) {
        // Do we have something to push into buffer?
        $import_run_buffer = PMA_ImportRunQuery_post($import_run_buffer, $sql, $full);
        return;
    }
    // Should we skip something?
    if ($skip_queries > 0) {
        $skip_queries--;
        // Do we have something to push into buffer?
        $import_run_buffer = PMA_ImportRunQuery_post($import_run_buffer, $sql, $full);
        return;
    }
    if (!empty($import_run_buffer['sql']) && trim($import_run_buffer['sql']) != '') {
        $max_sql_len = max($max_sql_len, mb_strlen($import_run_buffer['sql']));
        if (!$sql_query_disabled) {
            $sql_query .= $import_run_buffer['full'];
        }
        $executed_queries++;
        if ($run_query && $executed_queries < 50) {
            $go_sql = true;
            if (!$sql_query_disabled) {
                $complete_query = $sql_query;
                $display_query = $sql_query;
            } else {
                $complete_query = '';
                $display_query = '';
            }
            $sql_query = $import_run_buffer['sql'];
            $sql_data['valid_sql'][] = $import_run_buffer['sql'];
            $sql_data['valid_full'][] = $import_run_buffer['full'];
            if (!isset($sql_data['valid_queries'])) {
                $sql_data['valid_queries'] = 0;
            }
            $sql_data['valid_queries']++;
        } elseif ($run_query) {
            /* Handle rollback from go_sql */
            if ($go_sql && isset($sql_data['valid_full'])) {
                $queries = $sql_data['valid_sql'];
                $fulls = $sql_data['valid_full'];
                $count = $sql_data['valid_queries'];
                $go_sql = false;
                $sql_data['valid_sql'] = array();
                $sql_data['valid_queries'] = 0;
                unset($sql_data['valid_full']);
                for ($i = 0; $i < $count; $i++) {
                    PMA_executeQuery($queries[$i], $fulls[$i], $sql_data);
                }
            }
            PMA_executeQuery($import_run_buffer['sql'], $import_run_buffer['full'], $sql_data);
        }
        // end run query
        // end non empty query
    } elseif (!empty($import_run_buffer['full'])) {
        if ($go_sql) {
            $complete_query .= $import_run_buffer['full'];
            $display_query .= $import_run_buffer['full'];
        } else {
            if (!$sql_query_disabled) {
                $sql_query .= $import_run_buffer['full'];
            }
        }
    }
    // check length of query unless we decided to pass it to sql.php
    // (if $run_query is false, we are just displaying so show
    // the complete query in the textarea)
    if (!$go_sql && $run_query) {
        if (!empty($sql_query)) {
            if (mb_strlen($sql_query) > 50000 || $executed_queries > 50 || $max_sql_len > 1000) {
                $sql_query = '';
                $sql_query_disabled = true;
            }
        }
    }
    // Do we have something to push into buffer?
    $import_run_buffer = PMA_ImportRunQuery_post($import_run_buffer, $sql, $full);
    // In case of ROLLBACK, notify the user.
    if (isset($_REQUEST['rollback_query'])) {
        $msg .= __('[ROLLBACK occurred.]');
    }
}
/**
 * Return import run buffer
 *
 * @param array  $import_run_buffer Buffer of queries for import
 * @param string $sql               SQL query
 * @param string $full              Query to display
 *
 * @return array Buffer of queries for import
 */
function PMA_ImportRunQuery_post($import_run_buffer, $sql, $full)
{
    if (!empty($sql) || !empty($full)) {
        $import_run_buffer = array('sql' => $sql, 'full' => $full);
        return $import_run_buffer;
    } else {
        unset($GLOBALS['import_run_buffer']);
        return $import_run_buffer;
    }
}
/**
 * Looks for the presence of USE to possibly change current db
 *
 * @param string $buffer buffer to examine
 * @param string $db     current db
 * @param bool   $reload reload
 *
 * @return array (current or new db, whether to reload)
 * @access public
 */
function PMA_lookForUse($buffer, $db, $reload)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_lookForUse") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 294")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_lookForUse:294@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Returns next part of imported file/buffer
 *
 * @param int $size size of buffer to read
 *                  (this is maximal size function will return)
 *
 * @return string part of file/buffer
 * @access public
 */
function PMA_importGetNextChunk($size = 32768)
{
    global $compression, $import_handle, $charset_conversion, $charset_of_file, $read_multiply;
    // Add some progression while reading large amount of data
    if ($read_multiply <= 8) {
        $size *= $read_multiply;
    } else {
        $size *= 8;
    }
    $read_multiply++;
    // We can not read too much
    if ($size > $GLOBALS['read_limit']) {
        $size = $GLOBALS['read_limit'];
    }
    if (PMA_checkTimeout()) {
        return false;
    }
    if ($GLOBALS['finished']) {
        return true;
    }
    if ($GLOBALS['import_file'] == 'none') {
        // Well this is not yet supported and tested,
        // but should return content of textarea
        if (mb_strlen($GLOBALS['import_text']) < $size) {
            $GLOBALS['finished'] = true;
            return $GLOBALS['import_text'];
        } else {
            $r = mb_substr($GLOBALS['import_text'], 0, $size);
            $GLOBALS['offset'] += $size;
            $GLOBALS['import_text'] = mb_substr($GLOBALS['import_text'], $size);
            return $r;
        }
    }
    $result = $import_handle->read($size);
    $GLOBALS['finished'] = $import_handle->eof();
    $GLOBALS['offset'] += $size;
    if ($charset_conversion) {
        return Encoding::convertString($charset_of_file, 'utf-8', $result);
    }
    /**
     * Skip possible byte order marks (I do not think we need more
     * charsets, but feel free to add more, you can use wikipedia for
     * reference: <https://en.wikipedia.org/wiki/Byte_Order_Mark>)
     *
     * @todo BOM could be used for charset autodetection
     */
    if ($GLOBALS['offset'] == $size) {
        // UTF-8
        if (strncmp($result, "﻿", 3) == 0) {
            $result = mb_substr($result, 3);
            // UTF-16 BE, LE
        } elseif (strncmp($result, "\xfe\xff", 2) == 0 || strncmp($result, "\xff\xfe", 2) == 0) {
            $result = mb_substr($result, 2);
        }
    }
    return $result;
}
/**
 * Returns the "Excel" column name (i.e. 1 = "A", 26 = "Z", 27 = "AA", etc.)
 *
 * This functions uses recursion to build the Excel column name.
 *
 * The column number (1-26) is converted to the responding
 * ASCII character (A-Z) and returned.
 *
 * If the column number is bigger than 26 (= num of letters in alphabet),
 * an extra character needs to be added. To find this extra character,
 * the number is divided by 26 and this value is passed to another instance
 * of the same function (hence recursion). In that new instance the number is
 * evaluated again, and if it is still bigger than 26, it is divided again
 * and passed to another instance of the same function. This continues until
 * the number is smaller than 26. Then the last called function returns
 * the corresponding ASCII character to the function that called it.
 * Each time a called function ends an extra character is added to the column name.
 * When the first function is reached, the last character is added and the complete
 * column name is returned.
 *
 * @param int $num the column number
 *
 * @return string The column's "Excel" name
 * @access  public
 */
function PMA_getColumnAlphaName($num)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getColumnAlphaName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 413")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getColumnAlphaName:413@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Returns the column number based on the Excel name.
 * So "A" = 1, "Z" = 26, "AA" = 27, etc.
 *
 * Basically this is a base26 (A-Z) to base10 (0-9) conversion.
 * It iterates through all characters in the column name and
 * calculates the corresponding value, based on character value
 * (A = 1, ..., Z = 26) and position in the string.
 *
 * @param string $name column name(i.e. "A", or "BC", etc.)
 *
 * @return int The column number
 * @access  public
 */
function PMA_getColumnNumberFromName($name)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getColumnNumberFromName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 460")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getColumnNumberFromName:460@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Constants definitions
 */
/* MySQL type defs */
define("NONE", 0);
define("VARCHAR", 1);
define("INT", 2);
define("DECIMAL", 3);
define("BIGINT", 4);
define("GEOMETRY", 5);
/* Decimal size defs */
define("M", 0);
define("D", 1);
define("FULL", 2);
/* Table array defs */
define("TBL_NAME", 0);
define("COL_NAMES", 1);
define("ROWS", 2);
/* Analysis array defs */
define("TYPES", 0);
define("SIZES", 1);
define("FORMATTEDSQL", 2);
/**
 * Obtains the precision (total # of digits) from a size of type decimal
 *
 * @param string $last_cumulative_size Size of type decimal
 *
 * @return int Precision of the given decimal size notation
 * @access  public
 */
function PMA_getDecimalPrecision($last_cumulative_size)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDecimalPrecision") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 522")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDecimalPrecision:522@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Obtains the scale (# of digits to the right of the decimal point)
 * from a size of type decimal
 *
 * @param string $last_cumulative_size Size of type decimal
 *
 * @return int Scale of the given decimal size notation
 * @access  public
 */
function PMA_getDecimalScale($last_cumulative_size)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDecimalScale") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 540")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDecimalScale:540@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Obtains the decimal size of a given cell
 *
 * @param string $cell cell content
 *
 * @return array Contains the precision, scale, and full size
 *                representation of the given decimal cell
 * @access  public
 */
function PMA_getDecimalSize($cell)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getDecimalSize") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 558")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getDecimalSize:558@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Obtains the size of the given cell
 *
 * @param string $last_cumulative_size Last cumulative column size
 * @param int    $last_cumulative_type Last cumulative column type
 *                                     (NONE or VARCHAR or DECIMAL or INT or BIGINT)
 * @param int    $curr_type            Type of the current cell
 *                                     (NONE or VARCHAR or DECIMAL or INT or BIGINT)
 * @param string $cell                 The current cell
 *
 * @return string  Size of the given cell in the type-appropriate format
 * @access  public
 *
 * @todo    Handle the error cases more elegantly
 */
function PMA_detectSize($last_cumulative_size, $last_cumulative_type, $curr_type, $cell)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_detectSize") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 586")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_detectSize:586@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Determines what MySQL type a cell is
 *
 * @param int    $last_cumulative_type Last cumulative column type
 *                                     (VARCHAR or INT or BIGINT or DECIMAL or NONE)
 * @param string $cell                 String representation of the cell for which
 *                                     a best-fit type is to be determined
 *
 * @return int  The MySQL type representation
 *               (VARCHAR or INT or BIGINT or DECIMAL or NONE)
 * @access  public
 */
function PMA_detectType($last_cumulative_type, $cell)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_detectType") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 789")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_detectType:789@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Determines if the column types are int, decimal, or string
 *
 * @param array &$table array(string $table_name, array $col_names, array $rows)
 *
 * @return array    array(array $types, array $sizes)
 * @access  public
 *
 * @link https://wiki.phpmyadmin.net/pma/Import
 *
 * @todo    Handle the error case more elegantly
 */
function PMA_analyzeTable(&$table)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_analyzeTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 830")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_analyzeTable:830@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/* Needed to quell the beast that is Message */
$import_notice = null;
/**
 * Builds and executes SQL statements to create the database and tables
 * as necessary, as well as insert all the data.
 *
 * @param string $db_name         Name of the database
 * @param array  &$tables         Array of tables for the specified database
 * @param array  &$analyses       Analyses of the tables
 * @param array  &$additional_sql Additional SQL statements to be executed
 * @param array  $options         Associative array of options
 * @param array  &$sql_data       2-element array with sql data
 *
 * @return void
 * @access  public
 *
 * @link https://wiki.phpmyadmin.net/pma/Import
 */
function PMA_buildSQL($db_name, &$tables, &$analyses = null, &$additional_sql = null, $options = null, &$sql_data)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_buildSQL") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 936")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_buildSQL:936@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Stops the import on (mostly upload/file related) error
 *
 * @param PMA\libraries\Message $error_message The error message
 *
 * @return void
 * @access  public
 *
 */
function PMA_stopImport(Message $error_message)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_stopImport") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 1310")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_stopImport:1310@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Handles request for Simulation of UPDATE/DELETE queries.
 *
 * @return void
 */
function PMA_handleSimulateDMLRequest()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_handleSimulateDMLRequest") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 1338")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_handleSimulateDMLRequest:1338@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Find the matching rows for UPDATE/DELETE query.
 *
 * @param array $analyzed_sql_results Analyzed SQL results from parser.
 *
 * @return mixed
 */
function PMA_getMatchedRows($analyzed_sql_results = array())
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getMatchedRows") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 1405")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getMatchedRows:1405@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Transforms a UPDATE query into SELECT statement.
 *
 * @param array $analyzed_sql_results Analyzed SQL results from parser.
 *
 * @return string SQL query
 */
function PMA_getSimulatedUpdateQuery($analyzed_sql_results)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getSimulatedUpdateQuery") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 1440")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getSimulatedUpdateQuery:1440@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Transforms a DELETE query into SELECT statement.
 *
 * @param array $analyzed_sql_results Analyzed SQL results from parser.
 *
 * @return string SQL query
 */
function PMA_getSimulatedDeleteQuery($analyzed_sql_results)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getSimulatedDeleteQuery") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 1496")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getSimulatedDeleteQuery:1496@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Executes the matched_row_query and returns the resultant row count.
 *
 * @param string $matched_row_query SQL query
 *
 * @return integer Number of rows returned
 */
function PMA_executeMatchedRowQuery($matched_row_query)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_executeMatchedRowQuery") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 1541")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_executeMatchedRowQuery:1541@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Handles request for ROLLBACK.
 *
 * @param string $sql_query SQL query(s)
 *
 * @return void
 */
function PMA_handleRollbackRequest($sql_query)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_handleRollbackRequest") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 1559")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_handleRollbackRequest:1559@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Checks if ROLLBACK is possible for a SQL query or not.
 *
 * @param string $sql_query SQL query
 *
 * @return bool
 */
function PMA_checkIfRollbackPossible($sql_query)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_checkIfRollbackPossible") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 1604")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_checkIfRollbackPossible:1604@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}
/**
 * Checks if a table is 'InnoDB' or not.
 *
 * @param string $table Table details
 *
 * @return bool
 */
function PMA_isTableTransactional($table)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_isTableTransactional") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php at line 1643")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_isTableTransactional:1643@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/import.lib.php');
    die();
}