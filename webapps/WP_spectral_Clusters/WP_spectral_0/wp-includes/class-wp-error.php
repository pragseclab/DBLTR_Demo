<?php

/**
 * WordPress Error API.
 *
 * @package WordPress
 */
/**
 * WordPress Error class.
 *
 * Container for checking for WordPress errors and error messages. Return
 * WP_Error and use is_wp_error() to check if this class is returned. Many
 * core WordPress functions pass this class in the event of an error and
 * if not handled properly will result in code errors.
 *
 * @since 2.1.0
 */
class WP_Error
{
    /**
     * Stores the list of errors.
     *
     * @since 2.1.0
     * @var array
     */
    public $errors = array();
    /**
     * Stores the most recently added data for each error code.
     *
     * @since 2.1.0
     * @var array
     */
    public $error_data = array();
    /**
     * Stores previously added data added for error codes, oldest-to-newest by code.
     *
     * @since 5.6.0
     * @var array[]
     */
    protected $additional_data = array();
    /**
     * Initializes the error.
     *
     * If `$code` is empty, the other parameters will be ignored.
     * When `$code` is not empty, `$message` will be used even if
     * it is empty. The `$data` parameter will be used only if it
     * is not empty.
     *
     * Though the class is constructed with a single error code and
     * message, multiple codes can be added using the `add()` method.
     *
     * @since 2.1.0
     *
     * @param string|int $code    Error code.
     * @param string     $message Error message.
     * @param mixed      $data    Optional. Error data.
     */
    public function __construct($code = '', $message = '', $data = '')
    {
        if (empty($code)) {
            return;
        }
        $this->add($code, $message, $data);
    }
    /**
     * Retrieves all error codes.
     *
     * @since 2.1.0
     *
     * @return array List of error codes, if available.
     */
    public function get_error_codes()
    {
        if (!$this->has_errors()) {
            return array();
        }
        return array_keys($this->errors);
    }
    /**
     * Retrieves the first error code available.
     *
     * @since 2.1.0
     *
     * @return string|int Empty string, if no error codes.
     */
    public function get_error_code()
    {
        $codes = $this->get_error_codes();
        if (empty($codes)) {
            return '';
        }
        return $codes[0];
    }
    /**
     * Retrieves all error messages, or the error messages for the given error code.
     *
     * @since 2.1.0
     *
     * @param string|int $code Optional. Retrieve messages matching code, if exists.
     * @return array Error strings on success, or empty array if there are none.
     */
    public function get_error_messages($code = '')
    {
        // Return all messages if no code specified.
        if (empty($code)) {
            $all_messages = array();
            foreach ((array) $this->errors as $code => $messages) {
                $all_messages = array_merge($all_messages, $messages);
            }
            return $all_messages;
        }
        if (isset($this->errors[$code])) {
            return $this->errors[$code];
        } else {
            return array();
        }
    }
    /**
     * Gets a single error message.
     *
     * This will get the first message available for the code. If no code is
     * given then the first code available will be used.
     *
     * @since 2.1.0
     *
     * @param string|int $code Optional. Error code to retrieve message.
     * @return string The error message.
     */
    public function get_error_message($code = '')
    {
        if (empty($code)) {
            $code = $this->get_error_code();
        }
        $messages = $this->get_error_messages($code);
        if (empty($messages)) {
            return '';
        }
        return $messages[0];
    }
    /**
     * Retrieves the most recently added error data for an error code.
     *
     * @since 2.1.0
     *
     * @param string|int $code Optional. Error code.
     * @return mixed Error data, if it exists.
     */
    public function get_error_data($code = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_error_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php at line 150")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_error_data:150@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php');
        die();
    }
    /**
     * Verifies if the instance contains errors.
     *
     * @since 5.1.0
     *
     * @return bool If the instance contains errors.
     */
    public function has_errors()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("has_errors") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php at line 166")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called has_errors:166@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php');
        die();
    }
    /**
     * Adds an error or appends an additional message to an existing error.
     *
     * @since 2.1.0
     *
     * @param string|int $code    Error code.
     * @param string     $message Error message.
     * @param mixed      $data    Optional. Error data.
     */
    public function add($code, $message, $data = '')
    {
        $this->errors[$code][] = $message;
        if (!empty($data)) {
            $this->add_data($data, $code);
        }
        /**
         * Fires when an error is added to a WP_Error object.
         *
         * @since 5.6.0
         *
         * @param string|int $code     Error code.
         * @param string     $message  Error message.
         * @param mixed      $data     Error data. Might be empty.
         * @param WP_Error   $wp_error The WP_Error object.
         */
        do_action('wp_error_added', $code, $message, $data, $this);
    }
    /**
     * Adds data to an error with the given code.
     *
     * @since 2.1.0
     * @since 5.6.0 Errors can now contain more than one item of error data. {@see WP_Error::$additional_data}.
     *
     * @param mixed      $data Error data.
     * @param string|int $code Error code.
     */
    public function add_data($data, $code = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php at line 209")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add_data:209@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php');
        die();
    }
    /**
     * Retrieves all error data for an error code in the order in which the data was added.
     *
     * @since 5.6.0
     *
     * @param string|int $code Error code.
     * @return mixed[] Array of error data, if it exists.
     */
    public function get_all_error_data($code = '')
    {
        if (empty($code)) {
            $code = $this->get_error_code();
        }
        $data = array();
        if (isset($this->additional_data[$code])) {
            $data = $this->additional_data[$code];
        }
        if (isset($this->error_data[$code])) {
            $data[] = $this->error_data[$code];
        }
        return $data;
    }
    /**
     * Removes the specified error.
     *
     * This function removes all error messages associated with the specified
     * error code, along with any error data for that code.
     *
     * @since 4.1.0
     *
     * @param string|int $code Error code.
     */
    public function remove($code)
    {
        unset($this->errors[$code]);
        unset($this->error_data[$code]);
        unset($this->additional_data[$code]);
    }
    /**
     * Merges the errors in the given error object into this one.
     *
     * @since 5.6.0
     *
     * @param WP_Error $error Error object to merge.
     */
    public function merge_from(WP_Error $error)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("merge_from") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php at line 264")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called merge_from:264@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php');
        die();
    }
    /**
     * Exports the errors in this object into the given one.
     *
     * @since 5.6.0
     *
     * @param WP_Error $error Error object to export into.
     */
    public function export_to(WP_Error $error)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("export_to") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php at line 275")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called export_to:275@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php');
        die();
    }
    /**
     * Copies errors from one WP_Error instance to another.
     *
     * @since 5.6.0
     *
     * @param WP_Error $from The WP_Error to copy from.
     * @param WP_Error $to   The WP_Error to copy to.
     */
    protected static function copy_errors(WP_Error $from, WP_Error $to)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("copy_errors") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php at line 287")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called copy_errors:287@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/class-wp-error.php');
        die();
    }
}