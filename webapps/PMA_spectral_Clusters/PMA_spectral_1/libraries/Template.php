<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * hold PMA\libraries\Template class
 *
 * @package PMA\libraries
 */
namespace PMA\libraries;

/**
 * Class Template
 *
 * Handle front end templating
 *
 * @package PMA\libraries
 */
class Template
{
    /**
     * Name of the template
     */
    protected $name = null;
    /**
     * Data associated with the template
     */
    protected $data;
    /**
     * Helper functions for the template
     */
    protected $helperFunctions;
    const BASE_PATH = 'templates/';
    /**
     * Template constructor
     *
     * @param string $name            Template name
     * @param array  $data            Variables to be provided to the template
     * @param array  $helperFunctions Helper functions to be used by template
     */
    protected function __construct($name, $data = array(), $helperFunctions = array())
    {
        $this->name = $name;
        $this->data = $data;
        $this->helperFunctions = $helperFunctions;
    }
    /**
     * Template getter
     *
     * @param string $name            Template name
     * @param array  $data            Variables to be provided to the template
     * @param array  $helperFunctions Helper functions to be used by template
     *
     * @return Template
     */
    public static function get($name, $data = array(), $helperFunctions = array())
    {
        return new Template($name, $data, $helperFunctions);
    }
    /**
     * Adds more entries to the data for this template
     *
     * @param array|string $data  containing data array or data key
     * @param string       $value containing data value
     */
    public function set($data, $value = null)
    {
        if (is_array($data) && !$value) {
            $this->data = array_merge($this->data, $data);
        } else {
            if (is_string($data)) {
                $this->data[$data] = $value;
            }
        }
    }
    /**
     * Adds a function for use by the template
     *
     * @param string   $funcName function name
     * @param callable $funcDef  function definition
     */
    public function setHelper($funcName, $funcDef)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setHelper") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Template.php at line 90")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setHelper:90@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Template.php');
        die();
    }
    /**
     * Removes a function
     *
     * @param string $funcName function name
     */
    public function removeHelper($funcName)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("removeHelper") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Template.php at line 106")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called removeHelper:106@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Template.php');
        die();
    }
    /**
     * Magic call to locally inaccessible but associated helper functions
     *
     * @param string $funcName  function name
     * @param array  $arguments function arguments
     */
    public function __call($funcName, $arguments)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__call") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Template.php at line 123")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __call:123@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Template.php');
        die();
    }
    /**
     * Render template
     *
     * @param array $data            Variables to be provided to the template
     * @param array $helperFunctions Helper functions to be used by template
     *
     * @return string
     */
    public function render($data = array(), $helperFunctions = array())
    {
        $template = static::BASE_PATH . $this->name . '.phtml';
        try {
            $this->set($data);
            $this->helperFunctions = array_merge($this->helperFunctions, $helperFunctions);
            extract($this->data);
            ob_start();
            if (file_exists($template)) {
                include $template;
            } else {
                throw new \LogicException('The template "' . $template . '" not found.');
            }
            $content = ob_get_clean();
            return $content;
        } catch (\LogicException $e) {
            ob_end_clean();
            throw new \LogicException($e->getMessage());
        }
    }
}