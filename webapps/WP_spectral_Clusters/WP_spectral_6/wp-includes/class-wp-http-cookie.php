<?php

/**
 * HTTP API: WP_Http_Cookie class
 *
 * @package WordPress
 * @subpackage HTTP
 * @since 4.4.0
 */
/**
 * Core class used to encapsulate a single cookie object for internal use.
 *
 * Returned cookies are represented using this class, and when cookies are set, if they are not
 * already a WP_Http_Cookie() object, then they are turned into one.
 *
 * @todo The WordPress convention is to use underscores instead of camelCase for function and method
 * names. Need to switch to use underscores instead for the methods.
 *
 * @since 2.8.0
 */
class WP_Http_Cookie
{
    /**
     * Cookie name.
     *
     * @since 2.8.0
     * @var string
     */
    public $name;
    /**
     * Cookie value.
     *
     * @since 2.8.0
     * @var string
     */
    public $value;
    /**
     * When the cookie expires. Unix timestamp or formatted date.
     *
     * @since 2.8.0
     * @var string|int|null
     */
    public $expires;
    /**
     * Cookie URL path.
     *
     * @since 2.8.0
     * @var string
     */
    public $path;
    /**
     * Cookie Domain.
     *
     * @since 2.8.0
     * @var string
     */
    public $domain;
    /**
     * host-only flag.
     *
     * @since 5.2.0
     * @var bool
     */
    public $host_only;
    /**
     * Sets up this cookie object.
     *
     * The parameter $data should be either an associative array containing the indices names below
     * or a header string detailing it.
     *
     * @since 2.8.0
     * @since 5.2.0 Added `host_only` to the `$data` parameter.
     *
     * @param string|array $data {
     *     Raw cookie data as header string or data array.
     *
     *     @type string          $name      Cookie name.
     *     @type mixed           $value     Value. Should NOT already be urlencoded.
     *     @type string|int|null $expires   Optional. Unix timestamp or formatted date. Default null.
     *     @type string          $path      Optional. Path. Default '/'.
     *     @type string          $domain    Optional. Domain. Default host of parsed $requested_url.
     *     @type int             $port      Optional. Port. Default null.
     *     @type bool            $host_only Optional. host-only storage flag. Default true.
     * }
     * @param string       $requested_url The URL which the cookie was set on, used for default $domain
     *                                    and $port values.
     */
    public function __construct($data, $requested_url = '')
    {
        if ($requested_url) {
            $arrURL = parse_url($requested_url);
        }
        if (isset($arrURL['host'])) {
            $this->domain = $arrURL['host'];
        }
        $this->path = isset($arrURL['path']) ? $arrURL['path'] : '/';
        if ('/' !== substr($this->path, -1)) {
            $this->path = dirname($this->path) . '/';
        }
        if (is_string($data)) {
            // Assume it's a header string direct from a previous request.
            $pairs = explode(';', $data);
            // Special handling for first pair; name=value. Also be careful of "=" in value.
            $name = trim(substr($pairs[0], 0, strpos($pairs[0], '=')));
            $value = substr($pairs[0], strpos($pairs[0], '=') + 1);
            $this->name = $name;
            $this->value = urldecode($value);
            // Removes name=value from items.
            array_shift($pairs);
            // Set everything else as a property.
            foreach ($pairs as $pair) {
                $pair = rtrim($pair);
                // Handle the cookie ending in ; which results in a empty final pair.
                if (empty($pair)) {
                    continue;
                }
                list($key, $val) = strpos($pair, '=') ? explode('=', $pair) : array($pair, '');
                $key = strtolower(trim($key));
                if ('expires' === $key) {
                    $val = strtotime($val);
                }
                $this->{$key} = $val;
            }
        } else {
            if (!isset($data['name'])) {
                return;
            }
            // Set properties based directly on parameters.
            foreach (array('name', 'value', 'path', 'domain', 'port', 'host_only') as $field) {
                if (isset($data[$field])) {
                    $this->{$field} = $data[$field];
                }
            }
            if (isset($data['expires'])) {
                $this->expires = is_int($data['expires']) ? $data['expires'] : strtotime($data['expires']);
            } else {
                $this->expires = null;
            }
        }
    }
    /**
     * Confirms that it's OK to send this cookie to the URL checked against.
     *
     * Decision is based on RFC 2109/2965, so look there for details on validity.
     *
     * @since 2.8.0
     *
     * @param string $url URL you intend to send this cookie to
     * @return bool true if allowed, false otherwise.
     */
    public function test($url)
    {
        if (is_null($this->name)) {
            return false;
        }
        // Expires - if expired then nothing else matters.
        if (isset($this->expires) && time() > $this->expires) {
            return false;
        }
        // Get details on the URL we're thinking about sending to.
        $url = parse_url($url);
        $url['port'] = isset($url['port']) ? $url['port'] : ('https' === $url['scheme'] ? 443 : 80);
        $url['path'] = isset($url['path']) ? $url['path'] : '/';
        // Values to use for comparison against the URL.
        $path = isset($this->path) ? $this->path : '/';
        $port = isset($this->port) ? $this->port : null;
        $domain = isset($this->domain) ? strtolower($this->domain) : strtolower($url['host']);
        if (false === stripos($domain, '.')) {
            $domain .= '.local';
        }
        // Host - very basic check that the request URL ends with the domain restriction (minus leading dot).
        $domain = '.' === substr($domain, 0, 1) ? substr($domain, 1) : $domain;
        if (substr($url['host'], -strlen($domain)) != $domain) {
            return false;
        }
        // Port - supports "port-lists" in the format: "80,8000,8080".
        if (!empty($port) && !in_array($url['port'], array_map('intval', explode(',', $port)), true)) {
            return false;
        }
        // Path - request path must start with path restriction.
        if (substr($url['path'], 0, strlen($path)) != $path) {
            return false;
        }
        return true;
    }
    /**
     * Convert cookie name and value back to header string.
     *
     * @since 2.8.0
     *
     * @return string Header encoded cookie name and value.
     */
    public function getHeaderValue()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHeaderValue") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-cookie.php at line 196")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHeaderValue:196@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-cookie.php');
        die();
    }
    /**
     * Retrieve cookie header for usage in the rest of the WordPress HTTP API.
     *
     * @since 2.8.0
     *
     * @return string
     */
    public function getFullHeader()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFullHeader") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-cookie.php at line 219")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFullHeader:219@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-cookie.php');
        die();
    }
    /**
     * Retrieves cookie attributes.
     *
     * @since 4.6.0
     *
     * @return array {
     *     List of attributes.
     *
     *     @type string|int|null $expires When the cookie expires. Unix timestamp or formatted date.
     *     @type string          $path    Cookie URL path.
     *     @type string          $domain  Cookie domain.
     * }
     */
    public function get_attributes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_attributes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-cookie.php at line 236")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_attributes:236@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class-wp-http-cookie.php');
        die();
    }
}