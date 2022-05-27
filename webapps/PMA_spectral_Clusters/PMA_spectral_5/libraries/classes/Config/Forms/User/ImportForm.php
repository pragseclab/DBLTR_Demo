<?php

/**
 * User preferences form
 */
declare (strict_types=1);
namespace PhpMyAdmin\Config\Forms\User;

use PhpMyAdmin\Config\Forms\BaseForm;
class ImportForm extends BaseForm
{
    /**
     * @return array
     */
    public static function getForms()
    {
        return ['Import_defaults' => ['Import/format', 'Import/charset', 'Import/allow_interrupt', 'Import/skip_queries', 'enable_drag_drop_import'], 'Sql' => ['Import/sql_compatibility', 'Import/sql_no_auto_value_on_zero', 'Import/sql_read_as_multibytes'], 'Csv' => [':group:' . __('CSV'), 'Import/csv_replace', 'Import/csv_ignore', 'Import/csv_terminated', 'Import/csv_enclosed', 'Import/csv_escaped', 'Import/csv_col_names', ':group:end', ':group:' . __('CSV using LOAD DATA'), 'Import/ldi_replace', 'Import/ldi_ignore', 'Import/ldi_terminated', 'Import/ldi_enclosed', 'Import/ldi_escaped', 'Import/ldi_local_option'], 'Open_Document' => [':group:' . __('OpenDocument Spreadsheet'), 'Import/ods_col_names', 'Import/ods_empty_rows', 'Import/ods_recognize_percentages', 'Import/ods_recognize_currency']];
    }
    /**
     * @return string
     */
    public static function getName()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Config/Forms/User/ImportForm.php at line 24")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getName:24@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Config/Forms/User/ImportForm.php');
        die();
    }
}