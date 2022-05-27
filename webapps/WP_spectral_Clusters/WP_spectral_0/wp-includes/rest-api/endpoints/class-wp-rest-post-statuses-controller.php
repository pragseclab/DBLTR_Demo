<?php

/**
 * REST API: WP_REST_Post_Statuses_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core class used to access post statuses via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Post_Statuses_Controller extends WP_REST_Controller
{
    /**
     * Constructor.
     *
     * @since 4.7.0
     */
    public function __construct()
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'statuses';
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
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<status>[\\w-]+)', array('args' => array('status' => array('description' => __('An alphanumeric identifier for the status.'), 'type' => 'string')), array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_item'), 'permission_callback' => array($this, 'get_item_permissions_check'), 'args' => array('context' => $this->get_context_param(array('default' => 'view')))), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks whether a given request has permission to read post statuses.
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
            return new WP_Error('rest_cannot_view', __('Sorry, you are not allowed to manage post statuses.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Retrieves all post statuses, depending on user context.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        $data = array();
        $statuses = get_post_stati(array('internal' => false), 'object');
        $statuses['trash'] = get_post_status_object('trash');
        foreach ($statuses as $slug => $obj) {
            $ret = $this->check_read_permission($obj);
            if (!$ret) {
                continue;
            }
            $status = $this->prepare_item_for_response($obj, $request);
            $data[$obj->name] = $this->prepare_response_for_collection($status);
        }
        return rest_ensure_response($data);
    }
    /**
     * Checks if a given request has access to read a post status.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, WP_Error object otherwise.
     */
    public function get_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php at line 95")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_permissions_check:95@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php');
        die();
    }
    /**
     * Checks whether a given post status should be visible.
     *
     * @since 4.7.0
     *
     * @param object $status Post status.
     * @return bool True if the post status is visible, otherwise false.
     */
    protected function check_read_permission($status)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_read_permission") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php at line 115")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_read_permission:115@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php');
        die();
    }
    /**
     * Retrieves a specific post status.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php at line 138")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:138@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php');
        die();
    }
    /**
     * Prepares a post status object for serialization.
     *
     * @since 4.7.0
     *
     * @param stdClass        $status  Post status data.
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response Post status data.
     */
    public function prepare_item_for_response($status, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php at line 156")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:156@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php');
        die();
    }
    /**
     * Retrieves the post status' schema, conforming to JSON Schema.
     *
     * @since 4.7.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php at line 213")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:213@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_collection_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php at line 229")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_collection_params:229@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php');
        die();
    }
}