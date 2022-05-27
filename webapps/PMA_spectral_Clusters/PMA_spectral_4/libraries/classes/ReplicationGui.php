<?php

/**
 * Functions for the replication GUI
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Query\Utilities;
use function htmlspecialchars;
use function in_array;
use function is_array;
use function mb_strrpos;
use function mb_strtolower;
use function mb_substr;
use function sprintf;
use function str_replace;
use function strlen;
use function strtok;
use function time;
/**
 * Functions for the replication GUI
 */
class ReplicationGui
{
    /** @var Replication */
    private $replication;
    /** @var Template */
    private $template;
    /**
     * @param Replication $replication Replication instance
     * @param Template    $template    Template instance
     */
    public function __construct(Replication $replication, Template $template)
    {
        $this->replication = $replication;
        $this->template = $template;
    }
    /**
     * returns HTML for error message
     *
     * @return string HTML code
     */
    public function getHtmlForErrorMessage()
    {
        $html = '';
        if (isset($_SESSION['replication']['sr_action_status'], $_SESSION['replication']['sr_action_info'])) {
            if ($_SESSION['replication']['sr_action_status'] === 'error') {
                $error_message = $_SESSION['replication']['sr_action_info'];
                $html .= Message::error($error_message)->getDisplay();
                $_SESSION['replication']['sr_action_status'] = 'unknown';
            } elseif ($_SESSION['replication']['sr_action_status'] === 'success') {
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
     * @return string HTML code
     */
    public function getHtmlForMasterReplication()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForMasterReplication") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 67")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForMasterReplication:67@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
    /**
     * returns HTML for master replication configuration
     *
     * @return string HTML code
     */
    public function getHtmlForMasterConfiguration()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForMasterConfiguration") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 87")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForMasterConfiguration:87@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
    /**
     * returns HTML for slave replication configuration
     *
     * @param bool  $serverSlaveStatus      Whether it is Master or Slave
     * @param array $serverSlaveReplication Slave replication
     *
     * @return string HTML code
     */
    public function getHtmlForSlaveConfiguration($serverSlaveStatus, array $serverSlaveReplication)
    {
        global $dbi;
        $serverSlaveMultiReplication = $dbi->fetchResult('SHOW ALL SLAVES STATUS');
        if ($serverSlaveStatus) {
            $urlParams = $GLOBALS['url_params'];
            $urlParams['sr_take_action'] = true;
            $urlParams['sr_slave_server_control'] = true;
            if ($serverSlaveReplication[0]['Slave_IO_Running'] === 'No') {
                $urlParams['sr_slave_action'] = 'start';
            } else {
                $urlParams['sr_slave_action'] = 'stop';
            }
            $urlParams['sr_slave_control_parm'] = 'IO_THREAD';
            $slaveControlIoLink = Url::getCommon($urlParams, '');
            if ($serverSlaveReplication[0]['Slave_SQL_Running'] === 'No') {
                $urlParams['sr_slave_action'] = 'start';
            } else {
                $urlParams['sr_slave_action'] = 'stop';
            }
            $urlParams['sr_slave_control_parm'] = 'SQL_THREAD';
            $slaveControlSqlLink = Url::getCommon($urlParams, '');
            if ($serverSlaveReplication[0]['Slave_IO_Running'] === 'No' || $serverSlaveReplication[0]['Slave_SQL_Running'] === 'No') {
                $urlParams['sr_slave_action'] = 'start';
            } else {
                $urlParams['sr_slave_action'] = 'stop';
            }
            $urlParams['sr_slave_control_parm'] = null;
            $slaveControlFullLink = Url::getCommon($urlParams, '');
            $urlParams['sr_slave_action'] = 'reset';
            $slaveControlResetLink = Url::getCommon($urlParams, '');
            $urlParams = $GLOBALS['url_params'];
            $urlParams['sr_take_action'] = true;
            $urlParams['sr_slave_skip_error'] = true;
            $slaveSkipErrorLink = Url::getCommon($urlParams, '');
            $urlParams = $GLOBALS['url_params'];
            $urlParams['sl_configure'] = true;
            $urlParams['repl_clear_scr'] = true;
            $reconfigureMasterLink = Url::getCommon($urlParams, '');
            $slaveStatusTable = $this->getHtmlForReplicationStatusTable('slave', true, false);
            $slaveIoRunning = $serverSlaveReplication[0]['Slave_IO_Running'] !== 'No';
            $slaveSqlRunning = $serverSlaveReplication[0]['Slave_SQL_Running'] !== 'No';
        }
        return $this->template->render('server/replication/slave_configuration', ['server_slave_multi_replication' => $serverSlaveMultiReplication, 'url_params' => $GLOBALS['url_params'], 'master_connection' => $_POST['master_connection'] ?? '', 'server_slave_status' => $serverSlaveStatus, 'slave_status_table' => $slaveStatusTable ?? '', 'slave_sql_running' => $slaveSqlRunning ?? false, 'slave_io_running' => $slaveIoRunning ?? false, 'slave_control_full_link' => $slaveControlFullLink ?? '', 'slave_control_reset_link' => $slaveControlResetLink ?? '', 'slave_control_sql_link' => $slaveControlSqlLink ?? '', 'slave_control_io_link' => $slaveControlIoLink ?? '', 'slave_skip_error_link' => $slaveSkipErrorLink ?? '', 'reconfigure_master_link' => $reconfigureMasterLink ?? '', 'has_slave_configure' => isset($_POST['sl_configure'])]);
    }
    /**
     * returns HTML code for selecting databases
     *
     * @return string HTML code
     */
    public function getHtmlForReplicationDbMultibox()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForReplicationDbMultibox") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 150")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForReplicationDbMultibox:150@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
    /**
     * returns HTML for changing master
     *
     * @param string $submitName submit button name
     *
     * @return string HTML code
     */
    public function getHtmlForReplicationChangeMaster($submitName)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForReplicationChangeMaster") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 168")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForReplicationChangeMaster:168@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
    /**
     * This function returns html code for table with replication status.
     *
     * @param string $type     either master or slave
     * @param bool   $isHidden if true, then default style is set to hidden,
     *                         default value false
     * @param bool   $hasTitle if true, then title is displayed, default true
     *
     * @return string HTML code
     */
    public function getHtmlForReplicationStatusTable($type, $isHidden = false, $hasTitle = true) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForReplicationStatusTable") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForReplicationStatusTable:183@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
    /**
     * get the correct username and hostname lengths for this MySQL server
     *
     * @return array   username length, hostname length
     */
    public function getUsernameHostnameLength()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUsernameHostnameLength") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 220")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUsernameHostnameLength:220@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
    /**
     * returns html code to add a replication slave user to the master
     *
     * @return string HTML code
     */
    public function getHtmlForReplicationMasterAddSlaveUser()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForReplicationMasterAddSlaveUser") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 248")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForReplicationMasterAddSlaveUser:248@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
    /**
     * handle control requests
     *
     * @return void
     */
    public function handleControlRequest()
    {
        if (!isset($_POST['sr_take_action'])) {
            return;
        }
        $refresh = false;
        $result = false;
        $messageSuccess = '';
        $messageError = '';
        if (isset($_POST['slave_changemaster']) && !$GLOBALS['cfg']['AllowArbitraryServer']) {
            $_SESSION['replication']['sr_action_status'] = 'error';
            $_SESSION['replication']['sr_action_info'] = __('Connection to server is disabled, please enable' . ' $cfg[\'AllowArbitraryServer\'] in phpMyAdmin configuration.');
        } elseif (isset($_POST['slave_changemaster'])) {
            $result = $this->handleRequestForSlaveChangeMaster();
        } elseif (isset($_POST['sr_slave_server_control'])) {
            $result = $this->handleRequestForSlaveServerControl();
            $refresh = true;
            switch ($_POST['sr_slave_action']) {
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
        } elseif (isset($_POST['sr_slave_skip_error'])) {
            $result = $this->handleRequestForSlaveSkipError();
        }
        if ($refresh) {
            $response = Response::getInstance();
            if ($response->isAjax()) {
                $response->setRequestStatus($result);
                $response->addJSON('message', $result ? Message::success($messageSuccess) : Message::error($messageError));
            } else {
                Core::sendHeaderLocation('./index.php?route=/server/replication' . Url::getCommonRaw($GLOBALS['url_params'], '&'));
            }
        }
        unset($refresh);
    }
    /**
     * handle control requests for Slave Change Master
     *
     * @return bool
     */
    public function handleRequestForSlaveChangeMaster()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handleRequestForSlaveChangeMaster") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 343")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handleRequestForSlaveChangeMaster:343@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
    /**
     * handle control requests for Slave Server Control
     *
     * @return bool
     */
    public function handleRequestForSlaveServerControl()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handleRequestForSlaveServerControl") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 383")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handleRequestForSlaveServerControl:383@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
    /**
     * handle control requests for Slave Skip Error
     *
     * @return bool
     */
    public function handleRequestForSlaveSkipError()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("handleRequestForSlaveSkipError") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php at line 405")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called handleRequestForSlaveSkipError:405@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ReplicationGui.php');
        die();
    }
}