<?php

/**
 * Form validation for configuration editor
 */
declare (strict_types=1);
namespace PhpMyAdmin\Config;

use PhpMyAdmin\Core;
use PhpMyAdmin\Util;
use function mysqli_report;
use const FILTER_FLAG_IPV4;
use const FILTER_FLAG_IPV6;
use const FILTER_VALIDATE_IP;
use const MYSQLI_REPORT_OFF;
use const PHP_INT_MAX;
use function array_map;
use function array_merge;
use function array_shift;
use function call_user_func_array;
use function count;
use function error_clear_last;
use function error_get_last;
use function explode;
use function filter_var;
use function htmlspecialchars;
use function intval;
use function is_array;
use function is_object;
use function mb_strpos;
use function mb_substr;
use function mysqli_close;
use function mysqli_connect;
use function preg_match;
use function preg_replace;
use function sprintf;
use function str_replace;
use function trim;
/**
 * Validation class for various validation functions
 *
 * Validation function takes two argument: id for which it is called
 * and array of fields' values (usually values for entire formset).
 * The function must always return an array with an error (or error array)
 * assigned to a form element (formset name or field path). Even if there are
 * no errors, key must be set with an empty value.
 *
 * Validation functions are assigned in $cfg_db['_validators'] (config.values.php).
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
        $validators = $cf->getDbEntry('_validators', []);
        if ($GLOBALS['PMA_Config']->get('is_setup')) {
            return $validators;
        }
        // not in setup script: load additional validators for user
        // preferences we need original config values not overwritten
        // by user preferences, creating a new PhpMyAdmin\Config instance is a
        // better idea than hacking into its code
        $uvs = $cf->getDbEntry('_userValidators', []);
        foreach ($uvs as $field => $uvList) {
            $uvList = (array) $uvList;
            foreach ($uvList as &$uv) {
                if (!is_array($uv)) {
                    continue;
                }
                for ($i = 1, $nb = count($uv); $i < $nb; $i++) {
                    if (mb_substr($uv[$i], 0, 6) !== 'value:') {
                        continue;
                    }
                    $uv[$i] = Core::arrayRead(mb_substr($uv[$i], 6), $GLOBALS['PMA_Config']->baseSettings);
                }
            }
            $validators[$field] = isset($validators[$field]) ? array_merge((array) $validators[$field], $uvList) : $uvList;
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
     * @param string|array $validatorId  ID of validator(s) to run
     * @param array        $values       Values to validate
     * @param bool         $isPostSource tells whether $values are directly from
     *                                   POST request
     *
     * @return bool|array
     */
    public static function validate(ConfigFile $cf, $validatorId, array &$values, $isPostSource)
    {
        // find validators
        $validatorId = (array) $validatorId;
        $validators = static::getValidators($cf);
        $vids = [];
        foreach ($validatorId as &$vid) {
            $vid = $cf->getCanonicalPath($vid);
            if (!isset($validators[$vid])) {
                continue;
            }
            $vids[] = $vid;
        }
        if (empty($vids)) {
            return false;
        }
        // create argument list with canonical paths and remember path mapping
        $arguments = [];
        $keyMap = [];
        foreach ($values as $k => $v) {
            $k2 = $isPostSource ? str_replace('-', '/', $k) : $k;
            $k2 = mb_strpos($k2, '/') ? $cf->getCanonicalPath($k2) : $k2;
            $keyMap[$k2] = $k;
            $arguments[$k2] = $v;
        }
        // validate
        $result = [];
        foreach ($vids as $vid) {
            // call appropriate validation functions
            foreach ((array) $validators[$vid] as $validator) {
                $vdef = (array) $validator;
                $vname = array_shift($vdef);
                $vname = 'PhpMyAdmin\\Config\\Validator::' . $vname;
                $args = array_merge([$vid, &$arguments], $vdef);
                $r = call_user_func_array($vname, $args);
                // merge results
                if (!is_array($r)) {
                    continue;
                }
                foreach ($r as $key => $errorList) {
                    // skip empty values if $isPostSource is false
                    if (!$isPostSource && empty($errorList)) {
                        continue;
                    }
                    if (!isset($result[$key])) {
                        $result[$key] = [];
                    }
                    $result[$key] = array_merge($result[$key], (array) $errorList);
                }
            }
        }
        // restore original paths
        $newResult = [];
        foreach ($result as $k => $v) {
            $k2 = $keyMap[$k] ?? $k;
            if (is_array($v)) {
                $newResult[$k2] = array_map('htmlspecialchars', $v);
            } else {
                $newResult[$k2] = htmlspecialchars($v);
            }
        }
        return empty($newResult) ? true : $newResult;
    }
    /**
     * Test database connection
     *
     * @param string $host     host name
     * @param string $port     tcp port to use
     * @param string $socket   socket to use
     * @param string $user     username to use
     * @param string $pass     password to use
     * @param string $errorKey key to use in return array
     *
     * @return bool|array
     */
    public static function testDBConnection($host, $port, $socket, $user, $pass = null, $errorKey = 'Server')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("testDBConnection") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php at line 185")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called testDBConnection:185@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php');
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
    public static function validateServer($path, array $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validateServer") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php at line 221")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validateServer:221@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php');
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
    public static function validatePMAStorage($path, array $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validatePMAStorage") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php at line 264")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validatePMAStorage:264@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php');
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
    public static function validateRegex($path, array $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validateRegex") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php at line 296")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validateRegex:296@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php');
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
    public static function validateTrustedProxies($path, array $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validateTrustedProxies") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php at line 322")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validateTrustedProxies:322@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php');
        die();
    }
    /**
     * Tests integer value
     *
     * @param string $path          path to config
     * @param array  $values        config values
     * @param bool   $allowNegative allow negative values
     * @param bool   $allowZero     allow zero
     * @param int    $maxValue      max allowed value
     * @param string $errorString   error message string
     *
     * @return string  empty string if test is successful
     */
    public static function validateNumber($path, array $values, $allowNegative, $allowZero, $maxValue, $errorString)
    {
        if (empty($values[$path])) {
            return '';
        }
        $value = Util::requestString($values[$path]);
        if (intval($value) != $value || !$allowNegative && $value < 0 || !$allowZero && $value == 0 || $value > $maxValue) {
            return $errorString;
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
    public static function validatePortNumber($path, array $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("validatePortNumber") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php at line 387")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called validatePortNumber:387@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Config/Validator.php');
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
    public static function validatePositiveNumber($path, array $values)
    {
        return [$path => static::validateNumber($path, $values, false, false, PHP_INT_MAX, __('Not a positive number!'))];
    }
    /**
     * Validates non-negative number
     *
     * @param string $path   path to config
     * @param array  $values config values
     *
     * @return array
     */
    public static function validateNonNegativeNumber($path, array $values)
    {
        return [$path => static::validateNumber($path, $values, false, true, PHP_INT_MAX, __('Not a non-negative number!'))];
    }
    /**
     * Validates value according to given regular expression
     * Pattern and modifiers must be a valid for PCRE <b>and</b> JavaScript RegExp
     *
     * @param string $path   path to config
     * @param array  $values config values
     * @param string $regex  regular expression to match
     *
     * @return array|string
     */
    public static function validateByRegex($path, array $values, $regex)
    {
        if (!isset($values[$path])) {
            return '';
        }
        $result = preg_match($regex, Util::requestString($values[$path]));
        return [$path => $result ? '' : __('Incorrect value!')];
    }
    /**
     * Validates upper bound for numeric inputs
     *
     * @param string $path     path to config
     * @param array  $values   config values
     * @param int    $maxValue maximal allowed value
     *
     * @return array
     */
    public static function validateUpperBound($path, array $values, $maxValue)
    {
        $result = $values[$path] <= $maxValue;
        return [$path => $result ? '' : sprintf(__('Value must be less than or equal to %s!'), $maxValue)];
    }
}