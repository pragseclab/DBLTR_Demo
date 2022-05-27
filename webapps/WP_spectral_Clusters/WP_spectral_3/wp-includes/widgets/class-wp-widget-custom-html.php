<?php

/**
 * Widget API: WP_Widget_Custom_HTML class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.8.1
 */
/**
 * Core class used to implement a Custom HTML widget.
 *
 * @since 4.8.1
 *
 * @see WP_Widget
 */
class WP_Widget_Custom_HTML extends WP_Widget
{
    /**
     * Whether or not the widget has been registered yet.
     *
     * @since 4.9.0
     * @var bool
     */
    protected $registered = false;
    /**
     * Default instance.
     *
     * @since 4.8.1
     * @var array
     */
    protected $default_instance = array('title' => '', 'content' => '');
    /**
     * Sets up a new Custom HTML widget instance.
     *
     * @since 4.8.1
     */
    public function __construct()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-custom-html.php at line 40")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:40@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-custom-html.php');
        die();
    }
    /**
     * Add hooks for enqueueing assets when registering all widget instances of this widget class.
     *
     * @since 4.9.0
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
        wp_add_inline_script('custom-html-widgets', sprintf('wp.customHtmlWidgets.idBases.push( %s );', wp_json_encode($this->id_base)));
        // Note that the widgets component in the customizer will also do
        // the 'admin_print_scripts-widgets.php' action in WP_Customize_Widgets::print_scripts().
        add_action('admin_print_scripts-widgets.php', array($this, 'enqueue_admin_scripts'));
        // Note that the widgets component in the customizer will also do
        // the 'admin_footer-widgets.php' action in WP_Customize_Widgets::print_footer_scripts().
        add_action('admin_footer-widgets.php', array('WP_Widget_Custom_HTML', 'render_control_template_scripts'));
        // Note this action is used to ensure the help text is added to the end.
        add_action('admin_head-widgets.php', array('WP_Widget_Custom_HTML', 'add_help_text'));
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
        if (!is_singular() && empty($attrs['id']) && empty($attrs['include'])) {
            $attrs['id'] = -1;
        }
        return $attrs;
    }
    /**
     * Outputs the content for the current Custom HTML widget instance.
     *
     * @since 4.8.1
     *
     * @global WP_Post $post Global post object.
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Custom HTML widget instance.
     */
    public function widget($args, $instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-custom-html.php at line 100")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called widget:100@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-custom-html.php');
        die();
    }
    /**
     * Handles updating settings for the current Custom HTML widget instance.
     *
     * @since 4.8.1
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Settings to save or bool false to cancel saving.
     */
    public function update($new_instance, $old_instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-custom-html.php at line 165")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:165@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-custom-html.php');
        die();
    }
    /**
     * Loads the required scripts and styles for the widget control.
     *
     * @since 4.9.0
     */
    public function enqueue_admin_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue_admin_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-custom-html.php at line 181")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue_admin_scripts:181@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-custom-html.php');
        die();
    }
    /**
     * Outputs the Custom HTML widget settings form.
     *
     * @since 4.8.1
     * @since 4.9.0 The form contains only hidden sync inputs. For the control UI, see `WP_Widget_Custom_HTML::render_control_template_scripts()`.
     *
     * @see WP_Widget_Custom_HTML::render_control_template_scripts()
     *
     * @param array $instance Current instance.
     */
    public function form($instance)
    {
        $instance = wp_parse_args((array) $instance, $this->default_instance);
        ?>
		<input id="<?php 
        echo $this->get_field_id('title');
        ?>" name="<?php 
        echo $this->get_field_name('title');
        ?>" class="title sync-input" type="hidden" value="<?php 
        echo esc_attr($instance['title']);
        ?>" />
		<textarea id="<?php 
        echo $this->get_field_id('content');
        ?>" name="<?php 
        echo $this->get_field_name('content');
        ?>" class="content sync-input" hidden><?php 
        echo esc_textarea($instance['content']);
        ?></textarea>
		<?php 
    }
    /**
     * Render form template scripts.
     *
     * @since 4.9.0
     */
    public static function render_control_template_scripts()
    {
        ?>
		<script type="text/html" id="tmpl-widget-custom-html-control-fields">
			<# var elementIdPrefix = 'el' + String( Math.random() ).replace( /\D/g, '' ) + '_' #>
			<p>
				<label for="{{ elementIdPrefix }}title"><?php 
        esc_html_e('Title:');
        ?></label>
				<input id="{{ elementIdPrefix }}title" type="text" class="widefat title">
			</p>

			<p>
				<label for="{{ elementIdPrefix }}content" id="{{ elementIdPrefix }}content-label"><?php 
        esc_html_e('Content:');
        ?></label>
				<textarea id="{{ elementIdPrefix }}content" class="widefat code content" rows="16" cols="20"></textarea>
			</p>

			<?php 
        if (!current_user_can('unfiltered_html')) {
            ?>
				<?php 
            $probably_unsafe_html = array('script', 'iframe', 'form', 'input', 'style');
            $allowed_html = wp_kses_allowed_html('post');
            $disallowed_html = array_diff($probably_unsafe_html, array_keys($allowed_html));
            ?>
				<?php 
            if (!empty($disallowed_html)) {
                ?>
					<# if ( data.codeEditorDisabled ) { #>
						<p>
							<?php 
                _e('Some HTML tags are not permitted, including:');
                ?>
							<code><?php 
                echo implode('</code>, <code>', $disallowed_html);
                ?></code>
						</p>
					<# } #>
				<?php 
            }
            ?>
			<?php 
        }
        ?>

			<div class="code-editor-error-container"></div>
		</script>
		<?php 
    }
    /**
     * Add help text to widgets admin screen.
     *
     * @since 4.9.0
     */
    public static function add_help_text()
    {
        $screen = get_current_screen();
        $content = '<p>';
        $content .= __('Use the Custom HTML widget to add arbitrary HTML code to your widget areas.');
        $content .= '</p>';
        if ('false' !== wp_get_current_user()->syntax_highlighting) {
            $content .= '<p>';
            $content .= sprintf(
                /* translators: 1: Link to user profile, 2: Additional link attributes, 3: Accessibility text. */
                __('The edit field automatically highlights code syntax. You can disable this in your <a href="%1$s" %2$s>user profile%3$s</a> to work in plain text mode.'),
                esc_url(get_edit_profile_url()),
                'class="external-link" target="_blank"',
                sprintf(
                    '<span class="screen-reader-text"> %s</span>',
                    /* translators: Accessibility text. */
                    __('(opens in a new tab)')
                )
            );
            $content .= '</p>';
            $content .= '<p id="editor-keyboard-trap-help-1">' . __('When using a keyboard to navigate:') . '</p>';
            $content .= '<ul>';
            $content .= '<li id="editor-keyboard-trap-help-2">' . __('In the editing area, the Tab key enters a tab character.') . '</li>';
            $content .= '<li id="editor-keyboard-trap-help-3">' . __('To move away from this area, press the Esc key followed by the Tab key.') . '</li>';
            $content .= '<li id="editor-keyboard-trap-help-4">' . __('Screen reader users: when in forms mode, you may need to press the Esc key twice.') . '</li>';
            $content .= '</ul>';
        }
        $screen->add_help_tab(array('id' => 'custom_html_widget', 'title' => __('Custom HTML Widget'), 'content' => $content));
    }
}