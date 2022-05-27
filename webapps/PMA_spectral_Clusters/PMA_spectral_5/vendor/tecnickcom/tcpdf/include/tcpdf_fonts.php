<?php

//============================================================+
// File name   : tcpdf_fonts.php
// Version     : 1.1.0
// Begin       : 2008-01-01
// Last Update : 2014-12-10
// Author      : Nicola Asuni - Tecnick.com LTD - www.tecnick.com - info@tecnick.com
// License     : GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2008-2014 Nicola Asuni - Tecnick.com LTD
//
// This file is part of TCPDF software library.
//
// TCPDF is free software: you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// TCPDF is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with TCPDF.  If not, see <http://www.gnu.org/licenses/>.
//
// See LICENSE.TXT file for more information.
// -------------------------------------------------------------------
//
// Description :Font methods for TCPDF library.
//
//============================================================+
/**
 * @file
 * Unicode data and font methods for TCPDF library.
 * @author Nicola Asuni
 * @package com.tecnick.tcpdf
 */
/**
 * @class TCPDF_FONTS
 * Font methods for TCPDF library.
 * @package com.tecnick.tcpdf
 * @version 1.1.0
 * @author Nicola Asuni - info@tecnick.com
 */
class TCPDF_FONTS
{
    /**
     * Static cache used for speed up uniord performances
     * @protected
     */
    protected static $cache_uniord = array();
    /**
     * Convert and add the selected TrueType or Type1 font to the fonts folder (that must be writeable).
     * @param $fontfile (string) Font file (full path).
     * @param $fonttype (string) Font type. Leave empty for autodetect mode. Valid values are: TrueTypeUnicode, TrueType, Type1, CID0JP = CID-0 Japanese, CID0KR = CID-0 Korean, CID0CS = CID-0 Chinese Simplified, CID0CT = CID-0 Chinese Traditional.
     * @param $enc (string) Name of the encoding table to use. Leave empty for default mode. Omit this parameter for TrueType Unicode and symbolic fonts like Symbol or ZapfDingBats.
     * @param $flags (int) Unsigned 32-bit integer containing flags specifying various characteristics of the font (PDF32000:2008 - 9.8.2 Font Descriptor Flags): +1 for fixed font; +4 for symbol or +32 for non-symbol; +64 for italic. Fixed and Italic mode are generally autodetected so you have to set it to 32 = non-symbolic font (default) or 4 = symbolic font.
     * @param $outpath (string) Output path for generated font files (must be writeable by the web server). Leave empty for default font folder.
     * @param $platid (int) Platform ID for CMAP table to extract (when building a Unicode font for Windows this value should be 3, for Macintosh should be 1).
     * @param $encid (int) Encoding ID for CMAP table to extract (when building a Unicode font for Windows this value should be 1, for Macintosh should be 0). When Platform ID is 3, legal values for Encoding ID are: 0=Symbol, 1=Unicode, 2=ShiftJIS, 3=PRC, 4=Big5, 5=Wansung, 6=Johab, 7=Reserved, 8=Reserved, 9=Reserved, 10=UCS-4.
     * @param $addcbbox (boolean) If true includes the character bounding box information on the php font file.
     * @param $link (boolean) If true link to system font instead of copying the font data (not transportable) - Note: do not work with Type1 fonts.
     * @return (string) TCPDF font name or boolean false in case of error.
     * @author Nicola Asuni
     * @since 5.9.123 (2010-09-30)
     * @public static
     */
    public static function addTTFfont($fontfile, $fonttype = '', $enc = '', $flags = 32, $outpath = '', $platid = 3, $encid = 1, $addcbbox = false, $link = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addTTFfont") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 72")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addTTFfont:72@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Returs the checksum of a TTF table.
     * @param $table (string) table to check
     * @param $length (int) length of table in bytes
     * @return int checksum
     * @author Nicola Asuni
     * @since 5.2.000 (2010-06-02)
     * @public static
     */
    public static function _getTTFtableChecksum($table, $length)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getTTFtableChecksum") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 956")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getTTFtableChecksum:956@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Returns a subset of the TrueType font data without the unused glyphs.
     * @param $font (string) TrueType font data.
     * @param $subsetchars (array) Array of used characters (the glyphs to keep).
     * @return (string) A subset of TrueType font data without the unused glyphs.
     * @author Nicola Asuni
     * @since 5.2.000 (2010-06-02)
     * @public static
     */
    public static function _getTrueTypeFontSubset($font, $subsetchars)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getTrueTypeFontSubset") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 978")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getTrueTypeFontSubset:978@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Outputs font widths
     * @param $font (array) font data
     * @param $cidoffset (int) offset for CID values
     * @return PDF command string for font widths
     * @author Nicola Asuni
     * @since 4.4.000 (2008-12-07)
     * @public static
     */
    public static function _putfontwidths($font, $cidoffset = 0)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_putfontwidths") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1454")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _putfontwidths:1454@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Update the CIDToGIDMap string with a new value.
     * @param $map (string) CIDToGIDMap.
     * @param $cid (int) CID value.
     * @param $gid (int) GID value.
     * @return (string) CIDToGIDMap.
     * @author Nicola Asuni
     * @since 5.9.123 (2011-09-29)
     * @public static
     */
    public static function updateCIDtoGIDmap($map, $cid, $gid)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("updateCIDtoGIDmap") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1560")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called updateCIDtoGIDmap:1560@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Return fonts path
     * @return string
     * @public static
     */
    public static function _getfontpath()
    {
        if (!defined('K_PATH_FONTS') and is_dir($fdir = realpath(dirname(__FILE__) . '/../fonts'))) {
            if (substr($fdir, -1) != '/') {
                $fdir .= '/';
            }
            define('K_PATH_FONTS', $fdir);
        }
        return defined('K_PATH_FONTS') ? K_PATH_FONTS : '';
    }
    /**
     * Return font full path
     * @param $file (string) Font file name.
     * @param $fontdir (string) Font directory (set to false fto search on default directories)
     * @return string Font full path or empty string
     * @author Nicola Asuni
     * @since 6.0.025
     * @public static
     */
    public static function getFontFullPath($file, $fontdir = false)
    {
        $fontfile = '';
        // search files on various directories
        if ($fontdir !== false and @TCPDF_STATIC::file_exists($fontdir . $file)) {
            $fontfile = $fontdir . $file;
        } elseif (@TCPDF_STATIC::file_exists(self::_getfontpath() . $file)) {
            $fontfile = self::_getfontpath() . $file;
        } elseif (@TCPDF_STATIC::file_exists($file)) {
            $fontfile = $file;
        }
        return $fontfile;
    }
    /**
     * Get a reference font size.
     * @param $size (string) String containing font size value.
     * @param $refsize (float) Reference font size in points.
     * @return float value in points
     * @public static
     */
    public static function getFontRefSize($size, $refsize = 12)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFontRefSize") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1615")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFontRefSize:1615@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    // ====================================================================================================================
    // REIMPLEMENTED
    // ====================================================================================================================
    /**
     * Returns the unicode caracter specified by the value
     * @param $c (int) UTF-8 value
     * @param $unicode (boolean) True if we are in unicode mode, false otherwise.
     * @return Returns the specified character.
     * @since 2.3.000 (2008-03-05)
     * @public static
     */
    public static function unichr($c, $unicode = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unichr") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1659")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called unichr:1659@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Returns the unicode caracter specified by UTF-8 value
     * @param $c (int) UTF-8 value
     * @return Returns the specified character.
     * @public static
     */
    public static function unichrUnicode($c)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unichrUnicode") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1686")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called unichrUnicode:1686@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Returns the unicode caracter specified by ASCII value
     * @param $c (int) UTF-8 value
     * @return Returns the specified character.
     * @public static
     */
    public static function unichrASCII($c)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unichrASCII") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1696")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called unichrASCII:1696@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Converts array of UTF-8 characters to UTF16-BE string.<br>
     * Based on: http://www.faqs.org/rfcs/rfc2781.html
     * <pre>
     *   Encoding UTF-16:
     *
     *   Encoding of a single character from an ISO 10646 character value to
     *    UTF-16 proceeds as follows. Let U be the character number, no greater
     *    than 0x10FFFF.
     *
     *    1) If U < 0x10000, encode U as a 16-bit unsigned integer and
     *       terminate.
     *
     *    2) Let U' = U - 0x10000. Because U is less than or equal to 0x10FFFF,
     *       U' must be less than or equal to 0xFFFFF. That is, U' can be
     *       represented in 20 bits.
     *
     *    3) Initialize two 16-bit unsigned integers, W1 and W2, to 0xD800 and
     *       0xDC00, respectively. These integers each have 10 bits free to
     *       encode the character value, for a total of 20 bits.
     *
     *    4) Assign the 10 high-order bits of the 20-bit U' to the 10 low-order
     *       bits of W1 and the 10 low-order bits of U' to the 10 low-order
     *       bits of W2. Terminate.
     *
     *    Graphically, steps 2 through 4 look like:
     *    U' = yyyyyyyyyyxxxxxxxxxx
     *    W1 = 110110yyyyyyyyyy
     *    W2 = 110111xxxxxxxxxx
     * </pre>
     * @param $unicode (array) array containing UTF-8 unicode values
     * @param $setbom (boolean) if true set the Byte Order Mark (BOM = 0xFEFF)
     * @return string
     * @protected
     * @author Nicola Asuni
     * @since 2.1.000 (2008-01-08)
     * @public static
     */
    public static function arrUTF8ToUTF16BE($unicode, $setbom = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("arrUTF8ToUTF16BE") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1738")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called arrUTF8ToUTF16BE:1738@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Convert an array of UTF8 values to array of unicode characters
     * @param $ta (array) The input array of UTF8 values.
     * @param $isunicode (boolean) True for Unicode mode, false otherwise.
     * @return Return array of unicode characters
     * @since 4.5.037 (2009-04-07)
     * @public static
     */
    public static function UTF8ArrayToUniArray($ta, $isunicode = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("UTF8ArrayToUniArray") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1775")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called UTF8ArrayToUniArray:1775@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Extract a slice of the $strarr array and return it as string.
     * @param $strarr (string) The input array of characters.
     * @param $start (int) the starting element of $strarr.
     * @param $end (int) first element that will not be returned.
     * @param $unicode (boolean) True if we are in unicode mode, false otherwise.
     * @return Return part of a string
     * @public static
     */
    public static function UTF8ArrSubString($strarr, $start = '', $end = '', $unicode = true)
    {
        if (strlen($start) == 0) {
            $start = 0;
        }
        if (strlen($end) == 0) {
            $end = count($strarr);
        }
        $string = '';
        for ($i = $start; $i < $end; ++$i) {
            $string .= self::unichr($strarr[$i], $unicode);
        }
        return $string;
    }
    /**
     * Extract a slice of the $uniarr array and return it as string.
     * @param $uniarr (string) The input array of characters.
     * @param $start (int) the starting element of $strarr.
     * @param $end (int) first element that will not be returned.
     * @return Return part of a string
     * @since 4.5.037 (2009-04-07)
     * @public static
     */
    public static function UniArrSubString($uniarr, $start = '', $end = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("UniArrSubString") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1814")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called UniArrSubString:1814@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Converts UTF-8 characters array to array of Latin1 characters array<br>
     * @param $unicode (array) array containing UTF-8 unicode values
     * @return array
     * @author Nicola Asuni
     * @since 4.8.023 (2010-01-15)
     * @public static
     */
    public static function UTF8ArrToLatin1Arr($unicode)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("UTF8ArrToLatin1Arr") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1836")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called UTF8ArrToLatin1Arr:1836@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Converts UTF-8 characters array to array of Latin1 string<br>
     * @param $unicode (array) array containing UTF-8 unicode values
     * @return array
     * @author Nicola Asuni
     * @since 4.8.023 (2010-01-15)
     * @public static
     */
    public static function UTF8ArrToLatin1($unicode)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("UTF8ArrToLatin1") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1863")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called UTF8ArrToLatin1:1863@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Converts UTF-8 character to integer value.<br>
     * Uses the getUniord() method if the value is not cached.
     * @param $uch (string) character string to process.
     * @return integer Unicode value
     * @public static
     */
    public static function uniord($uch)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("uniord") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1888")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called uniord:1888@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Converts UTF-8 character to integer value.<br>
     * Invalid byte sequences will be replaced with 0xFFFD (replacement character)<br>
     * Based on: http://www.faqs.org/rfcs/rfc3629.html
     * <pre>
     *    Char. number range  |        UTF-8 octet sequence
     *       (hexadecimal)    |              (binary)
     *    --------------------+-----------------------------------------------
     *    0000 0000-0000 007F | 0xxxxxxx
     *    0000 0080-0000 07FF | 110xxxxx 10xxxxxx
     *    0000 0800-0000 FFFF | 1110xxxx 10xxxxxx 10xxxxxx
     *    0001 0000-0010 FFFF | 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx
     *    ---------------------------------------------------------------------
     *
     *   ABFN notation:
     *   ---------------------------------------------------------------------
     *   UTF8-octets = *( UTF8-char )
     *   UTF8-char   = UTF8-1 / UTF8-2 / UTF8-3 / UTF8-4
     *   UTF8-1      = %x00-7F
     *   UTF8-2      = %xC2-DF UTF8-tail
     *
     *   UTF8-3      = %xE0 %xA0-BF UTF8-tail / %xE1-EC 2( UTF8-tail ) /
     *                 %xED %x80-9F UTF8-tail / %xEE-EF 2( UTF8-tail )
     *   UTF8-4      = %xF0 %x90-BF 2( UTF8-tail ) / %xF1-F3 3( UTF8-tail ) /
     *                 %xF4 %x80-8F 2( UTF8-tail )
     *   UTF8-tail   = %x80-BF
     *   ---------------------------------------------------------------------
     * </pre>
     * @param $uch (string) character string to process.
     * @return integer Unicode value
     * @author Nicola Asuni
     * @public static
     */
    public static function getUniord($uch)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUniord") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 1928")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUniord:1928@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Converts UTF-8 strings to codepoints array.<br>
     * Invalid byte sequences will be replaced with 0xFFFD (replacement character)<br>
     * @param $str (string) string to process.
     * @param $isunicode (boolean) True when the documetn is in Unicode mode, false otherwise.
     * @param $currentfont (array) Reference to current font array.
     * @return array containing codepoints (UTF-8 characters values)
     * @author Nicola Asuni
     * @public static
     */
    public static function UTF8StringToArray($str, $isunicode = true, &$currentfont = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("UTF8StringToArray") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 2007")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called UTF8StringToArray:2007@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Converts UTF-8 strings to Latin1 when using the standard 14 core fonts.<br>
     * @param $str (string) string to process.
     * @param $isunicode (boolean) True when the documetn is in Unicode mode, false otherwise.
     * @param $currentfont (array) Reference to current font array.
     * @return string
     * @since 3.2.000 (2008-06-23)
     * @public static
     */
    public static function UTF8ToLatin1($str, $isunicode = true, &$currentfont = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("UTF8ToLatin1") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 2033")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called UTF8ToLatin1:2033@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Converts UTF-8 strings to UTF16-BE.<br>
     * @param $str (string) string to process.
     * @param $setbom (boolean) if true set the Byte Order Mark (BOM = 0xFEFF)
     * @param $isunicode (boolean) True when the documetn is in Unicode mode, false otherwise.
     * @param $currentfont (array) Reference to current font array.
     * @return string
     * @author Nicola Asuni
     * @since 1.53.0.TC005 (2005-01-05)
     * @public static
     */
    public static function UTF8ToUTF16BE($str, $setbom = false, $isunicode = true, &$currentfont = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("UTF8ToUTF16BE") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 2050")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called UTF8ToUTF16BE:2050@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Reverse the RLT substrings using the Bidirectional Algorithm (http://unicode.org/reports/tr9/).
     * @param $str (string) string to manipulate.
     * @param $setbom (bool) if true set the Byte Order Mark (BOM = 0xFEFF)
     * @param $forcertl (bool) if true forces RTL text direction
     * @param $isunicode (boolean) True if the document is in Unicode mode, false otherwise.
     * @param $currentfont (array) Reference to current font array.
     * @return string
     * @author Nicola Asuni
     * @since 2.1.000 (2008-01-08)
     * @public static
     */
    public static function utf8StrRev($str, $setbom = false, $forcertl = false, $isunicode = true, &$currentfont = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("utf8StrRev") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 2072")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called utf8StrRev:2072@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Reverse the RLT substrings array using the Bidirectional Algorithm (http://unicode.org/reports/tr9/).
     * @param $arr (array) array of unicode values.
     * @param $str (string) string to manipulate (or empty value).
     * @param $setbom (bool) if true set the Byte Order Mark (BOM = 0xFEFF)
     * @param $forcertl (bool) if true forces RTL text direction
     * @param $isunicode (boolean) True if the document is in Unicode mode, false otherwise.
     * @param $currentfont (array) Reference to current font array.
     * @return string
     * @author Nicola Asuni
     * @since 4.9.000 (2010-03-27)
     * @public static
     */
    public static function utf8StrArrRev($arr, $str = '', $setbom = false, $forcertl = false, $isunicode = true, &$currentfont = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("utf8StrArrRev") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php at line 2089")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called utf8StrArrRev:2089@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');
        die();
    }
    /**
     * Reverse the RLT substrings using the Bidirectional Algorithm (http://unicode.org/reports/tr9/).
     * @param $ta (array) array of characters composing the string.
     * @param $str (string) string to process
     * @param $forcertl (bool) if 'R' forces RTL, if 'L' forces LTR
     * @param $isunicode (boolean) True if the document is in Unicode mode, false otherwise.
     * @param $currentfont (array) Reference to current font array.
     * @return array of unicode chars
     * @author Nicola Asuni
     * @since 2.4.000 (2008-03-06)
     * @public static
     */
    public static function utf8Bidi($ta, $str = '', $forcertl = false, $isunicode = true, &$currentfont = array())
    {
        // paragraph embedding level
        $pel = 0;
        // max level
        $maxlevel = 0;
        if (TCPDF_STATIC::empty_string($str)) {
            // create string from array
            $str = self::UTF8ArrSubString($ta, '', '', $isunicode);
        }
        // check if string contains arabic text
        if (preg_match(TCPDF_FONT_DATA::$uni_RE_PATTERN_ARABIC, $str)) {
            $arabic = true;
        } else {
            $arabic = false;
        }
        // check if string contains RTL text
        if (!($forcertl or $arabic or preg_match(TCPDF_FONT_DATA::$uni_RE_PATTERN_RTL, $str))) {
            return $ta;
        }
        // get number of chars
        $numchars = count($ta);
        if ($forcertl == 'R') {
            $pel = 1;
        } elseif ($forcertl == 'L') {
            $pel = 0;
        } else {
            // P2. In each paragraph, find the first character of type L, AL, or R.
            // P3. If a character is found in P2 and it is of type AL or R, then set the paragraph embedding level to one; otherwise, set it to zero.
            for ($i = 0; $i < $numchars; ++$i) {
                $type = TCPDF_FONT_DATA::$uni_type[$ta[$i]];
                if ($type == 'L') {
                    $pel = 0;
                    break;
                } elseif ($type == 'AL' or $type == 'R') {
                    $pel = 1;
                    break;
                }
            }
        }
        // Current Embedding Level
        $cel = $pel;
        // directional override status
        $dos = 'N';
        $remember = array();
        // start-of-level-run
        $sor = $pel % 2 ? 'R' : 'L';
        $eor = $sor;
        // Array of characters data
        $chardata = array();
        // X1. Begin by setting the current embedding level to the paragraph embedding level. Set the directional override status to neutral. Process each character iteratively, applying rules X2 through X9. Only embedding levels from 0 to 61 are valid in this phase.
        // In the resolution of levels in rules I1 and I2, the maximum embedding level of 62 can be reached.
        for ($i = 0; $i < $numchars; ++$i) {
            if ($ta[$i] == TCPDF_FONT_DATA::$uni_RLE) {
                // X2. With each RLE, compute the least greater odd embedding level.
                //	a. If this new level would be valid, then this embedding code is valid. Remember (push) the current embedding level and override status. Reset the current level to this new level, and reset the override status to neutral.
                //	b. If the new level would not be valid, then this code is invalid. Do not change the current level or override status.
                $next_level = $cel + $cel % 2 + 1;
                if ($next_level < 62) {
                    $remember[] = array('num' => TCPDF_FONT_DATA::$uni_RLE, 'cel' => $cel, 'dos' => $dos);
                    $cel = $next_level;
                    $dos = 'N';
                    $sor = $eor;
                    $eor = $cel % 2 ? 'R' : 'L';
                }
            } elseif ($ta[$i] == TCPDF_FONT_DATA::$uni_LRE) {
                // X3. With each LRE, compute the least greater even embedding level.
                //	a. If this new level would be valid, then this embedding code is valid. Remember (push) the current embedding level and override status. Reset the current level to this new level, and reset the override status to neutral.
                //	b. If the new level would not be valid, then this code is invalid. Do not change the current level or override status.
                $next_level = $cel + 2 - $cel % 2;
                if ($next_level < 62) {
                    $remember[] = array('num' => TCPDF_FONT_DATA::$uni_LRE, 'cel' => $cel, 'dos' => $dos);
                    $cel = $next_level;
                    $dos = 'N';
                    $sor = $eor;
                    $eor = $cel % 2 ? 'R' : 'L';
                }
            } elseif ($ta[$i] == TCPDF_FONT_DATA::$uni_RLO) {
                // X4. With each RLO, compute the least greater odd embedding level.
                //	a. If this new level would be valid, then this embedding code is valid. Remember (push) the current embedding level and override status. Reset the current level to this new level, and reset the override status to right-to-left.
                //	b. If the new level would not be valid, then this code is invalid. Do not change the current level or override status.
                $next_level = $cel + $cel % 2 + 1;
                if ($next_level < 62) {
                    $remember[] = array('num' => TCPDF_FONT_DATA::$uni_RLO, 'cel' => $cel, 'dos' => $dos);
                    $cel = $next_level;
                    $dos = 'R';
                    $sor = $eor;
                    $eor = $cel % 2 ? 'R' : 'L';
                }
            } elseif ($ta[$i] == TCPDF_FONT_DATA::$uni_LRO) {
                // X5. With each LRO, compute the least greater even embedding level.
                //	a. If this new level would be valid, then this embedding code is valid. Remember (push) the current embedding level and override status. Reset the current level to this new level, and reset the override status to left-to-right.
                //	b. If the new level would not be valid, then this code is invalid. Do not change the current level or override status.
                $next_level = $cel + 2 - $cel % 2;
                if ($next_level < 62) {
                    $remember[] = array('num' => TCPDF_FONT_DATA::$uni_LRO, 'cel' => $cel, 'dos' => $dos);
                    $cel = $next_level;
                    $dos = 'L';
                    $sor = $eor;
                    $eor = $cel % 2 ? 'R' : 'L';
                }
            } elseif ($ta[$i] == TCPDF_FONT_DATA::$uni_PDF) {
                // X7. With each PDF, determine the matching embedding or override code. If there was a valid matching code, restore (pop) the last remembered (pushed) embedding level and directional override.
                if (count($remember)) {
                    $last = count($remember) - 1;
                    if ($remember[$last]['num'] == TCPDF_FONT_DATA::$uni_RLE or $remember[$last]['num'] == TCPDF_FONT_DATA::$uni_LRE or $remember[$last]['num'] == TCPDF_FONT_DATA::$uni_RLO or $remember[$last]['num'] == TCPDF_FONT_DATA::$uni_LRO) {
                        $match = array_pop($remember);
                        $cel = $match['cel'];
                        $dos = $match['dos'];
                        $sor = $eor;
                        $eor = ($cel > $match['cel'] ? $cel : $match['cel']) % 2 ? 'R' : 'L';
                    }
                }
            } elseif ($ta[$i] != TCPDF_FONT_DATA::$uni_RLE and $ta[$i] != TCPDF_FONT_DATA::$uni_LRE and $ta[$i] != TCPDF_FONT_DATA::$uni_RLO and $ta[$i] != TCPDF_FONT_DATA::$uni_LRO and $ta[$i] != TCPDF_FONT_DATA::$uni_PDF) {
                // X6. For all types besides RLE, LRE, RLO, LRO, and PDF:
                //	a. Set the level of the current character to the current embedding level.
                //	b. Whenever the directional override status is not neutral, reset the current character type to the directional override status.
                if ($dos != 'N') {
                    $chardir = $dos;
                } else {
                    if (isset(TCPDF_FONT_DATA::$uni_type[$ta[$i]])) {
                        $chardir = TCPDF_FONT_DATA::$uni_type[$ta[$i]];
                    } else {
                        $chardir = 'L';
                    }
                }
                // stores string characters and other information
                $chardata[] = array('char' => $ta[$i], 'level' => $cel, 'type' => $chardir, 'sor' => $sor, 'eor' => $eor);
            }
        }
        // end for each char
        // X8. All explicit directional embeddings and overrides are completely terminated at the end of each paragraph. Paragraph separators are not included in the embedding.
        // X9. Remove all RLE, LRE, RLO, LRO, PDF, and BN codes.
        // X10. The remaining rules are applied to each run of characters at the same level. For each run, determine the start-of-level-run (sor) and end-of-level-run (eor) type, either L or R. This depends on the higher of the two levels on either side of the boundary (at the start or end of the paragraph, the level of the 'other' run is the base embedding level). If the higher level is odd, the type is R; otherwise, it is L.
        // 3.3.3 Resolving Weak Types
        // Weak types are now resolved one level run at a time. At level run boundaries where the type of the character on the other side of the boundary is required, the type assigned to sor or eor is used.
        // Nonspacing marks are now resolved based on the previous characters.
        $numchars = count($chardata);
        // W1. Examine each nonspacing mark (NSM) in the level run, and change the type of the NSM to the type of the previous character. If the NSM is at the start of the level run, it will get the type of sor.
        $prevlevel = -1;
        // track level changes
        $levcount = 0;
        // counts consecutive chars at the same level
        for ($i = 0; $i < $numchars; ++$i) {
            if ($chardata[$i]['type'] == 'NSM') {
                if ($levcount) {
                    $chardata[$i]['type'] = $chardata[$i]['sor'];
                } elseif ($i > 0) {
                    $chardata[$i]['type'] = $chardata[$i - 1]['type'];
                }
            }
            if ($chardata[$i]['level'] != $prevlevel) {
                $levcount = 0;
            } else {
                ++$levcount;
            }
            $prevlevel = $chardata[$i]['level'];
        }
        // W2. Search backward from each instance of a European number until the first strong type (R, L, AL, or sor) is found. If an AL is found, change the type of the European number to Arabic number.
        $prevlevel = -1;
        $levcount = 0;
        for ($i = 0; $i < $numchars; ++$i) {
            if ($chardata[$i]['char'] == 'EN') {
                for ($j = $levcount; $j >= 0; $j--) {
                    if ($chardata[$j]['type'] == 'AL') {
                        $chardata[$i]['type'] = 'AN';
                    } elseif ($chardata[$j]['type'] == 'L' or $chardata[$j]['type'] == 'R') {
                        break;
                    }
                }
            }
            if ($chardata[$i]['level'] != $prevlevel) {
                $levcount = 0;
            } else {
                ++$levcount;
            }
            $prevlevel = $chardata[$i]['level'];
        }
        // W3. Change all ALs to R.
        for ($i = 0; $i < $numchars; ++$i) {
            if ($chardata[$i]['type'] == 'AL') {
                $chardata[$i]['type'] = 'R';
            }
        }
        // W4. A single European separator between two European numbers changes to a European number. A single common separator between two numbers of the same type changes to that type.
        $prevlevel = -1;
        $levcount = 0;
        for ($i = 0; $i < $numchars; ++$i) {
            if ($levcount > 0 and $i + 1 < $numchars and $chardata[$i + 1]['level'] == $prevlevel) {
                if ($chardata[$i]['type'] == 'ES' and $chardata[$i - 1]['type'] == 'EN' and $chardata[$i + 1]['type'] == 'EN') {
                    $chardata[$i]['type'] = 'EN';
                } elseif ($chardata[$i]['type'] == 'CS' and $chardata[$i - 1]['type'] == 'EN' and $chardata[$i + 1]['type'] == 'EN') {
                    $chardata[$i]['type'] = 'EN';
                } elseif ($chardata[$i]['type'] == 'CS' and $chardata[$i - 1]['type'] == 'AN' and $chardata[$i + 1]['type'] == 'AN') {
                    $chardata[$i]['type'] = 'AN';
                }
            }
            if ($chardata[$i]['level'] != $prevlevel) {
                $levcount = 0;
            } else {
                ++$levcount;
            }
            $prevlevel = $chardata[$i]['level'];
        }
        // W5. A sequence of European terminators adjacent to European numbers changes to all European numbers.
        $prevlevel = -1;
        $levcount = 0;
        for ($i = 0; $i < $numchars; ++$i) {
            if ($chardata[$i]['type'] == 'ET') {
                if ($levcount > 0 and $chardata[$i - 1]['type'] == 'EN') {
                    $chardata[$i]['type'] = 'EN';
                } else {
                    $j = $i + 1;
                    while ($j < $numchars and $chardata[$j]['level'] == $prevlevel) {
                        if ($chardata[$j]['type'] == 'EN') {
                            $chardata[$i]['type'] = 'EN';
                            break;
                        } elseif ($chardata[$j]['type'] != 'ET') {
                            break;
                        }
                        ++$j;
                    }
                }
            }
            if ($chardata[$i]['level'] != $prevlevel) {
                $levcount = 0;
            } else {
                ++$levcount;
            }
            $prevlevel = $chardata[$i]['level'];
        }
        // W6. Otherwise, separators and terminators change to Other Neutral.
        $prevlevel = -1;
        $levcount = 0;
        for ($i = 0; $i < $numchars; ++$i) {
            if ($chardata[$i]['type'] == 'ET' or $chardata[$i]['type'] == 'ES' or $chardata[$i]['type'] == 'CS') {
                $chardata[$i]['type'] = 'ON';
            }
            if ($chardata[$i]['level'] != $prevlevel) {
                $levcount = 0;
            } else {
                ++$levcount;
            }
            $prevlevel = $chardata[$i]['level'];
        }
        //W7. Search backward from each instance of a European number until the first strong type (R, L, or sor) is found. If an L is found, then change the type of the European number to L.
        $prevlevel = -1;
        $levcount = 0;
        for ($i = 0; $i < $numchars; ++$i) {
            if ($chardata[$i]['char'] == 'EN') {
                for ($j = $levcount; $j >= 0; $j--) {
                    if ($chardata[$j]['type'] == 'L') {
                        $chardata[$i]['type'] = 'L';
                    } elseif ($chardata[$j]['type'] == 'R') {
                        break;
                    }
                }
            }
            if ($chardata[$i]['level'] != $prevlevel) {
                $levcount = 0;
            } else {
                ++$levcount;
            }
            $prevlevel = $chardata[$i]['level'];
        }
        // N1. A sequence of neutrals takes the direction of the surrounding strong text if the text on both sides has the same direction. European and Arabic numbers act as if they were R in terms of their influence on neutrals. Start-of-level-run (sor) and end-of-level-run (eor) are used at level run boundaries.
        $prevlevel = -1;
        $levcount = 0;
        for ($i = 0; $i < $numchars; ++$i) {
            if ($levcount > 0 and $i + 1 < $numchars and $chardata[$i + 1]['level'] == $prevlevel) {
                if ($chardata[$i]['type'] == 'N' and $chardata[$i - 1]['type'] == 'L' and $chardata[$i + 1]['type'] == 'L') {
                    $chardata[$i]['type'] = 'L';
                } elseif ($chardata[$i]['type'] == 'N' and ($chardata[$i - 1]['type'] == 'R' or $chardata[$i - 1]['type'] == 'EN' or $chardata[$i - 1]['type'] == 'AN') and ($chardata[$i + 1]['type'] == 'R' or $chardata[$i + 1]['type'] == 'EN' or $chardata[$i + 1]['type'] == 'AN')) {
                    $chardata[$i]['type'] = 'R';
                } elseif ($chardata[$i]['type'] == 'N') {
                    // N2. Any remaining neutrals take the embedding direction
                    $chardata[$i]['type'] = $chardata[$i]['sor'];
                }
            } elseif ($levcount == 0 and $i + 1 < $numchars and $chardata[$i + 1]['level'] == $prevlevel) {
                // first char
                if ($chardata[$i]['type'] == 'N' and $chardata[$i]['sor'] == 'L' and $chardata[$i + 1]['type'] == 'L') {
                    $chardata[$i]['type'] = 'L';
                } elseif ($chardata[$i]['type'] == 'N' and ($chardata[$i]['sor'] == 'R' or $chardata[$i]['sor'] == 'EN' or $chardata[$i]['sor'] == 'AN') and ($chardata[$i + 1]['type'] == 'R' or $chardata[$i + 1]['type'] == 'EN' or $chardata[$i + 1]['type'] == 'AN')) {
                    $chardata[$i]['type'] = 'R';
                } elseif ($chardata[$i]['type'] == 'N') {
                    // N2. Any remaining neutrals take the embedding direction
                    $chardata[$i]['type'] = $chardata[$i]['sor'];
                }
            } elseif ($levcount > 0 and ($i + 1 == $numchars or $i + 1 < $numchars and $chardata[$i + 1]['level'] != $prevlevel)) {
                //last char
                if ($chardata[$i]['type'] == 'N' and $chardata[$i - 1]['type'] == 'L' and $chardata[$i]['eor'] == 'L') {
                    $chardata[$i]['type'] = 'L';
                } elseif ($chardata[$i]['type'] == 'N' and ($chardata[$i - 1]['type'] == 'R' or $chardata[$i - 1]['type'] == 'EN' or $chardata[$i - 1]['type'] == 'AN') and ($chardata[$i]['eor'] == 'R' or $chardata[$i]['eor'] == 'EN' or $chardata[$i]['eor'] == 'AN')) {
                    $chardata[$i]['type'] = 'R';
                } elseif ($chardata[$i]['type'] == 'N') {
                    // N2. Any remaining neutrals take the embedding direction
                    $chardata[$i]['type'] = $chardata[$i]['sor'];
                }
            } elseif ($chardata[$i]['type'] == 'N') {
                // N2. Any remaining neutrals take the embedding direction
                $chardata[$i]['type'] = $chardata[$i]['sor'];
            }
            if ($chardata[$i]['level'] != $prevlevel) {
                $levcount = 0;
            } else {
                ++$levcount;
            }
            $prevlevel = $chardata[$i]['level'];
        }
        // I1. For all characters with an even (left-to-right) embedding direction, those of type R go up one level and those of type AN or EN go up two levels.
        // I2. For all characters with an odd (right-to-left) embedding direction, those of type L, EN or AN go up one level.
        for ($i = 0; $i < $numchars; ++$i) {
            $odd = $chardata[$i]['level'] % 2;
            if ($odd) {
                if ($chardata[$i]['type'] == 'L' or $chardata[$i]['type'] == 'AN' or $chardata[$i]['type'] == 'EN') {
                    $chardata[$i]['level'] += 1;
                }
            } else {
                if ($chardata[$i]['type'] == 'R') {
                    $chardata[$i]['level'] += 1;
                } elseif ($chardata[$i]['type'] == 'AN' or $chardata[$i]['type'] == 'EN') {
                    $chardata[$i]['level'] += 2;
                }
            }
            $maxlevel = max($chardata[$i]['level'], $maxlevel);
        }
        // L1. On each line, reset the embedding level of the following characters to the paragraph embedding level:
        //	1. Segment separators,
        //	2. Paragraph separators,
        //	3. Any sequence of whitespace characters preceding a segment separator or paragraph separator, and
        //	4. Any sequence of white space characters at the end of the line.
        for ($i = 0; $i < $numchars; ++$i) {
            if ($chardata[$i]['type'] == 'B' or $chardata[$i]['type'] == 'S') {
                $chardata[$i]['level'] = $pel;
            } elseif ($chardata[$i]['type'] == 'WS') {
                $j = $i + 1;
                while ($j < $numchars) {
                    if ($chardata[$j]['type'] == 'B' or $chardata[$j]['type'] == 'S' or $j == $numchars - 1 and $chardata[$j]['type'] == 'WS') {
                        $chardata[$i]['level'] = $pel;
                        break;
                    } elseif ($chardata[$j]['type'] != 'WS') {
                        break;
                    }
                    ++$j;
                }
            }
        }
        // Arabic Shaping
        // Cursively connected scripts, such as Arabic or Syriac, require the selection of positional character shapes that depend on adjacent characters. Shaping is logically applied after the Bidirectional Algorithm is used and is limited to characters within the same directional run.
        if ($arabic) {
            $endedletter = array(1569, 1570, 1571, 1572, 1573, 1575, 1577, 1583, 1584, 1585, 1586, 1608, 1688);
            $alfletter = array(1570, 1571, 1573, 1575);
            $chardata2 = $chardata;
            $laaletter = false;
            $charAL = array();
            $x = 0;
            for ($i = 0; $i < $numchars; ++$i) {
                if (TCPDF_FONT_DATA::$uni_type[$chardata[$i]['char']] == 'AL' or $chardata[$i]['char'] == 32 or $chardata[$i]['char'] == 8204) {
                    $charAL[$x] = $chardata[$i];
                    $charAL[$x]['i'] = $i;
                    $chardata[$i]['x'] = $x;
                    ++$x;
                }
            }
            $numAL = $x;
            for ($i = 0; $i < $numchars; ++$i) {
                $thischar = $chardata[$i];
                if ($i > 0) {
                    $prevchar = $chardata[$i - 1];
                } else {
                    $prevchar = false;
                }
                if ($i + 1 < $numchars) {
                    $nextchar = $chardata[$i + 1];
                } else {
                    $nextchar = false;
                }
                if (TCPDF_FONT_DATA::$uni_type[$thischar['char']] == 'AL') {
                    $x = $thischar['x'];
                    if ($x > 0) {
                        $prevchar = $charAL[$x - 1];
                    } else {
                        $prevchar = false;
                    }
                    if ($x + 1 < $numAL) {
                        $nextchar = $charAL[$x + 1];
                    } else {
                        $nextchar = false;
                    }
                    // if laa letter
                    if ($prevchar !== false and $prevchar['char'] == 1604 and in_array($thischar['char'], $alfletter)) {
                        $arabicarr = TCPDF_FONT_DATA::$uni_laa_array;
                        $laaletter = true;
                        if ($x > 1) {
                            $prevchar = $charAL[$x - 2];
                        } else {
                            $prevchar = false;
                        }
                    } else {
                        $arabicarr = TCPDF_FONT_DATA::$uni_arabicsubst;
                        $laaletter = false;
                    }
                    if ($prevchar !== false and $nextchar !== false and (TCPDF_FONT_DATA::$uni_type[$prevchar['char']] == 'AL' or TCPDF_FONT_DATA::$uni_type[$prevchar['char']] == 'NSM') and (TCPDF_FONT_DATA::$uni_type[$nextchar['char']] == 'AL' or TCPDF_FONT_DATA::$uni_type[$nextchar['char']] == 'NSM') and $prevchar['type'] == $thischar['type'] and $nextchar['type'] == $thischar['type'] and $nextchar['char'] != 1567) {
                        if (in_array($prevchar['char'], $endedletter)) {
                            if (isset($arabicarr[$thischar['char']][2])) {
                                // initial
                                $chardata2[$i]['char'] = $arabicarr[$thischar['char']][2];
                            }
                        } else {
                            if (isset($arabicarr[$thischar['char']][3])) {
                                // medial
                                $chardata2[$i]['char'] = $arabicarr[$thischar['char']][3];
                            }
                        }
                    } elseif ($nextchar !== false and (TCPDF_FONT_DATA::$uni_type[$nextchar['char']] == 'AL' or TCPDF_FONT_DATA::$uni_type[$nextchar['char']] == 'NSM') and $nextchar['type'] == $thischar['type'] and $nextchar['char'] != 1567) {
                        if (isset($arabicarr[$chardata[$i]['char']][2])) {
                            // initial
                            $chardata2[$i]['char'] = $arabicarr[$thischar['char']][2];
                        }
                    } elseif ($prevchar !== false and (TCPDF_FONT_DATA::$uni_type[$prevchar['char']] == 'AL' or TCPDF_FONT_DATA::$uni_type[$prevchar['char']] == 'NSM') and $prevchar['type'] == $thischar['type'] or $nextchar !== false and $nextchar['char'] == 1567) {
                        // final
                        if ($i > 1 and $thischar['char'] == 1607 and $chardata[$i - 1]['char'] == 1604 and $chardata[$i - 2]['char'] == 1604) {
                            //Allah Word
                            // mark characters to delete with false
                            $chardata2[$i - 2]['char'] = false;
                            $chardata2[$i - 1]['char'] = false;
                            $chardata2[$i]['char'] = 65010;
                        } else {
                            if ($prevchar !== false and in_array($prevchar['char'], $endedletter)) {
                                if (isset($arabicarr[$thischar['char']][0])) {
                                    // isolated
                                    $chardata2[$i]['char'] = $arabicarr[$thischar['char']][0];
                                }
                            } else {
                                if (isset($arabicarr[$thischar['char']][1])) {
                                    // final
                                    $chardata2[$i]['char'] = $arabicarr[$thischar['char']][1];
                                }
                            }
                        }
                    } elseif (isset($arabicarr[$thischar['char']][0])) {
                        // isolated
                        $chardata2[$i]['char'] = $arabicarr[$thischar['char']][0];
                    }
                    // if laa letter
                    if ($laaletter) {
                        // mark characters to delete with false
                        $chardata2[$charAL[$x - 1]['i']]['char'] = false;
                    }
                }
                // end if AL (Arabic Letter)
            }
            // end for each char
            /*
             * Combining characters that can occur with Arabic Shadda (0651 HEX, 1617 DEC) are replaced.
             * Putting the combining mark and shadda in the same glyph allows us to avoid the two marks overlapping each other in an illegible manner.
             */
            for ($i = 0; $i < $numchars - 1; ++$i) {
                if ($chardata2[$i]['char'] == 1617 and isset(TCPDF_FONT_DATA::$uni_diacritics[$chardata2[$i + 1]['char']])) {
                    // check if the subtitution font is defined on current font
                    if (isset($currentfont['cw'][TCPDF_FONT_DATA::$uni_diacritics[$chardata2[$i + 1]['char']]])) {
                        $chardata2[$i]['char'] = false;
                        $chardata2[$i + 1]['char'] = TCPDF_FONT_DATA::$uni_diacritics[$chardata2[$i + 1]['char']];
                    }
                }
            }
            // remove marked characters
            foreach ($chardata2 as $key => $value) {
                if ($value['char'] === false) {
                    unset($chardata2[$key]);
                }
            }
            $chardata = array_values($chardata2);
            $numchars = count($chardata);
            unset($chardata2);
            unset($arabicarr);
            unset($laaletter);
            unset($charAL);
        }
        // L2. From the highest level found in the text to the lowest odd level on each line, including intermediate levels not actually present in the text, reverse any contiguous sequence of characters that are at that level or higher.
        for ($j = $maxlevel; $j > 0; $j--) {
            $ordarray = array();
            $revarr = array();
            $onlevel = false;
            for ($i = 0; $i < $numchars; ++$i) {
                if ($chardata[$i]['level'] >= $j) {
                    $onlevel = true;
                    if (isset(TCPDF_FONT_DATA::$uni_mirror[$chardata[$i]['char']])) {
                        // L4. A character is depicted by a mirrored glyph if and only if (a) the resolved directionality of that character is R, and (b) the Bidi_Mirrored property value of that character is true.
                        $chardata[$i]['char'] = TCPDF_FONT_DATA::$uni_mirror[$chardata[$i]['char']];
                    }
                    $revarr[] = $chardata[$i];
                } else {
                    if ($onlevel) {
                        $revarr = array_reverse($revarr);
                        $ordarray = array_merge($ordarray, $revarr);
                        $revarr = array();
                        $onlevel = false;
                    }
                    $ordarray[] = $chardata[$i];
                }
            }
            if ($onlevel) {
                $revarr = array_reverse($revarr);
                $ordarray = array_merge($ordarray, $revarr);
            }
            $chardata = $ordarray;
        }
        $ordarray = array();
        foreach ($chardata as $cd) {
            $ordarray[] = $cd['char'];
            // store char values for subsetting
            $currentfont['subsetchars'][$cd['char']] = true;
        }
        return $ordarray;
    }
}
// END OF TCPDF_FONTS CLASS
//============================================================+
// END OF FILE
//============================================================+