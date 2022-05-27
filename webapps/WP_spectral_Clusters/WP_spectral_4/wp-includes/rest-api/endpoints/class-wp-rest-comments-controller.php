<?php

/**
 * REST API: WP_REST_Comments_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core controller used to access comments via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Comments_Controller extends WP_REST_Controller
{
    /**
     * Instance of a comment meta fields object.
     *
     * @since 4.7.0
     * @var WP_REST_Comment_Meta_Fields
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
        $this->rest_base = 'comments';
        $this->meta = new WP_REST_Comment_Meta_Fields();
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
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\\d]+)', array('args' => array('id' => array('description' => __('Unique identifier for the object.'), 'type' => 'integer')), array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_item'), 'permission_callback' => array($this, 'get_item_permissions_check'), 'args' => array('context' => $this->get_context_param(array('default' => 'view')), 'password' => array('description' => __('The password for the parent post of the comment (if the post is password protected).'), 'type' => 'string'))), array('methods' => WP_REST_Server::EDITABLE, 'callback' => array($this, 'update_item'), 'permission_callback' => array($this, 'update_item_permissions_check'), 'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::EDITABLE)), array('methods' => WP_REST_Server::DELETABLE, 'callback' => array($this, 'delete_item'), 'permission_callback' => array($this, 'delete_item_permissions_check'), 'args' => array('force' => array('type' => 'boolean', 'default' => false, 'description' => __('Whether to bypass Trash and force deletion.')), 'password' => array('description' => __('The password for the parent post of the comment (if the post is password protected).'), 'type' => 'string'))), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks if a given request has access to read comments.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, error object otherwise.
     */
    public function get_items_permissions_check($request)
    {
        if (!empty($request['post'])) {
            foreach ((array) $request['post'] as $post_id) {
                $post = get_post($post_id);
                if (!empty($post_id) && $post && !$this->check_read_post_permission($post, $request)) {
                    return new WP_Error('rest_cannot_read_post', __('Sorry, you are not allowed to read the post for this comment.'), array('status' => rest_authorization_required_code()));
                } elseif (0 === $post_id && !current_user_can('moderate_comments')) {
                    return new WP_Error('rest_cannot_read', __('Sorry, you are not allowed to read comments without a post.'), array('status' => rest_authorization_required_code()));
                }
            }
        }
        if (!empty($request['context']) && 'edit' === $request['context'] && !current_user_can('moderate_comments')) {
            return new WP_Error('rest_forbidden_context', __('Sorry, you are not allowed to edit comments.'), array('status' => rest_authorization_required_code()));
        }
        if (!current_user_can('edit_posts')) {
            $protected_params = array('author', 'author_exclude', 'author_email', 'type', 'status');
            $forbidden_params = array();
            foreach ($protected_params as $param) {
                if ('status' === $param) {
                    if ('approve' !== $request[$param]) {
                        $forbidden_params[] = $param;
                    }
                } elseif ('type' === $param) {
                    if ('comment' !== $request[$param]) {
                        $forbidden_params[] = $param;
                    }
                } elseif (!empty($request[$param])) {
                    $forbidden_params[] = $param;
                }
            }
            if (!empty($forbidden_params)) {
                return new WP_Error(
                    'rest_forbidden_param',
                    /* translators: %s: List of forbidden parameters. */
                    sprintf(__('Query parameter not permitted: %s'), implode(', ', $forbidden_params)),
                    array('status' => rest_authorization_required_code())
                );
            }
        }
        return true;
    }
    /**
     * Retrieves a list of comment items.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or error object on failure.
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
        $parameter_mappings = array('author' => 'author__in', 'author_email' => 'author_email', 'author_exclude' => 'author__not_in', 'exclude' => 'comment__not_in', 'include' => 'comment__in', 'offset' => 'offset', 'order' => 'order', 'parent' => 'parent__in', 'parent_exclude' => 'parent__not_in', 'per_page' => 'number', 'post' => 'post__in', 'search' => 'search', 'status' => 'status', 'type' => 'type');
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
        // Ensure certain parameter values default to empty strings.
        foreach (array('author_email', 'search') as $param) {
            if (!isset($prepared_args[$param])) {
                $prepared_args[$param] = '';
            }
        }
        if (isset($registered['orderby'])) {
            $prepared_args['orderby'] = $this->normalize_query_param($request['orderby']);
        }
        $prepared_args['no_found_rows'] = false;
        $prepared_args['date_query'] = array();
        // Set before into date query. Date query must be specified as an array of an array.
        if (isset($registered['before'], $request['before'])) {
            $prepared_args['date_query'][0]['before'] = $request['before'];
        }
        // Set after into date query. Date query must be specified as an array of an array.
        if (isset($registered['after'], $request['after'])) {
            $prepared_args['date_query'][0]['after'] = $request['after'];
        }
        if (isset($registered['page']) && empty($request['offset'])) {
            $prepared_args['offset'] = $prepared_args['number'] * (absint($request['page']) - 1);
        }
        /**
         * Filters arguments, before passing to WP_Comment_Query, when querying comments via the REST API.
         *
         * @since 4.7.0
         *
         * @link https://developer.wordpress.org/reference/classes/wp_comment_query/
         *
         * @param array           $prepared_args Array of arguments for WP_Comment_Query.
         * @param WP_REST_Request $request       The current request.
         */
        $prepared_args = apply_filters('rest_comment_query', $prepared_args, $request);
        $query = new WP_Comment_Query();
        $query_result = $query->query($prepared_args);
        $comments = array();
        foreach ($query_result as $comment) {
            if (!$this->check_read_permission($comment, $request)) {
                continue;
            }
            $data = $this->prepare_item_for_response($comment, $request);
            $comments[] = $this->prepare_response_for_collection($data);
        }
        $total_comments = (int) $query->found_comments;
        $max_pages = (int) $query->max_num_pages;
        if ($total_comments < 1) {
            // Out-of-bounds, run the query again without LIMIT for total count.
            unset($prepared_args['number'], $prepared_args['offset']);
            $query = new WP_Comment_Query();
            $prepared_args['count'] = true;
            $total_comments = $query->query($prepared_args);
            $max_pages = ceil($total_comments / $request['per_page']);
        }
        $response = rest_ensure_response($comments);
        $response->header('X-WP-Total', $total_comments);
        $response->header('X-WP-TotalPages', $max_pages);
        $base = add_query_arg(urlencode_deep($request->get_query_params()), rest_url(sprintf('%s/%s', $this->namespace, $this->rest_base)));
        if ($request['page'] > 1) {
            $prev_page = $request['page'] - 1;
            if ($prev_page > $max_pages) {
                $prev_page = $max_pages;
            }
            $prev_link = add_query_arg('page', $prev_page, $base);
            $response->link_header('prev', $prev_link);
        }
        if ($max_pages > $request['page']) {
            $next_page = $request['page'] + 1;
            $next_link = add_query_arg('page', $next_page, $base);
            $response->link_header('next', $next_link);
        }
        return $response;
    }
    /**
     * Get the comment, if the ID is valid.
     *
     * @since 4.7.2
     *
     * @param int $id Supplied ID.
     * @return WP_Comment|WP_Error Comment object if ID is valid, WP_Error otherwise.
     */
    protected function get_comment($id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_comment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 210")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_comment:210@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to read the comment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, error object otherwise.
     */
    public function get_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 237")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_permissions_check:237@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Retrieves a comment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 263")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:263@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to create a comment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to create items, error object otherwise.
     */
    public function create_item_permissions_check($request)
    {
        if (!is_user_logged_in()) {
            if (get_option('comment_registration')) {
                return new WP_Error('rest_comment_login_required', __('Sorry, you must be logged in to comment.'), array('status' => 401));
            }
            /**
             * Filters whether comments can be created via the REST API without authentication.
             *
             * Enables creating comments for anonymous users.
             *
             * @since 4.7.0
             *
             * @param bool $allow_anonymous Whether to allow anonymous comments to
             *                              be created. Default `false`.
             * @param WP_REST_Request $request Request used to generate the
             *                                 response.
             */
            $allow_anonymous = apply_filters('rest_allow_anonymous_comments', false, $request);
            if (!$allow_anonymous) {
                return new WP_Error('rest_comment_login_required', __('Sorry, you must be logged in to comment.'), array('status' => 401));
            }
        }
        // Limit who can set comment `author`, `author_ip` or `status` to anything other than the default.
        if (isset($request['author']) && get_current_user_id() !== $request['author'] && !current_user_can('moderate_comments')) {
            return new WP_Error(
                'rest_comment_invalid_author',
                /* translators: %s: Request parameter. */
                sprintf(__("Sorry, you are not allowed to edit '%s' for comments."), 'author'),
                array('status' => rest_authorization_required_code())
            );
        }
        if (isset($request['author_ip']) && !current_user_can('moderate_comments')) {
            if (empty($_SERVER['REMOTE_ADDR']) || $request['author_ip'] !== $_SERVER['REMOTE_ADDR']) {
                return new WP_Error(
                    'rest_comment_invalid_author_ip',
                    /* translators: %s: Request parameter. */
                    sprintf(__("Sorry, you are not allowed to edit '%s' for comments."), 'author_ip'),
                    array('status' => rest_authorization_required_code())
                );
            }
        }
        if (isset($request['status']) && !current_user_can('moderate_comments')) {
            return new WP_Error(
                'rest_comment_invalid_status',
                /* translators: %s: Request parameter. */
                sprintf(__("Sorry, you are not allowed to edit '%s' for comments."), 'status'),
                array('status' => rest_authorization_required_code())
            );
        }
        if (empty($request['post'])) {
            return new WP_Error('rest_comment_invalid_post_id', __('Sorry, you are not allowed to create this comment without a post.'), array('status' => 403));
        }
        $post = get_post((int) $request['post']);
        if (!$post) {
            return new WP_Error('rest_comment_invalid_post_id', __('Sorry, you are not allowed to create this comment without a post.'), array('status' => 403));
        }
        if ('draft' === $post->post_status) {
            return new WP_Error('rest_comment_draft_post', __('Sorry, you are not allowed to create a comment on this post.'), array('status' => 403));
        }
        if ('trash' === $post->post_status) {
            return new WP_Error('rest_comment_trash_post', __('Sorry, you are not allowed to create a comment on this post.'), array('status' => 403));
        }
        if (!$this->check_read_post_permission($post, $request)) {
            return new WP_Error('rest_cannot_read_post', __('Sorry, you are not allowed to read the post for this comment.'), array('status' => rest_authorization_required_code()));
        }
        if (!comments_open($post->ID)) {
            return new WP_Error('rest_comment_closed', __('Sorry, comments are closed for this item.'), array('status' => 403));
        }
        return true;
    }
    /**
     * Creates a comment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or error object on failure.
     */
    public function create_item($request)
    {
        if (!empty($request['id'])) {
            return new WP_Error('rest_comment_exists', __('Cannot create existing comment.'), array('status' => 400));
        }
        // Do not allow comments to be created with a non-default type.
        if (!empty($request['type']) && 'comment' !== $request['type']) {
            return new WP_Error('rest_invalid_comment_type', __('Cannot create a comment with that type.'), array('status' => 400));
        }
        $prepared_comment = $this->prepare_item_for_database($request);
        if (is_wp_error($prepared_comment)) {
            return $prepared_comment;
        }
        $prepared_comment['comment_type'] = 'comment';
        if (!isset($prepared_comment['comment_content'])) {
            $prepared_comment['comment_content'] = '';
        }
        if (!$this->check_is_comment_content_allowed($prepared_comment)) {
            return new WP_Error('rest_comment_content_invalid', __('Invalid comment content.'), array('status' => 400));
        }
        // Setting remaining values before wp_insert_comment so we can use wp_allow_comment().
        if (!isset($prepared_comment['comment_date_gmt'])) {
            $prepared_comment['comment_date_gmt'] = current_time('mysql', true);
        }
        // Set author data if the user's logged in.
        $missing_author = empty($prepared_comment['user_id']) && empty($prepared_comment['comment_author']) && empty($prepared_comment['comment_author_email']) && empty($prepared_comment['comment_author_url']);
        if (is_user_logged_in() && $missing_author) {
            $user = wp_get_current_user();
            $prepared_comment['user_id'] = $user->ID;
            $prepared_comment['comment_author'] = $user->display_name;
            $prepared_comment['comment_author_email'] = $user->user_email;
            $prepared_comment['comment_author_url'] = $user->user_url;
        }
        // Honor the discussion setting that requires a name and email address of the comment author.
        if (get_option('require_name_email')) {
            if (empty($prepared_comment['comment_author']) || empty($prepared_comment['comment_author_email'])) {
                return new WP_Error('rest_comment_author_data_required', __('Creating a comment requires valid author name and email values.'), array('status' => 400));
            }
        }
        if (!isset($prepared_comment['comment_author_email'])) {
            $prepared_comment['comment_author_email'] = '';
        }
        if (!isset($prepared_comment['comment_author_url'])) {
            $prepared_comment['comment_author_url'] = '';
        }
        if (!isset($prepared_comment['comment_agent'])) {
            $prepared_comment['comment_agent'] = '';
        }
        $check_comment_lengths = wp_check_comment_data_max_lengths($prepared_comment);
        if (is_wp_error($check_comment_lengths)) {
            $error_code = $check_comment_lengths->get_error_code();
            return new WP_Error($error_code, __('Comment field exceeds maximum length allowed.'), array('status' => 400));
        }
        $prepared_comment['comment_approved'] = wp_allow_comment($prepared_comment, true);
        if (is_wp_error($prepared_comment['comment_approved'])) {
            $error_code = $prepared_comment['comment_approved']->get_error_code();
            $error_message = $prepared_comment['comment_approved']->get_error_message();
            if ('comment_duplicate' === $error_code) {
                return new WP_Error($error_code, $error_message, array('status' => 409));
            }
            if ('comment_flood' === $error_code) {
                return new WP_Error($error_code, $error_message, array('status' => 400));
            }
            return $prepared_comment['comment_approved'];
        }
        /**
         * Filters a comment before it is inserted via the REST API.
         *
         * Allows modification of the comment right before it is inserted via wp_insert_comment().
         * Returning a WP_Error value from the filter will short-circuit insertion and allow
         * skipping further processing.
         *
         * @since 4.7.0
         * @since 4.8.0 `$prepared_comment` can now be a WP_Error to short-circuit insertion.
         *
         * @param array|WP_Error  $prepared_comment The prepared comment data for wp_insert_comment().
         * @param WP_REST_Request $request          Request used to insert the comment.
         */
        $prepared_comment = apply_filters('rest_pre_insert_comment', $prepared_comment, $request);
        if (is_wp_error($prepared_comment)) {
            return $prepared_comment;
        }
        $comment_id = wp_insert_comment(wp_filter_comment(wp_slash((array) $prepared_comment)));
        if (!$comment_id) {
            return new WP_Error('rest_comment_failed_create', __('Creating comment failed.'), array('status' => 500));
        }
        if (isset($request['status'])) {
            $this->handle_status_param($request['status'], $comment_id);
        }
        $comment = get_comment($comment_id);
        /**
         * Fires after a comment is created or updated via the REST API.
         *
         * @since 4.7.0
         *
         * @param WP_Comment      $comment  Inserted or updated comment object.
         * @param WP_REST_Request $request  Request object.
         * @param bool            $creating True when creating a comment, false
         *                                  when updating.
         */
        do_action('rest_insert_comment', $comment, $request, true);
        $schema = $this->get_item_schema();
        if (!empty($schema['properties']['meta']) && isset($request['meta'])) {
            $meta_update = $this->meta->update_value($request['meta'], $comment_id);
            if (is_wp_error($meta_update)) {
                return $meta_update;
            }
        }
        $fields_update = $this->update_additional_fields_for_object($comment, $request);
        if (is_wp_error($fields_update)) {
            return $fields_update;
        }
        $context = current_user_can('moderate_comments') ? 'edit' : 'view';
        $request->set_param('context', $context);
        /**
         * Fires completely after a comment is created or updated via the REST API.
         *
         * @since 5.0.0
         *
         * @param WP_Comment      $comment  Inserted or updated comment object.
         * @param WP_REST_Request $request  Request object.
         * @param bool            $creating True when creating a comment, false
         *                                  when updating.
         */
        do_action('rest_after_insert_comment', $comment, $request, true);
        $response = $this->prepare_item_for_response($comment, $request);
        $response = rest_ensure_response($response);
        $response->set_status(201);
        $response->header('Location', rest_url(sprintf('%s/%s/%d', $this->namespace, $this->rest_base, $comment_id)));
        return $response;
    }
    /**
     * Checks if a given REST request has access to update a comment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to update the item, error object otherwise.
     */
    public function update_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 499")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item_permissions_check:499@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Updates a comment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or error object on failure.
     */
    public function update_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 518")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item:518@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to delete a comment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to delete the item, error object otherwise.
     */
    public function delete_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 593")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item_permissions_check:593@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Deletes a comment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or error object on failure.
     */
    public function delete_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 612")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item:612@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Prepares a single comment output for response.
     *
     * @since 4.7.0
     *
     * @param WP_Comment      $comment Comment object.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response($comment, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 677")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:677@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Prepares links for the request.
     *
     * @since 4.7.0
     *
     * @param WP_Comment $comment Comment object.
     * @return array Links for the given comment.
     */
    protected function prepare_links($comment)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 763")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_links:763@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Prepends internal property prefix to query parameters to match our response fields.
     *
     * @since 4.7.0
     *
     * @param string $query_param Query parameter.
     * @return string The normalized query parameter.
     */
    protected function normalize_query_param($query_param)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("normalize_query_param") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 796")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called normalize_query_param:796@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Checks comment_approved to set comment status for single comment output.
     *
     * @since 4.7.0
     *
     * @param string|int $comment_approved comment status.
     * @return string Comment status.
     */
    protected function prepare_status_response($comment_approved)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_status_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 826")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_status_response:826@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Prepares a single comment to be inserted into the database.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Request object.
     * @return array|WP_Error Prepared comment, otherwise WP_Error object.
     */
    protected function prepare_item_for_database($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_database") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 853")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_database:853@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Retrieves the comment's schema, conforming to JSON Schema.
     *
     * @since 4.7.0
     *
     * @return array
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 933")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:933@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Retrieves the query params for collections.
     *
     * @since 4.7.0
     *
     * @return array Comments collection parameters.
     */
    public function get_collection_params()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_collection_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 968")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_collection_params:968@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Sets the comment_status of a given comment object when creating or updating a comment.
     *
     * @since 4.7.0
     *
     * @param string|int $new_status New comment status.
     * @param int        $comment_id Comment ID.
     * @return bool Whether the status was changed.
     */
    protected function handle_status_param($new_status, $comment_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handle_status_param") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1010")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handle_status_param:1010@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Checks if the post can be read.
     *
     * Correctly handles posts with the inherit status.
     *
     * @since 4.7.0
     *
     * @param WP_Post         $post    Post object.
     * @param WP_REST_Request $request Request data to check.
     * @return bool Whether post can be read.
     */
    protected function check_read_post_permission($post, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_read_post_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1055")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_read_post_permission:1055@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Checks if the comment can be read.
     *
     * @since 4.7.0
     *
     * @param WP_Comment      $comment Comment object.
     * @param WP_REST_Request $request Request data to check.
     * @return bool Whether the comment can be read.
     */
    protected function check_read_permission($comment, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_read_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1095")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_read_permission:1095@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Checks if a comment can be edited or deleted.
     *
     * @since 4.7.0
     *
     * @param WP_Comment $comment Comment object.
     * @return bool Whether the comment can be edited or deleted.
     */
    protected function check_edit_permission($comment)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_edit_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1124")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_edit_permission:1124@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * Checks a comment author email for validity.
     *
     * Accepts either a valid email address or empty string as a valid comment
     * author email address. Setting the comment author email to an empty
     * string is allowed when a comment is being updated.
     *
     * @since 4.7.0
     *
     * @param string          $value   Author email value submitted.
     * @param WP_REST_Request $request Full details about the request.
     * @param string          $param   The parameter name.
     * @return string|WP_Error The sanitized email address, if valid,
     *                         otherwise an error.
     */
    public function check_comment_author_email($value, $request, $param)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_comment_author_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1149")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_comment_author_email:1149@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
    /**
     * If empty comments are not allowed, checks if the provided comment content is not empty.
     *
     * @since 5.6.0
     *
     * @param array $prepared_comment The prepared comment data.
     * @return bool True if the content is allowed, false otherwise.
     */
    protected function check_is_comment_content_allowed($prepared_comment)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_is_comment_content_allowed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1169")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_is_comment_content_allowed:1169@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
}