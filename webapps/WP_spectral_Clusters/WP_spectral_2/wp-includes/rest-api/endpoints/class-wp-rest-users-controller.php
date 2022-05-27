<?php

/**
 * REST API: WP_REST_Users_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core class used to manage users via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Users_Controller extends WP_REST_Controller
{
    /**
     * Instance of a user meta fields object.
     *
     * @since 4.7.0
     * @var WP_REST_User_Meta_Fields
     */
    protected $meta;
    /**
     * Constructor.
     *
     * @since 4.7.0
     */
    public function __construct()
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'users';
        $this->meta = new WP_REST_User_Meta_Fields();
    }
    /**
     * Registers the routes for the objects of the controller.
     *
     * @since 4.7.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/' . $this->rest_base, array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_items'), 'permission_callback' => array($this, 'get_items_permissions_check'), 'args' => $this->get_collection_params()), array('methods' => WP_REST_Server::CREATABLE, 'callback' => array($this, 'create_item'), 'permission_callback' => array($this, 'create_item_permissions_check'), 'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::CREATABLE)), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\\d]+)', array('args' => array('id' => array('description' => __('Unique identifier for the user.'), 'type' => 'integer')), array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_item'), 'permission_callback' => array($this, 'get_item_permissions_check'), 'args' => array('context' => $this->get_context_param(array('default' => 'view')))), array('methods' => WP_REST_Server::EDITABLE, 'callback' => array($this, 'update_item'), 'permission_callback' => array($this, 'update_item_permissions_check'), 'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::EDITABLE)), array('methods' => WP_REST_Server::DELETABLE, 'callback' => array($this, 'delete_item'), 'permission_callback' => array($this, 'delete_item_permissions_check'), 'args' => array('force' => array('type' => 'boolean', 'default' => false, 'description' => __('Required to be true, as users do not support trashing.')), 'reassign' => array('type' => 'integer', 'description' => __('Reassign the deleted user\'s posts and links to this user ID.'), 'required' => true, 'sanitize_callback' => array($this, 'check_reassign')))), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, '/' . $this->rest_base . '/me', array(array('methods' => WP_REST_Server::READABLE, 'permission_callback' => '__return_true', 'callback' => array($this, 'get_current_item'), 'args' => array('context' => $this->get_context_param(array('default' => 'view')))), array('methods' => WP_REST_Server::EDITABLE, 'callback' => array($this, 'update_current_item'), 'permission_callback' => array($this, 'update_current_item_permissions_check'), 'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::EDITABLE)), array('methods' => WP_REST_Server::DELETABLE, 'callback' => array($this, 'delete_current_item'), 'permission_callback' => array($this, 'delete_current_item_permissions_check'), 'args' => array('force' => array('type' => 'boolean', 'default' => false, 'description' => __('Required to be true, as users do not support trashing.')), 'reassign' => array('type' => 'integer', 'description' => __('Reassign the deleted user\'s posts and links to this user ID.'), 'required' => true, 'sanitize_callback' => array($this, 'check_reassign')))), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks for a valid value for the reassign parameter when deleting users.
     *
     * The value can be an integer, 'false', false, or ''.
     *
     * @since 4.7.0
     *
     * @param int|bool        $value   The value passed to the reassign parameter.
     * @param WP_REST_Request $request Full details about the request.
     * @param string          $param   The parameter that is being sanitized.
     * @return int|bool|WP_Error
     */
    public function check_reassign($value, $request, $param)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_reassign") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 64")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_reassign:64@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Permissions check for getting all users.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, otherwise WP_Error object.
     */
    public function get_items_permissions_check($request)
    {
        // Check if roles is specified in GET request and if user can list users.
        if (!empty($request['roles']) && !current_user_can('list_users')) {
            return new WP_Error('rest_user_cannot_view', __('Sorry, you are not allowed to filter users by role.'), array('status' => rest_authorization_required_code()));
        }
        if ('edit' === $request['context'] && !current_user_can('list_users')) {
            return new WP_Error('rest_forbidden_context', __('Sorry, you are not allowed to list users.'), array('status' => rest_authorization_required_code()));
        }
        if (in_array($request['orderby'], array('email', 'registered_date'), true) && !current_user_can('list_users')) {
            return new WP_Error('rest_forbidden_orderby', __('Sorry, you are not allowed to order users by this parameter.'), array('status' => rest_authorization_required_code()));
        }
        if ('authors' === $request['who']) {
            $types = get_post_types(array('show_in_rest' => true), 'objects');
            foreach ($types as $type) {
                if (post_type_supports($type->name, 'author') && current_user_can($type->cap->edit_posts)) {
                    return true;
                }
            }
            return new WP_Error('rest_forbidden_who', __('Sorry, you are not allowed to query users by this parameter.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Retrieves all users.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        // Retrieve the list of registered collection query parameters.
        $registered = $this->get_collection_params();
        /*
         * This array defines mappings between public API query parameters whose
         * values are accepted as-passed, and their internal WP_Query parameter
         * name equivalents (some are the same). Only values which are also
         * present in $registered will be set.
         */
        $parameter_mappings = array('exclude' => 'exclude', 'include' => 'include', 'order' => 'order', 'per_page' => 'number', 'search' => 'search', 'roles' => 'role__in', 'slug' => 'nicename__in');
        $prepared_args = array();
        /*
         * For each known parameter which is both registered and present in the request,
         * set the parameter's value on the query $prepared_args.
         */
        foreach ($parameter_mappings as $api_param => $wp_param) {
            if (isset($registered[$api_param], $request[$api_param])) {
                $prepared_args[$wp_param] = $request[$api_param];
            }
        }
        if (isset($registered['offset']) && !empty($request['offset'])) {
            $prepared_args['offset'] = $request['offset'];
        } else {
            $prepared_args['offset'] = ($request['page'] - 1) * $prepared_args['number'];
        }
        if (isset($registered['orderby'])) {
            $orderby_possibles = array('id' => 'ID', 'include' => 'include', 'name' => 'display_name', 'registered_date' => 'registered', 'slug' => 'user_nicename', 'include_slugs' => 'nicename__in', 'email' => 'user_email', 'url' => 'user_url');
            $prepared_args['orderby'] = $orderby_possibles[$request['orderby']];
        }
        if (isset($registered['who']) && !empty($request['who']) && 'authors' === $request['who']) {
            $prepared_args['who'] = 'authors';
        } elseif (!current_user_can('list_users')) {
            $prepared_args['has_published_posts'] = get_post_types(array('show_in_rest' => true), 'names');
        }
        if (!empty($prepared_args['search'])) {
            $prepared_args['search'] = '*' . $prepared_args['search'] . '*';
        }
        /**
         * Filters WP_User_Query arguments when querying users via the REST API.
         *
         * @link https://developer.wordpress.org/reference/classes/wp_user_query/
         *
         * @since 4.7.0
         *
         * @param array           $prepared_args Array of arguments for WP_User_Query.
         * @param WP_REST_Request $request       The REST API request.
         */
        $prepared_args = apply_filters('rest_user_query', $prepared_args, $request);
        $query = new WP_User_Query($prepared_args);
        $users = array();
        foreach ($query->results as $user) {
            $data = $this->prepare_item_for_response($user, $request);
            $users[] = $this->prepare_response_for_collection($data);
        }
        $response = rest_ensure_response($users);
        // Store pagination values for headers then unset for count query.
        $per_page = (int) $prepared_args['number'];
        $page = ceil((int) $prepared_args['offset'] / $per_page + 1);
        $prepared_args['fields'] = 'ID';
        $total_users = $query->get_total();
        if ($total_users < 1) {
            // Out-of-bounds, run the query again without LIMIT for total count.
            unset($prepared_args['number'], $prepared_args['offset']);
            $count_query = new WP_User_Query($prepared_args);
            $total_users = $count_query->get_total();
        }
        $response->header('X-WP-Total', (int) $total_users);
        $max_pages = ceil($total_users / $per_page);
        $response->header('X-WP-TotalPages', (int) $max_pages);
        $base = add_query_arg(urlencode_deep($request->get_query_params()), rest_url(sprintf('%s/%s', $this->namespace, $this->rest_base)));
        if ($page > 1) {
            $prev_page = $page - 1;
            if ($prev_page > $max_pages) {
                $prev_page = $max_pages;
            }
            $prev_link = add_query_arg('page', $prev_page, $base);
            $response->link_header('prev', $prev_link);
        }
        if ($max_pages > $page) {
            $next_page = $page + 1;
            $next_link = add_query_arg('page', $next_page, $base);
            $response->link_header('next', $next_link);
        }
        return $response;
    }
    /**
     * Get the user, if the ID is valid.
     *
     * @since 4.7.2
     *
     * @param int $id Supplied ID.
     * @return WP_User|WP_Error True if ID is valid, WP_Error otherwise.
     */
    protected function get_user($id)
    {
        $error = new WP_Error('rest_user_invalid_id', __('Invalid user ID.'), array('status' => 404));
        if ((int) $id <= 0) {
            return $error;
        }
        $user = get_userdata((int) $id);
        if (empty($user) || !$user->exists()) {
            return $error;
        }
        if (is_multisite() && !is_user_member_of_blog($user->ID)) {
            return $error;
        }
        return $user;
    }
    /**
     * Checks if a given request has access to read a user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, otherwise WP_Error object.
     */
    public function get_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 230")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_permissions_check:230@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Retrieves a single user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 255")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:255@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Retrieves the current user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_current_item($request)
    {
        $current_user_id = get_current_user_id();
        if (empty($current_user_id)) {
            return new WP_Error('rest_not_logged_in', __('You are not currently logged in.'), array('status' => 401));
        }
        $user = wp_get_current_user();
        $response = $this->prepare_item_for_response($user, $request);
        $response = rest_ensure_response($response);
        return $response;
    }
    /**
     * Checks if a given request has access create users.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to create items, WP_Error object otherwise.
     */
    public function create_item_permissions_check($request)
    {
        if (!current_user_can('create_users')) {
            return new WP_Error('rest_cannot_create_user', __('Sorry, you are not allowed to create new users.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Creates a single user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function create_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 307")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item:307@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to update a user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to update the item, WP_Error object otherwise.
     */
    public function update_item_permissions_check($request)
    {
        $user = $this->get_user($request['id']);
        if (is_wp_error($user)) {
            return $user;
        }
        if (!empty($request['roles'])) {
            if (!current_user_can('promote_user', $user->ID)) {
                return new WP_Error('rest_cannot_edit_roles', __('Sorry, you are not allowed to edit roles of this user.'), array('status' => rest_authorization_required_code()));
            }
            $request_params = array_keys($request->get_params());
            sort($request_params);
            // If only 'id' and 'roles' are specified (we are only trying to
            // edit roles), then only the 'promote_user' cap is required.
            if (array('id', 'roles') === $request_params) {
                return true;
            }
        }
        if (!current_user_can('edit_user', $user->ID)) {
            return new WP_Error('rest_cannot_edit', __('Sorry, you are not allowed to edit this user.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Updates a single user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function update_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 437")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item:437@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to update the current user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to update the item, WP_Error object otherwise.
     */
    public function update_current_item_permissions_check($request)
    {
        $request['id'] = get_current_user_id();
        return $this->update_item_permissions_check($request);
    }
    /**
     * Updates the current user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function update_current_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_current_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 516")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_current_item:516@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Checks if a given request has access delete a user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to delete the item, WP_Error object otherwise.
     */
    public function delete_item_permissions_check($request)
    {
        $user = $this->get_user($request['id']);
        if (is_wp_error($user)) {
            return $user;
        }
        if (!current_user_can('delete_user', $user->ID)) {
            return new WP_Error('rest_user_cannot_delete', __('Sorry, you are not allowed to delete this user.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Deletes a single user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function delete_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 549")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item:549@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to delete the current user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to delete the item, WP_Error object otherwise.
     */
    public function delete_current_item_permissions_check($request)
    {
        $request['id'] = get_current_user_id();
        return $this->delete_item_permissions_check($request);
    }
    /**
     * Deletes the current user.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function delete_current_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_current_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 618")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_current_item:618@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Prepares a single user output for response.
     *
     * @since 4.7.0
     *
     * @param WP_User         $user    User object.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response($user, $request)
    {
        $data = array();
        $fields = $this->get_fields_for_response($request);
        if (in_array('id', $fields, true)) {
            $data['id'] = $user->ID;
        }
        if (in_array('username', $fields, true)) {
            $data['username'] = $user->user_login;
        }
        if (in_array('name', $fields, true)) {
            $data['name'] = $user->display_name;
        }
        if (in_array('first_name', $fields, true)) {
            $data['first_name'] = $user->first_name;
        }
        if (in_array('last_name', $fields, true)) {
            $data['last_name'] = $user->last_name;
        }
        if (in_array('email', $fields, true)) {
            $data['email'] = $user->user_email;
        }
        if (in_array('url', $fields, true)) {
            $data['url'] = $user->user_url;
        }
        if (in_array('description', $fields, true)) {
            $data['description'] = $user->description;
        }
        if (in_array('link', $fields, true)) {
            $data['link'] = get_author_posts_url($user->ID, $user->user_nicename);
        }
        if (in_array('locale', $fields, true)) {
            $data['locale'] = get_user_locale($user);
        }
        if (in_array('nickname', $fields, true)) {
            $data['nickname'] = $user->nickname;
        }
        if (in_array('slug', $fields, true)) {
            $data['slug'] = $user->user_nicename;
        }
        if (in_array('roles', $fields, true)) {
            // Defensively call array_values() to ensure an array is returned.
            $data['roles'] = array_values($user->roles);
        }
        if (in_array('registered_date', $fields, true)) {
            $data['registered_date'] = gmdate('c', strtotime($user->user_registered));
        }
        if (in_array('capabilities', $fields, true)) {
            $data['capabilities'] = (object) $user->allcaps;
        }
        if (in_array('extra_capabilities', $fields, true)) {
            $data['extra_capabilities'] = (object) $user->caps;
        }
        if (in_array('avatar_urls', $fields, true)) {
            $data['avatar_urls'] = rest_get_avatar_urls($user);
        }
        if (in_array('meta', $fields, true)) {
            $data['meta'] = $this->meta->get_value($user->ID, $request);
        }
        $context = !empty($request['context']) ? $request['context'] : 'embed';
        $data = $this->add_additional_fields_to_object($data, $request);
        $data = $this->filter_response_by_context($data, $context);
        // Wrap the data in a response object.
        $response = rest_ensure_response($data);
        $response->add_links($this->prepare_links($user));
        /**
         * Filters user data returned from the REST API.
         *
         * @since 4.7.0
         *
         * @param WP_REST_Response $response The response object.
         * @param WP_User          $user     User object used to create response.
         * @param WP_REST_Request  $request  Request object.
         */
        return apply_filters('rest_prepare_user', $response, $user, $request);
    }
    /**
     * Prepares links for the user request.
     *
     * @since 4.7.0
     *
     * @param WP_User $user User object.
     * @return array Links for the given user.
     */
    protected function prepare_links($user)
    {
        $links = array('self' => array('href' => rest_url(sprintf('%s/%s/%d', $this->namespace, $this->rest_base, $user->ID))), 'collection' => array('href' => rest_url(sprintf('%s/%s', $this->namespace, $this->rest_base))));
        return $links;
    }
    /**
     * Prepares a single user for creation or update.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Request object.
     * @return object User object.
     */
    protected function prepare_item_for_database($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_database") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 729")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_database:729@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Determines if the current user is allowed to make the desired roles change.
     *
     * @since 4.7.0
     *
     * @param int   $user_id User ID.
     * @param array $roles   New user roles.
     * @return true|WP_Error True if the current user is allowed to make the role change,
     *                       otherwise a WP_Error object.
     */
    protected function check_role_update($user_id, $roles)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_role_update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 795")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_role_update:795@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Check a username for the REST API.
     *
     * Performs a couple of checks like edit_user() in wp-admin/includes/user.php.
     *
     * @since 4.7.0
     *
     * @param string          $value   The username submitted in the request.
     * @param WP_REST_Request $request Full details about the request.
     * @param string          $param   The parameter name.
     * @return string|WP_Error The sanitized username, if valid, otherwise an error.
     */
    public function check_username($value, $request, $param)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_username") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 837")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_username:837@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Check a user password for the REST API.
     *
     * Performs a couple of checks like edit_user() in wp-admin/includes/user.php.
     *
     * @since 4.7.0
     *
     * @param string          $value   The password submitted in the request.
     * @param WP_REST_Request $request Full details about the request.
     * @param string          $param   The parameter name.
     * @return string|WP_Error The sanitized password, if valid, otherwise an error.
     */
    public function check_user_password($value, $request, $param)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_user_password") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 862")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_user_password:862@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
    /**
     * Retrieves the user's schema, conforming to JSON Schema.
     *
     * @since 4.7.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        if ($this->schema) {
            return $this->add_additional_fields_schema($this->schema);
        }
        $schema = array('$schema' => 'http://json-schema.org/draft-04/schema#', 'title' => 'user', 'type' => 'object', 'properties' => array('id' => array('description' => __('Unique identifier for the user.'), 'type' => 'integer', 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'username' => array('description' => __('Login name for the user.'), 'type' => 'string', 'context' => array('edit'), 'required' => true, 'arg_options' => array('sanitize_callback' => array($this, 'check_username'))), 'name' => array('description' => __('Display name for the user.'), 'type' => 'string', 'context' => array('embed', 'view', 'edit'), 'arg_options' => array('sanitize_callback' => 'sanitize_text_field')), 'first_name' => array('description' => __('First name for the user.'), 'type' => 'string', 'context' => array('edit'), 'arg_options' => array('sanitize_callback' => 'sanitize_text_field')), 'last_name' => array('description' => __('Last name for the user.'), 'type' => 'string', 'context' => array('edit'), 'arg_options' => array('sanitize_callback' => 'sanitize_text_field')), 'email' => array('description' => __('The email address for the user.'), 'type' => 'string', 'format' => 'email', 'context' => array('edit'), 'required' => true), 'url' => array('description' => __('URL of the user.'), 'type' => 'string', 'format' => 'uri', 'context' => array('embed', 'view', 'edit')), 'description' => array('description' => __('Description of the user.'), 'type' => 'string', 'context' => array('embed', 'view', 'edit')), 'link' => array('description' => __('Author URL of the user.'), 'type' => 'string', 'format' => 'uri', 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'locale' => array('description' => __('Locale for the user.'), 'type' => 'string', 'enum' => array_merge(array('', 'en_US'), get_available_languages()), 'context' => array('edit')), 'nickname' => array('description' => __('The nickname for the user.'), 'type' => 'string', 'context' => array('edit'), 'arg_options' => array('sanitize_callback' => 'sanitize_text_field')), 'slug' => array('description' => __('An alphanumeric identifier for the user.'), 'type' => 'string', 'context' => array('embed', 'view', 'edit'), 'arg_options' => array('sanitize_callback' => array($this, 'sanitize_slug'))), 'registered_date' => array('description' => __('Registration date for the user.'), 'type' => 'string', 'format' => 'date-time', 'context' => array('edit'), 'readonly' => true), 'roles' => array('description' => __('Roles assigned to the user.'), 'type' => 'array', 'items' => array('type' => 'string'), 'context' => array('edit')), 'password' => array(
            'description' => __('Password for the user (never included).'),
            'type' => 'string',
            'context' => array(),
            // Password is never displayed.
            'required' => true,
            'arg_options' => array('sanitize_callback' => array($this, 'check_user_password')),
        ), 'capabilities' => array('description' => __('All capabilities assigned to the user.'), 'type' => 'object', 'context' => array('edit'), 'readonly' => true), 'extra_capabilities' => array('description' => __('Any extra capabilities assigned to the user.'), 'type' => 'object', 'context' => array('edit'), 'readonly' => true)));
        if (get_option('show_avatars')) {
            $avatar_properties = array();
            $avatar_sizes = rest_get_avatar_sizes();
            foreach ($avatar_sizes as $size) {
                $avatar_properties[$size] = array(
                    /* translators: %d: Avatar image size in pixels. */
                    'description' => sprintf(__('Avatar URL with image size of %d pixels.'), $size),
                    'type' => 'string',
                    'format' => 'uri',
                    'context' => array('embed', 'view', 'edit'),
                );
            }
            $schema['properties']['avatar_urls'] = array('description' => __('Avatar URLs for the user.'), 'type' => 'object', 'context' => array('embed', 'view', 'edit'), 'readonly' => true, 'properties' => $avatar_properties);
        }
        $schema['properties']['meta'] = $this->meta->get_field_schema();
        $this->schema = $schema;
        return $this->add_additional_fields_schema($this->schema);
    }
    /**
     * Retrieves the query params for collections.
     *
     * @since 4.7.0
     *
     * @return array Collection parameters.
     */
    public function get_collection_params()
    {
        $query_params = parent::get_collection_params();
        $query_params['context']['default'] = 'view';
        $query_params['exclude'] = array('description' => __('Ensure result set excludes specific IDs.'), 'type' => 'array', 'items' => array('type' => 'integer'), 'default' => array());
        $query_params['include'] = array('description' => __('Limit result set to specific IDs.'), 'type' => 'array', 'items' => array('type' => 'integer'), 'default' => array());
        $query_params['offset'] = array('description' => __('Offset the result set by a specific number of items.'), 'type' => 'integer');
        $query_params['order'] = array('default' => 'asc', 'description' => __('Order sort attribute ascending or descending.'), 'enum' => array('asc', 'desc'), 'type' => 'string');
        $query_params['orderby'] = array('default' => 'name', 'description' => __('Sort collection by object attribute.'), 'enum' => array('id', 'include', 'name', 'registered_date', 'slug', 'include_slugs', 'email', 'url'), 'type' => 'string');
        $query_params['slug'] = array('description' => __('Limit result set to users with one or more specific slugs.'), 'type' => 'array', 'items' => array('type' => 'string'));
        $query_params['roles'] = array('description' => __('Limit result set to users matching at least one specific role provided. Accepts csv list or single role.'), 'type' => 'array', 'items' => array('type' => 'string'));
        $query_params['who'] = array('description' => __('Limit result set to users who are considered authors.'), 'type' => 'string', 'enum' => array('authors'));
        /**
         * Filters REST API collection parameters for the users controller.
         *
         * This filter registers the collection parameter, but does not map the
         * collection parameter to an internal WP_User_Query parameter.  Use the
         * `rest_user_query` filter to set WP_User_Query arguments.
         *
         * @since 4.7.0
         *
         * @param array $query_params JSON Schema-formatted collection parameters.
         */
        return apply_filters('rest_user_collection_params', $query_params);
    }
}