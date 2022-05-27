<?php

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
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Plugins\TransformationsInterface;
use function array_shift;
use function class_exists;
use function closedir;
use function count;
use function explode;
use function ltrim;
use function mb_strtolower;
use function mb_substr;
use function opendir;
use function preg_match;
use function preg_replace;
use function readdir;
use function rtrim;
use function sort;
use function str_replace;
use function stripslashes;
use function strlen;
use function strpos;
use function trim;
use function ucfirst;
use function ucwords;
/**
 * Transformations class
 */
class Transformations
{
    /**
     * Returns array of options from string with options separated by comma,
     * removes quotes
     *
     * <code>
     * getOptions("'option ,, quoted',abd,'2,3',");
     * // array {
     * //     'option ,, quoted',
     * //     'abc',
     * //     '2,3',
     * //     '',
     * // }
     * </code>
     *
     * @param string $optionString comma separated options
     *
     * @return array options
     */
    public function getOptions($optionString)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getOptions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php at line 66")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getOptions:66@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php');
        die();
    }
    /**
     * Gets all available MIME-types
     *
     * @return array    array[mimetype], array[transformation]
     *
     * @access public
     * @staticvar array   mimetypes
     */
    public function getAvailableMimeTypes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getAvailableMimeTypes") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getAvailableMimeTypes:105@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php');
        die();
    }
    /**
     * Returns the class name of the transformation
     *
     * @param string $filename transformation file name
     *
     * @return string the class name of transformation
     */
    public function getClassName($filename)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getClassName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php at line 167")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getClassName:167@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php');
        die();
    }
    /**
     * Returns the description of the transformation
     *
     * @param string $file transformation file
     *
     * @return string the description of the transformation
     */
    public function getDescription($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDescription") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php at line 180")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDescription:180@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php');
        die();
    }
    /**
     * Returns the name of the transformation
     *
     * @param string $file transformation file
     *
     * @return string the name of the transformation
     */
    public function getName($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getName:197@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php');
        die();
    }
    /**
     * Fixups old MIME or transformation name to new one
     *
     * - applies some hardcoded fixups
     * - adds spaces after _ and numbers
     * - capitalizes words
     * - removes back spaces
     *
     * @param string $value Value to fixup
     *
     * @return string
     */
    public function fixUpMime($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fixUpMime") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php at line 219")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fixUpMime:219@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php');
        die();
    }
    /**
     * Gets the mimetypes for all columns of a table
     *
     * @param string $db       the name of the db to check for
     * @param string $table    the name of the table to check for
     * @param bool   $strict   whether to include only results having a mimetype set
     * @param bool   $fullName whether to use full column names as the key
     *
     * @return array|null [field_name][field_key] = field_value
     *
     * @access public
     */
    public function getMime($db, $table, $strict = false, $fullName = false)
    {
        global $dbi;
        $relation = new Relation($dbi);
        $cfgRelation = $relation->getRelationsParam();
        if (!$cfgRelation['mimework']) {
            return null;
        }
        $com_qry = '';
        if ($fullName) {
            $com_qry .= 'SELECT CONCAT(' . "`db_name`, '.', `table_name`, '.', `column_name`" . ') AS column_name, ';
        } else {
            $com_qry = 'SELECT `column_name`, ';
        }
        $com_qry .= '`mimetype`, ' . '`transformation`, ' . '`transformation_options`, ' . '`input_transformation`, ' . '`input_transformation_options`' . ' FROM ' . Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['column_info']) . ' WHERE `db_name` = \'' . $dbi->escapeString($db) . '\'' . ' AND `table_name` = \'' . $dbi->escapeString($table) . '\'' . ' AND ( `mimetype` != \'\'' . (!$strict ? ' OR `transformation` != \'\'' . ' OR `transformation_options` != \'\'' . ' OR `input_transformation` != \'\'' . ' OR `input_transformation_options` != \'\'' : '') . ')';
        $result = $dbi->fetchResult($com_qry, 'column_name', null, DatabaseInterface::CONNECT_CONTROL);
        foreach ($result as $column => $values) {
            // convert mimetype to new format (f.e. Text_Plain, etc)
            $values['mimetype'] = $this->fixUpMime($values['mimetype']);
            // For transformation of form
            // output/image_jpeg__inline.inc.php
            // extract dir part.
            $dir = explode('/', $values['transformation']);
            $subdir = '';
            if (count($dir) === 2) {
                $subdir = ucfirst($dir[0]) . '/';
                $values['transformation'] = $dir[1];
            }
            $values['transformation'] = $this->fixUpMime($values['transformation']);
            $values['transformation'] = $subdir . $values['transformation'];
            $result[$column] = $values;
        }
        return $result;
    }
    /**
     * Set a single mimetype to a certain value.
     *
     * @param string $db                 the name of the db
     * @param string $table              the name of the table
     * @param string $key                the name of the column
     * @param string $mimetype           the mimetype of the column
     * @param string $transformation     the transformation of the column
     * @param string $transformationOpts the transformation options of the column
     * @param string $inputTransform     the input transformation of the column
     * @param string $inputTransformOpts the input transformation options of the column
     * @param bool   $forcedelete        force delete, will erase any existing
     *                                   comments for this column
     *
     * @return bool true, if comment-query was made.
     *
     * @access public
     */
    public function setMime($db, $table, $key, $mimetype, $transformation, $transformationOpts, $inputTransform, $inputTransformOpts, $forcedelete = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setMime") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php at line 288")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setMime:288@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php');
        die();
    }
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
     * @return bool State of the query execution
     */
    public function clear($db, $table = '', $column = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("clear") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php at line 342")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called clear:342@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Transformations.php');
        die();
    }
}