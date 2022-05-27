<?php

/**
 * HTTP API: WP_HTTP_Requests_Response class
 *
 * @package WordPress
 * @subpackage HTTP
 * @since 4.6.0
 */
/**
 * Core wrapper object for a Requests_Response for standardisation.
 *
 * @since 4.6.0
 *
 * @see WP_HTTP_Response
 */
class WP_HTTP_Requests_Response extends WP_HTTP_Response
{
    /**
     * Requests Response object.
     *
     * @since 4.6.0
     * @var Requests_Response
     */
    protected $response;
    /**
     * Filename the response was saved to.
     *
     * @since 4.6.0
     * @var string|null
     */
    protected $filename;
    /**
     * Constructor.
     *
     * @since 4.6.0
     *
     * @param Requests_Response $response HTTP response.
     * @param string            $filename Optional. File name. Default empty.
     */
    public function __construct(Requests_Response $response, $filename = '')
    {
        $this->response = $response;
        $this->filename = $filename;
    }
    /**
     * Retrieves the response object for the request.
     *
     * @since 4.6.0
     *
     * @return Requests_Response HTTP response.
     */
    public function get_response_object()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_response_object") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php at line 55")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_response_object:55@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php');
        die();
    }
    /**
     * Retrieves headers associated with the response.
     *
     * @since 4.6.0
     *
     * @return \Requests_Utility_CaseInsensitiveDictionary Map of header name to header value.
     */
    public function get_headers()
    {
        // Ensure headers remain case-insensitive.
        $converted = new Requests_Utility_CaseInsensitiveDictionary();
        foreach ($this->response->headers->getAll() as $key => $value) {
            if (count($value) === 1) {
                $converted[$key] = $value[0];
            } else {
                $converted[$key] = $value;
            }
        }
        return $converted;
    }
    /**
     * Sets all header values.
     *
     * @since 4.6.0
     *
     * @param array $headers Map of header name to header value.
     */
    public function set_headers($headers)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_headers") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php at line 86")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_headers:86@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php');
        die();
    }
    /**
     * Sets a single HTTP header.
     *
     * @since 4.6.0
     *
     * @param string $key     Header name.
     * @param string $value   Header value.
     * @param bool   $replace Optional. Whether to replace an existing header of the same name.
     *                        Default true.
     */
    public function header($key, $value, $replace = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("header") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php at line 100")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called header:100@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php');
        die();
    }
    /**
     * Retrieves the HTTP return code for the response.
     *
     * @since 4.6.0
     *
     * @return int The 3-digit HTTP status code.
     */
    public function get_status()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_status") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php at line 114")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_status:114@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php');
        die();
    }
    /**
     * Sets the 3-digit HTTP status code.
     *
     * @since 4.6.0
     *
     * @param int $code HTTP status.
     */
    public function set_status($code)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_status") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php at line 125")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_status:125@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php');
        die();
    }
    /**
     * Retrieves the response data.
     *
     * @since 4.6.0
     *
     * @return string Response data.
     */
    public function get_data()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php at line 136")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_data:136@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php');
        die();
    }
    /**
     * Sets the response data.
     *
     * @since 4.6.0
     *
     * @param string $data Response data.
     */
    public function set_data($data)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php at line 147")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_data:147@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php');
        die();
    }
    /**
     * Retrieves cookies from the response.
     *
     * @since 4.6.0
     *
     * @return WP_HTTP_Cookie[] List of cookie objects.
     */
    public function get_cookies()
    {
        $cookies = array();
        foreach ($this->response->cookies as $cookie) {
            $cookies[] = new WP_Http_Cookie(array('name' => $cookie->name, 'value' => urldecode($cookie->value), 'expires' => isset($cookie->attributes['expires']) ? $cookie->attributes['expires'] : null, 'path' => isset($cookie->attributes['path']) ? $cookie->attributes['path'] : null, 'domain' => isset($cookie->attributes['domain']) ? $cookie->attributes['domain'] : null, 'host_only' => isset($cookie->flags['host-only']) ? $cookie->flags['host-only'] : null));
        }
        return $cookies;
    }
    /**
     * Converts the object to a WP_Http response array.
     *
     * @since 4.6.0
     *
     * @return array WP_Http response array, per WP_Http::request().
     */
    public function to_array()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("to_array") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php at line 173")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called to_array:173@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-requests-response.php');
        die();
    }
}