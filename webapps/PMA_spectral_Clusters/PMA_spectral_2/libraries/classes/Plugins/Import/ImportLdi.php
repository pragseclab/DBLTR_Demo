<?php

/**
 * CSV import plugin for phpMyAdmin using LOAD DATA
 */
declare (strict_types=1);
namespace PhpMyAdmin\Plugins\Import;

use PhpMyAdmin\File;
use PhpMyAdmin\Message;
use PhpMyAdmin\Properties\Options\Items\BoolPropertyItem;
use PhpMyAdmin\Properties\Options\Items\TextPropertyItem;
use PhpMyAdmin\Util;
use const PHP_EOL;
use function count;
use function is_array;
use function preg_split;
use function strlen;
use function trim;
// phpcs:disable PSR1.Files.SideEffects
// We need relations enabled and we work only on database
if (!isset($GLOBALS['plugin_param']) || $GLOBALS['plugin_param'] !== 'table') {
    $GLOBALS['skip_import'] = true;
    return;
}
// phpcs:enable
/**
 * Handles the import for the CSV format using load data
 */
class ImportLdi extends AbstractImportCsv
{
    public function __construct()
    {
        parent::__construct();
        $this->setProperties();
    }
    /**
     * Sets the import plugin properties.
     * Called in the constructor.
     *
     * @return void
     */
    protected function setProperties()
    {
        global $dbi;
        if ($GLOBALS['cfg']['Import']['ldi_local_option'] === 'auto') {
            $GLOBALS['cfg']['Import']['ldi_local_option'] = false;
            $result = $dbi->tryQuery('SELECT @@local_infile;');
            if ($result != false && $dbi->numRows($result) > 0) {
                $tmp = $dbi->fetchRow($result);
                if ($tmp[0] === 'ON') {
                    $GLOBALS['cfg']['Import']['ldi_local_option'] = true;
                }
            }
            $dbi->freeResult($result);
            unset($result);
        }
        $generalOptions = parent::setProperties();
        $this->properties->setText('CSV using LOAD DATA');
        $this->properties->setExtension('ldi');
        $leaf = new TextPropertyItem('columns', __('Column names: '));
        $generalOptions->addProperty($leaf);
        $leaf = new BoolPropertyItem('ignore', __('Do not abort on INSERT error'));
        $generalOptions->addProperty($leaf);
        $leaf = new BoolPropertyItem('local_option', __('Use LOCAL keyword'));
        $generalOptions->addProperty($leaf);
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("doImport") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Plugins/Import/ImportLdi.php at line 77")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called doImport:77@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Plugins/Import/ImportLdi.php');
        die();
    }
}