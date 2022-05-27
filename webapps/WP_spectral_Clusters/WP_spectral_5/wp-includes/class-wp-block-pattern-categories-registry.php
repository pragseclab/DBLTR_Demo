<?php

/**
 * Blocks API: WP_Block_Pattern_Categories_Registry class
 *
 * @package WordPress
 * @subpackage Blocks
 * @since 5.5.0
 */
/**
 * Class used for interacting with block pattern categories.
 */
final class WP_Block_Pattern_Categories_Registry
{
    /**
     * Registered block pattern categories array.
     *
     * @since 5.5.0
     * @var array
     */
    private $registered_categories = array();
    /**
     * Container for the main instance of the class.
     *
     * @since 5.5.0
     * @var WP_Block_Pattern_Categories_Registry|null
     */
    private static $instance = null;
    /**
     * Registers a pattern category.
     *
     * @since 5.5.0
     *
     * @param string $category_name       Pattern category name including namespace.
     * @param array  $category_properties Array containing the properties of the category: label.
     * @return bool True if the pattern was registered with success and false otherwise.
     */
    public function register($category_name, $category_properties)
    {
        if (!isset($category_name) || !is_string($category_name)) {
            _doing_it_wrong(__METHOD__, __('Block pattern category name must be a string.'), '5.5.0');
            return false;
        }
        $this->registered_categories[$category_name] = array_merge(array('name' => $category_name), $category_properties);
        return true;
    }
    /**
     * Unregisters a pattern category.
     *
     * @since 5.5.0
     *
     * @param string $category_name Pattern category name including namespace.
     * @return bool True if the pattern was unregistered with success and false otherwise.
     */
    public function unregister($category_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unregister") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php at line 57")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called unregister:57@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php');
        die();
    }
    /**
     * Retrieves an array containing the properties of a registered pattern category.
     *
     * @since 5.5.0
     *
     * @param string $category_name Pattern category name including namespace.
     * @return array Registered pattern properties.
     */
    public function get_registered($category_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php at line 76")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_registered:76@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php');
        die();
    }
    /**
     * Retrieves all registered pattern categories.
     *
     * @since 5.5.0
     *
     * @return array Array of arrays containing the registered pattern categories properties.
     */
    public function get_all_registered()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_all_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php at line 90")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_all_registered:90@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php');
        die();
    }
    /**
     * Checks if a pattern category is registered.
     *
     * @since 5.5.0
     *
     * @param string $category_name Pattern category name including namespace.
     * @return bool True if the pattern category is registered, false otherwise.
     */
    public function is_registered($category_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php at line 102")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_registered:102@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php');
        die();
    }
    /**
     * Utility method to retrieve the main instance of the class.
     *
     * The instance will be created if it does not exist yet.
     *
     * @since 5.5.0
     *
     * @return WP_Block_Pattern_Categories_Registry The main instance.
     */
    public static function get_instance()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_instance") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php at line 115")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_instance:115@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php');
        die();
    }
}
/**
 * Registers a new pattern category.
 *
 * @since 5.5.0
 *
 * @param string $category_name       Pattern category name including namespace.
 * @param array  $category_properties Array containing the properties of the category.
 * @return bool True if the pattern category was registered with success and false otherwise.
 */
function register_block_pattern_category($category_name, $category_properties)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_block_pattern_category") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php at line 132")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called register_block_pattern_category:132@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php');
    die();
}
/**
 * Unregisters a pattern category.
 *
 * @since 5.5.0
 *
 * @param string $category_name Pattern category name including namespace.
 * @return bool True if the pattern category was unregistered with success and false otherwise.
 */
function unregister_block_pattern_category($category_name)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unregister_block_pattern_category") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php at line 144")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called unregister_block_pattern_category:144@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-block-pattern-categories-registry.php');
    die();
}