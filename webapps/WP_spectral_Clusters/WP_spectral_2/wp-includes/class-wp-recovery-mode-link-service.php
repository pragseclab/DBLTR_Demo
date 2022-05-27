<?php

/**
 * Error Protection API: WP_Recovery_Mode_Link_Handler class
 *
 * @package WordPress
 * @since 5.2.0
 */
/**
 * Core class used to generate and handle recovery mode links.
 *
 * @since 5.2.0
 */
class WP_Recovery_Mode_Link_Service
{
    const LOGIN_ACTION_ENTER = 'enter_recovery_mode';
    const LOGIN_ACTION_ENTERED = 'entered_recovery_mode';
    /**
     * Service to generate and validate recovery mode keys.
     *
     * @since 5.2.0
     * @var WP_Recovery_Mode_Key_Service
     */
    private $key_service;
    /**
     * Service to handle cookies.
     *
     * @since 5.2.0
     * @var WP_Recovery_Mode_Cookie_Service
     */
    private $cookie_service;
    /**
     * WP_Recovery_Mode_Link_Service constructor.
     *
     * @since 5.2.0
     *
     * @param WP_Recovery_Mode_Cookie_Service $cookie_service Service to handle setting the recovery mode cookie.
     * @param WP_Recovery_Mode_Key_Service    $key_service    Service to handle generating recovery mode keys.
     */
    public function __construct(WP_Recovery_Mode_Cookie_Service $cookie_service, WP_Recovery_Mode_Key_Service $key_service)
    {
        $this->cookie_service = $cookie_service;
        $this->key_service = $key_service;
    }
    /**
     * Generates a URL to begin recovery mode.
     *
     * Only one recovery mode URL can may be valid at the same time.
     *
     * @since 5.2.0
     *
     * @return string Generated URL.
     */
    public function generate_url()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("generate_url") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-recovery-mode-link-service.php at line 56")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called generate_url:56@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-recovery-mode-link-service.php');
        die();
    }
    /**
     * Enters recovery mode when the user hits wp-login.php with a valid recovery mode link.
     *
     * @since 5.2.0
     *
     * @global string $pagenow
     *
     * @param int $ttl Number of seconds the link should be valid for.
     */
    public function handle_begin_link($ttl)
    {
        if (!isset($GLOBALS['pagenow']) || 'wp-login.php' !== $GLOBALS['pagenow']) {
            return;
        }
        if (!isset($_GET['action'], $_GET['rm_token'], $_GET['rm_key']) || self::LOGIN_ACTION_ENTER !== $_GET['action']) {
            return;
        }
        if (!function_exists('wp_generate_password')) {
            require_once ABSPATH . WPINC . '/pluggable.php';
        }
        $validated = $this->key_service->validate_recovery_mode_key($_GET['rm_token'], $_GET['rm_key'], $ttl);
        if (is_wp_error($validated)) {
            wp_die($validated, '');
        }
        $this->cookie_service->set_cookie();
        $url = add_query_arg('action', self::LOGIN_ACTION_ENTERED, wp_login_url());
        wp_redirect($url);
        die;
    }
    /**
     * Gets a URL to begin recovery mode.
     *
     * @since 5.2.0
     *
     * @param string $token Recovery Mode token created by {@see generate_recovery_mode_token()}.
     * @param string $key   Recovery Mode key created by {@see generate_and_store_recovery_mode_key()}.
     * @return string Recovery mode begin URL.
     */
    private function get_recovery_mode_begin_url($token, $key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_recovery_mode_begin_url") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-recovery-mode-link-service.php at line 100")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_recovery_mode_begin_url:100@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-recovery-mode-link-service.php');
        die();
    }
}