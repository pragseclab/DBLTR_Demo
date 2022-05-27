<?php

declare (strict_types=1);
namespace PhpMyAdmin\Export;

use PhpMyAdmin\Core;
use PhpMyAdmin\Encoding;
use PhpMyAdmin\Plugins;
use PhpMyAdmin\Plugins\ExportPlugin;
use PhpMyAdmin\Query\Utilities;
use PhpMyAdmin\Relation;
use PhpMyAdmin\Table;
use PhpMyAdmin\Util;
use function explode;
use function function_exists;
use function in_array;
use function is_array;
use function mb_strpos;
use function strlen;
use function urldecode;
final class Options
{
    /** @var Relation */
    private $relation;
    /** @var TemplateModel */
    private $templateModel;
    public function __construct(Relation $relation, TemplateModel $templateModel)
    {
        $this->relation = $relation;
        $this->templateModel = $templateModel;
    }
    /**
     * Outputs appropriate checked statement for checkbox.
     *
     * @param string $str option name
     *
     * @return bool
     */
    private function checkboxCheck($str)
    {
        return isset($GLOBALS['cfg']['Export'][$str]) && $GLOBALS['cfg']['Export'][$str];
    }
    /**
     * Prints Html For Export Selection Options
     *
     * @param string $tmpSelect Tmp selected method of export
     *
     * @return array
     */
    public function getDatabasesForSelectOptions($tmpSelect = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDatabasesForSelectOptions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Export/Options.php at line 54")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDatabasesForSelectOptions:54@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Export/Options.php');
        die();
    }
    /**
     * @param string         $exportType   export type: server|database|table
     * @param string         $db           selected DB
     * @param string         $table        selected table
     * @param string         $sqlQuery     SQL query
     * @param int|string     $numTables    number of tables
     * @param int|string     $unlimNumRows unlimited number of rows
     * @param ExportPlugin[] $exportList
     *
     * @return array<string, mixed>
     */
    public function getOptions($exportType, $db, $table, $sqlQuery, $numTables, $unlimNumRows, array $exportList)
    {
        global $cfg;
        $cfgRelation = $this->relation->getRelationsParam();
        $templates = [];
        if ($cfgRelation['exporttemplateswork']) {
            $templates = $this->templateModel->getAll($cfgRelation['db'], $cfgRelation['export_templates'], $GLOBALS['cfg']['Server']['user'], $exportType);
            $templates = is_array($templates) ? $templates : [];
        }
        $dropdown = Plugins::getChoice('Export', 'what', $exportList, 'format');
        $tableObject = new Table($table, $db);
        $rows = [];
        if (strlen($table) > 0 && empty($numTables) && !$tableObject->isMerge() && $exportType !== 'raw') {
            $rows = ['allrows' => $_POST['allrows'] ?? null, 'limit_to' => $_POST['limit_to'] ?? null, 'limit_from' => $_POST['limit_from'] ?? null, 'unlim_num_rows' => $unlimNumRows, 'number_of_rows' => $tableObject->countRecords()];
        }
        $hasAliases = isset($_SESSION['tmpval']['aliases']) && !Core::emptyRecursive($_SESSION['tmpval']['aliases']);
        $aliases = $_SESSION['tmpval']['aliases'] ?? [];
        unset($_SESSION['tmpval']['aliases']);
        $filenameTemplate = $this->getFileNameTemplate($exportType, $_POST['filename_template'] ?? null);
        $isEncodingSupported = Encoding::isSupported();
        $selectedCompression = $_POST['compression'] ?? $cfg['Export']['compression'] ?? 'none';
        if (isset($cfg['Export']['as_separate_files']) && $cfg['Export']['as_separate_files']) {
            $selectedCompression = 'zip';
        }
        $hiddenInputs = ['db' => $db, 'table' => $table, 'export_type' => $exportType, 'export_method' => $_POST['export_method'] ?? $cfg['Export']['method'] ?? 'quick', 'template_id' => $_POST['template_id'] ?? ''];
        if (!empty($GLOBALS['single_table'])) {
            $hiddenInputs['single_table'] = true;
        }
        if (!empty($sqlQuery)) {
            $hiddenInputs['sql_query'] = $sqlQuery;
        }
        return ['export_type' => $exportType, 'db' => $db, 'table' => $table, 'templates' => ['is_enabled' => $cfgRelation['exporttemplateswork'], 'templates' => $templates, 'selected' => $_POST['template_id'] ?? null], 'sql_query' => $sqlQuery, 'hidden_inputs' => $hiddenInputs, 'export_method' => $_POST['quick_or_custom'] ?? $cfg['Export']['method'] ?? '', 'dropdown' => $dropdown, 'options' => Plugins::getOptions('Export', $exportList), 'can_convert_kanji' => Encoding::canConvertKanji(), 'exec_time_limit' => $cfg['ExecTimeLimit'], 'rows' => $rows, 'has_save_dir' => isset($cfg['SaveDir']) && !empty($cfg['SaveDir']), 'save_dir' => Util::userDir($cfg['SaveDir'] ?? ''), 'export_is_checked' => $this->checkboxCheck('quick_export_onserver'), 'export_overwrite_is_checked' => $this->checkboxCheck('quick_export_onserver_overwrite'), 'has_aliases' => $hasAliases, 'aliases' => $aliases, 'is_checked_lock_tables' => $this->checkboxCheck('lock_tables'), 'is_checked_asfile' => $this->checkboxCheck('asfile'), 'is_checked_as_separate_files' => $this->checkboxCheck('as_separate_files'), 'is_checked_export' => $this->checkboxCheck('onserver'), 'is_checked_export_overwrite' => $this->checkboxCheck('onserver_overwrite'), 'is_checked_remember_file_template' => $this->checkboxCheck('remember_file_template'), 'repopulate' => isset($_POST['repopulate']), 'lock_tables' => isset($_POST['lock_tables']), 'is_encoding_supported' => $isEncodingSupported, 'encodings' => $isEncodingSupported ? Encoding::listEncodings() : [], 'export_charset' => $cfg['Export']['charset'], 'export_asfile' => $cfg['Export']['asfile'], 'has_zip' => $cfg['ZipDump'] && function_exists('gzcompress'), 'has_gzip' => $cfg['GZipDump'] && function_exists('gzencode'), 'selected_compression' => $selectedCompression, 'filename_template' => $filenameTemplate];
    }
    private function getFileNameTemplate(string $exportType, ?string $filename = null) : string
    {
        global $cfg, $PMA_Config;
        if ($filename !== null) {
            return $filename;
        }
        if ($exportType === 'database') {
            return (string) $PMA_Config->getUserValue('pma_db_filename_template', $cfg['Export']['file_template_database']);
        }
        if ($exportType === 'table') {
            return (string) $PMA_Config->getUserValue('pma_table_filename_template', $cfg['Export']['file_template_table']);
        }
        return (string) $PMA_Config->getUserValue('pma_server_filename_template', $cfg['Export']['file_template_server']);
    }
}