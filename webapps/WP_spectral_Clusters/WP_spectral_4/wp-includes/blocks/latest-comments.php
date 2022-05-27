<?php

/**
 * Server-side rendering of the `core/latest-comments` block.
 *
 * @package WordPress
 */
/**
 * Get the post title.
 *
 * The post title is fetched and if it is blank then a default string is
 * returned.
 *
 * Copied from `wp-admin/includes/template.php`, but we can't include that
 * file because:
 *
 * 1. It causes bugs with test fixture generation and strange Docker 255 error
 *    codes.
 * 2. It's in the admin; ideally we *shouldn't* be including files from the
 *    admin for a block's output. It's a very small/simple function as well,
 *    so duplicating it isn't too terrible.
 *
 * @since 3.3.0
 *
 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global $post.
 * @return string The post title if set; "(no title)" if no title is set.
 */
function wp_latest_comments_draft_or_post_title($post = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_latest_comments_draft_or_post_title") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-comments.php at line 30")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_latest_comments_draft_or_post_title:30@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-comments.php');
    die();
}
/**
 * Renders the `core/latest-comments` block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest comments added.
 */
function render_block_core_latest_comments($attributes = array())
{
    $comments = get_comments(
        // This filter is documented in wp-includes/widgets/class-wp-widget-recent-comments.php.
        apply_filters('widget_comments_args', array('number' => $attributes['commentsToShow'], 'status' => 'approve', 'post_status' => 'publish'))
    );
    $list_items_markup = '';
    if (!empty($comments)) {
        // Prime the cache for associated posts. This is copied from \WP_Widget_Recent_Comments::widget().
        $post_ids = array_unique(wp_list_pluck($comments, 'comment_post_ID'));
        _prime_post_caches($post_ids, strpos(get_option('permalink_structure'), '%category%'), false);
        foreach ($comments as $comment) {
            $list_items_markup .= '<li class="wp-block-latest-comments__comment">';
            if ($attributes['displayAvatar']) {
                $avatar = get_avatar($comment, 48, '', '', array('class' => 'wp-block-latest-comments__comment-avatar'));
                if ($avatar) {
                    $list_items_markup .= $avatar;
                }
            }
            $list_items_markup .= '<article>';
            $list_items_markup .= '<footer class="wp-block-latest-comments__comment-meta">';
            $author_url = get_comment_author_url($comment);
            if (empty($author_url) && !empty($comment->user_id)) {
                $author_url = get_author_posts_url($comment->user_id);
            }
            $author_markup = '';
            if ($author_url) {
                $author_markup .= '<a class="wp-block-latest-comments__comment-author" href="' . esc_url($author_url) . '">' . get_comment_author($comment) . '</a>';
            } else {
                $author_markup .= '<span class="wp-block-latest-comments__comment-author">' . get_comment_author($comment) . '</span>';
            }
            // `_draft_or_post_title` calls `esc_html()` so we don't need to wrap that call in
            // `esc_html`.
            $post_title = '<a class="wp-block-latest-comments__comment-link" href="' . esc_url(get_comment_link($comment)) . '">' . wp_latest_comments_draft_or_post_title($comment->comment_post_ID) . '</a>';
            $list_items_markup .= sprintf(
                /* translators: 1: author name (inside <a> or <span> tag, based on if they have a URL), 2: post title related to this comment */
                __('%1$s on %2$s'),
                $author_markup,
                $post_title
            );
            if ($attributes['displayDate']) {
                $list_items_markup .= sprintf('<time datetime="%1$s" class="wp-block-latest-comments__comment-date">%2$s</time>', esc_attr(get_comment_date('c', $comment)), date_i18n(get_option('date_format'), get_comment_date('U', $comment)));
            }
            $list_items_markup .= '</footer>';
            if ($attributes['displayExcerpt']) {
                $list_items_markup .= '<div class="wp-block-latest-comments__comment-excerpt">' . wpautop(get_comment_excerpt($comment)) . '</div>';
            }
            $list_items_markup .= '</article></li>';
        }
    }
    $classnames = array();
    if ($attributes['displayAvatar']) {
        $classnames[] = 'has-avatars';
    }
    if ($attributes['displayDate']) {
        $classnames[] = 'has-dates';
    }
    if ($attributes['displayExcerpt']) {
        $classnames[] = 'has-excerpts';
    }
    if (empty($comments)) {
        $classnames[] = 'no-comments';
    }
    $wrapper_attributes = get_block_wrapper_attributes(array('class' => implode(' ', $classnames)));
    return !empty($comments) ? sprintf('<ol %1$s>%2$s</ol>', $wrapper_attributes, $list_items_markup) : sprintf('<div %1$s>%2$s</div>', $wrapper_attributes, __('No comments to show.'));
}
/**
 * Registers the `core/latest-comments` block.
 */
function register_block_core_latest_comments()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_block_core_latest_comments") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-comments.php at line 114")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called register_block_core_latest_comments:114@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/blocks/latest-comments.php');
    die();
}
add_action('init', 'register_block_core_latest_comments');