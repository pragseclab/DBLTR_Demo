<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Form validation for configuration editor
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries\config;

use PMA\libraries\DatabaseInterface;
use PMA\libraries\Util;
/**
 * Validation class for various validation functions
 *
 * Validation function takes two argument: id for which it is called
 * and array of fields' values (usually values for entire formset, as defined
 * in forms.inc.php).
 * The function must always return an array with an error (or error array)
 * assigned to a form element (formset name or field path). Even if there are
 * no errors, key must be set with an empty value.
 *
 * Validation functions are assigned in $cfg_db['_validators'] (config.values.php).
 *
 * @package PhpMyAdmin
 */
class Validator
{
    /**
     * Returns validator list
     *
     * @param ConfigFile $cf Config file instance
     *
     * @return array
     */
    public static function getValidators(ConfigFile $cf)
    {
        static $validators = null;
        if ($validators !== null) {
            return $validators;
        }
        $validators = $cf->getDbEntry('_validators', array());
        if (defined('PMA_SETUP')) {
            return $validators;
        }
        // not in setup script: load additional validators for user
        // preferences we need original config values not overwritten
        // by user preferences, creating a new PMA\libraries\Config instance is a
        // better idea than hacking into its code
        $uvs = $cf->getDbEntry('_userValidators', array());
        foreach ($uvs as $field => $uv_list) {
            $uv_list = (array) $uv_list;
            foreach ($uv_list as &$uv) {
                if (!is_array($uv)) {
                    continue;
                }
                for ($i = 1, $nb = count($uv); $i < $nb; $i++) {
                    if (mb_substr($uv[$i], 0, 6) == 'value:') {
                        $uv[$i] = PMA_arrayRead(mb_substr($uv[$i], 6), $GLOBALS['PMA_Config']->base_settings);
                    }
                }
            }
            $validators[$field] = isset($validators[$field]) ? array_merge((array) $validators[$field], $uv_list) : $uv_list;
        }
        return $validators;
    }
    /**
     * Runs validation $validator_id on values $values and returns error list.
     *
     * Return values:
     * o array, keys - field path or formset id, values - array of errors
     *   when $isPostSource is true values is an empty array to allow for error list
     *   cleanup in HTML document
     * o false - when no validators match name(s) given by $validator_id
     *
     * @param ConfigFile   $cf           Config file instance
     * @param string|array $validator_id ID of validator(s) to run
     * @param array        &$values      Values to validate
     * @param bool         $isPostSource tells whether $values are directly from
     *                                   POST request
     *
     * @return bool|array
     */
    public static function validate(ConfigFile $cf, $validator_id, &$values, $isPostSource)
    {
        // find validators
        $validator_id = (array) $validator_id;
        $validators = static::getValidators($cf);
        $vids = array();
        foreach ($validator_id as &$vid) {
            $vid = $cf->getCanonicalPath($vid);
            if (isset($validators[$vid])) {
                $vids[] = $vid;
            }
        }
        if (empty($vids)) {
            return false;
        }
        // create argument list with canonical paths and remember path mapping
        $arguments = array();
        $key_map = array();
        foreach ($values as $k => $v) {
            $k2 = $isPostSource ? str_replace('-', '/', $k) : $k;
            $k2 = mb_strpos($k2, '/') ? $cf->getCanonicalPath($k2) : $k2;
            $key_map[$k2] = $k;
            $arguments[$k2] = $v;
        }
        // validate
        $result = array();
        foreach ($vids as $vid) {
            // call appropriate validation functions
            foreach ((array) $validators[$vid] as $validator) {
                $vdef = (array) $validator;
                $vname = array_shift($vdef);
                $vname = 'PMA\\libraries\\config\\Validator::' . $vname;
                $args = array_merge(array($vid, &$arguments), $vdef);
                $r = call_user_func_array($vname, $args);
                // merge results
                if (!is_array($r)) {
                    continue;
                }
                foreach ($r as $key => $error_list) {
                    // skip empty values if $isPostSource is false
                    if (!$isPostSource && empty($error_list)) {
                        continue;
                    }
                    if (!isset($result[$key])) {
                        $result[$key] = array();
                    }
                    $result[$key] = array_merge($result[$key], (array) $error_list);
                }
            }
        }
        // restore original paths
        $new_result = array();
        foreach ($result as $k => $v) {
            $k2 = isset($key_map[$k]) ? $key_map[$k] : $k;
            $new_result[$k2] = $v;
        }
        return empty($new_result) ? true : $new_result;
    }
    /**
     * Test database connection
     *
     * @param string $host         host name
     * @param string $port         tcp port to use
     * @param string $socket       socket to use
     * @param string $user         username to use
     * @param string $pass         password to use
     * @param string $error_key    key to use in return array
     *
     * @return bool|array
     */
    public static function testDBConnection($host, $port, $socket, $user, $pass = null, $error_key = 'Server')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("testDBConnection") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php at line 183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called testDBConnection:183@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php');
        die();
    }
    /**
     * Validate server config
     *
     * @param string $path   path to config, not used
     *                       keep this parameter since the method is invoked using
     *                       reflection along with other similar methods
     * @param array  $values config values
     *
     * @return array
     */
    public static function validateServer($path, $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validateServer") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php at line 230")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validateServer:230@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php');
        die();
    }
    /**
     * Validate pmadb config
     *
     * @param string $path   path to config, not used
     *                       keep this parameter since the method is invoked using
     *                       reflection along with other similar methods
     * @param array  $values config values
     *
     * @return array
     */
    public static function validatePMAStorage($path, $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validatePMAStorage") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php at line 302")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validatePMAStorage:302@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php');
        die();
    }
    /**
     * Validates regular expression
     *
     * @param string $path   path to config
     * @param array  $values config values
     *
     * @return array
     */
    public static function validateRegex($path, $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validateRegex") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php at line 355")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validateRegex:355@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php');
        die();
    }
    /**
     * Validates TrustedProxies field
     *
     * @param string $path   path to config
     * @param array  $values config values
     *
     * @return array
     */
    public static function validateTrustedProxies($path, $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validateTrustedProxies") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php at line 397")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validateTrustedProxies:397@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php');
        die();
    }
    /**
     * Tests integer value
     *
     * @param string $path         path to config
     * @param array  $values       config values
     * @param bool   $allow_neg    allow negative values
     * @param bool   $allow_zero   allow zero
     * @param int    $max_value    max allowed value
     * @param string $error_string error message key:
     *                             $GLOBALS["strConfig$error_lang_key"]
     *
     * @return string  empty string if test is successful
     */
    public static function validateNumber($path, $values, $allow_neg, $allow_zero, $max_value, $error_string)
    {
        if (empty($values[$path])) {
            return '';
        }
        $value = Util::requestString($values[$path]);
        if (intval($value) != $value || !$allow_neg && $value < 0 || !$allow_zero && $value == 0 || $value > $max_value) {
            return $error_string;
        }
        return '';
    }
    /**
     * Validates port number
     *
     * @param string $path   path to config
     * @param array  $values config values
     *
     * @return array
     */
    public static function validatePortNumber($path, $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validatePortNumber") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php at line 486")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validatePortNumber:486@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php');
        die();
    }
    /**
     * Validates positive number
     *
     * @param string $path   path to config
     * @param array  $values config values
     *
     * @return array
     */
    public static function validatePositiveNumber($path, $values)
    {
        return array($path => static::validateNumber($path, $values, false, false, PHP_INT_MAX, __('Not a positive number!')));
    }
    /**
     * Validates non-negative number
     *
     * @param string $path   path to config
     * @param array  $values config values
     *
     * @return array
     */
    public static function validateNonNegativeNumber($path, $values)
    {
        return array($path => static::validateNumber($path, $values, false, true, PHP_INT_MAX, __('Not a non-negative number!')));
    }
    /**
     * Validates value according to given regular expression
     * Pattern and modifiers must be a valid for PCRE <b>and</b> JavaScript RegExp
     *
     * @param string $path   path to config
     * @param array  $values config values
     * @param string $regex  regular expression to match
     *
     * @return array
     */
    public static function validateByRegex($path, $values, $regex)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validateByRegex") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php at line 554")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validateByRegex:554@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/config/Validator.php');
        die();
    }
    /**
     * Validates upper bound for numeric inputs
     *
     * @param string $path      path to config
     * @param array  $values    config values
     * @param int    $max_value maximal allowed value
     *
     * @return array
     */
    public static function validateUpperBound($path, $values, $max_value)
    {
        $result = $values[$path] <= $max_value;
        return array($path => $result ? '' : sprintf(__('Value must be equal or lower than %s!'), $max_value));
    }
}