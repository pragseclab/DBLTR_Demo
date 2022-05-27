<?php

/**
 * HTTP response class
 *
 * Contains a response from Requests::request()
 * @package Requests
 */
/**
 * HTTP response class
 *
 * Contains a response from Requests::request()
 * @package Requests
 */
class Requests_Response
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->headers = new Requests_Response_Headers();
        $this->cookies = new Requests_Cookie_Jar();
    }
    /**
     * Response body
     *
     * @var string
     */
    public $body = '';
    /**
     * Raw HTTP data from the transport
     *
     * @var string
     */
    public $raw = '';
    /**
     * Headers, as an associative array
     *
     * @var Requests_Response_Headers Array-like object representing headers
     */
    public $headers = array();
    /**
     * Status code, false if non-blocking
     *
     * @var integer|boolean
     */
    public $status_code = false;
    /**
     * Protocol version, false if non-blocking
     * @var float|boolean
     */
    public $protocol_version = false;
    /**
     * Whether the request succeeded or not
     *
     * @var boolean
     */
    public $success = false;
    /**
     * Number of redirects the request used
     *
     * @var integer
     */
    public $redirects = 0;
    /**
     * URL requested
     *
     * @var string
     */
    public $url = '';
    /**
     * Previous requests (from redirects)
     *
     * @var array Array of Requests_Response objects
     */
    public $history = array();
    /**
     * Cookies from the request
     *
     * @var Requests_Cookie_Jar Array-like object representing a cookie jar
     */
    public $cookies = array();
    /**
     * Is the response a redirect?
     *
     * @return boolean True if redirect (3xx status), false if not.
     */
    public function is_redirect()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_redirect") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/Requests/Response.php at line 91")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_redirect:91@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/Requests/Response.php');
        die();
    }
    /**
     * Throws an exception if the request was not successful
     *
     * @throws Requests_Exception If `$allow_redirects` is false, and code is 3xx (`response.no_redirects`)
     * @throws Requests_Exception_HTTP On non-successful status code. Exception class corresponds to code (e.g. {@see Requests_Exception_HTTP_404})
     * @param boolean $allow_redirects Set to false to throw on a 3xx as well
     */
    public function throw_for_status($allow_redirects = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("throw_for_status") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/Requests/Response.php at line 103")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called throw_for_status:103@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/Requests/Response.php');
        die();
    }
}