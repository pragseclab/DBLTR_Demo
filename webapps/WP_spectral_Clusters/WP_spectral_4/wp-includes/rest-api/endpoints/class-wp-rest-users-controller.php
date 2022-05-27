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
        if (is_numeric($value)) {
            return $value;
        }
        if (empty($value) || false === $value || 'false' === $value) {
            return false;
        }
        return new WP_Error('rest_invalid_param', __('Invalid user parameter(s).'), array('status' => 400));
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
        $user = $this->get_user($request['id']);
        if (is_wp_error($user)) {
            return $user;
        }
        $types = get_post_types(array('show_in_rest' => true), 'names');
        if (get_current_user_id() === $user->ID) {
            return true;
        }
        if ('edit' === $request['context'] && !current_user_can('list_users')) {
            return new WP_Error('rest_user_cannot_view', __('Sorry, you are not allowed to list users.'), array('status' => rest_authorization_required_code()));
        } elseif (!count_user_posts($user->ID, $types) && !current_user_can('edit_user', $user->ID) && !current_user_can('list_users')) {
            return new WP_Error('rest_user_cannot_view', __('Sorry, you are not allowed to list users.'), array('status' => rest_authorization_required_code()));
        }
        return true;
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
        $user = $this->get_user($request['id']);
        if (is_wp_error($user)) {
            return $user;
        }
        $user = $this->prepare_item_for_response($user, $request);
        $response = rest_ensure_response($user);
        return $response;
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
        if (!empty($request['id'])) {
            return new WP_Error('rest_user_exists', __('Cannot create existing user.'), array('status' => 400));
        }
        $schema = $this->get_item_schema();
        if (!empty($request['roles']) && !empty($schema['properties']['roles'])) {
            $check_permission = $this->check_role_update($request['id'], $request['roles']);
            if (is_wp_error($check_permission)) {
                return $check_permission;
            }
        }
        $user = $this->prepare_item_for_database($request);
        if (is_multisite()) {
            $ret = wpmu_validate_user_signup($user->user_login, $user->user_email);
            if (is_wp_error($ret['errors']) && $ret['errors']->has_errors()) {
                $error = new WP_Error('rest_invalid_param', __('Invalid user parameter(s).'), array('status' => 400));
                foreach ($ret['errors']->errors as $code => $messages) {
                    foreach ($messages as $message) {
                        $error->add($code, $message);
                    }
                    $error_data = $error->get_error_data($code);
                    if ($error_data) {
                        $error->add_data($error_data, $code);
                    }
                }
                return $error;
            }
        }
        if (is_multisite()) {
            $user_id = wpmu_create_user($user->user_login, $user->user_pass, $user->user_email);
            if (!$user_id) {
                return new WP_Error('rest_user_create', __('Error creating new user.'), array('status' => 500));
            }
            $user->ID = $user_id;
            $user_id = wp_update_user(wp_slash((array) $user));
            if (is_wp_error($user_id)) {
                return $user_id;
            }
            $result = add_user_to_blog(get_site()->id, $user_id, '');
            if (is_wp_error($result)) {
                return $result;
            }
        } else {
            $user_id = wp_insert_user(wp_slash((array) $user));
            if (is_wp_error($user_id)) {
                return $user_id;
            }
        }
        $user = get_user_by('id', $user_id);
        /**
         * Fires immediately after a user is created or updated via the REST API.
         *
         * @since 4.7.0
         *
         * @param WP_User         $user     Inserted or updated user object.
         * @param WP_REST_Request $request  Request object.
         * @param bool            $creating True when creating a user, false when updating.
         */
        do_action('rest_insert_user', $user, $request, true);
        if (!empty($request['roles']) && !empty($schema['properties']['roles'])) {
            array_map(array($user, 'add_role'), $request['roles']);
        }
        if (!empty($schema['properties']['meta']) && isset($request['meta'])) {
            $meta_update = $this->meta->update_value($request['meta'], $user_id);
            if (is_wp_error($meta_update)) {
                return $meta_update;
            }
        }
        $user = get_user_by('id', $user_id);
        $fields_update = $this->update_additional_fields_for_object($user, $request);
        if (is_wp_error($fields_update)) {
            return $fields_update;
        }
        $request->set_param('context', 'edit');
        /**
         * Fires after a user is completely created or updated via the REST API.
         *
         * @since 5.0.0
         *
         * @param WP_User         $user     Inserted or updated user object.
         * @param WP_REST_Request $request  Request object.
         * @param bool            $creating True when creating a user, false when updating.
         */
        do_action('rest_after_insert_user', $user, $request, true);
        $response = $this->prepare_item_for_response($user, $request);
        $response = rest_ensure_response($response);
        $response->set_status(201);
        $response->header('Location', rest_url(sprintf('%s/%s/%d', $this->namespace, $this->rest_base, $user_id)));
        return $response;
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 406")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item_permissions_check:406@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 437")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item:437@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_current_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 516")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_current_item:516@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 529")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item_permissions_check:529@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 549")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item:549@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_current_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 605")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_current_item_permissions_check:605@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_current_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 618")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_current_item:618@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 632")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:632@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 716")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_links:716@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_database") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 729")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_database:729@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_role_update") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 795")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_role_update:795@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_username") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 837")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_username:837@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_user_password") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 862")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_user_password:862@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 884")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:884@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_collection_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php at line 922")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_collection_params:922@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php');
        die();
    }
}