<?php

/**
 * HTTP API: WP_Http class
 *
 * @package WordPress
 * @subpackage HTTP
 * @since 2.7.0
 */
if (!class_exists('Requests')) {
    require ABSPATH . WPINC . '/class-requests.php';
    Requests::register_autoloader();
    Requests::set_certificate_path(ABSPATH . WPINC . '/certificates/ca-bundle.crt');
}
/**
 * Core class used for managing HTTP transports and making HTTP requests.
 *
 * This class is used to consistently make outgoing HTTP requests easy for developers
 * while still being compatible with the many PHP configurations under which
 * WordPress runs.
 *
 * Debugging includes several actions, which pass different variables for debugging the HTTP API.
 *
 * @since 2.7.0
 */
class WP_Http
{
    // Aliases for HTTP response codes.
    const HTTP_CONTINUE = 100;
    const SWITCHING_PROTOCOLS = 101;
    const PROCESSING = 102;
    const EARLY_HINTS = 103;
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NON_AUTHORITATIVE_INFORMATION = 203;
    const NO_CONTENT = 204;
    const RESET_CONTENT = 205;
    const PARTIAL_CONTENT = 206;
    const MULTI_STATUS = 207;
    const IM_USED = 226;
    const MULTIPLE_CHOICES = 300;
    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const SEE_OTHER = 303;
    const NOT_MODIFIED = 304;
    const USE_PROXY = 305;
    const RESERVED = 306;
    const TEMPORARY_REDIRECT = 307;
    const PERMANENT_REDIRECT = 308;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const PAYMENT_REQUIRED = 402;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_ACCEPTABLE = 406;
    const PROXY_AUTHENTICATION_REQUIRED = 407;
    const REQUEST_TIMEOUT = 408;
    const CONFLICT = 409;
    const GONE = 410;
    const LENGTH_REQUIRED = 411;
    const PRECONDITION_FAILED = 412;
    const REQUEST_ENTITY_TOO_LARGE = 413;
    const REQUEST_URI_TOO_LONG = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const EXPECTATION_FAILED = 417;
    const IM_A_TEAPOT = 418;
    const MISDIRECTED_REQUEST = 421;
    const UNPROCESSABLE_ENTITY = 422;
    const LOCKED = 423;
    const FAILED_DEPENDENCY = 424;
    const UPGRADE_REQUIRED = 426;
    const PRECONDITION_REQUIRED = 428;
    const TOO_MANY_REQUESTS = 429;
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    const UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const VARIANT_ALSO_NEGOTIATES = 506;
    const INSUFFICIENT_STORAGE = 507;
    const NOT_EXTENDED = 510;
    const NETWORK_AUTHENTICATION_REQUIRED = 511;
    /**
     * Send an HTTP request to a URI.
     *
     * Please note: The only URI that are supported in the HTTP Transport implementation
     * are the HTTP and HTTPS protocols.
     *
     * @since 2.7.0
     *
     * @param string       $url  The request URL.
     * @param string|array $args {
     *     Optional. Array or string of HTTP request arguments.
     *
     *     @type string       $method              Request method. Accepts 'GET', 'POST', 'HEAD', 'PUT', 'DELETE',
     *                                             'TRACE', 'OPTIONS', or 'PATCH'.
     *                                             Some transports technically allow others, but should not be
     *                                             assumed. Default 'GET'.
     *     @type float        $timeout             How long the connection should stay open in seconds. Default 5.
     *     @type int          $redirection         Number of allowed redirects. Not supported by all transports
     *                                             Default 5.
     *     @type string       $httpversion         Version of the HTTP protocol to use. Accepts '1.0' and '1.1'.
     *                                             Default '1.0'.
     *     @type string       $user-agent          User-agent value sent.
     *                                             Default 'WordPress/' . get_bloginfo( 'version' ) . '; ' . get_bloginfo( 'url' ).
     *     @type bool         $reject_unsafe_urls  Whether to pass URLs through wp_http_validate_url().
     *                                             Default false.
     *     @type bool         $blocking            Whether the calling code requires the result of the request.
     *                                             If set to false, the request will be sent to the remote server,
     *                                             and processing returned to the calling code immediately, the caller
     *                                             will know if the request succeeded or failed, but will not receive
     *                                             any response from the remote server. Default true.
     *     @type string|array $headers             Array or string of headers to send with the request.
     *                                             Default empty array.
     *     @type array        $cookies             List of cookies to send with the request. Default empty array.
     *     @type string|array $body                Body to send with the request. Default null.
     *     @type bool         $compress            Whether to compress the $body when sending the request.
     *                                             Default false.
     *     @type bool         $decompress          Whether to decompress a compressed response. If set to false and
     *                                             compressed content is returned in the response anyway, it will
     *                                             need to be separately decompressed. Default true.
     *     @type bool         $sslverify           Whether to verify SSL for the request. Default true.
     *     @type string       $sslcertificates     Absolute path to an SSL certificate .crt file.
     *                                             Default ABSPATH . WPINC . '/certificates/ca-bundle.crt'.
     *     @type bool         $stream              Whether to stream to a file. If set to true and no filename was
     *                                             given, it will be droped it in the WP temp dir and its name will
     *                                             be set using the basename of the URL. Default false.
     *     @type string       $filename            Filename of the file to write to when streaming. $stream must be
     *                                             set to true. Default null.
     *     @type int          $limit_response_size Size in bytes to limit the response to. Default null.
     *
     * }
     * @return array|WP_Error Array containing 'headers', 'body', 'response', 'cookies', 'filename'.
     *                        A WP_Error instance upon error.
     */
    public function request($url, $args = array())
    {
        $defaults = array(
            'method' => 'GET',
            /**
             * Filters the timeout value for an HTTP request.
             *
             * @since 2.7.0
             * @since 5.1.0 The `$url` parameter was added.
             *
             * @param float  $timeout_value Time in seconds until a request times out. Default 5.
             * @param string $url           The request URL.
             */
            'timeout' => apply_filters('http_request_timeout', 5, $url),
            /**
             * Filters the number of redirects allowed during an HTTP request.
             *
             * @since 2.7.0
             * @since 5.1.0 The `$url` parameter was added.
             *
             * @param int    $redirect_count Number of redirects allowed. Default 5.
             * @param string $url            The request URL.
             */
            'redirection' => apply_filters('http_request_redirection_count', 5, $url),
            /**
             * Filters the version of the HTTP protocol used in a request.
             *
             * @since 2.7.0
             * @since 5.1.0 The `$url` parameter was added.
             *
             * @param string $version Version of HTTP used. Accepts '1.0' and '1.1'. Default '1.0'.
             * @param string $url     The request URL.
             */
            'httpversion' => apply_filters('http_request_version', '1.0', $url),
            /**
             * Filters the user agent value sent with an HTTP request.
             *
             * @since 2.7.0
             * @since 5.1.0 The `$url` parameter was added.
             *
             * @param string $user_agent WordPress user agent string.
             * @param string $url        The request URL.
             */
            'user-agent' => apply_filters('http_headers_useragent', 'WordPress/' . get_bloginfo('version') . '; ' . get_bloginfo('url'), $url),
            /**
             * Filters whether to pass URLs through wp_http_validate_url() in an HTTP request.
             *
             * @since 3.6.0
             * @since 5.1.0 The `$url` parameter was added.
             *
             * @param bool   $pass_url Whether to pass URLs through wp_http_validate_url(). Default false.
             * @param string $url      The request URL.
             */
            'reject_unsafe_urls' => apply_filters('http_request_reject_unsafe_urls', false, $url),
            'blocking' => true,
            'headers' => array(),
            'cookies' => array(),
            'body' => null,
            'compress' => false,
            'decompress' => true,
            'sslverify' => true,
            'sslcertificates' => ABSPATH . WPINC . '/certificates/ca-bundle.crt',
            'stream' => false,
            'filename' => null,
            'limit_response_size' => null,
        );
        // Pre-parse for the HEAD checks.
        $args = wp_parse_args($args);
        // By default, HEAD requests do not cause redirections.
        if (isset($args['method']) && 'HEAD' === $args['method']) {
            $defaults['redirection'] = 0;
        }
        $parsed_args = wp_parse_args($args, $defaults);
        /**
         * Filters the arguments used in an HTTP request.
         *
         * @since 2.7.0
         *
         * @param array  $parsed_args An array of HTTP request arguments.
         * @param string $url         The request URL.
         */
        $parsed_args = apply_filters('http_request_args', $parsed_args, $url);
        // The transports decrement this, store a copy of the original value for loop purposes.
        if (!isset($parsed_args['_redirection'])) {
            $parsed_args['_redirection'] = $parsed_args['redirection'];
        }
        /**
         * Filters the preemptive return value of an HTTP request.
         *
         * Returning a non-false value from the filter will short-circuit the HTTP request and return
         * early with that value. A filter should return one of:
         *
         *  - An array containing 'headers', 'body', 'response', 'cookies', and 'filename' elements
         *  - A WP_Error instance
         *  - boolean false to avoid short-circuiting the response
         *
         * Returning any other value may result in unexpected behaviour.
         *
         * @since 2.9.0
         *
         * @param false|array|WP_Error $preempt     A preemptive return value of an HTTP request. Default false.
         * @param array                $parsed_args HTTP request arguments.
         * @param string               $url         The request URL.
         */
        $pre = apply_filters('pre_http_request', false, $parsed_args, $url);
        if (false !== $pre) {
            return $pre;
        }
        if (function_exists('wp_kses_bad_protocol')) {
            if ($parsed_args['reject_unsafe_urls']) {
                $url = wp_http_validate_url($url);
            }
            if ($url) {
                $url = wp_kses_bad_protocol($url, array('http', 'https', 'ssl'));
            }
        }
        $arrURL = parse_url($url);
        if (empty($url) || empty($arrURL['scheme'])) {
            $response = new WP_Error('http_request_failed', __('A valid URL was not provided.'));
            /** This action is documented in wp-includes/class-http.php */
            do_action('http_api_debug', $response, 'response', 'Requests', $parsed_args, $url);
            return $response;
        }
        if ($this->block_request($url)) {
            $response = new WP_Error('http_request_not_executed', __('User has blocked requests through HTTP.'));
            /** This action is documented in wp-includes/class-http.php */
            do_action('http_api_debug', $response, 'response', 'Requests', $parsed_args, $url);
            return $response;
        }
        // If we are streaming to a file but no filename was given drop it in the WP temp dir
        // and pick its name using the basename of the $url.
        if ($parsed_args['stream']) {
            if (empty($parsed_args['filename'])) {
                $parsed_args['filename'] = get_temp_dir() . basename($url);
            }
            // Force some settings if we are streaming to a file and check for existence
            // and perms of destination directory.
            $parsed_args['blocking'] = true;
            if (!wp_is_writable(dirname($parsed_args['filename']))) {
                $response = new WP_Error('http_request_failed', __('Destination directory for file streaming does not exist or is not writable.'));
                /** This action is documented in wp-includes/class-http.php */
                do_action('http_api_debug', $response, 'response', 'Requests', $parsed_args, $url);
                return $response;
            }
        }
        if (is_null($parsed_args['headers'])) {
            $parsed_args['headers'] = array();
        }
        // WP allows passing in headers as a string, weirdly.
        if (!is_array($parsed_args['headers'])) {
            $processedHeaders = WP_Http::processHeaders($parsed_args['headers']);
            $parsed_args['headers'] = $processedHeaders['headers'];
        }
        // Setup arguments.
        $headers = $parsed_args['headers'];
        $data = $parsed_args['body'];
        $type = $parsed_args['method'];
        $options = array('timeout' => $parsed_args['timeout'], 'useragent' => $parsed_args['user-agent'], 'blocking' => $parsed_args['blocking'], 'hooks' => new WP_HTTP_Requests_Hooks($url, $parsed_args));
        // Ensure redirects follow browser behaviour.
        $options['hooks']->register('requests.before_redirect', array(get_class(), 'browser_redirect_compatibility'));
        // Validate redirected URLs.
        if (function_exists('wp_kses_bad_protocol') && $parsed_args['reject_unsafe_urls']) {
            $options['hooks']->register('requests.before_redirect', array(get_class(), 'validate_redirects'));
        }
        if ($parsed_args['stream']) {
            $options['filename'] = $parsed_args['filename'];
        }
        if (empty($parsed_args['redirection'])) {
            $options['follow_redirects'] = false;
        } else {
            $options['redirects'] = $parsed_args['redirection'];
        }
        // Use byte limit, if we can.
        if (isset($parsed_args['limit_response_size'])) {
            $options['max_bytes'] = $parsed_args['limit_response_size'];
        }
        // If we've got cookies, use and convert them to Requests_Cookie.
        if (!empty($parsed_args['cookies'])) {
            $options['cookies'] = WP_Http::normalize_cookies($parsed_args['cookies']);
        }
        // SSL certificate handling.
        if (!$parsed_args['sslverify']) {
            $options['verify'] = false;
            $options['verifyname'] = false;
        } else {
            $options['verify'] = $parsed_args['sslcertificates'];
        }
        // All non-GET/HEAD requests should put the arguments in the form body.
        if ('HEAD' !== $type && 'GET' !== $type) {
            $options['data_format'] = 'body';
        }
        /**
         * Filters whether SSL should be verified for non-local requests.
         *
         * @since 2.8.0
         * @since 5.1.0 The `$url` parameter was added.
         *
         * @param bool   $ssl_verify Whether to verify the SSL connection. Default true.
         * @param string $url        The request URL.
         */
        $options['verify'] = apply_filters('https_ssl_verify', $options['verify'], $url);
        // Check for proxies.
        $proxy = new WP_HTTP_Proxy();
        if ($proxy->is_enabled() && $proxy->send_through_proxy($url)) {
            $options['proxy'] = new Requests_Proxy_HTTP($proxy->host() . ':' . $proxy->port());
            if ($proxy->use_authentication()) {
                $options['proxy']->use_authentication = true;
                $options['proxy']->user = $proxy->username();
                $options['proxy']->pass = $proxy->password();
            }
        }
        // Avoid issues where mbstring.func_overload is enabled.
        mbstring_binary_safe_encoding();
        try {
            $requests_response = Requests::request($url, $headers, $data, $type, $options);
            // Convert the response into an array.
            $http_response = new WP_HTTP_Requests_Response($requests_response, $parsed_args['filename']);
            $response = $http_response->to_array();
            // Add the original object to the array.
            $response['http_response'] = $http_response;
        } catch (Requests_Exception $e) {
            $response = new WP_Error('http_request_failed', $e->getMessage());
        }
        reset_mbstring_encoding();
        /**
         * Fires after an HTTP API response is received and before the response is returned.
         *
         * @since 2.8.0
         *
         * @param array|WP_Error $response    HTTP response or WP_Error object.
         * @param string         $context     Context under which the hook is fired.
         * @param string         $class       HTTP transport used.
         * @param array          $parsed_args HTTP request arguments.
         * @param string         $url         The request URL.
         */
        do_action('http_api_debug', $response, 'response', 'Requests', $parsed_args, $url);
        if (is_wp_error($response)) {
            return $response;
        }
        if (!$parsed_args['blocking']) {
            return array('headers' => array(), 'body' => '', 'response' => array('code' => false, 'message' => false), 'cookies' => array(), 'http_response' => null);
        }
        /**
         * Filters the HTTP API response immediately before the response is returned.
         *
         * @since 2.9.0
         *
         * @param array  $response    HTTP response.
         * @param array  $parsed_args HTTP request arguments.
         * @param string $url         The request URL.
         */
        return apply_filters('http_response', $response, $parsed_args, $url);
    }
    /**
     * Normalizes cookies for using in Requests.
     *
     * @since 4.6.0
     *
     * @param array $cookies Array of cookies to send with the request.
     * @return Requests_Cookie_Jar Cookie holder object.
     */
    public static function normalize_cookies($cookies)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("normalize_cookies") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 405")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called normalize_cookies:405@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Match redirect behaviour to browser handling.
     *
     * Changes 302 redirects from POST to GET to match browser handling. Per
     * RFC 7231, user agents can deviate from the strict reading of the
     * specification for compatibility purposes.
     *
     * @since 4.6.0
     *
     * @param string            $location URL to redirect to.
     * @param array             $headers  Headers for the redirect.
     * @param string|array      $data     Body to send with the request.
     * @param array             $options  Redirect request options.
     * @param Requests_Response $original Response object.
     */
    public static function browser_redirect_compatibility($location, $headers, $data, &$options, $original)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("browser_redirect_compatibility") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 433")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called browser_redirect_compatibility:433@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Validate redirected URLs.
     *
     * @since 4.7.5
     *
     * @throws Requests_Exception On unsuccessful URL validation.
     * @param string $location URL to redirect to.
     */
    public static function validate_redirects($location)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validate_redirects") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 447")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validate_redirects:447@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Tests which transports are capable of supporting the request.
     *
     * @since 3.2.0
     *
     * @param array  $args Request arguments.
     * @param string $url  URL to request.
     * @return string|false Class name for the first transport that claims to support the request.
     *                      False if no transport claims to support the request.
     */
    public function _get_first_available_transport($args, $url = null)
    {
        $transports = array('curl', 'streams');
        /**
         * Filters which HTTP transports are available and in what order.
         *
         * @since 3.7.0
         *
         * @param string[] $transports Array of HTTP transports to check. Default array contains
         *                             'curl' and 'streams', in that order.
         * @param array    $args       HTTP request arguments.
         * @param string   $url        The URL to request.
         */
        $request_order = apply_filters('http_api_transports', $transports, $args, $url);
        // Loop over each transport on each HTTP request looking for one which will serve this request's needs.
        foreach ($request_order as $transport) {
            if (in_array($transport, $transports, true)) {
                $transport = ucfirst($transport);
            }
            $class = 'WP_Http_' . $transport;
            // Check to see if this transport is a possibility, calls the transport statically.
            if (!call_user_func(array($class, 'test'), $args, $url)) {
                continue;
            }
            return $class;
        }
        return false;
    }
    /**
     * Dispatches a HTTP request to a supporting transport.
     *
     * Tests each transport in order to find a transport which matches the request arguments.
     * Also caches the transport instance to be used later.
     *
     * The order for requests is cURL, and then PHP Streams.
     *
     * @since 3.2.0
     * @deprecated 5.1.0 Use WP_Http::request()
     * @see WP_Http::request()
     *
     * @param string $url  URL to request.
     * @param array  $args Request arguments.
     * @return array|WP_Error Array containing 'headers', 'body', 'response', 'cookies', 'filename'.
     *                        A WP_Error instance upon error.
     */
    private function _dispatch_request($url, $args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_dispatch_request") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 508")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _dispatch_request:508@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Uses the POST HTTP method.
     *
     * Used for sending data that is expected to be in the body.
     *
     * @since 2.7.0
     *
     * @param string       $url  The request URL.
     * @param string|array $args Optional. Override the defaults.
     * @return array|WP_Error Array containing 'headers', 'body', 'response', 'cookies', 'filename'.
     *                        A WP_Error instance upon error.
     */
    public function post($url, $args = array())
    {
        $defaults = array('method' => 'POST');
        $parsed_args = wp_parse_args($args, $defaults);
        return $this->request($url, $parsed_args);
    }
    /**
     * Uses the GET HTTP method.
     *
     * Used for sending data that is expected to be in the body.
     *
     * @since 2.7.0
     *
     * @param string       $url  The request URL.
     * @param string|array $args Optional. Override the defaults.
     * @return array|WP_Error Array containing 'headers', 'body', 'response', 'cookies', 'filename'.
     *                        A WP_Error instance upon error.
     */
    public function get($url, $args = array())
    {
        $defaults = array('method' => 'GET');
        $parsed_args = wp_parse_args($args, $defaults);
        return $this->request($url, $parsed_args);
    }
    /**
     * Uses the HEAD HTTP method.
     *
     * Used for sending data that is expected to be in the body.
     *
     * @since 2.7.0
     *
     * @param string       $url  The request URL.
     * @param string|array $args Optional. Override the defaults.
     * @return array|WP_Error Array containing 'headers', 'body', 'response', 'cookies', 'filename'.
     *                        A WP_Error instance upon error.
     */
    public function head($url, $args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("head") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 576")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called head:576@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Parses the responses and splits the parts into headers and body.
     *
     * @since 2.7.0
     *
     * @param string $strResponse The full response string.
     * @return array {
     *     Array with response headers and body.
     *
     *     @type string $headers HTTP response headers.
     *     @type string $body    HTTP response body.
     * }
     */
    public static function processResponse($strResponse)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("processResponse") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 596")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called processResponse:596@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Transforms header string into an array.
     *
     * @since 2.7.0
     *
     * @param string|array $headers The original headers. If a string is passed, it will be converted
     *                              to an array. If an array is passed, then it is assumed to be
     *                              raw header data with numeric keys with the headers as the values.
     *                              No headers must be passed that were already processed.
     * @param string       $url     Optional. The URL that was requested. Default empty.
     * @return array {
     *     Processed string headers. If duplicate headers are encountered,
     *     then a numbered array is returned as the value of that header-key.
     *
     *     @type array            $response {
     *          @type int    $code    The response status code. Default 0.
     *          @type string $message The response message. Default empty.
     *     }
     *     @type array            $newheaders The processed header data as a multidimensional array.
     *     @type WP_Http_Cookie[] $cookies    If the original headers contain the 'Set-Cookie' key,
     *                                        an array containing `WP_Http_Cookie` objects is returned.
     * }
     */
    public static function processHeaders($headers, $url = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("processHeaders") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 626")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called processHeaders:626@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Takes the arguments for a ::request() and checks for the cookie array.
     *
     * If it's found, then it upgrades any basic name => value pairs to WP_Http_Cookie instances,
     * which are each parsed into strings and added to the Cookie: header (within the arguments array).
     * Edits the array by reference.
     *
     * @since 2.8.0
     *
     * @param array $r Full array of args passed into ::request()
     */
    public static function buildCookieHeader(&$r)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("buildCookieHeader") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 693")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called buildCookieHeader:693@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Decodes chunk transfer-encoding, based off the HTTP 1.1 specification.
     *
     * Based off the HTTP http_encoding_dechunk function.
     *
     * @link https://tools.ietf.org/html/rfc2616#section-19.4.6 Process for chunked decoding.
     *
     * @since 2.7.0
     *
     * @param string $body Body content.
     * @return string Chunked decoded body on success or raw body on failure.
     */
    public static function chunkTransferDecode($body)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("chunkTransferDecode") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 724")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called chunkTransferDecode:724@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Determines whether an HTTP API request to the given URL should be blocked.
     *
     * Those who are behind a proxy and want to prevent access to certain hosts may do so. This will
     * prevent plugins from working and core functionality, if you don't include `api.wordpress.org`.
     *
     * You block external URL requests by defining `WP_HTTP_BLOCK_EXTERNAL` as true in your `wp-config.php`
     * file and this will only allow localhost and your site to make requests. The constant
     * `WP_ACCESSIBLE_HOSTS` will allow additional hosts to go through for requests. The format of the
     * `WP_ACCESSIBLE_HOSTS` constant is a comma separated list of hostnames to allow, wildcard domains
     * are supported, eg `*.wordpress.org` will allow for all subdomains of `wordpress.org` to be contacted.
     *
     * @since 2.8.0
     *
     * @link https://core.trac.wordpress.org/ticket/8927 Allow preventing external requests.
     * @link https://core.trac.wordpress.org/ticket/14636 Allow wildcard domains in WP_ACCESSIBLE_HOSTS
     *
     * @param string $uri URI of url.
     * @return bool True to block, false to allow.
     */
    public function block_request($uri)
    {
        // We don't need to block requests, because nothing is blocked.
        if (!defined('WP_HTTP_BLOCK_EXTERNAL') || !WP_HTTP_BLOCK_EXTERNAL) {
            return false;
        }
        $check = parse_url($uri);
        if (!$check) {
            return true;
        }
        $home = parse_url(get_option('siteurl'));
        // Don't block requests back to ourselves by default.
        if ('localhost' === $check['host'] || isset($home['host']) && $home['host'] == $check['host']) {
            /**
             * Filters whether to block local HTTP API requests.
             *
             * A local request is one to `localhost` or to the same host as the site itself.
             *
             * @since 2.8.0
             *
             * @param bool $block Whether to block local requests. Default false.
             */
            return apply_filters('block_local_requests', false);
        }
        if (!defined('WP_ACCESSIBLE_HOSTS')) {
            return true;
        }
        static $accessible_hosts = null;
        static $wildcard_regex = array();
        if (null === $accessible_hosts) {
            $accessible_hosts = preg_split('|,\\s*|', WP_ACCESSIBLE_HOSTS);
            if (false !== strpos(WP_ACCESSIBLE_HOSTS, '*')) {
                $wildcard_regex = array();
                foreach ($accessible_hosts as $host) {
                    $wildcard_regex[] = str_replace('\\*', '.+', preg_quote($host, '/'));
                }
                $wildcard_regex = '/^(' . implode('|', $wildcard_regex) . ')$/i';
            }
        }
        if (!empty($wildcard_regex)) {
            return !preg_match($wildcard_regex, $check['host']);
        } else {
            return !in_array($check['host'], $accessible_hosts, true);
            // Inverse logic, if it's in the array, then don't block it.
        }
    }
    /**
     * Used as a wrapper for PHP's parse_url() function that handles edgecases in < PHP 5.4.7.
     *
     * @deprecated 4.4.0 Use wp_parse_url()
     * @see wp_parse_url()
     *
     * @param string $url The URL to parse.
     * @return bool|array False on failure; Array of URL components on success;
     *                    See parse_url()'s return values.
     */
    protected static function parse_url($url)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse_url") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 825")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parse_url:825@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Converts a relative URL to an absolute URL relative to a given URL.
     *
     * If an Absolute URL is provided, no processing of that URL is done.
     *
     * @since 3.4.0
     *
     * @param string $maybe_relative_path The URL which might be relative.
     * @param string $url                 The URL which $maybe_relative_path is relative to.
     * @return string An Absolute URL, in a failure condition where the URL cannot be parsed, the relative URL will be returned.
     */
    public static function make_absolute_url($maybe_relative_path, $url)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("make_absolute_url") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 841")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called make_absolute_url:841@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Handles an HTTP redirect and follows it if appropriate.
     *
     * @since 3.7.0
     *
     * @param string $url      The URL which was requested.
     * @param array  $args     The arguments which were used to make the request.
     * @param array  $response The response of the HTTP request.
     * @return array|false|WP_Error An HTTP API response array if the redirect is successfully followed,
     *                              false if no redirect is present, or a WP_Error object if there's an error.
     */
    public static function handle_redirects($url, $args, $response)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handle_redirects") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 908")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handle_redirects:908@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
    /**
     * Determines if a specified string represents an IP address or not.
     *
     * This function also detects the type of the IP address, returning either
     * '4' or '6' to represent a IPv4 and IPv6 address respectively.
     * This does not verify if the IP is a valid IP, only that it appears to be
     * an IP address.
     *
     * @link http://home.deds.nl/~aeron/regex/ for IPv6 regex.
     *
     * @since 3.7.0
     *
     * @param string $maybe_ip A suspected IP address.
     * @return int|false Upon success, '4' or '6' to represent a IPv4 or IPv6 address, false upon failure
     */
    public static function is_ip_address($maybe_ip)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_ip_address") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php at line 958")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_ip_address:958@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-http.php');
        die();
    }
}