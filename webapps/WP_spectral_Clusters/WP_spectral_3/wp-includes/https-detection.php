<?php

/**
 * HTTPS detection functions.
 *
 * @package WordPress
 * @since 5.7.0
 */
/**
 * Checks whether the website is using HTTPS.
 *
 * This is based on whether both the home and site URL are using HTTPS.
 *
 * @since 5.7.0
 * @see wp_is_home_url_using_https()
 * @see wp_is_site_url_using_https()
 *
 * @return bool True if using HTTPS, false otherwise.
 */
function wp_is_using_https()
{
    if (!wp_is_home_url_using_https()) {
        return false;
    }
    return wp_is_site_url_using_https();
}
/**
 * Checks whether the current site URL is using HTTPS.
 *
 * @since 5.7.0
 * @see home_url()
 *
 * @return bool True if using HTTPS, false otherwise.
 */
function wp_is_home_url_using_https()
{
    return 'https' === wp_parse_url(home_url(), PHP_URL_SCHEME);
}
/**
 * Checks whether the current site's URL where WordPress is stored is using HTTPS.
 *
 * This checks the URL where WordPress application files (e.g. wp-blog-header.php or the wp-admin/ folder) are
 * accessible.
 *
 * @since 5.7.0
 * @see site_url()
 *
 * @return bool True if using HTTPS, false otherwise.
 */
function wp_is_site_url_using_https()
{
    // Use direct option access for 'siteurl' and manually run the 'site_url'
    // filter because `site_url()` will adjust the scheme based on what the
    // current request is using.
    /** This filter is documented in wp-includes/link-template.php */
    $site_url = apply_filters('site_url', get_option('siteurl'), '', null, null);
    return 'https' === wp_parse_url($site_url, PHP_URL_SCHEME);
}
/**
 * Checks whether HTTPS is supported for the server and domain.
 *
 * @since 5.7.0
 *
 * @return bool True if HTTPS is supported, false otherwise.
 */
function wp_is_https_supported()
{
    $https_detection_errors = get_option('https_detection_errors');
    // If option has never been set by the Cron hook before, run it on-the-fly as fallback.
    if (false === $https_detection_errors) {
        wp_update_https_detection_errors();
        $https_detection_errors = get_option('https_detection_errors');
    }
    // If there are no detection errors, HTTPS is supported.
    return empty($https_detection_errors);
}
/**
 * Runs a remote HTTPS request to detect whether HTTPS supported, and stores potential errors.
 *
 * This internal function is called by a regular Cron hook to ensure HTTPS support is detected and maintained.
 *
 * @since 5.7.0
 * @access private
 */
function wp_update_https_detection_errors()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_update_https_detection_errors") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/https-detection.php at line 98")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_update_https_detection_errors:98@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/https-detection.php');
    die();
}
/**
 * Schedules the Cron hook for detecting HTTPS support.
 *
 * @since 5.7.0
 * @access private
 */
function wp_schedule_https_detection()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_schedule_https_detection") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/https-detection.php at line 131")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_schedule_https_detection:131@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/https-detection.php');
    die();
}
/**
 * Disables SSL verification if the 'cron_request' arguments include an HTTPS URL.
 *
 * This prevents an issue if HTTPS breaks, where there would be a failed attempt to verify HTTPS.
 *
 * @since 5.7.0
 * @access private
 *
 * @param array $request The Cron request arguments.
 * @return array $request The filtered Cron request arguments.
 */
function wp_cron_conditionally_prevent_sslverify($request)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_cron_conditionally_prevent_sslverify") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/https-detection.php at line 151")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_cron_conditionally_prevent_sslverify:151@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/https-detection.php');
    die();
}
/**
 * Checks whether a given HTML string is likely an output from this WordPress site.
 *
 * This function attempts to check for various common WordPress patterns whether they are included in the HTML string.
 * Since any of these actions may be disabled through third-party code, this function may also return null to indicate
 * that it was not possible to determine ownership.
 *
 * @since 5.7.0
 * @access private
 *
 * @param string $html Full HTML output string, e.g. from a HTTP response.
 * @return bool|null True/false for whether HTML was generated by this site, null if unable to determine.
 */
function wp_is_local_html_output($html)
{
    // 1. Check if HTML includes the site's Really Simple Discovery link.
    if (has_action('wp_head', 'rsd_link')) {
        $pattern = preg_replace('#^https?:(?=//)#', '', esc_url(site_url('xmlrpc.php?rsd', 'rpc')));
        // See rsd_link().
        return false !== strpos($html, $pattern);
    }
    // 2. Check if HTML includes the site's Windows Live Writer manifest link.
    if (has_action('wp_head', 'wlwmanifest_link')) {
        // Try both HTTPS and HTTP since the URL depends on context.
        $pattern = preg_replace('#^https?:(?=//)#', '', includes_url('wlwmanifest.xml'));
        // See wlwmanifest_link().
        return false !== strpos($html, $pattern);
    }
    // 3. Check if HTML includes the site's REST API link.
    if (has_action('wp_head', 'rest_output_link_wp_head')) {
        // Try both HTTPS and HTTP since the URL depends on context.
        $pattern = preg_replace('#^https?:(?=//)#', '', esc_url(get_rest_url()));
        // See rest_output_link_wp_head().
        return false !== strpos($html, $pattern);
    }
    // Otherwise the result cannot be determined.
    return null;
}