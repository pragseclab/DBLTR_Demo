<?php

/**
 * REST API: WP_REST_Application_Passwords_Controller class
 *
 * @package    WordPress
 * @subpackage REST_API
 * @since      5.6.0
 */
/**
 * Core class to access a user's application passwords via the REST API.
 *
 * @since 5.6.0
 *
 * @see   WP_REST_Controller
 */
class WP_REST_Application_Passwords_Controller extends WP_REST_Controller
{
    /**
     * Application Passwords controller constructor.
     *
     * @since 5.6.0
     */
    public function __construct()
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'users/(?P<user_id>(?:[\\d]+|me))/application-passwords';
    }
    /**
     * Registers the REST API routes for the application passwords controller.
     *
     * @since 5.6.0
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/' . $this->rest_base, array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_items'), 'permission_callback' => array($this, 'get_items_permissions_check'), 'args' => $this->get_collection_params()), array('methods' => WP_REST_Server::CREATABLE, 'callback' => array($this, 'create_item'), 'permission_callback' => array($this, 'create_item_permissions_check'), 'args' => $this->get_endpoint_args_for_item_schema()), array('methods' => WP_REST_Server::DELETABLE, 'callback' => array($this, 'delete_items'), 'permission_callback' => array($this, 'delete_items_permissions_check')), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, '/' . $this->rest_base . '/introspect', array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_current_item'), 'permission_callback' => array($this, 'get_current_item_permissions_check'), 'args' => array('context' => $this->get_context_param(array('default' => 'view')))), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<uuid>[\\w\\-]+)', array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_item'), 'permission_callback' => array($this, 'get_item_permissions_check'), 'args' => array('context' => $this->get_context_param(array('default' => 'view')))), array('methods' => WP_REST_Server::EDITABLE, 'callback' => array($this, 'update_item'), 'permission_callback' => array($this, 'update_item_permissions_check'), 'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::EDITABLE)), array('methods' => WP_REST_Server::DELETABLE, 'callback' => array($this, 'delete_item'), 'permission_callback' => array($this, 'delete_item_permissions_check')), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks if a given request has access to get application passwords.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check($request)
    {
        $user = $this->get_user($request);
        if (is_wp_error($user)) {
            return $user;
        }
        if (!current_user_can('list_app_passwords', $user->ID)) {
            return new WP_Error('rest_cannot_list_application_passwords', __('Sorry, you are not allowed to list application passwords for this user.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Retrieves a collection of application passwords.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        $user = $this->get_user($request);
        if (is_wp_error($user)) {
            return $user;
        }
        $passwords = WP_Application_Passwords::get_user_application_passwords($user->ID);
        $response = array();
        foreach ($passwords as $password) {
            $response[] = $this->prepare_response_for_collection($this->prepare_item_for_response($password, $request));
        }
        return new WP_REST_Response($response);
    }
    /**
     * Checks if a given request has access to get a specific application password.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, WP_Error object otherwise.
     */
    public function get_item_permissions_check($request)
    {
        $user = $this->get_user($request);
        if (is_wp_error($user)) {
            return $user;
        }
        if (!current_user_can('read_app_password', $user->ID, $request['uuid'])) {
            return new WP_Error('rest_cannot_read_application_password', __('Sorry, you are not allowed to read this application password.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Retrieves one application password from the collection.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 109")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:109@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to create application passwords.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to create items, WP_Error object otherwise.
     */
    public function create_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 125")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item_permissions_check:125@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Creates an application password.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function create_item($request)
    {
        $user = $this->get_user($request);
        if (is_wp_error($user)) {
            return $user;
        }
        $prepared = $this->prepare_item_for_database($request);
        if (is_wp_error($prepared)) {
            return $prepared;
        }
        $created = WP_Application_Passwords::create_new_application_password($user->ID, wp_slash((array) $prepared));
        if (is_wp_error($created)) {
            return $created;
        }
        $password = $created[0];
        $item = WP_Application_Passwords::get_user_application_password($user->ID, $created[1]['uuid']);
        $item['new_password'] = WP_Application_Passwords::chunk_password($password);
        $fields_update = $this->update_additional_fields_for_object($item, $request);
        if (is_wp_error($fields_update)) {
            return $fields_update;
        }
        /**
         * Fires after a single application password is completely created or updated via the REST API.
         *
         * @since 5.6.0
         *
         * @param array           $item     Inserted or updated password item.
         * @param WP_REST_Request $request  Request object.
         * @param bool            $creating True when creating an application password, false when updating.
         */
        do_action('rest_after_insert_application_password', $item, $request, true);
        $request->set_param('context', 'edit');
        $response = $this->prepare_item_for_response($item, $request);
        $response->set_status(201);
        $response->header('Location', $response->get_links()['self'][0]['href']);
        return $response;
    }
    /**
     * Checks if a given request has access to update application passwords.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to create items, WP_Error object otherwise.
     */
    public function update_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 189")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item_permissions_check:189@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Updates an application password.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function update_item($request)
    {
        $user = $this->get_user($request);
        if (is_wp_error($user)) {
            return $user;
        }
        $item = $this->get_application_password($request);
        if (is_wp_error($item)) {
            return $item;
        }
        $prepared = $this->prepare_item_for_database($request);
        if (is_wp_error($prepared)) {
            return $prepared;
        }
        $saved = WP_Application_Passwords::update_application_password($user->ID, $item['uuid'], wp_slash((array) $prepared));
        if (is_wp_error($saved)) {
            return $saved;
        }
        $fields_update = $this->update_additional_fields_for_object($item, $request);
        if (is_wp_error($fields_update)) {
            return $fields_update;
        }
        $item = WP_Application_Passwords::get_user_application_password($user->ID, $item['uuid']);
        /** This action is documented in wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php */
        do_action('rest_after_insert_application_password', $item, $request, false);
        $request->set_param('context', 'edit');
        return $this->prepare_item_for_response($item, $request);
    }
    /**
     * Checks if a given request has access to delete all application passwords.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to delete the item, WP_Error object otherwise.
     */
    public function delete_items_permissions_check($request)
    {
        $user = $this->get_user($request);
        if (is_wp_error($user)) {
            return $user;
        }
        if (!current_user_can('delete_app_passwords', $user->ID)) {
            return new WP_Error('rest_cannot_delete_application_passwords', __('Sorry, you are not allowed to delete application passwords for this user.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Deletes all application passwords.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function delete_items($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 263")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_items:263@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to delete a specific application password.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to delete the item, WP_Error object otherwise.
     */
    public function delete_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 283")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item_permissions_check:283@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Deletes one application password.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function delete_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 302")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item:302@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to get the currently used application password.
     *
     * @since 5.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, WP_Error object otherwise.
     */
    public function get_current_item_permissions_check($request)
    {
        $user = $this->get_user($request);
        if (is_wp_error($user)) {
            return $user;
        }
        if (get_current_user_id() !== $user->ID) {
            return new WP_Error('rest_cannot_introspect_app_password_for_non_authenticated_user', __('The authenticated Application Password can only be introspected for the current user.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Retrieves the application password being currently used for authentication.
     *
     * @since 5.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_current_item($request)
    {
        $user = $this->get_user($request);
        if (is_wp_error($user)) {
            return $user;
        }
        $uuid = rest_get_authenticated_app_password();
        if (!$uuid) {
            return new WP_Error('rest_no_authenticated_app_password', __('Cannot introspect Application Password.'), array('status' => 404));
        }
        $password = WP_Application_Passwords::get_user_application_password($user->ID, $uuid);
        if (!$password) {
            return new WP_Error('rest_application_password_not_found', __('Application password not found.'), array('status' => 500));
        }
        return $this->prepare_item_for_response($password, $request);
    }
    /**
     * Performs a permissions check for the request.
     *
     * @since 5.6.0
     * @deprecated 5.7.0 Use `edit_user` directly or one of the specific meta capabilities introduced in 5.7.0.
     *
     * @param WP_REST_Request $request
     * @return true|WP_Error
     */
    protected function do_permissions_check($request)
    {
        _deprecated_function(__METHOD__, '5.7.0');
        $user = $this->get_user($request);
        if (is_wp_error($user)) {
            return $user;
        }
        if (!current_user_can('edit_user', $user->ID)) {
            return new WP_Error('rest_cannot_manage_application_passwords', __('Sorry, you are not allowed to manage application passwords for this user.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Prepares an application password for a create or update operation.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request Request object.
     * @return object|WP_Error The prepared item, or WP_Error object on failure.
     */
    protected function prepare_item_for_database($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_database") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 392")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_database:392@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Prepares the application password for the REST response.
     *
     * @since 5.6.0
     *
     * @param array           $item    WordPress representation of the item.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function prepare_item_for_response($item, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 417")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:417@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Prepares links for the object.
     *
     * @since 5.6.0
     *
     * @param WP_User $user The requested user.
     * @param array   $item The application password.
     * @return array The list of links.
     */
    protected function prepare_links(WP_User $user, $item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 451")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_links:451@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Gets the requested user.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request The request object.
     * @return WP_User|WP_Error The WordPress user associated with the request, or a WP_Error if none found.
     */
    protected function get_user($request)
    {
        if (!wp_is_application_passwords_available()) {
            return new WP_Error('application_passwords_disabled', __('Application passwords are not available.'), array('status' => 501));
        }
        $error = new WP_Error('rest_user_invalid_id', __('Invalid user ID.'), array('status' => 404));
        $id = $request['user_id'];
        if ('me' === $id) {
            if (!is_user_logged_in()) {
                return new WP_Error('rest_not_logged_in', __('You are not currently logged in.'), array('status' => 401));
            }
            $user = wp_get_current_user();
        } else {
            $id = (int) $id;
            if ($id <= 0) {
                return $error;
            }
            $user = get_userdata($id);
        }
        if (empty($user) || !$user->exists()) {
            return $error;
        }
        if (is_multisite() && !is_user_member_of_blog($user->ID)) {
            return $error;
        }
        if (!wp_is_application_passwords_available_for_user($user)) {
            return new WP_Error('application_passwords_disabled_for_user', __('Application passwords are not available for your account. Please contact the site administrator for assistance.'), array('status' => 501));
        }
        return $user;
    }
    /**
     * Gets the requested application password.
     *
     * @since 5.6.0
     *
     * @param WP_REST_Request $request The request object.
     * @return array|WP_Error The application password details if found, a WP_Error otherwise.
     */
    protected function get_application_password($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_application_password") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 501")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_application_password:501@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Retrieves the query params for the collections.
     *
     * @since 5.6.0
     *
     * @return array Query parameters for the collection.
     */
    public function get_collection_params()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_collection_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 520")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_collection_params:520@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
    /**
     * Retrieves the application password's schema, conforming to JSON Schema.
     *
     * @since 5.6.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php at line 531")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:531@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-application-passwords-controller.php');
        die();
    }
}