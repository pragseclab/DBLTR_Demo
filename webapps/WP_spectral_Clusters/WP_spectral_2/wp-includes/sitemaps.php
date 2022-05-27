<?php

/**
 * Sitemaps: Public functions
 *
 * This file contains a variety of public functions developers can use to interact with
 * the XML Sitemaps API.
 *
 * @package WordPress
 * @subpackage Sitemaps
 * @since 5.5.0
 */
/**
 * Retrieves the current Sitemaps server instance.
 *
 * @since 5.5.0
 *
 * @global WP_Sitemaps $wp_sitemaps Global Core Sitemaps instance.
 *
 * @return WP_Sitemaps Sitemaps instance.
 */
function wp_sitemaps_get_server()
{
    global $wp_sitemaps;
    // If there isn't a global instance, set and bootstrap the sitemaps system.
    if (empty($wp_sitemaps)) {
        $wp_sitemaps = new WP_Sitemaps();
        $wp_sitemaps->init();
        /**
         * Fires when initializing the Sitemaps object.
         *
         * Additional sitemaps should be registered on this hook.
         *
         * @since 5.5.0
         *
         * @param WP_Sitemaps $wp_sitemaps Sitemaps object.
         */
        do_action('wp_sitemaps_init', $wp_sitemaps);
    }
    return $wp_sitemaps;
}
/**
 * Gets an array of sitemap providers.
 *
 * @since 5.5.0
 *
 * @return WP_Sitemaps_Provider[] Array of sitemap providers.
 */
function wp_get_sitemap_providers()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_get_sitemap_providers") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/sitemaps.php at line 51")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_get_sitemap_providers:51@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/sitemaps.php');
    die();
}
/**
 * Registers a new sitemap provider.
 *
 * @since 5.5.0
 *
 * @param string               $name     Unique name for the sitemap provider.
 * @param WP_Sitemaps_Provider $provider The `Sitemaps_Provider` instance implementing the sitemap.
 * @return bool Whether the sitemap was added.
 */
function wp_register_sitemap_provider($name, WP_Sitemaps_Provider $provider)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_register_sitemap_provider") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/sitemaps.php at line 65")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_register_sitemap_provider:65@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/sitemaps.php');
    die();
}
/**
 * Gets the maximum number of URLs for a sitemap.
 *
 * @since 5.5.0
 *
 * @param string $object_type Object type for sitemap to be filtered (e.g. 'post', 'term', 'user').
 * @return int The maximum number of URLs.
 */
function wp_sitemaps_get_max_urls($object_type)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_sitemaps_get_max_urls") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/sitemaps.php at line 86")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_sitemaps_get_max_urls:86@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/sitemaps.php');
    die();
}
/**
 * Retrieves the full URL for a sitemap.
 *
 * @since 5.5.1
 *
 * @param string $name         The sitemap name.
 * @param string $subtype_name The sitemap subtype name.  Default empty string.
 * @param int    $page         The page of the sitemap.  Default 1.
 * @return string|false The sitemap URL or false if the sitemap doesn't exist.
 */
function get_sitemap_url($name, $subtype_name = '', $page = 1)
{
    $sitemaps = wp_sitemaps_get_server();
    if (!$sitemaps) {
        return false;
    }
    if ('index' === $name) {
        return $sitemaps->index->get_index_url();
    }
    $provider = $sitemaps->registry->get_provider($name);
    if (!$provider) {
        return false;
    }
    if ($subtype_name && !in_array($subtype_name, array_keys($provider->get_object_subtypes()), true)) {
        return false;
    }
    $page = absint($page);
    if (0 >= $page) {
        $page = 1;
    }
    return $provider->get_sitemap_url($subtype_name, $page);
}