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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__toString") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 113")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __toString:113@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
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
        if (method_exists($this, 'set_' . $name)) {
            call_user_func(array($this, 'set_' . $name), $value);
        } elseif ($name === 'iauthority' || $name === 'iuserinfo' || $name === 'ihost' || $name === 'ipath' || $name === 'iquery' || $name === 'ifragment') {
            call_user_func(array($this, 'set_' . substr($name, 1)), $value);
        }
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__isset") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 167")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __isset:167@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
    }
    /**
     * Overload __unset() to provide access via properties
     *
     * @param string $name Property name
     */
    public function __unset($name)
    {
        if (method_exists($this, 'set_' . $name)) {
            call_user_func(array($this, 'set_' . $name), '');
        }
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse_iri") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 283")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parse_iri:283@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
    }
    /**
     * Remove dot segments from a path
     *
     * @param string $input
     * @return string
     */
    protected function remove_dot_segments($input)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove_dot_segments") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 313")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove_dot_segments:313@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
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
        // As we just have valid percent encoded sequences we can just explode
        // and ignore the first member of the returned array (an empty string).
        $bytes = explode('%', $match[0]);
        // Initialize the new string (this is what will be returned) and that
        // there are no bytes remaining in the current sequence (unsurprising
        // at the first byte!).
        $string = '';
        $remaining = 0;
        // Loop over each and every byte, and set $value to its value
        for ($i = 1, $len = count($bytes); $i < $len; $i++) {
            $value = hexdec($bytes[$i]);
            // If we're the first byte of sequence:
            if (!$remaining) {
                // Start position
                $start = $i;
                // By default we are valid
                $valid = true;
                // One byte sequence:
                if ($value <= 0x7f) {
                    $character = $value;
                    $length = 1;
                } elseif (($value & 0xe0) === 0xc0) {
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
                    $remaining = 0;
                }
            } else {
                // Check that the byte is valid, then add it to the character:
                if (($value & 0xc0) === 0x80) {
                    $remaining--;
                    $character |= ($value & 0x3f) << $remaining * 6;
                } else {
                    $valid = false;
                    $remaining = 0;
                    $i--;
                }
            }
            // If we've reached the end of the current byte sequence, append it to Unicode::$data
            if (!$remaining) {
                // Percent encode anything invalid or not in iunreserved
                if (!$valid || $length > 1 && $character <= 0x7f || $length > 2 && $character <= 0x7ff || $length > 3 && $character <= 0xffff || $character < 0x2d || $character > 0xefffd || ($character & 0xfffe) === 0xfffe || $character >= 0xfdd0 && $character <= 0xfdef || $character === 0x2f || $character > 0x39 && $character < 0x41 || $character > 0x5a && $character < 0x61 || $character > 0x7a && $character < 0x7e || $character > 0x7e && $character < 0xa0 || $character > 0xd7ff && $character < 0xf900) {
                    for ($j = $start; $j <= $i; $j++) {
                        $string .= '%' . strtoupper($bytes[$j]);
                    }
                } else {
                    for ($j = $start; $j <= $i; $j++) {
                        $string .= chr(hexdec($bytes[$j]));
                    }
                }
            }
        }
        // If we have any bytes left over they are invalid (i.e., we are
        // mid-way through a multi-byte sequence)
        if ($remaining) {
            for ($j = $start; $j < $len; $j++) {
                $string .= '%' . strtoupper($bytes[$j]);
            }
        }
        return $string;
    }
    protected function scheme_normalization()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("scheme_normalization") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 506")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called scheme_normalization:506@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
    }
    /**
     * Check if the object represents a valid IRI. This needs to be done on each
     * call as some things change depending on another part of the IRI.
     *
     * @return bool
     */
    public function is_valid()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_valid") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 533")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_valid:533@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_iri") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 559")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_iri:559@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_scheme") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 590")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_scheme:590@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_authority") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 609")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_authority:609@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
    }
    /**
     * Set the iuserinfo.
     *
     * @param string $iuserinfo
     * @return bool
     */
    public function set_userinfo($iuserinfo)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_userinfo") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 653")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_userinfo:653@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_host") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 670")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_host:670@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_port") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 709")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_port:709@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_fragment") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 772")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_fragment:772@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_authority") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php at line 868")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_authority:868@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/SimplePie/IRI.php');
        die();
    }
}