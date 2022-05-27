<?php

/**
 * This class includes various sanitization methods that can be called statically
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Html\MySQLDocumentation;
use function array_keys;
use function array_merge;
use function count;
use function htmlspecialchars;
use function in_array;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function preg_match;
use function preg_replace;
use function preg_replace_callback;
use function str_replace;
use function strlen;
use function strncmp;
use function strtolower;
use function strtr;
use function substr;
/**
 * This class includes various sanitization methods that can be called statically
 */
class Sanitize
{
    /**
     * Checks whether given link is valid
     *
     * @param string $url   URL to check
     * @param bool   $http  Whether to allow http links
     * @param bool   $other Whether to allow ftp and mailto links
     *
     * @return bool True if string can be used as link
     */
    public static function checkLink($url, $http = false, $other = false)
    {
        $url = strtolower($url);
        $valid_starts = ['https://', './url.php?url=https%3a%2f%2f', './doc/html/', './index.php?'];
        $is_setup = self::isSetup();
        // Adjust path to setup script location
        if ($is_setup) {
            foreach ($valid_starts as $key => $value) {
                if (substr($value, 0, 2) !== './') {
                    continue;
                }
                $valid_starts[$key] = '.' . $value;
            }
        }
        if ($other) {
            $valid_starts[] = 'mailto:';
            $valid_starts[] = 'ftp://';
        }
        if ($http) {
            $valid_starts[] = 'http://';
        }
        if ($is_setup) {
            $valid_starts[] = '?page=form&';
            $valid_starts[] = '?page=servers&';
        }
        foreach ($valid_starts as $val) {
            if (substr($url, 0, strlen($val)) == $val) {
                return true;
            }
        }
        return false;
    }
    /**
     * Check if we are currently on a setup folder page
     */
    public static function isSetup() : bool
    {
        return $GLOBALS['PMA_Config'] !== null && $GLOBALS['PMA_Config']->get('is_setup');
    }
    /**
     * Callback function for replacing [a@link@target] links in bb code.
     *
     * @param array $found Array of preg matches
     *
     * @return string Replaced string
     */
    public static function replaceBBLink(array $found)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("replaceBBLink") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Sanitize.php at line 91")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called replaceBBLink:91@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Sanitize.php');
        die();
    }
    /**
     * Callback function for replacing [doc@anchor] links in bb code.
     *
     * @param array $found Array of preg matches
     *
     * @return string Replaced string
     */
    public static function replaceDocLink(array $found)
    {
        if (count($found) >= 4) {
            /* doc@page@anchor pattern */
            $page = $found[1];
            $anchor = $found[3];
        } else {
            /* doc@anchor pattern */
            $anchor = $found[1];
            if (strncmp('faq', $anchor, 3) == 0) {
                $page = 'faq';
            } elseif (strncmp('cfg', $anchor, 3) == 0) {
                $page = 'config';
            } else {
                /* Guess */
                $page = 'setup';
            }
        }
        $link = MySQLDocumentation::getDocumentationLink($page, $anchor, self::isSetup() ? '../' : './');
        return '<a href="' . $link . '" target="documentation">';
    }
    /**
     * Sanitizes $message, taking into account our special codes
     * for formatting.
     *
     * If you want to include result in element attribute, you should escape it.
     *
     * Examples:
     *
     * <p><?php echo Sanitize::sanitizeMessage($foo); ?></p>
     *
     * <a title="<?php echo Sanitize::sanitizeMessage($foo, true); ?>">bar</a>
     *
     * @param string $message the message
     * @param bool   $escape  whether to escape html in result
     * @param bool   $safe    whether string is safe (can keep < and > chars)
     */
    public static function sanitizeMessage(string $message, $escape = false, $safe = false) : string
    {
        if (!$safe) {
            $message = strtr($message, ['<' => '&lt;', '>' => '&gt;']);
        }
        /* Interpret bb code */
        $replace_pairs = [
            '[em]' => '<em>',
            '[/em]' => '</em>',
            '[strong]' => '<strong>',
            '[/strong]' => '</strong>',
            '[code]' => '<code>',
            '[/code]' => '</code>',
            '[kbd]' => '<kbd>',
            '[/kbd]' => '</kbd>',
            '[br]' => '<br>',
            '[/a]' => '</a>',
            '[/doc]' => '</a>',
            '[sup]' => '<sup>',
            '[/sup]' => '</sup>',
            // used in common.inc.php:
            '[conferr]' => '<iframe src="show_config_errors.php"><a href=' . '"show_config_errors.php">show_config_errors.php</a></iframe>',
            // used in libraries/Util.php
            '[dochelpicon]' => Html\Generator::getImage('b_help', __('Documentation')),
        ];
        $message = strtr($message, $replace_pairs);
        /* Match links in bb code ([a@url@target], where @target is options) */
        $pattern = '/\\[a@([^]"@]*)(@([^]"]*))?\\]/';
        /* Find and replace all links */
        $message = (string) preg_replace_callback($pattern, static function (array $match) {
            return self::replaceBBLink($match);
        }, $message);
        /* Replace documentation links */
        $message = (string) preg_replace_callback('/\\[doc@([a-zA-Z0-9_-]+)(@([a-zA-Z0-9_-]*))?\\]/', static function (array $match) {
            return self::replaceDocLink($match);
        }, $message);
        /* Possibly escape result */
        if ($escape) {
            $message = htmlspecialchars($message);
        }
        return $message;
    }
    /**
     * Sanitize a filename by removing anything besides legit characters
     *
     * Intended usecase:
     *    When using a filename in a Content-Disposition header
     *    the value should not contain ; or "
     *
     *    When exporting, avoiding generation of an unexpected double-extension file
     *
     * @param string $filename    The filename
     * @param bool   $replaceDots Whether to also replace dots
     *
     * @return string  the sanitized filename
     */
    public static function sanitizeFilename($filename, $replaceDots = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitizeFilename") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Sanitize.php at line 216")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sanitizeFilename:216@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Sanitize.php');
        die();
    }
    /**
     * Format a string so it can be a string inside JavaScript code inside an
     * eventhandler (onclick, onchange, on..., ).
     * This function is used to displays a javascript confirmation box for
     * "DROP/DELETE/ALTER" queries.
     *
     * @param string $a_string       the string to format
     * @param bool   $add_backquotes whether to add backquotes to the string or not
     *
     * @return string   the formatted string
     *
     * @access public
     */
    public static function jsFormat($a_string = '', $add_backquotes = true)
    {
        $a_string = htmlspecialchars((string) $a_string);
        $a_string = self::escapeJsString($a_string);
        // Needed for inline javascript to prevent some browsers
        // treating it as a anchor
        $a_string = str_replace('#', '\\#', $a_string);
        return $add_backquotes ? Util::backquote($a_string) : $a_string;
    }
    /**
     * escapes a string to be inserted as string a JavaScript block
     * enclosed by <![CDATA[ ... ]]>
     * this requires only to escape ' with \' and end of script block
     *
     * We also remove NUL byte as some browsers (namely MSIE) ignore it and
     * inserting it anywhere inside </script would allow to bypass this check.
     *
     * @param string $string the string to be escaped
     *
     * @return string  the escaped string
     */
    public static function escapeJsString($string)
    {
        return preg_replace('@</script@i', '</\' + \'script', strtr((string) $string, ["\x00" => '', '\\' => '\\\\', '\'' => '\\\'', '"' => '\\"', "\n" => '\\n', "\r" => '\\r']));
    }
    /**
     * Formats a value for javascript code.
     *
     * @param string $value String to be formatted.
     *
     * @return int|string formatted value.
     */
    public static function formatJsVal($value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("formatJsVal") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Sanitize.php at line 273")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called formatJsVal:273@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Sanitize.php');
        die();
    }
    /**
     * Formats an javascript assignment with proper escaping of a value
     * and support for assigning array of strings.
     *
     * @param string $key    Name of value to set
     * @param mixed  $value  Value to set, can be either string or array of strings
     * @param bool   $escape Whether to escape value or keep it as it is
     *                       (for inclusion of js code)
     *
     * @return string Javascript code.
     */
    public static function getJsValue($key, $value, $escape = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getJsValue") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Sanitize.php at line 297")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getJsValue:297@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Sanitize.php');
        die();
    }
    /**
     * Removes all variables from request except allowed ones.
     *
     * @param string[] $allowList list of variables to allow
     *
     * @access public
     */
    public static function removeRequestVars(&$allowList) : void
    {
        // do not check only $_REQUEST because it could have been overwritten
        // and use type casting because the variables could have become
        // strings
        $keys = array_keys(array_merge((array) $_REQUEST, (array) $_GET, (array) $_POST, (array) $_COOKIE));
        foreach ($keys as $key) {
            if (!in_array($key, $allowList)) {
                unset($_REQUEST[$key], $_GET[$key], $_POST[$key]);
                continue;
            }
            // allowed stuff could be compromised so escape it
            // we require it to be a string
            if (isset($_REQUEST[$key]) && !is_string($_REQUEST[$key])) {
                unset($_REQUEST[$key]);
            }
            if (isset($_POST[$key]) && !is_string($_POST[$key])) {
                unset($_POST[$key]);
            }
            if (isset($_COOKIE[$key]) && !is_string($_COOKIE[$key])) {
                unset($_COOKIE[$key]);
            }
            if (!isset($_GET[$key]) || is_string($_GET[$key])) {
                continue;
            }
            unset($_GET[$key]);
        }
    }
}