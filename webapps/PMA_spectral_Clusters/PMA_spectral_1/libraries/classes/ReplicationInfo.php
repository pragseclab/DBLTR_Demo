<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use function count;
use function explode;
use function sprintf;
final class ReplicationInfo
{
    /** @var string[] */
    public $primaryVariables = ['File', 'Position', 'Binlog_Do_DB', 'Binlog_Ignore_DB'];
    /** @var string[] */
    public $replicaVariables = ['Slave_IO_State', 'Master_Host', 'Master_User', 'Master_Port', 'Connect_Retry', 'Master_Log_File', 'Read_Master_Log_Pos', 'Relay_Log_File', 'Relay_Log_Pos', 'Relay_Master_Log_File', 'Slave_IO_Running', 'Slave_SQL_Running', 'Replicate_Do_DB', 'Replicate_Ignore_DB', 'Replicate_Do_Table', 'Replicate_Ignore_Table', 'Replicate_Wild_Do_Table', 'Replicate_Wild_Ignore_Table', 'Last_Errno', 'Last_Error', 'Skip_Counter', 'Exec_Master_Log_Pos', 'Relay_Log_Space', 'Until_Condition', 'Until_Log_File', 'Until_Log_Pos', 'Master_SSL_Allowed', 'Master_SSL_CA_File', 'Master_SSL_CA_Path', 'Master_SSL_Cert', 'Master_SSL_Cipher', 'Master_SSL_Key', 'Seconds_Behind_Master'];
    /** @var array */
    private $primaryStatus;
    /** @var array */
    private $replicaStatus;
    /** @var array */
    private $multiPrimaryStatus;
    /** @var array */
    private $primaryInfo;
    /** @var array */
    private $replicaInfo;
    /** @var DatabaseInterface */
    private $dbi;
    public function __construct(DatabaseInterface $dbi)
    {
        $this->dbi = $dbi;
    }
    public function load(?string $connection = null) : void
    {
        global $url_params;
        $this->setPrimaryStatus();
        if (!empty($connection)) {
            $this->setMultiPrimaryStatus();
            if ($this->multiPrimaryStatus) {
                $this->setDefaultPrimaryConnection($connection);
                $url_params['master_connection'] = $connection;
            }
        }
        $this->setReplicaStatus();
        $this->setPrimaryInfo();
        $this->setReplicaInfo();
    }
    private function setPrimaryStatus() : void
    {
        $this->primaryStatus = $this->dbi->fetchResult('SHOW MASTER STATUS');
    }
    /**
     * @return array
     */
    public function getPrimaryStatus()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPrimaryStatus") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php at line 55")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPrimaryStatus:55@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php');
        die();
    }
    private function setReplicaStatus() : void
    {
        $this->replicaStatus = $this->dbi->fetchResult('SHOW SLAVE STATUS');
    }
    /**
     * @return array
     */
    public function getReplicaStatus()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getReplicaStatus") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php at line 66")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getReplicaStatus:66@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php');
        die();
    }
    private function setMultiPrimaryStatus() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setMultiPrimaryStatus") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php at line 70")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setMultiPrimaryStatus:70@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php');
        die();
    }
    private function setDefaultPrimaryConnection(string $connection) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setDefaultPrimaryConnection") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php at line 74")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setDefaultPrimaryConnection:74@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php');
        die();
    }
    private static function fill(array $status, string $key) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fill") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php at line 78")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fill:78@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/ReplicationInfo.php');
        die();
    }
    private function setPrimaryInfo() : void
    {
        $this->primaryInfo = ['status' => false];
        if (count($this->primaryStatus) > 0) {
            $this->primaryInfo['status'] = true;
        }
        if (!$this->primaryInfo['status']) {
            return;
        }
        $this->primaryInfo['Do_DB'] = self::fill($this->primaryStatus, 'Binlog_Do_DB');
        $this->primaryInfo['Ignore_DB'] = self::fill($this->primaryStatus, 'Binlog_Ignore_DB');
    }
    /**
     * @return array
     */
    public function getPrimaryInfo() : array
    {
        return $this->primaryInfo;
    }
    private function setReplicaInfo() : void
    {
        $this->replicaInfo = ['status' => false];
        if (count($this->replicaStatus) > 0) {
            $this->replicaInfo['status'] = true;
        }
        if (!$this->replicaInfo['status']) {
            return;
        }
        $this->replicaInfo['Do_DB'] = self::fill($this->replicaStatus, 'Replicate_Do_DB');
        $this->replicaInfo['Ignore_DB'] = self::fill($this->replicaStatus, 'Replicate_Ignore_DB');
        $this->replicaInfo['Do_Table'] = self::fill($this->replicaStatus, 'Replicate_Do_Table');
        $this->replicaInfo['Ignore_Table'] = self::fill($this->replicaStatus, 'Replicate_Ignore_Table');
        $this->replicaInfo['Wild_Do_Table'] = self::fill($this->replicaStatus, 'Replicate_Wild_Do_Table');
        $this->replicaInfo['Wild_Ignore_Table'] = self::fill($this->replicaStatus, 'Replicate_Wild_Ignore_Table');
    }
    /**
     * @return array
     */
    public function getReplicaInfo() : array
    {
        return $this->replicaInfo;
    }
}