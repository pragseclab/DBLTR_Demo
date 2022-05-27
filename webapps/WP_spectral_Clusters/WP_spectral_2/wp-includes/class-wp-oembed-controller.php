<?php

/**
 * WP_oEmbed_Controller class, used to provide an oEmbed endpoint.
 *
 * @package WordPress
 * @subpackage Embeds
 * @since 4.4.0
 */
/**
 * oEmbed API endpoint controller.
 *
 * Registers the REST API route and delivers the response data.
 * The output format (XML or JSON) is handled by the REST API.
 *
 * @since 4.4.0
 */
final class WP_oEmbed_Controller
{
    /**
     * Register the oEmbed REST API route.
     *
     * @since 4.4.0
     */
    public function register_routes()
    {
        /**
         * Filters the maxwidth oEmbed parameter.
         *
         * @since 4.4.0
         *
         * @param int $maxwidth Maximum allowed width. Default 600.
         */
        $maxwidth = apply_filters('oembed_default_width', 600);
        register_rest_route('oembed/1.0', '/embed', array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_item'), 'permission_callback' => '__return_true', 'args' => array('url' => array('description' => __('The URL of the resource for which to fetch oEmbed data.'), 'required' => true, 'type' => 'string', 'format' => 'uri'), 'format' => array('default' => 'json', 'sanitize_callback' => 'wp_oembed_ensure_format'), 'maxwidth' => array('default' => $maxwidth, 'sanitize_callback' => 'absint')))));
        register_rest_route('oembed/1.0', '/proxy', array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_proxy_item'), 'permission_callback' => array($this, 'get_proxy_item_permissions_check'), 'args' => array('url' => array('description' => __('The URL of the resource for which to fetch oEmbed data.'), 'required' => true, 'type' => 'string', 'format' => 'uri'), 'format' => array('description' => __('The oEmbed format to use.'), 'type' => 'string', 'default' => 'json', 'enum' => array('json', 'xml')), 'maxwidth' => array('description' => __('The maximum width of the embed frame in pixels.'), 'type' => 'integer', 'default' => $maxwidth, 'sanitize_callback' => 'absint'), 'maxheight' => array('description' => __('The maximum height of the embed frame in pixels.'), 'type' => 'integer', 'sanitize_callback' => 'absint'), 'discover' => array('description' => __('Whether to perform an oEmbed discovery request for unsanctioned providers.'), 'type' => 'boolean', 'default' => true)))));
    }
    /**
     * Callback for the embed API endpoint.
     *
     * Returns the JSON object for the post.
     *
     * @since 4.4.0
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return array|WP_Error oEmbed response data or WP_Error on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-oembed-controller.php at line 50")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:50@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-oembed-controller.php');
        die();
    }
    /**
     * Checks if current user can make a proxy oEmbed request.
     *
     * @since 4.8.0
     *
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_proxy_item_permissions_check()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_proxy_item_permissions_check") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-oembed-controller.php at line 75")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_proxy_item_permissions_check:75@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-oembed-controller.php');
        die();
    }
    /**
     * Callback for the proxy API endpoint.
     *
     * Returns the JSON object for the proxied item.
     *
     * @since 4.8.0
     *
     * @see WP_oEmbed::get_html()
     * @param WP_REST_Request $request Full data about the request.
     * @return object|WP_Error oEmbed response data or WP_Error on failure.
     */
    public function get_proxy_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_proxy_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-oembed-controller.php at line 93")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_proxy_item:93@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-oembed-controller.php');
        die();
    }
}