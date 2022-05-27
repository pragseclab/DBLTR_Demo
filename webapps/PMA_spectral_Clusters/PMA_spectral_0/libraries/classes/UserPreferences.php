<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Config\ConfigFile;
use PhpMyAdmin\Config\Forms\User\UserFormList;
use function array_flip;
use function array_merge;
use function basename;
use function http_build_query;
use function is_array;
use function json_decode;
use function json_encode;
use function strpos;
use function time;
use function urlencode;
/**
 * Functions for displaying user preferences pages
 */
class UserPreferences
{
    /** @var Relation */
    private $relation;
    /** @var Template */
    public $template;
    public function __construct()
    {
        global $dbi;
        $this->relation = new Relation($dbi);
        $this->template = new Template();
    }
    /**
     * Common initialization for user preferences modification pages
     *
     * @param ConfigFile $cf Config file instance
     *
     * @return void
     */
    public function pageInit(ConfigFile $cf)
    {
        $forms_all_keys = UserFormList::getFields();
        $cf->resetConfigData();
        // start with a clean instance
        $cf->setAllowedKeys($forms_all_keys);
        $cf->setCfgUpdateReadMapping(['Server/hide_db' => 'Servers/1/hide_db', 'Server/only_db' => 'Servers/1/only_db']);
        $cf->updateWithGlobalConfig($GLOBALS['cfg']);
    }
    /**
     * Loads user preferences
     *
     * Returns an array:
     * * config_data - path => value pairs
     * * mtime - last modification time
     * * type - 'db' (config read from pmadb) or 'session' (read from user session)
     *
     * @return array
     */
    public function load()
    {
        global $dbi;
        $cfgRelation = $this->relation->getRelationsParam();
        if (!$cfgRelation['userconfigwork']) {
            // no pmadb table, use session storage
            if (!isset($_SESSION['userconfig'])) {
                $_SESSION['userconfig'] = ['db' => [], 'ts' => time()];
            }
            return ['config_data' => $_SESSION['userconfig']['db'], 'mtime' => $_SESSION['userconfig']['ts'], 'type' => 'session'];
        }
        // load configuration from pmadb
        $query_table = Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['userconfig']);
        $query = 'SELECT `config_data`, UNIX_TIMESTAMP(`timevalue`) ts' . ' FROM ' . $query_table . ' WHERE `username` = \'' . $dbi->escapeString($cfgRelation['user']) . '\'';
        $row = $dbi->fetchSingleRow($query, 'ASSOC', DatabaseInterface::CONNECT_CONTROL);
        return ['config_data' => $row ? json_decode($row['config_data'], true) : [], 'mtime' => $row ? $row['ts'] : time(), 'type' => 'db'];
    }
    /**
     * Saves user preferences
     *
     * @param array $config_array configuration array
     *
     * @return true|Message
     */
    public function save(array $config_array)
    {
        global $dbi;
        $cfgRelation = $this->relation->getRelationsParam();
        $server = $GLOBALS['server'] ?? $GLOBALS['cfg']['ServerDefault'];
        $cache_key = 'server_' . $server;
        if (!$cfgRelation['userconfigwork']) {
            // no pmadb table, use session storage
            $_SESSION['userconfig'] = ['db' => $config_array, 'ts' => time()];
            if (isset($_SESSION['cache'][$cache_key]['userprefs'])) {
                unset($_SESSION['cache'][$cache_key]['userprefs']);
            }
            return true;
        }
        // save configuration to pmadb
        $query_table = Util::backquote($cfgRelation['db']) . '.' . Util::backquote($cfgRelation['userconfig']);
        $query = 'SELECT `username` FROM ' . $query_table . ' WHERE `username` = \'' . $dbi->escapeString($cfgRelation['user']) . '\'';
        $has_config = $dbi->fetchValue($query, 0, 0, DatabaseInterface::CONNECT_CONTROL);
        $config_data = json_encode($config_array);
        if ($has_config) {
            $query = 'UPDATE ' . $query_table . ' SET `timevalue` = NOW(), `config_data` = \'' . $dbi->escapeString($config_data) . '\'' . ' WHERE `username` = \'' . $dbi->escapeString($cfgRelation['user']) . '\'';
        } else {
            $query = 'INSERT INTO ' . $query_table . ' (`username`, `timevalue`,`config_data`) ' . 'VALUES (\'' . $dbi->escapeString($cfgRelation['user']) . '\', NOW(), ' . '\'' . $dbi->escapeString($config_data) . '\')';
        }
        if (isset($_SESSION['cache'][$cache_key]['userprefs'])) {
            unset($_SESSION['cache'][$cache_key]['userprefs']);
        }
        if (!$dbi->tryQuery($query, DatabaseInterface::CONNECT_CONTROL)) {
            $message = Message::error(__('Could not save configuration'));
            $message->addMessage(Message::rawError($dbi->getError(DatabaseInterface::CONNECT_CONTROL)), '<br><br>');
            return $message;
        }
        return true;
    }
    /**
     * Returns a user preferences array filtered by $cfg['UserprefsDisallow']
     * (exclude list) and keys from user preferences form (allow list)
     *
     * @param array $config_data path => value pairs
     *
     * @return array
     */
    public function apply(array $config_data)
    {
        $cfg = [];
        $excludeList = array_flip($GLOBALS['cfg']['UserprefsDisallow']);
        $allowList = array_flip(UserFormList::getFields());
        // allow some additional fields which are custom handled
        $allowList['ThemeDefault'] = true;
        $allowList['lang'] = true;
        $allowList['Server/hide_db'] = true;
        $allowList['Server/only_db'] = true;
        $allowList['2fa'] = true;
        foreach ($config_data as $path => $value) {
            if (!isset($allowList[$path]) || isset($excludeList[$path])) {
                continue;
            }
            Core::arrayWrite($path, $cfg, $value);
        }
        return $cfg;
    }
    /**
     * Updates one user preferences option (loads and saves to database).
     *
     * No validation is done!
     *
     * @param string $path          configuration
     * @param mixed  $value         value
     * @param mixed  $default_value default value
     *
     * @return true|Message
     */
    public function persistOption($path, $value, $default_value)
    {
        $prefs = $this->load();
        if ($value === $default_value) {
            if (!isset($prefs['config_data'][$path])) {
                return true;
            }
            unset($prefs['config_data'][$path]);
        } else {
            $prefs['config_data'][$path] = $value;
        }
        return $this->save($prefs['config_data']);
    }
    /**
     * Redirects after saving new user preferences
     *
     * @param string     $file_name Filename
     * @param array|null $params    URL parameters
     * @param string     $hash      Hash value
     *
     * @return void
     */
    public function redirect($file_name, $params = null, $hash = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("redirect") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/UserPreferences.php at line 180")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called redirect:180@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/UserPreferences.php');
        die();
    }
    /**
     * Shows form which allows to quickly load
     * settings stored in browser's local storage
     *
     * @return string
     */
    public function autoloadGetHeader()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("autoloadGetHeader") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/UserPreferences.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called autoloadGetHeader:197@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/UserPreferences.php');
        die();
    }
}