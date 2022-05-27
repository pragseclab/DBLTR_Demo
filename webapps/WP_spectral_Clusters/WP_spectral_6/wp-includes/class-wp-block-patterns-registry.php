<?php

/**
 * Blocks API: WP_Block_Patterns_Registry class
 *
 * @package WordPress
 * @subpackage Blocks
 * @since 5.5.0
 */
/**
 * Class used for interacting with patterns.
 *
 * @since 5.5.0
 */
final class WP_Block_Patterns_Registry
{
    /**
     * Registered patterns array.
     *
     * @since 5.5.0
     * @var array
     */
    private $registered_patterns = array();
    /**
     * Container for the main instance of the class.
     *
     * @since 5.5.0
     * @var WP_Block_Patterns_Registry|null
     */
    private static $instance = null;
    /**
     * Registers a pattern.
     *
     * @since 5.5.0
     *
     * @param string $pattern_name       Pattern name including namespace.
     * @param array  $pattern_properties Array containing the properties of the pattern: title,
     *                                   content, description, viewportWidth, categories, keywords.
     * @return bool True if the pattern was registered with success and false otherwise.
     */
    public function register($pattern_name, $pattern_properties)
    {
        if (!isset($pattern_name) || !is_string($pattern_name)) {
            _doing_it_wrong(__METHOD__, __('Pattern name must be a string.'), '5.5.0');
            return false;
        }
        if (!isset($pattern_properties['title']) || !is_string($pattern_properties['title'])) {
            _doing_it_wrong(__METHOD__, __('Pattern title must be a string.'), '5.5.0');
            return false;
        }
        if (!isset($pattern_properties['content']) || !is_string($pattern_properties['content'])) {
            _doing_it_wrong(__METHOD__, __('Pattern content must be a string.'), '5.5.0');
            return false;
        }
        $this->registered_patterns[$pattern_name] = array_merge($pattern_properties, array('name' => $pattern_name));
        return true;
    }
    /**
     * Unregisters a pattern.
     *
     * @since 5.5.0
     *
     * @param string $pattern_name Pattern name including namespace.
     * @return bool True if the pattern was unregistered with success and false otherwise.
     */
    public function unregister($pattern_name)
    {
        if (!$this->is_registered($pattern_name)) {
            /* translators: %s: Pattern name. */
            $message = sprintf(__('Pattern "%s" not found.'), $pattern_name);
            _doing_it_wrong(__METHOD__, $message, '5.5.0');
            return false;
        }
        unset($this->registered_patterns[$pattern_name]);
        return true;
    }
    /**
     * Retrieves an array containing the properties of a registered pattern.
     *
     * @since 5.5.0
     *
     * @param string $pattern_name Pattern name including namespace.
     * @return array Registered pattern properties.
     */
    public function get_registered($pattern_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php at line 87")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_registered:87@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php');
        die();
    }
    /**
     * Retrieves all registered patterns.
     *
     * @since 5.5.0
     *
     * @return array Array of arrays containing the registered patterns properties,
     *               and per style.
     */
    public function get_all_registered()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_all_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php at line 102")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_all_registered:102@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php');
        die();
    }
    /**
     * Checks if a pattern is registered.
     *
     * @since 5.5.0
     *
     * @param string $pattern_name Pattern name including namespace.
     * @return bool True if the pattern is registered, false otherwise.
     */
    public function is_registered($pattern_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php at line 114")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_registered:114@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php');
        die();
    }
    /**
     * Utility method to retrieve the main instance of the class.
     *
     * The instance will be created if it does not exist yet.
     *
     * @since 5.5.0
     *
     * @return WP_Block_Patterns_Registry The main instance.
     */
    public static function get_instance()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_instance") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php at line 127")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_instance:127@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php');
        die();
    }
}
/**
 * Registers a new pattern.
 *
 * @since 5.5.0
 *
 * @param string $pattern_name       Pattern name including namespace.
 * @param array  $pattern_properties Array containing the properties of the pattern.
 * @return bool True if the pattern was registered with success and false otherwise.
 */
function register_block_pattern($pattern_name, $pattern_properties)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_block_pattern") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php at line 144")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called register_block_pattern:144@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-block-patterns-registry.php');
    die();
}
/**
 * Unregisters a pattern.
 *
 * @since 5.5.0
 *
 * @param string $pattern_name Pattern name including namespace.
 * @return bool True if the pattern was unregistered with success and false otherwise.
 */
function unregister_block_pattern($pattern_name)
{
    return WP_Block_Patterns_Registry::get_instance()->unregister($pattern_name);
}