<?php

/**
 * Administration API: Core Ajax handlers
 *
 * @package WordPress
 * @subpackage Administration
 * @since 2.1.0
 */
//
// No-privilege Ajax handlers.
//
/**
 * Ajax handler for the Heartbeat API in the no-privilege context.
 *
 * Runs when the user is not logged in.
 *
 * @since 3.6.0
 */
function wp_ajax_nopriv_heartbeat()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_nopriv_heartbeat") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 22")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_nopriv_heartbeat:22@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
//
// GET-based Ajax handlers.
//
/**
 * Ajax handler for fetching a list table.
 *
 * @since 3.1.0
 */
function wp_ajax_fetch_list()
{
    $list_class = $_GET['list_args']['class'];
    check_ajax_referer("fetch-list-{$list_class}", '_ajax_fetch_list_nonce');
    $wp_list_table = _get_list_table($list_class, array('screen' => $_GET['list_args']['screen']['id']));
    if (!$wp_list_table) {
        wp_die(0);
    }
    if (!$wp_list_table->ajax_user_can()) {
        wp_die(-1);
    }
    $wp_list_table->ajax_response();
    wp_die(0);
}
/**
 * Ajax handler for tag search.
 *
 * @since 3.1.0
 */
function wp_ajax_ajax_tag_search()
{
    if (!isset($_GET['tax'])) {
        wp_die(0);
    }
    $taxonomy = sanitize_key($_GET['tax']);
    $tax = get_taxonomy($taxonomy);
    if (!$tax) {
        wp_die(0);
    }
    if (!current_user_can($tax->cap->assign_terms)) {
        wp_die(-1);
    }
    $s = wp_unslash($_GET['q']);
    $comma = _x(',', 'tag delimiter');
    if (',' !== $comma) {
        $s = str_replace($comma, ',', $s);
    }
    if (false !== strpos($s, ',')) {
        $s = explode(',', $s);
        $s = $s[count($s) - 1];
    }
    $s = trim($s);
    /**
     * Filters the minimum number of characters required to fire a tag search via Ajax.
     *
     * @since 4.0.0
     *
     * @param int         $characters The minimum number of characters required. Default 2.
     * @param WP_Taxonomy $tax        The taxonomy object.
     * @param string      $s          The search term.
     */
    $term_search_min_chars = (int) apply_filters('term_search_min_chars', 2, $tax, $s);
    /*
     * Require $term_search_min_chars chars for matching (default: 2)
     * ensure it's a non-negative, non-zero integer.
     */
    if (0 == $term_search_min_chars || strlen($s) < $term_search_min_chars) {
        wp_die();
    }
    $results = get_terms(array('taxonomy' => $taxonomy, 'name__like' => $s, 'fields' => 'names', 'hide_empty' => false));
    echo implode("\n", $results);
    wp_die();
}
/**
 * Ajax handler for compression testing.
 *
 * @since 3.1.0
 */
function wp_ajax_wp_compression_test()
{
    if (!current_user_can('manage_options')) {
        wp_die(-1);
    }
    if (ini_get('zlib.output_compression') || 'ob_gzhandler' === ini_get('output_handler')) {
        update_site_option('can_compress_scripts', 0);
        wp_die(0);
    }
    if (isset($_GET['test'])) {
        header('Expires: Wed, 11 Jan 1984 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Content-Type: application/javascript; charset=UTF-8');
        $force_gzip = defined('ENFORCE_GZIP') && ENFORCE_GZIP;
        $test_str = '"wpCompressionTest Lorem ipsum dolor sit amet consectetuer mollis sapien urna ut a. Eu nonummy condimentum fringilla tempor pretium platea vel nibh netus Maecenas. Hac molestie amet justo quis pellentesque est ultrices interdum nibh Morbi. Cras mattis pretium Phasellus ante ipsum ipsum ut sociis Suspendisse Lorem. Ante et non molestie. Porta urna Vestibulum egestas id congue nibh eu risus gravida sit. Ac augue auctor Ut et non a elit massa id sodales. Elit eu Nulla at nibh adipiscing mattis lacus mauris at tempus. Netus nibh quis suscipit nec feugiat eget sed lorem et urna. Pellentesque lacus at ut massa consectetuer ligula ut auctor semper Pellentesque. Ut metus massa nibh quam Curabitur molestie nec mauris congue. Volutpat molestie elit justo facilisis neque ac risus Ut nascetur tristique. Vitae sit lorem tellus et quis Phasellus lacus tincidunt nunc Fusce. Pharetra wisi Suspendisse mus sagittis libero lacinia Integer consequat ac Phasellus. Et urna ac cursus tortor aliquam Aliquam amet tellus volutpat Vestibulum. Justo interdum condimentum In augue congue tellus sollicitudin Quisque quis nibh."';
        if (1 == $_GET['test']) {
            echo $test_str;
            wp_die();
        } elseif (2 == $_GET['test']) {
            if (!isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
                wp_die(-1);
            }
            if (false !== stripos($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate') && function_exists('gzdeflate') && !$force_gzip) {
                header('Content-Encoding: deflate');
                $out = gzdeflate($test_str, 1);
            } elseif (false !== stripos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && function_exists('gzencode')) {
                header('Content-Encoding: gzip');
                $out = gzencode($test_str, 1);
            } else {
                wp_die(-1);
            }
            echo $out;
            wp_die();
        } elseif ('no' === $_GET['test']) {
            check_ajax_referer('update_can_compress_scripts');
            update_site_option('can_compress_scripts', 0);
        } elseif ('yes' === $_GET['test']) {
            check_ajax_referer('update_can_compress_scripts');
            update_site_option('can_compress_scripts', 1);
        }
    }
    wp_die(0);
}
/**
 * Ajax handler for image editor previews.
 *
 * @since 3.1.0
 */
function wp_ajax_imgedit_preview()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_imgedit_preview") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 193")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_imgedit_preview:193@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for oEmbed caching.
 *
 * @since 3.1.0
 *
 * @global WP_Embed $wp_embed
 */
function wp_ajax_oembed_cache()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_oembed_cache") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 213")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_oembed_cache:213@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for user autocomplete.
 *
 * @since 3.4.0
 */
function wp_ajax_autocomplete_user()
{
    if (!is_multisite() || !current_user_can('promote_users') || wp_is_large_network('users')) {
        wp_die(-1);
    }
    /** This filter is documented in wp-admin/user-new.php */
    if (!current_user_can('manage_network_users') && !apply_filters('autocomplete_users_for_site_admins', false)) {
        wp_die(-1);
    }
    $return = array();
    // Check the type of request.
    // Current allowed values are `add` and `search`.
    if (isset($_REQUEST['autocomplete_type']) && 'search' === $_REQUEST['autocomplete_type']) {
        $type = $_REQUEST['autocomplete_type'];
    } else {
        $type = 'add';
    }
    // Check the desired field for value.
    // Current allowed values are `user_email` and `user_login`.
    if (isset($_REQUEST['autocomplete_field']) && 'user_email' === $_REQUEST['autocomplete_field']) {
        $field = $_REQUEST['autocomplete_field'];
    } else {
        $field = 'user_login';
    }
    // Exclude current users of this blog.
    if (isset($_REQUEST['site_id'])) {
        $id = absint($_REQUEST['site_id']);
    } else {
        $id = get_current_blog_id();
    }
    $include_blog_users = 'search' === $type ? get_users(array('blog_id' => $id, 'fields' => 'ID')) : array();
    $exclude_blog_users = 'add' === $type ? get_users(array('blog_id' => $id, 'fields' => 'ID')) : array();
    $users = get_users(array('blog_id' => false, 'search' => '*' . $_REQUEST['term'] . '*', 'include' => $include_blog_users, 'exclude' => $exclude_blog_users, 'search_columns' => array('user_login', 'user_nicename', 'user_email')));
    foreach ($users as $user) {
        $return[] = array(
            /* translators: 1: User login, 2: User email address. */
            'label' => sprintf(_x('%1$s (%2$s)', 'user autocomplete result'), $user->user_login, $user->user_email),
            'value' => $user->{$field},
        );
    }
    wp_die(wp_json_encode($return));
}
/**
 * Handles Ajax requests for community events
 *
 * @since 4.8.0
 */
function wp_ajax_get_community_events()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_get_community_events") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 270")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_get_community_events:270@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for dashboard widgets.
 *
 * @since 3.4.0
 */
function wp_ajax_dashboard_widgets()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_dashboard_widgets") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 313")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_dashboard_widgets:313@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for Customizer preview logged-in status.
 *
 * @since 3.4.0
 */
function wp_ajax_logged_in()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_logged_in") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 332")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_logged_in:332@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
//
// Ajax helpers.
//
/**
 * Sends back current comment total and new page links if they need to be updated.
 *
 * Contrary to normal success Ajax response ("1"), die with time() on success.
 *
 * @since 2.7.0
 * @access private
 *
 * @param int $comment_id
 * @param int $delta
 */
function _wp_ajax_delete_comment_response($comment_id, $delta = -1)
{
    $total = isset($_POST['_total']) ? (int) $_POST['_total'] : 0;
    $per_page = isset($_POST['_per_page']) ? (int) $_POST['_per_page'] : 0;
    $page = isset($_POST['_page']) ? (int) $_POST['_page'] : 0;
    $url = isset($_POST['_url']) ? esc_url_raw($_POST['_url']) : '';
    // JS didn't send us everything we need to know. Just die with success message.
    if (!$total || !$per_page || !$page || !$url) {
        $time = time();
        $comment = get_comment($comment_id);
        $comment_status = '';
        $comment_link = '';
        if ($comment) {
            $comment_status = $comment->comment_approved;
        }
        if (1 === (int) $comment_status) {
            $comment_link = get_comment_link($comment);
        }
        $counts = wp_count_comments();
        $x = new WP_Ajax_Response(array(
            'what' => 'comment',
            // Here for completeness - not used.
            'id' => $comment_id,
            'supplemental' => array('status' => $comment_status, 'postId' => $comment ? $comment->comment_post_ID : '', 'time' => $time, 'in_moderation' => $counts->moderated, 'i18n_comments_text' => sprintf(
                /* translators: %s: Number of comments. */
                _n('%s Comment', '%s Comments', $counts->approved),
                number_format_i18n($counts->approved)
            ), 'i18n_moderation_text' => sprintf(
                /* translators: %s: Number of comments. */
                _n('%s Comment in moderation', '%s Comments in moderation', $counts->moderated),
                number_format_i18n($counts->moderated)
            ), 'comment_link' => $comment_link),
        ));
        $x->send();
    }
    $total += $delta;
    if ($total < 0) {
        $total = 0;
    }
    // Only do the expensive stuff on a page-break, and about 1 other time per page.
    if (0 == $total % $per_page || 1 == mt_rand(1, $per_page)) {
        $post_id = 0;
        // What type of comment count are we looking for?
        $status = 'all';
        $parsed = parse_url($url);
        if (isset($parsed['query'])) {
            parse_str($parsed['query'], $query_vars);
            if (!empty($query_vars['comment_status'])) {
                $status = $query_vars['comment_status'];
            }
            if (!empty($query_vars['p'])) {
                $post_id = (int) $query_vars['p'];
            }
            if (!empty($query_vars['comment_type'])) {
                $type = $query_vars['comment_type'];
            }
        }
        if (empty($type)) {
            // Only use the comment count if not filtering by a comment_type.
            $comment_count = wp_count_comments($post_id);
            // We're looking for a known type of comment count.
            if (isset($comment_count->{$status})) {
                $total = $comment_count->{$status};
            }
        }
        // Else use the decremented value from above.
    }
    // The time since the last comment count.
    $time = time();
    $comment = get_comment($comment_id);
    $counts = wp_count_comments();
    $x = new WP_Ajax_Response(array('what' => 'comment', 'id' => $comment_id, 'supplemental' => array(
        'status' => $comment ? $comment->comment_approved : '',
        'postId' => $comment ? $comment->comment_post_ID : '',
        /* translators: %s: Number of comments. */
        'total_items_i18n' => sprintf(_n('%s item', '%s items', $total), number_format_i18n($total)),
        'total_pages' => ceil($total / $per_page),
        'total_pages_i18n' => number_format_i18n(ceil($total / $per_page)),
        'total' => $total,
        'time' => $time,
        'in_moderation' => $counts->moderated,
        'i18n_moderation_text' => sprintf(
            /* translators: %s: Number of comments. */
            _n('%s Comment in moderation', '%s Comments in moderation', $counts->moderated),
            number_format_i18n($counts->moderated)
        ),
    )));
    $x->send();
}
//
// POST-based Ajax handlers.
//
/**
 * Ajax handler for adding a hierarchical term.
 *
 * @since 3.1.0
 * @access private
 */
function _wp_ajax_add_hierarchical_term()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_wp_ajax_add_hierarchical_term") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 448")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _wp_ajax_add_hierarchical_term:448@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for deleting a comment.
 *
 * @since 3.1.0
 */
function wp_ajax_delete_comment()
{
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $comment = get_comment($id);
    if (!$comment) {
        wp_die(time());
    }
    if (!current_user_can('edit_comment', $comment->comment_ID)) {
        wp_die(-1);
    }
    check_ajax_referer("delete-comment_{$id}");
    $status = wp_get_comment_status($comment);
    $delta = -1;
    if (isset($_POST['trash']) && 1 == $_POST['trash']) {
        if ('trash' === $status) {
            wp_die(time());
        }
        $r = wp_trash_comment($comment);
    } elseif (isset($_POST['untrash']) && 1 == $_POST['untrash']) {
        if ('trash' !== $status) {
            wp_die(time());
        }
        $r = wp_untrash_comment($comment);
        // Undo trash, not in Trash.
        if (!isset($_POST['comment_status']) || 'trash' !== $_POST['comment_status']) {
            $delta = 1;
        }
    } elseif (isset($_POST['spam']) && 1 == $_POST['spam']) {
        if ('spam' === $status) {
            wp_die(time());
        }
        $r = wp_spam_comment($comment);
    } elseif (isset($_POST['unspam']) && 1 == $_POST['unspam']) {
        if ('spam' !== $status) {
            wp_die(time());
        }
        $r = wp_unspam_comment($comment);
        // Undo spam, not in spam.
        if (!isset($_POST['comment_status']) || 'spam' !== $_POST['comment_status']) {
            $delta = 1;
        }
    } elseif (isset($_POST['delete']) && 1 == $_POST['delete']) {
        $r = wp_delete_comment($comment);
    } else {
        wp_die(-1);
    }
    if ($r) {
        // Decide if we need to send back '1' or a more complicated response including page links and comment counts.
        _wp_ajax_delete_comment_response($comment->comment_ID, $delta);
    }
    wp_die(0);
}
/**
 * Ajax handler for deleting a tag.
 *
 * @since 3.1.0
 */
function wp_ajax_delete_tag()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_delete_tag") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 576")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_delete_tag:576@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for deleting a link.
 *
 * @since 3.1.0
 */
function wp_ajax_delete_link()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_delete_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 599")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_delete_link:599@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for deleting meta.
 *
 * @since 3.1.0
 */
function wp_ajax_delete_meta()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_delete_meta") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 621")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_delete_meta:621@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for deleting a post.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function wp_ajax_delete_post($action)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_delete_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 644")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_delete_post:644@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for sending a post to the Trash.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function wp_ajax_trash_post($action)
{
    if (empty($action)) {
        $action = 'trash-post';
    }
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    check_ajax_referer("{$action}_{$id}");
    if (!current_user_can('delete_post', $id)) {
        wp_die(-1);
    }
    if (!get_post($id)) {
        wp_die(1);
    }
    if ('trash-post' === $action) {
        $done = wp_trash_post($id);
    } else {
        $done = wp_untrash_post($id);
    }
    if ($done) {
        wp_die(1);
    }
    wp_die(0);
}
/**
 * Ajax handler to restore a post from the Trash.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function wp_ajax_untrash_post($action)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_untrash_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 700")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_untrash_post:700@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler to delete a page.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function wp_ajax_delete_page($action)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_delete_page") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 714")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_delete_page:714@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler to dim a comment.
 *
 * @since 3.1.0
 */
function wp_ajax_dim_comment()
{
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $comment = get_comment($id);
    if (!$comment) {
        $x = new WP_Ajax_Response(array('what' => 'comment', 'id' => new WP_Error(
            'invalid_comment',
            /* translators: %d: Comment ID. */
            sprintf(__('Comment %d does not exist'), $id)
        )));
        $x->send();
    }
    if (!current_user_can('edit_comment', $comment->comment_ID) && !current_user_can('moderate_comments')) {
        wp_die(-1);
    }
    $current = wp_get_comment_status($comment);
    if (isset($_POST['new']) && $_POST['new'] == $current) {
        wp_die(time());
    }
    check_ajax_referer("approve-comment_{$id}");
    if (in_array($current, array('unapproved', 'spam'), true)) {
        $result = wp_set_comment_status($comment, 'approve', true);
    } else {
        $result = wp_set_comment_status($comment, 'hold', true);
    }
    if (is_wp_error($result)) {
        $x = new WP_Ajax_Response(array('what' => 'comment', 'id' => $result));
        $x->send();
    }
    // Decide if we need to send back '1' or a more complicated response including page links and comment counts.
    _wp_ajax_delete_comment_response($comment->comment_ID);
    wp_die(0);
}
/**
 * Ajax handler for adding a link category.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function wp_ajax_add_link_category($action)
{
    if (empty($action)) {
        $action = 'add-link-category';
    }
    check_ajax_referer($action);
    $tax = get_taxonomy('link_category');
    if (!current_user_can($tax->cap->manage_terms)) {
        wp_die(-1);
    }
    $names = explode(',', wp_unslash($_POST['newcat']));
    $x = new WP_Ajax_Response();
    foreach ($names as $cat_name) {
        $cat_name = trim($cat_name);
        $slug = sanitize_title($cat_name);
        if ('' === $slug) {
            continue;
        }
        $cat_id = wp_insert_term($cat_name, 'link_category');
        if (!$cat_id || is_wp_error($cat_id)) {
            continue;
        } else {
            $cat_id = $cat_id['term_id'];
        }
        $cat_name = esc_html($cat_name);
        $x->add(array('what' => 'link-category', 'id' => $cat_id, 'data' => "<li id='link-category-{$cat_id}'><label for='in-link-category-{$cat_id}' class='selectit'><input value='" . esc_attr($cat_id) . "' type='checkbox' checked='checked' name='link_category[]' id='in-link-category-{$cat_id}'/> {$cat_name}</label></li>", 'position' => -1));
    }
    $x->send();
}
/**
 * Ajax handler to add a tag.
 *
 * @since 3.1.0
 */
function wp_ajax_add_tag()
{
    check_ajax_referer('add-tag', '_wpnonce_add-tag');
    $taxonomy = !empty($_POST['taxonomy']) ? $_POST['taxonomy'] : 'post_tag';
    $tax = get_taxonomy($taxonomy);
    if (!current_user_can($tax->cap->edit_terms)) {
        wp_die(-1);
    }
    $x = new WP_Ajax_Response();
    $tag = wp_insert_term($_POST['tag-name'], $taxonomy, $_POST);
    if ($tag && !is_wp_error($tag)) {
        $tag = get_term($tag['term_id'], $taxonomy);
    }
    if (!$tag || is_wp_error($tag)) {
        $message = __('An error has occurred. Please reload the page and try again.');
        if (is_wp_error($tag) && $tag->get_error_message()) {
            $message = $tag->get_error_message();
        }
        $x->add(array('what' => 'taxonomy', 'data' => new WP_Error('error', $message)));
        $x->send();
    }
    $wp_list_table = _get_list_table('WP_Terms_List_Table', array('screen' => $_POST['screen']));
    $level = 0;
    $noparents = '';
    if (is_taxonomy_hierarchical($taxonomy)) {
        $level = count(get_ancestors($tag->term_id, $taxonomy, 'taxonomy'));
        ob_start();
        $wp_list_table->single_row($tag, $level);
        $noparents = ob_get_clean();
    }
    ob_start();
    $wp_list_table->single_row($tag);
    $parents = ob_get_clean();
    $x->add(array('what' => 'taxonomy', 'supplemental' => compact('parents', 'noparents')));
    $x->add(array('what' => 'term', 'position' => $level, 'supplemental' => (array) $tag));
    $x->send();
}
/**
 * Ajax handler for getting a tagcloud.
 *
 * @since 3.1.0
 */
function wp_ajax_get_tagcloud()
{
    if (!isset($_POST['tax'])) {
        wp_die(0);
    }
    $taxonomy = sanitize_key($_POST['tax']);
    $tax = get_taxonomy($taxonomy);
    if (!$tax) {
        wp_die(0);
    }
    if (!current_user_can($tax->cap->assign_terms)) {
        wp_die(-1);
    }
    $tags = get_terms(array('taxonomy' => $taxonomy, 'number' => 45, 'orderby' => 'count', 'order' => 'DESC'));
    if (empty($tags)) {
        wp_die($tax->labels->not_found);
    }
    if (is_wp_error($tags)) {
        wp_die($tags->get_error_message());
    }
    foreach ($tags as $key => $tag) {
        $tags[$key]->link = '#';
        $tags[$key]->id = $tag->term_id;
    }
    // We need raw tag names here, so don't filter the output.
    $return = wp_generate_tag_cloud($tags, array('filter' => 0, 'format' => 'list'));
    if (empty($return)) {
        wp_die(0);
    }
    echo $return;
    wp_die();
}
/**
 * Ajax handler for getting comments.
 *
 * @since 3.1.0
 *
 * @global int $post_id
 *
 * @param string $action Action to perform.
 */
function wp_ajax_get_comments($action)
{
    global $post_id;
    if (empty($action)) {
        $action = 'get-comments';
    }
    check_ajax_referer($action);
    if (empty($post_id) && !empty($_REQUEST['p'])) {
        $id = absint($_REQUEST['p']);
        if (!empty($id)) {
            $post_id = $id;
        }
    }
    if (empty($post_id)) {
        wp_die(-1);
    }
    $wp_list_table = _get_list_table('WP_Post_Comments_List_Table', array('screen' => 'edit-comments'));
    if (!current_user_can('edit_post', $post_id)) {
        wp_die(-1);
    }
    $wp_list_table->prepare_items();
    if (!$wp_list_table->has_items()) {
        wp_die(1);
    }
    $x = new WP_Ajax_Response();
    ob_start();
    foreach ($wp_list_table->items as $comment) {
        if (!current_user_can('edit_comment', $comment->comment_ID) && 0 === $comment->comment_approved) {
            continue;
        }
        get_comment($comment);
        $wp_list_table->single_row($comment);
    }
    $comment_list_item = ob_get_clean();
    $x->add(array('what' => 'comments', 'data' => $comment_list_item));
    $x->send();
}
/**
 * Ajax handler for replying to a comment.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function wp_ajax_replyto_comment($action)
{
    if (empty($action)) {
        $action = 'replyto-comment';
    }
    check_ajax_referer($action, '_ajax_nonce-replyto-comment');
    $comment_post_ID = (int) $_POST['comment_post_ID'];
    $post = get_post($comment_post_ID);
    if (!$post) {
        wp_die(-1);
    }
    if (!current_user_can('edit_post', $comment_post_ID)) {
        wp_die(-1);
    }
    if (empty($post->post_status)) {
        wp_die(1);
    } elseif (in_array($post->post_status, array('draft', 'pending', 'trash'), true)) {
        wp_die(__('Error: You can&#8217;t reply to a comment on a draft post.'));
    }
    $user = wp_get_current_user();
    if ($user->exists()) {
        $user_ID = $user->ID;
        $comment_author = wp_slash($user->display_name);
        $comment_author_email = wp_slash($user->user_email);
        $comment_author_url = wp_slash($user->user_url);
        $comment_content = trim($_POST['content']);
        $comment_type = isset($_POST['comment_type']) ? trim($_POST['comment_type']) : 'comment';
        if (current_user_can('unfiltered_html')) {
            if (!isset($_POST['_wp_unfiltered_html_comment'])) {
                $_POST['_wp_unfiltered_html_comment'] = '';
            }
            if (wp_create_nonce('unfiltered-html-comment') != $_POST['_wp_unfiltered_html_comment']) {
                kses_remove_filters();
                // Start with a clean slate.
                kses_init_filters();
                // Set up the filters.
                remove_filter('pre_comment_content', 'wp_filter_post_kses');
                add_filter('pre_comment_content', 'wp_filter_kses');
            }
        }
    } else {
        wp_die(__('Sorry, you must be logged in to reply to a comment.'));
    }
    if ('' === $comment_content) {
        wp_die(__('Error: Please type your comment text.'));
    }
    $comment_parent = 0;
    if (isset($_POST['comment_ID'])) {
        $comment_parent = absint($_POST['comment_ID']);
    }
    $comment_auto_approved = false;
    $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
    // Automatically approve parent comment.
    if (!empty($_POST['approve_parent'])) {
        $parent = get_comment($comment_parent);
        if ($parent && '0' === $parent->comment_approved && $parent->comment_post_ID == $comment_post_ID) {
            if (!current_user_can('edit_comment', $parent->comment_ID)) {
                wp_die(-1);
            }
            if (wp_set_comment_status($parent, 'approve')) {
                $comment_auto_approved = true;
            }
        }
    }
    $comment_id = wp_new_comment($commentdata);
    if (is_wp_error($comment_id)) {
        wp_die($comment_id->get_error_message());
    }
    $comment = get_comment($comment_id);
    if (!$comment) {
        wp_die(1);
    }
    $position = isset($_POST['position']) && (int) $_POST['position'] ? (int) $_POST['position'] : '-1';
    ob_start();
    if (isset($_REQUEST['mode']) && 'dashboard' === $_REQUEST['mode']) {
        require_once ABSPATH . 'wp-admin/includes/dashboard.php';
        _wp_dashboard_recent_comments_row($comment);
    } else {
        if (isset($_REQUEST['mode']) && 'single' === $_REQUEST['mode']) {
            $wp_list_table = _get_list_table('WP_Post_Comments_List_Table', array('screen' => 'edit-comments'));
        } else {
            $wp_list_table = _get_list_table('WP_Comments_List_Table', array('screen' => 'edit-comments'));
        }
        $wp_list_table->single_row($comment);
    }
    $comment_list_item = ob_get_clean();
    $response = array('what' => 'comment', 'id' => $comment->comment_ID, 'data' => $comment_list_item, 'position' => $position);
    $counts = wp_count_comments();
    $response['supplemental'] = array('in_moderation' => $counts->moderated, 'i18n_comments_text' => sprintf(
        /* translators: %s: Number of comments. */
        _n('%s Comment', '%s Comments', $counts->approved),
        number_format_i18n($counts->approved)
    ), 'i18n_moderation_text' => sprintf(
        /* translators: %s: Number of comments. */
        _n('%s Comment in moderation', '%s Comments in moderation', $counts->moderated),
        number_format_i18n($counts->moderated)
    ));
    if ($comment_auto_approved) {
        $response['supplemental']['parent_approved'] = $parent->comment_ID;
        $response['supplemental']['parent_post_id'] = $parent->comment_post_ID;
    }
    $x = new WP_Ajax_Response();
    $x->add($response);
    $x->send();
}
/**
 * Ajax handler for editing a comment.
 *
 * @since 3.1.0
 */
function wp_ajax_edit_comment()
{
    check_ajax_referer('replyto-comment', '_ajax_nonce-replyto-comment');
    $comment_id = (int) $_POST['comment_ID'];
    if (!current_user_can('edit_comment', $comment_id)) {
        wp_die(-1);
    }
    if ('' === $_POST['content']) {
        wp_die(__('Error: Please type your comment text.'));
    }
    if (isset($_POST['status'])) {
        $_POST['comment_status'] = $_POST['status'];
    }
    $updated = edit_comment();
    if (is_wp_error($updated)) {
        wp_die($updated->get_error_message());
    }
    $position = isset($_POST['position']) && (int) $_POST['position'] ? (int) $_POST['position'] : '-1';
    $checkbox = isset($_POST['checkbox']) && true == $_POST['checkbox'] ? 1 : 0;
    $wp_list_table = _get_list_table($checkbox ? 'WP_Comments_List_Table' : 'WP_Post_Comments_List_Table', array('screen' => 'edit-comments'));
    $comment = get_comment($comment_id);
    if (empty($comment->comment_ID)) {
        wp_die(-1);
    }
    ob_start();
    $wp_list_table->single_row($comment);
    $comment_list_item = ob_get_clean();
    $x = new WP_Ajax_Response();
    $x->add(array('what' => 'edit_comment', 'id' => $comment->comment_ID, 'data' => $comment_list_item, 'position' => $position));
    $x->send();
}
/**
 * Ajax handler for adding a menu item.
 *
 * @since 3.1.0
 */
function wp_ajax_add_menu_item()
{
    check_ajax_referer('add-menu_item', 'menu-settings-column-nonce');
    if (!current_user_can('edit_theme_options')) {
        wp_die(-1);
    }
    require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
    // For performance reasons, we omit some object properties from the checklist.
    // The following is a hacky way to restore them when adding non-custom items.
    $menu_items_data = array();
    foreach ((array) $_POST['menu-item'] as $menu_item_data) {
        if (!empty($menu_item_data['menu-item-type']) && 'custom' !== $menu_item_data['menu-item-type'] && !empty($menu_item_data['menu-item-object-id'])) {
            switch ($menu_item_data['menu-item-type']) {
                case 'post_type':
                    $_object = get_post($menu_item_data['menu-item-object-id']);
                    break;
                case 'post_type_archive':
                    $_object = get_post_type_object($menu_item_data['menu-item-object']);
                    break;
                case 'taxonomy':
                    $_object = get_term($menu_item_data['menu-item-object-id'], $menu_item_data['menu-item-object']);
                    break;
            }
            $_menu_items = array_map('wp_setup_nav_menu_item', array($_object));
            $_menu_item = reset($_menu_items);
            // Restore the missing menu item properties.
            $menu_item_data['menu-item-description'] = $_menu_item->description;
        }
        $menu_items_data[] = $menu_item_data;
    }
    $item_ids = wp_save_nav_menu_items(0, $menu_items_data);
    if (is_wp_error($item_ids)) {
        wp_die(0);
    }
    $menu_items = array();
    foreach ((array) $item_ids as $menu_item_id) {
        $menu_obj = get_post($menu_item_id);
        if (!empty($menu_obj->ID)) {
            $menu_obj = wp_setup_nav_menu_item($menu_obj);
            $menu_obj->title = empty($menu_obj->title) ? __('Menu Item') : $menu_obj->title;
            $menu_obj->label = $menu_obj->title;
            // Don't show "(pending)" in ajax-added items.
            $menu_items[] = $menu_obj;
        }
    }
    /** This filter is documented in wp-admin/includes/nav-menu.php */
    $walker_class_name = apply_filters('wp_edit_nav_menu_walker', 'Walker_Nav_Menu_Edit', $_POST['menu']);
    if (!class_exists($walker_class_name)) {
        wp_die(0);
    }
    if (!empty($menu_items)) {
        $args = array('after' => '', 'before' => '', 'link_after' => '', 'link_before' => '', 'walker' => new $walker_class_name());
        echo walk_nav_menu_tree($menu_items, 0, (object) $args);
    }
    wp_die();
}
/**
 * Ajax handler for adding meta.
 *
 * @since 3.1.0
 */
function wp_ajax_add_meta()
{
    check_ajax_referer('add-meta', '_ajax_nonce-add-meta');
    $c = 0;
    $pid = (int) $_POST['post_id'];
    $post = get_post($pid);
    if (isset($_POST['metakeyselect']) || isset($_POST['metakeyinput'])) {
        if (!current_user_can('edit_post', $pid)) {
            wp_die(-1);
        }
        if (isset($_POST['metakeyselect']) && '#NONE#' === $_POST['metakeyselect'] && empty($_POST['metakeyinput'])) {
            wp_die(1);
        }
        // If the post is an autodraft, save the post as a draft and then attempt to save the meta.
        if ('auto-draft' === $post->post_status) {
            $post_data = array();
            $post_data['action'] = 'draft';
            // Warning fix.
            $post_data['post_ID'] = $pid;
            $post_data['post_type'] = $post->post_type;
            $post_data['post_status'] = 'draft';
            $now = time();
            /* translators: 1: Post creation date, 2: Post creation time. */
            $post_data['post_title'] = sprintf(__('Draft created on %1$s at %2$s'), gmdate(__('F j, Y'), $now), gmdate(__('g:i a'), $now));
            $pid = edit_post($post_data);
            if ($pid) {
                if (is_wp_error($pid)) {
                    $x = new WP_Ajax_Response(array('what' => 'meta', 'data' => $pid));
                    $x->send();
                }
                $mid = add_meta($pid);
                if (!$mid) {
                    wp_die(__('Please provide a custom field value.'));
                }
            } else {
                wp_die(0);
            }
        } else {
            $mid = add_meta($pid);
            if (!$mid) {
                wp_die(__('Please provide a custom field value.'));
            }
        }
        $meta = get_metadata_by_mid('post', $mid);
        $pid = (int) $meta->post_id;
        $meta = get_object_vars($meta);
        $x = new WP_Ajax_Response(array('what' => 'meta', 'id' => $mid, 'data' => _list_meta_row($meta, $c), 'position' => 1, 'supplemental' => array('postid' => $pid)));
    } else {
        // Update?
        $mid = (int) key($_POST['meta']);
        $key = wp_unslash($_POST['meta'][$mid]['key']);
        $value = wp_unslash($_POST['meta'][$mid]['value']);
        if ('' === trim($key)) {
            wp_die(__('Please provide a custom field name.'));
        }
        $meta = get_metadata_by_mid('post', $mid);
        if (!$meta) {
            wp_die(0);
            // If meta doesn't exist.
        }
        if (is_protected_meta($meta->meta_key, 'post') || is_protected_meta($key, 'post') || !current_user_can('edit_post_meta', $meta->post_id, $meta->meta_key) || !current_user_can('edit_post_meta', $meta->post_id, $key)) {
            wp_die(-1);
        }
        if ($meta->meta_value != $value || $meta->meta_key != $key) {
            $u = update_metadata_by_mid('post', $mid, $value, $key);
            if (!$u) {
                wp_die(0);
                // We know meta exists; we also know it's unchanged (or DB error, in which case there are bigger problems).
            }
        }
        $x = new WP_Ajax_Response(array('what' => 'meta', 'id' => $mid, 'old_id' => $mid, 'data' => _list_meta_row(array('meta_key' => $key, 'meta_value' => $value, 'meta_id' => $mid), $c), 'position' => 0, 'supplemental' => array('postid' => $meta->post_id)));
    }
    $x->send();
}
/**
 * Ajax handler for adding a user.
 *
 * @since 3.1.0
 *
 * @param string $action Action to perform.
 */
function wp_ajax_add_user($action)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_add_user") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1227")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_add_user:1227@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for closed post boxes.
 *
 * @since 3.1.0
 */
function wp_ajax_closed_postboxes()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_closed_postboxes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1258")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_closed_postboxes:1258@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for hidden columns.
 *
 * @since 3.1.0
 */
function wp_ajax_hidden_columns()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_hidden_columns") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1288")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_hidden_columns:1288@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for updating whether to display the welcome panel.
 *
 * @since 3.1.0
 */
function wp_ajax_update_welcome_panel()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_update_welcome_panel") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1308")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_update_welcome_panel:1308@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for retrieving menu meta boxes.
 *
 * @since 3.1.0
 */
function wp_ajax_menu_get_metabox()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_menu_get_metabox") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1322")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_menu_get_metabox:1322@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for internal linking.
 *
 * @since 3.1.0
 */
function wp_ajax_wp_link_ajax()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_wp_link_ajax") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1354")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_wp_link_ajax:1354@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for menu locations save.
 *
 * @since 3.1.0
 */
function wp_ajax_menu_locations_save()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_menu_locations_save") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1381")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_menu_locations_save:1381@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for saving the meta box order.
 *
 * @since 3.1.0
 */
function wp_ajax_meta_box_order()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_meta_box_order") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1398")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_meta_box_order:1398@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for menu quick searching.
 *
 * @since 3.1.0
 */
function wp_ajax_menu_quick_search()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_menu_quick_search") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1427")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_menu_quick_search:1427@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler to retrieve a permalink.
 *
 * @since 3.1.0
 */
function wp_ajax_get_permalink()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_get_permalink") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1441")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_get_permalink:1441@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler to retrieve a sample permalink.
 *
 * @since 3.1.0
 */
function wp_ajax_sample_permalink()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_sample_permalink") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1452")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_sample_permalink:1452@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for Quick Edit saving a post from a list table.
 *
 * @since 3.1.0
 *
 * @global string $mode List table view mode.
 */
function wp_ajax_inline_save()
{
    global $mode;
    check_ajax_referer('inlineeditnonce', '_inline_edit');
    if (!isset($_POST['post_ID']) || !(int) $_POST['post_ID']) {
        wp_die();
    }
    $post_ID = (int) $_POST['post_ID'];
    if ('page' === $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_ID)) {
            wp_die(__('Sorry, you are not allowed to edit this page.'));
        }
    } else {
        if (!current_user_can('edit_post', $post_ID)) {
            wp_die(__('Sorry, you are not allowed to edit this post.'));
        }
    }
    $last = wp_check_post_lock($post_ID);
    if ($last) {
        $last_user = get_userdata($last);
        $last_user_name = $last_user ? $last_user->display_name : __('Someone');
        /* translators: %s: User's display name. */
        $msg_template = __('Saving is disabled: %s is currently editing this post.');
        if ('page' === $_POST['post_type']) {
            /* translators: %s: User's display name. */
            $msg_template = __('Saving is disabled: %s is currently editing this page.');
        }
        printf($msg_template, esc_html($last_user_name));
        wp_die();
    }
    $data =& $_POST;
    $post = get_post($post_ID, ARRAY_A);
    // Since it's coming from the database.
    $post = wp_slash($post);
    $data['content'] = $post['post_content'];
    $data['excerpt'] = $post['post_excerpt'];
    // Rename.
    $data['user_ID'] = get_current_user_id();
    if (isset($data['post_parent'])) {
        $data['parent_id'] = $data['post_parent'];
    }
    // Status.
    if (isset($data['keep_private']) && 'private' === $data['keep_private']) {
        $data['visibility'] = 'private';
        $data['post_status'] = 'private';
    } else {
        $data['post_status'] = $data['_status'];
    }
    if (empty($data['comment_status'])) {
        $data['comment_status'] = 'closed';
    }
    if (empty($data['ping_status'])) {
        $data['ping_status'] = 'closed';
    }
    // Exclude terms from taxonomies that are not supposed to appear in Quick Edit.
    if (!empty($data['tax_input'])) {
        foreach ($data['tax_input'] as $taxonomy => $terms) {
            $tax_object = get_taxonomy($taxonomy);
            /** This filter is documented in wp-admin/includes/class-wp-posts-list-table.php */
            if (!apply_filters('quick_edit_show_taxonomy', $tax_object->show_in_quick_edit, $taxonomy, $post['post_type'])) {
                unset($data['tax_input'][$taxonomy]);
            }
        }
    }
    // Hack: wp_unique_post_slug() doesn't work for drafts, so we will fake that our post is published.
    if (!empty($data['post_name']) && in_array($post['post_status'], array('draft', 'pending'), true)) {
        $post['post_status'] = 'publish';
        $data['post_name'] = wp_unique_post_slug($data['post_name'], $post['ID'], $post['post_status'], $post['post_type'], $post['post_parent']);
    }
    // Update the post.
    edit_post();
    $wp_list_table = _get_list_table('WP_Posts_List_Table', array('screen' => $_POST['screen']));
    $mode = 'excerpt' === $_POST['post_view'] ? 'excerpt' : 'list';
    $level = 0;
    if (is_post_type_hierarchical($wp_list_table->screen->post_type)) {
        $request_post = array(get_post($_POST['post_ID']));
        $parent = $request_post[0]->post_parent;
        while ($parent > 0) {
            $parent_post = get_post($parent);
            $parent = $parent_post->post_parent;
            $level++;
        }
    }
    $wp_list_table->display_rows(array(get_post($_POST['post_ID'])), $level);
    wp_die();
}
/**
 * Ajax handler for quick edit saving for a term.
 *
 * @since 3.1.0
 */
function wp_ajax_inline_save_tax()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_inline_save_tax") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1558")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_inline_save_tax:1558@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for querying posts for the Find Posts modal.
 *
 * @see window.findPosts
 *
 * @since 3.1.0
 */
function wp_ajax_find_posts()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_find_posts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1608")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_find_posts:1608@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for saving the widgets order.
 *
 * @since 3.1.0
 */
function wp_ajax_widgets_order()
{
    check_ajax_referer('save-sidebar-widgets', 'savewidgets');
    if (!current_user_can('edit_theme_options')) {
        wp_die(-1);
    }
    unset($_POST['savewidgets'], $_POST['action']);
    // Save widgets order for all sidebars.
    if (is_array($_POST['sidebars'])) {
        $sidebars = array();
        foreach (wp_unslash($_POST['sidebars']) as $key => $val) {
            $sb = array();
            if (!empty($val)) {
                $val = explode(',', $val);
                foreach ($val as $k => $v) {
                    if (strpos($v, 'widget-') === false) {
                        continue;
                    }
                    $sb[$k] = substr($v, strpos($v, '_') + 1);
                }
            }
            $sidebars[$key] = $sb;
        }
        wp_set_sidebars_widgets($sidebars);
        wp_die(1);
    }
    wp_die(-1);
}
/**
 * Ajax handler for saving a widget.
 *
 * @since 3.1.0
 *
 * @global array $wp_registered_widgets
 * @global array $wp_registered_widget_controls
 * @global array $wp_registered_widget_updates
 */
function wp_ajax_save_widget()
{
    global $wp_registered_widgets, $wp_registered_widget_controls, $wp_registered_widget_updates;
    check_ajax_referer('save-sidebar-widgets', 'savewidgets');
    if (!current_user_can('edit_theme_options') || !isset($_POST['id_base'])) {
        wp_die(-1);
    }
    unset($_POST['savewidgets'], $_POST['action']);
    /**
     * Fires early when editing the widgets displayed in sidebars.
     *
     * @since 2.8.0
     */
    do_action('load-widgets.php');
    // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
    /**
     * Fires early when editing the widgets displayed in sidebars.
     *
     * @since 2.8.0
     */
    do_action('widgets.php');
    // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
    /** This action is documented in wp-admin/widgets.php */
    do_action('sidebar_admin_setup');
    $id_base = wp_unslash($_POST['id_base']);
    $widget_id = wp_unslash($_POST['widget-id']);
    $sidebar_id = $_POST['sidebar'];
    $multi_number = !empty($_POST['multi_number']) ? (int) $_POST['multi_number'] : 0;
    $settings = isset($_POST['widget-' . $id_base]) && is_array($_POST['widget-' . $id_base]) ? $_POST['widget-' . $id_base] : false;
    $error = '<p>' . __('An error has occurred. Please reload the page and try again.') . '</p>';
    $sidebars = wp_get_sidebars_widgets();
    $sidebar = isset($sidebars[$sidebar_id]) ? $sidebars[$sidebar_id] : array();
    // Delete.
    if (isset($_POST['delete_widget']) && $_POST['delete_widget']) {
        if (!isset($wp_registered_widgets[$widget_id])) {
            wp_die($error);
        }
        $sidebar = array_diff($sidebar, array($widget_id));
        $_POST = array('sidebar' => $sidebar_id, 'widget-' . $id_base => array(), 'the-widget-id' => $widget_id, 'delete_widget' => '1');
        /** This action is documented in wp-admin/widgets.php */
        do_action('delete_widget', $widget_id, $sidebar_id, $id_base);
    } elseif ($settings && preg_match('/__i__|%i%/', key($settings))) {
        if (!$multi_number) {
            wp_die($error);
        }
        $_POST['widget-' . $id_base] = array($multi_number => reset($settings));
        $widget_id = $id_base . '-' . $multi_number;
        $sidebar[] = $widget_id;
    }
    $_POST['widget-id'] = $sidebar;
    foreach ((array) $wp_registered_widget_updates as $name => $control) {
        if ($name == $id_base) {
            if (!is_callable($control['callback'])) {
                continue;
            }
            ob_start();
            call_user_func_array($control['callback'], $control['params']);
            ob_end_clean();
            break;
        }
    }
    if (isset($_POST['delete_widget']) && $_POST['delete_widget']) {
        $sidebars[$sidebar_id] = $sidebar;
        wp_set_sidebars_widgets($sidebars);
        echo "deleted:{$widget_id}";
        wp_die();
    }
    if (!empty($_POST['add_new'])) {
        wp_die();
    }
    $form = $wp_registered_widget_controls[$widget_id];
    if ($form) {
        call_user_func_array($form['callback'], $form['params']);
    }
    wp_die();
}
/**
 * Ajax handler for updating a widget.
 *
 * @since 3.9.0
 *
 * @global WP_Customize_Manager $wp_customize
 */
function wp_ajax_update_widget()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_update_widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1779")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_update_widget:1779@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for removing inactive widgets.
 *
 * @since 4.4.0
 */
function wp_ajax_delete_inactive_widgets()
{
    check_ajax_referer('remove-inactive-widgets', 'removeinactivewidgets');
    if (!current_user_can('edit_theme_options')) {
        wp_die(-1);
    }
    unset($_POST['removeinactivewidgets'], $_POST['action']);
    /** This action is documented in wp-admin/includes/ajax-actions.php */
    do_action('load-widgets.php');
    // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
    /** This action is documented in wp-admin/includes/ajax-actions.php */
    do_action('widgets.php');
    // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
    /** This action is documented in wp-admin/widgets.php */
    do_action('sidebar_admin_setup');
    $sidebars_widgets = wp_get_sidebars_widgets();
    foreach ($sidebars_widgets['wp_inactive_widgets'] as $key => $widget_id) {
        $pieces = explode('-', $widget_id);
        $multi_number = array_pop($pieces);
        $id_base = implode('-', $pieces);
        $widget = get_option('widget_' . $id_base);
        unset($widget[$multi_number]);
        update_option('widget_' . $id_base, $widget);
        unset($sidebars_widgets['wp_inactive_widgets'][$key]);
    }
    wp_set_sidebars_widgets($sidebars_widgets);
    wp_die();
}
/**
 * Ajax handler for creating missing image sub-sizes for just uploaded images.
 *
 * @since 5.3.0
 */
function wp_ajax_media_create_image_subsizes()
{
    check_ajax_referer('media-form');
    if (!current_user_can('upload_files')) {
        wp_send_json_error(array('message' => __('Sorry, you are not allowed to upload files.')));
    }
    if (empty($_POST['attachment_id'])) {
        wp_send_json_error(array('message' => __('Upload failed. Please reload and try again.')));
    }
    $attachment_id = (int) $_POST['attachment_id'];
    if (!empty($_POST['_wp_upload_failed_cleanup'])) {
        // Upload failed. Cleanup.
        if (wp_attachment_is_image($attachment_id) && current_user_can('delete_post', $attachment_id)) {
            $attachment = get_post($attachment_id);
            // Created at most 10 min ago.
            if ($attachment && time() - strtotime($attachment->post_date_gmt) < 600) {
                wp_delete_attachment($attachment_id, true);
                wp_send_json_success();
            }
        }
    }
    // Set a custom header with the attachment_id.
    // Used by the browser/client to resume creating image sub-sizes after a PHP fatal error.
    if (!headers_sent()) {
        header('X-WP-Upload-Attachment-ID: ' . $attachment_id);
    }
    // This can still be pretty slow and cause timeout or out of memory errors.
    // The js that handles the response would need to also handle HTTP 500 errors.
    wp_update_image_subsizes($attachment_id);
    if (!empty($_POST['_legacy_support'])) {
        // The old (inline) uploader. Only needs the attachment_id.
        $response = array('id' => $attachment_id);
    } else {
        // Media modal and Media Library grid view.
        $response = wp_prepare_attachment_for_js($attachment_id);
        if (!$response) {
            wp_send_json_error(array('message' => __('Upload failed.')));
        }
    }
    // At this point the image has been uploaded successfully.
    wp_send_json_success($response);
}
/**
 * Ajax handler for uploading attachments
 *
 * @since 3.3.0
 */
function wp_ajax_upload_attachment()
{
    check_ajax_referer('media-form');
    /*
     * This function does not use wp_send_json_success() / wp_send_json_error()
     * as the html4 Plupload handler requires a text/html content-type for older IE.
     * See https://core.trac.wordpress.org/ticket/31037
     */
    if (!current_user_can('upload_files')) {
        echo wp_json_encode(array('success' => false, 'data' => array('message' => __('Sorry, you are not allowed to upload files.'), 'filename' => esc_html($_FILES['async-upload']['name']))));
        wp_die();
    }
    if (isset($_REQUEST['post_id'])) {
        $post_id = $_REQUEST['post_id'];
        if (!current_user_can('edit_post', $post_id)) {
            echo wp_json_encode(array('success' => false, 'data' => array('message' => __('Sorry, you are not allowed to attach files to this post.'), 'filename' => esc_html($_FILES['async-upload']['name']))));
            wp_die();
        }
    } else {
        $post_id = null;
    }
    $post_data = !empty($_REQUEST['post_data']) ? _wp_get_allowed_postdata(_wp_translate_postdata(false, (array) $_REQUEST['post_data'])) : array();
    if (is_wp_error($post_data)) {
        wp_die($post_data->get_error_message());
    }
    // If the context is custom header or background, make sure the uploaded file is an image.
    if (isset($post_data['context']) && in_array($post_data['context'], array('custom-header', 'custom-background'), true)) {
        $wp_filetype = wp_check_filetype_and_ext($_FILES['async-upload']['tmp_name'], $_FILES['async-upload']['name']);
        if (!wp_match_mime_types('image', $wp_filetype['type'])) {
            echo wp_json_encode(array('success' => false, 'data' => array('message' => __('The uploaded file is not a valid image. Please try again.'), 'filename' => esc_html($_FILES['async-upload']['name']))));
            wp_die();
        }
    }
    $attachment_id = media_handle_upload('async-upload', $post_id, $post_data);
    if (is_wp_error($attachment_id)) {
        echo wp_json_encode(array('success' => false, 'data' => array('message' => $attachment_id->get_error_message(), 'filename' => esc_html($_FILES['async-upload']['name']))));
        wp_die();
    }
    if (isset($post_data['context']) && isset($post_data['theme'])) {
        if ('custom-background' === $post_data['context']) {
            update_post_meta($attachment_id, '_wp_attachment_is_custom_background', $post_data['theme']);
        }
        if ('custom-header' === $post_data['context']) {
            update_post_meta($attachment_id, '_wp_attachment_is_custom_header', $post_data['theme']);
        }
    }
    $attachment = wp_prepare_attachment_for_js($attachment_id);
    if (!$attachment) {
        wp_die();
    }
    echo wp_json_encode(array('success' => true, 'data' => $attachment));
    wp_die();
}
/**
 * Ajax handler for image editing.
 *
 * @since 3.1.0
 */
function wp_ajax_image_editor()
{
    $attachment_id = (int) $_POST['postid'];
    if (empty($attachment_id) || !current_user_can('edit_post', $attachment_id)) {
        wp_die(-1);
    }
    check_ajax_referer("image_editor-{$attachment_id}");
    include_once ABSPATH . 'wp-admin/includes/image-edit.php';
    $msg = false;
    switch ($_POST['do']) {
        case 'save':
            $msg = wp_save_image($attachment_id);
            if (!empty($msg->error)) {
                wp_send_json_error($msg);
            }
            wp_send_json_success($msg);
            break;
        case 'scale':
            $msg = wp_save_image($attachment_id);
            break;
        case 'restore':
            $msg = wp_restore_image($attachment_id);
            break;
    }
    ob_start();
    wp_image_editor($attachment_id, $msg);
    $html = ob_get_clean();
    if (!empty($msg->error)) {
        wp_send_json_error(array('message' => $msg, 'html' => $html));
    }
    wp_send_json_success(array('message' => $msg, 'html' => $html));
}
/**
 * Ajax handler for setting the featured image.
 *
 * @since 3.1.0
 */
function wp_ajax_set_post_thumbnail()
{
    $json = !empty($_REQUEST['json']);
    // New-style request.
    $post_ID = (int) $_POST['post_id'];
    if (!current_user_can('edit_post', $post_ID)) {
        wp_die(-1);
    }
    $thumbnail_id = (int) $_POST['thumbnail_id'];
    if ($json) {
        check_ajax_referer("update-post_{$post_ID}");
    } else {
        check_ajax_referer("set_post_thumbnail-{$post_ID}");
    }
    if ('-1' == $thumbnail_id) {
        if (delete_post_thumbnail($post_ID)) {
            $return = _wp_post_thumbnail_html(null, $post_ID);
            $json ? wp_send_json_success($return) : wp_die($return);
        } else {
            wp_die(0);
        }
    }
    if (set_post_thumbnail($post_ID, $thumbnail_id)) {
        $return = _wp_post_thumbnail_html($thumbnail_id, $post_ID);
        $json ? wp_send_json_success($return) : wp_die($return);
    }
    wp_die(0);
}
/**
 * Ajax handler for retrieving HTML for the featured image.
 *
 * @since 4.6.0
 */
function wp_ajax_get_post_thumbnail_html()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_get_post_thumbnail_html") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 1997")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_get_post_thumbnail_html:1997@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for setting the featured image for an attachment.
 *
 * @since 4.0.0
 *
 * @see set_post_thumbnail()
 */
function wp_ajax_set_attachment_thumbnail()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_set_attachment_thumbnail") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2019")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_set_attachment_thumbnail:2019@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for date formatting.
 *
 * @since 3.1.0
 */
function wp_ajax_date_format()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_date_format") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2061")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_date_format:2061@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for time formatting.
 *
 * @since 3.1.0
 */
function wp_ajax_time_format()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_time_format") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2070")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_time_format:2070@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for saving posts from the fullscreen editor.
 *
 * @since 3.1.0
 * @deprecated 4.3.0
 */
function wp_ajax_wp_fullscreen_save_post()
{
    $post_id = isset($_POST['post_ID']) ? (int) $_POST['post_ID'] : 0;
    $post = null;
    if ($post_id) {
        $post = get_post($post_id);
    }
    check_ajax_referer('update-post_' . $post_id, '_wpnonce');
    $post_id = edit_post();
    if (is_wp_error($post_id)) {
        wp_send_json_error();
    }
    if ($post) {
        $last_date = mysql2date(__('F j, Y'), $post->post_modified);
        $last_time = mysql2date(__('g:i a'), $post->post_modified);
    } else {
        $last_date = date_i18n(__('F j, Y'));
        $last_time = date_i18n(__('g:i a'));
    }
    $last_id = get_post_meta($post_id, '_edit_last', true);
    if ($last_id) {
        $last_user = get_userdata($last_id);
        /* translators: 1: User's display name, 2: Date of last edit, 3: Time of last edit. */
        $last_edited = sprintf(__('Last edited by %1$s on %2$s at %3$s'), esc_html($last_user->display_name), $last_date, $last_time);
    } else {
        /* translators: 1: Date of last edit, 2: Time of last edit. */
        $last_edited = sprintf(__('Last edited on %1$s at %2$s'), $last_date, $last_time);
    }
    wp_send_json_success(array('last_edited' => $last_edited));
}
/**
 * Ajax handler for removing a post lock.
 *
 * @since 3.1.0
 */
function wp_ajax_wp_remove_post_lock()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_wp_remove_post_lock") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2115")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_wp_remove_post_lock:2115@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for dismissing a WordPress pointer.
 *
 * @since 3.1.0
 */
function wp_ajax_dismiss_wp_pointer()
{
    $pointer = $_POST['pointer'];
    if (sanitize_key($pointer) != $pointer) {
        wp_die(0);
    }
    //  check_ajax_referer( 'dismiss-pointer_' . $pointer );
    $dismissed = array_filter(explode(',', (string) get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true)));
    if (in_array($pointer, $dismissed, true)) {
        wp_die(0);
    }
    $dismissed[] = $pointer;
    $dismissed = implode(',', $dismissed);
    update_user_meta(get_current_user_id(), 'dismissed_wp_pointers', $dismissed);
    wp_die(1);
}
/**
 * Ajax handler for getting an attachment.
 *
 * @since 3.5.0
 */
function wp_ajax_get_attachment()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_get_attachment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2171")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_get_attachment:2171@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for querying attachments.
 *
 * @since 3.5.0
 */
function wp_ajax_query_attachments()
{
    if (!current_user_can('upload_files')) {
        wp_send_json_error();
    }
    $query = isset($_REQUEST['query']) ? (array) $_REQUEST['query'] : array();
    $keys = array('s', 'order', 'orderby', 'posts_per_page', 'paged', 'post_mime_type', 'post_parent', 'author', 'post__in', 'post__not_in', 'year', 'monthnum');
    foreach (get_taxonomies_for_attachments('objects') as $t) {
        if ($t->query_var && isset($query[$t->query_var])) {
            $keys[] = $t->query_var;
        }
    }
    $query = array_intersect_key($query, array_flip($keys));
    $query['post_type'] = 'attachment';
    if (MEDIA_TRASH && !empty($_REQUEST['query']['post_status']) && 'trash' === $_REQUEST['query']['post_status']) {
        $query['post_status'] = 'trash';
    } else {
        $query['post_status'] = 'inherit';
    }
    if (current_user_can(get_post_type_object('attachment')->cap->read_private_posts)) {
        $query['post_status'] .= ',private';
    }
    // Filter query clauses to include filenames.
    if (isset($query['s'])) {
        add_filter('posts_clauses', '_filter_query_attachment_filenames');
    }
    /**
     * Filters the arguments passed to WP_Query during an Ajax
     * call for querying attachments.
     *
     * @since 3.7.0
     *
     * @see WP_Query::parse_query()
     *
     * @param array $query An array of query variables.
     */
    $query = apply_filters('ajax_query_attachments_args', $query);
    $query = new WP_Query($query);
    $posts = array_map('wp_prepare_attachment_for_js', $query->posts);
    $posts = array_filter($posts);
    wp_send_json_success($posts);
}
/**
 * Ajax handler for updating attachment attributes.
 *
 * @since 3.5.0
 */
function wp_ajax_save_attachment()
{
    if (!isset($_REQUEST['id']) || !isset($_REQUEST['changes'])) {
        wp_send_json_error();
    }
    $id = absint($_REQUEST['id']);
    if (!$id) {
        wp_send_json_error();
    }
    check_ajax_referer('update-post_' . $id, 'nonce');
    if (!current_user_can('edit_post', $id)) {
        wp_send_json_error();
    }
    $changes = $_REQUEST['changes'];
    $post = get_post($id, ARRAY_A);
    if ('attachment' !== $post['post_type']) {
        wp_send_json_error();
    }
    if (isset($changes['parent'])) {
        $post['post_parent'] = $changes['parent'];
    }
    if (isset($changes['title'])) {
        $post['post_title'] = $changes['title'];
    }
    if (isset($changes['caption'])) {
        $post['post_excerpt'] = $changes['caption'];
    }
    if (isset($changes['description'])) {
        $post['post_content'] = $changes['description'];
    }
    if (MEDIA_TRASH && isset($changes['status'])) {
        $post['post_status'] = $changes['status'];
    }
    if (isset($changes['alt'])) {
        $alt = wp_unslash($changes['alt']);
        if (get_post_meta($id, '_wp_attachment_image_alt', true) !== $alt) {
            $alt = wp_strip_all_tags($alt, true);
            update_post_meta($id, '_wp_attachment_image_alt', wp_slash($alt));
        }
    }
    if (wp_attachment_is('audio', $post['ID'])) {
        $changed = false;
        $id3data = wp_get_attachment_metadata($post['ID']);
        if (!is_array($id3data)) {
            $changed = true;
            $id3data = array();
        }
        foreach (wp_get_attachment_id3_keys((object) $post, 'edit') as $key => $label) {
            if (isset($changes[$key])) {
                $changed = true;
                $id3data[$key] = sanitize_text_field(wp_unslash($changes[$key]));
            }
        }
        if ($changed) {
            wp_update_attachment_metadata($id, $id3data);
        }
    }
    if (MEDIA_TRASH && isset($changes['status']) && 'trash' === $changes['status']) {
        wp_delete_post($id);
    } else {
        wp_update_post($post);
    }
    wp_send_json_success();
}
/**
 * Ajax handler for saving backward compatible attachment attributes.
 *
 * @since 3.5.0
 */
function wp_ajax_save_attachment_compat()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_save_attachment_compat") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2317")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_save_attachment_compat:2317@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for saving the attachment order.
 *
 * @since 3.5.0
 */
function wp_ajax_save_attachment_order()
{
    if (!isset($_REQUEST['post_id'])) {
        wp_send_json_error();
    }
    $post_id = absint($_REQUEST['post_id']);
    if (!$post_id) {
        wp_send_json_error();
    }
    if (empty($_REQUEST['attachments'])) {
        wp_send_json_error();
    }
    check_ajax_referer('update-post_' . $post_id, 'nonce');
    $attachments = $_REQUEST['attachments'];
    if (!current_user_can('edit_post', $post_id)) {
        wp_send_json_error();
    }
    foreach ($attachments as $attachment_id => $menu_order) {
        if (!current_user_can('edit_post', $attachment_id)) {
            continue;
        }
        $attachment = get_post($attachment_id);
        if (!$attachment) {
            continue;
        }
        if ('attachment' !== $attachment->post_type) {
            continue;
        }
        wp_update_post(array('ID' => $attachment_id, 'menu_order' => $menu_order));
    }
    wp_send_json_success();
}
/**
 * Ajax handler for sending an attachment to the editor.
 *
 * Generates the HTML to send an attachment to the editor.
 * Backward compatible with the {@see 'media_send_to_editor'} filter
 * and the chain of filters that follow.
 *
 * @since 3.5.0
 */
function wp_ajax_send_attachment_to_editor()
{
    check_ajax_referer('media-send-to-editor', 'nonce');
    $attachment = wp_unslash($_POST['attachment']);
    $id = (int) $attachment['id'];
    $post = get_post($id);
    if (!$post) {
        wp_send_json_error();
    }
    if ('attachment' !== $post->post_type) {
        wp_send_json_error();
    }
    if (current_user_can('edit_post', $id)) {
        // If this attachment is unattached, attach it. Primarily a back compat thing.
        $insert_into_post_id = (int) $_POST['post_id'];
        if (0 == $post->post_parent && $insert_into_post_id) {
            wp_update_post(array('ID' => $id, 'post_parent' => $insert_into_post_id));
        }
    }
    $url = empty($attachment['url']) ? '' : $attachment['url'];
    $rel = strpos($url, 'attachment_id') || get_attachment_link($id) == $url;
    remove_filter('media_send_to_editor', 'image_media_send_to_editor');
    if ('image' === substr($post->post_mime_type, 0, 5)) {
        $align = isset($attachment['align']) ? $attachment['align'] : 'none';
        $size = isset($attachment['image-size']) ? $attachment['image-size'] : 'medium';
        $alt = isset($attachment['image_alt']) ? $attachment['image_alt'] : '';
        // No whitespace-only captions.
        $caption = isset($attachment['post_excerpt']) ? $attachment['post_excerpt'] : '';
        if ('' === trim($caption)) {
            $caption = '';
        }
        $title = '';
        // We no longer insert title tags into <img> tags, as they are redundant.
        $html = get_image_send_to_editor($id, $caption, $title, $align, $url, $rel, $size, $alt);
    } elseif (wp_attachment_is('video', $post) || wp_attachment_is('audio', $post)) {
        $html = stripslashes_deep($_POST['html']);
    } else {
        $html = isset($attachment['post_title']) ? $attachment['post_title'] : '';
        $rel = $rel ? ' rel="attachment wp-att-' . $id . '"' : '';
        // Hard-coded string, $id is already sanitized.
        if (!empty($url)) {
            $html = '<a href="' . esc_url($url) . '"' . $rel . '>' . $html . '</a>';
        }
    }
    /** This filter is documented in wp-admin/includes/media.php */
    $html = apply_filters('media_send_to_editor', $html, $id, $attachment);
    wp_send_json_success($html);
}
/**
 * Ajax handler for sending a link to the editor.
 *
 * Generates the HTML to send a non-image embed link to the editor.
 *
 * Backward compatible with the following filters:
 * - file_send_to_editor_url
 * - audio_send_to_editor_url
 * - video_send_to_editor_url
 *
 * @since 3.5.0
 *
 * @global WP_Post  $post     Global post object.
 * @global WP_Embed $wp_embed
 */
function wp_ajax_send_link_to_editor()
{
    global $post, $wp_embed;
    check_ajax_referer('media-send-to-editor', 'nonce');
    $src = wp_unslash($_POST['src']);
    if (!$src) {
        wp_send_json_error();
    }
    if (!strpos($src, '://')) {
        $src = 'http://' . $src;
    }
    $src = esc_url_raw($src);
    if (!$src) {
        wp_send_json_error();
    }
    $link_text = trim(wp_unslash($_POST['link_text']));
    if (!$link_text) {
        $link_text = wp_basename($src);
    }
    $post = get_post(isset($_POST['post_id']) ? $_POST['post_id'] : 0);
    // Ping WordPress for an embed.
    $check_embed = $wp_embed->run_shortcode('[embed]' . $src . '[/embed]');
    // Fallback that WordPress creates when no oEmbed was found.
    $fallback = $wp_embed->maybe_make_link($src);
    if ($check_embed !== $fallback) {
        // TinyMCE view for [embed] will parse this.
        $html = '[embed]' . $src . '[/embed]';
    } elseif ($link_text) {
        $html = '<a href="' . esc_url($src) . '">' . $link_text . '</a>';
    } else {
        $html = '';
    }
    // Figure out what filter to run:
    $type = 'file';
    $ext = preg_replace('/^.+?\\.([^.]+)$/', '$1', $src);
    if ($ext) {
        $ext_type = wp_ext2type($ext);
        if ('audio' === $ext_type || 'video' === $ext_type) {
            $type = $ext_type;
        }
    }
    /** This filter is documented in wp-admin/includes/media.php */
    $html = apply_filters("{$type}_send_to_editor_url", $html, $src, $link_text);
    wp_send_json_success($html);
}
/**
 * Ajax handler for the Heartbeat API.
 *
 * Runs when the user is logged in.
 *
 * @since 3.6.0
 */
function wp_ajax_heartbeat()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_heartbeat") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2518")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_heartbeat:2518@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for getting revision diffs.
 *
 * @since 3.6.0
 */
function wp_ajax_get_revision_diffs()
{
    require ABSPATH . 'wp-admin/includes/revision.php';
    $post = get_post((int) $_REQUEST['post_id']);
    if (!$post) {
        wp_send_json_error();
    }
    if (!current_user_can('edit_post', $post->ID)) {
        wp_send_json_error();
    }
    // Really just pre-loading the cache here.
    $revisions = wp_get_post_revisions($post->ID, array('check_enabled' => false));
    if (!$revisions) {
        wp_send_json_error();
    }
    $return = array();
    set_time_limit(0);
    foreach ($_REQUEST['compare'] as $compare_key) {
        list($compare_from, $compare_to) = explode(':', $compare_key);
        // from:to
        $return[] = array('id' => $compare_key, 'fields' => wp_get_revision_ui_diff($post, $compare_from, $compare_to));
    }
    wp_send_json_success($return);
}
/**
 * Ajax handler for auto-saving the selected color scheme for
 * a user's own profile.
 *
 * @since 3.8.0
 *
 * @global array $_wp_admin_css_colors
 */
function wp_ajax_save_user_color_scheme()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_save_user_color_scheme") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2625")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_save_user_color_scheme:2625@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for getting themes from themes_api().
 *
 * @since 3.9.0
 *
 * @global array $themes_allowedtags
 * @global array $theme_field_defaults
 */
function wp_ajax_query_themes()
{
    global $themes_allowedtags, $theme_field_defaults;
    if (!current_user_can('install_themes')) {
        wp_send_json_error();
    }
    $args = wp_parse_args(wp_unslash($_REQUEST['request']), array('per_page' => 20, 'fields' => array_merge((array) $theme_field_defaults, array('reviews_url' => true))));
    if (isset($args['browse']) && 'favorites' === $args['browse'] && !isset($args['user'])) {
        $user = get_user_option('wporg_favorites');
        if ($user) {
            $args['user'] = $user;
        }
    }
    $old_filter = isset($args['browse']) ? $args['browse'] : 'search';
    /** This filter is documented in wp-admin/includes/class-wp-theme-install-list-table.php */
    $args = apply_filters('install_themes_table_api_args_' . $old_filter, $args);
    $api = themes_api('query_themes', $args);
    if (is_wp_error($api)) {
        wp_send_json_error();
    }
    $update_php = network_admin_url('update.php?action=install-theme');
    foreach ($api->themes as &$theme) {
        $theme->install_url = add_query_arg(array('theme' => $theme->slug, '_wpnonce' => wp_create_nonce('install-theme_' . $theme->slug)), $update_php);
        if (current_user_can('switch_themes')) {
            if (is_multisite()) {
                $theme->activate_url = add_query_arg(array('action' => 'enable', '_wpnonce' => wp_create_nonce('enable-theme_' . $theme->slug), 'theme' => $theme->slug), network_admin_url('themes.php'));
            } else {
                $theme->activate_url = add_query_arg(array('action' => 'activate', '_wpnonce' => wp_create_nonce('switch-theme_' . $theme->slug), 'stylesheet' => $theme->slug), admin_url('themes.php'));
            }
        }
        if (!is_multisite() && current_user_can('edit_theme_options') && current_user_can('customize')) {
            $theme->customize_url = add_query_arg(array('return' => urlencode(network_admin_url('theme-install.php', 'relative'))), wp_customize_url($theme->slug));
        }
        $theme->name = wp_kses($theme->name, $themes_allowedtags);
        $theme->author = wp_kses($theme->author['display_name'], $themes_allowedtags);
        $theme->version = wp_kses($theme->version, $themes_allowedtags);
        $theme->description = wp_kses($theme->description, $themes_allowedtags);
        $theme->stars = wp_star_rating(array('rating' => $theme->rating, 'type' => 'percent', 'number' => $theme->num_ratings, 'echo' => false));
        $theme->num_ratings = number_format_i18n($theme->num_ratings);
        $theme->preview_url = set_url_scheme($theme->preview_url);
        $theme->compatible_wp = is_wp_version_compatible($theme->requires);
        $theme->compatible_php = is_php_version_compatible($theme->requires_php);
    }
    wp_send_json_success($api);
}
/**
 * Apply [embed] Ajax handlers to a string.
 *
 * @since 4.0.0
 *
 * @global WP_Post    $post       Global post object.
 * @global WP_Embed   $wp_embed   Embed API instance.
 * @global WP_Scripts $wp_scripts
 * @global int        $content_width
 */
function wp_ajax_parse_embed()
{
    global $post, $wp_embed, $content_width;
    if (empty($_POST['shortcode'])) {
        wp_send_json_error();
    }
    $post_id = isset($_POST['post_ID']) ? (int) $_POST['post_ID'] : 0;
    if ($post_id > 0) {
        $post = get_post($post_id);
        if (!$post || !current_user_can('edit_post', $post->ID)) {
            wp_send_json_error();
        }
        setup_postdata($post);
    } elseif (!current_user_can('edit_posts')) {
        // See WP_oEmbed_Controller::get_proxy_item_permissions_check().
        wp_send_json_error();
    }
    $shortcode = wp_unslash($_POST['shortcode']);
    preg_match('/' . get_shortcode_regex() . '/s', $shortcode, $matches);
    $atts = shortcode_parse_atts($matches[3]);
    if (!empty($matches[5])) {
        $url = $matches[5];
    } elseif (!empty($atts['src'])) {
        $url = $atts['src'];
    } else {
        $url = '';
    }
    $parsed = false;
    $wp_embed->return_false_on_fail = true;
    if (0 === $post_id) {
        /*
         * Refresh oEmbeds cached outside of posts that are past their TTL.
         * Posts are excluded because they have separate logic for refreshing
         * their post meta caches. See WP_Embed::cache_oembed().
         */
        $wp_embed->usecache = false;
    }
    if (is_ssl() && 0 === strpos($url, 'http://')) {
        // Admin is ssl and the user pasted non-ssl URL.
        // Check if the provider supports ssl embeds and use that for the preview.
        $ssl_shortcode = preg_replace('%^(\\[embed[^\\]]*\\])http://%i', '$1https://', $shortcode);
        $parsed = $wp_embed->run_shortcode($ssl_shortcode);
        if (!$parsed) {
            $no_ssl_support = true;
        }
    }
    // Set $content_width so any embeds fit in the destination iframe.
    if (isset($_POST['maxwidth']) && is_numeric($_POST['maxwidth']) && $_POST['maxwidth'] > 0) {
        if (!isset($content_width)) {
            $content_width = (int) $_POST['maxwidth'];
        } else {
            $content_width = min($content_width, (int) $_POST['maxwidth']);
        }
    }
    if ($url && !$parsed) {
        $parsed = $wp_embed->run_shortcode($shortcode);
    }
    if (!$parsed) {
        wp_send_json_error(array(
            'type' => 'not-embeddable',
            /* translators: %s: URL that could not be embedded. */
            'message' => sprintf(__('%s failed to embed.'), '<code>' . esc_html($url) . '</code>'),
        ));
    }
    if (has_shortcode($parsed, 'audio') || has_shortcode($parsed, 'video')) {
        $styles = '';
        $mce_styles = wpview_media_sandbox_styles();
        foreach ($mce_styles as $style) {
            $styles .= sprintf('<link rel="stylesheet" href="%s" />', $style);
        }
        $html = do_shortcode($parsed);
        global $wp_scripts;
        if (!empty($wp_scripts)) {
            $wp_scripts->done = array();
        }
        ob_start();
        wp_print_scripts(array('mediaelement-vimeo', 'wp-mediaelement'));
        $scripts = ob_get_clean();
        $parsed = $styles . $html . $scripts;
    }
    if (!empty($no_ssl_support) || is_ssl() && (preg_match('%<(iframe|script|embed) [^>]*src="http://%', $parsed) || preg_match('%<link [^>]*href="http://%', $parsed))) {
        // Admin is ssl and the embed is not. Iframes, scripts, and other "active content" will be blocked.
        wp_send_json_error(array('type' => 'not-ssl', 'message' => __('This preview is unavailable in the editor.')));
    }
    $return = array('body' => $parsed, 'attr' => $wp_embed->last_attr);
    if (strpos($parsed, 'class="wp-embedded-content')) {
        if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
            $script_src = includes_url('js/wp-embed.js');
        } else {
            $script_src = includes_url('js/wp-embed.min.js');
        }
        $return['head'] = '<script src="' . $script_src . '"></script>';
        $return['sandbox'] = true;
    }
    wp_send_json_success($return);
}
/**
 * @since 4.0.0
 *
 * @global WP_Post    $post       Global post object.
 * @global WP_Scripts $wp_scripts
 */
function wp_ajax_parse_media_shortcode()
{
    global $post, $wp_scripts;
    if (empty($_POST['shortcode'])) {
        wp_send_json_error();
    }
    $shortcode = wp_unslash($_POST['shortcode']);
    if (!empty($_POST['post_ID'])) {
        $post = get_post((int) $_POST['post_ID']);
    }
    // The embed shortcode requires a post.
    if (!$post || !current_user_can('edit_post', $post->ID)) {
        if ('embed' === $shortcode) {
            wp_send_json_error();
        }
    } else {
        setup_postdata($post);
    }
    $parsed = do_shortcode($shortcode);
    if (empty($parsed)) {
        wp_send_json_error(array('type' => 'no-items', 'message' => __('No items found.')));
    }
    $head = '';
    $styles = wpview_media_sandbox_styles();
    foreach ($styles as $style) {
        $head .= '<link type="text/css" rel="stylesheet" href="' . $style . '">';
    }
    if (!empty($wp_scripts)) {
        $wp_scripts->done = array();
    }
    ob_start();
    echo $parsed;
    if ('playlist' === $_REQUEST['type']) {
        wp_underscore_playlist_templates();
        wp_print_scripts('wp-playlist');
    } else {
        wp_print_scripts(array('mediaelement-vimeo', 'wp-mediaelement'));
    }
    wp_send_json_success(array('head' => $head, 'body' => ob_get_clean()));
}
/**
 * Ajax handler for destroying multiple open sessions for a user.
 *
 * @since 4.1.0
 */
function wp_ajax_destroy_sessions()
{
    $user = get_userdata((int) $_POST['user_id']);
    if ($user) {
        if (!current_user_can('edit_user', $user->ID)) {
            $user = false;
        } elseif (!wp_verify_nonce($_POST['nonce'], 'update-user_' . $user->ID)) {
            $user = false;
        }
    }
    if (!$user) {
        wp_send_json_error(array('message' => __('Could not log out user sessions. Please try again.')));
    }
    $sessions = WP_Session_Tokens::get_instance($user->ID);
    if (get_current_user_id() === $user->ID) {
        $sessions->destroy_others(wp_get_session_token());
        $message = __('You are now logged out everywhere else.');
    } else {
        $sessions->destroy_all();
        /* translators: %s: User's display name. */
        $message = sprintf(__('%s has been logged out.'), $user->display_name);
    }
    wp_send_json_success(array('message' => $message));
}
/**
 * Ajax handler for cropping an image.
 *
 * @since 4.3.0
 */
function wp_ajax_crop_image()
{
    $attachment_id = absint($_POST['id']);
    check_ajax_referer('image_editor-' . $attachment_id, 'nonce');
    if (empty($attachment_id) || !current_user_can('edit_post', $attachment_id)) {
        wp_send_json_error();
    }
    $context = str_replace('_', '-', $_POST['context']);
    $data = array_map('absint', $_POST['cropDetails']);
    $cropped = wp_crop_image($attachment_id, $data['x1'], $data['y1'], $data['width'], $data['height'], $data['dst_width'], $data['dst_height']);
    if (!$cropped || is_wp_error($cropped)) {
        wp_send_json_error(array('message' => __('Image could not be processed.')));
    }
    switch ($context) {
        case 'site-icon':
            require_once ABSPATH . 'wp-admin/includes/class-wp-site-icon.php';
            $wp_site_icon = new WP_Site_Icon();
            // Skip creating a new attachment if the attachment is a Site Icon.
            if (get_post_meta($attachment_id, '_wp_attachment_context', true) == $context) {
                // Delete the temporary cropped file, we don't need it.
                wp_delete_file($cropped);
                // Additional sizes in wp_prepare_attachment_for_js().
                add_filter('image_size_names_choose', array($wp_site_icon, 'additional_sizes'));
                break;
            }
            /** This filter is documented in wp-admin/includes/class-custom-image-header.php */
            $cropped = apply_filters('wp_create_file_in_uploads', $cropped, $attachment_id);
            // For replication.
            $object = $wp_site_icon->create_attachment_object($cropped, $attachment_id);
            unset($object['ID']);
            // Update the attachment.
            add_filter('intermediate_image_sizes_advanced', array($wp_site_icon, 'additional_sizes'));
            $attachment_id = $wp_site_icon->insert_attachment($object, $cropped);
            remove_filter('intermediate_image_sizes_advanced', array($wp_site_icon, 'additional_sizes'));
            // Additional sizes in wp_prepare_attachment_for_js().
            add_filter('image_size_names_choose', array($wp_site_icon, 'additional_sizes'));
            break;
        default:
            /**
             * Fires before a cropped image is saved.
             *
             * Allows to add filters to modify the way a cropped image is saved.
             *
             * @since 4.3.0
             *
             * @param string $context       The Customizer control requesting the cropped image.
             * @param int    $attachment_id The attachment ID of the original image.
             * @param string $cropped       Path to the cropped image file.
             */
            do_action('wp_ajax_crop_image_pre_save', $context, $attachment_id, $cropped);
            /** This filter is documented in wp-admin/includes/class-custom-image-header.php */
            $cropped = apply_filters('wp_create_file_in_uploads', $cropped, $attachment_id);
            // For replication.
            $parent_url = wp_get_attachment_url($attachment_id);
            $url = str_replace(wp_basename($parent_url), wp_basename($cropped), $parent_url);
            $size = wp_getimagesize($cropped);
            $image_type = $size ? $size['mime'] : 'image/jpeg';
            $object = array('post_title' => wp_basename($cropped), 'post_content' => $url, 'post_mime_type' => $image_type, 'guid' => $url, 'context' => $context);
            $attachment_id = wp_insert_attachment($object, $cropped);
            $metadata = wp_generate_attachment_metadata($attachment_id, $cropped);
            /**
             * Filters the cropped image attachment metadata.
             *
             * @since 4.3.0
             *
             * @see wp_generate_attachment_metadata()
             *
             * @param array $metadata Attachment metadata.
             */
            $metadata = apply_filters('wp_ajax_cropped_attachment_metadata', $metadata);
            wp_update_attachment_metadata($attachment_id, $metadata);
            /**
             * Filters the attachment ID for a cropped image.
             *
             * @since 4.3.0
             *
             * @param int    $attachment_id The attachment ID of the cropped image.
             * @param string $context       The Customizer control requesting the cropped image.
             */
            $attachment_id = apply_filters('wp_ajax_cropped_attachment_id', $attachment_id, $context);
    }
    wp_send_json_success(wp_prepare_attachment_for_js($attachment_id));
}
/**
 * Ajax handler for generating a password.
 *
 * @since 4.4.0
 */
function wp_ajax_generate_password()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_generate_password") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2964")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_generate_password:2964@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for generating a password in the no-privilege context.
 *
 * @since 5.7.0
 */
function wp_ajax_nopriv_generate_password()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_nopriv_generate_password") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2973")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_nopriv_generate_password:2973@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for saving the user's WordPress.org username.
 *
 * @since 4.4.0
 */
function wp_ajax_save_wporg_username()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_save_wporg_username") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 2982")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_save_wporg_username:2982@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for installing a theme.
 *
 * @since 4.6.0
 *
 * @see Theme_Upgrader
 *
 * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
 */
function wp_ajax_install_theme()
{
    check_ajax_referer('updates');
    if (empty($_POST['slug'])) {
        wp_send_json_error(array('slug' => '', 'errorCode' => 'no_theme_specified', 'errorMessage' => __('No theme specified.')));
    }
    $slug = sanitize_key(wp_unslash($_POST['slug']));
    $status = array('install' => 'theme', 'slug' => $slug);
    if (!current_user_can('install_themes')) {
        $status['errorMessage'] = __('Sorry, you are not allowed to install themes on this site.');
        wp_send_json_error($status);
    }
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/theme.php';
    $api = themes_api('theme_information', array('slug' => $slug, 'fields' => array('sections' => false)));
    if (is_wp_error($api)) {
        $status['errorMessage'] = $api->get_error_message();
        wp_send_json_error($status);
    }
    $skin = new WP_Ajax_Upgrader_Skin();
    $upgrader = new Theme_Upgrader($skin);
    $result = $upgrader->install($api->download_link);
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $status['debug'] = $skin->get_upgrade_messages();
    }
    if (is_wp_error($result)) {
        $status['errorCode'] = $result->get_error_code();
        $status['errorMessage'] = $result->get_error_message();
        wp_send_json_error($status);
    } elseif (is_wp_error($skin->result)) {
        $status['errorCode'] = $skin->result->get_error_code();
        $status['errorMessage'] = $skin->result->get_error_message();
        wp_send_json_error($status);
    } elseif ($skin->get_errors()->has_errors()) {
        $status['errorMessage'] = $skin->get_error_messages();
        wp_send_json_error($status);
    } elseif (is_null($result)) {
        global $wp_filesystem;
        $status['errorCode'] = 'unable_to_connect_to_filesystem';
        $status['errorMessage'] = __('Unable to connect to the filesystem. Please confirm your credentials.');
        // Pass through the error from WP_Filesystem if one was raised.
        if ($wp_filesystem instanceof WP_Filesystem_Base && is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->has_errors()) {
            $status['errorMessage'] = esc_html($wp_filesystem->errors->get_error_message());
        }
        wp_send_json_error($status);
    }
    $status['themeName'] = wp_get_theme($slug)->get('Name');
    if (current_user_can('switch_themes')) {
        if (is_multisite()) {
            $status['activateUrl'] = add_query_arg(array('action' => 'enable', '_wpnonce' => wp_create_nonce('enable-theme_' . $slug), 'theme' => $slug), network_admin_url('themes.php'));
        } else {
            $status['activateUrl'] = add_query_arg(array('action' => 'activate', '_wpnonce' => wp_create_nonce('switch-theme_' . $slug), 'stylesheet' => $slug), admin_url('themes.php'));
        }
    }
    if (!is_multisite() && current_user_can('edit_theme_options') && current_user_can('customize')) {
        $status['customizeUrl'] = add_query_arg(array('return' => urlencode(network_admin_url('theme-install.php', 'relative'))), wp_customize_url($slug));
    }
    /*
     * See WP_Theme_Install_List_Table::_get_theme_status() if we wanted to check
     * on post-installation status.
     */
    wp_send_json_success($status);
}
/**
 * Ajax handler for updating a theme.
 *
 * @since 4.6.0
 *
 * @see Theme_Upgrader
 *
 * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
 */
function wp_ajax_update_theme()
{
    check_ajax_referer('updates');
    if (empty($_POST['slug'])) {
        wp_send_json_error(array('slug' => '', 'errorCode' => 'no_theme_specified', 'errorMessage' => __('No theme specified.')));
    }
    $stylesheet = preg_replace('/[^A-z0-9_\\-]/', '', wp_unslash($_POST['slug']));
    $status = array('update' => 'theme', 'slug' => $stylesheet, 'oldVersion' => '', 'newVersion' => '');
    if (!current_user_can('update_themes')) {
        $status['errorMessage'] = __('Sorry, you are not allowed to update themes for this site.');
        wp_send_json_error($status);
    }
    $theme = wp_get_theme($stylesheet);
    if ($theme->exists()) {
        $status['oldVersion'] = $theme->get('Version');
    }
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    $current = get_site_transient('update_themes');
    if (empty($current)) {
        wp_update_themes();
    }
    $skin = new WP_Ajax_Upgrader_Skin();
    $upgrader = new Theme_Upgrader($skin);
    $result = $upgrader->bulk_upgrade(array($stylesheet));
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $status['debug'] = $skin->get_upgrade_messages();
    }
    if (is_wp_error($skin->result)) {
        $status['errorCode'] = $skin->result->get_error_code();
        $status['errorMessage'] = $skin->result->get_error_message();
        wp_send_json_error($status);
    } elseif ($skin->get_errors()->has_errors()) {
        $status['errorMessage'] = $skin->get_error_messages();
        wp_send_json_error($status);
    } elseif (is_array($result) && !empty($result[$stylesheet])) {
        // Theme is already at the latest version.
        if (true === $result[$stylesheet]) {
            $status['errorMessage'] = $upgrader->strings['up_to_date'];
            wp_send_json_error($status);
        }
        $theme = wp_get_theme($stylesheet);
        if ($theme->exists()) {
            $status['newVersion'] = $theme->get('Version');
        }
        wp_send_json_success($status);
    } elseif (false === $result) {
        global $wp_filesystem;
        $status['errorCode'] = 'unable_to_connect_to_filesystem';
        $status['errorMessage'] = __('Unable to connect to the filesystem. Please confirm your credentials.');
        // Pass through the error from WP_Filesystem if one was raised.
        if ($wp_filesystem instanceof WP_Filesystem_Base && is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->has_errors()) {
            $status['errorMessage'] = esc_html($wp_filesystem->errors->get_error_message());
        }
        wp_send_json_error($status);
    }
    // An unhandled error occurred.
    $status['errorMessage'] = __('Theme update failed.');
    wp_send_json_error($status);
}
/**
 * Ajax handler for deleting a theme.
 *
 * @since 4.6.0
 *
 * @see delete_theme()
 *
 * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
 */
function wp_ajax_delete_theme()
{
    check_ajax_referer('updates');
    if (empty($_POST['slug'])) {
        wp_send_json_error(array('slug' => '', 'errorCode' => 'no_theme_specified', 'errorMessage' => __('No theme specified.')));
    }
    $stylesheet = preg_replace('/[^A-z0-9_\\-]/', '', wp_unslash($_POST['slug']));
    $status = array('delete' => 'theme', 'slug' => $stylesheet);
    if (!current_user_can('delete_themes')) {
        $status['errorMessage'] = __('Sorry, you are not allowed to delete themes on this site.');
        wp_send_json_error($status);
    }
    if (!wp_get_theme($stylesheet)->exists()) {
        $status['errorMessage'] = __('The requested theme does not exist.');
        wp_send_json_error($status);
    }
    // Check filesystem credentials. `delete_theme()` will bail otherwise.
    $url = wp_nonce_url('themes.php?action=delete&stylesheet=' . urlencode($stylesheet), 'delete-theme_' . $stylesheet);
    ob_start();
    $credentials = request_filesystem_credentials($url);
    ob_end_clean();
    if (false === $credentials || !WP_Filesystem($credentials)) {
        global $wp_filesystem;
        $status['errorCode'] = 'unable_to_connect_to_filesystem';
        $status['errorMessage'] = __('Unable to connect to the filesystem. Please confirm your credentials.');
        // Pass through the error from WP_Filesystem if one was raised.
        if ($wp_filesystem instanceof WP_Filesystem_Base && is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->has_errors()) {
            $status['errorMessage'] = esc_html($wp_filesystem->errors->get_error_message());
        }
        wp_send_json_error($status);
    }
    include_once ABSPATH . 'wp-admin/includes/theme.php';
    $result = delete_theme($stylesheet);
    if (is_wp_error($result)) {
        $status['errorMessage'] = $result->get_error_message();
        wp_send_json_error($status);
    } elseif (false === $result) {
        $status['errorMessage'] = __('Theme could not be deleted.');
        wp_send_json_error($status);
    }
    wp_send_json_success($status);
}
/**
 * Ajax handler for installing a plugin.
 *
 * @since 4.6.0
 *
 * @see Plugin_Upgrader
 *
 * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
 */
function wp_ajax_install_plugin()
{
    check_ajax_referer('updates');
    if (empty($_POST['slug'])) {
        wp_send_json_error(array('slug' => '', 'errorCode' => 'no_plugin_specified', 'errorMessage' => __('No plugin specified.')));
    }
    $status = array('install' => 'plugin', 'slug' => sanitize_key(wp_unslash($_POST['slug'])));
    if (!current_user_can('install_plugins')) {
        $status['errorMessage'] = __('Sorry, you are not allowed to install plugins on this site.');
        wp_send_json_error($status);
    }
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    $api = plugins_api('plugin_information', array('slug' => sanitize_key(wp_unslash($_POST['slug'])), 'fields' => array('sections' => false)));
    if (is_wp_error($api)) {
        $status['errorMessage'] = $api->get_error_message();
        wp_send_json_error($status);
    }
    $status['pluginName'] = $api->name;
    $skin = new WP_Ajax_Upgrader_Skin();
    $upgrader = new Plugin_Upgrader($skin);
    $result = $upgrader->install($api->download_link);
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $status['debug'] = $skin->get_upgrade_messages();
    }
    if (is_wp_error($result)) {
        $status['errorCode'] = $result->get_error_code();
        $status['errorMessage'] = $result->get_error_message();
        wp_send_json_error($status);
    } elseif (is_wp_error($skin->result)) {
        $status['errorCode'] = $skin->result->get_error_code();
        $status['errorMessage'] = $skin->result->get_error_message();
        wp_send_json_error($status);
    } elseif ($skin->get_errors()->has_errors()) {
        $status['errorMessage'] = $skin->get_error_messages();
        wp_send_json_error($status);
    } elseif (is_null($result)) {
        global $wp_filesystem;
        $status['errorCode'] = 'unable_to_connect_to_filesystem';
        $status['errorMessage'] = __('Unable to connect to the filesystem. Please confirm your credentials.');
        // Pass through the error from WP_Filesystem if one was raised.
        if ($wp_filesystem instanceof WP_Filesystem_Base && is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->has_errors()) {
            $status['errorMessage'] = esc_html($wp_filesystem->errors->get_error_message());
        }
        wp_send_json_error($status);
    }
    $install_status = install_plugin_install_status($api);
    $pagenow = isset($_POST['pagenow']) ? sanitize_key($_POST['pagenow']) : '';
    // If installation request is coming from import page, do not return network activation link.
    $plugins_url = 'import' === $pagenow ? admin_url('plugins.php') : network_admin_url('plugins.php');
    if (current_user_can('activate_plugin', $install_status['file']) && is_plugin_inactive($install_status['file'])) {
        $status['activateUrl'] = add_query_arg(array('_wpnonce' => wp_create_nonce('activate-plugin_' . $install_status['file']), 'action' => 'activate', 'plugin' => $install_status['file']), $plugins_url);
    }
    if (is_multisite() && current_user_can('manage_network_plugins') && 'import' !== $pagenow) {
        $status['activateUrl'] = add_query_arg(array('networkwide' => 1), $status['activateUrl']);
    }
    wp_send_json_success($status);
}
/**
 * Ajax handler for updating a plugin.
 *
 * @since 4.2.0
 *
 * @see Plugin_Upgrader
 *
 * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
 */
function wp_ajax_update_plugin()
{
    check_ajax_referer('updates');
    if (empty($_POST['plugin']) || empty($_POST['slug'])) {
        wp_send_json_error(array('slug' => '', 'errorCode' => 'no_plugin_specified', 'errorMessage' => __('No plugin specified.')));
    }
    $plugin = plugin_basename(sanitize_text_field(wp_unslash($_POST['plugin'])));
    $status = array('update' => 'plugin', 'slug' => sanitize_key(wp_unslash($_POST['slug'])), 'oldVersion' => '', 'newVersion' => '');
    if (!current_user_can('update_plugins') || 0 !== validate_file($plugin)) {
        $status['errorMessage'] = __('Sorry, you are not allowed to update plugins for this site.');
        wp_send_json_error($status);
    }
    $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
    $status['plugin'] = $plugin;
    $status['pluginName'] = $plugin_data['Name'];
    if ($plugin_data['Version']) {
        /* translators: %s: Plugin version. */
        $status['oldVersion'] = sprintf(__('Version %s'), $plugin_data['Version']);
    }
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    wp_update_plugins();
    $skin = new WP_Ajax_Upgrader_Skin();
    $upgrader = new Plugin_Upgrader($skin);
    $result = $upgrader->bulk_upgrade(array($plugin));
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $status['debug'] = $skin->get_upgrade_messages();
    }
    if (is_wp_error($skin->result)) {
        $status['errorCode'] = $skin->result->get_error_code();
        $status['errorMessage'] = $skin->result->get_error_message();
        wp_send_json_error($status);
    } elseif ($skin->get_errors()->has_errors()) {
        $status['errorMessage'] = $skin->get_error_messages();
        wp_send_json_error($status);
    } elseif (is_array($result) && !empty($result[$plugin])) {
        /*
         * Plugin is already at the latest version.
         *
         * This may also be the return value if the `update_plugins` site transient is empty,
         * e.g. when you update two plugins in quick succession before the transient repopulates.
         *
         * Preferably something can be done to ensure `update_plugins` isn't empty.
         * For now, surface some sort of error here.
         */
        if (true === $result[$plugin]) {
            $status['errorMessage'] = $upgrader->strings['up_to_date'];
            wp_send_json_error($status);
        }
        $plugin_data = get_plugins('/' . $result[$plugin]['destination_name']);
        $plugin_data = reset($plugin_data);
        if ($plugin_data['Version']) {
            /* translators: %s: Plugin version. */
            $status['newVersion'] = sprintf(__('Version %s'), $plugin_data['Version']);
        }
        wp_send_json_success($status);
    } elseif (false === $result) {
        global $wp_filesystem;
        $status['errorCode'] = 'unable_to_connect_to_filesystem';
        $status['errorMessage'] = __('Unable to connect to the filesystem. Please confirm your credentials.');
        // Pass through the error from WP_Filesystem if one was raised.
        if ($wp_filesystem instanceof WP_Filesystem_Base && is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->has_errors()) {
            $status['errorMessage'] = esc_html($wp_filesystem->errors->get_error_message());
        }
        wp_send_json_error($status);
    }
    // An unhandled error occurred.
    $status['errorMessage'] = __('Plugin update failed.');
    wp_send_json_error($status);
}
/**
 * Ajax handler for deleting a plugin.
 *
 * @since 4.6.0
 *
 * @see delete_plugins()
 *
 * @global WP_Filesystem_Base $wp_filesystem WordPress filesystem subclass.
 */
function wp_ajax_delete_plugin()
{
    check_ajax_referer('updates');
    if (empty($_POST['slug']) || empty($_POST['plugin'])) {
        wp_send_json_error(array('slug' => '', 'errorCode' => 'no_plugin_specified', 'errorMessage' => __('No plugin specified.')));
    }
    $plugin = plugin_basename(sanitize_text_field(wp_unslash($_POST['plugin'])));
    $status = array('delete' => 'plugin', 'slug' => sanitize_key(wp_unslash($_POST['slug'])));
    if (!current_user_can('delete_plugins') || 0 !== validate_file($plugin)) {
        $status['errorMessage'] = __('Sorry, you are not allowed to delete plugins for this site.');
        wp_send_json_error($status);
    }
    $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
    $status['plugin'] = $plugin;
    $status['pluginName'] = $plugin_data['Name'];
    if (is_plugin_active($plugin)) {
        $status['errorMessage'] = __('You cannot delete a plugin while it is active on the main site.');
        wp_send_json_error($status);
    }
    // Check filesystem credentials. `delete_plugins()` will bail otherwise.
    $url = wp_nonce_url('plugins.php?action=delete-selected&verify-delete=1&checked[]=' . $plugin, 'bulk-plugins');
    ob_start();
    $credentials = request_filesystem_credentials($url);
    ob_end_clean();
    if (false === $credentials || !WP_Filesystem($credentials)) {
        global $wp_filesystem;
        $status['errorCode'] = 'unable_to_connect_to_filesystem';
        $status['errorMessage'] = __('Unable to connect to the filesystem. Please confirm your credentials.');
        // Pass through the error from WP_Filesystem if one was raised.
        if ($wp_filesystem instanceof WP_Filesystem_Base && is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->has_errors()) {
            $status['errorMessage'] = esc_html($wp_filesystem->errors->get_error_message());
        }
        wp_send_json_error($status);
    }
    $result = delete_plugins(array($plugin));
    if (is_wp_error($result)) {
        $status['errorMessage'] = $result->get_error_message();
        wp_send_json_error($status);
    } elseif (false === $result) {
        $status['errorMessage'] = __('Plugin could not be deleted.');
        wp_send_json_error($status);
    }
    wp_send_json_success($status);
}
/**
 * Ajax handler for searching plugins.
 *
 * @since 4.6.0
 *
 * @global string $s Search term.
 */
function wp_ajax_search_plugins()
{
    check_ajax_referer('updates');
    // Ensure after_plugin_row_{$plugin_file} gets hooked.
    wp_plugin_update_rows();
    $pagenow = isset($_POST['pagenow']) ? sanitize_key($_POST['pagenow']) : '';
    if ('plugins-network' === $pagenow || 'plugins' === $pagenow) {
        set_current_screen($pagenow);
    }
    /** @var WP_Plugins_List_Table $wp_list_table */
    $wp_list_table = _get_list_table('WP_Plugins_List_Table', array('screen' => get_current_screen()));
    $status = array();
    if (!$wp_list_table->ajax_user_can()) {
        $status['errorMessage'] = __('Sorry, you are not allowed to manage plugins for this site.');
        wp_send_json_error($status);
    }
    // Set the correct requester, so pagination works.
    $_SERVER['REQUEST_URI'] = add_query_arg(array_diff_key($_POST, array('_ajax_nonce' => null, 'action' => null)), network_admin_url('plugins.php', 'relative'));
    $GLOBALS['s'] = wp_unslash($_POST['s']);
    $wp_list_table->prepare_items();
    ob_start();
    $wp_list_table->display();
    $status['count'] = count($wp_list_table->items);
    $status['items'] = ob_get_clean();
    wp_send_json_success($status);
}
/**
 * Ajax handler for searching plugins to install.
 *
 * @since 4.6.0
 */
function wp_ajax_search_install_plugins()
{
    check_ajax_referer('updates');
    $pagenow = isset($_POST['pagenow']) ? sanitize_key($_POST['pagenow']) : '';
    if ('plugin-install-network' === $pagenow || 'plugin-install' === $pagenow) {
        set_current_screen($pagenow);
    }
    /** @var WP_Plugin_Install_List_Table $wp_list_table */
    $wp_list_table = _get_list_table('WP_Plugin_Install_List_Table', array('screen' => get_current_screen()));
    $status = array();
    if (!$wp_list_table->ajax_user_can()) {
        $status['errorMessage'] = __('Sorry, you are not allowed to manage plugins for this site.');
        wp_send_json_error($status);
    }
    // Set the correct requester, so pagination works.
    $_SERVER['REQUEST_URI'] = add_query_arg(array_diff_key($_POST, array('_ajax_nonce' => null, 'action' => null)), network_admin_url('plugin-install.php', 'relative'));
    $wp_list_table->prepare_items();
    ob_start();
    $wp_list_table->display();
    $status['count'] = (int) $wp_list_table->get_pagination_arg('total_items');
    $status['items'] = ob_get_clean();
    wp_send_json_success($status);
}
/**
 * Ajax handler for editing a theme or plugin file.
 *
 * @since 4.9.0
 *
 * @see wp_edit_theme_plugin_file()
 */
function wp_ajax_edit_theme_plugin_file()
{
    $r = wp_edit_theme_plugin_file(wp_unslash($_POST));
    // Validation of args is done in wp_edit_theme_plugin_file().
    if (is_wp_error($r)) {
        wp_send_json_error(array_merge(array('code' => $r->get_error_code(), 'message' => $r->get_error_message()), (array) $r->get_error_data()));
    } else {
        wp_send_json_success(array('message' => __('File edited successfully.')));
    }
}
/**
 * Ajax handler for exporting a user's personal data.
 *
 * @since 4.9.6
 */
function wp_ajax_wp_privacy_export_personal_data()
{
    if (empty($_POST['id'])) {
        wp_send_json_error(__('Missing request ID.'));
    }
    $request_id = (int) $_POST['id'];
    if ($request_id < 1) {
        wp_send_json_error(__('Invalid request ID.'));
    }
    if (!current_user_can('export_others_personal_data')) {
        wp_send_json_error(__('Sorry, you are not allowed to perform this action.'));
    }
    check_ajax_referer('wp-privacy-export-personal-data-' . $request_id, 'security');
    // Get the request.
    $request = wp_get_user_request($request_id);
    if (!$request || 'export_personal_data' !== $request->action_name) {
        wp_send_json_error(__('Invalid request type.'));
    }
    $email_address = $request->email;
    if (!is_email($email_address)) {
        wp_send_json_error(__('A valid email address must be given.'));
    }
    if (!isset($_POST['exporter'])) {
        wp_send_json_error(__('Missing exporter index.'));
    }
    $exporter_index = (int) $_POST['exporter'];
    if (!isset($_POST['page'])) {
        wp_send_json_error(__('Missing page index.'));
    }
    $page = (int) $_POST['page'];
    $send_as_email = isset($_POST['sendAsEmail']) ? 'true' === $_POST['sendAsEmail'] : false;
    /**
     * Filters the array of exporter callbacks.
     *
     * @since 4.9.6
     *
     * @param array $args {
     *     An array of callable exporters of personal data. Default empty array.
     *
     *     @type array ...$0 {
     *         Array of personal data exporters.
     *
     *         @type callable $callback               Callable exporter function that accepts an
     *                                                email address and a page and returns an array
     *                                                of name => value pairs of personal data.
     *         @type string   $exporter_friendly_name Translated user facing friendly name for the
     *                                                exporter.
     *     }
     * }
     */
    $exporters = apply_filters('wp_privacy_personal_data_exporters', array());
    if (!is_array($exporters)) {
        wp_send_json_error(__('An exporter has improperly used the registration filter.'));
    }
    // Do we have any registered exporters?
    if (0 < count($exporters)) {
        if ($exporter_index < 1) {
            wp_send_json_error(__('Exporter index cannot be negative.'));
        }
        if ($exporter_index > count($exporters)) {
            wp_send_json_error(__('Exporter index is out of range.'));
        }
        if ($page < 1) {
            wp_send_json_error(__('Page index cannot be less than one.'));
        }
        $exporter_keys = array_keys($exporters);
        $exporter_key = $exporter_keys[$exporter_index - 1];
        $exporter = $exporters[$exporter_key];
        if (!is_array($exporter)) {
            wp_send_json_error(
                /* translators: %s: Exporter array index. */
                sprintf(__('Expected an array describing the exporter at index %s.'), $exporter_key)
            );
        }
        if (!array_key_exists('exporter_friendly_name', $exporter)) {
            wp_send_json_error(
                /* translators: %s: Exporter array index. */
                sprintf(__('Exporter array at index %s does not include a friendly name.'), $exporter_key)
            );
        }
        $exporter_friendly_name = $exporter['exporter_friendly_name'];
        if (!array_key_exists('callback', $exporter)) {
            wp_send_json_error(
                /* translators: %s: Exporter friendly name. */
                sprintf(__('Exporter does not include a callback: %s.'), esc_html($exporter_friendly_name))
            );
        }
        if (!is_callable($exporter['callback'])) {
            wp_send_json_error(
                /* translators: %s: Exporter friendly name. */
                sprintf(__('Exporter callback is not a valid callback: %s.'), esc_html($exporter_friendly_name))
            );
        }
        $callback = $exporter['callback'];
        $response = call_user_func($callback, $email_address, $page);
        if (is_wp_error($response)) {
            wp_send_json_error($response);
        }
        if (!is_array($response)) {
            wp_send_json_error(
                /* translators: %s: Exporter friendly name. */
                sprintf(__('Expected response as an array from exporter: %s.'), esc_html($exporter_friendly_name))
            );
        }
        if (!array_key_exists('data', $response)) {
            wp_send_json_error(
                /* translators: %s: Exporter friendly name. */
                sprintf(__('Expected data in response array from exporter: %s.'), esc_html($exporter_friendly_name))
            );
        }
        if (!is_array($response['data'])) {
            wp_send_json_error(
                /* translators: %s: Exporter friendly name. */
                sprintf(__('Expected data array in response array from exporter: %s.'), esc_html($exporter_friendly_name))
            );
        }
        if (!array_key_exists('done', $response)) {
            wp_send_json_error(
                /* translators: %s: Exporter friendly name. */
                sprintf(__('Expected done (boolean) in response array from exporter: %s.'), esc_html($exporter_friendly_name))
            );
        }
    } else {
        // No exporters, so we're done.
        $exporter_key = '';
        $response = array('data' => array(), 'done' => true);
    }
    /**
     * Filters a page of personal data exporter data. Used to build the export report.
     *
     * Allows the export response to be consumed by destinations in addition to Ajax.
     *
     * @since 4.9.6
     *
     * @param array  $response        The personal data for the given exporter and page.
     * @param int    $exporter_index  The index of the exporter that provided this data.
     * @param string $email_address   The email address associated with this personal data.
     * @param int    $page            The page for this response.
     * @param int    $request_id      The privacy request post ID associated with this request.
     * @param bool   $send_as_email   Whether the final results of the export should be emailed to the user.
     * @param string $exporter_key    The key (slug) of the exporter that provided this data.
     */
    $response = apply_filters('wp_privacy_personal_data_export_page', $response, $exporter_index, $email_address, $page, $request_id, $send_as_email, $exporter_key);
    if (is_wp_error($response)) {
        wp_send_json_error($response);
    }
    wp_send_json_success($response);
}
/**
 * Ajax handler for erasing personal data.
 *
 * @since 4.9.6
 */
function wp_ajax_wp_privacy_erase_personal_data()
{
    if (empty($_POST['id'])) {
        wp_send_json_error(__('Missing request ID.'));
    }
    $request_id = (int) $_POST['id'];
    if ($request_id < 1) {
        wp_send_json_error(__('Invalid request ID.'));
    }
    // Both capabilities are required to avoid confusion, see `_wp_personal_data_removal_page()`.
    if (!current_user_can('erase_others_personal_data') || !current_user_can('delete_users')) {
        wp_send_json_error(__('Sorry, you are not allowed to perform this action.'));
    }
    check_ajax_referer('wp-privacy-erase-personal-data-' . $request_id, 'security');
    // Get the request.
    $request = wp_get_user_request($request_id);
    if (!$request || 'remove_personal_data' !== $request->action_name) {
        wp_send_json_error(__('Invalid request type.'));
    }
    $email_address = $request->email;
    if (!is_email($email_address)) {
        wp_send_json_error(__('Invalid email address in request.'));
    }
    if (!isset($_POST['eraser'])) {
        wp_send_json_error(__('Missing eraser index.'));
    }
    $eraser_index = (int) $_POST['eraser'];
    if (!isset($_POST['page'])) {
        wp_send_json_error(__('Missing page index.'));
    }
    $page = (int) $_POST['page'];
    /**
     * Filters the array of personal data eraser callbacks.
     *
     * @since 4.9.6
     *
     * @param array $args {
     *     An array of callable erasers of personal data. Default empty array.
     *
     *     @type array ...$0 {
     *         Array of personal data exporters.
     *
     *         @type callable $callback               Callable eraser that accepts an email address and
     *                                                a page and returns an array with boolean values for
     *                                                whether items were removed or retained and any messages
     *                                                from the eraser, as well as if additional pages are
     *                                                available.
     *         @type string   $exporter_friendly_name Translated user facing friendly name for the eraser.
     *     }
     * }
     */
    $erasers = apply_filters('wp_privacy_personal_data_erasers', array());
    // Do we have any registered erasers?
    if (0 < count($erasers)) {
        if ($eraser_index < 1) {
            wp_send_json_error(__('Eraser index cannot be less than one.'));
        }
        if ($eraser_index > count($erasers)) {
            wp_send_json_error(__('Eraser index is out of range.'));
        }
        if ($page < 1) {
            wp_send_json_error(__('Page index cannot be less than one.'));
        }
        $eraser_keys = array_keys($erasers);
        $eraser_key = $eraser_keys[$eraser_index - 1];
        $eraser = $erasers[$eraser_key];
        if (!is_array($eraser)) {
            /* translators: %d: Eraser array index. */
            wp_send_json_error(sprintf(__('Expected an array describing the eraser at index %d.'), $eraser_index));
        }
        if (!array_key_exists('eraser_friendly_name', $eraser)) {
            /* translators: %d: Eraser array index. */
            wp_send_json_error(sprintf(__('Eraser array at index %d does not include a friendly name.'), $eraser_index));
        }
        $eraser_friendly_name = $eraser['eraser_friendly_name'];
        if (!array_key_exists('callback', $eraser)) {
            wp_send_json_error(sprintf(
                /* translators: %s: Eraser friendly name. */
                __('Eraser does not include a callback: %s.'),
                esc_html($eraser_friendly_name)
            ));
        }
        if (!is_callable($eraser['callback'])) {
            wp_send_json_error(sprintf(
                /* translators: %s: Eraser friendly name. */
                __('Eraser callback is not valid: %s.'),
                esc_html($eraser_friendly_name)
            ));
        }
        $callback = $eraser['callback'];
        $response = call_user_func($callback, $email_address, $page);
        if (is_wp_error($response)) {
            wp_send_json_error($response);
        }
        if (!is_array($response)) {
            wp_send_json_error(sprintf(
                /* translators: 1: Eraser friendly name, 2: Eraser array index. */
                __('Did not receive array from %1$s eraser (index %2$d).'),
                esc_html($eraser_friendly_name),
                $eraser_index
            ));
        }
        if (!array_key_exists('items_removed', $response)) {
            wp_send_json_error(sprintf(
                /* translators: 1: Eraser friendly name, 2: Eraser array index. */
                __('Expected items_removed key in response array from %1$s eraser (index %2$d).'),
                esc_html($eraser_friendly_name),
                $eraser_index
            ));
        }
        if (!array_key_exists('items_retained', $response)) {
            wp_send_json_error(sprintf(
                /* translators: 1: Eraser friendly name, 2: Eraser array index. */
                __('Expected items_retained key in response array from %1$s eraser (index %2$d).'),
                esc_html($eraser_friendly_name),
                $eraser_index
            ));
        }
        if (!array_key_exists('messages', $response)) {
            wp_send_json_error(sprintf(
                /* translators: 1: Eraser friendly name, 2: Eraser array index. */
                __('Expected messages key in response array from %1$s eraser (index %2$d).'),
                esc_html($eraser_friendly_name),
                $eraser_index
            ));
        }
        if (!is_array($response['messages'])) {
            wp_send_json_error(sprintf(
                /* translators: 1: Eraser friendly name, 2: Eraser array index. */
                __('Expected messages key to reference an array in response array from %1$s eraser (index %2$d).'),
                esc_html($eraser_friendly_name),
                $eraser_index
            ));
        }
        if (!array_key_exists('done', $response)) {
            wp_send_json_error(sprintf(
                /* translators: 1: Eraser friendly name, 2: Eraser array index. */
                __('Expected done flag in response array from %1$s eraser (index %2$d).'),
                esc_html($eraser_friendly_name),
                $eraser_index
            ));
        }
    } else {
        // No erasers, so we're done.
        $eraser_key = '';
        $response = array('items_removed' => false, 'items_retained' => false, 'messages' => array(), 'done' => true);
    }
    /**
     * Filters a page of personal data eraser data.
     *
     * Allows the erasure response to be consumed by destinations in addition to Ajax.
     *
     * @since 4.9.6
     *
     * @param array  $response        The personal data for the given exporter and page.
     * @param int    $eraser_index    The index of the eraser that provided this data.
     * @param string $email_address   The email address associated with this personal data.
     * @param int    $page            The page for this response.
     * @param int    $request_id      The privacy request post ID associated with this request.
     * @param string $eraser_key      The key (slug) of the eraser that provided this data.
     */
    $response = apply_filters('wp_privacy_personal_data_erasure_page', $response, $eraser_index, $email_address, $page, $request_id, $eraser_key);
    if (is_wp_error($response)) {
        wp_send_json_error($response);
    }
    wp_send_json_success($response);
}
/**
 * Ajax handler for site health checks on server communication.
 *
 * @since 5.2.0
 * @deprecated 5.6.0 Use WP_REST_Site_Health_Controller::test_dotorg_communication()
 * @see WP_REST_Site_Health_Controller::test_dotorg_communication()
 */
function wp_ajax_health_check_dotorg_communication()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_health_check_dotorg_communication") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 3793")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_health_check_dotorg_communication:3793@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for site health checks on background updates.
 *
 * @since 5.2.0
 * @deprecated 5.6.0 Use WP_REST_Site_Health_Controller::test_background_updates()
 * @see WP_REST_Site_Health_Controller::test_background_updates()
 */
function wp_ajax_health_check_background_updates()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_health_check_background_updates") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 3818")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_health_check_background_updates:3818@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for site health checks on loopback requests.
 *
 * @since 5.2.0
 * @deprecated 5.6.0 Use WP_REST_Site_Health_Controller::test_loopback_requests()
 * @see WP_REST_Site_Health_Controller::test_loopback_requests()
 */
function wp_ajax_health_check_loopback_requests()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_health_check_loopback_requests") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 3843")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_health_check_loopback_requests:3843@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for site health check to update the result status.
 *
 * @since 5.2.0
 */
function wp_ajax_health_check_site_status_result()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_health_check_site_status_result") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 3866")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_health_check_site_status_result:3866@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler for site health check to get directories and database sizes.
 *
 * @since 5.2.0
 * @deprecated 5.6.0 Use WP_REST_Site_Health_Controller::get_directory_sizes()
 * @see WP_REST_Site_Health_Controller::get_directory_sizes()
 */
function wp_ajax_health_check_get_sizes()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_health_check_get_sizes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 3882")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_health_check_get_sizes:3882@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler to renew the REST API nonce.
 *
 * @since 5.3.0
 */
function wp_ajax_rest_nonce()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_rest_nonce") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 3931")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_rest_nonce:3931@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler to enable or disable plugin and theme auto-updates.
 *
 * @since 5.5.0
 */
function wp_ajax_toggle_auto_updates()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_toggle_auto_updates") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php at line 3940")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_toggle_auto_updates:3940@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-admin/includes/ajax-actions.php');
    die();
}
/**
 * Ajax handler sends a password reset link.
 *
 * @since 5.7.0
 */
function wp_ajax_send_password_reset()
{
    // Validate the nonce for this action.
    $user_id = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;
    check_ajax_referer('reset-password-for-' . $user_id, 'nonce');
    // Verify user capabilities.
    if (!current_user_can('edit_user', $user_id)) {
        wp_send_json_error(__('Cannot send password reset, permission denied.'));
    }
    // Send the password reset link.
    $user = get_userdata($user_id);
    $results = retrieve_password($user->user_login);
    if (true === $results) {
        wp_send_json_success(
            /* translators: %s: User's display name. */
            sprintf(__('A password reset link was emailed to %s.'), $user->display_name)
        );
    } else {
        wp_send_json_error($results->get_error_message());
    }
}