<?php

/**
 * REST API: WP_REST_Block_Directory_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 5.5.0
 */
/**
 * Controller which provides REST endpoint for the blocks.
 *
 * @since 5.5.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Block_Directory_Controller extends WP_REST_Controller
{
    /**
     * Constructs the controller.
     */
    public function __construct()
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'block-directory';
    }
    /**
     * Registers the necessary REST API routes.
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/' . $this->rest_base . '/search', array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_items'), 'permission_callback' => array($this, 'get_items_permissions_check'), 'args' => $this->get_collection_params()), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks whether a given request has permission to install and activate plugins.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     *
     * @return true|WP_Error True if the request has permission, WP_Error object otherwise.
     */
    public function get_items_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php at line 45")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items_permissions_check:45@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php');
        die();
    }
    /**
     * Search and retrieve blocks metadata
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php at line 61")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items:61@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php');
        die();
    }
    /**
     * Parse block metadata for a block, and prepare it for an API repsonse.
     *
     * @since 5.5.0
     *
     * @param array           $plugin  The plugin metadata.
     * @param WP_REST_Request $request Request object.
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function prepare_item_for_response($plugin, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php at line 92")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:92@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php');
        die();
    }
    /**
     * Generates a list of links to include in the response for the plugin.
     *
     * @since 5.5.0
     *
     * @param array $plugin The plugin data from WordPress.org.
     *
     * @return array
     */
    protected function prepare_links($plugin)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php at line 115")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_links:115@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php');
        die();
    }
    /**
     * Finds an installed plugin for the given slug.
     *
     * @since 5.5.0
     *
     * @param string $slug The WordPress.org directory slug for a plugin.
     *
     * @return string The plugin file found matching it.
     */
    protected function find_plugin_for_slug($slug)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("find_plugin_for_slug") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php at line 133")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called find_plugin_for_slug:133@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-block-directory-controller.php');
        die();
    }
    /**
     * Retrieves the theme's schema, conforming to JSON Schema.
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
        $this->schema = array('$schema' => 'http://json-schema.org/draft-04/schema#', 'title' => 'block-directory-item', 'type' => 'object', 'properties' => array('name' => array('description' => __('The block name, in namespace/block-name format.'), 'type' => 'string', 'context' => array('view')), 'title' => array('description' => __('The block title, in human readable format.'), 'type' => 'string', 'context' => array('view')), 'description' => array('description' => __('A short description of the block, in human readable format.'), 'type' => 'string', 'context' => array('view')), 'id' => array('description' => __('The block slug.'), 'type' => 'string', 'context' => array('view')), 'rating' => array('description' => __('The star rating of the block.'), 'type' => 'integer', 'context' => array('view')), 'rating_count' => array('description' => __('The number of ratings.'), 'type' => 'integer', 'context' => array('view')), 'active_installs' => array('description' => __('The number sites that have activated this block.'), 'type' => 'string', 'context' => array('view')), 'author_block_rating' => array('description' => __('The average rating of blocks published by the same author.'), 'type' => 'integer', 'context' => array('view')), 'author_block_count' => array('description' => __('The number of blocks published by the same author.'), 'type' => 'integer', 'context' => array('view')), 'author' => array('description' => __('The WordPress.org username of the block author.'), 'type' => 'string', 'context' => array('view')), 'icon' => array('description' => __('The block icon.'), 'type' => 'string', 'format' => 'uri', 'context' => array('view')), 'last_updated' => array('description' => __('The date when the block was last updated, in fuzzy human readable format.'), 'type' => 'string', 'format' => 'date-time', 'context' => array('view')), 'humanized_updated' => array('description' => __('The date when the block was last updated, in fuzzy human readable format.'), 'type' => 'string', 'context' => array('view'))));
        return $this->add_additional_fields_schema($this->schema);
    }
    /**
     * Retrieves the search params for the blocks collection.
     *
     * @since 5.5.0
     *
     * @return array Collection parameters.
     */
    public function get_collection_params()
    {
        $query_params = parent::get_collection_params();
        $query_params['context']['default'] = 'view';
        $query_params['term'] = array('description' => __('Limit result set to blocks matching the search term.'), 'type' => 'string', 'required' => true, 'minLength' => 1);
        unset($query_params['search']);
        /**
         * Filters REST API collection parameters for the block directory controller.
         *
         * @since 5.5.0
         *
         * @param array $query_params JSON Schema-formatted collection parameters.
         */
        return apply_filters('rest_block_directory_collection_params', $query_params);
    }
}