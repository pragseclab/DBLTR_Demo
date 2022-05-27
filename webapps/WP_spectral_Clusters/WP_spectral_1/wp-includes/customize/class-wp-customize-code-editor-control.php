<?php

/**
 * Customize API: WP_Customize_Code_Editor_Control class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.9.0
 */
/**
 * Customize Code Editor Control class.
 *
 * @since 4.9.0
 *
 * @see WP_Customize_Control
 */
class WP_Customize_Code_Editor_Control extends WP_Customize_Control
{
    /**
     * Customize control type.
     *
     * @since 4.9.0
     * @var string
     */
    public $type = 'code_editor';
    /**
     * Type of code that is being edited.
     *
     * @since 4.9.0
     * @var string
     */
    public $code_type = '';
    /**
     * Code editor settings.
     *
     * @see wp_enqueue_code_editor()
     * @since 4.9.0
     * @var array|false
     */
    public $editor_settings = array();
    /**
     * Enqueue control related scripts/styles.
     *
     * @since 4.9.0
     */
    public function enqueue()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/customize/class-wp-customize-code-editor-control.php at line 48")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue:48@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/customize/class-wp-customize-code-editor-control.php');
        die();
    }
    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @since 4.9.0
     *
     * @see WP_Customize_Control::json()
     *
     * @return array Array of parameters passed to the JavaScript.
     */
    public function json()
    {
        $json = parent::json();
        $json['editor_settings'] = $this->editor_settings;
        $json['input_attrs'] = $this->input_attrs;
        return $json;
    }
    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     *
     * @since 4.9.0
     */
    public function render_content()
    {
    }
    /**
     * Render a JS template for control display.
     *
     * @since 4.9.0
     */
    public function content_template()
    {
        ?>
		<# var elementIdPrefix = 'el' + String( Math.random() ); #>
		<# if ( data.label ) { #>
			<label for="{{ elementIdPrefix }}_editor" class="customize-control-title">
				{{ data.label }}
			</label>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-notifications-container"></div>
		<textarea id="{{ elementIdPrefix }}_editor"
			<# _.each( _.extend( { 'class': 'code' }, data.input_attrs ), function( value, key ) { #>
				{{{ key }}}="{{ value }}"
			<# }); #>
			></textarea>
		<?php 
    }
}