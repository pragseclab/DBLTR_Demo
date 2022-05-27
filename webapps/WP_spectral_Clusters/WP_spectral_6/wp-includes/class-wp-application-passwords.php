<?php

/**
 * WP_Application_Passwords class
 *
 * @package WordPress
 * @since   5.6.0
 */
/**
 * Class for displaying, modifying, and sanitizing application passwords.
 *
 * @package WordPress
 */
class WP_Application_Passwords
{
    /**
     * The application passwords user meta key.
     *
     * @since 5.6.0
     *
     * @var string
     */
    const USERMETA_KEY_APPLICATION_PASSWORDS = '_application_passwords';
    /**
     * The option name used to store whether application passwords is in use.
     *
     * @since 5.6.0
     *
     * @var string
     */
    const OPTION_KEY_IN_USE = 'using_application_passwords';
    /**
     * The generated application password length.
     *
     * @since 5.6.0
     *
     * @var int
     */
    const PW_LENGTH = 24;
    /**
     * Checks if Application Passwords are being used by the site.
     *
     * This returns true if at least one App Password has ever been created.
     *
     * @since 5.6.0
     *
     * @return bool
     */
    public static function is_in_use()
    {
        $network_id = get_main_network_id();
        return (bool) get_network_option($network_id, self::OPTION_KEY_IN_USE);
    }
    /**
     * Creates a new application password.
     *
     * @since 5.6.0
     * @since 5.7.0 Returns WP_Error if application name already exists.
     *
     * @param int   $user_id  User ID.
     * @param array $args     Information about the application password.
     * @return array|WP_Error The first key in the array is the new password, the second is its detailed information.
     *                        A WP_Error instance is returned on error.
     */
    public static function create_new_application_password($user_id, $args = array())
    {
        if (!empty($args['name'])) {
            $args['name'] = sanitize_text_field($args['name']);
        }
        if (empty($args['name'])) {
            return new WP_Error('application_password_empty_name', __('An application name is required to create an application password.'), array('status' => 400));
        }
        if (self::application_name_exists_for_user($user_id, $args['name'])) {
            return new WP_Error('application_password_duplicate_name', __('Each application name should be unique.'), array('status' => 409));
        }
        $new_password = wp_generate_password(static::PW_LENGTH, false);
        $hashed_password = wp_hash_password($new_password);
        $new_item = array('uuid' => wp_generate_uuid4(), 'app_id' => empty($args['app_id']) ? '' : $args['app_id'], 'name' => $args['name'], 'password' => $hashed_password, 'created' => time(), 'last_used' => null, 'last_ip' => null);
        $passwords = static::get_user_application_passwords($user_id);
        $passwords[] = $new_item;
        $saved = static::set_user_application_passwords($user_id, $passwords);
        if (!$saved) {
            return new WP_Error('db_error', __('Could not save application password.'));
        }
        $network_id = get_main_network_id();
        if (!get_network_option($network_id, self::OPTION_KEY_IN_USE)) {
            update_network_option($network_id, self::OPTION_KEY_IN_USE, true);
        }
        /**
         * Fires when an application password is created.
         *
         * @since 5.6.0
         *
         * @param int    $user_id      The user ID.
         * @param array  $new_item     The details about the created password.
         * @param string $new_password The unhashed generated app password.
         * @param array  $args         Information used to create the application password.
         */
        do_action('wp_create_application_password', $user_id, $new_item, $new_password, $args);
        return array($new_password, $new_item);
    }
    /**
     * Gets a user's application passwords.
     *
     * @since 5.6.0
     *
     * @param int $user_id User ID.
     * @return array The list of app passwords.
     */
    public static function get_user_application_passwords($user_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_user_application_passwords") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php at line 112")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_user_application_passwords:112@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php');
        die();
    }
    /**
     * Gets a user's application password with the given uuid.
     *
     * @since 5.6.0
     *
     * @param int    $user_id User ID.
     * @param string $uuid    The password's uuid.
     * @return array|null The application password if found, null otherwise.
     */
    public static function get_user_application_password($user_id, $uuid)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_user_application_password") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php at line 139")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_user_application_password:139@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php');
        die();
    }
    /**
     * Checks if application name exists for this user.
     *
     * @since 5.7.0
     *
     * @param int    $user_id User ID.
     * @param string $name    Application name.
     * @return bool Whether provided application name exists or not.
     */
    public static function application_name_exists_for_user($user_id, $name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("application_name_exists_for_user") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php at line 158")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called application_name_exists_for_user:158@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php');
        die();
    }
    /**
     * Updates an application password.
     *
     * @since 5.6.0
     *
     * @param int    $user_id User ID.
     * @param string $uuid    The password's uuid.
     * @param array  $update  Information about the application password to update.
     * @return true|WP_Error True if successful, otherwise a WP_Error instance is returned on error.
     */
    public static function update_application_password($user_id, $uuid, $update = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_application_password") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php at line 178")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_application_password:178@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php');
        die();
    }
    /**
     * Records that an application password has been used.
     *
     * @since 5.6.0
     *
     * @param int    $user_id User ID.
     * @param string $uuid    The password's uuid.
     * @return true|WP_Error True if the usage was recorded, a WP_Error if an error occurs.
     */
    public static function record_application_password_usage($user_id, $uuid)
    {
        $passwords = static::get_user_application_passwords($user_id);
        foreach ($passwords as &$password) {
            if ($password['uuid'] !== $uuid) {
                continue;
            }
            // Only record activity once a day.
            if ($password['last_used'] + DAY_IN_SECONDS > time()) {
                return true;
            }
            $password['last_used'] = time();
            $password['last_ip'] = $_SERVER['REMOTE_ADDR'];
            $saved = static::set_user_application_passwords($user_id, $passwords);
            if (!$saved) {
                return new WP_Error('db_error', __('Could not save application password.'));
            }
            return true;
        }
        // Specified Application Password not found!
        return new WP_Error('application_password_not_found', __('Could not find an application password with that id.'));
    }
    /**
     * Deletes an application password.
     *
     * @since 5.6.0
     *
     * @param int    $user_id User ID.
     * @param string $uuid    The password's uuid.
     * @return true|WP_Error Whether the password was successfully found and deleted, a WP_Error otherwise.
     */
    public static function delete_application_password($user_id, $uuid)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_application_password") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php at line 253")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_application_password:253@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php');
        die();
    }
    /**
     * Deletes all application passwords for the given user.
     *
     * @since 5.6.0
     *
     * @param int $user_id User ID.
     * @return int|WP_Error The number of passwords that were deleted or a WP_Error on failure.
     */
    public static function delete_all_application_passwords($user_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_all_application_passwords") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php at line 285")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_all_application_passwords:285@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php');
        die();
    }
    /**
     * Sets a users application passwords.
     *
     * @since 5.6.0
     *
     * @param int   $user_id   User ID.
     * @param array $passwords Application passwords.
     *
     * @return bool
     */
    protected static function set_user_application_passwords($user_id, $passwords)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_user_application_passwords") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php at line 311")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_user_application_passwords:311@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php');
        die();
    }
    /**
     * Sanitizes and then splits a password into smaller chunks.
     *
     * @since 5.6.0
     *
     * @param string $raw_password The raw application password.
     * @return string The chunked password.
     */
    public static function chunk_password($raw_password)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("chunk_password") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php at line 323")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called chunk_password:323@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-application-passwords.php');
        die();
    }
}