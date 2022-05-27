<?php

/**
 * Sitemaps: WP_Sitemaps_Posts class
 *
 * Builds the sitemaps for the 'post' object type.
 *
 * @package WordPress
 * @subpackage Sitemaps
 * @since 5.5.0
 */
/**
 * Posts XML sitemap provider.
 *
 * @since 5.5.0
 */
class WP_Sitemaps_Posts extends WP_Sitemaps_Provider
{
    /**
     * WP_Sitemaps_Posts constructor.
     *
     * @since 5.5.0
     */
    public function __construct()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/sitemaps/providers/class-wp-sitemaps-posts.php at line 26")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:26@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/sitemaps/providers/class-wp-sitemaps-posts.php');
        die();
    }
    /**
     * Returns the public post types, which excludes nav_items and similar types.
     * Attachments are also excluded. This includes custom post types with public = true.
     *
     * @since 5.5.0
     *
     * @return WP_Post_Type[] Array of registered post type objects keyed by their name.
     */
    public function get_object_subtypes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_object_subtypes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/sitemaps/providers/class-wp-sitemaps-posts.php at line 39")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_object_subtypes:39@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/sitemaps/providers/class-wp-sitemaps-posts.php');
        die();
    }
    /**
     * Gets a URL list for a post type sitemap.
     *
     * @since 5.5.0
     *
     * @param int    $page_num  Page of results.
     * @param string $post_type Optional. Post type name. Default empty.
     * @return array Array of URLs for a sitemap.
     */
    public function get_url_list($page_num, $post_type = '')
    {
        // Bail early if the queried post type is not supported.
        $supported_types = $this->get_object_subtypes();
        if (!isset($supported_types[$post_type])) {
            return array();
        }
        /**
         * Filters the posts URL list before it is generated.
         *
         * Passing a non-null value will effectively short-circuit the generation,
         * returning that value instead.
         *
         * @since 5.5.0
         *
         * @param array  $url_list  The URL list. Default null.
         * @param string $post_type Post type name.
         * @param int    $page_num  Page of results.
         */
        $url_list = apply_filters('wp_sitemaps_posts_pre_url_list', null, $post_type, $page_num);
        if (null !== $url_list) {
            return $url_list;
        }
        $args = $this->get_posts_query_args($post_type);
        $args['paged'] = $page_num;
        $query = new WP_Query($args);
        $url_list = array();
        /*
         * Add a URL for the homepage in the pages sitemap.
         * Shows only on the first page if the reading settings are set to display latest posts.
         */
        if ('page' === $post_type && 1 === $page_num && 'posts' === get_option('show_on_front')) {
            // Extract the data needed for home URL to add to the array.
            $sitemap_entry = array('loc' => home_url('/'));
            /**
             * Filters the sitemap entry for the home page when the 'show_on_front' option equals 'posts'.
             *
             * @since 5.5.0
             *
             * @param array $sitemap_entry Sitemap entry for the home page.
             */
            $sitemap_entry = apply_filters('wp_sitemaps_posts_show_on_front_entry', $sitemap_entry);
            $url_list[] = $sitemap_entry;
        }
        foreach ($query->posts as $post) {
            $sitemap_entry = array('loc' => get_permalink($post));
            /**
             * Filters the sitemap entry for an individual post.
             *
             * @since 5.5.0
             *
             * @param array   $sitemap_entry Sitemap entry for the post.
             * @param WP_Post $post          Post object.
             * @param string  $post_type     Name of the post_type.
             */
            $sitemap_entry = apply_filters('wp_sitemaps_posts_entry', $sitemap_entry, $post, $post_type);
            $url_list[] = $sitemap_entry;
        }
        return $url_list;
    }
    /**
     * Gets the max number of pages available for the object type.
     *
     * @since 5.5.0
     *
     * @param string $post_type Optional. Post type name. Default empty.
     * @return int Total number of pages.
     */
    public function get_max_num_pages($post_type = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_max_num_pages") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/sitemaps/providers/class-wp-sitemaps-posts.php at line 130")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_max_num_pages:130@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/sitemaps/providers/class-wp-sitemaps-posts.php');
        die();
    }
    /**
     * Returns the query args for retrieving posts to list in the sitemap.
     *
     * @since 5.5.0
     *
     * @param string $post_type Post type name.
     * @return array Array of WP_Query arguments.
     */
    protected function get_posts_query_args($post_type)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_posts_query_args") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/sitemaps/providers/class-wp-sitemaps-posts.php at line 175")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_posts_query_args:175@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/sitemaps/providers/class-wp-sitemaps-posts.php');
        die();
    }
}