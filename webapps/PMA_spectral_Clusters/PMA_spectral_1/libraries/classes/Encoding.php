<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use function array_intersect;
use function array_map;
use function explode;
use function fclose;
use function feof;
use function fgets;
use function fopen;
use function function_exists;
use function fwrite;
use function recode_string;
use function mb_convert_encoding;
use function mb_convert_kana;
use function mb_detect_encoding;
use function mb_list_encodings;
use function tempnam;
use function unlink;
use function iconv;
/**
 * Encoding conversion helper class
 */
class Encoding
{
    /**
     * None encoding conversion engine
     */
    public const ENGINE_NONE = 0;
    /**
     * iconv encoding conversion engine
     */
    public const ENGINE_ICONV = 1;
    /**
     * recode encoding conversion engine
     */
    public const ENGINE_RECODE = 2;
    /**
     * mbstring encoding conversion engine
     */
    public const ENGINE_MB = 3;
    /**
     * Chosen encoding engine
     *
     * @var int
     */
    private static $engine = null;
    /**
     * Map of conversion engine configurations
     *
     * Each entry contains:
     *
     * - function to detect
     * - engine contant
     * - extension name to warn when missing
     *
     * @var array
     */
    private static $enginemap = ['iconv' => ['iconv', self::ENGINE_ICONV, 'iconv'], 'recode' => ['recode_string', self::ENGINE_RECODE, 'recode'], 'mb' => ['mb_convert_encoding', self::ENGINE_MB, 'mbstring'], 'none' => ['isset', self::ENGINE_NONE, '']];
    /**
     * Order of automatic detection of engines
     *
     * @var array
     */
    private static $engineorder = ['iconv', 'mb', 'recode'];
    /**
     * Kanji encodings list
     *
     * @var string
     */
    private static $kanjiEncodings = 'ASCII,SJIS,EUC-JP,JIS';
    /**
     * Initializes encoding engine detecting available backends.
     */
    public static function initEngine() : void
    {
        $engine = 'auto';
        if (isset($GLOBALS['cfg']['RecodingEngine'])) {
            $engine = $GLOBALS['cfg']['RecodingEngine'];
        }
        /* Use user configuration */
        if (isset(self::$enginemap[$engine])) {
            if (function_exists(self::$enginemap[$engine][0])) {
                self::$engine = self::$enginemap[$engine][1];
                return;
            }
            Core::warnMissingExtension(self::$enginemap[$engine][2]);
        }
        /* Autodetection */
        foreach (self::$engineorder as $engine) {
            if (function_exists(self::$enginemap[$engine][0])) {
                self::$engine = self::$enginemap[$engine][1];
                return;
            }
        }
        /* Fallback to none conversion */
        self::$engine = self::ENGINE_NONE;
    }
    /**
     * Setter for engine. Use with caution, mostly useful for testing.
     *
     * @param int $engine Engine encoding
     */
    public static function setEngine(int $engine) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setEngine") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php at line 108")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setEngine:108@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php');
        die();
    }
    /**
     * Checks whether there is any charset conversion supported
     */
    public static function isSupported() : bool
    {
        if (self::$engine === null) {
            self::initEngine();
        }
        return self::$engine != self::ENGINE_NONE;
    }
    /**
     * Converts encoding of text according to parameters with detected
     * conversion function.
     *
     * @param string $src_charset  source charset
     * @param string $dest_charset target charset
     * @param string $what         what to convert
     *
     * @return string   converted text
     *
     * @access public
     */
    public static function convertString(string $src_charset, string $dest_charset, string $what) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("convertString") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php at line 134")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called convertString:134@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php');
        die();
    }
    /**
     * Detects whether Kanji encoding is available
     */
    public static function canConvertKanji() : bool
    {
        return $GLOBALS['lang'] === 'ja';
    }
    /**
     * Setter for Kanji encodings. Use with caution, mostly useful for testing.
     */
    public static function getKanjiEncodings() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getKanjiEncodings") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php at line 163")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getKanjiEncodings:163@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php');
        die();
    }
    /**
     * Setter for Kanji encodings. Use with caution, mostly useful for testing.
     *
     * @param string $value Kanji encodings list
     */
    public static function setKanjiEncodings(string $value) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setKanjiEncodings") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php at line 172")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setKanjiEncodings:172@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php');
        die();
    }
    /**
     * Reverses SJIS & EUC-JP position in the encoding codes list
     */
    public static function kanjiChangeOrder() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("kanjiChangeOrder") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php at line 179")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called kanjiChangeOrder:179@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php');
        die();
    }
    /**
     * Kanji string encoding convert
     *
     * @param string $str  the string to convert
     * @param string $enc  the destination encoding code
     * @param string $kana set 'kana' convert to JIS-X208-kana
     *
     * @return string   the converted string
     */
    public static function kanjiStrConv(string $str, string $enc, string $kana) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("kanjiStrConv") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called kanjiStrConv:197@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php');
        die();
    }
    /**
     * Kanji file encoding convert
     *
     * @param string $file the name of the file to convert
     * @param string $enc  the destination encoding code
     * @param string $kana set 'kana' convert to JIS-X208-kana
     *
     * @return string   the name of the converted file
     */
    public static function kanjiFileConv(string $file, string $enc, string $kana) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("kanjiFileConv") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php at line 226")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called kanjiFileConv:226@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php');
        die();
    }
    /**
     * Defines radio form fields to switch between encoding modes
     *
     * @return string HTML code for the radio controls
     */
    public static function kanjiEncodingForm() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("kanjiEncodingForm") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php at line 251")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called kanjiEncodingForm:251@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Encoding.php');
        die();
    }
    /**
     * Lists available encodings.
     *
     * @return array
     */
    public static function listEncodings() : array
    {
        if (self::$engine === null) {
            self::initEngine();
        }
        /* Most engines do not support listing */
        if (self::$engine != self::ENGINE_MB) {
            return $GLOBALS['cfg']['AvailableCharsets'];
        }
        return array_intersect(array_map('strtolower', mb_list_encodings()), $GLOBALS['cfg']['AvailableCharsets']);
    }
}