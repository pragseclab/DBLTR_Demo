<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Abstract class for the authentication plugins
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries\plugins;

use PMA\libraries\Sanitize;
/**
 * Provides a common interface that will have to be implemented by all of the
 * authentication plugins.
 *
 * @package PhpMyAdmin
 */
abstract class AuthenticationPlugin
{
    /**
     * Displays authentication form
     *
     * @return boolean
     */
    public abstract function auth();
    /**
     * Gets advanced authentication settings
     *
     * @return boolean
     */
    public abstract function authCheck();
    /**
     * Set the user and password after last checkings if required
     *
     * @return boolean
     */
    public abstract function authSetUser();
    /**
     * Stores user credentials after successful login.
     *
     * @return void
     */
    public function storeUserCredentials()
    {
    }
    /**
     * User is not allowed to login to MySQL -> authentication failed
     *
     * @return boolean
     */
    public abstract function authFails();
    /**
     * Perform logout
     *
     * @return void
     */
    public function logOut()
    {
        global $PHP_AUTH_USER, $PHP_AUTH_PW;
        /* Obtain redirect URL (before doing logout) */
        if (!empty($GLOBALS['cfg']['Server']['LogoutURL'])) {
            $redirect_url = $GLOBALS['cfg']['Server']['LogoutURL'];
        } else {
            $redirect_url = $this->getLoginFormURL();
        }
        /* Clear credentials */
        $PHP_AUTH_USER = '';
        $PHP_AUTH_PW = '';
        /* delete user's choices that were stored in session */
        $_SESSION = array();
        if (!defined('TESTSUITE')) {
            session_destroy();
        }
        /* Redirect to login form (or configured URL) */
        PMA_sendHeaderLocation($redirect_url);
    }
    /**
     * Returns URL for login form.
     *
     * @return string
     */
    public function getLoginFormURL()
    {
        return './index.php';
    }
    /**
     * Returns error message for failed authentication.
     *
     * @return string
     */
    public function getErrorMessage()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getErrorMessage") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/plugins/AuthenticationPlugin.php at line 104")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getErrorMessage:104@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/plugins/AuthenticationPlugin.php');
        die();
    }
    /**
     * Callback when user changes password.
     *
     * @param string $password New password to set
     *
     * @return void
     */
    public function handlePasswordChange($password)
    {
    }
    /**
     * Store session access time in session.
     *
     * Tries to workaround PHP 5 session garbage collection which
     * looks at the session file's last modified time
     *
     * @return void
     */
    public function setSessionAccessTime()
    {
        if (isset($_REQUEST['guid'])) {
            $guid = (string) $_REQUEST['guid'];
        } else {
            $guid = 'default';
        }
        if (isset($_REQUEST['access_time'])) {
            // Ensure access_time is in range <0, LoginCookieValidity + 1>
            // to avoid excessive extension of validity.
            //
            // Negative values can cause session expiry extension
            // Too big values can cause overflow and lead to same
            $time = time() - min(max(0, intval($_REQUEST['access_time'])), $GLOBALS['cfg']['LoginCookieValidity'] + 1);
        } else {
            $time = time();
        }
        $_SESSION['browser_access_time'][$guid] = $time;
    }
}