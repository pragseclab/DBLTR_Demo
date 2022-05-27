<?php

/**
 * Deprecated pluggable functions from past WordPress versions. You shouldn't use these
 * functions and look for the alternatives instead. The functions will be removed in a
 * later version.
 *
 * Deprecated warnings are also thrown if one of these functions is being defined by a plugin.
 *
 * @package WordPress
 * @subpackage Deprecated
 * @see pluggable.php
 */
/*
 * Deprecated functions come here to die.
 */
if (!function_exists('set_current_user')) {
    /**
     * Changes the current user by ID or name.
     *
     * Set $id to null and specify a name if you do not know a user's ID.
     *
     * @since 2.0.1
     * @deprecated 3.0.0 Use wp_set_current_user()
     * @see wp_set_current_user()
     *
     * @param int|null $id User ID.
     * @param string $name Optional. The user's username
     * @return WP_User returns wp_set_current_user()
     */
    function set_current_user($id, $name = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_current_user") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php at line 33")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_current_user:33@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php');
        die();
    }
}
if (!function_exists('get_currentuserinfo')) {
    /**
     * Populate global variables with information about the currently logged in user.
     *
     * @since 0.71
     * @deprecated 4.5.0 Use wp_get_current_user()
     * @see wp_get_current_user()
     *
     * @return bool|WP_User False on XMLRPC Request and invalid auth cookie, WP_User instance otherwise.
     */
    function get_currentuserinfo()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_currentuserinfo") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php at line 49")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_currentuserinfo:49@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php');
        die();
    }
}
if (!function_exists('get_userdatabylogin')) {
    /**
     * Retrieve user info by login name.
     *
     * @since 0.71
     * @deprecated 3.3.0 Use get_user_by()
     * @see get_user_by()
     *
     * @param string $user_login User's username
     * @return bool|object False on failure, User DB row object
     */
    function get_userdatabylogin($user_login)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_userdatabylogin") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php at line 66")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_userdatabylogin:66@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php');
        die();
    }
}
if (!function_exists('get_user_by_email')) {
    /**
     * Retrieve user info by email.
     *
     * @since 2.5.0
     * @deprecated 3.3.0 Use get_user_by()
     * @see get_user_by()
     *
     * @param string $email User's email address
     * @return bool|object False on failure, User DB row object
     */
    function get_user_by_email($email)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_user_by_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php at line 83")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_user_by_email:83@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php');
        die();
    }
}
if (!function_exists('wp_setcookie')) {
    /**
     * Sets a cookie for a user who just logged in. This function is deprecated.
     *
     * @since 1.5.0
     * @deprecated 2.5.0 Use wp_set_auth_cookie()
     * @see wp_set_auth_cookie()
     *
     * @param string $username The user's username
     * @param string $password Optional. The user's password
     * @param bool $already_md5 Optional. Whether the password has already been through MD5
     * @param string $home Optional. Will be used instead of COOKIEPATH if set
     * @param string $siteurl Optional. Will be used instead of SITECOOKIEPATH if set
     * @param bool $remember Optional. Remember that the user is logged in
     */
    function wp_setcookie($username, $password = '', $already_md5 = false, $home = '', $siteurl = '', $remember = false)
    {
        _deprecated_function(__FUNCTION__, '2.5.0', 'wp_set_auth_cookie()');
        $user = get_user_by('login', $username);
        wp_set_auth_cookie($user->ID, $remember);
    }
} else {
    _deprecated_function('wp_setcookie', '2.5.0', 'wp_set_auth_cookie()');
}
if (!function_exists('wp_clearcookie')) {
    /**
     * Clears the authentication cookie, logging the user out. This function is deprecated.
     *
     * @since 1.5.0
     * @deprecated 2.5.0 Use wp_clear_auth_cookie()
     * @see wp_clear_auth_cookie()
     */
    function wp_clearcookie()
    {
        _deprecated_function(__FUNCTION__, '2.5.0', 'wp_clear_auth_cookie()');
        wp_clear_auth_cookie();
    }
} else {
    _deprecated_function('wp_clearcookie', '2.5.0', 'wp_clear_auth_cookie()');
}
if (!function_exists('wp_get_cookie_login')) {
    /**
     * Gets the user cookie login. This function is deprecated.
     *
     * This function is deprecated and should no longer be extended as it won't be
     * used anywhere in WordPress. Also, plugins shouldn't use it either.
     *
     * @since 2.0.3
     * @deprecated 2.5.0
     *
     * @return bool Always returns false
     */
    function wp_get_cookie_login()
    {
        _deprecated_function(__FUNCTION__, '2.5.0');
        return false;
    }
} else {
    _deprecated_function('wp_get_cookie_login', '2.5.0');
}
if (!function_exists('wp_login')) {
    /**
     * Checks a users login information and logs them in if it checks out. This function is deprecated.
     *
     * Use the global $error to get the reason why the login failed. If the username
     * is blank, no error will be set, so assume blank username on that case.
     *
     * Plugins extending this function should also provide the global $error and set
     * what the error is, so that those checking the global for why there was a
     * failure can utilize it later.
     *
     * @since 1.2.2
     * @deprecated 2.5.0 Use wp_signon()
     * @see wp_signon()
     *
     * @global string $error Error when false is returned
     *
     * @param string $username   User's username
     * @param string $password   User's password
     * @param string $deprecated Not used
     * @return bool True on successful check, false on login failure.
     */
    function wp_login($username, $password, $deprecated = '')
    {
        _deprecated_function(__FUNCTION__, '2.5.0', 'wp_signon()');
        global $error;
        $user = wp_authenticate($username, $password);
        if (!is_wp_error($user)) {
            return true;
        }
        $error = $user->get_error_message();
        return false;
    }
} else {
    _deprecated_function('wp_login', '2.5.0', 'wp_signon()');
}
/**
 * WordPress AtomPub API implementation.
 *
 * Originally stored in wp-app.php, and later wp-includes/class-wp-atom-server.php.
 * It is kept here in case a plugin directly referred to the class.
 *
 * @since 2.2.0
 * @deprecated 3.5.0
 *
 * @link https://wordpress.org/plugins/atom-publishing-protocol/
 */
if (!class_exists('wp_atom_server', false)) {
    class wp_atom_server
    {
        public function __call($name, $arguments)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__call") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php at line 199")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called __call:199@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php');
            die();
        }
        public static function __callStatic($name, $arguments)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__callStatic") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php at line 203")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called __callStatic:203@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/pluggable-deprecated.php');
            die();
        }
    }
}