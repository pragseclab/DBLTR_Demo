<?php

/**
 * Abstract class for the link transformations plugins
 */
declare (strict_types=1);
namespace PhpMyAdmin\Plugins\Transformations\Abs;

use PhpMyAdmin\Plugins\TransformationsPlugin;
use PhpMyAdmin\Sanitize;
use stdClass;
use function htmlspecialchars;
/**
 * Provides common methods for all of the link transformations plugins.
 */
abstract class TextLinkTransformationsPlugin extends TransformationsPlugin
{
    /**
     * Gets the transformation description of the specific plugin
     *
     * @return string
     */
    public static function getInfo()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getInfo") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Plugins/Transformations/Abs/TextLinkTransformationsPlugin.php at line 25")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getInfo:25@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Plugins/Transformations/Abs/TextLinkTransformationsPlugin.php');
        die();
    }
    /**
     * Does the actual work of each specific transformations plugin.
     *
     * @param string        $buffer  text to be transformed
     * @param array         $options transformation options
     * @param stdClass|null $meta    meta information
     *
     * @return string
     */
    public function applyTransformation($buffer, array $options = [], ?stdClass $meta = null)
    {
        $cfg = $GLOBALS['cfg'];
        $options = $this->getOptions($options, $cfg['DefaultTransformations']['TextLink']);
        $url = ($options[0] ?? '') . (isset($options[2]) && $options[2] ? '' : $buffer);
        /* Do not allow javascript links */
        if (!Sanitize::checkLink($url, true, true)) {
            return htmlspecialchars($url);
        }
        return '<a href="' . htmlspecialchars($url) . '" title="' . htmlspecialchars($options[1] ?? '') . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($options[1] ?? $buffer) . '</a>';
    }
    /* ~~~~~~~~~~~~~~~~~~~~ Getters and Setters ~~~~~~~~~~~~~~~~~~~~ */
    /**
     * Gets the transformation name of the specific plugin
     *
     * @return string
     */
    public static function getName()
    {
        return 'TextLink';
    }
}