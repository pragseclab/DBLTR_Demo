<?php

/**
 * REST API: WP_REST_Request class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.4.0
 */
/**
 * Core class used to implement a REST request object.
 *
 * Contains data from the request, to be passed to the callback.
 *
 * Note: This implements ArrayAccess, and acts as an array of parameters when
 * used in that manner. It does not use ArrayObject (as we cannot rely on SPL),
 * so be aware it may have non-array behaviour in some cases.
 *
 * Note: When using features provided by ArrayAccess, be aware that WordPress deliberately
 * does not distinguish between arguments of the same name for different request methods.
 * For instance, in a request with `GET id=1` and `POST id=2`, `$request['id']` will equal
 * 2 (`POST`) not 1 (`GET`). For more precision between request methods, use
 * WP_REST_Request::get_body_params(), WP_REST_Request::get_url_params(), etc.
 *
 * @since 4.4.0
 *
 * @link https://www.php.net/manual/en/class.arrayaccess.php
 */
class WP_REST_Request implements ArrayAccess
{
    /**
     * HTTP method.
     *
     * @since 4.4.0
     * @var string
     */
    protected $method = '';
    /**
     * Parameters passed to the request.
     *
     * These typically come from the `$_GET`, `$_POST` and `$_FILES`
     * superglobals when being created from the global scope.
     *
     * @since 4.4.0
     * @var array Contains GET, POST and FILES keys mapping to arrays of data.
     */
    protected $params;
    /**
     * HTTP headers for the request.
     *
     * @since 4.4.0
     * @var array Map of key to value. Key is always lowercase, as per HTTP specification.
     */
    protected $headers = array();
    /**
     * Body data.
     *
     * @since 4.4.0
     * @var string Binary data from the request.
     */
    protected $body = null;
    /**
     * Route matched for the request.
     *
     * @since 4.4.0
     * @var string
     */
    protected $route;
    /**
     * Attributes (options) for the route that was matched.
     *
     * This is the options array used when the route was registered, typically
     * containing the callback as well as the valid methods for the route.
     *
     * @since 4.4.0
     * @var array Attributes for the request.
     */
    protected $attributes = array();
    /**
     * Used to determine if the JSON data has been parsed yet.
     *
     * Allows lazy-parsing of JSON data where possible.
     *
     * @since 4.4.0
     * @var bool
     */
    protected $parsed_json = false;
    /**
     * Used to determine if the body data has been parsed yet.
     *
     * @since 4.4.0
     * @var bool
     */
    protected $parsed_body = false;
    /**
     * Constructor.
     *
     * @since 4.4.0
     *
     * @param string $method     Optional. Request method. Default empty.
     * @param string $route      Optional. Request route. Default empty.
     * @param array  $attributes Optional. Request attributes. Default empty array.
     */
    public function __construct($method = '', $route = '', $attributes = array())
    {
        $this->params = array(
            'URL' => array(),
            'GET' => array(),
            'POST' => array(),
            'FILES' => array(),
            // See parse_json_params.
            'JSON' => null,
            'defaults' => array(),
        );
        $this->set_method($method);
        $this->set_route($route);
        $this->set_attributes($attributes);
    }
    /**
     * Retrieves the HTTP method for the request.
     *
     * @since 4.4.0
     *
     * @return string HTTP method.
     */
    public function get_method()
    {
        return $this->method;
    }
    /**
     * Sets HTTP method for the request.
     *
     * @since 4.4.0
     *
     * @param string $method HTTP method.
     */
    public function set_method($method)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_method") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 139")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_method:139@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves all headers from the request.
     *
     * @since 4.4.0
     *
     * @return array Map of key to value. Key is always lowercase, as per HTTP specification.
     */
    public function get_headers()
    {
        return $this->headers;
    }
    /**
     * Canonicalizes the header name.
     *
     * Ensures that header names are always treated the same regardless of
     * source. Header names are always case insensitive.
     *
     * Note that we treat `-` (dashes) and `_` (underscores) as the same
     * character, as per header parsing rules in both Apache and nginx.
     *
     * @link https://stackoverflow.com/q/18185366
     * @link https://www.nginx.com/resources/wiki/start/topics/tutorials/config_pitfalls/#missing-disappearing-http-headers
     * @link https://nginx.org/en/docs/http/ngx_http_core_module.html#underscores_in_headers
     *
     * @since 4.4.0
     *
     * @param string $key Header name.
     * @return string Canonicalized name.
     */
    public static function canonicalize_header_name($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("canonicalize_header_name") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 172")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called canonicalize_header_name:172@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves the given header from the request.
     *
     * If the header has multiple values, they will be concatenated with a comma
     * as per the HTTP specification. Be aware that some non-compliant headers
     * (notably cookie headers) cannot be joined this way.
     *
     * @since 4.4.0
     *
     * @param string $key Header name, will be canonicalized to lowercase.
     * @return string|null String value if set, null otherwise.
     */
    public function get_header($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_header") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 190")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_header:190@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves header values from the request.
     *
     * @since 4.4.0
     *
     * @param string $key Header name, will be canonicalized to lowercase.
     * @return array|null List of string values if set, null otherwise.
     */
    public function get_header_as_array($key)
    {
        $key = $this->canonicalize_header_name($key);
        if (!isset($this->headers[$key])) {
            return null;
        }
        return $this->headers[$key];
    }
    /**
     * Sets the header on request.
     *
     * @since 4.4.0
     *
     * @param string $key   Header name.
     * @param string $value Header value, or list of values.
     */
    public function set_header($key, $value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_header") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 222")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_header:222@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Appends a header value for the given header.
     *
     * @since 4.4.0
     *
     * @param string $key   Header name.
     * @param string $value Header value, or list of values.
     */
    public function add_header($key, $value)
    {
        $key = $this->canonicalize_header_name($key);
        $value = (array) $value;
        if (!isset($this->headers[$key])) {
            $this->headers[$key] = array();
        }
        $this->headers[$key] = array_merge($this->headers[$key], $value);
    }
    /**
     * Removes all values for a header.
     *
     * @since 4.4.0
     *
     * @param string $key Header name.
     */
    public function remove_header($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove_header") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 252")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove_header:252@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Sets headers on the request.
     *
     * @since 4.4.0
     *
     * @param array $headers  Map of header name to value.
     * @param bool  $override If true, replace the request's headers. Otherwise, merge with existing.
     */
    public function set_headers($headers, $override = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_headers") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 265")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_headers:265@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves the content-type of the request.
     *
     * @since 4.4.0
     *
     * @return array|null Map containing 'value' and 'parameters' keys
     *                    or null when no valid content-type header was
     *                    available.
     */
    public function get_content_type()
    {
        $value = $this->get_header('content-type');
        if (empty($value)) {
            return null;
        }
        $parameters = '';
        if (strpos($value, ';')) {
            list($value, $parameters) = explode(';', $value, 2);
        }
        $value = strtolower($value);
        if (false === strpos($value, '/')) {
            return null;
        }
        // Parse type and subtype out.
        list($type, $subtype) = explode('/', $value, 2);
        $data = compact('value', 'type', 'subtype', 'parameters');
        $data = array_map('trim', $data);
        return $data;
    }
    /**
     * Checks if the request has specified a JSON content-type.
     *
     * @since 5.6.0
     *
     * @return bool True if the content-type header is JSON.
     */
    public function is_json_content_type()
    {
        $content_type = $this->get_content_type();
        return isset($content_type['value']) && wp_is_json_media_type($content_type['value']);
    }
    /**
     * Retrieves the parameter priority order.
     *
     * Used when checking parameters in WP_REST_Request::get_param().
     *
     * @since 4.4.0
     *
     * @return string[] Array of types to check, in order of priority.
     */
    protected function get_parameter_order()
    {
        $order = array();
        if ($this->is_json_content_type()) {
            $order[] = 'JSON';
        }
        $this->parse_json_params();
        // Ensure we parse the body data.
        $body = $this->get_body();
        if ('POST' !== $this->method && !empty($body)) {
            $this->parse_body_params();
        }
        $accepts_body_data = array('POST', 'PUT', 'PATCH', 'DELETE');
        if (in_array($this->method, $accepts_body_data, true)) {
            $order[] = 'POST';
        }
        $order[] = 'GET';
        $order[] = 'URL';
        $order[] = 'defaults';
        /**
         * Filters the parameter priority order for a REST API request.
         *
         * The order affects which parameters are checked when using WP_REST_Request::get_param()
         * and family. This acts similarly to PHP's `request_order` setting.
         *
         * @since 4.4.0
         *
         * @param string[]        $order Array of types to check, in order of priority.
         * @param WP_REST_Request $this  The request object.
         */
        return apply_filters('rest_request_parameter_order', $order, $this);
    }
    /**
     * Retrieves a parameter from the request.
     *
     * @since 4.4.0
     *
     * @param string $key Parameter name.
     * @return mixed|null Value if set, null otherwise.
     */
    public function get_param($key)
    {
        $order = $this->get_parameter_order();
        foreach ($order as $type) {
            // Determine if we have the parameter for this type.
            if (isset($this->params[$type][$key])) {
                return $this->params[$type][$key];
            }
        }
        return null;
    }
    /**
     * Checks if a parameter exists in the request.
     *
     * This allows distinguishing between an omitted parameter,
     * and a parameter specifically set to null.
     *
     * @since 5.3.0
     *
     * @param string $key Parameter name.
     * @return bool True if a param exists for the given key.
     */
    public function has_param($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("has_param") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 386")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called has_param:386@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Sets a parameter on the request.
     *
     * If the given parameter key exists in any parameter type an update will take place,
     * otherwise a new param will be created in the first parameter type (respecting
     * get_parameter_order()).
     *
     * @since 4.4.0
     *
     * @param string $key   Parameter name.
     * @param mixed  $value Parameter value.
     */
    public function set_param($key, $value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_param") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 408")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_param:408@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves merged parameters from the request.
     *
     * The equivalent of get_param(), but returns all parameters for the request.
     * Handles merging all the available values into a single array.
     *
     * @since 4.4.0
     *
     * @return array Map of key to value.
     */
    public function get_params()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 432")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_params:432@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves parameters from the route itself.
     *
     * These are parsed from the URL using the regex.
     *
     * @since 4.4.0
     *
     * @return array Parameter map of key to value.
     */
    public function get_url_params()
    {
        return $this->params['URL'];
    }
    /**
     * Sets parameters from the route.
     *
     * Typically, this is set after parsing the URL.
     *
     * @since 4.4.0
     *
     * @param array $params Parameter map of key to value.
     */
    public function set_url_params($params)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_url_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 468")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_url_params:468@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves parameters from the query string.
     *
     * These are the parameters you'd typically find in `$_GET`.
     *
     * @since 4.4.0
     *
     * @return array Parameter map of key to value
     */
    public function get_query_params()
    {
        return $this->params['GET'];
    }
    /**
     * Sets parameters from the query string.
     *
     * Typically, this is set from `$_GET`.
     *
     * @since 4.4.0
     *
     * @param array $params Parameter map of key to value.
     */
    public function set_query_params($params)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_query_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 494")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_query_params:494@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves parameters from the body.
     *
     * These are the parameters you'd typically find in `$_POST`.
     *
     * @since 4.4.0
     *
     * @return array Parameter map of key to value.
     */
    public function get_body_params()
    {
        return $this->params['POST'];
    }
    /**
     * Sets parameters from the body.
     *
     * Typically, this is set from `$_POST`.
     *
     * @since 4.4.0
     *
     * @param array $params Parameter map of key to value.
     */
    public function set_body_params($params)
    {
        $this->params['POST'] = $params;
    }
    /**
     * Retrieves multipart file parameters from the body.
     *
     * These are the parameters you'd typically find in `$_FILES`.
     *
     * @since 4.4.0
     *
     * @return array Parameter map of key to value
     */
    public function get_file_params()
    {
        return $this->params['FILES'];
    }
    /**
     * Sets multipart file parameters from the body.
     *
     * Typically, this is set from `$_FILES`.
     *
     * @since 4.4.0
     *
     * @param array $params Parameter map of key to value.
     */
    public function set_file_params($params)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_file_params") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 546")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_file_params:546@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves the default parameters.
     *
     * These are the parameters set in the route registration.
     *
     * @since 4.4.0
     *
     * @return array Parameter map of key to value
     */
    public function get_default_params()
    {
        return $this->params['defaults'];
    }
    /**
     * Sets default parameters.
     *
     * These are the parameters set in the route registration.
     *
     * @since 4.4.0
     *
     * @param array $params Parameter map of key to value.
     */
    public function set_default_params($params)
    {
        $this->params['defaults'] = $params;
    }
    /**
     * Retrieves the request body content.
     *
     * @since 4.4.0
     *
     * @return string Binary data from the request body.
     */
    public function get_body()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_body") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 583")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_body:583@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Sets body content.
     *
     * @since 4.4.0
     *
     * @param string $data Binary data from the request body.
     */
    public function set_body($data)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_body") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 594")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_body:594@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves the parameters from a JSON-formatted body.
     *
     * @since 4.4.0
     *
     * @return array Parameter map of key to value.
     */
    public function get_json_params()
    {
        // Ensure the parameters have been parsed out.
        $this->parse_json_params();
        return $this->params['JSON'];
    }
    /**
     * Parses the JSON parameters.
     *
     * Avoids parsing the JSON data until we need to access it.
     *
     * @since 4.4.0
     * @since 4.7.0 Returns error instance if value cannot be decoded.
     * @return true|WP_Error True if the JSON data was passed or no JSON data was provided, WP_Error if invalid JSON was passed.
     */
    protected function parse_json_params()
    {
        if ($this->parsed_json) {
            return true;
        }
        $this->parsed_json = true;
        // Check that we actually got JSON.
        if (!$this->is_json_content_type()) {
            return true;
        }
        $body = $this->get_body();
        if (empty($body)) {
            return true;
        }
        $params = json_decode($body, true);
        /*
         * Check for a parsing error.
         */
        if (null === $params && JSON_ERROR_NONE !== json_last_error()) {
            // Ensure subsequent calls receive error instance.
            $this->parsed_json = false;
            $error_data = array('status' => WP_Http::BAD_REQUEST, 'json_error_code' => json_last_error(), 'json_error_message' => json_last_error_msg());
            return new WP_Error('rest_invalid_json', __('Invalid JSON body passed.'), $error_data);
        }
        $this->params['JSON'] = $params;
        return true;
    }
    /**
     * Parses the request body parameters.
     *
     * Parses out URL-encoded bodies for request methods that aren't supported
     * natively by PHP. In PHP 5.x, only POST has these parsed automatically.
     *
     * @since 4.4.0
     */
    protected function parse_body_params()
    {
        if ($this->parsed_body) {
            return;
        }
        $this->parsed_body = true;
        /*
         * Check that we got URL-encoded. Treat a missing content-type as
         * URL-encoded for maximum compatibility.
         */
        $content_type = $this->get_content_type();
        if (!empty($content_type) && 'application/x-www-form-urlencoded' !== $content_type['value']) {
            return;
        }
        parse_str($this->get_body(), $params);
        /*
         * Add to the POST parameters stored internally. If a user has already
         * set these manually (via `set_body_params`), don't override them.
         */
        $this->params['POST'] = array_merge($params, $this->params['POST']);
    }
    /**
     * Retrieves the route that matched the request.
     *
     * @since 4.4.0
     *
     * @return string Route matching regex.
     */
    public function get_route()
    {
        return $this->route;
    }
    /**
     * Sets the route that matched the request.
     *
     * @since 4.4.0
     *
     * @param string $route Route matching regex.
     */
    public function set_route($route)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_route") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 698")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_route:698@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Retrieves the attributes for the request.
     *
     * These are the options for the route that was matched.
     *
     * @since 4.4.0
     *
     * @return array Attributes for the request.
     */
    public function get_attributes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_attributes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 711")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_attributes:711@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Sets the attributes for the request.
     *
     * @since 4.4.0
     *
     * @param array $attributes Attributes for the request.
     */
    public function set_attributes($attributes)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_attributes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 722")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_attributes:722@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Sanitizes (where possible) the params on the request.
     *
     * This is primarily based off the sanitize_callback param on each registered
     * argument.
     *
     * @since 4.4.0
     *
     * @return true|WP_Error True if parameters were sanitized, WP_Error if an error occurred during sanitization.
     */
    public function sanitize_params()
    {
        $attributes = $this->get_attributes();
        // No arguments set, skip sanitizing.
        if (empty($attributes['args'])) {
            return true;
        }
        $order = $this->get_parameter_order();
        $invalid_params = array();
        $invalid_details = array();
        foreach ($order as $type) {
            if (empty($this->params[$type])) {
                continue;
            }
            foreach ($this->params[$type] as $key => $value) {
                if (!isset($attributes['args'][$key])) {
                    continue;
                }
                $param_args = $attributes['args'][$key];
                // If the arg has a type but no sanitize_callback attribute, default to rest_parse_request_arg.
                if (!array_key_exists('sanitize_callback', $param_args) && !empty($param_args['type'])) {
                    $param_args['sanitize_callback'] = 'rest_parse_request_arg';
                }
                // If there's still no sanitize_callback, nothing to do here.
                if (empty($param_args['sanitize_callback'])) {
                    continue;
                }
                /** @var mixed|WP_Error $sanitized_value */
                $sanitized_value = call_user_func($param_args['sanitize_callback'], $value, $this, $key);
                if (is_wp_error($sanitized_value)) {
                    $invalid_params[$key] = implode(' ', $sanitized_value->get_error_messages());
                    $invalid_details[$key] = rest_convert_error_to_response($sanitized_value)->get_data();
                } else {
                    $this->params[$type][$key] = $sanitized_value;
                }
            }
        }
        if ($invalid_params) {
            return new WP_Error(
                'rest_invalid_param',
                /* translators: %s: List of invalid parameters. */
                sprintf(__('Invalid parameter(s): %s'), implode(', ', array_keys($invalid_params))),
                array('status' => 400, 'params' => $invalid_params, 'details' => $invalid_details)
            );
        }
        return true;
    }
    /**
     * Checks whether this request is valid according to its attributes.
     *
     * @since 4.4.0
     *
     * @return true|WP_Error True if there are no parameters to validate or if all pass validation,
     *                       WP_Error if required parameters are missing.
     */
    public function has_valid_params()
    {
        // If JSON data was passed, check for errors.
        $json_error = $this->parse_json_params();
        if (is_wp_error($json_error)) {
            return $json_error;
        }
        $attributes = $this->get_attributes();
        $required = array();
        $args = empty($attributes['args']) ? array() : $attributes['args'];
        foreach ($args as $key => $arg) {
            $param = $this->get_param($key);
            if (isset($arg['required']) && true === $arg['required'] && null === $param) {
                $required[] = $key;
            }
        }
        if (!empty($required)) {
            return new WP_Error(
                'rest_missing_callback_param',
                /* translators: %s: List of required parameters. */
                sprintf(__('Missing parameter(s): %s'), implode(', ', $required)),
                array('status' => 400, 'params' => $required)
            );
        }
        /*
         * Check the validation callbacks for each registered arg.
         *
         * This is done after required checking as required checking is cheaper.
         */
        $invalid_params = array();
        $invalid_details = array();
        foreach ($args as $key => $arg) {
            $param = $this->get_param($key);
            if (null !== $param && !empty($arg['validate_callback'])) {
                /** @var bool|\WP_Error $valid_check */
                $valid_check = call_user_func($arg['validate_callback'], $param, $this, $key);
                if (false === $valid_check) {
                    $invalid_params[$key] = __('Invalid parameter.');
                }
                if (is_wp_error($valid_check)) {
                    $invalid_params[$key] = implode(' ', $valid_check->get_error_messages());
                    $invalid_details[$key] = rest_convert_error_to_response($valid_check)->get_data();
                }
            }
        }
        if ($invalid_params) {
            return new WP_Error(
                'rest_invalid_param',
                /* translators: %s: List of invalid parameters. */
                sprintf(__('Invalid parameter(s): %s'), implode(', ', array_keys($invalid_params))),
                array('status' => 400, 'params' => $invalid_params, 'details' => $invalid_details)
            );
        }
        if (isset($attributes['validate_callback'])) {
            $valid_check = call_user_func($attributes['validate_callback'], $this);
            if (is_wp_error($valid_check)) {
                return $valid_check;
            }
            if (false === $valid_check) {
                // A WP_Error instance is preferred, but false is supported for parity with the per-arg validate_callback.
                return new WP_Error('rest_invalid_params', __('Invalid parameters.'), array('status' => 400));
            }
        }
        return true;
    }
    /**
     * Checks if a parameter is set.
     *
     * @since 4.4.0
     *
     * @param string $offset Parameter name.
     * @return bool Whether the parameter is set.
     */
    public function offsetExists($offset)
    {
        $order = $this->get_parameter_order();
        foreach ($order as $type) {
            if (isset($this->params[$type][$offset])) {
                return true;
            }
        }
        return false;
    }
    /**
     * Retrieves a parameter from the request.
     *
     * @since 4.4.0
     *
     * @param string $offset Parameter name.
     * @return mixed|null Value if set, null otherwise.
     */
    public function offsetGet($offset)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetGet") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 882")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetGet:882@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Sets a parameter on the request.
     *
     * @since 4.4.0
     *
     * @param string $offset Parameter name.
     * @param mixed  $value  Parameter value.
     */
    public function offsetSet($offset, $value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetSet") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php at line 894")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetSet:894@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/rest-api/class-wp-rest-request.php');
        die();
    }
    /**
     * Removes a parameter from the request.
     *
     * @since 4.4.0
     *
     * @param string $offset Parameter name.
     */
    public function offsetUnset($offset)
    {
        $order = $this->get_parameter_order();
        // Remove the offset from every group.
        foreach ($order as $type) {
            unset($this->params[$type][$offset]);
        }
    }
    /**
     * Retrieves a WP_REST_Request object from a full URL.
     *
     * @since 4.5.0
     *
     * @param string $url URL with protocol, domain, path and query args.
     * @return WP_REST_Request|false WP_REST_Request object on success, false on failure.
     */
    public static function from_url($url)
    {
        $bits = parse_url($url);
        $query_params = array();
        if (!empty($bits['query'])) {
            wp_parse_str($bits['query'], $query_params);
        }
        $api_root = rest_url();
        if (get_option('permalink_structure') && 0 === strpos($url, $api_root)) {
            // Pretty permalinks on, and URL is under the API root.
            $api_url_part = substr($url, strlen(untrailingslashit($api_root)));
            $route = parse_url($api_url_part, PHP_URL_PATH);
        } elseif (!empty($query_params['rest_route'])) {
            // ?rest_route=... set directly.
            $route = $query_params['rest_route'];
            unset($query_params['rest_route']);
        }
        $request = false;
        if (!empty($route)) {
            $request = new WP_REST_Request('GET', $route);
            $request->set_query_params($query_params);
        }
        /**
         * Filters the REST API request generated from a URL.
         *
         * @since 4.5.0
         *
         * @param WP_REST_Request|false $request Generated request object, or false if URL
         *                                       could not be parsed.
         * @param string                $url     URL the request was generated from.
         */
        return apply_filters('rest_request_from_url', $request, $url);
    }
}