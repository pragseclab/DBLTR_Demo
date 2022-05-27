<?php

/**
 * Build Administration Menu.
 *
 * @package WordPress
 * @subpackage Administration
 */
if (is_network_admin()) {
    /**
     * Fires before the administration menu loads in the Network Admin.
     *
     * The hook fires before menus and sub-menus are removed based on user privileges.
     *
     * @private
     * @since 3.1.0
     */
    do_action('_network_admin_menu');
} elseif (is_user_admin()) {
    /**
     * Fires before the administration menu loads in the User Admin.
     *
     * The hook fires before menus and sub-menus are removed based on user privileges.
     *
     * @private
     * @since 3.1.0
     */
    do_action('_user_admin_menu');
} else {
    /**
     * Fires before the administration menu loads in the admin.
     *
     * The hook fires before menus and sub-menus are removed based on user privileges.
     *
     * @private
     * @since 2.2.0
     */
    do_action('_admin_menu');
}
// Create list of page plugin hook names.
foreach ($menu as $menu_page) {
    $pos = strpos($menu_page[2], '?');
    if (false !== $pos) {
        // Handle post_type=post|page|foo pages.
        $hook_name = substr($menu_page[2], 0, $pos);
        $hook_args = substr($menu_page[2], $pos + 1);
        wp_parse_str($hook_args, $hook_args);
        // Set the hook name to be the post type.
        if (isset($hook_args['post_type'])) {
            $hook_name = $hook_args['post_type'];
        } else {
            $hook_name = basename($hook_name, '.php');
        }
        unset($hook_args);
    } else {
        $hook_name = basename($menu_page[2], '.php');
    }
    $hook_name = sanitize_title($hook_name);
    if (isset($compat[$hook_name])) {
        $hook_name = $compat[$hook_name];
    } elseif (!$hook_name) {
        continue;
    }
    $admin_page_hooks[$menu_page[2]] = $hook_name;
}
unset($menu_page, $compat);
$_wp_submenu_nopriv = array();
$_wp_menu_nopriv = array();
// Loop over submenus and remove pages for which the user does not have privs.
foreach ($submenu as $parent => $sub) {
    foreach ($sub as $index => $data) {
        if (!current_user_can($data[1])) {
            unset($submenu[$parent][$index]);
            $_wp_submenu_nopriv[$parent][$data[2]] = true;
        }
    }
    unset($index, $data);
    if (empty($submenu[$parent])) {
        unset($submenu[$parent]);
    }
}
unset($sub, $parent);
/*
 * Loop over the top-level menu.
 * Menus for which the original parent is not accessible due to lack of privileges
 * will have the next submenu in line be assigned as the new menu parent.
 */
foreach ($menu as $id => $data) {
    if (empty($submenu[$data[2]])) {
        continue;
    }
    $subs = $submenu[$data[2]];
    $first_sub = reset($subs);
    $old_parent = $data[2];
    $new_parent = $first_sub[2];
    /*
     * If the first submenu is not the same as the assigned parent,
     * make the first submenu the new parent.
     */
    if ($new_parent != $old_parent) {
        $_wp_real_parent_file[$old_parent] = $new_parent;
        $menu[$id][2] = $new_parent;
        foreach ($submenu[$old_parent] as $index => $data) {
            $submenu[$new_parent][$index] = $submenu[$old_parent][$index];
            unset($submenu[$old_parent][$index]);
        }
        unset($submenu[$old_parent], $index);
        if (isset($_wp_submenu_nopriv[$old_parent])) {
            $_wp_submenu_nopriv[$new_parent] = $_wp_submenu_nopriv[$old_parent];
        }
    }
}
unset($id, $data, $subs, $first_sub, $old_parent, $new_parent);
if (is_network_admin()) {
    /**
     * Fires before the administration menu loads in the Network Admin.
     *
     * @since 3.1.0
     *
     * @param string $context Empty context.
     */
    do_action('network_admin_menu', '');
} elseif (is_user_admin()) {
    /**
     * Fires before the administration menu loads in the User Admin.
     *
     * @since 3.1.0
     *
     * @param string $context Empty context.
     */
    do_action('user_admin_menu', '');
} else {
    /**
     * Fires before the administration menu loads in the admin.
     *
     * @since 1.5.0
     *
     * @param string $context Empty context.
     */
    do_action('admin_menu', '');
}
/*
 * Remove menus that have no accessible submenus and require privileges
 * that the user does not have. Run re-parent loop again.
 */
foreach ($menu as $id => $data) {
    if (!current_user_can($data[1])) {
        $_wp_menu_nopriv[$data[2]] = true;
    }
    /*
     * If there is only one submenu and it is has same destination as the parent,
     * remove the submenu.
     */
    if (!empty($submenu[$data[2]]) && 1 === count($submenu[$data[2]])) {
        $subs = $submenu[$data[2]];
        $first_sub = reset($subs);
        if ($data[2] == $first_sub[2]) {
            unset($submenu[$data[2]]);
        }
    }
    // If submenu is empty...
    if (empty($submenu[$data[2]])) {
        // And user doesn't have privs, remove menu.
        if (isset($_wp_menu_nopriv[$data[2]])) {
            unset($menu[$id]);
        }
    }
}
unset($id, $data, $subs, $first_sub);
/**
 * @param string $add
 * @param string $class
 * @return string
 */
function add_cssclass($add, $class)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_cssclass") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/menu.php at line 177")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called add_cssclass:177@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/menu.php');
    die();
}
/**
 * @param array $menu
 * @return array
 */
function add_menu_classes($menu)
{
    $first = false;
    $lastorder = false;
    $i = 0;
    $mc = count($menu);
    foreach ($menu as $order => $top) {
        $i++;
        if (0 == $order) {
            // Dashboard is always shown/single.
            $menu[0][4] = add_cssclass('menu-top-first', $top[4]);
            $lastorder = 0;
            continue;
        }
        if (0 === strpos($top[2], 'separator') && false !== $lastorder) {
            // If separator.
            $first = true;
            $c = $menu[$lastorder][4];
            $menu[$lastorder][4] = add_cssclass('menu-top-last', $c);
            continue;
        }
        if ($first) {
            $c = $menu[$order][4];
            $menu[$order][4] = add_cssclass('menu-top-first', $c);
            $first = false;
        }
        if ($mc == $i) {
            // Last item.
            $c = $menu[$order][4];
            $menu[$order][4] = add_cssclass('menu-top-last', $c);
        }
        $lastorder = $order;
    }
    /**
     * Filters administration menus array with classes added for top-level items.
     *
     * @since 2.7.0
     *
     * @param array $menu Associative array of administration menu items.
     */
    return apply_filters('add_menu_classes', $menu);
}
uksort($menu, 'strnatcasecmp');
// Make it all pretty.
/**
 * Filters whether to enable custom ordering of the administration menu.
 *
 * See the {@see 'menu_order'} filter for reordering menu items.
 *
 * @since 2.8.0
 *
 * @param bool $custom Whether custom ordering is enabled. Default false.
 */
if (apply_filters('custom_menu_order', false)) {
    $menu_order = array();
    foreach ($menu as $menu_item) {
        $menu_order[] = $menu_item[2];
    }
    unset($menu_item);
    $default_menu_order = $menu_order;
    /**
     * Filters the order of administration menu items.
     *
     * A truthy value must first be passed to the {@see 'custom_menu_order'} filter
     * for this filter to work. Use the following to enable custom menu ordering:
     *
     *     add_filter( 'custom_menu_order', '__return_true' );
     *
     * @since 2.8.0
     *
     * @param array $menu_order An ordered array of menu items.
     */
    $menu_order = apply_filters('menu_order', $menu_order);
    $menu_order = array_flip($menu_order);
    $default_menu_order = array_flip($default_menu_order);
    /**
     * @global array $menu_order
     * @global array $default_menu_order
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    function sort_menu($a, $b)
    {
        global $menu_order, $default_menu_order;
        $a = $a[2];
        $b = $b[2];
        if (isset($menu_order[$a]) && !isset($menu_order[$b])) {
            return -1;
        } elseif (!isset($menu_order[$a]) && isset($menu_order[$b])) {
            return 1;
        } elseif (isset($menu_order[$a]) && isset($menu_order[$b])) {
            if ($menu_order[$a] == $menu_order[$b]) {
                return 0;
            }
            return $menu_order[$a] < $menu_order[$b] ? -1 : 1;
        } else {
            return $default_menu_order[$a] <= $default_menu_order[$b] ? -1 : 1;
        }
    }
    usort($menu, 'sort_menu');
    unset($menu_order, $default_menu_order);
}
// Prevent adjacent separators.
$prev_menu_was_separator = false;
foreach ($menu as $id => $data) {
    if (false === stristr($data[4], 'wp-menu-separator')) {
        // This item is not a separator, so falsey the toggler and do nothing.
        $prev_menu_was_separator = false;
    } else {
        // The previous item was a separator, so unset this one.
        if (true === $prev_menu_was_separator) {
            unset($menu[$id]);
        }
        // This item is a separator, so truthy the toggler and move on.
        $prev_menu_was_separator = true;
    }
}
unset($id, $data, $prev_menu_was_separator);
// Remove the last menu item if it is a separator.
$last_menu_key = array_keys($menu);
$last_menu_key = array_pop($last_menu_key);
if (!empty($menu) && 'wp-menu-separator' === $menu[$last_menu_key][4]) {
    unset($menu[$last_menu_key]);
}
unset($last_menu_key);
if (!user_can_access_admin_page()) {
    /**
     * Fires when access to an admin page is denied.
     *
     * @since 2.5.0
     */
    do_action('admin_page_access_denied');
    wp_die(__('Sorry, you are not allowed to access this page.'), 403);
}
$menu = add_menu_classes($menu);