<?php

/**
 * Block Renderer REST API: WP_REST_Block_Renderer_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 5.0.0
 */
/**
 * Controller which provides REST endpoint for rendering a block.
 *
 * @since 5.0.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Block_Renderer_Controller extends WP_REST_Controller
{
    /**
     * Constructs the controller.
     *
     * @since 5.0.0
     */
    public function __construct()
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'block-renderer';
    }
    /**
     * Registers the necessary REST API routes, one for each dynamic block.
     *
     * @since 5.0.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<name>[a-z0-9-]+/[a-z0-9-]+)', array('args' => array('name' => array('description' => __('Unique registered name for the block.'), 'type' => 'string')), array('methods' => array(WP_REST_Server::READABLE, WP_REST_Server::CREATABLE), 'callback' => array($this, 'get_item'), 'permission_callback' => array($this, 'get_item_permissions_check'), 'args' => array('context' => $this->get_context_param(array('default' => 'view')), 'attributes' => array('description' => __('Attributes for the block.'), 'type' => 'object', 'default' => array(), 'validate_callback' => static function ($value, $request) {
            $block = WP_Block_Type_Registry::get_instance()->get_registered($request['name']);
            if (!$block) {
                // This will get rejected in ::get_item().
                return true;
            }
            $schema = array('type' => 'object', 'properties' => $block->get_attributes(), 'additionalProperties' => false);
            return rest_validate_value_from_schema($value, $schema);
        }, 'sanitize_callback' => static function ($value, $request) {
            $block = WP_Block_Type_Registry::get_instance()->get_registered($request['name']);
            if (!$block) {
                // This will get rejected in ::get_item().
                return true;
            }
            $schema = array('type' => 'object', 'properties' => $block->get_attributes(), 'additionalProperties' => false);
            return rest_sanitize_value_from_schema($value, $schema);
        }), 'post_id' => array('description' => __('ID of the post context.'), 'type' => 'integer'))), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks if a given request has access to read blocks.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_item_permissions_check($request)
    {
        global $post;
        $post_id = isset($request['post_id']) ? (int) $request['post_id'] : 0;
        if (0 < $post_id) {
            $post = get_post($post_id);
            if (!$post || !current_user_can('edit_post', $post->ID)) {
                return new WP_Error('block_cannot_read', __('Sorry, you are not allowed to read blocks of this post.'), array('status' => rest_authorization_required_code()));
            }
        } else {
            if (!current_user_can('edit_posts')) {
                return new WP_Error('block_cannot_read', __('Sorry, you are not allowed to read blocks as this user.'), array('status' => rest_authorization_required_code()));
            }
        }
        return true;
    }
    /**
     * Returns block output from block's registered render_callback.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        global $post;
        $post_id = isset($request['post_id']) ? (int) $request['post_id'] : 0;
        if (0 < $post_id) {
            $post = get_post($post_id);
            // Set up postdata since this will be needed if post_id was set.
            setup_postdata($post);
        }
        $registry = WP_Block_Type_Registry::get_instance();
        $registered = $registry->get_registered($request['name']);
        if (null === $registered || !$registered->is_dynamic()) {
            return new WP_Error('block_invalid', __('Invalid block.'), array('status' => 404));
        }
        $attributes = $request->get_param('attributes');
        // Create an array representation simulating the output of parse_blocks.
        $block = array('blockName' => $request['name'], 'attrs' => $attributes, 'innerHTML' => '', 'innerContent' => array());
        // Render using render_block to ensure all relevant filters are used.
        $data = array('rendered' => render_block($block));
        return rest_ensure_response($data);
    }
    /**
     * Retrieves block's output schema, conforming to JSON Schema.
     *
     * @since 5.0.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-block-renderer-controller.php at line 118")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:118@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-block-renderer-controller.php');
        die();
    }
}