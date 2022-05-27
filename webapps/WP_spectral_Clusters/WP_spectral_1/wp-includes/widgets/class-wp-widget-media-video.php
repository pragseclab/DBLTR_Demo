<?php

/**
 * Widget API: WP_Widget_Media_Video class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.8.0
 */
/**
 * Core class that implements a video widget.
 *
 * @since 4.8.0
 *
 * @see WP_Widget_Media
 * @see WP_Widget
 */
class WP_Widget_Media_Video extends WP_Widget_Media
{
    /**
     * Constructor.
     *
     * @since 4.8.0
     */
    public function __construct()
    {
        parent::__construct('media_video', __('Video'), array('description' => __('Displays a video from the media library or from YouTube, Vimeo, or another provider.'), 'mime_type' => 'video'));
        $this->l10n = array_merge($this->l10n, array(
            'no_media_selected' => __('No video selected'),
            'add_media' => _x('Add Video', 'label for button in the video widget'),
            'replace_media' => _x('Replace Video', 'label for button in the video widget; should preferably not be longer than ~13 characters long'),
            'edit_media' => _x('Edit Video', 'label for button in the video widget; should preferably not be longer than ~13 characters long'),
            'missing_attachment' => sprintf(
                /* translators: %s: URL to media library. */
                __('We can&#8217;t find that video. Check your <a href="%s">media library</a> and make sure it wasn&#8217;t deleted.'),
                esc_url(admin_url('upload.php'))
            ),
            /* translators: %d: Widget count. */
            'media_library_state_multi' => _n_noop('Video Widget (%d)', 'Video Widget (%d)'),
            'media_library_state_single' => __('Video Widget'),
            /* translators: %s: A list of valid video file extensions. */
            'unsupported_file_type' => sprintf(__('Sorry, we can&#8217;t load the video at the supplied URL. Please check that the URL is for a supported video file (%s) or stream (e.g. YouTube and Vimeo).'), '<code>.' . implode('</code>, <code>.', wp_get_video_extensions()) . '</code>'),
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_instance_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-media-video.php at line 58")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_instance_schema:58@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-media-video.php');
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
        $src = $instance['url'];
        if ($attachment) {
            $src = wp_get_attachment_url($attachment->ID);
        }
        if (empty($src)) {
            return;
        }
        $youtube_pattern = '#^https?://(?:www\\.)?(?:youtube\\.com/watch|youtu\\.be/)#';
        $vimeo_pattern = '#^https?://(.+\\.)?vimeo\\.com/.*#';
        if ($attachment || preg_match($youtube_pattern, $src) || preg_match($vimeo_pattern, $src)) {
            add_filter('wp_video_shortcode', array($this, 'inject_video_max_width_style'));
            echo wp_video_shortcode(array_merge($instance, compact('src')), $instance['content']);
            remove_filter('wp_video_shortcode', array($this, 'inject_video_max_width_style'));
        } else {
            echo $this->inject_video_max_width_style(wp_oembed_get($src));
        }
    }
    /**
     * Inject max-width and remove height for videos too constrained to fit inside sidebars on frontend.
     *
     * @since 4.8.0
     *
     * @param string $html Video shortcode HTML output.
     * @return string HTML Output.
     */
    public function inject_video_max_width_style($html)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("inject_video_max_width_style") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-media-video.php at line 111")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called inject_video_max_width_style:111@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-media-video.php');
        die();
    }
    /**
     * Enqueue preview scripts.
     *
     * These scripts normally are enqueued just-in-time when a video shortcode is used.
     * In the customizer, however, widgets can be dynamically added and rendered via
     * selective refresh, and so it is important to unconditionally enqueue them in
     * case a widget does get added.
     *
     * @since 4.8.0
     */
    public function enqueue_preview_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue_preview_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-media-video.php at line 129")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue_preview_scripts:129@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-media-video.php');
        die();
    }
    /**
     * Loads the required scripts and styles for the widget control.
     *
     * @since 4.8.0
     */
    public function enqueue_admin_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue_admin_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-media-video.php at line 142")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue_admin_scripts:142@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-media-video.php');
        die();
    }
    /**
     * Render form template scripts.
     *
     * @since 4.8.0
     */
    public function render_control_template_scripts()
    {
        parent::render_control_template_scripts();
        ?>
		<script type="text/html" id="tmpl-wp-media-widget-video-preview">
			<# if ( data.error && 'missing_attachment' === data.error ) { #>
				<div class="notice notice-error notice-alt notice-missing-attachment">
					<p><?php 
        echo $this->l10n['missing_attachment'];
        ?></p>
				</div>
			<# } else if ( data.error && 'unsupported_file_type' === data.error ) { #>
				<div class="notice notice-error notice-alt notice-missing-attachment">
					<p><?php 
        echo $this->l10n['unsupported_file_type'];
        ?></p>
				</div>
			<# } else if ( data.error ) { #>
				<div class="notice notice-error notice-alt">
					<p><?php 
        _e('Unable to preview media due to an unknown error.');
        ?></p>
				</div>
			<# } else if ( data.is_oembed && data.model.poster ) { #>
				<a href="{{ data.model.src }}" target="_blank" class="media-widget-video-link">
					<img src="{{ data.model.poster }}" />
				</a>
			<# } else if ( data.is_oembed ) { #>
				<a href="{{ data.model.src }}" target="_blank" class="media-widget-video-link no-poster">
					<span class="dashicons dashicons-format-video"></span>
				</a>
			<# } else if ( data.model.src ) { #>
				<?php 
        wp_underscore_video_template();
        ?>
			<# } #>
		</script>
		<?php 
    }
}