<?php

/**
 * Session handling
 *
 * @see     https://www.php.net/manual/en/features.sessions.php
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use const PHP_SESSION_ACTIVE;
use function defined;
use function function_exists;
use function htmlspecialchars;
use function implode;
use function ini_get;
use function ini_set;
use function preg_replace;
use function session_abort;
use function session_cache_limiter;
use function session_destroy;
use function session_id;
use function session_name;
use function session_regenerate_id;
use function session_save_path;
use function session_set_cookie_params;
use function session_start;
use function session_status;
use function session_unset;
use function session_write_close;
use function setcookie;
/**
 * Session class
 */
class Session
{
    /**
     * Generates PMA_token session variable.
     *
     * @return void
     */
    private static function generateToken()
    {
        $_SESSION[' PMA_token '] = Util::generateRandom(16, true);
        $_SESSION[' HMAC_secret '] = Util::generateRandom(16);
        /**
         * Check if token is properly generated (the generation can fail, for example
         * due to missing /dev/random for openssl).
         */
        if (!empty($_SESSION[' PMA_token '])) {
            return;
        }
        Core::fatalError('Failed to generate random CSRF token!');
    }
    /**
     * tries to secure session from hijacking and fixation
     * should be called before login and after successful login
     * (only required if sensitive information stored in session)
     *
     * @return void
     */
    public static function secure()
    {
        // prevent session fixation and XSS
        if (session_status() === PHP_SESSION_ACTIVE && !defined('TESTSUITE')) {
            session_regenerate_id(true);
        }
        // continue with empty session
        session_unset();
        self::generateToken();
    }
    /**
     * Session failed function
     *
     * @param array $errors PhpMyAdmin\ErrorHandler array
     *
     * @return void
     */
    private static function sessionFailed(array $errors)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sessionFailed") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Session.php at line 81")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sessionFailed:81@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Session.php');
        die();
    }
    /**
     * Set up session
     *
     * @param Config       $config       Configuration handler
     * @param ErrorHandler $errorHandler Error handler
     *
     * @return void
     */
    public static function setUp(Config $config, ErrorHandler $errorHandler)
    {
        // verify if PHP supports session, die if it does not
        if (!function_exists('session_name')) {
            Core::warnMissingExtension('session', true);
        } elseif (!empty(ini_get('session.auto_start')) && session_name() !== 'phpMyAdmin' && !empty(session_id())) {
            // Do not delete the existing non empty session, it might be used by
            // other applications; instead just close it.
            if (empty($_SESSION)) {
                // Ignore errors as this might have been destroyed in other
                // request meanwhile
                @session_destroy();
            } elseif (function_exists('session_abort')) {
                // PHP 5.6 and newer
                session_abort();
            } else {
                session_write_close();
            }
        }
        // session cookie settings
        session_set_cookie_params(0, $config->getRootPath(), '', $config->isHttps(), true);
        // cookies are safer (use ini_set() in case this function is disabled)
        ini_set('session.use_cookies', 'true');
        // optionally set session_save_path
        $path = $config->get('SessionSavePath');
        if (!empty($path)) {
            session_save_path($path);
            // We can not do this unconditionally as this would break
            // any more complex setup (eg. cluster), see
            // https://github.com/phpmyadmin/phpmyadmin/issues/8346
            ini_set('session.save_handler', 'files');
        }
        // use cookies only
        ini_set('session.use_only_cookies', '1');
        // strict session mode (do not accept random string as session ID)
        ini_set('session.use_strict_mode', '1');
        // make the session cookie HttpOnly
        ini_set('session.cookie_httponly', '1');
        // do not force transparent session ids
        ini_set('session.use_trans_sid', '0');
        // delete session/cookies when browser is closed
        ini_set('session.cookie_lifetime', '0');
        // some pages (e.g. stylesheet) may be cached on clients, but not in shared
        // proxy servers
        session_cache_limiter('private');
        $httpCookieName = $config->getCookieName('phpMyAdmin');
        @session_name($httpCookieName);
        // Restore correct session ID (it might have been reset by auto started session
        if ($config->issetCookie('phpMyAdmin')) {
            session_id($config->getCookie('phpMyAdmin'));
        }
        // on first start of session we check for errors
        // f.e. session dir cannot be accessed - session file not created
        $orig_error_count = $errorHandler->countErrors(false);
        $session_result = session_start();
        if ($session_result !== true || $orig_error_count != $errorHandler->countErrors(false)) {
            setcookie($httpCookieName, '', 1);
            $errors = $errorHandler->sliceErrors($orig_error_count);
            self::sessionFailed($errors);
        }
        unset($orig_error_count, $session_result);
        /**
         * Disable setting of session cookies for further session_start() calls.
         */
        if (session_status() !== PHP_SESSION_ACTIVE) {
            ini_set('session.use_cookies', 'true');
        }
        /**
         * Token which is used for authenticating access queries.
         * (we use "space PMA_token space" to prevent overwriting)
         */
        if (!empty($_SESSION[' PMA_token '])) {
            return;
        }
        self::generateToken();
        /**
         * Check for disk space on session storage by trying to write it.
         *
         * This seems to be most reliable approach to test if sessions are working,
         * otherwise the check would fail with custom session backends.
         */
        $orig_error_count = $errorHandler->countErrors();
        session_write_close();
        if ($errorHandler->countErrors() > $orig_error_count) {
            $errors = $errorHandler->sliceErrors($orig_error_count);
            self::sessionFailed($errors);
        }
        session_start();
        if (!empty($_SESSION[' PMA_token '])) {
            return;
        }
        Core::fatalError('Failed to store CSRF token in session! ' . 'Probably sessions are not working properly.');
    }
}