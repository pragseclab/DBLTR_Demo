<?php

/**
 * REST API: WP_REST_Site_Health_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 5.6.0
 */
/**
 * Core class for interacting with Site Health tests.
 *
 * @since 5.6.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Site_Health_Controller extends WP_REST_Controller
{
    /**
     * An instance of the site health class.
     *
     * @since 5.6.0
     *
     * @var WP_Site_Health
     */
    private $site_health;
    /**
     * Site Health controller constructor.
     *
     * @since 5.6.0
     *
     * @param WP_Site_Health $site_health An instance of the site health class.
     */
    public function __construct($site_health)
    {
        $this->namespace = 'wp-site-health/v1';
        $this->rest_base = 'tests';
        $this->site_health = $site_health;
    }
    /**
     * Registers API routes.
     *
     * @since 5.6.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, sprintf('/%s/%s', $this->rest_base, 'background-updates'), array(array('methods' => 'GET', 'callback' => array($this, 'test_background_updates'), 'permission_callback' => function () {
            return $this->validate_request_permission('background_updates');
        }), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, sprintf('/%s/%s', $this->rest_base, 'loopback-requests'), array(array('methods' => 'GET', 'callback' => array($this, 'test_loopback_requests'), 'permission_callback' => function () {
            return $this->validate_request_permission('loopback_requests');
        }), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, sprintf('/%s/%s', $this->rest_base, 'https-status'), array(array('methods' => 'GET', 'callback' => array($this, 'test_https_status'), 'permission_callback' => function () {
            return $this->validate_request_permission('https_status');
        }), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, sprintf('/%s/%s', $this->rest_base, 'dotorg-communication'), array(array('methods' => 'GET', 'callback' => array($this, 'test_dotorg_communication'), 'permission_callback' => function () {
            return $this->validate_request_permission('dotorg_communication');
        }), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, sprintf('/%s/%s', $this->rest_base, 'authorization-header'), array(array('methods' => 'GET', 'callback' => array($this, 'test_authorization_header'), 'permission_callback' => function () {
            return $this->validate_request_permission('authorization_header');
        }), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, sprintf('/%s', 'directory-sizes'), array('methods' => 'GET', 'callback' => array($this, 'get_directory_sizes'), 'permission_callback' => function () {
            return $this->validate_request_permission('debug_enabled') && !is_multisite();
        }));
    }
    /**
     * Validates if the current user can request this REST endpoint.
     *
     * @since 5.6.0
     *
     * @param string $check The endpoint check being ran.
     * @return bool
     */
    protected function validate_request_permission($check)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validate_request_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php at line 78")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validate_request_permission:78@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php');
        die();
    }
    /**
     * Checks if background updates work as expected.
     *
     * @since 5.6.0
     *
     * @return array
     */
    public function test_background_updates()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("test_background_updates") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php at line 99")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called test_background_updates:99@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php');
        die();
    }
    /**
     * Checks that the site can reach the WordPress.org API.
     *
     * @since 5.6.0
     *
     * @return array
     */
    public function test_dotorg_communication()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("test_dotorg_communication") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php at line 111")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called test_dotorg_communication:111@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php');
        die();
    }
    /**
     * Checks that loopbacks can be performed.
     *
     * @since 5.6.0
     *
     * @return array
     */
    public function test_loopback_requests()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("test_loopback_requests") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php at line 123")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called test_loopback_requests:123@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php');
        die();
    }
    /**
     * Checks that the site's frontend can be accessed over HTTPS.
     *
     * @since 5.7.0
     *
     * @return array
     */
    public function test_https_status()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("test_https_status") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php at line 135")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called test_https_status:135@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php');
        die();
    }
    /**
     * Checks that the authorization header is valid.
     *
     * @since 5.6.0
     *
     * @return array
     */
    public function test_authorization_header()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("test_authorization_header") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php at line 147")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called test_authorization_header:147@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php');
        die();
    }
    /**
     * Gets the current directory sizes for this install.
     *
     * @since 5.6.0
     *
     * @return array|WP_Error
     */
    public function get_directory_sizes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_directory_sizes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php at line 159")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_directory_sizes:159@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php');
        die();
    }
    /**
     * Loads the admin textdomain for Site Health tests.
     *
     * The {@see WP_Site_Health} class is defined in WP-Admin, while the REST API operates in a front-end context.
     * This means that the translations for Site Health won't be loaded by default in {@see load_default_textdomain()}.
     *
     * @since 5.6.0
     */
    protected function load_admin_textdomain()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("load_admin_textdomain") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php at line 203")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called load_admin_textdomain:203@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php');
        die();
    }
    /**
     * Gets the schema for each site health test.
     *
     * @since 5.6.0
     *
     * @return array The test schema.
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php at line 217")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:217@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php');
        die();
    }
}