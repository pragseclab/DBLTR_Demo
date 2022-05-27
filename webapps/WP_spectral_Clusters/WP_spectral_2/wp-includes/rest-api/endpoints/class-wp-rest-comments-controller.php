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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 59")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items_permissions_check:59@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 110")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items:110@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_comment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 210")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_comment:210@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 237")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_permissions_check:237@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 263")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:263@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 281")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item_permissions_check:281@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 360")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item:360@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 499")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item_permissions_check:499@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 518")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item:518@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 593")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item_permissions_check:593@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 612")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item:612@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 677")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:677@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_links") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 763")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_links:763@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("normalize_query_param") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 796")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called normalize_query_param:796@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_status_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 826")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_status_response:826@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_database") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 853")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_database:853@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        if ($this->schema) {
            return $this->add_additional_fields_schema($this->schema);
        }
        $schema = array('$schema' => 'http://json-schema.org/draft-04/schema#', 'title' => 'comment', 'type' => 'object', 'properties' => array('id' => array('description' => __('Unique identifier for the object.'), 'type' => 'integer', 'context' => array('view', 'edit', 'embed'), 'readonly' => true), 'author' => array('description' => __('The ID of the user object, if author was a user.'), 'type' => 'integer', 'context' => array('view', 'edit', 'embed')), 'author_email' => array('description' => __('Email address for the object author.'), 'type' => 'string', 'format' => 'email', 'context' => array('edit'), 'arg_options' => array('sanitize_callback' => array($this, 'check_comment_author_email'), 'validate_callback' => null)), 'author_ip' => array('description' => __('IP address for the object author.'), 'type' => 'string', 'format' => 'ip', 'context' => array('edit')), 'author_name' => array('description' => __('Display name for the object author.'), 'type' => 'string', 'context' => array('view', 'edit', 'embed'), 'arg_options' => array('sanitize_callback' => 'sanitize_text_field')), 'author_url' => array('description' => __('URL for the object author.'), 'type' => 'string', 'format' => 'uri', 'context' => array('view', 'edit', 'embed')), 'author_user_agent' => array('description' => __('User agent for the object author.'), 'type' => 'string', 'context' => array('edit'), 'arg_options' => array('sanitize_callback' => 'sanitize_text_field')), 'content' => array('description' => __('The content for the object.'), 'type' => 'object', 'context' => array('view', 'edit', 'embed'), 'arg_options' => array(
            'sanitize_callback' => null,
            // Note: sanitization implemented in self::prepare_item_for_database().
            'validate_callback' => null,
        ), 'properties' => array('raw' => array('description' => __('Content for the object, as it exists in the database.'), 'type' => 'string', 'context' => array('edit')), 'rendered' => array('description' => __('HTML content for the object, transformed for display.'), 'type' => 'string', 'context' => array('view', 'edit', 'embed'), 'readonly' => true))), 'date' => array('description' => __("The date the object was published, in the site's timezone."), 'type' => 'string', 'format' => 'date-time', 'context' => array('view', 'edit', 'embed')), 'date_gmt' => array('description' => __('The date the object was published, as GMT.'), 'type' => 'string', 'format' => 'date-time', 'context' => array('view', 'edit')), 'link' => array('description' => __('URL to the object.'), 'type' => 'string', 'format' => 'uri', 'context' => array('view', 'edit', 'embed'), 'readonly' => true), 'parent' => array('description' => __('The ID for the parent of the object.'), 'type' => 'integer', 'context' => array('view', 'edit', 'embed'), 'default' => 0), 'post' => array('description' => __('The ID of the associated post object.'), 'type' => 'integer', 'context' => array('view', 'edit'), 'default' => 0), 'status' => array('description' => __('State of the object.'), 'type' => 'string', 'context' => array('view', 'edit'), 'arg_options' => array('sanitize_callback' => 'sanitize_key')), 'type' => array('description' => __('Type of Comment for the object.'), 'type' => 'string', 'context' => array('view', 'edit', 'embed'), 'readonly' => true)));
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
            $schema['properties']['author_avatar_urls'] = array('description' => __('Avatar URLs for the object author.'), 'type' => 'object', 'context' => array('view', 'edit', 'embed'), 'readonly' => true, 'properties' => $avatar_properties);
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
     * @return array Comments collection parameters.
     */
    public function get_collection_params()
    {
        $query_params = parent::get_collection_params();
        $query_params['context']['default'] = 'view';
        $query_params['after'] = array('description' => __('Limit response to comments published after a given ISO8601 compliant date.'), 'type' => 'string', 'format' => 'date-time');
        $query_params['author'] = array('description' => __('Limit result set to comments assigned to specific user IDs. Requires authorization.'), 'type' => 'array', 'items' => array('type' => 'integer'));
        $query_params['author_exclude'] = array('description' => __('Ensure result set excludes comments assigned to specific user IDs. Requires authorization.'), 'type' => 'array', 'items' => array('type' => 'integer'));
        $query_params['author_email'] = array('default' => null, 'description' => __('Limit result set to that from a specific author email. Requires authorization.'), 'format' => 'email', 'type' => 'string');
        $query_params['before'] = array('description' => __('Limit response to comments published before a given ISO8601 compliant date.'), 'type' => 'string', 'format' => 'date-time');
        $query_params['exclude'] = array('description' => __('Ensure result set excludes specific IDs.'), 'type' => 'array', 'items' => array('type' => 'integer'), 'default' => array());
        $query_params['include'] = array('description' => __('Limit result set to specific IDs.'), 'type' => 'array', 'items' => array('type' => 'integer'), 'default' => array());
        $query_params['offset'] = array('description' => __('Offset the result set by a specific number of items.'), 'type' => 'integer');
        $query_params['order'] = array('description' => __('Order sort attribute ascending or descending.'), 'type' => 'string', 'default' => 'desc', 'enum' => array('asc', 'desc'));
        $query_params['orderby'] = array('description' => __('Sort collection by object attribute.'), 'type' => 'string', 'default' => 'date_gmt', 'enum' => array('date', 'date_gmt', 'id', 'include', 'post', 'parent', 'type'));
        $query_params['parent'] = array('default' => array(), 'description' => __('Limit result set to comments of specific parent IDs.'), 'type' => 'array', 'items' => array('type' => 'integer'));
        $query_params['parent_exclude'] = array('default' => array(), 'description' => __('Ensure result set excludes specific parent IDs.'), 'type' => 'array', 'items' => array('type' => 'integer'));
        $query_params['post'] = array('default' => array(), 'description' => __('Limit result set to comments assigned to specific post IDs.'), 'type' => 'array', 'items' => array('type' => 'integer'));
        $query_params['status'] = array('default' => 'approve', 'description' => __('Limit result set to comments assigned a specific status. Requires authorization.'), 'sanitize_callback' => 'sanitize_key', 'type' => 'string', 'validate_callback' => 'rest_validate_request_arg');
        $query_params['type'] = array('default' => 'comment', 'description' => __('Limit result set to comments assigned a specific type. Requires authorization.'), 'sanitize_callback' => 'sanitize_key', 'type' => 'string', 'validate_callback' => 'rest_validate_request_arg');
        $query_params['password'] = array('description' => __('The password for the post if it is password protected.'), 'type' => 'string');
        /**
         * Filters REST API collection parameters for the comments controller.
         *
         * This filter registers the collection parameter, but does not map the
         * collection parameter to an internal WP_Comment_Query parameter. Use the
         * `rest_comment_query` filter to set WP_Comment_Query parameters.
         *
         * @since 4.7.0
         *
         * @param array $query_params JSON Schema-formatted collection parameters.
         */
        return apply_filters('rest_comment_collection_params', $query_params);
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handle_status_param") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1010")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handle_status_param:1010@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_read_post_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1055")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_read_post_permission:1055@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_read_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1095")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_read_permission:1095@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_edit_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1124")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_edit_permission:1124@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_comment_author_email") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1149")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_comment_author_email:1149@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_is_comment_content_allowed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php at line 1169")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_is_comment_content_allowed:1169@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php');
        die();
    }
}