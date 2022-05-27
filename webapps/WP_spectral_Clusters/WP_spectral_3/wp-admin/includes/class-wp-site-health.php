<?php

/**
 * Class for looking up a site's health based on a user's WordPress environment.
 *
 * @package WordPress
 * @subpackage Site_Health
 * @since 5.2.0
 */
class WP_Site_Health
{
    private static $instance = null;
    private $mysql_min_version_check;
    private $mysql_rec_version_check;
    public $is_mariadb = false;
    private $mysql_server_version = '';
    private $health_check_mysql_required_version = '5.5';
    private $health_check_mysql_rec_version = '';
    public $php_memory_limit;
    public $schedules;
    public $crons;
    public $last_missed_cron = null;
    public $last_late_cron = null;
    private $timeout_missed_cron = null;
    private $timeout_late_cron = null;
    /**
     * WP_Site_Health constructor.
     *
     * @since 5.2.0
     */
    public function __construct()
    {
        $this->maybe_create_scheduled_event();
        // Save memory limit before it's affected by wp_raise_memory_limit( 'admin' ).
        $this->php_memory_limit = ini_get('memory_limit');
        $this->timeout_late_cron = 0;
        $this->timeout_missed_cron = -5 * MINUTE_IN_SECONDS;
        if (defined('DISABLE_WP_CRON') && DISABLE_WP_CRON) {
            $this->timeout_late_cron = -15 * MINUTE_IN_SECONDS;
            $this->timeout_missed_cron = -1 * HOUR_IN_SECONDS;
        }
        add_filter('admin_body_class', array($this, 'admin_body_class'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_site_health_scheduled_check', array($this, 'wp_cron_scheduled_check'));
        add_action('site_health_tab_content', array($this, 'show_site_health_tab'));
    }
    /**
     * Output the content of a tab in the Site Health screen.
     *
     * @since 5.8.0
     *
     * @param string $tab Slug of the current tab being displayed.
     */
    public function show_site_health_tab($tab)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("show_site_health_tab") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 56")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called show_site_health_tab:56@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Return an instance of the WP_Site_Health class, or create one if none exist yet.
     *
     * @since 5.4.0
     *
     * @return WP_Site_Health|null
     */
    public static function get_instance()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_instance") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 69")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_instance:69@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Enqueues the site health scripts.
     *
     * @since 5.2.0
     */
    public function enqueue_scripts()
    {
        $screen = get_current_screen();
        if ('site-health' !== $screen->id && 'dashboard' !== $screen->id) {
            return;
        }
        $health_check_js_variables = array('screen' => $screen->id, 'nonce' => array('site_status' => wp_create_nonce('health-check-site-status'), 'site_status_result' => wp_create_nonce('health-check-site-status-result')), 'site_status' => array('direct' => array(), 'async' => array(), 'issues' => array('good' => 0, 'recommended' => 0, 'critical' => 0)));
        $issue_counts = get_transient('health-check-site-status-result');
        if (false !== $issue_counts) {
            $issue_counts = json_decode($issue_counts);
            $health_check_js_variables['site_status']['issues'] = $issue_counts;
        }
        if ('site-health' === $screen->id && (!isset($_GET['tab']) || empty($_GET['tab']))) {
            $tests = WP_Site_Health::get_tests();
            // Don't run https test on development environments.
            if ($this->is_development_environment()) {
                unset($tests['async']['https_status']);
            }
            foreach ($tests['direct'] as $test) {
                if (is_string($test['test'])) {
                    $test_function = sprintf('get_test_%s', $test['test']);
                    if (method_exists($this, $test_function) && is_callable(array($this, $test_function))) {
                        $health_check_js_variables['site_status']['direct'][] = $this->perform_test(array($this, $test_function));
                        continue;
                    }
                }
                if (is_callable($test['test'])) {
                    $health_check_js_variables['site_status']['direct'][] = $this->perform_test($test['test']);
                }
            }
            foreach ($tests['async'] as $test) {
                if (is_string($test['test'])) {
                    $health_check_js_variables['site_status']['async'][] = array('test' => $test['test'], 'has_rest' => isset($test['has_rest']) ? $test['has_rest'] : false, 'completed' => false, 'headers' => isset($test['headers']) ? $test['headers'] : array());
                }
            }
        }
        wp_localize_script('site-health', 'SiteHealth', $health_check_js_variables);
    }
    /**
     * Run a Site Health test directly.
     *
     * @since 5.4.0
     *
     * @param callable $callback
     * @return mixed|void
     */
    private function perform_test($callback)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("perform_test") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 148")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called perform_test:148@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Run the SQL version checks.
     *
     * These values are used in later tests, but the part of preparing them is more easily managed
     * early in the class for ease of access and discovery.
     *
     * @since 5.2.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     */
    private function prepare_sql_data()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_sql_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 162")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_sql_data:162@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if `wp_version_check` is blocked.
     *
     * It's possible to block updates with the `wp_version_check` filter, but this can't be checked
     * during an Ajax call, as the filter is never introduced then.
     *
     * This filter overrides a standard page request if it's made by an admin through the Ajax call
     * with the right query argument to check for this.
     *
     * @since 5.2.0
     */
    public function check_wp_version_check_exists()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_wp_version_check_exists") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 192")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_wp_version_check_exists:192@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Tests for WordPress version and outputs it.
     *
     * Gives various results depending on what kind of updates are available, if any, to encourage
     * the user to install security updates as a priority.
     *
     * @since 5.2.0
     *
     * @return array The test result.
     */
    public function get_test_wordpress_version()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_wordpress_version") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 210")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_wordpress_version:210@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if plugins are outdated, or unnecessary.
     *
     * The tests checks if your plugins are up to date, and encourages you to remove any
     * that are not in use.
     *
     * @since 5.2.0
     *
     * @return array The test result.
     */
    public function get_test_plugin_version()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_plugin_version") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 270")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_plugin_version:270@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if themes are outdated, or unnecessary.
     *
     * Сhecks if your site has a default theme (to fall back on if there is a need),
     * if your themes are up to date and, finally, encourages you to remove any themes
     * that are not needed.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_theme_version()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_theme_version") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 337")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_theme_version:337@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if the supplied PHP version is supported.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_php_version()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_php_version") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 470")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_php_version:470@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Check if the passed extension or function are available.
     *
     * Make the check for available PHP modules into a simple boolean operator for a cleaner test runner.
     *
     * @since 5.2.0
     * @since 5.3.0 The `$constant` and `$class` parameters were added.
     *
     * @param string $extension Optional. The extension name to test. Default null.
     * @param string $function  Optional. The function name to test. Default null.
     * @param string $constant  Optional. The constant name to test for. Default null.
     * @param string $class     Optional. The class name to test for. Default null.
     * @return bool Whether or not the extension and function are available.
     */
    private function test_php_extension_availability($extension = null, $function = null, $constant = null, $class = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("test_php_extension_availability") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 537")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called test_php_extension_availability:537@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if required PHP modules are installed on the host.
     *
     * This test builds on the recommendations made by the WordPress Hosting Team
     * as seen at https://make.wordpress.org/hosting/handbook/handbook/server-environment/#php-extensions
     *
     * @since 5.2.0
     *
     * @return array
     */
    public function get_test_php_extensions()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_php_extensions") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 566")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_php_extensions:566@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if the PHP default timezone is set to UTC.
     *
     * @since 5.3.1
     *
     * @return array The test results.
     */
    public function get_test_php_default_timezone()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_php_default_timezone") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 672")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_php_default_timezone:672@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if there's an active PHP session that can affect loopback requests.
     *
     * @since 5.5.0
     *
     * @return array The test results.
     */
    public function get_test_php_sessions()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_php_sessions") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 693")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_php_sessions:693@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if the SQL server is up to date.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_sql_server()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_sql_server") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 720")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_sql_server:720@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if the database server is capable of using utf8mb4.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_utf8mb4_support()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_utf8mb4_support") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 772")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_utf8mb4_support:772@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if the site can communicate with WordPress.org.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_dotorg_communication()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_dotorg_communication") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 849")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_dotorg_communication:849@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if debug information is enabled.
     *
     * When WP_DEBUG is enabled, errors and information may be disclosed to site visitors,
     * or logged to a publicly accessible file.
     *
     * Debugging is also frequently left enabled after looking for errors on a site,
     * as site owners do not understand the implications of this.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_is_in_debug_mode()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_is_in_debug_mode") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 888")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_is_in_debug_mode:888@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if your site is serving content over HTTPS.
     *
     * Many sites have varying degrees of HTTPS support, the most common of which is sites that have it
     * enabled, but only if you visit the right site address.
     *
     * @since 5.2.0
     * @since 5.7.0 Updated to rely on {@see wp_is_using_https()} and {@see wp_is_https_supported()}.
     *
     * @return array The test results.
     */
    public function get_test_https_status()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_https_status") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 938")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_https_status:938@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Check if the HTTP API can handle SSL/TLS requests.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_ssl_support()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_ssl_support") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1035")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_ssl_support:1035@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if scheduled events run as intended.
     *
     * If scheduled events are not running, this may indicate something with WP_Cron is not working
     * as intended, or that there are orphaned events hanging around from older code.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_scheduled_events()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_scheduled_events") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1059")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_scheduled_events:1059@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if WordPress can run automated background updates.
     *
     * Background updates in WordPress are primarily used for minor releases and security updates.
     * It's important to either have these working, or be aware that they are intentionally disabled
     * for whatever reason.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_background_updates()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_background_updates") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1101")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_background_updates:1101@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if plugin and theme auto-updates appear to be configured correctly.
     *
     * @since 5.5.0
     *
     * @return array The test results.
     */
    public function get_test_plugin_theme_auto_updates()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_plugin_theme_auto_updates") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1139")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_plugin_theme_auto_updates:1139@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if loopbacks work as expected.
     *
     * A loopback is when WordPress queries itself, for example to start a new WP_Cron instance,
     * or when editing a plugin or theme. This has shown itself to be a recurring issue,
     * as code can very easily break this interaction.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_loopback_requests()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_loopback_requests") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1161")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_loopback_requests:1161@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if HTTP requests are blocked.
     *
     * It's possible to block all outgoing communication (with the possibility of allowing certain
     * hosts) via the HTTP API. This may create problems for users as many features are running as
     * services these days.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_http_requests()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_http_requests") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_http_requests:1183@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if the REST API is accessible.
     *
     * Various security measures may block the REST API from working, or it may have been disabled in general.
     * This is required for the new block editor to work, so we explicitly test for this.
     *
     * @since 5.2.0
     *
     * @return array The test results.
     */
    public function get_test_rest_availability()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_rest_availability") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1225")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_rest_availability:1225@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Test if 'file_uploads' directive in PHP.ini is turned off.
     *
     * @since 5.5.0
     *
     * @return array The test results.
     */
    public function get_test_file_uploads()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_file_uploads") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1280")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_file_uploads:1280@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Tests if the Authorization header has the expected values.
     *
     * @since 5.6.0
     *
     * @return array
     */
    public function get_test_authorization_header()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_test_authorization_header") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1343")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_test_authorization_header:1343@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Return a set of tests that belong to the site status page.
     *
     * Each site status test is defined here, they may be `direct` tests, that run on page load, or `async` tests
     * which will run later down the line via JavaScript calls to improve page performance and hopefully also user
     * experiences.
     *
     * @since 5.2.0
     * @since 5.6.0 Added support for `has_rest` and `permissions`.
     *
     * @return array The list of tests to run.
     */
    public static function get_tests()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_tests") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1382")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_tests:1382@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Add a class to the body HTML tag.
     *
     * Filters the body class string for admin pages and adds our own class for easier styling.
     *
     * @since 5.2.0
     *
     * @param string $body_class The body class string.
     * @return string The modified body class string.
     */
    public function admin_body_class($body_class)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("admin_body_class") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1441")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called admin_body_class:1441@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Initiate the WP_Cron schedule test cases.
     *
     * @since 5.2.0
     */
    private function wp_schedule_test_init()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_schedule_test_init") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1455")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_schedule_test_init:1455@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Populate our list of cron events and store them to a class-wide variable.
     *
     * @since 5.2.0
     */
    private function get_cron_tasks()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_cron_tasks") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1465")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_cron_tasks:1465@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Check if any scheduled tasks have been missed.
     *
     * Returns a boolean value of `true` if a scheduled task has been missed and ends processing.
     *
     * If the list of crons is an instance of WP_Error, returns the instance instead of a boolean value.
     *
     * @since 5.2.0
     *
     * @return bool|WP_Error True if a cron was missed, false if not. WP_Error if the cron is set to that.
     */
    public function has_missed_cron()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("has_missed_cron") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1492")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called has_missed_cron:1492@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Check if any scheduled tasks are late.
     *
     * Returns a boolean value of `true` if a scheduled task is late and ends processing.
     *
     * If the list of crons is an instance of WP_Error, returns the instance instead of a boolean value.
     *
     * @since 5.3.0
     *
     * @return bool|WP_Error True if a cron is late, false if not. WP_Error if the cron is set to that.
     */
    public function has_late_cron()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("has_late_cron") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1516")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called has_late_cron:1516@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Check for potential issues with plugin and theme auto-updates.
     *
     * Though there is no way to 100% determine if plugin and theme auto-updates are configured
     * correctly, a few educated guesses could be made to flag any conditions that would
     * potentially cause unexpected behaviors.
     *
     * @since 5.5.0
     *
     * @return object The test results.
     */
    function detect_plugin_theme_auto_update_issues()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("detect_plugin_theme_auto_update_issues") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1541")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called detect_plugin_theme_auto_update_issues:1541@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Run a loopback test on our site.
     *
     * Loopbacks are what WordPress uses to communicate with itself to start up WP_Cron, scheduled posts,
     * make sure plugin or theme edits don't cause site failures and similar.
     *
     * @since 5.2.0
     *
     * @return object The test results.
     */
    function can_perform_loopback()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("can_perform_loopback") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1573")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called can_perform_loopback:1573@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Create a weekly cron event, if one does not already exist.
     *
     * @since 5.4.0
     */
    public function maybe_create_scheduled_event()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("maybe_create_scheduled_event") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1619")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called maybe_create_scheduled_event:1619@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Run our scheduled event to check and update the latest site health status for the website.
     *
     * @since 5.4.0
     */
    public function wp_cron_scheduled_check()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_cron_scheduled_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1631")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_cron_scheduled_check:1631@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
    /**
     * Checks if the current environment type is set to 'development' or 'local'.
     *
     * @since 5.6.0
     *
     * @return bool True if it is a development environment, false if not.
     */
    public function is_development_environment()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_development_environment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php at line 1700")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_development_environment:1700@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-admin/includes/class-wp-site-health.php');
        die();
    }
}