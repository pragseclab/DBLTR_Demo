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
        $last_sent = get_option(self::RATE_LIMIT_OPTION);
        if (!$last_sent || time() > $last_sent + $rate_limit) {
            if (!update_option(self::RATE_LIMIT_OPTION, time())) {
                return new WP_Error('storage_error', __('Could not update the email last sent time.'));
            }
            $sent = $this->send_recovery_mode_email($rate_limit, $error, $extension);
            if ($sent) {
                return true;
            }
            return new WP_Error('email_failed', sprintf(
                /* translators: %s: mail() */
                __('The email could not be sent. Possible reason: your host may have disabled the %s function.'),
                'mail()'
            ));
        }
        $err_message = sprintf(
            /* translators: 1: Last sent as a human time diff, 2: Wait time as a human time diff. */
            __('A recovery link was already sent %1$s ago. Please wait another %2$s before requesting a new email.'),
            human_time_diff($last_sent),
            human_time_diff($last_sent + $rate_limit)
        );
        return new WP_Error('email_sent_already', $err_message);
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("clear_rate_limit") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php at line 84")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called clear_rate_limit:84@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php');
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
        $url = $this->link_service->generate_url();
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $switched_locale = false;
        // The switch_to_locale() function is loaded before it can actually be used.
        if (function_exists('switch_to_locale') && isset($GLOBALS['wp_locale_switcher'])) {
            $switched_locale = switch_to_locale(get_locale());
        }
        if ($extension) {
            $cause = $this->get_cause($extension);
            $details = wp_strip_all_tags(wp_get_extension_error_description($error));
            if ($details) {
                $header = __('Error Details');
                $details = "\n\n" . $header . "\n" . str_pad('', strlen($header), '=') . "\n" . $details;
            }
        } else {
            $cause = '';
            $details = '';
        }
        /**
         * Filters the support message sent with the the fatal error protection email.
         *
         * @since 5.2.0
         *
         * @param string $message The Message to include in the email.
         */
        $support = apply_filters('recovery_email_support_info', __('Please contact your host for assistance with investigating this issue further.'));
        /**
         * Filters the debug information included in the fatal error protection email.
         *
         * @since 5.3.0
         *
         * @param array $message An associative array of debug information.
         */
        $debug = apply_filters('recovery_email_debug_info', $this->get_debug($extension));
        /* translators: Do not translate LINK, EXPIRES, CAUSE, DETAILS, SITEURL, PAGEURL, SUPPORT. DEBUG: those are placeholders. */
        $message = __('Howdy!

Since WordPress 5.2 there is a built-in feature that detects when a plugin or theme causes a fatal error on your site, and notifies you with this automated email.
###CAUSE###
First, visit your website (###SITEURL###) and check for any visible issues. Next, visit the page where the error was caught (###PAGEURL###) and check for any visible issues.

###SUPPORT###

If your site appears broken and you can\'t access your dashboard normally, WordPress now has a special "recovery mode". This lets you safely login to your dashboard and investigate further.

###LINK###

To keep your site safe, this link will expire in ###EXPIRES###. Don\'t worry about that, though: a new link will be emailed to you if the error occurs again after it expires.

When seeking help with this issue, you may be asked for some of the following information:
###DEBUG###

###DETAILS###');
        $message = str_replace(array('###LINK###', '###EXPIRES###', '###CAUSE###', '###DETAILS###', '###SITEURL###', '###PAGEURL###', '###SUPPORT###', '###DEBUG###'), array($url, human_time_diff(time() + $rate_limit), $cause ? "\n{$cause}\n" : "\n", $details, home_url('/'), home_url($_SERVER['REQUEST_URI']), $support, implode("\r\n", $debug)), $message);
        $email = array(
            'to' => $this->get_recovery_mode_email_address(),
            /* translators: %s: Site title. */
            'subject' => __('[%s] Your Site is Experiencing a Technical Issue'),
            'message' => $message,
            'headers' => '',
            'attachments' => '',
        );
        /**
         * Filters the contents of the Recovery Mode email.
         *
         * @since 5.2.0
         * @since 5.6.0 The `$email` argument includes the `attachments` key.
         *
         * @param array  $email {
         *     Used to build a call to wp_mail().
         *
         *     @type string|array $to          Array or comma-separated list of email addresses to send message.
         *     @type string       $subject     Email subject
         *     @type string       $message     Message contents
         *     @type string|array $headers     Optional. Additional headers.
         *     @type string|array $attachments Optional. Files to attach.
         * }
         * @param string $url   URL to enter recovery mode.
         */
        $email = apply_filters('recovery_mode_email', $email, $url);
        $sent = wp_mail($email['to'], wp_specialchars_decode(sprintf($email['subject'], $blogname)), $email['message'], $email['headers'], $email['attachments']);
        if ($switched_locale) {
            restore_previous_locale();
        }
        return $sent;
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_recovery_mode_email_address") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php at line 193")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_recovery_mode_email_address:193@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_cause") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php at line 208")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_cause:208@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_plugin") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php at line 235")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_plugin:235@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_debug") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php at line 261")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_debug:261@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-recovery-mode-email-service.php');
        die();
    }
}