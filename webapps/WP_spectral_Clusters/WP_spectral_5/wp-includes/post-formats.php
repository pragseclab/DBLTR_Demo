<?php

/**
 * Post format functions.
 *
 * @package WordPress
 * @subpackage Post
 */
/**
 * Retrieve the format slug for a post
 *
 * @since 3.1.0
 *
 * @param int|WP_Post|null $post Optional. Post ID or post object. Defaults to the current post in the loop.
 * @return string|false The format if successful. False otherwise.
 */
function get_post_format($post = null)
{
    $post = get_post($post);
    if (!$post) {
        return false;
    }
    if (!post_type_supports($post->post_type, 'post-formats')) {
        return false;
    }
    $_format = get_the_terms($post->ID, 'post_format');
    if (empty($_format)) {
        return false;
    }
    $format = reset($_format);
    return str_replace('post-format-', '', $format->slug);
}
/**
 * Check if a post has any of the given formats, or any format.
 *
 * @since 3.1.0
 *
 * @param string|string[]  $format Optional. The format or formats to check.
 * @param WP_Post|int|null $post   Optional. The post to check. Defaults to the current post in the loop.
 * @return bool True if the post has any of the given formats (or any format, if no format specified),
 *              false otherwise.
 */
function has_post_format($format = array(), $post = null)
{
    $prefixed = array();
    if ($format) {
        foreach ((array) $format as $single) {
            $prefixed[] = 'post-format-' . sanitize_key($single);
        }
    }
    return has_term($prefixed, 'post_format', $post);
}
/**
 * Assign a format to a post
 *
 * @since 3.1.0
 *
 * @param int|object $post   The post for which to assign a format.
 * @param string     $format A format to assign. Use an empty string or array to remove all formats from the post.
 * @return array|WP_Error|false Array of affected term IDs on success. WP_Error on error.
 */
function set_post_format($post, $format)
{
    $post = get_post($post);
    if (!$post) {
        return new WP_Error('invalid_post', __('Invalid post.'));
    }
    if (!empty($format)) {
        $format = sanitize_key($format);
        if ('standard' === $format || !in_array($format, get_post_format_slugs(), true)) {
            $format = '';
        } else {
            $format = 'post-format-' . $format;
        }
    }
    return wp_set_post_terms($post->ID, $format, 'post_format');
}
/**
 * Returns an array of post format slugs to their translated and pretty display versions
 *
 * @since 3.1.0
 *
 * @return string[] Array of post format labels keyed by format slug.
 */
function get_post_format_strings()
{
    $strings = array(
        'standard' => _x('Standard', 'Post format'),
        // Special case. Any value that evals to false will be considered standard.
        'aside' => _x('Aside', 'Post format'),
        'chat' => _x('Chat', 'Post format'),
        'gallery' => _x('Gallery', 'Post format'),
        'link' => _x('Link', 'Post format'),
        'image' => _x('Image', 'Post format'),
        'quote' => _x('Quote', 'Post format'),
        'status' => _x('Status', 'Post format'),
        'video' => _x('Video', 'Post format'),
        'audio' => _x('Audio', 'Post format'),
    );
    return $strings;
}
/**
 * Retrieves the array of post format slugs.
 *
 * @since 3.1.0
 *
 * @return string[] The array of post format slugs as both keys and values.
 */
function get_post_format_slugs()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_post_format_slugs") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php at line 111")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_post_format_slugs:111@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php');
    die();
}
/**
 * Returns a pretty, translated version of a post format slug
 *
 * @since 3.1.0
 *
 * @param string $slug A post format slug.
 * @return string The translated post format name.
 */
function get_post_format_string($slug)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_post_format_string") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php at line 124")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_post_format_string:124@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php');
    die();
}
/**
 * Returns a link to a post format index.
 *
 * @since 3.1.0
 *
 * @param string $format The post format slug.
 * @return string|WP_Error|false The post format term link.
 */
function get_post_format_link($format)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_post_format_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php at line 141")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_post_format_link:141@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php');
    die();
}
/**
 * Filters the request to allow for the format prefix.
 *
 * @access private
 * @since 3.1.0
 *
 * @param array $qvs
 * @return array
 */
function _post_format_request($qvs)
{
    if (!isset($qvs['post_format'])) {
        return $qvs;
    }
    $slugs = get_post_format_slugs();
    if (isset($slugs[$qvs['post_format']])) {
        $qvs['post_format'] = 'post-format-' . $slugs[$qvs['post_format']];
    }
    $tax = get_taxonomy('post_format');
    if (!is_admin()) {
        $qvs['post_type'] = $tax->object_type;
    }
    return $qvs;
}
/**
 * Filters the post format term link to remove the format prefix.
 *
 * @access private
 * @since 3.1.0
 *
 * @global WP_Rewrite $wp_rewrite WordPress rewrite component.
 *
 * @param string  $link
 * @param WP_Term $term
 * @param string  $taxonomy
 * @return string
 */
function _post_format_link($link, $term, $taxonomy)
{
    global $wp_rewrite;
    if ('post_format' !== $taxonomy) {
        return $link;
    }
    if ($wp_rewrite->get_extra_permastruct($taxonomy)) {
        return str_replace("/{$term->slug}", '/' . str_replace('post-format-', '', $term->slug), $link);
    } else {
        $link = remove_query_arg('post_format', $link);
        return add_query_arg('post_format', str_replace('post-format-', '', $term->slug), $link);
    }
}
/**
 * Remove the post format prefix from the name property of the term object created by get_term().
 *
 * @access private
 * @since 3.1.0
 *
 * @param object $term
 * @return object
 */
function _post_format_get_term($term)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_post_format_get_term") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php at line 208")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _post_format_get_term:208@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php');
    die();
}
/**
 * Remove the post format prefix from the name property of the term objects created by get_terms().
 *
 * @access private
 * @since 3.1.0
 *
 * @param array        $terms
 * @param string|array $taxonomies
 * @param array        $args
 * @return array
 */
function _post_format_get_terms($terms, $taxonomies, $args)
{
    if (in_array('post_format', (array) $taxonomies, true)) {
        if (isset($args['fields']) && 'names' === $args['fields']) {
            foreach ($terms as $order => $name) {
                $terms[$order] = get_post_format_string(str_replace('post-format-', '', $name));
            }
        } else {
            foreach ((array) $terms as $order => $term) {
                if (isset($term->taxonomy) && 'post_format' === $term->taxonomy) {
                    $terms[$order]->name = get_post_format_string(str_replace('post-format-', '', $term->slug));
                }
            }
        }
    }
    return $terms;
}
/**
 * Remove the post format prefix from the name property of the term objects created by wp_get_object_terms().
 *
 * @access private
 * @since 3.1.0
 *
 * @param array $terms
 * @return array
 */
function _post_format_wp_get_object_terms($terms)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_post_format_wp_get_object_terms") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php at line 252")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _post_format_wp_get_object_terms:252@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/post-formats.php');
    die();
}