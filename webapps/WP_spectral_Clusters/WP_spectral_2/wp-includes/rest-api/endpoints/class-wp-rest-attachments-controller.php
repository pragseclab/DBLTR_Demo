<?php

/**
 * REST API: WP_REST_Attachments_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core controller used to access attachments via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Posts_Controller
 */
class WP_REST_Attachments_Controller extends WP_REST_Posts_Controller
{
    /**
     * Registers the routes for attachments.
     *
     * @since 5.3.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        parent::register_routes();
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\\d]+)/post-process', array('methods' => WP_REST_Server::CREATABLE, 'callback' => array($this, 'post_process_item'), 'permission_callback' => array($this, 'post_process_item_permissions_check'), 'args' => array('id' => array('description' => __('Unique identifier for the object.'), 'type' => 'integer'), 'action' => array('type' => 'string', 'enum' => array('create-image-subsizes'), 'required' => true))));
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\\d]+)/edit', array('methods' => WP_REST_Server::CREATABLE, 'callback' => array($this, 'edit_media_item'), 'permission_callback' => array($this, 'edit_media_item_permissions_check'), 'args' => $this->get_edit_media_item_args()));
    }
    /**
     * Determines the allowed query_vars for a get_items() response and
     * prepares for WP_Query.
     *
     * @since 4.7.0
     *
     * @param array           $prepared_args Optional. Array of prepared arguments. Default empty array.
     * @param WP_REST_Request $request       Optional. Request to prepare items for.
     * @return array Array of query arguments.
     */
    protected function prepare_items_query($prepared_args = array(), $request = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_items_query") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 44")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_items_query:44@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to create an attachment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error Boolean true if the attachment may be created, or a WP_Error if not.
     */
    public function create_item_permissions_check($request)
    {
        $ret = parent::create_item_permissions_check($request);
        if (!$ret || is_wp_error($ret)) {
            return $ret;
        }
        if (!current_user_can('upload_files')) {
            return new WP_Error('rest_cannot_create', __('Sorry, you are not allowed to upload media on this site.'), array('status' => 400));
        }
        // Attaching media to a post requires ability to edit said post.
        if (!empty($request['post']) && !current_user_can('edit_post', (int) $request['post'])) {
            return new WP_Error('rest_cannot_edit', __('Sorry, you are not allowed to upload media to this post.'), array('status' => rest_authorization_required_code()));
        }
        return true;
    }
    /**
     * Creates a single attachment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, WP_Error object on failure.
     */
    public function create_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 97")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item:97@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Inserts the attachment post in the database. Does not update the attachment meta.
     *
     * @since 5.3.0
     *
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    protected function insert_attachment($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("insert_attachment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 162")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called insert_attachment:162@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Updates a single attachment.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, WP_Error object on failure.
     */
    public function update_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 230")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item:230@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Performs post processing on an attachment.
     *
     * @since 5.3.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, WP_Error object on failure.
     */
    public function post_process_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_process_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 266")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called post_process_item:266@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Checks if a given request can perform post processing on an attachment.
     *
     * @since 5.3.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to update the item, WP_Error object otherwise.
     */
    public function post_process_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("post_process_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 285")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called post_process_item_permissions_check:285@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to editing media.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function edit_media_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("edit_media_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 297")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called edit_media_item_permissions_check:297@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Applies edits to a media item and creates a new attachment record.
     *
     * @since 5.5.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, WP_Error object on failure.
     */
    public function edit_media_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("edit_media_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 312")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called edit_media_item:312@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Prepares a single attachment for create or update.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Request object.
     * @return stdClass|WP_Error Post object.
     */
    protected function prepare_item_for_database($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_database") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 479")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_database:479@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Prepares a single attachment output for response.
     *
     * @since 4.7.0
     *
     * @param WP_Post         $post    Attachment object.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response($post, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 512")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:512@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Retrieves the attachment's schema, conforming to JSON Schema.
     *
     * @since 4.7.0
     *
     * @return array Item schema as an array.
     */
    public function get_item_schema()
    {
        if ($this->schema) {
            return $this->add_additional_fields_schema($this->schema);
        }
        $schema = parent::get_item_schema();
        $schema['properties']['alt_text'] = array('description' => __('Alternative text to display when attachment is not displayed.'), 'type' => 'string', 'context' => array('view', 'edit', 'embed'), 'arg_options' => array('sanitize_callback' => 'sanitize_text_field'));
        $schema['properties']['caption'] = array('description' => __('The attachment caption.'), 'type' => 'object', 'context' => array('view', 'edit', 'embed'), 'arg_options' => array(
            'sanitize_callback' => null,
            // Note: sanitization implemented in self::prepare_item_for_database().
            'validate_callback' => null,
        ), 'properties' => array('raw' => array('description' => __('Caption for the attachment, as it exists in the database.'), 'type' => 'string', 'context' => array('edit')), 'rendered' => array('description' => __('HTML caption for the attachment, transformed for display.'), 'type' => 'string', 'context' => array('view', 'edit', 'embed'), 'readonly' => true)));
        $schema['properties']['description'] = array('description' => __('The attachment description.'), 'type' => 'object', 'context' => array('view', 'edit'), 'arg_options' => array(
            'sanitize_callback' => null,
            // Note: sanitization implemented in self::prepare_item_for_database().
            'validate_callback' => null,
        ), 'properties' => array('raw' => array('description' => __('Description for the object, as it exists in the database.'), 'type' => 'string', 'context' => array('edit')), 'rendered' => array('description' => __('HTML description for the object, transformed for display.'), 'type' => 'string', 'context' => array('view', 'edit'), 'readonly' => true)));
        $schema['properties']['media_type'] = array('description' => __('Attachment type.'), 'type' => 'string', 'enum' => array('image', 'file'), 'context' => array('view', 'edit', 'embed'), 'readonly' => true);
        $schema['properties']['mime_type'] = array('description' => __('The attachment MIME type.'), 'type' => 'string', 'context' => array('view', 'edit', 'embed'), 'readonly' => true);
        $schema['properties']['media_details'] = array('description' => __('Details about the media file, specific to its type.'), 'type' => 'object', 'context' => array('view', 'edit', 'embed'), 'readonly' => true);
        $schema['properties']['post'] = array('description' => __('The ID for the associated post of the attachment.'), 'type' => 'integer', 'context' => array('view', 'edit'));
        $schema['properties']['source_url'] = array('description' => __('URL to the original attachment file.'), 'type' => 'string', 'format' => 'uri', 'context' => array('view', 'edit', 'embed'), 'readonly' => true);
        $schema['properties']['missing_image_sizes'] = array('description' => __('List of the missing image sizes of the attachment.'), 'type' => 'array', 'items' => array('type' => 'string'), 'context' => array('edit'), 'readonly' => true);
        unset($schema['properties']['password']);
        $this->schema = $schema;
        return $this->add_additional_fields_schema($this->schema);
    }
    /**
     * Handles an upload via raw POST data.
     *
     * @since 4.7.0
     *
     * @param array $data    Supplied file data.
     * @param array $headers HTTP headers from the request.
     * @return array|WP_Error Data from wp_handle_sideload().
     */
    protected function upload_from_data($data, $headers)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upload_from_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 642")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called upload_from_data:642@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Parses filename from a Content-Disposition header value.
     *
     * As per RFC6266:
     *
     *     content-disposition = "Content-Disposition" ":"
     *                            disposition-type *( ";" disposition-parm )
     *
     *     disposition-type    = "inline" | "attachment" | disp-ext-type
     *                         ; case-insensitive
     *     disp-ext-type       = token
     *
     *     disposition-parm    = filename-parm | disp-ext-parm
     *
     *     filename-parm       = "filename" "=" value
     *                         | "filename*" "=" ext-value
     *
     *     disp-ext-parm       = token "=" value
     *                         | ext-token "=" ext-value
     *     ext-token           = <the characters in token, followed by "*">
     *
     * @since 4.7.0
     *
     * @link https://tools.ietf.org/html/rfc2388
     * @link https://tools.ietf.org/html/rfc6266
     *
     * @param string[] $disposition_header List of Content-Disposition header values.
     * @return string|null Filename if available, or null if not found.
     */
    public static function get_filename_from_disposition($disposition_header)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_filename_from_disposition") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 721")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_filename_from_disposition:721@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Retrieves the query params for collections of attachments.
     *
     * @since 4.7.0
     *
     * @return array Query parameters for the attachment collection as an array.
     */
    public function get_collection_params()
    {
        $params = parent::get_collection_params();
        $params['status']['default'] = 'inherit';
        $params['status']['items']['enum'] = array('inherit', 'private', 'trash');
        $media_types = $this->get_media_types();
        $params['media_type'] = array('default' => null, 'description' => __('Limit result set to attachments of a particular media type.'), 'type' => 'string', 'enum' => array_keys($media_types));
        $params['mime_type'] = array('default' => null, 'description' => __('Limit result set to attachments of a particular MIME type.'), 'type' => 'string');
        return $params;
    }
    /**
     * Handles an upload via multipart/form-data ($_FILES).
     *
     * @since 4.7.0
     *
     * @param array $files   Data from the `$_FILES` superglobal.
     * @param array $headers HTTP headers from the request.
     * @return array|WP_Error Data from wp_handle_upload().
     */
    protected function upload_from_file($files, $headers)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("upload_from_file") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 776")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called upload_from_file:776@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Retrieves the supported media types.
     *
     * Media types are considered the MIME type category.
     *
     * @since 4.7.0
     *
     * @return array Array of supported media types.
     */
    protected function get_media_types()
    {
        $media_types = array();
        foreach (get_allowed_mime_types() as $mime_type) {
            $parts = explode('/', $mime_type);
            if (!isset($media_types[$parts[0]])) {
                $media_types[$parts[0]] = array();
            }
            $media_types[$parts[0]][] = $mime_type;
        }
        return $media_types;
    }
    /**
     * Determine if uploaded file exceeds space quota on multisite.
     *
     * Replicates check_upload_size().
     *
     * @since 4.9.8
     *
     * @param array $file $_FILES array for a given file.
     * @return true|WP_Error True if can upload, error for errors.
     */
    protected function check_upload_size($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("check_upload_size") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php at line 839")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called check_upload_size:839@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php');
        die();
    }
    /**
     * Gets the request args for the edit item route.
     *
     * @since 5.5.0
     *
     * @return array
     */
    protected function get_edit_media_item_args()
    {
        return array('src' => array('description' => __('URL to the edited image file.'), 'type' => 'string', 'format' => 'uri', 'required' => true), 'modifiers' => array('description' => __('Array of image edits.'), 'type' => 'array', 'minItems' => 1, 'items' => array('description' => __('Image edit.'), 'type' => 'object', 'required' => array('type', 'args'), 'oneOf' => array(array('title' => __('Rotation'), 'properties' => array('type' => array('description' => __('Rotation type.'), 'type' => 'string', 'enum' => array('rotate')), 'args' => array('description' => __('Rotation arguments.'), 'type' => 'object', 'required' => array('angle'), 'properties' => array('angle' => array('description' => __('Angle to rotate clockwise in degrees.'), 'type' => 'number'))))), array('title' => __('Crop'), 'properties' => array('type' => array('description' => __('Crop type.'), 'type' => 'string', 'enum' => array('crop')), 'args' => array('description' => __('Crop arguments.'), 'type' => 'object', 'required' => array('left', 'top', 'width', 'height'), 'properties' => array('left' => array('description' => __('Horizontal position from the left to begin the crop as a percentage of the image width.'), 'type' => 'number'), 'top' => array('description' => __('Vertical position from the top to begin the crop as a percentage of the image height.'), 'type' => 'number'), 'width' => array('description' => __('Width of the crop as a percentage of the image width.'), 'type' => 'number'), 'height' => array('description' => __('Height of the crop as a percentage of the image height.'), 'type' => 'number')))))))), 'rotation' => array('description' => __('The amount to rotate the image clockwise in degrees. DEPRECATED: Use `modifiers` instead.'), 'type' => 'integer', 'minimum' => 0, 'exclusiveMinimum' => true, 'maximum' => 360, 'exclusiveMaximum' => true), 'x' => array('description' => __('As a percentage of the image, the x position to start the crop from. DEPRECATED: Use `modifiers` instead.'), 'type' => 'number', 'minimum' => 0, 'maximum' => 100), 'y' => array('description' => __('As a percentage of the image, the y position to start the crop from. DEPRECATED: Use `modifiers` instead.'), 'type' => 'number', 'minimum' => 0, 'maximum' => 100), 'width' => array('description' => __('As a percentage of the image, the width to crop the image to. DEPRECATED: Use `modifiers` instead.'), 'type' => 'number', 'minimum' => 0, 'maximum' => 100), 'height' => array('description' => __('As a percentage of the image, the height to crop the image to. DEPRECATED: Use `modifiers` instead.'), 'type' => 'number', 'minimum' => 0, 'maximum' => 100));
    }
}