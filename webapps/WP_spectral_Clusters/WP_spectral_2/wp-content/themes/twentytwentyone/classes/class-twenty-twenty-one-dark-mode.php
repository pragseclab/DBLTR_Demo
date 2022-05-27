<?php

/**
 * Dark Mode Class
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
/**
 * This class is in charge of Dark Mode.
 */
class Twenty_Twenty_One_Dark_Mode
{
    /**
     * Instantiate the object.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     */
    public function __construct()
    {
        // Enqueue assets for the block-editor.
        add_action('enqueue_block_editor_assets', array($this, 'editor_custom_color_variables'));
        // Add styles for dark-mode.
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        // Add scripts for customizer controls.
        add_action('customize_controls_enqueue_scripts', array($this, 'customize_controls_enqueue_scripts'));
        // Add customizer controls.
        add_action('customize_register', array($this, 'customizer_controls'));
        // Add HTML classes.
        add_filter('twentytwentyone_html_classes', array($this, 'html_classes'));
        // Add classes to <body> in the dashboard.
        add_filter('admin_body_class', array($this, 'admin_body_classes'));
        // Add the switch on the frontend & customizer.
        add_action('wp_footer', array($this, 'the_switch'));
        // Add the privacy policy content.
        add_action('admin_init', array($this, 'add_privacy_policy_content'));
    }
    /**
     * Editor custom color variables & scripts.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function editor_custom_color_variables()
    {
        if (!$this->switch_should_render()) {
            return;
        }
        $background_color = get_theme_mod('background_color', 'D1E4DD');
        $should_respect_color_scheme = get_theme_mod('respect_user_color_preference', false);
        if ($should_respect_color_scheme && Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex($background_color) > 127) {
            // Add Dark Mode variable overrides.
            wp_add_inline_style('twenty-twenty-one-custom-color-overrides', '.is-dark-theme.is-dark-theme .editor-styles-wrapper { --global--color-background: var(--global--color-dark-gray); --global--color-primary: var(--global--color-light-gray); --global--color-secondary: var(--global--color-light-gray); --button--color-text: var(--global--color-background); --button--color-text-hover: var(--global--color-secondary); --button--color-text-active: var(--global--color-secondary); --button--color-background: var(--global--color-secondary); --button--color-background-active: var(--global--color-background); --global--color-border: #9ea1a7; --table--stripes-border-color: rgba(240, 240, 240, 0.15); --table--stripes-background-color: rgba(240, 240, 240, 0.15); }');
        }
        wp_enqueue_script('twentytwentyone-dark-mode-support-toggle', get_template_directory_uri() . '/assets/js/dark-mode-toggler.js', array(), '1.0.0', true);
        wp_enqueue_script('twentytwentyone-editor-dark-mode-support', get_template_directory_uri() . '/assets/js/editor-dark-mode-support.js', array('twentytwentyone-dark-mode-support-toggle'), '1.0.0', true);
    }
    /**
     * Enqueue scripts and styles.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        if (!$this->switch_should_render()) {
            return;
        }
        $url = get_template_directory_uri() . '/assets/css/style-dark-mode.css';
        if (is_rtl()) {
            $url = get_template_directory_uri() . '/assets/css/style-dark-mode-rtl.css';
        }
        wp_enqueue_style('tt1-dark-mode', $url, array('twenty-twenty-one-style'), wp_get_theme()->get('Version'));
        // @phpstan-ignore-line. Version is always a string.
    }
    /**
     * Enqueue scripts for the customizer.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function customize_controls_enqueue_scripts()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("customize_controls_enqueue_scripts") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-dark-mode.php at line 96")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called customize_controls_enqueue_scripts:96@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-dark-mode.php');
        die();
    }
    /**
     * Register customizer options.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     *
     * @return void
     */
    public function customizer_controls($wp_customize)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("customizer_controls") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-dark-mode.php at line 114")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called customizer_controls:114@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-dark-mode.php');
        die();
    }
    /**
     * Calculate classes for the main <html> element.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string $classes The classes for <html> element.
     *
     * @return string
     */
    public function html_classes($classes)
    {
        if (!$this->switch_should_render()) {
            return $classes;
        }
        $background_color = get_theme_mod('background_color', 'D1E4DD');
        $should_respect_color_scheme = get_theme_mod('respect_user_color_preference', false);
        if ($should_respect_color_scheme && 127 <= Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex($background_color)) {
            return $classes ? ' respect-color-scheme-preference' : 'respect-color-scheme-preference';
        }
        return $classes;
    }
    /**
     * Adds a class to the <body> element in the editor to accommodate dark-mode.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string $classes The admin body-classes.
     *
     * @return string
     */
    public function admin_body_classes($classes)
    {
        if (!$this->switch_should_render()) {
            return $classes;
        }
        global $current_screen;
        if (empty($current_screen)) {
            set_current_screen();
        }
        if ($current_screen->is_block_editor()) {
            $should_respect_color_scheme = get_theme_mod('respect_user_color_preference', false);
            $background_color = get_theme_mod('background_color', 'D1E4DD');
            if ($should_respect_color_scheme && Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex($background_color) > 127) {
                $classes .= ' twentytwentyone-supports-dark-theme';
            }
        }
        return $classes;
    }
    /**
     * Determine if we want to print the dark-mode switch or not.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return bool
     */
    public function switch_should_render()
    {
        global $is_IE;
        return get_theme_mod('respect_user_color_preference', false) && !$is_IE && 127 <= Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex(get_theme_mod('background_color', 'D1E4DD'));
    }
    /**
     * Add night/day switch.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function the_switch()
    {
        if (!$this->switch_should_render()) {
            return;
        }
        $this->the_html();
        $this->the_script();
    }
    /**
     * Print the dark-mode switch HTML.
     *
     * Inspired from https://codepen.io/aaroniker/pen/KGpXZo (MIT-licensed)
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param array $attrs The attributes to add to our <button> element.
     *
     * @return void
     */
    public function the_html($attrs = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_html") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-dark-mode.php at line 243")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called the_html:243@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-dark-mode.php');
        die();
    }
    /**
     * Print the dark-mode switch script.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function the_script()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("the_script") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-dark-mode.php at line 304")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called the_script:304@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-dark-mode.php');
        die();
    }
    /**
     * Adds information to the privacy policy.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function add_privacy_policy_content()
    {
        if (!function_exists('wp_add_privacy_policy_content')) {
            return;
        }
        $content = '<p class="privacy-policy-tutorial">' . __('Twenty Twenty-One uses LocalStorage when Dark Mode support is enabled.', 'twentytwentyone') . '</p>' . '<strong class="privacy-policy-tutorial">' . __('Suggested text:', 'twentytwentyone') . '</strong> ' . __('This website uses LocalStorage to save the setting when Dark Mode support is turned on or off.<br> LocalStorage is necessary for the setting to work and is only used when a user clicks on the Dark Mode button.<br> No data is saved in the database or transferred.', 'twentytwentyone');
        wp_add_privacy_policy_content('Twenty Twenty-One', wp_kses_post(wpautop($content, false)));
    }
}