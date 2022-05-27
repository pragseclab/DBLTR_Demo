<?php

/**
 * Blocks API: WP_Block_Styles_Registry class
 *
 * @package WordPress
 * @subpackage Blocks
 * @since 5.3.0
 */
/**
 * Class used for interacting with block styles.
 *
 * @since 5.3.0
 */
final class WP_Block_Styles_Registry
{
    /**
     * Registered block styles, as `$block_name => $block_style_name => $block_style_properties` multidimensional arrays.
     *
     * @since 5.3.0
     * @var array
     */
    private $registered_block_styles = array();
    /**
     * Container for the main instance of the class.
     *
     * @since 5.3.0
     * @var WP_Block_Styles_Registry|null
     */
    private static $instance = null;
    /**
     * Registers a block style.
     *
     * @since 5.3.0
     *
     * @param string $block_name       Block type name including namespace.
     * @param array  $style_properties Array containing the properties of the style name, label,
     *                                 is_default, style_handle (name of the stylesheet to be enqueued),
     *                                 inline_style (string containing the CSS to be added).
     * @return bool True if the block style was registered with success and false otherwise.
     */
    public function register($block_name, $style_properties)
    {
        if (!isset($block_name) || !is_string($block_name)) {
            $message = __('Block name must be a string.');
            _doing_it_wrong(__METHOD__, $message, '5.3.0');
            return false;
        }
        if (!isset($style_properties['name']) || !is_string($style_properties['name'])) {
            $message = __('Block style name must be a string.');
            _doing_it_wrong(__METHOD__, $message, '5.3.0');
            return false;
        }
        $block_style_name = $style_properties['name'];
        if (!isset($this->registered_block_styles[$block_name])) {
            $this->registered_block_styles[$block_name] = array();
        }
        $this->registered_block_styles[$block_name][$block_style_name] = $style_properties;
        return true;
    }
    /**
     * Unregisters a block style.
     *
     * @param string $block_name       Block type name including namespace.
     * @param string $block_style_name Block style name.
     * @return bool True if the block style was unregistered with success and false otherwise.
     */
    public function unregister($block_name, $block_style_name)
    {
        if (!$this->is_registered($block_name, $block_style_name)) {
            /* translators: 1: Block name, 2: Block style name. */
            $message = sprintf(__('Block "%1$s" does not contain a style named "%2$s".'), $block_name, $block_style_name);
            _doing_it_wrong(__METHOD__, $message, '5.3.0');
            return false;
        }
        unset($this->registered_block_styles[$block_name][$block_style_name]);
        return true;
    }
    /**
     * Retrieves an array containing the properties of a registered block style.
     *
     * @since 5.3.0
     *
     * @param string $block_name       Block type name including namespace.
     * @param string $block_style_name Block style name.
     * @return array Registered block style properties.
     */
    public function get_registered($block_name, $block_style_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php at line 90")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_registered:90@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php');
        die();
    }
    /**
     * Retrieves all registered block styles.
     *
     * @since 5.3.0
     *
     * @return array Array of arrays containing the registered block styles properties grouped per block,
     *               and per style.
     */
    public function get_all_registered()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_all_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_all_registered:105@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php');
        die();
    }
    /**
     * Retrieves registered block styles for a specific block.
     *
     * @since 5.3.0
     *
     * @param string $block_name Block type name including namespace.
     * @return array Array whose keys are block style names and whose value are block style properties.
     */
    public function get_registered_styles_for_block($block_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_registered_styles_for_block") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php at line 117")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_registered_styles_for_block:117@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php');
        die();
    }
    /**
     * Checks if a block style is registered.
     *
     * @since 5.3.0
     *
     * @param string $block_name       Block type name including namespace.
     * @param string $block_style_name Block style name.
     * @return bool True if the block style is registered, false otherwise.
     */
    public function is_registered($block_name, $block_style_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php at line 133")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_registered:133@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php');
        die();
    }
    /**
     * Utility method to retrieve the main instance of the class.
     *
     * The instance will be created if it does not exist yet.
     *
     * @since 5.3.0
     *
     * @return WP_Block_Styles_Registry The main instance.
     */
    public static function get_instance()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_instance") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php at line 146")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_instance:146@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-styles-registry.php');
        die();
    }
}