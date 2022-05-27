<?php

/**
 * REST API: WP_REST_Post_Types_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core class to access post types via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Post_Types_Controller extends WP_REST_Controller
{
    /**
     * Constructor.
     *
     * @since 4.7.0
     */
    public function __construct()
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'types';
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
        register_rest_route($this->namespace, '/' . $this->rest_base, array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_items'), 'permission_callback' => array($this, 'get_items_permissions_check'), 'args' => $this->get_collection_params()), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<type>[\\w-]+)', array('args' => array('type' => array('description' => __('An alphanumeric identifier for the post type.'), 'type' => 'string')), array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_item'), 'permission_callback' => '__return_true', 'args' => array('context' => $this->get_context_param(array('default' => 'view')))), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks whether a given request has permission to read types.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check($request)
    {
        if ('edit' === $request['context']) {
            $types = get_post_types(array('show_in_rest' => true), 'objects');
            foreach ($types as $type) {
                if (current_user_can($type->cap->edit_posts)) {
                    return true;
                }
            }
            return new WP_Error('rest_cannot_view', __('Sorry, you are not allowed to edit posts in this post type.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Retrieves all public post types.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        $data = array();
        $types = get_post_types(array('show_in_rest' => true), 'objects');
        foreach ($types as $type) {
            if ('edit' === $request['context'] && !current_user_can($type->cap->edit_posts)) {
                continue;
            }
            $post_type = $this->prepare_item_for_response($type, $request);
            $data[$type->name] = $this->prepare_response_for_collection($post_type);
        }
        return rest_ensure_response($data);
    }
    /**
     * Retrieves a specific post type.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-types-controller.php at line 93")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:93@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-types-controller.php');
        die();
    }
    /**
     * Prepares a post type object for serialization.
     *
     * @since 4.7.0
     *
     * @param WP_Post_Type    $post_type Post type object.
     * @param WP_REST_Request $request   Full details about the request.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response($post_type, $request)
    {
        $taxonomies = wp_list_filter(get_object_taxonomies($post_type->name, 'objects'), array('show_in_rest' => true));
        $taxonomies = wp_list_pluck($taxonomies, 'name');
        $base = !empty($post_type->rest_base) ? $post_type->rest_base : $post_type->name;
        $supports = get_all_post_type_supports($post_type->name);
        $fields = $this->get_fields_for_response($request);
        $data = array();
        if (in_array('capabilities', $fields, true)) {
            $data['capabilities'] = $post_type->cap;
        }
        if (in_array('description', $fields, true)) {
            $data['description'] = $post_type->description;
        }
        if (in_array('hierarchical', $fields, true)) {
            $data['hierarchical'] = $post_type->hierarchical;
        }
        if (in_array('viewable', $fields, true)) {
            $data['viewable'] = is_post_type_viewable($post_type);
        }
        if (in_array('labels', $fields, true)) {
            $data['labels'] = $post_type->labels;
        }
        if (in_array('name', $fields, true)) {
            $data['name'] = $post_type->label;
        }
        if (in_array('slug', $fields, true)) {
            $data['slug'] = $post_type->name;
        }
        if (in_array('supports', $fields, true)) {
            $data['supports'] = $supports;
        }
        if (in_array('taxonomies', $fields, true)) {
            $data['taxonomies'] = array_values($taxonomies);
        }
        if (in_array('rest_base', $fields, true)) {
            $data['rest_base'] = $base;
        }
        $context = !empty($request['context']) ? $request['context'] : 'view';
        $data = $this->add_additional_fields_to_object($data, $request);
        $data = $this->filter_response_by_context($data, $context);
        // Wrap the data in a response object.
        $response = rest_ensure_response($data);
        $response->add_links(array('collection' => array('href' => rest_url(sprintf('%s/%s', $this->namespace, $this->rest_base))), 'https://api.w.org/items' => array('href' => rest_url(sprintf('wp/v2/%s', $base)))));
        /**
         * Filters a post type returned from the REST API.
         *
         * Allows modification of the post type data right before it is returned.
         *
         * @since 4.7.0
         *
         * @param WP_REST_Response $response  The response object.
         * @param WP_Post_Type     $post_type The original post type object.
         * @param WP_REST_Request  $request   Request used to generate the response.
         */
        return apply_filters('rest_prepare_post_type', $response, $post_type, $request);
    }
    /**
     * Retrieves the post type's schema, conforming to JSON Schema.
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
        $schema = array('$schema' => 'http://json-schema.org/draft-04/schema#', 'title' => 'type', 'type' => 'object', 'properties' => array('capabilities' => array('description' => __('All capabilities used by the post type.'), 'type' => 'object', 'context' => array('edit'), 'readonly' => true), 'description' => array('description' => __('A human-readable description of the post type.'), 'type' => 'string', 'context' => array('view', 'edit'), 'readonly' => true), 'hierarchical' => array('description' => __('Whether or not the post type should have children.'), 'type' => 'boolean', 'context' => array('view', 'edit'), 'readonly' => true), 'viewable' => array('description' => __('Whether or not the post type can be viewed.'), 'type' => 'boolean', 'context' => array('edit'), 'readonly' => true), 'labels' => array('description' => __('Human-readable labels for the post type for various contexts.'), 'type' => 'object', 'context' => array('edit'), 'readonly' => true), 'name' => array('description' => __('The title for the post type.'), 'type' => 'string', 'context' => array('view', 'edit', 'embed'), 'readonly' => true), 'slug' => array('description' => __('An alphanumeric identifier for the post type.'), 'type' => 'string', 'context' => array('view', 'edit', 'embed'), 'readonly' => true), 'supports' => array('description' => __('All features, supported by the post type.'), 'type' => 'object', 'context' => array('edit'), 'readonly' => true), 'taxonomies' => array('description' => __('Taxonomies associated with post type.'), 'type' => 'array', 'items' => array('type' => 'string'), 'context' => array('view', 'edit'), 'readonly' => true), 'rest_base' => array('description' => __('REST base route for the post type.'), 'type' => 'string', 'context' => array('view', 'edit', 'embed'), 'readonly' => true)));
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
        return array('context' => $this->get_context_param(array('default' => 'view')));
    }
}