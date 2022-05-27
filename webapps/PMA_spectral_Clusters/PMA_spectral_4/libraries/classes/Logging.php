<?php

/**
 * Logging functionality for webserver.
 *
 * This includes web server specific code to log some information.
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use const LOG_AUTHPRIV;
use const LOG_NDELAY;
use const LOG_PID;
use const LOG_WARNING;
use function closelog;
use function date;
use function error_log;
use function function_exists;
use function openlog;
use function syslog;
/**
 * Misc logging functions
 */
class Logging
{
    /**
     * Get authentication logging destination
     *
     * @return string
     */
    public static function getLogDestination()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getLogDestination") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Logging.php at line 33")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getLogDestination:33@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Logging.php');
        die();
    }
    /**
     * Generate log message for authentication logging
     *
     * @param string $user   user name
     * @param string $status status message
     *
     * @return string
     */
    public static function getLogMessage($user, $status)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getLogMessage") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Logging.php at line 56")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getLogMessage:56@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Logging.php');
        die();
    }
    /**
     * Logs user information to webserver logs.
     *
     * @param string $user   user name
     * @param string $status status message
     *
     * @return void
     */
    public static function logUser($user, $status = 'ok')
    {
        if (function_exists('apache_note')) {
            apache_note('userID', $user);
            apache_note('userStatus', $status);
        }
        /* Do not log successful authentications */
        if (!$GLOBALS['PMA_Config']->get('AuthLogSuccess') && $status === 'ok') {
            return;
        }
        $log_file = self::getLogDestination();
        if (empty($log_file)) {
            return;
        }
        $message = self::getLogMessage($user, $status);
        if ($log_file === 'syslog') {
            if (function_exists('syslog')) {
                @openlog('phpMyAdmin', LOG_NDELAY | LOG_PID, LOG_AUTHPRIV);
                @syslog(LOG_WARNING, $message);
                closelog();
            }
        } elseif ($log_file === 'php') {
            @error_log($message);
        } elseif ($log_file === 'sapi') {
            @error_log($message, 4);
        } else {
            @error_log(date('M d H:i:s') . ' phpmyadmin: ' . $message . "\n", 3, $log_file);
        }
    }
}