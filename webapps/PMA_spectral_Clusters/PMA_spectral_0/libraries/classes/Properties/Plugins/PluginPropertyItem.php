<?php

/**
 * The top-level class of the "Plugin" subtree of the object-oriented
 * properties system (the other subtree is "Options").
 */
declare (strict_types=1);
namespace PhpMyAdmin\Properties\Plugins;

use PhpMyAdmin\Properties\Options\Groups\OptionsPropertyRootGroup;
use PhpMyAdmin\Properties\PropertyItem;
/**
 * Superclass for
 *  - PhpMyAdmin\Properties\Plugins\ExportPluginProperties,
 *  - PhpMyAdmin\Properties\Plugins\ImportPluginProperties and
 *  - TransformationsPluginProperties
 */
abstract class PluginPropertyItem extends PropertyItem
{
    /**
     * Text
     *
     * @var string
     */
    private $text;
    /**
     * Extension
     *
     * @var string
     */
    private $extension;
    /**
     * Options
     *
     * @var OptionsPropertyRootGroup
     */
    private $options;
    /**
     * Options text
     *
     * @var string
     */
    private $optionsText;
    /**
     * MIME Type
     *
     * @var string
     */
    private $mimeType;
    /* ~~~~~~~~~~~~~~~~~~~~ Getters and Setters ~~~~~~~~~~~~~~~~~~~~ */
    /**
     * Gets the text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * Sets the text
     *
     * @param string $text text
     *
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }
    /**
     * Gets the extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }
    /**
     * Sets the extension
     *
     * @param string $extension extension
     *
     * @return void
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }
    /**
     * Gets the options
     *
     * @return OptionsPropertyRootGroup
     */
    public function getOptions()
    {
        return $this->options;
    }
    /**
     * Sets the options
     *
     * @param OptionsPropertyRootGroup $options options
     *
     * @return void
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
    /**
     * Gets the options text
     *
     * @return string
     */
    public function getOptionsText()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getOptionsText") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Properties/Plugins/PluginPropertyItem.php at line 118")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getOptionsText:118@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Properties/Plugins/PluginPropertyItem.php');
        die();
    }
    /**
     * Sets the options text
     *
     * @param string $optionsText optionsText
     *
     * @return void
     */
    public function setOptionsText($optionsText)
    {
        $this->optionsText = $optionsText;
    }
    /**
     * Gets the MIME type
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }
    /**
     * Sets the MIME type
     *
     * @param string $mimeType MIME type
     *
     * @return void
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }
    /**
     * Returns the property type ( either "options", or "plugin" ).
     *
     * @return string
     */
    public function getPropertyType()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPropertyType") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Properties/Plugins/PluginPropertyItem.php at line 158")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPropertyType:158@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Properties/Plugins/PluginPropertyItem.php');
        die();
    }
}