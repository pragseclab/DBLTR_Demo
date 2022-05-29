<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Configuration handling.
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use DirectoryIterator;
use PMA\libraries\URL;
use PMA\libraries\ThemeManager;
/**
 * Indication for error handler (see end of this file).
 */
$GLOBALS['pma_config_loading'] = false;
/**
 * Configuration class
 *
 * @package PhpMyAdmin
 */
class Config
{
    /**
     * @var string  default config source
     */
    var $default_source = './libraries/config.default.php';
    /**
     * @var array   default configuration settings
     */
    var $default = array();
    /**
     * @var array   configuration settings, without user preferences applied
     */
    var $base_settings = array();
    /**
     * @var array   configuration settings
     */
    var $settings = array();
    /**
     * @var string  config source
     */
    var $source = '';
    /**
     * @var int     source modification time
     */
    var $source_mtime = 0;
    var $default_source_mtime = 0;
    var $set_mtime = 0;
    /**
     * @var boolean
     */
    var $error_config_file = false;
    /**
     * @var boolean
     */
    var $error_config_default_file = false;
    /**
     * @var array
     */
    var $default_server = array();
    /**
     * @var boolean whether init is done or not
     * set this to false to force some initial checks
     * like checking for required functions
     */
    var $done = false;
    /**
     * constructor
     *
     * @param string $source source to read config from
     */
    public function __construct($source = null)
    {
        $this->settings = array();
        // functions need to refresh in case of config file changed goes in
        // PMA\libraries\Config::load()
        $this->load($source);
        // other settings, independent from config file, comes in
        $this->checkSystem();
        $this->base_settings = $this->settings;
    }
    /**
     * sets system and application settings
     *
     * @return void
     */
    public function checkSystem()
    {
        $this->set('PMA_VERSION', '4.7.0');
        /**
         * @deprecated
         */
        $this->set('PMA_THEME_VERSION', 2);
        /**
         * @deprecated
         */
        $this->set('PMA_THEME_GENERATION', 2);
        $this->checkWebServerOs();
        $this->checkWebServer();
        $this->checkGd2();
        $this->checkClient();
        $this->checkUpload();
        $this->checkUploadSize();
        $this->checkOutputCompression();
    }
    /**
     * whether to use gzip output compression or not
     *
     * @return void
     */
    public function checkOutputCompression()
    {
        // If zlib output compression is set in the php configuration file, no
        // output buffering should be run
        if (@ini_get('zlib.output_compression')) {
            $this->set('OBGzip', false);
        }
        // enable output-buffering (if set to 'auto')
        if (strtolower($this->get('OBGzip')) == 'auto') {
            $this->set('OBGzip', true);
        }
    }
    /**
     * Sets the client platform based on user agent
     *
     * @param string $user_agent the user agent
     *
     * @return void
     */
    private function _setClientPlatform($user_agent)
    {
        if (mb_strstr($user_agent, 'Win')) {
            $this->set('PMA_USR_OS', 'Win');
        } elseif (mb_strstr($user_agent, 'Mac')) {
            $this->set('PMA_USR_OS', 'Mac');
        } elseif (mb_strstr($user_agent, 'Linux')) {
            $this->set('PMA_USR_OS', 'Linux');
        } elseif (mb_strstr($user_agent, 'Unix')) {
            $this->set('PMA_USR_OS', 'Unix');
        } elseif (mb_strstr($user_agent, 'OS/2')) {
            $this->set('PMA_USR_OS', 'OS/2');
        } else {
            $this->set('PMA_USR_OS', 'Other');
        }
    }
    /**
     * Determines platform (OS), browser and version of the user
     * Based on a phpBuilder article:
     *
     * @see http://www.phpbuilder.net/columns/tim20000821.php
     *
     * @return void
     */
    public function checkClient()
    {
        if (PMA_getenv('HTTP_USER_AGENT')) {
            $HTTP_USER_AGENT = PMA_getenv('HTTP_USER_AGENT');
        } else {
            $HTTP_USER_AGENT = '';
        }
        // 1. Platform
        $this->_setClientPlatform($HTTP_USER_AGENT);
        // 2. browser and version
        // (must check everything else before Mozilla)
        $is_mozilla = preg_match('@Mozilla/([0-9]\\.[0-9]{1,2})@', $HTTP_USER_AGENT, $mozilla_version);
        if (preg_match('@Opera(/| )([0-9]\\.[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[2]);
            $this->set('PMA_USR_BROWSER_AGENT', 'OPERA');
        } elseif (preg_match('@(MS)?IE ([0-9]{1,2}\\.[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[2]);
            $this->set('PMA_USR_BROWSER_AGENT', 'IE');
        } elseif (preg_match('@Trident/(7)\\.0@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', intval($log_version[1]) + 4);
            $this->set('PMA_USR_BROWSER_AGENT', 'IE');
        } elseif (preg_match('@OmniWeb/([0-9]{1,3})@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'OMNIWEB');
            // Konqueror 2.2.2 says Konqueror/2.2.2
            // Konqueror 3.0.3 says Konqueror/3
        } elseif (preg_match('@(Konqueror/)(.*)(;)@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[2]);
            $this->set('PMA_USR_BROWSER_AGENT', 'KONQUEROR');
            // must check Chrome before Safari
        } elseif ($is_mozilla && preg_match('@Chrome/([0-9.]*)@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'CHROME');
            // newer Safari
        } elseif ($is_mozilla && preg_match('@Version/(.*) Safari@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'SAFARI');
            // older Safari
        } elseif ($is_mozilla && preg_match('@Safari/([0-9]*)@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $mozilla_version[1] . '.' . $log_version[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'SAFARI');
            // Firefox
        } elseif (!mb_strstr($HTTP_USER_AGENT, 'compatible') && preg_match('@Firefox/([\\w.]+)@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'FIREFOX');
        } elseif (preg_match('@rv:1\\.9(.*)Gecko@', $HTTP_USER_AGENT)) {
            $this->set('PMA_USR_BROWSER_VER', '1.9');
            $this->set('PMA_USR_BROWSER_AGENT', 'GECKO');
        } elseif ($is_mozilla) {
            $this->set('PMA_USR_BROWSER_VER', $mozilla_version[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'MOZILLA');
        } else {
            $this->set('PMA_USR_BROWSER_VER', 0);
            $this->set('PMA_USR_BROWSER_AGENT', 'OTHER');
        }
    }
    /**
     * Whether GD2 is present
     *
     * @return void
     */
    public function checkGd2()
    {
        if ($this->get('GD2Available') == 'yes') {
            $this->set('PMA_IS_GD2', 1);
            return;
        }
        if ($this->get('GD2Available') == 'no') {
            $this->set('PMA_IS_GD2', 0);
            return;
        }
        if (!@function_exists('imagecreatetruecolor')) {
            $this->set('PMA_IS_GD2', 0);
            return;
        }
        if (@function_exists('gd_info')) {
            $gd_nfo = gd_info();
            if (mb_strstr($gd_nfo["GD Version"], '2.')) {
                $this->set('PMA_IS_GD2', 1);
            } else {
                $this->set('PMA_IS_GD2', 0);
            }
        } else {
            $this->set('PMA_IS_GD2', 0);
        }
    }
    /**
     * Whether the Web server php is running on is IIS
     *
     * @return void
     */
    public function checkWebServer()
    {
        // some versions return Microsoft-IIS, some Microsoft/IIS
        // we could use a preg_match() but it's slower
        if (PMA_getenv('SERVER_SOFTWARE') && stristr(PMA_getenv('SERVER_SOFTWARE'), 'Microsoft') && stristr(PMA_getenv('SERVER_SOFTWARE'), 'IIS')) {
            $this->set('PMA_IS_IIS', 1);
        } else {
            $this->set('PMA_IS_IIS', 0);
        }
    }
    /**
     * Whether the os php is running on is windows or not
     *
     * @return void
     */
    public function checkWebServerOs()
    {
        // Default to Unix or Equiv
        $this->set('PMA_IS_WINDOWS', 0);
        // If PHP_OS is defined then continue
        if (defined('PHP_OS')) {
            if (stristr(PHP_OS, 'win') && !stristr(PHP_OS, 'darwin')) {
                // Is it some version of Windows
                $this->set('PMA_IS_WINDOWS', 1);
            } elseif (stristr(PHP_OS, 'OS/2')) {
                // Is it OS/2 (No file permissions like Windows)
                $this->set('PMA_IS_WINDOWS', 1);
            }
        }
    }
    /**
     * detects if Git revision
     *
     * @return boolean
     */
    public function isGitRevision()
    {
        if (!$this->get('ShowGitRevision')) {
            return false;
        }
        // caching
        if (isset($_SESSION['is_git_revision'])) {
            if ($_SESSION['is_git_revision']) {
                $this->set('PMA_VERSION_GIT', 1);
            }
            return $_SESSION['is_git_revision'];
        }
        // find out if there is a .git folder
        $git_folder = '.git';
        if (!@file_exists($git_folder) || !@file_exists($git_folder . '/config')) {
            $_SESSION['is_git_revision'] = false;
            return false;
        }
        $_SESSION['is_git_revision'] = true;
        return true;
    }
    /**
     * detects Git revision, if running inside repo
     *
     * @return void
     */
    public function checkGitRevision()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkGitRevision") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Config.php at line 387")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkGitRevision:387@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Config.php');
        die();
    }
    /**
     * loads default values from default source
     *
     * @return boolean     success
     */
    public function loadDefaults()
    {
        $cfg = array();
        if (!@file_exists($this->default_source)) {
            $this->error_config_default_file = true;
            return false;
        }
        $old_error_reporting = error_reporting(0);
        ob_start();
        $GLOBALS['pma_config_loading'] = true;
        $eval_result = (include $this->default_source);
        $GLOBALS['pma_config_loading'] = false;
        ob_end_clean();
        error_reporting($old_error_reporting);
        if ($eval_result === false) {
            $this->error_config_default_file = true;
            return false;
        }
        $this->default_source_mtime = filemtime($this->default_source);
        $this->default_server = $cfg['Servers'][1];
        unset($cfg['Servers']);
        $this->default = $cfg;
        $this->settings = array_replace_recursive($this->settings, $cfg);
        $this->error_config_default_file = false;
        return true;
    }
    /**
     * loads configuration from $source, usually the config file
     * should be called on object creation
     *
     * @param string $source config file
     *
     * @return bool
     */
    public function load($source = null)
    {
        $this->loadDefaults();
        if (null !== $source) {
            $this->setSource($source);
        }
        /**
         * We check and set the font size at this point, to make the font size
         * selector work also for users without a config.inc.php
         */
        $this->checkFontsize();
        if (!$this->checkConfigSource()) {
            // even if no config file, set collation_connection
            $this->checkCollationConnection();
            return false;
        }
        $cfg = array();
        /**
         * Parses the configuration file, we throw away any errors or
         * output.
         */
        $old_error_reporting = error_reporting(0);
        ob_start();
        $GLOBALS['pma_config_loading'] = true;
        $eval_result = (include $this->getSource());
        $GLOBALS['pma_config_loading'] = false;
        ob_end_clean();
        error_reporting($old_error_reporting);
        if ($eval_result === false) {
            $this->error_config_file = true;
        } else {
            $this->error_config_file = false;
            $this->source_mtime = filemtime($this->getSource());
        }
        /**
         * Ignore keys with / as we do not use these
         *
         * These can be confusing for user configuration layer as it
         * flatten array using / and thus don't see difference between
         * $cfg['Export/method'] and $cfg['Export']['method'], while rest
         * of thre code uses the setting only in latter form.
         *
         * This could be removed once we consistently handle both values
         * in the functional code as well.
         *
         * It could use array_filter(...ARRAY_FILTER_USE_KEY), but it's not
         * supported on PHP 5.5 and HHVM.
         */
        $matched_keys = array_filter(array_keys($cfg), function ($key) {
            return strpos($key, '/') === false;
        });
        $cfg = array_intersect_key($cfg, array_flip($matched_keys));
        /**
         * Backward compatibility code
         */
        if (!empty($cfg['DefaultTabTable'])) {
            $cfg['DefaultTabTable'] = str_replace('_properties', '', str_replace('tbl_properties.php', 'tbl_sql.php', $cfg['DefaultTabTable']));
        }
        if (!empty($cfg['DefaultTabDatabase'])) {
            $cfg['DefaultTabDatabase'] = str_replace('_details', '', str_replace('db_details.php', 'db_sql.php', $cfg['DefaultTabDatabase']));
        }
        $this->settings = array_replace_recursive($this->settings, $cfg);
        // Handling of the collation must be done after merging of $cfg
        // (from config.inc.php) so that $cfg['DefaultConnectionCollation']
        // can have an effect.
        $this->checkCollationConnection();
        return true;
    }
    /**
     * Saves the connection collation
     *
     * @param array $config_data configuration data from user preferences
     *
     * @return void
     */
    private function _saveConnectionCollation($config_data)
    {
        // just to shorten the lines
        $collation = 'collation_connection';
        if (isset($GLOBALS[$collation]) && (isset($_COOKIE['pma_collation_connection']) || isset($_POST[$collation]))) {
            if (!isset($config_data[$collation]) && $GLOBALS[$collation] != 'utf8_general_ci' || isset($config_data[$collation]) && $GLOBALS[$collation] != $config_data[$collation]) {
                $this->setUserValue(null, $collation, $GLOBALS[$collation], 'utf8_general_ci');
            }
        } else {
            // read collation from settings
            if (isset($config_data[$collation])) {
                $GLOBALS[$collation] = $config_data[$collation];
                $this->setCookie('pma_collation_connection', $GLOBALS[$collation]);
            }
        }
    }
    /**
     * Loads user preferences and merges them with current config
     * must be called after control connection has been established
     *
     * @return void
     */
    public function loadUserPreferences()
    {
        // index.php should load these settings, so that phpmyadmin.css.php
        // will have everything available in session cache
        $server = isset($GLOBALS['server']) ? $GLOBALS['server'] : (!empty($GLOBALS['cfg']['ServerDefault']) ? $GLOBALS['cfg']['ServerDefault'] : 0);
        $cache_key = 'server_' . $server;
        if ($server > 0 && !defined('PMA_MINIMUM_COMMON')) {
            $config_mtime = max($this->default_source_mtime, $this->source_mtime);
            // cache user preferences, use database only when needed
            if (!isset($_SESSION['cache'][$cache_key]['userprefs']) || $_SESSION['cache'][$cache_key]['config_mtime'] < $config_mtime) {
                // load required libraries
                include_once './libraries/user_preferences.lib.php';
                $prefs = PMA_loadUserprefs();
                $_SESSION['cache'][$cache_key]['userprefs'] = PMA_applyUserprefs($prefs['config_data']);
                $_SESSION['cache'][$cache_key]['userprefs_mtime'] = $prefs['mtime'];
                $_SESSION['cache'][$cache_key]['userprefs_type'] = $prefs['type'];
                $_SESSION['cache'][$cache_key]['config_mtime'] = $config_mtime;
            }
        } elseif ($server == 0 || !isset($_SESSION['cache'][$cache_key]['userprefs'])) {
            $this->set('user_preferences', false);
            return;
        }
        $config_data = $_SESSION['cache'][$cache_key]['userprefs'];
        // type is 'db' or 'session'
        $this->set('user_preferences', $_SESSION['cache'][$cache_key]['userprefs_type']);
        $this->set('user_preferences_mtime', $_SESSION['cache'][$cache_key]['userprefs_mtime']);
        // backup some settings
        $org_fontsize = '';
        if (isset($this->settings['fontsize'])) {
            $org_fontsize = $this->settings['fontsize'];
        }
        // load config array
        $this->settings = array_replace_recursive($this->settings, $config_data);
        $GLOBALS['cfg'] = array_replace_recursive($GLOBALS['cfg'], $config_data);
        if (defined('PMA_MINIMUM_COMMON')) {
            return;
        }
        // settings below start really working on next page load, but
        // changes are made only in index.php so everything is set when
        // in frames
        // save theme
        /** @var ThemeManager $tmanager */
        $tmanager = ThemeManager::getInstance();
        if ($tmanager->getThemeCookie() || isset($_REQUEST['set_theme'])) {
            if (!isset($config_data['ThemeDefault']) && $tmanager->theme->getId() != 'original' || isset($config_data['ThemeDefault']) && $config_data['ThemeDefault'] != $tmanager->theme->getId()) {
                // new theme was set in common.inc.php
                $this->setUserValue(null, 'ThemeDefault', $tmanager->theme->getId(), 'original');
            }
        } else {
            // no cookie - read default from settings
            if ($this->settings['ThemeDefault'] != $tmanager->theme->getId() && $tmanager->checkTheme($this->settings['ThemeDefault'])) {
                $tmanager->setActiveTheme($this->settings['ThemeDefault']);
                $tmanager->setThemeCookie();
            }
        }
        // save font size
        if (!isset($config_data['fontsize']) && $org_fontsize != '82%' || isset($config_data['fontsize']) && $org_fontsize != $config_data['fontsize']) {
            $this->setUserValue(null, 'fontsize', $org_fontsize, '82%');
        }
        // save language
        if (isset($_COOKIE['pma_lang']) || isset($_POST['lang'])) {
            if (!isset($config_data['lang']) && $GLOBALS['lang'] != 'en' || isset($config_data['lang']) && $GLOBALS['lang'] != $config_data['lang']) {
                $this->setUserValue(null, 'lang', $GLOBALS['lang'], 'en');
            }
        } else {
            // read language from settings
            if (isset($config_data['lang'])) {
                $language = LanguageManager::getInstance()->getLanguage($config_data['lang']);
                if ($language !== false) {
                    $language->activate();
                    $this->setCookie('pma_lang', $language->getCode());
                }
            }
        }
        // save connection collation
        $this->_saveConnectionCollation($config_data);
    }
    /**
     * Sets config value which is stored in user preferences (if available)
     * or in a cookie.
     *
     * If user preferences are not yet initialized, option is applied to
     * global config and added to a update queue, which is processed
     * by {@link loadUserPreferences()}
     *
     * @param string $cookie_name   can be null
     * @param string $cfg_path      configuration path
     * @param mixed  $new_cfg_value new value
     * @param mixed  $default_value default value
     *
     * @return void
     */
    public function setUserValue($cookie_name, $cfg_path, $new_cfg_value, $default_value = null)
    {
        // use permanent user preferences if possible
        $prefs_type = $this->get('user_preferences');
        if ($prefs_type) {
            include_once './libraries/user_preferences.lib.php';
            if ($default_value === null) {
                $default_value = PMA_arrayRead($cfg_path, $this->default);
            }
            PMA_persistOption($cfg_path, $new_cfg_value, $default_value);
        }
        if ($prefs_type != 'db' && $cookie_name) {
            // fall back to cookies
            if ($default_value === null) {
                $default_value = PMA_arrayRead($cfg_path, $this->settings);
            }
            $this->setCookie($cookie_name, $new_cfg_value, $default_value);
        }
        PMA_arrayWrite($cfg_path, $GLOBALS['cfg'], $new_cfg_value);
        PMA_arrayWrite($cfg_path, $this->settings, $new_cfg_value);
    }
    /**
     * Reads value stored by {@link setUserValue()}
     *
     * @param string $cookie_name cookie name
     * @param mixed  $cfg_value   config value
     *
     * @return mixed
     */
    public function getUserValue($cookie_name, $cfg_value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUserValue") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Config.php at line 1061")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUserValue:1061@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Config.php');
        die();
    }
    /**
     * set source
     *
     * @param string $source source
     *
     * @return void
     */
    public function setSource($source)
    {
        $this->source = trim($source);
    }
    /**
     * check config source
     *
     * @return boolean whether source is valid or not
     */
    public function checkConfigSource()
    {
        if (!$this->getSource()) {
            // no configuration file set at all
            return false;
        }
        if (!@file_exists($this->getSource())) {
            $this->source_mtime = 0;
            return false;
        }
        if (!@is_readable($this->getSource())) {
            // manually check if file is readable
            // might be bug #3059806 Supporting running from CIFS/Samba shares
            $contents = false;
            $handle = @fopen($this->getSource(), 'r');
            if ($handle !== false) {
                $contents = @fread($handle, 1);
                // reading 1 byte is enough to test
                fclose($handle);
            }
            if ($contents === false) {
                $this->source_mtime = 0;
                PMA_fatalError(sprintf(function_exists('__') ? __('Existing configuration file (%s) is not readable.') : 'Existing configuration file (%s) is not readable.', $this->getSource()));
                return false;
            }
        }
        return true;
    }
    /**
     * verifies the permissions on config file (if asked by configuration)
     * (must be called after config.inc.php has been merged)
     *
     * @return void
     */
    public function checkPermissions()
    {
        // Check for permissions (on platforms that support it):
        if ($this->get('CheckConfigurationPermissions')) {
            $perms = @fileperms($this->getSource());
            if (!($perms === false) && $perms & 2) {
                // This check is normally done after loading configuration
                $this->checkWebServerOs();
                if ($this->get('PMA_IS_WINDOWS') == 0) {
                    $this->source_mtime = 0;
                    PMA_fatalError(__('Wrong permissions on configuration file, ' . 'should not be world writable!'));
                }
            }
        }
    }
    /**
     * Checks for errors
     * (must be called after config.inc.php has been merged)
     *
     * @return void
     */
    public function checkErrors()
    {
        if ($this->error_config_default_file) {
            PMA_fatalError(sprintf(__('Could not load default configuration from: %1$s'), $this->default_source));
        }
        if ($this->error_config_file) {
            $error = '[strong]' . __('Failed to read configuration file!') . '[/strong]' . '[br][br]' . __('This usually means there is a syntax error in it, ' . 'please check any errors shown below.') . '[br][br]' . '[conferr]';
            trigger_error($error, E_USER_ERROR);
        }
    }
    /**
     * returns specific config setting
     *
     * @param string $setting config setting
     *
     * @return mixed value
     */
    public function get($setting)
    {
        if (isset($this->settings[$setting])) {
            return $this->settings[$setting];
        }
        return null;
    }
    /**
     * sets configuration variable
     *
     * @param string $setting configuration option
     * @param mixed  $value   new value for configuration option
     *
     * @return void
     */
    public function set($setting, $value)
    {
        if (!isset($this->settings[$setting]) || $this->settings[$setting] !== $value) {
            $this->settings[$setting] = $value;
            $this->set_mtime = time();
        }
    }
    /**
     * returns source for current config
     *
     * @return string  config source
     */
    public function getSource()
    {
        return $this->source;
    }
    /**
     * returns a unique value to force a CSS reload if either the config
     * or the theme changes
     * must also check the pma_fontsize cookie in case there is no
     * config file
     *
     * @return int Summary of unix timestamps and fontsize,
     * to be unique on theme parameters change
     */
    public function getThemeUniqueValue()
    {
        if (null !== $this->get('fontsize')) {
            $fontsize = intval($this->get('fontsize'));
        } elseif (isset($_COOKIE['pma_fontsize'])) {
            $fontsize = intval($_COOKIE['pma_fontsize']);
        } else {
            $fontsize = 0;
        }
        return $fontsize + $this->source_mtime + $this->default_source_mtime + $this->get('user_preferences_mtime') + $_SESSION['PMA_Theme']->mtime_info + $_SESSION['PMA_Theme']->filesize_info;
    }
    /**
     * Sets collation_connection based on user preference. First is checked
     * value from request, then cookies with fallback to default.
     *
     * After setting it here, cookie is set in common.inc.php to persist
     * the selection.
     *
     * @todo check validity of collation string
     *
     * @return void
     */
    public function checkCollationConnection()
    {
        if (!empty($_REQUEST['collation_connection'])) {
            $collation = htmlspecialchars(strip_tags($_REQUEST['collation_connection']));
        } elseif (!empty($_COOKIE['pma_collation_connection'])) {
            $collation = htmlspecialchars(strip_tags($_COOKIE['pma_collation_connection']));
        } else {
            $collation = $this->get('DefaultConnectionCollation');
        }
        $this->set('collation_connection', $collation);
    }
    /**
     * checks for font size configuration, and sets font size as requested by user
     *
     * @return void
     */
    public function checkFontsize()
    {
        $new_fontsize = '';
        if (isset($_GET['set_fontsize'])) {
            $new_fontsize = $_GET['set_fontsize'];
        } elseif (isset($_POST['set_fontsize'])) {
            $new_fontsize = $_POST['set_fontsize'];
        } elseif (isset($_COOKIE['pma_fontsize'])) {
            $new_fontsize = $_COOKIE['pma_fontsize'];
        }
        if (preg_match('/^[0-9.]+(px|em|pt|\\%)$/', $new_fontsize)) {
            $this->set('fontsize', $new_fontsize);
        } elseif (!$this->get('fontsize')) {
            // 80% would correspond to the default browser font size
            // of 16, but use 82% to help read the monoface font
            $this->set('fontsize', '82%');
        }
        $this->setCookie('pma_fontsize', $this->get('fontsize'), '82%');
    }
    /**
     * checks if upload is enabled
     *
     * @return void
     */
    public function checkUpload()
    {
        if (!ini_get('file_uploads')) {
            $this->set('enable_upload', false);
            return;
        }
        $this->set('enable_upload', true);
        // if set "php_admin_value file_uploads Off" in httpd.conf
        // ini_get() also returns the string "Off" in this case:
        if ('off' == strtolower(ini_get('file_uploads'))) {
            $this->set('enable_upload', false);
        }
    }
    /**
     * Maximum upload size as limited by PHP
     * Used with permission from Moodle (https://moodle.org/) by Martin Dougiamas
     *
     * this section generates $max_upload_size in bytes
     *
     * @return void
     */
    public function checkUploadSize()
    {
        if (!($filesize = ini_get('upload_max_filesize'))) {
            $filesize = "5M";
        }
        if ($postsize = ini_get('post_max_size')) {
            $this->set('max_upload_size', min(PMA_getRealSize($filesize), PMA_getRealSize($postsize)));
        } else {
            $this->set('max_upload_size', PMA_getRealSize($filesize));
        }
    }
    /**
     * Checks if protocol is https
     *
     * This function checks if the https protocol on the active connection.
     *
     * @return bool
     */
    public function isHttps()
    {
        if (null !== $this->get('is_https')) {
            return $this->get('is_https');
        }
        $url = $this->get('PmaAbsoluteUri');
        $is_https = false;
        if (!empty($url) && parse_url($url, PHP_URL_SCHEME) === 'https') {
            $is_https = true;
        } elseif (strtolower(PMA_getenv('HTTP_SCHEME')) == 'https') {
            $is_https = true;
        } elseif (strtolower(PMA_getenv('HTTPS')) == 'on') {
            $is_https = true;
        } elseif (substr(strtolower(PMA_getenv('REQUEST_URI')), 0, 6) == 'https:') {
            $is_https = true;
        } elseif (strtolower(PMA_getenv('HTTP_HTTPS_FROM_LB')) == 'on') {
            // A10 Networks load balancer
            $is_https = true;
        } elseif (strtolower(PMA_getenv('HTTP_FRONT_END_HTTPS')) == 'on') {
            $is_https = true;
        } elseif (strtolower(PMA_getenv('HTTP_X_FORWARDED_PROTO')) == 'https') {
            $is_https = true;
        } elseif (PMA_getenv('SERVER_PORT') == 443) {
            $is_https = true;
        }
        $this->set('is_https', $is_https);
        return $is_https;
    }
    /**
     * Get phpMyAdmin root path
     *
     * @return string
     */
    public function getRootPath()
    {
        static $cookie_path = null;
        if (null !== $cookie_path && !defined('TESTSUITE')) {
            return $cookie_path;
        }
        $url = $this->get('PmaAbsoluteUri');
        if (!empty($url)) {
            $path = parse_url($url, PHP_URL_PATH);
            if (!empty($path)) {
                if (substr($path, -1) != '/') {
                    return $path . '/';
                }
                return $path;
            }
        }
        $parsed_url = parse_url($GLOBALS['PMA_PHP_SELF']);
        $parts = explode('/', rtrim(str_replace('\\', '/', $parsed_url['path']), '/'));
        /* Remove filename */
        if (substr($parts[count($parts) - 1], -4) == '.php') {
            $parts = array_slice($parts, 0, count($parts) - 1);
        }
        /* Remove extra path from javascript calls */
        if (defined('PMA_PATH_TO_BASEDIR')) {
            $parts = array_slice($parts, 0, count($parts) - 1);
        }
        $parts[] = '';
        return implode('/', $parts);
    }
    /**
     * enables backward compatibility
     *
     * @return void
     */
    public function enableBc()
    {
        $GLOBALS['cfg'] = $this->settings;
        $GLOBALS['default_server'] = $this->default_server;
        unset($this->default_server);
        $GLOBALS['collation_connection'] = $this->get('collation_connection');
        $GLOBALS['is_upload'] = $this->get('enable_upload');
        $GLOBALS['max_upload_size'] = $this->get('max_upload_size');
        $GLOBALS['is_https'] = $this->get('is_https');
        $defines = array('PMA_VERSION', 'PMA_THEME_VERSION', 'PMA_THEME_GENERATION', 'PMA_IS_WINDOWS', 'PMA_IS_GD2', 'PMA_USR_OS', 'PMA_USR_BROWSER_VER', 'PMA_USR_BROWSER_AGENT');
        foreach ($defines as $define) {
            if (!defined($define)) {
                define($define, $this->get($define));
            }
        }
    }
    /**
     * returns options for font size selection
     *
     * @param string $current_size current selected font size with unit
     *
     * @return array selectable font sizes
     */
    protected static function getFontsizeOptions($current_size = '82%')
    {
        $unit = preg_replace('/[0-9.]*/', '', $current_size);
        $value = preg_replace('/[^0-9.]*/', '', $current_size);
        $factors = array();
        $options = array();
        $options["{$value}"] = $value . $unit;
        if ($unit === '%') {
            $factors[] = 1;
            $factors[] = 5;
            $factors[] = 10;
            $options['100'] = '100%';
        } elseif ($unit === 'em') {
            $factors[] = 0.05;
            $factors[] = 0.2;
            $factors[] = 1;
        } elseif ($unit === 'pt') {
            $factors[] = 0.5;
            $factors[] = 2;
        } elseif ($unit === 'px') {
            $factors[] = 1;
            $factors[] = 5;
            $factors[] = 10;
        } else {
            //unknown font size unit
            $factors[] = 0.05;
            $factors[] = 0.2;
            $factors[] = 1;
            $factors[] = 5;
            $factors[] = 10;
        }
        foreach ($factors as $key => $factor) {
            $option_inc = $value + $factor;
            $option_dec = $value - $factor;
            while (count($options) < 21) {
                $options["{$option_inc}"] = $option_inc . $unit;
                if ($option_dec > $factors[0]) {
                    $options["{$option_dec}"] = $option_dec . $unit;
                }
                $option_inc += $factor;
                $option_dec -= $factor;
                if (isset($factors[$key + 1]) && $option_inc >= $value + $factors[$key + 1]) {
                    break;
                }
            }
        }
        ksort($options);
        return $options;
    }
    /**
     * returns html selectbox for font sizes
     *
     * @return string html selectbox
     */
    protected static function getFontsizeSelection()
    {
        $current_size = $GLOBALS['PMA_Config']->get('fontsize');
        // for the case when there is no config file (this is supported)
        if (empty($current_size)) {
            if (isset($_COOKIE['pma_fontsize'])) {
                $current_size = htmlspecialchars($_COOKIE['pma_fontsize']);
            } else {
                $current_size = '82%';
            }
        }
        $options = Config::getFontsizeOptions($current_size);
        $return = '<label for="select_fontsize">' . __('Font size') . ':</label>' . "\n" . '<select name="set_fontsize" id="select_fontsize"' . ' class="autosubmit">' . "\n";
        foreach ($options as $option) {
            $return .= '<option value="' . $option . '"';
            if ($option == $current_size) {
                $return .= ' selected="selected"';
            }
            $return .= '>' . $option . '</option>' . "\n";
        }
        $return .= '</select>';
        return $return;
    }
    /**
     * return complete font size selection form
     *
     * @return string html selectbox
     */
    public static function getFontsizeForm()
    {
        return '<form name="form_fontsize_selection" id="form_fontsize_selection"' . ' method="get" action="index.php" class="disableAjax">' . "\n" . URL::getHiddenInputs() . "\n" . Config::getFontsizeSelection() . "\n" . '</form>';
    }
    /**
     * removes cookie
     *
     * @param string $cookie name of cookie to remove
     *
     * @return boolean result of setcookie()
     */
    public function removeCookie($cookie)
    {
        if (defined('TESTSUITE')) {
            if (isset($_COOKIE[$cookie])) {
                unset($_COOKIE[$cookie]);
            }
            return true;
        }
        return setcookie($cookie, '', time() - 3600, $this->getRootPath(), '', $this->isHttps());
    }
    /**
     * sets cookie if value is different from current cookie value,
     * or removes if value is equal to default
     *
     * @param string $cookie   name of cookie to remove
     * @param mixed  $value    new cookie value
     * @param string $default  default value
     * @param int    $validity validity of cookie in seconds (default is one month)
     * @param bool   $httponly whether cookie is only for HTTP (and not for scripts)
     *
     * @return boolean result of setcookie()
     */
    public function setCookie($cookie, $value, $default = null, $validity = null, $httponly = true)
    {
        if (strlen($value) > 0 && null !== $default && $value === $default) {
            // default value is used
            if (isset($_COOKIE[$cookie])) {
                // remove cookie
                return $this->removeCookie($cookie);
            }
            return false;
        }
        if (strlen($value) === 0 && isset($_COOKIE[$cookie])) {
            // remove cookie, value is empty
            return $this->removeCookie($cookie);
        }
        if (!isset($_COOKIE[$cookie]) || $_COOKIE[$cookie] !== $value) {
            // set cookie with new value
            /* Calculate cookie validity */
            if ($validity === null) {
                /* Valid for one month */
                $validity = time() + 2592000;
            } elseif ($validity == 0) {
                /* Valid for session */
                $validity = 0;
            } else {
                $validity = time() + $validity;
            }
            if (defined('TESTSUITE')) {
                $_COOKIE[$cookie] = $value;
                return true;
            }
            return setcookie($cookie, $value, $validity, $this->getRootPath(), '', $this->isHttps(), $httponly);
        }
        // cookie has already $value as value
        return true;
    }
    /**
     * Error handler to catch fatal errors when loading configuration
     * file
     *
     *
     * PMA_Config_fatalErrorHandler
     * @return void
     */
    public static function fatalErrorHandler()
    {
        if (!isset($GLOBALS['pma_config_loading']) || !$GLOBALS['pma_config_loading']) {
            return;
        }
        $error = error_get_last();
        if ($error === null) {
            return;
        }
        PMA_fatalError(sprintf('Failed to load phpMyAdmin configuration (%s:%s): %s', Error::relPath($error['file']), $error['line'], $error['message']));
    }
    /**
     * Wrapper for footer/header rendering
     *
     * @param string $filename File to check and render
     * @param string $id       Div ID
     *
     * @return string
     */
    private static function _renderCustom($filename, $id)
    {
        $retval = '';
        if (file_exists($filename)) {
            $retval .= '<div id="' . $id . '">';
            ob_start();
            include $filename;
            $retval .= ob_get_contents();
            ob_end_clean();
            $retval .= '</div>';
        }
        return $retval;
    }
    /**
     * Renders user configured footer
     *
     * @return string
     */
    public static function renderFooter()
    {
        return self::_renderCustom(CUSTOM_FOOTER_FILE, 'pma_footer');
    }
    /**
     * Renders user configured footer
     *
     * @return string
     */
    public static function renderHeader()
    {
        return self::_renderCustom(CUSTOM_HEADER_FILE, 'pma_header');
    }
}
if (!defined('TESTSUITE')) {
    register_shutdown_function(array('PMA\\libraries\\Config', 'fatalErrorHandler'));
}