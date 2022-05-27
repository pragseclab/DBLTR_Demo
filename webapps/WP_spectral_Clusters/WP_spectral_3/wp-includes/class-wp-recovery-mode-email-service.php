<?php

/**
 * Error Protection API: WP_Recovery_Mode_Email_Link class
 *
 * @package WordPress
 * @since 5.2.0
 */
/**
 * Core class used to send an email with a link to begin Recovery Mode.
 *
 * @since 5.2.0
 */
final class WP_Recovery_Mode_Email_Service
{
    const RATE_LIMIT_OPTION = 'recovery_mode_email_last_sent';
    /**
     * Service to generate recovery mode URLs.
     *
     * @since 5.2.0
     * @var WP_Recovery_Mode_Link_Service
     */
    private $link_service;
    /**
     * WP_Recovery_Mode_Email_Service constructor.
     *
     * @since 5.2.0
     *
     * @param WP_Recovery_Mode_Link_Service $link_service
     */
    public function __construct(WP_Recovery_Mode_Link_Service $link_service)
    {
        $this->link_service = $link_service;
    }
    /**
     * Sends the recovery mode email if the rate limit has not been sent.
     *
     * @since 5.2.0
     *
     * @param int   $rate_limit Number of seconds before another email can be sent.
     * @param array $error      Error details from {@see error_get_last()}
     * @param array $extension {
     *     The extension that caused the error.
     *
     *     @type string $slug The extension slug. The plugin or theme's directory.
     *     @type string $type The extension type. Either 'plugin' or 'theme'.
     * }
     * @return true|WP_Error True if email sent, WP_Error otherwise.
     */
    public function maybe_send_recovery_mode_email($rate_limit, $error, $extension)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("maybe_send_recovery_mode_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php at line 52")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called maybe_send_recovery_mode_email:52@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php');
        die();
    }
    /**
     * Clears the rate limit, allowing a new recovery mode email to be sent immediately.
     *
     * @since 5.2.0
     *
     * @return bool True on success, false on failure.
     */
    public function clear_rate_limit()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("clear_rate_limit") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php at line 84")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called clear_rate_limit:84@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php');
        die();
    }
    /**
     * Sends the Recovery Mode email to the site admin email address.
     *
     * @since 5.2.0
     *
     * @param int   $rate_limit Number of seconds before another email can be sent.
     * @param array $error      Error details from {@see error_get_last()}
     * @param array $extension  Extension that caused the error.
     * @return bool Whether the email was sent successfully.
     */
    private function send_recovery_mode_email($rate_limit, $error, $extension)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("send_recovery_mode_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php at line 98")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called send_recovery_mode_email:98@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php');
        die();
    }
    /**
     * Gets the email address to send the recovery mode link to.
     *
     * @since 5.2.0
     *
     * @return string Email address to send recovery mode link to.
     */
    private function get_recovery_mode_email_address()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_recovery_mode_email_address") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php at line 193")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_recovery_mode_email_address:193@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php');
        die();
    }
    /**
     * Gets the description indicating the possible cause for the error.
     *
     * @since 5.2.0
     *
     * @param array $extension The extension that caused the error.
     * @return string Message about which extension caused the error.
     */
    private function get_cause($extension)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_cause") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php at line 208")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_cause:208@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php');
        die();
    }
    /**
     * Return the details for a single plugin based on the extension data from an error.
     *
     * @since 5.3.0
     *
     * @param array $extension The extension that caused the error.
     * @return array|false A plugin array {@see get_plugins()} or `false` if no plugin was found.
     */
    private function get_plugin($extension)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_plugin") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php at line 235")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_plugin:235@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php');
        die();
    }
    /**
     * Return debug information in an easy to manipulate format.
     *
     * @since 5.3.0
     *
     * @param array $extension The extension that caused the error.
     * @return array An associative array of debug information.
     */
    private function get_debug($extension)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_debug") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php at line 261")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_debug:261@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-recovery-mode-email-service.php');
        die();
    }
}