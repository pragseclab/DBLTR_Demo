<?php

/**
 * Server-side rendering of the `core/rss` block.
 *
 * @package WordPress
 */
/**
 * Renders the `core/rss` block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the block content with received rss items.
 */
function render_block_core_rss($attributes)
{
    $rss = fetch_feed($attributes['feedURL']);
    if (is_wp_error($rss)) {
        return '<div class="components-placeholder"><div class="notice notice-error"><strong>' . __('RSS Error:') . '</strong> ' . $rss->get_error_message() . '</div></div>';
    }
    if (!$rss->get_item_quantity()) {
        return '<div class="components-placeholder"><div class="notice notice-error">' . __('An error has occurred, which probably means the feed is down. Try again later.') . '</div></div>';
    }
    $rss_items = $rss->get_items(0, $attributes['itemsToShow']);
    $list_items = '';
    foreach ($rss_items as $item) {
        $title = esc_html(trim(strip_tags($item->get_title())));
        if (empty($title)) {
            $title = __('(no title)');
        }
        $link = $item->get_link();
        $link = esc_url($link);
        if ($link) {
            $title = "<a href='{$link}'>{$title}</a>";
        }
        $title = "<div class='wp-block-rss__item-title'>{$title}</div>";
        $date = '';
        if ($attributes['displayDate']) {
            $date = $item->get_date('U');
            if ($date) {
                $date = sprintf('<time datetime="%1$s" class="wp-block-rss__item-publish-date">%2$s</time> ', date_i18n(get_option('c'), $date), date_i18n(get_option('date_format'), $date));
            }
        }
        $author = '';
        if ($attributes['displayAuthor']) {
            $author = $item->get_author();
            if (is_object($author)) {
                $author = $author->get_name();
                $author = '<span class="wp-block-rss__item-author">' . sprintf(
                    /* translators: %s: the author. */
                    __('by %s'),
                    esc_html(strip_tags($author))
                ) . '</span>';
            }
        }
        $excerpt = '';
        if ($attributes['displayExcerpt']) {
            $excerpt = html_entity_decode($item->get_description(), ENT_QUOTES, get_option('blog_charset'));
            $excerpt = esc_attr(wp_trim_words($excerpt, $attributes['excerptLength'], ' [&hellip;]'));
            // Change existing [...] to [&hellip;].
            if ('[...]' === substr($excerpt, -5)) {
                $excerpt = substr($excerpt, 0, -5) . '[&hellip;]';
            }
            $excerpt = '<div class="wp-block-rss__item-excerpt">' . esc_html($excerpt) . '</div>';
        }
        $list_items .= "<li class='wp-block-rss__item'>{$title}{$date}{$author}{$excerpt}</li>";
    }
    $classnames = array();
    if (isset($attributes['blockLayout']) && 'grid' === $attributes['blockLayout']) {
        $classnames[] = 'is-grid';
    }
    if (isset($attributes['columns']) && 'grid' === $attributes['blockLayout']) {
        $classnames[] = 'columns-' . $attributes['columns'];
    }
    $wrapper_attributes = get_block_wrapper_attributes(array('class' => implode(' ', $classnames)));
    return sprintf('<ul %s>%s</ul>', $wrapper_attributes, $list_items);
}
/**
 * Registers the `core/rss` block on server.
 */
function register_block_core_rss()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_block_core_rss") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/blocks/rss.php at line 83")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called register_block_core_rss:83@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/blocks/rss.php');
    die();
}
add_action('init', 'register_block_core_rss');