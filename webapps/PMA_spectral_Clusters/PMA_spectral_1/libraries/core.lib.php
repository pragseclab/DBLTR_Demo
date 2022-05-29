<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Core functions used all over the scripts.
 * This script is distinct from libraries/common.inc.php because this
 * script is called from /test.
 *
 * @package PhpMyAdmin
 */
use PMA\libraries\Message;
use PMA\libraries\Response;
use PMA\libraries\URL;
use PMA\libraries\Sanitize;
if (!defined('PHPMYADMIN')) {
    exit;
}
/**
 * String handling (security)
 */
require_once 'libraries/string.lib.php';
/**
 * checks given $var and returns it if valid, or $default of not valid
 * given $var is also checked for type being 'similar' as $default
 * or against any other type if $type is provided
 *
 * <code>
 * // $_REQUEST['db'] not set
 * echo PMA_ifSetOr($_REQUEST['db'], ''); // ''
 * // $_REQUEST['sql_query'] not set
 * echo PMA_ifSetOr($_REQUEST['sql_query']); // null
 * // $cfg['EnableFoo'] not set
 * echo PMA_ifSetOr($cfg['EnableFoo'], false, 'boolean'); // false
 * echo PMA_ifSetOr($cfg['EnableFoo']); // null
 * // $cfg['EnableFoo'] set to 1
 * echo PMA_ifSetOr($cfg['EnableFoo'], false, 'boolean'); // false
 * echo PMA_ifSetOr($cfg['EnableFoo'], false, 'similar'); // 1
 * echo PMA_ifSetOr($cfg['EnableFoo'], false); // 1
 * // $cfg['EnableFoo'] set to true
 * echo PMA_ifSetOr($cfg['EnableFoo'], false, 'boolean'); // true
 * </code>
 *
 * @param mixed &$var    param to check
 * @param mixed $default default value
 * @param mixed $type    var type or array of values to check against $var
 *
 * @return mixed   $var or $default
 *
 * @see     PMA_isValid()
 */
function PMA_ifSetOr(&$var, $default = null, $type = 'similar')
{
    if (!PMA_isValid($var, $type, $default)) {
        return $default;
    }
    return $var;
}
/**
 * checks given $var against $type or $compare
 *
 * $type can be:
 * - false       : no type checking
 * - 'scalar'    : whether type of $var is integer, float, string or boolean
 * - 'numeric'   : whether type of $var is any number representation
 * - 'length'    : whether type of $var is scalar with a string length > 0
 * - 'similar'   : whether type of $var is similar to type of $compare
 * - 'equal'     : whether type of $var is identical to type of $compare
 * - 'identical' : whether $var is identical to $compare, not only the type!
 * - or any other valid PHP variable type
 *
 * <code>
 * // $_REQUEST['doit'] = true;
 * PMA_isValid($_REQUEST['doit'], 'identical', 'true'); // false
 * // $_REQUEST['doit'] = 'true';
 * PMA_isValid($_REQUEST['doit'], 'identical', 'true'); // true
 * </code>
 *
 * NOTE: call-by-reference is used to not get NOTICE on undefined vars,
 * but the var is not altered inside this function, also after checking a var
 * this var exists nut is not set, example:
 * <code>
 * // $var is not set
 * isset($var); // false
 * functionCallByReference($var); // false
 * isset($var); // true
 * functionCallByReference($var); // true
 * </code>
 *
 * to avoid this we set this var to null if not isset
 *
 * @param mixed &$var    variable to check
 * @param mixed $type    var type or array of valid values to check against $var
 * @param mixed $compare var to compare with $var
 *
 * @return boolean whether valid or not
 *
 * @todo add some more var types like hex, bin, ...?
 * @see     https://secure.php.net/gettype
 */
function PMA_isValid(&$var, $type = 'length', $compare = null)
{
    if (!isset($var)) {
        // var is not even set
        return false;
    }
    if ($type === false) {
        // no vartype requested
        return true;
    }
    if (is_array($type)) {
        return in_array($var, $type);
    }
    // allow some aliases of var types
    $type = strtolower($type);
    switch ($type) {
        case 'identic':
            $type = 'identical';
            break;
        case 'len':
            $type = 'length';
            break;
        case 'bool':
            $type = 'boolean';
            break;
        case 'float':
            $type = 'double';
            break;
        case 'int':
            $type = 'integer';
            break;
        case 'null':
            $type = 'NULL';
            break;
    }
    if ($type === 'identical') {
        return $var === $compare;
    }
    // whether we should check against given $compare
    if ($type === 'similar') {
        switch (gettype($compare)) {
            case 'string':
            case 'boolean':
                $type = 'scalar';
                break;
            case 'integer':
            case 'double':
                $type = 'numeric';
                break;
            default:
                $type = gettype($compare);
        }
    } elseif ($type === 'equal') {
        $type = gettype($compare);
    }
    // do the check
    if ($type === 'length' || $type === 'scalar') {
        $is_scalar = is_scalar($var);
        if ($is_scalar && $type === 'length') {
            return strlen($var) > 0;
        }
        return $is_scalar;
    }
    if ($type === 'numeric') {
        return is_numeric($var);
    }
    if (gettype($var) === $type) {
        return true;
    }
    return false;
}
/**
 * Removes insecure parts in a path; used before include() or
 * require() when a part of the path comes from an insecure source
 * like a cookie or form.
 *
 * @param string $path The path to check
 *
 * @return string  The secured path
 *
 * @access  public
 */
function PMA_securePath($path)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_securePath") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 200")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_securePath:200@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
// end function
/**
 * displays the given error message on phpMyAdmin error page in foreign language,
 * ends script execution and closes session
 *
 * loads language file if not loaded already
 *
 * @param string       $error_message  the error message or named error message
 * @param string|array $message_args   arguments applied to $error_message
 *
 * @return void
 */
function PMA_fatalError($error_message, $message_args = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_fatalError") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 218")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_fatalError:218@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * Returns a link to the PHP documentation
 *
 * @param string $target anchor in documentation
 *
 * @return string  the URL
 *
 * @access  public
 */
function PMA_getPHPDocLink($target)
{
    /* List of PHP documentation translations */
    $php_doc_languages = array('pt_BR', 'zh', 'fr', 'de', 'it', 'ja', 'pl', 'ro', 'ru', 'fa', 'es', 'tr');
    $lang = 'en';
    if (in_array($GLOBALS['lang'], $php_doc_languages)) {
        $lang = $GLOBALS['lang'];
    }
    return PMA_linkURL('https://secure.php.net/manual/' . $lang . '/' . $target);
}
/**
 * Warn or fail on missing extension.
 *
 * @param string $extension Extension name
 * @param bool   $fatal     Whether the error is fatal.
 * @param string $extra     Extra string to append to message.
 *
 * @return void
 */
function PMA_warnMissingExtension($extension, $fatal = false, $extra = '')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_warnMissingExtension") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 294")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_warnMissingExtension:294@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * returns count of tables in given db
 *
 * @param string $db database to count tables for
 *
 * @return integer count of tables in $db
 */
function PMA_getTableCount($db)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getTableCount") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 333")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getTableCount:333@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * Converts numbers like 10M into bytes
 * Used with permission from Moodle (https://moodle.org) by Martin Dougiamas
 * (renamed with PMA prefix to avoid double definition when embedded
 * in Moodle)
 *
 * @param string|int $size size (Default = 0)
 *
 * @return integer $size
 */
function PMA_getRealSize($size = 0)
{
    if (!$size) {
        return 0;
    }
    $binaryprefixes = array('T' => 1099511627776, 't' => 1099511627776, 'G' => 1073741824, 'g' => 1073741824, 'M' => 1048576, 'm' => 1048576, 'K' => 1024, 'k' => 1024);
    if (preg_match('/^([0-9]+)([KMGT])/i', $size, $matches)) {
        return $matches[1] * $binaryprefixes[$matches[2]];
    }
    return (int) $size;
}
// end function PMA_getRealSize()
/**
 * boolean phpMyAdmin.PMA_checkPageValidity(string &$page, array $whitelist)
 *
 * checks given $page against given $whitelist and returns true if valid
 * it optionally ignores query parameters in $page (script.php?ignored)
 *
 * @param string &$page     page to check
 * @param array  $whitelist whitelist to check page against
 *
 * @return boolean whether $page is valid or not (in $whitelist or not)
 */
function PMA_checkPageValidity(&$page, $whitelist)
{
    if (!isset($page) || !is_string($page)) {
        return false;
    }
    if (in_array($page, $whitelist)) {
        return true;
    }
    $_page = mb_substr($page, 0, mb_strpos($page . '?', '?'));
    if (in_array($_page, $whitelist)) {
        return true;
    }
    $_page = urldecode($page);
    $_page = mb_substr($_page, 0, mb_strpos($_page . '?', '?'));
    if (in_array($_page, $whitelist)) {
        return true;
    }
    return false;
}
/**
 * tries to find the value for the given environment variable name
 *
 * searches in $_SERVER, $_ENV then tries getenv() and apache_getenv()
 * in this order
 *
 * @param string $var_name variable name
 *
 * @return string  value of $var or empty string
 */
function PMA_getenv($var_name)
{
    if (isset($_SERVER[$var_name])) {
        return $_SERVER[$var_name];
    }
    if (isset($_ENV[$var_name])) {
        return $_ENV[$var_name];
    }
    if (getenv($var_name)) {
        return getenv($var_name);
    }
    if (function_exists('apache_getenv') && apache_getenv($var_name, true)) {
        return apache_getenv($var_name, true);
    }
    return '';
}
/**
 * Send HTTP header, taking IIS limits into account (600 seems ok)
 *
 * @param string $uri         the header to send
 * @param bool   $use_refresh whether to use Refresh: header when running on IIS
 *
 * @return void
 */
function PMA_sendHeaderLocation($uri, $use_refresh = false)
{
    if ($GLOBALS['PMA_Config']->get('PMA_IS_IIS') && mb_strlen($uri) > 600) {
        Response::getInstance()->disable();
        echo PMA\libraries\Template::get('header_location')->render(array('uri' => $uri));
        return;
    }
    /*
     * Avoid relative path redirect problems in case user entered URL
     * like /phpmyadmin/index.php/ which some web servers happily accept.
     */
    if ($uri[0] == '.') {
        $uri = $GLOBALS['PMA_Config']->getRootPath() . substr($uri, 2);
    }
    $response = Response::getInstance();
    session_write_close();
    if ($response->headersSent()) {
        trigger_error('PMA_sendHeaderLocation called when headers are already sent!', E_USER_ERROR);
    }
    // bug #1523784: IE6 does not like 'Refresh: 0', it
    // results in a blank page
    // but we need it when coming from the cookie login panel)
    if ($GLOBALS['PMA_Config']->get('PMA_IS_IIS') && $use_refresh) {
        $response->header('Refresh: 0; ' . $uri);
    } else {
        $response->header('Location: ' . $uri);
    }
}
/**
 * Outputs application/json headers. This includes no caching.
 *
 * @return void
 */
function PMA_headerJSON()
{
    if (defined('TESTSUITE')) {
        return;
    }
    // No caching
    PMA_noCacheHeader();
    // MIME type
    header('Content-Type: application/json; charset=UTF-8');
    // Disable content sniffing in browser
    // This is needed in case we include HTML in JSON, browser might assume it's
    // html to display
    header('X-Content-Type-Options: nosniff');
}
/**
 * Outputs headers to prevent caching in browser (and on the way).
 *
 * @return void
 */
function PMA_noCacheHeader()
{
    if (defined('TESTSUITE')) {
        return;
    }
    // rfc2616 - Section 14.21
    header('Expires: ' . gmdate(DATE_RFC1123));
    // HTTP/1.1
    header('Cache-Control: no-store, no-cache, must-revalidate,' . '  pre-check=0, post-check=0, max-age=0');
    header('Pragma: no-cache');
    // HTTP/1.0
    // test case: exporting a database into a .gz file with Safari
    // would produce files not having the current time
    // (added this header for Safari but should not harm other browsers)
    header('Last-Modified: ' . gmdate(DATE_RFC1123));
}
/**
 * Sends header indicating file download.
 *
 * @param string $filename Filename to include in headers if empty,
 *                         none Content-Disposition header will be sent.
 * @param string $mimetype MIME type to include in headers.
 * @param int    $length   Length of content (optional)
 * @param bool   $no_cache Whether to include no-caching headers.
 *
 * @return void
 */
function PMA_downloadHeader($filename, $mimetype, $length = 0, $no_cache = true)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_downloadHeader") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 562")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_downloadHeader:562@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * Returns value of an element in $array given by $path.
 * $path is a string describing position of an element in an associative array,
 * eg. Servers/1/host refers to $array[Servers][1][host]
 *
 * @param string $path    path in the array
 * @param array  $array   the array
 * @param mixed  $default default value
 *
 * @return mixed    array element or $default
 */
function PMA_arrayRead($path, $array, $default = null)
{
    $keys = explode('/', $path);
    $value =& $array;
    foreach ($keys as $key) {
        if (!isset($value[$key])) {
            return $default;
        }
        $value =& $value[$key];
    }
    return $value;
}
/**
 * Stores value in an array
 *
 * @param string $path   path in the array
 * @param array  &$array the array
 * @param mixed  $value  value to store
 *
 * @return void
 */
function PMA_arrayWrite($path, &$array, $value)
{
    $keys = explode('/', $path);
    $last_key = array_pop($keys);
    $a =& $array;
    foreach ($keys as $key) {
        if (!isset($a[$key])) {
            $a[$key] = array();
        }
        $a =& $a[$key];
    }
    $a[$last_key] = $value;
}
/**
 * Removes value from an array
 *
 * @param string $path   path in the array
 * @param array  &$array the array
 *
 * @return void
 */
function PMA_arrayRemove($path, &$array)
{
    $keys = explode('/', $path);
    $keys_last = array_pop($keys);
    $path = array();
    $depth = 0;
    $path[0] =& $array;
    $found = true;
    // go as deep as required or possible
    foreach ($keys as $key) {
        if (!isset($path[$depth][$key])) {
            $found = false;
            break;
        }
        $depth++;
        $path[$depth] =& $path[$depth - 1][$key];
    }
    // if element found, remove it
    if ($found) {
        unset($path[$depth][$keys_last]);
        $depth--;
    }
    // remove empty nested arrays
    for (; $depth >= 0; $depth--) {
        if (!isset($path[$depth + 1]) || count($path[$depth + 1]) == 0) {
            unset($path[$depth][$keys[$depth]]);
        } else {
            break;
        }
    }
}
/**
 * Returns link to (possibly) external site using defined redirector.
 *
 * @param string $url URL where to go.
 *
 * @return string URL for a link.
 */
function PMA_linkURL($url)
{
    if (!preg_match('#^https?://#', $url)) {
        return $url;
    }
    $params = array();
    $params['url'] = $url;
    $url = URL::getCommon($params);
    //strip off token and such sensitive information. Just keep url.
    $arr = parse_url($url);
    parse_str($arr["query"], $vars);
    $query = http_build_query(array("url" => $vars["url"]));
    if (defined('PMA_SETUP')) {
        $url = '../url.php?' . $query;
    } else {
        $url = './url.php?' . $query;
    }
    return $url;
}
/**
 * Checks whether domain of URL is whitelisted domain or not.
 * Use only for URLs of external sites.
 *
 * @param string $url URL of external site.
 *
 * @return boolean True: if domain of $url is allowed domain,
 *                 False: otherwise.
 */
function PMA_isAllowedDomain($url)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_isAllowedDomain") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 716")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_isAllowedDomain:716@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * Replace some html-unfriendly stuff
 *
 * @param string $buffer String to process
 *
 * @return string Escaped and cleaned up text suitable for html
 */
function PMA_mimeDefaultFunction($buffer)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_mimeDefaultFunction") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 770")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_mimeDefaultFunction:770@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * Displays SQL query before executing.
 *
 * @param array|string $query_data Array containing queries or query itself
 *
 * @return void
 */
function PMA_previewSQL($query_data)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_previewSQL") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 786")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_previewSQL:786@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * recursively check if variable is empty
 *
 * @param mixed $value the variable
 *
 * @return bool true if empty
 */
function PMA_emptyRecursive($value)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_emptyRecursive") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 811")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_emptyRecursive:811@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * Creates some globals from $_POST variables matching a pattern
 *
 * @param array $post_patterns The patterns to search for
 *
 * @return void
 */
function PMA_setPostAsGlobal($post_patterns)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_setPostAsGlobal") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 834")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_setPostAsGlobal:834@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * Creates some globals from $_REQUEST
 *
 * @param string $param db|table
 *
 * @return void
 */
function PMA_setGlobalDbOrTable($param)
{
    $GLOBALS[$param] = '';
    if (PMA_isValid($_REQUEST[$param])) {
        // can we strip tags from this?
        // only \ and / is not allowed in db names for MySQL
        $GLOBALS[$param] = $_REQUEST[$param];
        $GLOBALS['url_params'][$param] = $GLOBALS[$param];
    }
}
/**
 * PATH_INFO could be compromised if set, so remove it from PHP_SELF
 * and provide a clean PHP_SELF here
 *
 * @return void
 */
function PMA_cleanupPathInfo()
{
    global $PMA_PHP_SELF;
    $PMA_PHP_SELF = PMA_getenv('PHP_SELF');
    if (empty($PMA_PHP_SELF)) {
        $PMA_PHP_SELF = urldecode(PMA_getenv('REQUEST_URI'));
    }
    $_PATH_INFO = PMA_getenv('PATH_INFO');
    if (!empty($_PATH_INFO) && !empty($PMA_PHP_SELF)) {
        $question_pos = mb_strpos($PMA_PHP_SELF, '?');
        if ($question_pos != false) {
            $PMA_PHP_SELF = mb_substr($PMA_PHP_SELF, 0, $question_pos);
        }
        $path_info_pos = mb_strrpos($PMA_PHP_SELF, $_PATH_INFO);
        if ($path_info_pos !== false) {
            $path_info_part = mb_substr($PMA_PHP_SELF, $path_info_pos, mb_strlen($_PATH_INFO));
            if ($path_info_part == $_PATH_INFO) {
                $PMA_PHP_SELF = mb_substr($PMA_PHP_SELF, 0, $path_info_pos);
            }
        }
    }
    $path = [];
    foreach (explode('/', $PMA_PHP_SELF) as $part) {
        // ignore parts that have no value
        if (empty($part) || $part === '.') {
            continue;
        }
        if ($part !== '..') {
            // cool, we found a new part
            array_push($path, $part);
        } else {
            if (count($path) > 0) {
                // going back up? sure
                array_pop($path);
            }
        }
        // Here we intentionall ignore case where we go too up
        // as there is nothing sane to do
    }
    $PMA_PHP_SELF = htmlspecialchars('/' . join('/', $path));
}
/**
 * Checks that required PHP extensions are there.
 * @return void
 */
function PMA_checkExtensions()
{
    /**
     * Warning about mbstring.
     */
    if (!function_exists('mb_detect_encoding')) {
        PMA_warnMissingExtension('mbstring', true);
    }
    /**
     * We really need this one!
     */
    if (!function_exists('preg_replace')) {
        PMA_warnMissingExtension('pcre', true);
    }
    /**
     * JSON is required in several places.
     */
    if (!function_exists('json_encode')) {
        PMA_warnMissingExtension('json', true);
    }
}
/**
 * Gets the "true" IP address of the current user
 *
 * @return string   the ip of the user
 *
 * @access  private
 */
function PMA_getIp()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getIp") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 947")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getIp:947@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
// end of the 'PMA_getIp()' function
/* Compatibility with PHP < 5.6 */
if (!function_exists('hash_equals')) {
    /**
     * Timing attack safe string comparison
     *
     * @param string $a first string
     * @param string $b second string
     *
     * @return boolean whether they are equal
     */
    function hash_equals($a, $b)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hash_equals") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 993")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hash_equals:993@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
        die();
    }
}
/* Compatibility with PHP < 5.1 or PHP without hash extension */
if (!function_exists('hash_hmac')) {
    function hash_hmac($algo, $data, $key, $raw_output = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hash_hmac") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 1002")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hash_hmac:1002@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
        die();
    }
}
/**
 * Sanitizes MySQL hostname
 *
 * * strips p: prefix(es)
 *
 * @param string $name User given hostname
 *
 * @return string
 */
function PMA_sanitizeMySQLHost($name)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_sanitizeMySQLHost") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 1036")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_sanitizeMySQLHost:1036@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}
/**
 * Sanitizes MySQL username
 *
 * * strips part behind null byte
 *
 * @param string $name User given username
 *
 * @return string
 */
function PMA_sanitizeMySQLUser($name)
{
    $position = strpos($name, chr(0));
    if ($position !== false) {
        return substr($name, 0, $position);
    }
    return $name;
}
/**
 * Safe unserializer wrapper
 *
 * It does not unserialize data containing objects
 *
 * @param string $data Data to unserialize
 *
 * @return mixed
 */
function PMA_safeUnserialize($data)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_safeUnserialize") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php at line 1072")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_safeUnserialize:1072@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/core.lib.php');
    die();
}