<?php

//============================================================+
// File name   : tcpdf_colors.php
// Version     : 1.0.004
// Begin       : 2002-04-09
// Last Update : 2014-04-25
// Author      : Nicola Asuni - Tecnick.com LTD - www.tecnick.com - info@tecnick.com
// License     : GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2002-2013  Nicola Asuni - Tecnick.com LTD
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
// Description : Array of WEB safe colors
//
//============================================================+
/**
 * @file
 * PHP color class for TCPDF
 * @author Nicola Asuni
 * @package com.tecnick.tcpdf
 */
/**
 * @class TCPDF_COLORS
 * PHP color class for TCPDF
 * @package com.tecnick.tcpdf
 * @version 1.0.004
 * @author Nicola Asuni - info@tecnick.com
 */
class TCPDF_COLORS
{
    /**
     * Array of WEB safe colors
     * @public static
     */
    public static $webcolor = array('aliceblue' => 'f0f8ff', 'antiquewhite' => 'faebd7', 'aqua' => '00ffff', 'aquamarine' => '7fffd4', 'azure' => 'f0ffff', 'beige' => 'f5f5dc', 'bisque' => 'ffe4c4', 'black' => '000000', 'blanchedalmond' => 'ffebcd', 'blue' => '0000ff', 'blueviolet' => '8a2be2', 'brown' => 'a52a2a', 'burlywood' => 'deb887', 'cadetblue' => '5f9ea0', 'chartreuse' => '7fff00', 'chocolate' => 'd2691e', 'coral' => 'ff7f50', 'cornflowerblue' => '6495ed', 'cornsilk' => 'fff8dc', 'crimson' => 'dc143c', 'cyan' => '00ffff', 'darkblue' => '00008b', 'darkcyan' => '008b8b', 'darkgoldenrod' => 'b8860b', 'dkgray' => 'a9a9a9', 'darkgray' => 'a9a9a9', 'darkgrey' => 'a9a9a9', 'darkgreen' => '006400', 'darkkhaki' => 'bdb76b', 'darkmagenta' => '8b008b', 'darkolivegreen' => '556b2f', 'darkorange' => 'ff8c00', 'darkorchid' => '9932cc', 'darkred' => '8b0000', 'darksalmon' => 'e9967a', 'darkseagreen' => '8fbc8f', 'darkslateblue' => '483d8b', 'darkslategray' => '2f4f4f', 'darkslategrey' => '2f4f4f', 'darkturquoise' => '00ced1', 'darkviolet' => '9400d3', 'deeppink' => 'ff1493', 'deepskyblue' => '00bfff', 'dimgray' => '696969', 'dimgrey' => '696969', 'dodgerblue' => '1e90ff', 'firebrick' => 'b22222', 'floralwhite' => 'fffaf0', 'forestgreen' => '228b22', 'fuchsia' => 'ff00ff', 'gainsboro' => 'dcdcdc', 'ghostwhite' => 'f8f8ff', 'gold' => 'ffd700', 'goldenrod' => 'daa520', 'gray' => '808080', 'grey' => '808080', 'green' => '008000', 'greenyellow' => 'adff2f', 'honeydew' => 'f0fff0', 'hotpink' => 'ff69b4', 'indianred' => 'cd5c5c', 'indigo' => '4b0082', 'ivory' => 'fffff0', 'khaki' => 'f0e68c', 'lavender' => 'e6e6fa', 'lavenderblush' => 'fff0f5', 'lawngreen' => '7cfc00', 'lemonchiffon' => 'fffacd', 'lightblue' => 'add8e6', 'lightcoral' => 'f08080', 'lightcyan' => 'e0ffff', 'lightgoldenrodyellow' => 'fafad2', 'ltgray' => 'd3d3d3', 'lightgray' => 'd3d3d3', 'lightgrey' => 'd3d3d3', 'lightgreen' => '90ee90', 'lightpink' => 'ffb6c1', 'lightsalmon' => 'ffa07a', 'lightseagreen' => '20b2aa', 'lightskyblue' => '87cefa', 'lightslategray' => '778899', 'lightslategrey' => '778899', 'lightsteelblue' => 'b0c4de', 'lightyellow' => 'ffffe0', 'lime' => '00ff00', 'limegreen' => '32cd32', 'linen' => 'faf0e6', 'magenta' => 'ff00ff', 'maroon' => '800000', 'mediumaquamarine' => '66cdaa', 'mediumblue' => '0000cd', 'mediumorchid' => 'ba55d3', 'mediumpurple' => '9370d8', 'mediumseagreen' => '3cb371', 'mediumslateblue' => '7b68ee', 'mediumspringgreen' => '00fa9a', 'mediumturquoise' => '48d1cc', 'mediumvioletred' => 'c71585', 'midnightblue' => '191970', 'mintcream' => 'f5fffa', 'mistyrose' => 'ffe4e1', 'moccasin' => 'ffe4b5', 'navajowhite' => 'ffdead', 'navy' => '000080', 'oldlace' => 'fdf5e6', 'olive' => '808000', 'olivedrab' => '6b8e23', 'orange' => 'ffa500', 'orangered' => 'ff4500', 'orchid' => 'da70d6', 'palegoldenrod' => 'eee8aa', 'palegreen' => '98fb98', 'paleturquoise' => 'afeeee', 'palevioletred' => 'd87093', 'papayawhip' => 'ffefd5', 'peachpuff' => 'ffdab9', 'peru' => 'cd853f', 'pink' => 'ffc0cb', 'plum' => 'dda0dd', 'powderblue' => 'b0e0e6', 'purple' => '800080', 'red' => 'ff0000', 'rosybrown' => 'bc8f8f', 'royalblue' => '4169e1', 'saddlebrown' => '8b4513', 'salmon' => 'fa8072', 'sandybrown' => 'f4a460', 'seagreen' => '2e8b57', 'seashell' => 'fff5ee', 'sienna' => 'a0522d', 'silver' => 'c0c0c0', 'skyblue' => '87ceeb', 'slateblue' => '6a5acd', 'slategray' => '708090', 'slategrey' => '708090', 'snow' => 'fffafa', 'springgreen' => '00ff7f', 'steelblue' => '4682b4', 'tan' => 'd2b48c', 'teal' => '008080', 'thistle' => 'd8bfd8', 'tomato' => 'ff6347', 'turquoise' => '40e0d0', 'violet' => 'ee82ee', 'wheat' => 'f5deb3', 'white' => 'ffffff', 'whitesmoke' => 'f5f5f5', 'yellow' => 'ffff00', 'yellowgreen' => '9acd32');
    // end of web colors
    /**
     * Array of valid JavaScript color names
     * @public static
     */
    public static $jscolor = array('transparent', 'black', 'white', 'red', 'green', 'blue', 'cyan', 'magenta', 'yellow', 'dkGray', 'gray', 'ltGray');
    /**
     * Array of Spot colors (C,M,Y,K,name)
     * Color keys must be in lowercase and without spaces.
     * As long as no open standard for spot colours exists, you have to buy a colour book by one of the colour manufacturers and insert the values and names of spot colours directly.
     * Common industry standard spot colors are: ANPA-COLOR, DIC, FOCOLTONE, GCMI, HKS, PANTONE, TOYO, TRUMATCH.
     * @public static
     */
    public static $spotcolor = array(
        // special registration colors
        'none' => array(0, 0, 0, 0, 'None'),
        'all' => array(100, 100, 100, 100, 'All'),
        // standard CMYK colors
        'cyan' => array(100, 0, 0, 0, 'Cyan'),
        'magenta' => array(0, 100, 0, 0, 'Magenta'),
        'yellow' => array(0, 0, 100, 0, 'Yellow'),
        'key' => array(0, 0, 0, 100, 'Key'),
        // alias
        'white' => array(0, 0, 0, 0, 'White'),
        'black' => array(0, 0, 0, 100, 'Black'),
        // standard RGB colors
        'red' => array(0, 100, 100, 0, 'Red'),
        'green' => array(100, 0, 100, 0, 'Green'),
        'blue' => array(100, 100, 0, 0, 'Blue'),
    );
    // end of spot colors
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    /**
     * Return the Spot color array.
     * @param $name (string) Name of the spot color.
     * @param $spotc (array) Reference to an array of spot colors.
     * @return (array) Spot color array or false if not defined.
     * @since 5.9.125 (2011-10-03)
     * @public static
     */
    public static function getSpotColor($name, &$spotc)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getSpotColor") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_colors.php at line 96")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getSpotColor:96@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_colors.php');
        die();
    }
    /**
     * Returns an array (RGB or CMYK) from an html color name, or a six-digit (i.e. #3FE5AA), or three-digit (i.e. #7FF) hexadecimal color, or a javascript color array, or javascript color name.
     * @param $hcolor (string) HTML color.
     * @param $spotc (array) Reference to an array of spot colors.
     * @param $defcol (array) Color to return in case of error.
     * @return array RGB or CMYK color, or false in case of error.
     * @public static
     */
    public static function convertHTMLColorToDec($hcolor, &$spotc, $defcol = array('R' => 128, 'G' => 128, 'B' => 128))
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("convertHTMLColorToDec") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_colors.php at line 121")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called convertHTMLColorToDec:121@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_colors.php');
        die();
    }
    /**
     * Convert a color array into a string representation.
     * @param $c (array) Array of colors.
     * @return (string) The color array representation.
     * @since 5.9.137 (2011-12-01)
     * @public static
     */
    public static function getColorStringFromArray($c)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getColorStringFromArray") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_colors.php at line 256")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getColorStringFromArray:256@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_colors.php');
        die();
    }
    /**
     * Convert color to javascript color.
     * @param $color (string) color name or "#RRGGBB"
     * @protected
     * @since 2.1.002 (2008-02-12)
     * @public static
     */
    public static function _JScolor($color)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_JScolor") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_colors.php at line 284")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _JScolor:284@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/vendor/tecnickcom/tcpdf/include/tcpdf_colors.php');
        die();
    }
}
// END OF TCPDF_COLORS CLASS
//============================================================+
// END OF FILE
//============================================================+