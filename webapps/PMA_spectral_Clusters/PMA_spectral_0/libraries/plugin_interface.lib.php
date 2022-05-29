<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Generic plugin interface.
 *
 * @package PhpMyAdmin
 */
use PMA\libraries\properties\options\groups\OptionsPropertySubgroup;
use PMA\libraries\properties\options\OptionsPropertyItem;
use PMA\libraries\properties\plugins\ExportPluginProperties;
use PMA\libraries\properties\plugins\PluginPropertyItem;
use PMA\libraries\properties\plugins\SchemaPluginProperties;
/**
 * Includes and instantiates the specified plugin type for a certain format
 *
 * @param string $plugin_type   the type of the plugin (import, export, etc)
 * @param string $plugin_format the format of the plugin (sql, xml, et )
 * @param string $plugins_dir   directory with plugins
 * @param mixed  $plugin_param  parameter to plugin by which they can
 *                              decide whether they can work
 *
 * @return object|null new plugin instance
 */
function PMA_getPlugin($plugin_type, $plugin_format, $plugins_dir, $plugin_param = false)
{
    $GLOBALS['plugin_param'] = $plugin_param;
    $class_name = mb_strtoupper($plugin_type[0]) . mb_strtolower(mb_substr($plugin_type, 1)) . mb_strtoupper($plugin_format[0]) . mb_strtolower(mb_substr($plugin_format, 1));
    $file = $class_name . ".php";
    if (is_file($plugins_dir . $file)) {
        //include_once $plugins_dir . $file;
        $fqnClass = 'PMA\\' . str_replace('/', '\\', $plugins_dir) . $class_name;
        // check if class exists, could be caused by skip_import
        if (class_exists($fqnClass)) {
            return new $fqnClass();
        }
    }
    return null;
}
/**
 * Reads all plugin information from directory $plugins_dir
 *
 * @param string $plugin_type  the type of the plugin (import, export, etc)
 * @param string $plugins_dir  directory with plugins
 * @param mixed  $plugin_param parameter to plugin by which they can
 *                             decide whether they can work
 *
 * @return array list of plugin instances
 */
function PMA_getPlugins($plugin_type, $plugins_dir, $plugin_param)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getPlugins") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php at line 61")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getPlugins:61@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php');
    die();
}
/**
 * Returns locale string for $name or $name if no locale is found
 *
 * @param string $name for local string
 *
 * @return string  locale string for $name
 */
function PMA_getString($name)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getString") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php at line 111")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getString:111@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php');
    die();
}
/**
 * Returns html input tag option 'checked' if plugin $opt
 * should be set by config or request
 *
 * @param string $section name of config section in
 *                        $GLOBALS['cfg'][$section] for plugin
 * @param string $opt     name of option
 *
 * @return string  html input tag option 'checked'
 */
function PMA_pluginCheckboxCheck($section, $opt)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_pluginCheckboxCheck") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php at line 127")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_pluginCheckboxCheck:127@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php');
    die();
}
/**
 * Returns default value for option $opt
 *
 * @param string $section name of config section in
 *                        $GLOBALS['cfg'][$section] for plugin
 * @param string $opt     name of option
 *
 * @return string  default value for option $opt
 */
function PMA_pluginGetDefault($section, $opt)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_pluginGetDefault") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php at line 148")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_pluginGetDefault:148@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php');
    die();
}
/**
 * Returns html select form element for plugin choice
 * and hidden fields denoting whether each plugin must be exported as a file
 *
 * @param string $section name of config section in
 *                        $GLOBALS['cfg'][$section] for plugin
 * @param string $name    name of select element
 * @param array  &$list   array with plugin instances
 * @param string $cfgname name of config value, if none same as $name
 *
 * @return string  html select tag
 */
function PMA_pluginGetChoice($section, $name, &$list, $cfgname = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_pluginGetChoice") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php at line 197")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_pluginGetChoice:197@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php');
    die();
}
/**
 * Returns single option in a list element
 *
 * @param string                                       $section        name of
 *                                                                     config
 *                                                                     section in
 *                                                                     $GLOBALS['cfg'][$section]
 *                                                                     for plugin
 * @param string                                       $plugin_name    unique plugin
 *                                                                     name
 * @param array|\PMA\libraries\properties\PropertyItem &$propertyGroup options
 *                                                                     property main
 *                                                                     group
 *                                                                     instance
 * @param boolean                                      $is_subgroup    if this group
 *                                                                     is a subgroup
 *
 * @return string  table row with option
 */
function PMA_pluginGetOneOption($section, $plugin_name, &$propertyGroup, $is_subgroup = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_pluginGetOneOption") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php at line 277")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_pluginGetOneOption:277@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php');
    die();
}
/**
 * Get HTML for properties items
 *
 * @param string              $section      name of config section in
 *                                          $GLOBALS['cfg'][$section] for plugin
 * @param string              $plugin_name  unique plugin name
 * @param OptionsPropertyItem $propertyItem Property item
 *
 * @return string
 */
function PMA_getHtmlForProperty($section, $plugin_name, $propertyItem)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForProperty") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php at line 403")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForProperty:403@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php');
    die();
}
/**
 * Returns html div with editable options for plugin
 *
 * @param string $section name of config section in $GLOBALS['cfg'][$section]
 * @param array  &$list   array with plugin instances
 *
 * @return string  html fieldset with plugin options
 */
function PMA_pluginGetOptions($section, &$list)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_pluginGetOptions") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php at line 527")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_pluginGetOptions:527@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/plugin_interface.lib.php');
    die();
}