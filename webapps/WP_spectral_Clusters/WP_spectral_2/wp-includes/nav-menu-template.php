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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_nav_menu") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/nav-menu-template.php at line 58")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_nav_menu:58@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/nav-menu-template.php');
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
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_wp_menu_item_classes_by_context") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/nav-menu-template.php at line 263")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _wp_menu_item_classes_by_context:263@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/nav-menu-template.php');
    die();
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
    $walker = empty($r->walker) ? new Walker_Nav_Menu() : $r->walker;
    return $walker->walk($items, $depth, $r);
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
    static $_used_ids = array();
    if (in_array($item->ID, $_used_ids, true)) {
        return '';
    }
    $_used_ids[] = $item->ID;
    return $id;
}