<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Config file management
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries\config;

use PMA\libraries\Config;
/**
 * Config file management class.
 * Stores its data in $_SESSION
 *
 * @package PhpMyAdmin
 */
class ConfigFile
{
    /**
     * Stores default PMA config from config.default.php
     * @var array
     */
    private $_defaultCfg;
    /**
     * Stores allowed values for non-standard fields
     * @var array
     */
    private $_cfgDb;
    /**
     * Stores original PMA config, not modified by user preferences
     * @var Config
     */
    private $_baseCfg;
    /**
     * Whether we are currently working in PMA Setup context
     * @var bool
     */
    private $_isInSetup;
    /**
     * Keys which will be always written to config file
     * @var array
     */
    private $_persistKeys = array();
    /**
     * Changes keys while updating config in {@link updateWithGlobalConfig()}
     * or reading by {@link getConfig()} or {@link getConfigArray()}
     * @var array
     */
    private $_cfgUpdateReadMapping = array();
    /**
     * Key filter for {@link set()}
     * @var array|null
     */
    private $_setFilter;
    /**
     * Instance id (key in $_SESSION array, separate for each server -
     * ConfigFile{server id})
     * @var string
     */
    private $_id;
    /**
     * Result for {@link _flattenArray()}
     * @var array|null
     */
    private $_flattenArrayResult;
    /**
     * Constructor
     *
     * @param array $base_config base configuration read from
     *                           {@link PMA\libraries\Config::$base_config},
     *                           use only when not in PMA Setup
     */
    public function __construct(array $base_config = null)
    {
        // load default config values
        $cfg =& $this->_defaultCfg;
        include './libraries/config.default.php';
        $cfg['fontsize'] = '82%';
        // load additional config information
        $cfg_db =& $this->_cfgDb;
        include './libraries/config.values.php';
        // apply default values overrides
        if (count($cfg_db['_overrides'])) {
            foreach ($cfg_db['_overrides'] as $path => $value) {
                PMA_arrayWrite($path, $cfg, $value);
            }
        }
        $this->_baseCfg = $base_config;
        $this->_isInSetup = is_null($base_config);
        $this->_id = 'ConfigFile' . $GLOBALS['server'];
        if (!isset($_SESSION[$this->_id])) {
            $_SESSION[$this->_id] = array();
        }
    }
    /**
     * Sets names of config options which will be placed in config file even if
     * they are set to their default values (use only full paths)
     *
     * @param array $keys the names of the config options
     *
     * @return void
     */
    public function setPersistKeys(array $keys)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setPersistKeys") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 121")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setPersistKeys:121@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Returns flipped array set by {@link setPersistKeys()}
     *
     * @return array
     */
    public function getPersistKeysMap()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPersistKeysMap") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 131")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPersistKeysMap:131@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * By default ConfigFile allows setting of all configuration keys, use
     * this method to set up a filter on {@link set()} method
     *
     * @param array|null $keys array of allowed keys or null to remove filter
     *
     * @return void
     */
    public function setAllowedKeys($keys)
    {
        if ($keys === null) {
            $this->_setFilter = null;
            return;
        }
        // checking key presence is much faster than searching so move values
        // to keys
        $this->_setFilter = array_flip($keys);
    }
    /**
     * Sets path mapping for updating config in
     * {@link updateWithGlobalConfig()} or reading
     * by {@link getConfig()} or {@link getConfigArray()}
     *
     * @param array $mapping Contains the mapping of "Server/config options"
     *                       to "Server/1/config options"
     *
     * @return void
     */
    public function setCfgUpdateReadMapping(array $mapping)
    {
        $this->_cfgUpdateReadMapping = $mapping;
    }
    /**
     * Resets configuration data
     *
     * @return void
     */
    public function resetConfigData()
    {
        $_SESSION[$this->_id] = array();
    }
    /**
     * Sets configuration data (overrides old data)
     *
     * @param array $cfg Configuration options
     *
     * @return void
     */
    public function setConfigData(array $cfg)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setConfigData") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 187")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setConfigData:187@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Sets config value
     *
     * @param string $path           Path
     * @param mixed  $value          Value
     * @param string $canonical_path Canonical path
     *
     * @return void
     */
    public function set($path, $value, $canonical_path = null)
    {
        if ($canonical_path === null) {
            $canonical_path = $this->getCanonicalPath($path);
        }
        // apply key whitelist
        if ($this->_setFilter !== null && !isset($this->_setFilter[$canonical_path])) {
            return;
        }
        // if the path isn't protected it may be removed
        if (isset($this->_persistKeys[$canonical_path])) {
            PMA_arrayWrite($path, $_SESSION[$this->_id], $value);
            return;
        }
        $default_value = $this->getDefault($canonical_path);
        $remove_path = $value === $default_value;
        if ($this->_isInSetup) {
            // remove if it has a default value or is empty
            $remove_path = $remove_path || empty($value) && empty($default_value);
        } else {
            // get original config values not overwritten by user
            // preferences to allow for overwriting options set in
            // config.inc.php with default values
            $instance_default_value = PMA_arrayRead($canonical_path, $this->_baseCfg);
            // remove if it has a default value and base config (config.inc.php)
            // uses default value
            $remove_path = $remove_path && $instance_default_value === $default_value;
        }
        if ($remove_path) {
            PMA_arrayRemove($path, $_SESSION[$this->_id]);
            return;
        }
        PMA_arrayWrite($path, $_SESSION[$this->_id], $value);
    }
    /**
     * Flattens multidimensional array, changes indices to paths
     * (eg. 'key/subkey').
     * Used as array_walk() callback.
     *
     * @param mixed $value  Value
     * @param mixed $key    Key
     * @param mixed $prefix Prefix
     *
     * @return void
     */
    private function _flattenArray($value, $key, $prefix)
    {
        // no recursion for numeric arrays
        if (is_array($value) && !isset($value[0])) {
            $prefix .= $key . '/';
            array_walk($value, array($this, '_flattenArray'), $prefix);
        } else {
            $this->_flattenArrayResult[$prefix . $key] = $value;
        }
    }
    /**
     * Returns default config in a flattened array
     *
     * @return array
     */
    public function getFlatDefaultConfig()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFlatDefaultConfig") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 272")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFlatDefaultConfig:272@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Updates config with values read from given array
     * (config will contain differences to defaults from config.defaults.php).
     *
     * @param array $cfg Configuration
     *
     * @return void
     */
    public function updateWithGlobalConfig(array $cfg)
    {
        // load config array and flatten it
        $this->_flattenArrayResult = array();
        array_walk($cfg, array($this, '_flattenArray'), '');
        $flat_cfg = $this->_flattenArrayResult;
        $this->_flattenArrayResult = null;
        // save values map for translating a few user preferences paths,
        // should be complemented by code reading from generated config
        // to perform inverse mapping
        foreach ($flat_cfg as $path => $value) {
            if (isset($this->_cfgUpdateReadMapping[$path])) {
                $path = $this->_cfgUpdateReadMapping[$path];
            }
            $this->set($path, $value, $path);
        }
    }
    /**
     * Returns config value or $default if it's not set
     *
     * @param string $path    Path of config file
     * @param mixed  $default Default values
     *
     * @return mixed
     */
    public function get($path, $default = null)
    {
        return PMA_arrayRead($path, $_SESSION[$this->_id], $default);
    }
    /**
     * Returns default config value or $default it it's not set ie. it doesn't
     * exist in config.default.php ($cfg) and config.values.php
     * ($_cfg_db['_overrides'])
     *
     * @param string $canonical_path Canonical path
     * @param mixed  $default        Default value
     *
     * @return mixed
     */
    public function getDefault($canonical_path, $default = null)
    {
        return PMA_arrayRead($canonical_path, $this->_defaultCfg, $default);
    }
    /**
     * Returns config value, if it's not set uses the default one; returns
     * $default if the path isn't set and doesn't contain a default value
     *
     * @param string $path    Path
     * @param mixed  $default Default value
     *
     * @return mixed
     */
    public function getValue($path, $default = null)
    {
        $v = PMA_arrayRead($path, $_SESSION[$this->_id], null);
        if ($v !== null) {
            return $v;
        }
        $path = $this->getCanonicalPath($path);
        return $this->getDefault($path, $default);
    }
    /**
     * Returns canonical path
     *
     * @param string $path Path
     *
     * @return string
     */
    public function getCanonicalPath($path)
    {
        return preg_replace('#^Servers/([\\d]+)/#', 'Servers/1/', $path);
    }
    /**
     * Returns config database entry for $path ($cfg_db in config_info.php)
     *
     * @param string $path    path of the variable in config db
     * @param mixed  $default default value
     *
     * @return mixed
     */
    public function getDbEntry($path, $default = null)
    {
        return PMA_arrayRead($path, $this->_cfgDb, $default);
    }
    /**
     * Returns server count
     *
     * @return int
     */
    public function getServerCount()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getServerCount") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 385")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getServerCount:385@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Returns server list
     *
     * @return array|null
     */
    public function getServers()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getServers") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 397")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getServers:397@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Returns DSN of given server
     *
     * @param integer $server server index
     *
     * @return string
     */
    public function getServerDSN($server)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getServerDSN") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 411")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getServerDSN:411@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Returns server name
     *
     * @param int $id server index
     *
     * @return string
     */
    public function getServerName($id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getServerName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 445")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getServerName:445@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Removes server
     *
     * @param int $server server index
     *
     * @return void
     */
    public function removeServer($server)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("removeServer") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 465")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called removeServer:465@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Returns configuration array (full, multidimensional format)
     *
     * @return array
     */
    public function getConfig()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getConfig") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 490")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getConfig:490@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Returns configuration array (flat format)
     *
     * @return array
     */
    public function getConfigArray()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getConfigArray") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 508")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getConfigArray:508@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
    /**
     * Returns temporary directory
     *
     * @return string
     */
    public static function getDefaultTempDirectory()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDefaultTempDirectory") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php at line 538")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDefaultTempDirectory:538@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/ConfigFile.php');
        die();
    }
}