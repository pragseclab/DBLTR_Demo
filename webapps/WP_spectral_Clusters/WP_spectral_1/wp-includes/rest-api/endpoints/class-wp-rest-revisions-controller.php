<?php

/**
 * REST API: WP_REST_Revisions_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core class used to access revisions via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Revisions_Controller extends WP_REST_Controller
{
    /**
     * Parent post type.
     *
     * @since 4.7.0
     * @var string
     */
    private $parent_post_type;
    /**
     * Parent controller.
     *
     * @since 4.7.0
     * @var WP_REST_Controller
     */
    private $parent_controller;
    /**
     * The base of the parent controller's route.
     *
     * @since 4.7.0
     * @var string
     */
    private $parent_base;
    /**
     * Constructor.
     *
     * @since 4.7.0
     *
     * @param string $parent_post_type Post type of the parent.
     */
    public function __construct($parent_post_type)
    {
        $this->parent_post_type = $parent_post_type;
        $this->namespace = 'wp/v2';
        $this->rest_base = 'revisions';
        $post_type_object = get_post_type_object($parent_post_type);
        $this->parent_base = !empty($post_type_object->rest_base) ? $post_type_object->rest_base : $post_type_object->name;
        $this->parent_controller = $post_type_object->get_rest_controller();
        if (!$this->parent_controller) {
            $this->parent_controller = new WP_REST_Posts_Controller($parent_post_type);
        }
    }
    /**
     * Registers the routes for revisions based on post types supporting revisions.
     *
     * @since 4.7.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_routes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 68")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called register_routes:68@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
    /**
     * Get the parent post, if the ID is valid.
     *
     * @since 4.7.2
     *
     * @param int $parent Supplied ID.
     * @return WP_Post|WP_Error Post object if ID is valid, WP_Error otherwise.
     */
    protected function get_parent($parent)
    {
        $error = new WP_Error('rest_post_invalid_parent', __('Invalid post parent ID.'), array('status' => 404));
        if ((int) $parent <= 0) {
            return $error;
        }
        $parent = get_post((int) $parent);
        if (empty($parent) || empty($parent->ID) || $this->parent_post_type !== $parent->post_type) {
            return $error;
        }
        return $parent;
    }
    /**
     * Checks if a given request has access to get revisions.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check($request)
    {
        $parent = $this->get_parent($request['parent']);
        if (is_wp_error($parent)) {
            return $parent;
        }
        if (!current_user_can('edit_post', $parent->ID)) {
            return new WP_Error('rest_cannot_read', __('Sorry, you are not allowed to view revisions of this post.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Get the revision, if the ID is valid.
     *
     * @since 4.7.2
     *
     * @param int $id Supplied ID.
     * @return WP_Post|WP_Error Revision post object if ID is valid, WP_Error otherwise.
     */
    protected function get_revision($id)
    {
        $error = new WP_Error('rest_post_invalid_id', __('Invalid revision ID.'), array('status' => 404));
        if ((int) $id <= 0) {
            return $error;
        }
        $revision = get_post((int) $id);
        if (empty($revision) || empty($revision->ID) || 'revision' !== $revision->post_type) {
            return $error;
        }
        return $revision;
    }
    /**
     * Gets a collection of revisions.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        $parent = $this->get_parent($request['parent']);
        if (is_wp_error($parent)) {
            return $parent;
        }
        // Ensure a search string is set in case the orderby is set to 'relevance'.
        if (!empty($request['orderby']) && 'relevance' === $request['orderby'] && empty($request['search'])) {
            return new WP_Error('rest_no_search_term_defined', __('You need to define a search term to order by relevance.'), array('status' => 400));
        }
        // Ensure an include parameter is set in case the orderby is set to 'include'.
        if (!empty($request['orderby']) && 'include' === $request['orderby'] && empty($request['include'])) {
            return new WP_Error('rest_orderby_include_missing_include', __('You need to define an include parameter to order by include.'), array('status' => 400));
        }
        if (wp_revisions_enabled($parent)) {
            $registered = $this->get_collection_params();
            $args = array('post_parent' => $parent->ID, 'post_type' => 'revision', 'post_status' => 'inherit', 'posts_per_page' => -1, 'orderby' => 'date ID', 'order' => 'DESC', 'suppress_filters' => true);
            $parameter_mappings = array('exclude' => 'post__not_in', 'include' => 'post__in', 'offset' => 'offset', 'order' => 'order', 'orderby' => 'orderby', 'page' => 'paged', 'per_page' => 'posts_per_page', 'search' => 's');
            foreach ($parameter_mappings as $api_param => $wp_param) {
                if (isset($registered[$api_param], $request[$api_param])) {
                    $args[$wp_param] = $request[$api_param];
                }
            }
            // For backward-compatibility, 'date' needs to resolve to 'date ID'.
            if (isset($args['orderby']) && 'date' === $args['orderby']) {
                $args['orderby'] = 'date ID';
            }
            /** This filter is documented in wp-includes/rest-api/endpoints/class-wp-rest-posts-controller.php */
            $args = apply_filters('rest_revision_query', $args, $request);
            $query_args = $this->prepare_items_query($args, $request);
            $revisions_query = new WP_Query();
            $revisions = $revisions_query->query($query_args);
            $offset = isset($query_args['offset']) ? (int) $query_args['offset'] : 0;
            $page = (int) $query_args['paged'];
            $total_revisions = $revisions_query->found_posts;
            if ($total_revisions < 1) {
                // Out-of-bounds, run the query again without LIMIT for total count.
                unset($query_args['paged'], $query_args['offset']);
                $count_query = new WP_Query();
                $count_query->query($query_args);
                $total_revisions = $count_query->found_posts;
            }
            if ($revisions_query->query_vars['posts_per_page'] > 0) {
                $max_pages = ceil($total_revisions / (int) $revisions_query->query_vars['posts_per_page']);
            } else {
                $max_pages = $total_revisions > 0 ? 1 : 0;
            }
            if ($total_revisions > 0) {
                if ($offset >= $total_revisions) {
                    return new WP_Error('rest_revision_invalid_offset_number', __('The offset number requested is larger than or equal to the number of available revisions.'), array('status' => 400));
                } elseif (!$offset && $page > $max_pages) {
                    return new WP_Error('rest_revision_invalid_page_number', __('The page number requested is larger than the number of pages available.'), array('status' => 400));
                }
            }
        } else {
            $revisions = array();
            $total_revisions = 0;
            $max_pages = 0;
            $page = (int) $request['page'];
        }
        $response = array();
        foreach ($revisions as $revision) {
            $data = $this->prepare_item_for_response($revision, $request);
            $response[] = $this->prepare_response_for_collection($data);
        }
        $response = rest_ensure_response($response);
        $response->header('X-WP-Total', (int) $total_revisions);
        $response->header('X-WP-TotalPages', (int) $max_pages);
        $request_params = $request->get_query_params();
        $base = add_query_arg(urlencode_deep($request_params), rest_url(sprintf('%s/%s/%d/%s', $this->namespace, $this->parent_base, $request['parent'], $this->rest_base)));
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
     * Checks if a given request has access to get a specific revision.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, WP_Error object otherwise.
     */
    public function get_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 233")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_permissions_check:233@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
    /**
     * Retrieves one revision from the collection.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 245")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:245@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to delete a revision.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to delete the item, WP_Error object otherwise.
     */
    public function delete_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 266")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item_permissions_check:266@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
    /**
     * Deletes a single revision.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function delete_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 297")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item:297@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
    /**
     * Determines the allowed query_vars for a get_items() response and prepares
     * them for WP_Query.
     *
     * @since 5.0.0
     *
     * @param array           $prepared_args Optional. Prepared WP_Query arguments. Default empty array.
     * @param WP_REST_Request $request       Optional. Full details about the request.
     * @return array Items query arguments.
     */
    protected function prepare_items_query($prepared_args = array(), $request = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_items_query") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 343")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_items_query:343@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
    /**
     * Prepares the revision for the REST response.
     *
     * @since 4.7.0
     *
     * @param WP_Post         $post    Post revision object.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response($post, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 369")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:369@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
    /**
     * Checks the post_date_gmt or modified_gmt and prepare any post or
     * modified date for single post output.
     *
     * @since 4.7.0
     *
     * @param string      $date_gmt GMT publication time.
     * @param string|null $date     Optional. Local publication time. Default null.
     * @return string|null ISO8601/RFC3339 formatted datetime, otherwise null.
     */
    protected function prepare_date_response($date_gmt, $date = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_date_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 449")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_date_response:449@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
    /**
     * Retrieves the revision's schema, conforming to JSON Schema.
     *
     * @since 4.7.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 466")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:466@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_collection_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 501")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_collection_params:501@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
    /**
     * Checks the post excerpt and prepare it for single post output.
     *
     * @since 4.7.0
     *
     * @param string  $excerpt The post excerpt.
     * @param WP_Post $post    Post revision object.
     * @return string Prepared excerpt or empty string.
     */
    protected function prepare_excerpt_response($excerpt, $post)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_excerpt_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php at line 523")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_excerpt_response:523@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php');
        die();
    }
}