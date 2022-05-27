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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_handler") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called register_handler:105@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php');
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
        $post = get_post();
        if (empty($url) && !empty($attr['src'])) {
            $url = $attr['src'];
        }
        $this->last_url = $url;
        if (empty($url)) {
            $this->last_attr = $attr;
            return '';
        }
        $rawattr = $attr;
        $attr = wp_parse_args($attr, wp_embed_defaults($url));
        $this->last_attr = $attr;
        // KSES converts & into &amp; and we need to undo this.
        // See https://core.trac.wordpress.org/ticket/11311
        $url = str_replace('&amp;', '&', $url);
        // Look for known internal handlers.
        $embed_handler_html = $this->get_embed_handler_html($rawattr, $url);
        if (false !== $embed_handler_html) {
            return $embed_handler_html;
        }
        $post_ID = !empty($post->ID) ? $post->ID : null;
        // Potentially set by WP_Embed::cache_oembed().
        if (!empty($this->post_ID)) {
            $post_ID = $this->post_ID;
        }
        // Check for a cached result (stored as custom post or in the post meta).
        $key_suffix = md5($url . serialize($attr));
        $cachekey = '_oembed_' . $key_suffix;
        $cachekey_time = '_oembed_time_' . $key_suffix;
        /**
         * Filters the oEmbed TTL value (time to live).
         *
         * @since 4.0.0
         *
         * @param int    $time    Time to live (in seconds).
         * @param string $url     The attempted embed URL.
         * @param array  $attr    An array of shortcode attributes.
         * @param int    $post_ID Post ID.
         */
        $ttl = apply_filters('oembed_ttl', DAY_IN_SECONDS, $url, $attr, $post_ID);
        $cache = '';
        $cache_time = 0;
        $cached_post_id = $this->find_oembed_post_id($key_suffix);
        if ($post_ID) {
            $cache = get_post_meta($post_ID, $cachekey, true);
            $cache_time = get_post_meta($post_ID, $cachekey_time, true);
            if (!$cache_time) {
                $cache_time = 0;
            }
        } elseif ($cached_post_id) {
            $cached_post = get_post($cached_post_id);
            $cache = $cached_post->post_content;
            $cache_time = strtotime($cached_post->post_modified_gmt);
        }
        $cached_recently = time() - $cache_time < $ttl;
        if ($this->usecache || $cached_recently) {
            // Failures are cached. Serve one if we're using the cache.
            if ('{{unknown}}' === $cache) {
                return $this->maybe_make_link($url);
            }
            if (!empty($cache)) {
                /**
                 * Filters the cached oEmbed HTML.
                 *
                 * @since 2.9.0
                 *
                 * @see WP_Embed::shortcode()
                 *
                 * @param string|false $cache   The cached HTML result, stored in post meta.
                 * @param string       $url     The attempted embed URL.
                 * @param array        $attr    An array of shortcode attributes.
                 * @param int          $post_ID Post ID.
                 */
                return apply_filters('embed_oembed_html', $cache, $url, $attr, $post_ID);
            }
        }
        /**
         * Filters whether to inspect the given URL for discoverable link tags.
         *
         * @since 2.9.0
         * @since 4.4.0 The default value changed to true.
         *
         * @see WP_oEmbed::discover()
         *
         * @param bool $enable Whether to enable `<link>` tag discovery. Default true.
         */
        $attr['discover'] = apply_filters('embed_oembed_discover', true);
        // Use oEmbed to get the HTML.
        $html = wp_oembed_get($url, $attr);
        if ($post_ID) {
            if ($html) {
                update_post_meta($post_ID, $cachekey, $html);
                update_post_meta($post_ID, $cachekey_time, time());
            } elseif (!$cache) {
                update_post_meta($post_ID, $cachekey, '{{unknown}}');
            }
        } else {
            $has_kses = false !== has_filter('content_save_pre', 'wp_filter_post_kses');
            if ($has_kses) {
                // Prevent KSES from corrupting JSON in post_content.
                kses_remove_filters();
            }
            $insert_post_args = array('post_name' => $key_suffix, 'post_status' => 'publish', 'post_type' => 'oembed_cache');
            if ($html) {
                if ($cached_post_id) {
                    wp_update_post(wp_slash(array('ID' => $cached_post_id, 'post_content' => $html)));
                } else {
                    wp_insert_post(wp_slash(array_merge($insert_post_args, array('post_content' => $html))));
                }
            } elseif (!$cache) {
                wp_insert_post(wp_slash(array_merge($insert_post_args, array('post_content' => '{{unknown}}'))));
            }
            if ($has_kses) {
                kses_init_filters();
            }
        }
        // If there was a result, return it.
        if ($html) {
            /** This filter is documented in wp-includes/class-wp-embed.php */
            return apply_filters('embed_oembed_html', $html, $url, $attr, $post_ID);
        }
        // Still unknown.
        return $this->maybe_make_link($url);
    }
    /**
     * Delete all oEmbed caches. Unused by core as of 4.0.0.
     *
     * @param int $post_ID Post ID to delete the caches for.
     */
    public function delete_oembed_caches($post_ID)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_oembed_caches") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php at line 314")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_oembed_caches:314@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php');
        die();
    }
    /**
     * Triggers a caching of all oEmbed results.
     *
     * @param int $post_ID Post ID to do the caching for.
     */
    public function cache_oembed($post_ID)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("cache_oembed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php at line 331")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called cache_oembed:331@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php');
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
        // Replace line breaks from all HTML elements with placeholders.
        $content = wp_replace_in_html_tags($content, array("\n" => '<!-- wp-line-break -->'));
        if (preg_match('#(^|\\s|>)https?://#i', $content)) {
            // Find URLs on their own line.
            $content = preg_replace_callback('|^(\\s*)(https?://[^\\s<>"]+)(\\s*)$|im', array($this, 'autoembed_callback'), $content);
            // Find URLs in their own paragraph.
            $content = preg_replace_callback('|(<p(?: [^>]*)?>\\s*)(https?://[^\\s<>"]+)(\\s*<\\/p>)|i', array($this, 'autoembed_callback'), $content);
        }
        // Put the line breaks back.
        return str_replace('<!-- wp-line-break -->', "\n", $content);
    }
    /**
     * Callback function for WP_Embed::autoembed().
     *
     * @param array $match A regex match array.
     * @return string The embed HTML on success, otherwise the original URL.
     */
    public function autoembed_callback($match)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("autoembed_callback") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php at line 382")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called autoembed_callback:382@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("maybe_make_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php at line 396")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called maybe_make_link:396@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("find_oembed_post_id") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php at line 420")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called find_oembed_post_id:420@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-embed.php');
        die();
    }
}