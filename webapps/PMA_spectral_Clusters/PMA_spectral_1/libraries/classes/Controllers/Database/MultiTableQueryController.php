<?php

declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Database;

use PhpMyAdmin\Database\MultiTableQuery;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Response;
use PhpMyAdmin\Template;
/**
 * Handles database multi-table querying
 */
class MultiTableQueryController extends AbstractController
{
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param Response          $response
     * @param string            $db       Database name.
     * @param DatabaseInterface $dbi
     */
    public function __construct($response, Template $template, $db, $dbi)
    {
        parent::__construct($response, $template, $db);
        $this->dbi = $dbi;
    }
    public function index() : void
    {
        $this->addScriptFiles(['vendor/jquery/jquery.md5.js', 'database/multi_table_query.js', 'database/query_generator.js']);
        $queryInstance = new MultiTableQuery($this->dbi, $this->template, $this->db);
        $this->response->addHTML($queryInstance->getFormHtml());
    }
    public function displayResults() : void
    {
        global $PMA_Theme;
        $params = ['sql_query' => $_POST['sql_query'], 'db' => $_POST['db'] ?? $_GET['db'] ?? null];
        $this->response->addHTML(MultiTableQuery::displayResults($params['sql_query'], $params['db'], $PMA_Theme->getImgPath()));
    }
    public function table() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("table") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Controllers/Database/MultiTableQueryController.php at line 41")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called table:41@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Controllers/Database/MultiTableQueryController.php');
        die();
    }
}