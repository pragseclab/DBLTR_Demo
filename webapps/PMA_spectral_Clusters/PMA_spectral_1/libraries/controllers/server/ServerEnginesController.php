<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds the PMA\libraries\controllers\server\ServerEnginesController
 *
 * @package PMA\libraries\controllers\server
 */
namespace PMA\libraries\controllers\server;

use PMA\libraries\controllers\Controller;
use PMA\libraries\StorageEngine;
use PMA\libraries\Template;
use PMA\libraries\Util;
/**
 * Handles viewing storage engine details
 *
 * @package PMA\libraries\controllers\server
 */
class ServerEnginesController extends Controller
{
    /**
     * Index action
     *
     * @return void
     */
    public function indexAction()
    {
        /**
         * Does the common work
         */
        require 'libraries/server_common.inc.php';
        /**
         * Displays the sub-page heading
         */
        $this->response->addHTML(PMA_getHtmlForSubPageHeader('engines'));
        /**
         * Did the user request information about a certain storage engine?
         */
        if (empty($_REQUEST['engine']) || !StorageEngine::isValid($_REQUEST['engine'])) {
            $this->response->addHTML($this->_getHtmlForAllServerEngines());
        } else {
            $engine = StorageEngine::getEngine($_REQUEST['engine']);
            $this->response->addHTML($this->_getHtmlForServerEngine($engine));
        }
    }
    /**
     * Return HTML with all Storage Engine information
     *
     * @return string
     */
    private function _getHtmlForAllServerEngines()
    {
        return Template::get('server/engines/engines')->render(array('engines' => StorageEngine::getStorageEngines()));
    }
    /**
     * Return HTML for a given Storage Engine
     *
     * @param StorageEngine $engine storage engine
     *
     * @return string
     */
    private function _getHtmlForServerEngine($engine)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getHtmlForServerEngine") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/server/ServerEnginesController.php at line 75")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getHtmlForServerEngine:75@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/controllers/server/ServerEnginesController.php');
        die();
    }
}