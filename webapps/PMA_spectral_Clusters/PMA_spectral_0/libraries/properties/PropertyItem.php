<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * The top-level class of the object-oriented properties system.
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries\properties;

/**
 * Provides an interface for Property classes
 *
 * @package PhpMyAdmin
 */
abstract class PropertyItem
{
    /**
     * Returns the property type ( either "Options", or "Plugin" ).
     *
     * @return string
     */
    public abstract function getPropertyType();
    /**
     * Returns the property item type of either an instance of
     *  - PMA\libraries\properties\options\OptionsPropertyOneItem ( f.e. "bool", "text", "radio", etc ) or
     *  - PMA\libraries\properties\options\OptionsPropertyGroup   ( "root", "main" or "subgroup" )
     *  - PMA\libraries\properties\plugins\PluginPropertyItem     ( "export", "import", "transformations" )
     *
     * @return string
     */
    public abstract function getItemType();
    /**
     * Only overwritten in the PMA\libraries\properties\options\OptionsPropertyGroup class:
     * Used to tell whether we can use the current item as a group by calling
     * the addProperty() or removeProperty() methods, which are not available
     * for simple PMA\libraries\properties\options\OptionsPropertyOneItem subclasses.
     *
     * @return string
     */
    public function getGroup()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getGroup") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/properties/PropertyItem.php at line 44")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getGroup:44@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/properties/PropertyItem.php');
        die();
    }
}