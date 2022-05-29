<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * functions for displaying server status
 *
 * @usedby  server_status.php
 *
 * @package PhpMyAdmin
 */
use PMA\libraries\ServerStatusData;
/**
 * Prints server status information: processes, connections and traffic
 *
 * @param ServerStatusData $ServerStatusData Server status data
 *
 * @return string
 */
function PMA_getHtmlForServerStatus($ServerStatusData)
{
    //display the server state General Information
    $retval = PMA_getHtmlForServerStateGeneralInfo($ServerStatusData);
    //display the server state traffic information
    $retval .= PMA_getHtmlForServerStateTraffic($ServerStatusData);
    //display the server state connection information
    $retval .= PMA_getHtmlForServerStateConnections($ServerStatusData);
    // display replication information
    if ($GLOBALS['replication_info']['master']['status'] || $GLOBALS['replication_info']['slave']['status']) {
        $retval .= PMA_getHtmlForReplicationInfo();
    }
    return $retval;
}
/**
 * Prints server state General information
 *
 * @param ServerStatusData $ServerStatusData Server status data
 *
 * @return string
 */
function PMA_getHtmlForServerStateGeneralInfo($ServerStatusData)
{
    $start_time = $GLOBALS['dbi']->fetchValue('SELECT UNIX_TIMESTAMP() - ' . $ServerStatusData->status['Uptime']);
    $retval = '<h3>';
    $bytes_received = $ServerStatusData->status['Bytes_received'];
    $bytes_sent = $ServerStatusData->status['Bytes_sent'];
    $retval .= sprintf(__('Network traffic since startup: %s'), implode(' ', PMA\libraries\Util::formatByteDown($bytes_received + $bytes_sent, 3, 1)));
    $retval .= '</h3>';
    $retval .= '<p>';
    $retval .= sprintf(__('This MySQL server has been running for %1$s. It started up on %2$s.'), PMA\libraries\Util::timespanFormat($ServerStatusData->status['Uptime']), PMA\libraries\Util::localisedDate($start_time)) . "\n";
    $retval .= '</p>';
    return $retval;
}
/**
 * Returns HTML to display replication information
 *
 * @return string HTML on replication
 */
function PMA_getHtmlForReplicationInfo()
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_getHtmlForReplicationInfo") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/server_status.lib.php at line 86")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_getHtmlForReplicationInfo:86@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/server_status.lib.php');
    die();
}
/**
 * Prints server state traffic information
 *
 * @param ServerStatusData $ServerStatusData Server status data
 *
 * @return string
 */
function PMA_getHtmlForServerStateTraffic($ServerStatusData)
{
    $hour_factor = 3600 / $ServerStatusData->status['Uptime'];
    $retval = '<table id="serverstatustraffic" class="data noclick">';
    $retval .= '<thead>';
    $retval .= '<tr>';
    $retval .= '<th>';
    $retval .= __('Traffic') . '&nbsp;';
    $retval .= PMA\libraries\Util::showHint(__('On a busy server, the byte counters may overrun, so those statistics ' . 'as reported by the MySQL server may be incorrect.'));
    $retval .= '</th>';
    $retval .= '<th>#</th>';
    $retval .= '<th>&oslash; ' . __('per hour') . '</th>';
    $retval .= '</tr>';
    $retval .= '</thead>';
    $retval .= '<tbody>';
    $retval .= '<tr>';
    $retval .= '<th class="name">' . __('Received') . '</th>';
    $retval .= '<td class="value">';
    $retval .= implode(' ', PMA\libraries\Util::formatByteDown($ServerStatusData->status['Bytes_received'], 3, 1));
    $retval .= '</td>';
    $retval .= '<td class="value">';
    $retval .= implode(' ', PMA\libraries\Util::formatByteDown($ServerStatusData->status['Bytes_received'] * $hour_factor, 3, 1));
    $retval .= '</td>';
    $retval .= '</tr>';
    $retval .= '<tr>';
    $retval .= '<th class="name">' . __('Sent') . '</th>';
    $retval .= '<td class="value">';
    $retval .= implode(' ', PMA\libraries\Util::formatByteDown($ServerStatusData->status['Bytes_sent'], 3, 1));
    $retval .= '</td>';
    $retval .= '<td class="value">';
    $retval .= implode(' ', PMA\libraries\Util::formatByteDown($ServerStatusData->status['Bytes_sent'] * $hour_factor, 3, 1));
    $retval .= '</td>';
    $retval .= '</tr>';
    $retval .= '<tr>';
    $retval .= '<th class="name">' . __('Total') . '</th>';
    $retval .= '<td class="value">';
    $bytes_received = $ServerStatusData->status['Bytes_received'];
    $bytes_sent = $ServerStatusData->status['Bytes_sent'];
    $retval .= implode(' ', PMA\libraries\Util::formatByteDown($bytes_received + $bytes_sent, 3, 1));
    $retval .= '</td>';
    $retval .= '<td class="value">';
    $bytes_received = $ServerStatusData->status['Bytes_received'];
    $bytes_sent = $ServerStatusData->status['Bytes_sent'];
    $retval .= implode(' ', PMA\libraries\Util::formatByteDown(($bytes_received + $bytes_sent) * $hour_factor, 3, 1));
    $retval .= '</td>';
    $retval .= '</tr>';
    $retval .= '</tbody>';
    $retval .= '</table>';
    return $retval;
}
/**
 * Prints server state connections information
 *
 * @param ServerStatusData $ServerStatusData Server status data
 *
 * @return string
 */
function PMA_getHtmlForServerStateConnections($ServerStatusData)
{
    $hour_factor = 3600 / $ServerStatusData->status['Uptime'];
    $retval = '<table id="serverstatusconnections" class="data noclick">';
    $retval .= '<thead>';
    $retval .= '<tr>';
    $retval .= '<th>' . __('Connections') . '</th>';
    $retval .= '<th>#</th>';
    $retval .= '<th>&oslash; ' . __('per hour') . '</th>';
    $retval .= '<th>%</th>';
    $retval .= '</tr>';
    $retval .= '</thead>';
    $retval .= '<tbody>';
    $retval .= '<tr>';
    $retval .= '<th class="name">' . __('Max. concurrent connections') . '</th>';
    $retval .= '<td class="value">';
    $retval .= PMA\libraries\Util::formatNumber($ServerStatusData->status['Max_used_connections'], 0);
    $retval .= '</td>';
    $retval .= '<td class="value">--- </td>';
    $retval .= '<td class="value">--- </td>';
    $retval .= '</tr>';
    $retval .= '<tr>';
    $retval .= '<th class="name">' . __('Failed attempts') . '</th>';
    $retval .= '<td class="value">';
    $retval .= PMA\libraries\Util::formatNumber($ServerStatusData->status['Aborted_connects'], 4, 1, true);
    $retval .= '</td>';
    $retval .= '<td class="value">';
    $retval .= PMA\libraries\Util::formatNumber($ServerStatusData->status['Aborted_connects'] * $hour_factor, 4, 2, true);
    $retval .= '</td>';
    $retval .= '<td class="value">';
    if ($ServerStatusData->status['Connections'] > 0) {
        $abortNum = $ServerStatusData->status['Aborted_connects'];
        $connectNum = $ServerStatusData->status['Connections'];
        $retval .= PMA\libraries\Util::formatNumber($abortNum * 100 / $connectNum, 0, 2, true);
        $retval .= '%';
    } else {
        $retval .= '--- ';
    }
    $retval .= '</td>';
    $retval .= '</tr>';
    $retval .= '<tr>';
    $retval .= '<th class="name">' . __('Aborted') . '</th>';
    $retval .= '<td class="value">';
    $retval .= PMA\libraries\Util::formatNumber($ServerStatusData->status['Aborted_clients'], 4, 1, true);
    $retval .= '</td>';
    $retval .= '<td class="value">';
    $retval .= PMA\libraries\Util::formatNumber($ServerStatusData->status['Aborted_clients'] * $hour_factor, 4, 2, true);
    $retval .= '</td>';
    $retval .= '<td class="value">';
    if ($ServerStatusData->status['Connections'] > 0) {
        $abortNum = $ServerStatusData->status['Aborted_clients'];
        $connectNum = $ServerStatusData->status['Connections'];
        $retval .= PMA\libraries\Util::formatNumber($abortNum * 100 / $connectNum, 0, 2, true);
        $retval .= '%';
    } else {
        $retval .= '--- ';
    }
    $retval .= '</td>';
    $retval .= '</tr>';
    $retval .= '<tr>';
    $retval .= '<th class="name">' . __('Total') . '</th>';
    $retval .= '<td class="value">';
    $retval .= PMA\libraries\Util::formatNumber($ServerStatusData->status['Connections'], 4, 0);
    $retval .= '</td>';
    $retval .= '<td class="value">';
    $retval .= PMA\libraries\Util::formatNumber($ServerStatusData->status['Connections'] * $hour_factor, 4, 2);
    $retval .= '</td>';
    $retval .= '<td class="value">';
    $retval .= PMA\libraries\Util::formatNumber(100, 0, 2);
    $retval .= '%</td>';
    $retval .= '</tr>';
    $retval .= '</tbody>';
    $retval .= '</table>';
    return $retval;
}