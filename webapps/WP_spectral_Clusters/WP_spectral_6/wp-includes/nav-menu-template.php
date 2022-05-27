<?php

/**
 * Nav Menu API: Template functions
 *
 * @package WordPress
 * @subpackage Nav_Menus
 * @since 3.0.0
 */
/** Walker_Nav_Menu class */
require_once ABSPATH . WPINC . '/class-walker-nav-menu.php';
/**
 * Displays a navigation menu.
 *
 * @since 3.0.0
 * @since 4.7.0 Added the `item_spacing` argument.
 * @since 5.5.0 Added the `container_aria_label` argument.
 *
 * @param array $args {
 *     Optional. Array of nav menu arguments.
 *
 *     @type int|string|WP_Term $menu                 Desired menu. Accepts a menu ID, slug, name, or object.
 *                                                    Default empty.
 *     @type string             $menu_class           CSS class to use for the ul element which forms the menu.
 *                                                    Default 'menu'.
 *     @type string             $menu_id              The ID that is applied to the ul element which forms the menu.
 *                                                    Default is the menu slug, incremented.
 *     @type string             $container            Whether to wrap the ul, and what to wrap it with.
 *                                                    Default 'div'.
 *     @type string             $container_class      Class that is applied to the container.
 *                                                    Default 'menu-{menu slug}-container'.
 *     @type string             $container_id         The ID that is applied to the container. Default empty.
 *     @type string             $container_aria_label The aria-label attribute that is applied to the container
 *                                                    when it's a nav element. Default empty.
 *     @type callable|false     $fallback_cb          If the menu doesn't exist, a callback function will fire.
 *                                                    Default is 'wp_page_menu'. Set to false for no fallback.
 *     @type string             $before               Text before the link markup. Default empty.
 *     @type string             $after                Text after the link markup. Default empty.
 *     @type string             $link_before          Text before the link text. Default empty.
 *     @type string             $link_after           Text after the link text. Default empty.
 *     @type bool               $echo                 Whether to echo the menu or return it. Default true.
 *     @type int                $depth                How many levels of the hierarchy are to be included.
 *                                                    0 means all. Default 0.
 *                                                    Default 0.
 *     @type object             $walker               Instance of a custom walker class. Default empty.
 *     @type string             $theme_location       Theme location to be used. Must be registered with
 *                                                    register_nav_menu() in order to be selectable by the user.
 *     @type string             $items_wrap           How the list items should be wrapped. Uses printf() format with
 *                                                    numbered placeholders. Default is a ul with an id and class.
 *     @type string             $item_spacing         Whether to preserve whitespace within the menu's HTML.
 *                                                    Accepts 'preserve' or 'discard'. Default 'preserve'.
 * }
 * @return void|string|false Void if 'echo' argument is true, menu output if 'echo' is false.
 *                           False if there are no items or no menu was found.
 */
function wp_nav_menu($args = array())
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_nav_menu") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/nav-menu-template.php at line 58")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_nav_menu:58@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/nav-menu-template.php');
    die();
}
/**
 * Adds the class property classes for the current context, if applicable.
 *
 * @access private
 * @since 3.0.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress rewrite component.
 *
 * @param array $menu_items The current menu item objects to which to add the class property information.
 */
function _wp_menu_item_classes_by_context(&$menu_items)
{
    global $wp_query, $wp_rewrite;
    $queried_object = $wp_query->get_queried_object();
    $queried_object_id = (int) $wp_query->queried_object_id;
    $active_object = '';
    $active_ancestor_item_ids = array();
    $active_parent_item_ids = array();
    $active_parent_object_ids = array();
    $possible_taxonomy_ancestors = array();
    $possible_object_parents = array();
    $home_page_id = (int) get_option('page_for_posts');
    if ($wp_query->is_singular && !empty($queried_object->post_type) && !is_post_type_hierarchical($queried_object->post_type)) {
        foreach ((array) get_object_taxonomies($queried_object->post_type) as $taxonomy) {
            if (is_taxonomy_hierarchical($taxonomy)) {
                $term_hierarchy = _get_term_hierarchy($taxonomy);
                $terms = wp_get_object_terms($queried_object_id, $taxonomy, array('fields' => 'ids'));
                if (is_array($terms)) {
                    $possible_object_parents = array_merge($possible_object_parents, $terms);
                    $term_to_ancestor = array();
                    foreach ((array) $term_hierarchy as $anc => $descs) {
                        foreach ((array) $descs as $desc) {
                            $term_to_ancestor[$desc] = $anc;
                        }
                    }
                    foreach ($terms as $desc) {
                        do {
                            $possible_taxonomy_ancestors[$taxonomy][] = $desc;
                            if (isset($term_to_ancestor[$desc])) {
                                $_desc = $term_to_ancestor[$desc];
                                unset($term_to_ancestor[$desc]);
                                $desc = $_desc;
                            } else {
                                $desc = 0;
                            }
                        } while (!empty($desc));
                    }
                }
            }
        }
    } elseif (!empty($queried_object->taxonomy) && is_taxonomy_hierarchical($queried_object->taxonomy)) {
        $term_hierarchy = _get_term_hierarchy($queried_object->taxonomy);
        $term_to_ancestor = array();
        foreach ((array) $term_hierarchy as $anc => $descs) {
            foreach ((array) $descs as $desc) {
                $term_to_ancestor[$desc] = $anc;
            }
        }
        $desc = $queried_object->term_id;
        do {
            $possible_taxonomy_ancestors[$queried_object->taxonomy][] = $desc;
            if (isset($term_to_ancestor[$desc])) {
                $_desc = $term_to_ancestor[$desc];
                unset($term_to_ancestor[$desc]);
                $desc = $_desc;
            } else {
                $desc = 0;
            }
        } while (!empty($desc));
    }
    $possible_object_parents = array_filter($possible_object_parents);
    $front_page_url = home_url();
    $front_page_id = (int) get_option('page_on_front');
    $privacy_policy_page_id = (int) get_option('wp_page_for_privacy_policy');
    foreach ((array) $menu_items as $key => $menu_item) {
        $menu_items[$key]->current = false;
        $classes = (array) $menu_item->classes;
        $classes[] = 'menu-item';
        $classes[] = 'menu-item-type-' . $menu_item->type;
        $classes[] = 'menu-item-object-' . $menu_item->object;
        // This menu item is set as the 'Front Page'.
        if ('post_type' === $menu_item->type && $front_page_id === (int) $menu_item->object_id) {
            $classes[] = 'menu-item-home';
        }
        // This menu item is set as the 'Privacy Policy Page'.
        if ('post_type' === $menu_item->type && $privacy_policy_page_id === (int) $menu_item->object_id) {
            $classes[] = 'menu-item-privacy-policy';
        }
        // If the menu item corresponds to a taxonomy term for the currently queried non-hierarchical post object.
        if ($wp_query->is_singular && 'taxonomy' === $menu_item->type && in_array((int) $menu_item->object_id, $possible_object_parents, true)) {
            $active_parent_object_ids[] = (int) $menu_item->object_id;
            $active_parent_item_ids[] = (int) $menu_item->db_id;
            $active_object = $queried_object->post_type;
            // If the menu item corresponds to the currently queried post or taxonomy object.
        } elseif ($menu_item->object_id == $queried_object_id && (!empty($home_page_id) && 'post_type' === $menu_item->type && $wp_query->is_home && $home_page_id == $menu_item->object_id || 'post_type' === $menu_item->type && $wp_query->is_singular || 'taxonomy' === $menu_item->type && ($wp_query->is_category || $wp_query->is_tag || $wp_query->is_tax) && $queried_object->taxonomy == $menu_item->object)) {
            $classes[] = 'current-menu-item';
            $menu_items[$key]->current = true;
            $_anc_id = (int) $menu_item->db_id;
            while (($_anc_id = (int) get_post_meta($_anc_id, '_menu_item_menu_item_parent', true)) && !in_array($_anc_id, $active_ancestor_item_ids, true)) {
                $active_ancestor_item_ids[] = $_anc_id;
            }
            if ('post_type' === $menu_item->type && 'page' === $menu_item->object) {
                // Back compat classes for pages to match wp_page_menu().
                $classes[] = 'page_item';
                $classes[] = 'page-item-' . $menu_item->object_id;
                $classes[] = 'current_page_item';
            }
            $active_parent_item_ids[] = (int) $menu_item->menu_item_parent;
            $active_parent_object_ids[] = (int) $menu_item->post_parent;
            $active_object = $menu_item->object;
            // If the menu item corresponds to the currently queried post type archive.
        } elseif ('post_type_archive' === $menu_item->type && is_post_type_archive(array($menu_item->object))) {
            $classes[] = 'current-menu-item';
            $menu_items[$key]->current = true;
            $_anc_id = (int) $menu_item->db_id;
            while (($_anc_id = (int) get_post_meta($_anc_id, '_menu_item_menu_item_parent', true)) && !in_array($_anc_id, $active_ancestor_item_ids, true)) {
                $active_ancestor_item_ids[] = $_anc_id;
            }
            $active_parent_item_ids[] = (int) $menu_item->menu_item_parent;
            // If the menu item corresponds to the currently requested URL.
        } elseif ('custom' === $menu_item->object && isset($_SERVER['HTTP_HOST'])) {
            $_root_relative_current = untrailingslashit($_SERVER['REQUEST_URI']);
            // If it's the customize page then it will strip the query var off the URL before entering the comparison block.
            if (is_customize_preview()) {
                $_root_relative_current = strtok(untrailingslashit($_SERVER['REQUEST_URI']), '?');
            }
            $current_url = set_url_scheme('http://' . $_SERVER['HTTP_HOST'] . $_root_relative_current);
            $raw_item_url = strpos($menu_item->url, '#') ? substr($menu_item->url, 0, strpos($menu_item->url, '#')) : $menu_item->url;
            $item_url = set_url_scheme(untrailingslashit($raw_item_url));
            $_indexless_current = untrailingslashit(preg_replace('/' . preg_quote($wp_rewrite->index, '/') . '$/', '', $current_url));
            $matches = array($current_url, urldecode($current_url), $_indexless_current, urldecode($_indexless_current), $_root_relative_current, urldecode($_root_relative_current));
            if ($raw_item_url && in_array($item_url, $matches, true)) {
                $classes[] = 'current-menu-item';
                $menu_items[$key]->current = true;
                $_anc_id = (int) $menu_item->db_id;
                while (($_anc_id = (int) get_post_meta($_anc_id, '_menu_item_menu_item_parent', true)) && !in_array($_anc_id, $active_ancestor_item_ids, true)) {
                    $active_ancestor_item_ids[] = $_anc_id;
                }
                if (in_array(home_url(), array(untrailingslashit($current_url), untrailingslashit($_indexless_current)), true)) {
                    // Back compat for home link to match wp_page_menu().
                    $classes[] = 'current_page_item';
                }
                $active_parent_item_ids[] = (int) $menu_item->menu_item_parent;
                $active_parent_object_ids[] = (int) $menu_item->post_parent;
                $active_object = $menu_item->object;
                // Give front page item the 'current-menu-item' class when extra query arguments are involved.
            } elseif ($item_url == $front_page_url && is_front_page()) {
                $classes[] = 'current-menu-item';
            }
            if (untrailingslashit($item_url) == home_url()) {
                $classes[] = 'menu-item-home';
            }
        }
        // Back-compat with wp_page_menu(): add "current_page_parent" to static home page link for any non-page query.
        if (!empty($home_page_id) && 'post_type' === $menu_item->type && empty($wp_query->is_page) && $home_page_id == $menu_item->object_id) {
            $classes[] = 'current_page_parent';
        }
        $menu_items[$key]->classes = array_unique($classes);
    }
    $active_ancestor_item_ids = array_filter(array_unique($active_ancestor_item_ids));
    $active_parent_item_ids = array_filter(array_unique($active_parent_item_ids));
    $active_parent_object_ids = array_filter(array_unique($active_parent_object_ids));
    // Set parent's class.
    foreach ((array) $menu_items as $key => $parent_item) {
        $classes = (array) $parent_item->classes;
        $menu_items[$key]->current_item_ancestor = false;
        $menu_items[$key]->current_item_parent = false;
        if (isset($parent_item->type) && ('post_type' === $parent_item->type && !empty($queried_object->post_type) && is_post_type_hierarchical($queried_object->post_type) && in_array((int) $parent_item->object_id, $queried_object->ancestors, true) && $parent_item->object != $queried_object->ID || 'taxonomy' === $parent_item->type && isset($possible_taxonomy_ancestors[$parent_item->object]) && in_array((int) $parent_item->object_id, $possible_taxonomy_ancestors[$parent_item->object], true) && (!isset($queried_object->term_id) || $parent_item->object_id != $queried_object->term_id))) {
            if (!empty($queried_object->taxonomy)) {
                $classes[] = 'current-' . $queried_object->taxonomy . '-ancestor';
            } else {
                $classes[] = 'current-' . $queried_object->post_type . '-ancestor';
            }
        }
        if (in_array((int) $parent_item->db_id, $active_ancestor_item_ids, true)) {
            $classes[] = 'current-menu-ancestor';
            $menu_items[$key]->current_item_ancestor = true;
        }
        if (in_array((int) $parent_item->db_id, $active_parent_item_ids, true)) {
            $classes[] = 'current-menu-parent';
            $menu_items[$key]->current_item_parent = true;
        }
        if (in_array((int) $parent_item->object_id, $active_parent_object_ids, true)) {
            $classes[] = 'current-' . $active_object . '-parent';
        }
        if ('post_type' === $parent_item->type && 'page' === $parent_item->object) {
            // Back compat classes for pages to match wp_page_menu().
            if (in_array('current-menu-parent', $classes, true)) {
                $classes[] = 'current_page_parent';
            }
            if (in_array('current-menu-ancestor', $classes, true)) {
                $classes[] = 'current_page_ancestor';
            }
        }
        $menu_items[$key]->classes = array_unique($classes);
    }
}
/**
 * Retrieves the HTML list content for nav menu items.
 *
 * @uses Walker_Nav_Menu to create HTML list content.
 * @since 3.0.0
 *
 * @param array    $items The menu items, sorted by each menu item's menu order.
 * @param int      $depth Depth of the item in reference to parents.
 * @param stdClass $r     An object containing wp_nav_menu() arguments.
 * @return string The HTML list content for the menu items.
 */
function walk_nav_menu_tree($items, $depth, $r)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("walk_nav_menu_tree") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/nav-menu-template.php at line 461")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called walk_nav_menu_tree:461@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/nav-menu-template.php');
    die();
}
/**
 * Prevents a menu item ID from being used more than once.
 *
 * @since 3.0.1
 * @access private
 *
 * @param string $id
 * @param object $item
 * @return string
 */
function _nav_menu_item_id_use_once($id, $item)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_nav_menu_item_id_use_once") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/nav-menu-template.php at line 476")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _nav_menu_item_id_use_once:476@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/nav-menu-template.php');
    die();
}