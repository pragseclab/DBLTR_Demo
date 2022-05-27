<?php

/**
 * ESRI Shape file import plugin for phpMyAdmin
 */
declare (strict_types=1);
namespace PhpMyAdmin\Plugins\Import;

use PhpMyAdmin\File;
use PhpMyAdmin\Gis\GisFactory;
use PhpMyAdmin\Gis\GisMultiLineString;
use PhpMyAdmin\Gis\GisMultiPoint;
use PhpMyAdmin\Gis\GisPoint;
use PhpMyAdmin\Gis\GisPolygon;
use PhpMyAdmin\Import;
use PhpMyAdmin\Message;
use PhpMyAdmin\Plugins\ImportPlugin;
use PhpMyAdmin\Properties\Plugins\ImportPluginProperties;
use PhpMyAdmin\Sanitize;
use PhpMyAdmin\ZipExtension;
use ZipArchive;
use const LOCK_EX;
use function count;
use function extension_loaded;
use function file_exists;
use function file_put_contents;
use function mb_strlen;
use function mb_substr;
use function pathinfo;
use function strcmp;
use function strlen;
use function substr;
use function trim;
use function unlink;
/**
 * Handles the import for ESRI Shape files
 */
class ImportShp extends ImportPlugin
{
    /** @var ZipExtension */
    private $zipExtension;
    public function __construct()
    {
        parent::__construct();
        $this->setProperties();
        if (!extension_loaded('zip')) {
            return;
        }
        $this->zipExtension = new ZipExtension(new ZipArchive());
    }
    /**
     * Sets the import plugin properties.
     * Called in the constructor.
     *
     * @return void
     */
    protected function setProperties()
    {
        $importPluginProperties = new ImportPluginProperties();
        $importPluginProperties->setText(__('ESRI Shape File'));
        $importPluginProperties->setExtension('shp');
        $importPluginProperties->setOptions([]);
        $importPluginProperties->setOptionsText(__('Options'));
        $this->properties = $importPluginProperties;
    }
    /**
     * Handles the whole import logic
     *
     * @param array $sql_data 2-element array with sql data
     *
     * @return void
     */
    public function doImport(?File $importHandle = null, array &$sql_data = [])
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("doImport") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Plugins/Import/ImportShp.php at line 75")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called doImport:75@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Plugins/Import/ImportShp.php');
        die();
    }
    /**
     * Returns specified number of bytes from the buffer.
     * Buffer automatically fetches next chunk of data when the buffer
     * falls short.
     * Sets $eof when $GLOBALS['finished'] is set and the buffer falls short.
     *
     * @param int $length number of bytes
     *
     * @return string
     */
    public static function readFromBuffer($length)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("readFromBuffer") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Plugins/Import/ImportShp.php at line 256")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called readFromBuffer:256@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Plugins/Import/ImportShp.php');
        die();
    }
}