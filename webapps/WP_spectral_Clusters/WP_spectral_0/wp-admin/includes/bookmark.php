<?php

/**
 * WordPress Bookmark Administration API
 *
 * @package WordPress
 * @subpackage Administration
 */
/**
 * Add a link to using values provided in $_POST.
 *
 * @since 2.0.0
 *
 * @return int|WP_Error Value 0 or WP_Error on failure. The link ID on success.
 */
function add_link()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php at line 18")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called add_link:18@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php');
    die();
}
/**
 * Updates or inserts a link using values provided in $_POST.
 *
 * @since 2.0.0
 *
 * @param int $link_id Optional. ID of the link to edit. Default 0.
 * @return int|WP_Error Value 0 or WP_Error on failure. The link ID on success.
 */
function edit_link($link_id = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("edit_link") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php at line 30")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called edit_link:30@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php');
    die();
}
/**
 * Retrieves the default link for editing.
 *
 * @since 2.0.0
 *
 * @return stdClass Default link object.
 */
function get_default_link_to_edit()
{
    $link = new stdClass();
    if (isset($_GET['linkurl'])) {
        $link->link_url = esc_url(wp_unslash($_GET['linkurl']));
    } else {
        $link->link_url = '';
    }
    if (isset($_GET['name'])) {
        $link->link_name = esc_attr(wp_unslash($_GET['name']));
    } else {
        $link->link_name = '';
    }
    $link->link_visible = 'Y';
    return $link;
}
/**
 * Deletes a specified link from the database.
 *
 * @since 2.0.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param int $link_id ID of the link to delete
 * @return true Always true.
 */
function wp_delete_link($link_id)
{
    global $wpdb;
    /**
     * Fires before a link is deleted.
     *
     * @since 2.0.0
     *
     * @param int $link_id ID of the link to delete.
     */
    do_action('delete_link', $link_id);
    wp_delete_object_term_relationships($link_id, 'link_category');
    $wpdb->delete($wpdb->links, array('link_id' => $link_id));
    /**
     * Fires after a link has been deleted.
     *
     * @since 2.2.0
     *
     * @param int $link_id ID of the deleted link.
     */
    do_action('deleted_link', $link_id);
    clean_bookmark_cache($link_id);
    return true;
}
/**
 * Retrieves the link category IDs associated with the link specified.
 *
 * @since 2.1.0
 *
 * @param int $link_id Link ID to look up.
 * @return int[] The IDs of the requested link's categories.
 */
function wp_get_link_cats($link_id = 0)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_get_link_cats") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php at line 115")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_get_link_cats:115@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php');
    die();
}
/**
 * Retrieves link data based on its ID.
 *
 * @since 2.0.0
 *
 * @param int|stdClass $link Link ID or object to retrieve.
 * @return object Link object for editing.
 */
function get_link_to_edit($link)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_link_to_edit") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php at line 128")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_link_to_edit:128@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php');
    die();
}
/**
 * Inserts a link into the database, or updates an existing link.
 *
 * Runs all the necessary sanitizing, provides default values if arguments are missing,
 * and finally saves the link.
 *
 * @since 2.0.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param array $linkdata {
 *     Elements that make up the link to insert.
 *
 *     @type int    $link_id          Optional. The ID of the existing link if updating.
 *     @type string $link_url         The URL the link points to.
 *     @type string $link_name        The title of the link.
 *     @type string $link_image       Optional. A URL of an image.
 *     @type string $link_target      Optional. The target element for the anchor tag.
 *     @type string $link_description Optional. A short description of the link.
 *     @type string $link_visible     Optional. 'Y' means visible, anything else means not.
 *     @type int    $link_owner       Optional. A user ID.
 *     @type int    $link_rating      Optional. A rating for the link.
 *     @type string $link_updated     Optional. When the link was last updated.
 *     @type string $link_rel         Optional. A relationship of the link to you.
 *     @type string $link_notes       Optional. An extended description of or notes on the link.
 *     @type string $link_rss         Optional. A URL of an associated RSS feed.
 *     @type int    $link_category    Optional. The term ID of the link category.
 *                                    If empty, uses default link category.
 * }
 * @param bool  $wp_error Optional. Whether to return a WP_Error object on failure. Default false.
 * @return int|WP_Error Value 0 or WP_Error on failure. The link ID on success.
 */
function wp_insert_link($linkdata, $wp_error = false)
{
    global $wpdb;
    $defaults = array('link_id' => 0, 'link_name' => '', 'link_url' => '', 'link_rating' => 0);
    $parsed_args = wp_parse_args($linkdata, $defaults);
    $parsed_args = wp_unslash(sanitize_bookmark($parsed_args, 'db'));
    $link_id = $parsed_args['link_id'];
    $link_name = $parsed_args['link_name'];
    $link_url = $parsed_args['link_url'];
    $update = false;
    if (!empty($link_id)) {
        $update = true;
    }
    if ('' === trim($link_name)) {
        if ('' !== trim($link_url)) {
            $link_name = $link_url;
        } else {
            return 0;
        }
    }
    if ('' === trim($link_url)) {
        return 0;
    }
    $link_rating = !empty($parsed_args['link_rating']) ? $parsed_args['link_rating'] : 0;
    $link_image = !empty($parsed_args['link_image']) ? $parsed_args['link_image'] : '';
    $link_target = !empty($parsed_args['link_target']) ? $parsed_args['link_target'] : '';
    $link_visible = !empty($parsed_args['link_visible']) ? $parsed_args['link_visible'] : 'Y';
    $link_owner = !empty($parsed_args['link_owner']) ? $parsed_args['link_owner'] : get_current_user_id();
    $link_notes = !empty($parsed_args['link_notes']) ? $parsed_args['link_notes'] : '';
    $link_description = !empty($parsed_args['link_description']) ? $parsed_args['link_description'] : '';
    $link_rss = !empty($parsed_args['link_rss']) ? $parsed_args['link_rss'] : '';
    $link_rel = !empty($parsed_args['link_rel']) ? $parsed_args['link_rel'] : '';
    $link_category = !empty($parsed_args['link_category']) ? $parsed_args['link_category'] : array();
    // Make sure we set a valid category.
    if (!is_array($link_category) || 0 === count($link_category)) {
        $link_category = array(get_option('default_link_category'));
    }
    if ($update) {
        if (false === $wpdb->update($wpdb->links, compact('link_url', 'link_name', 'link_image', 'link_target', 'link_description', 'link_visible', 'link_owner', 'link_rating', 'link_rel', 'link_notes', 'link_rss'), compact('link_id'))) {
            if ($wp_error) {
                return new WP_Error('db_update_error', __('Could not update link in the database.'), $wpdb->last_error);
            } else {
                return 0;
            }
        }
    } else {
        if (false === $wpdb->insert($wpdb->links, compact('link_url', 'link_name', 'link_image', 'link_target', 'link_description', 'link_visible', 'link_owner', 'link_rating', 'link_rel', 'link_notes', 'link_rss'))) {
            if ($wp_error) {
                return new WP_Error('db_insert_error', __('Could not insert link into the database.'), $wpdb->last_error);
            } else {
                return 0;
            }
        }
        $link_id = (int) $wpdb->insert_id;
    }
    wp_set_link_cats($link_id, $link_category);
    if ($update) {
        /**
         * Fires after a link was updated in the database.
         *
         * @since 2.0.0
         *
         * @param int $link_id ID of the link that was updated.
         */
        do_action('edit_link', $link_id);
    } else {
        /**
         * Fires after a link was added to the database.
         *
         * @since 2.0.0
         *
         * @param int $link_id ID of the link that was added.
         */
        do_action('add_link', $link_id);
    }
    clean_bookmark_cache($link_id);
    return $link_id;
}
/**
 * Update link with the specified link categories.
 *
 * @since 2.1.0
 *
 * @param int   $link_id         ID of the link to update.
 * @param int[] $link_categories Array of link category IDs to add the link to.
 */
function wp_set_link_cats($link_id = 0, $link_categories = array())
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_set_link_cats") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php at line 251")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_set_link_cats:251@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/bookmark.php');
    die();
}
/**
 * Updates a link in the database.
 *
 * @since 2.0.0
 *
 * @param array $linkdata Link data to update. See wp_insert_link() for accepted arguments.
 * @return int|WP_Error Value 0 or WP_Error on failure. The updated link ID on success.
 */
function wp_update_link($linkdata)
{
    $link_id = (int) $linkdata['link_id'];
    $link = get_bookmark($link_id, ARRAY_A);
    // Escape data pulled from DB.
    $link = wp_slash($link);
    // Passed link category list overwrites existing category list if not empty.
    if (isset($linkdata['link_category']) && is_array($linkdata['link_category']) && count($linkdata['link_category']) > 0) {
        $link_cats = $linkdata['link_category'];
    } else {
        $link_cats = $link['link_category'];
    }
    // Merge old and new fields with new fields overwriting old ones.
    $linkdata = array_merge($link, $linkdata);
    $linkdata['link_category'] = $link_cats;
    return wp_insert_link($linkdata);
}
/**
 * Outputs the 'disabled' message for the WordPress Link Manager.
 *
 * @since 3.5.0
 * @access private
 *
 * @global string $pagenow
 */
function wp_link_manager_disabled_message()
{
    global $pagenow;
    if (!in_array($pagenow, array('link-manager.php', 'link-add.php', 'link.php'), true)) {
        return;
    }
    add_filter('pre_option_link_manager_enabled', '__return_true', 100);
    $really_can_manage_links = current_user_can('manage_links');
    remove_filter('pre_option_link_manager_enabled', '__return_true', 100);
    if ($really_can_manage_links && current_user_can('install_plugins')) {
        $link = network_admin_url('plugin-install.php?tab=search&amp;s=Link+Manager');
        /* translators: %s: URL to install the Link Manager plugin. */
        wp_die(sprintf(__('If you are looking to use the link manager, please install the <a href="%s">Link Manager</a> plugin.'), $link));
    }
    wp_die(__('Sorry, you are not allowed to edit the links for this site.'));
}