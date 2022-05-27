<?php

/**
 * Widget API: WP_Nav_Menu_Widget class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement the Navigation Menu widget.
 *
 * @since 3.0.0
 *
 * @see WP_Widget
 */
class WP_Nav_Menu_Widget extends WP_Widget
{
    /**
     * Sets up a new Navigation Menu widget instance.
     *
     * @since 3.0.0
     */
    public function __construct()
    {
        $widget_ops = array('description' => __('Add a navigation menu to your sidebar.'), 'customize_selective_refresh' => true);
        parent::__construct('nav_menu', __('Navigation Menu'), $widget_ops);
    }
    /**
     * Outputs the content for the current Navigation Menu widget instance.
     *
     * @since 3.0.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Navigation Menu widget instance.
     */
    public function widget($args, $instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-nav-menu-widget.php at line 41")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called widget:41@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-nav-menu-widget.php');
        die();
    }
    /**
     * Handles updating settings for the current Navigation Menu widget instance.
     *
     * @since 3.0.0
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update($new_instance, $old_instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-nav-menu-widget.php at line 102")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:102@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-nav-menu-widget.php');
        die();
    }
    /**
     * Outputs the settings form for the Navigation Menu widget.
     *
     * @since 3.0.0
     *
     * @param array $instance Current settings.
     * @global WP_Customize_Manager $wp_customize
     */
    public function form($instance)
    {
        global $wp_customize;
        $title = isset($instance['title']) ? $instance['title'] : '';
        $nav_menu = isset($instance['nav_menu']) ? $instance['nav_menu'] : '';
        // Get menus.
        $menus = wp_get_nav_menus();
        $empty_menus_style = '';
        $not_empty_menus_style = '';
        if (empty($menus)) {
            $empty_menus_style = ' style="display:none" ';
        } else {
            $not_empty_menus_style = ' style="display:none" ';
        }
        $nav_menu_style = '';
        if (!$nav_menu) {
            $nav_menu_style = 'display: none;';
        }
        // If no menus exists, direct the user to go and create some.
        ?>
		<p class="nav-menu-widget-no-menus-message" <?php 
        echo $not_empty_menus_style;
        ?>>
			<?php 
        if ($wp_customize instanceof WP_Customize_Manager) {
            $url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
        } else {
            $url = admin_url('nav-menus.php');
        }
        /* translators: %s: URL to create a new menu. */
        printf(__('No menus have been created yet. <a href="%s">Create some</a>.'), esc_attr($url));
        ?>
		</p>
		<div class="nav-menu-widget-form-controls" <?php 
        echo $empty_menus_style;
        ?>>
			<p>
				<label for="<?php 
        echo $this->get_field_id('title');
        ?>"><?php 
        _e('Title:');
        ?></label>
				<input type="text" class="widefat" id="<?php 
        echo $this->get_field_id('title');
        ?>" name="<?php 
        echo $this->get_field_name('title');
        ?>" value="<?php 
        echo esc_attr($title);
        ?>" />
			</p>
			<p>
				<label for="<?php 
        echo $this->get_field_id('nav_menu');
        ?>"><?php 
        _e('Select Menu:');
        ?></label>
				<select id="<?php 
        echo $this->get_field_id('nav_menu');
        ?>" name="<?php 
        echo $this->get_field_name('nav_menu');
        ?>">
					<option value="0"><?php 
        _e('&mdash; Select &mdash;');
        ?></option>
					<?php 
        foreach ($menus as $menu) {
            ?>
						<option value="<?php 
            echo esc_attr($menu->term_id);
            ?>" <?php 
            selected($nav_menu, $menu->term_id);
            ?>>
							<?php 
            echo esc_html($menu->name);
            ?>
						</option>
					<?php 
        }
        ?>
				</select>
			</p>
			<?php 
        if ($wp_customize instanceof WP_Customize_Manager) {
            ?>
				<p class="edit-selected-nav-menu" style="<?php 
            echo $nav_menu_style;
            ?>">
					<button type="button" class="button"><?php 
            _e('Edit Menu');
            ?></button>
				</p>
			<?php 
        }
        ?>
		</div>
		<?php 
    }
}