<?php

/**
 * User API: WP_User class
 *
 * @package WordPress
 * @subpackage Users
 * @since 4.4.0
 */
/**
 * Core class used to implement the WP_User object.
 *
 * @since 2.0.0
 *
 * @property string $nickname
 * @property string $description
 * @property string $user_description
 * @property string $first_name
 * @property string $user_firstname
 * @property string $last_name
 * @property string $user_lastname
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_nicename
 * @property string $user_email
 * @property string $user_url
 * @property string $user_registered
 * @property string $user_activation_key
 * @property string $user_status
 * @property int    $user_level
 * @property string $display_name
 * @property string $spam
 * @property string $deleted
 * @property string $locale
 * @property string $rich_editing
 * @property string $syntax_highlighting
 */
class WP_User
{
    /**
     * User data container.
     *
     * @since 2.0.0
     * @var stdClass
     */
    public $data;
    /**
     * The user's ID.
     *
     * @since 2.1.0
     * @var int
     */
    public $ID = 0;
    /**
     * Capabilities that the individual user has been granted outside of those inherited from their role.
     *
     * @since 2.0.0
     * @var bool[] Array of key/value pairs where keys represent a capability name
     *             and boolean values represent whether the user has that capability.
     */
    public $caps = array();
    /**
     * User metadata option name.
     *
     * @since 2.0.0
     * @var string
     */
    public $cap_key;
    /**
     * The roles the user is part of.
     *
     * @since 2.0.0
     * @var string[]
     */
    public $roles = array();
    /**
     * All capabilities the user has, including individual and role based.
     *
     * @since 2.0.0
     * @var bool[] Array of key/value pairs where keys represent a capability name
     *             and boolean values represent whether the user has that capability.
     */
    public $allcaps = array();
    /**
     * The filter context applied to user data fields.
     *
     * @since 2.9.0
     * @var string
     */
    public $filter = null;
    /**
     * The site ID the capabilities of this user are initialized for.
     *
     * @since 4.9.0
     * @var int
     */
    private $site_id = 0;
    /**
     * @since 3.3.0
     * @var array
     */
    private static $back_compat_keys;
    /**
     * Constructor.
     *
     * Retrieves the userdata and passes it to WP_User::init().
     *
     * @since 2.0.0
     *
     * @param int|string|stdClass|WP_User $id      User's ID, a WP_User object, or a user object from the DB.
     * @param string                      $name    Optional. User's username
     * @param int                         $site_id Optional Site ID, defaults to current site.
     */
    public function __construct($id = 0, $name = '', $site_id = '')
    {
        if (!isset(self::$back_compat_keys)) {
            $prefix = $GLOBALS['wpdb']->prefix;
            self::$back_compat_keys = array('user_firstname' => 'first_name', 'user_lastname' => 'last_name', 'user_description' => 'description', 'user_level' => $prefix . 'user_level', $prefix . 'usersettings' => $prefix . 'user-settings', $prefix . 'usersettingstime' => $prefix . 'user-settings-time');
        }
        if ($id instanceof WP_User) {
            $this->init($id->data, $site_id);
            return;
        } elseif (is_object($id)) {
            $this->init($id, $site_id);
            return;
        }
        if (!empty($id) && !is_numeric($id)) {
            $name = $id;
            $id = 0;
        }
        if ($id) {
            $data = self::get_data_by('id', $id);
        } else {
            $data = self::get_data_by('login', $name);
        }
        if ($data) {
            $this->init($data, $site_id);
        } else {
            $this->data = new stdClass();
        }
    }
    /**
     * Sets up object properties, including capabilities.
     *
     * @since 3.3.0
     *
     * @param object $data    User DB row object.
     * @param int    $site_id Optional. The site ID to initialize for.
     */
    public function init($data, $site_id = '')
    {
        if (!isset($data->ID)) {
            $data->ID = 0;
        }
        $this->data = $data;
        $this->ID = (int) $data->ID;
        $this->for_site($site_id);
    }
    /**
     * Return only the main user fields
     *
     * @since 3.3.0
     * @since 4.4.0 Added 'ID' as an alias of 'id' for the `$field` parameter.
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param string     $field The field to query against: 'id', 'ID', 'slug', 'email' or 'login'.
     * @param string|int $value The field value
     * @return object|false Raw user object
     */
    public static function get_data_by($field, $value)
    {
        global $wpdb;
        // 'ID' is an alias of 'id'.
        if ('ID' === $field) {
            $field = 'id';
        }
        if ('id' === $field) {
            // Make sure the value is numeric to avoid casting objects, for example,
            // to int 1.
            if (!is_numeric($value)) {
                return false;
            }
            $value = (int) $value;
            if ($value < 1) {
                return false;
            }
        } else {
            $value = trim($value);
        }
        if (!$value) {
            return false;
        }
        switch ($field) {
            case 'id':
                $user_id = $value;
                $db_field = 'ID';
                break;
            case 'slug':
                $user_id = wp_cache_get($value, 'userslugs');
                $db_field = 'user_nicename';
                break;
            case 'email':
                $user_id = wp_cache_get($value, 'useremail');
                $db_field = 'user_email';
                break;
            case 'login':
                $value = sanitize_user($value);
                $user_id = wp_cache_get($value, 'userlogins');
                $db_field = 'user_login';
                break;
            default:
                return false;
        }
        if (false !== $user_id) {
            $user = wp_cache_get($user_id, 'users');
            if ($user) {
                return $user;
            }
        }
        $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->users} WHERE {$db_field} = %s LIMIT 1", $value));
        if (!$user) {
            return false;
        }
        update_user_caches($user);
        return $user;
    }
    /**
     * Magic method for checking the existence of a certain custom field.
     *
     * @since 3.3.0
     *
     * @param string $key User meta key to check if set.
     * @return bool Whether the given user meta key is set.
     */
    public function __isset($key)
    {
        if ('id' === $key) {
            _deprecated_argument('WP_User->id', '2.1.0', sprintf(
                /* translators: %s: WP_User->ID */
                __('Use %s instead.'),
                '<code>WP_User->ID</code>'
            ));
            $key = 'ID';
        }
        if (isset($this->data->{$key})) {
            return true;
        }
        if (isset(self::$back_compat_keys[$key])) {
            $key = self::$back_compat_keys[$key];
        }
        return metadata_exists('user', $this->ID, $key);
    }
    /**
     * Magic method for accessing custom fields.
     *
     * @since 3.3.0
     *
     * @param string $key User meta key to retrieve.
     * @return mixed Value of the given user meta key (if set). If `$key` is 'id', the user ID.
     */
    public function __get($key)
    {
        if ('id' === $key) {
            _deprecated_argument('WP_User->id', '2.1.0', sprintf(
                /* translators: %s: WP_User->ID */
                __('Use %s instead.'),
                '<code>WP_User->ID</code>'
            ));
            return $this->ID;
        }
        if (isset($this->data->{$key})) {
            $value = $this->data->{$key};
        } else {
            if (isset(self::$back_compat_keys[$key])) {
                $key = self::$back_compat_keys[$key];
            }
            $value = get_user_meta($this->ID, $key, true);
        }
        if ($this->filter) {
            $value = sanitize_user_field($key, $value, $this->ID, $this->filter);
        }
        return $value;
    }
    /**
     * Magic method for setting custom user fields.
     *
     * This method does not update custom fields in the database. It only stores
     * the value on the WP_User instance.
     *
     * @since 3.3.0
     *
     * @param string $key   User meta key.
     * @param mixed  $value User meta value.
     */
    public function __set($key, $value)
    {
        if ('id' === $key) {
            _deprecated_argument('WP_User->id', '2.1.0', sprintf(
                /* translators: %s: WP_User->ID */
                __('Use %s instead.'),
                '<code>WP_User->ID</code>'
            ));
            $this->ID = $value;
            return;
        }
        $this->data->{$key} = $value;
    }
    /**
     * Magic method for unsetting a certain custom field.
     *
     * @since 4.4.0
     *
     * @param string $key User meta key to unset.
     */
    public function __unset($key)
    {
        if ('id' === $key) {
            _deprecated_argument('WP_User->id', '2.1.0', sprintf(
                /* translators: %s: WP_User->ID */
                __('Use %s instead.'),
                '<code>WP_User->ID</code>'
            ));
        }
        if (isset($this->data->{$key})) {
            unset($this->data->{$key});
        }
        if (isset(self::$back_compat_keys[$key])) {
            unset(self::$back_compat_keys[$key]);
        }
    }
    /**
     * Determine whether the user exists in the database.
     *
     * @since 3.4.0
     *
     * @return bool True if user exists in the database, false if not.
     */
    public function exists()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exists") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 341")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exists:341@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Retrieve the value of a property or meta key.
     *
     * Retrieves from the users and usermeta table.
     *
     * @since 3.3.0
     *
     * @param string $key Property
     * @return mixed
     */
    public function get($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 355")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get:355@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Determine whether a property or meta key is set
     *
     * Consults the users and usermeta tables.
     *
     * @since 3.3.0
     *
     * @param string $key Property
     * @return bool
     */
    public function has_prop($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("has_prop") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 369")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called has_prop:369@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Return an array representation.
     *
     * @since 3.5.0
     *
     * @return array Array representation.
     */
    public function to_array()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("to_array") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 380")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called to_array:380@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Makes private/protected methods readable for backward compatibility.
     *
     * @since 4.3.0
     *
     * @param string $name      Method to call.
     * @param array  $arguments Arguments to pass when calling.
     * @return mixed|false Return value of the callback, false otherwise.
     */
    public function __call($name, $arguments)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__call") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 393")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __call:393@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Set up capability object properties.
     *
     * Will set the value for the 'cap_key' property to current database table
     * prefix, followed by 'capabilities'. Will then check to see if the
     * property matching the 'cap_key' exists and is an array. If so, it will be
     * used.
     *
     * @since 2.1.0
     * @deprecated 4.9.0 Use WP_User::for_site()
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param string $cap_key Optional capability key
     */
    protected function _init_caps($cap_key = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_init_caps") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 415")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _init_caps:415@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Retrieves all of the capabilities of the user's roles, and merges them with
     * individual user capabilities.
     *
     * All of the capabilities of the user's roles are merged with the user's individual
     * capabilities. This means that the user can be denied specific capabilities that
     * their role might have, but the user is specifically denied.
     *
     * @since 2.0.0
     *
     * @return bool[] Array of key/value pairs where keys represent a capability name
     *                and boolean values represent whether the user has that capability.
     */
    public function get_role_caps()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_role_caps") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 440")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_role_caps:440@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Add role to user.
     *
     * Updates the user's meta data option with capabilities and roles.
     *
     * @since 2.0.0
     *
     * @param string $role Role name.
     */
    public function add_role($role)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_role") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 473")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add_role:473@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Remove role from user.
     *
     * @since 2.0.0
     *
     * @param string $role Role name.
     */
    public function remove_role($role)
    {
        if (!in_array($role, $this->roles, true)) {
            return;
        }
        unset($this->caps[$role]);
        update_user_meta($this->ID, $this->cap_key, $this->caps);
        $this->get_role_caps();
        $this->update_user_level_from_caps();
        /**
         * Fires immediately after a role as been removed from a user.
         *
         * @since 4.3.0
         *
         * @param int    $user_id The user ID.
         * @param string $role    The removed role.
         */
        do_action('remove_user_role', $this->ID, $role);
    }
    /**
     * Set the role of the user.
     *
     * This will remove the previous roles of the user and assign the user the
     * new one. You can set the role to an empty string and it will remove all
     * of the roles from the user.
     *
     * @since 2.0.0
     *
     * @param string $role Role name.
     */
    public function set_role($role)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_role") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 529")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_role:529@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Choose the maximum level the user has.
     *
     * Will compare the level from the $item parameter against the $max
     * parameter. If the item is incorrect, then just the $max parameter value
     * will be returned.
     *
     * Used to get the max level based on the capabilities the user has. This
     * is also based on roles, so if the user is assigned the Administrator role
     * then the capability 'level_10' will exist and the user will get that
     * value.
     *
     * @since 2.0.0
     *
     * @param int    $max  Max level of user.
     * @param string $item Level capability name.
     * @return int Max Level.
     */
    public function level_reduction($max, $item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("level_reduction") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 577")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called level_reduction:577@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Update the maximum user level for the user.
     *
     * Updates the 'user_level' user metadata (includes prefix that is the
     * database table prefix) with the maximum user level. Gets the value from
     * the all of the capabilities that the user has.
     *
     * @since 2.0.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     */
    public function update_user_level_from_caps()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_user_level_from_caps") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 597")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_user_level_from_caps:597@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Add capability and grant or deny access to capability.
     *
     * @since 2.0.0
     *
     * @param string $cap   Capability name.
     * @param bool   $grant Whether to grant capability to user.
     */
    public function add_cap($cap, $grant = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_cap") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 611")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add_cap:611@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Remove capability from user.
     *
     * @since 2.0.0
     *
     * @param string $cap Capability name.
     */
    public function remove_cap($cap)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove_cap") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 625")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove_cap:625@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Remove all of the capabilities of the user.
     *
     * @since 2.1.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     */
    public function remove_all_caps()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove_all_caps") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 642")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove_all_caps:642@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Returns whether the user has the specified capability.
     *
     * This function also accepts an ID of an object to check against if the capability is a meta capability. Meta
     * capabilities such as `edit_post` and `edit_user` are capabilities used by the `map_meta_cap()` function to
     * map to primitive capabilities that a user or role has, such as `edit_posts` and `edit_others_posts`.
     *
     * Example usage:
     *
     *     $user->has_cap( 'edit_posts' );
     *     $user->has_cap( 'edit_post', $post->ID );
     *     $user->has_cap( 'edit_post_meta', $post->ID, $meta_key );
     *
     * While checking against a role in place of a capability is supported in part, this practice is discouraged as it
     * may produce unreliable results.
     *
     * @since 2.0.0
     * @since 5.3.0 Formalized the existing and already documented `...$args` parameter
     *              by adding it to the function signature.
     *
     * @see map_meta_cap()
     *
     * @param string $cap     Capability name.
     * @param mixed  ...$args Optional further parameters, typically starting with an object ID.
     * @return bool Whether the user has the given capability, or, if an object ID is passed, whether the user has
     *              the given capability for that object.
     */
    public function has_cap($cap, ...$args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("has_cap") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 677")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called has_cap:677@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Convert numeric level to level capability name.
     *
     * Prepends 'level_' to level number.
     *
     * @since 2.0.0
     *
     * @param int $level Level number, 1 to 10.
     * @return string
     */
    public function translate_level_to_cap($level)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("translate_level_to_cap") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 734")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called translate_level_to_cap:734@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Set the site to operate on. Defaults to the current site.
     *
     * @since 3.0.0
     * @deprecated 4.9.0 Use WP_User::for_site()
     *
     * @param int $blog_id Optional. Site ID, defaults to current site.
     */
    public function for_blog($blog_id = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("for_blog") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 746")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called for_blog:746@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Sets the site to operate on. Defaults to the current site.
     *
     * @since 4.9.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param int $site_id Site ID to initialize user capabilities for. Default is the current site.
     */
    public function for_site($site_id = '')
    {
        global $wpdb;
        if (!empty($site_id)) {
            $this->site_id = absint($site_id);
        } else {
            $this->site_id = get_current_blog_id();
        }
        $this->cap_key = $wpdb->get_blog_prefix($this->site_id) . 'capabilities';
        $this->caps = $this->get_caps_data();
        $this->get_role_caps();
    }
    /**
     * Gets the ID of the site for which the user's capabilities are currently initialized.
     *
     * @since 4.9.0
     *
     * @return int Site ID.
     */
    public function get_site_id()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_site_id") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php at line 779")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_site_id:779@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-user.php');
        die();
    }
    /**
     * Gets the available user capabilities data.
     *
     * @since 4.9.0
     *
     * @return bool[] List of capabilities keyed by the capability name,
     *                e.g. array( 'edit_posts' => true, 'delete_posts' => false ).
     */
    private function get_caps_data()
    {
        $caps = get_user_meta($this->ID, $this->cap_key, true);
        if (!is_array($caps)) {
            return array();
        }
        return $caps;
    }
}