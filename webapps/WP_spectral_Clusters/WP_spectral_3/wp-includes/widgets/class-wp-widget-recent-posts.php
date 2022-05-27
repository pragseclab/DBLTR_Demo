<?php

/**
 * Widget API: WP_Widget_Recent_Posts class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Recent_Posts extends WP_Widget
{
    /**
     * Sets up a new Recent Posts widget instance.
     *
     * @since 2.8.0
     */
    public function __construct()
    {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __('Your site&#8217;s most recent Posts.'), 'customize_selective_refresh' => true);
        parent::__construct('recent-posts', __('Recent Posts'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';
    }
    /**
     * Outputs the content for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Posts widget instance.
     */
    public function widget($args, $instance)
    {
        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }
        $default_title = __('Recent Posts');
        $title = !empty($instance['title']) ? $instance['title'] : $default_title;
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        if (!$number) {
            $number = 5;
        }
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
        $r = new WP_Query(
            /**
             * Filters the arguments for the Recent Posts widget.
             *
             * @since 3.4.0
             * @since 4.9.0 Added the `$instance` parameter.
             *
             * @see WP_Query::get_posts()
             *
             * @param array $args     An array of arguments used to retrieve the recent posts.
             * @param array $instance Array of settings for the current widget.
             */
            apply_filters('widget_posts_args', array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true), $instance)
        );
        if (!$r->have_posts()) {
            return;
        }
        ?>

		<?php 
        echo $args['before_widget'];
        ?>

		<?php 
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
        foreach ($r->posts as $recent_post) {
            ?>
				<?php 
            $post_title = get_the_title($recent_post->ID);
            $title = !empty($post_title) ? $post_title : __('(no title)');
            $aria_current = '';
            if (get_queried_object_id() === $recent_post->ID) {
                $aria_current = ' aria-current="page"';
            }
            ?>
				<li>
					<a href="<?php 
            the_permalink($recent_post->ID);
            ?>"<?php 
            echo $aria_current;
            ?>><?php 
            echo $title;
            ?></a>
					<?php 
            if ($show_date) {
                ?>
						<span class="post-date"><?php 
                echo get_the_date('', $recent_post->ID);
                ?></span>
					<?php 
            }
            ?>
				</li>
			<?php 
        }
        ?>
		</ul>

		<?php 
        if ('html5' === $format) {
            echo '</nav>';
        }
        echo $args['after_widget'];
    }
    /**
     * Handles updating the settings for the current Recent Posts widget instance.
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-recent-posts.php at line 144")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:144@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/widgets/class-wp-widget-recent-posts.php');
        die();
    }
    /**
     * Outputs the settings form for the Recent Posts widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form($instance)
    {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
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
        echo $title;
        ?>" />
		</p>

		<p>
			<label for="<?php 
        echo $this->get_field_id('number');
        ?>"><?php 
        _e('Number of posts to show:');
        ?></label>
			<input class="tiny-text" id="<?php 
        echo $this->get_field_id('number');
        ?>" name="<?php 
        echo $this->get_field_name('number');
        ?>" type="number" step="1" min="1" value="<?php 
        echo $number;
        ?>" size="3" />
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php 
        checked($show_date);
        ?> id="<?php 
        echo $this->get_field_id('show_date');
        ?>" name="<?php 
        echo $this->get_field_name('show_date');
        ?>" />
			<label for="<?php 
        echo $this->get_field_id('show_date');
        ?>"><?php 
        _e('Display post date?');
        ?></label>
		</p>
		<?php 
    }
}