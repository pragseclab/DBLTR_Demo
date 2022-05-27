<?php

/**
 * Widget API: WP_Media_Widget class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.8.0
 */
/**
 * Core class that implements a media widget.
 *
 * @since 4.8.0
 *
 * @see WP_Widget
 */
abstract class WP_Widget_Media extends WP_Widget
{
    /**
     * Translation labels.
     *
     * @since 4.8.0
     * @var array
     */
    public $l10n = array('add_to_widget' => '', 'replace_media' => '', 'edit_media' => '', 'media_library_state_multi' => '', 'media_library_state_single' => '', 'missing_attachment' => '', 'no_media_selected' => '', 'add_media' => '');
    /**
     * Whether or not the widget has been registered yet.
     *
     * @since 4.8.1
     * @var bool
     */
    protected $registered = false;
    /**
     * Constructor.
     *
     * @since 4.8.0
     *
     * @param string $id_base         Base ID for the widget, lowercase and unique.
     * @param string $name            Name for the widget displayed on the configuration page.
     * @param array  $widget_options  Optional. Widget options. See wp_register_sidebar_widget() for
     *                                information on accepted arguments. Default empty array.
     * @param array  $control_options Optional. Widget control options. See wp_register_widget_control()
     *                                for information on accepted arguments. Default empty array.
     */
    public function __construct($id_base, $name, $widget_options = array(), $control_options = array())
    {
        $widget_opts = wp_parse_args($widget_options, array('description' => __('A media item.'), 'customize_selective_refresh' => true, 'mime_type' => ''));
        $control_opts = wp_parse_args($control_options, array());
        $l10n_defaults = array(
            'no_media_selected' => __('No media selected'),
            'add_media' => _x('Add Media', 'label for button in the media widget'),
            'replace_media' => _x('Replace Media', 'label for button in the media widget; should preferably not be longer than ~13 characters long'),
            'edit_media' => _x('Edit Media', 'label for button in the media widget; should preferably not be longer than ~13 characters long'),
            'add_to_widget' => __('Add to Widget'),
            'missing_attachment' => sprintf(
                /* translators: %s: URL to media library. */
                __('We can&#8217;t find that file. Check your <a href="%s">media library</a> and make sure it wasn&#8217;t deleted.'),
                esc_url(admin_url('upload.php'))
            ),
            /* translators: %d: Widget count. */
            'media_library_state_multi' => _n_noop('Media Widget (%d)', 'Media Widget (%d)'),
            'media_library_state_single' => __('Media Widget'),
            'unsupported_file_type' => __('Looks like this isn&#8217;t the correct kind of file. Please link to an appropriate file instead.'),
        );
        $this->l10n = array_merge($l10n_defaults, array_filter($this->l10n));
        parent::__construct($id_base, $name, $widget_opts, $control_opts);
    }
    /**
     * Add hooks while registering all widget instances of this widget class.
     *
     * @since 4.8.0
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
        // Note that the widgets component in the customizer will also do
        // the 'admin_print_scripts-widgets.php' action in WP_Customize_Widgets::print_scripts().
        add_action('admin_print_scripts-widgets.php', array($this, 'enqueue_admin_scripts'));
        if ($this->is_preview()) {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_preview_scripts'));
        }
        // Note that the widgets component in the customizer will also do
        // the 'admin_footer-widgets.php' action in WP_Customize_Widgets::print_footer_scripts().
        add_action('admin_footer-widgets.php', array($this, 'render_control_template_scripts'));
        add_filter('display_media_states', array($this, 'display_media_state'), 10, 2);
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
        $schema = array('attachment_id' => array('type' => 'integer', 'default' => 0, 'minimum' => 0, 'description' => __('Attachment post ID'), 'media_prop' => 'id'), 'url' => array('type' => 'string', 'default' => '', 'format' => 'uri', 'description' => __('URL to the media file')), 'title' => array('type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'description' => __('Title for the widget'), 'should_preview_update' => false));
        /**
         * Filters the media widget instance schema to add additional properties.
         *
         * @since 4.9.0
         *
         * @param array           $schema Instance schema.
         * @param WP_Widget_Media $widget Widget object.
         */
        $schema = apply_filters("widget_{$this->id_base}_instance_schema", $schema, $this);
        return $schema;
    }
    /**
     * Determine if the supplied attachment is for a valid attachment post with the specified MIME type.
     *
     * @since 4.8.0
     *
     * @param int|WP_Post $attachment Attachment post ID or object.
     * @param string      $mime_type  MIME type.
     * @return bool Is matching MIME type.
     */
    public function is_attachment_with_mime_type($attachment, $mime_type)
    {
        if (empty($attachment)) {
            return false;
        }
        $attachment = get_post($attachment);
        if (!$attachment) {
            return false;
        }
        if ('attachment' !== $attachment->post_type) {
            return false;
        }
        return wp_attachment_is($mime_type, $attachment);
    }
    /**
     * Sanitize a token list string, such as used in HTML rel and class attributes.
     *
     * @since 4.8.0
     *
     * @link http://w3c.github.io/html/infrastructure.html#space-separated-tokens
     * @link https://developer.mozilla.org/en-US/docs/Web/API/DOMTokenList
     * @param string|array $tokens List of tokens separated by spaces, or an array of tokens.
     * @return string Sanitized token string list.
     */
    public function sanitize_token_list($tokens)
    {
        if (is_string($tokens)) {
            $tokens = preg_split('/\\s+/', trim($tokens));
        }
        $tokens = array_map('sanitize_html_class', $tokens);
        $tokens = array_filter($tokens);
        return implode(' ', $tokens);
    }
    /**
     * Displays the widget on the front-end.
     *
     * @since 4.8.0
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Display arguments including before_title, after_title, before_widget, and after_widget.
     * @param array $instance Saved setting from the database.
     */
    public function widget($args, $instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-media.php at line 173")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called widget:173@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-media.php');
        die();
    }
    /**
     * Sanitizes the widget form values as they are saved.
     *
     * @since 4.8.0
     *
     * @see WP_Widget::update()
     * @see WP_REST_Request::has_valid_params()
     * @see WP_REST_Request::sanitize_params()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $instance     Previously saved values from database.
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-media.php at line 212")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:212@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-media.php');
        die();
    }
    /**
     * Render the media on the frontend.
     *
     * @since 4.8.0
     *
     * @param array $instance Widget instance props.
     * @return string
     */
    public abstract function render_media($instance);
    /**
     * Outputs the settings update form.
     *
     * Note that the widget UI itself is rendered with JavaScript via `MediaWidgetControl#render()`.
     *
     * @since 4.8.0
     *
     * @see \WP_Widget_Media::render_control_template_scripts() Where the JS template is located.
     *
     * @param array $instance Current settings.
     */
    public final function form($instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("form") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-media.php at line 267")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called form:267@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-media.php');
        die();
    }
    /**
     * Filters the default media display states for items in the Media list table.
     *
     * @since 4.8.0
     *
     * @param array   $states An array of media states.
     * @param WP_Post $post   The current attachment object.
     * @return array
     */
    public function display_media_state($states, $post = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("display_media_state") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-media.php at line 302")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called display_media_state:302@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-media.php');
        die();
    }
    /**
     * Enqueue preview scripts.
     *
     * These scripts normally are enqueued just-in-time when a widget is rendered.
     * In the customizer, however, widgets can be dynamically added and rendered via
     * selective refresh, and so it is important to unconditionally enqueue them in
     * case a widget does get added.
     *
     * @since 4.8.0
     */
    public function enqueue_preview_scripts()
    {
    }
    /**
     * Loads the required scripts and styles for the widget control.
     *
     * @since 4.8.0
     */
    public function enqueue_admin_scripts()
    {
        wp_enqueue_media();
        wp_enqueue_script('media-widgets');
    }
    /**
     * Render form template scripts.
     *
     * @since 4.8.0
     */
    public function render_control_template_scripts()
    {
        ?>
		<script type="text/html" id="tmpl-widget-media-<?php 
        echo esc_attr($this->id_base);
        ?>-control">
			<# var elementIdPrefix = 'el' + String( Math.random() ) + '_' #>
			<p>
				<label for="{{ elementIdPrefix }}title"><?php 
        esc_html_e('Title:');
        ?></label>
				<input id="{{ elementIdPrefix }}title" type="text" class="widefat title">
			</p>
			<div class="media-widget-preview <?php 
        echo esc_attr($this->id_base);
        ?>">
				<div class="attachment-media-view">
					<button type="button" class="select-media button-add-media not-selected">
						<?php 
        echo esc_html($this->l10n['add_media']);
        ?>
					</button>
				</div>
			</div>
			<p class="media-widget-buttons">
				<button type="button" class="button edit-media selected">
					<?php 
        echo esc_html($this->l10n['edit_media']);
        ?>
				</button>
			<?php 
        if (!empty($this->l10n['replace_media'])) {
            ?>
				<button type="button" class="button change-media select-media selected">
					<?php 
            echo esc_html($this->l10n['replace_media']);
            ?>
				</button>
			<?php 
        }
        ?>
			</p>
			<div class="media-widget-fields">
			</div>
		</script>
		<?php 
    }
    /**
     * Whether the widget has content to show.
     *
     * @since 4.8.0
     *
     * @param array $instance Widget instance props.
     * @return bool Whether widget has content.
     */
    protected function has_content($instance)
    {
        return $instance['attachment_id'] && 'attachment' === get_post_type($instance['attachment_id']) || $instance['url'];
    }
}