<?php

/**
 * Customize API: WP_Customize_Media_Control class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */
/**
 * Customize Media Control class.
 *
 * @since 4.2.0
 *
 * @see WP_Customize_Control
 */
class WP_Customize_Media_Control extends WP_Customize_Control
{
    /**
     * Control type.
     *
     * @since 4.2.0
     * @var string
     */
    public $type = 'media';
    /**
     * Media control mime type.
     *
     * @since 4.2.0
     * @var string
     */
    public $mime_type = '';
    /**
     * Button labels.
     *
     * @since 4.2.0
     * @var array
     */
    public $button_labels = array();
    /**
     * Constructor.
     *
     * @since 4.1.0
     * @since 4.2.0 Moved from WP_Customize_Upload_Control.
     *
     * @see WP_Customize_Control::__construct()
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     *                                      See WP_Customize_Control::__construct() for information
     *                                      on accepted arguments. Default empty array.
     */
    public function __construct($manager, $id, $args = array())
    {
        parent::__construct($manager, $id, $args);
        $this->button_labels = wp_parse_args($this->button_labels, $this->get_default_button_labels());
    }
    /**
     * Enqueue control related scripts/styles.
     *
     * @since 3.4.0
     * @since 4.2.0 Moved from WP_Customize_Upload_Control.
     */
    public function enqueue()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/customize/class-wp-customize-media-control.php at line 67")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue:67@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/customize/class-wp-customize-media-control.php');
        die();
    }
    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @since 3.4.0
     * @since 4.2.0 Moved from WP_Customize_Upload_Control.
     *
     * @see WP_Customize_Control::to_json()
     */
    public function to_json()
    {
        parent::to_json();
        $this->json['label'] = html_entity_decode($this->label, ENT_QUOTES, get_bloginfo('charset'));
        $this->json['mime_type'] = $this->mime_type;
        $this->json['button_labels'] = $this->button_labels;
        $this->json['canUpload'] = current_user_can('upload_files');
        $value = $this->value();
        if (is_object($this->setting)) {
            if ($this->setting->default) {
                // Fake an attachment model - needs all fields used by template.
                // Note that the default value must be a URL, NOT an attachment ID.
                $ext = substr($this->setting->default, -3);
                $type = in_array($ext, array('jpg', 'png', 'gif', 'bmp'), true) ? 'image' : 'document';
                $default_attachment = array('id' => 1, 'url' => $this->setting->default, 'type' => $type, 'icon' => wp_mime_type_icon($type), 'title' => wp_basename($this->setting->default));
                if ('image' === $type) {
                    $default_attachment['sizes'] = array('full' => array('url' => $this->setting->default));
                }
                $this->json['defaultAttachment'] = $default_attachment;
            }
            if ($value && $this->setting->default && $value === $this->setting->default) {
                // Set the default as the attachment.
                $this->json['attachment'] = $this->json['defaultAttachment'];
            } elseif ($value) {
                $this->json['attachment'] = wp_prepare_attachment_for_js($value);
            }
        }
    }
    /**
     * Don't render any content for this control from PHP.
     *
     * @since 3.4.0
     * @since 4.2.0 Moved from WP_Customize_Upload_Control.
     *
     * @see WP_Customize_Media_Control::content_template()
     */
    public function render_content()
    {
    }
    /**
     * Render a JS template for the content of the media control.
     *
     * @since 4.1.0
     * @since 4.2.0 Moved from WP_Customize_Upload_Control.
     */
    public function content_template()
    {
        ?>
		<#
		var descriptionId = _.uniqueId( 'customize-media-control-description-' );
		var describedByAttr = data.description ? ' aria-describedby="' + descriptionId + '" ' : '';
		#>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<div class="customize-control-notifications-container"></div>
		<# if ( data.description ) { #>
			<span id="{{ descriptionId }}" class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<# if ( data.attachment && data.attachment.id ) { #>
			<div class="attachment-media-view attachment-media-view-{{ data.attachment.type }} {{ data.attachment.orientation }}">
				<div class="thumbnail thumbnail-{{ data.attachment.type }}">
					<# if ( 'image' === data.attachment.type && data.attachment.sizes && data.attachment.sizes.medium ) { #>
						<img class="attachment-thumb" src="{{ data.attachment.sizes.medium.url }}" draggable="false" alt="" />
					<# } else if ( 'image' === data.attachment.type && data.attachment.sizes && data.attachment.sizes.full ) { #>
						<img class="attachment-thumb" src="{{ data.attachment.sizes.full.url }}" draggable="false" alt="" />
					<# } else if ( 'audio' === data.attachment.type ) { #>
						<# if ( data.attachment.image && data.attachment.image.src && data.attachment.image.src !== data.attachment.icon ) { #>
							<img src="{{ data.attachment.image.src }}" class="thumbnail" draggable="false" alt="" />
						<# } else { #>
							<img src="{{ data.attachment.icon }}" class="attachment-thumb type-icon" draggable="false" alt="" />
						<# } #>
						<p class="attachment-meta attachment-meta-title">&#8220;{{ data.attachment.title }}&#8221;</p>
						<# if ( data.attachment.album || data.attachment.meta.album ) { #>
						<p class="attachment-meta"><em>{{ data.attachment.album || data.attachment.meta.album }}</em></p>
						<# } #>
						<# if ( data.attachment.artist || data.attachment.meta.artist ) { #>
						<p class="attachment-meta">{{ data.attachment.artist || data.attachment.meta.artist }}</p>
						<# } #>
						<audio style="visibility: hidden" controls class="wp-audio-shortcode" width="100%" preload="none">
							<source type="{{ data.attachment.mime }}" src="{{ data.attachment.url }}" />
						</audio>
					<# } else if ( 'video' === data.attachment.type ) { #>
						<div class="wp-media-wrapper wp-video">
							<video controls="controls" class="wp-video-shortcode" preload="metadata"
								<# if ( data.attachment.image && data.attachment.image.src !== data.attachment.icon ) { #>poster="{{ data.attachment.image.src }}"<# } #>>
								<source type="{{ data.attachment.mime }}" src="{{ data.attachment.url }}" />
							</video>
						</div>
					<# } else { #>
						<img class="attachment-thumb type-icon icon" src="{{ data.attachment.icon }}" draggable="false" alt="" />
						<p class="attachment-title">{{ data.attachment.title }}</p>
					<# } #>
				</div>
				<div class="actions">
					<# if ( data.canUpload ) { #>
					<button type="button" class="button remove-button">{{ data.button_labels.remove }}</button>
					<button type="button" class="button upload-button control-focus" {{{ describedByAttr }}}>{{ data.button_labels.change }}</button>
					<# } #>
				</div>
			</div>
		<# } else { #>
			<div class="attachment-media-view">
				<# if ( data.canUpload ) { #>
					<button type="button" class="upload-button button-add-media" {{{ describedByAttr }}}>{{ data.button_labels.select }}</button>
				<# } #>
				<div class="actions">
					<# if ( data.defaultAttachment ) { #>
						<button type="button" class="button default-button">{{ data.button_labels['default'] }}</button>
					<# } #>
				</div>
			</div>
		<# } #>
		<?php 
    }
    /**
     * Get default button labels.
     *
     * Provides an array of the default button labels based on the mime type of the current control.
     *
     * @since 4.9.0
     *
     * @return string[] An associative array of default button labels keyed by the button name.
     */
    public function get_default_button_labels()
    {
        // Get just the mime type and strip the mime subtype if present.
        $mime_type = !empty($this->mime_type) ? strtok(ltrim($this->mime_type, '/'), '/') : 'default';
        switch ($mime_type) {
            case 'video':
                return array('select' => __('Select video'), 'change' => __('Change video'), 'default' => __('Default'), 'remove' => __('Remove'), 'placeholder' => __('No video selected'), 'frame_title' => __('Select video'), 'frame_button' => __('Choose video'));
            case 'audio':
                return array('select' => __('Select audio'), 'change' => __('Change audio'), 'default' => __('Default'), 'remove' => __('Remove'), 'placeholder' => __('No audio selected'), 'frame_title' => __('Select audio'), 'frame_button' => __('Choose audio'));
            case 'image':
                return array('select' => __('Select image'), 'site_icon' => __('Select site icon'), 'change' => __('Change image'), 'default' => __('Default'), 'remove' => __('Remove'), 'placeholder' => __('No image selected'), 'frame_title' => __('Select image'), 'frame_button' => __('Choose image'));
            default:
                return array('select' => __('Select file'), 'change' => __('Change file'), 'default' => __('Default'), 'remove' => __('Remove'), 'placeholder' => __('No file selected'), 'frame_title' => __('Select file'), 'frame_button' => __('Choose file'));
        }
        // End switch().
    }
}