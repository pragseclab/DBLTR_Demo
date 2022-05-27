<?php

/**
 * REST API: WP_REST_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core base controller for managing and interacting with REST API items.
 *
 * @since 4.7.0
 */
abstract class WP_REST_Controller
{
    /**
     * The namespace of this controller's route.
     *
     * @since 4.7.0
     * @var string
     */
    protected $namespace;
    /**
     * The base of this controller's route.
     *
     * @since 4.7.0
     * @var string
     */
    protected $rest_base;
    /**
     * Cached results of get_item_schema.
     *
     * @since 5.3.0
     * @var array
     */
    protected $schema;
    /**
     * Registers the routes for the objects of the controller.
     *
     * @since 4.7.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_routes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 47")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called register_routes:47@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to get items.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 64")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items_permissions_check:64@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Retrieves a collection of items.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_items") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 81")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_items:81@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to get a specific item.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access for the item, WP_Error object otherwise.
     */
    public function get_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 98")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_permissions_check:98@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Retrieves one item from the collection.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 115")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:115@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to create items.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to create items, WP_Error object otherwise.
     */
    public function create_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 132")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item_permissions_check:132@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Creates one item from the collection.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function create_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("create_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 149")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called create_item:149@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to update a specific item.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to update the item, WP_Error object otherwise.
     */
    public function update_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 166")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item_permissions_check:166@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Updates one item from the collection.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function update_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item:183@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Checks if a given request has access to delete a specific item.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has access to delete the item, WP_Error object otherwise.
     */
    public function delete_item_permissions_check($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 200")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item_permissions_check:200@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Deletes one item from the collection.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function delete_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 217")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_item:217@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Prepares one item for create or update operation.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Request object.
     * @return object|WP_Error The prepared item, or WP_Error object on failure.
     */
    protected function prepare_item_for_database($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_database") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 234")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_database:234@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Prepares the item for the REST response.
     *
     * @since 4.7.0
     *
     * @param mixed           $item    WordPress representation of the item.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function prepare_item_for_response($item, $request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_item_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 252")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_item_for_response:252@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Prepares a response for insertion into a collection.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Response $response Response object.
     * @return array|mixed Response data, ready for insertion into collection data.
     */
    public function prepare_response_for_collection($response)
    {
        if (!$response instanceof WP_REST_Response) {
            return $response;
        }
        $data = (array) $response->get_data();
        $server = rest_get_server();
        $links = $server::get_compact_response_links($response);
        if (!empty($links)) {
            $data['_links'] = $links;
        }
        return $data;
    }
    /**
     * Filters a response based on the context defined in the schema.
     *
     * @since 4.7.0
     *
     * @param array  $data    Response data to filter.
     * @param string $context Context defined in the schema.
     * @return array Filtered response.
     */
    public function filter_response_by_context($data, $context)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("filter_response_by_context") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 291")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called filter_response_by_context:291@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Retrieves the item's schema, conforming to JSON Schema.
     *
     * @since 4.7.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 303")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item_schema:303@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Retrieves the item's schema for display / public consumption purposes.
     *
     * @since 4.7.0
     *
     * @return array Public item schema data.
     */
    public function get_public_item_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_public_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 314")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_public_item_schema:314@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Retrieves the query params for the collections.
     *
     * @since 4.7.0
     *
     * @return array Query parameters for the collection.
     */
    public function get_collection_params()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_collection_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 331")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_collection_params:331@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Retrieves the magical context param.
     *
     * Ensures consistent descriptions between endpoints, and populates enum from schema.
     *
     * @since 4.7.0
     *
     * @param array $args Optional. Additional arguments for context parameter. Default empty array.
     * @return array Context parameter details.
     */
    public function get_context_param($args = array())
    {
        $param_details = array('description' => __('Scope under which the request is made; determines fields present in response.'), 'type' => 'string', 'sanitize_callback' => 'sanitize_key', 'validate_callback' => 'rest_validate_request_arg');
        $schema = $this->get_item_schema();
        if (empty($schema['properties'])) {
            return array_merge($param_details, $args);
        }
        $contexts = array();
        foreach ($schema['properties'] as $attributes) {
            if (!empty($attributes['context'])) {
                $contexts = array_merge($contexts, $attributes['context']);
            }
        }
        if (!empty($contexts)) {
            $param_details['enum'] = array_unique($contexts);
            rsort($param_details['enum']);
        }
        return array_merge($param_details, $args);
    }
    /**
     * Adds the values from additional fields to a data object.
     *
     * @since 4.7.0
     *
     * @param array           $prepared Prepared response array.
     * @param WP_REST_Request $request  Full details about the request.
     * @return array Modified data object with additional fields.
     */
    protected function add_additional_fields_to_object($prepared, $request)
    {
        $additional_fields = $this->get_additional_fields();
        $requested_fields = $this->get_fields_for_response($request);
        foreach ($additional_fields as $field_name => $field_options) {
            if (!$field_options['get_callback']) {
                continue;
            }
            if (!rest_is_field_included($field_name, $requested_fields)) {
                continue;
            }
            $prepared[$field_name] = call_user_func($field_options['get_callback'], $prepared, $field_name, $request, $this->get_object_type());
        }
        return $prepared;
    }
    /**
     * Updates the values of additional fields added to a data object.
     *
     * @since 4.7.0
     *
     * @param object          $object  Data model like WP_Term or WP_Post.
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True on success, WP_Error object if a field cannot be updated.
     */
    protected function update_additional_fields_for_object($object, $request)
    {
        $additional_fields = $this->get_additional_fields();
        foreach ($additional_fields as $field_name => $field_options) {
            if (!$field_options['update_callback']) {
                continue;
            }
            // Don't run the update callbacks if the data wasn't passed in the request.
            if (!isset($request[$field_name])) {
                continue;
            }
            $result = call_user_func($field_options['update_callback'], $request[$field_name], $object, $field_name, $request, $this->get_object_type());
            if (is_wp_error($result)) {
                return $result;
            }
        }
        return true;
    }
    /**
     * Adds the schema from additional fields to a schema array.
     *
     * The type of object is inferred from the passed schema.
     *
     * @since 4.7.0
     *
     * @param array $schema Schema array.
     * @return array Modified Schema array.
     */
    protected function add_additional_fields_schema($schema)
    {
        if (empty($schema['title'])) {
            return $schema;
        }
        // Can't use $this->get_object_type otherwise we cause an inf loop.
        $object_type = $schema['title'];
        $additional_fields = $this->get_additional_fields($object_type);
        foreach ($additional_fields as $field_name => $field_options) {
            if (!$field_options['schema']) {
                continue;
            }
            $schema['properties'][$field_name] = $field_options['schema'];
        }
        return $schema;
    }
    /**
     * Retrieves all of the registered additional fields for a given object-type.
     *
     * @since 4.7.0
     *
     * @param string $object_type Optional. The object type.
     * @return array Registered additional fields (if any), empty array if none or if the object type could
     *               not be inferred.
     */
    protected function get_additional_fields($object_type = null)
    {
        if (!$object_type) {
            $object_type = $this->get_object_type();
        }
        if (!$object_type) {
            return array();
        }
        global $wp_rest_additional_fields;
        if (!$wp_rest_additional_fields || !isset($wp_rest_additional_fields[$object_type])) {
            return array();
        }
        return $wp_rest_additional_fields[$object_type];
    }
    /**
     * Retrieves the object type this controller is responsible for managing.
     *
     * @since 4.7.0
     *
     * @return string Object type for the controller.
     */
    protected function get_object_type()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_object_type") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 471")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_object_type:471@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Gets an array of fields to be included on the response.
     *
     * Included fields are based on item schema and `_fields=` request argument.
     *
     * @since 4.9.6
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return string[] Fields to be included in the response.
     */
    public function get_fields_for_response($request)
    {
        $schema = $this->get_item_schema();
        $properties = isset($schema['properties']) ? $schema['properties'] : array();
        $additional_fields = $this->get_additional_fields();
        foreach ($additional_fields as $field_name => $field_options) {
            // For back-compat, include any field with an empty schema
            // because it won't be present in $this->get_item_schema().
            if (is_null($field_options['schema'])) {
                $properties[$field_name] = $field_options;
            }
        }
        // Exclude fields that specify a different context than the request context.
        $context = $request['context'];
        if ($context) {
            foreach ($properties as $name => $options) {
                if (!empty($options['context']) && !in_array($context, $options['context'], true)) {
                    unset($properties[$name]);
                }
            }
        }
        $fields = array_keys($properties);
        if (!isset($request['_fields'])) {
            return $fields;
        }
        $requested_fields = wp_parse_list($request['_fields']);
        if (0 === count($requested_fields)) {
            return $fields;
        }
        // Trim off outside whitespace from the comma delimited list.
        $requested_fields = array_map('trim', $requested_fields);
        // Always persist 'id', because it can be needed for add_additional_fields_to_object().
        if (in_array('id', $fields, true)) {
            $requested_fields[] = 'id';
        }
        // Return the list of all requested fields which appear in the schema.
        return array_reduce($requested_fields, function ($response_fields, $field) use($fields) {
            if (in_array($field, $fields, true)) {
                $response_fields[] = $field;
                return $response_fields;
            }
            // Check for nested fields if $field is not a direct match.
            $nested_fields = explode('.', $field);
            // A nested field is included so long as its top-level property
            // is present in the schema.
            if (in_array($nested_fields[0], $fields, true)) {
                $response_fields[] = $field;
            }
            return $response_fields;
        }, array());
    }
    /**
     * Retrieves an array of endpoint arguments from the item schema for the controller.
     *
     * @since 4.7.0
     *
     * @param string $method Optional. HTTP method of the request. The arguments for `CREATABLE` requests are
     *                       checked for required values and may fall-back to a given default, this is not done
     *                       on `EDITABLE` requests. Default WP_REST_Server::CREATABLE.
     * @return array Endpoint arguments.
     */
    public function get_endpoint_args_for_item_schema($method = WP_REST_Server::CREATABLE)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_endpoint_args_for_item_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 550")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_endpoint_args_for_item_schema:550@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
    /**
     * Sanitizes the slug value.
     *
     * @since 4.7.0
     *
     * @internal We can't use sanitize_title() directly, as the second
     * parameter is the fallback title, which would end up being set to the
     * request object.
     *
     * @see https://github.com/WP-API/WP-API/issues/1585
     *
     * @todo Remove this in favour of https://core.trac.wordpress.org/ticket/34659
     *
     * @param string $slug Slug value passed in request.
     * @return string Sanitized value for the slug.
     */
    public function sanitize_slug($slug)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitize_slug") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php at line 570")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sanitize_slug:570@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/endpoints/class-wp-rest-controller.php');
        die();
    }
}