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
 * Used for data cleanup and post-processing
 *
 *
 * This class can be overloaded with {@see SimplePie::set_sanitize_class()}
 *
 * @package SimplePie
 * @todo Move to using an actual HTML parser (this will allow tags to be properly stripped, and to switch between HTML and XHTML), this will also make it easier to shorten a string while preserving HTML tags
 */
class SimplePie_Sanitize
{
    // Private vars
    var $base;
    // Options
    var $remove_div = true;
    var $image_handler = '';
    var $strip_htmltags = array('base', 'blink', 'body', 'doctype', 'embed', 'font', 'form', 'frame', 'frameset', 'html', 'iframe', 'input', 'marquee', 'meta', 'noscript', 'object', 'param', 'script', 'style');
    var $encode_instead_of_strip = false;
    var $strip_attributes = array('bgsound', 'expr', 'id', 'style', 'onclick', 'onerror', 'onfinish', 'onmouseover', 'onmouseout', 'onfocus', 'onblur', 'lowsrc', 'dynsrc');
    var $add_attributes = array('audio' => array('preload' => 'none'), 'iframe' => array('sandbox' => 'allow-scripts allow-same-origin'), 'video' => array('preload' => 'none'));
    var $strip_comments = false;
    var $output_encoding = 'UTF-8';
    var $enable_cache = true;
    var $cache_location = './cache';
    var $cache_name_function = 'md5';
    var $timeout = 10;
    var $useragent = '';
    var $force_fsockopen = false;
    var $replace_url_attributes = null;
    public function __construct()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 76")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:76@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    public function remove_div($enable = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove_div") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 80")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove_div:80@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    public function set_image_handler($page = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_image_handler") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 84")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_image_handler:84@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    public function set_registry(SimplePie_Registry $registry)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_registry") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 92")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_registry:92@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    public function pass_cache_data($enable_cache = true, $cache_location = './cache', $cache_name_function = 'md5', $cache_class = 'SimplePie_Cache')
    {
        if (isset($enable_cache)) {
            $this->enable_cache = (bool) $enable_cache;
        }
        if ($cache_location) {
            $this->cache_location = (string) $cache_location;
        }
        if ($cache_name_function) {
            $this->cache_name_function = (string) $cache_name_function;
        }
    }
    public function pass_file_data($file_class = 'SimplePie_File', $timeout = 10, $useragent = '', $force_fsockopen = false)
    {
        if ($timeout) {
            $this->timeout = (string) $timeout;
        }
        if ($useragent) {
            $this->useragent = (string) $useragent;
        }
        if ($force_fsockopen) {
            $this->force_fsockopen = (string) $force_fsockopen;
        }
    }
    public function strip_htmltags($tags = array('base', 'blink', 'body', 'doctype', 'embed', 'font', 'form', 'frame', 'frameset', 'html', 'iframe', 'input', 'marquee', 'meta', 'noscript', 'object', 'param', 'script', 'style'))
    {
        if ($tags) {
            if (is_array($tags)) {
                $this->strip_htmltags = $tags;
            } else {
                $this->strip_htmltags = explode(',', $tags);
            }
        } else {
            $this->strip_htmltags = false;
        }
    }
    public function encode_instead_of_strip($encode = false)
    {
        $this->encode_instead_of_strip = (bool) $encode;
    }
    public function strip_attributes($attribs = array('bgsound', 'expr', 'id', 'style', 'onclick', 'onerror', 'onfinish', 'onmouseover', 'onmouseout', 'onfocus', 'onblur', 'lowsrc', 'dynsrc'))
    {
        if ($attribs) {
            if (is_array($attribs)) {
                $this->strip_attributes = $attribs;
            } else {
                $this->strip_attributes = explode(',', $attribs);
            }
        } else {
            $this->strip_attributes = false;
        }
    }
    public function add_attributes($attribs = array('audio' => array('preload' => 'none'), 'iframe' => array('sandbox' => 'allow-scripts allow-same-origin'), 'video' => array('preload' => 'none')))
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_attributes") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 148")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add_attributes:148@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    public function strip_comments($strip = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("strip_comments") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 160")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called strip_comments:160@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    public function set_output_encoding($encoding = 'UTF-8')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_output_encoding") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 164")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_output_encoding:164@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    /**
     * Set element/attribute key/value pairs of HTML attributes
     * containing URLs that need to be resolved relative to the feed
     *
     * Defaults to |a|@href, |area|@href, |blockquote|@cite, |del|@cite,
     * |form|@action, |img|@longdesc, |img|@src, |input|@src, |ins|@cite,
     * |q|@cite
     *
     * @since 1.0
     * @param array|null $element_attribute Element/attribute key/value pairs, null for default
     */
    public function set_url_replacements($element_attribute = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_url_replacements") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 179")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_url_replacements:179@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    public function sanitize($data, $type, $base = '')
    {
        $data = trim($data);
        if ($data !== '' || $type & SIMPLEPIE_CONSTRUCT_IRI) {
            if ($type & SIMPLEPIE_CONSTRUCT_MAYBE_HTML) {
                if (preg_match('/(&(#(x[0-9a-fA-F]+|[0-9]+)|[a-zA-Z0-9]+)|<\\/[A-Za-z][^\\x09\\x0A\\x0B\\x0C\\x0D\\x20\\x2F\\x3E]*' . SIMPLEPIE_PCRE_HTML_ATTRIBUTE . '>)/', $data)) {
                    $type |= SIMPLEPIE_CONSTRUCT_HTML;
                } else {
                    $type |= SIMPLEPIE_CONSTRUCT_TEXT;
                }
            }
            if ($type & SIMPLEPIE_CONSTRUCT_BASE64) {
                $data = base64_decode($data);
            }
            if ($type & (SIMPLEPIE_CONSTRUCT_HTML | SIMPLEPIE_CONSTRUCT_XHTML)) {
                if (!class_exists('DOMDocument')) {
                    throw new SimplePie_Exception('DOMDocument not found, unable to use sanitizer');
                }
                $document = new DOMDocument();
                $document->encoding = 'UTF-8';
                $data = $this->preprocess($data, $type);
                set_error_handler(array('SimplePie_Misc', 'silence_errors'));
                $document->loadHTML($data);
                restore_error_handler();
                $xpath = new DOMXPath($document);
                // Strip comments
                if ($this->strip_comments) {
                    $comments = $xpath->query('//comment()');
                    foreach ($comments as $comment) {
                        $comment->parentNode->removeChild($comment);
                    }
                }
                // Strip out HTML tags and attributes that might cause various security problems.
                // Based on recommendations by Mark Pilgrim at:
                // http://diveintomark.org/archives/2003/06/12/how_to_consume_rss_safely
                if ($this->strip_htmltags) {
                    foreach ($this->strip_htmltags as $tag) {
                        $this->strip_tag($tag, $document, $xpath, $type);
                    }
                }
                if ($this->strip_attributes) {
                    foreach ($this->strip_attributes as $attrib) {
                        $this->strip_attr($attrib, $xpath);
                    }
                }
                if ($this->add_attributes) {
                    foreach ($this->add_attributes as $tag => $valuePairs) {
                        $this->add_attr($tag, $valuePairs, $document);
                    }
                }
                // Replace relative URLs
                $this->base = $base;
                foreach ($this->replace_url_attributes as $element => $attributes) {
                    $this->replace_urls($document, $element, $attributes);
                }
                // If image handling (caching, etc.) is enabled, cache and rewrite all the image tags.
                if (isset($this->image_handler) && (string) $this->image_handler !== '' && $this->enable_cache) {
                    $images = $document->getElementsByTagName('img');
                    foreach ($images as $img) {
                        if ($img->hasAttribute('src')) {
                            $image_url = call_user_func($this->cache_name_function, $img->getAttribute('src'));
                            $cache = $this->registry->call('Cache', 'get_handler', array($this->cache_location, $image_url, 'spi'));
                            if ($cache->load()) {
                                $img->setAttribute('src', $this->image_handler . $image_url);
                            } else {
                                $file = $this->registry->create('File', array($img->getAttribute('src'), $this->timeout, 5, array('X-FORWARDED-FOR' => $_SERVER['REMOTE_ADDR']), $this->useragent, $this->force_fsockopen));
                                $headers = $file->headers;
                                if ($file->success && ($file->method & SIMPLEPIE_FILE_SOURCE_REMOTE === 0 || ($file->status_code === 200 || $file->status_code > 206 && $file->status_code < 300))) {
                                    if ($cache->save(array('headers' => $file->headers, 'body' => $file->body))) {
                                        $img->setAttribute('src', $this->image_handler . $image_url);
                                    } else {
                                        trigger_error("{$this->cache_location} is not writable. Make sure you've set the correct relative or absolute path, and that the location is server-writable.", E_USER_WARNING);
                                    }
                                }
                            }
                        }
                    }
                }
                // Get content node
                $div = $document->getElementsByTagName('body')->item(0)->firstChild;
                // Finally, convert to a HTML string
                $data = trim($document->saveHTML($div));
                if ($this->remove_div) {
                    $data = preg_replace('/^<div' . SIMPLEPIE_PCRE_XML_ATTRIBUTE . '>/', '', $data);
                    $data = preg_replace('/<\\/div>$/', '', $data);
                } else {
                    $data = preg_replace('/^<div' . SIMPLEPIE_PCRE_XML_ATTRIBUTE . '>/', '<div>', $data);
                }
            }
            if ($type & SIMPLEPIE_CONSTRUCT_IRI) {
                $absolute = $this->registry->call('Misc', 'absolutize_url', array($data, $base));
                if ($absolute !== false) {
                    $data = $absolute;
                }
            }
            if ($type & (SIMPLEPIE_CONSTRUCT_TEXT | SIMPLEPIE_CONSTRUCT_IRI)) {
                $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
            }
            if ($this->output_encoding !== 'UTF-8') {
                $data = $this->registry->call('Misc', 'change_encoding', array($data, 'UTF-8', $this->output_encoding));
            }
        }
        return $data;
    }
    protected function preprocess($html, $type)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("preprocess") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 290")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called preprocess:290@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    public function replace_urls($document, $tag, $attributes)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("replace_urls") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 309")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called replace_urls:309@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    public function do_strip_htmltags($match)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("do_strip_htmltags") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 328")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called do_strip_htmltags:328@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
    protected function strip_tag($tag, $document, $xpath, $type)
    {
        $elements = $xpath->query('body//' . $tag);
        if ($this->encode_instead_of_strip) {
            foreach ($elements as $element) {
                $fragment = $document->createDocumentFragment();
                // For elements which aren't script or style, include the tag itself
                if (!in_array($tag, array('script', 'style'))) {
                    $text = '<' . $tag;
                    if ($element->hasAttributes()) {
                        $attrs = array();
                        foreach ($element->attributes as $name => $attr) {
                            $value = $attr->value;
                            // In XHTML, empty values should never exist, so we repeat the value
                            if (empty($value) && $type & SIMPLEPIE_CONSTRUCT_XHTML) {
                                $value = $name;
                            } elseif (empty($value) && $type & SIMPLEPIE_CONSTRUCT_HTML) {
                                $attrs[] = $name;
                                continue;
                            }
                            // Standard attribute text
                            $attrs[] = $name . '="' . $attr->value . '"';
                        }
                        $text .= ' ' . implode(' ', $attrs);
                    }
                    $text .= '>';
                    $fragment->appendChild(new DOMText($text));
                }
                $number = $element->childNodes->length;
                for ($i = $number; $i > 0; $i--) {
                    $child = $element->childNodes->item(0);
                    $fragment->appendChild($child);
                }
                if (!in_array($tag, array('script', 'style'))) {
                    $fragment->appendChild(new DOMText('</' . $tag . '>'));
                }
                $element->parentNode->replaceChild($fragment, $element);
            }
            return;
        } elseif (in_array($tag, array('script', 'style'))) {
            foreach ($elements as $element) {
                $element->parentNode->removeChild($element);
            }
            return;
        } else {
            foreach ($elements as $element) {
                $fragment = $document->createDocumentFragment();
                $number = $element->childNodes->length;
                for ($i = $number; $i > 0; $i--) {
                    $child = $element->childNodes->item(0);
                    $fragment->appendChild($child);
                }
                $element->parentNode->replaceChild($fragment, $element);
            }
        }
    }
    protected function strip_attr($attrib, $xpath)
    {
        $elements = $xpath->query('//*[@' . $attrib . ']');
        foreach ($elements as $element) {
            $element->removeAttribute($attrib);
        }
    }
    protected function add_attr($tag, $valuePairs, $document)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_attr") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php at line 407")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add_attr:407@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/SimplePie/Sanitize.php');
        die();
    }
}