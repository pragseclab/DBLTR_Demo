<?php

/**
 * Robots template functions.
 *
 * @package WordPress
 * @subpackage Robots
 * @since 5.7.0
 */
/**
 * Displays the robots meta tag as necessary.
 *
 * Gathers robots directives to include for the current context, using the
 * {@see 'wp_robots'} filter. The directives are then sanitized, and the
 * robots meta tag is output if there is at least one relevant directive.
 *
 * @since 5.7.0
 * @since 5.7.1 No longer prevents specific directives to occur together.
 */
function wp_robots()
{
    /**
     * Filters the directives to be included in the 'robots' meta tag.
     *
     * The meta tag will only be included as necessary.
     *
     * @since 5.7.0
     *
     * @param array $robots Associative array of directives. Every key must be the name of the directive, and the
     *                      corresponding value must either be a string to provide as value for the directive or a
     *                      boolean `true` if it is a boolean directive, i.e. without a value.
     */
    $robots = apply_filters('wp_robots', array());
    $robots_strings = array();
    foreach ($robots as $directive => $value) {
        if (is_string($value)) {
            // If a string value, include it as value for the directive.
            $robots_strings[] = "{$directive}:{$value}";
        } elseif ($value) {
            // Otherwise, include the directive if it is truthy.
            $robots_strings[] = $directive;
        }
    }
    if (empty($robots_strings)) {
        return;
    }
    echo "<meta name='robots' content='" . esc_attr(implode(', ', $robots_strings)) . "' />\n";
}
/**
 * Adds noindex to the robots meta tag if required by the site configuration.
 *
 * If a blog is marked as not being public then noindex will be output to
 * tell web robots not to index the page content. Add this to the
 * {@see 'wp_robots'} filter.
 *
 * Typical usage is as a {@see 'wp_robots'} callback:
 *
 *     add_filter( 'wp_robots', 'wp_robots_noindex' );
 *
 * @since 5.7.0
 *
 * @see wp_robots_no_robots()
 *
 * @param array $robots Associative array of robots directives.
 * @return array Filtered robots directives.
 */
function wp_robots_noindex(array $robots)
{
    if (!get_option('blog_public')) {
        return wp_robots_no_robots($robots);
    }
    return $robots;
}
/**
 * Adds noindex to the robots meta tag for embeds.
 *
 * Typical usage is as a {@see 'wp_robots'} callback:
 *
 *     add_filter( 'wp_robots', 'wp_robots_noindex_embeds' );
 *
 * @since 5.7.0
 *
 * @see wp_robots_no_robots()
 *
 * @param array $robots Associative array of robots directives.
 * @return array Filtered robots directives.
 */
function wp_robots_noindex_embeds(array $robots)
{
    if (is_embed()) {
        return wp_robots_no_robots($robots);
    }
    return $robots;
}
/**
 * Adds noindex to the robots meta tag if a search is being performed.
 *
 * If a search is being performed then noindex will be output to
 * tell web robots not to index the page content. Add this to the
 * {@see 'wp_robots'} filter.
 *
 * Typical usage is as a {@see 'wp_robots'} callback:
 *
 *     add_filter( 'wp_robots', 'wp_robots_noindex_search' );
 *
 * @since 5.7.0
 *
 * @see wp_robots_no_robots()
 *
 * @param array $robots Associative array of robots directives.
 * @return array Filtered robots directives.
 */
function wp_robots_noindex_search(array $robots)
{
    if (is_search()) {
        return wp_robots_no_robots($robots);
    }
    return $robots;
}
/**
 * Adds noindex to the robots meta tag.
 *
 * This directive tells web robots not to index the page content.
 *
 * Typical usage is as a {@see 'wp_robots'} callback:
 *
 *     add_filter( 'wp_robots', 'wp_robots_no_robots' );
 *
 * @since 5.7.0
 *
 * @param array $robots Associative array of robots directives.
 * @return array Filtered robots directives.
 */
function wp_robots_no_robots(array $robots)
{
    $robots['noindex'] = true;
    if (get_option('blog_public')) {
        $robots['follow'] = true;
    } else {
        $robots['nofollow'] = true;
    }
    return $robots;
}
/**
 * Adds noindex and noarchive to the robots meta tag.
 *
 * This directive tells web robots not to index or archive the page content and
 * is recommended to be used for sensitive pages.
 *
 * Typical usage is as a {@see 'wp_robots'} callback:
 *
 *     add_filter( 'wp_robots', 'wp_robots_sensitive_page' );
 *
 * @since 5.7.0
 *
 * @param array $robots Associative array of robots directives.
 * @return array Filtered robots directives.
 */
function wp_robots_sensitive_page(array $robots)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_robots_sensitive_page") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/robots-template.php at line 161")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_robots_sensitive_page:161@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/robots-template.php');
    die();
}
/**
 * Adds 'max-image-preview:large' to the robots meta tag.
 *
 * This directive tells web robots that large image previews are allowed to be
 * displayed, e.g. in search engines, unless the blog is marked as not being public.
 *
 * Typical usage is as a {@see 'wp_robots'} callback:
 *
 *     add_filter( 'wp_robots', 'wp_robots_max_image_preview_large' );
 *
 * @since 5.7.0
 *
 * @param array $robots Associative array of robots directives.
 * @return array Filtered robots directives.
 */
function wp_robots_max_image_preview_large(array $robots)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_robots_max_image_preview_large") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/robots-template.php at line 182")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_robots_max_image_preview_large:182@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/robots-template.php');
    die();
}