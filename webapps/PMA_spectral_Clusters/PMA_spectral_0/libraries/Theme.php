<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * hold Theme class
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PMA\libraries\URL;
/**
 * handles theme
 *
 * @todo add the possibility to make a theme depend on another theme
 * and by default on original
 * @todo make all components optional - get missing components from 'parent' theme
 *
 * @package PhpMyAdmin
 */
class Theme
{
    /**
     * @var string theme version
     * @access  protected
     */
    var $version = '0.0.0.0';
    /**
     * @var string theme name
     * @access  protected
     */
    var $name = '';
    /**
     * @var string theme id
     * @access  protected
     */
    var $id = '';
    /**
     * @var string theme path
     * @access  protected
     */
    var $path = '';
    /**
     * @var string image path
     * @access  protected
     */
    var $img_path = '';
    /**
     * @var integer last modification time for info file
     * @access  protected
     */
    var $mtime_info = 0;
    /**
     * needed because sometimes, the mtime for different themes
     * is identical
     * @var integer filesize for info file
     * @access  protected
     */
    var $filesize_info = 0;
    /**
     * @var array List of css files to load
     * @access private
     */
    private $_cssFiles = array('common', 'enum_editor', 'gis', 'navigation', 'pmd', 'rte', 'codemirror', 'jqplot', 'resizable-menu');
    /**
     * Loads theme information
     *
     * @return boolean whether loading them info was successful or not
     * @access  public
     */
    function loadInfo()
    {
        if (!file_exists($this->getPath() . '/info.inc.php')) {
            return false;
        }
        if ($this->mtime_info === filemtime($this->getPath() . '/info.inc.php')) {
            return true;
        }
        @(include $this->getPath() . '/info.inc.php');
        // was it set correctly?
        if (!isset($theme_name)) {
            return false;
        }
        $this->mtime_info = filemtime($this->getPath() . '/info.inc.php');
        $this->filesize_info = filesize($this->getPath() . '/info.inc.php');
        if (isset($theme_full_version)) {
            $this->setVersion($theme_full_version);
        } elseif (isset($theme_generation, $theme_version)) {
            $this->setVersion($theme_generation . '.' . $theme_version);
        }
        $this->setName($theme_name);
        return true;
    }
    /**
     * returns theme object loaded from given folder
     * or false if theme is invalid
     *
     * @param string $folder path to theme
     *
     * @return Theme|false
     * @static
     * @access public
     */
    public static function load($folder)
    {
        $theme = new Theme();
        $theme->setPath($folder);
        if (!$theme->loadInfo()) {
            return false;
        }
        $theme->checkImgPath();
        return $theme;
    }
    /**
     * checks image path for existence - if not found use img from fallback theme
     *
     * @access public
     * @return bool
     */
    public function checkImgPath()
    {
        // try current theme first
        if (is_dir($this->getPath() . '/img/')) {
            $this->setImgPath($this->getPath() . '/img/');
            return true;
        }
        // try fallback theme
        $fallback = './themes/' . ThemeManager::FALLBACK_THEME . '/img/';
        if (is_dir($fallback)) {
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
     * @access public
     * @return string path to theme
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     * returns layout file
     *
     * @access public
     * @return string layout file
     */
    public function getLayoutFile()
    {
        return $this->getPath() . '/layout.inc.php';
    }
    /**
     * set path to theme
     *
     * @param string $path path to theme
     *
     * @return void
     * @access public
     */
    public function setPath($path)
    {
        $this->path = trim($path);
    }
    /**
     * sets version
     *
     * @param string $version version to set
     *
     * @return void
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
     * @access public
     */
    public function getVersion()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getVersion") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Theme.php at line 232")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getVersion:232@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Theme.php');
        die();
    }
    /**
     * checks theme version against $version
     * returns true if theme version is equal or higher to $version
     *
     * @param string $version version to compare to
     *
     * @return boolean true if theme version is equal or higher to $version
     * @access public
     */
    public function checkVersion($version)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkVersion") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Theme.php at line 246")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkVersion:246@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Theme.php');
        die();
    }
    /**
     * sets name
     *
     * @param string $name name to set
     *
     * @return void
     * @access public
     */
    public function setName($name)
    {
        $this->name = trim($name);
    }
    /**
     * returns name
     *
     * @access  public
     * @return string name
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
     * @access public
     */
    public function setImgPath($path)
    {
        $this->img_path = $path;
    }
    /**
     * Returns the path to image for the theme.
     * If filename is given, it possibly fallbacks to fallback
     * theme for it if image does not exist.
     *
     * @param string $file file name for image
     *
     * @access public
     * @return string image path for this theme
     */
    public function getImgPath($file = null)
    {
        if (is_null($file)) {
            return $this->img_path;
        }
        if (is_readable($this->img_path . $file)) {
            return $this->img_path . $file;
        }
        return './themes/' . ThemeManager::FALLBACK_THEME . '/img/' . $file;
    }
    /**
     * load css (send to stdout, normally the browser)
     *
     * @return bool
     * @access  public
     */
    public function loadCss()
    {
        $success = true;
        if ($GLOBALS['text_dir'] === 'ltr') {
            $right = 'right';
            $left = 'left';
        } else {
            $right = 'left';
            $left = 'right';
        }
        foreach ($this->_cssFiles as $file) {
            $path = $this->getPath() . "/css/{$file}.css.php";
            $fallback = "./themes/" . ThemeManager::FALLBACK_THEME . "/css/{$file}.css.php";
            if (is_readable($path)) {
                echo "\n/* FILE: ", $file, ".css.php */\n";
                include $path;
            } else {
                if (is_readable($fallback)) {
                    echo "\n/* FILE: ", $file, ".css.php */\n";
                    include $fallback;
                } else {
                    $success = false;
                }
            }
        }
        $sprites = $this->getSpriteData();
        /* Check if there is a valid data file for sprites */
        if (count($sprites) > 0) {
            $bg = $this->getImgPath() . 'sprites.png?v=' . urlencode(PMA_VERSION);
            ?>
            /* Icon sprites */
            .icon {
            margin: 0;
            margin-<?php 
            echo $left;
            ?>: .3em;
            padding: 0 !important;
            width: 16px;
            height: 16px;
            background-image: url('<?php 
            echo $bg;
            ?>') !important;
            background-repeat: no-repeat !important;
            background-position: top left !important;
            }
            <?php 
            $template = ".ic_%s { background-position: 0 -%upx !important;%s%s }\n";
            foreach ($sprites as $name => $data) {
                // generate the CSS code for each icon
                $width = '';
                $height = '';
                // if either the height or width of an icon is 16px,
                // then it's pointless to set this as a parameter,
                //since it will be inherited from the "icon" class
                if ($data['width'] != 16) {
                    $width = " width: " . $data['width'] . "px;";
                }
                if ($data['height'] != 16) {
                    $height = " height: " . $data['height'] . "px;";
                }
                printf($template, $name, $data['position'] * 16, $width, $height);
            }
        }
        return $success;
    }
    /**
     * Loads sprites data
     *
     * @return array with sprites
     */
    public function getSpriteData()
    {
        $sprites = array();
        $filename = $this->getPath() . '/sprites.lib.php';
        if (is_readable($filename)) {
            // This defines sprites array
            include $filename;
            // Backwards compatibility for themes from 4.6 and older
            if (function_exists('PMA_sprites')) {
                $sprites = PMA_sprites();
            }
        }
        return $sprites;
    }
    /**
     * Renders the preview for this theme
     *
     * @return string
     * @access public
     */
    public function getPrintPreview()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPrintPreview") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Theme.php at line 443")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPrintPreview:443@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/Theme.php');
        die();
    }
    /**
     * Gets currently configured font size.
     *
     * @return String with font size.
     */
    function getFontSize()
    {
        $fs = $GLOBALS['PMA_Config']->get('fontsize');
        if (!is_null($fs)) {
            return $fs;
        }
        return '82%';
    }
    /**
     * Generates code for CSS gradient using various browser extensions.
     *
     * @param string $start_color Color of gradient start, hex value without #
     * @param string $end_color   Color of gradient end, hex value without #
     *
     * @return string CSS code.
     */
    function getCssGradient($start_color, $end_color)
    {
        $result = array();
        // Opera 9.5+, IE 9
        $result[] = 'background-image: url(./themes/svg_gradient.php?from=' . $start_color . '&to=' . $end_color . ');';
        $result[] = 'background-size: 100% 100%;';
        // Safari 4-5, Chrome 1-9
        $result[] = 'background: ' . '-webkit-gradient(linear, left top, left bottom, from(#' . $start_color . '), to(#' . $end_color . '));';
        // Safari 5.1, Chrome 10+
        $result[] = 'background: -webkit-linear-gradient(top, #' . $start_color . ', #' . $end_color . ');';
        // Firefox 3.6+
        $result[] = 'background: -moz-linear-gradient(top, #' . $start_color . ', #' . $end_color . ');';
        // IE 10
        $result[] = 'background: -ms-linear-gradient(top, #' . $start_color . ', #' . $end_color . ');';
        // Opera 11.10
        $result[] = 'background: -o-linear-gradient(top, #' . $start_color . ', #' . $end_color . ');';
        return implode("\n", $result);
    }
}