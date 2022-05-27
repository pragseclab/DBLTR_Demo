<?php

/**
 * SimplePie
 *
 * A PHP-Based RSS and Atom Feed Framework.
 * Takes the hard work out of managing a complete RSS/Atom solution.
 *
 * Copyright (c) 2004-2016, Ryan Parman, Sam Sneddon, Ryan McCue, and contributors
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 * 	* Redistributions of source code must retain the above copyright notice, this list of
 * 	  conditions and the following disclaimer.
 *
 * 	* Redistributions in binary form must reproduce the above copyright notice, this list
 * 	  of conditions and the following disclaimer in the documentation and/or other materials
 * 	  provided with the distribution.
 *
 * 	* Neither the name of the SimplePie Team nor the names of its contributors may be used
 * 	  to endorse or promote products derived from this software without specific prior
 * 	  written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS
 * AND CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package SimplePie
 * @copyright 2004-2016 Ryan Parman, Sam Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Sam Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */
/**
 * Miscellanous utilities
 *
 * @package SimplePie
 */
class SimplePie_Misc
{
    public static function time_hms($seconds)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("time_hms") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 53")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called time_hms:53@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function absolutize_url($relative, $base)
    {
        $iri = SimplePie_IRI::absolutize(new SimplePie_IRI($base), $relative);
        if ($iri === false) {
            return false;
        }
        return $iri->get_uri();
    }
    /**
     * Get a HTML/XML element from a HTML string
     *
     * @deprecated Use DOMDocument instead (parsing HTML with regex is bad!)
     * @param string $realname Element name (including namespace prefix if applicable)
     * @param string $string HTML document
     * @return array
     */
    public static function get_element($realname, $string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_element") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 89")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_element:89@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function element_implode($element)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("element_implode") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 117")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called element_implode:117@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function error($message, $level, $file, $line)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("error") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 131")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called error:131@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function fix_protocol($url, $http = 1)
    {
        $url = SimplePie_Misc::normalize_url($url);
        $parsed = SimplePie_Misc::parse_url($url);
        if ($parsed['scheme'] !== '' && $parsed['scheme'] !== 'http' && $parsed['scheme'] !== 'https') {
            return SimplePie_Misc::fix_protocol(SimplePie_Misc::compress_parse_url('http', $parsed['authority'], $parsed['path'], $parsed['query'], $parsed['fragment']), $http);
        }
        if ($parsed['scheme'] === '' && $parsed['authority'] === '' && !file_exists($url)) {
            return SimplePie_Misc::fix_protocol(SimplePie_Misc::compress_parse_url('http', $parsed['path'], '', $parsed['query'], $parsed['fragment']), $http);
        }
        if ($http === 2 && $parsed['scheme'] !== '') {
            return "feed:{$url}";
        } elseif ($http === 3 && strtolower($parsed['scheme']) === 'http') {
            return substr_replace($url, 'podcast', 0, 4);
        } elseif ($http === 4 && strtolower($parsed['scheme']) === 'http') {
            return substr_replace($url, 'itpc', 0, 4);
        }
        return $url;
    }
    public static function array_merge_recursive($array1, $array2)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("array_merge_recursive") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 181")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called array_merge_recursive:181@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function parse_url($url)
    {
        $iri = new SimplePie_IRI($url);
        return array('scheme' => (string) $iri->scheme, 'authority' => (string) $iri->authority, 'path' => (string) $iri->path, 'query' => (string) $iri->query, 'fragment' => (string) $iri->fragment);
    }
    public static function compress_parse_url($scheme = '', $authority = '', $path = '', $query = '', $fragment = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("compress_parse_url") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called compress_parse_url:197@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function normalize_url($url)
    {
        $iri = new SimplePie_IRI($url);
        return $iri->get_uri();
    }
    public static function percent_encoding_normalization($match)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("percent_encoding_normalization") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 212")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called percent_encoding_normalization:212@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Converts a Windows-1252 encoded string to a UTF-8 encoded string
     *
     * @static
     * @param string $string Windows-1252 encoded string
     * @return string UTF-8 encoded string
     */
    public static function windows_1252_to_utf8($string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("windows_1252_to_utf8") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 227")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called windows_1252_to_utf8:227@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Change a string from one encoding to another
     *
     * @param string $data Raw data in $input encoding
     * @param string $input Encoding of $data
     * @param string $output Encoding you want
     * @return string|boolean False if we can't convert it
     */
    public static function change_encoding($data, $input, $output)
    {
        $input = SimplePie_Misc::encoding($input);
        $output = SimplePie_Misc::encoding($output);
        // We fail to fail on non US-ASCII bytes
        if ($input === 'US-ASCII') {
            static $non_ascii_octects = '';
            if (!$non_ascii_octects) {
                for ($i = 0x80; $i <= 0xff; $i++) {
                    $non_ascii_octects .= chr($i);
                }
            }
            $data = substr($data, 0, strcspn($data, $non_ascii_octects));
        }
        // This is first, as behaviour of this is completely predictable
        if ($input === 'windows-1252' && $output === 'UTF-8') {
            return SimplePie_Misc::windows_1252_to_utf8($data);
        } elseif (function_exists('mb_convert_encoding') && ($return = SimplePie_Misc::change_encoding_mbstring($data, $input, $output))) {
            return $return;
        } elseif (function_exists('iconv') && ($return = SimplePie_Misc::change_encoding_iconv($data, $input, $output))) {
            return $return;
        } elseif (class_exists('\\UConverter') && ($return = SimplePie_Misc::change_encoding_uconverter($data, $input, $output))) {
            return $return;
        }
        // If we can't do anything, just fail
        return false;
    }
    protected static function change_encoding_mbstring($data, $input, $output)
    {
        if ($input === 'windows-949') {
            $input = 'EUC-KR';
        }
        if ($output === 'windows-949') {
            $output = 'EUC-KR';
        }
        if ($input === 'Windows-31J') {
            $input = 'SJIS';
        }
        if ($output === 'Windows-31J') {
            $output = 'SJIS';
        }
        // Check that the encoding is supported
        if (!in_array($input, mb_list_encodings())) {
            return false;
        }
        if (@mb_convert_encoding("\x80", 'UTF-16BE', $input) === "\x00\x80") {
            return false;
        }
        // Let's do some conversion
        if ($return = @mb_convert_encoding($data, $output, $input)) {
            return $return;
        }
        return false;
    }
    protected static function change_encoding_iconv($data, $input, $output)
    {
        return @iconv($input, $output, $data);
    }
    /**
     * @param string $data
     * @param string $input
     * @param string $output
     * @return string|false
     */
    protected static function change_encoding_uconverter($data, $input, $output)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("change_encoding_uconverter") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 304")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called change_encoding_uconverter:304@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Normalize an encoding name
     *
     * This is automatically generated by create.php
     *
     * To generate it, run `php create.php` on the command line, and copy the
     * output to replace this function.
     *
     * @param string $charset Character set to standardise
     * @return string Standardised name
     */
    public static function encoding($charset)
    {
        // Normalization from UTS #22
        switch (strtolower(preg_replace('/(?:[^a-zA-Z0-9]+|([^0-9])0+)/', '\\1', $charset))) {
            case 'adobestandardencoding':
            case 'csadobestandardencoding':
                return 'Adobe-Standard-Encoding';
            case 'adobesymbolencoding':
            case 'cshppsmath':
                return 'Adobe-Symbol-Encoding';
            case 'ami1251':
            case 'amiga1251':
                return 'Amiga-1251';
            case 'ansix31101983':
            case 'csat5001983':
            case 'csiso99naplps':
            case 'isoir99':
            case 'naplps':
                return 'ANSI_X3.110-1983';
            case 'arabic7':
            case 'asmo449':
            case 'csiso89asmo449':
            case 'iso9036':
            case 'isoir89':
                return 'ASMO_449';
            case 'big5':
            case 'csbig5':
                return 'Big5';
            case 'big5hkscs':
                return 'Big5-HKSCS';
            case 'bocu1':
            case 'csbocu1':
                return 'BOCU-1';
            case 'brf':
            case 'csbrf':
                return 'BRF';
            case 'bs4730':
            case 'csiso4unitedkingdom':
            case 'gb':
            case 'iso646gb':
            case 'isoir4':
            case 'uk':
                return 'BS_4730';
            case 'bsviewdata':
            case 'csiso47bsviewdata':
            case 'isoir47':
                return 'BS_viewdata';
            case 'cesu8':
            case 'cscesu8':
                return 'CESU-8';
            case 'ca':
            case 'csa71':
            case 'csaz243419851':
            case 'csiso121canadian1':
            case 'iso646ca':
            case 'isoir121':
                return 'CSA_Z243.4-1985-1';
            case 'csa72':
            case 'csaz243419852':
            case 'csiso122canadian2':
            case 'iso646ca2':
            case 'isoir122':
                return 'CSA_Z243.4-1985-2';
            case 'csaz24341985gr':
            case 'csiso123csaz24341985gr':
            case 'isoir123':
                return 'CSA_Z243.4-1985-gr';
            case 'csiso139csn369103':
            case 'csn369103':
            case 'isoir139':
                return 'CSN_369103';
            case 'csdecmcs':
            case 'dec':
            case 'decmcs':
                return 'DEC-MCS';
            case 'csiso21german':
            case 'de':
            case 'din66003':
            case 'iso646de':
            case 'isoir21':
                return 'DIN_66003';
            case 'csdkus':
            case 'dkus':
                return 'dk-us';
            case 'csiso646danish':
            case 'dk':
            case 'ds2089':
            case 'iso646dk':
                return 'DS_2089';
            case 'csibmebcdicatde':
            case 'ebcdicatde':
                return 'EBCDIC-AT-DE';
            case 'csebcdicatdea':
            case 'ebcdicatdea':
                return 'EBCDIC-AT-DE-A';
            case 'csebcdiccafr':
            case 'ebcdiccafr':
                return 'EBCDIC-CA-FR';
            case 'csebcdicdkno':
            case 'ebcdicdkno':
                return 'EBCDIC-DK-NO';
            case 'csebcdicdknoa':
            case 'ebcdicdknoa':
                return 'EBCDIC-DK-NO-A';
            case 'csebcdices':
            case 'ebcdices':
                return 'EBCDIC-ES';
            case 'csebcdicesa':
            case 'ebcdicesa':
                return 'EBCDIC-ES-A';
            case 'csebcdicess':
            case 'ebcdicess':
                return 'EBCDIC-ES-S';
            case 'csebcdicfise':
            case 'ebcdicfise':
                return 'EBCDIC-FI-SE';
            case 'csebcdicfisea':
            case 'ebcdicfisea':
                return 'EBCDIC-FI-SE-A';
            case 'csebcdicfr':
            case 'ebcdicfr':
                return 'EBCDIC-FR';
            case 'csebcdicit':
            case 'ebcdicit':
                return 'EBCDIC-IT';
            case 'csebcdicpt':
            case 'ebcdicpt':
                return 'EBCDIC-PT';
            case 'csebcdicuk':
            case 'ebcdicuk':
                return 'EBCDIC-UK';
            case 'csebcdicus':
            case 'ebcdicus':
                return 'EBCDIC-US';
            case 'csiso111ecmacyrillic':
            case 'ecmacyrillic':
            case 'isoir111':
            case 'koi8e':
                return 'ECMA-cyrillic';
            case 'csiso17spanish':
            case 'es':
            case 'iso646es':
            case 'isoir17':
                return 'ES';
            case 'csiso85spanish2':
            case 'es2':
            case 'iso646es2':
            case 'isoir85':
                return 'ES2';
            case 'cseucpkdfmtjapanese':
            case 'eucjp':
            case 'extendedunixcodepackedformatforjapanese':
                return 'EUC-JP';
            case 'cseucfixwidjapanese':
            case 'extendedunixcodefixedwidthforjapanese':
                return 'Extended_UNIX_Code_Fixed_Width_for_Japanese';
            case 'gb18030':
                return 'GB18030';
            case 'chinese':
            case 'cp936':
            case 'csgb2312':
            case 'csiso58gb231280':
            case 'gb2312':
            case 'gb231280':
            case 'gbk':
            case 'isoir58':
            case 'ms936':
            case 'windows936':
                return 'GBK';
            case 'cn':
            case 'csiso57gb1988':
            case 'gb198880':
            case 'iso646cn':
            case 'isoir57':
                return 'GB_1988-80';
            case 'csiso153gost1976874':
            case 'gost1976874':
            case 'isoir153':
            case 'stsev35888':
                return 'GOST_19768-74';
            case 'csiso150':
            case 'csiso150greekccitt':
            case 'greekccitt':
            case 'isoir150':
                return 'greek-ccitt';
            case 'csiso88greek7':
            case 'greek7':
            case 'isoir88':
                return 'greek7';
            case 'csiso18greek7old':
            case 'greek7old':
            case 'isoir18':
                return 'greek7-old';
            case 'cshpdesktop':
            case 'hpdesktop':
                return 'HP-DeskTop';
            case 'cshplegal':
            case 'hplegal':
                return 'HP-Legal';
            case 'cshpmath8':
            case 'hpmath8':
                return 'HP-Math8';
            case 'cshppifont':
            case 'hppifont':
                return 'HP-Pi-font';
            case 'cshproman8':
            case 'hproman8':
            case 'r8':
            case 'roman8':
                return 'hp-roman8';
            case 'hzgb2312':
                return 'HZ-GB-2312';
            case 'csibmsymbols':
            case 'ibmsymbols':
                return 'IBM-Symbols';
            case 'csibmthai':
            case 'ibmthai':
                return 'IBM-Thai';
            case 'cp37':
            case 'csibm37':
            case 'ebcdiccpca':
            case 'ebcdiccpnl':
            case 'ebcdiccpus':
            case 'ebcdiccpwt':
            case 'ibm37':
                return 'IBM037';
            case 'cp38':
            case 'csibm38':
            case 'ebcdicint':
            case 'ibm38':
                return 'IBM038';
            case 'cp273':
            case 'csibm273':
            case 'ibm273':
                return 'IBM273';
            case 'cp274':
            case 'csibm274':
            case 'ebcdicbe':
            case 'ibm274':
                return 'IBM274';
            case 'cp275':
            case 'csibm275':
            case 'ebcdicbr':
            case 'ibm275':
                return 'IBM275';
            case 'csibm277':
            case 'ebcdiccpdk':
            case 'ebcdiccpno':
            case 'ibm277':
                return 'IBM277';
            case 'cp278':
            case 'csibm278':
            case 'ebcdiccpfi':
            case 'ebcdiccpse':
            case 'ibm278':
                return 'IBM278';
            case 'cp280':
            case 'csibm280':
            case 'ebcdiccpit':
            case 'ibm280':
                return 'IBM280';
            case 'cp281':
            case 'csibm281':
            case 'ebcdicjpe':
            case 'ibm281':
                return 'IBM281';
            case 'cp284':
            case 'csibm284':
            case 'ebcdiccpes':
            case 'ibm284':
                return 'IBM284';
            case 'cp285':
            case 'csibm285':
            case 'ebcdiccpgb':
            case 'ibm285':
                return 'IBM285';
            case 'cp290':
            case 'csibm290':
            case 'ebcdicjpkana':
            case 'ibm290':
                return 'IBM290';
            case 'cp297':
            case 'csibm297':
            case 'ebcdiccpfr':
            case 'ibm297':
                return 'IBM297';
            case 'cp420':
            case 'csibm420':
            case 'ebcdiccpar1':
            case 'ibm420':
                return 'IBM420';
            case 'cp423':
            case 'csibm423':
            case 'ebcdiccpgr':
            case 'ibm423':
                return 'IBM423';
            case 'cp424':
            case 'csibm424':
            case 'ebcdiccphe':
            case 'ibm424':
                return 'IBM424';
            case '437':
            case 'cp437':
            case 'cspc8codepage437':
            case 'ibm437':
                return 'IBM437';
            case 'cp500':
            case 'csibm500':
            case 'ebcdiccpbe':
            case 'ebcdiccpch':
            case 'ibm500':
                return 'IBM500';
            case 'cp775':
            case 'cspc775baltic':
            case 'ibm775':
                return 'IBM775';
            case '850':
            case 'cp850':
            case 'cspc850multilingual':
            case 'ibm850':
                return 'IBM850';
            case '851':
            case 'cp851':
            case 'csibm851':
            case 'ibm851':
                return 'IBM851';
            case '852':
            case 'cp852':
            case 'cspcp852':
            case 'ibm852':
                return 'IBM852';
            case '855':
            case 'cp855':
            case 'csibm855':
            case 'ibm855':
                return 'IBM855';
            case '857':
            case 'cp857':
            case 'csibm857':
            case 'ibm857':
                return 'IBM857';
            case 'ccsid858':
            case 'cp858':
            case 'ibm858':
            case 'pcmultilingual850euro':
                return 'IBM00858';
            case '860':
            case 'cp860':
            case 'csibm860':
            case 'ibm860':
                return 'IBM860';
            case '861':
            case 'cp861':
            case 'cpis':
            case 'csibm861':
            case 'ibm861':
                return 'IBM861';
            case '862':
            case 'cp862':
            case 'cspc862latinhebrew':
            case 'ibm862':
                return 'IBM862';
            case '863':
            case 'cp863':
            case 'csibm863':
            case 'ibm863':
                return 'IBM863';
            case 'cp864':
            case 'csibm864':
            case 'ibm864':
                return 'IBM864';
            case '865':
            case 'cp865':
            case 'csibm865':
            case 'ibm865':
                return 'IBM865';
            case '866':
            case 'cp866':
            case 'csibm866':
            case 'ibm866':
                return 'IBM866';
            case 'cp868':
            case 'cpar':
            case 'csibm868':
            case 'ibm868':
                return 'IBM868';
            case '869':
            case 'cp869':
            case 'cpgr':
            case 'csibm869':
            case 'ibm869':
                return 'IBM869';
            case 'cp870':
            case 'csibm870':
            case 'ebcdiccproece':
            case 'ebcdiccpyu':
            case 'ibm870':
                return 'IBM870';
            case 'cp871':
            case 'csibm871':
            case 'ebcdiccpis':
            case 'ibm871':
                return 'IBM871';
            case 'cp880':
            case 'csibm880':
            case 'ebcdiccyrillic':
            case 'ibm880':
                return 'IBM880';
            case 'cp891':
            case 'csibm891':
            case 'ibm891':
                return 'IBM891';
            case 'cp903':
            case 'csibm903':
            case 'ibm903':
                return 'IBM903';
            case '904':
            case 'cp904':
            case 'csibbm904':
            case 'ibm904':
                return 'IBM904';
            case 'cp905':
            case 'csibm905':
            case 'ebcdiccptr':
            case 'ibm905':
                return 'IBM905';
            case 'cp918':
            case 'csibm918':
            case 'ebcdiccpar2':
            case 'ibm918':
                return 'IBM918';
            case 'ccsid924':
            case 'cp924':
            case 'ebcdiclatin9euro':
            case 'ibm924':
                return 'IBM00924';
            case 'cp1026':
            case 'csibm1026':
            case 'ibm1026':
                return 'IBM1026';
            case 'ibm1047':
                return 'IBM1047';
            case 'ccsid1140':
            case 'cp1140':
            case 'ebcdicus37euro':
            case 'ibm1140':
                return 'IBM01140';
            case 'ccsid1141':
            case 'cp1141':
            case 'ebcdicde273euro':
            case 'ibm1141':
                return 'IBM01141';
            case 'ccsid1142':
            case 'cp1142':
            case 'ebcdicdk277euro':
            case 'ebcdicno277euro':
            case 'ibm1142':
                return 'IBM01142';
            case 'ccsid1143':
            case 'cp1143':
            case 'ebcdicfi278euro':
            case 'ebcdicse278euro':
            case 'ibm1143':
                return 'IBM01143';
            case 'ccsid1144':
            case 'cp1144':
            case 'ebcdicit280euro':
            case 'ibm1144':
                return 'IBM01144';
            case 'ccsid1145':
            case 'cp1145':
            case 'ebcdices284euro':
            case 'ibm1145':
                return 'IBM01145';
            case 'ccsid1146':
            case 'cp1146':
            case 'ebcdicgb285euro':
            case 'ibm1146':
                return 'IBM01146';
            case 'ccsid1147':
            case 'cp1147':
            case 'ebcdicfr297euro':
            case 'ibm1147':
                return 'IBM01147';
            case 'ccsid1148':
            case 'cp1148':
            case 'ebcdicinternational500euro':
            case 'ibm1148':
                return 'IBM01148';
            case 'ccsid1149':
            case 'cp1149':
            case 'ebcdicis871euro':
            case 'ibm1149':
                return 'IBM01149';
            case 'csiso143iecp271':
            case 'iecp271':
            case 'isoir143':
                return 'IEC_P27-1';
            case 'csiso49inis':
            case 'inis':
            case 'isoir49':
                return 'INIS';
            case 'csiso50inis8':
            case 'inis8':
            case 'isoir50':
                return 'INIS-8';
            case 'csiso51iniscyrillic':
            case 'iniscyrillic':
            case 'isoir51':
                return 'INIS-cyrillic';
            case 'csinvariant':
            case 'invariant':
                return 'INVARIANT';
            case 'iso2022cn':
                return 'ISO-2022-CN';
            case 'iso2022cnext':
                return 'ISO-2022-CN-EXT';
            case 'csiso2022jp':
            case 'iso2022jp':
                return 'ISO-2022-JP';
            case 'csiso2022jp2':
            case 'iso2022jp2':
                return 'ISO-2022-JP-2';
            case 'csiso2022kr':
            case 'iso2022kr':
                return 'ISO-2022-KR';
            case 'cswindows30latin1':
            case 'iso88591windows30latin1':
                return 'ISO-8859-1-Windows-3.0-Latin-1';
            case 'cswindows31latin1':
            case 'iso88591windows31latin1':
                return 'ISO-8859-1-Windows-3.1-Latin-1';
            case 'csisolatin2':
            case 'iso88592':
            case 'iso885921987':
            case 'isoir101':
            case 'l2':
            case 'latin2':
                return 'ISO-8859-2';
            case 'cswindows31latin2':
            case 'iso88592windowslatin2':
                return 'ISO-8859-2-Windows-Latin-2';
            case 'csisolatin3':
            case 'iso88593':
            case 'iso885931988':
            case 'isoir109':
            case 'l3':
            case 'latin3':
                return 'ISO-8859-3';
            case 'csisolatin4':
            case 'iso88594':
            case 'iso885941988':
            case 'isoir110':
            case 'l4':
            case 'latin4':
                return 'ISO-8859-4';
            case 'csisolatincyrillic':
            case 'cyrillic':
            case 'iso88595':
            case 'iso885951988':
            case 'isoir144':
                return 'ISO-8859-5';
            case 'arabic':
            case 'asmo708':
            case 'csisolatinarabic':
            case 'ecma114':
            case 'iso88596':
            case 'iso885961987':
            case 'isoir127':
                return 'ISO-8859-6';
            case 'csiso88596e':
            case 'iso88596e':
                return 'ISO-8859-6-E';
            case 'csiso88596i':
            case 'iso88596i':
                return 'ISO-8859-6-I';
            case 'csisolatingreek':
            case 'ecma118':
            case 'elot928':
            case 'greek':
            case 'greek8':
            case 'iso88597':
            case 'iso885971987':
            case 'isoir126':
                return 'ISO-8859-7';
            case 'csisolatinhebrew':
            case 'hebrew':
            case 'iso88598':
            case 'iso885981988':
            case 'isoir138':
                return 'ISO-8859-8';
            case 'csiso88598e':
            case 'iso88598e':
                return 'ISO-8859-8-E';
            case 'csiso88598i':
            case 'iso88598i':
                return 'ISO-8859-8-I';
            case 'cswindows31latin5':
            case 'iso88599windowslatin5':
                return 'ISO-8859-9-Windows-Latin-5';
            case 'csisolatin6':
            case 'iso885910':
            case 'iso8859101992':
            case 'isoir157':
            case 'l6':
            case 'latin6':
                return 'ISO-8859-10';
            case 'iso885913':
                return 'ISO-8859-13';
            case 'iso885914':
            case 'iso8859141998':
            case 'isoceltic':
            case 'isoir199':
            case 'l8':
            case 'latin8':
                return 'ISO-8859-14';
            case 'iso885915':
            case 'latin9':
                return 'ISO-8859-15';
            case 'iso885916':
            case 'iso8859162001':
            case 'isoir226':
            case 'l10':
            case 'latin10':
                return 'ISO-8859-16';
            case 'iso10646j1':
                return 'ISO-10646-J-1';
            case 'csunicode':
            case 'iso10646ucs2':
                return 'ISO-10646-UCS-2';
            case 'csucs4':
            case 'iso10646ucs4':
                return 'ISO-10646-UCS-4';
            case 'csunicodeascii':
            case 'iso10646ucsbasic':
                return 'ISO-10646-UCS-Basic';
            case 'csunicodelatin1':
            case 'iso10646':
            case 'iso10646unicodelatin1':
                return 'ISO-10646-Unicode-Latin1';
            case 'csiso10646utf1':
            case 'iso10646utf1':
                return 'ISO-10646-UTF-1';
            case 'csiso115481':
            case 'iso115481':
            case 'isotr115481':
                return 'ISO-11548-1';
            case 'csiso90':
            case 'isoir90':
                return 'iso-ir-90';
            case 'csunicodeibm1261':
            case 'isounicodeibm1261':
                return 'ISO-Unicode-IBM-1261';
            case 'csunicodeibm1264':
            case 'isounicodeibm1264':
                return 'ISO-Unicode-IBM-1264';
            case 'csunicodeibm1265':
            case 'isounicodeibm1265':
                return 'ISO-Unicode-IBM-1265';
            case 'csunicodeibm1268':
            case 'isounicodeibm1268':
                return 'ISO-Unicode-IBM-1268';
            case 'csunicodeibm1276':
            case 'isounicodeibm1276':
                return 'ISO-Unicode-IBM-1276';
            case 'csiso646basic1983':
            case 'iso646basic1983':
            case 'ref':
                return 'ISO_646.basic:1983';
            case 'csiso2intlrefversion':
            case 'irv':
            case 'iso646irv1983':
            case 'isoir2':
                return 'ISO_646.irv:1983';
            case 'csiso2033':
            case 'e13b':
            case 'iso20331983':
            case 'isoir98':
                return 'ISO_2033-1983';
            case 'csiso5427cyrillic':
            case 'iso5427':
            case 'isoir37':
                return 'ISO_5427';
            case 'iso5427cyrillic1981':
            case 'iso54271981':
            case 'isoir54':
                return 'ISO_5427:1981';
            case 'csiso5428greek':
            case 'iso54281980':
            case 'isoir55':
                return 'ISO_5428:1980';
            case 'csiso6937add':
            case 'iso6937225':
            case 'isoir152':
                return 'ISO_6937-2-25';
            case 'csisotextcomm':
            case 'iso69372add':
            case 'isoir142':
                return 'ISO_6937-2-add';
            case 'csiso8859supp':
            case 'iso8859supp':
            case 'isoir154':
            case 'latin125':
                return 'ISO_8859-supp';
            case 'csiso10367box':
            case 'iso10367box':
            case 'isoir155':
                return 'ISO_10367-box';
            case 'csiso15italian':
            case 'iso646it':
            case 'isoir15':
            case 'it':
                return 'IT';
            case 'csiso13jisc6220jp':
            case 'isoir13':
            case 'jisc62201969':
            case 'jisc62201969jp':
            case 'katakana':
            case 'x2017':
                return 'JIS_C6220-1969-jp';
            case 'csiso14jisc6220ro':
            case 'iso646jp':
            case 'isoir14':
            case 'jisc62201969ro':
            case 'jp':
                return 'JIS_C6220-1969-ro';
            case 'csiso42jisc62261978':
            case 'isoir42':
            case 'jisc62261978':
                return 'JIS_C6226-1978';
            case 'csiso87jisx208':
            case 'isoir87':
            case 'jisc62261983':
            case 'jisx2081983':
            case 'x208':
                return 'JIS_C6226-1983';
            case 'csiso91jisc62291984a':
            case 'isoir91':
            case 'jisc62291984a':
            case 'jpocra':
                return 'JIS_C6229-1984-a';
            case 'csiso92jisc62991984b':
            case 'iso646jpocrb':
            case 'isoir92':
            case 'jisc62291984b':
            case 'jpocrb':
                return 'JIS_C6229-1984-b';
            case 'csiso93jis62291984badd':
            case 'isoir93':
            case 'jisc62291984badd':
            case 'jpocrbadd':
                return 'JIS_C6229-1984-b-add';
            case 'csiso94jis62291984hand':
            case 'isoir94':
            case 'jisc62291984hand':
            case 'jpocrhand':
                return 'JIS_C6229-1984-hand';
            case 'csiso95jis62291984handadd':
            case 'isoir95':
            case 'jisc62291984handadd':
            case 'jpocrhandadd':
                return 'JIS_C6229-1984-hand-add';
            case 'csiso96jisc62291984kana':
            case 'isoir96':
            case 'jisc62291984kana':
                return 'JIS_C6229-1984-kana';
            case 'csjisencoding':
            case 'jisencoding':
                return 'JIS_Encoding';
            case 'cshalfwidthkatakana':
            case 'jisx201':
            case 'x201':
                return 'JIS_X0201';
            case 'csiso159jisx2121990':
            case 'isoir159':
            case 'jisx2121990':
            case 'x212':
                return 'JIS_X0212-1990';
            case 'csiso141jusib1002':
            case 'iso646yu':
            case 'isoir141':
            case 'js':
            case 'jusib1002':
            case 'yu':
                return 'JUS_I.B1.002';
            case 'csiso147macedonian':
            case 'isoir147':
            case 'jusib1003mac':
            case 'macedonian':
                return 'JUS_I.B1.003-mac';
            case 'csiso146serbian':
            case 'isoir146':
            case 'jusib1003serb':
            case 'serbian':
                return 'JUS_I.B1.003-serb';
            case 'koi7switched':
                return 'KOI7-switched';
            case 'cskoi8r':
            case 'koi8r':
                return 'KOI8-R';
            case 'koi8u':
                return 'KOI8-U';
            case 'csksc5636':
            case 'iso646kr':
            case 'ksc5636':
                return 'KSC5636';
            case 'cskz1048':
            case 'kz1048':
            case 'rk1048':
            case 'strk10482002':
                return 'KZ-1048';
            case 'csiso19latingreek':
            case 'isoir19':
            case 'latingreek':
                return 'latin-greek';
            case 'csiso27latingreek1':
            case 'isoir27':
            case 'latingreek1':
                return 'Latin-greek-1';
            case 'csiso158lap':
            case 'isoir158':
            case 'lap':
            case 'latinlap':
                return 'latin-lap';
            case 'csmacintosh':
            case 'mac':
            case 'macintosh':
                return 'macintosh';
            case 'csmicrosoftpublishing':
            case 'microsoftpublishing':
                return 'Microsoft-Publishing';
            case 'csmnem':
            case 'mnem':
                return 'MNEM';
            case 'csmnemonic':
            case 'mnemonic':
                return 'MNEMONIC';
            case 'csiso86hungarian':
            case 'hu':
            case 'iso646hu':
            case 'isoir86':
            case 'msz77953':
                return 'MSZ_7795.3';
            case 'csnatsdano':
            case 'isoir91':
            case 'natsdano':
                return 'NATS-DANO';
            case 'csnatsdanoadd':
            case 'isoir92':
            case 'natsdanoadd':
                return 'NATS-DANO-ADD';
            case 'csnatssefi':
            case 'isoir81':
            case 'natssefi':
                return 'NATS-SEFI';
            case 'csnatssefiadd':
            case 'isoir82':
            case 'natssefiadd':
                return 'NATS-SEFI-ADD';
            case 'csiso151cuba':
            case 'cuba':
            case 'iso646cu':
            case 'isoir151':
            case 'ncnc1081':
                return 'NC_NC00-10:81';
            case 'csiso69french':
            case 'fr':
            case 'iso646fr':
            case 'isoir69':
            case 'nfz62010':
                return 'NF_Z_62-010';
            case 'csiso25french':
            case 'iso646fr1':
            case 'isoir25':
            case 'nfz620101973':
                return 'NF_Z_62-010_(1973)';
            case 'csiso60danishnorwegian':
            case 'csiso60norwegian1':
            case 'iso646no':
            case 'isoir60':
            case 'no':
            case 'ns45511':
                return 'NS_4551-1';
            case 'csiso61norwegian2':
            case 'iso646no2':
            case 'isoir61':
            case 'no2':
            case 'ns45512':
                return 'NS_4551-2';
            case 'osdebcdicdf3irv':
                return 'OSD_EBCDIC_DF03_IRV';
            case 'osdebcdicdf41':
                return 'OSD_EBCDIC_DF04_1';
            case 'osdebcdicdf415':
                return 'OSD_EBCDIC_DF04_15';
            case 'cspc8danishnorwegian':
            case 'pc8danishnorwegian':
                return 'PC8-Danish-Norwegian';
            case 'cspc8turkish':
            case 'pc8turkish':
                return 'PC8-Turkish';
            case 'csiso16portuguese':
            case 'iso646pt':
            case 'isoir16':
            case 'pt':
                return 'PT';
            case 'csiso84portuguese2':
            case 'iso646pt2':
            case 'isoir84':
            case 'pt2':
                return 'PT2';
            case 'cp154':
            case 'csptcp154':
            case 'cyrillicasian':
            case 'pt154':
            case 'ptcp154':
                return 'PTCP154';
            case 'scsu':
                return 'SCSU';
            case 'csiso10swedish':
            case 'fi':
            case 'iso646fi':
            case 'iso646se':
            case 'isoir10':
            case 'se':
            case 'sen850200b':
                return 'SEN_850200_B';
            case 'csiso11swedishfornames':
            case 'iso646se2':
            case 'isoir11':
            case 'se2':
            case 'sen850200c':
                return 'SEN_850200_C';
            case 'csiso102t617bit':
            case 'isoir102':
            case 't617bit':
                return 'T.61-7bit';
            case 'csiso103t618bit':
            case 'isoir103':
            case 't61':
            case 't618bit':
                return 'T.61-8bit';
            case 'csiso128t101g2':
            case 'isoir128':
            case 't101g2':
                return 'T.101-G2';
            case 'cstscii':
            case 'tscii':
                return 'TSCII';
            case 'csunicode11':
            case 'unicode11':
                return 'UNICODE-1-1';
            case 'csunicode11utf7':
            case 'unicode11utf7':
                return 'UNICODE-1-1-UTF-7';
            case 'csunknown8bit':
            case 'unknown8bit':
                return 'UNKNOWN-8BIT';
            case 'ansix341968':
            case 'ansix341986':
            case 'ascii':
            case 'cp367':
            case 'csascii':
            case 'ibm367':
            case 'iso646irv1991':
            case 'iso646us':
            case 'isoir6':
            case 'us':
            case 'usascii':
                return 'US-ASCII';
            case 'csusdk':
            case 'usdk':
                return 'us-dk';
            case 'utf7':
                return 'UTF-7';
            case 'utf8':
                return 'UTF-8';
            case 'utf16':
                return 'UTF-16';
            case 'utf16be':
                return 'UTF-16BE';
            case 'utf16le':
                return 'UTF-16LE';
            case 'utf32':
                return 'UTF-32';
            case 'utf32be':
                return 'UTF-32BE';
            case 'utf32le':
                return 'UTF-32LE';
            case 'csventurainternational':
            case 'venturainternational':
                return 'Ventura-International';
            case 'csventuramath':
            case 'venturamath':
                return 'Ventura-Math';
            case 'csventuraus':
            case 'venturaus':
                return 'Ventura-US';
            case 'csiso70videotexsupp1':
            case 'isoir70':
            case 'videotexsuppl':
                return 'videotex-suppl';
            case 'csviqr':
            case 'viqr':
                return 'VIQR';
            case 'csviscii':
            case 'viscii':
                return 'VISCII';
            case 'csshiftjis':
            case 'cswindows31j':
            case 'mskanji':
            case 'shiftjis':
            case 'windows31j':
                return 'Windows-31J';
            case 'iso885911':
            case 'tis620':
                return 'windows-874';
            case 'cseuckr':
            case 'csksc56011987':
            case 'euckr':
            case 'isoir149':
            case 'korean':
            case 'ksc5601':
            case 'ksc56011987':
            case 'ksc56011989':
            case 'windows949':
                return 'windows-949';
            case 'windows1250':
                return 'windows-1250';
            case 'windows1251':
                return 'windows-1251';
            case 'cp819':
            case 'csisolatin1':
            case 'ibm819':
            case 'iso88591':
            case 'iso885911987':
            case 'isoir100':
            case 'l1':
            case 'latin1':
            case 'windows1252':
                return 'windows-1252';
            case 'windows1253':
                return 'windows-1253';
            case 'csisolatin5':
            case 'iso88599':
            case 'iso885991989':
            case 'isoir148':
            case 'l5':
            case 'latin5':
            case 'windows1254':
                return 'windows-1254';
            case 'windows1255':
                return 'windows-1255';
            case 'windows1256':
                return 'windows-1256';
            case 'windows1257':
                return 'windows-1257';
            case 'windows1258':
                return 'windows-1258';
            default:
                return $charset;
        }
    }
    public static function get_curl_version()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_curl_version") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1382")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_curl_version:1382@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Strip HTML comments
     *
     * @param string $data Data to strip comments from
     * @return string Comment stripped string
     */
    public static function strip_comments($data)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("strip_comments") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1401")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called strip_comments:1401@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function parse_date($dt)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse_date") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1414")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parse_date:1414@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Decode HTML entities
     *
     * @deprecated Use DOMDocument instead
     * @param string $data Input data
     * @return string Output data
     */
    public static function entities_decode($data)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("entities_decode") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1426")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called entities_decode:1426@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Remove RFC822 comments
     *
     * @param string $data Data to strip comments from
     * @return string Comment stripped string
     */
    public static function uncomment_rfc822($string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("uncomment_rfc822") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1437")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called uncomment_rfc822:1437@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function parse_mime($mime)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse_mime") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1475")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parse_mime:1475@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function atom_03_construct_type($attribs)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("atom_03_construct_type") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1482")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called atom_03_construct_type:1482@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function atom_10_construct_type($attribs)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("atom_10_construct_type") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1506")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called atom_10_construct_type:1506@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function atom_10_content_construct_type($attribs)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("atom_10_content_construct_type") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1522")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called atom_10_content_construct_type:1522@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function is_isegment_nz_nc($string)
    {
        return (bool) preg_match('/^([A-Za-z0-9\\-._~\\x{A0}-\\x{D7FF}\\x{F900}-\\x{FDCF}\\x{FDF0}-\\x{FFEF}\\x{10000}-\\x{1FFFD}\\x{20000}-\\x{2FFFD}\\x{30000}-\\x{3FFFD}\\x{40000}-\\x{4FFFD}\\x{50000}-\\x{5FFFD}\\x{60000}-\\x{6FFFD}\\x{70000}-\\x{7FFFD}\\x{80000}-\\x{8FFFD}\\x{90000}-\\x{9FFFD}\\x{A0000}-\\x{AFFFD}\\x{B0000}-\\x{BFFFD}\\x{C0000}-\\x{CFFFD}\\x{D0000}-\\x{DFFFD}\\x{E1000}-\\x{EFFFD}!$&\'()*+,;=@]|(%[0-9ABCDEF]{2}))+$/u', $string);
    }
    public static function space_separated_tokens($string)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("space_separated_tokens") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1546")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called space_separated_tokens:1546@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Converts a unicode codepoint to a UTF-8 character
     *
     * @static
     * @param int $codepoint Unicode codepoint
     * @return string UTF-8 character
     */
    public static function codepoint_to_utf8($codepoint)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("codepoint_to_utf8") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1567")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called codepoint_to_utf8:1567@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Similar to parse_str()
     *
     * Returns an associative array of name/value pairs, where the value is an
     * array of values that have used the same name
     *
     * @static
     * @param string $str The input string.
     * @return array
     */
    public static function parse_str($str)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse_str") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1602")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parse_str:1602@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Detect XML encoding, as per XML 1.0 Appendix F.1
     *
     * @todo Add support for EBCDIC
     * @param string $data XML data
     * @param SimplePie_Registry $registry Class registry
     * @return array Possible encodings
     */
    public static function xml_encoding($data, $registry)
    {
        // UTF-32 Big Endian BOM
        if (substr($data, 0, 4) === "\x00\x00\xfe\xff") {
            $encoding[] = 'UTF-32BE';
        } elseif (substr($data, 0, 4) === "\xff\xfe\x00\x00") {
            $encoding[] = 'UTF-32LE';
        } elseif (substr($data, 0, 2) === "\xfe\xff") {
            $encoding[] = 'UTF-16BE';
        } elseif (substr($data, 0, 2) === "\xff\xfe") {
            $encoding[] = 'UTF-16LE';
        } elseif (substr($data, 0, 3) === "﻿") {
            $encoding[] = 'UTF-8';
        } elseif (substr($data, 0, 20) === "\x00\x00\x00<\x00\x00\x00?\x00\x00\x00x\x00\x00\x00m\x00\x00\x00l") {
            if ($pos = strpos($data, "\x00\x00\x00?\x00\x00\x00>")) {
                $parser = $registry->create('XML_Declaration_Parser', array(SimplePie_Misc::change_encoding(substr($data, 20, $pos - 20), 'UTF-32BE', 'UTF-8')));
                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }
            $encoding[] = 'UTF-32BE';
        } elseif (substr($data, 0, 20) === "<\x00\x00\x00?\x00\x00\x00x\x00\x00\x00m\x00\x00\x00l\x00\x00\x00") {
            if ($pos = strpos($data, "?\x00\x00\x00>\x00\x00\x00")) {
                $parser = $registry->create('XML_Declaration_Parser', array(SimplePie_Misc::change_encoding(substr($data, 20, $pos - 20), 'UTF-32LE', 'UTF-8')));
                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }
            $encoding[] = 'UTF-32LE';
        } elseif (substr($data, 0, 10) === "\x00<\x00?\x00x\x00m\x00l") {
            if ($pos = strpos($data, "\x00?\x00>")) {
                $parser = $registry->create('XML_Declaration_Parser', array(SimplePie_Misc::change_encoding(substr($data, 20, $pos - 10), 'UTF-16BE', 'UTF-8')));
                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }
            $encoding[] = 'UTF-16BE';
        } elseif (substr($data, 0, 10) === "<\x00?\x00x\x00m\x00l\x00") {
            if ($pos = strpos($data, "?\x00>\x00")) {
                $parser = $registry->create('XML_Declaration_Parser', array(SimplePie_Misc::change_encoding(substr($data, 20, $pos - 10), 'UTF-16LE', 'UTF-8')));
                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }
            $encoding[] = 'UTF-16LE';
        } elseif (substr($data, 0, 5) === "<?xml") {
            if ($pos = strpos($data, "?>")) {
                $parser = $registry->create('XML_Declaration_Parser', array(substr($data, 5, $pos - 5)));
                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }
            $encoding[] = 'UTF-8';
        } else {
            $encoding[] = 'UTF-8';
        }
        return $encoding;
    }
    public static function output_javascript()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("output_javascript") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1682")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called output_javascript:1682@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    /**
     * Get the SimplePie build timestamp
     *
     * Uses the git index if it exists, otherwise uses the modification time
     * of the newest file.
     */
    public static function get_build()
    {
        $root = dirname(dirname(__FILE__));
        if (file_exists($root . '/.git/index')) {
            return filemtime($root . '/.git/index');
        } elseif (file_exists($root . '/SimplePie')) {
            $time = 0;
            foreach (glob($root . '/SimplePie/*.php') as $file) {
                if (($mtime = filemtime($file)) > $time) {
                    $time = $mtime;
                }
            }
            return $time;
        } elseif (file_exists(dirname(__FILE__) . '/Core.php')) {
            return filemtime(dirname(__FILE__) . '/Core.php');
        }
        return filemtime(__FILE__);
    }
    /**
     * Format debugging information
     */
    public static function debug(&$sp)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("debug") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php at line 1741")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called debug:1741@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Misc.php');
        die();
    }
    public static function silence_errors($num, $str)
    {
        // No-op
    }
}