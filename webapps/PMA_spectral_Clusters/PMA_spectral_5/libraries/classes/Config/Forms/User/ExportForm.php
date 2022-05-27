<?php

/**
 * User preferences form
 */
declare (strict_types=1);
namespace PhpMyAdmin\Config\Forms\User;

use PhpMyAdmin\Config\Forms\BaseForm;
class ExportForm extends BaseForm
{
    /**
     * @return array
     */
    public static function getForms()
    {
        // phpcs:disable Squiz.Arrays.ArrayDeclaration.KeySpecified,Squiz.Arrays.ArrayDeclaration.NoKeySpecified
        return ['Export_defaults' => ['Export/method', ':group:' . __('Quick'), 'Export/quick_export_onserver', 'Export/quick_export_onserver_overwrite', ':group:end', ':group:' . __('Custom'), 'Export/format', 'Export/compression', 'Export/charset', 'Export/lock_tables', 'Export/as_separate_files', 'Export/asfile' => ':group', 'Export/onserver', 'Export/onserver_overwrite', ':group:end', 'Export/file_template_table', 'Export/file_template_database', 'Export/file_template_server'], 'Sql' => ['Export/sql_include_comments' => ':group', 'Export/sql_dates', 'Export/sql_relation', 'Export/sql_mime', ':group:end', 'Export/sql_use_transaction', 'Export/sql_disable_fk', 'Export/sql_views_as_tables', 'Export/sql_metadata', 'Export/sql_compatibility', 'Export/sql_structure_or_data', ':group:' . __('Structure'), 'Export/sql_drop_database', 'Export/sql_create_database', 'Export/sql_drop_table', 'Export/sql_create_table' => ':group', 'Export/sql_if_not_exists', 'Export/sql_auto_increment', ':group:end', 'Export/sql_create_view' => ':group', 'Export/sql_view_current_user', 'Export/sql_or_replace_view', ':group:end', 'Export/sql_procedure_function', 'Export/sql_create_trigger', 'Export/sql_backquotes', ':group:end', ':group:' . __('Data'), 'Export/sql_delayed', 'Export/sql_ignore', 'Export/sql_type', 'Export/sql_insert_syntax', 'Export/sql_max_query_size', 'Export/sql_hex_for_binary', 'Export/sql_utc_time'], 'CodeGen' => ['Export/codegen_format'], 'Csv' => [':group:' . __('CSV'), 'Export/csv_separator', 'Export/csv_enclosed', 'Export/csv_escaped', 'Export/csv_terminated', 'Export/csv_null', 'Export/csv_removeCRLF', 'Export/csv_columns', ':group:end', ':group:' . __('CSV for MS Excel'), 'Export/excel_null', 'Export/excel_removeCRLF', 'Export/excel_columns', 'Export/excel_edition'], 'Latex' => ['Export/latex_caption', 'Export/latex_structure_or_data', ':group:' . __('Structure'), 'Export/latex_structure_caption', 'Export/latex_structure_continued_caption', 'Export/latex_structure_label', 'Export/latex_relation', 'Export/latex_comments', 'Export/latex_mime', ':group:end', ':group:' . __('Data'), 'Export/latex_columns', 'Export/latex_data_caption', 'Export/latex_data_continued_caption', 'Export/latex_data_label', 'Export/latex_null'], 'Microsoft_Office' => [':group:' . __('Microsoft Word 2000'), 'Export/htmlword_structure_or_data', 'Export/htmlword_null', 'Export/htmlword_columns'], 'Open_Document' => [':group:' . __('OpenDocument Spreadsheet'), 'Export/ods_columns', 'Export/ods_null', ':group:end', ':group:' . __('OpenDocument Text'), 'Export/odt_structure_or_data', ':group:' . __('Structure'), 'Export/odt_relation', 'Export/odt_comments', 'Export/odt_mime', ':group:end', ':group:' . __('Data'), 'Export/odt_columns', 'Export/odt_null'], 'Texy' => ['Export/texytext_structure_or_data', ':group:' . __('Data'), 'Export/texytext_null', 'Export/texytext_columns']];
        // phpcs:enable
    }
    /**
     * @return string
     */
    public static function getName()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Config/Forms/User/ExportForm.php at line 26")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getName:26@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Config/Forms/User/ExportForm.php');
        die();
    }
}