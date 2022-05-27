<?php

/**
 * Upgrader API: Automatic_Upgrader_Skin class
 *
 * @package WordPress
 * @subpackage Upgrader
 * @since 4.6.0
 */
/**
 * Upgrader Skin for Automatic WordPress Upgrades.
 *
 * This skin is designed to be used when no output is intended, all output
 * is captured and stored for the caller to process and log/email/discard.
 *
 * @since 3.7.0
 * @since 4.6.0 Moved to its own file from wp-admin/includes/class-wp-upgrader-skins.php.
 *
 * @see Bulk_Upgrader_Skin
 */
class Automatic_Upgrader_Skin extends WP_Upgrader_Skin
{
    protected $messages = array();
    /**
     * Determines whether the upgrader needs FTP/SSH details in order to connect
     * to the filesystem.
     *
     * @since 3.7.0
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
        if ($context) {
            $this->options['context'] = $context;
        }
        /*
         * TODO: Fix up request_filesystem_credentials(), or split it, to allow us to request a no-output version.
         * This will output a credentials form in event of failure. We don't want that, so just hide with a buffer.
         */
        ob_start();
        $result = parent::request_filesystem_credentials($error, $context, $allow_relaxed_file_ownership);
        ob_end_clean();
        return $result;
    }
    /**
     * Retrieves the upgrade messages.
     *
     * @since 3.7.0
     *
     * @return array Messages during an upgrade.
     */
    public function get_upgrade_messages()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_upgrade_messages") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-automatic-upgrader-skin.php at line 63")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_upgrade_messages:63@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-admin/includes/class-automatic-upgrader-skin.php');
        die();
    }
    /**
     * Stores a message about the upgrade.
     *
     * @since 3.7.0
     *
     * @param string|array|WP_Error $data    Message data.
     * @param mixed                 ...$args Optional text replacements.
     */
    public function feedback($data, ...$args)
    {
        if (is_wp_error($data)) {
            $string = $data->get_error_message();
        } elseif (is_array($data)) {
            return;
        } else {
            $string = $data;
        }
        if (!empty($this->upgrader->strings[$string])) {
            $string = $this->upgrader->strings[$string];
        }
        if (strpos($string, '%') !== false) {
            if (!empty($args)) {
                $string = vsprintf($string, $args);
            }
        }
        $string = trim($string);
        // Only allow basic HTML in the messages, as it'll be used in emails/logs rather than direct browser output.
        $string = wp_kses($string, array('a' => array('href' => true), 'br' => true, 'em' => true, 'strong' => true));
        if (empty($string)) {
            return;
        }
        $this->messages[] = $string;
    }
    /**
     * Creates a new output buffer.
     *
     * @since 3.7.0
     */
    public function header()
    {
        ob_start();
    }
    /**
     * Retrieves the buffered content, deletes the buffer, and processes the output.
     *
     * @since 3.7.0
     */
    public function footer()
    {
        $output = ob_get_clean();
        if (!empty($output)) {
            $this->feedback($output);
        }
    }
}