<?php

declare (strict_types=1);
namespace PhpMyAdmin\Import;

use PhpMyAdmin\Core;
use function extension_loaded;
use function function_exists;
use function ini_get;
use function json_encode;
use function ucwords;
use function uniqid;
/**
 * Handles plugins that show the upload progress.
 */
final class Ajax
{
    /**
     * Sets up some variables for upload progress
     */
    public static function uploadProgressSetup() : array
    {
        /**
         * constant for differentiating array in $_SESSION variable
         */
        $SESSION_KEY = '__upload_status';
        /**
         * sets default plugin for handling the import process
         */
        $_SESSION[$SESSION_KEY]['handler'] = '';
        /**
         * unique ID for each upload
         */
        $upload_id = uniqid('');
        /**
         * list of available plugins
         */
        $plugins = [
            // in PHP 5.4 session-based upload progress was problematic, see closed bug 3964
            //"session",
            'progress',
            'apc',
            'noplugin',
        ];
        // select available plugin
        foreach ($plugins as $plugin) {
            $check = $plugin . 'Check';
            if (self::$check()) {
                $upload_class = 'PhpMyAdmin\\Plugins\\Import\\Upload\\Upload' . ucwords($plugin);
                $_SESSION[$SESSION_KEY]['handler'] = $upload_class;
                break;
            }
        }
        return [$SESSION_KEY, $upload_id, $plugins];
    }
    /**
     * Checks if APC bar extension is available and configured correctly.
     *
     * @return bool true if APC extension is available and if rfc1867 is enabled,
     * false if it is not
     */
    public static function apcCheck()
    {
        if (!extension_loaded('apc') || !function_exists('apc_fetch') || !function_exists('getallheaders')) {
            return false;
        }
        return ini_get('apc.enabled') && ini_get('apc.rfc1867');
    }
    /**
     * Checks if PhpMyAdmin\Plugins\Import\Upload\UploadProgress bar extension is
     * available.
     *
     * @return bool true if PhpMyAdmin\Plugins\Import\Upload\UploadProgress
     * extension is available, false if it is not
     */
    public static function progressCheck() : bool
    {
        return function_exists('uploadprogress_get_info') && function_exists('getallheaders');
    }
    /**
     * Checks if PHP 5.4 session upload-progress feature is available.
     *
     * @return bool true if PHP 5.4 session upload-progress is available,
     * false if it is not
     */
    public static function sessionCheck() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sessionCheck") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Import/Ajax.php at line 88")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sessionCheck:88@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Import/Ajax.php');
        die();
    }
    /**
     * Default plugin for handling import.
     * If no other plugin is available, noplugin is used.
     *
     * @return true
     */
    public static function nopluginCheck() : bool
    {
        return true;
    }
    /**
     * The function outputs json encoded status of uploaded.
     * It uses PMA_getUploadStatus, which is defined in plugin's file.
     *
     * @param string $id ID of transfer, usually $upload_id
     */
    public static function status($id) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("status") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Import/Ajax.php at line 108")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called status:108@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Import/Ajax.php');
        die();
    }
}