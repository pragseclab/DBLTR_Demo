<?php

/**
 * Error Protection API: WP_Paused_Extensions_Storage class
 *
 * @package WordPress
 * @since 5.2.0
 */
/**
 * Core class used for storing paused extensions.
 *
 * @since 5.2.0
 */
class WP_Paused_Extensions_Storage
{
    /**
     * Type of extension. Used to key extension storage.
     *
     * @since 5.2.0
     * @var string
     */
    protected $type;
    /**
     * Constructor.
     *
     * @since 5.2.0
     *
     * @param string $extension_type Extension type. Either 'plugin' or 'theme'.
     */
    public function __construct($extension_type)
    {
        $this->type = $extension_type;
    }
    /**
     * Records an extension error.
     *
     * Only one error is stored per extension, with subsequent errors for the same extension overriding the
     * previously stored error.
     *
     * @since 5.2.0
     *
     * @param string $extension Plugin or theme directory name.
     * @param array  $error     {
     *     Error that was triggered.
     *
     *     @type string $type    The error type.
     *     @type string $file    The name of the file in which the error occurred.
     *     @type string $line    The line number in which the error occurred.
     *     @type string $message The error message.
     * }
     * @return bool True on success, false on failure.
     */
    public function set($extension, $error)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php at line 55")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set:55@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php');
        die();
    }
    /**
     * Forgets a previously recorded extension error.
     *
     * @since 5.2.0
     *
     * @param string $extension Plugin or theme directory name.
     * @return bool True on success, false on failure.
     */
    public function delete($extension)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php at line 80")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete:80@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php');
        die();
    }
    /**
     * Gets the error for an extension, if paused.
     *
     * @since 5.2.0
     *
     * @param string $extension Plugin or theme directory name.
     * @return array|null Error that is stored, or null if the extension is not paused.
     */
    public function get($extension)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php at line 112")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get:112@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php');
        die();
    }
    /**
     * Gets the paused extensions with their errors.
     *
     * @since 5.2.0
     *
     * @return array Associative array of extension slugs to the error recorded.
     */
    public function get_all()
    {
        if (!$this->is_api_loaded()) {
            return array();
        }
        $option_name = $this->get_option_name();
        if (!$option_name) {
            return array();
        }
        $paused_extensions = (array) get_option($option_name, array());
        return isset($paused_extensions[$this->type]) ? $paused_extensions[$this->type] : array();
    }
    /**
     * Remove all paused extensions.
     *
     * @since 5.2.0
     *
     * @return bool
     */
    public function delete_all()
    {
        if (!$this->is_api_loaded()) {
            return false;
        }
        $option_name = $this->get_option_name();
        if (!$option_name) {
            return false;
        }
        $paused_extensions = (array) get_option($option_name, array());
        unset($paused_extensions[$this->type]);
        if (!$paused_extensions) {
            return delete_option($option_name);
        }
        return update_option($option_name, $paused_extensions);
    }
    /**
     * Checks whether the underlying API to store paused extensions is loaded.
     *
     * @since 5.2.0
     *
     * @return bool True if the API is loaded, false otherwise.
     */
    protected function is_api_loaded()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_api_loaded") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php at line 172")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_api_loaded:172@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php');
        die();
    }
    /**
     * Get the option name for storing paused extensions.
     *
     * @since 5.2.0
     *
     * @return string
     */
    protected function get_option_name()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_option_name") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php at line 183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_option_name:183@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-paused-extensions-storage.php');
        die();
    }
}