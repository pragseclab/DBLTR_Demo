<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Set of functions used with the relation and pdf feature
 *
 * This file also provides basic functions to use in other plugins!
 * These are declared in the 'GLOBAL Plugin functions' section
 *
 * Please use short and expressive names.
 * For now, special characters which aren't allowed in
 * filenames or functions should not be used.
 *
 * Please provide a comment for your function,
 * what it does and what parameters are available.
 *
 * @package PhpMyAdmin
 */
if (!defined('PHPMYADMIN')) {
    exit;
}
/**
 * Returns array of options from string with options separated by comma,
 * removes quotes
 *
 * <code>
 * PMA_Transformation_getOptions("'option ,, quoted',abd,'2,3',");
 * // array {
 * //     'option ,, quoted',
 * //     'abc',
 * //     '2,3',
 * //     '',
 * // }
 * </code>
 *
 * @param string $option_string comma separated options
 *
 * @return array options
 */
function PMA_Transformation_getOptions($option_string)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_Transformation_getOptions") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php at line 42")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_Transformation_getOptions:42@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php');
    die();
}
/**
 * Gets all available MIME-types
 *
 * @access  public
 * @staticvar   array   mimetypes
 * @return array    array[mimetype], array[transformation]
 */
function PMA_getAvailableMIMEtypes()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getAvailableMIMEtypes") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php at line 87")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getAvailableMIMEtypes:87@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php');
    die();
}
/**
 * Returns the class name of the transformation
 *
 * @param string $filename transformation file name
 *
 * @return string the class name of transformation
 */
function PMA_getTransformationClassName($filename)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getTransformationClassName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php at line 164")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getTransformationClassName:164@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php');
    die();
}
/**
 * Returns the description of the transformation
 *
 * @param string $file transformation file
 *
 * @return String the description of the transformation
 */
function PMA_getTransformationDescription($file)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getTransformationDescription") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php at line 179")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getTransformationDescription:179@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php');
    die();
}
/**
 * Returns the name of the transformation
 *
 * @param string $file transformation file
 *
 * @return String the name of the transformation
 */
function PMA_getTransformationName($file)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getTransformationName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php at line 196")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getTransformationName:196@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php');
    die();
}
/**
 * Gets the mimetypes for all columns of a table
 *
 * @param string  $db       the name of the db to check for
 * @param string  $table    the name of the table to check for
 * @param boolean $strict   whether to include only results having a mimetype set
 * @param boolean $fullName whether to use full column names as the key
 *
 * @access public
 *
 * @return array [field_name][field_key] = field_value
 */
function PMA_getMIME($db, $table, $strict = false, $fullName = false)
{
    $cfgRelation = PMA_getRelationsParam();
    if (!$cfgRelation['commwork']) {
        return false;
    }
    $com_qry = '';
    if ($fullName) {
        $com_qry .= "SELECT CONCAT(" . "`db_name`, '.', `table_name`, '.', `column_name`" . ") AS column_name, ";
    } else {
        $com_qry = "SELECT `column_name`, ";
    }
    $com_qry .= '`mimetype`,
                `transformation`,
                `transformation_options`,
                `input_transformation`,
                `input_transformation_options`
         FROM ' . PMA\libraries\Util::backquote($cfgRelation['db']) . '.' . PMA\libraries\Util::backquote($cfgRelation['column_info']) . '
         WHERE `db_name`    = \'' . $GLOBALS['dbi']->escapeString($db) . '\'
           AND `table_name` = \'' . $GLOBALS['dbi']->escapeString($table) . '\'
           AND ( `mimetype` != \'\'' . (!$strict ? '
              OR `transformation` != \'\'
              OR `transformation_options` != \'\'
              OR `input_transformation` != \'\'
              OR `input_transformation_options` != \'\'' : '') . ')';
    $result = $GLOBALS['dbi']->fetchResult($com_qry, 'column_name', null, $GLOBALS['controllink']);
    foreach ($result as $column => $values) {
        // replacements in mimetype and transformation
        $values = str_replace("jpeg", "JPEG", $values);
        $values = str_replace("png", "PNG", $values);
        // convert mimetype to new format (f.e. Text_Plain, etc)
        $delimiter_space = '- ';
        $delimiter = "_";
        $values['mimetype'] = str_replace($delimiter_space, $delimiter, ucwords(str_replace($delimiter, $delimiter_space, $values['mimetype'])));
        // For transformation of form
        // output/image_jpeg__inline.inc.php
        // extract dir part.
        $dir = explode('/', $values['transformation']);
        $subdir = '';
        if (count($dir) === 2) {
            $subdir = $dir[0] . '/';
            $values['transformation'] = $dir[1];
        }
        $values['transformation'] = str_replace($delimiter_space, $delimiter, ucwords(str_replace($delimiter, $delimiter_space, $values['transformation'])));
        $values['transformation'] = $subdir . $values['transformation'];
        $result[$column] = $values;
    }
    return $result;
}
// end of the 'PMA_getMIME()' function
/**
 * Set a single mimetype to a certain value.
 *
 * @param string  $db                 the name of the db
 * @param string  $table              the name of the table
 * @param string  $key                the name of the column
 * @param string  $mimetype           the mimetype of the column
 * @param string  $transformation     the transformation of the column
 * @param string  $transformationOpts the transformation options of the column
 * @param string  $inputTransform     the input transformation of the column
 * @param string  $inputTransformOpts the input transformation options of the column
 * @param boolean $forcedelete        force delete, will erase any existing
 *                                    comments for this column
 *
 * @access  public
 *
 * @return boolean  true, if comment-query was made.
 */
function PMA_setMIME($db, $table, $key, $mimetype, $transformation, $transformationOpts, $inputTransform, $inputTransformOpts, $forcedelete = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_setMIME") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php at line 319")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_setMIME:319@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php');
    die();
}
// end of 'PMA_setMIME()' function
/**
 * GLOBAL Plugin functions
 */
/**
 * Delete related transformation details
 * after deleting database. table or column
 *
 * @param string $db     Database name
 * @param string $table  Table name
 * @param string $column Column name
 *
 * @return boolean State of the query execution
 */
function PMA_clearTransformations($db, $table = '', $column = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_clearTransformations") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php at line 423")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_clearTransformations:423@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/transformations.lib.php');
    die();
}