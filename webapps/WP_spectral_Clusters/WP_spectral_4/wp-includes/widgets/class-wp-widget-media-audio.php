<?php

/**
 * Widget API: WP_Widget_Media_Audio class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.8.0
 */
/**
 * Core class that implements an audio widget.
 *
 * @since 4.8.0
 *
 * @see WP_Widget_Media
 * @see WP_Widget
 */
class WP_Widget_Media_Audio extends WP_Widget_Media
{
    /**
     * Constructor.
     *
     * @since 4.8.0
     */
    public function __construct()
    {
        parent::__construct('media_audio', __('Audio'), array('description' => __('Displays an audio player.'), 'mime_type' => 'audio'));
        $this->l10n = array_merge($this->l10n, array(
            'no_media_selected' => __('No audio selected'),
            'add_media' => _x('Add Audio', 'label for button in the audio widget'),
            'replace_media' => _x('Replace Audio', 'label for button in the audio widget; should preferably not be longer than ~13 characters long'),
            'edit_media' => _x('Edit Audio', 'label for button in the audio widget; should preferably not be longer than ~13 characters long'),
            'missing_attachment' => sprintf(
                /* translators: %s: URL to media library. */
                __('We can&#8217;t find that audio file. Check your <a href="%s">media library</a> and make sure it wasn&#8217;t deleted.'),
                esc_url(admin_url('upload.php'))
            ),
            /* translators: %d: Widget count. */
            'media_library_state_multi' => _n_noop('Audio Widget (%d)', 'Audio Widget (%d)'),
            'media_library_state_single' => __('Audio Widget'),
            'unsupported_file_type' => __('Looks like this isn&#8217;t the correct kind of file. Please link to an audio file instead.'),
        ));
    }
    /**
     * Get schema for properties of a widget instance (item).
     *
     * @since 4.8.0
     *
     * @see WP_REST_Controller::get_item_schema()
     * @see WP_REST_Controller::get_additional_fields()
     * @link https://core.trac.wordpress.org/ticket/35574
     *
     * @return array Schema for properties.
     */
    public function get_instance_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_instance_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-audio.php at line 57")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_instance_schema:57@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-audio.php');
        die();
    }
    /**
     * Render the media on the frontend.
     *
     * @since 4.8.0
     *
     * @param array $instance Widget instance props.
     */
    public function render_media($instance)
    {
        $instance = array_merge(wp_list_pluck($this->get_instance_schema(), 'default'), $instance);
        $attachment = null;
        if ($this->is_attachment_with_mime_type($instance['attachment_id'], $this->widget_options['mime_type'])) {
            $attachment = get_post($instance['attachment_id']);
        }
        if ($attachment) {
            $src = wp_get_attachment_url($attachment->ID);
        } else {
            $src = $instance['url'];
        }
        echo wp_audio_shortcode(array_merge($instance, compact('src')));
    }
    /**
     * Enqueue preview scripts.
     *
     * These scripts normally are enqueued just-in-time when an audio shortcode is used.
     * In the customizer, however, widgets can be dynamically added and rendered via
     * selective refresh, and so it is important to unconditionally enqueue them in
     * case a widget does get added.
     *
     * @since 4.8.0
     */
    public function enqueue_preview_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue_preview_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-audio.php at line 103")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue_preview_scripts:103@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-audio.php');
        die();
    }
    /**
     * Loads the required media files for the media manager and scripts for media widgets.
     *
     * @since 4.8.0
     */
    public function enqueue_admin_scripts()
    {
        parent::enqueue_admin_scripts();
        wp_enqueue_style('wp-mediaelement');
        wp_enqueue_script('wp-mediaelement');
        $handle = 'media-audio-widget';
        wp_enqueue_script($handle);
        $exported_schema = array();
        foreach ($this->get_instance_schema() as $field => $field_schema) {
            $exported_schema[$field] = wp_array_slice_assoc($field_schema, array('type', 'default', 'enum', 'minimum', 'format', 'media_prop', 'should_preview_update'));
        }
        wp_add_inline_script($handle, sprintf('wp.mediaWidgets.modelConstructors[ %s ].prototype.schema = %s;', wp_json_encode($this->id_base), wp_json_encode($exported_schema)));
        wp_add_inline_script($handle, sprintf('
					wp.mediaWidgets.controlConstructors[ %1$s ].prototype.mime_type = %2$s;
					wp.mediaWidgets.controlConstructors[ %1$s ].prototype.l10n = _.extend( {}, wp.mediaWidgets.controlConstructors[ %1$s ].prototype.l10n, %3$s );
				', wp_json_encode($this->id_base), wp_json_encode($this->widget_options['mime_type']), wp_json_encode($this->l10n)));
    }
    /**
     * Render form template scripts.
     *
     * @since 4.8.0
     */
    public function render_control_template_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("render_control_template_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-audio.php at line 137")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called render_control_template_scripts:137@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-audio.php');
        die();
    }
}