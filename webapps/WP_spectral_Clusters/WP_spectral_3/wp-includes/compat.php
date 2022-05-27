<?php

/**
 * WordPress implementation for PHP functions either missing from older PHP versions or not included by default.
 *
 * @package PHP
 * @access private
 */
// If gettext isn't available.
if (!function_exists('_')) {
    function _($string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php at line 13")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _:13@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php');
        die();
    }
}
/**
 * Returns whether PCRE/u (PCRE_UTF8 modifier) is available for use.
 *
 * @ignore
 * @since 4.2.2
 * @access private
 *
 * @param bool $set - Used for testing only
 *             null   : default - get PCRE/u capability
 *             false  : Used for testing - return false for future calls to this function
 *             'reset': Used for testing - restore default behavior of this function
 */
function _wp_can_use_pcre_u($set = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_wp_can_use_pcre_u") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php at line 30")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _wp_can_use_pcre_u:30@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php');
    die();
}
if (!function_exists('mb_substr')) {
    /**
     * Compat function to mimic mb_substr().
     *
     * @ignore
     * @since 3.2.0
     *
     * @see _mb_substr()
     *
     * @param string      $str      The string to extract the substring from.
     * @param int         $start    Position to being extraction from in `$str`.
     * @param int|null    $length   Optional. Maximum number of characters to extract from `$str`.
     *                              Default null.
     * @param string|null $encoding Optional. Character encoding to use. Default null.
     * @return string Extracted substring.
     */
    function mb_substr($str, $start, $length = null, $encoding = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mb_substr") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php at line 58")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mb_substr:58@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php');
        die();
    }
}
/**
 * Internal compat function to mimic mb_substr().
 *
 * Only understands UTF-8 and 8bit.  All other character sets will be treated as 8bit.
 * For $encoding === UTF-8, the $str input is expected to be a valid UTF-8 byte sequence.
 * The behavior of this function for invalid inputs is undefined.
 *
 * @ignore
 * @since 3.2.0
 *
 * @param string      $str      The string to extract the substring from.
 * @param int         $start    Position to being extraction from in `$str`.
 * @param int|null    $length   Optional. Maximum number of characters to extract from `$str`.
 *                              Default null.
 * @param string|null $encoding Optional. Character encoding to use. Default null.
 * @return string Extracted substring.
 */
function _mb_substr($str, $start, $length = null, $encoding = null)
{
    if (null === $encoding) {
        $encoding = get_option('blog_charset');
    }
    /*
     * The solution below works only for UTF-8, so in case of a different
     * charset just use built-in substr().
     */
    if (!in_array($encoding, array('utf8', 'utf-8', 'UTF8', 'UTF-8'), true)) {
        return is_null($length) ? substr($str, $start) : substr($str, $start, $length);
    }
    if (_wp_can_use_pcre_u()) {
        // Use the regex unicode support to separate the UTF-8 characters into an array.
        preg_match_all('/./us', $str, $match);
        $chars = is_null($length) ? array_slice($match[0], $start) : array_slice($match[0], $start, $length);
        return implode('', $chars);
    }
    $regex = '/(
		[\\x00-\\x7F]                  # single-byte sequences   0xxxxxxx
		| [\\xC2-\\xDF][\\x80-\\xBF]       # double-byte sequences   110xxxxx 10xxxxxx
		| \\xE0[\\xA0-\\xBF][\\x80-\\xBF]   # triple-byte sequences   1110xxxx 10xxxxxx * 2
		| [\\xE1-\\xEC][\\x80-\\xBF]{2}
		| \\xED[\\x80-\\x9F][\\x80-\\xBF]
		| [\\xEE-\\xEF][\\x80-\\xBF]{2}
		| \\xF0[\\x90-\\xBF][\\x80-\\xBF]{2} # four-byte sequences   11110xxx 10xxxxxx * 3
		| [\\xF1-\\xF3][\\x80-\\xBF]{3}
		| \\xF4[\\x80-\\x8F][\\x80-\\xBF]{2}
	)/x';
    // Start with 1 element instead of 0 since the first thing we do is pop.
    $chars = array('');
    do {
        // We had some string left over from the last round, but we counted it in that last round.
        array_pop($chars);
        /*
         * Split by UTF-8 character, limit to 1000 characters (last array element will contain
         * the rest of the string).
         */
        $pieces = preg_split($regex, $str, 1000, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $chars = array_merge($chars, $pieces);
        // If there's anything left over, repeat the loop.
    } while (count($pieces) > 1 && ($str = array_pop($pieces)));
    return implode('', array_slice($chars, $start, $length));
}
if (!function_exists('mb_strlen')) {
    /**
     * Compat function to mimic mb_strlen().
     *
     * @ignore
     * @since 4.2.0
     *
     * @see _mb_strlen()
     *
     * @param string      $str      The string to retrieve the character length from.
     * @param string|null $encoding Optional. Character encoding to use. Default null.
     * @return int String length of `$str`.
     */
    function mb_strlen($str, $encoding = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mb_strlen") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php at line 137")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mb_strlen:137@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php');
        die();
    }
}
/**
 * Internal compat function to mimic mb_strlen().
 *
 * Only understands UTF-8 and 8bit.  All other character sets will be treated as 8bit.
 * For $encoding === UTF-8, the `$str` input is expected to be a valid UTF-8 byte
 * sequence. The behavior of this function for invalid inputs is undefined.
 *
 * @ignore
 * @since 4.2.0
 *
 * @param string      $str      The string to retrieve the character length from.
 * @param string|null $encoding Optional. Character encoding to use. Default null.
 * @return int String length of `$str`.
 */
function _mb_strlen($str, $encoding = null)
{
    if (null === $encoding) {
        $encoding = get_option('blog_charset');
    }
    /*
     * The solution below works only for UTF-8, so in case of a different charset
     * just use built-in strlen().
     */
    if (!in_array($encoding, array('utf8', 'utf-8', 'UTF8', 'UTF-8'), true)) {
        return strlen($str);
    }
    if (_wp_can_use_pcre_u()) {
        // Use the regex unicode support to separate the UTF-8 characters into an array.
        preg_match_all('/./us', $str, $match);
        return count($match[0]);
    }
    $regex = '/(?:
		[\\x00-\\x7F]                  # single-byte sequences   0xxxxxxx
		| [\\xC2-\\xDF][\\x80-\\xBF]       # double-byte sequences   110xxxxx 10xxxxxx
		| \\xE0[\\xA0-\\xBF][\\x80-\\xBF]   # triple-byte sequences   1110xxxx 10xxxxxx * 2
		| [\\xE1-\\xEC][\\x80-\\xBF]{2}
		| \\xED[\\x80-\\x9F][\\x80-\\xBF]
		| [\\xEE-\\xEF][\\x80-\\xBF]{2}
		| \\xF0[\\x90-\\xBF][\\x80-\\xBF]{2} # four-byte sequences   11110xxx 10xxxxxx * 3
		| [\\xF1-\\xF3][\\x80-\\xBF]{3}
		| \\xF4[\\x80-\\x8F][\\x80-\\xBF]{2}
	)/x';
    // Start at 1 instead of 0 since the first thing we do is decrement.
    $count = 1;
    do {
        // We had some string left over from the last round, but we counted it in that last round.
        $count--;
        /*
         * Split by UTF-8 character, limit to 1000 characters (last array element will contain
         * the rest of the string).
         */
        $pieces = preg_split($regex, $str, 1000);
        // Increment.
        $count += count($pieces);
        // If there's anything left over, repeat the loop.
    } while ($str = array_pop($pieces));
    // Fencepost: preg_split() always returns one extra item in the array.
    return --$count;
}
if (!function_exists('hash_hmac')) {
    /**
     * Compat function to mimic hash_hmac().
     *
     * The Hash extension is bundled with PHP by default since PHP 5.1.2.
     * However, the extension may be explicitly disabled on select servers.
     * As of PHP 7.4.0, the Hash extension is a core PHP extension and can no
     * longer be disabled.
     * I.e. when PHP 7.4.0 becomes the minimum requirement, this polyfill
     * and the associated `_hash_hmac()` function can be safely removed.
     *
     * @ignore
     * @since 3.2.0
     *
     * @see _hash_hmac()
     *
     * @param string $algo       Hash algorithm. Accepts 'md5' or 'sha1'.
     * @param string $data       Data to be hashed.
     * @param string $key        Secret key to use for generating the hash.
     * @param bool   $raw_output Optional. Whether to output raw binary data (true),
     *                           or lowercase hexits (false). Default false.
     * @return string|false The hash in output determined by `$raw_output`. False if `$algo`
     *                      is unknown or invalid.
     */
    function hash_hmac($algo, $data, $key, $raw_output = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hash_hmac") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php at line 225")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hash_hmac:225@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php');
        die();
    }
}
/**
 * Internal compat function to mimic hash_hmac().
 *
 * @ignore
 * @since 3.2.0
 *
 * @param string $algo       Hash algorithm. Accepts 'md5' or 'sha1'.
 * @param string $data       Data to be hashed.
 * @param string $key        Secret key to use for generating the hash.
 * @param bool   $raw_output Optional. Whether to output raw binary data (true),
 *                           or lowercase hexits (false). Default false.
 * @return string|false The hash in output determined by `$raw_output`. False if `$algo`
 *                      is unknown or invalid.
 */
function _hash_hmac($algo, $data, $key, $raw_output = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_hash_hmac") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php at line 244")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called _hash_hmac:244@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php');
    die();
}
if (!function_exists('hash_equals')) {
    /**
     * Timing attack safe string comparison
     *
     * Compares two strings using the same time whether they're equal or not.
     *
     * Note: It can leak the length of a string when arguments of differing length are supplied.
     *
     * This function was added in PHP 5.6.
     * However, the Hash extension may be explicitly disabled on select servers.
     * As of PHP 7.4.0, the Hash extension is a core PHP extension and can no
     * longer be disabled.
     * I.e. when PHP 7.4.0 becomes the minimum requirement, this polyfill
     * can be safely removed.
     *
     * @since 3.9.2
     *
     * @param string $a Expected string.
     * @param string $b Actual, user supplied, string.
     * @return bool Whether strings are equal.
     */
    function hash_equals($a, $b)
    {
        $a_length = strlen($a);
        if (strlen($b) !== $a_length) {
            return false;
        }
        $result = 0;
        // Do not attempt to "optimize" this.
        for ($i = 0; $i < $a_length; $i++) {
            $result |= ord($a[$i]) ^ ord($b[$i]);
        }
        return 0 === $result;
    }
}
// random_int() was introduced in PHP 7.0.
if (!function_exists('random_int')) {
    require ABSPATH . WPINC . '/random_compat/random.php';
}
// sodium_crypto_box() was introduced in PHP 7.2.
if (!function_exists('sodium_crypto_box')) {
    require ABSPATH . WPINC . '/sodium_compat/autoload.php';
}
if (!function_exists('is_countable')) {
    /**
     * Polyfill for is_countable() function added in PHP 7.3.
     *
     * Verify that the content of a variable is an array or an object
     * implementing the Countable interface.
     *
     * @since 4.9.6
     *
     * @param mixed $var The value to check.
     * @return bool True if `$var` is countable, false otherwise.
     */
    function is_countable($var)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_countable") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php at line 318")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_countable:318@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/compat.php');
        die();
    }
}
if (!function_exists('is_iterable')) {
    /**
     * Polyfill for is_iterable() function added in PHP 7.1.
     *
     * Verify that the content of a variable is an array or an object
     * implementing the Traversable interface.
     *
     * @since 4.9.6
     *
     * @param mixed $var The value to check.
     * @return bool True if `$var` is iterable, false otherwise.
     */
    function is_iterable($var)
    {
        return is_array($var) || $var instanceof Traversable;
    }
}