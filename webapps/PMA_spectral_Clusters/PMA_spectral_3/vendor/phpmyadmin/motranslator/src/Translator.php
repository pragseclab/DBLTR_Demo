<?php

declare (strict_types=1);
/*
    Copyright (c) 2003, 2009 Danilo Segan <danilo@kvota.net>.
    Copyright (c) 2005 Nico Kaiser <nico@siriux.net>
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

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Throwable;
use function array_key_exists;
use function chr;
use function count;
use function explode;
use function implode;
use function intval;
use function is_readable;
use function ltrim;
use function preg_replace;
use function rtrim;
use function strcmp;
use function stripos;
use function strpos;
use function strtolower;
use function substr;
use function trim;
/**
 * Provides a simple gettext replacement that works independently from
 * the system's gettext abilities.
 * It can read MO files and use them for translating strings.
 *
 * It caches ll strings and translations to speed up the string lookup.
 */
class Translator
{
    /**
     * None error.
     */
    public const ERROR_NONE = 0;
    /**
     * File does not exist.
     */
    public const ERROR_DOES_NOT_EXIST = 1;
    /**
     * File has bad magic number.
     */
    public const ERROR_BAD_MAGIC = 2;
    /**
     * Error while reading file, probably too short.
     */
    public const ERROR_READING = 3;
    /**
     * Big endian mo file magic bytes.
     */
    public const MAGIC_BE = "\x95\x04\x12\xde";
    /**
     * Little endian mo file magic bytes.
     */
    public const MAGIC_LE = "\xde\x12\x04\x95";
    /**
     * Parse error code (0 if no error).
     *
     * @var int
     */
    public $error = self::ERROR_NONE;
    /**
     * Cache header field for plural forms.
     *
     * @var string|null
     */
    private $pluralEquation = null;
    /** @var ExpressionLanguage|null Evaluator for plurals */
    private $pluralExpression = null;
    /** @var int|null number of plurals */
    private $pluralCount = null;
    /**
     * Array with original -> translation mapping.
     *
     * @var array<string,string>
     */
    private $cacheTranslations = [];
    /**
     * @param string|null $filename Name of mo file to load (null to not load a file)
     */
    public function __construct(?string $filename)
    {
        // The user can load the translations manually
        if ($filename === null) {
            return;
        }
        $this->loadTranslationsFromFile($filename);
    }
    /**
     * Load a Mo file translations
     *
     * @param string $filename Name of mo file to load
     */
    private function loadTranslationsFromFile(string $filename) : void
    {
        if (!is_readable($filename)) {
            $this->error = self::ERROR_DOES_NOT_EXIST;
            return;
        }
        $stream = new StringReader($filename);
        try {
            $magic = $stream->read(0, 4);
            if (strcmp($magic, self::MAGIC_LE) === 0) {
                $unpack = 'V';
            } elseif (strcmp($magic, self::MAGIC_BE) === 0) {
                $unpack = 'N';
            } else {
                $this->error = self::ERROR_BAD_MAGIC;
                return;
            }
            /* Parse header */
            $total = $stream->readint($unpack, 8);
            $originals = $stream->readint($unpack, 12);
            $translations = $stream->readint($unpack, 16);
            /* get original and translations tables */
            $totalTimesTwo = (int) ($total * 2);
            // Fix for issue #36 on ARM
            $tableOriginals = $stream->readintarray($unpack, $originals, $totalTimesTwo);
            $tableTranslations = $stream->readintarray($unpack, $translations, $totalTimesTwo);
            /* read all strings to the cache */
            for ($i = 0; $i < $total; ++$i) {
                $iTimesTwo = $i * 2;
                $iPlusOne = $iTimesTwo + 1;
                $iPlusTwo = $iTimesTwo + 2;
                $original = $stream->read($tableOriginals[$iPlusTwo], $tableOriginals[$iPlusOne]);
                $translation = $stream->read($tableTranslations[$iPlusTwo], $tableTranslations[$iPlusOne]);
                $this->cacheTranslations[$original] = $translation;
            }
        } catch (ReaderException $e) {
            $this->error = self::ERROR_READING;
            return;
        }
    }
    /**
     * Translates a string.
     *
     * @param string $msgid String to be translated
     *
     * @return string translated string (or original, if not found)
     */
    public function gettext(string $msgid) : string
    {
        if (array_key_exists($msgid, $this->cacheTranslations)) {
            return $this->cacheTranslations[$msgid];
        }
        return $msgid;
    }
    /**
     * Check if a string is translated.
     *
     * @param string $msgid String to be checked
     */
    public function exists(string $msgid) : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exists") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 177")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exists:177@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
    /**
     * Sanitize plural form expression for use in ExpressionLanguage.
     *
     * @param string $expr Expression to sanitize
     *
     * @return string sanitized plural form expression
     */
    public static function sanitizePluralExpression(string $expr) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitizePluralExpression") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 189")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sanitizePluralExpression:189@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
    /**
     * Extracts number of plurals from plurals form expression.
     *
     * @param string $expr Expression to process
     *
     * @return int Total number of plurals
     */
    public static function extractPluralCount(string $expr) : int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("extractPluralCount") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 217")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called extractPluralCount:217@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
    /**
     * Parse full PO header and extract only plural forms line.
     *
     * @param string $header Gettext header
     *
     * @return string verbatim plural form header field
     */
    public static function extractPluralsForms(string $header) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("extractPluralsForms") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 236")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called extractPluralsForms:236@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
    /**
     * Get possible plural forms from MO header.
     *
     * @return string plural form header
     */
    private function getPluralForms() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPluralForms") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 256")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPluralForms:256@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
    /**
     * Detects which plural form to take.
     *
     * @param int $n count of objects
     *
     * @return int array index of the right plural form
     */
    private function selectString(int $n) : int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("selectString") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 277")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called selectString:277@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
    /**
     * Plural version of gettext.
     *
     * @param string $msgid       Single form
     * @param string $msgidPlural Plural form
     * @param int    $number      Number of objects
     *
     * @return string translated plural form
     */
    public function ngettext(string $msgid, string $msgidPlural, int $number) : string
    {
        // this should contains all strings separated by NULLs
        $key = implode(chr(0), [$msgid, $msgidPlural]);
        if (!array_key_exists($key, $this->cacheTranslations)) {
            return $number !== 1 ? $msgidPlural : $msgid;
        }
        // find out the appropriate form
        $select = $this->selectString($number);
        $result = $this->cacheTranslations[$key];
        $list = explode(chr(0), $result);
        // @codeCoverageIgnoreStart
        if ($list === false) {
            // This was added in 3ff2c63bcf85f81b3a205ce7222de11b33e2bf56 for phpstan
            // But according to the php manual it should never happen
            return '';
        }
        // @codeCoverageIgnoreEnd
        if (!isset($list[$select])) {
            return $list[0];
        }
        return $list[$select];
    }
    /**
     * Translate with context.
     *
     * @param string $msgctxt Context
     * @param string $msgid   String to be translated
     *
     * @return string translated plural form
     */
    public function pgettext(string $msgctxt, string $msgid) : string
    {
        $key = implode(chr(4), [$msgctxt, $msgid]);
        $ret = $this->gettext($key);
        if (strpos($ret, chr(4)) !== false) {
            return $msgid;
        }
        return $ret;
    }
    /**
     * Plural version of pgettext.
     *
     * @param string $msgctxt     Context
     * @param string $msgid       Single form
     * @param string $msgidPlural Plural form
     * @param int    $number      Number of objects
     *
     * @return string translated plural form
     */
    public function npgettext(string $msgctxt, string $msgid, string $msgidPlural, int $number) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("npgettext") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 351")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called npgettext:351@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
    /**
     * Set translation in place
     *
     * @param string $msgid  String to be set
     * @param string $msgstr Translation
     */
    public function setTranslation(string $msgid, string $msgstr) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setTranslation") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 366")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setTranslation:366@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
    /**
     * Set the translations
     *
     * @param array<string,string> $translations The translations "key => value" array
     */
    public function setTranslations(array $translations) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setTranslations") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 375")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setTranslations:375@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
    /**
     * Get the translations
     *
     * @return array<string,string> The translations "key => value" array
     */
    public function getTranslations() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTranslations") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php at line 384")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTranslations:384@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/phpmyadmin/motranslator/src/Translator.php');
        die();
    }
}