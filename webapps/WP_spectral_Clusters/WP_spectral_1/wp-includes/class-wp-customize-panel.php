<?php

/**
 * WordPress Customize Panel classes
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.0.0
 */
/**
 * Customize Panel class.
 *
 * A UI container for sections, managed by the WP_Customize_Manager.
 *
 * @since 4.0.0
 *
 * @see WP_Customize_Manager
 */
class WP_Customize_Panel
{
    /**
     * Incremented with each new class instantiation, then stored in $instance_number.
     *
     * Used when sorting two instances whose priorities are equal.
     *
     * @since 4.1.0
     * @var int
     */
    protected static $instance_count = 0;
    /**
     * Order in which this instance was created in relation to other instances.
     *
     * @since 4.1.0
     * @var int
     */
    public $instance_number;
    /**
     * WP_Customize_Manager instance.
     *
     * @since 4.0.0
     * @var WP_Customize_Manager
     */
    public $manager;
    /**
     * Unique identifier.
     *
     * @since 4.0.0
     * @var string
     */
    public $id;
    /**
     * Priority of the panel, defining the display order of panels and sections.
     *
     * @since 4.0.0
     * @var integer
     */
    public $priority = 160;
    /**
     * Capability required for the panel.
     *
     * @since 4.0.0
     * @var string
     */
    public $capability = 'edit_theme_options';
    /**
     * Theme features required to support the panel.
     *
     * @since 4.0.0
     * @var string|string[]
     */
    public $theme_supports = '';
    /**
     * Title of the panel to show in UI.
     *
     * @since 4.0.0
     * @var string
     */
    public $title = '';
    /**
     * Description to show in the UI.
     *
     * @since 4.0.0
     * @var string
     */
    public $description = '';
    /**
     * Auto-expand a section in a panel when the panel is expanded when the panel only has the one section.
     *
     * @since 4.7.4
     * @var bool
     */
    public $auto_expand_sole_section = false;
    /**
     * Customizer sections for this panel.
     *
     * @since 4.0.0
     * @var array
     */
    public $sections;
    /**
     * Type of this panel.
     *
     * @since 4.1.0
     * @var string
     */
    public $type = 'default';
    /**
     * Active callback.
     *
     * @since 4.1.0
     *
     * @see WP_Customize_Section::active()
     *
     * @var callable Callback is called with one argument, the instance of
     *               WP_Customize_Section, and returns bool to indicate whether
     *               the section is active (such as it relates to the URL currently
     *               being previewed).
     */
    public $active_callback = '';
    /**
     * Constructor.
     *
     * Any supplied $args override class property defaults.
     *
     * @since 4.0.0
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      A specific ID for the panel.
     * @param array                $args    {
     *     Optional. Array of properties for the new Panel object. Default empty array.
     *
     *     @type int             $priority        Priority of the panel, defining the display order
     *                                            of panels and sections. Default 160.
     *     @type string          $capability      Capability required for the panel.
     *                                            Default `edit_theme_options`.
     *     @type string|string[] $theme_supports  Theme features required to support the panel.
     *     @type string          $title           Title of the panel to show in UI.
     *     @type string          $description     Description to show in the UI.
     *     @type string          $type            Type of the panel.
     *     @type callable        $active_callback Active callback.
     * }
     */
    public function __construct($manager, $id, $args = array())
    {
        $keys = array_keys(get_object_vars($this));
        foreach ($keys as $key) {
            if (isset($args[$key])) {
                $this->{$key} = $args[$key];
            }
        }
        $this->manager = $manager;
        $this->id = $id;
        if (empty($this->active_callback)) {
            $this->active_callback = array($this, 'active_callback');
        }
        self::$instance_count += 1;
        $this->instance_number = self::$instance_count;
        $this->sections = array();
        // Users cannot customize the $sections array.
    }
    /**
     * Check whether panel is active to current Customizer preview.
     *
     * @since 4.1.0
     *
     * @return bool Whether the panel is active to the current preview.
     */
    public final function active()
    {
        $panel = $this;
        $active = call_user_func($this->active_callback, $this);
        /**
         * Filters response of WP_Customize_Panel::active().
         *
         * @since 4.1.0
         *
         * @param bool               $active Whether the Customizer panel is active.
         * @param WP_Customize_Panel $panel  WP_Customize_Panel instance.
         */
        $active = apply_filters('customize_panel_active', $active, $panel);
        return $active;
    }
    /**
     * Default callback used when invoking WP_Customize_Panel::active().
     *
     * Subclasses can override this with their specific logic, or they may
     * provide an 'active_callback' argument to the constructor.
     *
     * @since 4.1.0
     *
     * @return bool Always true.
     */
    public function active_callback()
    {
        return true;
    }
    /**
     * Gather the parameters passed to client JavaScript via JSON.
     *
     * @since 4.1.0
     *
     * @return array The array to be exported to the client as JSON.
     */
    public function json()
    {
        $array = wp_array_slice_assoc((array) $this, array('id', 'description', 'priority', 'type'));
        $array['title'] = html_entity_decode($this->title, ENT_QUOTES, get_bloginfo('charset'));
        $array['content'] = $this->get_content();
        $array['active'] = $this->active();
        $array['instanceNumber'] = $this->instance_number;
        $array['autoExpandSoleSection'] = $this->auto_expand_sole_section;
        return $array;
    }
    /**
     * Checks required user capabilities and whether the theme has the
     * feature support required by the panel.
     *
     * @since 4.0.0
     *
     * @return bool False if theme doesn't support the panel or the user doesn't have the capability.
     */
    public final function check_capabilities()
    {
        if ($this->capability && !current_user_can($this->capability)) {
            return false;
        }
        if ($this->theme_supports && !current_theme_supports(...(array) $this->theme_supports)) {
            return false;
        }
        return true;
    }
    /**
     * Get the panel's content template for insertion into the Customizer pane.
     *
     * @since 4.1.0
     *
     * @return string Content for the panel.
     */
    public final function get_content()
    {
        ob_start();
        $this->maybe_render();
        return trim(ob_get_clean());
    }
    /**
     * Check capabilities and render the panel.
     *
     * @since 4.0.0
     */
    public final function maybe_render()
    {
        if (!$this->check_capabilities()) {
            return;
        }
        /**
         * Fires before rendering a Customizer panel.
         *
         * @since 4.0.0
         *
         * @param WP_Customize_Panel $this WP_Customize_Panel instance.
         */
        do_action('customize_render_panel', $this);
        /**
         * Fires before rendering a specific Customizer panel.
         *
         * The dynamic portion of the hook name, `$this->id`, refers to
         * the ID of the specific Customizer panel to be rendered.
         *
         * @since 4.0.0
         */
        do_action("customize_render_panel_{$this->id}");
        $this->render();
    }
    /**
     * Render the panel container, and then its contents (via `this->render_content()`) in a subclass.
     *
     * Panel containers are now rendered in JS by default, see WP_Customize_Panel::print_template().
     *
     * @since 4.0.0
     */
    protected function render()
    {
    }
    /**
     * Render the panel UI in a subclass.
     *
     * Panel contents are now rendered in JS by default, see WP_Customize_Panel::print_template().
     *
     * @since 4.1.0
     */
    protected function render_content()
    {
    }
    /**
     * Render the panel's JS templates.
     *
     * This function is only run for panel types that have been registered with
     * WP_Customize_Manager::register_panel_type().
     *
     * @since 4.3.0
     *
     * @see WP_Customize_Manager::register_panel_type()
     */
    public function print_template()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("print_template") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-customize-panel.php at line 307")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called print_template:307@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-customize-panel.php');
        die();
    }
    /**
     * An Underscore (JS) template for rendering this panel's container.
     *
     * Class variables for this panel class are available in the `data` JS object;
     * export custom variables by overriding WP_Customize_Panel::json().
     *
     * @see WP_Customize_Panel::print_template()
     *
     * @since 4.3.0
     */
    protected function render_template()
    {
        ?>
		<li id="accordion-panel-{{ data.id }}" class="accordion-section control-section control-panel control-panel-{{ data.type }}">
			<h3 class="accordion-section-title" tabindex="0">
				{{ data.title }}
				<span class="screen-reader-text"><?php 
        _e('Press return or enter to open this panel');
        ?></span>
			</h3>
			<ul class="accordion-sub-container control-panel-content"></ul>
		</li>
		<?php 
    }
    /**
     * An Underscore (JS) template for this panel's content (but not its container).
     *
     * Class variables for this panel class are available in the `data` JS object;
     * export custom variables by overriding WP_Customize_Panel::json().
     *
     * @see WP_Customize_Panel::print_template()
     *
     * @since 4.3.0
     */
    protected function content_template()
    {
        ?>
		<li class="panel-meta customize-info accordion-section <# if ( ! data.description ) { #> cannot-expand<# } #>">
			<button class="customize-panel-back" tabindex="-1"><span class="screen-reader-text"><?php 
        _e('Back');
        ?></span></button>
			<div class="accordion-section-title">
				<span class="preview-notice">
				<?php 
        /* translators: %s: The site/panel title in the Customizer. */
        printf(__('You are customizing %s'), '<strong class="panel-title">{{ data.title }}</strong>');
        ?>
				</span>
				<# if ( data.description ) { #>
					<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php 
        _e('Help');
        ?></span></button>
				<# } #>
			</div>
			<# if ( data.description ) { #>
				<div class="description customize-panel-description">
					{{{ data.description }}}
				</div>
			<# } #>

			<div class="customize-control-notifications-container"></div>
		</li>
		<?php 
    }
}
/** WP_Customize_Nav_Menus_Panel class */
require_once ABSPATH . WPINC . '/customize/class-wp-customize-nav-menus-panel.php';