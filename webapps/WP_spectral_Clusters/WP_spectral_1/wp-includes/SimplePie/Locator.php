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
 * Used for feed auto-discovery
 *
 *
 * This class can be overloaded with {@see SimplePie::set_locator_class()}
 *
 * @package SimplePie
 */
class SimplePie_Locator
{
    var $useragent;
    var $timeout;
    var $file;
    var $local = array();
    var $elsewhere = array();
    var $cached_entities = array();
    var $http_base;
    var $base;
    var $base_location = 0;
    var $checked_feeds = 0;
    var $max_checked_feeds = 10;
    var $force_fsockopen = false;
    var $curl_options = array();
    protected $registry;
    public function __construct(SimplePie_File $file, $timeout = 10, $useragent = null, $max_checked_feeds = 10, $force_fsockopen = false, $curl_options = array())
    {
        $this->file = $file;
        $this->useragent = $useragent;
        $this->timeout = $timeout;
        $this->max_checked_feeds = $max_checked_feeds;
        $this->force_fsockopen = $force_fsockopen;
        $this->curl_options = $curl_options;
        if (class_exists('DOMDocument')) {
            $this->dom = new DOMDocument();
            set_error_handler(array('SimplePie_Misc', 'silence_errors'));
            $this->dom->loadHTML($this->file->body);
            restore_error_handler();
        } else {
            $this->dom = null;
        }
    }
    public function set_registry(SimplePie_Registry $registry)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_registry") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Locator.php at line 87")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_registry:87@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Locator.php');
        die();
    }
    public function find($type = SIMPLEPIE_LOCATOR_ALL, &$working = null)
    {
        if ($this->is_feed($this->file)) {
            return $this->file;
        }
        if ($this->file->method & SIMPLEPIE_FILE_SOURCE_REMOTE) {
            $sniffer = $this->registry->create('Content_Type_Sniffer', array($this->file));
            if ($sniffer->get_type() !== 'text/html') {
                return null;
            }
        }
        if ($type & ~SIMPLEPIE_LOCATOR_NONE) {
            $this->get_base();
        }
        if ($type & SIMPLEPIE_LOCATOR_AUTODISCOVERY && ($working = $this->autodiscovery())) {
            return $working[0];
        }
        if ($type & (SIMPLEPIE_LOCATOR_LOCAL_EXTENSION | SIMPLEPIE_LOCATOR_LOCAL_BODY | SIMPLEPIE_LOCATOR_REMOTE_EXTENSION | SIMPLEPIE_LOCATOR_REMOTE_BODY) && $this->get_links()) {
            if ($type & SIMPLEPIE_LOCATOR_LOCAL_EXTENSION && ($working = $this->extension($this->local))) {
                return $working[0];
            }
            if ($type & SIMPLEPIE_LOCATOR_LOCAL_BODY && ($working = $this->body($this->local))) {
                return $working[0];
            }
            if ($type & SIMPLEPIE_LOCATOR_REMOTE_EXTENSION && ($working = $this->extension($this->elsewhere))) {
                return $working[0];
            }
            if ($type & SIMPLEPIE_LOCATOR_REMOTE_BODY && ($working = $this->body($this->elsewhere))) {
                return $working[0];
            }
        }
        return null;
    }
    public function is_feed($file, $check_html = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_feed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Locator.php at line 124")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_feed:124@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Locator.php');
        die();
    }
    public function get_base()
    {
        if ($this->dom === null) {
            throw new SimplePie_Exception('DOMDocument not found, unable to use locator');
        }
        $this->http_base = $this->file->url;
        $this->base = $this->http_base;
        $elements = $this->dom->getElementsByTagName('base');
        foreach ($elements as $element) {
            if ($element->hasAttribute('href')) {
                $base = $this->registry->call('Misc', 'absolutize_url', array(trim($element->getAttribute('href')), $this->http_base));
                if ($base === false) {
                    continue;
                }
                $this->base = $base;
                $this->base_location = method_exists($element, 'getLineNo') ? $element->getLineNo() : 0;
                break;
            }
        }
    }
    public function autodiscovery()
    {
        $done = array();
        $feeds = array();
        $feeds = array_merge($feeds, $this->search_elements_by_tag('link', $done, $feeds));
        $feeds = array_merge($feeds, $this->search_elements_by_tag('a', $done, $feeds));
        $feeds = array_merge($feeds, $this->search_elements_by_tag('area', $done, $feeds));
        if (!empty($feeds)) {
            return array_values($feeds);
        }
        return null;
    }
    protected function search_elements_by_tag($name, &$done, $feeds)
    {
        if ($this->dom === null) {
            throw new SimplePie_Exception('DOMDocument not found, unable to use locator');
        }
        $links = $this->dom->getElementsByTagName($name);
        foreach ($links as $link) {
            if ($this->checked_feeds === $this->max_checked_feeds) {
                break;
            }
            if ($link->hasAttribute('href') && $link->hasAttribute('rel')) {
                $rel = array_unique($this->registry->call('Misc', 'space_separated_tokens', array(strtolower($link->getAttribute('rel')))));
                $line = method_exists($link, 'getLineNo') ? $link->getLineNo() : 1;
                if ($this->base_location < $line) {
                    $href = $this->registry->call('Misc', 'absolutize_url', array(trim($link->getAttribute('href')), $this->base));
                } else {
                    $href = $this->registry->call('Misc', 'absolutize_url', array(trim($link->getAttribute('href')), $this->http_base));
                }
                if ($href === false) {
                    continue;
                }
                if (!in_array($href, $done) && in_array('feed', $rel) || in_array('alternate', $rel) && !in_array('stylesheet', $rel) && $link->hasAttribute('type') && in_array(strtolower($this->registry->call('Misc', 'parse_mime', array($link->getAttribute('type')))), array('text/html', 'application/rss+xml', 'application/atom+xml')) && !isset($feeds[$href])) {
                    $this->checked_feeds++;
                    $headers = array('Accept' => 'application/atom+xml, application/rss+xml, application/rdf+xml;q=0.9, application/xml;q=0.8, text/xml;q=0.8, text/html;q=0.7, unknown/unknown;q=0.1, application/unknown;q=0.1, */*;q=0.1');
                    $feed = $this->registry->create('File', array($href, $this->timeout, 5, $headers, $this->useragent, $this->force_fsockopen, $this->curl_options));
                    if ($feed->success && ($feed->method & SIMPLEPIE_FILE_SOURCE_REMOTE === 0 || ($feed->status_code === 200 || $feed->status_code > 206 && $feed->status_code < 300)) && $this->is_feed($feed, true)) {
                        $feeds[$href] = $feed;
                    }
                }
                $done[] = $href;
            }
        }
        return $feeds;
    }
    public function get_links()
    {
        if ($this->dom === null) {
            throw new SimplePie_Exception('DOMDocument not found, unable to use locator');
        }
        $links = $this->dom->getElementsByTagName('a');
        foreach ($links as $link) {
            if ($link->hasAttribute('href')) {
                $href = trim($link->getAttribute('href'));
                $parsed = $this->registry->call('Misc', 'parse_url', array($href));
                if ($parsed['scheme'] === '' || preg_match('/^(https?|feed)?$/i', $parsed['scheme'])) {
                    if (method_exists($link, 'getLineNo') && $this->base_location < $link->getLineNo()) {
                        $href = $this->registry->call('Misc', 'absolutize_url', array(trim($link->getAttribute('href')), $this->base));
                    } else {
                        $href = $this->registry->call('Misc', 'absolutize_url', array(trim($link->getAttribute('href')), $this->http_base));
                    }
                    if ($href === false) {
                        continue;
                    }
                    $current = $this->registry->call('Misc', 'parse_url', array($this->file->url));
                    if ($parsed['authority'] === '' || $parsed['authority'] === $current['authority']) {
                        $this->local[] = $href;
                    } else {
                        $this->elsewhere[] = $href;
                    }
                }
            }
        }
        $this->local = array_unique($this->local);
        $this->elsewhere = array_unique($this->elsewhere);
        if (!empty($this->local) || !empty($this->elsewhere)) {
            return true;
        }
        return null;
    }
    public function get_rel_link($rel)
    {
        if ($this->dom === null) {
            throw new SimplePie_Exception('DOMDocument not found, unable to use ' . 'locator');
        }
        if (!class_exists('DOMXpath')) {
            throw new SimplePie_Exception('DOMXpath not found, unable to use ' . 'get_rel_link');
        }
        $xpath = new DOMXpath($this->dom);
        $query = '//a[@rel and @href] | //link[@rel and @href]';
        foreach ($xpath->query($query) as $link) {
            $href = trim($link->getAttribute('href'));
            $parsed = $this->registry->call('Misc', 'parse_url', array($href));
            if ($parsed['scheme'] === '' || preg_match('/^https?$/i', $parsed['scheme'])) {
                if (method_exists($link, 'getLineNo') && $this->base_location < $link->getLineNo()) {
                    $href = $this->registry->call('Misc', 'absolutize_url', array(trim($link->getAttribute('href')), $this->base));
                } else {
                    $href = $this->registry->call('Misc', 'absolutize_url', array(trim($link->getAttribute('href')), $this->http_base));
                }
                if ($href === false) {
                    return null;
                }
                $rel_values = explode(' ', strtolower($link->getAttribute('rel')));
                if (in_array($rel, $rel_values)) {
                    return $href;
                }
            }
        }
        return null;
    }
    public function extension(&$array)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("extension") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Locator.php at line 271")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called extension:271@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Locator.php');
        die();
    }
    public function body(&$array)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("body") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Locator.php at line 290")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called body:290@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/SimplePie/Locator.php');
        die();
    }
}