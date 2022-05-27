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
 * IRI parser/serialiser/normaliser
 *
 * @package SimplePie
 * @subpackage HTTP
 * @author Sam Sneddon
 * @author Steve Minutillo
 * @author Ryan McCue
 * @copyright 2007-2012 Sam Sneddon, Steve Minutillo, Ryan McCue
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
class SimplePie_IRI
{
    /**
     * Scheme
     *
     * @var string
     */
    protected $scheme = null;
    /**
     * User Information
     *
     * @var string
     */
    protected $iuserinfo = null;
    /**
     * ihost
     *
     * @var string
     */
    protected $ihost = null;
    /**
     * Port
     *
     * @var string
     */
    protected $port = null;
    /**
     * ipath
     *
     * @var string
     */
    protected $ipath = '';
    /**
     * iquery
     *
     * @var string
     */
    protected $iquery = null;
    /**
     * ifragment
     *
     * @var string
     */
    protected $ifragment = null;
    /**
     * Normalization database
     *
     * Each key is the scheme, each value is an array with each key as the IRI
     * part and value as the default value for that part.
     */
    protected $normalization = array('acap' => array('port' => 674), 'dict' => array('port' => 2628), 'file' => array('ihost' => 'localhost'), 'http' => array('port' => 80, 'ipath' => '/'), 'https' => array('port' => 443, 'ipath' => '/'));
    /**
     * Return the entire IRI when you try and read the object as a string
     *
     * @return string
     */
    public function __toString()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__toString") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php at line 113")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __toString:113@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php');
        die();
    }
    /**
     * Overload __set() to provide access via properties
     *
     * @param string $name Property name
     * @param mixed $value Property value
     */
    public function __set($name, $value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__set") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php at line 123")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __set:123@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php');
        die();
    }
    /**
     * Overload __get() to provide access via properties
     *
     * @param string $name Property name
     * @return mixed
     */
    public function __get($name)
    {
        // isset() returns false for null, we don't want to do that
        // Also why we use array_key_exists below instead of isset()
        $props = get_object_vars($this);
        if ($name === 'iri' || $name === 'uri' || $name === 'iauthority' || $name === 'authority') {
            $return = $this->{"get_{$name}"}();
        } elseif (array_key_exists($name, $props)) {
            $return = $this->{$name};
        } elseif (($prop = 'i' . $name) && array_key_exists($prop, $props)) {
            $name = $prop;
            $return = $this->{$prop};
        } elseif (($prop = substr($name, 1)) && array_key_exists($prop, $props)) {
            $name = $prop;
            $return = $this->{$prop};
        } else {
            trigger_error('Undefined property: ' . get_class($this) . '::' . $name, E_USER_NOTICE);
            $return = null;
        }
        if ($return === null && isset($this->normalization[$this->scheme][$name])) {
            return $this->normalization[$this->scheme][$name];
        }
        return $return;
    }
    /**
     * Overload __isset() to provide access via properties
     *
     * @param string $name Property name
     * @return bool
     */
    public function __isset($name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__isset") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php at line 167")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __isset:167@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php');
        die();
    }
    /**
     * Overload __unset() to provide access via properties
     *
     * @param string $name Property name
     */
    public function __unset($name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__unset") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php at line 176")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __unset:176@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php');
        die();
    }
    /**
     * Create a new IRI object, from a specified string
     *
     * @param string $iri
     */
    public function __construct($iri = null)
    {
        $this->set_iri($iri);
    }
    /**
     * Clean up
     */
    public function __destruct()
    {
        $stop_coverage = false;
        if (function_exists('end_coverage_cav39s8hca')) {
            $stop_coverage = !xdebug_code_coverage_started();
            if (!xdebug_code_coverage_started()) {
                xdebug_start_code_coverage();
            }
        }
        $this->set_iri(null, true);
        $this->set_path(null, true);
        $this->set_authority(null, true);
        if (function_exists('end_coverage_cav39s8hca')) {
            if ($stop_coverage) {
                end_coverage_cav39s8hca($stop_coverage);
            }
        }
    }
    /**
     * Create a new IRI object by resolving a relative IRI
     *
     * Returns false if $base is not absolute, otherwise an IRI.
     *
     * @param IRI|string $base (Absolute) Base IRI
     * @param IRI|string $relative Relative IRI
     * @return IRI|false
     */
    public static function absolutize($base, $relative)
    {
        if (!$relative instanceof SimplePie_IRI) {
            $relative = new SimplePie_IRI($relative);
        }
        if (!$relative->is_valid()) {
            return false;
        } elseif ($relative->scheme !== null) {
            return clone $relative;
        } else {
            if (!$base instanceof SimplePie_IRI) {
                $base = new SimplePie_IRI($base);
            }
            if ($base->scheme !== null && $base->is_valid()) {
                if ($relative->get_iri() !== '') {
                    if ($relative->iuserinfo !== null || $relative->ihost !== null || $relative->port !== null) {
                        $target = clone $relative;
                        $target->scheme = $base->scheme;
                    } else {
                        $target = new SimplePie_IRI();
                        $target->scheme = $base->scheme;
                        $target->iuserinfo = $base->iuserinfo;
                        $target->ihost = $base->ihost;
                        $target->port = $base->port;
                        if ($relative->ipath !== '') {
                            if ($relative->ipath[0] === '/') {
                                $target->ipath = $relative->ipath;
                            } elseif (($base->iuserinfo !== null || $base->ihost !== null || $base->port !== null) && $base->ipath === '') {
                                $target->ipath = '/' . $relative->ipath;
                            } elseif (($last_segment = strrpos($base->ipath, '/')) !== false) {
                                $target->ipath = substr($base->ipath, 0, $last_segment + 1) . $relative->ipath;
                            } else {
                                $target->ipath = $relative->ipath;
                            }
                            $target->ipath = $target->remove_dot_segments($target->ipath);
                            $target->iquery = $relative->iquery;
                        } else {
                            $target->ipath = $base->ipath;
                            if ($relative->iquery !== null) {
                                $target->iquery = $relative->iquery;
                            } elseif ($base->iquery !== null) {
                                $target->iquery = $base->iquery;
                            }
                        }
                        $target->ifragment = $relative->ifragment;
                    }
                } else {
                    $target = clone $base;
                    $target->ifragment = null;
                }
                $target->scheme_normalization();
                return $target;
            }
            return false;
        }
    }
    /**
     * Parse an IRI into scheme/authority/path/query/fragment segments
     *
     * @param string $iri
     * @return array
     */
    protected function parse_iri($iri)
    {
        $iri = trim($iri, " \t\n\f\r");
        if (preg_match('/^((?P<scheme>[^:\\/?#]+):)?(\\/\\/(?P<authority>[^\\/?#]*))?(?P<path>[^?#]*)(\\?(?P<query>[^#]*))?(#(?P<fragment>.*))?$/', $iri, $match)) {
            if ($match[1] === '') {
                $match['scheme'] = null;
            }
            if (!isset($match[3]) || $match[3] === '') {
                $match['authority'] = null;
            }
            if (!isset($match[5])) {
                $match['path'] = '';
            }
            if (!isset($match[6]) || $match[6] === '') {
                $match['query'] = null;
            }
            if (!isset($match[8]) || $match[8] === '') {
                $match['fragment'] = null;
            }
            return $match;
        }
        // This can occur when a paragraph is accidentally parsed as a URI
        return false;
    }
    /**
     * Remove dot segments from a path
     *
     * @param string $input
     * @return string
     */
    protected function remove_dot_segments($input)
    {
        $output = '';
        while (strpos($input, './') !== false || strpos($input, '/.') !== false || $input === '.' || $input === '..') {
            // A: If the input buffer begins with a prefix of "../" or "./", then remove that prefix from the input buffer; otherwise,
            if (strpos($input, '../') === 0) {
                $input = substr($input, 3);
            } elseif (strpos($input, './') === 0) {
                $input = substr($input, 2);
            } elseif (strpos($input, '/./') === 0) {
                $input = substr($input, 2);
            } elseif ($input === '/.') {
                $input = '/';
            } elseif (strpos($input, '/../') === 0) {
                $input = substr($input, 3);
                $output = substr_replace($output, '', strrpos($output, '/'));
            } elseif ($input === '/..') {
                $input = '/';
                $output = substr_replace($output, '', strrpos($output, '/'));
            } elseif ($input === '.' || $input === '..') {
                $input = '';
            } elseif (($pos = strpos($input, '/', 1)) !== false) {
                $output .= substr($input, 0, $pos);
                $input = substr_replace($input, '', 0, $pos);
            } else {
                $output .= $input;
                $input = '';
            }
        }
        return $output . $input;
    }
    /**
     * Replace invalid character with percent encoding
     *
     * @param string $string Input string
     * @param string $extra_chars Valid characters not in iunreserved or
     *                            iprivate (this is ASCII-only)
     * @param bool $iprivate Allow iprivate
     * @return string
     */
    protected function replace_invalid_with_pct_encoding($string, $extra_chars, $iprivate = false)
    {
        // Normalize as many pct-encoded sections as possible
        $string = preg_replace_callback('/(?:%[A-Fa-f0-9]{2})+/', array($this, 'remove_iunreserved_percent_encoded'), $string);
        // Replace invalid percent characters
        $string = preg_replace('/%(?![A-Fa-f0-9]{2})/', '%25', $string);
        // Add unreserved and % to $extra_chars (the latter is safe because all
        // pct-encoded sections are now valid).
        $extra_chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~%';
        // Now replace any bytes that aren't allowed with their pct-encoded versions
        $position = 0;
        $strlen = strlen($string);
        while (($position += strspn($string, $extra_chars, $position)) < $strlen) {
            $value = ord($string[$position]);
            // Start position
            $start = $position;
            // By default we are valid
            $valid = true;
            // No one byte sequences are valid due to the while.
            // Two byte sequence:
            if (($value & 0xe0) === 0xc0) {
                $character = ($value & 0x1f) << 6;
                $length = 2;
                $remaining = 1;
            } elseif (($value & 0xf0) === 0xe0) {
                $character = ($value & 0xf) << 12;
                $length = 3;
                $remaining = 2;
            } elseif (($value & 0xf8) === 0xf0) {
                $character = ($value & 0x7) << 18;
                $length = 4;
                $remaining = 3;
            } else {
                $valid = false;
                $length = 1;
                $remaining = 0;
            }
            if ($remaining) {
                if ($position + $length <= $strlen) {
                    for ($position++; $remaining; $position++) {
                        $value = ord($string[$position]);
                        // Check that the byte is valid, then add it to the character:
                        if (($value & 0xc0) === 0x80) {
                            $character |= ($value & 0x3f) << --$remaining * 6;
                        } else {
                            $valid = false;
                            $position--;
                            break;
                        }
                    }
                } else {
                    $position = $strlen - 1;
                    $valid = false;
                }
            }
            // Percent encode anything invalid or not in ucschar
            if (!$valid || $length > 1 && $character <= 0x7f || $length > 2 && $character <= 0x7ff || $length > 3 && $character <= 0xffff || ($character & 0xfffe) === 0xfffe || $character >= 0xfdd0 && $character <= 0xfdef || ($character > 0xd7ff && $character < 0xf900 || $character < 0xa0 || $character > 0xefffd) && (!$iprivate || $character < 0xe000 || $character > 0x10fffd)) {
                // If we were a character, pretend we weren't, but rather an error.
                if ($valid) {
                    $position--;
                }
                for ($j = $start; $j <= $position; $j++) {
                    $string = substr_replace($string, sprintf('%%%02X', ord($string[$j])), $j, 1);
                    $j += 2;
                    $position += 2;
                    $strlen += 2;
                }
            }
        }
        return $string;
    }
    /**
     * Callback function for preg_replace_callback.
     *
     * Removes sequences of percent encoded bytes that represent UTF-8
     * encoded characters in iunreserved
     *
     * @param array $match PCRE match
     * @return string Replacement
     */
    protected function remove_iunreserved_percent_encoded($match)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove_iunreserved_percent_encoded") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php at line 435")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove_iunreserved_percent_encoded:435@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/IRI.php');
        die();
    }
    protected function scheme_normalization()
    {
        if (isset($this->normalization[$this->scheme]['iuserinfo']) && $this->iuserinfo === $this->normalization[$this->scheme]['iuserinfo']) {
            $this->iuserinfo = null;
        }
        if (isset($this->normalization[$this->scheme]['ihost']) && $this->ihost === $this->normalization[$this->scheme]['ihost']) {
            $this->ihost = null;
        }
        if (isset($this->normalization[$this->scheme]['port']) && $this->port === $this->normalization[$this->scheme]['port']) {
            $this->port = null;
        }
        if (isset($this->normalization[$this->scheme]['ipath']) && $this->ipath === $this->normalization[$this->scheme]['ipath']) {
            $this->ipath = '';
        }
        if (isset($this->normalization[$this->scheme]['iquery']) && $this->iquery === $this->normalization[$this->scheme]['iquery']) {
            $this->iquery = null;
        }
        if (isset($this->normalization[$this->scheme]['ifragment']) && $this->ifragment === $this->normalization[$this->scheme]['ifragment']) {
            $this->ifragment = null;
        }
    }
    /**
     * Check if the object represents a valid IRI. This needs to be done on each
     * call as some things change depending on another part of the IRI.
     *
     * @return bool
     */
    public function is_valid()
    {
        if ($this->ipath === '') {
            return true;
        }
        $isauthority = $this->iuserinfo !== null || $this->ihost !== null || $this->port !== null;
        if ($isauthority && $this->ipath[0] === '/') {
            return true;
        }
        if (!$isauthority && substr($this->ipath, 0, 2) === '//') {
            return false;
        }
        // Relative urls cannot have a colon in the first path segment (and the
        // slashes themselves are not included so skip the first character).
        if (!$this->scheme && !$isauthority && strpos($this->ipath, ':') !== false && strpos($this->ipath, '/', 1) !== false && strpos($this->ipath, ':') < strpos($this->ipath, '/', 1)) {
            return false;
        }
        return true;
    }
    /**
     * Set the entire IRI. Returns true on success, false on failure (if there
     * are any invalid characters).
     *
     * @param string $iri
     * @return bool
     */
    public function set_iri($iri, $clear_cache = false)
    {
        static $cache;
        if ($clear_cache) {
            $cache = null;
            return;
        }
        if (!$cache) {
            $cache = array();
        }
        if ($iri === null) {
            return true;
        } elseif (isset($cache[$iri])) {
            list($this->scheme, $this->iuserinfo, $this->ihost, $this->port, $this->ipath, $this->iquery, $this->ifragment, $return) = $cache[$iri];
            return $return;
        }
        $parsed = $this->parse_iri((string) $iri);
        if (!$parsed) {
            return false;
        }
        $return = $this->set_scheme($parsed['scheme']) && $this->set_authority($parsed['authority']) && $this->set_path($parsed['path']) && $this->set_query($parsed['query']) && $this->set_fragment($parsed['fragment']);
        $cache[$iri] = array($this->scheme, $this->iuserinfo, $this->ihost, $this->port, $this->ipath, $this->iquery, $this->ifragment, $return);
        return $return;
    }
    /**
     * Set the scheme. Returns true on success, false on failure (if there are
     * any invalid characters).
     *
     * @param string $scheme
     * @return bool
     */
    public function set_scheme($scheme)
    {
        if ($scheme === null) {
            $this->scheme = null;
        } elseif (!preg_match('/^[A-Za-z][0-9A-Za-z+\\-.]*$/', $scheme)) {
            $this->scheme = null;
            return false;
        } else {
            $this->scheme = strtolower($scheme);
        }
        return true;
    }
    /**
     * Set the authority. Returns true on success, false on failure (if there are
     * any invalid characters).
     *
     * @param string $authority
     * @return bool
     */
    public function set_authority($authority, $clear_cache = false)
    {
        static $cache;
        if ($clear_cache) {
            $cache = null;
            return;
        }
        if (!$cache) {
            $cache = array();
        }
        if ($authority === null) {
            $this->iuserinfo = null;
            $this->ihost = null;
            $this->port = null;
            return true;
        } elseif (isset($cache[$authority])) {
            list($this->iuserinfo, $this->ihost, $this->port, $return) = $cache[$authority];
            return $return;
        }
        $remaining = $authority;
        if (($iuserinfo_end = strrpos($remaining, '@')) !== false) {
            $iuserinfo = substr($remaining, 0, $iuserinfo_end);
            $remaining = substr($remaining, $iuserinfo_end + 1);
        } else {
            $iuserinfo = null;
        }
        if (($port_start = strpos($remaining, ':', strpos($remaining, ']'))) !== false) {
            if (($port = substr($remaining, $port_start + 1)) === false) {
                $port = null;
            }
            $remaining = substr($remaining, 0, $port_start);
        } else {
            $port = null;
        }
        $return = $this->set_userinfo($iuserinfo) && $this->set_host($remaining) && $this->set_port($port);
        $cache[$authority] = array($this->iuserinfo, $this->ihost, $this->port, $return);
        return $return;
    }
    /**
     * Set the iuserinfo.
     *
     * @param string $iuserinfo
     * @return bool
     */
    public function set_userinfo($iuserinfo)
    {
        if ($iuserinfo === null) {
            $this->iuserinfo = null;
        } else {
            $this->iuserinfo = $this->replace_invalid_with_pct_encoding($iuserinfo, '!$&\'()*+,;=:');
            $this->scheme_normalization();
        }
        return true;
    }
    /**
     * Set the ihost. Returns true on success, false on failure (if there are
     * any invalid characters).
     *
     * @param string $ihost
     * @return bool
     */
    public function set_host($ihost)
    {
        if ($ihost === null) {
            $this->ihost = null;
            return true;
        } elseif (substr($ihost, 0, 1) === '[' && substr($ihost, -1) === ']') {
            if (SimplePie_Net_IPv6::check_ipv6(substr($ihost, 1, -1))) {
                $this->ihost = '[' . SimplePie_Net_IPv6::compress(substr($ihost, 1, -1)) . ']';
            } else {
                $this->ihost = null;
                return false;
            }
        } else {
            $ihost = $this->replace_invalid_with_pct_encoding($ihost, '!$&\'()*+,;=');
            // Lowercase, but ignore pct-encoded sections (as they should
            // remain uppercase). This must be done after the previous step
            // as that can add unescaped characters.
            $position = 0;
            $strlen = strlen($ihost);
            while (($position += strcspn($ihost, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ%', $position)) < $strlen) {
                if ($ihost[$position] === '%') {
                    $position += 3;
                } else {
                    $ihost[$position] = strtolower($ihost[$position]);
                    $position++;
                }
            }
            $this->ihost = $ihost;
        }
        $this->scheme_normalization();
        return true;
    }
    /**
     * Set the port. Returns true on success, false on failure (if there are
     * any invalid characters).
     *
     * @param string $port
     * @return bool
     */
    public function set_port($port)
    {
        if ($port === null) {
            $this->port = null;
            return true;
        } elseif (strspn($port, '0123456789') === strlen($port)) {
            $this->port = (int) $port;
            $this->scheme_normalization();
            return true;
        }
        $this->port = null;
        return false;
    }
    /**
     * Set the ipath.
     *
     * @param string $ipath
     * @return bool
     */
    public function set_path($ipath, $clear_cache = false)
    {
        static $cache;
        if ($clear_cache) {
            $cache = null;
            return;
        }
        if (!$cache) {
            $cache = array();
        }
        $ipath = (string) $ipath;
        if (isset($cache[$ipath])) {
            $this->ipath = $cache[$ipath][(int) ($this->scheme !== null)];
        } else {
            $valid = $this->replace_invalid_with_pct_encoding($ipath, '!$&\'()*+,;=@:/');
            $removed = $this->remove_dot_segments($valid);
            $cache[$ipath] = array($valid, $removed);
            $this->ipath = $this->scheme !== null ? $removed : $valid;
        }
        $this->scheme_normalization();
        return true;
    }
    /**
     * Set the iquery.
     *
     * @param string $iquery
     * @return bool
     */
    public function set_query($iquery)
    {
        if ($iquery === null) {
            $this->iquery = null;
        } else {
            $this->iquery = $this->replace_invalid_with_pct_encoding($iquery, '!$&\'()*+,;=:@/?', true);
            $this->scheme_normalization();
        }
        return true;
    }
    /**
     * Set the ifragment.
     *
     * @param string $ifragment
     * @return bool
     */
    public function set_fragment($ifragment)
    {
        if ($ifragment === null) {
            $this->ifragment = null;
        } else {
            $this->ifragment = $this->replace_invalid_with_pct_encoding($ifragment, '!$&\'()*+,;=:@/?');
            $this->scheme_normalization();
        }
        return true;
    }
    /**
     * Convert an IRI to a URI (or parts thereof)
     *
     * @return string
     */
    public function to_uri($string)
    {
        static $non_ascii;
        if (!$non_ascii) {
            $non_ascii = implode('', range("\x80", "\xff"));
        }
        $position = 0;
        $strlen = strlen($string);
        while (($position += strcspn($string, $non_ascii, $position)) < $strlen) {
            $string = substr_replace($string, sprintf('%%%02X', ord($string[$position])), $position, 1);
            $position += 3;
            $strlen += 2;
        }
        return $string;
    }
    /**
     * Get the complete IRI
     *
     * @return string
     */
    public function get_iri()
    {
        if (!$this->is_valid()) {
            return false;
        }
        $iri = '';
        if ($this->scheme !== null) {
            $iri .= $this->scheme . ':';
        }
        if (($iauthority = $this->get_iauthority()) !== null) {
            $iri .= '//' . $iauthority;
        }
        if ($this->ipath !== '') {
            $iri .= $this->ipath;
        } elseif (!empty($this->normalization[$this->scheme]['ipath']) && $iauthority !== null && $iauthority !== '') {
            $iri .= $this->normalization[$this->scheme]['ipath'];
        }
        if ($this->iquery !== null) {
            $iri .= '?' . $this->iquery;
        }
        if ($this->ifragment !== null) {
            $iri .= '#' . $this->ifragment;
        }
        return $iri;
    }
    /**
     * Get the complete URI
     *
     * @return string
     */
    public function get_uri()
    {
        return $this->to_uri($this->get_iri());
    }
    /**
     * Get the complete iauthority
     *
     * @return string
     */
    protected function get_iauthority()
    {
        if ($this->iuserinfo !== null || $this->ihost !== null || $this->port !== null) {
            $iauthority = '';
            if ($this->iuserinfo !== null) {
                $iauthority .= $this->iuserinfo . '@';
            }
            if ($this->ihost !== null) {
                $iauthority .= $this->ihost;
            }
            if ($this->port !== null && $this->port !== 0) {
                $iauthority .= ':' . $this->port;
            }
            return $iauthority;
        }
        return null;
    }
    /**
     * Get the complete authority
     *
     * @return string
     */
    protected function get_authority()
    {
        $iauthority = $this->get_iauthority();
        if (is_string($iauthority)) {
            return $this->to_uri($iauthority);
        }
        return $iauthority;
    }
}