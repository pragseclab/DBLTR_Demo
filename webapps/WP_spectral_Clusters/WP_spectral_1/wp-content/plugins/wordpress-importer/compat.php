<?php

/**
 * Implementation for WordPress functions missing in older WordPress versions.
 *
 * @package WordPress
 * @subpackage Importer
 */
if (!function_exists('wp_slash_strings_only')) {
    /**
     * Adds slashes to only string values in an array of values.
     *
     * Compat for WordPress < 5.3.0.
     *
     * @since 0.7.0
     *
     * @param mixed $value Scalar or array of scalars.
     * @return mixed Slashes $value
     */
    function wp_slash_strings_only($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("wp_slash_strings_only") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/plugins/wordpress-importer/compat.php at line 22")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called wp_slash_strings_only:22@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/plugins/wordpress-importer/compat.php');
        die();
    }
}
if (!function_exists('addslashes_strings_only')) {
    /**
     * Adds slashes only if the provided value is a string.
     *
     * Compat for WordPress < 5.3.0.
     *
     * @since 0.7.0
     *
     * @param mixed $value
     * @return mixed
     */
    function addslashes_strings_only($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addslashes_strings_only") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/plugins/wordpress-importer/compat.php at line 38")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addslashes_strings_only:38@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/plugins/wordpress-importer/compat.php');
        die();
    }
}
if (!function_exists('map_deep')) {
    /**
     * Maps a function to all non-iterable elements of an array or an object.
     *
     * Compat for WordPress < 4.4.0.
     *
     * @since 0.7.0
     *
     * @param mixed    $value    The array, object, or scalar.
     * @param callable $callback The function to map onto $value.
     * @return mixed The value with the callback applied to all non-arrays and non-objects inside it.
     */
    function map_deep($value, $callback)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("map_deep") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/plugins/wordpress-importer/compat.php at line 55")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called map_deep:55@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-content/plugins/wordpress-importer/compat.php');
        die();
    }
}