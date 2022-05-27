<?php

/**
 * HTTP API: WP_Http_Streams class
 *
 * @package WordPress
 * @subpackage HTTP
 * @since 4.4.0
 */
/**
 * Core class used to integrate PHP Streams as an HTTP transport.
 *
 * @since 2.7.0
 * @since 3.7.0 Combined with the fsockopen transport and switched to `stream_socket_client()`.
 */
class WP_Http_Streams
{
    /**
     * Send a HTTP request to a URI using PHP Streams.
     *
     * @see WP_Http::request For default options descriptions.
     *
     * @since 2.7.0
     * @since 3.7.0 Combined with the fsockopen transport and switched to stream_socket_client().
     *
     * @param string       $url  The request URL.
     * @param string|array $args Optional. Override the defaults.
     * @return array|WP_Error Array containing 'headers', 'body', 'response', 'cookies', 'filename'. A WP_Error instance upon error
     */
    public function request($url, $args = array())
    {
        $defaults = array('method' => 'GET', 'timeout' => 5, 'redirection' => 5, 'httpversion' => '1.0', 'blocking' => true, 'headers' => array(), 'body' => null, 'cookies' => array());
        $parsed_args = wp_parse_args($args, $defaults);
        if (isset($parsed_args['headers']['User-Agent'])) {
            $parsed_args['user-agent'] = $parsed_args['headers']['User-Agent'];
            unset($parsed_args['headers']['User-Agent']);
        } elseif (isset($parsed_args['headers']['user-agent'])) {
            $parsed_args['user-agent'] = $parsed_args['headers']['user-agent'];
            unset($parsed_args['headers']['user-agent']);
        }
        // Construct Cookie: header if any cookies are set.
        WP_Http::buildCookieHeader($parsed_args);
        $arrURL = parse_url($url);
        $connect_host = $arrURL['host'];
        $secure_transport = 'ssl' === $arrURL['scheme'] || 'https' === $arrURL['scheme'];
        if (!isset($arrURL['port'])) {
            if ('ssl' === $arrURL['scheme'] || 'https' === $arrURL['scheme']) {
                $arrURL['port'] = 443;
                $secure_transport = true;
            } else {
                $arrURL['port'] = 80;
            }
        }
        // Always pass a path, defaulting to the root in cases such as http://example.com.
        if (!isset($arrURL['path'])) {
            $arrURL['path'] = '/';
        }
        if (isset($parsed_args['headers']['Host']) || isset($parsed_args['headers']['host'])) {
            if (isset($parsed_args['headers']['Host'])) {
                $arrURL['host'] = $parsed_args['headers']['Host'];
            } else {
                $arrURL['host'] = $parsed_args['headers']['host'];
            }
            unset($parsed_args['headers']['Host'], $parsed_args['headers']['host']);
        }
        /*
         * Certain versions of PHP have issues with 'localhost' and IPv6, It attempts to connect
         * to ::1, which fails when the server is not set up for it. For compatibility, always
         * connect to the IPv4 address.
         */
        if ('localhost' === strtolower($connect_host)) {
            $connect_host = '127.0.0.1';
        }
        $connect_host = $secure_transport ? 'ssl://' . $connect_host : 'tcp://' . $connect_host;
        $is_local = isset($parsed_args['local']) && $parsed_args['local'];
        $ssl_verify = isset($parsed_args['sslverify']) && $parsed_args['sslverify'];
        if ($is_local) {
            /**
             * Filters whether SSL should be verified for local HTTP API requests.
             *
             * @since 2.8.0
             * @since 5.1.0 The `$url` parameter was added.
             *
             * @param bool   $ssl_verify Whether to verify the SSL connection. Default true.
             * @param string $url        The request URL.
             */
            $ssl_verify = apply_filters('https_local_ssl_verify', $ssl_verify, $url);
        } elseif (!$is_local) {
            /** This filter is documented in wp-includes/class-http.php */
            $ssl_verify = apply_filters('https_ssl_verify', $ssl_verify, $url);
        }
        $proxy = new WP_HTTP_Proxy();
        $context = stream_context_create(array('ssl' => array(
            'verify_peer' => $ssl_verify,
            // 'CN_match' => $arrURL['host'], // This is handled by self::verify_ssl_certificate().
            'capture_peer_cert' => $ssl_verify,
            'SNI_enabled' => true,
            'cafile' => $parsed_args['sslcertificates'],
            'allow_self_signed' => !$ssl_verify,
        )));
        $timeout = (int) floor($parsed_args['timeout']);
        $utimeout = $timeout == $parsed_args['timeout'] ? 0 : 1000000 * $parsed_args['timeout'] % 1000000;
        $connect_timeout = max($timeout, 1);
        // Store error number.
        $connection_error = null;
        // Store error string.
        $connection_error_str = null;
        if (!WP_DEBUG) {
            // In the event that the SSL connection fails, silence the many PHP warnings.
            if ($secure_transport) {
                $error_reporting = error_reporting(0);
            }
            if ($proxy->is_enabled() && $proxy->send_through_proxy($url)) {
                // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
                $handle = @stream_socket_client('tcp://' . $proxy->host() . ':' . $proxy->port(), $connection_error, $connection_error_str, $connect_timeout, STREAM_CLIENT_CONNECT, $context);
            } else {
                // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
                $handle = @stream_socket_client($connect_host . ':' . $arrURL['port'], $connection_error, $connection_error_str, $connect_timeout, STREAM_CLIENT_CONNECT, $context);
            }
            if ($secure_transport) {
                error_reporting($error_reporting);
            }
        } else {
            if ($proxy->is_enabled() && $proxy->send_through_proxy($url)) {
                $handle = stream_socket_client('tcp://' . $proxy->host() . ':' . $proxy->port(), $connection_error, $connection_error_str, $connect_timeout, STREAM_CLIENT_CONNECT, $context);
            } else {
                $handle = stream_socket_client($connect_host . ':' . $arrURL['port'], $connection_error, $connection_error_str, $connect_timeout, STREAM_CLIENT_CONNECT, $context);
            }
        }
        if (false === $handle) {
            // SSL connection failed due to expired/invalid cert, or, OpenSSL configuration is broken.
            if ($secure_transport && 0 === $connection_error && '' === $connection_error_str) {
                return new WP_Error('http_request_failed', __('The SSL certificate for the host could not be verified.'));
            }
            return new WP_Error('http_request_failed', $connection_error . ': ' . $connection_error_str);
        }
        // Verify that the SSL certificate is valid for this request.
        if ($secure_transport && $ssl_verify && !$proxy->is_enabled()) {
            if (!self::verify_ssl_certificate($handle, $arrURL['host'])) {
                return new WP_Error('http_request_failed', __('The SSL certificate for the host could not be verified.'));
            }
        }
        stream_set_timeout($handle, $timeout, $utimeout);
        if ($proxy->is_enabled() && $proxy->send_through_proxy($url)) {
            // Some proxies require full URL in this field.
            $requestPath = $url;
        } else {
            $requestPath = $arrURL['path'] . (isset($arrURL['query']) ? '?' . $arrURL['query'] : '');
        }
        $strHeaders = strtoupper($parsed_args['method']) . ' ' . $requestPath . ' HTTP/' . $parsed_args['httpversion'] . "\r\n";
        $include_port_in_host_header = $proxy->is_enabled() && $proxy->send_through_proxy($url) || 'http' === $arrURL['scheme'] && 80 != $arrURL['port'] || 'https' === $arrURL['scheme'] && 443 != $arrURL['port'];
        if ($include_port_in_host_header) {
            $strHeaders .= 'Host: ' . $arrURL['host'] . ':' . $arrURL['port'] . "\r\n";
        } else {
            $strHeaders .= 'Host: ' . $arrURL['host'] . "\r\n";
        }
        if (isset($parsed_args['user-agent'])) {
            $strHeaders .= 'User-agent: ' . $parsed_args['user-agent'] . "\r\n";
        }
        if (is_array($parsed_args['headers'])) {
            foreach ((array) $parsed_args['headers'] as $header => $headerValue) {
                $strHeaders .= $header . ': ' . $headerValue . "\r\n";
            }
        } else {
            $strHeaders .= $parsed_args['headers'];
        }
        if ($proxy->use_authentication()) {
            $strHeaders .= $proxy->authentication_header() . "\r\n";
        }
        $strHeaders .= "\r\n";
        if (!is_null($parsed_args['body'])) {
            $strHeaders .= $parsed_args['body'];
        }
        fwrite($handle, $strHeaders);
        if (!$parsed_args['blocking']) {
            stream_set_blocking($handle, 0);
            fclose($handle);
            return array('headers' => array(), 'body' => '', 'response' => array('code' => false, 'message' => false), 'cookies' => array());
        }
        $strResponse = '';
        $bodyStarted = false;
        $keep_reading = true;
        $block_size = 4096;
        if (isset($parsed_args['limit_response_size'])) {
            $block_size = min($block_size, $parsed_args['limit_response_size']);
        }
        // If streaming to a file setup the file handle.
        if ($parsed_args['stream']) {
            if (!WP_DEBUG) {
                $stream_handle = @fopen($parsed_args['filename'], 'w+');
            } else {
                $stream_handle = fopen($parsed_args['filename'], 'w+');
            }
            if (!$stream_handle) {
                return new WP_Error('http_request_failed', sprintf(
                    /* translators: 1: fopen(), 2: File name. */
                    __('Could not open handle for %1$s to %2$s.'),
                    'fopen()',
                    $parsed_args['filename']
                ));
            }
            $bytes_written = 0;
            while (!feof($handle) && $keep_reading) {
                $block = fread($handle, $block_size);
                if (!$bodyStarted) {
                    $strResponse .= $block;
                    if (strpos($strResponse, "\r\n\r\n")) {
                        $process = WP_Http::processResponse($strResponse);
                        $bodyStarted = true;
                        $block = $process['body'];
                        unset($strResponse);
                        $process['body'] = '';
                    }
                }
                $this_block_size = strlen($block);
                if (isset($parsed_args['limit_response_size']) && $bytes_written + $this_block_size > $parsed_args['limit_response_size']) {
                    $this_block_size = $parsed_args['limit_response_size'] - $bytes_written;
                    $block = substr($block, 0, $this_block_size);
                }
                $bytes_written_to_file = fwrite($stream_handle, $block);
                if ($bytes_written_to_file != $this_block_size) {
                    fclose($handle);
                    fclose($stream_handle);
                    return new WP_Error('http_request_failed', __('Failed to write request to temporary file.'));
                }
                $bytes_written += $bytes_written_to_file;
                $keep_reading = !isset($parsed_args['limit_response_size']) || $bytes_written < $parsed_args['limit_response_size'];
            }
            fclose($stream_handle);
        } else {
            $header_length = 0;
            while (!feof($handle) && $keep_reading) {
                $block = fread($handle, $block_size);
                $strResponse .= $block;
                if (!$bodyStarted && strpos($strResponse, "\r\n\r\n")) {
                    $header_length = strpos($strResponse, "\r\n\r\n") + 4;
                    $bodyStarted = true;
                }
                $keep_reading = !$bodyStarted || !isset($parsed_args['limit_response_size']) || strlen($strResponse) < $header_length + $parsed_args['limit_response_size'];
            }
            $process = WP_Http::processResponse($strResponse);
            unset($strResponse);
        }
        fclose($handle);
        $arrHeaders = WP_Http::processHeaders($process['headers'], $url);
        $response = array(
            'headers' => $arrHeaders['headers'],
            // Not yet processed.
            'body' => null,
            'response' => $arrHeaders['response'],
            'cookies' => $arrHeaders['cookies'],
            'filename' => $parsed_args['filename'],
        );
        // Handle redirects.
        $redirect_response = WP_Http::handle_redirects($url, $parsed_args, $response);
        if (false !== $redirect_response) {
            return $redirect_response;
        }
        // If the body was chunk encoded, then decode it.
        if (!empty($process['body']) && isset($arrHeaders['headers']['transfer-encoding']) && 'chunked' === $arrHeaders['headers']['transfer-encoding']) {
            $process['body'] = WP_Http::chunkTransferDecode($process['body']);
        }
        if (true === $parsed_args['decompress'] && true === WP_Http_Encoding::should_decode($arrHeaders['headers'])) {
            $process['body'] = WP_Http_Encoding::decompress($process['body']);
        }
        if (isset($parsed_args['limit_response_size']) && strlen($process['body']) > $parsed_args['limit_response_size']) {
            $process['body'] = substr($process['body'], 0, $parsed_args['limit_response_size']);
        }
        $response['body'] = $process['body'];
        return $response;
    }
    /**
     * Verifies the received SSL certificate against its Common Names and subjectAltName fields.
     *
     * PHP's SSL verifications only verify that it's a valid Certificate, it doesn't verify if
     * the certificate is valid for the hostname which was requested.
     * This function verifies the requested hostname against certificate's subjectAltName field,
     * if that is empty, or contains no DNS entries, a fallback to the Common Name field is used.
     *
     * IP Address support is included if the request is being made to an IP address.
     *
     * @since 3.7.0
     *
     * @param stream $stream The PHP Stream which the SSL request is being made over
     * @param string $host The hostname being requested
     * @return bool If the cerficiate presented in $stream is valid for $host
     */
    public static function verify_ssl_certificate($stream, $host)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("verify_ssl_certificate") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-http-streams.php at line 290")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called verify_ssl_certificate:290@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-http-streams.php');
        die();
    }
    /**
     * Determines whether this class can be used for retrieving a URL.
     *
     * @since 2.7.0
     * @since 3.7.0 Combined with the fsockopen transport and switched to stream_socket_client().
     *
     * @param array $args Optional. Array of request arguments. Default empty array.
     * @return bool False means this class can not be used, true means it can.
     */
    public static function test($args = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("test") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-http-streams.php at line 344")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called test:344@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-http-streams.php');
        die();
    }
}
/**
 * Deprecated HTTP Transport method which used fsockopen.
 *
 * This class is not used, and is included for backward compatibility only.
 * All code should make use of WP_Http directly through its API.
 *
 * @see WP_HTTP::request
 *
 * @since 2.7.0
 * @deprecated 3.7.0 Please use WP_HTTP::request() directly
 */
class WP_HTTP_Fsockopen extends WP_HTTP_Streams
{
    // For backward compatibility for users who are using the class directly.
}