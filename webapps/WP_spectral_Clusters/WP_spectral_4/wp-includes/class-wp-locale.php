<?php

/**
 * Locale API: WP_Locale class
 *
 * @package WordPress
 * @subpackage i18n
 * @since 4.6.0
 */
/**
 * Core class used to store translated data for a locale.
 *
 * @since 2.1.0
 * @since 4.6.0 Moved to its own file from wp-includes/locale.php.
 */
class WP_Locale
{
    /**
     * Stores the translated strings for the full weekday names.
     *
     * @since 2.1.0
     * @var array
     */
    public $weekday;
    /**
     * Stores the translated strings for the one character weekday names.
     *
     * There is a hack to make sure that Tuesday and Thursday, as well
     * as Sunday and Saturday, don't conflict. See init() method for more.
     *
     * @see WP_Locale::init() for how to handle the hack.
     *
     * @since 2.1.0
     * @var array
     */
    public $weekday_initial;
    /**
     * Stores the translated strings for the abbreviated weekday names.
     *
     * @since 2.1.0
     * @var array
     */
    public $weekday_abbrev;
    /**
     * Stores the translated strings for the full month names.
     *
     * @since 2.1.0
     * @var array
     */
    public $month;
    /**
     * Stores the translated strings for the month names in genitive case, if the locale specifies.
     *
     * @since 4.4.0
     * @var array
     */
    public $month_genitive;
    /**
     * Stores the translated strings for the abbreviated month names.
     *
     * @since 2.1.0
     * @var array
     */
    public $month_abbrev;
    /**
     * Stores the translated strings for 'am' and 'pm'.
     *
     * Also the capitalized versions.
     *
     * @since 2.1.0
     * @var array
     */
    public $meridiem;
    /**
     * The text direction of the locale language.
     *
     * Default is left to right 'ltr'.
     *
     * @since 2.1.0
     * @var string
     */
    public $text_direction = 'ltr';
    /**
     * The thousands separator and decimal point values used for localizing numbers.
     *
     * @since 2.3.0
     * @var array
     */
    public $number_format;
    /**
     * Constructor which calls helper methods to set up object variables.
     *
     * @since 2.1.0
     */
    public function __construct()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php at line 97")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:97@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php');
        die();
    }
    /**
     * Sets up the translated strings and object properties.
     *
     * The method creates the translatable strings for various
     * calendar elements. Which allows for specifying locale
     * specific calendar names and text direction.
     *
     * @since 2.1.0
     *
     * @global string $text_direction
     * @global string $wp_version     The WordPress version string.
     */
    public function init()
    {
        // The weekdays.
        $this->weekday[0] = __('Sunday');
        $this->weekday[1] = __('Monday');
        $this->weekday[2] = __('Tuesday');
        $this->weekday[3] = __('Wednesday');
        $this->weekday[4] = __('Thursday');
        $this->weekday[5] = __('Friday');
        $this->weekday[6] = __('Saturday');
        // The first letter of each day.
        $this->weekday_initial[__('Sunday')] = _x('S', 'Sunday initial');
        $this->weekday_initial[__('Monday')] = _x('M', 'Monday initial');
        $this->weekday_initial[__('Tuesday')] = _x('T', 'Tuesday initial');
        $this->weekday_initial[__('Wednesday')] = _x('W', 'Wednesday initial');
        $this->weekday_initial[__('Thursday')] = _x('T', 'Thursday initial');
        $this->weekday_initial[__('Friday')] = _x('F', 'Friday initial');
        $this->weekday_initial[__('Saturday')] = _x('S', 'Saturday initial');
        // Abbreviations for each day.
        $this->weekday_abbrev[__('Sunday')] = __('Sun');
        $this->weekday_abbrev[__('Monday')] = __('Mon');
        $this->weekday_abbrev[__('Tuesday')] = __('Tue');
        $this->weekday_abbrev[__('Wednesday')] = __('Wed');
        $this->weekday_abbrev[__('Thursday')] = __('Thu');
        $this->weekday_abbrev[__('Friday')] = __('Fri');
        $this->weekday_abbrev[__('Saturday')] = __('Sat');
        // The months.
        $this->month['01'] = __('January');
        $this->month['02'] = __('February');
        $this->month['03'] = __('March');
        $this->month['04'] = __('April');
        $this->month['05'] = __('May');
        $this->month['06'] = __('June');
        $this->month['07'] = __('July');
        $this->month['08'] = __('August');
        $this->month['09'] = __('September');
        $this->month['10'] = __('October');
        $this->month['11'] = __('November');
        $this->month['12'] = __('December');
        // The months, genitive.
        $this->month_genitive['01'] = _x('January', 'genitive');
        $this->month_genitive['02'] = _x('February', 'genitive');
        $this->month_genitive['03'] = _x('March', 'genitive');
        $this->month_genitive['04'] = _x('April', 'genitive');
        $this->month_genitive['05'] = _x('May', 'genitive');
        $this->month_genitive['06'] = _x('June', 'genitive');
        $this->month_genitive['07'] = _x('July', 'genitive');
        $this->month_genitive['08'] = _x('August', 'genitive');
        $this->month_genitive['09'] = _x('September', 'genitive');
        $this->month_genitive['10'] = _x('October', 'genitive');
        $this->month_genitive['11'] = _x('November', 'genitive');
        $this->month_genitive['12'] = _x('December', 'genitive');
        // Abbreviations for each month.
        $this->month_abbrev[__('January')] = _x('Jan', 'January abbreviation');
        $this->month_abbrev[__('February')] = _x('Feb', 'February abbreviation');
        $this->month_abbrev[__('March')] = _x('Mar', 'March abbreviation');
        $this->month_abbrev[__('April')] = _x('Apr', 'April abbreviation');
        $this->month_abbrev[__('May')] = _x('May', 'May abbreviation');
        $this->month_abbrev[__('June')] = _x('Jun', 'June abbreviation');
        $this->month_abbrev[__('July')] = _x('Jul', 'July abbreviation');
        $this->month_abbrev[__('August')] = _x('Aug', 'August abbreviation');
        $this->month_abbrev[__('September')] = _x('Sep', 'September abbreviation');
        $this->month_abbrev[__('October')] = _x('Oct', 'October abbreviation');
        $this->month_abbrev[__('November')] = _x('Nov', 'November abbreviation');
        $this->month_abbrev[__('December')] = _x('Dec', 'December abbreviation');
        // The meridiems.
        $this->meridiem['am'] = __('am');
        $this->meridiem['pm'] = __('pm');
        $this->meridiem['AM'] = __('AM');
        $this->meridiem['PM'] = __('PM');
        // Numbers formatting.
        // See https://www.php.net/number_format
        /* translators: $thousands_sep argument for https://www.php.net/number_format, default is ',' */
        $thousands_sep = __('number_format_thousands_sep');
        // Replace space with a non-breaking space to avoid wrapping.
        $thousands_sep = str_replace(' ', '&nbsp;', $thousands_sep);
        $this->number_format['thousands_sep'] = 'number_format_thousands_sep' === $thousands_sep ? ',' : $thousands_sep;
        /* translators: $dec_point argument for https://www.php.net/number_format, default is '.' */
        $decimal_point = __('number_format_decimal_point');
        $this->number_format['decimal_point'] = 'number_format_decimal_point' === $decimal_point ? '.' : $decimal_point;
        // Set text direction.
        if (isset($GLOBALS['text_direction'])) {
            $this->text_direction = $GLOBALS['text_direction'];
            /* translators: 'rtl' or 'ltr'. This sets the text direction for WordPress. */
        } elseif ('rtl' === _x('ltr', 'text direction')) {
            $this->text_direction = 'rtl';
        }
    }
    /**
     * Retrieve the full translated weekday word.
     *
     * Week starts on translated Sunday and can be fetched
     * by using 0 (zero). So the week starts with 0 (zero)
     * and ends on Saturday with is fetched by using 6 (six).
     *
     * @since 2.1.0
     *
     * @param int $weekday_number 0 for Sunday through 6 Saturday.
     * @return string Full translated weekday.
     */
    public function get_weekday($weekday_number)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_weekday") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php at line 214")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_weekday:214@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php');
        die();
    }
    /**
     * Retrieve the translated weekday initial.
     *
     * The weekday initial is retrieved by the translated
     * full weekday word. When translating the weekday initial
     * pay attention to make sure that the starting letter does
     * not conflict.
     *
     * @since 2.1.0
     *
     * @param string $weekday_name Full translated weekday word.
     * @return string Translated weekday initial.
     */
    public function get_weekday_initial($weekday_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_weekday_initial") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php at line 231")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_weekday_initial:231@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php');
        die();
    }
    /**
     * Retrieve the translated weekday abbreviation.
     *
     * The weekday abbreviation is retrieved by the translated
     * full weekday word.
     *
     * @since 2.1.0
     *
     * @param string $weekday_name Full translated weekday word.
     * @return string Translated weekday abbreviation.
     */
    public function get_weekday_abbrev($weekday_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_weekday_abbrev") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php at line 246")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_weekday_abbrev:246@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php');
        die();
    }
    /**
     * Retrieve the full translated month by month number.
     *
     * The $month_number parameter has to be a string
     * because it must have the '0' in front of any number
     * that is less than 10. Starts from '01' and ends at
     * '12'.
     *
     * You can use an integer instead and it will add the
     * '0' before the numbers less than 10 for you.
     *
     * @since 2.1.0
     *
     * @param string|int $month_number '01' through '12'.
     * @return string Translated full month name.
     */
    public function get_month($month_number)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_month") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php at line 266")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_month:266@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php');
        die();
    }
    /**
     * Retrieve translated version of month abbreviation string.
     *
     * The $month_name parameter is expected to be the translated or
     * translatable version of the month.
     *
     * @since 2.1.0
     *
     * @param string $month_name Translated month to get abbreviated version.
     * @return string Translated abbreviated month.
     */
    public function get_month_abbrev($month_name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_month_abbrev") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php at line 281")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_month_abbrev:281@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php');
        die();
    }
    /**
     * Retrieve translated version of meridiem string.
     *
     * The $meridiem parameter is expected to not be translated.
     *
     * @since 2.1.0
     *
     * @param string $meridiem Either 'am', 'pm', 'AM', or 'PM'. Not translated version.
     * @return string Translated version
     */
    public function get_meridiem($meridiem)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_meridiem") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php at line 295")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_meridiem:295@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php');
        die();
    }
    /**
     * Global variables are deprecated.
     *
     * For backward compatibility only.
     *
     * @deprecated For backward compatibility only.
     *
     * @global array $weekday
     * @global array $weekday_initial
     * @global array $weekday_abbrev
     * @global array $month
     * @global array $month_abbrev
     *
     * @since 2.1.0
     */
    public function register_globals()
    {
        $GLOBALS['weekday'] = $this->weekday;
        $GLOBALS['weekday_initial'] = $this->weekday_initial;
        $GLOBALS['weekday_abbrev'] = $this->weekday_abbrev;
        $GLOBALS['month'] = $this->month;
        $GLOBALS['month_abbrev'] = $this->month_abbrev;
    }
    /**
     * Checks if current locale is RTL.
     *
     * @since 3.0.0
     * @return bool Whether locale is RTL.
     */
    public function is_rtl()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_rtl") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php at line 328")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_rtl:328@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php');
        die();
    }
    /**
     * Register date/time format strings for general POT.
     *
     * Private, unused method to add some date/time formats translated
     * on wp-admin/options-general.php to the general POT that would
     * otherwise be added to the admin POT.
     *
     * @since 3.6.0
     */
    public function _strings_for_pot()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_strings_for_pot") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php at line 342")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _strings_for_pot:342@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_4/wp-includes/class-wp-locale.php');
        die();
    }
}