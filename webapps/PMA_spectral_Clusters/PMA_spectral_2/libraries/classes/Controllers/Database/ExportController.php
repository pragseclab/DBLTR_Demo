<?php

declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Database;

use PhpMyAdmin\Config\PageSettings;
use PhpMyAdmin\Export;
use PhpMyAdmin\Export\Options;
use PhpMyAdmin\Message;
use PhpMyAdmin\Plugins;
use PhpMyAdmin\Response;
use PhpMyAdmin\Template;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use function array_merge;
use function is_array;
final class ExportController extends AbstractController
{
    /** @var Export */
    private $export;
    /** @var Options */
    private $exportOptions;
    /**
     * @param Response $response
     * @param string   $db       Database name.
     */
    public function __construct($response, Template $template, $db, Export $export, Options $exportOptions)
    {
        parent::__construct($response, $template, $db);
        $this->export = $export;
        $this->exportOptions = $exportOptions;
    }
    public function index() : void
    {
        global $db, $table, $sub_part, $url_params, $sql_query;
        global $tables, $num_tables, $total_num_tables, $tooltip_truename;
        global $tooltip_aliasname, $pos, $table_select, $unlim_num_rows, $cfg, $err_url;
        $pageSettings = new PageSettings('Export');
        $pageSettingsErrorHtml = $pageSettings->getErrorHTML();
        $pageSettingsHtml = $pageSettings->getHTML();
        $this->addScriptFiles(['export.js']);
        // $sub_part is used in Util::getDbInfo() to see if we are coming from
        // /database/export, in which case we don't obey $cfg['MaxTableList']
        $sub_part = '_export';
        Util::checkParameters(['db']);
        $err_url = Util::getScriptNameForOption($cfg['DefaultTabDatabase'], 'database');
        $err_url .= Url::getCommon(['db' => $db], '&');
        if (!$this->hasDatabase()) {
            return;
        }
        $url_params['goto'] = Url::getFromRoute('/database/export');
        [$tables, $num_tables, $total_num_tables, $sub_part, , , $tooltip_truename, $tooltip_aliasname, $pos] = Util::getDbInfo($db, $sub_part ?? '');
        // exit if no tables in db found
        if ($num_tables < 1) {
            $this->response->addHTML(Message::error(__('No tables found in database.'))->getDisplay());
            return;
        }
        if (!empty($_POST['selected_tbl']) && empty($table_select)) {
            $table_select = $_POST['selected_tbl'];
        }
        $tablesForMultiValues = [];
        foreach ($tables as $each_table) {
            if (isset($_POST['table_select']) && is_array($_POST['table_select'])) {
                $is_checked = $this->export->getCheckedClause($each_table['Name'], $_POST['table_select']);
            } elseif (isset($table_select)) {
                $is_checked = $this->export->getCheckedClause($each_table['Name'], $table_select);
            } else {
                $is_checked = true;
            }
            if (isset($_POST['table_structure']) && is_array($_POST['table_structure'])) {
                $structure_checked = $this->export->getCheckedClause($each_table['Name'], $_POST['table_structure']);
            } else {
                $structure_checked = $is_checked;
            }
            if (isset($_POST['table_data']) && is_array($_POST['table_data'])) {
                $data_checked = $this->export->getCheckedClause($each_table['Name'], $_POST['table_data']);
            } else {
                $data_checked = $is_checked;
            }
            $tablesForMultiValues[] = ['name' => $each_table['Name'], 'is_checked_select' => $is_checked, 'is_checked_structure' => $structure_checked, 'is_checked_data' => $data_checked];
        }
        if (!isset($sql_query)) {
            $sql_query = '';
        }
        if (!isset($unlim_num_rows)) {
            $unlim_num_rows = 0;
        }
        $isReturnBackFromRawExport = isset($_POST['export_type']) && $_POST['export_type'] === 'raw';
        if (isset($_POST['raw_query']) || $isReturnBackFromRawExport) {
            $export_type = 'raw';
        } else {
            $export_type = 'database';
        }
        $GLOBALS['single_table'] = $_POST['single_table'] ?? $_GET['single_table'] ?? null;
        $exportList = Plugins::getExport($export_type, isset($GLOBALS['single_table']));
        if (empty($exportList)) {
            $this->response->addHTML(Message::error(__('Could not load export plugins, please check your installation!'))->getDisplay());
            return;
        }
        $options = $this->exportOptions->getOptions($export_type, $db, $table, $sql_query, $num_tables, $unlim_num_rows, $exportList);
        $this->render('database/export/index', array_merge($options, ['page_settings_error_html' => $pageSettingsErrorHtml, 'page_settings_html' => $pageSettingsHtml, 'structure_or_data_forced' => $_POST['structure_or_data_forced'] ?? 0, 'tables' => $tablesForMultiValues]));
    }
    public function tables() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("tables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/ExportController.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called tables:105@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Database/ExportController.php');
        die();
    }
}