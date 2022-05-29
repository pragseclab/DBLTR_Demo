<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Hold the PMA\libraries\LanguageManager class
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PMA\libraries\LanguageManager;
/**
 * Language object
 *
 * @package PhpMyAdmin
 */
class Language
{
    protected $code;
    protected $name;
    protected $native;
    protected $regex;
    protected $mysql;
    /**
     * Constructs the Language object
     *
     * @param string $code   Language code
     * @param string $name   English name
     * @param string $native Native name
     * @param string $regex  Match regullar expression
     * @param string $mysql  MySQL locale code
     *
     */
    public function __construct($code, $name, $native, $regex, $mysql)
    {
        $this->code = $code;
        $this->name = $name;
        $this->native = $native;
        if (strpos($regex, '[-_]') === false) {
            $regex = str_replace('|', '([-_][[:alpha:]]{2,3})?|', $regex);
        }
        $this->regex = $regex;
        $this->mysql = $mysql;
    }
    /**
     * Returns native name for language
     *
     * @return string
     */
    public function getNativeName()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getNativeName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Language.php at line 55")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getNativeName:55@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Language.php');
        die();
    }
    /**
     * Returns English name for language
     *
     * @return string
     */
    public function getEnglishName()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEnglishName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Language.php at line 65")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getEnglishName:65@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Language.php');
        die();
    }
    /**
     * Returns verbose name for language
     *
     * @return string
     */
    public function getName()
    {
        if (!empty($this->native)) {
            return $this->native . ' - ' . $this->name;
        } else {
            return $this->name;
        }
    }
    /**
     * Returns language code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Returns MySQL locale code, can be empty
     *
     * @return string
     */
    public function getMySQLLocale()
    {
        return $this->mysql;
    }
    /**
     * Compare function used for sorting
     *
     * @param Language $other Other object to compare
     *
     * @return int same as strcmp
     */
    public function cmp($other)
    {
        return strcmp($this->name, $other->name);
    }
    /**
     * Checks whether language is currently active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $GLOBALS['lang'] == $this->code;
    }
    /**
     * Checks whether language matches HTTP header Accept-Language.
     *
     * @param string $header Header content
     *
     * @return bool
     */
    public function matchesAcceptLanguage($header)
    {
        $pattern = '/^(' . addcslashes($this->regex, '/') . ')(;q=[0-9]\\.[0-9])?$/i';
        return preg_match($pattern, $header);
    }
    /**
     * Checks whether language matches HTTP header User-Agent
     *
     * @param string $header Header content
     *
     * @return bool
     */
    public function matchesUserAgent($header)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("matchesUserAgent") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Language.php at line 148")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called matchesUserAgent:148@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Language.php');
        die();
    }
    /**
     * Checks whether langauge is RTL
     *
     * @return bool
     */
    public function isRTL()
    {
        return in_array($this->code, array('ar', 'fa', 'he', 'ur'));
    }
    /**
     * Activates given translation
     *
     * @return bool
     */
    public function activate()
    {
        $GLOBALS['lang'] = $this->code;
        // Set locale
        _setlocale(0, $this->code);
        _bindtextdomain('phpmyadmin', LOCALE_PATH);
        _textdomain('phpmyadmin');
        /* Text direction for language */
        if ($this->isRTL()) {
            $GLOBALS['text_dir'] = 'rtl';
        } else {
            $GLOBALS['text_dir'] = 'ltr';
        }
        /* TCPDF */
        $GLOBALS['l'] = array();
        /* TCPDF settings */
        $GLOBALS['l']['a_meta_charset'] = 'UTF-8';
        $GLOBALS['l']['a_meta_dir'] = $GLOBALS['text_dir'];
        $GLOBALS['l']['a_meta_language'] = $this->code;
        /* TCPDF translations */
        $GLOBALS['l']['w_page'] = __('Page number:');
        /* Show possible warnings from langauge selection */
        LanguageManager::getInstance()->showWarnings();
    }
}