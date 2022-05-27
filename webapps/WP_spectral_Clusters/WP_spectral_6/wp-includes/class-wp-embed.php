<?php

/**
 * API for easily embedding rich media such as videos and images into content.
 *
 * @package WordPress
 * @subpackage Embed
 * @since 2.9.0
 */
class WP_Embed
{
    public $handlers = array();
    public $post_ID;
    public $usecache = true;
    public $linkifunknown = true;
    public $last_attr = array();
    public $last_url = '';
    /**
     * When a URL cannot be embedded, return false instead of returning a link
     * or the URL.
     *
     * Bypasses the {@see 'embed_maybe_make_link'} filter.
     *
     * @var bool
     */
    public $return_false_on_fail = false;
    /**
     * Constructor
     */
    public function __construct()
    {
        // Hack to get the [embed] shortcode to run before wpautop().
        add_filter('the_content', array($this, 'run_shortcode'), 8);
        add_filter('widget_text_content', array($this, 'run_shortcode'), 8);
        // Shortcode placeholder for strip_shortcodes().
        add_shortcode('embed', '__return_false');
        // Attempts to embed all URLs in a post.
        add_filter('the_content', array($this, 'autoembed'), 8);
        add_filter('widget_text_content', array($this, 'autoembed'), 8);
        // After a post is saved, cache oEmbed items via Ajax.
        add_action('edit_form_advanced', array($this, 'maybe_run_ajax_cache'));
        add_action('edit_page_form', array($this, 'maybe_run_ajax_cache'));
    }
    /**
     * Process the [embed] shortcode.
     *
     * Since the [embed] shortcode needs to be run earlier than other shortcodes,
     * this function removes all existing shortcodes, registers the [embed] shortcode,
     * calls do_shortcode(), and then re-registers the old shortcodes.
     *
     * @global array $shortcode_tags
     *
     * @param string $content Content to parse
     * @return string Content with shortcode parsed
     */
    public function run_shortcode($content)
    {
        global $shortcode_tags;
        // Back up current registered shortcodes and clear them all out.
        $orig_shortcode_tags = $shortcode_tags;
        remove_all_shortcodes();
        add_shortcode('embed', array($this, 'shortcode'));
        // Do the shortcode (only the [embed] one is registered).
        $content = do_shortcode($content, true);
        // Put the original shortcodes back.
        $shortcode_tags = $orig_shortcode_tags;
        return $content;
    }
    /**
     * If a post/page was saved, then output JavaScript to make
     * an Ajax request that will call WP_Embed::cache_oembed().
     */
    public function maybe_run_ajax_cache()
    {
        $post = get_post();
        if (!$post || empty($_GET['message'])) {
            return;
        }
        ?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$.get("<?php 
        echo admin_url('admin-ajax.php?action=oembed-cache&post=' . $post->ID, 'relative');
        ?>");
	});
</script>
		<?php 
    }
    /**
     * Registers an embed handler.
     *
     * Do not use this function directly, use wp_embed_register_handler() instead.
     *
     * This function should probably also only be used for sites that do not support oEmbed.
     *
     * @param string   $id       An internal ID/name for the handler. Needs to be unique.
     * @param string   $regex    The regex that will be used to see if this handler should be used for a URL.
     * @param callable $callback The callback function that will be called if the regex is matched.
     * @param int      $priority Optional. Used to specify the order in which the registered handlers will be tested.
     *                           Lower numbers correspond with earlier testing, and handlers with the same priority are
     *                           tested in the order in which they were added to the action. Default 10.
     */
    public function register_handler($id, $regex, $callback, $priority = 10)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_handler") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called register_handler:105@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php');
        die();
    }
    /**
     * Unregisters a previously-registered embed handler.
     *
     * Do not use this function directly, use wp_embed_unregister_handler() instead.
     *
     * @param string $id       The handler ID that should be removed.
     * @param int    $priority Optional. The priority of the handler to be removed (default: 10).
     */
    public function unregister_handler($id, $priority = 10)
    {
        unset($this->handlers[$priority][$id]);
    }
    /**
     * Returns embed HTML for a given URL from embed handlers.
     *
     * Attempts to convert a URL into embed HTML by checking the URL
     * against the regex of the registered embed handlers.
     *
     * @since 5.5.0
     *
     * @param array  $attr {
     *     Shortcode attributes. Optional.
     *
     *     @type int $width  Width of the embed in pixels.
     *     @type int $height Height of the embed in pixels.
     * }
     * @param string $url The URL attempting to be embedded.
     * @return string|false The embed HTML on success, false otherwise.
     */
    public function get_embed_handler_html($attr, $url)
    {
        $rawattr = $attr;
        $attr = wp_parse_args($attr, wp_embed_defaults($url));
        ksort($this->handlers);
        foreach ($this->handlers as $priority => $handlers) {
            foreach ($handlers as $id => $handler) {
                if (preg_match($handler['regex'], $url, $matches) && is_callable($handler['callback'])) {
                    $return = call_user_func($handler['callback'], $matches, $attr, $url, $rawattr);
                    if (false !== $return) {
                        /**
                         * Filters the returned embed HTML.
                         *
                         * @since 2.9.0
                         *
                         * @see WP_Embed::shortcode()
                         *
                         * @param string|false $return The HTML result of the shortcode, or false on failure.
                         * @param string       $url    The embed URL.
                         * @param array        $attr   An array of shortcode attributes.
                         */
                        return apply_filters('embed_handler_html', $return, $url, $attr);
                    }
                }
            }
        }
        return false;
    }
    /**
     * The do_shortcode() callback function.
     *
     * Attempts to convert a URL into embed HTML. Starts by checking the URL against the regex of
     * the registered embed handlers. If none of the regex matches and it's enabled, then the URL
     * will be given to the WP_oEmbed class.
     *
     * @param array  $attr {
     *     Shortcode attributes. Optional.
     *
     *     @type int $width  Width of the embed in pixels.
     *     @type int $height Height of the embed in pixels.
     * }
     * @param string $url The URL attempting to be embedded.
     * @return string|false The embed HTML on success, otherwise the original URL.
     *                      `->maybe_make_link()` can return false on failure.
     */
    public function shortcode($attr, $url = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("shortcode") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php at line 183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called shortcode:183@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php');
        die();
    }
    /**
     * Delete all oEmbed caches. Unused by core as of 4.0.0.
     *
     * @param int $post_ID Post ID to delete the caches for.
     */
    public function delete_oembed_caches($post_ID)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_oembed_caches") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php at line 314")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_oembed_caches:314@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php');
        die();
    }
    /**
     * Triggers a caching of all oEmbed results.
     *
     * @param int $post_ID Post ID to do the caching for.
     */
    public function cache_oembed($post_ID)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("cache_oembed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php at line 331")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called cache_oembed:331@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php');
        die();
    }
    /**
     * Passes any unlinked URLs that are on their own line to WP_Embed::shortcode() for potential embedding.
     *
     * @see WP_Embed::autoembed_callback()
     *
     * @param string $content The content to be searched.
     * @return string Potentially modified $content.
     */
    public function autoembed($content)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("autoembed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php at line 364")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called autoembed:364@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php');
        die();
    }
    /**
     * Callback function for WP_Embed::autoembed().
     *
     * @param array $match A regex match array.
     * @return string The embed HTML on success, otherwise the original URL.
     */
    public function autoembed_callback($match)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("autoembed_callback") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php at line 382")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called autoembed_callback:382@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-embed.php');
        die();
    }
    /**
     * Conditionally makes a hyperlink based on an internal class variable.
     *
     * @param string $url URL to potentially be linked.
     * @return string|false Linked URL or the original URL. False if 'return_false_on_fail' is true.
     */
    public function maybe_make_link($url)
    {
        if ($this->return_false_on_fail) {
            return false;
        }
        $output = $this->linkifunknown ? '<a href="' . esc_url($url) . '">' . esc_html($url) . '</a>' : $url;
        /**
         * Filters the returned, maybe-linked embed URL.
         *
         * @since 2.9.0
         *
         * @param string $output The linked or original URL.
         * @param string $url    The original URL.
         */
        return apply_filters('embed_maybe_make_link', $output, $url);
    }
    /**
     * Find the oEmbed cache post ID for a given cache key.
     *
     * @since 4.9.0
     *
     * @param string $cache_key oEmbed cache key.
     * @return int|null Post ID on success, null on failure.
     */
    public function find_oembed_post_id($cache_key)
    {
        $cache_group = 'oembed_cache_post';
        $oembed_post_id = wp_cache_get($cache_key, $cache_group);
        if ($oembed_post_id && 'oembed_cache' === get_post_type($oembed_post_id)) {
            return $oembed_post_id;
        }
        $oembed_post_query = new WP_Query(array('post_type' => 'oembed_cache', 'post_status' => 'publish', 'name' => $cache_key, 'posts_per_page' => 1, 'no_found_rows' => true, 'cache_results' => true, 'update_post_meta_cache' => false, 'update_post_term_cache' => false, 'lazy_load_term_meta' => false));
        if (!empty($oembed_post_query->posts)) {
            // Note: 'fields' => 'ids' is not being used in order to cache the post object as it will be needed.
            $oembed_post_id = $oembed_post_query->posts[0]->ID;
            wp_cache_set($cache_key, $oembed_post_id, $cache_group);
            return $oembed_post_id;
        }
        return null;
    }
}