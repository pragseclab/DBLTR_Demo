<?php

/**
 * Server-side rendering of the `core/latest-posts` block.
 *
 * @package WordPress
 */
/**
 * The excerpt length set by the Latest Posts core block
 * set at render time and used by the block itself.
 *
 * @var int
 */
global $block_core_latest_posts_excerpt_length;
$block_core_latest_posts_excerpt_length = 0;
/**
 * Callback for the excerpt_length filter used by
 * the Latest Posts block at render time.
 *
 * @return int Returns the global $block_core_latest_posts_excerpt_length variable
 *             to allow the excerpt_length filter respect the Latest Block setting.
 */
function block_core_latest_posts_get_excerpt_length()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("block_core_latest_posts_get_excerpt_length") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-posts.php at line 25")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called block_core_latest_posts_get_excerpt_length:25@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-posts.php');
    die();
}
/**
 * Renders the `core/latest-posts` block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
function render_block_core_latest_posts($attributes)
{
    global $post, $block_core_latest_posts_excerpt_length;
    $args = array('posts_per_page' => $attributes['postsToShow'], 'post_status' => 'publish', 'order' => $attributes['order'], 'orderby' => $attributes['orderBy'], 'suppress_filters' => false);
    $block_core_latest_posts_excerpt_length = $attributes['excerptLength'];
    add_filter('excerpt_length', 'block_core_latest_posts_get_excerpt_length', 20);
    if (isset($attributes['categories'])) {
        $args['category__in'] = array_column($attributes['categories'], 'id');
    }
    if (isset($attributes['selectedAuthor'])) {
        $args['author'] = $attributes['selectedAuthor'];
    }
    $recent_posts = get_posts($args);
    $list_items_markup = '';
    foreach ($recent_posts as $post) {
        $post_link = esc_url(get_permalink($post));
        $list_items_markup .= '<li>';
        if ($attributes['displayFeaturedImage'] && has_post_thumbnail($post)) {
            $image_style = '';
            if (isset($attributes['featuredImageSizeWidth'])) {
                $image_style .= sprintf('max-width:%spx;', $attributes['featuredImageSizeWidth']);
            }
            if (isset($attributes['featuredImageSizeHeight'])) {
                $image_style .= sprintf('max-height:%spx;', $attributes['featuredImageSizeHeight']);
            }
            $image_classes = 'wp-block-latest-posts__featured-image';
            if (isset($attributes['featuredImageAlign'])) {
                $image_classes .= ' align' . $attributes['featuredImageAlign'];
            }
            $featured_image = get_the_post_thumbnail($post, $attributes['featuredImageSizeSlug'], array('style' => $image_style));
            if ($attributes['addLinkToFeaturedImage']) {
                $featured_image = sprintf('<a href="%1$s">%2$s</a>', $post_link, $featured_image);
            }
            $list_items_markup .= sprintf('<div class="%1$s">%2$s</div>', $image_classes, $featured_image);
        }
        $title = get_the_title($post);
        if (!$title) {
            $title = __('(no title)');
        }
        $list_items_markup .= sprintf('<a href="%1$s">%2$s</a>', $post_link, $title);
        if (isset($attributes['displayAuthor']) && $attributes['displayAuthor']) {
            $author_display_name = get_the_author_meta('display_name', $post->post_author);
            /* translators: byline. %s: current author. */
            $byline = sprintf(__('by %s'), $author_display_name);
            if (!empty($author_display_name)) {
                $list_items_markup .= sprintf('<div class="wp-block-latest-posts__post-author">%1$s</div>', esc_html($byline));
            }
        }
        if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) {
            $list_items_markup .= sprintf('<time datetime="%1$s" class="wp-block-latest-posts__post-date">%2$s</time>', esc_attr(get_the_date('c', $post)), esc_html(get_the_date('', $post)));
        }
        if (isset($attributes['displayPostContent']) && $attributes['displayPostContent'] && isset($attributes['displayPostContentRadio']) && 'excerpt' === $attributes['displayPostContentRadio']) {
            $trimmed_excerpt = get_the_excerpt($post);
            if (post_password_required($post)) {
                $trimmed_excerpt = __('This content is password protected.');
            }
            $list_items_markup .= sprintf('<div class="wp-block-latest-posts__post-excerpt">%1$s</div>', $trimmed_excerpt);
        }
        if (isset($attributes['displayPostContent']) && $attributes['displayPostContent'] && isset($attributes['displayPostContentRadio']) && 'full_post' === $attributes['displayPostContentRadio']) {
            $post_content = wp_kses_post(html_entity_decode($post->post_content, ENT_QUOTES, get_option('blog_charset')));
            if (post_password_required($post)) {
                $post_content = __('This content is password protected.');
            }
            $list_items_markup .= sprintf('<div class="wp-block-latest-posts__post-full-content">%1$s</div>', $post_content);
        }
        $list_items_markup .= "</li>\n";
    }
    remove_filter('excerpt_length', 'block_core_latest_posts_get_excerpt_length', 20);
    $class = 'wp-block-latest-posts__list';
    if (isset($attributes['postLayout']) && 'grid' === $attributes['postLayout']) {
        $class .= ' is-grid';
    }
    if (isset($attributes['columns']) && 'grid' === $attributes['postLayout']) {
        $class .= ' columns-' . $attributes['columns'];
    }
    if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) {
        $class .= ' has-dates';
    }
    if (isset($attributes['displayAuthor']) && $attributes['displayAuthor']) {
        $class .= ' has-author';
    }
    $wrapper_attributes = get_block_wrapper_attributes(array('class' => $class));
    return sprintf('<ul %1$s>%2$s</ul>', $wrapper_attributes, $list_items_markup);
}
/**
 * Registers the `core/latest-posts` block on server.
 */
function register_block_core_latest_posts()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_block_core_latest_posts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-posts.php at line 124")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called register_block_core_latest_posts:124@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-posts.php');
    die();
}
add_action('init', 'register_block_core_latest_posts');
/**
 * Handles outdated versions of the `core/latest-posts` block by converting
 * attribute `categories` from a numeric string to an array with key `id`.
 *
 * This is done to accommodate the changes introduced in #20781 that sought to
 * add support for multiple categories to the block. However, given that this
 * block is dynamic, the usual provisions for block migration are insufficient,
 * as they only act when a block is loaded in the editor.
 *
 * TODO: Remove when and if the bottom client-side deprecation for this block
 * is removed.
 *
 * @param array $block A single parsed block object.
 *
 * @return array The migrated block object.
 */
function block_core_latest_posts_migrate_categories($block)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("block_core_latest_posts_migrate_categories") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-posts.php at line 145")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called block_core_latest_posts_migrate_categories:145@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-posts.php');
    die();
}
add_filter('render_block_data', 'block_core_latest_posts_migrate_categories');