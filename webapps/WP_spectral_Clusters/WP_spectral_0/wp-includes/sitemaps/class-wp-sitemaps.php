<?php

/**
 * Sitemaps: WP_Sitemaps class
 *
 * This is the main class integrating all other classes.
 *
 * @package WordPress
 * @subpackage Sitemaps
 * @since 5.5.0
 */
/**
 * Class WP_Sitemaps.
 *
 * @since 5.5.0
 */
class WP_Sitemaps
{
    /**
     * The main index of supported sitemaps.
     *
     * @since 5.5.0
     *
     * @var WP_Sitemaps_Index
     */
    public $index;
    /**
     * The main registry of supported sitemaps.
     *
     * @since 5.5.0
     *
     * @var WP_Sitemaps_Registry
     */
    public $registry;
    /**
     * An instance of the renderer class.
     *
     * @since 5.5.0
     *
     * @var WP_Sitemaps_Renderer
     */
    public $renderer;
    /**
     * WP_Sitemaps constructor.
     *
     * @since 5.5.0
     */
    public function __construct()
    {
        $this->registry = new WP_Sitemaps_Registry();
        $this->renderer = new WP_Sitemaps_Renderer();
        $this->index = new WP_Sitemaps_Index($this->registry);
    }
    /**
     * Initiates all sitemap functionality.
     *
     * If sitemaps are disabled, only the rewrite rules will be registered
     * by this method, in order to properly send 404s.
     *
     * @since 5.5.0
     */
    public function init()
    {
        // These will all fire on the init hook.
        $this->register_rewrites();
        add_action('template_redirect', array($this, 'render_sitemaps'));
        if (!$this->sitemaps_enabled()) {
            return;
        }
        $this->register_sitemaps();
        // Add additional action callbacks.
        add_filter('pre_handle_404', array($this, 'redirect_sitemapxml'), 10, 2);
        add_filter('robots_txt', array($this, 'add_robots'), 0, 2);
    }
    /**
     * Determines whether sitemaps are enabled or not.
     *
     * @since 5.5.0
     *
     * @return bool Whether sitemaps are enabled.
     */
    public function sitemaps_enabled()
    {
        $is_enabled = (bool) get_option('blog_public');
        /**
         * Filters whether XML Sitemaps are enabled or not.
         *
         * When XML Sitemaps are disabled via this filter, rewrite rules are still
         * in place to ensure a 404 is returned.
         *
         * @see WP_Sitemaps::register_rewrites()
         *
         * @since 5.5.0
         *
         * @param bool $is_enabled Whether XML Sitemaps are enabled or not. Defaults
         * to true for public sites.
         */
        return (bool) apply_filters('wp_sitemaps_enabled', $is_enabled);
    }
    /**
     * Registers and sets up the functionality for all supported sitemaps.
     *
     * @since 5.5.0
     */
    public function register_sitemaps()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_sitemaps") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/sitemaps/class-wp-sitemaps.php at line 107")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called register_sitemaps:107@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/sitemaps/class-wp-sitemaps.php');
        die();
    }
    /**
     * Registers sitemap rewrite tags and routing rules.
     *
     * @since 5.5.0
     */
    public function register_rewrites()
    {
        // Add rewrite tags.
        add_rewrite_tag('%sitemap%', '([^?]+)');
        add_rewrite_tag('%sitemap-subtype%', '([^?]+)');
        // Register index route.
        add_rewrite_rule('^wp-sitemap\\.xml$', 'index.php?sitemap=index', 'top');
        // Register rewrites for the XSL stylesheet.
        add_rewrite_tag('%sitemap-stylesheet%', '([^?]+)');
        add_rewrite_rule('^wp-sitemap\\.xsl$', 'index.php?sitemap-stylesheet=sitemap', 'top');
        add_rewrite_rule('^wp-sitemap-index\\.xsl$', 'index.php?sitemap-stylesheet=index', 'top');
        // Register routes for providers.
        add_rewrite_rule('^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$', 'index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]', 'top');
        add_rewrite_rule('^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$', 'index.php?sitemap=$matches[1]&paged=$matches[2]', 'top');
    }
    /**
     * Renders sitemap templates based on rewrite rules.
     *
     * @since 5.5.0
     *
     * @global WP_Query $wp_query WordPress Query object.
     */
    public function render_sitemaps()
    {
        global $wp_query;
        $sitemap = sanitize_text_field(get_query_var('sitemap'));
        $object_subtype = sanitize_text_field(get_query_var('sitemap-subtype'));
        $stylesheet_type = sanitize_text_field(get_query_var('sitemap-stylesheet'));
        $paged = absint(get_query_var('paged'));
        // Bail early if this isn't a sitemap or stylesheet route.
        if (!($sitemap || $stylesheet_type)) {
            return;
        }
        if (!$this->sitemaps_enabled()) {
            $wp_query->set_404();
            status_header(404);
            return;
        }
        // Render stylesheet if this is stylesheet route.
        if ($stylesheet_type) {
            $stylesheet = new WP_Sitemaps_Stylesheet();
            $stylesheet->render_stylesheet($stylesheet_type);
            exit;
        }
        // Render the index.
        if ('index' === $sitemap) {
            $sitemap_list = $this->index->get_sitemap_list();
            $this->renderer->render_index($sitemap_list);
            exit;
        }
        $provider = $this->registry->get_provider($sitemap);
        if (!$provider) {
            return;
        }
        if (empty($paged)) {
            $paged = 1;
        }
        $url_list = $provider->get_url_list($paged, $object_subtype);
        // Force a 404 and bail early if no URLs are present.
        if (empty($url_list)) {
            $wp_query->set_404();
            status_header(404);
            return;
        }
        $this->renderer->render_sitemap($url_list);
        exit;
    }
    /**
     * Redirects a URL to the wp-sitemap.xml
     *
     * @since 5.5.0
     *
     * @param bool     $bypass Pass-through of the pre_handle_404 filter value.
     * @param WP_Query $query  The WP_Query object.
     * @return bool Bypass value.
     */
    public function redirect_sitemapxml($bypass, $query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("redirect_sitemapxml") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/sitemaps/class-wp-sitemaps.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called redirect_sitemapxml:197@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/sitemaps/class-wp-sitemaps.php');
        die();
    }
    /**
     * Adds the sitemap index to robots.txt.
     *
     * @since 5.5.0
     *
     * @param string $output robots.txt output.
     * @param bool   $public Whether the site is public.
     * @return string The robots.txt output.
     */
    public function add_robots($output, $public)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_robots") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/sitemaps/class-wp-sitemaps.php at line 218")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add_robots:218@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/sitemaps/class-wp-sitemaps.php');
        die();
    }
}