<?php

/**
 * HTTPS migration functions.
 *
 * @package WordPress
 * @since 5.7.0
 */
/**
 * Checks whether WordPress should replace old HTTP URLs to the site with their HTTPS counterpart.
 *
 * If a WordPress site had its URL changed from HTTP to HTTPS, by default this will return `true`, causing WordPress to
 * add frontend filters to replace insecure site URLs that may be present in older database content. The
 * {@see 'wp_should_replace_insecure_home_url'} filter can be used to modify that behavior.
 *
 * @since 5.7.0
 *
 * @return bool True if insecure URLs should replaced, false otherwise.
 */
function wp_should_replace_insecure_home_url()
{
    $should_replace_insecure_home_url = wp_is_using_https() && get_option('https_migration_required') && wp_parse_url(home_url(), PHP_URL_HOST) === wp_parse_url(site_url(), PHP_URL_HOST);
    /**
     * Filters whether WordPress should replace old HTTP URLs to the site with their HTTPS counterpart.
     *
     * If a WordPress site had its URL changed from HTTP to HTTPS, by default this will return `true`. This filter can
     * be used to disable that behavior, e.g. after having replaced URLs manually in the database.
     *
     * @since 5.7.0
     *
     * @param bool $should_replace_insecure_home_url Whether insecure HTTP URLs to the site should be replaced.
     */
    return apply_filters('wp_should_replace_insecure_home_url', $should_replace_insecure_home_url);
}
/**
 * Replaces insecure HTTP URLs to the site in the given content, if configured to do so.
 *
 * This function replaces all occurrences of the HTTP version of the site's URL with its HTTPS counterpart, if
 * determined via {@see wp_should_replace_insecure_home_url()}.
 *
 * @since 5.7.0
 *
 * @param string $content Content to replace URLs in.
 * @return string Filtered content.
 */
function wp_replace_insecure_home_url($content)
{
    if (!wp_should_replace_insecure_home_url()) {
        return $content;
    }
    $https_url = home_url('', 'https');
    $http_url = str_replace('https://', 'http://', $https_url);
    // Also replace potentially escaped URL.
    $escaped_https_url = str_replace('/', '\\/', $https_url);
    $escaped_http_url = str_replace('/', '\\/', $http_url);
    return str_replace(array($http_url, $escaped_http_url), array($https_url, $escaped_https_url), $content);
}
/**
 * Update the 'home' and 'siteurl' option to use the HTTPS variant of their URL.
 *
 * If this update does not result in WordPress recognizing that the site is now using HTTPS (e.g. due to constants
 * overriding the URLs used), the changes will be reverted. In such a case the function will return false.
 *
 * @since 5.7.0
 *
 * @return bool True on success, false on failure.
 */
function wp_update_urls_to_https()
{
    // Get current URL options.
    $orig_home = get_option('home');
    $orig_siteurl = get_option('siteurl');
    // Get current URL options, replacing HTTP with HTTPS.
    $home = str_replace('http://', 'https://', $orig_home);
    $siteurl = str_replace('http://', 'https://', $orig_siteurl);
    // Update the options.
    update_option('home', $home);
    update_option('siteurl', $siteurl);
    if (!wp_is_using_https()) {
        // If this did not result in the site recognizing HTTPS as being used,
        // revert the change and return false.
        update_option('home', $orig_home);
        update_option('siteurl', $orig_siteurl);
        return false;
    }
    // Otherwise the URLs were successfully changed to use HTTPS.
    return true;
}
/**
 * Updates the 'https_migration_required' option if needed when the given URL has been updated from HTTP to HTTPS.
 *
 * If this is a fresh site, a migration will not be required, so the option will be set as `false`.
 *
 * This is hooked into the {@see 'update_option_home'} action.
 *
 * @since 5.7.0
 * @access private
 *
 * @param mixed $old_url Previous value of the URL option.
 * @param mixed $new_url New value of the URL option.
 */
function wp_update_https_migration_required($old_url, $new_url)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_update_https_migration_required") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/https-migration.php at line 105")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_update_https_migration_required:105@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/https-migration.php');
    die();
}