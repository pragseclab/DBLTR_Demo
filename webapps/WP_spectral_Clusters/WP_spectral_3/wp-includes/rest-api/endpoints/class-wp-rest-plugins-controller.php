<?php

/**
 * REST API: WP_REST_Plugins_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 5.5.0
 */
/**
 * Core class to access plugins via the REST API.
 *
 * @since 5.5.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Plugins_Controller extends WP_REST_Controller
{
    const PATTERN = '[^.\\/]+(?:\\/[^.\\/]+)?';
    /**
     * Plugins controller constructor.
     *
     * @since 5.5.0
     */
    public function __construct()
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'plugins';
    }
    /**
     * Registers the routes for the plugins controller.
     *
     * @since 5.5.0
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/' . $this->rest_base, array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_items'), 'permission_callback' => array($this, 'get_items_permissions_check'), 'args' => $this->get_collection_params()), array('methods' => WP_REST_Server::CREATABLE, 'callback' => array($this, 'create_item'), 'permission_callback' => array($this, 'create_item_permissions_check'), 'args' => array('slug' => array('type' => 'string', 'required' => true, 'description' => __('WordPress.org plugin directory slug.'), 'pattern' => '[\\w\\-]+'), 'status' => array('description' => __('The plugin activation status.'), 'type' => 'string', 'enum' => is_multisite() ? array('inactive', 'active', 'network-active') : array('inactive', 'active'), 'default' => 'inactive'))), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<plugin>' . self::PATTERN . ')', array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_item'), 'permission_callback' => array($this, 'get_item_permissions_check')), array('methods' => WP_REST_Server::EDITABLE, 'callback' => array($this, 'update_item'), 'permission_callback' => array($this, 'update_item_permissions_check'), 'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::EDITABLE)), array('methods' => WP_REST_Server::DELETABLE, 'callback' => array($this, 'delete_item'), 'permission_callback' => array($this, 'delete_item_permissions_check')), 'args' => array('context' => $this->get_context_param(array('default' => 'view')), 'plugin' => array('type' => 'string', 'pattern' => self::PATTERN, 'validate_callback' => array($this, 'validate_plugin_param'), 'sanitize_callback' => array($this, 'sanitize_plugin_param'))), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks if a given request has access to get plugins.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check($request)
    {
        if (!current_user_can('activate_plugins')) {
            return new WP_Error('rest_cannot_view_plugins', __('Sorry, you are not allowed to manage plugins for this site.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Retrieves a collection of plugins.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        $plugins = array();
        foreach (get_plugins() as $file => $data) {
            if (is_wp_error($this->check_read_permission($file))) {
                continue;
            }
            $data['_file'] = $file;
            if (!$this->does_plugin_match_request($request, $data)) {
                continue;
            }
            $plugins[] = $this->prepare_response_for_collection($this->prepare_item_for_response($data, $request));
        }
        return new WP_REST_Response($plugins);
    }
    /**
     * Checks if a given request has access to get a specific plugin.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, WP_Error object otherwise.
     */
    public function get_item_permissions_check($request)
    {
        if (!current_user_can('activate_plugins')) {
            return new WP_Error('rest_cannot_view_plugin', __('Sorry, you are not allowed to manage plugins for this site.'), array('status' => rest_authorization_required_code()));
        }
        $can_read = $this->check_read_permission($request['plugin']);
        if (is_wp_error($can_read)) {
            return $can_read;
        }
        return true;
    }
    /**
     * Retrieves one plugin from the site.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 108")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:108@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Checks if the given plugin can be viewed by the current user.
     *
     * On multisite, this hides non-active network only plugins if the user does not have permission
     * to manage network plugins.
     *
     * @since 5.5.0
     *
     * @param string $plugin The plugin file to check.
     * @return true|WP_Error True if can read, a WP_Error instance otherwise.
     */
    protected function check_read_permission($plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_read_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 128")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_read_permission:128@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to upload plugins.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to create items, WP_Error object otherwise.
     */
    public function create_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 150")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item_permissions_check:150@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Uploads a plugin and optionally activates it.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function create_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 168")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item:168@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to update a specific plugin.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to update the item, WP_Error object otherwise.
     */
    public function update_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 259")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item_permissions_check:259@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Updates one plugin.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function update_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 286")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item:286@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to delete a specific plugin.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to delete the item, WP_Error object otherwise.
     */
    public function delete_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 312")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item_permissions_check:312@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Deletes one plugin from the site.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function delete_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 334")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item:334@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Prepares the plugin for the REST response.
     *
     * @since 5.5.0
     *
     * @param mixed           $item    Unmarked up and untranslated plugin data from {@see get_plugin_data()}.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function prepare_item_for_response($item, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 366")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:366@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Prepares links for the request.
     *
     * @since 5.5.0
     *
     * @param array $item The plugin item.
     * @return array[]
     */
    protected function prepare_links($item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 393")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_links:393@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Gets the plugin header data for a plugin.
     *
     * @since 5.5.0
     *
     * @param string $plugin The plugin file to get data for.
     * @return array|WP_Error The plugin data, or a WP_Error if the plugin is not installed.
     */
    protected function get_plugin_data($plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_plugin_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 405")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_plugin_data:405@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Get's the activation status for a plugin.
     *
     * @since 5.5.0
     *
     * @param string $plugin The plugin file to check.
     * @return string Either 'network-active', 'active' or 'inactive'.
     */
    protected function get_plugin_status($plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_plugin_status") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 423")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_plugin_status:423@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Handle updating a plugin's status.
     *
     * @since 5.5.0
     *
     * @param string $plugin         The plugin file to update.
     * @param string $new_status     The plugin's new status.
     * @param string $current_status The plugin's current status.
     *
     * @return true|WP_Error
     */
    protected function plugin_status_permission_check($plugin, $new_status, $current_status)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("plugin_status_permission_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 444")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called plugin_status_permission_check:444@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Handle updating a plugin's status.
     *
     * @since 5.5.0
     *
     * @param string $plugin         The plugin file to update.
     * @param string $new_status     The plugin's new status.
     * @param string $current_status The plugin's current status.
     * @return true|WP_Error
     */
    protected function handle_plugin_status($plugin, $new_status, $current_status)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handle_plugin_status") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 467")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handle_plugin_status:467@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Checks that the "plugin" parameter is a valid path.
     *
     * @since 5.5.0
     *
     * @param string $file The plugin file parameter.
     * @return bool
     */
    public function validate_plugin_param($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validate_plugin_param") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 495")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validate_plugin_param:495@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Sanitizes the "plugin" parameter to be a proper plugin file with ".php" appended.
     *
     * @since 5.5.0
     *
     * @param string $file The plugin file parameter.
     * @return string
     */
    public function sanitize_plugin_param($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitize_plugin_param") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 511")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sanitize_plugin_param:511@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Checks if the plugin matches the requested parameters.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request The request to require the plugin matches against.
     * @param array           $item    The plugin item.
     *
     * @return bool
     */
    protected function does_plugin_match_request($request, $item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("does_plugin_match_request") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 525")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called does_plugin_match_request:525@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Checks if the plugin is installed.
     *
     * @since 5.5.0
     *
     * @param string $plugin The plugin file.
     * @return bool
     */
    protected function is_plugin_installed($plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_plugin_installed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 554")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_plugin_installed:554@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Determine if the endpoints are available.
     *
     * Only the 'Direct' filesystem transport, and SSH/FTP when credentials are stored are supported at present.
     *
     * @since 5.5.0
     *
     * @return true|WP_Error True if filesystem is available, WP_Error otherwise.
     */
    protected function is_filesystem_available()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_filesystem_available") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 567")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_filesystem_available:567@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Retrieves the plugin's schema, conforming to JSON Schema.
     *
     * @since 5.5.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 588")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:588@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
    /**
     * Retrieves the query params for the collections.
     *
     * @since 5.5.0
     *
     * @return array Query parameters for the collection.
     */
    public function get_collection_params()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_collection_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php at line 603")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_collection_params:603@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/endpoints/class-wp-rest-plugins-controller.php');
        die();
    }
}