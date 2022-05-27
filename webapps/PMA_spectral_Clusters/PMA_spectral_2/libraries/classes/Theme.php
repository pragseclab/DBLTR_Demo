<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use const E_USER_ERROR;
use function file_exists;
use function file_get_contents;
use function filemtime;
use function filesize;
use function in_array;
use function is_array;
use function is_dir;
use function is_readable;
use function json_decode;
use function sprintf;
use function trigger_error;
use function trim;
use function version_compare;
/**
 * handles theme
 *
 * @todo add the possibility to make a theme depend on another theme
 * and by default on original
 * @todo make all components optional - get missing components from 'parent' theme
 */
class Theme
{
    /**
     * @var string theme version
     * @access protected
     */
    public $version = '0.0.0.0';
    /**
     * @var string theme name
     * @access protected
     */
    public $name = '';
    /**
     * @var string theme id
     * @access protected
     */
    public $id = '';
    /**
     * @var string theme path
     * @access protected
     */
    public $path = '';
    /** @var string file system theme path */
    private $fsPath = '';
    /**
     * @var string image path
     * @access protected
     */
    public $imgPath = '';
    /**
     * @var int last modification time for info file
     * @access protected
     */
    public $mtimeInfo = 0;
    /**
     * needed because sometimes, the mtime for different themes
     * is identical
     *
     * @var int filesize for info file
     * @access protected
     */
    public $filesizeInfo = 0;
    /**
     * @var array List of css files to load
     * @access private
     */
    public $cssFiles = array('common', 'enum_editor', 'gis', 'navigation', 'designer', 'rte', 'codemirror', 'jqplot', 'resizable-menu', 'icons');
    /** @var Template */
    public $template;
    public function __construct()
    {
        $this->template = new Template();
    }
    /**
     * Loads theme information
     *
     * @return bool whether loading them info was successful or not
     *
     * @access public
     */
    public function loadInfo()
    {
        $infofile = $this->getFsPath() . 'theme.json';
        if (!@file_exists($infofile)) {
            return false;
        }
        if ($this->mtimeInfo === filemtime($infofile)) {
            return true;
        }
        $content = @file_get_contents($infofile);
        if ($content === false) {
            return false;
        }
        $data = json_decode($content, true);
        // Did we get expected data?
        if (!is_array($data)) {
            return false;
        }
        // Check that all required data are there
        $members = ['name', 'version', 'supports'];
        foreach ($members as $member) {
            if (!isset($data[$member])) {
                return false;
            }
        }
        // Version check
        if (!is_array($data['supports'])) {
            return false;
        }
        if (!in_array(PMA_MAJOR_VERSION, $data['supports'])) {
            return false;
        }
        $this->mtimeInfo = filemtime($infofile);
        $this->filesizeInfo = filesize($infofile);
        $this->setVersion($data['version']);
        $this->setName($data['name']);
        return true;
    }
    /**
     * returns theme object loaded from given folder
     * or false if theme is invalid
     *
     * @param string $folder path to theme
     * @param string $fsPath file-system path to theme
     *
     * @return Theme|false
     *
     * @static
     * @access public
     */
    public static function load(string $folder, string $fsPath)
    {
        $theme = new Theme();
        $theme->setPath($folder);
        $theme->setFsPath($fsPath);
        if (!$theme->loadInfo()) {
            return false;
        }
        $theme->checkImgPath();
        return $theme;
    }
    /**
     * checks image path for existence - if not found use img from fallback theme
     *
     * @return bool
     *
     * @access public
     */
    public function checkImgPath()
    {
        // try current theme first
        if (is_dir($this->getFsPath() . 'img/')) {
            $this->setImgPath($this->getPath() . '/img/');
            return true;
        }
        // try fallback theme
        $fallback = ThemeManager::getThemesDir() . ThemeManager::FALLBACK_THEME . '/img/';
        if (is_dir(ThemeManager::getThemesFsDir() . ThemeManager::FALLBACK_THEME . '/img/')) {
            $this->setImgPath($fallback);
            return true;
        }
        // we failed
        trigger_error(sprintf(__('No valid image path for theme %s found!'), $this->getName()), E_USER_ERROR);
        return false;
    }
    /**
     * returns path to theme
     *
     * @return string path to theme
     *
     * @access public
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     * returns file system path to the theme
     *
     * @return string file system path to theme
     */
    public function getFsPath() : string
    {
        return $this->fsPath;
    }
    /**
     * set path to theme
     *
     * @param string $path path to theme
     *
     * @return void
     *
     * @access public
     */
    public function setPath($path)
    {
        $this->path = trim($path);
    }
    /**
     * set file system path to the theme
     *
     * @param string $path path to theme
     */
    public function setFsPath(string $path) : void
    {
        $this->fsPath = trim($path);
    }
    /**
     * sets version
     *
     * @param string $version version to set
     *
     * @return void
     *
     * @access public
     */
    public function setVersion($version)
    {
        $this->version = trim($version);
    }
    /**
     * returns version
     *
     * @return string version
     *
     * @access public
     */
    public function getVersion()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getVersion") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Theme.php at line 236")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getVersion:236@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Theme.php');
        die();
    }
    /**
     * checks theme version against $version
     * returns true if theme version is equal or higher to $version
     *
     * @param string $version version to compare to
     *
     * @return bool true if theme version is equal or higher to $version
     *
     * @access public
     */
    public function checkVersion($version)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkVersion") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Theme.php at line 250")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkVersion:250@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Theme.php');
        die();
    }
    /**
     * sets name
     *
     * @param string $name name to set
     *
     * @return void
     *
     * @access public
     */
    public function setName($name)
    {
        $this->name = trim($name);
    }
    /**
     * returns name
     *
     * @return string name
     *
     * @access public
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * sets id
     *
     * @param string $id new id
     *
     * @return void
     *
     * @access public
     */
    public function setId($id)
    {
        $this->id = trim($id);
    }
    /**
     * returns id
     *
     * @return string id
     *
     * @access public
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Sets path to images for the theme
     *
     * @param string $path path to images for this theme
     *
     * @return void
     *
     * @access public
     */
    public function setImgPath($path)
    {
        $this->imgPath = $path;
    }
    /**
     * Returns the path to image for the theme.
     * If filename is given, it possibly fallbacks to fallback
     * theme for it if image does not exist.
     *
     * @param string $file     file name for image
     * @param string $fallback fallback image
     *
     * @return string image path for this theme
     *
     * @access public
     */
    public function getImgPath($file = null, $fallback = null)
    {
        if ($file === null) {
            return $this->imgPath;
        }
        if (is_readable($this->imgPath . $file)) {
            return $this->imgPath . $file;
        }
        if ($fallback !== null) {
            return $this->getImgPath($fallback);
        }
        return './themes/' . ThemeManager::FALLBACK_THEME . '/img/' . $file;
    }
    /**
     * Renders the preview for this theme
     *
     * @return string
     *
     * @access public
     */
    public function getPrintPreview()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPrintPreview") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Theme.php at line 347")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPrintPreview:347@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Theme.php');
        die();
    }
}