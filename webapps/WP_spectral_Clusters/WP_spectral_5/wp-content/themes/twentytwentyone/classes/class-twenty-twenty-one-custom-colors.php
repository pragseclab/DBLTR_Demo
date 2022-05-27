<?php

/**
 * Custom Colors Class
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
/**
 * This class is in charge of color customization via the Customizer.
 */
class Twenty_Twenty_One_Custom_Colors
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
        // Enqueue color variables for customizer & frontend.
        add_action('wp_enqueue_scripts', array($this, 'custom_color_variables'));
        // Enqueue color variables for editor.
        add_action('enqueue_block_editor_assets', array($this, 'editor_custom_color_variables'));
        // Add body-class if needed.
        add_filter('body_class', array($this, 'body_class'));
    }
    /**
     * Determine the luminance of the given color and then return #fff or #000 so that the text is always readable.
     *
     * @access public
     *
     * @param string $background_color The background color.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return string (hex color)
     */
    public function custom_get_readable_color($background_color)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("custom_get_readable_color") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-custom-colors.php at line 44")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called custom_get_readable_color:44@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-custom-colors.php');
        die();
    }
    /**
     * Generate color variables.
     *
     * Adjust the color value of the CSS variables depending on the background color theme mod.
     * Both text and link colors needs to be updated.
     * The code below needs to be updated, because the colors are no longer theme mods.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string|null $context Can be "editor" or null.
     *
     * @return string
     */
    public function generate_custom_color_variables($context = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("generate_custom_color_variables") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-custom-colors.php at line 63")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called generate_custom_color_variables:63@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-custom-colors.php');
        die();
    }
    /**
     * Customizer & frontend custom color variables.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function custom_color_variables()
    {
        if ('d1e4dd' !== strtolower(get_theme_mod('background_color', 'D1E4DD'))) {
            wp_add_inline_style('twenty-twenty-one-style', $this->generate_custom_color_variables());
        }
    }
    /**
     * Editor custom color variables.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function editor_custom_color_variables()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("editor_custom_color_variables") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-custom-colors.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called editor_custom_color_variables:105@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-custom-colors.php');
        die();
    }
    /**
     * Get luminance from a HEX color.
     *
     * @static
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string $hex The HEX color.
     *
     * @return int Returns a number (0-255).
     */
    public static function get_relative_luminance_from_hex($hex)
    {
        // Remove the "#" symbol from the beginning of the color.
        $hex = ltrim($hex, '#');
        // Make sure there are 6 digits for the below calculations.
        if (3 === strlen($hex)) {
            $hex = substr($hex, 0, 1) . substr($hex, 0, 1) . substr($hex, 1, 1) . substr($hex, 1, 1) . substr($hex, 2, 1) . substr($hex, 2, 1);
        }
        // Get red, green, blue.
        $red = hexdec(substr($hex, 0, 2));
        $green = hexdec(substr($hex, 2, 2));
        $blue = hexdec(substr($hex, 4, 2));
        // Calculate the luminance.
        $lum = 0.2126 * $red + 0.7151999999999999 * $green + 0.0722 * $blue;
        return (int) round($lum);
    }
    /**
     * Adds a class to <body> if the background-color is dark.
     *
     * @access public
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param array $classes The existing body classes.
     *
     * @return array
     */
    public function body_class($classes)
    {
        $background_color = get_theme_mod('background_color', 'D1E4DD');
        $luminance = self::get_relative_luminance_from_hex($background_color);
        if (127 > $luminance) {
            $classes[] = 'is-dark-theme';
        } else {
            $classes[] = 'is-light-theme';
        }
        if (225 <= $luminance) {
            $classes[] = 'has-background-white';
        }
        return $classes;
    }
}