<?php

/**
 * Widget API: WP_Widget_Categories class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Categories widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Categories extends WP_Widget
{
    /**
     * Sets up a new Categories widget instance.
     *
     * @since 2.8.0
     */
    public function __construct()
    {
        $widget_ops = array('classname' => 'widget_categories', 'description' => __('A list or dropdown of categories.'), 'customize_selective_refresh' => true);
        parent::__construct('categories', __('Categories'), $widget_ops);
    }
    /**
     * Outputs the content for the current Categories widget instance.
     *
     * @since 2.8.0
     * @since 4.2.0 Creates a unique HTML ID for the `<select>` element
     *              if more than one instance is displayed on the page.
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Categories widget instance.
     */
    public function widget($args, $instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/widgets/class-wp-widget-categories.php at line 42")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called widget:42@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/widgets/class-wp-widget-categories.php');
        die();
    }
    /**
     * Handles updating settings for the current Categories widget instance.
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/widgets/class-wp-widget-categories.php at line 144")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:144@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/widgets/class-wp-widget-categories.php');
        die();
    }
    /**
     * Outputs the settings form for the Categories widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form($instance)
    {
        // Defaults.
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $count = isset($instance['count']) ? (bool) $instance['count'] : false;
        $hierarchical = isset($instance['hierarchical']) ? (bool) $instance['hierarchical'] : false;
        $dropdown = isset($instance['dropdown']) ? (bool) $instance['dropdown'] : false;
        ?>
		<p>
			<label for="<?php 
        echo $this->get_field_id('title');
        ?>"><?php 
        _e('Title:');
        ?></label>
			<input class="widefat" id="<?php 
        echo $this->get_field_id('title');
        ?>" name="<?php 
        echo $this->get_field_name('title');
        ?>" type="text" value="<?php 
        echo esc_attr($instance['title']);
        ?>" />
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php 
        echo $this->get_field_id('dropdown');
        ?>" name="<?php 
        echo $this->get_field_name('dropdown');
        ?>"<?php 
        checked($dropdown);
        ?> />
			<label for="<?php 
        echo $this->get_field_id('dropdown');
        ?>"><?php 
        _e('Display as dropdown');
        ?></label>
			<br />

			<input type="checkbox" class="checkbox" id="<?php 
        echo $this->get_field_id('count');
        ?>" name="<?php 
        echo $this->get_field_name('count');
        ?>"<?php 
        checked($count);
        ?> />
			<label for="<?php 
        echo $this->get_field_id('count');
        ?>"><?php 
        _e('Show post counts');
        ?></label>
			<br />

			<input type="checkbox" class="checkbox" id="<?php 
        echo $this->get_field_id('hierarchical');
        ?>" name="<?php 
        echo $this->get_field_name('hierarchical');
        ?>"<?php 
        checked($hierarchical);
        ?> />
			<label for="<?php 
        echo $this->get_field_id('hierarchical');
        ?>"><?php 
        _e('Show hierarchy');
        ?></label>
		</p>
		<?php 
    }
}