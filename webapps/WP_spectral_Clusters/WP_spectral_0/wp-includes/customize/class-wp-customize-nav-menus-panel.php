<?php

/**
 * Customize API: WP_Customize_Nav_Menus_Panel class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */
/**
 * Customize Nav Menus Panel Class
 *
 * Needed to add screen options.
 *
 * @since 4.3.0
 *
 * @see WP_Customize_Panel
 */
class WP_Customize_Nav_Menus_Panel extends WP_Customize_Panel
{
    /**
     * Control type.
     *
     * @since 4.3.0
     * @var string
     */
    public $type = 'nav_menus';
    /**
     * Render screen options for Menus.
     *
     * @since 4.3.0
     */
    public function render_screen_options()
    {
        // Adds the screen options.
        require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
        add_filter('manage_nav-menus_columns', 'wp_nav_menu_manage_columns');
        // Display screen options.
        $screen = WP_Screen::get('nav-menus.php');
        $screen->render_screen_options(array('wrap' => false));
    }
    /**
     * Returns the advanced options for the nav menus page.
     *
     * Link title attribute added as it's a relatively advanced concept for new users.
     *
     * @since 4.3.0
     * @deprecated 4.5.0 Deprecated in favor of wp_nav_menu_manage_columns().
     */
    public function wp_nav_menu_manage_columns()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_nav_menu_manage_columns") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/customize/class-wp-customize-nav-menus-panel.php at line 52")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_nav_menu_manage_columns:52@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/customize/class-wp-customize-nav-menus-panel.php');
        die();
    }
    /**
     * An Underscore (JS) template for this panel's content (but not its container).
     *
     * Class variables for this panel class are available in the `data` JS object;
     * export custom variables by overriding WP_Customize_Panel::json().
     *
     * @since 4.3.0
     *
     * @see WP_Customize_Panel::print_template()
     */
    protected function content_template()
    {
        ?>
		<li class="panel-meta customize-info accordion-section <# if ( ! data.description ) { #> cannot-expand<# } #>">
			<button type="button" class="customize-panel-back" tabindex="-1">
				<span class="screen-reader-text"><?php 
        _e('Back');
        ?></span>
			</button>
			<div class="accordion-section-title">
				<span class="preview-notice">
					<?php 
        /* translators: %s: The site/panel title in the Customizer. */
        printf(__('You are customizing %s'), '<strong class="panel-title">{{ data.title }}</strong>');
        ?>
				</span>
				<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false">
					<span class="screen-reader-text"><?php 
        _e('Help');
        ?></span>
				</button>
				<button type="button" class="customize-screen-options-toggle" aria-expanded="false">
					<span class="screen-reader-text"><?php 
        _e('Menu Options');
        ?></span>
				</button>
			</div>
			<# if ( data.description ) { #>
			<div class="description customize-panel-description">{{{ data.description }}}</div>
			<# } #>
			<div id="screen-options-wrap">
				<?php 
        $this->render_screen_options();
        ?>
			</div>
		</li>
		<?php 
        // NOTE: The following is a workaround for an inability to treat (and thus label) a list of sections as a whole.
        ?>
		<li class="customize-control-title customize-section-title-nav_menus-heading"><?php 
        _e('Menus');
        ?></li>
		<?php 
    }
}