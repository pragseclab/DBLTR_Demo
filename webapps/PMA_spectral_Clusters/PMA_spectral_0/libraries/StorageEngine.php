<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Library for extracting information about the available storage engines
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

/**
 * defines
 */
use PMA\libraries\engines\Bdb;
use PMA\libraries\engines\Berkeleydb;
use PMA\libraries\engines\Binlog;
use PMA\libraries\engines\Innobase;
use PMA\libraries\engines\Innodb;
use PMA\libraries\engines\Memory;
use PMA\libraries\engines\Merge;
use PMA\libraries\engines\Mrg_Myisam;
use PMA\libraries\engines\Myisam;
use PMA\libraries\engines\Ndbcluster;
use PMA\libraries\engines\Pbxt;
use PMA\libraries\engines\Performance_Schema;
define('PMA_ENGINE_SUPPORT_NO', 0);
define('PMA_ENGINE_SUPPORT_DISABLED', 1);
define('PMA_ENGINE_SUPPORT_YES', 2);
define('PMA_ENGINE_SUPPORT_DEFAULT', 3);
define('PMA_ENGINE_DETAILS_TYPE_PLAINTEXT', 0);
define('PMA_ENGINE_DETAILS_TYPE_SIZE', 1);
define('PMA_ENGINE_DETAILS_TYPE_NUMERIC', 2);
//Has no effect yet...
define('PMA_ENGINE_DETAILS_TYPE_BOOLEAN', 3);
// 'ON' or 'OFF'
/**
 * Base Storage Engine Class
 *
 * @package PhpMyAdmin
 */
class StorageEngine
{
    /**
     * @var string engine name
     */
    var $engine = 'dummy';
    /**
     * @var string engine title/description
     */
    var $title = 'PMA Dummy Engine Class';
    /**
     * @var string engine lang description
     */
    var $comment = 'If you read this text inside phpMyAdmin, something went wrong...';
    /**
     * @var integer engine supported by current server
     */
    var $support = PMA_ENGINE_SUPPORT_NO;
    /**
     * Constructor
     *
     * @param string $engine The engine ID
     */
    public function __construct($engine)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 71")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:71@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Returns array of storage engines
     *
     * @static
     * @staticvar array $storage_engines storage engines
     * @access public
     * @return string[] array of storage engines
     */
    public static function getStorageEngines()
    {
        static $storage_engines = null;
        if (null == $storage_engines) {
            $storage_engines = $GLOBALS['dbi']->fetchResult('SHOW STORAGE ENGINES', 'Engine');
            if (PMA_MYSQL_INT_VERSION >= 50708) {
                $disabled = Util::cacheGet('disabled_storage_engines', function () {
                    return $GLOBALS['dbi']->fetchValue('SELECT @@disabled_storage_engines');
                });
                foreach (explode(",", $disabled) as $engine) {
                    if (isset($storage_engines[$engine])) {
                        $storage_engines[$engine]['Support'] = 'DISABLED';
                    }
                }
            }
        }
        return $storage_engines;
    }
    /**
     * Returns HTML code for storage engine select box
     *
     * @param string  $name                    The name of the select form element
     * @param string  $id                      The ID of the form field
     * @param string  $selected                The selected engine
     * @param boolean $offerUnavailableEngines Should unavailable storage
     *                                         engines be offered?
     * @param boolean $addEmpty                Whether to provide empty option
     *
     * @static
     * @return string html selectbox
     */
    public static function getHtmlSelect($name = 'engine', $id = null, $selected = null, $offerUnavailableEngines = false, $addEmpty = false)
    {
        $selected = mb_strtolower($selected);
        $output = '<select name="' . $name . '"' . (empty($id) ? '' : ' id="' . $id . '"') . '>' . "\n";
        if ($addEmpty) {
            $output .= '<option value=""></option>';
        }
        foreach (StorageEngine::getStorageEngines() as $key => $details) {
            // Don't show PERFORMANCE_SCHEMA engine (MySQL 5.5)
            if (!$offerUnavailableEngines && ($details['Support'] == 'NO' || $details['Support'] == 'DISABLED' || $details['Engine'] == 'PERFORMANCE_SCHEMA')) {
                continue;
            }
            $output .= '    <option value="' . htmlspecialchars($key) . '"' . (empty($details['Comment']) ? '' : ' title="' . htmlspecialchars($details['Comment']) . '"') . (mb_strtolower($key) == $selected || empty($selected) && $details['Support'] == 'DEFAULT' && !$addEmpty ? ' selected="selected"' : '') . '>' . "\n" . '        ' . htmlspecialchars($details['Engine']) . "\n" . '    </option>' . "\n";
        }
        $output .= '</select>' . "\n";
        return $output;
    }
    /**
     * Loads the corresponding engine plugin, if available.
     *
     * @param string $engine The engine ID
     *
     * @return StorageEngine The engine plugin
     * @static
     */
    public static function getEngine($engine)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEngine") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 190")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getEngine:190@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Returns true if given engine name is supported/valid, otherwise false
     *
     * @param string $engine name of engine
     *
     * @static
     * @return boolean whether $engine is valid or not
     */
    public static function isValid($engine)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isValid") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 230")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isValid:230@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Returns as HTML table of the engine's server variables
     *
     * @return string The table that was generated based on the retrieved
     *                information
     */
    public function getHtmlVariables()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlVariables") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 245")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlVariables:245@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Returns the engine specific handling for
     * PMA_ENGINE_DETAILS_TYPE_SIZE type variables.
     *
     * This function should be overridden when
     * PMA_ENGINE_DETAILS_TYPE_SIZE type needs to be
     * handled differently for a particular engine.
     *
     * @param integer $value Value to format
     *
     * @return string the formatted value and its unit
     */
    public function resolveTypeSize($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("resolveTypeSize") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 305")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called resolveTypeSize:305@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Returns array with detailed info about engine specific server variables
     *
     * @return array array with detailed info about specific engine server variables
     */
    public function getVariablesStatus()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getVariablesStatus") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 315")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getVariablesStatus:315@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Reveals the engine's title
     *
     * @return string The title
     */
    public function getTitle()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTitle") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 360")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTitle:360@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Fetches the server's comment about this engine
     *
     * @return string The comment
     */
    public function getComment()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getComment") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 370")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getComment:370@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Information message on whether this storage engine is supported
     *
     * @return string The localized message.
     */
    public function getSupportInformationMessage()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getSupportInformationMessage") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 380")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getSupportInformationMessage:380@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Generates a list of MySQL variables that provide information about this
     * engine. This function should be overridden when extending this class
     * for a particular engine.
     *
     * @return array The list of variables.
     */
    public function getVariables()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getVariables") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 408")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getVariables:408@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Returns string with filename for the MySQL helppage
     * about this storage engine
     *
     * @return string MySQL help page filename
     */
    public function getMysqlHelpPage()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getMysqlHelpPage") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 419")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getMysqlHelpPage:419@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Returns the pattern to be used in the query for SQL variables
     * related to the storage engine
     *
     * @return string SQL query LIKE pattern
     */
    public function getVariablesLikePattern()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getVariablesLikePattern") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 430")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getVariablesLikePattern:430@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Returns a list of available information pages with labels
     *
     * @return string[] The list
     */
    public function getInfoPages()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getInfoPages") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 440")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getInfoPages:440@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
    /**
     * Generates the requested information page
     *
     * @param string $id page id
     *
     * @return string html output
     */
    public function getPage($id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPage") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php at line 452")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPage:452@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/StorageEngine.php');
        die();
    }
}