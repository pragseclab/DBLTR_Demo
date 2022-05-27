<?php

/**
 * Core Widgets API
 *
 * This API is used for creating dynamic sidebar without hardcoding functionality into
 * themes
 *
 * Includes both internal WordPress routines and theme-use routines.
 *
 * This functionality was found in a plugin before the WordPress 2.2 release, which
 * included it in the core from that point on.
 *
 * @link https://wordpress.org/support/article/wordpress-widgets/
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 2.2.0
 */
//
// Global Variables.
//
/** @ignore */
global $wp_registered_sidebars, $wp_registered_widgets, $wp_registered_widget_controls, $wp_registered_widget_updates;
/**
 * Stores the sidebars, since many themes can have more than one.
 *
 * @global array $wp_registered_sidebars Registered sidebars.
 * @since 2.2.0
 */
$wp_registered_sidebars = array();
/**
 * Stores the registered widgets.
 *
 * @global array $wp_registered_widgets
 * @since 2.2.0
 */
$wp_registered_widgets = array();
/**
 * Stores the registered widget controls (options).
 *
 * @global array $wp_registered_widget_controls
 * @since 2.2.0
 */
$wp_registered_widget_controls = array();
/**
 * @global array $wp_registered_widget_updates
 */
$wp_registered_widget_updates = array();
/**
 * Private
 *
 * @global array $_wp_sidebars_widgets
 */
$_wp_sidebars_widgets = array();
/**
 * Private
 *
 * @global array $_wp_deprecated_widgets_callbacks
 */
$GLOBALS['_wp_deprecated_widgets_callbacks'] = array('wp_widget_pages', 'wp_widget_pages_control', 'wp_widget_calendar', 'wp_widget_calendar_control', 'wp_widget_archives', 'wp_widget_archives_control', 'wp_widget_links', 'wp_widget_meta', 'wp_widget_meta_control', 'wp_widget_search', 'wp_widget_recent_entries', 'wp_widget_recent_entries_control', 'wp_widget_tag_cloud', 'wp_widget_tag_cloud_control', 'wp_widget_categories', 'wp_widget_categories_control', 'wp_widget_text', 'wp_widget_text_control', 'wp_widget_rss', 'wp_widget_rss_control', 'wp_widget_recent_comments', 'wp_widget_recent_comments_control');
//
// Template tags & API functions.
//
/**
 * Register a widget
 *
 * Registers a WP_Widget widget
 *
 * @since 2.8.0
 * @since 4.6.0 Updated the `$widget` parameter to also accept a WP_Widget instance object
 *              instead of simply a `WP_Widget` subclass name.
 *
 * @see WP_Widget
 *
 * @global WP_Widget_Factory $wp_widget_factory
 *
 * @param string|WP_Widget $widget Either the name of a `WP_Widget` subclass or an instance of a `WP_Widget` subclass.
 */
function register_widget($widget)
{
    global $wp_widget_factory;
    $wp_widget_factory->register($widget);
}
/**
 * Unregisters a widget.
 *
 * Unregisters a WP_Widget widget. Useful for un-registering default widgets.
 * Run within a function hooked to the {@see 'widgets_init'} action.
 *
 * @since 2.8.0
 * @since 4.6.0 Updated the `$widget` parameter to also accept a WP_Widget instance object
 *              instead of simply a `WP_Widget` subclass name.
 *
 * @see WP_Widget
 *
 * @global WP_Widget_Factory $wp_widget_factory
 *
 * @param string|WP_Widget $widget Either the name of a `WP_Widget` subclass or an instance of a `WP_Widget` subclass.
 */
function unregister_widget($widget)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unregister_widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 104")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called unregister_widget:104@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Creates multiple sidebars.
 *
 * If you wanted to quickly create multiple sidebars for a theme or internally.
 * This function will allow you to do so. If you don't pass the 'name' and/or
 * 'id' in `$args`, then they will be built for you.
 *
 * @since 2.2.0
 *
 * @see register_sidebar() The second parameter is documented by register_sidebar() and is the same here.
 *
 * @global array $wp_registered_sidebars The new sidebars are stored in this array by sidebar ID.
 *
 * @param int          $number Optional. Number of sidebars to create. Default 1.
 * @param array|string $args {
 *     Optional. Array or string of arguments for building a sidebar.
 *
 *     @type string $id   The base string of the unique identifier for each sidebar. If provided, and multiple
 *                        sidebars are being defined, the ID will have "-2" appended, and so on.
 *                        Default 'sidebar-' followed by the number the sidebar creation is currently at.
 *     @type string $name The name or title for the sidebars displayed in the admin dashboard. If registering
 *                        more than one sidebar, include '%d' in the string as a placeholder for the uniquely
 *                        assigned number for each sidebar.
 *                        Default 'Sidebar' for the first sidebar, otherwise 'Sidebar %d'.
 * }
 */
function register_sidebars($number = 1, $args = array())
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_sidebars") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 135")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called register_sidebars:135@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Builds the definition for a single sidebar and returns the ID.
 *
 * Accepts either a string or an array and then parses that against a set
 * of default arguments for the new sidebar. WordPress will automatically
 * generate a sidebar ID and name based on the current number of registered
 * sidebars if those arguments are not included.
 *
 * When allowing for automatic generation of the name and ID parameters, keep
 * in mind that the incrementor for your sidebar can change over time depending
 * on what other plugins and themes are installed.
 *
 * If theme support for 'widgets' has not yet been added when this function is
 * called, it will be automatically enabled through the use of add_theme_support()
 *
 * @since 2.2.0
 * @since 5.6.0 Added the `before_sidebar` and `after_sidebar` arguments.
 *
 * @global array $wp_registered_sidebars Registered sidebars.
 *
 * @param array|string $args {
 *     Optional. Array or string of arguments for the sidebar being registered.
 *
 *     @type string $name           The name or title of the sidebar displayed in the Widgets
 *                                  interface. Default 'Sidebar $instance'.
 *     @type string $id             The unique identifier by which the sidebar will be called.
 *                                  Default 'sidebar-$instance'.
 *     @type string $description    Description of the sidebar, displayed in the Widgets interface.
 *                                  Default empty string.
 *     @type string $class          Extra CSS class to assign to the sidebar in the Widgets interface.
 *                                  Default empty.
 *     @type string $before_widget  HTML content to prepend to each widget's HTML output when assigned
 *                                  to this sidebar. Receives the widget's ID attribute as `%1$s`
 *                                  and class name as `%2$s`. Default is an opening list item element.
 *     @type string $after_widget   HTML content to append to each widget's HTML output when assigned
 *                                  to this sidebar. Default is a closing list item element.
 *     @type string $before_title   HTML content to prepend to the sidebar title when displayed.
 *                                  Default is an opening h2 element.
 *     @type string $after_title    HTML content to append to the sidebar title when displayed.
 *                                  Default is a closing h2 element.
 *     @type string $before_sidebar HTML content to prepend to the sidebar when displayed.
 *                                  Receives the `$id` argument as `%1$s` and `$class` as `%2$s`.
 *                                  Outputs after the {@see 'dynamic_sidebar_before'} action.
 *                                  Default empty string.
 *     @type string $after_sidebar  HTML content to append to the sidebar when displayed.
 *                                  Outputs before the {@see 'dynamic_sidebar_after'} action.
 *                                  Default empty string.
 * }
 * @return string Sidebar ID added to $wp_registered_sidebars global.
 */
function register_sidebar($args = array())
{
    global $wp_registered_sidebars;
    $i = count($wp_registered_sidebars) + 1;
    $id_is_empty = empty($args['id']);
    $defaults = array(
        /* translators: %d: Sidebar number. */
        'name' => sprintf(__('Sidebar %d'), $i),
        'id' => "sidebar-{$i}",
        'description' => '',
        'class' => '',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => "</li>\n",
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => "</h2>\n",
        'before_sidebar' => '',
        'after_sidebar' => '',
    );
    /**
     * Filters the sidebar default arguments.
     *
     * @since 5.3.0
     *
     * @see register_sidebar()
     *
     * @param array $defaults The default sidebar arguments.
     */
    $sidebar = wp_parse_args($args, apply_filters('register_sidebar_defaults', $defaults));
    if ($id_is_empty) {
        _doing_it_wrong(__FUNCTION__, sprintf(
            /* translators: 1: The 'id' argument, 2: Sidebar name, 3: Recommended 'id' value. */
            __('No %1$s was set in the arguments array for the "%2$s" sidebar. Defaulting to "%3$s". Manually set the %1$s to "%3$s" to silence this notice and keep existing sidebar content.'),
            '<code>id</code>',
            $sidebar['name'],
            $sidebar['id']
        ), '4.2.0');
    }
    $wp_registered_sidebars[$sidebar['id']] = $sidebar;
    add_theme_support('widgets');
    /**
     * Fires once a sidebar has been registered.
     *
     * @since 3.0.0
     *
     * @param array $sidebar Parsed arguments for the registered sidebar.
     */
    do_action('register_sidebar', $sidebar);
    return $sidebar['id'];
}
/**
 * Removes a sidebar from the list.
 *
 * @since 2.2.0
 *
 * @global array $wp_registered_sidebars Registered sidebars.
 *
 * @param string|int $sidebar_id The ID of the sidebar when it was registered.
 */
function unregister_sidebar($sidebar_id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unregister_sidebar") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 280")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called unregister_sidebar:280@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Checks if a sidebar is registered.
 *
 * @since 4.4.0
 *
 * @global array $wp_registered_sidebars Registered sidebars.
 *
 * @param string|int $sidebar_id The ID of the sidebar when it was registered.
 * @return bool True if the sidebar is registered, false otherwise.
 */
function is_registered_sidebar($sidebar_id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_registered_sidebar") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 295")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called is_registered_sidebar:295@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Register an instance of a widget.
 *
 * The default widget option is 'classname' that can be overridden.
 *
 * The function can also be used to un-register widgets when `$output_callback`
 * parameter is an empty string.
 *
 * @since 2.2.0
 * @since 5.3.0 Formalized the existing and already documented `...$params` parameter
 *              by adding it to the function signature.
 *
 * @global array $wp_registered_widgets            Uses stored registered widgets.
 * @global array $wp_registered_widget_controls    Stores the registered widget controls (options).
 * @global array $wp_registered_widget_updates
 * @global array $_wp_deprecated_widgets_callbacks
 *
 * @param int|string $id              Widget ID.
 * @param string     $name            Widget display title.
 * @param callable   $output_callback Run when widget is called.
 * @param array      $options {
 *     Optional. An array of supplementary widget options for the instance.
 *
 *     @type string $classname   Class name for the widget's HTML container. Default is a shortened
 *                               version of the output callback name.
 *     @type string $description Widget description for display in the widget administration
 *                               panel and/or theme.
 * }
 * @param mixed      ...$params       Optional additional parameters to pass to the callback function when it's called.
 */
function wp_register_sidebar_widget($id, $name, $output_callback, $options = array(), ...$params)
{
    global $wp_registered_widgets, $wp_registered_widget_controls, $wp_registered_widget_updates, $_wp_deprecated_widgets_callbacks;
    $id = strtolower($id);
    if (empty($output_callback)) {
        unset($wp_registered_widgets[$id]);
        return;
    }
    $id_base = _get_widget_id_base($id);
    if (in_array($output_callback, $_wp_deprecated_widgets_callbacks, true) && !is_callable($output_callback)) {
        unset($wp_registered_widget_controls[$id]);
        unset($wp_registered_widget_updates[$id_base]);
        return;
    }
    $defaults = array('classname' => $output_callback);
    $options = wp_parse_args($options, $defaults);
    $widget = array('name' => $name, 'id' => $id, 'callback' => $output_callback, 'params' => $params);
    $widget = array_merge($widget, $options);
    if (is_callable($output_callback) && (!isset($wp_registered_widgets[$id]) || did_action('widgets_init'))) {
        /**
         * Fires once for each registered widget.
         *
         * @since 3.0.0
         *
         * @param array $widget An array of default widget arguments.
         */
        do_action('wp_register_sidebar_widget', $widget);
        $wp_registered_widgets[$id] = $widget;
    }
}
/**
 * Retrieve description for widget.
 *
 * When registering widgets, the options can also include 'description' that
 * describes the widget for display on the widget administration panel or
 * in the theme.
 *
 * @since 2.5.0
 *
 * @global array $wp_registered_widgets
 *
 * @param int|string $id Widget ID.
 * @return string|void Widget description, if available.
 */
function wp_widget_description($id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_widget_description") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 374")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_widget_description:374@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Retrieve description for a sidebar.
 *
 * When registering sidebars a 'description' parameter can be included that
 * describes the sidebar for display on the widget administration panel.
 *
 * @since 2.9.0
 *
 * @global array $wp_registered_sidebars Registered sidebars.
 *
 * @param string $id sidebar ID.
 * @return string|void Sidebar description, if available.
 */
function wp_sidebar_description($id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_sidebar_description") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 397")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_sidebar_description:397@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Remove widget from sidebar.
 *
 * @since 2.2.0
 *
 * @param int|string $id Widget ID.
 */
function wp_unregister_sidebar_widget($id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_unregister_sidebar_widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 421")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_unregister_sidebar_widget:421@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Registers widget control callback for customizing options.
 *
 * @since 2.2.0
 * @since 5.3.0 Formalized the existing and already documented `...$params` parameter
 *              by adding it to the function signature.
 *
 * @global array $wp_registered_widget_controls
 * @global array $wp_registered_widget_updates
 * @global array $wp_registered_widgets
 * @global array $_wp_deprecated_widgets_callbacks
 *
 * @param int|string $id               Sidebar ID.
 * @param string     $name             Sidebar display name.
 * @param callable   $control_callback Run when sidebar is displayed.
 * @param array      $options {
 *     Optional. Array or string of control options. Default empty array.
 *
 *     @type int        $height  Never used. Default 200.
 *     @type int        $width   Width of the fully expanded control form (but try hard to use the default width).
 *                               Default 250.
 *     @type int|string $id_base Required for multi-widgets, i.e widgets that allow multiple instances such as the
 *                               text widget. The widget id will end up looking like `{$id_base}-{$unique_number}`.
 * }
 * @param mixed      ...$params        Optional additional parameters to pass to the callback function when it's called.
 */
function wp_register_widget_control($id, $name, $control_callback, $options = array(), ...$params)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_register_widget_control") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 453")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_register_widget_control:453@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Registers the update callback for a widget.
 *
 * @since 2.8.0
 * @since 5.3.0 Formalized the existing and already documented `...$params` parameter
 *              by adding it to the function signature.
 *
 * @global array $wp_registered_widget_updates
 *
 * @param string   $id_base         The base ID of a widget created by extending WP_Widget.
 * @param callable $update_callback Update callback method for the widget.
 * @param array    $options         Optional. Widget control options. See wp_register_widget_control().
 *                                  Default empty array.
 * @param mixed    ...$params       Optional additional parameters to pass to the callback function when it's called.
 */
function _register_widget_update_callback($id_base, $update_callback, $options = array(), ...$params)
{
    global $wp_registered_widget_updates;
    if (isset($wp_registered_widget_updates[$id_base])) {
        if (empty($update_callback)) {
            unset($wp_registered_widget_updates[$id_base]);
        }
        return;
    }
    $widget = array('callback' => $update_callback, 'params' => $params);
    $widget = array_merge($widget, $options);
    $wp_registered_widget_updates[$id_base] = $widget;
}
/**
 * Registers the form callback for a widget.
 *
 * @since 2.8.0
 * @since 5.3.0 Formalized the existing and already documented `...$params` parameter
 *              by adding it to the function signature.
 *
 * @global array $wp_registered_widget_controls
 *
 * @param int|string $id            Widget ID.
 * @param string     $name          Name attribute for the widget.
 * @param callable   $form_callback Form callback.
 * @param array      $options       Optional. Widget control options. See wp_register_widget_control().
 *                                  Default empty array.
 * @param mixed      ...$params     Optional additional parameters to pass to the callback function when it's called.
 */
function _register_widget_form_callback($id, $name, $form_callback, $options = array(), ...$params)
{
    global $wp_registered_widget_controls;
    $id = strtolower($id);
    if (empty($form_callback)) {
        unset($wp_registered_widget_controls[$id]);
        return;
    }
    if (isset($wp_registered_widget_controls[$id]) && !did_action('widgets_init')) {
        return;
    }
    $defaults = array('width' => 250, 'height' => 200);
    $options = wp_parse_args($options, $defaults);
    $options['width'] = (int) $options['width'];
    $options['height'] = (int) $options['height'];
    $widget = array('name' => $name, 'id' => $id, 'callback' => $form_callback, 'params' => $params);
    $widget = array_merge($widget, $options);
    $wp_registered_widget_controls[$id] = $widget;
}
/**
 * Remove control callback for widget.
 *
 * @since 2.2.0
 *
 * @param int|string $id Widget ID.
 */
function wp_unregister_widget_control($id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_unregister_widget_control") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 557")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_unregister_widget_control:557@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Display dynamic sidebar.
 *
 * By default this displays the default sidebar or 'sidebar-1'. If your theme specifies the 'id' or
 * 'name' parameter for its registered sidebars you can pass an ID or name as the $index parameter.
 * Otherwise, you can pass in a numerical index to display the sidebar at that index.
 *
 * @since 2.2.0
 *
 * @global array $wp_registered_sidebars Registered sidebars.
 * @global array $wp_registered_widgets  Registered widgets.
 *
 * @param int|string $index Optional. Index, name or ID of dynamic sidebar. Default 1.
 * @return bool True, if widget sidebar was found and called. False if not found or not called.
 */
function dynamic_sidebar($index = 1)
{
    global $wp_registered_sidebars, $wp_registered_widgets;
    if (is_int($index)) {
        $index = "sidebar-{$index}";
    } else {
        $index = sanitize_title($index);
        foreach ((array) $wp_registered_sidebars as $key => $value) {
            if (sanitize_title($value['name']) === $index) {
                $index = $key;
                break;
            }
        }
    }
    $sidebars_widgets = wp_get_sidebars_widgets();
    if (empty($wp_registered_sidebars[$index]) || empty($sidebars_widgets[$index]) || !is_array($sidebars_widgets[$index])) {
        /** This action is documented in wp-includes/widget.php */
        do_action('dynamic_sidebar_before', $index, false);
        /** This action is documented in wp-includes/widget.php */
        do_action('dynamic_sidebar_after', $index, false);
        /** This filter is documented in wp-includes/widget.php */
        return apply_filters('dynamic_sidebar_has_widgets', false, $index);
    }
    $sidebar = $wp_registered_sidebars[$index];
    $sidebar['before_sidebar'] = sprintf($sidebar['before_sidebar'], $sidebar['id'], $sidebar['class']);
    /**
     * Fires before widgets are rendered in a dynamic sidebar.
     *
     * Note: The action also fires for empty sidebars, and on both the front end
     * and back end, including the Inactive Widgets sidebar on the Widgets screen.
     *
     * @since 3.9.0
     *
     * @param int|string $index       Index, name, or ID of the dynamic sidebar.
     * @param bool       $has_widgets Whether the sidebar is populated with widgets.
     *                                Default true.
     */
    do_action('dynamic_sidebar_before', $index, true);
    if (!is_admin() && !empty($sidebar['before_sidebar'])) {
        echo $sidebar['before_sidebar'];
    }
    $did_one = false;
    foreach ((array) $sidebars_widgets[$index] as $id) {
        if (!isset($wp_registered_widgets[$id])) {
            continue;
        }
        $params = array_merge(array(array_merge($sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']))), (array) $wp_registered_widgets[$id]['params']);
        // Substitute HTML `id` and `class` attributes into `before_widget`.
        $classname_ = '';
        foreach ((array) $wp_registered_widgets[$id]['classname'] as $cn) {
            if (is_string($cn)) {
                $classname_ .= '_' . $cn;
            } elseif (is_object($cn)) {
                $classname_ .= '_' . get_class($cn);
            }
        }
        $classname_ = ltrim($classname_, '_');
        $params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);
        /**
         * Filters the parameters passed to a widget's display callback.
         *
         * Note: The filter is evaluated on both the front end and back end,
         * including for the Inactive Widgets sidebar on the Widgets screen.
         *
         * @since 2.5.0
         *
         * @see register_sidebar()
         *
         * @param array $params {
         *     @type array $args  {
         *         An array of widget display arguments.
         *
         *         @type string $name          Name of the sidebar the widget is assigned to.
         *         @type string $id            ID of the sidebar the widget is assigned to.
         *         @type string $description   The sidebar description.
         *         @type string $class         CSS class applied to the sidebar container.
         *         @type string $before_widget HTML markup to prepend to each widget in the sidebar.
         *         @type string $after_widget  HTML markup to append to each widget in the sidebar.
         *         @type string $before_title  HTML markup to prepend to the widget title when displayed.
         *         @type string $after_title   HTML markup to append to the widget title when displayed.
         *         @type string $widget_id     ID of the widget.
         *         @type string $widget_name   Name of the widget.
         *     }
         *     @type array $widget_args {
         *         An array of multi-widget arguments.
         *
         *         @type int $number Number increment used for multiples of the same widget.
         *     }
         * }
         */
        $params = apply_filters('dynamic_sidebar_params', $params);
        $callback = $wp_registered_widgets[$id]['callback'];
        /**
         * Fires before a widget's display callback is called.
         *
         * Note: The action fires on both the front end and back end, including
         * for widgets in the Inactive Widgets sidebar on the Widgets screen.
         *
         * The action is not fired for empty sidebars.
         *
         * @since 3.0.0
         *
         * @param array $widget {
         *     An associative array of widget arguments.
         *
         *     @type string   $name        Name of the widget.
         *     @type string   $id          Widget ID.
         *     @type callable $callback    When the hook is fired on the front end, `$callback` is an array
         *                                 containing the widget object. Fired on the back end, `$callback`
         *                                 is 'wp_widget_control', see `$_callback`.
         *     @type array    $params      An associative array of multi-widget arguments.
         *     @type string   $classname   CSS class applied to the widget container.
         *     @type string   $description The widget description.
         *     @type array    $_callback   When the hook is fired on the back end, `$_callback` is populated
         *                                 with an array containing the widget object, see `$callback`.
         * }
         */
        do_action('dynamic_sidebar', $wp_registered_widgets[$id]);
        if (is_callable($callback)) {
            call_user_func_array($callback, $params);
            $did_one = true;
        }
    }
    if (!is_admin() && !empty($sidebar['after_sidebar'])) {
        echo $sidebar['after_sidebar'];
    }
    /**
     * Fires after widgets are rendered in a dynamic sidebar.
     *
     * Note: The action also fires for empty sidebars, and on both the front end
     * and back end, including the Inactive Widgets sidebar on the Widgets screen.
     *
     * @since 3.9.0
     *
     * @param int|string $index       Index, name, or ID of the dynamic sidebar.
     * @param bool       $has_widgets Whether the sidebar is populated with widgets.
     *                                Default true.
     */
    do_action('dynamic_sidebar_after', $index, true);
    /**
     * Filters whether a sidebar has widgets.
     *
     * Note: The filter is also evaluated for empty sidebars, and on both the front end
     * and back end, including the Inactive Widgets sidebar on the Widgets screen.
     *
     * @since 3.9.0
     *
     * @param bool       $did_one Whether at least one widget was rendered in the sidebar.
     *                            Default false.
     * @param int|string $index   Index, name, or ID of the dynamic sidebar.
     */
    return apply_filters('dynamic_sidebar_has_widgets', $did_one, $index);
}
/**
 * Determines whether a given widget is displayed on the front end.
 *
 * Either $callback or $id_base can be used
 * $id_base is the first argument when extending WP_Widget class
 * Without the optional $widget_id parameter, returns the ID of the first sidebar
 * in which the first instance of the widget with the given callback or $id_base is found.
 * With the $widget_id parameter, returns the ID of the sidebar where
 * the widget with that callback/$id_base AND that ID is found.
 *
 * NOTE: $widget_id and $id_base are the same for single widgets. To be effective
 * this function has to run after widgets have initialized, at action {@see 'init'} or later.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.wordpress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 2.2.0
 *
 * @global array $wp_registered_widgets
 *
 * @param callable|false $callback      Optional. Widget callback to check. Default false.
 * @param string|false   $widget_id     Optional. Widget ID. Optional, but needed for checking.
 *                                      Default false.
 * @param string|false   $id_base       Optional. The base ID of a widget created by extending WP_Widget.
 *                                      Default false.
 * @param bool           $skip_inactive Optional. Whether to check in 'wp_inactive_widgets'.
 *                                      Default true.
 * @return string|false ID of the sidebar in which the widget is active,
 *                      false if the widget is not active.
 */
function is_active_widget($callback = false, $widget_id = false, $id_base = false, $skip_inactive = true)
{
    global $wp_registered_widgets;
    $sidebars_widgets = wp_get_sidebars_widgets();
    if (is_array($sidebars_widgets)) {
        foreach ($sidebars_widgets as $sidebar => $widgets) {
            if ($skip_inactive && ('wp_inactive_widgets' === $sidebar || 'orphaned_widgets' === substr($sidebar, 0, 16))) {
                continue;
            }
            if (is_array($widgets)) {
                foreach ($widgets as $widget) {
                    if ($callback && isset($wp_registered_widgets[$widget]['callback']) && $wp_registered_widgets[$widget]['callback'] === $callback || $id_base && _get_widget_id_base($widget) === $id_base) {
                        if (!$widget_id || $widget_id === $wp_registered_widgets[$widget]['id']) {
                            return $sidebar;
                        }
                    }
                }
            }
        }
    }
    return false;
}
/**
 * Determines whether the dynamic sidebar is enabled and used by the theme.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.wordpress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 2.2.0
 *
 * @global array $wp_registered_widgets  Registered widgets.
 * @global array $wp_registered_sidebars Registered sidebars.
 *
 * @return bool True if using widgets, false otherwise.
 */
function is_dynamic_sidebar()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_dynamic_sidebar") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 796")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called is_dynamic_sidebar:796@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Determines whether a sidebar contains widgets.
 *
 * For more information on this and similar theme functions, check out
 * the {@link https://developer.wordpress.org/themes/basics/conditional-tags/
 * Conditional Tags} article in the Theme Developer Handbook.
 *
 * @since 2.8.0
 *
 * @param string|int $index Sidebar name, id or number to check.
 * @return bool True if the sidebar has widgets, false otherwise.
 */
function is_active_sidebar($index)
{
    $index = is_int($index) ? "sidebar-{$index}" : sanitize_title($index);
    $sidebars_widgets = wp_get_sidebars_widgets();
    $is_active_sidebar = !empty($sidebars_widgets[$index]);
    /**
     * Filters whether a dynamic sidebar is considered "active".
     *
     * @since 3.9.0
     *
     * @param bool       $is_active_sidebar Whether or not the sidebar should be considered "active".
     *                                      In other words, whether the sidebar contains any widgets.
     * @param int|string $index             Index, name, or ID of the dynamic sidebar.
     */
    return apply_filters('is_active_sidebar', $is_active_sidebar, $index);
}
//
// Internal Functions.
//
/**
 * Retrieve full list of sidebars and their widget instance IDs.
 *
 * Will upgrade sidebar widget list, if needed. Will also save updated list, if
 * needed.
 *
 * @since 2.2.0
 * @access private
 *
 * @global array $_wp_sidebars_widgets
 * @global array $sidebars_widgets
 *
 * @param bool $deprecated Not used (argument deprecated).
 * @return array Upgraded list of widgets to version 3 array format when called from the admin.
 */
function wp_get_sidebars_widgets($deprecated = true)
{
    if (true !== $deprecated) {
        _deprecated_argument(__FUNCTION__, '2.8.1');
    }
    global $_wp_sidebars_widgets, $sidebars_widgets;
    // If loading from front page, consult $_wp_sidebars_widgets rather than options
    // to see if wp_convert_widget_settings() has made manipulations in memory.
    if (!is_admin()) {
        if (empty($_wp_sidebars_widgets)) {
            $_wp_sidebars_widgets = get_option('sidebars_widgets', array());
        }
        $sidebars_widgets = $_wp_sidebars_widgets;
    } else {
        $sidebars_widgets = get_option('sidebars_widgets', array());
    }
    if (is_array($sidebars_widgets) && isset($sidebars_widgets['array_version'])) {
        unset($sidebars_widgets['array_version']);
    }
    /**
     * Filters the list of sidebars and their widgets.
     *
     * @since 2.7.0
     *
     * @param array $sidebars_widgets An associative array of sidebars and their widgets.
     */
    return apply_filters('sidebars_widgets', $sidebars_widgets);
}
/**
 * Set the sidebar widget option to update sidebars.
 *
 * @since 2.2.0
 * @access private
 *
 * @global array $_wp_sidebars_widgets
 * @param array $sidebars_widgets Sidebar widgets and their settings.
 */
function wp_set_sidebars_widgets($sidebars_widgets)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_set_sidebars_widgets") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 894")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_set_sidebars_widgets:894@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Retrieve default registered sidebars list.
 *
 * @since 2.2.0
 * @access private
 *
 * @global array $wp_registered_sidebars Registered sidebars.
 *
 * @return array
 */
function wp_get_widget_defaults()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_get_widget_defaults") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 914")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_get_widget_defaults:914@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Converts the widget settings from single to multi-widget format.
 *
 * @since 2.8.0
 *
 * @global array $_wp_sidebars_widgets
 *
 * @param string $base_name   Root ID for all widgets of this type.
 * @param string $option_name Option name for this widget type.
 * @param array  $settings    The array of widget instance settings.
 * @return array The array of widget settings converted to multi-widget format.
 */
function wp_convert_widget_settings($base_name, $option_name, $settings)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_convert_widget_settings") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 936")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_convert_widget_settings:936@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Output an arbitrary widget as a template tag.
 *
 * @since 2.8.0
 *
 * @global WP_Widget_Factory $wp_widget_factory
 *
 * @param string $widget   The widget's PHP class name (see class-wp-widget.php).
 * @param array  $instance Optional. The widget's instance settings. Default empty array.
 * @param array  $args {
 *     Optional. Array of arguments to configure the display of the widget.
 *
 *     @type string $before_widget HTML content that will be prepended to the widget's HTML output.
 *                                 Default `<div class="widget %s">`, where `%s` is the widget's class name.
 *     @type string $after_widget  HTML content that will be appended to the widget's HTML output.
 *                                 Default `</div>`.
 *     @type string $before_title  HTML content that will be prepended to the widget's title when displayed.
 *                                 Default `<h2 class="widgettitle">`.
 *     @type string $after_title   HTML content that will be appended to the widget's title when displayed.
 *                                 Default `</h2>`.
 * }
 */
function the_widget($widget, $instance = array(), $args = array())
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 1007")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called the_widget:1007@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Retrieves the widget ID base value.
 *
 * @since 2.8.0
 *
 * @param string $id Widget ID.
 * @return string Widget ID base.
 */
function _get_widget_id_base($id)
{
    return preg_replace('/-[0-9]+$/', '', $id);
}
/**
 * Handle sidebars config after theme change
 *
 * @access private
 * @since 3.3.0
 *
 * @global array $sidebars_widgets
 */
function _wp_sidebars_changed()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_wp_sidebars_changed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 1064")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _wp_sidebars_changed:1064@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Look for "lost" widgets, this has to run at least on each theme change.
 *
 * @since 2.8.0
 *
 * @global array $wp_registered_sidebars Registered sidebars.
 * @global array $sidebars_widgets
 * @global array $wp_registered_widgets  Registered widgets.
 *
 * @param string|bool $theme_changed Whether the theme was changed as a boolean. A value
 *                                   of 'customize' defers updates for the Customizer.
 * @return array Updated sidebars widgets.
 */
function retrieve_widgets($theme_changed = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("retrieve_widgets") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 1085")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called retrieve_widgets:1085@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Compares a list of sidebars with their widgets against an allowed list.
 *
 * @since 4.9.0
 * @since 4.9.2 Always tries to restore widget assignments from previous data, not just if sidebars needed mapping.
 *
 * @param array $existing_sidebars_widgets List of sidebars and their widget instance IDs.
 * @return array Mapped sidebars widgets.
 */
function wp_map_sidebars_widgets($existing_sidebars_widgets)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_map_sidebars_widgets") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 1131")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_map_sidebars_widgets:1131@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Compares a list of sidebars with their widgets against an allowed list.
 *
 * @since 4.9.0
 *
 * @param array $sidebars_widgets   List of sidebars and their widget instance IDs.
 * @param array $allowed_widget_ids Optional. List of widget IDs to compare against. Default: Registered widgets.
 * @return array Sidebars with allowed widgets.
 */
function _wp_remove_unregistered_widgets($sidebars_widgets, $allowed_widget_ids = array())
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_wp_remove_unregistered_widgets") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 1272")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _wp_remove_unregistered_widgets:1272@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Display the RSS entries in a list.
 *
 * @since 2.5.0
 *
 * @param string|array|object $rss  RSS url.
 * @param array               $args Widget arguments.
 */
function wp_widget_rss_output($rss, $args = array())
{
    if (is_string($rss)) {
        $rss = fetch_feed($rss);
    } elseif (is_array($rss) && isset($rss['url'])) {
        $args = $rss;
        $rss = fetch_feed($rss['url']);
    } elseif (!is_object($rss)) {
        return;
    }
    if (is_wp_error($rss)) {
        if (is_admin() || current_user_can('manage_options')) {
            echo '<p><strong>' . __('RSS Error:') . '</strong> ' . $rss->get_error_message() . '</p>';
        }
        return;
    }
    $default_args = array('show_author' => 0, 'show_date' => 0, 'show_summary' => 0, 'items' => 0);
    $args = wp_parse_args($args, $default_args);
    $items = (int) $args['items'];
    if ($items < 1 || 20 < $items) {
        $items = 10;
    }
    $show_summary = (int) $args['show_summary'];
    $show_author = (int) $args['show_author'];
    $show_date = (int) $args['show_date'];
    if (!$rss->get_item_quantity()) {
        echo '<ul><li>' . __('An error has occurred, which probably means the feed is down. Try again later.') . '</li></ul>';
        $rss->__destruct();
        unset($rss);
        return;
    }
    echo '<ul>';
    foreach ($rss->get_items(0, $items) as $item) {
        $link = $item->get_link();
        while (stristr($link, 'http') !== $link) {
            $link = substr($link, 1);
        }
        $link = esc_url(strip_tags($link));
        $title = esc_html(trim(strip_tags($item->get_title())));
        if (empty($title)) {
            $title = __('Untitled');
        }
        $desc = html_entity_decode($item->get_description(), ENT_QUOTES, get_option('blog_charset'));
        $desc = esc_attr(wp_trim_words($desc, 55, ' [&hellip;]'));
        $summary = '';
        if ($show_summary) {
            $summary = $desc;
            // Change existing [...] to [&hellip;].
            if ('[...]' === substr($summary, -5)) {
                $summary = substr($summary, 0, -5) . '[&hellip;]';
            }
            $summary = '<div class="rssSummary">' . esc_html($summary) . '</div>';
        }
        $date = '';
        if ($show_date) {
            $date = $item->get_date('U');
            if ($date) {
                $date = ' <span class="rss-date">' . date_i18n(get_option('date_format'), $date) . '</span>';
            }
        }
        $author = '';
        if ($show_author) {
            $author = $item->get_author();
            if (is_object($author)) {
                $author = $author->get_name();
                $author = ' <cite>' . esc_html(strip_tags($author)) . '</cite>';
            }
        }
        if ('' === $link) {
            echo "<li>{$title}{$date}{$summary}{$author}</li>";
        } elseif ($show_summary) {
            echo "<li><a class='rsswidget' href='{$link}'>{$title}</a>{$date}{$summary}{$author}</li>";
        } else {
            echo "<li><a class='rsswidget' href='{$link}'>{$title}</a>{$date}{$author}</li>";
        }
    }
    echo '</ul>';
    $rss->__destruct();
    unset($rss);
}
/**
 * Display RSS widget options form.
 *
 * The options for what fields are displayed for the RSS form are all booleans
 * and are as follows: 'url', 'title', 'items', 'show_summary', 'show_author',
 * 'show_date'.
 *
 * @since 2.5.0
 *
 * @param array|string $args   Values for input fields.
 * @param array        $inputs Override default display options.
 */
function wp_widget_rss_form($args, $inputs = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_widget_rss_form") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 1384")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_widget_rss_form:1384@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Process RSS feed widget data and optionally retrieve feed items.
 *
 * The feed widget can not have more than 20 items or it will reset back to the
 * default, which is 10.
 *
 * The resulting array has the feed title, feed url, feed link (from channel),
 * feed items, error (if any), and whether to show summary, author, and date.
 * All respectively in the order of the array elements.
 *
 * @since 2.5.0
 *
 * @param array $widget_rss RSS widget feed data. Expects unescaped data.
 * @param bool  $check_feed Optional. Whether to check feed for errors. Default true.
 * @return array
 */
function wp_widget_rss_process($widget_rss, $check_feed = true)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_widget_rss_process") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php at line 1545")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called wp_widget_rss_process:1545@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets.php');
    die();
}
/**
 * Registers all of the default WordPress widgets on startup.
 *
 * Calls {@see 'widgets_init'} action after all of the WordPress widgets have been registered.
 *
 * @since 2.2.0
 */
function wp_widgets_init()
{
    if (!is_blog_installed()) {
        return;
    }
    register_widget('WP_Widget_Pages');
    register_widget('WP_Widget_Calendar');
    register_widget('WP_Widget_Archives');
    if (get_option('link_manager_enabled')) {
        register_widget('WP_Widget_Links');
    }
    register_widget('WP_Widget_Media_Audio');
    register_widget('WP_Widget_Media_Image');
    register_widget('WP_Widget_Media_Gallery');
    register_widget('WP_Widget_Media_Video');
    register_widget('WP_Widget_Meta');
    register_widget('WP_Widget_Search');
    register_widget('WP_Widget_Text');
    register_widget('WP_Widget_Categories');
    register_widget('WP_Widget_Recent_Posts');
    register_widget('WP_Widget_Recent_Comments');
    register_widget('WP_Widget_RSS');
    register_widget('WP_Widget_Tag_Cloud');
    register_widget('WP_Nav_Menu_Widget');
    register_widget('WP_Widget_Custom_HTML');
    /**
     * Fires after all default WordPress widgets have been registered.
     *
     * @since 2.2.0
     */
    do_action('widgets_init');
}