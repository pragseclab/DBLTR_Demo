<?php

/**
 * REST API: WP_REST_Autosaves_Controller class.
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 5.0.0
 */
/**
 * Core class used to access autosaves via the REST API.
 *
 * @since 5.0.0
 *
 * @see WP_REST_Revisions_Controller
 * @see WP_REST_Controller
 */
class WP_REST_Autosaves_Controller extends WP_REST_Revisions_Controller
{
    /**
     * Parent post type.
     *
     * @since 5.0.0
     * @var string
     */
    private $parent_post_type;
    /**
     * Parent post controller.
     *
     * @since 5.0.0
     * @var WP_REST_Controller
     */
    private $parent_controller;
    /**
     * Revision controller.
     *
     * @since 5.0.0
     * @var WP_REST_Controller
     */
    private $revisions_controller;
    /**
     * The base of the parent controller's route.
     *
     * @since 5.0.0
     * @var string
     */
    private $parent_base;
    /**
     * Constructor.
     *
     * @since 5.0.0
     *
     * @param string $parent_post_type Post type of the parent.
     */
    public function __construct($parent_post_type)
    {
        $this->parent_post_type = $parent_post_type;
        $post_type_object = get_post_type_object($parent_post_type);
        $parent_controller = $post_type_object->get_rest_controller();
        if (!$parent_controller) {
            $parent_controller = new WP_REST_Posts_Controller($parent_post_type);
        }
        $this->parent_controller = $parent_controller;
        $this->revisions_controller = new WP_REST_Revisions_Controller($parent_post_type);
        $this->namespace = 'wp/v2';
        $this->rest_base = 'autosaves';
        $this->parent_base = !empty($post_type_object->rest_base) ? $post_type_object->rest_base : $post_type_object->name;
    }
    /**
     * Registers the routes for autosaves.
     *
     * @since 5.0.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_routes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php at line 78")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called register_routes:78@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php');
        die();
    }
    /**
     * Get the parent post.
     *
     * @since 5.0.0
     *
     * @param int $parent_id Supplied ID.
     * @return WP_Post|WP_Error Post object if ID is valid, WP_Error otherwise.
     */
    protected function get_parent($parent_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_parent") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php at line 91")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_parent:91@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to get autosaves.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check($request)
    {
        $parent = $this->get_parent($request['id']);
        if (is_wp_error($parent)) {
            return $parent;
        }
        if (!current_user_can('edit_post', $parent->ID)) {
            return new WP_Error('rest_cannot_read', __('Sorry, you are not allowed to view autosaves of this post.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Checks if a given request has access to create an autosave revision.
     *
     * Autosave revisions inherit permissions from the parent post,
     * check if the current user has permission to edit the post.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to create the item, WP_Error object otherwise.
     */
    public function create_item_permissions_check($request)
    {
        $id = $request->get_param('id');
        if (empty($id)) {
            return new WP_Error('rest_post_invalid_id', __('Invalid item ID.'), array('status' => 404));
        }
        return $this->parent_controller->update_item_permissions_check($request);
    }
    /**
     * Creates, updates or deletes an autosave revision.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function create_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php at line 141")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item:141@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php');
        die();
    }
    /**
     * Get the autosave, if the ID is valid.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_Post|WP_Error Revision post object if ID is valid, WP_Error otherwise.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php at line 178")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:178@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php');
        die();
    }
    /**
     * Gets a collection of autosaves using wp_get_post_autosave.
     *
     * Contains the user's autosave, for empty if it doesn't exist.
     *
     * @since 5.0.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php at line 201")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items:201@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php');
        die();
    }
    /**
     * Retrieves the autosave's schema, conforming to JSON Schema.
     *
     * @since 5.0.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php at line 225")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:225@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php');
        die();
    }
    /**
     * Creates autosave for the specified post.
     *
     * From wp-admin/post.php.
     *
     * @since 5.0.0
     *
     * @param array $post_data Associative array containing the post data.
     * @return mixed The autosave revision ID or WP_Error.
     */
    public function create_post_autosave($post_data)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_post_autosave") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php at line 245")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_post_autosave:245@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php');
        die();
    }
    /**
     * Prepares the revision for the REST response.
     *
     * @since 5.0.0
     *
     * @param WP_Post         $post    Post revision object.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response($post, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php at line 288")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:288@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/rest-api/endpoints/class-wp-rest-autosaves-controller.php');
        die();
    }
    /**
     * Retrieves the query params for the autosaves collection.
     *
     * @since 5.0.0
     *
     * @return array Collection parameters.
     */
    public function get_collection_params()
    {
        return array('context' => $this->get_context_param(array('default' => 'view')));
    }
}