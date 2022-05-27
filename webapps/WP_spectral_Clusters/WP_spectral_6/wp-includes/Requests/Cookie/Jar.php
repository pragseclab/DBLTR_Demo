<?php

/**
 * Cookie holder object
 *
 * @package Requests
 * @subpackage Cookies
 */
/**
 * Cookie holder object
 *
 * @package Requests
 * @subpackage Cookies
 */
class Requests_Cookie_Jar implements ArrayAccess, IteratorAggregate
{
    /**
     * Actual item data
     *
     * @var array
     */
    protected $cookies = array();
    /**
     * Create a new jar
     *
     * @param array $cookies Existing cookie values
     */
    public function __construct($cookies = array())
    {
        $this->cookies = $cookies;
    }
    /**
     * Normalise cookie data into a Requests_Cookie
     *
     * @param string|Requests_Cookie $cookie
     * @return Requests_Cookie
     */
    public function normalize_cookie($cookie, $key = null)
    {
        if ($cookie instanceof Requests_Cookie) {
            return $cookie;
        }
        return Requests_Cookie::parse($cookie, $key);
    }
    /**
     * Normalise cookie data into a Requests_Cookie
     *
     * @codeCoverageIgnore
     * @deprecated Use {@see Requests_Cookie_Jar::normalize_cookie}
     * @return Requests_Cookie
     */
    public function normalizeCookie($cookie, $key = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("normalizeCookie") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php at line 54")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called normalizeCookie:54@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php');
        die();
    }
    /**
     * Check if the given item exists
     *
     * @param string $key Item key
     * @return boolean Does the item exist?
     */
    public function offsetExists($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetExists") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php at line 64")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetExists:64@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php');
        die();
    }
    /**
     * Get the value for the item
     *
     * @param string $key Item key
     * @return string Item value
     */
    public function offsetGet($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetGet") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php at line 74")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetGet:74@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php');
        die();
    }
    /**
     * Set the given item
     *
     * @throws Requests_Exception On attempting to use dictionary as list (`invalidset`)
     *
     * @param string $key Item name
     * @param string $value Item value
     */
    public function offsetSet($key, $value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetSet") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php at line 89")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetSet:89@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php');
        die();
    }
    /**
     * Unset the given header
     *
     * @param string $key
     */
    public function offsetUnset($key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("offsetUnset") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php at line 101")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called offsetUnset:101@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php');
        die();
    }
    /**
     * Get an iterator for the data
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getIterator") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php at line 110")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getIterator:110@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Cookie/Jar.php');
        die();
    }
    /**
     * Register the cookie handler with the request's hooking system
     *
     * @param Requests_Hooker $hooks Hooking system
     */
    public function register(Requests_Hooker $hooks)
    {
        $hooks->register('requests.before_request', array($this, 'before_request'));
        $hooks->register('requests.before_redirect_check', array($this, 'before_redirect_check'));
    }
    /**
     * Add Cookie header to a request if we have any
     *
     * As per RFC 6265, cookies are separated by '; '
     *
     * @param string $url
     * @param array $headers
     * @param array $data
     * @param string $type
     * @param array $options
     */
    public function before_request($url, &$headers, &$data, &$type, &$options)
    {
        if (!$url instanceof Requests_IRI) {
            $url = new Requests_IRI($url);
        }
        if (!empty($this->cookies)) {
            $cookies = array();
            foreach ($this->cookies as $key => $cookie) {
                $cookie = $this->normalize_cookie($cookie, $key);
                // Skip expired cookies
                if ($cookie->is_expired()) {
                    continue;
                }
                if ($cookie->domain_matches($url->host)) {
                    $cookies[] = $cookie->format_for_header();
                }
            }
            $headers['Cookie'] = implode('; ', $cookies);
        }
    }
    /**
     * Parse all cookies from a response and attach them to the response
     *
     * @var Requests_Response $response
     */
    public function before_redirect_check(Requests_Response &$return)
    {
        $url = $return->url;
        if (!$url instanceof Requests_IRI) {
            $url = new Requests_IRI($url);
        }
        $cookies = Requests_Cookie::parse_from_headers($return->headers, $url);
        $this->cookies = array_merge($this->cookies, $cookies);
        $return->cookies = $this;
    }
}