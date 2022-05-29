<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds the PMA\TableIndexesController
 *
 * @package PMA
 */
namespace PMA\libraries\controllers\table;

use PMA\libraries\controllers\TableController;
use PMA\libraries\Index;
use PMA\libraries\Message;
use PMA\libraries\Template;
use PMA\libraries\Util;
use PMA\libraries\Response;
/**
 * Class TableIndexesController
 *
 * @package PMA\libraries\controllers\table
 */
class TableIndexesController extends TableController
{
    /**
     * @var Index $index
     */
    protected $index;
    /**
     * Constructor
     *
     * @param Index $index Index
     */
    public function __construct($index)
    {
        parent::__construct();
        $this->index = $index;
    }
    /**
     * Index
     *
     * @return void
     */
    public function indexAction()
    {
        if (isset($_REQUEST['do_save_data'])) {
            $this->doSaveDataAction();
            return;
        }
        // end builds the new index
        $this->displayFormAction();
    }
    /**
     * Display the form to edit/create an index
     *
     * @return void
     */
    public function displayFormAction()
    {
        include_once 'libraries/tbl_info.inc.php';
        $add_fields = 0;
        if (isset($_REQUEST['index']) && is_array($_REQUEST['index'])) {
            // coming already from form
            if (isset($_REQUEST['index']['columns']['names'])) {
                $add_fields = count($_REQUEST['index']['columns']['names']) - $this->index->getColumnCount();
            }
            if (isset($_REQUEST['add_fields'])) {
                $add_fields += $_REQUEST['added_fields'];
            }
        } elseif (isset($_REQUEST['create_index'])) {
            $add_fields = $_REQUEST['added_fields'];
        }
        // end preparing form values
        // Get fields and stores their name/type
        if (isset($_REQUEST['create_edit_table'])) {
            $fields = json_decode($_REQUEST['columns'], true);
            $index_params = array('Non_unique' => $_REQUEST['index']['Index_choice'] == 'UNIQUE' ? '0' : '1');
            $this->index->set($index_params);
            $add_fields = count($fields);
        } else {
            $fields = $this->dbi->getTable($this->db, $this->table)->getNameAndTypeOfTheColumns();
        }
        $form_params = array('db' => $this->db, 'table' => $this->table);
        if (isset($_REQUEST['create_index'])) {
            $form_params['create_index'] = 1;
        } elseif (isset($_REQUEST['old_index'])) {
            $form_params['old_index'] = $_REQUEST['old_index'];
        } elseif (isset($_REQUEST['index'])) {
            $form_params['old_index'] = $_REQUEST['index'];
        }
        $this->response->getHeader()->getScripts()->addFile('indexes.js');
        $this->response->addHTML(Template::get('table/index_form')->render(array('fields' => $fields, 'index' => $this->index, 'form_params' => $form_params, 'add_fields' => $add_fields)));
    }
    /**
     * Process the data from the edit/create index form,
     * run the query to build the new index
     * and moves back to "tbl_sql.php"
     *
     * @return void
     */
    public function doSaveDataAction()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("doSaveDataAction") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableIndexesController.php at line 132")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called doSaveDataAction:132@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/controllers/table/TableIndexesController.php');
        die();
    }
}