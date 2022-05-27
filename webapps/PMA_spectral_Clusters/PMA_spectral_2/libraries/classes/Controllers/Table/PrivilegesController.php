<?php

/**
 * Controller for table privileges
 */
declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Table;

use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Response;
use PhpMyAdmin\Server\Privileges;
use PhpMyAdmin\Template;
use PhpMyAdmin\Util;
/**
 * Controller for table privileges
 */
class PrivilegesController extends AbstractController
{
    /** @var Privileges */
    private $privileges;
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param Response          $response
     * @param string            $db       Database name
     * @param string            $table    Table name
     * @param DatabaseInterface $dbi
     */
    public function __construct($response, Template $template, $db, $table, Privileges $privileges, $dbi)
    {
        parent::__construct($response, $template, $db, $table);
        $this->privileges = $privileges;
        $this->dbi = $dbi;
    }
    /**
     * @param array $params Request parameters
     */
    public function index(array $params) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("index") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Table/PrivilegesController.php at line 40")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called index:40@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Table/PrivilegesController.php');
        die();
    }
}