<?php

/**
 * Widget API: WP_Widget_Text class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Text widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Text extends WP_Widget
{
    /**
     * Whether or not the widget has been registered yet.
     *
     * @since 4.8.1
     * @var bool
     */
    protected $registered = false;
    /**
     * Sets up a new Text widget instance.
     *
     * @since 2.8.0
     */
    public function __construct()
    {
        $widget_ops = array('classname' => 'widget_text', 'description' => __('Arbitrary text.'), 'customize_selective_refresh' => true);
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('text', __('Text'), $widget_ops, $control_ops);
    }
    /**
     * Add hooks for enqueueing assets when registering all widget instances of this widget class.
     *
     * @param int $number Optional. The unique order number of this widget instance
     *                    compared to other instances of the same class. Default -1.
     */
    public function _register_one($number = -1)
    {
        parent::_register_one($number);
        if ($this->registered) {
            return;
        }
        $this->registered = true;
        wp_add_inline_script('text-widgets', sprintf('wp.textWidgets.idBases.push( %s );', wp_json_encode($this->id_base)));
        if ($this->is_preview()) {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_preview_scripts'));
        }
        // Note that the widgets component in the customizer will also do
        // the 'admin_print_scripts-widgets.php' action in WP_Customize_Widgets::print_scripts().
        add_action('admin_print_scripts-widgets.php', array($this, 'enqueue_admin_scripts'));
        // Note that the widgets component in the customizer will also do
        // the 'admin_footer-widgets.php' action in WP_Customize_Widgets::print_footer_scripts().
        add_action('admin_footer-widgets.php', array('WP_Widget_Text', 'render_control_template_scripts'));
    }
    /**
     * Determines whether a given instance is legacy and should bypass using TinyMCE.
     *
     * @since 4.8.1
     *
     * @param array $instance {
     *     Instance data.
     *
     *     @type string      $text   Content.
     *     @type bool|string $filter Whether autop or content filters should apply.
     *     @type bool        $legacy Whether widget is in legacy mode.
     * }
     * @return bool Whether Text widget instance contains legacy data.
     */
    public function is_legacy_instance($instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_legacy_instance") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php at line 78")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_legacy_instance:78@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php');
        die();
    }
    /**
     * Filters gallery shortcode attributes.
     *
     * Prevents all of a site's attachments from being shown in a gallery displayed on a
     * non-singular template where a $post context is not available.
     *
     * @since 4.9.0
     *
     * @param array $attrs Attributes.
     * @return array Attributes.
     */
    public function _filter_gallery_shortcode_attrs($attrs)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_filter_gallery_shortcode_attrs") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php at line 151")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _filter_gallery_shortcode_attrs:151@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php');
        die();
    }
    /**
     * Outputs the content for the current Text widget instance.
     *
     * @since 2.8.0
     *
     * @global WP_Post $post Global post object.
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Text widget instance.
     */
    public function widget($args, $instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php at line 169")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called widget:169@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php');
        die();
    }
    /**
     * Inject max-width and remove height for videos too constrained to fit inside sidebars on frontend.
     *
     * @since 4.9.0
     *
     * @see WP_Widget_Media_Video::inject_video_max_width_style()
     *
     * @param array $matches Pattern matches from preg_replace_callback.
     * @return string HTML Output.
     */
    public function inject_video_max_width_style($matches)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("inject_video_max_width_style") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php at line 283")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called inject_video_max_width_style:283@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php');
        die();
    }
    /**
     * Handles updating settings for the current Text widget instance.
     *
     * @since 2.8.0
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Settings to save or bool false to cancel saving.
     */
    public function update($new_instance, $old_instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php at line 301")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:301@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php');
        die();
    }
    /**
     * Enqueue preview scripts.
     *
     * These scripts normally are enqueued just-in-time when a playlist shortcode is used.
     * However, in the customizer, a playlist shortcode may be used in a text widget and
     * dynamically added via selective refresh, so it is important to unconditionally enqueue them.
     *
     * @since 4.9.3
     */
    public function enqueue_preview_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue_preview_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php at line 343")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue_preview_scripts:343@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php');
        die();
    }
    /**
     * Loads the required scripts and styles for the widget control.
     *
     * @since 4.8.0
     */
    public function enqueue_admin_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue_admin_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php at line 354")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue_admin_scripts:354@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php');
        die();
    }
    /**
     * Outputs the Text widget settings form.
     *
     * @since 2.8.0
     * @since 4.8.0 Form only contains hidden inputs which are synced with JS template.
     * @since 4.8.1 Restored original form to be displayed when in legacy mode.
     *
     * @see WP_Widget_Text::render_control_template_scripts()
     * @see _WP_Editors::editor()
     *
     * @param array $instance Current settings.
     */
    public function form($instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("form") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php at line 373")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called form:373@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-text.php');
        die();
    }
    /**
     * Render form template scripts.
     *
     * @since 4.8.0
     * @since 4.9.0 The method is now static.
     */
    public static function render_control_template_scripts()
    {
        $dismissed_pointers = explode(',', (string) get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
        ?>
		<script type="text/html" id="tmpl-widget-text-control-fields">
			<# var elementIdPrefix = 'el' + String( Math.random() ).replace( /\D/g, '' ) + '_' #>
			<p>
				<label for="{{ elementIdPrefix }}title"><?php 
        esc_html_e('Title:');
        ?></label>
				<input id="{{ elementIdPrefix }}title" type="text" class="widefat title">
			</p>

			<?php 
        if (!in_array('text_widget_custom_html', $dismissed_pointers, true)) {
            ?>
				<div hidden class="wp-pointer custom-html-widget-pointer wp-pointer-top">
					<div class="wp-pointer-content">
						<h3><?php 
            _e('New Custom HTML Widget');
            ?></h3>
						<?php 
            if (is_customize_preview()) {
                ?>
							<p><?php 
                _e('Did you know there is a &#8220;Custom HTML&#8221; widget now? You can find it by pressing the &#8220;<a class="add-widget" href="#">Add a Widget</a>&#8221; button and searching for &#8220;HTML&#8221;. Check it out to add some custom code to your site!');
                ?></p>
						<?php 
            } else {
                ?>
							<p><?php 
                _e('Did you know there is a &#8220;Custom HTML&#8221; widget now? You can find it by scanning the list of available widgets on this screen. Check it out to add some custom code to your site!');
                ?></p>
						<?php 
            }
            ?>
						<div class="wp-pointer-buttons">
							<a class="close" href="#"><?php 
            _e('Dismiss');
            ?></a>
						</div>
					</div>
					<div class="wp-pointer-arrow">
						<div class="wp-pointer-arrow-inner"></div>
					</div>
				</div>
			<?php 
        }
        ?>

			<?php 
        if (!in_array('text_widget_paste_html', $dismissed_pointers, true)) {
            ?>
				<div hidden class="wp-pointer paste-html-pointer wp-pointer-top">
					<div class="wp-pointer-content">
						<h3><?php 
            _e('Did you just paste HTML?');
            ?></h3>
						<p><?php 
            _e('Hey there, looks like you just pasted HTML into the &#8220;Visual&#8221; tab of the Text widget. You may want to paste your code into the &#8220;Text&#8221; tab instead. Alternately, try out the new &#8220;Custom HTML&#8221; widget!');
            ?></p>
						<div class="wp-pointer-buttons">
							<a class="close" href="#"><?php 
            _e('Dismiss');
            ?></a>
						</div>
					</div>
					<div class="wp-pointer-arrow">
						<div class="wp-pointer-arrow-inner"></div>
					</div>
				</div>
			<?php 
        }
        ?>

			<p>
				<label for="{{ elementIdPrefix }}text" class="screen-reader-text"><?php 
        esc_html_e('Content:');
        ?></label>
				<textarea id="{{ elementIdPrefix }}text" class="widefat text wp-editor-area" style="height: 200px" rows="16" cols="20"></textarea>
			</p>
		</script>
		<?php 
    }
}