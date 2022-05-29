<?php

/*
    Copyright (c) 2005 Steven Armstrong <sa at c-area dot ch>
    Copyright (c) 2009 Danilo Segan <danilo@kvota.net>
    Copyright (c) 2016 Michal Čihař <michal@cihar.com>

    This file is part of MoTranslator.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/
namespace PhpMyAdmin\MoTranslator;

class Loader
{
    /**
     * Loader instance.
     *
     * @static
     *
     * @var Loader
     */
    private static $_instance;
    /**
     * Default gettext domain to use.
     *
     * @var string
     */
    private $default_domain = '';
    /**
     * Configured locale.
     *
     * @var string
     */
    private $locale = '';
    /**
     * Loaded domains.
     *
     * @var array
     */
    private $domains = array();
    /**
     * Bound paths for domains.
     *
     * @var array
     */
    private $paths = array('' => './');
    /**
     * Returns the singleton Loader object.
     *
     * @return Loader object
     */
    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * Loads global localizaton functions.
     */
    public static function loadFunctions()
    {
        require_once __DIR__ . '/functions.php';
    }
    /**
     * Figure out all possible locale names and start with the most
     * specific ones.  I.e. for sr_CS.UTF-8@latin, look through all of
     * sr_CS.UTF-8@latin, sr_CS@latin, sr@latin, sr_CS.UTF-8, sr_CS, sr.
     *
     * @param string $locale Locale code
     *
     * @return array list of locales to try for any POSIX-style locale specification
     */
    public static function listLocales($locale)
    {
        $locale_names = array();
        $lang = null;
        $country = null;
        $charset = null;
        $modifier = null;
        if ($locale) {
            if (preg_match(
                '/^(?P<lang>[a-z]{2,3})' . '(?:_(?P<country>[A-Z]{2}))?' . '(?:\\.(?P<charset>[-A-Za-z0-9_]+))?' . '(?:@(?P<modifier>[-A-Za-z0-9_]+))?$/',
                // @ modifier
                $locale,
                $matches
            )) {
                extract($matches);
                if ($modifier) {
                    if ($country) {
                        if ($charset) {
                            array_push($locale_names, "{$lang}_{$country}.{$charset}@{$modifier}");
                        }
                        array_push($locale_names, "{$lang}_{$country}@{$modifier}");
                    } elseif ($charset) {
                        array_push($locale_names, "{$lang}.{$charset}@{$modifier}");
                    }
                    array_push($locale_names, "{$lang}@{$modifier}");
                }
                if ($country) {
                    if ($charset) {
                        array_push($locale_names, "{$lang}_{$country}.{$charset}");
                    }
                    array_push($locale_names, "{$lang}_{$country}");
                } elseif ($charset) {
                    array_push($locale_names, "{$lang}.{$charset}");
                }
                array_push($locale_names, $lang);
            }
            // If the locale name doesn't match POSIX style, just include it as-is.
            if (!in_array($locale, $locale_names)) {
                array_push($locale_names, $locale);
            }
        }
        return $locale_names;
    }
    /**
     * Returns Translator object for domain or for default domain.
     *
     * @param string $domain Translation domain
     *
     * @return Translator
     */
    public function getTranslator($domain = '')
    {
        if (empty($domain)) {
            $domain = $this->default_domain;
        }
        if (!isset($this->domains[$domain])) {
            if (isset($this->paths[$domain])) {
                $base = $this->paths[$domain];
            } else {
                $base = './';
            }
            $locale_names = $this->listLocales($this->locale);
            $filename = '';
            foreach ($locale_names as $locale) {
                $filename = "{$base}/{$locale}/LC_MESSAGES/{$domain}.mo";
                if (file_exists($filename)) {
                    break;
                }
            }
            // We don't care about invalid path, we will get fallback
            // translator here
            $this->domains[$domain] = new Translator($filename);
        }
        return $this->domains[$domain];
    }
    /**
     * Sets the path for a domain.
     *
     * @param string $domain Domain name
     * @param string $path   Path where to find locales
     */
    public function bindtextdomain($domain, $path)
    {
        $this->paths[$domain] = $path;
    }
    /**
     * Sets the default domain.
     *
     * @param string $domain Domain name
     */
    public function textdomain($domain)
    {
        $this->default_domain = $domain;
    }
    /**
     * Sets a requested locale.
     *
     * @param string $locale Locale name
     *
     * @return string Set or current locale
     */
    public function setlocale($locale)
    {
        if (!empty($locale)) {
            $this->locale = $locale;
            // Set system locales as well
            if (function_exists('setlocale')) {
                setlocale(0, $locale);
            }
        }
        return $this->locale;
    }
    /**
     * Detects currently configured locale.
     *
     * It checks:
     *
     * - global lang variable
     * - environment for LC_ALL, LC_MESSAGES and LANG
     *
     * @return string with locale name
     */
    public function detectlocale()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("detectlocale") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/motranslator/src/Loader.php at line 235")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called detectlocale:235@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/vendor/phpmyadmin/motranslator/src/Loader.php');
        die();
    }
}