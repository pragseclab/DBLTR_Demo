<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * session handling
 *
 * @todo    add an option to use mm-module for session handler
 *
 * @package PhpMyAdmin
 * @see     https://secure.php.net/session
 */
if (!defined('PHPMYADMIN')) {
    exit;
}
require_once 'libraries/session.lib.php';
// verify if PHP supports session, die if it does not
if (!@function_exists('session_name')) {
    PMA_warnMissingExtension('session', true);
} elseif (ini_get('session.auto_start') !== '' && session_name() != 'phpMyAdmin') {
    // Do not delete the existing session, it might be used by other
    // applications; instead just close it.
    session_write_close();
}
// disable starting of sessions before all settings are done
// does not work, besides how it is written in php manual
//ini_set('session.auto_start', '0');
// session cookie settings
session_set_cookie_params(0, $GLOBALS['PMA_Config']->getRootPath(), '', $GLOBALS['PMA_Config']->isHttps(), true);
// cookies are safer (use @ini_set() in case this function is disabled)
@ini_set('session.use_cookies', 'true');
// optionally set session_save_path
$path = $GLOBALS['PMA_Config']->get('SessionSavePath');
if (!empty($path)) {
    session_save_path($path);
}
// use cookies only
@ini_set('session.use_only_cookies', '1');
// strict session mode (do not accept random string as session ID)
@ini_set('session.use_strict_mode', '1');
// make the session cookie HttpOnly
@ini_set('session.cookie_httponly', '1');
// do not force transparent session ids
@ini_set('session.use_trans_sid', '0');
// delete session/cookies when browser is closed
@ini_set('session.cookie_lifetime', '0');
// warn but don't work with bug
@ini_set('session.bug_compat_42', 'false');
@ini_set('session.bug_compat_warn', 'true');
// use more secure session ids
@ini_set('session.hash_function', '1');
// some pages (e.g. stylesheet) may be cached on clients, but not in shared
// proxy servers
session_cache_limiter('private');
// start the session
// on some servers (for example, sourceforge.net), we get a permission error
// on the session data directory, so I add some "@"
function PMA_sessionFailed($errors)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_sessionFailed") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/session.inc.php at line 76")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_sessionFailed:76@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/session.inc.php');
    die();
}
// See bug #1538132. This would block normal behavior on a cluster
//ini_set('session.save_handler', 'files');
$session_name = 'phpMyAdmin';
@session_name($session_name);
// on first start of session we check for errors
// f.e. session dir cannot be accessed - session file not created
$orig_error_count = $GLOBALS['error_handler']->countErrors(false);
$session_result = session_start();
if ($session_result !== true || $orig_error_count != $GLOBALS['error_handler']->countErrors(false)) {
    setcookie($session_name, '', 1);
    $errors = $GLOBALS['error_handler']->sliceErrors($orig_error_count);
    PMA_sessionFailed($errors);
}
unset($orig_error_count, $session_result);
/**
 * Disable setting of session cookies for further session_start() calls.
 */
@ini_set('session.use_cookies', 'true');
/**
 * Token which is used for authenticating access queries.
 * (we use "space PMA_token space" to prevent overwriting)
 */
if (!isset($_SESSION[' PMA_token '])) {
    PMA_generateToken();
    /**
     * Check for disk space on session storage by trying to write it.
     *
     * This seems to be most reliable approach to test if sessions are working,
     * otherwise the check would fail with custom session backends.
     */
    $orig_error_count = $GLOBALS['error_handler']->countErrors();
    session_write_close();
    if ($GLOBALS['error_handler']->countErrors() > $orig_error_count) {
        $errors = $GLOBALS['error_handler']->sliceErrors($orig_error_count);
        PMA_sessionFailed($errors);
    }
    session_start();
}