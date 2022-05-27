<?php

declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Table;

use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\DbTableExists;
use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Index;
use PhpMyAdmin\Message;
use PhpMyAdmin\Query\Compatibility;
use PhpMyAdmin\Query\Generator as QueryGenerator;
use PhpMyAdmin\Response;
use PhpMyAdmin\Template;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use function count;
use function is_array;
use function json_decode;
/**
 * Displays index edit/creation form and handles it.
 */
class IndexesController extends AbstractController
{
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param Response          $response
     * @param string            $db       Database name.
     * @param string            $table    Table name.
     * @param DatabaseInterface $dbi
     */
    public function __construct($response, Template $template, $db, $table, $dbi)
    {
        parent::__construct($response, $template, $db, $table);
        $this->dbi = $dbi;
    }
    public function index() : void
    {
        global $db, $table, $url_params, $cfg, $err_url;
        if (!isset($_POST['create_edit_table'])) {
            Util::checkParameters(['db', 'table']);
            $url_params = ['db' => $db, 'table' => $table];
            $err_url = Util::getScriptNameForOption($cfg['DefaultTabTable'], 'table');
            $err_url .= Url::getCommon($url_params, '&');
            DbTableExists::check();
        }
        if (isset($_POST['index'])) {
            if (is_array($_POST['index'])) {
                // coming already from form
                $index = new Index($_POST['index']);
            } else {
                $index = $this->dbi->getTable($this->db, $this->table)->getIndex($_POST['index']);
            }
        } else {
            $index = new Index();
        }
        if (isset($_POST['do_save_data'])) {
            $this->doSaveData($index, false);
            return;
        }
        $this->displayForm($index);
    }
    public function indexRename() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("indexRename") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Controllers/Table/IndexesController.php at line 66")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called indexRename:66@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Controllers/Table/IndexesController.php');
        die();
    }
    /**
     * Display the rename form to rename an index
     *
     * @param Index $index An Index instance.
     */
    public function displayRenameForm(Index $index) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("displayRenameForm") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Controllers/Table/IndexesController.php at line 97")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called displayRenameForm:97@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Controllers/Table/IndexesController.php');
        die();
    }
    /**
     * Display the form to edit/create an index
     *
     * @param Index $index An Index instance.
     */
    public function displayForm(Index $index) : void
    {
        $this->dbi->selectDb($GLOBALS['db']);
        $add_fields = 0;
        if (isset($_POST['index']) && is_array($_POST['index'])) {
            // coming already from form
            if (isset($_POST['index']['columns']['names'])) {
                $add_fields = count($_POST['index']['columns']['names']) - $index->getColumnCount();
            }
            if (isset($_POST['add_fields'])) {
                $add_fields += $_POST['added_fields'];
            }
        } elseif (isset($_POST['create_index'])) {
            $add_fields = $_POST['added_fields'];
        }
        // Get fields and stores their name/type
        if (isset($_POST['create_edit_table'])) {
            $fields = json_decode($_POST['columns'], true);
            $index_params = ['Non_unique' => $_POST['index']['Index_choice'] === 'UNIQUE' ? '0' : '1'];
            $index->set($index_params);
            $add_fields = count($fields);
        } else {
            $fields = $this->dbi->getTable($this->db, $this->table)->getNameAndTypeOfTheColumns();
        }
        $form_params = ['db' => $this->db, 'table' => $this->table];
        if (isset($_POST['create_index'])) {
            $form_params['create_index'] = 1;
        } elseif (isset($_POST['old_index'])) {
            $form_params['old_index'] = $_POST['old_index'];
        } elseif (isset($_POST['index'])) {
            $form_params['old_index'] = $_POST['index'];
        }
        $this->addScriptFiles(['indexes.js']);
        $this->render('table/index_form', ['fields' => $fields, 'index' => $index, 'form_params' => $form_params, 'add_fields' => $add_fields, 'create_edit_table' => isset($_POST['create_edit_table']), 'default_sliders_state' => $GLOBALS['cfg']['InitialSlidersState']]);
    }
    /**
     * Process the data from the edit/create index form,
     * run the query to build the new index
     * and moves back to /table/sql
     *
     * @param Index $index      An Index instance.
     * @param bool  $renameMode Rename the Index mode
     */
    public function doSaveData(Index $index, bool $renameMode) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("doSaveData") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Controllers/Table/IndexesController.php at line 157")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called doSaveData:157@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Controllers/Table/IndexesController.php');
        die();
    }
}