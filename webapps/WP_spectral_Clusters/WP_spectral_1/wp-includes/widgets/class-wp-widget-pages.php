<?php

/**
 * Widget API: WP_Widget_Pages class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Pages widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Pages extends WP_Widget
{
    /**
     * Sets up a new Pages widget instance.
     *
     * @since 2.8.0
     */
    public function __construct()
    {
        $widget_ops = array('classname' => 'widget_pages', 'description' => __('A list of your site&#8217;s Pages.'), 'customize_selective_refresh' => true);
        parent::__construct('pages', __('Pages'), $widget_ops);
    }
    /**
     * Outputs the content for the current Pages widget instance.
     *
     * @since 2.8.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Pages widget instance.
     */
    public function widget($args, $instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-pages.php at line 40")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called widget:40@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-pages.php');
        die();
    }
    /**
     * Handles updating settings for the current Pages widget instance.
     *
     * @since 2.8.0
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update($new_instance, $old_instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-pages.php at line 112")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:112@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/widgets/class-wp-widget-pages.php');
        die();
    }
    /**
     * Outputs the settings form for the Pages widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form($instance)
    {
        // Defaults.
        $instance = wp_parse_args((array) $instance, array('sortby' => 'post_title', 'title' => '', 'exclude' => ''));
        ?>
		<p>
			<label for="<?php 
        echo esc_attr($this->get_field_id('title'));
        ?>"><?php 
        _e('Title:');
        ?></label>
			<input class="widefat" id="<?php 
        echo esc_attr($this->get_field_id('title'));
        ?>" name="<?php 
        echo esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php 
        echo esc_attr($instance['title']);
        ?>" />
		</p>

		<p>
			<label for="<?php 
        echo esc_attr($this->get_field_id('sortby'));
        ?>"><?php 
        _e('Sort by:');
        ?></label>
			<select name="<?php 
        echo esc_attr($this->get_field_name('sortby'));
        ?>" id="<?php 
        echo esc_attr($this->get_field_id('sortby'));
        ?>" class="widefat">
				<option value="post_title"<?php 
        selected($instance['sortby'], 'post_title');
        ?>><?php 
        _e('Page title');
        ?></option>
				<option value="menu_order"<?php 
        selected($instance['sortby'], 'menu_order');
        ?>><?php 
        _e('Page order');
        ?></option>
				<option value="ID"<?php 
        selected($instance['sortby'], 'ID');
        ?>><?php 
        _e('Page ID');
        ?></option>
			</select>
		</p>

		<p>
			<label for="<?php 
        echo esc_attr($this->get_field_id('exclude'));
        ?>"><?php 
        _e('Exclude:');
        ?></label>
			<input type="text" value="<?php 
        echo esc_attr($instance['exclude']);
        ?>" name="<?php 
        echo esc_attr($this->get_field_name('exclude'));
        ?>" id="<?php 
        echo esc_attr($this->get_field_id('exclude'));
        ?>" class="widefat" />
			<br />
			<small><?php 
        _e('Page IDs, separated by commas.');
        ?></small>
		</p>
		<?php 
    }
}