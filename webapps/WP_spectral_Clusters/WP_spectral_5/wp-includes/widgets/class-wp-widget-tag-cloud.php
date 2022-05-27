<?php

/**
 * Widget API: WP_Widget_Tag_Cloud class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Tag cloud widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Tag_Cloud extends WP_Widget
{
    /**
     * Sets up a new Tag Cloud widget instance.
     *
     * @since 2.8.0
     */
    public function __construct()
    {
        $widget_ops = array('description' => __('A cloud of your most used tags.'), 'customize_selective_refresh' => true);
        parent::__construct('tag_cloud', __('Tag Cloud'), $widget_ops);
    }
    /**
     * Outputs the content for the current Tag Cloud widget instance.
     *
     * @since 2.8.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Tag Cloud widget instance.
     */
    public function widget($args, $instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("widget") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-tag-cloud.php at line 40")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called widget:40@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-tag-cloud.php');
        die();
    }
    /**
     * Handles updating settings for the current Tag Cloud widget instance.
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-tag-cloud.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:105@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-tag-cloud.php');
        die();
    }
    /**
     * Outputs the Tag Cloud widget settings form.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $count = isset($instance['count']) ? (bool) $instance['count'] : false;
        ?>
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
		<?php 
        $taxonomies = get_taxonomies(array('show_tagcloud' => true), 'object');
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        switch (count($taxonomies)) {
            // No tag cloud supporting taxonomies found, display error message.
            case 0:
                ?>
				<input type="hidden" id="<?php 
                echo $this->get_field_id('taxonomy');
                ?>" name="<?php 
                echo $this->get_field_name('taxonomy');
                ?>" value="" />
				<p>
					<?php 
                _e('The tag cloud will not be displayed since there are no taxonomies that support the tag cloud widget.');
                ?>
				</p>
				<?php 
                break;
            // Just a single tag cloud supporting taxonomy found, no need to display a select.
            case 1:
                $keys = array_keys($taxonomies);
                $taxonomy = reset($keys);
                ?>
				<input type="hidden" id="<?php 
                echo $this->get_field_id('taxonomy');
                ?>" name="<?php 
                echo $this->get_field_name('taxonomy');
                ?>" value="<?php 
                echo esc_attr($taxonomy);
                ?>" />
				<?php 
                break;
            // More than one tag cloud supporting taxonomy found, display a select.
            default:
                ?>
				<p>
					<label for="<?php 
                echo $this->get_field_id('taxonomy');
                ?>"><?php 
                _e('Taxonomy:');
                ?></label>
					<select class="widefat" id="<?php 
                echo $this->get_field_id('taxonomy');
                ?>" name="<?php 
                echo $this->get_field_name('taxonomy');
                ?>">
					<?php 
                foreach ($taxonomies as $taxonomy => $tax) {
                    ?>
						<option value="<?php 
                    echo esc_attr($taxonomy);
                    ?>" <?php 
                    selected($taxonomy, $current_taxonomy);
                    ?>>
							<?php 
                    echo esc_html($tax->labels->name);
                    ?>
						</option>
					<?php 
                }
                ?>
					</select>
				</p>
				<?php 
        }
        if (count($taxonomies) > 0) {
            ?>
			<p>
				<input type="checkbox" class="checkbox" id="<?php 
            echo $this->get_field_id('count');
            ?>" name="<?php 
            echo $this->get_field_name('count');
            ?>" <?php 
            checked($count, true);
            ?> />
				<label for="<?php 
            echo $this->get_field_id('count');
            ?>"><?php 
            _e('Show tag counts');
            ?></label>
			</p>
			<?php 
        }
    }
    /**
     * Retrieves the taxonomy for the current Tag cloud widget instance.
     *
     * @since 4.4.0
     *
     * @param array $instance Current settings.
     * @return string Name of the current taxonomy if set, otherwise 'post_tag'.
     */
    public function _get_current_taxonomy($instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_get_current_taxonomy") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-tag-cloud.php at line 232")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _get_current_taxonomy:232@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/widgets/class-wp-widget-tag-cloud.php');
        die();
    }
}