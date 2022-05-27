<?php

/**
 * Customize API: WP_Widget_Area_Customize_Control class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */
/**
 * Widget Area Customize Control class.
 *
 * @since 3.9.0
 *
 * @see WP_Customize_Control
 */
class WP_Widget_Area_Customize_Control extends WP_Customize_Control
{
    /**
     * Customize control type.
     *
     * @since 3.9.0
     * @var string
     */
    public $type = 'sidebar_widgets';
    /**
     * Sidebar ID.
     *
     * @since 3.9.0
     * @var int|string
     */
    public $sidebar_id;
    /**
     * Refreshes the parameters passed to the JavaScript via JSON.
     *
     * @since 3.9.0
     */
    public function to_json()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("to_json") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/customize/class-wp-widget-area-customize-control.php at line 40")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called to_json:40@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/customize/class-wp-widget-area-customize-control.php');
        die();
    }
    /**
     * Renders the control's content.
     *
     * @since 3.9.0
     */
    public function render_content()
    {
        $id = 'reorder-widgets-desc-' . str_replace(array('[', ']'), array('-', ''), $this->id);
        ?>
		<button type="button" class="button add-new-widget" aria-expanded="false" aria-controls="available-widgets">
			<?php 
        _e('Add a Widget');
        ?>
		</button>
		<button type="button" class="button-link reorder-toggle" aria-label="<?php 
        esc_attr_e('Reorder widgets');
        ?>" aria-describedby="<?php 
        echo esc_attr($id);
        ?>">
			<span class="reorder"><?php 
        _e('Reorder');
        ?></span>
			<span class="reorder-done"><?php 
        _e('Done');
        ?></span>
		</button>
		<p class="screen-reader-text" id="<?php 
        echo esc_attr($id);
        ?>"><?php 
        _e('When in reorder mode, additional controls to reorder widgets will be available in the widgets list above.');
        ?></p>
		<?php 
    }
}