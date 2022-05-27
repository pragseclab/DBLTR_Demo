<?php

/**
 * WordPress Translation Installation Administration API
 *
 * @package WordPress
 * @subpackage Administration
 */
/**
 * Retrieve translations from WordPress Translation API.
 *
 * @since 4.0.0
 *
 * @param string       $type Type of translations. Accepts 'plugins', 'themes', 'core'.
 * @param array|object $args Translation API arguments. Optional.
 * @return object|WP_Error On success an object of translations, WP_Error on failure.
 */
function translations_api($type, $args = null)
{
    // Include an unmodified $wp_version.
    require ABSPATH . WPINC . '/version.php';
    if (!in_array($type, array('plugins', 'themes', 'core'), true)) {
        return new WP_Error('invalid_type', __('Invalid translation type.'));
    }
    /**
     * Allows a plugin to override the WordPress.org Translation Installation API entirely.
     *
     * @since 4.0.0
     *
     * @param false|object $result The result object. Default false.
     * @param string       $type   The type of translations being requested.
     * @param object       $args   Translation API arguments.
     */
    $res = apply_filters('translations_api', false, $type, $args);
    if (false === $res) {
        $url = 'http://api.wordpress.org/translations/' . $type . '/1.0/';
        $http_url = $url;
        $ssl = wp_http_supports(array('ssl'));
        if ($ssl) {
            $url = set_url_scheme($url, 'https');
        }
        $options = array('timeout' => 3, 'body' => array('wp_version' => $wp_version, 'locale' => get_locale(), 'version' => $args['version']));
        if ('core' !== $type) {
            $options['body']['slug'] = $args['slug'];
            // Plugin or theme slug.
        }
        $request = wp_remote_post($url, $options);
        if ($ssl && is_wp_error($request)) {
            trigger_error(sprintf(
                /* translators: %s: Support forums URL. */
                __('An unexpected error occurred. Something may be wrong with WordPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="%s">support forums</a>.'),
                __('https://wordpress.org/support/forums/')
            ) . ' ' . __('(WordPress could not establish a secure connection to WordPress.org. Please contact your server administrator.)'), headers_sent() || WP_DEBUG ? E_USER_WARNING : E_USER_NOTICE);
            $request = wp_remote_post($http_url, $options);
        }
        if (is_wp_error($request)) {
            $res = new WP_Error('translations_api_failed', sprintf(
                /* translators: %s: Support forums URL. */
                __('An unexpected error occurred. Something may be wrong with WordPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="%s">support forums</a>.'),
                __('https://wordpress.org/support/forums/')
            ), $request->get_error_message());
        } else {
            $res = json_decode(wp_remote_retrieve_body($request), true);
            if (!is_object($res) && !is_array($res)) {
                $res = new WP_Error('translations_api_failed', sprintf(
                    /* translators: %s: Support forums URL. */
                    __('An unexpected error occurred. Something may be wrong with WordPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="%s">support forums</a>.'),
                    __('https://wordpress.org/support/forums/')
                ), wp_remote_retrieve_body($request));
            }
        }
    }
    /**
     * Filters the Translation Installation API response results.
     *
     * @since 4.0.0
     *
     * @param object|WP_Error $res  Response object or WP_Error.
     * @param string          $type The type of translations being requested.
     * @param object          $args Translation API arguments.
     */
    return apply_filters('translations_api_result', $res, $type, $args);
}
/**
 * Get available translations from the WordPress.org API.
 *
 * @since 4.0.0
 *
 * @see translations_api()
 *
 * @return array[] Array of translations, each an array of data, keyed by the language. If the API response results
 *                 in an error, an empty array will be returned.
 */
function wp_get_available_translations()
{
    if (!wp_installing()) {
        $translations = get_site_transient('available_translations');
        if (false !== $translations) {
            return $translations;
        }
    }
    // Include an unmodified $wp_version.
    require ABSPATH . WPINC . '/version.php';
    $api = translations_api('core', array('version' => $wp_version));
    if (is_wp_error($api) || empty($api['translations'])) {
        return array();
    }
    $translations = array();
    // Key the array with the language code for now.
    foreach ($api['translations'] as $translation) {
        $translations[$translation['language']] = $translation;
    }
    if (!defined('WP_INSTALLING')) {
        set_site_transient('available_translations', $translations, 3 * HOUR_IN_SECONDS);
    }
    return $translations;
}
/**
 * Output the select form for the language selection on the installation screen.
 *
 * @since 4.0.0
 *
 * @global string $wp_local_package Locale code of the package.
 *
 * @param array[] $languages Array of available languages (populated via the Translation API).
 */
function wp_install_language_form($languages)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_install_language_form") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/translation-install.php at line 129")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_install_language_form:129@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/translation-install.php');
    die();
}
/**
 * Download a language pack.
 *
 * @since 4.0.0
 *
 * @see wp_get_available_translations()
 *
 * @param string $download Language code to download.
 * @return string|false Returns the language code if successfully downloaded
 *                      (or already installed), or false on failure.
 */
function wp_download_language_pack($download)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_download_language_pack") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/translation-install.php at line 162")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_download_language_pack:162@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/translation-install.php');
    die();
}
/**
 * Check if WordPress has access to the filesystem without asking for
 * credentials.
 *
 * @since 4.0.0
 *
 * @return bool Returns true on success, false on failure.
 */
function wp_can_install_language_pack()
{
    if (!wp_is_file_mod_allowed('can_install_language_pack')) {
        return false;
    }
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    $skin = new Automatic_Upgrader_Skin();
    $upgrader = new Language_Pack_Upgrader($skin);
    $upgrader->init();
    $check = $upgrader->fs_connect(array(WP_CONTENT_DIR, WP_LANG_DIR));
    if (!$check || is_wp_error($check)) {
        return false;
    }
    return true;
}