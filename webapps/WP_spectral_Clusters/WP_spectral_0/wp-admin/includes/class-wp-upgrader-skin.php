<?php

/**
 * Upgrader API: WP_Upgrader_Skin class
 *
 * @package WordPress
 * @subpackage Upgrader
 * @since 4.6.0
 */
/**
 * Generic Skin for the WordPress Upgrader classes. This skin is designed to be extended for specific purposes.
 *
 * @since 2.8.0
 * @since 4.6.0 Moved to its own file from wp-admin/includes/class-wp-upgrader-skins.php.
 */
class WP_Upgrader_Skin
{
    /**
     * Holds the upgrader data.
     *
     * @since 2.8.0
     *
     * @var WP_Upgrader
     */
    public $upgrader;
    /**
     * Whether header is done.
     *
     * @since 2.8.0
     *
     * @var bool
     */
    public $done_header = false;
    /**
     * Whether footer is done.
     *
     * @since 2.8.0
     *
     * @var bool
     */
    public $done_footer = false;
    /**
     * Holds the result of an upgrade.
     *
     * @since 2.8.0
     *
     * @var string|bool|WP_Error
     */
    public $result = false;
    /**
     * Holds the options of an upgrade.
     *
     * @since 2.8.0
     *
     * @var array
     */
    public $options = array();
    /**
     * Constructor.
     *
     * Sets up the generic skin for the WordPress Upgrader classes.
     *
     * @since 2.8.0
     *
     * @param array $args Optional. The WordPress upgrader skin arguments to
     *                    override default options. Default empty array.
     */
    public function __construct($args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php at line 70")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:70@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php');
        die();
    }
    /**
     * @since 2.8.0
     *
     * @param WP_Upgrader $upgrader
     */
    public function set_upgrader(&$upgrader)
    {
        if (is_object($upgrader)) {
            $this->upgrader =& $upgrader;
        }
        $this->add_strings();
    }
    /**
     * @since 3.0.0
     */
    public function add_strings()
    {
    }
    /**
     * Sets the result of an upgrade.
     *
     * @since 2.8.0
     *
     * @param string|bool|WP_Error $result The result of an upgrade.
     */
    public function set_result($result)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_result") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php at line 100")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_result:100@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php');
        die();
    }
    /**
     * Displays a form to the user to request for their FTP/SSH details in order
     * to connect to the filesystem.
     *
     * @since 2.8.0
     * @since 4.6.0 The `$context` parameter default changed from `false` to an empty string.
     *
     * @see request_filesystem_credentials()
     *
     * @param bool|WP_Error $error                        Optional. Whether the current request has failed to connect,
     *                                                    or an error object. Default false.
     * @param string        $context                      Optional. Full path to the directory that is tested
     *                                                    for being writable. Default empty.
     * @param bool          $allow_relaxed_file_ownership Optional. Whether to allow Group/World writable. Default false.
     * @return bool True on success, false on failure.
     */
    public function request_filesystem_credentials($error = false, $context = '', $allow_relaxed_file_ownership = false)
    {
        $url = $this->options['url'];
        if (!$context) {
            $context = $this->options['context'];
        }
        if (!empty($this->options['nonce'])) {
            $url = wp_nonce_url($url, $this->options['nonce']);
        }
        $extra_fields = array();
        return request_filesystem_credentials($url, '', $error, $context, $extra_fields, $allow_relaxed_file_ownership);
    }
    /**
     * @since 2.8.0
     */
    public function header()
    {
        if ($this->done_header) {
            return;
        }
        $this->done_header = true;
        echo '<div class="wrap">';
        echo '<h1>' . $this->options['title'] . '</h1>';
    }
    /**
     * @since 2.8.0
     */
    public function footer()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("footer") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php at line 147")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called footer:147@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php');
        die();
    }
    /**
     * @since 2.8.0
     *
     * @param string|WP_Error $errors
     */
    public function error($errors)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("error") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php at line 160")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called error:160@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php');
        die();
    }
    /**
     * @since 2.8.0
     *
     * @param string $string
     * @param mixed  ...$args Optional text replacements.
     */
    public function feedback($string, ...$args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("feedback") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php at line 183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called feedback:183@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php');
        die();
    }
    /**
     * Action to perform before an update.
     *
     * @since 2.8.0
     */
    public function before()
    {
    }
    /**
     * Action to perform following an update.
     *
     * @since 2.8.0
     */
    public function after()
    {
    }
    /**
     * Output JavaScript that calls function to decrement the update counts.
     *
     * @since 3.9.0
     *
     * @param string $type Type of update count to decrement. Likely values include 'plugin',
     *                     'theme', 'translation', etc.
     */
    protected function decrement_update_count($type)
    {
        if (!$this->result || is_wp_error($this->result) || 'up_to_date' === $this->result) {
            return;
        }
        if (defined('IFRAME_REQUEST')) {
            echo '<script type="text/javascript">
					if ( window.postMessage && JSON ) {
						window.parent.postMessage( JSON.stringify( { action: "decrementUpdateCount", upgradeType: "' . $type . '" } ), window.location.protocol + "//" + window.location.hostname );
					}
				</script>';
        } else {
            echo '<script type="text/javascript">
					(function( wp ) {
						if ( wp && wp.updates && wp.updates.decrementCount ) {
							wp.updates.decrementCount( "' . $type . '" );
						}
					})( window.wp );
				</script>';
        }
    }
    /**
     * @since 3.0.0
     */
    public function bulk_header()
    {
    }
    /**
     * @since 3.0.0
     */
    public function bulk_footer()
    {
    }
    /**
     * Hides the `process_failed` error message when updating by uploading a zip file.
     *
     * @since 5.5.0
     *
     * @param WP_Error $wp_error WP_Error object.
     * @return bool
     */
    public function hide_process_failed($wp_error)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hide_process_failed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php at line 265")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hide_process_failed:265@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-admin/includes/class-wp-upgrader-skin.php');
        die();
    }
}