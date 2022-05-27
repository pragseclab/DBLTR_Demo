<?php

/**
 * Sitemaps: WP_Sitemaps_Renderer class
 *
 * Responsible for rendering Sitemaps data to XML in accordance with sitemap protocol.
 *
 * @package WordPress
 * @subpackage Sitemaps
 * @since 5.5.0
 */
/**
 * Class WP_Sitemaps_Renderer
 *
 * @since 5.5.0
 */
class WP_Sitemaps_Renderer
{
    /**
     * XSL stylesheet for styling a sitemap for web browsers.
     *
     * @since 5.5.0
     *
     * @var string
     */
    protected $stylesheet = '';
    /**
     * XSL stylesheet for styling a sitemap for web browsers.
     *
     * @since 5.5.0
     *
     * @var string
     */
    protected $stylesheet_index = '';
    /**
     * WP_Sitemaps_Renderer constructor.
     *
     * @since 5.5.0
     */
    public function __construct()
    {
        $stylesheet_url = $this->get_sitemap_stylesheet_url();
        if ($stylesheet_url) {
            $this->stylesheet = '<?xml-stylesheet type="text/xsl" href="' . esc_url($stylesheet_url) . '" ?>';
        }
        $stylesheet_index_url = $this->get_sitemap_index_stylesheet_url();
        if ($stylesheet_index_url) {
            $this->stylesheet_index = '<?xml-stylesheet type="text/xsl" href="' . esc_url($stylesheet_index_url) . '" ?>';
        }
    }
    /**
     * Gets the URL for the sitemap stylesheet.
     *
     * @since 5.5.0
     *
     * @global WP_Rewrite $wp_rewrite WordPress rewrite component.
     *
     * @return string The sitemap stylesheet URL.
     */
    public function get_sitemap_stylesheet_url()
    {
        global $wp_rewrite;
        $sitemap_url = home_url('/wp-sitemap.xsl');
        if (!$wp_rewrite->using_permalinks()) {
            $sitemap_url = home_url('/?sitemap-stylesheet=sitemap');
        }
        /**
         * Filters the URL for the sitemap stylesheet.
         *
         * If a falsey value is returned, no stylesheet will be used and
         * the "raw" XML of the sitemap will be displayed.
         *
         * @since 5.5.0
         *
         * @param string $sitemap_url Full URL for the sitemaps XSL file.
         */
        return apply_filters('wp_sitemaps_stylesheet_url', $sitemap_url);
    }
    /**
     * Gets the URL for the sitemap index stylesheet.
     *
     * @since 5.5.0
     *
     * @global WP_Rewrite $wp_rewrite WordPress rewrite component.
     *
     * @return string The sitemap index stylesheet URL.
     */
    public function get_sitemap_index_stylesheet_url()
    {
        global $wp_rewrite;
        $sitemap_url = home_url('/wp-sitemap-index.xsl');
        if (!$wp_rewrite->using_permalinks()) {
            $sitemap_url = home_url('/?sitemap-stylesheet=index');
        }
        /**
         * Filters the URL for the sitemap index stylesheet.
         *
         * If a falsey value is returned, no stylesheet will be used and
         * the "raw" XML of the sitemap index will be displayed.
         *
         * @since 5.5.0
         *
         * @param string $sitemap_url Full URL for the sitemaps index XSL file.
         */
        return apply_filters('wp_sitemaps_stylesheet_index_url', $sitemap_url);
    }
    /**
     * Renders a sitemap index.
     *
     * @since 5.5.0
     *
     * @param array $sitemaps Array of sitemap URLs.
     */
    public function render_index($sitemaps)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("render_index") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php at line 116")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called render_index:116@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php');
        die();
    }
    /**
     * Gets XML for a sitemap index.
     *
     * @since 5.5.0
     *
     * @param array $sitemaps Array of sitemap URLs.
     * @return string|false A well-formed XML string for a sitemap index. False on error.
     */
    public function get_sitemap_index_xml($sitemaps)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_sitemap_index_xml") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php at line 135")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_sitemap_index_xml:135@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php');
        die();
    }
    /**
     * Renders a sitemap.
     *
     * @since 5.5.0
     *
     * @param array $url_list Array of URLs for a sitemap.
     */
    public function render_sitemap($url_list)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("render_sitemap") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php at line 164")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called render_sitemap:164@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php');
        die();
    }
    /**
     * Gets XML for a sitemap.
     *
     * @since 5.5.0
     *
     * @param array $url_list Array of URLs for a sitemap.
     * @return string|false A well-formed XML string for a sitemap index. False on error.
     */
    public function get_sitemap_xml($url_list)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_sitemap_xml") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php at line 183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_sitemap_xml:183@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php');
        die();
    }
    /**
     * Checks for the availability of the SimpleXML extension and errors if missing.
     *
     * @since 5.5.0
     */
    private function check_for_simple_xml_availability()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_for_simple_xml_availability") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php at line 210")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_for_simple_xml_availability:210@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/sitemaps/class-wp-sitemaps-renderer.php');
        die();
    }
}