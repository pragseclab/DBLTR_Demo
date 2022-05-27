<?php

/**
 * Customize API: WP_Customize_Custom_CSS_Setting class
 *
 * This handles validation, sanitization and saving of the value.
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.7.0
 */
/**
 * Custom Setting to handle WP Custom CSS.
 *
 * @since 4.7.0
 *
 * @see WP_Customize_Setting
 */
final class WP_Customize_Custom_CSS_Setting extends WP_Customize_Setting
{
    /**
     * The setting type.
     *
     * @since 4.7.0
     * @var string
     */
    public $type = 'custom_css';
    /**
     * Setting Transport
     *
     * @since 4.7.0
     * @var string
     */
    public $transport = 'postMessage';
    /**
     * Capability required to edit this setting.
     *
     * @since 4.7.0
     * @var string
     */
    public $capability = 'edit_css';
    /**
     * Stylesheet
     *
     * @since 4.7.0
     * @var string
     */
    public $stylesheet = '';
    /**
     * WP_Customize_Custom_CSS_Setting constructor.
     *
     * @since 4.7.0
     *
     * @throws Exception If the setting ID does not match the pattern `custom_css[$stylesheet]`.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      A specific ID of the setting.
     *                                      Can be a theme mod or option name.
     * @param array                $args    Setting arguments.
     */
    public function __construct($manager, $id, $args = array())
    {
        parent::__construct($manager, $id, $args);
        if ('custom_css' !== $this->id_data['base']) {
            throw new Exception('Expected custom_css id_base.');
        }
        if (1 !== count($this->id_data['keys']) || empty($this->id_data['keys'][0])) {
            throw new Exception('Expected single stylesheet key.');
        }
        $this->stylesheet = $this->id_data['keys'][0];
    }
    /**
     * Add filter to preview post value.
     *
     * @since 4.7.9
     *
     * @return bool False when preview short-circuits due no change needing to be previewed.
     */
    public function preview()
    {
        if ($this->is_previewed) {
            return false;
        }
        $this->is_previewed = true;
        add_filter('wp_get_custom_css', array($this, 'filter_previewed_wp_get_custom_css'), 9, 2);
        return true;
    }
    /**
     * Filters `wp_get_custom_css` for applying the customized value.
     *
     * This is used in the preview when `wp_get_custom_css()` is called for rendering the styles.
     *
     * @since 4.7.0
     *
     * @see wp_get_custom_css()
     *
     * @param string $css        Original CSS.
     * @param string $stylesheet Current stylesheet.
     * @return string CSS.
     */
    public function filter_previewed_wp_get_custom_css($css, $stylesheet)
    {
        if ($stylesheet === $this->stylesheet) {
            $customized_value = $this->post_value(null);
            if (!is_null($customized_value)) {
                $css = $customized_value;
            }
        }
        return $css;
    }
    /**
     * Fetch the value of the setting. Will return the previewed value when `preview()` is called.
     *
     * @since 4.7.0
     *
     * @see WP_Customize_Setting::value()
     *
     * @return string
     */
    public function value()
    {
        if ($this->is_previewed) {
            $post_value = $this->post_value(null);
            if (null !== $post_value) {
                return $post_value;
            }
        }
        $id_base = $this->id_data['base'];
        $value = '';
        $post = wp_get_custom_css_post($this->stylesheet);
        if ($post) {
            $value = $post->post_content;
        }
        if (empty($value)) {
            $value = $this->default;
        }
        /** This filter is documented in wp-includes/class-wp-customize-setting.php */
        $value = apply_filters("customize_value_{$id_base}", $value, $this);
        return $value;
    }
    /**
     * Validate CSS.
     *
     * Checks for imbalanced braces, brackets, and comments.
     * Notifications are rendered when the customizer state is saved.
     *
     * @since 4.7.0
     * @since 4.9.0 Checking for balanced characters has been moved client-side via linting in code editor.
     *
     * @param string $css The input string.
     * @return true|WP_Error True if the input was validated, otherwise WP_Error.
     */
    public function validate($css)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validate") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-custom-css-setting.php at line 155")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validate:155@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-custom-css-setting.php');
        die();
    }
    /**
     * Store the CSS setting value in the custom_css custom post type for the stylesheet.
     *
     * @since 4.7.0
     *
     * @param string $css The input value.
     * @return int|false The post ID or false if the value could not be saved.
     */
    public function update($css)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-custom-css-setting.php at line 174")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update:174@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/customize/class-wp-customize-custom-css-setting.php');
        die();
    }
}