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
 * Parses XML into something sane
 *
 *
 * This class can be overloaded with {@see SimplePie::set_parser_class()}
 *
 * @package SimplePie
 * @subpackage Parsing
 */
class SimplePie_Parser
{
    var $error_code;
    var $error_string;
    var $current_line;
    var $current_column;
    var $current_byte;
    var $separator = ' ';
    var $namespace = array('');
    var $element = array('');
    var $xml_base = array('');
    var $xml_base_explicit = array(false);
    var $xml_lang = array('');
    var $data = array();
    var $datas = array(array());
    var $current_xhtml_construct = -1;
    var $encoding;
    protected $registry;
    public function set_registry(SimplePie_Registry $registry)
    {
        $this->registry = $registry;
    }
    public function parse(&$data, $encoding, $url = '')
    {
        if (class_exists('DOMXpath') && function_exists('Mf2\\parse')) {
            $doc = new DOMDocument();
            @$doc->loadHTML($data);
            $xpath = new DOMXpath($doc);
            // Check for both h-feed and h-entry, as both a feed with no entries
            // and a list of entries without an h-feed wrapper are both valid.
            $query = '//*[contains(concat(" ", @class, " "), " h-feed ") or ' . 'contains(concat(" ", @class, " "), " h-entry ")]';
            $result = $xpath->query($query);
            if ($result->length !== 0) {
                return $this->parse_microformats($data, $url);
            }
        }
        // Use UTF-8 if we get passed US-ASCII, as every US-ASCII character is a UTF-8 character
        if (strtoupper($encoding) === 'US-ASCII') {
            $this->encoding = 'UTF-8';
        } else {
            $this->encoding = $encoding;
        }
        // Strip BOM:
        // UTF-32 Big Endian BOM
        if (substr($data, 0, 4) === "\x00\x00\xfe\xff") {
            $data = substr($data, 4);
        } elseif (substr($data, 0, 4) === "\xff\xfe\x00\x00") {
            $data = substr($data, 4);
        } elseif (substr($data, 0, 2) === "\xfe\xff") {
            $data = substr($data, 2);
        } elseif (substr($data, 0, 2) === "\xff\xfe") {
            $data = substr($data, 2);
        } elseif (substr($data, 0, 3) === "﻿") {
            $data = substr($data, 3);
        }
        if (substr($data, 0, 5) === '<?xml' && strspn(substr($data, 5, 1), "\t\n\r ") && ($pos = strpos($data, '?>')) !== false) {
            $declaration = $this->registry->create('XML_Declaration_Parser', array(substr($data, 5, $pos - 5)));
            if ($declaration->parse()) {
                $data = substr($data, $pos + 2);
                $data = '<?xml version="' . $declaration->version . '" encoding="' . $encoding . '" standalone="' . ($declaration->standalone ? 'yes' : 'no') . '"?>' . "\n" . $this->declare_html_entities() . $data;
            } else {
                $this->error_string = 'SimplePie bug! Please report this!';
                return false;
            }
        }
        $return = true;
        static $xml_is_sane = null;
        if ($xml_is_sane === null) {
            $parser_check = xml_parser_create();
            xml_parse_into_struct($parser_check, '<foo>&amp;</foo>', $values);
            xml_parser_free($parser_check);
            $xml_is_sane = isset($values[0]['value']);
        }
        // Create the parser
        if ($xml_is_sane) {
            $xml = xml_parser_create_ns($this->encoding, $this->separator);
            xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);
            xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);
            xml_set_object($xml, $this);
            xml_set_character_data_handler($xml, 'cdata');
            xml_set_element_handler($xml, 'tag_open', 'tag_close');
            // Parse!
            if (!xml_parse($xml, $data, true)) {
                $this->error_code = xml_get_error_code($xml);
                $this->error_string = xml_error_string($this->error_code);
                $return = false;
            }
            $this->current_line = xml_get_current_line_number($xml);
            $this->current_column = xml_get_current_column_number($xml);
            $this->current_byte = xml_get_current_byte_index($xml);
            xml_parser_free($xml);
            return $return;
        }
        libxml_clear_errors();
        $xml = new XMLReader();
        $xml->xml($data);
        while (@$xml->read()) {
            switch ($xml->nodeType) {
                case constant('XMLReader::END_ELEMENT'):
                    if ($xml->namespaceURI !== '') {
                        $tagName = $xml->namespaceURI . $this->separator . $xml->localName;
                    } else {
                        $tagName = $xml->localName;
                    }
                    $this->tag_close(null, $tagName);
                    break;
                case constant('XMLReader::ELEMENT'):
                    $empty = $xml->isEmptyElement;
                    if ($xml->namespaceURI !== '') {
                        $tagName = $xml->namespaceURI . $this->separator . $xml->localName;
                    } else {
                        $tagName = $xml->localName;
                    }
                    $attributes = array();
                    while ($xml->moveToNextAttribute()) {
                        if ($xml->namespaceURI !== '') {
                            $attrName = $xml->namespaceURI . $this->separator . $xml->localName;
                        } else {
                            $attrName = $xml->localName;
                        }
                        $attributes[$attrName] = $xml->value;
                    }
                    $this->tag_open(null, $tagName, $attributes);
                    if ($empty) {
                        $this->tag_close(null, $tagName);
                    }
                    break;
                case constant('XMLReader::TEXT'):
                case constant('XMLReader::CDATA'):
                    $this->cdata(null, $xml->value);
                    break;
            }
        }
        if ($error = libxml_get_last_error()) {
            $this->error_code = $error->code;
            $this->error_string = $error->message;
            $this->current_line = $error->line;
            $this->current_column = $error->column;
            return false;
        }
        return true;
    }
    public function get_error_code()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_error_code") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_error_code:197@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_error_string()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_error_string") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php at line 201")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_error_string:201@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_current_line()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_current_line") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php at line 205")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_current_line:205@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_current_column()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_current_column") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php at line 209")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_current_column:209@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_current_byte()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_current_byte") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php at line 213")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_current_byte:213@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_data()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php at line 217")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_data:217@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function tag_open($parser, $tag, $attributes)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("tag_open") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php at line 221")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called tag_open:221@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function cdata($parser, $cdata)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("cdata") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php at line 264")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called cdata:264@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function tag_close($parser, $tag)
    {
        if ($this->current_xhtml_construct >= 0) {
            $this->current_xhtml_construct--;
            if (end($this->namespace) === SIMPLEPIE_NAMESPACE_XHTML && !in_array(end($this->element), array('area', 'base', 'basefont', 'br', 'col', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param'))) {
                $this->data['data'] .= '</' . end($this->element) . '>';
            }
        }
        if ($this->current_xhtml_construct === -1) {
            $this->data =& $this->datas[count($this->datas) - 1];
            array_pop($this->datas);
        }
        array_pop($this->element);
        array_pop($this->namespace);
        array_pop($this->xml_base);
        array_pop($this->xml_base_explicit);
        array_pop($this->xml_lang);
    }
    public function split_ns($string)
    {
        static $cache = array();
        if (!isset($cache[$string])) {
            if ($pos = strpos($string, $this->separator)) {
                static $separator_length;
                if (!$separator_length) {
                    $separator_length = strlen($this->separator);
                }
                $namespace = substr($string, 0, $pos);
                $local_name = substr($string, $pos + $separator_length);
                if (strtolower($namespace) === SIMPLEPIE_NAMESPACE_ITUNES) {
                    $namespace = SIMPLEPIE_NAMESPACE_ITUNES;
                }
                // Normalize the Media RSS namespaces
                if ($namespace === SIMPLEPIE_NAMESPACE_MEDIARSS_WRONG || $namespace === SIMPLEPIE_NAMESPACE_MEDIARSS_WRONG2 || $namespace === SIMPLEPIE_NAMESPACE_MEDIARSS_WRONG3 || $namespace === SIMPLEPIE_NAMESPACE_MEDIARSS_WRONG4 || $namespace === SIMPLEPIE_NAMESPACE_MEDIARSS_WRONG5) {
                    $namespace = SIMPLEPIE_NAMESPACE_MEDIARSS;
                }
                $cache[$string] = array($namespace, $local_name);
            } else {
                $cache[$string] = array('', $string);
            }
        }
        return $cache[$string];
    }
    private function parse_hcard($data, $category = false)
    {
        $name = '';
        $link = '';
        // Check if h-card is set and pass that information on in the link.
        if (isset($data['type']) && in_array('h-card', $data['type'])) {
            if (isset($data['properties']['name'][0])) {
                $name = $data['properties']['name'][0];
            }
            if (isset($data['properties']['url'][0])) {
                $link = $data['properties']['url'][0];
                if ($name === '') {
                    $name = $link;
                } else {
                    // can't have commas in categories.
                    $name = str_replace(',', '', $name);
                }
                $person_tag = $category ? '<span class="person-tag"></span>' : '';
                return '<a class="h-card" href="' . $link . '">' . $person_tag . $name . '</a>';
            }
        }
        return isset($data['value']) ? $data['value'] : '';
    }
    private function parse_microformats(&$data, $url)
    {
        $feed_title = '';
        $feed_author = NULL;
        $author_cache = array();
        $items = array();
        $entries = array();
        $mf = Mf2\parse($data, $url);
        // First look for an h-feed.
        $h_feed = array();
        foreach ($mf['items'] as $mf_item) {
            if (in_array('h-feed', $mf_item['type'])) {
                $h_feed = $mf_item;
                break;
            }
            // Also look for h-feed or h-entry in the children of each top level item.
            if (!isset($mf_item['children'][0]['type'])) {
                continue;
            }
            if (in_array('h-feed', $mf_item['children'][0]['type'])) {
                $h_feed = $mf_item['children'][0];
                // In this case the parent of the h-feed may be an h-card, so use it as
                // the feed_author.
                if (in_array('h-card', $mf_item['type'])) {
                    $feed_author = $mf_item;
                }
                break;
            } else {
                if (in_array('h-entry', $mf_item['children'][0]['type'])) {
                    $entries = $mf_item['children'];
                    // In this case the parent of the h-entry list may be an h-card, so use
                    // it as the feed_author.
                    if (in_array('h-card', $mf_item['type'])) {
                        $feed_author = $mf_item;
                    }
                    break;
                }
            }
        }
        if (isset($h_feed['children'])) {
            $entries = $h_feed['children'];
            // Also set the feed title and store author from the h-feed if available.
            if (isset($mf['items'][0]['properties']['name'][0])) {
                $feed_title = $mf['items'][0]['properties']['name'][0];
            }
            if (isset($mf['items'][0]['properties']['author'][0])) {
                $feed_author = $mf['items'][0]['properties']['author'][0];
            }
        } else {
            if (count($entries) === 0) {
                $entries = $mf['items'];
            }
        }
        for ($i = 0; $i < count($entries); $i++) {
            $entry = $entries[$i];
            if (in_array('h-entry', $entry['type'])) {
                $item = array();
                $title = '';
                $description = '';
                if (isset($entry['properties']['url'][0])) {
                    $link = $entry['properties']['url'][0];
                    if (isset($link['value'])) {
                        $link = $link['value'];
                    }
                    $item['link'] = array(array('data' => $link));
                }
                if (isset($entry['properties']['uid'][0])) {
                    $guid = $entry['properties']['uid'][0];
                    if (isset($guid['value'])) {
                        $guid = $guid['value'];
                    }
                    $item['guid'] = array(array('data' => $guid));
                }
                if (isset($entry['properties']['name'][0])) {
                    $title = $entry['properties']['name'][0];
                    if (isset($title['value'])) {
                        $title = $title['value'];
                    }
                    $item['title'] = array(array('data' => $title));
                }
                if (isset($entry['properties']['author'][0]) || isset($feed_author)) {
                    // author is a special case, it can be plain text or an h-card array.
                    // If it's plain text it can also be a url that should be followed to
                    // get the actual h-card.
                    $author = isset($entry['properties']['author'][0]) ? $entry['properties']['author'][0] : $feed_author;
                    if (!is_string($author)) {
                        $author = $this->parse_hcard($author);
                    } else {
                        if (strpos($author, 'http') === 0) {
                            if (isset($author_cache[$author])) {
                                $author = $author_cache[$author];
                            } else {
                                $mf = Mf2\fetch($author);
                                foreach ($mf['items'] as $hcard) {
                                    // Only interested in an h-card by itself in this case.
                                    if (!in_array('h-card', $hcard['type'])) {
                                        continue;
                                    }
                                    // It must have a url property matching what we fetched.
                                    if (!isset($hcard['properties']['url']) || !in_array($author, $hcard['properties']['url'])) {
                                        continue;
                                    }
                                    // Save parse_hcard the trouble of finding the correct url.
                                    $hcard['properties']['url'][0] = $author;
                                    // Cache this h-card for the next h-entry to check.
                                    $author_cache[$author] = $this->parse_hcard($hcard);
                                    $author = $author_cache[$author];
                                    break;
                                }
                            }
                        }
                    }
                    $item['author'] = array(array('data' => $author));
                }
                if (isset($entry['properties']['photo'][0])) {
                    // If a photo is also in content, don't need to add it again here.
                    $content = '';
                    if (isset($entry['properties']['content'][0]['html'])) {
                        $content = $entry['properties']['content'][0]['html'];
                    }
                    $photo_list = array();
                    for ($j = 0; $j < count($entry['properties']['photo']); $j++) {
                        $photo = $entry['properties']['photo'][$j];
                        if (!empty($photo) && strpos($content, $photo) === false) {
                            $photo_list[] = $photo;
                        }
                    }
                    // When there's more than one photo show the first and use a lightbox.
                    // Need a permanent, unique name for the image set, but don't have
                    // anything unique except for the content itself, so use that.
                    $count = count($photo_list);
                    if ($count > 1) {
                        $image_set_id = preg_replace('/[[:^alnum:]]/', '', $photo_list[0]);
                        $description = '<p>';
                        for ($j = 0; $j < $count; $j++) {
                            $hidden = $j === 0 ? '' : 'class="hidden" ';
                            $description .= '<a href="' . $photo_list[$j] . '" ' . $hidden . 'data-lightbox="image-set-' . $image_set_id . '">' . '<img src="' . $photo_list[$j] . '"></a>';
                        }
                        $description .= '<br><b>' . $count . ' photos</b></p>';
                    } else {
                        if ($count == 1) {
                            $description = '<p><img src="' . $photo_list[0] . '"></p>';
                        }
                    }
                }
                if (isset($entry['properties']['content'][0]['html'])) {
                    // e-content['value'] is the same as p-name when they are on the same
                    // element. Use this to replace title with a strip_tags version so
                    // that alt text from images is not included in the title.
                    if ($entry['properties']['content'][0]['value'] === $title) {
                        $title = strip_tags($entry['properties']['content'][0]['html']);
                        $item['title'] = array(array('data' => $title));
                    }
                    $description .= $entry['properties']['content'][0]['html'];
                    if (isset($entry['properties']['in-reply-to'][0])) {
                        $in_reply_to = '';
                        if (is_string($entry['properties']['in-reply-to'][0])) {
                            $in_reply_to = $entry['properties']['in-reply-to'][0];
                        } else {
                            if (isset($entry['properties']['in-reply-to'][0]['value'])) {
                                $in_reply_to = $entry['properties']['in-reply-to'][0]['value'];
                            }
                        }
                        if ($in_reply_to !== '') {
                            $description .= '<p><span class="in-reply-to"></span> ' . '<a href="' . $in_reply_to . '">' . $in_reply_to . '</a><p>';
                        }
                    }
                    $item['description'] = array(array('data' => $description));
                }
                if (isset($entry['properties']['category'])) {
                    $category_csv = '';
                    // Categories can also contain h-cards.
                    foreach ($entry['properties']['category'] as $category) {
                        if ($category_csv !== '') {
                            $category_csv .= ', ';
                        }
                        if (is_string($category)) {
                            // Can't have commas in categories.
                            $category_csv .= str_replace(',', '', $category);
                        } else {
                            $category_csv .= $this->parse_hcard($category, true);
                        }
                    }
                    $item['category'] = array(array('data' => $category_csv));
                }
                if (isset($entry['properties']['published'][0])) {
                    $timestamp = strtotime($entry['properties']['published'][0]);
                    $pub_date = date('F j Y g:ia', $timestamp) . ' GMT';
                    $item['pubDate'] = array(array('data' => $pub_date));
                }
                // The title and description are set to the empty string to represent
                // a deleted item (which also makes it an invalid rss item).
                if (isset($entry['properties']['deleted'][0])) {
                    $item['title'] = array(array('data' => ''));
                    $item['description'] = array(array('data' => ''));
                }
                $items[] = array('child' => array('' => $item));
            }
        }
        // Mimic RSS data format when storing microformats.
        $link = array(array('data' => $url));
        $image = '';
        if (!is_string($feed_author) && isset($feed_author['properties']['photo'][0])) {
            $image = array(array('child' => array('' => array('url' => array(array('data' => $feed_author['properties']['photo'][0]))))));
        }
        // Use the name given for the h-feed, or get the title from the html.
        if ($feed_title !== '') {
            $feed_title = array(array('data' => htmlspecialchars($feed_title)));
        } else {
            if ($position = strpos($data, '<title>')) {
                $start = $position < 200 ? 0 : $position - 200;
                $check = substr($data, $start, 400);
                $matches = array();
                if (preg_match('/<title>(.+)<\\/title>/', $check, $matches)) {
                    $feed_title = array(array('data' => htmlspecialchars($matches[1])));
                }
            }
        }
        $channel = array('channel' => array(array('child' => array('' => array('link' => $link, 'image' => $image, 'title' => $feed_title, 'item' => $items)))));
        $rss = array(array('attribs' => array('' => array('version' => '2.0')), 'child' => array('' => $channel)));
        $this->data = array('child' => array('' => array('rss' => $rss)));
        return true;
    }
    private function declare_html_entities()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("declare_html_entities") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php at line 563")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called declare_html_entities:563@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Parser.php');
        die();
    }
}