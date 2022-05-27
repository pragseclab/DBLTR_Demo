<?php

/**
 * Widget API: WP_Widget_RSS class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a RSS widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_RSS extends WP_Widget
{
    /**
     * Sets up a new RSS widget instance.
     *
     * @since 2.8.0
     */
    public function __construct()
    {
        $widget_ops = array('description' => __('Entries from any RSS or Atom feed.'), 'customize_selective_refresh' => true);
        $control_ops = array('width' => 400, 'height' => 200);
        parent::__construct('rss', __('RSS'), $widget_ops, $control_ops);
    }
    /**
     * Outputs the content for the current RSS widget instance.
     *
     * @since 2.8.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current RSS widget instance.
     */
    public function widget($args, $instance)
    {
        if (isset($instance['error']) && $instance['error']) {
            return;
        }
        $url = !empty($instance['url']) ? $instance['url'] : '';
        while (stristr($url, 'http') !== $url) {
            $url = substr($url, 1);
        }
        if (empty($url)) {
            return;
        }
        // Self-URL destruction sequence.
        if (in_array(untrailingslashit($url), array(site_url(), home_url()), true)) {
            return;
        }
        $rss = fetch_feed($url);
        $title = $instance['title'];
        $desc = '';
        $link = '';
        if (!is_wp_error($rss)) {
            $desc = esc_attr(strip_tags(html_entity_decode($rss->get_description(), ENT_QUOTES, get_option('blog_charset'))));
            if (empty($title)) {
                $title = strip_tags($rss->get_title());
            }
            $link = strip_tags($rss->get_permalink());
            while (stristr($link, 'http') !== $link) {
                $link = substr($link, 1);
            }
        }
        if (empty($title)) {
            $title = !empty($desc) ? $desc : __('Unknown Feed');
        }
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        $url = strip_tags($url);
        $icon = includes_url('images/rss.png');
        if ($title) {
            $title = '<a class="rsswidget" href="' . esc_url($url) . '"><img class="rss-widget-icon" style="border:0" width="14" height="14" src="' . esc_url($icon) . '" alt="RSS" /></a> <a class="rsswidget" href="' . esc_url($link) . '">' . esc_html($title) . '</a>';
        }
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
            $aria_label = $title ? $title : __('RSS Feed');
            echo '<nav role="navigation" aria-label="' . esc_attr($aria_label) . '">';
        }
        wp_widget_rss_output($rss, $instance);
        if ('html5' === $format) {
            echo '</nav>';
        }
        echo $args['after_widget'];
        if (!is_wp_error($rss)) {
            $rss->__destruct();
        }
        unset($rss);
    }
    /**
     * Handles updating settings for the current RSS widget instance.
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/widgets/class-wp-widget-rss.php at line 114")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:114@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/widgets/class-wp-widget-rss.php');
        die();
    }
    /**
     * Outputs the settings form for the RSS widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form($instance)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("form") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/widgets/class-wp-widget-rss.php at line 126")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called form:126@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/widgets/class-wp-widget-rss.php');
        die();
    }
}