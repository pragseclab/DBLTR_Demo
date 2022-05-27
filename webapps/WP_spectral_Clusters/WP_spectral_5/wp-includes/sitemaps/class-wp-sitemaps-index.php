<?php

/**
 * Sitemaps: WP_Sitemaps_Index class.
 *
 * Generates the sitemap index.
 *
 * @package WordPress
 * @subpackage Sitemaps
 * @since 5.5.0
 */
/**
 * Class WP_Sitemaps_Index.
 * Builds the sitemap index page that lists the links to all of the sitemaps.
 *
 * @since 5.5.0
 */
class WP_Sitemaps_Index
{
    /**
     * The main registry of supported sitemaps.
     *
     * @since 5.5.0
     * @var WP_Sitemaps_Registry
     */
    protected $registry;
    /**
     * Maximum number of sitemaps to include in an index.
     *
     * @sincee 5.5.0
     *
     * @var int Maximum number of sitemaps.
     */
    private $max_sitemaps = 50000;
    /**
     * WP_Sitemaps_Index constructor.
     *
     * @since 5.5.0
     *
     * @param WP_Sitemaps_Registry $registry Sitemap provider registry.
     */
    public function __construct(WP_Sitemaps_Registry $registry)
    {
        $this->registry = $registry;
    }
    /**
     * Gets a sitemap list for the index.
     *
     * @since 5.5.0
     *
     * @return array[] Array of all sitemaps.
     */
    public function get_sitemap_list()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_sitemap_list") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/sitemaps/class-wp-sitemaps-index.php at line 55")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_sitemap_list:55@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/sitemaps/class-wp-sitemaps-index.php');
        die();
    }
    /**
     * Builds the URL for the sitemap index.
     *
     * @since 5.5.0
     *
     * @global WP_Rewrite $wp_rewrite WordPress rewrite component.
     *
     * @return string The sitemap index URL.
     */
    public function get_index_url()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_index_url") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/sitemaps/class-wp-sitemaps-index.php at line 83")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_index_url:83@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/sitemaps/class-wp-sitemaps-index.php');
        die();
    }
}