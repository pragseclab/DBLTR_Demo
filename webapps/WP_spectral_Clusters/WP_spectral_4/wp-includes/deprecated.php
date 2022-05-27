<?php

/**
 * Deprecated functions from past WordPress versions. You shouldn't use these
 * functions and look for the alternatives instead. The functions will be
 * removed in a later version.
 *
 * @package WordPress
 * @subpackage Deprecated
 */
/*
 * Deprecated functions come here to die.
 */
/**
 * Retrieves all post data for a given post.
 *
 * @since 0.71
 * @deprecated 1.5.1 Use get_post()
 * @see get_post()
 *
 * @param int $postid Post ID.
 * @return array Post data.
 */
function get_postdata($postid)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_postdata") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 26")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_postdata:26@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Sets up the WordPress Loop.
 *
 * Use The Loop instead.
 *
 * @link https://developer.wordpress.org/themes/basics/the-loop/
 *
 * @since 1.0.1
 * @deprecated 1.5.0
 */
function start_wp()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("start_wp") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 43")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called start_wp:43@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Returns or prints a category ID.
 *
 * @since 0.71
 * @deprecated 0.71 Use get_the_category()
 * @see get_the_category()
 *
 * @param bool $echo Optional. Whether to echo the output. Default true.
 * @return int Category ID.
 */
function the_category_ID($echo = true)
{
    _deprecated_function(__FUNCTION__, '0.71', 'get_the_category()');
    // Grab the first cat in the list.
    $categories = get_the_category();
    $cat = $categories[0]->term_id;
    if ($echo) {
        echo $cat;
    }
    return $cat;
}
/**
 * Prints a category with optional text before and after.
 *
 * @since 0.71
 * @deprecated 0.71 Use get_the_category_by_ID()
 * @see get_the_category_by_ID()
 *
 * @param string $before Optional. Text to display before the category. Default empty.
 * @param string $after  Optional. Text to display after the category. Default empty.
 */
function the_category_head($before = '', $after = '')
{
    global $currentcat, $previouscat;
    _deprecated_function(__FUNCTION__, '0.71', 'get_the_category_by_ID()');
    // Grab the first cat in the list.
    $categories = get_the_category();
    $currentcat = $categories[0]->category_id;
    if ($currentcat != $previouscat) {
        echo $before;
        echo get_the_category_by_ID($currentcat);
        echo $after;
        $previouscat = $currentcat;
    }
}
/**
 * Prints a link to the previous post.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use previous_post_link()
 * @see previous_post_link()
 *
 * @param string $format
 * @param string $previous
 * @param string $title
 * @param string $in_same_cat
 * @param int    $limitprev
 * @param string $excluded_categories
 */
function previous_post($format = '%', $previous = 'previous post: ', $title = 'yes', $in_same_cat = 'no', $limitprev = 1, $excluded_categories = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("previous_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 110")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called previous_post:110@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Prints link to the next post.
 *
 * @since 0.71
 * @deprecated 2.0.0 Use next_post_link()
 * @see next_post_link()
 *
 * @param string $format
 * @param string $next
 * @param string $title
 * @param string $in_same_cat
 * @param int $limitnext
 * @param string $excluded_categories
 */
function next_post($format = '%', $next = 'next post: ', $title = 'yes', $in_same_cat = 'no', $limitnext = 1, $excluded_categories = '')
{
    _deprecated_function(__FUNCTION__, '2.0.0', 'next_post_link()');
    if (empty($in_same_cat) || 'no' == $in_same_cat) {
        $in_same_cat = false;
    } else {
        $in_same_cat = true;
    }
    $post = get_next_post($in_same_cat, $excluded_categories);
    if (!$post) {
        return;
    }
    $string = '<a href="' . get_permalink($post->ID) . '">' . $next;
    if ('yes' == $title) {
        $string .= apply_filters('the_title', $post->post_title, $post->ID);
    }
    $string .= '</a>';
    $format = str_replace('%', $string, $format);
    echo $format;
}
/**
 * Whether user can create a post.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use current_user_can()
 * @see current_user_can()
 *
 * @param int $user_id
 * @param int $blog_id Not Used
 * @param int $category_id Not Used
 * @return bool
 */
function user_can_create_post($user_id, $blog_id = 1, $category_id = 'None')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("user_can_create_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 176")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called user_can_create_post:176@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Whether user can create a post.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use current_user_can()
 * @see current_user_can()
 *
 * @param int $user_id
 * @param int $blog_id Not Used
 * @param int $category_id Not Used
 * @return bool
 */
function user_can_create_draft($user_id, $blog_id = 1, $category_id = 'None')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("user_can_create_draft") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 194")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called user_can_create_draft:194@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Whether user can edit a post.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use current_user_can()
 * @see current_user_can()
 *
 * @param int $user_id
 * @param int $post_id
 * @param int $blog_id Not Used
 * @return bool
 */
function user_can_edit_post($user_id, $post_id, $blog_id = 1)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("user_can_edit_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 212")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called user_can_edit_post:212@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Whether user can delete a post.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use current_user_can()
 * @see current_user_can()
 *
 * @param int $user_id
 * @param int $post_id
 * @param int $blog_id Not Used
 * @return bool
 */
function user_can_delete_post($user_id, $post_id, $blog_id = 1)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("user_can_delete_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 236")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called user_can_delete_post:236@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Whether user can set new posts' dates.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use current_user_can()
 * @see current_user_can()
 *
 * @param int $user_id
 * @param int $blog_id Not Used
 * @param int $category_id Not Used
 * @return bool
 */
function user_can_set_post_date($user_id, $blog_id = 1, $category_id = 'None')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("user_can_set_post_date") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 254")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called user_can_set_post_date:254@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Whether user can delete a post.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use current_user_can()
 * @see current_user_can()
 *
 * @param int $user_id
 * @param int $post_id
 * @param int $blog_id Not Used
 * @return bool returns true if $user_id can edit $post_id's date
 */
function user_can_edit_post_date($user_id, $post_id, $blog_id = 1)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("user_can_edit_post_date") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 272")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called user_can_edit_post_date:272@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Whether user can delete a post.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use current_user_can()
 * @see current_user_can()
 *
 * @param int $user_id
 * @param int $post_id
 * @param int $blog_id Not Used
 * @return bool returns true if $user_id can edit $post_id's comments
 */
function user_can_edit_post_comments($user_id, $post_id, $blog_id = 1)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("user_can_edit_post_comments") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 290")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called user_can_edit_post_comments:290@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Whether user can delete a post.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use current_user_can()
 * @see current_user_can()
 *
 * @param int $user_id
 * @param int $post_id
 * @param int $blog_id Not Used
 * @return bool returns true if $user_id can delete $post_id's comments
 */
function user_can_delete_post_comments($user_id, $post_id, $blog_id = 1)
{
    _deprecated_function(__FUNCTION__, '2.0.0', 'current_user_can()');
    // Right now if one can edit comments, one can delete comments.
    return user_can_edit_post_comments($user_id, $post_id, $blog_id);
}
/**
 * Can user can edit other user.
 *
 * @since 1.5.0
 * @deprecated 2.0.0 Use current_user_can()
 * @see current_user_can()
 *
 * @param int $user_id
 * @param int $other_user
 * @return bool
 */
function user_can_edit_user($user_id, $other_user)
{
    _deprecated_function(__FUNCTION__, '2.0.0', 'current_user_can()');
    $user = get_userdata($user_id);
    $other = get_userdata($other_user);
    if ($user->user_level > $other->user_level || $user->user_level > 8 || $user->ID == $other->ID) {
        return true;
    } else {
        return false;
    }
}
/**
 * Gets the links associated with category $cat_name.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use get_bookmarks()
 * @see get_bookmarks()
 *
 * @param string $cat_name         Optional. The category name to use. If no match is found, uses all.
 *                                 Default 'noname'.
 * @param string $before           Optional. The HTML to output before the link. Default empty.
 * @param string $after            Optional. The HTML to output after the link. Default '<br />'.
 * @param string $between          Optional. The HTML to output between the link/image and its description.
 *                                 Not used if no image or $show_images is true. Default ' '.
 * @param bool   $show_images      Optional. Whether to show images (if defined). Default true.
 * @param string $orderby          Optional. The order to output the links. E.g. 'id', 'name', 'url',
 *                                 'description', 'rating', or 'owner'. Default 'id'.
 *                                 If you start the name with an underscore, the order will be reversed.
 *                                 Specifying 'rand' as the order will return links in a random order.
 * @param bool   $show_description Optional. Whether to show the description if show_images=false/not defined.
 *                                 Default true.
 * @param bool   $show_rating      Optional. Show rating stars/chars. Default false.
 * @param int    $limit            Optional. Limit to X entries. If not specified, all entries are shown.
 *                                 Default -1.
 * @param int    $show_updated     Optional. Whether to show last updated timestamp. Default 0.
 */
function get_linksbyname($cat_name = "noname", $before = '', $after = '<br />', $between = " ", $show_images = true, $orderby = 'id', $show_description = true, $show_rating = false, $limit = -1, $show_updated = 0)
{
    _deprecated_function(__FUNCTION__, '2.1.0', 'get_bookmarks()');
    $cat_id = -1;
    $cat = get_term_by('name', $cat_name, 'link_category');
    if ($cat) {
        $cat_id = $cat->term_id;
    }
    get_links($cat_id, $before, $after, $between, $show_images, $orderby, $show_description, $show_rating, $limit, $show_updated);
}
/**
 * Gets the links associated with the named category.
 *
 * @since 1.0.1
 * @deprecated 2.1.0 Use wp_list_bookmarks()
 * @see wp_list_bookmarks()
 *
 * @param string $category The category to use.
 * @param string $args
 * @return string|null
 */
function wp_get_linksbyname($category, $args = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_get_linksbyname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 382")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_get_linksbyname:382@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Gets an array of link objects associated with category $cat_name.
 *
 *     $links = get_linkobjectsbyname( 'fred' );
 *     foreach ( $links as $link ) {
 *      	echo '<li>' . $link->link_name . '</li>';
 *     }
 *
 * @since 1.0.1
 * @deprecated 2.1.0 Use get_bookmarks()
 * @see get_bookmarks()
 *
 * @param string $cat_name Optional. The category name to use. If no match is found, uses all.
 *                         Default 'noname'.
 * @param string $orderby  Optional. The order to output the links. E.g. 'id', 'name', 'url',
 *                         'description', 'rating', or 'owner'. Default 'name'.
 *                         If you start the name with an underscore, the order will be reversed.
 *                         Specifying 'rand' as the order will return links in a random order.
 * @param int    $limit    Optional. Limit to X entries. If not specified, all entries are shown.
 *                         Default -1.
 * @return array
 */
function get_linkobjectsbyname($cat_name = "noname", $orderby = 'name', $limit = -1)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_linkobjectsbyname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 411")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_linkobjectsbyname:411@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Gets an array of link objects associated with category n.
 *
 * Usage:
 *
 *     $links = get_linkobjects(1);
 *     if ($links) {
 *     	foreach ($links as $link) {
 *     		echo '<li>'.$link->link_name.'<br />'.$link->link_description.'</li>';
 *     	}
 *     }
 *
 * Fields are:
 *
 * - link_id
 * - link_url
 * - link_name
 * - link_image
 * - link_target
 * - link_category
 * - link_description
 * - link_visible
 * - link_owner
 * - link_rating
 * - link_updated
 * - link_rel
 * - link_notes
 *
 * @since 1.0.1
 * @deprecated 2.1.0 Use get_bookmarks()
 * @see get_bookmarks()
 *
 * @param int    $category Optional. The category to use. If no category supplied, uses all.
 *                         Default 0.
 * @param string $orderby  Optional. The order to output the links. E.g. 'id', 'name', 'url',
 *                         'description', 'rating', or 'owner'. Default 'name'.
 *                         If you start the name with an underscore, the order will be reversed.
 *                         Specifying 'rand' as the order will return links in a random order.
 * @param int    $limit    Optional. Limit to X entries. If not specified, all entries are shown.
 *                         Default 0.
 * @return array
 */
function get_linkobjects($category = 0, $orderby = 'name', $limit = 0)
{
    _deprecated_function(__FUNCTION__, '2.1.0', 'get_bookmarks()');
    $links = get_bookmarks(array('category' => $category, 'orderby' => $orderby, 'limit' => $limit));
    $links_array = array();
    foreach ($links as $link) {
        $links_array[] = $link;
    }
    return $links_array;
}
/**
 * Gets the links associated with category 'cat_name' and display rating stars/chars.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use get_bookmarks()
 * @see get_bookmarks()
 *
 * @param string $cat_name         Optional. The category name to use. If no match is found, uses all.
 *                                 Default 'noname'.
 * @param string $before           Optional. The HTML to output before the link. Default empty.
 * @param string $after            Optional. The HTML to output after the link. Default '<br />'.
 * @param string $between          Optional. The HTML to output between the link/image and its description.
 *                                 Not used if no image or $show_images is true. Default ' '.
 * @param bool   $show_images      Optional. Whether to show images (if defined). Default true.
 * @param string $orderby          Optional. The order to output the links. E.g. 'id', 'name', 'url',
 *                                 'description', 'rating', or 'owner'. Default 'id'.
 *                                 If you start the name with an underscore, the order will be reversed.
 *                                 Specifying 'rand' as the order will return links in a random order.
 * @param bool   $show_description Optional. Whether to show the description if show_images=false/not defined.
 *                                 Default true.
 * @param int    $limit		       Optional. Limit to X entries. If not specified, all entries are shown.
 *                                 Default -1.
 * @param int    $show_updated     Optional. Whether to show last updated timestamp. Default 0.
 */
function get_linksbyname_withrating($cat_name = "noname", $before = '', $after = '<br />', $between = " ", $show_images = true, $orderby = 'id', $show_description = true, $limit = -1, $show_updated = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_linksbyname_withrating") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 497")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_linksbyname_withrating:497@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Gets the links associated with category n and display rating stars/chars.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use get_bookmarks()
 * @see get_bookmarks()
 *
 * @param int    $category         Optional. The category to use. If no category supplied, uses all.
 *                                 Default 0.
 * @param string $before           Optional. The HTML to output before the link. Default empty.
 * @param string $after            Optional. The HTML to output after the link. Default '<br />'.
 * @param string $between          Optional. The HTML to output between the link/image and its description.
 *                                 Not used if no image or $show_images is true. Default ' '.
 * @param bool   $show_images      Optional. Whether to show images (if defined). Default true.
 * @param string $orderby          Optional. The order to output the links. E.g. 'id', 'name', 'url',
 *                                 'description', 'rating', or 'owner'. Default 'id'.
 *                                 If you start the name with an underscore, the order will be reversed.
 *                                 Specifying 'rand' as the order will return links in a random order.
 * @param bool   $show_description Optional. Whether to show the description if show_images=false/not defined.
 *                                 Default true.
 * @param int    $limit		       Optional. Limit to X entries. If not specified, all entries are shown.
 *                                 Default -1.
 * @param int    $show_updated     Optional. Whether to show last updated timestamp. Default 0.
 */
function get_links_withrating($category = -1, $before = '', $after = '<br />', $between = " ", $show_images = true, $orderby = 'id', $show_description = true, $limit = -1, $show_updated = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_links_withrating") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 526")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_links_withrating:526@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Gets the auto_toggle setting.
 *
 * @since 0.71
 * @deprecated 2.1.0
 *
 * @param int $id The category to get. If no category supplied uses 0
 * @return int Only returns 0.
 */
function get_autotoggle($id = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_autotoggle") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 540")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_autotoggle:540@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Lists categories.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use wp_list_categories()
 * @see wp_list_categories()
 *
 * @param int $optionall
 * @param string $all
 * @param string $sort_column
 * @param string $sort_order
 * @param string $file
 * @param bool $list
 * @param int $optiondates
 * @param int $optioncount
 * @param int $hide_empty
 * @param int $use_desc_for_title
 * @param bool $children
 * @param int $child_of
 * @param int $categories
 * @param int $recurse
 * @param string $feed
 * @param string $feed_image
 * @param string $exclude
 * @param bool $hierarchical
 * @return null|false
 */
function list_cats($optionall = 1, $all = 'All', $sort_column = 'ID', $sort_order = 'asc', $file = '', $list = true, $optiondates = 0, $optioncount = 0, $hide_empty = 1, $use_desc_for_title = 1, $children = false, $child_of = 0, $categories = 0, $recurse = 0, $feed = '', $feed_image = '', $exclude = '', $hierarchical = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("list_cats") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 572")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called list_cats:572@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Lists categories.
 *
 * @since 1.2.0
 * @deprecated 2.1.0 Use wp_list_categories()
 * @see wp_list_categories()
 *
 * @param string|array $args
 * @return null|string|false
 */
function wp_list_cats($args = '')
{
    _deprecated_function(__FUNCTION__, '2.1.0', 'wp_list_categories()');
    $parsed_args = wp_parse_args($args);
    // Map to new names.
    if (isset($parsed_args['optionall']) && isset($parsed_args['all'])) {
        $parsed_args['show_option_all'] = $parsed_args['all'];
    }
    if (isset($parsed_args['sort_column'])) {
        $parsed_args['orderby'] = $parsed_args['sort_column'];
    }
    if (isset($parsed_args['sort_order'])) {
        $parsed_args['order'] = $parsed_args['sort_order'];
    }
    if (isset($parsed_args['optiondates'])) {
        $parsed_args['show_last_update'] = $parsed_args['optiondates'];
    }
    if (isset($parsed_args['optioncount'])) {
        $parsed_args['show_count'] = $parsed_args['optioncount'];
    }
    if (isset($parsed_args['list'])) {
        $parsed_args['style'] = $parsed_args['list'] ? 'list' : 'break';
    }
    $parsed_args['title_li'] = '';
    return wp_list_categories($parsed_args);
}
/**
 * Deprecated method for generating a drop-down of categories.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use wp_dropdown_categories()
 * @see wp_dropdown_categories()
 *
 * @param int $optionall
 * @param string $all
 * @param string $orderby
 * @param string $order
 * @param int $show_last_update
 * @param int $show_count
 * @param int $hide_empty
 * @param bool $optionnone
 * @param int $selected
 * @param int $exclude
 * @return string
 */
function dropdown_cats($optionall = 1, $all = 'All', $orderby = 'ID', $order = 'asc', $show_last_update = 0, $show_count = 0, $hide_empty = 1, $optionnone = false, $selected = 0, $exclude = 0)
{
    _deprecated_function(__FUNCTION__, '2.1.0', 'wp_dropdown_categories()');
    $show_option_all = '';
    if ($optionall) {
        $show_option_all = $all;
    }
    $show_option_none = '';
    if ($optionnone) {
        $show_option_none = __('None');
    }
    $vars = compact('show_option_all', 'show_option_none', 'orderby', 'order', 'show_last_update', 'show_count', 'hide_empty', 'selected', 'exclude');
    $query = add_query_arg($vars, '');
    return wp_dropdown_categories($query);
}
/**
 * Lists authors.
 *
 * @since 1.2.0
 * @deprecated 2.1.0 Use wp_list_authors()
 * @see wp_list_authors()
 *
 * @param bool $optioncount
 * @param bool $exclude_admin
 * @param bool $show_fullname
 * @param bool $hide_empty
 * @param string $feed
 * @param string $feed_image
 * @return null|string
 */
function list_authors($optioncount = false, $exclude_admin = true, $show_fullname = false, $hide_empty = true, $feed = '', $feed_image = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("list_authors") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 663")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called list_authors:663@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieves a list of post categories.
 *
 * @since 1.0.1
 * @deprecated 2.1.0 Use wp_get_post_categories()
 * @see wp_get_post_categories()
 *
 * @param int $blogid Not Used
 * @param int $post_ID
 * @return array
 */
function wp_get_post_cats($blogid = '1', $post_ID = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_get_post_cats") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 680")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_get_post_cats:680@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Sets the categories that the post ID belongs to.
 *
 * @since 1.0.1
 * @deprecated 2.1.0
 * @deprecated Use wp_set_post_categories()
 * @see wp_set_post_categories()
 *
 * @param int $blogid Not used
 * @param int $post_ID
 * @param array $post_categories
 * @return bool|mixed
 */
function wp_set_post_cats($blogid = '1', $post_ID = 0, $post_categories = array())
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_set_post_cats") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 698")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_set_post_cats:698@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieves a list of archives.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use wp_get_archives()
 * @see wp_get_archives()
 *
 * @param string $type
 * @param string $limit
 * @param string $format
 * @param string $before
 * @param string $after
 * @param bool $show_post_count
 * @return string|null
 */
function get_archives($type = '', $limit = '', $format = 'html', $before = '', $after = '', $show_post_count = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_archives") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 718")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_archives:718@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Returns or Prints link to the author's posts.
 *
 * @since 1.2.0
 * @deprecated 2.1.0 Use get_author_posts_url()
 * @see get_author_posts_url()
 *
 * @param bool $echo
 * @param int $author_id
 * @param string $author_nicename Optional.
 * @return string|null
 */
function get_author_link($echo, $author_id, $author_nicename = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_author_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 736")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_author_link:736@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Print list of pages based on arguments.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use wp_link_pages()
 * @see wp_link_pages()
 *
 * @param string $before
 * @param string $after
 * @param string $next_or_number
 * @param string $nextpagelink
 * @param string $previouspagelink
 * @param string $pagelink
 * @param string $more_file
 * @return string
 */
function link_pages($before = '<br />', $after = '<br />', $next_or_number = 'number', $nextpagelink = 'next page', $previouspagelink = 'previous page', $pagelink = '%', $more_file = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("link_pages") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 761")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called link_pages:761@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Get value based on option.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use get_option()
 * @see get_option()
 *
 * @param string $option
 * @return string
 */
function get_settings($option)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_settings") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 777")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_settings:777@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Print the permalink of the current post in the loop.
 *
 * @since 0.71
 * @deprecated 1.2.0 Use the_permalink()
 * @see the_permalink()
 */
function permalink_link()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("permalink_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 789")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called permalink_link:789@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Print the permalink to the RSS feed.
 *
 * @since 0.71
 * @deprecated 2.3.0 Use the_permalink_rss()
 * @see the_permalink_rss()
 *
 * @param string $deprecated
 */
function permalink_single_rss($deprecated = '')
{
    _deprecated_function(__FUNCTION__, '2.3.0', 'the_permalink_rss()');
    the_permalink_rss();
}
/**
 * Gets the links associated with category.
 *
 * @since 1.0.1
 * @deprecated 2.1.0 Use wp_list_bookmarks()
 * @see wp_list_bookmarks()
 *
 * @param string $args a query string
 * @return null|string
 */
function wp_get_links($args = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_get_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 818")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_get_links:818@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Gets the links associated with category by ID.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use get_bookmarks()
 * @see get_bookmarks()
 *
 * @param int    $category         Optional. The category to use. If no category supplied uses all.
 *                                 Default 0.
 * @param string $before           Optional. The HTML to output before the link. Default empty.
 * @param string $after            Optional. The HTML to output after the link. Default '<br />'.
 * @param string $between          Optional. The HTML to output between the link/image and its description.
 *                                 Not used if no image or $show_images is true. Default ' '.
 * @param bool   $show_images      Optional. Whether to show images (if defined). Default true.
 * @param string $orderby          Optional. The order to output the links. E.g. 'id', 'name', 'url',
 *                                 'description', 'rating', or 'owner'. Default 'name'.
 *                                 If you start the name with an underscore, the order will be reversed.
 *                                 Specifying 'rand' as the order will return links in a random order.
 * @param bool   $show_description Optional. Whether to show the description if show_images=false/not defined.
 *                                 Default true.
 * @param bool   $show_rating      Optional. Show rating stars/chars. Default false.
 * @param int    $limit            Optional. Limit to X entries. If not specified, all entries are shown.
 *                                 Default -1.
 * @param int    $show_updated     Optional. Whether to show last updated timestamp. Default 1.
 * @param bool   $echo             Whether to echo the results, or return them instead.
 * @return null|string
 */
function get_links($category = -1, $before = '', $after = '<br />', $between = ' ', $show_images = true, $orderby = 'name', $show_description = true, $show_rating = false, $limit = -1, $show_updated = 1, $echo = true)
{
    _deprecated_function(__FUNCTION__, '2.1.0', 'get_bookmarks()');
    $order = 'ASC';
    if (substr($orderby, 0, 1) == '_') {
        $order = 'DESC';
        $orderby = substr($orderby, 1);
    }
    if ($category == -1) {
        // get_bookmarks() uses '' to signify all categories.
        $category = '';
    }
    $results = get_bookmarks(array('category' => $category, 'orderby' => $orderby, 'order' => $order, 'show_updated' => $show_updated, 'limit' => $limit));
    if (!$results) {
        return;
    }
    $output = '';
    foreach ((array) $results as $row) {
        if (!isset($row->recently_updated)) {
            $row->recently_updated = false;
        }
        $output .= $before;
        if ($show_updated && $row->recently_updated) {
            $output .= get_option('links_recently_updated_prepend');
        }
        $the_link = '#';
        if (!empty($row->link_url)) {
            $the_link = esc_url($row->link_url);
        }
        $rel = $row->link_rel;
        if ('' != $rel) {
            $rel = ' rel="' . $rel . '"';
        }
        $desc = esc_attr(sanitize_bookmark_field('link_description', $row->link_description, $row->link_id, 'display'));
        $name = esc_attr(sanitize_bookmark_field('link_name', $row->link_name, $row->link_id, 'display'));
        $title = $desc;
        if ($show_updated) {
            if (substr($row->link_updated_f, 0, 2) != '00') {
                $title .= ' (' . __('Last updated') . ' ' . gmdate(get_option('links_updated_date_format'), $row->link_updated_f + get_option('gmt_offset') * HOUR_IN_SECONDS) . ')';
            }
        }
        if ('' != $title) {
            $title = ' title="' . $title . '"';
        }
        $alt = ' alt="' . $name . '"';
        $target = $row->link_target;
        if ('' != $target) {
            $target = ' target="' . $target . '"';
        }
        $output .= '<a href="' . $the_link . '"' . $rel . $title . $target . '>';
        if ($row->link_image != null && $show_images) {
            if (strpos($row->link_image, 'http') !== false) {
                $output .= "<img src=\"{$row->link_image}\" {$alt} {$title} />";
            } else {
                // If it's a relative path.
                $output .= "<img src=\"" . get_option('siteurl') . "{$row->link_image}\" {$alt} {$title} />";
            }
        } else {
            $output .= $name;
        }
        $output .= '</a>';
        if ($show_updated && $row->recently_updated) {
            $output .= get_option('links_recently_updated_append');
        }
        if ($show_description && '' != $desc) {
            $output .= $between . $desc;
        }
        if ($show_rating) {
            $output .= $between . get_linkrating($row);
        }
        $output .= "{$after}\n";
    }
    // End while.
    if (!$echo) {
        return $output;
    }
    echo $output;
}
/**
 * Output entire list of links by category.
 *
 * Output a list of all links, listed by category, using the settings in
 * $wpdb->linkcategories and output it as a nested HTML unordered list.
 *
 * @since 1.0.1
 * @deprecated 2.1.0 Use wp_list_bookmarks()
 * @see wp_list_bookmarks()
 *
 * @param string $order Sort link categories by 'name' or 'id'
 */
function get_links_list($order = 'name')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_links_list") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 946")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_links_list:946@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Show the link to the links popup and the number of links.
 *
 * @since 0.71
 * @deprecated 2.1.0
 *
 * @param string $text the text of the link
 * @param int $width the width of the popup window
 * @param int $height the height of the popup window
 * @param string $file the page to open in the popup window
 * @param bool $count the number of links in the db
 */
function links_popup_script($text = 'Links', $width = 400, $height = 400, $file = 'links.all.php', $count = true)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("links_popup_script") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 985")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called links_popup_script:985@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Legacy function that retrieved the value of a link's link_rating field.
 *
 * @since 1.0.1
 * @deprecated 2.1.0 Use sanitize_bookmark_field()
 * @see sanitize_bookmark_field()
 *
 * @param object $link Link object.
 * @return mixed Value of the 'link_rating' field, false otherwise.
 */
function get_linkrating($link)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_linkrating") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 999")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_linkrating:999@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Gets the name of category by ID.
 *
 * @since 0.71
 * @deprecated 2.1.0 Use get_category()
 * @see get_category()
 *
 * @param int $id The category to get. If no category supplied uses 0
 * @return string
 */
function get_linkcatname($id = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_linkcatname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1014")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_linkcatname:1014@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Print RSS comment feed link.
 *
 * @since 1.0.1
 * @deprecated 2.5.0 Use post_comments_feed_link()
 * @see post_comments_feed_link()
 *
 * @param string $link_text
 */
function comments_rss_link($link_text = 'Comments RSS')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("comments_rss_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1039")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called comments_rss_link:1039@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Print/Return link to category RSS2 feed.
 *
 * @since 1.2.0
 * @deprecated 2.5.0 Use get_category_feed_link()
 * @see get_category_feed_link()
 *
 * @param bool $echo
 * @param int $cat_ID
 * @return string
 */
function get_category_rss_link($echo = false, $cat_ID = 1)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_category_rss_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1055")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_category_rss_link:1055@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Print/Return link to author RSS feed.
 *
 * @since 1.2.0
 * @deprecated 2.5.0 Use get_author_feed_link()
 * @see get_author_feed_link()
 *
 * @param bool $echo
 * @param int $author_id
 * @return string
 */
function get_author_rss_link($echo = false, $author_id = 1)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_author_rss_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1075")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_author_rss_link:1075@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Return link to the post RSS feed.
 *
 * @since 1.5.0
 * @deprecated 2.2.0 Use get_post_comments_feed_link()
 * @see get_post_comments_feed_link()
 *
 * @return string
 */
function comments_rss()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("comments_rss") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1093")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called comments_rss:1093@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * An alias of wp_create_user().
 *
 * @since 2.0.0
 * @deprecated 2.0.0 Use wp_create_user()
 * @see wp_create_user()
 *
 * @param string $username The user's username.
 * @param string $password The user's password.
 * @param string $email    The user's email.
 * @return int The new user's ID.
 */
function create_user($username, $password, $email)
{
    _deprecated_function(__FUNCTION__, '2.0.0', 'wp_create_user()');
    return wp_create_user($username, $password, $email);
}
/**
 * Unused function.
 *
 * @deprecated 2.5.0
 */
function gzip_compression()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("gzip_compression") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1120")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called gzip_compression:1120@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve an array of comment data about comment $comment_ID.
 *
 * @since 0.71
 * @deprecated 2.7.0 Use get_comment()
 * @see get_comment()
 *
 * @param int $comment_ID The ID of the comment
 * @param int $no_cache Whether to use the cache (cast to bool)
 * @param bool $include_unapproved Whether to include unapproved comments
 * @return array The comment data
 */
function get_commentdata($comment_ID, $no_cache = 0, $include_unapproved = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_commentdata") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1137")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_commentdata:1137@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the category name by the category ID.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use get_cat_name()
 * @see get_cat_name()
 *
 * @param int $cat_ID Category ID
 * @return string category name
 */
function get_catname($cat_ID)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_catname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1152")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_catname:1152@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve category children list separated before and after the term IDs.
 *
 * @since 1.2.0
 * @deprecated 2.8.0 Use get_term_children()
 * @see get_term_children()
 *
 * @param int    $id      Category ID to retrieve children.
 * @param string $before  Optional. Prepend before category term ID. Default '/'.
 * @param string $after   Optional. Append after category term ID. Default empty string.
 * @param array  $visited Optional. Category Term IDs that have already been added.
 *                        Default empty array.
 * @return string
 */
function get_category_children($id, $before = '/', $after = '', $visited = array())
{
    _deprecated_function(__FUNCTION__, '2.8.0', 'get_term_children()');
    if (0 == $id) {
        return '';
    }
    $chain = '';
    /** TODO: Consult hierarchy */
    $cat_ids = get_all_category_ids();
    foreach ((array) $cat_ids as $cat_id) {
        if ($cat_id == $id) {
            continue;
        }
        $category = get_category($cat_id);
        if (is_wp_error($category)) {
            return $category;
        }
        if ($category->parent == $id && !in_array($category->term_id, $visited)) {
            $visited[] = $category->term_id;
            $chain .= $before . $category->term_id . $after;
            $chain .= get_category_children($category->term_id, $before, $after);
        }
    }
    return $chain;
}
/**
 * Retrieves all category IDs.
 *
 * @since 2.0.0
 * @deprecated 4.0.0 Use get_terms()
 * @see get_terms()
 *
 * @link https://developer.wordpress.org/reference/functions/get_all_category_ids/
 *
 * @return int[] List of all of the category IDs.
 */
function get_all_category_ids()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_all_category_ids") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1207")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_all_category_ids:1207@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the description of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's description.
 */
function get_the_author_description()
{
    _deprecated_function(__FUNCTION__, '2.8.0', 'get_the_author_meta(\'description\')');
    return get_the_author_meta('description');
}
/**
 * Display the description of the author of the current post.
 *
 * @since 1.0.0
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_description()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_description") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1234")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_description:1234@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the login name of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's login name (username).
 */
function get_the_author_login()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_author_login") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1248")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_author_login:1248@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the login name of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_login()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_login") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1260")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_login:1260@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the first name of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's first name.
 */
function get_the_author_firstname()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_author_firstname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1274")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_author_firstname:1274@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the first name of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_firstname()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_firstname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1286")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_firstname:1286@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the last name of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's last name.
 */
function get_the_author_lastname()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_author_lastname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1300")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_author_lastname:1300@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the last name of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_lastname()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_lastname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1312")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_lastname:1312@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the nickname of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's nickname.
 */
function get_the_author_nickname()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_author_nickname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1326")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_author_nickname:1326@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the nickname of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_nickname()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_nickname") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1338")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_nickname:1338@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the email of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's username.
 */
function get_the_author_email()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_author_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1352")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_author_email:1352@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the email of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_email()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1364")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_email:1364@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the ICQ number of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's ICQ number.
 */
function get_the_author_icq()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_author_icq") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1378")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_author_icq:1378@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the ICQ number of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_icq()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_icq") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1390")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_icq:1390@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the Yahoo! IM name of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's Yahoo! IM name.
 */
function get_the_author_yim()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_author_yim") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1404")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_author_yim:1404@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the Yahoo! IM name of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_yim()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_yim") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1416")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_yim:1416@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the MSN address of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's MSN address.
 */
function get_the_author_msn()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_author_msn") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1430")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_author_msn:1430@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the MSN address of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_msn()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_msn") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1442")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_msn:1442@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the AIM address of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The author's AIM address.
 */
function get_the_author_aim()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_author_aim") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1456")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_author_aim:1456@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the AIM address of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta('aim')
 * @see the_author_meta()
 */
function the_author_aim()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_aim") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1468")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_aim:1468@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the specified author's preferred display name.
 *
 * @since 1.0.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @param int $auth_id The ID of the author.
 * @return string The author's display name.
 */
function get_author_name($auth_id = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_author_name") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1483")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_author_name:1483@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the URL to the home page of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string The URL to the author's page.
 */
function get_the_author_url()
{
    _deprecated_function(__FUNCTION__, '2.8.0', 'get_the_author_meta(\'url\')');
    return get_the_author_meta('url');
}
/**
 * Display the URL to the home page of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_url()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_url") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1509")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_url:1509@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the ID of the author of the current post.
 *
 * @since 1.5.0
 * @deprecated 2.8.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @return string|int The author's ID.
 */
function get_the_author_ID()
{
    _deprecated_function(__FUNCTION__, '2.8.0', 'get_the_author_meta(\'ID\')');
    return get_the_author_meta('ID');
}
/**
 * Display the ID of the author of the current post.
 *
 * @since 0.71
 * @deprecated 2.8.0 Use the_author_meta()
 * @see the_author_meta()
 */
function the_author_ID()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_author_ID") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1535")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_author_ID:1535@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the post content for the feed.
 *
 * For encoding the HTML or the $encode_html parameter, there are three possible values:
 * - '0' will make urls footnotes and use make_url_footnote().
 * - '1' will encode special characters and automatically display all of the content.
 * - '2' will strip all HTML tags from the content.
 *
 * Also note that you cannot set the amount of words and not set the HTML encoding.
 * If that is the case, then the HTML encoding will default to 2, which will strip
 * all HTML tags.
 *
 * To restrict the amount of words of the content, you can use the cut parameter.
 * If the content is less than the amount, then there won't be any dots added to the end.
 * If there is content left over, then dots will be added and the rest of the content
 * will be removed.
 *
 * @since 0.71
 *
 * @deprecated 2.9.0 Use the_content_feed()
 * @see the_content_feed()
 *
 * @param string $more_link_text Optional. Text to display when more content is available
 *                               but not displayed. Default '(more...)'.
 * @param int    $stripteaser    Optional. Default 0.
 * @param string $more_file      Optional.
 * @param int    $cut            Optional. Amount of words to keep for the content.
 * @param int    $encode_html    Optional. How to encode the content.
 */
function the_content_rss($more_link_text = '(more...)', $stripteaser = 0, $more_file = '', $cut = 0, $encode_html = 0)
{
    _deprecated_function(__FUNCTION__, '2.9.0', 'the_content_feed()');
    $content = get_the_content($more_link_text, $stripteaser);
    /**
     * Filters the post content in the context of an RSS feed.
     *
     * @since 0.71
     *
     * @param string $content Content of the current post.
     */
    $content = apply_filters('the_content_rss', $content);
    if ($cut && !$encode_html) {
        $encode_html = 2;
    }
    if (1 == $encode_html) {
        $content = esc_html($content);
        $cut = 0;
    } elseif (0 == $encode_html) {
        $content = make_url_footnote($content);
    } elseif (2 == $encode_html) {
        $content = strip_tags($content);
    }
    if ($cut) {
        $blah = explode(' ', $content);
        if (count($blah) > $cut) {
            $k = $cut;
            $use_dotdotdot = 1;
        } else {
            $k = count($blah);
            $use_dotdotdot = 0;
        }
        /** @todo Check performance, might be faster to use array slice instead. */
        for ($i = 0; $i < $k; $i++) {
            $excerpt .= $blah[$i] . ' ';
        }
        $excerpt .= $use_dotdotdot ? '...' : '';
        $content = $excerpt;
    }
    $content = str_replace(']]>', ']]&gt;', $content);
    echo $content;
}
/**
 * Strip HTML and put links at the bottom of stripped content.
 *
 * Searches for all of the links, strips them out of the content, and places
 * them at the bottom of the content with numbers.
 *
 * @since 0.71
 * @deprecated 2.9.0
 *
 * @param string $content Content to get links.
 * @return string HTML stripped out of content with links at the bottom.
 */
function make_url_footnote($content)
{
    _deprecated_function(__FUNCTION__, '2.9.0', '');
    preg_match_all('/<a(.+?)href=\\"(.+?)\\"(.*?)>(.+?)<\\/a>/', $content, $matches);
    $links_summary = "\n";
    for ($i = 0, $c = count($matches[0]); $i < $c; $i++) {
        $link_match = $matches[0][$i];
        $link_number = '[' . ($i + 1) . ']';
        $link_url = $matches[2][$i];
        $link_text = $matches[4][$i];
        $content = str_replace($link_match, $link_text . ' ' . $link_number, $content);
        $link_url = strtolower(substr($link_url, 0, 7)) != 'http://' && strtolower(substr($link_url, 0, 8)) != 'https://' ? get_option('home') . $link_url : $link_url;
        $links_summary .= "\n" . $link_number . ' ' . $link_url;
    }
    $content = strip_tags($content);
    $content .= $links_summary;
    return $content;
}
/**
 * Retrieve translated string with vertical bar context
 *
 * Quite a few times, there will be collisions with similar translatable text
 * found in more than two places but with different translated context.
 *
 * In order to use the separate contexts, the _c() function is used and the
 * translatable string uses a pipe ('|') which has the context the string is in.
 *
 * When the translated string is returned, it is everything before the pipe, not
 * including the pipe character. If there is no pipe in the translated text then
 * everything is returned.
 *
 * @since 2.2.0
 * @deprecated 2.9.0 Use _x()
 * @see _x()
 *
 * @param string $text Text to translate.
 * @param string $domain Optional. Domain to retrieve the translated text.
 * @return string Translated context string without pipe.
 */
function _c($text, $domain = 'default')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_c") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1662")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _c:1662@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Translates $text like translate(), but assumes that the text
 * contains a context after its last vertical bar.
 *
 * @since 2.5.0
 * @deprecated 3.0.0 Use _x()
 * @see _x()
 *
 * @param string $text Text to translate.
 * @param string $domain Domain to retrieve the translated text.
 * @return string Translated text.
 */
function translate_with_context($text, $domain = 'default')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("translate_with_context") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1679")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called translate_with_context:1679@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Legacy version of _n(), which supports contexts.
 *
 * Strips everything from the translation after the last bar.
 *
 * @since 2.7.0
 * @deprecated 3.0.0 Use _nx()
 * @see _nx()
 *
 * @param string $single The text to be used if the number is singular.
 * @param string $plural The text to be used if the number is plural.
 * @param int    $number The number to compare against to use either the singular or plural form.
 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
 *                       Default 'default'.
 * @return string The translated singular or plural form.
 */
function _nc($single, $plural, $number, $domain = 'default')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_nc") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1700")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _nc:1700@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve the plural or single form based on the amount.
 *
 * @since 1.2.0
 * @deprecated 2.8.0 Use _n()
 * @see _n()
 */
function __ngettext(...$args)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__ngettext") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1713")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called __ngettext:1713@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Register plural strings in POT file, but don't translate them.
 *
 * @since 2.5.0
 * @deprecated 2.8.0 Use _n_noop()
 * @see _n_noop()
 */
function __ngettext_noop(...$args)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__ngettext_noop") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1726")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called __ngettext_noop:1726@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve all autoload options, or all options if no autoloaded ones exist.
 *
 * @since 1.0.0
 * @deprecated 3.0.0 Use wp_load_alloptions())
 * @see wp_load_alloptions()
 *
 * @return array List of all options.
 */
function get_alloptions()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_alloptions") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1740")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_alloptions:1740@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve HTML content of attachment image with link.
 *
 * @since 2.0.0
 * @deprecated 2.5.0 Use wp_get_attachment_link()
 * @see wp_get_attachment_link()
 *
 * @param int   $id       Optional. Post ID.
 * @param bool  $fullsize Optional. Whether to use full size image. Default false.
 * @param array $max_dims Optional. Max image dimensions.
 * @param bool $permalink Optional. Whether to include permalink to image. Default false.
 * @return string
 */
function get_the_attachment_link($id = 0, $fullsize = false, $max_dims = false, $permalink = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_the_attachment_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1758")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_the_attachment_link:1758@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve icon URL and Path.
 *
 * @since 2.1.0
 * @deprecated 2.5.0 Use wp_get_attachment_image_src()
 * @see wp_get_attachment_image_src()
 *
 * @param int  $id       Optional. Post ID.
 * @param bool $fullsize Optional. Whether to have full image. Default false.
 * @return array Icon URL and full path to file, respectively.
 */
function get_attachment_icon_src($id = 0, $fullsize = false)
{
    _deprecated_function(__FUNCTION__, '2.5.0', 'wp_get_attachment_image_src()');
    $id = (int) $id;
    if (!($post = get_post($id))) {
        return false;
    }
    $file = get_attached_file($post->ID);
    if (!$fullsize && ($src = wp_get_attachment_thumb_url($post->ID))) {
        // We have a thumbnail desired, specified and existing.
        $src_file = wp_basename($src);
    } elseif (wp_attachment_is_image($post->ID)) {
        // We have an image without a thumbnail.
        $src = wp_get_attachment_url($post->ID);
        $src_file =& $file;
    } elseif ($src = wp_mime_type_icon($post->ID)) {
        // No thumb, no image. We'll look for a mime-related icon instead.
        /** This filter is documented in wp-includes/post.php */
        $icon_dir = apply_filters('icon_dir', get_template_directory() . '/images');
        $src_file = $icon_dir . '/' . wp_basename($src);
    }
    if (!isset($src) || !$src) {
        return false;
    }
    return array($src, $src_file);
}
/**
 * Retrieve HTML content of icon attachment image element.
 *
 * @since 2.0.0
 * @deprecated 2.5.0 Use wp_get_attachment_image()
 * @see wp_get_attachment_image()
 *
 * @param int   $id       Optional. Post ID.
 * @param bool  $fullsize Optional. Whether to have full size image. Default false.
 * @param array $max_dims Optional. Dimensions of image.
 * @return string|false HTML content.
 */
function get_attachment_icon($id = 0, $fullsize = false, $max_dims = false)
{
    _deprecated_function(__FUNCTION__, '2.5.0', 'wp_get_attachment_image()');
    $id = (int) $id;
    if (!($post = get_post($id))) {
        return false;
    }
    if (!($src = get_attachment_icon_src($post->ID, $fullsize))) {
        return false;
    }
    list($src, $src_file) = $src;
    // Do we need to constrain the image?
    if (($max_dims = apply_filters('attachment_max_dims', $max_dims)) && file_exists($src_file)) {
        $imagesize = wp_getimagesize($src_file);
        if ($imagesize[0] > $max_dims[0] || $imagesize[1] > $max_dims[1]) {
            $actual_aspect = $imagesize[0] / $imagesize[1];
            $desired_aspect = $max_dims[0] / $max_dims[1];
            if ($actual_aspect >= $desired_aspect) {
                $height = $actual_aspect * $max_dims[0];
                $constraint = "width='{$max_dims[0]}' ";
                $post->iconsize = array($max_dims[0], $height);
            } else {
                $width = $max_dims[1] / $actual_aspect;
                $constraint = "height='{$max_dims[1]}' ";
                $post->iconsize = array($width, $max_dims[1]);
            }
        } else {
            $post->iconsize = array($imagesize[0], $imagesize[1]);
            $constraint = '';
        }
    } else {
        $constraint = '';
    }
    $post_title = esc_attr($post->post_title);
    $icon = "<img src='{$src}' title='{$post_title}' alt='{$post_title}' {$constraint}/>";
    return apply_filters('attachment_icon', $icon, $post->ID);
}
/**
 * Retrieve HTML content of image element.
 *
 * @since 2.0.0
 * @deprecated 2.5.0 Use wp_get_attachment_image()
 * @see wp_get_attachment_image()
 *
 * @param int   $id       Optional. Post ID.
 * @param bool  $fullsize Optional. Whether to have full size image. Default false.
 * @param array $max_dims Optional. Dimensions of image.
 * @return string|false
 */
function get_attachment_innerHTML($id = 0, $fullsize = false, $max_dims = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_attachment_innerHTML") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1871")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_attachment_innerHTML:1871@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieves bookmark data based on ID.
 *
 * @since 2.0.0
 * @deprecated 2.1.0 Use get_bookmark()
 * @see get_bookmark()
 *
 * @param int    $bookmark_id ID of link
 * @param string $output      Optional. Type of output. Accepts OBJECT, ARRAY_N, or ARRAY_A.
 *                            Default OBJECT.
 * @param string $filter      Optional. How to filter the link for output. Accepts 'raw', 'edit',
 *                            'attribute', 'js', 'db', or 'display'. Default 'raw'.
 * @return object|array Bookmark object or array, depending on the type specified by `$output`.
 */
function get_link($bookmark_id, $output = OBJECT, $filter = 'raw')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1898")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_link:1898@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Performs esc_url() for database or redirect usage.
 *
 * @since 2.3.1
 * @deprecated 2.8.0 Use esc_url_raw()
 * @see esc_url_raw()
 *
 * @param string $url The URL to be cleaned.
 * @param array $protocols An array of acceptable protocols.
 * @return string The cleaned URL.
 */
function sanitize_url($url, $protocols = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitize_url") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1914")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called sanitize_url:1914@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Checks and cleans a URL.
 *
 * A number of characters are removed from the URL. If the URL is for displaying
 * (the default behaviour) ampersands are also replaced. The 'clean_url' filter
 * is applied to the returned cleaned URL.
 *
 * @since 1.2.0
 * @deprecated 3.0.0 Use esc_url()
 * @see esc_url()
 *
 * @param string $url The URL to be cleaned.
 * @param array $protocols Optional. An array of acceptable protocols.
 * @param string $context Optional. How the URL will be used. Default is 'display'.
 * @return string The cleaned $url after the {@see 'clean_url'} filter is applied.
 */
function clean_url($url, $protocols = null, $context = 'display')
{
    if ($context == 'db') {
        _deprecated_function('clean_url( $context = \'db\' )', '3.0.0', 'esc_url_raw()');
    } else {
        _deprecated_function(__FUNCTION__, '3.0.0', 'esc_url()');
    }
    return esc_url($url, $protocols, $context);
}
/**
 * Escape single quotes, specialchar double quotes, and fix line endings.
 *
 * The filter {@see 'js_escape'} is also applied by esc_js().
 *
 * @since 2.0.4
 * @deprecated 2.8.0 Use esc_js()
 * @see esc_js()
 *
 * @param string $text The text to be escaped.
 * @return string Escaped text.
 */
function js_escape($text)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("js_escape") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1956")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called js_escape:1956@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Legacy escaping for HTML blocks.
 *
 * @deprecated 2.8.0 Use esc_html()
 * @see esc_html()
 *
 * @param string       $string        String to escape.
 * @param string       $quote_style   Unused.
 * @param false|string $charset       Unused.
 * @param false        $double_encode Whether to double encode. Unused.
 * @return string Escaped `$string`.
 */
function wp_specialchars($string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_specialchars") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 1973")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_specialchars:1973@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Escaping for HTML attributes.
 *
 * @since 2.0.6
 * @deprecated 2.8.0 Use esc_attr()
 * @see esc_attr()
 *
 * @param string $text
 * @return string
 */
function attribute_escape($text)
{
    _deprecated_function(__FUNCTION__, '2.8.0', 'esc_attr()');
    return esc_attr($text);
}
/**
 * Register widget for sidebar with backward compatibility.
 *
 * Allows $name to be an array that accepts either three elements to grab the
 * first element and the third for the name or just uses the first element of
 * the array for the name.
 *
 * Passes to wp_register_sidebar_widget() after argument list and backward
 * compatibility is complete.
 *
 * @since 2.2.0
 * @deprecated 2.8.0 Use wp_register_sidebar_widget()
 * @see wp_register_sidebar_widget()
 *
 * @param string|int $name            Widget ID.
 * @param callable   $output_callback Run when widget is called.
 * @param string     $classname       Optional. Classname widget option. Default empty.
 * @param mixed      ...$params       Widget parameters.
 */
function register_sidebar_widget($name, $output_callback, $classname = '', ...$params)
{
    _deprecated_function(__FUNCTION__, '2.8.0', 'wp_register_sidebar_widget()');
    // Compat.
    if (is_array($name)) {
        if (count($name) === 3) {
            $name = sprintf($name[0], $name[2]);
        } else {
            $name = $name[0];
        }
    }
    $id = sanitize_title($name);
    $options = array();
    if (!empty($classname) && is_string($classname)) {
        $options['classname'] = $classname;
    }
    wp_register_sidebar_widget($id, $name, $output_callback, $options, ...$params);
}
/**
 * Serves as an alias of wp_unregister_sidebar_widget().
 *
 * @since 2.2.0
 * @deprecated 2.8.0 Use wp_unregister_sidebar_widget()
 * @see wp_unregister_sidebar_widget()
 *
 * @param int|string $id Widget ID.
 */
function unregister_sidebar_widget($id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unregister_sidebar_widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2044")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called unregister_sidebar_widget:2044@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Registers widget control callback for customizing options.
 *
 * Allows $name to be an array that accepts either three elements to grab the
 * first element and the third for the name or just uses the first element of
 * the array for the name.
 *
 * Passes to wp_register_widget_control() after the argument list has
 * been compiled.
 *
 * @since 2.2.0
 * @deprecated 2.8.0 Use wp_register_widget_control()
 * @see wp_register_widget_control()
 *
 * @param int|string $name             Sidebar ID.
 * @param callable   $control_callback Widget control callback to display and process form.
 * @param int        $width            Widget width.
 * @param int        $height           Widget height.
 * @param mixed      ...$params        Widget parameters.
 */
function register_widget_control($name, $control_callback, $width = '', $height = '', ...$params)
{
    _deprecated_function(__FUNCTION__, '2.8.0', 'wp_register_widget_control()');
    // Compat.
    if (is_array($name)) {
        if (count($name) === 3) {
            $name = sprintf($name[0], $name[2]);
        } else {
            $name = $name[0];
        }
    }
    $id = sanitize_title($name);
    $options = array();
    if (!empty($width)) {
        $options['width'] = $width;
    }
    if (!empty($height)) {
        $options['height'] = $height;
    }
    wp_register_widget_control($id, $name, $control_callback, $options, ...$params);
}
/**
 * Alias of wp_unregister_widget_control().
 *
 * @since 2.2.0
 * @deprecated 2.8.0 Use wp_unregister_widget_control()
 * @see wp_unregister_widget_control()
 *
 * @param int|string $id Widget ID.
 */
function unregister_widget_control($id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unregister_widget_control") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2099")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called unregister_widget_control:2099@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Remove user meta data.
 *
 * @since 2.0.0
 * @deprecated 3.0.0 Use delete_user_meta()
 * @see delete_user_meta()
 *
 * @param int $user_id User ID.
 * @param string $meta_key Metadata key.
 * @param mixed $meta_value Optional. Metadata value. Default empty.
 * @return bool True deletion completed and false if user_id is not a number.
 */
function delete_usermeta($user_id, $meta_key, $meta_value = '')
{
    _deprecated_function(__FUNCTION__, '3.0.0', 'delete_user_meta()');
    global $wpdb;
    if (!is_numeric($user_id)) {
        return false;
    }
    $meta_key = preg_replace('|[^a-z0-9_]|i', '', $meta_key);
    if (is_array($meta_value) || is_object($meta_value)) {
        $meta_value = serialize($meta_value);
    }
    $meta_value = trim($meta_value);
    $cur = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = %s", $user_id, $meta_key));
    if ($cur && $cur->umeta_id) {
        do_action('delete_usermeta', $cur->umeta_id, $user_id, $meta_key, $meta_value);
    }
    if (!empty($meta_value)) {
        $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = %s AND meta_value = %s", $user_id, $meta_key, $meta_value));
    } else {
        $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = %s", $user_id, $meta_key));
    }
    clean_user_cache($user_id);
    wp_cache_delete($user_id, 'user_meta');
    if ($cur && $cur->umeta_id) {
        do_action('deleted_usermeta', $cur->umeta_id, $user_id, $meta_key, $meta_value);
    }
    return true;
}
/**
 * Retrieve user metadata.
 *
 * If $user_id is not a number, then the function will fail over with a 'false'
 * boolean return value. Other returned values depend on whether there is only
 * one item to be returned, which be that single item type. If there is more
 * than one metadata value, then it will be list of metadata values.
 *
 * @since 2.0.0
 * @deprecated 3.0.0 Use get_user_meta()
 * @see get_user_meta()
 *
 * @param int $user_id User ID
 * @param string $meta_key Optional. Metadata key. Default empty.
 * @return mixed
 */
function get_usermeta($user_id, $meta_key = '')
{
    _deprecated_function(__FUNCTION__, '3.0.0', 'get_user_meta()');
    global $wpdb;
    $user_id = (int) $user_id;
    if (!$user_id) {
        return false;
    }
    if (!empty($meta_key)) {
        $meta_key = preg_replace('|[^a-z0-9_]|i', '', $meta_key);
        $user = wp_cache_get($user_id, 'users');
        // Check the cached user object.
        if (false !== $user && isset($user->{$meta_key})) {
            $metas = array($user->{$meta_key});
        } else {
            $metas = $wpdb->get_col($wpdb->prepare("SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = %s", $user_id, $meta_key));
        }
    } else {
        $metas = $wpdb->get_col($wpdb->prepare("SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = %d", $user_id));
    }
    if (empty($metas)) {
        if (empty($meta_key)) {
            return array();
        } else {
            return '';
        }
    }
    $metas = array_map('maybe_unserialize', $metas);
    if (count($metas) == 1) {
        return $metas[0];
    } else {
        return $metas;
    }
}
/**
 * Update metadata of user.
 *
 * There is no need to serialize values, they will be serialized if it is
 * needed. The metadata key can only be a string with underscores. All else will
 * be removed.
 *
 * Will remove the metadata, if the meta value is empty.
 *
 * @since 2.0.0
 * @deprecated 3.0.0 Use update_user_meta()
 * @see update_user_meta()
 *
 * @param int $user_id User ID
 * @param string $meta_key Metadata key.
 * @param mixed $meta_value Metadata value.
 * @return bool True on successful update, false on failure.
 */
function update_usermeta($user_id, $meta_key, $meta_value)
{
    _deprecated_function(__FUNCTION__, '3.0.0', 'update_user_meta()');
    global $wpdb;
    if (!is_numeric($user_id)) {
        return false;
    }
    $meta_key = preg_replace('|[^a-z0-9_]|i', '', $meta_key);
    /** @todo Might need fix because usermeta data is assumed to be already escaped */
    if (is_string($meta_value)) {
        $meta_value = stripslashes($meta_value);
    }
    $meta_value = maybe_serialize($meta_value);
    if (empty($meta_value)) {
        return delete_usermeta($user_id, $meta_key);
    }
    $cur = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = %s", $user_id, $meta_key));
    if ($cur) {
        do_action('update_usermeta', $cur->umeta_id, $user_id, $meta_key, $meta_value);
    }
    if (!$cur) {
        $wpdb->insert($wpdb->usermeta, compact('user_id', 'meta_key', 'meta_value'));
    } elseif ($cur->meta_value != $meta_value) {
        $wpdb->update($wpdb->usermeta, compact('meta_value'), compact('user_id', 'meta_key'));
    } else {
        return false;
    }
    clean_user_cache($user_id);
    wp_cache_delete($user_id, 'user_meta');
    if (!$cur) {
        do_action('added_usermeta', $wpdb->insert_id, $user_id, $meta_key, $meta_value);
    } else {
        do_action('updated_usermeta', $cur->umeta_id, $user_id, $meta_key, $meta_value);
    }
    return true;
}
/**
 * Get users for the site.
 *
 * For setups that use the multisite feature. Can be used outside of the
 * multisite feature.
 *
 * @since 2.2.0
 * @deprecated 3.1.0 Use get_users()
 * @see get_users()
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param int $id Site ID.
 * @return array List of users that are part of that site ID
 */
function get_users_of_blog($id = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_users_of_blog") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2263")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_users_of_blog:2263@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Enable/disable automatic general feed link outputting.
 *
 * @since 2.8.0
 * @deprecated 3.0.0 Use add_theme_support()
 * @see add_theme_support()
 *
 * @param bool $add Optional. Add or remove links. Default true.
 */
function automatic_feed_links($add = true)
{
    _deprecated_function(__FUNCTION__, '3.0.0', "add_theme_support( 'automatic-feed-links' )");
    if ($add) {
        add_theme_support('automatic-feed-links');
    } else {
        remove_action('wp_head', 'feed_links_extra', 3);
    }
    // Just do this yourself in 3.0+.
}
/**
 * Retrieve user data based on field.
 *
 * @since 1.5.0
 * @deprecated 3.0.0 Use get_the_author_meta()
 * @see get_the_author_meta()
 *
 * @param string    $field User meta field.
 * @param false|int $user  Optional. User ID to retrieve the field for. Default false (current user).
 * @return string The author's field from the current author's DB object.
 */
function get_profile($field, $user = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_profile") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2304")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_profile:2304@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieves the number of posts a user has written.
 *
 * @since 0.71
 * @deprecated 3.0.0 Use count_user_posts()
 * @see count_user_posts()
 *
 * @param int $userid User to count posts for.
 * @return int Number of posts the given user has written.
 */
function get_usernumposts($userid)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_usernumposts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2323")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_usernumposts:2323@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Callback used to change %uXXXX to &#YYY; syntax
 *
 * @since 2.8.0
 * @access private
 * @deprecated 3.0.0
 *
 * @param array $matches Single Match
 * @return string An HTML entity
 */
function funky_javascript_callback($matches)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("funky_javascript_callback") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2338")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called funky_javascript_callback:2338@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Fixes JavaScript bugs in browsers.
 *
 * Converts unicode characters to HTML numbered entities.
 *
 * @since 1.5.0
 * @deprecated 3.0.0
 *
 * @global $is_macIE
 * @global $is_winIE
 *
 * @param string $text Text to be made safe.
 * @return string Fixed text.
 */
function funky_javascript_fix($text)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("funky_javascript_fix") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2356")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called funky_javascript_fix:2356@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Checks that the taxonomy name exists.
 *
 * @since 2.3.0
 * @deprecated 3.0.0 Use taxonomy_exists()
 * @see taxonomy_exists()
 *
 * @param string $taxonomy Name of taxonomy object
 * @return bool Whether the taxonomy exists.
 */
function is_taxonomy($taxonomy)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_taxonomy") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2376")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called is_taxonomy:2376@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Check if Term exists.
 *
 * @since 2.3.0
 * @deprecated 3.0.0 Use term_exists()
 * @see term_exists()
 *
 * @param int|string $term The term to check
 * @param string $taxonomy The taxonomy name to use
 * @param int $parent ID of parent term under which to confine the exists search.
 * @return mixed Get the term ID or term object, if exists.
 */
function is_term($term, $taxonomy = '', $parent = 0)
{
    _deprecated_function(__FUNCTION__, '3.0.0', 'term_exists()');
    return term_exists($term, $taxonomy, $parent);
}
/**
 * Determines whether the current admin page is generated by a plugin.
 *
 * Use global $plugin_page and/or get_plugin_page_hookname() hooks.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.wordpress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 * @deprecated 3.1.0
 *
 * @global $plugin_page
 *
 * @return bool
 */
function is_plugin_page()
{
    _deprecated_function(__FUNCTION__, '3.1.0');
    global $plugin_page;
    if (isset($plugin_page)) {
        return true;
    }
    return false;
}
/**
 * Update the categories cache.
 *
 * This function does not appear to be used anymore or does not appear to be
 * needed. It might be a legacy function left over from when there was a need
 * for updating the category cache.
 *
 * @since 1.5.0
 * @deprecated 3.1.0
 *
 * @return bool Always return True
 */
function update_category_cache()
{
    _deprecated_function(__FUNCTION__, '3.1.0');
    return true;
}
/**
 * Check for PHP timezone support
 *
 * @since 2.9.0
 * @deprecated 3.2.0
 *
 * @return bool
 */
function wp_timezone_supported()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_timezone_supported") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2448")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_timezone_supported:2448@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Displays an editor: TinyMCE, HTML, or both.
 *
 * @since 2.1.0
 * @deprecated 3.3.0 Use wp_editor()
 * @see wp_editor()
 *
 * @param string $content       Textarea content.
 * @param string $id            Optional. HTML ID attribute value. Default 'content'.
 * @param string $prev_id       Optional. Unused.
 * @param bool   $media_buttons Optional. Whether to display media buttons. Default true.
 * @param int    $tab_index     Optional. Unused.
 * @param bool   $extended      Optional. Unused.
 */
function the_editor($content, $id = 'content', $prev_id = 'title', $media_buttons = true, $tab_index = 2, $extended = true)
{
    _deprecated_function(__FUNCTION__, '3.3.0', 'wp_editor()');
    wp_editor($content, $id, array('media_buttons' => $media_buttons));
}
/**
 * Perform the query to get the $metavalues array(s) needed by _fill_user and _fill_many_users
 *
 * @since 3.0.0
 * @deprecated 3.3.0
 *
 * @param array $ids User ID numbers list.
 * @return array of arrays. The array is indexed by user_id, containing $metavalues object arrays.
 */
function get_user_metavalues($ids)
{
    _deprecated_function(__FUNCTION__, '3.3.0');
    $objects = array();
    $ids = array_map('intval', $ids);
    foreach ($ids as $id) {
        $objects[$id] = array();
    }
    $metas = update_meta_cache('user', $ids);
    foreach ($metas as $id => $meta) {
        foreach ($meta as $key => $metavalues) {
            foreach ($metavalues as $value) {
                $objects[$id][] = (object) array('user_id' => $id, 'meta_key' => $key, 'meta_value' => $value);
            }
        }
    }
    return $objects;
}
/**
 * Sanitize every user field.
 *
 * If the context is 'raw', then the user object or array will get minimal santization of the int fields.
 *
 * @since 2.3.0
 * @deprecated 3.3.0
 *
 * @param object|array $user    The user object or array.
 * @param string       $context Optional. How to sanitize user fields. Default 'display'.
 * @return object|array The now sanitized user object or array (will be the same type as $user).
 */
function sanitize_user_object($user, $context = 'display')
{
    _deprecated_function(__FUNCTION__, '3.3.0');
    if (is_object($user)) {
        if (!isset($user->ID)) {
            $user->ID = 0;
        }
        if (!$user instanceof WP_User) {
            $vars = get_object_vars($user);
            foreach (array_keys($vars) as $field) {
                if (is_string($user->{$field}) || is_numeric($user->{$field})) {
                    $user->{$field} = sanitize_user_field($field, $user->{$field}, $user->ID, $context);
                }
            }
        }
        $user->filter = $context;
    } else {
        if (!isset($user['ID'])) {
            $user['ID'] = 0;
        }
        foreach (array_keys($user) as $field) {
            $user[$field] = sanitize_user_field($field, $user[$field], $user['ID'], $context);
        }
        $user['filter'] = $context;
    }
    return $user;
}
/**
 * Get boundary post relational link.
 *
 * Can either be start or end post relational link.
 *
 * @since 2.8.0
 * @deprecated 3.3.0
 *
 * @param string $title               Optional. Link title format. Default '%title'.
 * @param bool   $in_same_cat         Optional. Whether link should be in a same category.
 *                                    Default false.
 * @param string $excluded_categories Optional. Excluded categories IDs. Default empty.
 * @param bool   $start               Optional. Whether to display link to first or last post.
 *                                    Default true.
 * @return string
 */
function get_boundary_post_rel_link($title = '%title', $in_same_cat = false, $excluded_categories = '', $start = true)
{
    _deprecated_function(__FUNCTION__, '3.3.0');
    $posts = get_boundary_post($in_same_cat, $excluded_categories, $start);
    // If there is no post, stop.
    if (empty($posts)) {
        return;
    }
    // Even though we limited get_posts() to return only 1 item it still returns an array of objects.
    $post = $posts[0];
    if (empty($post->post_title)) {
        $post->post_title = $start ? __('First Post') : __('Last Post');
    }
    $date = mysql2date(get_option('date_format'), $post->post_date);
    $title = str_replace('%title', $post->post_title, $title);
    $title = str_replace('%date', $date, $title);
    $title = apply_filters('the_title', $title, $post->ID);
    $link = $start ? "<link rel='start' title='" : "<link rel='end' title='";
    $link .= esc_attr($title);
    $link .= "' href='" . get_permalink($post) . "' />\n";
    $boundary = $start ? 'start' : 'end';
    return apply_filters("{$boundary}_post_rel_link", $link);
}
/**
 * Display relational link for the first post.
 *
 * @since 2.8.0
 * @deprecated 3.3.0
 *
 * @param string $title Optional. Link title format.
 * @param bool $in_same_cat Optional. Whether link should be in a same category.
 * @param string $excluded_categories Optional. Excluded categories IDs.
 */
function start_post_rel_link($title = '%title', $in_same_cat = false, $excluded_categories = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("start_post_rel_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2587")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called start_post_rel_link:2587@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Get site index relational link.
 *
 * @since 2.8.0
 * @deprecated 3.3.0
 *
 * @return string
 */
function get_index_rel_link()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_index_rel_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2600")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_index_rel_link:2600@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display relational link for the site index.
 *
 * @since 2.8.0
 * @deprecated 3.3.0
 */
function index_rel_link()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("index_rel_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2612")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called index_rel_link:2612@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Get parent post relational link.
 *
 * @since 2.8.0
 * @deprecated 3.3.0
 *
 * @param string $title Optional. Link title format. Default '%title'.
 * @return string
 */
function get_parent_post_rel_link($title = '%title')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_parent_post_rel_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2626")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_parent_post_rel_link:2626@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display relational link for parent item
 *
 * @since 2.8.0
 * @deprecated 3.3.0
 *
 * @param string $title Optional. Link title format. Default '%title'.
 */
function parent_post_rel_link($title = '%title')
{
    _deprecated_function(__FUNCTION__, '3.3.0');
    echo get_parent_post_rel_link($title);
}
/**
 * Add the "Dashboard"/"Visit Site" menu.
 *
 * @since 3.2.0
 * @deprecated 3.3.0
 *
 * @param WP_Admin_Bar $wp_admin_bar WP_Admin_Bar instance.
 */
function wp_admin_bar_dashboard_view_site_menu($wp_admin_bar)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_admin_bar_dashboard_view_site_menu") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2665")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_admin_bar_dashboard_view_site_menu:2665@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Checks if the current user belong to a given site.
 *
 * @since MU (3.0.0)
 * @deprecated 3.3.0 Use is_user_member_of_blog()
 * @see is_user_member_of_blog()
 *
 * @param int $blog_id Site ID
 * @return bool True if the current users belong to $blog_id, false if not.
 */
function is_blog_user($blog_id = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_blog_user") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2689")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called is_blog_user:2689@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Open the file handle for debugging.
 *
 * @since 0.71
 * @deprecated 3.4.0 Use error_log()
 * @see error_log()
 *
 * @link https://www.php.net/manual/en/function.error-log.php
 *
 * @param string $filename File name.
 * @param string $mode     Type of access you required to the stream.
 * @return false Always false.
 */
function debug_fopen($filename, $mode)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("debug_fopen") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2707")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called debug_fopen:2707@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Write contents to the file used for debugging.
 *
 * @since 0.71
 * @deprecated 3.4.0 Use error_log()
 * @see error_log()
 *
 * @link https://www.php.net/manual/en/function.error-log.php
 *
 * @param mixed  $fp     Unused.
 * @param string $string Message to log.
 */
function debug_fwrite($fp, $string)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("debug_fwrite") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2724")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called debug_fwrite:2724@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Close the debugging file handle.
 *
 * @since 0.71
 * @deprecated 3.4.0 Use error_log()
 * @see error_log()
 *
 * @link https://www.php.net/manual/en/function.error-log.php
 *
 * @param mixed $fp Unused.
 */
function debug_fclose($fp)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("debug_fclose") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2742")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called debug_fclose:2742@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve list of themes with theme data in theme directory.
 *
 * The theme is broken, if it doesn't have a parent theme and is missing either
 * style.css and, or index.php. If the theme has a parent theme then it is
 * broken, if it is missing style.css; index.php is optional.
 *
 * @since 1.5.0
 * @deprecated 3.4.0 Use wp_get_themes()
 * @see wp_get_themes()
 *
 * @return array Theme list with theme data.
 */
function get_themes()
{
    _deprecated_function(__FUNCTION__, '3.4.0', 'wp_get_themes()');
    global $wp_themes;
    if (isset($wp_themes)) {
        return $wp_themes;
    }
    $themes = wp_get_themes();
    $wp_themes = array();
    foreach ($themes as $theme) {
        $name = $theme->get('Name');
        if (isset($wp_themes[$name])) {
            $wp_themes[$name . '/' . $theme->get_stylesheet()] = $theme;
        } else {
            $wp_themes[$name] = $theme;
        }
    }
    return $wp_themes;
}
/**
 * Retrieve theme data.
 *
 * @since 1.5.0
 * @deprecated 3.4.0 Use wp_get_theme()
 * @see wp_get_theme()
 *
 * @param string $theme Theme name.
 * @return array|null Null, if theme name does not exist. Theme data, if exists.
 */
function get_theme($theme)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_theme") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2788")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_theme:2788@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve current theme name.
 *
 * @since 1.5.0
 * @deprecated 3.4.0 Use wp_get_theme()
 * @see wp_get_theme()
 *
 * @return string
 */
function get_current_theme()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_current_theme") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2806")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_current_theme:2806@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Accepts matches array from preg_replace_callback in wpautop() or a string.
 *
 * Ensures that the contents of a `<pre>...</pre>` HTML block are not
 * converted into paragraphs or line breaks.
 *
 * @since 1.2.0
 * @deprecated 3.4.0
 *
 * @param array|string $matches The array or string
 * @return string The pre block without paragraph/line break conversion.
 */
function clean_pre($matches)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("clean_pre") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2826")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called clean_pre:2826@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Add callbacks for image header display.
 *
 * @since 2.1.0
 * @deprecated 3.4.0 Use add_theme_support()
 * @see add_theme_support()
 *
 * @param callable $wp_head_callback Call on the {@see 'wp_head'} action.
 * @param callable $admin_head_callback Call on custom header administration screen.
 * @param callable $admin_preview_callback Output a custom header image div on the custom header administration screen. Optional.
 */
function add_custom_image_header($wp_head_callback, $admin_head_callback, $admin_preview_callback = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_custom_image_header") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2850")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called add_custom_image_header:2850@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Remove image header support.
 *
 * @since 3.1.0
 * @deprecated 3.4.0 Use remove_theme_support()
 * @see remove_theme_support()
 *
 * @return null|bool Whether support was removed.
 */
function remove_custom_image_header()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove_custom_image_header") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2868")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called remove_custom_image_header:2868@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Add callbacks for background image display.
 *
 * @since 3.0.0
 * @deprecated 3.4.0 Use add_theme_support()
 * @see add_theme_support()
 *
 * @param callable $wp_head_callback Call on the {@see 'wp_head'} action.
 * @param callable $admin_head_callback Call on custom background administration screen.
 * @param callable $admin_preview_callback Output a custom background image div on the custom background administration screen. Optional.
 */
function add_custom_background($wp_head_callback = '', $admin_head_callback = '', $admin_preview_callback = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_custom_background") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2884")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called add_custom_background:2884@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Remove custom background support.
 *
 * @since 3.1.0
 * @deprecated 3.4.0 Use add_custom_background()
 * @see add_custom_background()
 *
 * @return null|bool Whether support was removed.
 */
function remove_custom_background()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove_custom_background") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2908")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called remove_custom_background:2908@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve theme data from parsed theme file.
 *
 * @since 1.5.0
 * @deprecated 3.4.0 Use wp_get_theme()
 * @see wp_get_theme()
 *
 * @param string $theme_file Theme file path.
 * @return array Theme data.
 */
function get_theme_data($theme_file)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_theme_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2923")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_theme_data:2923@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Alias of update_post_cache().
 *
 * @see update_post_cache() Posts and pages are the same, alias is intentional
 *
 * @since 1.5.1
 * @deprecated 3.4.0 Use update_post_cache()
 * @see update_post_cache()
 *
 * @param array $pages list of page objects
 */
function update_page_cache(&$pages)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_page_cache") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2946")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called update_page_cache:2946@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Will clean the page in the cache.
 *
 * Clean (read: delete) page from cache that matches $id. Will also clean cache
 * associated with 'all_page_ids' and 'get_pages'.
 *
 * @since 2.0.0
 * @deprecated 3.4.0 Use clean_post_cache
 * @see clean_post_cache()
 *
 * @param int $id Page ID to clean
 */
function clean_page_cache($id)
{
    _deprecated_function(__FUNCTION__, '3.4.0', 'clean_post_cache()');
    clean_post_cache($id);
}
/**
 * Retrieve nonce action "Are you sure" message.
 *
 * Deprecated in 3.4.1 and 3.5.0. Backported to 3.3.3.
 *
 * @since 2.0.4
 * @deprecated 3.4.1 Use wp_nonce_ays()
 * @see wp_nonce_ays()
 *
 * @param string $action Nonce action.
 * @return string Are you sure message.
 */
function wp_explain_nonce($action)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_explain_nonce") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2980")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_explain_nonce:2980@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display "sticky" CSS class, if a post is sticky.
 *
 * @since 2.7.0
 * @deprecated 3.5.0 Use post_class()
 * @see post_class()
 *
 * @param int $post_id An optional post ID.
 */
function sticky_class($post_id = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sticky_class") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 2994")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called sticky_class:2994@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve post ancestors.
 *
 * This is no longer needed as WP_Post lazy-loads the ancestors
 * property with get_post_ancestors().
 *
 * @since 2.3.4
 * @deprecated 3.5.0 Use get_post_ancestors()
 * @see get_post_ancestors()
 *
 * @param WP_Post $post Post object, passed by reference (unused).
 */
function _get_post_ancestors(&$post)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_get_post_ancestors") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3013")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _get_post_ancestors:3013@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Load an image from a string, if PHP supports it.
 *
 * @since 2.1.0
 * @deprecated 3.5.0 Use wp_get_image_editor()
 * @see wp_get_image_editor()
 *
 * @param string $file Filename of the image to load.
 * @return resource|GdImage|string The resulting image resource or GdImage instance on success,
 *                                 error string on failure.
 */
function wp_load_image($file)
{
    _deprecated_function(__FUNCTION__, '3.5.0', 'wp_get_image_editor()');
    if (is_numeric($file)) {
        $file = get_attached_file($file);
    }
    if (!is_file($file)) {
        /* translators: %s: File name. */
        return sprintf(__('File &#8220;%s&#8221; doesn&#8217;t exist?'), $file);
    }
    if (!function_exists('imagecreatefromstring')) {
        return __('The GD image library is not installed.');
    }
    // Set artificially high because GD uses uncompressed images in memory.
    wp_raise_memory_limit('image');
    $image = imagecreatefromstring(file_get_contents($file));
    if (!is_gd_image($image)) {
        /* translators: %s: File name. */
        return sprintf(__('File &#8220;%s&#8221; is not an image.'), $file);
    }
    return $image;
}
/**
 * Scale down an image to fit a particular size and save a new copy of the image.
 *
 * The PNG transparency will be preserved using the function, as well as the
 * image type. If the file going in is PNG, then the resized image is going to
 * be PNG. The only supported image types are PNG, GIF, and JPEG.
 *
 * Some functionality requires API to exist, so some PHP version may lose out
 * support. This is not the fault of WordPress (where functionality is
 * downgraded, not actual defects), but of your PHP version.
 *
 * @since 2.5.0
 * @deprecated 3.5.0 Use wp_get_image_editor()
 * @see wp_get_image_editor()
 *
 * @param string $file         Image file path.
 * @param int    $max_w        Maximum width to resize to.
 * @param int    $max_h        Maximum height to resize to.
 * @param bool   $crop         Optional. Whether to crop image or resize. Default false.
 * @param string $suffix       Optional. File suffix. Default null.
 * @param string $dest_path    Optional. New image file path. Default null.
 * @param int    $jpeg_quality Optional. Image quality percentage. Default 90.
 * @return mixed WP_Error on failure. String with new destination path.
 */
function image_resize($file, $max_w, $max_h, $crop = false, $suffix = null, $dest_path = null, $jpeg_quality = 90)
{
    _deprecated_function(__FUNCTION__, '3.5.0', 'wp_get_image_editor()');
    $editor = wp_get_image_editor($file);
    if (is_wp_error($editor)) {
        return $editor;
    }
    $editor->set_quality($jpeg_quality);
    $resized = $editor->resize($max_w, $max_h, $crop);
    if (is_wp_error($resized)) {
        return $resized;
    }
    $dest_file = $editor->generate_filename($suffix, $dest_path);
    $saved = $editor->save($dest_file);
    if (is_wp_error($saved)) {
        return $saved;
    }
    return $dest_file;
}
/**
 * Retrieve a single post, based on post ID.
 *
 * Has categories in 'post_category' property or key. Has tags in 'tags_input'
 * property or key.
 *
 * @since 1.0.0
 * @deprecated 3.5.0 Use get_post()
 * @see get_post()
 *
 * @param int $postid Post ID.
 * @param string $mode How to return result, either OBJECT, ARRAY_N, or ARRAY_A.
 * @return WP_Post|null Post object or array holding post contents and information
 */
function wp_get_single_post($postid = 0, $mode = OBJECT)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_get_single_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3107")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_get_single_post:3107@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Check that the user login name and password is correct.
 *
 * @since 0.71
 * @deprecated 3.5.0 Use wp_authenticate()
 * @see wp_authenticate()
 *
 * @param string $user_login User name.
 * @param string $user_pass User password.
 * @return bool False if does not authenticate, true if username and password authenticates.
 */
function user_pass_ok($user_login, $user_pass)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("user_pass_ok") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3123")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called user_pass_ok:3123@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Callback formerly fired on the save_post hook. No longer needed.
 *
 * @since 2.3.0
 * @deprecated 3.5.0
 */
function _save_post_hook()
{
}
/**
 * Check if the installed version of GD supports particular image type
 *
 * @since 2.9.0
 * @deprecated 3.5.0 Use wp_image_editor_supports()
 * @see wp_image_editor_supports()
 *
 * @param string $mime_type
 * @return bool
 */
function gd_edit_image_support($mime_type)
{
    _deprecated_function(__FUNCTION__, '3.5.0', 'wp_image_editor_supports()');
    if (function_exists('imagetypes')) {
        switch ($mime_type) {
            case 'image/jpeg':
                return (imagetypes() & IMG_JPG) != 0;
            case 'image/png':
                return (imagetypes() & IMG_PNG) != 0;
            case 'image/gif':
                return (imagetypes() & IMG_GIF) != 0;
        }
    } else {
        switch ($mime_type) {
            case 'image/jpeg':
                return function_exists('imagecreatefromjpeg');
            case 'image/png':
                return function_exists('imagecreatefrompng');
            case 'image/gif':
                return function_exists('imagecreatefromgif');
        }
    }
    return false;
}
/**
 * Converts an integer byte value to a shorthand byte value.
 *
 * @since 2.3.0
 * @deprecated 3.6.0 Use size_format()
 * @see size_format()
 *
 * @param int $bytes An integer byte value.
 * @return string A shorthand byte value.
 */
function wp_convert_bytes_to_hr($bytes)
{
    _deprecated_function(__FUNCTION__, '3.6.0', 'size_format()');
    $units = array(0 => 'B', 1 => 'KB', 2 => 'MB', 3 => 'GB', 4 => 'TB');
    $log = log($bytes, KB_IN_BYTES);
    $power = (int) $log;
    $size = KB_IN_BYTES ** ($log - $power);
    if (!is_nan($size) && array_key_exists($power, $units)) {
        $unit = $units[$power];
    } else {
        $size = $bytes;
        $unit = $units[0];
    }
    return $size . $unit;
}
/**
 * Formerly used internally to tidy up the search terms.
 *
 * @since 2.9.0
 * @access private
 * @deprecated 3.7.0
 *
 * @param string $t Search terms to "tidy", e.g. trim.
 * @return string Trimmed search terms.
 */
function _search_terms_tidy($t)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_search_terms_tidy") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3210")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _search_terms_tidy:3210@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Determine if TinyMCE is available.
 *
 * Checks to see if the user has deleted the tinymce files to slim down
 * their WordPress installation.
 *
 * @since 2.1.0
 * @deprecated 3.9.0
 *
 * @return bool Whether TinyMCE exists.
 */
function rich_edit_exists()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("rich_edit_exists") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3226")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called rich_edit_exists:3226@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Old callback for tag link tooltips.
 *
 * @since 2.7.0
 * @access private
 * @deprecated 3.9.0
 *
 * @param int $count Number of topics.
 * @return int Number of topics.
 */
function default_topic_count_text($count)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("default_topic_count_text") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3245")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called default_topic_count_text:3245@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Formerly used to escape strings before inserting into the DB.
 *
 * Has not performed this function for many, many years. Use wpdb::prepare() instead.
 *
 * @since 0.71
 * @deprecated 3.9.0
 *
 * @param string $content The text to format.
 * @return string The very same text.
 */
function format_to_post($content)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("format_to_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3260")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called format_to_post:3260@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Formerly used to escape strings before searching the DB. It was poorly documented and never worked as described.
 *
 * @since 2.5.0
 * @deprecated 4.0.0 Use wpdb::esc_like()
 * @see wpdb::esc_like()
 *
 * @param string $text The text to be escaped.
 * @return string text, safe for inclusion in LIKE query.
 */
function like_escape($text)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("like_escape") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3275")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called like_escape:3275@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Determines if the URL can be accessed over SSL.
 *
 * Determines if the URL can be accessed over SSL by using the WordPress HTTP API to access
 * the URL using https as the scheme.
 *
 * @since 2.5.0
 * @deprecated 4.0.0
 *
 * @param string $url The URL to test.
 * @return bool Whether SSL access is available.
 */
function url_is_accessable_via_ssl($url)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("url_is_accessable_via_ssl") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3292")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called url_is_accessable_via_ssl:3292@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Start preview theme output buffer.
 *
 * Will only perform task if the user has permissions and template and preview
 * query variables exist.
 *
 * @since 2.6.0
 * @deprecated 4.3.0
 */
function preview_theme()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("preview_theme") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3313")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called preview_theme:3313@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Private function to modify the current template when previewing a theme
 *
 * @since 2.9.0
 * @deprecated 4.3.0
 * @access private
 *
 * @return string
 */
function _preview_theme_template_filter()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_preview_theme_template_filter") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3326")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _preview_theme_template_filter:3326@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Private function to modify the current stylesheet when previewing a theme
 *
 * @since 2.9.0
 * @deprecated 4.3.0
 * @access private
 *
 * @return string
 */
function _preview_theme_stylesheet_filter()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_preview_theme_stylesheet_filter") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3340")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _preview_theme_stylesheet_filter:3340@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Callback function for ob_start() to capture all links in the theme.
 *
 * @since 2.6.0
 * @deprecated 4.3.0
 * @access private
 *
 * @param string $content
 * @return string
 */
function preview_theme_ob_filter($content)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("preview_theme_ob_filter") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3355")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called preview_theme_ob_filter:3355@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Manipulates preview theme links in order to control and maintain location.
 *
 * Callback function for preg_replace_callback() to accept and filter matches.
 *
 * @since 2.6.0
 * @deprecated 4.3.0
 * @access private
 *
 * @param array $matches
 * @return string
 */
function preview_theme_ob_filter_callback($matches)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("preview_theme_ob_filter_callback") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3372")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called preview_theme_ob_filter_callback:3372@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Formats text for the rich text editor.
 *
 * The {@see 'richedit_pre'} filter is applied here. If `$text` is empty the filter will
 * be applied to an empty string.
 *
 * @since 2.0.0
 * @deprecated 4.3.0 Use format_for_editor()
 * @see format_for_editor()
 *
 * @param string $text The text to be formatted.
 * @return string The formatted text after filter is applied.
 */
function wp_richedit_pre($text)
{
    _deprecated_function(__FUNCTION__, '4.3.0', 'format_for_editor()');
    if (empty($text)) {
        /**
         * Filters text returned for the rich text editor.
         *
         * This filter is first evaluated, and the value returned, if an empty string
         * is passed to wp_richedit_pre(). If an empty string is passed, it results
         * in a break tag and line feed.
         *
         * If a non-empty string is passed, the filter is evaluated on the wp_richedit_pre()
         * return after being formatted.
         *
         * @since 2.0.0
         * @deprecated 4.3.0
         *
         * @param string $output Text for the rich text editor.
         */
        return apply_filters('richedit_pre', '');
    }
    $output = convert_chars($text);
    $output = wpautop($output);
    $output = htmlspecialchars($output, ENT_NOQUOTES, get_option('blog_charset'));
    /** This filter is documented in wp-includes/deprecated.php */
    return apply_filters('richedit_pre', $output);
}
/**
 * Formats text for the HTML editor.
 *
 * Unless $output is empty it will pass through htmlspecialchars before the
 * {@see 'htmledit_pre'} filter is applied.
 *
 * @since 2.5.0
 * @deprecated 4.3.0 Use format_for_editor()
 * @see format_for_editor()
 *
 * @param string $output The text to be formatted.
 * @return string Formatted text after filter applied.
 */
function wp_htmledit_pre($output)
{
    _deprecated_function(__FUNCTION__, '4.3.0', 'format_for_editor()');
    if (!empty($output)) {
        $output = htmlspecialchars($output, ENT_NOQUOTES, get_option('blog_charset'));
    }
    // Convert only '< > &'.
    /**
     * Filters the text before it is formatted for the HTML editor.
     *
     * @since 2.5.0
     * @deprecated 4.3.0
     *
     * @param string $output The HTML-formatted text.
     */
    return apply_filters('htmledit_pre', $output);
}
/**
 * Retrieve permalink from post ID.
 *
 * @since 1.0.0
 * @deprecated 4.4.0 Use get_permalink()
 * @see get_permalink()
 *
 * @param int|WP_Post $post_id Optional. Post ID or WP_Post object. Default is global $post.
 * @return string|false
 */
function post_permalink($post_id = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_permalink") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3457")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called post_permalink:3457@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Perform a HTTP HEAD or GET request.
 *
 * If $file_path is a writable filename, this will do a GET request and write
 * the file to that path.
 *
 * @since 2.5.0
 * @deprecated 4.4.0 Use WP_Http
 * @see WP_Http
 *
 * @param string      $url       URL to fetch.
 * @param string|bool $file_path Optional. File path to write request to. Default false.
 * @param int         $red       Optional. The number of Redirects followed, Upon 5 being hit,
 *                               returns false. Default 1.
 * @return bool|string False on failure and string of headers if HEAD request.
 */
function wp_get_http($url, $file_path = false, $red = 1)
{
    _deprecated_function(__FUNCTION__, '4.4.0', 'WP_Http');
    @set_time_limit(60);
    if ($red > 5) {
        return false;
    }
    $options = array();
    $options['redirection'] = 5;
    if (false == $file_path) {
        $options['method'] = 'HEAD';
    } else {
        $options['method'] = 'GET';
    }
    $response = wp_safe_remote_request($url, $options);
    if (is_wp_error($response)) {
        return false;
    }
    $headers = wp_remote_retrieve_headers($response);
    $headers['response'] = wp_remote_retrieve_response_code($response);
    // WP_HTTP no longer follows redirects for HEAD requests.
    if ('HEAD' == $options['method'] && in_array($headers['response'], array(301, 302)) && isset($headers['location'])) {
        return wp_get_http($headers['location'], $file_path, ++$red);
    }
    if (false == $file_path) {
        return $headers;
    }
    // GET request - write it to the supplied filename.
    $out_fp = fopen($file_path, 'w');
    if (!$out_fp) {
        return $headers;
    }
    fwrite($out_fp, wp_remote_retrieve_body($response));
    fclose($out_fp);
    clearstatcache();
    return $headers;
}
/**
 * Whether SSL login should be forced.
 *
 * @since 2.6.0
 * @deprecated 4.4.0 Use force_ssl_admin()
 * @see force_ssl_admin()
 *
 * @param string|bool $force Optional Whether to force SSL login. Default null.
 * @return bool True if forced, false if not forced.
 */
function force_ssl_login($force = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("force_ssl_login") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3525")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called force_ssl_login:3525@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve path of comment popup template in current or parent template.
 *
 * @since 1.5.0
 * @deprecated 4.5.0
 *
 * @return string Full path to comments popup template file.
 */
function get_comments_popup_template()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_comments_popup_template") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3538")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_comments_popup_template:3538@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Determines whether the current URL is within the comments popup window.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.wordpress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 1.5.0
 * @deprecated 4.5.0
 *
 * @return false Always returns false.
 */
function is_comments_popup()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_comments_popup") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3555")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called is_comments_popup:3555@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display the JS popup script to show a comment.
 *
 * @since 0.71
 * @deprecated 4.5.0
 */
function comments_popup_script()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("comments_popup_script") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3566")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called comments_popup_script:3566@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Adds element attributes to open links in new tabs.
 *
 * @since 0.71
 * @deprecated 4.5.0
 *
 * @param string $text Content to replace links to open in a new tab.
 * @return string Content that has filtered links.
 */
function popuplinks($text)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("popuplinks") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3579")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called popuplinks:3579@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * The Google Video embed handler callback.
 *
 * Deprecated function that previously assisted in turning Google Video URLs
 * into embeds but that service has since been shut down.
 *
 * @since 2.9.0
 * @deprecated 4.6.0
 *
 * @return string An empty string.
 */
function wp_embed_handler_googlevideo($matches, $attr, $url, $rawattr)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_embed_handler_googlevideo") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3596")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_embed_handler_googlevideo:3596@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieve path of paged template in current or parent template.
 *
 * @since 1.5.0
 * @deprecated 4.7.0 The paged.php template is no longer part of the theme template hierarchy.
 *
 * @return string Full path to paged template file.
 */
function get_paged_template()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_paged_template") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3609")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_paged_template:3609@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Removes the HTML JavaScript entities found in early versions of Netscape 4.
 *
 * Previously, this function was pulled in from the original
 * import of kses and removed a specific vulnerability only
 * existent in early version of Netscape 4. However, this
 * vulnerability never affected any other browsers and can
 * be considered safe for the modern web.
 *
 * The regular expression which sanitized this vulnerability
 * has been removed in consideration of the performance and
 * energy demands it placed, now merely passing through its
 * input to the return.
 *
 * @since 1.0.0
 * @deprecated 4.7.0 Officially dropped security support for Netscape 4.
 *
 * @param string $string
 * @return string
 */
function wp_kses_js_entities($string)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_kses_js_entities") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3634")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_kses_js_entities:3634@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Sort categories by ID.
 *
 * Used by usort() as a callback, should not be used directly. Can actually be
 * used to sort any term object.
 *
 * @since 2.3.0
 * @deprecated 4.7.0 Use wp_list_sort()
 * @access private
 *
 * @param object $a
 * @param object $b
 * @return int
 */
function _usort_terms_by_ID($a, $b)
{
    _deprecated_function(__FUNCTION__, '4.7.0', 'wp_list_sort()');
    if ($a->term_id > $b->term_id) {
        return 1;
    } elseif ($a->term_id < $b->term_id) {
        return -1;
    } else {
        return 0;
    }
}
/**
 * Sort categories by name.
 *
 * Used by usort() as a callback, should not be used directly. Can actually be
 * used to sort any term object.
 *
 * @since 2.3.0
 * @deprecated 4.7.0 Use wp_list_sort()
 * @access private
 *
 * @param object $a
 * @param object $b
 * @return int
 */
function _usort_terms_by_name($a, $b)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_usort_terms_by_name") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3678")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _usort_terms_by_name:3678@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Sort menu items by the desired key.
 *
 * @since 3.0.0
 * @deprecated 4.7.0 Use wp_list_sort()
 * @access private
 *
 * @global string $_menu_item_sort_prop
 *
 * @param object $a The first object to compare
 * @param object $b The second object to compare
 * @return int -1, 0, or 1 if $a is considered to be respectively less than, equal to, or greater than $b.
 */
function _sort_nav_menu_items($a, $b)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_sort_nav_menu_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3696")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _sort_nav_menu_items:3696@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Retrieves the Press This bookmarklet link.
 *
 * @since 2.6.0
 * @deprecated 4.9.0
 *
 */
function get_shortcut_link()
{
    _deprecated_function(__FUNCTION__, '4.9.0');
    $link = '';
    /**
     * Filters the Press This bookmarklet link.
     *
     * @since 2.6.0
     * @deprecated 4.9.0
     *
     * @param string $link The Press This bookmarklet link.
     */
    return apply_filters('shortcut_link', $link);
}
/**
* Ajax handler for saving a post from Press This.
*
* @since 4.2.0
* @deprecated 4.9.0
*/
function wp_ajax_press_this_save_post()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_ajax_press_this_save_post") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3743")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_ajax_press_this_save_post:3743@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
* Ajax handler for creating new category from Press This.
*
* @since 4.2.0
* @deprecated 4.9.0
*/
function wp_ajax_press_this_add_category()
{
    _deprecated_function(__FUNCTION__, '4.9.0');
    if (is_plugin_active('press-this/press-this-plugin.php')) {
        include WP_PLUGIN_DIR . '/press-this/class-wp-press-this-plugin.php';
        $wp_press_this = new WP_Press_This_Plugin();
        $wp_press_this->add_category();
    } else {
        wp_send_json_error(array('errorMessage' => __('The Press This plugin is required.')));
    }
}
/**
 * Return the user request object for the specified request ID.
 *
 * @since 4.9.6
 * @deprecated 5.4.0 Use wp_get_user_request()
 * @see wp_get_user_request()
 *
 * @param int $request_id The ID of the user request.
 * @return WP_User_Request|false
 */
function wp_get_user_request_data($request_id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_get_user_request_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3781")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_get_user_request_data:3781@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Filters 'img' elements in post content to add 'srcset' and 'sizes' attributes.
 *
 * @since 4.4.0
 * @deprecated 5.5.0
 *
 * @see wp_image_add_srcset_and_sizes()
 *
 * @param string $content The raw post content to be filtered.
 * @return string Converted content with 'srcset' and 'sizes' attributes added to images.
 */
function wp_make_content_images_responsive($content)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_make_content_images_responsive") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3797")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_make_content_images_responsive:3797@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Turn register globals off.
 *
 * @since 2.1.0
 * @access private
 * @deprecated 5.5.0
 */
function wp_unregister_GLOBALS()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_unregister_GLOBALS") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3812")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_unregister_GLOBALS:3812@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Does comment contain disallowed characters or words.
 *
 * @since 1.5.0
 * @deprecated 5.5.0 Use wp_check_comment_disallowed_list() instead.
 *                   Please consider writing more inclusive code.
 *
 * @param string $author The author of the comment
 * @param string $email The email of the comment
 * @param string $url The url used in the comment
 * @param string $comment The comment content
 * @param string $user_ip The comment author's IP address
 * @param string $user_agent The author's browser user agent
 * @return bool True if comment contains disallowed content, false if comment does not
 */
function wp_blacklist_check($author, $email, $url, $comment, $user_ip, $user_agent)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_blacklist_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3831")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_blacklist_check:3831@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Filters out `register_meta()` args based on an allowed list.
 *
 * `register_meta()` args may change over time, so requiring the allowed list
 * to be explicitly turned off is a warranty seal of sorts.
 *
 * @access private
 * @since 4.6.0
 * @deprecated 5.5.0 Use _wp_register_meta_args_allowed_list() instead.
 *                   Please consider writing more inclusive code.
 *
 * @param array $args         Arguments from `register_meta()`.
 * @param array $default_args Default arguments for `register_meta()`.
 * @return array Filtered arguments.
 */
function _wp_register_meta_args_whitelist($args, $default_args)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_wp_register_meta_args_whitelist") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3851")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _wp_register_meta_args_whitelist:3851@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Adds an array of options to the list of allowed options.
 *
 * @since 2.7.0
 * @deprecated 5.5.0 Use add_allowed_options() instead.
 *                   Please consider writing more inclusive code.
 *
 * @global array $allowed_options
 *
 * @param array        $new_options
 * @param string|array $options
 * @return array
 */
function add_option_whitelist($new_options, $options = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_option_whitelist") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3869")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called add_option_whitelist:3869@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Removes a list of options from the allowed options list.
 *
 * @since 2.7.0
 * @deprecated 5.5.0 Use remove_allowed_options() instead.
 *                   Please consider writing more inclusive code.
 *
 * @global array $allowed_options
 *
 * @param array        $del_options
 * @param string|array $options
 * @return array
 */
function remove_option_whitelist($del_options, $options = '')
{
    _deprecated_function(__FUNCTION__, '5.5.0', 'remove_allowed_options()');
    return remove_allowed_options($del_options, $options);
}
/**
 * Adds slashes to only string values in an array of values.
 *
 * This should be used when preparing data for core APIs that expect slashed data.
 * This should not be used to escape data going directly into an SQL query.
 *
 * @since 5.3.0
 * @deprecated 5.6.0 Use wp_slash()
 *
 * @see wp_slash()
 *
 * @param mixed $value Scalar or array of scalars.
 * @return mixed Slashes $value
 */
function wp_slash_strings_only($value)
{
    return map_deep($value, 'addslashes_strings_only');
}
/**
 * Adds slashes only if the provided value is a string.
 *
 * @since 5.3.0
 * @deprecated 5.6.0
 *
 * @see wp_slash()
 *
 * @param mixed $value
 * @return mixed
 */
function addslashes_strings_only($value)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addslashes_strings_only") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3921")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called addslashes_strings_only:3921@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Displays a noindex meta tag if required by the blog configuration.
 *
 * If a blog is marked as not being public then the noindex meta tag will be
 * output to tell web robots not to index the page content. Add this to the
 * {@see 'wp_head'} action.
 *
 * Typical usage is as a {@see 'wp_head'} callback:
 *
 *     add_action( 'wp_head', 'noindex' );
 *
 * @see wp_no_robots()
 *
 * @since 2.1.0
 * @deprecated 5.7.0 Use wp_robots_noindex() instead on 'wp_robots' filter.
 */
function noindex()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("noindex") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3941")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called noindex:3941@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display a noindex meta tag.
 *
 * Outputs a noindex meta tag that tells web robots not to index the page content.
 * Typical usage is as a {@see 'wp_head'} callback. add_action( 'wp_head', 'wp_no_robots' );
 *
 * @since 3.3.0
 * @since 5.3.0 Echo "noindex,nofollow" if search engine visibility is discouraged.
 * @deprecated 5.7.0 Use wp_robots_no_robots() instead on 'wp_robots' filter.
 */
function wp_no_robots()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_no_robots") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3959")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_no_robots:3959@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}
/**
 * Display a noindex,noarchive meta tag and referrer origin-when-cross-origin meta tag.
 *
 * Outputs a noindex,noarchive meta tag that tells web robots not to index or cache the page content.
 * Outputs a referrer origin-when-cross-origin meta tag that tells the browser not to send the full
 * url as a referrer to other sites when cross-origin assets are loaded.
 *
 * Typical usage is as a wp_head callback. add_action( 'wp_head', 'wp_sensitive_page_meta' );
 *
 * @since 5.0.1
 * @deprecated 5.7.0 Use wp_robots_sensitive_page() instead on 'wp_robots' filter
 *                   and wp_strict_cross_origin_referrer() on 'wp_head' action.
 */
function wp_sensitive_page_meta()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_sensitive_page_meta") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php at line 3981")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_sensitive_page_meta:3981@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/deprecated.php');
    die();
}