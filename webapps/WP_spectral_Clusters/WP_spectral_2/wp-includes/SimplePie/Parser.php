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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_error_code") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_error_code:197@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_error_string()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_error_string") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php at line 201")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_error_string:201@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_current_line()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_current_line") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php at line 205")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_current_line:205@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_current_column()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_current_column") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php at line 209")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_current_column:209@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_current_byte()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_current_byte") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php at line 213")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_current_byte:213@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php');
        die();
    }
    public function get_data()
    {
        return $this->data;
    }
    public function tag_open($parser, $tag, $attributes)
    {
        list($this->namespace[], $this->element[]) = $this->split_ns($tag);
        $attribs = array();
        foreach ($attributes as $name => $value) {
            list($attrib_namespace, $attribute) = $this->split_ns($name);
            $attribs[$attrib_namespace][$attribute] = $value;
        }
        if (isset($attribs[SIMPLEPIE_NAMESPACE_XML]['base'])) {
            $base = $this->registry->call('Misc', 'absolutize_url', array($attribs[SIMPLEPIE_NAMESPACE_XML]['base'], end($this->xml_base)));
            if ($base !== false) {
                $this->xml_base[] = $base;
                $this->xml_base_explicit[] = true;
            }
        } else {
            $this->xml_base[] = end($this->xml_base);
            $this->xml_base_explicit[] = end($this->xml_base_explicit);
        }
        if (isset($attribs[SIMPLEPIE_NAMESPACE_XML]['lang'])) {
            $this->xml_lang[] = $attribs[SIMPLEPIE_NAMESPACE_XML]['lang'];
        } else {
            $this->xml_lang[] = end($this->xml_lang);
        }
        if ($this->current_xhtml_construct >= 0) {
            $this->current_xhtml_construct++;
            if (end($this->namespace) === SIMPLEPIE_NAMESPACE_XHTML) {
                $this->data['data'] .= '<' . end($this->element);
                if (isset($attribs[''])) {
                    foreach ($attribs[''] as $name => $value) {
                        $this->data['data'] .= ' ' . $name . '="' . htmlspecialchars($value, ENT_COMPAT, $this->encoding) . '"';
                    }
                }
                $this->data['data'] .= '>';
            }
        } else {
            $this->datas[] =& $this->data;
            $this->data =& $this->data['child'][end($this->namespace)][end($this->element)][];
            $this->data = array('data' => '', 'attribs' => $attribs, 'xml_base' => end($this->xml_base), 'xml_base_explicit' => end($this->xml_base_explicit), 'xml_lang' => end($this->xml_lang));
            if (end($this->namespace) === SIMPLEPIE_NAMESPACE_ATOM_03 && in_array(end($this->element), array('title', 'tagline', 'copyright', 'info', 'summary', 'content')) && isset($attribs['']['mode']) && $attribs['']['mode'] === 'xml' || end($this->namespace) === SIMPLEPIE_NAMESPACE_ATOM_10 && in_array(end($this->element), array('rights', 'subtitle', 'summary', 'info', 'title', 'content')) && isset($attribs['']['type']) && $attribs['']['type'] === 'xhtml' || end($this->namespace) === SIMPLEPIE_NAMESPACE_RSS_20 && in_array(end($this->element), array('title')) || end($this->namespace) === SIMPLEPIE_NAMESPACE_RSS_090 && in_array(end($this->element), array('title')) || end($this->namespace) === SIMPLEPIE_NAMESPACE_RSS_10 && in_array(end($this->element), array('title'))) {
                $this->current_xhtml_construct = 0;
            }
        }
    }
    public function cdata($parser, $cdata)
    {
        if ($this->current_xhtml_construct >= 0) {
            $this->data['data'] .= htmlspecialchars($cdata, ENT_QUOTES, $this->encoding);
        } else {
            $this->data['data'] .= $cdata;
        }
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse_hcard") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php at line 315")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parse_hcard:315@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php');
        die();
    }
    private function parse_microformats(&$data, $url)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse_microformats") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php at line 338")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parse_microformats:338@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Parser.php');
        die();
    }
    private function declare_html_entities()
    {
        // This is required because the RSS specification says that entity-encoded
        // html is allowed, but the xml specification says they must be declared.
        return '<!DOCTYPE html [ <!ENTITY nbsp "&#x00A0;"> <!ENTITY iexcl "&#x00A1;"> <!ENTITY cent "&#x00A2;"> <!ENTITY pound "&#x00A3;"> <!ENTITY curren "&#x00A4;"> <!ENTITY yen "&#x00A5;"> <!ENTITY brvbar "&#x00A6;"> <!ENTITY sect "&#x00A7;"> <!ENTITY uml "&#x00A8;"> <!ENTITY copy "&#x00A9;"> <!ENTITY ordf "&#x00AA;"> <!ENTITY laquo "&#x00AB;"> <!ENTITY not "&#x00AC;"> <!ENTITY shy "&#x00AD;"> <!ENTITY reg "&#x00AE;"> <!ENTITY macr "&#x00AF;"> <!ENTITY deg "&#x00B0;"> <!ENTITY plusmn "&#x00B1;"> <!ENTITY sup2 "&#x00B2;"> <!ENTITY sup3 "&#x00B3;"> <!ENTITY acute "&#x00B4;"> <!ENTITY micro "&#x00B5;"> <!ENTITY para "&#x00B6;"> <!ENTITY middot "&#x00B7;"> <!ENTITY cedil "&#x00B8;"> <!ENTITY sup1 "&#x00B9;"> <!ENTITY ordm "&#x00BA;"> <!ENTITY raquo "&#x00BB;"> <!ENTITY frac14 "&#x00BC;"> <!ENTITY frac12 "&#x00BD;"> <!ENTITY frac34 "&#x00BE;"> <!ENTITY iquest "&#x00BF;"> <!ENTITY Agrave "&#x00C0;"> <!ENTITY Aacute "&#x00C1;"> <!ENTITY Acirc "&#x00C2;"> <!ENTITY Atilde "&#x00C3;"> <!ENTITY Auml "&#x00C4;"> <!ENTITY Aring "&#x00C5;"> <!ENTITY AElig "&#x00C6;"> <!ENTITY Ccedil "&#x00C7;"> <!ENTITY Egrave "&#x00C8;"> <!ENTITY Eacute "&#x00C9;"> <!ENTITY Ecirc "&#x00CA;"> <!ENTITY Euml "&#x00CB;"> <!ENTITY Igrave "&#x00CC;"> <!ENTITY Iacute "&#x00CD;"> <!ENTITY Icirc "&#x00CE;"> <!ENTITY Iuml "&#x00CF;"> <!ENTITY ETH "&#x00D0;"> <!ENTITY Ntilde "&#x00D1;"> <!ENTITY Ograve "&#x00D2;"> <!ENTITY Oacute "&#x00D3;"> <!ENTITY Ocirc "&#x00D4;"> <!ENTITY Otilde "&#x00D5;"> <!ENTITY Ouml "&#x00D6;"> <!ENTITY times "&#x00D7;"> <!ENTITY Oslash "&#x00D8;"> <!ENTITY Ugrave "&#x00D9;"> <!ENTITY Uacute "&#x00DA;"> <!ENTITY Ucirc "&#x00DB;"> <!ENTITY Uuml "&#x00DC;"> <!ENTITY Yacute "&#x00DD;"> <!ENTITY THORN "&#x00DE;"> <!ENTITY szlig "&#x00DF;"> <!ENTITY agrave "&#x00E0;"> <!ENTITY aacute "&#x00E1;"> <!ENTITY acirc "&#x00E2;"> <!ENTITY atilde "&#x00E3;"> <!ENTITY auml "&#x00E4;"> <!ENTITY aring "&#x00E5;"> <!ENTITY aelig "&#x00E6;"> <!ENTITY ccedil "&#x00E7;"> <!ENTITY egrave "&#x00E8;"> <!ENTITY eacute "&#x00E9;"> <!ENTITY ecirc "&#x00EA;"> <!ENTITY euml "&#x00EB;"> <!ENTITY igrave "&#x00EC;"> <!ENTITY iacute "&#x00ED;"> <!ENTITY icirc "&#x00EE;"> <!ENTITY iuml "&#x00EF;"> <!ENTITY eth "&#x00F0;"> <!ENTITY ntilde "&#x00F1;"> <!ENTITY ograve "&#x00F2;"> <!ENTITY oacute "&#x00F3;"> <!ENTITY ocirc "&#x00F4;"> <!ENTITY otilde "&#x00F5;"> <!ENTITY ouml "&#x00F6;"> <!ENTITY divide "&#x00F7;"> <!ENTITY oslash "&#x00F8;"> <!ENTITY ugrave "&#x00F9;"> <!ENTITY uacute "&#x00FA;"> <!ENTITY ucirc "&#x00FB;"> <!ENTITY uuml "&#x00FC;"> <!ENTITY yacute "&#x00FD;"> <!ENTITY thorn "&#x00FE;"> <!ENTITY yuml "&#x00FF;"> <!ENTITY OElig "&#x0152;"> <!ENTITY oelig "&#x0153;"> <!ENTITY Scaron "&#x0160;"> <!ENTITY scaron "&#x0161;"> <!ENTITY Yuml "&#x0178;"> <!ENTITY fnof "&#x0192;"> <!ENTITY circ "&#x02C6;"> <!ENTITY tilde "&#x02DC;"> <!ENTITY Alpha "&#x0391;"> <!ENTITY Beta "&#x0392;"> <!ENTITY Gamma "&#x0393;"> <!ENTITY Epsilon "&#x0395;"> <!ENTITY Zeta "&#x0396;"> <!ENTITY Eta "&#x0397;"> <!ENTITY Theta "&#x0398;"> <!ENTITY Iota "&#x0399;"> <!ENTITY Kappa "&#x039A;"> <!ENTITY Lambda "&#x039B;"> <!ENTITY Mu "&#x039C;"> <!ENTITY Nu "&#x039D;"> <!ENTITY Xi "&#x039E;"> <!ENTITY Omicron "&#x039F;"> <!ENTITY Pi "&#x03A0;"> <!ENTITY Rho "&#x03A1;"> <!ENTITY Sigma "&#x03A3;"> <!ENTITY Tau "&#x03A4;"> <!ENTITY Upsilon "&#x03A5;"> <!ENTITY Phi "&#x03A6;"> <!ENTITY Chi "&#x03A7;"> <!ENTITY Psi "&#x03A8;"> <!ENTITY Omega "&#x03A9;"> <!ENTITY alpha "&#x03B1;"> <!ENTITY beta "&#x03B2;"> <!ENTITY gamma "&#x03B3;"> <!ENTITY delta "&#x03B4;"> <!ENTITY epsilon "&#x03B5;"> <!ENTITY zeta "&#x03B6;"> <!ENTITY eta "&#x03B7;"> <!ENTITY theta "&#x03B8;"> <!ENTITY iota "&#x03B9;"> <!ENTITY kappa "&#x03BA;"> <!ENTITY lambda "&#x03BB;"> <!ENTITY mu "&#x03BC;"> <!ENTITY nu "&#x03BD;"> <!ENTITY xi "&#x03BE;"> <!ENTITY omicron "&#x03BF;"> <!ENTITY pi "&#x03C0;"> <!ENTITY rho "&#x03C1;"> <!ENTITY sigmaf "&#x03C2;"> <!ENTITY sigma "&#x03C3;"> <!ENTITY tau "&#x03C4;"> <!ENTITY upsilon "&#x03C5;"> <!ENTITY phi "&#x03C6;"> <!ENTITY chi "&#x03C7;"> <!ENTITY psi "&#x03C8;"> <!ENTITY omega "&#x03C9;"> <!ENTITY thetasym "&#x03D1;"> <!ENTITY upsih "&#x03D2;"> <!ENTITY piv "&#x03D6;"> <!ENTITY ensp "&#x2002;"> <!ENTITY emsp "&#x2003;"> <!ENTITY thinsp "&#x2009;"> <!ENTITY zwnj "&#x200C;"> <!ENTITY zwj "&#x200D;"> <!ENTITY lrm "&#x200E;"> <!ENTITY rlm "&#x200F;"> <!ENTITY ndash "&#x2013;"> <!ENTITY mdash "&#x2014;"> <!ENTITY lsquo "&#x2018;"> <!ENTITY rsquo "&#x2019;"> <!ENTITY sbquo "&#x201A;"> <!ENTITY ldquo "&#x201C;"> <!ENTITY rdquo "&#x201D;"> <!ENTITY bdquo "&#x201E;"> <!ENTITY dagger "&#x2020;"> <!ENTITY Dagger "&#x2021;"> <!ENTITY bull "&#x2022;"> <!ENTITY hellip "&#x2026;"> <!ENTITY permil "&#x2030;"> <!ENTITY prime "&#x2032;"> <!ENTITY Prime "&#x2033;"> <!ENTITY lsaquo "&#x2039;"> <!ENTITY rsaquo "&#x203A;"> <!ENTITY oline "&#x203E;"> <!ENTITY frasl "&#x2044;"> <!ENTITY euro "&#x20AC;"> <!ENTITY image "&#x2111;"> <!ENTITY weierp "&#x2118;"> <!ENTITY real "&#x211C;"> <!ENTITY trade "&#x2122;"> <!ENTITY alefsym "&#x2135;"> <!ENTITY larr "&#x2190;"> <!ENTITY uarr "&#x2191;"> <!ENTITY rarr "&#x2192;"> <!ENTITY darr "&#x2193;"> <!ENTITY harr "&#x2194;"> <!ENTITY crarr "&#x21B5;"> <!ENTITY lArr "&#x21D0;"> <!ENTITY uArr "&#x21D1;"> <!ENTITY rArr "&#x21D2;"> <!ENTITY dArr "&#x21D3;"> <!ENTITY hArr "&#x21D4;"> <!ENTITY forall "&#x2200;"> <!ENTITY part "&#x2202;"> <!ENTITY exist "&#x2203;"> <!ENTITY empty "&#x2205;"> <!ENTITY nabla "&#x2207;"> <!ENTITY isin "&#x2208;"> <!ENTITY notin "&#x2209;"> <!ENTITY ni "&#x220B;"> <!ENTITY prod "&#x220F;"> <!ENTITY sum "&#x2211;"> <!ENTITY minus "&#x2212;"> <!ENTITY lowast "&#x2217;"> <!ENTITY radic "&#x221A;"> <!ENTITY prop "&#x221D;"> <!ENTITY infin "&#x221E;"> <!ENTITY ang "&#x2220;"> <!ENTITY and "&#x2227;"> <!ENTITY or "&#x2228;"> <!ENTITY cap "&#x2229;"> <!ENTITY cup "&#x222A;"> <!ENTITY int "&#x222B;"> <!ENTITY there4 "&#x2234;"> <!ENTITY sim "&#x223C;"> <!ENTITY cong "&#x2245;"> <!ENTITY asymp "&#x2248;"> <!ENTITY ne "&#x2260;"> <!ENTITY equiv "&#x2261;"> <!ENTITY le "&#x2264;"> <!ENTITY ge "&#x2265;"> <!ENTITY sub "&#x2282;"> <!ENTITY sup "&#x2283;"> <!ENTITY nsub "&#x2284;"> <!ENTITY sube "&#x2286;"> <!ENTITY supe "&#x2287;"> <!ENTITY oplus "&#x2295;"> <!ENTITY otimes "&#x2297;"> <!ENTITY perp "&#x22A5;"> <!ENTITY sdot "&#x22C5;"> <!ENTITY lceil "&#x2308;"> <!ENTITY rceil "&#x2309;"> <!ENTITY lfloor "&#x230A;"> <!ENTITY rfloor "&#x230B;"> <!ENTITY lang "&#x2329;"> <!ENTITY rang "&#x232A;"> <!ENTITY loz "&#x25CA;"> <!ENTITY spades "&#x2660;"> <!ENTITY clubs "&#x2663;"> <!ENTITY hearts "&#x2665;"> <!ENTITY diams "&#x2666;"> ]>';
    }
}