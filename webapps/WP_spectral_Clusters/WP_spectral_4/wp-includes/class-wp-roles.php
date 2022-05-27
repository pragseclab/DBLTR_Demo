<?php

/**
 * User API: WP_Roles class
 *
 * @package WordPress
 * @subpackage Users
 * @since 4.4.0
 */
/**
 * Core class used to implement a user roles API.
 *
 * The role option is simple, the structure is organized by role name that store
 * the name in value of the 'name' key. The capabilities are stored as an array
 * in the value of the 'capability' key.
 *
 *     array (
 *          'rolename' => array (
 *              'name' => 'rolename',
 *              'capabilities' => array()
 *          )
 *     )
 *
 * @since 2.0.0
 */
class WP_Roles
{
    /**
     * List of roles and capabilities.
     *
     * @since 2.0.0
     * @var array[]
     */
    public $roles;
    /**
     * List of the role objects.
     *
     * @since 2.0.0
     * @var WP_Role[]
     */
    public $role_objects = array();
    /**
     * List of role names.
     *
     * @since 2.0.0
     * @var string[]
     */
    public $role_names = array();
    /**
     * Option name for storing role list.
     *
     * @since 2.0.0
     * @var string
     */
    public $role_key;
    /**
     * Whether to use the database for retrieval and storage.
     *
     * @since 2.1.0
     * @var bool
     */
    public $use_db = true;
    /**
     * The site ID the roles are initialized for.
     *
     * @since 4.9.0
     * @var int
     */
    protected $site_id = 0;
    /**
     * Constructor
     *
     * @since 2.0.0
     * @since 4.9.0 The `$site_id` argument was added.
     *
     * @global array $wp_user_roles Used to set the 'roles' property value.
     *
     * @param int $site_id Site ID to initialize roles for. Default is the current site.
     */
    public function __construct($site_id = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php at line 82")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:82@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php');
        die();
    }
    /**
     * Make private/protected methods readable for backward compatibility.
     *
     * @since 4.0.0
     *
     * @param string $name      Method to call.
     * @param array  $arguments Arguments to pass when calling.
     * @return mixed|false Return value of the callback, false otherwise.
     */
    public function __call($name, $arguments)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__call") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php at line 97")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __call:97@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php');
        die();
    }
    /**
     * Set up the object properties.
     *
     * The role key is set to the current prefix for the $wpdb object with
     * 'user_roles' appended. If the $wp_user_roles global is set, then it will
     * be used and the role option will not be updated or used.
     *
     * @since 2.1.0
     * @deprecated 4.9.0 Use WP_Roles::for_site()
     */
    protected function _init()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_init") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php at line 114")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _init:114@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php');
        die();
    }
    /**
     * Reinitialize the object
     *
     * Recreates the role objects. This is typically called only by switch_to_blog()
     * after switching wpdb to a new site ID.
     *
     * @since 3.5.0
     * @deprecated 4.7.0 Use WP_Roles::for_site()
     */
    public function reinit()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("reinit") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php at line 128")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called reinit:128@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php');
        die();
    }
    /**
     * Add role name with capabilities to list.
     *
     * Updates the list of roles, if the role doesn't already exist.
     *
     * The capabilities are defined in the following format `array( 'read' => true );`
     * To explicitly deny a role a capability you set the value for that capability to false.
     *
     * @since 2.0.0
     *
     * @param string $role         Role name.
     * @param string $display_name Role display name.
     * @param bool[] $capabilities List of capabilities keyed by the capability name,
     *                             e.g. array( 'edit_posts' => true, 'delete_posts' => false ).
     * @return WP_Role|void WP_Role object, if role is added.
     */
    public function add_role($role, $display_name, $capabilities = array())
    {
        if (empty($role) || isset($this->roles[$role])) {
            return;
        }
        $this->roles[$role] = array('name' => $display_name, 'capabilities' => $capabilities);
        if ($this->use_db) {
            update_option($this->role_key, $this->roles);
        }
        $this->role_objects[$role] = new WP_Role($role, $capabilities);
        $this->role_names[$role] = $display_name;
        return $this->role_objects[$role];
    }
    /**
     * Remove role by name.
     *
     * @since 2.0.0
     *
     * @param string $role Role name.
     */
    public function remove_role($role)
    {
        if (!isset($this->role_objects[$role])) {
            return;
        }
        unset($this->role_objects[$role]);
        unset($this->role_names[$role]);
        unset($this->roles[$role]);
        if ($this->use_db) {
            update_option($this->role_key, $this->roles);
        }
        if (get_option('default_role') == $role) {
            update_option('default_role', 'subscriber');
        }
    }
    /**
     * Add capability to role.
     *
     * @since 2.0.0
     *
     * @param string $role  Role name.
     * @param string $cap   Capability name.
     * @param bool   $grant Optional. Whether role is capable of performing capability.
     *                      Default true.
     */
    public function add_cap($role, $cap, $grant = true)
    {
        if (!isset($this->roles[$role])) {
            return;
        }
        $this->roles[$role]['capabilities'][$cap] = $grant;
        if ($this->use_db) {
            update_option($this->role_key, $this->roles);
        }
    }
    /**
     * Remove capability from role.
     *
     * @since 2.0.0
     *
     * @param string $role Role name.
     * @param string $cap  Capability name.
     */
    public function remove_cap($role, $cap)
    {
        if (!isset($this->roles[$role])) {
            return;
        }
        unset($this->roles[$role]['capabilities'][$cap]);
        if ($this->use_db) {
            update_option($this->role_key, $this->roles);
        }
    }
    /**
     * Retrieve role object by name.
     *
     * @since 2.0.0
     *
     * @param string $role Role name.
     * @return WP_Role|null WP_Role object if found, null if the role does not exist.
     */
    public function get_role($role)
    {
        if (isset($this->role_objects[$role])) {
            return $this->role_objects[$role];
        } else {
            return null;
        }
    }
    /**
     * Retrieve list of role names.
     *
     * @since 2.0.0
     *
     * @return string[] List of role names.
     */
    public function get_names()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_names") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php at line 245")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_names:245@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php');
        die();
    }
    /**
     * Whether role name is currently in the list of available roles.
     *
     * @since 2.0.0
     *
     * @param string $role Role name to look up.
     * @return bool
     */
    public function is_role($role)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_role") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php at line 257")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_role:257@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php');
        die();
    }
    /**
     * Initializes all of the available roles.
     *
     * @since 4.9.0
     */
    public function init_roles()
    {
        if (empty($this->roles)) {
            return;
        }
        $this->role_objects = array();
        $this->role_names = array();
        foreach (array_keys($this->roles) as $role) {
            $this->role_objects[$role] = new WP_Role($role, $this->roles[$role]['capabilities']);
            $this->role_names[$role] = $this->roles[$role]['name'];
        }
        /**
         * After the roles have been initialized, allow plugins to add their own roles.
         *
         * @since 4.7.0
         *
         * @param WP_Roles $this A reference to the WP_Roles object.
         */
        do_action('wp_roles_init', $this);
    }
    /**
     * Sets the site to operate on. Defaults to the current site.
     *
     * @since 4.9.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param int $site_id Site ID to initialize roles for. Default is the current site.
     */
    public function for_site($site_id = null)
    {
        global $wpdb;
        if (!empty($site_id)) {
            $this->site_id = absint($site_id);
        } else {
            $this->site_id = get_current_blog_id();
        }
        $this->role_key = $wpdb->get_blog_prefix($this->site_id) . 'user_roles';
        if (!empty($this->roles) && !$this->use_db) {
            return;
        }
        $this->roles = $this->get_roles_data();
        $this->init_roles();
    }
    /**
     * Gets the ID of the site for which roles are currently initialized.
     *
     * @since 4.9.0
     *
     * @return int Site ID.
     */
    public function get_site_id()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_site_id") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php at line 317")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_site_id:317@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-roles.php');
        die();
    }
    /**
     * Gets the available roles data.
     *
     * @since 4.9.0
     *
     * @global array $wp_user_roles Used to set the 'roles' property value.
     *
     * @return array Roles array.
     */
    protected function get_roles_data()
    {
        global $wp_user_roles;
        if (!empty($wp_user_roles)) {
            return $wp_user_roles;
        }
        if (is_multisite() && get_current_blog_id() != $this->site_id) {
            remove_action('switch_blog', 'wp_switch_roles_and_user', 1);
            $roles = get_blog_option($this->site_id, $this->role_key, array());
            add_action('switch_blog', 'wp_switch_roles_and_user', 1, 2);
            return $roles;
        }
        return get_option($this->role_key, array());
    }
}