<?php

/**
 * REST API: WP_REST_Search_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 5.0.0
 */
/**
 * Core class to search through all WordPress content via the REST API.
 *
 * @since 5.0.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Search_Controller extends WP_REST_Controller
{
    /**
     * ID property name.
     */
    const PROP_ID = 'id';
    /**
     * Title property name.
     */
    const PROP_TITLE = 'title';
    /**
     * URL property name.
     */
    const PROP_URL = 'url';
    /**
     * Type property name.
     */
    const PROP_TYPE = 'type';
    /**
     * Subtype property name.
     */
    const PROP_SUBTYPE = 'subtype';
    /**
     * Identifier for the 'any' type.
     */
    const TYPE_ANY = 'any';
    /**
     * Search handlers used by the controller.
     *
     * @since 5.0.0
     * @var array
     */
    protected $search_handlers = array();
    /**
     * Constructor.
     *
     * @since 5.0.0
     *
     * @param array $search_handlers List of search handlers to use in the controller. Each search
     *                               handler instance must extend the `WP_REST_Search_Handler` class.
     */
    public function __construct(array $search_handlers)
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'search';
        foreach ($search_handlers as $search_handler) {
            if (!$search_handler instanceof WP_REST_Search_Handler) {
                _doing_it_wrong(
                    __METHOD__,
                    /* translators: %s: PHP class name. */
                    sprintf(__('REST search handlers must extend the %s class.'), 'WP_REST_Search_Handler'),
                    '5.0.0'
                );
                continue;
            }
            $this->search_handlers[$search_handler->get_type()] = $search_handler;
        }
    }
    /**
     * Registers the routes for the objects of the controller.
     *
     * @since 5.0.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/' . $this->rest_base, array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_items'), 'permission_callback' => array($this, 'get_items_permission_check'), 'args' => $this->get_collection_params()), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks if a given request has access to search content.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has search access, WP_Error object otherwise.
     */
    public function get_items_permission_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items_permission_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php at line 96")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items_permission_check:96@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php');
        die();
    }
    /**
     * Retrieves a collection of search results.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php at line 108")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items:108@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php');
        die();
    }
    /**
     * Prepares a single search result for response.
     *
     * @since 5.0.0
     * @since 5.6.0 The `$id` parameter can accept a string.
     *
     * @param int|string      $id      ID of the item to prepare.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response($id, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php at line 156")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:156@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php');
        die();
    }
    /**
     * Retrieves the item schema, conforming to JSON Schema.
     *
     * @since 5.0.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        if ($this->schema) {
            return $this->add_additional_fields_schema($this->schema);
        }
        $types = array();
        $subtypes = array();
        foreach ($this->search_handlers as $search_handler) {
            $types[] = $search_handler->get_type();
            $subtypes = array_merge($subtypes, $search_handler->get_subtypes());
        }
        $types = array_unique($types);
        $subtypes = array_unique($subtypes);
        $schema = array('$schema' => 'http://json-schema.org/draft-04/schema#', 'title' => 'search-result', 'type' => 'object', 'properties' => array(self::PROP_ID => array('description' => __('Unique identifier for the object.'), 'type' => array('integer', 'string'), 'context' => array('view', 'embed'), 'readonly' => true), self::PROP_TITLE => array('description' => __('The title for the object.'), 'type' => 'string', 'context' => array('view', 'embed'), 'readonly' => true), self::PROP_URL => array('description' => __('URL to the object.'), 'type' => 'string', 'format' => 'uri', 'context' => array('view', 'embed'), 'readonly' => true), self::PROP_TYPE => array('description' => __('Object type.'), 'type' => 'string', 'enum' => $types, 'context' => array('view', 'embed'), 'readonly' => true), self::PROP_SUBTYPE => array('description' => __('Object subtype.'), 'type' => 'string', 'enum' => $subtypes, 'context' => array('view', 'embed'), 'readonly' => true)));
        $this->schema = $schema;
        return $this->add_additional_fields_schema($this->schema);
    }
    /**
     * Retrieves the query params for the search results collection.
     *
     * @since 5.0.0
     *
     * @return array Collection parameters.
     */
    public function get_collection_params()
    {
        $types = array();
        $subtypes = array();
        foreach ($this->search_handlers as $search_handler) {
            $types[] = $search_handler->get_type();
            $subtypes = array_merge($subtypes, $search_handler->get_subtypes());
        }
        $types = array_unique($types);
        $subtypes = array_unique($subtypes);
        $query_params = parent::get_collection_params();
        $query_params['context']['default'] = 'view';
        $query_params[self::PROP_TYPE] = array('default' => $types[0], 'description' => __('Limit results to items of an object type.'), 'type' => 'string', 'enum' => $types);
        $query_params[self::PROP_SUBTYPE] = array('default' => self::TYPE_ANY, 'description' => __('Limit results to items of one or more object subtypes.'), 'type' => 'array', 'items' => array('enum' => array_merge($subtypes, array(self::TYPE_ANY)), 'type' => 'string'), 'sanitize_callback' => array($this, 'sanitize_subtypes'));
        return $query_params;
    }
    /**
     * Sanitizes the list of subtypes, to ensure only subtypes of the passed type are included.
     *
     * @since 5.0.0
     *
     * @param string|array    $subtypes  One or more subtypes.
     * @param WP_REST_Request $request   Full details about the request.
     * @param string          $parameter Parameter name.
     * @return array|WP_Error List of valid subtypes, or WP_Error object on failure.
     */
    public function sanitize_subtypes($subtypes, $request, $parameter)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitize_subtypes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php at line 230")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sanitize_subtypes:230@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php');
        die();
    }
    /**
     * Gets the search handler to handle the current request.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Search_Handler|WP_Error Search handler for the request type, or WP_Error object on failure.
     */
    protected function get_search_handler($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_search_handler") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php at line 255")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_search_handler:255@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-search-controller.php');
        die();
    }
}