<?php

/**
 * Widget API: WP_Widget_Recent_Comments class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Recent Comments widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Recent_Comments extends WP_Widget
{
    /**
     * Sets up a new Recent Comments widget instance.
     *
     * @since 2.8.0
     */
    public function __construct()
    {
        $widget_ops = array('classname' => 'widget_recent_comments', 'description' => __('Your site&#8217;s most recent comments.'), 'customize_selective_refresh' => true);
        parent::__construct('recent-comments', __('Recent Comments'), $widget_ops);
        $this->alt_option_name = 'widget_recent_comments';
        if (is_active_widget(false, false, $this->id_base) || is_customize_preview()) {
            add_action('wp_head', array($this, 'recent_comments_style'));
        }
    }
    /**
     * Outputs the default styles for the Recent Comments widget.
     *
     * @since 2.8.0
     */
    public function recent_comments_style()
    {
        /**
         * Filters the Recent Comments default widget styles.
         *
         * @since 3.1.0
         *
         * @param bool   $active  Whether the widget is active. Default true.
         * @param string $id_base The widget ID.
         */
        if (!current_theme_supports('widgets') || !apply_filters('show_recent_comments_widget_style', true, $this->id_base)) {
            return;
        }
        $type_attr = current_theme_supports('html5', 'style') ? '' : ' type="text/css"';
        printf('<style%s>.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>', $type_attr);
    }
    /**
     * Outputs the content for the current Recent Comments widget instance.
     *
     * @since 2.8.0
     * @since 5.4.0 Creates a unique HTML ID for the `<ul>` element
     *              if more than one instance is displayed on the page.
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Comments widget instance.
     */
    public function widget($args, $instance)
    {
        static $first_instance = true;
        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }
        $output = '';
        $default_title = __('Recent Comments');
        $title = !empty($instance['title']) ? $instance['title'] : $default_title;
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        if (!$number) {
            $number = 5;
        }
        $comments = get_comments(
            /**
             * Filters the arguments for the Recent Comments widget.
             *
             * @since 3.4.0
             * @since 4.9.0 Added the `$instance` parameter.
             *
             * @see WP_Comment_Query::query() for information on accepted arguments.
             *
             * @param array $comment_args An array of arguments used to retrieve the recent comments.
             * @param array $instance     Array of settings for the current widget.
             */
            apply_filters('widget_comments_args', array('number' => $number, 'status' => 'approve', 'post_status' => 'publish'), $instance)
        );
        $output .= $args['before_widget'];
        if ($title) {
            $output .= $args['before_title'] . $title . $args['after_title'];
        }
        $recent_comments_id = $first_instance ? 'recentcomments' : "recentcomments-{$this->number}";
        $first_instance = false;
        $format = current_theme_supports('html5', 'navigation-widgets') ? 'html5' : 'xhtml';
        /** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
        $format = apply_filters('navigation_widgets_format', $format);
        if ('html5' === $format) {
            // The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
            $title = trim(strip_tags($title));
            $aria_label = $title ? $title : $default_title;
            $output .= '<nav role="navigation" aria-label="' . esc_attr($aria_label) . '">';
        }
        $output .= '<ul id="' . esc_attr($recent_comments_id) . '">';
        if (is_array($comments) && $comments) {
            // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
            $post_ids = array_unique(wp_list_pluck($comments, 'comment_post_ID'));
            _prime_post_caches($post_ids, strpos(get_option('permalink_structure'), '%category%'), false);
            foreach ((array) $comments as $comment) {
                $output .= '<li class="recentcomments">';
                $output .= sprintf(
                    /* translators: Comments widget. 1: Comment author, 2: Post link. */
                    _x('%1$s on %2$s', 'widgets'),
                    '<span class="comment-author-link">' . get_comment_author_link($comment) . '</span>',
                    '<a href="' . esc_url(get_comment_link($comment)) . '">' . get_the_title($comment->comment_post_ID) . '</a>'
                );
                $output .= '</li>';
            }
        }
        $output .= '</ul>';
        if ('html5' === $format) {
            $output .= '</nav>';
        }
        $output .= $args['after_widget'];
        echo $output;
    }
    /**
     * Handles updating settings for the current Recent Comments widget instance.
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets/class-wp-widget-recent-comments.php at line 144")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:144@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets/class-wp-widget-recent-comments.php');
        die();
    }
    /**
     * Outputs the settings form for the Recent Comments widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form($instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("form") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets/class-wp-widget-recent-comments.php at line 158")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called form:158@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets/class-wp-widget-recent-comments.php');
        die();
    }
    /**
     * Flushes the Recent Comments widget cache.
     *
     * @since 2.8.0
     *
     * @deprecated 4.4.0 Fragment caching was removed in favor of split queries.
     */
    public function flush_widget_cache()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("flush_widget_cache") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets/class-wp-widget-recent-comments.php at line 201")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called flush_widget_cache:201@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/widgets/class-wp-widget-recent-comments.php');
        die();
    }
}