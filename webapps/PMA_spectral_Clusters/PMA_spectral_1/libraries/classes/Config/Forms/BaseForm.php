<?php

/**
 * Base class for preferences.
 */
declare (strict_types=1);
namespace PhpMyAdmin\Config\Forms;

use PhpMyAdmin\Config\ConfigFile;
use PhpMyAdmin\Config\FormDisplay;
use function is_int;
/**
 * Base form for user preferences
 */
abstract class BaseForm extends FormDisplay
{
    /**
     * @param ConfigFile $cf       Config file instance
     * @param int|null   $serverId 0 if new server, validation; >= 1 if editing a server
     */
    public function __construct(ConfigFile $cf, $serverId = null)
    {
        parent::__construct($cf);
        foreach (static::getForms() as $formName => $form) {
            $this->registerForm($formName, $form, $serverId);
        }
    }
    /**
     * List of available forms, each form is described as an array of fields to display.
     * Fields MUST have their counterparts in the $cfg array.
     *
     * To define form field, use the notation below:
     * $forms['Form group']['Form name'] = array('Option/path');
     *
     * You can assign default values set by special button ("set value: ..."), eg.:
     * 'Servers/1/pmadb' => 'phpmyadmin'
     *
     * To group options, use:
     * ':group:' . __('group name') // just define a group
     * or
     * 'option' => ':group' // group starting from this option
     * End group blocks with:
     * ':group:end'
     *
     * @return array
     *
     * @todo This should be abstract, but that does not work in PHP 5
     */
    public static function getForms()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getForms") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Config/Forms/BaseForm.php at line 51")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getForms:51@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Config/Forms/BaseForm.php');
        die();
    }
    /**
     * Returns list of fields used in the form.
     *
     * @return string[]
     */
    public static function getFields()
    {
        $names = [];
        foreach (static::getForms() as $form) {
            foreach ($form as $k => $v) {
                $names[] = is_int($k) ? $v : $k;
            }
        }
        return $names;
    }
    /**
     * Returns name of the form
     *
     * @return string
     *
     * @todo This should be abstract, but that does not work in PHP 5
     */
    public static function getName()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Config/Forms/BaseForm.php at line 77")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getName:77@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Config/Forms/BaseForm.php');
        die();
    }
}