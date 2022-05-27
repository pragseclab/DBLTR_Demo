<?php

/**
 * Upgrader API: WP_Ajax_Upgrader_Skin class
 *
 * @package WordPress
 * @subpackage Upgrader
 * @since 4.6.0
 */
/**
 * Upgrader Skin for Ajax WordPress upgrades.
 *
 * This skin is designed to be used for Ajax updates.
 *
 * @since 4.6.0
 *
 * @see Automatic_Upgrader_Skin
 */
class WP_Ajax_Upgrader_Skin extends Automatic_Upgrader_Skin
{
    /**
     * Holds the WP_Error object.
     *
     * @since 4.6.0
     *
     * @var null|WP_Error
     */
    protected $errors = null;
    /**
     * Constructor.
     *
     * Sets up the WordPress Ajax upgrader skin.
     *
     * @since 4.6.0
     *
     * @see WP_Upgrader_Skin::__construct()
     *
     * @param array $args Optional. The WordPress Ajax upgrader skin arguments to
     *                    override default options. See WP_Upgrader_Skin::__construct().
     *                    Default empty array.
     */
    public function __construct($args = array())
    {
        parent::__construct($args);
        $this->errors = new WP_Error();
    }
    /**
     * Retrieves the list of errors.
     *
     * @since 4.6.0
     *
     * @return WP_Error Errors during an upgrade.
     */
    public function get_errors()
    {
        return $this->errors;
    }
    /**
     * Retrieves a string for error messages.
     *
     * @since 4.6.0
     *
     * @return string Error messages during an upgrade.
     */
    public function get_error_messages()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_error_messages") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-ajax-upgrader-skin.php at line 67")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_error_messages:67@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-ajax-upgrader-skin.php');
        die();
    }
    /**
     * Stores an error message about the upgrade.
     *
     * @since 4.6.0
     * @since 5.3.0 Formalized the existing `...$args` parameter by adding it
     *              to the function signature.
     *
     * @param string|WP_Error $errors  Errors.
     * @param mixed           ...$args Optional text replacements.
     */
    public function error($errors, ...$args)
    {
        if (is_string($errors)) {
            $string = $errors;
            if (!empty($this->upgrader->strings[$string])) {
                $string = $this->upgrader->strings[$string];
            }
            if (false !== strpos($string, '%')) {
                if (!empty($args)) {
                    $string = vsprintf($string, $args);
                }
            }
            // Count existing errors to generate a unique error code.
            $errors_count = count($this->errors->get_error_codes());
            $this->errors->add('unknown_upgrade_error_' . ($errors_count + 1), $string);
        } elseif (is_wp_error($errors)) {
            foreach ($errors->get_error_codes() as $error_code) {
                $this->errors->add($error_code, $errors->get_error_message($error_code), $errors->get_error_data($error_code));
            }
        }
        parent::error($errors, ...$args);
    }
    /**
     * Stores a message about the upgrade.
     *
     * @since 4.6.0
     * @since 5.3.0 Formalized the existing `...$args` parameter by adding it
     *              to the function signature.
     *
     * @param string|array|WP_Error $data    Message data.
     * @param mixed                 ...$args Optional text replacements.
     */
    public function feedback($data, ...$args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("feedback") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-ajax-upgrader-skin.php at line 122")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called feedback:122@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-admin/includes/class-wp-ajax-upgrader-skin.php');
        die();
    }
}