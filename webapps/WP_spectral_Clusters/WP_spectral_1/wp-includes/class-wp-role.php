<?php

/**
 * User API: WP_Role class
 *
 * @package WordPress
 * @subpackage Users
 * @since 4.4.0
 */
/**
 * Core class used to extend the user roles API.
 *
 * @since 2.0.0
 */
class WP_Role
{
    /**
     * Role name.
     *
     * @since 2.0.0
     * @var string
     */
    public $name;
    /**
     * List of capabilities the role contains.
     *
     * @since 2.0.0
     * @var bool[] Array of key/value pairs where keys represent a capability name and boolean values
     *             represent whether the role has that capability.
     */
    public $capabilities;
    /**
     * Constructor - Set up object properties.
     *
     * The list of capabilities must have the key as the name of the capability
     * and the value a boolean of whether it is granted to the role.
     *
     * @since 2.0.0
     *
     * @param string $role         Role name.
     * @param bool[] $capabilities Array of key/value pairs where keys represent a capability name and boolean values
     *                             represent whether the role has that capability.
     */
    public function __construct($role, $capabilities)
    {
        $this->name = $role;
        $this->capabilities = $capabilities;
    }
    /**
     * Assign role a capability.
     *
     * @since 2.0.0
     *
     * @param string $cap   Capability name.
     * @param bool   $grant Whether role has capability privilege.
     */
    public function add_cap($cap, $grant = true)
    {
        $this->capabilities[$cap] = $grant;
        wp_roles()->add_cap($this->name, $cap, $grant);
    }
    /**
     * Removes a capability from a role.
     *
     * @since 2.0.0
     *
     * @param string $cap Capability name.
     */
    public function remove_cap($cap)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove_cap") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-role.php at line 71")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove_cap:71@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-role.php');
        die();
    }
    /**
     * Determines whether the role has the given capability.
     *
     * @since 2.0.0
     *
     * @param string $cap Capability name.
     * @return bool Whether the role has the given capability.
     */
    public function has_cap($cap)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("has_cap") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-role.php at line 94")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called has_cap:94@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-role.php');
        die();
    }
}