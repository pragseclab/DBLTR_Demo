<?php

/**
 * Widget API: WP_Widget_Media_Image class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.8.0
 */
/**
 * Core class that implements an image widget.
 *
 * @since 4.8.0
 *
 * @see WP_Widget_Media
 * @see WP_Widget
 */
class WP_Widget_Media_Image extends WP_Widget_Media
{
    /**
     * Constructor.
     *
     * @since 4.8.0
     */
    public function __construct()
    {
        parent::__construct('media_image', __('Image'), array('description' => __('Displays an image.'), 'mime_type' => 'image'));
        $this->l10n = array_merge($this->l10n, array(
            'no_media_selected' => __('No image selected'),
            'add_media' => _x('Add Image', 'label for button in the image widget'),
            'replace_media' => _x('Replace Image', 'label for button in the image widget; should preferably not be longer than ~13 characters long'),
            'edit_media' => _x('Edit Image', 'label for button in the image widget; should preferably not be longer than ~13 characters long'),
            'missing_attachment' => sprintf(
                /* translators: %s: URL to media library. */
                __('We can&#8217;t find that image. Check your <a href="%s">media library</a> and make sure it wasn&#8217;t deleted.'),
                esc_url(admin_url('upload.php'))
            ),
            /* translators: %d: Widget count. */
            'media_library_state_multi' => _n_noop('Image Widget (%d)', 'Image Widget (%d)'),
            'media_library_state_single' => __('Image Widget'),
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_instance_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-image.php at line 56")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_instance_schema:56@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-image.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("render_media") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-image.php at line 79")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called render_media:79@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-media-image.php');
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
        $handle = 'media-image-widget';
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
        parent::render_control_template_scripts();
        ?>
		<script type="text/html" id="tmpl-wp-media-widget-image-fields">
			<# var elementIdPrefix = 'el' + String( Math.random() ) + '_'; #>
			<# if ( data.url ) { #>
			<p class="media-widget-image-link">
				<label for="{{ elementIdPrefix }}linkUrl"><?php 
        esc_html_e('Link to:');
        ?></label>
				<input id="{{ elementIdPrefix }}linkUrl" type="text" class="widefat link" value="{{ data.link_url }}" placeholder="https://" pattern="((\w+:)?\/\/\w.*|\w+:(?!\/\/$)|\/|\?|#).*">
			</p>
			<# } #>
		</script>
		<script type="text/html" id="tmpl-wp-media-widget-image-preview">
			<# if ( data.error && 'missing_attachment' === data.error ) { #>
				<div class="notice notice-error notice-alt notice-missing-attachment">
					<p><?php 
        echo $this->l10n['missing_attachment'];
        ?></p>
				</div>
			<# } else if ( data.error ) { #>
				<div class="notice notice-error notice-alt">
					<p><?php 
        _e('Unable to preview media due to an unknown error.');
        ?></p>
				</div>
			<# } else if ( data.url ) { #>
				<img class="attachment-thumb" src="{{ data.url }}" draggable="false" alt="{{ data.alt }}"
					<# if ( ! data.alt && data.currentFilename ) { #>
						aria-label="
						<?php 
        echo esc_attr(sprintf(
            /* translators: %s: The image file name. */
            __('The current image has no alternative text. The file name is: %s'),
            '{{ data.currentFilename }}'
        ));
        ?>
						"
					<# } #>
				/>
			<# } #>
		</script>
		<?php 
    }
}