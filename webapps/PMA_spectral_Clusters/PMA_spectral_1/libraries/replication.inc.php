<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Replication helpers
 *
 * @package PhpMyAdmin
 */
use PMA\libraries\DatabaseInterface;
if (!defined('PHPMYADMIN')) {
    exit;
}
/**
 * get master replication from server
 */
$server_master_replication = $GLOBALS['dbi']->fetchResult('SHOW MASTER STATUS');
/**
 * set selected master server
 */
if (!empty($_REQUEST['master_connection'])) {
    /**
     * check for multi-master replication functionality
     */
    $server_slave_multi_replication = $GLOBALS['dbi']->fetchResult('SHOW ALL SLAVES STATUS');
    if ($server_slave_multi_replication) {
        $GLOBALS['dbi']->query("SET @@default_master_connection = '" . $GLOBALS['dbi']->escapeString($_REQUEST['master_connection']) . "'");
        $GLOBALS['url_params']['master_connection'] = $_REQUEST['master_connection'];
    }
}
/**
 * get slave replication from server
 */
$server_slave_replication = $GLOBALS['dbi']->fetchResult('SHOW SLAVE STATUS');
/**
 * replication types
 */
$replication_types = array('master', 'slave');
/**
 * define variables for master status
 */
$master_variables = array('File', 'Position', 'Binlog_Do_DB', 'Binlog_Ignore_DB');
/**
 * Define variables for slave status
 */
$slave_variables = array('Slave_IO_State', 'Master_Host', 'Master_User', 'Master_Port', 'Connect_Retry', 'Master_Log_File', 'Read_Master_Log_Pos', 'Relay_Log_File', 'Relay_Log_Pos', 'Relay_Master_Log_File', 'Slave_IO_Running', 'Slave_SQL_Running', 'Replicate_Do_DB', 'Replicate_Ignore_DB', 'Replicate_Do_Table', 'Replicate_Ignore_Table', 'Replicate_Wild_Do_Table', 'Replicate_Wild_Ignore_Table', 'Last_Errno', 'Last_Error', 'Skip_Counter', 'Exec_Master_Log_Pos', 'Relay_Log_Space', 'Until_Condition', 'Until_Log_File', 'Until_Log_Pos', 'Master_SSL_Allowed', 'Master_SSL_CA_File', 'Master_SSL_CA_Path', 'Master_SSL_Cert', 'Master_SSL_Cipher', 'Master_SSL_Key', 'Seconds_Behind_Master');
/**
 * define important variables, which need to be watched for
 * correct running of replication in slave mode
 *
 * @usedby PMA_getHtmlForReplicationStatusTable()
 */
// TODO change to regexp or something, to allow for negative match.
// To e.g. highlight 'Last_Error'
//
$slave_variables_alerts = array('Slave_IO_Running' => 'No', 'Slave_SQL_Running' => 'No');
$slave_variables_oks = array('Slave_IO_Running' => 'Yes', 'Slave_SQL_Running' => 'Yes');
// check which replication is available and
// set $server_{master/slave}_status and assign values
// replication info is more easily passed to functions
$GLOBALS['replication_info'] = array();
foreach ($replication_types as $type) {
    if (count(${"server_{$type}_replication"}) > 0) {
        $GLOBALS['replication_info'][$type]['status'] = true;
    } else {
        $GLOBALS['replication_info'][$type]['status'] = false;
    }
    if ($GLOBALS['replication_info'][$type]['status']) {
        if ($type == "master") {
            PMA_fillReplicationInfo($type, 'Do_DB', $server_master_replication[0], 'Binlog_Do_DB');
            PMA_fillReplicationInfo($type, 'Ignore_DB', $server_master_replication[0], 'Binlog_Ignore_DB');
        } elseif ($type == "slave") {
            PMA_fillReplicationInfo($type, 'Do_DB', $server_slave_replication[0], 'Replicate_Do_DB');
            PMA_fillReplicationInfo($type, 'Ignore_DB', $server_slave_replication[0], 'Replicate_Ignore_DB');
            PMA_fillReplicationInfo($type, 'Do_Table', $server_slave_replication[0], 'Replicate_Do_Table');
            PMA_fillReplicationInfo($type, 'Ignore_Table', $server_slave_replication[0], 'Replicate_Ignore_Table');
            PMA_fillReplicationInfo($type, 'Wild_Do_Table', $server_slave_replication[0], 'Replicate_Wild_Do_Table');
            PMA_fillReplicationInfo($type, 'Wild_Ignore_Table', $server_slave_replication[0], 'Replicate_Wild_Ignore_Table');
        }
    }
}
/**
 * Fill global replication_info variable.
 *
 * @param string $type               Type: master, slave
 * @param string $replicationInfoKey Key in replication_info variable
 * @param array  $mysqlInfo          MySQL data about replication
 * @param string $mysqlKey           MySQL key
 *
 * @return array
 */
function PMA_fillReplicationInfo($type, $replicationInfoKey, $mysqlInfo, $mysqlKey)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_fillReplicationInfo") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php at line 188")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_fillReplicationInfo:188@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php');
    die();
}
/**
 * Extracts database or table name from string
 *
 * @param string $string contains "dbname.tablename"
 * @param string $what   what to extract (db|table)
 *
 * @return string the extracted part
 */
function PMA_extractDbOrTable($string, $what = 'db')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_extractDbOrTable") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php at line 209")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_extractDbOrTable:209@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php');
    die();
}
/**
 * Configures replication slave
 *
 * @param string $action  possible values: START or STOP
 * @param string $control default: null,
 *                        possible values: SQL_THREAD or IO_THREAD or null.
 *                        If it is set to null, it controls both
 *                        SQL_THREAD and IO_THREAD
 * @param mixed  $link    mysql link
 *
 * @return mixed output of DatabaseInterface::tryQuery
 */
function PMA_Replication_Slave_control($action, $control = null, $link = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_Replication_Slave_control") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php at line 231")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_Replication_Slave_control:231@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php');
    die();
}
/**
 * Changes master for replication slave
 *
 * @param string $user     replication user on master
 * @param string $password password for the user
 * @param string $host     master's hostname or IP
 * @param int    $port     port, where mysql is running
 * @param array  $pos      position of mysql replication,
 *                         array should contain fields File and Position
 * @param bool   $stop     shall we stop slave?
 * @param bool   $start    shall we start slave?
 * @param mixed  $link     mysql link
 *
 * @return string output of CHANGE MASTER mysql command
 */
function PMA_Replication_Slave_changeMaster($user, $password, $host, $port, $pos, $stop = true, $start = true, $link = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_Replication_Slave_changeMaster") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php at line 262")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_Replication_Slave_changeMaster:262@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php');
    die();
}
/**
 * This function provides connection to remote mysql server
 *
 * @param string $user     mysql username
 * @param string $password password for the user
 * @param string $host     mysql server's hostname or IP
 * @param int    $port     mysql remote port
 * @param string $socket   path to unix socket
 *
 * @return mixed $link mysql link on success
 */
function PMA_Replication_connectToMaster($user, $password, $host = null, $port = null, $socket = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_Replication_connectToMaster") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php at line 297")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_Replication_connectToMaster:297@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php');
    die();
}
/**
 * Fetches position and file of current binary log on master
 *
 * @param mixed $link mysql link
 *
 * @return array an array containing File and Position in MySQL replication
 * on master server, useful for PMA_Replication_Slave_changeMaster
 */
function PMA_Replication_Slave_binLogMaster($link = null)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_Replication_Slave_binLogMaster") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php at line 318")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_Replication_Slave_binLogMaster:318@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/replication.inc.php');
    die();
}