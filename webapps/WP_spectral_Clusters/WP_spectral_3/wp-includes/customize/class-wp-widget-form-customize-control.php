<?php

/**
 * Customize API: WP_Widget_Form_Customize_Control class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */
/**
 * Widget Form Customize Control class.
 *
 * @since 3.9.0
 *
 * @see WP_Customize_Control
 */
class WP_Widget_Form_Customize_Control extends WP_Customize_Control
{
    /**
     * Customize control type.
     *
     * @since 3.9.0
     * @var string
     */
    public $type = 'widget_form';
    /**
     * Widget ID.
     *
     * @since 3.9.0
     * @var string
     */
    public $widget_id;
    /**
     * Widget ID base.
     *
     * @since 3.9.0
     * @var string
     */
    public $widget_id_base;
    /**
     * Sidebar ID.
     *
     * @since 3.9.0
     * @var string
     */
    public $sidebar_id;
    /**
     * Widget status.
     *
     * @since 3.9.0
     * @var bool True if new, false otherwise. Default false.
     */
    public $is_new = false;
    /**
     * Widget width.
     *
     * @since 3.9.0
     * @var int
     */
    public $width;
    /**
     * Widget height.
     *
     * @since 3.9.0
     * @var int
     */
    public $height;
    /**
     * Widget mode.
     *
     * @since 3.9.0
     * @var bool True if wide, false otherwise. Default false.
     */
    public $is_wide = false;
    /**
     * Gather control params for exporting to JavaScript.
     *
     * @since 3.9.0
     *
     * @global array $wp_registered_widgets
     */
    public function to_json()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("to_json") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-widget-form-customize-control.php at line 84")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called to_json:84@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-widget-form-customize-control.php');
        die();
    }
    /**
     * Override render_content to be no-op since content is exported via to_json for deferred embedding.
     *
     * @since 3.9.0
     */
    public function render_content()
    {
    }
    /**
     * Whether the current widget is rendered on the page.
     *
     * @since 4.0.0
     *
     * @return bool Whether the widget is rendered.
     */
    public function active_callback()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("active_callback") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-widget-form-customize-control.php at line 119")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called active_callback:119@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-widget-form-customize-control.php');
        die();
    }
}