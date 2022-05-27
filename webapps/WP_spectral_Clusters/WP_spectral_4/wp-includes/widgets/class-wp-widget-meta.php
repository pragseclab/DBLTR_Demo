<?php

/**
 * Widget API: WP_Widget_Meta class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Meta widget.
 *
 * Displays log in/out, RSS feed links, etc.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Meta extends WP_Widget
{
    /**
     * Sets up a new Meta widget instance.
     *
     * @since 2.8.0
     */
    public function __construct()
    {
        $widget_ops = array('classname' => 'widget_meta', 'description' => __('Login, RSS, &amp; WordPress.org links.'), 'customize_selective_refresh' => true);
        parent::__construct('meta', __('Meta'), $widget_ops);
    }
    /**
     * Outputs the content for the current Meta widget instance.
     *
     * @since 2.8.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Meta widget instance.
     */
    public function widget($args, $instance)
    {
        $default_title = __('Meta');
        $title = !empty($instance['title']) ? $instance['title'] : $default_title;
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        echo $args['before_widget'];
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        $format = current_theme_supports('html5', 'navigation-widgets') ? 'html5' : 'xhtml';
        /** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
        $format = apply_filters('navigation_widgets_format', $format);
        if ('html5' === $format) {
            // The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
            $title = trim(strip_tags($title));
            $aria_label = $title ? $title : $default_title;
            echo '<nav role="navigation" aria-label="' . esc_attr($aria_label) . '">';
        }
        ?>

		<ul>
			<?php 
        wp_register();
        ?>
			<li><?php 
        wp_loginout();
        ?></li>
			<li><a href="<?php 
        echo esc_url(get_bloginfo('rss2_url'));
        ?>"><?php 
        _e('Entries feed');
        ?></a></li>
			<li><a href="<?php 
        echo esc_url(get_bloginfo('comments_rss2_url'));
        ?>"><?php 
        _e('Comments feed');
        ?></a></li>

			<?php 
        /**
         * Filters the "WordPress.org" list item HTML in the Meta widget.
         *
         * @since 3.6.0
         * @since 4.9.0 Added the `$instance` parameter.
         *
         * @param string $html     Default HTML for the WordPress.org list item.
         * @param array  $instance Array of settings for the current widget.
         */
        echo apply_filters('widget_meta_poweredby', sprintf('<li><a href="%1$s">%2$s</a></li>', esc_url(__('https://wordpress.org/')), __('WordPress.org')), $instance);
        wp_meta();
        ?>

		</ul>

		<?php 
        if ('html5' === $format) {
            echo '</nav>';
        }
        echo $args['after_widget'];
    }
    /**
     * Handles updating settings for the current Meta widget instance.
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-meta.php at line 113")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:113@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-meta.php');
        die();
    }
    /**
     * Outputs the settings form for the Meta widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form($instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("form") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-meta.php at line 126")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called form:126@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/widgets/class-wp-widget-meta.php');
        die();
    }
}