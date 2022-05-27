<?php

declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Server\Status;

use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Message;
use PhpMyAdmin\Response;
use PhpMyAdmin\Server\Status\Data;
use PhpMyAdmin\Template;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use function array_keys;
use function count;
use function mb_strtolower;
use function strlen;
use function ucfirst;
class ProcessesController extends AbstractController
{
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param Response          $response
     * @param Data              $data
     * @param DatabaseInterface $dbi
     */
    public function __construct($response, Template $template, $data, $dbi)
    {
        parent::__construct($response, $template, $data);
        $this->dbi = $dbi;
    }
    public function index() : void
    {
        global $err_url;
        $params = ['showExecuting' => $_POST['showExecuting'] ?? null, 'full' => $_POST['full'] ?? null, 'column_name' => $_POST['column_name'] ?? null, 'order_by_field' => $_POST['order_by_field'] ?? null, 'sort_order' => $_POST['sort_order'] ?? null];
        $err_url = Url::getFromRoute('/');
        if ($this->dbi->isSuperUser()) {
            $this->dbi->selectDb('mysql');
        }
        $this->addScriptFiles(['server/status/processes.js']);
        $isChecked = false;
        if (!empty($params['showExecuting'])) {
            $isChecked = true;
        }
        $urlParams = ['ajax_request' => true, 'full' => $params['full'] ?? '', 'column_name' => $params['column_name'] ?? '', 'order_by_field' => $params['order_by_field'] ?? '', 'sort_order' => $params['sort_order'] ?? ''];
        $serverProcessList = $this->getList($params);
        $this->render('server/status/processes/index', ['url_params' => $urlParams, 'is_checked' => $isChecked, 'server_process_list' => $serverProcessList]);
    }
    /**
     * Only sends the process list table
     */
    public function refresh() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("refresh") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Server/Status/ProcessesController.php at line 55")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called refresh:55@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Server/Status/ProcessesController.php');
        die();
    }
    /**
     * @param array $params Request parameters
     */
    public function kill(array $params) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("kill") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Server/Status/ProcessesController.php at line 66")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called kill:66@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/Controllers/Server/Status/ProcessesController.php');
        die();
    }
    /**
     * @param array $params Request parameters
     */
    private function getList(array $params) : string
    {
        $urlParams = [];
        $showFullSql = !empty($params['full']);
        if ($showFullSql) {
            $urlParams['full'] = '';
        } else {
            $urlParams['full'] = 1;
        }
        // This array contains display name and real column name of each
        // sortable column in the table
        $sortableColumns = [['column_name' => __('ID'), 'order_by_field' => 'Id'], ['column_name' => __('User'), 'order_by_field' => 'User'], ['column_name' => __('Host'), 'order_by_field' => 'Host'], ['column_name' => __('Database'), 'order_by_field' => 'db'], ['column_name' => __('Command'), 'order_by_field' => 'Command'], ['column_name' => __('Time'), 'order_by_field' => 'Time'], ['column_name' => __('Status'), 'order_by_field' => 'State'], ['column_name' => __('Progress'), 'order_by_field' => 'Progress'], ['column_name' => __('SQL query'), 'order_by_field' => 'Info']];
        $sortableColCount = count($sortableColumns);
        $sqlQuery = $showFullSql ? 'SHOW FULL PROCESSLIST' : 'SHOW PROCESSLIST';
        if (!empty($params['order_by_field']) && !empty($params['sort_order']) || !empty($params['showExecuting'])) {
            $urlParams['order_by_field'] = $params['order_by_field'];
            $urlParams['sort_order'] = $params['sort_order'];
            $urlParams['showExecuting'] = $params['showExecuting'];
            $sqlQuery = 'SELECT * FROM `INFORMATION_SCHEMA`.`PROCESSLIST` ';
        }
        if (!empty($params['showExecuting'])) {
            $sqlQuery .= ' WHERE state != "" ';
        }
        if (!empty($params['order_by_field']) && !empty($params['sort_order'])) {
            $sqlQuery .= ' ORDER BY ' . Util::backquote($params['order_by_field']) . ' ' . $params['sort_order'];
        }
        $result = $this->dbi->query($sqlQuery);
        $columns = [];
        foreach ($sortableColumns as $columnKey => $column) {
            $is_sorted = !empty($params['order_by_field']) && !empty($params['sort_order']) && $params['order_by_field'] == $column['order_by_field'];
            $column['sort_order'] = 'ASC';
            if ($is_sorted && $params['sort_order'] === 'ASC') {
                $column['sort_order'] = 'DESC';
            }
            if (isset($params['showExecuting'])) {
                $column['showExecuting'] = 'on';
            }
            $columns[$columnKey] = ['name' => $column['column_name'], 'params' => $column, 'is_sorted' => $is_sorted, 'sort_order' => $column['sort_order'], 'has_full_query' => false, 'is_full' => false];
            if (0 !== --$sortableColCount) {
                continue;
            }
            $columns[$columnKey]['has_full_query'] = true;
            if (!$showFullSql) {
                continue;
            }
            $columns[$columnKey]['is_full'] = true;
        }
        $rows = [];
        while ($process = $this->dbi->fetchAssoc($result)) {
            // Array keys need to modify due to the way it has used
            // to display column values
            if (!empty($params['order_by_field']) && !empty($params['sort_order']) || !empty($params['showExecuting'])) {
                foreach (array_keys($process) as $key) {
                    $newKey = ucfirst(mb_strtolower($key));
                    if ($newKey === $key) {
                        continue;
                    }
                    $process[$newKey] = $process[$key];
                    unset($process[$key]);
                }
            }
            $rows[] = ['id' => $process['Id'], 'user' => $process['User'], 'host' => $process['Host'], 'db' => !isset($process['db']) || strlen($process['db']) === 0 ? '' : $process['db'], 'command' => $process['Command'], 'time' => $process['Time'], 'state' => !empty($process['State']) ? $process['State'] : '---', 'progress' => !empty($process['Progress']) ? $process['Progress'] : '---', 'info' => !empty($process['Info']) ? Generator::formatSql($process['Info'], !$showFullSql) : '---'];
        }
        return $this->template->render('server/status/processes/list', ['columns' => $columns, 'rows' => $rows, 'refresh_params' => $urlParams]);
    }
}