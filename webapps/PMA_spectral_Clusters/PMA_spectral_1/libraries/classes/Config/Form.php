<?php

/**
 * Form handling code.
 */
declare (strict_types=1);
namespace PhpMyAdmin\Config;

use const E_USER_ERROR;
use function array_combine;
use function array_shift;
use function array_walk;
use function count;
use function gettype;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function ltrim;
use function mb_strpos;
use function mb_strrpos;
use function mb_substr;
use function str_replace;
use function trigger_error;
/**
 * Base class for forms, loads default configuration options, checks allowed
 * values etc.
 */
class Form
{
    /**
     * Form name
     *
     * @var string
     */
    public $name;
    /**
     * Arbitrary index, doesn't affect class' behavior
     *
     * @var int
     */
    public $index;
    /**
     * Form fields (paths), filled by {@link readFormPaths()}, indexed by field name
     *
     * @var array
     */
    public $fields;
    /**
     * Stores default values for some fields (eg. pmadb tables)
     *
     * @var array
     */
    public $default;
    /**
     * Caches field types, indexed by field names
     *
     * @var array
     */
    private $fieldsTypes;
    /**
     * ConfigFile instance
     *
     * @var ConfigFile
     */
    private $configFile;
    /**
     * A counter for the number of groups
     *
     * @var int
     */
    private static $groupCounter = 0;
    /**
     * Reads default config values
     *
     * @param string     $formName Form name
     * @param array      $form     Form data
     * @param ConfigFile $cf       Config file instance
     * @param int        $index    arbitrary index, stored in Form::$index
     */
    public function __construct($formName, array $form, ConfigFile $cf, $index = null)
    {
        $this->index = $index;
        $this->configFile = $cf;
        $this->loadForm($formName, $form);
    }
    /**
     * Returns type of given option
     *
     * @param string $optionName path or field name
     *
     * @return string|null one of: boolean, integer, double, string, select, array
     */
    public function getOptionType($optionName)
    {
        $key = ltrim(mb_substr($optionName, (int) mb_strrpos($optionName, '/')), '/');
        return $this->fieldsTypes[$key] ?? null;
    }
    /**
     * Returns allowed values for select fields
     *
     * @param string $optionPath Option path
     *
     * @return array
     */
    public function getOptionValueList($optionPath)
    {
        $value = $this->configFile->getDbEntry($optionPath);
        if ($value === null) {
            trigger_error($optionPath . ' - select options not defined', E_USER_ERROR);
            return [];
        }
        if (!is_array($value)) {
            trigger_error($optionPath . ' - not a static value list', E_USER_ERROR);
            return [];
        }
        // convert array('#', 'a', 'b') to array('a', 'b')
        if (isset($value[0]) && $value[0] === '#') {
            // remove first element ('#')
            array_shift($value);
            // $value has keys and value names, return it
            return $value;
        }
        // convert value list array('a', 'b') to array('a' => 'a', 'b' => 'b')
        $hasStringKeys = false;
        $keys = [];
        for ($i = 0, $nb = count($value); $i < $nb; $i++) {
            if (!isset($value[$i])) {
                $hasStringKeys = true;
                break;
            }
            $keys[] = is_bool($value[$i]) ? (int) $value[$i] : $value[$i];
        }
        if (!$hasStringKeys) {
            $value = array_combine($keys, $value);
        }
        // $value has keys and value names, return it
        return $value;
    }
    /**
     * array_walk callback function, reads path of form fields from
     * array (see docs for \PhpMyAdmin\Config\Forms\BaseForm::getForms)
     *
     * @param mixed $value  Value
     * @param mixed $key    Key
     * @param mixed $prefix Prefix
     *
     * @return void
     */
    private function readFormPathsCallback($value, $key, $prefix)
    {
        if (is_array($value)) {
            $prefix .= $key . '/';
            array_walk($value, function ($value, $key, $prefix) {
                $this->readFormPathsCallback($value, $key, $prefix);
            }, $prefix);
            return;
        }
        if (!is_int($key)) {
            $this->default[$prefix . $key] = $value;
            $value = $key;
        }
        // add unique id to group ends
        if ($value === ':group:end') {
            $value .= ':' . self::$groupCounter++;
        }
        $this->fields[] = $prefix . $value;
    }
    /**
     * Reset the group counter, function for testing purposes
     */
    public static function resetGroupCounter() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("resetGroupCounter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Config/Form.php at line 174")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called resetGroupCounter:174@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Config/Form.php');
        die();
    }
    /**
     * Reads form paths to {@link $fields}
     *
     * @param array $form Form
     *
     * @return void
     */
    protected function readFormPaths(array $form)
    {
        // flatten form fields' paths and save them to $fields
        $this->fields = [];
        array_walk($form, function ($value, $key, $prefix) {
            $this->readFormPathsCallback($value, $key, $prefix);
        }, '');
        // $this->fields is an array of the form: [0..n] => 'field path'
        // change numeric indexes to contain field names (last part of the path)
        $paths = $this->fields;
        $this->fields = [];
        foreach ($paths as $path) {
            $key = ltrim(mb_substr($path, (int) mb_strrpos($path, '/')), '/');
            $this->fields[$key] = $path;
        }
        // now $this->fields is an array of the form: 'field name' => 'field path'
    }
    /**
     * Reads fields' types to $this->fieldsTypes
     *
     * @return void
     */
    protected function readTypes()
    {
        $cf = $this->configFile;
        foreach ($this->fields as $name => $path) {
            if (mb_strpos((string) $name, ':group:') === 0) {
                $this->fieldsTypes[$name] = 'group';
                continue;
            }
            $v = $cf->getDbEntry($path);
            if ($v !== null) {
                $type = is_array($v) ? 'select' : $v;
            } else {
                $type = gettype($cf->getDefault($path));
            }
            $this->fieldsTypes[$name] = $type;
        }
    }
    /**
     * Remove slashes from group names
     *
     * @see issue #15836
     *
     * @param array $form The form data
     *
     * @return array
     */
    protected function cleanGroupPaths(array $form) : array
    {
        foreach ($form as &$name) {
            if (!is_string($name)) {
                continue;
            }
            if (mb_strpos($name, ':group:') !== 0) {
                continue;
            }
            $name = str_replace('/', '-', $name);
        }
        return $form;
    }
    /**
     * Reads form settings and prepares class to work with given subset of
     * config file
     *
     * @param string $formName Form name
     * @param array  $form     Form
     *
     * @return void
     */
    public function loadForm($formName, array $form)
    {
        $this->name = $formName;
        $form = $this->cleanGroupPaths($form);
        $this->readFormPaths($form);
        $this->readTypes();
    }
}