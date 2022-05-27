<?php

/**
 * REST API: WP_REST_Block_Types_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 5.5.0
 */
/**
 * Core class used to access block types via the REST API.
 *
 * @since 5.5.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Block_Types_Controller extends WP_REST_Controller
{
    /**
     * Instance of WP_Block_Type_Registry.
     *
     * @since 5.5.0
     * @var WP_Block_Type_Registry
     */
    protected $block_registry;
    /**
     * Instance of WP_Block_Styles_Registry.
     *
     * @since 5.5.0
     * @var WP_Block_Styles_Registry
     */
    protected $style_registry;
    /**
     * Constructor.
     *
     * @since 5.5.0
     */
    public function __construct()
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'block-types';
        $this->block_registry = WP_Block_Type_Registry::get_instance();
        $this->style_registry = WP_Block_Styles_Registry::get_instance();
    }
    /**
     * Registers the routes for the objects of the controller.
     *
     * @since 5.5.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/' . $this->rest_base, array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_items'), 'permission_callback' => array($this, 'get_items_permissions_check'), 'args' => $this->get_collection_params()), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<namespace>[a-zA-Z0-9_-]+)', array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_items'), 'permission_callback' => array($this, 'get_items_permissions_check'), 'args' => $this->get_collection_params()), 'schema' => array($this, 'get_public_item_schema')));
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<namespace>[a-zA-Z0-9_-]+)/(?P<name>[a-zA-Z0-9_-]+)', array('args' => array('name' => array('description' => __('Block name.'), 'type' => 'string'), 'namespace' => array('description' => __('Block namespace.'), 'type' => 'string')), array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_item'), 'permission_callback' => array($this, 'get_item_permissions_check'), 'args' => array('context' => $this->get_context_param(array('default' => 'view')))), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks whether a given request has permission to read post block types.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php at line 68")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items_permissions_check:68@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php');
        die();
    }
    /**
     * Retrieves all post block types, depending on user context.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php at line 80")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items:80@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to read a block type.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, WP_Error object otherwise.
     */
    public function get_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php at line 110")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_permissions_check:110@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php');
        die();
    }
    /**
     * Checks whether a given block type should be visible.
     *
     * @since 5.5.0
     *
     * @return true|WP_Error True if the block type is visible, WP_Error otherwise.
     */
    protected function check_read_permission()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_read_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php at line 130")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_read_permission:130@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php');
        die();
    }
    /**
     * Get the block, if the name is valid.
     *
     * @since 5.5.0
     *
     * @param string $name Block name.
     * @return WP_Block_Type|WP_Error Block type object if name is valid, WP_Error otherwise.
     */
    protected function get_block($name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_block") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php at line 150")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_block:150@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php');
        die();
    }
    /**
     * Retrieves a specific block type.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php at line 166")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:166@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php');
        die();
    }
    /**
     * Prepares a block type object for serialization.
     *
     * @since 5.5.0
     *
     * @param WP_Block_Type   $block_type Block type data.
     * @param WP_REST_Request $request    Full details about the request.
     * @return WP_REST_Response Block type data.
     */
    public function prepare_item_for_response($block_type, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php at line 185")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:185@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php');
        die();
    }
    /**
     * Prepares links for the request.
     *
     * @since 5.5.0
     *
     * @param WP_Block_Type $block_type Block type data.
     * @return array Links for the given block type.
     */
    protected function prepare_links($block_type)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php at line 241")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_links:241@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-types-controller.php');
        die();
    }
    /**
     * Retrieves the block type' schema, conforming to JSON Schema.
     *
     * @since 5.5.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        if ($this->schema) {
            return $this->add_additional_fields_schema($this->schema);
        }
        // rest_validate_value_from_schema doesn't understand $refs, pull out reused definitions for readability.
        $inner_blocks_definition = array('description' => __('The list of inner blocks used in the example.'), 'type' => 'array', 'items' => array('type' => 'object', 'properties' => array('name' => array('description' => __('The name of the inner block.'), 'type' => 'string'), 'attributes' => array('description' => __('The attributes of the inner block.'), 'type' => 'object'), 'innerBlocks' => array('description' => __("A list of the inner block's own inner blocks. This is a recursive definition following the parent innerBlocks schema."), 'type' => 'array'))));
        $example_definition = array('description' => __('Block example.'), 'type' => array('object', 'null'), 'default' => null, 'properties' => array('attributes' => array('description' => __('The attributes used in the example.'), 'type' => 'object'), 'innerBlocks' => $inner_blocks_definition), 'context' => array('embed', 'view', 'edit'), 'readonly' => true);
        $keywords_definition = array('description' => __('Block keywords.'), 'type' => 'array', 'items' => array('type' => 'string'), 'default' => array(), 'context' => array('embed', 'view', 'edit'), 'readonly' => true);
        $icon_definition = array('description' => __('Icon of block type.'), 'type' => array('string', 'null'), 'default' => null, 'context' => array('embed', 'view', 'edit'), 'readonly' => true);
        $category_definition = array('description' => __('Block category.'), 'type' => array('string', 'null'), 'default' => null, 'context' => array('embed', 'view', 'edit'), 'readonly' => true);
        $schema = array('$schema' => 'http://json-schema.org/draft-04/schema#', 'title' => 'block-type', 'type' => 'object', 'properties' => array('api_version' => array('description' => __('Version of block API.'), 'type' => 'integer', 'default' => 1, 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'title' => array('description' => __('Title of block type.'), 'type' => 'string', 'default' => '', 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'name' => array('description' => __('Unique name identifying the block type.'), 'type' => 'string', 'default' => '', 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'description' => array('description' => __('Description of block type.'), 'type' => 'string', 'default' => '', 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'icon' => $icon_definition, 'attributes' => array('description' => __('Block attributes.'), 'type' => array('object', 'null'), 'properties' => array(), 'default' => null, 'additionalProperties' => array('type' => 'object'), 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'provides_context' => array('description' => __('Context provided by blocks of this type.'), 'type' => 'object', 'properties' => array(), 'additionalProperties' => array('type' => 'string'), 'default' => array(), 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'uses_context' => array('description' => __('Context values inherited by blocks of this type.'), 'type' => 'array', 'default' => array(), 'items' => array('type' => 'string'), 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'supports' => array('description' => __('Block supports.'), 'type' => 'object', 'default' => array(), 'properties' => array(), 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'category' => $category_definition, 'is_dynamic' => array('description' => __('Is the block dynamically rendered.'), 'type' => 'boolean', 'default' => false, 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'editor_script' => array('description' => __('Editor script handle.'), 'type' => array('string', 'null'), 'default' => null, 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'script' => array('description' => __('Public facing script handle.'), 'type' => array('string', 'null'), 'default' => null, 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'editor_style' => array('description' => __('Editor style handle.'), 'type' => array('string', 'null'), 'default' => null, 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'style' => array('description' => __('Public facing style handle.'), 'type' => array('string', 'null'), 'default' => null, 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'styles' => array('description' => __('Block style variations.'), 'type' => 'array', 'items' => array('type' => 'object', 'properties' => array('name' => array('description' => __('Unique name identifying the style.'), 'type' => 'string', 'required' => true), 'label' => array('description' => __('The human-readable label for the style.'), 'type' => 'string'), 'inline_style' => array('description' => __('Inline CSS code that registers the CSS class required for the style.'), 'type' => 'string'), 'style_handle' => array('description' => __('Contains the handle that defines the block style.'), 'type' => 'string'))), 'default' => array(), 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'variations' => array('description' => __('Block variations.'), 'type' => 'array', 'items' => array('type' => 'object', 'properties' => array('name' => array('description' => __('The unique and machine-readable name.'), 'type' => 'string', 'required' => true), 'title' => array('description' => __('A human-readable variation title.'), 'type' => 'string', 'required' => true), 'description' => array('description' => __('A detailed variation description.'), 'type' => 'string', 'required' => false), 'category' => $category_definition, 'icon' => $icon_definition, 'isDefault' => array('description' => __('Indicates whether the current variation is the default one.'), 'type' => 'boolean', 'required' => false, 'default' => false), 'attributes' => array('description' => __('The initial values for attributes.'), 'type' => 'object'), 'innerBlocks' => $inner_blocks_definition, 'example' => $example_definition, 'scope' => array('description' => __('The list of scopes where the variation is applicable. When not provided, it assumes all available scopes.'), 'type' => array('array', 'null'), 'default' => null, 'items' => array('type' => 'string', 'enum' => array('block', 'inserter', 'transform')), 'readonly' => true), 'keywords' => $keywords_definition)), 'readonly' => true, 'context' => array('embed', 'view', 'edit'), 'default' => null), 'textdomain' => array('description' => __('Public text domain.'), 'type' => array('string', 'null'), 'default' => null, 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'parent' => array('description' => __('Parent blocks.'), 'type' => array('array', 'null'), 'items' => array('type' => 'string'), 'default' => null, 'context' => array('embed', 'view', 'edit'), 'readonly' => true), 'keywords' => $keywords_definition, 'example' => $example_definition));
        $this->schema = $schema;
        return $this->add_additional_fields_schema($this->schema);
    }
    /**
     * Retrieves the query params for collections.
     *
     * @since 5.5.0
     *
     * @return array Collection parameters.
     */
    public function get_collection_params()
    {
        return array('context' => $this->get_context_param(array('default' => 'view')), 'namespace' => array('description' => __('Block namespace.'), 'type' => 'string'));
    }
}