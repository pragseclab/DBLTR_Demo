<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Functions for the replication GUI
 *
 * @package PhpMyAdmin
 */
use PMA\libraries\Message;
use PMA\libraries\Response;
use PMA\libraries\URL;
/**
 * returns HTML for error message
 *
 * @return String HTML code
 */
function PMA_getHtmlForErrorMessage()
{
    $html = '';
    if (isset($_SESSION['replication']['sr_action_status']) && isset($_SESSION['replication']['sr_action_info'])) {
        if ($_SESSION['replication']['sr_action_status'] == 'error') {
            $error_message = $_SESSION['replication']['sr_action_info'];
            $html .= Message::error($error_message)->getDisplay();
            $_SESSION['replication']['sr_action_status'] = 'unknown';
        } elseif ($_SESSION['replication']['sr_action_status'] == 'success') {
            $success_message = $_SESSION['replication']['sr_action_info'];
            $html .= Message::success($success_message)->getDisplay();
            $_SESSION['replication']['sr_action_status'] = 'unknown';
        }
    }
    return $html;
}
/**
 * returns HTML for master replication
 *
 * @return String HTML code
 */
function PMA_getHtmlForMasterReplication()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForMasterReplication") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 43")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForMasterReplication:43@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * returns HTML for master replication configuration
 *
 * @return String HTML code
 */
function PMA_getHtmlForMasterConfiguration()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForMasterConfiguration") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 87")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForMasterConfiguration:87@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * returns HTML for slave replication configuration
 *
 * @param bool  $server_slave_status      Whether it is Master or Slave
 * @param array $server_slave_replication Slave replication
 *
 * @return String HTML code
 */
function PMA_getHtmlForSlaveConfiguration($server_slave_status, $server_slave_replication)
{
    $html = '<fieldset>';
    $html .= '<legend>' . __('Slave replication') . '</legend>';
    /**
     * check for multi-master replication functionality
     */
    $server_slave_multi_replication = $GLOBALS['dbi']->fetchResult('SHOW ALL SLAVES STATUS');
    if ($server_slave_multi_replication) {
        $html .= __('Master connection:');
        $html .= '<form method="get" action="server_replication.php">';
        $html .= URL::getHiddenInputs($GLOBALS['url_params']);
        $html .= ' <select name="master_connection">';
        $html .= '<option value="">' . __('Default') . '</option>';
        foreach ($server_slave_multi_replication as $server) {
            $html .= '<option' . (isset($_REQUEST['master_connection']) && $_REQUEST['master_connection'] == $server['Connection_name'] ? ' selected="selected"' : '') . '>' . $server['Connection_name'] . '</option>';
        }
        $html .= '</select>';
        $html .= ' <input type="submit" value="' . __('Go') . '" id="goButton" />';
        $html .= '</form>';
        $html .= '<br /><br />';
    }
    if ($server_slave_status) {
        $html .= '<div id="slave_configuration_gui">';
        $_url_params = $GLOBALS['url_params'];
        $_url_params['sr_take_action'] = true;
        $_url_params['sr_slave_server_control'] = true;
        if ($server_slave_replication[0]['Slave_IO_Running'] == 'No') {
            $_url_params['sr_slave_action'] = 'start';
        } else {
            $_url_params['sr_slave_action'] = 'stop';
        }
        $_url_params['sr_slave_control_parm'] = 'IO_THREAD';
        $slave_control_io_link = 'server_replication.php' . URL::getCommon($_url_params);
        if ($server_slave_replication[0]['Slave_SQL_Running'] == 'No') {
            $_url_params['sr_slave_action'] = 'start';
        } else {
            $_url_params['sr_slave_action'] = 'stop';
        }
        $_url_params['sr_slave_control_parm'] = 'SQL_THREAD';
        $slave_control_sql_link = 'server_replication.php' . URL::getCommon($_url_params);
        if ($server_slave_replication[0]['Slave_IO_Running'] == 'No' || $server_slave_replication[0]['Slave_SQL_Running'] == 'No') {
            $_url_params['sr_slave_action'] = 'start';
        } else {
            $_url_params['sr_slave_action'] = 'stop';
        }
        $_url_params['sr_slave_control_parm'] = null;
        $slave_control_full_link = 'server_replication.php' . URL::getCommon($_url_params);
        $_url_params['sr_slave_action'] = 'reset';
        $slave_control_reset_link = 'server_replication.php' . URL::getCommon($_url_params);
        $_url_params = $GLOBALS['url_params'];
        $_url_params['sr_take_action'] = true;
        $_url_params['sr_slave_skip_error'] = true;
        $slave_skip_error_link = 'server_replication.php' . URL::getCommon($_url_params);
        if ($server_slave_replication[0]['Slave_SQL_Running'] == 'No') {
            $html .= Message::error(__('Slave SQL Thread not running!'))->getDisplay();
        }
        if ($server_slave_replication[0]['Slave_IO_Running'] == 'No') {
            $html .= Message::error(__('Slave IO Thread not running!'))->getDisplay();
        }
        $_url_params = $GLOBALS['url_params'];
        $_url_params['sl_configure'] = true;
        $_url_params['repl_clear_scr'] = true;
        $reconfiguremaster_link = 'server_replication.php' . URL::getCommon($_url_params);
        $html .= __('Server is configured as slave in a replication process. Would you ' . 'like to:');
        $html .= '<br />';
        $html .= '<ul>';
        $html .= ' <li><a href="#slave_status_href" id="slave_status_href">';
        $html .= __('See slave status table') . '</a>';
        $html .= PMA_getHtmlForReplicationStatusTable('slave', true, false);
        $html .= ' </li>';
        $html .= ' <li><a href="#slave_control_href" id="slave_control_href">';
        $html .= __('Control slave:') . '</a>';
        $html .= ' <div id="slave_control_gui" style="display: none">';
        $html .= '  <ul>';
        $html .= '   <li><a href="' . $slave_control_full_link . '">';
        $html .= ($server_slave_replication[0]['Slave_IO_Running'] == 'No' || $server_slave_replication[0]['Slave_SQL_Running'] == 'No' ? __('Full start') : __('Full stop')) . ' </a></li>';
        $html .= '   <li><a class="ajax" id="reset_slave"' . ' href="' . $slave_control_reset_link . '">';
        $html .= __('Reset slave') . '</a></li>';
        if ($server_slave_replication[0]['Slave_SQL_Running'] == 'No') {
            $html .= '   <li><a href="' . $slave_control_sql_link . '">';
            $html .= __('Start SQL Thread only') . '</a></li>';
        } else {
            $html .= '   <li><a href="' . $slave_control_sql_link . '">';
            $html .= __('Stop SQL Thread only') . '</a></li>';
        }
        if ($server_slave_replication[0]['Slave_IO_Running'] == 'No') {
            $html .= '   <li><a href="' . $slave_control_io_link . '">';
            $html .= __('Start IO Thread only') . '</a></li>';
        } else {
            $html .= '   <li><a href="' . $slave_control_io_link . '">';
            $html .= __('Stop IO Thread only') . '</a></li>';
        }
        $html .= '  </ul>';
        $html .= ' </div>';
        $html .= ' </li>';
        $html .= ' <li>';
        $html .= PMA_getHtmlForSlaveErrorManagement($slave_skip_error_link);
        $html .= ' </li>';
        $html .= ' <li><a href="' . $reconfiguremaster_link . '">';
        $html .= __('Change or reconfigure master server') . '</a></li>';
        $html .= '</ul>';
        $html .= '</div>';
    } elseif (!isset($_REQUEST['sl_configure'])) {
        $_url_params = $GLOBALS['url_params'];
        $_url_params['sl_configure'] = true;
        $_url_params['repl_clear_scr'] = true;
        $html .= sprintf(__('This server is not configured as slave in a replication process. ' . 'Would you like to <a href="%s">configure</a> it?'), 'server_replication.php' . URL::getCommon($_url_params));
    }
    $html .= '</fieldset>';
    return $html;
}
/**
 * returns HTML for Slave Error Management
 *
 * @param String $slave_skip_error_link error link
 *
 * @return String HTML code
 */
function PMA_getHtmlForSlaveErrorManagement($slave_skip_error_link)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForSlaveErrorManagement") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 307")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForSlaveErrorManagement:307@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * returns HTML for not configure for a server replication
 *
 * @return String HTML code
 */
function PMA_getHtmlForNotServerReplication()
{
    $_url_params = $GLOBALS['url_params'];
    $_url_params['mr_configure'] = true;
    $html = '<fieldset>';
    $html .= '<legend>' . __('Master replication') . '</legend>';
    $html .= sprintf(__('This server is not configured as master in a replication process. ' . 'Would you like to <a href="%s">configure</a> it?'), 'server_replication.php' . URL::getCommon($_url_params));
    $html .= '</fieldset>';
    return $html;
}
/**
 * returns HTML code for selecting databases
 *
 * @return String HTML code
 */
function PMA_getHtmlForReplicationDbMultibox()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForReplicationDbMultibox") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 364")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForReplicationDbMultibox:364@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * returns HTML for changing master
 *
 * @param String $submitname - submit button name
 *
 * @return String HTML code
 */
function PMA_getHtmlForReplicationChangeMaster($submitname)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForReplicationChangeMaster") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 395")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForReplicationChangeMaster:395@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * returns HTML code for Add user input div
 *
 * @param array $label_array label tag elements
 * @param array $input_array input tag elements
 *
 * @return String HTML code
 */
function PMA_getHtmlForAddUserInputDiv($label_array, $input_array)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForAddUserInputDiv") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 480")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForAddUserInputDiv:480@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * This function returns html code for table with replication status.
 *
 * @param string  $type   either master or slave
 * @param boolean $hidden if true, then default style is set to hidden,
 *                        default value false
 * @param boolean $title  if true, then title is displayed, default true
 *
 * @return String HTML code
 */
function PMA_getHtmlForReplicationStatusTable($type, $hidden = false, $title = true)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForReplicationStatusTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 505")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForReplicationStatusTable:505@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * returns html code for table with slave users connected to this master
 *
 * @param boolean $hidden - if true, then default style is set to hidden,
 *                        - default value false
 *
 * @return string
 */
function PMA_getHtmlForReplicationSlavesTable($hidden = false)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForReplicationSlavesTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 607")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForReplicationSlavesTable:607@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * get the correct username and hostname lengths for this MySQL server
 *
 * @return array   username length, hostname length
 */
function PMA_replicationGetUsernameHostnameLength()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_replicationGetUsernameHostnameLength") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 652")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_replicationGetUsernameHostnameLength:652@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * returns html code to add a replication slave user to the master
 *
 * @return String HTML code
 */
function PMA_getHtmlForReplicationMasterAddSlaveuser()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForReplicationMasterAddSlaveuser") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 680")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForReplicationMasterAddSlaveuser:680@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 *  returns html code to add a replication slave user to the master
 *
 * @param int $username_length Username length
 *
 * @return String HTML code
 */
function PMA_getHtmlForAddUserLoginForm($username_length)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForAddUserLoginForm") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 771")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForAddUserLoginForm:771@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * returns HTML for TableInfoForm
 *
 * @param int $hostname_length Selected hostname length
 *
 * @return String HTML code
 */
function PMA_getHtmlForTableInfoForm($hostname_length)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForTableInfoForm") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 819")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForTableInfoForm:819@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * handle control requests
 *
 * @return NULL
 */
function PMA_handleControlRequest()
{
    if (isset($_REQUEST['sr_take_action'])) {
        $refresh = false;
        $result = false;
        $messageSuccess = null;
        $messageError = null;
        if (isset($_REQUEST['slave_changemaster']) && !$GLOBALS['cfg']['AllowArbitraryServer']) {
            $_SESSION['replication']['sr_action_status'] = 'error';
            $_SESSION['replication']['sr_action_info'] = __('Connection to server is disabled, please enable $cfg[\'AllowArbitraryServer\'] in phpMyAdmin configuration.');
        } elseif (isset($_REQUEST['slave_changemaster'])) {
            $result = PMA_handleRequestForSlaveChangeMaster();
        } elseif (isset($_REQUEST['sr_slave_server_control'])) {
            $result = PMA_handleRequestForSlaveServerControl();
            $refresh = true;
            switch ($_REQUEST['sr_slave_action']) {
                case 'start':
                    $messageSuccess = __('Replication started successfully.');
                    $messageError = __('Error starting replication.');
                    break;
                case 'stop':
                    $messageSuccess = __('Replication stopped successfully.');
                    $messageError = __('Error stopping replication.');
                    break;
                case 'reset':
                    $messageSuccess = __('Replication resetting successfully.');
                    $messageError = __('Error resetting replication.');
                    break;
                default:
                    $messageSuccess = __('Success.');
                    $messageError = __('Error.');
                    break;
            }
        } elseif (isset($_REQUEST['sr_slave_skip_error'])) {
            $result = PMA_handleRequestForSlaveSkipError();
        }
        if ($refresh) {
            $response = Response::getInstance();
            if ($response->isAjax()) {
                $response->setRequestStatus($result);
                $response->addJSON('message', $result ? Message::success($messageSuccess) : Message::error($messageError));
            } else {
                PMA_sendHeaderLocation('./server_replication.php' . URL::getCommonRaw($GLOBALS['url_params']));
            }
        }
        unset($refresh);
    }
}
/**
 * handle control requests for Slave Change Master
 *
 * @return boolean
 */
function PMA_handleRequestForSlaveChangeMaster()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_handleRequestForSlaveChangeMaster") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 961")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_handleRequestForSlaveChangeMaster:961@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * handle control requests for Slave Server Control
 *
 * @return boolean
 */
function PMA_handleRequestForSlaveServerControl()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_handleRequestForSlaveServerControl") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 1032")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_handleRequestForSlaveServerControl:1032@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}
/**
 * handle control requests for Slave Skip Error
 *
 * @return boolean
 */
function PMA_handleRequestForSlaveSkipError()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_handleRequestForSlaveSkipError") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php at line 1062")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_handleRequestForSlaveSkipError:1062@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication_gui.lib.php');
    die();
}