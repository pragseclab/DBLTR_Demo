<?php

/**
 * Abstract class for the authentication plugins
 */
declare (strict_types=1);
namespace PhpMyAdmin\Plugins;

use PhpMyAdmin\Config;
use PhpMyAdmin\Core;
use PhpMyAdmin\IpAllowDeny;
use PhpMyAdmin\Logging;
use PhpMyAdmin\Message;
use PhpMyAdmin\Response;
use PhpMyAdmin\Session;
use PhpMyAdmin\Template;
use PhpMyAdmin\TwoFactor;
use PhpMyAdmin\Url;
use function defined;
use function htmlspecialchars;
use function intval;
use function max;
use function min;
use function session_destroy;
use function session_unset;
use function sprintf;
use function time;
/**
 * Provides a common interface that will have to be implemented by all of the
 * authentication plugins.
 */
abstract class AuthenticationPlugin
{
    /**
     * Username
     *
     * @var string
     */
    public $user = '';
    /**
     * Password
     *
     * @var string
     */
    public $password = '';
    /** @var IpAllowDeny */
    protected $ipAllowDeny;
    /** @var Template */
    public $template;
    public function __construct()
    {
        $this->ipAllowDeny = new IpAllowDeny();
        $this->template = new Template();
    }
    /**
     * Displays authentication form
     *
     * @return bool
     */
    public abstract function showLoginForm();
    /**
     * Gets authentication credentials
     *
     * @return bool
     */
    public abstract function readCredentials();
    /**
     * Set the user and password after last checkings if required
     *
     * @return bool
     */
    public function storeCredentials()
    {
        global $cfg;
        $this->setSessionAccessTime();
        $cfg['Server']['user'] = $this->user;
        $cfg['Server']['password'] = $this->password;
        return true;
    }
    /**
     * Stores user credentials after successful login.
     *
     * @return void
     */
    public function rememberCredentials()
    {
    }
    /**
     * User is not allowed to login to MySQL -> authentication failed
     *
     * @param string $failure String describing why authentication has failed
     *
     * @return void
     */
    public function showFailure($failure)
    {
        Logging::logUser($this->user, $failure);
    }
    /**
     * Perform logout
     *
     * @return void
     */
    public function logOut()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("logOut") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Plugins/AuthenticationPlugin.php at line 106")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called logOut:106@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Plugins/AuthenticationPlugin.php');
        die();
    }
    /**
     * Returns URL for login form.
     *
     * @return string
     */
    public function getLoginFormURL()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getLoginFormURL") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Plugins/AuthenticationPlugin.php at line 149")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getLoginFormURL:149@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Plugins/AuthenticationPlugin.php');
        die();
    }
    /**
     * Returns error message for failed authentication.
     *
     * @param string $failure String describing why authentication has failed
     *
     * @return string
     */
    public function getErrorMessage($failure)
    {
        global $dbi;
        if ($failure === 'empty-denied') {
            return __('Login without a password is forbidden by configuration' . ' (see AllowNoPassword)');
        }
        if ($failure === 'root-denied' || $failure === 'allow-denied') {
            return __('Access denied!');
        }
        if ($failure === 'no-activity') {
            return sprintf(__('You have been automatically logged out due to inactivity of %s seconds.' . ' Once you log in again, you should be able to resume the work where you left off.'), intval($GLOBALS['cfg']['LoginCookieValidity']));
        }
        $dbi_error = $dbi->getError();
        if (!empty($dbi_error)) {
            return htmlspecialchars($dbi_error);
        }
        if (isset($GLOBALS['errno'])) {
            return '#' . $GLOBALS['errno'] . ' ' . __('Cannot log in to the MySQL server');
        }
        return __('Cannot log in to the MySQL server');
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
    /**
     * High level authentication interface
     *
     * Gets the credentials or shows login form if necessary
     *
     * @return void
     */
    public function authenticate()
    {
        $success = $this->readCredentials();
        /* Show login form (this exits) */
        if (!$success) {
            /* Force generating of new session */
            Session::secure();
            $this->showLoginForm();
        }
        /* Store credentials (eg. in cookies) */
        $this->storeCredentials();
        /* Check allow/deny rules */
        $this->checkRules();
    }
    /**
     * Check configuration defined restrictions for authentication
     *
     * @return void
     */
    public function checkRules()
    {
        global $cfg;
        // Check IP-based Allow/Deny rules as soon as possible to reject the
        // user based on mod_access in Apache
        if (isset($cfg['Server']['AllowDeny']['order'])) {
            $allowDeny_forbidden = false;
            // default
            if ($cfg['Server']['AllowDeny']['order'] === 'allow,deny') {
                $allowDeny_forbidden = true;
                if ($this->ipAllowDeny->allow()) {
                    $allowDeny_forbidden = false;
                }
                if ($this->ipAllowDeny->deny()) {
                    $allowDeny_forbidden = true;
                }
            } elseif ($cfg['Server']['AllowDeny']['order'] === 'deny,allow') {
                if ($this->ipAllowDeny->deny()) {
                    $allowDeny_forbidden = true;
                }
                if ($this->ipAllowDeny->allow()) {
                    $allowDeny_forbidden = false;
                }
            } elseif ($cfg['Server']['AllowDeny']['order'] === 'explicit') {
                if ($this->ipAllowDeny->allow() && !$this->ipAllowDeny->deny()) {
                    $allowDeny_forbidden = false;
                } else {
                    $allowDeny_forbidden = true;
                }
            }
            // Ejects the user if banished
            if ($allowDeny_forbidden) {
                $this->showFailure('allow-denied');
            }
        }
        // is root allowed?
        if (!$cfg['Server']['AllowRoot'] && $cfg['Server']['user'] === 'root') {
            $this->showFailure('root-denied');
        }
        // is a login without password allowed?
        if ($cfg['Server']['AllowNoPassword'] || $cfg['Server']['password'] !== '') {
            return;
        }
        $this->showFailure('empty-denied');
    }
    /**
     * Checks whether two factor authentication is active
     * for given user and performs it.
     */
    public function checkTwoFactor() : void
    {
        $twofactor = new TwoFactor($this->user);
        /* Do we need to show the form? */
        if ($twofactor->check()) {
            return;
        }
        $response = Response::getInstance();
        if ($response->loginPage()) {
            if (defined('TESTSUITE')) {
                return;
            }
            exit;
        }
        echo $this->template->render('login/header', ['theme' => $GLOBALS['PMA_Theme']]);
        echo Message::rawNotice(__('You have enabled two factor authentication, please confirm your login.'))->getDisplay();
        echo $this->template->render('login/twofactor', ['form' => $twofactor->render(), 'show_submit' => $twofactor->showSubmit()]);
        echo $this->template->render('login/footer');
        echo Config::renderFooter();
        if (!defined('TESTSUITE')) {
            exit;
        }
    }
}