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
 * Manages all item-related data
 *
 * Used by {@see SimplePie::get_item()} and {@see SimplePie::get_items()}
 *
 * This class can be overloaded with {@see SimplePie::set_item_class()}
 *
 * @package SimplePie
 * @subpackage API
 */
class SimplePie_Item
{
    /**
     * Parent feed
     *
     * @access private
     * @var SimplePie
     */
    var $feed;
    /**
     * Raw data
     *
     * @access private
     * @var array
     */
    var $data = array();
    /**
     * Registry object
     *
     * @see set_registry
     * @var SimplePie_Registry
     */
    protected $registry;
    /**
     * Create a new item object
     *
     * This is usually used by {@see SimplePie::get_items} and
     * {@see SimplePie::get_item}. Avoid creating this manually.
     *
     * @param SimplePie $feed Parent feed
     * @param array $data Raw data
     */
    public function __construct($feed, $data)
    {
        $this->feed = $feed;
        $this->data = $data;
    }
    /**
     * Set the registry handler
     *
     * This is usually used by {@see SimplePie_Registry::create}
     *
     * @since 1.3
     * @param SimplePie_Registry $registry
     */
    public function set_registry(SimplePie_Registry $registry)
    {
        $this->registry = $registry;
    }
    /**
     * Get a string representation of the item
     *
     * @return string
     */
    public function __toString()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__toString") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 110")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __toString:110@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Remove items that link back to this before destroying this object
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
        if (!gc_enabled()) {
            unset($this->feed);
        }
        if (function_exists('end_coverage_cav39s8hca')) {
            if ($stop_coverage) {
                end_coverage_cav39s8hca($stop_coverage);
            }
        }
    }
    /**
     * Get data for an item-level element
     *
     * This method allows you to get access to ANY element/attribute that is a
     * sub-element of the item/entry tag.
     *
     * See {@see SimplePie::get_feed_tags()} for a description of the return value
     *
     * @since 1.0
     * @see http://simplepie.org/wiki/faq/supported_xml_namespaces
     * @param string $namespace The URL of the XML namespace of the elements you're trying to access
     * @param string $tag Tag name
     * @return array
     */
    public function get_item_tags($namespace, $tag)
    {
        if (isset($this->data['child'][$namespace][$tag])) {
            return $this->data['child'][$namespace][$tag];
        }
        return null;
    }
    /**
     * Get the base URL value from the parent feed
     *
     * Uses `<xml:base>`
     *
     * @param array $element
     * @return string
     */
    public function get_base($element = array())
    {
        return $this->feed->get_base($element);
    }
    /**
     * Sanitize feed data
     *
     * @access private
     * @see SimplePie::sanitize()
     * @param string $data Data to sanitize
     * @param int $type One of the SIMPLEPIE_CONSTRUCT_* constants
     * @param string $base Base URL to resolve URLs against
     * @return string Sanitized data
     */
    public function sanitize($data, $type, $base = '')
    {
        return $this->feed->sanitize($data, $type, $base);
    }
    /**
     * Get the parent feed
     *
     * Note: this may not work as you think for multifeeds!
     *
     * @link http://simplepie.org/faq/typical_multifeed_gotchas#missing_data_from_feed
     * @since 1.0
     * @return SimplePie
     */
    public function get_feed()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_feed") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 191")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_feed:191@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the unique identifier for the item
     *
     * This is usually used when writing code to check for new items in a feed.
     *
     * Uses `<atom:id>`, `<guid>`, `<dc:identifier>` or the `about` attribute
     * for RDF. If none of these are supplied (or `$hash` is true), creates an
     * MD5 hash based on the permalink, title and content.
     *
     * @since Beta 2
     * @param boolean $hash Should we force using a hash instead of the supplied ID?
     * @param string|false $fn User-supplied function to generate an hash
     * @return string|null
     */
    public function get_id($hash = false, $fn = 'md5')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_id") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 209")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_id:209@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the title of the item
     *
     * Uses `<atom:title>`, `<title>` or `<dc:title>`
     *
     * @since Beta 2 (previously called `get_item_title` since 0.8)
     * @return string|null
     */
    public function get_title()
    {
        if (!isset($this->data['title'])) {
            if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'title')) {
                $this->data['title'] = $this->sanitize($return[0]['data'], $this->registry->call('Misc', 'atom_10_construct_type', array($return[0]['attribs'])), $this->get_base($return[0]));
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'title')) {
                $this->data['title'] = $this->sanitize($return[0]['data'], $this->registry->call('Misc', 'atom_03_construct_type', array($return[0]['attribs'])), $this->get_base($return[0]));
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'title')) {
                $this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_MAYBE_HTML, $this->get_base($return[0]));
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'title')) {
                $this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_MAYBE_HTML, $this->get_base($return[0]));
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'title')) {
                $this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_MAYBE_HTML, $this->get_base($return[0]));
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'title')) {
                $this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'title')) {
                $this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
            } else {
                $this->data['title'] = null;
            }
        }
        return $this->data['title'];
    }
    /**
     * Get the content for the item
     *
     * Prefers summaries over full content , but will return full content if a
     * summary does not exist.
     *
     * To prefer full content instead, use {@see get_content}
     *
     * Uses `<atom:summary>`, `<description>`, `<dc:description>` or
     * `<itunes:subtitle>`
     *
     * @since 0.8
     * @param boolean $description_only Should we avoid falling back to the content?
     * @return string|null
     */
    public function get_description($description_only = false)
    {
        if (($tags = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'summary')) && ($return = $this->sanitize($tags[0]['data'], $this->registry->call('Misc', 'atom_10_construct_type', array($tags[0]['attribs'])), $this->get_base($tags[0])))) {
            return $return;
        } elseif (($tags = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'summary')) && ($return = $this->sanitize($tags[0]['data'], $this->registry->call('Misc', 'atom_03_construct_type', array($tags[0]['attribs'])), $this->get_base($tags[0])))) {
            return $return;
        } elseif (($tags = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'description')) && ($return = $this->sanitize($tags[0]['data'], SIMPLEPIE_CONSTRUCT_MAYBE_HTML, $this->get_base($tags[0])))) {
            return $return;
        } elseif (($tags = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'description')) && ($return = $this->sanitize($tags[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($tags[0])))) {
            return $return;
        } elseif (($tags = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'description')) && ($return = $this->sanitize($tags[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT))) {
            return $return;
        } elseif (($tags = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'description')) && ($return = $this->sanitize($tags[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT))) {
            return $return;
        } elseif (($tags = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ITUNES, 'summary')) && ($return = $this->sanitize($tags[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($tags[0])))) {
            return $return;
        } elseif (($tags = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ITUNES, 'subtitle')) && ($return = $this->sanitize($tags[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT))) {
            return $return;
        } elseif (($tags = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'description')) && ($return = $this->sanitize($tags[0]['data'], SIMPLEPIE_CONSTRUCT_HTML))) {
            return $return;
        } elseif (!$description_only) {
            return $this->get_content(true);
        }
        return null;
    }
    /**
     * Get the content for the item
     *
     * Prefers full content over summaries, but will return a summary if full
     * content does not exist.
     *
     * To prefer summaries instead, use {@see get_description}
     *
     * Uses `<atom:content>` or `<content:encoded>` (RSS 1.0 Content Module)
     *
     * @since 1.0
     * @param boolean $content_only Should we avoid falling back to the description?
     * @return string|null
     */
    public function get_content($content_only = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_content") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 319")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_content:319@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the media:thumbnail of the item
     *
     * Uses `<media:thumbnail>`
     *
     *
     * @return array|null
     */
    public function get_thumbnail()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_thumbnail") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 340")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_thumbnail:340@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get a category for the item
     *
     * @since Beta 3 (previously called `get_categories()` since Beta 2)
     * @param int $key The category that you want to return.  Remember that arrays begin with 0, not 1
     * @return SimplePie_Category|null
     */
    public function get_category($key = 0)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_category") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 358")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_category:358@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get all categories for the item
     *
     * Uses `<atom:category>`, `<category>` or `<dc:subject>`
     *
     * @since Beta 3
     * @return SimplePie_Category[]|null List of {@see SimplePie_Category} objects
     */
    public function get_categories()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_categories") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 374")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_categories:374@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get an author for the item
     *
     * @since Beta 2
     * @param int $key The author that you want to return.  Remember that arrays begin with 0, not 1
     * @return SimplePie_Author|null
     */
    public function get_author($key = 0)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_author") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 423")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_author:423@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get a contributor for the item
     *
     * @since 1.1
     * @param int $key The contrbutor that you want to return.  Remember that arrays begin with 0, not 1
     * @return SimplePie_Author|null
     */
    public function get_contributor($key = 0)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_contributor") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 438")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_contributor:438@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get all contributors for the item
     *
     * Uses `<atom:contributor>`
     *
     * @since 1.1
     * @return SimplePie_Author[]|null List of {@see SimplePie_Author} objects
     */
    public function get_contributors()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_contributors") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 454")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_contributors:454@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get all authors for the item
     *
     * Uses `<atom:author>`, `<author>`, `<dc:creator>` or `<itunes:author>`
     *
     * @since Beta 2
     * @return SimplePie_Author[]|null List of {@see SimplePie_Author} objects
     */
    public function get_authors()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_authors") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 504")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_authors:504@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the copyright info for the item
     *
     * Uses `<atom:rights>` or `<dc:rights>`
     *
     * @since 1.1
     * @return string
     */
    public function get_copyright()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_copyright") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 570")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_copyright:570@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the posting date/time for the item
     *
     * Uses `<atom:published>`, `<atom:updated>`, `<atom:issued>`,
     * `<atom:modified>`, `<pubDate>` or `<dc:date>`
     *
     * Note: obeys PHP's timezone setting. To get a UTC date/time, use
     * {@see get_gmdate}
     *
     * @since Beta 2 (previously called `get_item_date` since 0.8)
     *
     * @param string $date_format Supports any PHP date format from {@see http://php.net/date} (empty for the raw data)
     * @return int|string|null
     */
    public function get_date($date_format = 'j F Y, g:i a')
    {
        if (!isset($this->data['date'])) {
            if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'published')) {
                $this->data['date']['raw'] = $return[0]['data'];
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'pubDate')) {
                $this->data['date']['raw'] = $return[0]['data'];
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'date')) {
                $this->data['date']['raw'] = $return[0]['data'];
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'date')) {
                $this->data['date']['raw'] = $return[0]['data'];
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'updated')) {
                $this->data['date']['raw'] = $return[0]['data'];
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'issued')) {
                $this->data['date']['raw'] = $return[0]['data'];
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'created')) {
                $this->data['date']['raw'] = $return[0]['data'];
            } elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'modified')) {
                $this->data['date']['raw'] = $return[0]['data'];
            }
            if (!empty($this->data['date']['raw'])) {
                $parser = $this->registry->call('Parse_Date', 'get');
                $this->data['date']['parsed'] = $parser->parse($this->data['date']['raw']);
            } else {
                $this->data['date'] = null;
            }
        }
        if ($this->data['date']) {
            $date_format = (string) $date_format;
            switch ($date_format) {
                case '':
                    return $this->sanitize($this->data['date']['raw'], SIMPLEPIE_CONSTRUCT_TEXT);
                case 'U':
                    return $this->data['date']['parsed'];
                default:
                    return date($date_format, $this->data['date']['parsed']);
            }
        }
        return null;
    }
    /**
     * Get the update date/time for the item
     *
     * Uses `<atom:updated>`
     *
     * Note: obeys PHP's timezone setting. To get a UTC date/time, use
     * {@see get_gmdate}
     *
     * @param string $date_format Supports any PHP date format from {@see http://php.net/date} (empty for the raw data)
     * @return int|string|null
     */
    public function get_updated_date($date_format = 'j F Y, g:i a')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_updated_date") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 646")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_updated_date:646@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the localized posting date/time for the item
     *
     * Returns the date formatted in the localized language. To display in
     * languages other than the server's default, you need to change the locale
     * with {@link http://php.net/setlocale setlocale()}. The available
     * localizations depend on which ones are installed on your web server.
     *
     * @since 1.0
     *
     * @param string $date_format Supports any PHP date format from {@see http://php.net/strftime} (empty for the raw data)
     * @return int|string|null
     */
    public function get_local_date($date_format = '%c')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_local_date") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 685")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_local_date:685@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the posting date/time for the item (UTC time)
     *
     * @see get_date
     * @param string $date_format Supports any PHP date format from {@see http://php.net/date}
     * @return int|string|null
     */
    public function get_gmdate($date_format = 'j F Y, g:i a')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_gmdate") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 701")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_gmdate:701@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the update date/time for the item (UTC time)
     *
     * @see get_updated_date
     * @param string $date_format Supports any PHP date format from {@see http://php.net/date}
     * @return int|string|null
     */
    public function get_updated_gmdate($date_format = 'j F Y, g:i a')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_updated_gmdate") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 716")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_updated_gmdate:716@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the permalink for the item
     *
     * Returns the first link available with a relationship of "alternate".
     * Identical to {@see get_link()} with key 0
     *
     * @see get_link
     * @since 0.8
     * @return string|null Permalink URL
     */
    public function get_permalink()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_permalink") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 734")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_permalink:734@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get a single link for the item
     *
     * @since Beta 3
     * @param int $key The link that you want to return.  Remember that arrays begin with 0, not 1
     * @param string $rel The relationship of the link to return
     * @return string|null Link URL
     */
    public function get_link($key = 0, $rel = 'alternate')
    {
        $links = $this->get_links($rel);
        if ($links && $links[$key] !== null) {
            return $links[$key];
        }
        return null;
    }
    /**
     * Get all links for the item
     *
     * Uses `<atom:link>`, `<link>` or `<guid>`
     *
     * @since Beta 2
     * @param string $rel The relationship of links to return
     * @return array|null Links found for the item (strings)
     */
    public function get_links($rel = 'alternate')
    {
        if (!isset($this->data['links'])) {
            $this->data['links'] = array();
            foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'link') as $link) {
                if (isset($link['attribs']['']['href'])) {
                    $link_rel = isset($link['attribs']['']['rel']) ? $link['attribs']['']['rel'] : 'alternate';
                    $this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));
                }
            }
            foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'link') as $link) {
                if (isset($link['attribs']['']['href'])) {
                    $link_rel = isset($link['attribs']['']['rel']) ? $link['attribs']['']['rel'] : 'alternate';
                    $this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));
                }
            }
            if ($links = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'link')) {
                $this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
            }
            if ($links = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'link')) {
                $this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
            }
            if ($links = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'link')) {
                $this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
            }
            if ($links = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'guid')) {
                if (!isset($links[0]['attribs']['']['isPermaLink']) || strtolower(trim($links[0]['attribs']['']['isPermaLink'])) === 'true') {
                    $this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
                }
            }
            $keys = array_keys($this->data['links']);
            foreach ($keys as $key) {
                if ($this->registry->call('Misc', 'is_isegment_nz_nc', array($key))) {
                    if (isset($this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key])) {
                        $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] = array_merge($this->data['links'][$key], $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key]);
                        $this->data['links'][$key] =& $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key];
                    } else {
                        $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] =& $this->data['links'][$key];
                    }
                } elseif (substr($key, 0, 41) === SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY) {
                    $this->data['links'][substr($key, 41)] =& $this->data['links'][$key];
                }
                $this->data['links'][$key] = array_unique($this->data['links'][$key]);
            }
        }
        if (isset($this->data['links'][$rel])) {
            return $this->data['links'][$rel];
        }
        return null;
    }
    /**
     * Get an enclosure from the item
     *
     * Supports the <enclosure> RSS tag, as well as Media RSS and iTunes RSS.
     *
     * @since Beta 2
     * @todo Add ability to prefer one type of content over another (in a media group).
     * @param int $key The enclosure that you want to return.  Remember that arrays begin with 0, not 1
     * @return SimplePie_Enclosure|null
     */
    public function get_enclosure($key = 0, $prefer = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_enclosure") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 830")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_enclosure:830@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get all available enclosures (podcasts, etc.)
     *
     * Supports the <enclosure> RSS tag, as well as Media RSS and iTunes RSS.
     *
     * At this point, we're pretty much assuming that all enclosures for an item
     * are the same content.  Anything else is too complicated to
     * properly support.
     *
     * @since Beta 2
     * @todo Add support for end-user defined sorting of enclosures by type/handler (so we can prefer the faster-loading FLV over MP4).
     * @todo If an element exists at a level, but its value is empty, we should fall back to the value from the parent (if it exists).
     * @return SimplePie_Enclosure[]|null List of SimplePie_Enclosure items
     */
    public function get_enclosures()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_enclosures") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 852")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_enclosures:852@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the latitude coordinates for the item
     *
     * Compatible with the W3C WGS84 Basic Geo and GeoRSS specifications
     *
     * Uses `<geo:lat>` or `<georss:point>`
     *
     * @since 1.0
     * @link http://www.w3.org/2003/01/geo/ W3C WGS84 Basic Geo
     * @link http://www.georss.org/ GeoRSS
     * @return string|null
     */
    public function get_latitude()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_latitude") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 2162")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_latitude:2162@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the longitude coordinates for the item
     *
     * Compatible with the W3C WGS84 Basic Geo and GeoRSS specifications
     *
     * Uses `<geo:long>`, `<geo:lon>` or `<georss:point>`
     *
     * @since 1.0
     * @link http://www.w3.org/2003/01/geo/ W3C WGS84 Basic Geo
     * @link http://www.georss.org/ GeoRSS
     * @return string|null
     */
    public function get_longitude()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_longitude") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 2183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_longitude:2183@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
    /**
     * Get the `<atom:source>` for the item
     *
     * @since 1.1
     * @return SimplePie_Source|null
     */
    public function get_source()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_source") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php at line 2200")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_source:2200@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/SimplePie/Item.php');
        die();
    }
}