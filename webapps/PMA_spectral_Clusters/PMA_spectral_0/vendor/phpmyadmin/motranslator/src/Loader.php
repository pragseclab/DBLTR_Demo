<?php

declare (strict_types=1);
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

use function array_push;
use function file_exists;
use function getenv;
use function in_array;
use function preg_match;
use function sprintf;
class Loader
{
    /**
     * Loader instance.
     *
     * @static
     * @var Loader
     */
    private static $instance;
    /**
     * Default gettext domain to use.
     *
     * @var string
     */
    private $defaultDomain = '';
    /**
     * Configured locale.
     *
     * @var string
     */
    private $locale = '';
    /**
     * Loaded domains.
     *
     * @var array<string,array<string,Translator>>
     */
    private $domains = array();
    /**
     * Bound paths for domains.
     *
     * @var array<string,string>
     */
    private $paths = array('' => './');
    /**
     * Returns the singleton Loader object.
     *
     * @return Loader object
     */
    public static function getInstance() : Loader
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * Loads global localization functions.
     */
    public static function loadFunctions() : void
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
     * @return string[] list of locales to try for any POSIX-style locale specification
     */
    public static function listLocales(string $locale) : array
    {
        $localeNames = [];
        if ($locale) {
            if (preg_match(
                '/^(?P<lang>[a-z]{2,3})' . '(?:_(?P<country>[A-Z]{2}))?' . '(?:\\.(?P<charset>[-A-Za-z0-9_]+))?' . '(?:@(?P<modifier>[-A-Za-z0-9_]+))?$/',
                // @ modifier
                $locale,
                $matches
            )) {
                $lang = $matches['lang'] ?? null;
                $country = $matches['country'] ?? null;
                $charset = $matches['charset'] ?? null;
                $modifier = $matches['modifier'] ?? null;
                if ($modifier) {
                    if ($country) {
                        if ($charset) {
                            array_push($localeNames, sprintf('%s_%s.%s@%s', $lang, $country, $charset, $modifier));
                        }
                        array_push($localeNames, sprintf('%s_%s@%s', $lang, $country, $modifier));
                    } elseif ($charset) {
                        array_push($localeNames, sprintf('%s.%s@%s', $lang, $charset, $modifier));
                    }
                    array_push($localeNames, sprintf('%s@%s', $lang, $modifier));
                }
                if ($country) {
                    if ($charset) {
                        array_push($localeNames, sprintf('%s_%s.%s', $lang, $country, $charset));
                    }
                    array_push($localeNames, sprintf('%s_%s', $lang, $country));
                } elseif ($charset) {
                    array_push($localeNames, sprintf('%s.%s', $lang, $charset));
                }
                array_push($localeNames, $lang);
            }
            // If the locale name doesn't match POSIX style, just include it as-is.
            if (!in_array($locale, $localeNames)) {
                array_push($localeNames, $locale);
            }
        }
        return $localeNames;
    }
    /**
     * Returns Translator object for domain or for default domain.
     *
     * @param string $domain Translation domain
     */
    public function getTranslator(string $domain = '') : Translator
    {
        if (empty($domain)) {
            $domain = $this->defaultDomain;
        }
        if (!isset($this->domains[$this->locale])) {
            $this->domains[$this->locale] = [];
        }
        if (!isset($this->domains[$this->locale][$domain])) {
            if (isset($this->paths[$domain])) {
                $base = $this->paths[$domain];
            } else {
                $base = './';
            }
            $localeNames = $this->listLocales($this->locale);
            $filename = '';
            foreach ($localeNames as $locale) {
                $filename = $base . '/' . $locale . '/LC_MESSAGES/' . $domain . '.mo';
                if (file_exists($filename)) {
                    break;
                }
            }
            // We don't care about invalid path, we will get fallback
            // translator here
            $this->domains[$this->locale][$domain] = new Translator($filename);
        }
        return $this->domains[$this->locale][$domain];
    }
    /**
     * Sets the path for a domain.
     *
     * @param string $domain Domain name
     * @param string $path   Path where to find locales
     */
    public function bindtextdomain(string $domain, string $path) : void
    {
        $this->paths[$domain] = $path;
    }
    /**
     * Sets the default domain.
     *
     * @param string $domain Domain name
     */
    public function textdomain(string $domain) : void
    {
        $this->defaultDomain = $domain;
    }
    /**
     * Sets a requested locale.
     *
     * @param string $locale Locale name
     *
     * @return string Set or current locale
     */
    public function setlocale(string $locale) : string
    {
        if (!empty($locale)) {
            $this->locale = $locale;
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
    public function detectlocale() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("detectlocale") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/motranslator/src/Loader.php at line 214")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called detectlocale:214@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/motranslator/src/Loader.php');
        die();
    }
}