<?php

declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Table;

use PhpMyAdmin\Config\PageSettings;
use PhpMyAdmin\Export\Options;
use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Message;
use PhpMyAdmin\Plugins;
use PhpMyAdmin\Response;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Statements\SelectStatement;
use PhpMyAdmin\SqlParser\Utils\Query;
use PhpMyAdmin\Template;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use function array_merge;
use function implode;
use function is_array;
class ExportController extends AbstractController
{
    /** @var Options */
    private $export;
    /**
     * @param Response $response
     * @param string   $db       Database name.
     * @param string   $table    Table name.
     */
    public function __construct($response, Template $template, $db, $table, Options $export)
    {
        parent::__construct($response, $template, $db, $table);
        $this->export = $export;
    }
    public function index() : void
    {
        global $db, $url_params, $table, $replaces, $cfg, $err_url;
        global $sql_query, $where_clause, $num_tables, $unlim_num_rows;
        $pageSettings = new PageSettings('Export');
        $pageSettingsErrorHtml = $pageSettings->getErrorHTML();
        $pageSettingsHtml = $pageSettings->getHTML();
        $this->addScriptFiles(['export.js']);
        Util::checkParameters(['db', 'table']);
        $url_params = ['db' => $db, 'table' => $table];
        $err_url = Util::getScriptNameForOption($cfg['DefaultTabTable'], 'table');
        $err_url .= Url::getCommon($url_params, '&');
        $url_params['goto'] = Url::getFromRoute('/table/export');
        $url_params['back'] = Url::getFromRoute('/table/export');
        $message = '';
        // When we have some query, we need to remove LIMIT from that and possibly
        // generate WHERE clause (if we are asked to export specific rows)
        if (!empty($sql_query)) {
            $parser = new Parser($sql_query);
            if (!empty($parser->statements[0]) && $parser->statements[0] instanceof SelectStatement) {
                // Checking if the WHERE clause has to be replaced.
                if (!empty($where_clause) && is_array($where_clause)) {
                    $replaces[] = ['WHERE', 'WHERE (' . implode(') OR (', $where_clause) . ')'];
                }
                // Preparing to remove the LIMIT clause.
                $replaces[] = ['LIMIT', ''];
                // Replacing the clauses.
                $sql_query = Query::replaceClauses($parser->statements[0], $parser->list, $replaces);
            }
            $message = Generator::getMessage(Message::success());
        }
        if (!isset($sql_query)) {
            $sql_query = '';
        }
        if (!isset($num_tables)) {
            $num_tables = 0;
        }
        if (!isset($unlim_num_rows)) {
            $unlim_num_rows = 0;
        }
        $GLOBALS['single_table'] = $_POST['single_table'] ?? $_GET['single_table'] ?? null;
        $exportList = Plugins::getExport('table', isset($GLOBALS['single_table']));
        if (empty($exportList)) {
            $this->response->addHTML(Message::error(__('Could not load export plugins, please check your installation!'))->getDisplay());
            return;
        }
        $options = $this->export->getOptions('table', $db, $table, $sql_query, $num_tables, $unlim_num_rows, $exportList);
        $this->render('table/export/index', array_merge($options, ['page_settings_error_html' => $pageSettingsErrorHtml, 'page_settings_html' => $pageSettingsHtml, 'message' => $message]));
    }
    public function rows() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("rows") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Table/ExportController.php at line 86")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called rows:86@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Table/ExportController.php');
        die();
    }
}