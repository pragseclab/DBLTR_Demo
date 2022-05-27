<?php

declare (strict_types=1);
namespace PhpMyAdmin\Utils;

use const CURL_IPRESOLVE_V4;
use const CURLINFO_HTTP_CODE;
use const CURLINFO_SSL_VERIFYRESULT;
use const CURLOPT_CAINFO;
use const CURLOPT_CAPATH;
use const CURLOPT_CONNECTTIMEOUT;
use const CURLOPT_CUSTOMREQUEST;
use const CURLOPT_FOLLOWLOCATION;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_IPRESOLVE;
use const CURLOPT_POSTFIELDS;
use const CURLOPT_PROXY;
use const CURLOPT_PROXYUSERPWD;
use const CURLOPT_RETURNTRANSFER;
use const CURLOPT_SSL_VERIFYHOST;
use const CURLOPT_SSL_VERIFYPEER;
use const CURLOPT_TIMEOUT;
use const CURLOPT_USERAGENT;
use function base64_encode;
use function curl_exec;
use function curl_getinfo;
use function curl_init;
use function curl_setopt;
use function file_get_contents;
use function function_exists;
use function ini_get;
use function intval;
use function preg_match;
use function stream_context_create;
use function strlen;
/**
 * Handles HTTP requests
 */
class HttpRequest
{
    /** @var string */
    private $proxyUrl;
    /** @var string */
    private $proxyUser;
    /** @var string */
    private $proxyPass;
    public function __construct()
    {
        global $cfg;
        $this->proxyUrl = $cfg['ProxyUrl'];
        $this->proxyUser = $cfg['ProxyUser'];
        $this->proxyPass = $cfg['ProxyPass'];
    }
    /**
     * Returns information with regards to handling the http request
     *
     * @param array $context Data about the context for which
     *                       to http request is sent
     *
     * @return array of updated context information
     */
    private function handleContext(array $context)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handleContext") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Utils/HttpRequest.php at line 64")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handleContext:64@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Utils/HttpRequest.php');
        die();
    }
    /**
     * Creates HTTP request using curl
     *
     * @param mixed $response         HTTP response
     * @param int   $httpStatus       HTTP response status code
     * @param bool  $returnOnlyStatus If set to true, the method would only return response status
     *
     * @return string|bool|null
     */
    private function response($response, $httpStatus, $returnOnlyStatus)
    {
        if ($httpStatus == 404) {
            return false;
        }
        if ($httpStatus != 200) {
            return null;
        }
        if ($returnOnlyStatus) {
            return true;
        }
        return $response;
    }
    /**
     * Creates HTTP request using curl
     *
     * @param string $url              Url to send the request
     * @param string $method           HTTP request method (GET, POST, PUT, DELETE, etc)
     * @param bool   $returnOnlyStatus If set to true, the method would only return response status
     * @param mixed  $content          Content to be sent with HTTP request
     * @param string $header           Header to be set for the HTTP request
     * @param int    $ssl              SSL mode to use
     *
     * @return string|bool|null
     */
    private function curl($url, $method, $returnOnlyStatus = false, $content = null, $header = '', $ssl = 0)
    {
        $curlHandle = curl_init($url);
        if ($curlHandle === false) {
            return null;
        }
        $curlStatus = true;
        if (strlen($this->proxyUrl) > 0) {
            $curlStatus &= curl_setopt($curlHandle, CURLOPT_PROXY, $this->proxyUrl);
            if (strlen($this->proxyUser) > 0) {
                $curlStatus &= curl_setopt($curlHandle, CURLOPT_PROXYUSERPWD, $this->proxyUser . ':' . $this->proxyPass);
            }
        }
        $curlStatus &= curl_setopt($curlHandle, CURLOPT_USERAGENT, 'phpMyAdmin');
        if ($method !== 'GET') {
            $curlStatus &= curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, $method);
        }
        if ($header) {
            $curlStatus &= curl_setopt($curlHandle, CURLOPT_HTTPHEADER, [$header]);
        }
        if ($method === 'POST') {
            $curlStatus &= curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $content);
        }
        $curlStatus &= curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, '2');
        $curlStatus &= curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, '1');
        /**
         * Configure ISRG Root X1 to be able to verify Let's Encrypt SSL
         * certificates even without properly configured curl in PHP.
         *
         * See https://letsencrypt.org/certificates/
         */
        $certsDir = ROOT_PATH . 'libraries/certs/';
        /* See code below for logic */
        if ($ssl == CURLOPT_CAPATH) {
            $curlStatus &= curl_setopt($curlHandle, CURLOPT_CAPATH, $certsDir);
        } elseif ($ssl == CURLOPT_CAINFO) {
            $curlStatus &= curl_setopt($curlHandle, CURLOPT_CAINFO, $certsDir . 'cacert.pem');
        }
        $curlStatus &= curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $curlStatus &= curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, 0);
        $curlStatus &= curl_setopt($curlHandle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $curlStatus &= curl_setopt($curlHandle, CURLOPT_TIMEOUT, 10);
        $curlStatus &= curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 10);
        if (!$curlStatus) {
            return null;
        }
        $response = @curl_exec($curlHandle);
        if ($response === false) {
            /*
             * In case of SSL verification failure let's try configuring curl
             * certificate verification. Unfortunately it is tricky as setting
             * options incompatible with PHP build settings can lead to failure.
             *
             * So let's rather try the options one by one.
             *
             * 1. Try using system SSL storage.
             * 2. Try setting CURLOPT_CAINFO.
             * 3. Try setting CURLOPT_CAPATH.
             * 4. Fail.
             */
            if (curl_getinfo($curlHandle, CURLINFO_SSL_VERIFYRESULT) != 0) {
                if ($ssl == 0) {
                    return $this->curl($url, $method, $returnOnlyStatus, $content, $header, CURLOPT_CAINFO);
                }
                if ($ssl == CURLOPT_CAINFO) {
                    return $this->curl($url, $method, $returnOnlyStatus, $content, $header, CURLOPT_CAPATH);
                }
            }
            return null;
        }
        $httpStatus = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        return $this->response($response, $httpStatus, $returnOnlyStatus);
    }
    /**
     * Creates HTTP request using file_get_contents
     *
     * @param string $url              Url to send the request
     * @param string $method           HTTP request method (GET, POST, PUT, DELETE, etc)
     * @param bool   $returnOnlyStatus If set to true, the method would only return response status
     * @param mixed  $content          Content to be sent with HTTP request
     * @param string $header           Header to be set for the HTTP request
     *
     * @return string|bool|null
     */
    private function fopen($url, $method, $returnOnlyStatus = false, $content = null, $header = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fopen") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Utils/HttpRequest.php at line 193")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fopen:193@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Utils/HttpRequest.php');
        die();
    }
    /**
     * Creates HTTP request
     *
     * @param string $url              Url to send the request
     * @param string $method           HTTP request method (GET, POST, PUT, DELETE, etc)
     * @param bool   $returnOnlyStatus If set to true, the method would only return response status
     * @param mixed  $content          Content to be sent with HTTP request
     * @param string $header           Header to be set for the HTTP request
     *
     * @return string|bool|null
     */
    public function create($url, $method, $returnOnlyStatus = false, $content = null, $header = '')
    {
        if (function_exists('curl_init')) {
            return $this->curl($url, $method, $returnOnlyStatus, $content, $header);
        }
        if (ini_get('allow_url_fopen')) {
            return $this->fopen($url, $method, $returnOnlyStatus, $content, $header);
        }
        return null;
    }
}