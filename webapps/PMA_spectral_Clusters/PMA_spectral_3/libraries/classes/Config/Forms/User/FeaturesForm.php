<?php

/**
 * User preferences form
 */
declare (strict_types=1);
namespace PhpMyAdmin\Config\Forms\User;

use PhpMyAdmin\Config\Forms\BaseForm;
class FeaturesForm extends BaseForm
{
    /**
     * @return array
     */
    public static function getForms()
    {
        $result = ['General' => ['VersionCheck', 'NaturalOrder', 'InitialSlidersState', 'LoginCookieValidity', 'SkipLockedTables', 'DisableMultiTableMaintenance', 'ShowHint', 'SendErrorReports', 'ConsoleEnterExecutes', 'DisableShortcutKeys', 'FirstDayOfCalendar'], 'Databases' => [
            'Servers/1/only_db',
            // saves to Server/only_db
            'Servers/1/hide_db',
            // saves to Server/hide_db
            'MaxDbList',
            'MaxTableList',
            'DefaultConnectionCollation',
        ], 'Text_fields' => ['CharEditing', 'MinSizeForInputField', 'MaxSizeForInputField', 'CharTextareaCols', 'CharTextareaRows', 'TextareaCols', 'TextareaRows', 'LongtextDoubleTextarea'], 'Page_titles' => ['TitleDefault', 'TitleTable', 'TitleDatabase', 'TitleServer'], 'Warnings' => ['PmaNoRelation_DisableWarning', 'SuhosinDisableWarning', 'LoginCookieValidityDisableWarning', 'ReservedWordDisableWarning'], 'Console' => ['Console/Mode', 'Console/StartHistory', 'Console/AlwaysExpand', 'Console/CurrentQuery', 'Console/EnterExecutes', 'Console/DarkTheme', 'Console/Height', 'Console/GroupQueries', 'Console/OrderBy', 'Console/Order']];
        // skip Developer form if no setting is available
        if ($GLOBALS['cfg']['UserprefsDeveloperTab']) {
            $result['Developer'] = ['DBG/sql'];
        }
        return $result;
    }
    /**
     * @return string
     */
    public static function getName()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Config/Forms/User/FeaturesForm.php at line 37")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getName:37@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/Config/Forms/User/FeaturesForm.php');
        die();
    }
}