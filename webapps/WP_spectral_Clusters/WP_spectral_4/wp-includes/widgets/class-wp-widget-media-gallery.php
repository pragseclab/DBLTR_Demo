<?php

/**
 * Widget API: WP_Widget_Media_Gallery class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.9.0
 */
/**
 * Core class that implements a gallery widget.
 *
 * @since 4.9.0
 *
 * @see WP_Widget_Media
 * @see WP_Widget
 */
class WP_Widget_Media_Gallery extends WP_Widget_Media
{
    /**
     * Constructor.
     *
     * @since 4.9.0
     */
    public function __construct()
    {
        parent::__construct('media_gallery', __('Gallery'), array('description' => __('Displays an image gallery.'), 'mime_type' => 'image'));
        $this->l10n = array_merge($this->l10n, array('no_media_selected' => __('No images selected'), 'add_media' => _x('Add Images', 'label for button in the gallery widget; should not be longer than ~13 characters long'), 'replace_media' => '', 'edit_media' => _x('Edit Gallery', 'label for button in the gallery widget; should not be longer than ~13 characters long')));
    }
    /**
     * Get schema for properties of a widget instance (item).
     *
     * @since 4.9.0
     *
     * @see WP_REST_Controller::get_item_schema()
     * @see WP_REST_Controller::get_additional_fields()
     * @link https://core.trac.wordpress.org/ticket/35574
     *
     * @return array Schema for properties.
     */
    public function get_instance_schema()
    {
        $schema = array('title' => array('type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'description' => __('Title for the widget'), 'should_preview_update' => false), 'ids' => array('type' => 'array', 'items' => array('type' => 'integer'), 'default' => array(), 'sanitize_callback' => 'wp_parse_id_list'), 'columns' => array('type' => 'integer', 'default' => 3, 'minimum' => 1, 'maximum' => 9), 'size' => array('type' => 'string', 'enum' => array_merge(get_intermediate_image_sizes(), array('full', 'custom')), 'default' => 'thumbnail'), 'link_type' => array('type' => 'string', 'enum' => array('post', 'file', 'none'), 'default' => 'post', 'media_prop' => 'link', 'should_preview_update' => false), 'orderby_random' => array('type' => 'boolean', 'default' => false, 'media_prop' => '_orderbyRandom', 'should_preview_update' => false));
        /** This filter is documented in wp-includes/widgets/class-wp-widget-media.php */
        $schema = apply_filters("widget_{$this->id_base}_instance_schema", $schema, $this);
        return $schema;
    }
    /**
     * Render the media on the frontend.
     *
     * @since 4.9.0
     *
     * @param array $instance Widget instance props.
     */
    public function render_media($instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("render_media") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-gallery.php at line 57")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called render_media:57@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-gallery.php');
        die();
    }
    /**
     * Loads the required media files for the media manager and scripts for media widgets.
     *
     * @since 4.9.0
     */
    public function enqueue_admin_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue_admin_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-gallery.php at line 73")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue_admin_scripts:73@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-gallery.php');
        die();
    }
    /**
     * Render form template scripts.
     *
     * @since 4.9.0
     */
    public function render_control_template_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("render_control_template_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-gallery.php at line 93")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called render_control_template_scripts:93@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-gallery.php');
        die();
    }
    /**
     * Whether the widget has content to show.
     *
     * @since 4.9.0
     * @access protected
     *
     * @param array $instance Widget instance props.
     * @return bool Whether widget has content.
     */
    protected function has_content($instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("has_content") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-gallery.php at line 166")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called has_content:166@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-gallery.php');
        die();
    }
}