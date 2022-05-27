<?php

/**
 * Widget API: WP_Widget_Factory class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Singleton that registers and instantiates WP_Widget classes.
 *
 * @since 2.8.0
 * @since 4.4.0 Moved to its own file from wp-includes/widgets.php
 */
class WP_Widget_Factory
{
    /**
     * Widgets array.
     *
     * @since 2.8.0
     * @var array
     */
    public $widgets = array();
    /**
     * PHP5 constructor.
     *
     * @since 4.3.0
     */
    public function __construct()
    {
        add_action('widgets_init', array($this, '_register_widgets'), 100);
    }
    /**
     * PHP4 constructor.
     *
     * @since 2.8.0
     * @deprecated 4.3.0 Use __construct() instead.
     *
     * @see WP_Widget_Factory::__construct()
     */
    public function WP_Widget_Factory()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("WP_Widget_Factory") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-widget-factory.php at line 44")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called WP_Widget_Factory:44@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-widget-factory.php');
        die();
    }
    /**
     * Registers a widget subclass.
     *
     * @since 2.8.0
     * @since 4.6.0 Updated the `$widget` parameter to also accept a WP_Widget instance object
     *              instead of simply a `WP_Widget` subclass name.
     *
     * @param string|WP_Widget $widget Either the name of a `WP_Widget` subclass or an instance of a `WP_Widget` subclass.
     */
    public function register($widget)
    {
        if ($widget instanceof WP_Widget) {
            $this->widgets[spl_object_hash($widget)] = $widget;
        } else {
            $this->widgets[$widget] = new $widget();
        }
    }
    /**
     * Un-registers a widget subclass.
     *
     * @since 2.8.0
     * @since 4.6.0 Updated the `$widget` parameter to also accept a WP_Widget instance object
     *              instead of simply a `WP_Widget` subclass name.
     *
     * @param string|WP_Widget $widget Either the name of a `WP_Widget` subclass or an instance of a `WP_Widget` subclass.
     */
    public function unregister($widget)
    {
        if ($widget instanceof WP_Widget) {
            unset($this->widgets[spl_object_hash($widget)]);
        } else {
            unset($this->widgets[$widget]);
        }
    }
    /**
     * Serves as a utility method for adding widgets to the registered widgets global.
     *
     * @since 2.8.0
     *
     * @global array $wp_registered_widgets
     */
    public function _register_widgets()
    {
        global $wp_registered_widgets;
        $keys = array_keys($this->widgets);
        $registered = array_keys($wp_registered_widgets);
        $registered = array_map('_get_widget_id_base', $registered);
        foreach ($keys as $key) {
            // Don't register new widget if old widget with the same id is already registered.
            if (in_array($this->widgets[$key]->id_base, $registered, true)) {
                unset($this->widgets[$key]);
                continue;
            }
            $this->widgets[$key]->_register();
        }
    }
}