<?php

/**
 * Library for extracting information about the partitions
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use function array_values;
/**
 * base Partition Class
 */
class Partition extends SubPartition
{
    /** @var string partition description */
    protected $description;
    /** @var SubPartition[] sub partitions */
    protected $subPartitions = array();
    /**
     * Loads data from the fetched row from information_schema.PARTITIONS
     *
     * @param array $row fetched row
     *
     * @return void
     */
    protected function loadData(array $row)
    {
        $this->name = $row['PARTITION_NAME'];
        $this->ordinal = $row['PARTITION_ORDINAL_POSITION'];
        $this->method = $row['PARTITION_METHOD'];
        $this->expression = $row['PARTITION_EXPRESSION'];
        $this->description = $row['PARTITION_DESCRIPTION'];
        // no sub partitions, load all data to this object
        if (!empty($row['SUBPARTITION_NAME'])) {
            return;
        }
        $this->loadCommonData($row);
    }
    /**
     * Returns the partition description
     *
     * @return string partition description
     */
    public function getDescription()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDescription") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php at line 46")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDescription:46@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php');
        die();
    }
    /**
     * Add a sub partition
     *
     * @param SubPartition $partition Sub partition
     *
     * @return void
     */
    public function addSubPartition(SubPartition $partition)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addSubPartition") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php at line 57")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addSubPartition:57@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php');
        die();
    }
    /**
     * Whether there are sub partitions
     *
     * @return bool
     */
    public function hasSubPartitions()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("hasSubPartitions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php at line 66")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called hasSubPartitions:66@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php');
        die();
    }
    /**
     * Returns the number of data rows
     *
     * @return int number of rows
     */
    public function getRows()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getRows") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php at line 75")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getRows:75@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php');
        die();
    }
    /**
     * Returns the total data length
     *
     * @return int data length
     */
    public function getDataLength()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDataLength") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php at line 91")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDataLength:91@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php');
        die();
    }
    /**
     * Returns the total index length
     *
     * @return int index length
     */
    public function getIndexLength()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getIndexLength") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php at line 107")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getIndexLength:107@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php');
        die();
    }
    /**
     * Returns the list of sub partitions
     *
     * @return SubPartition[]
     */
    public function getSubPartitions()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getSubPartitions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php at line 123")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getSubPartitions:123@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php');
        die();
    }
    /**
     * Returns array of partitions for a specific db/table
     *
     * @param string $db    database name
     * @param string $table table name
     *
     * @return Partition[]
     *
     * @access public
     */
    public static function getPartitions($db, $table)
    {
        global $dbi;
        if (self::havePartitioning()) {
            $result = $dbi->fetchResult('SELECT * FROM `information_schema`.`PARTITIONS`' . " WHERE `TABLE_SCHEMA` = '" . $dbi->escapeString($db) . "' AND `TABLE_NAME` = '" . $dbi->escapeString($table) . "'");
            if ($result) {
                $partitionMap = [];
                /** @var array $row */
                foreach ($result as $row) {
                    if (isset($partitionMap[$row['PARTITION_NAME']])) {
                        $partition = $partitionMap[$row['PARTITION_NAME']];
                    } else {
                        $partition = new Partition($row);
                        $partitionMap[$row['PARTITION_NAME']] = $partition;
                    }
                    if (empty($row['SUBPARTITION_NAME'])) {
                        continue;
                    }
                    $parentPartition = $partition;
                    $partition = new SubPartition($row);
                    $parentPartition->addSubPartition($partition);
                }
                return array_values($partitionMap);
            }
            return [];
        }
        return [];
    }
    /**
     * returns array of partition names for a specific db/table
     *
     * @param string $db    database name
     * @param string $table table name
     *
     * @return array   of partition names
     *
     * @access public
     */
    public static function getPartitionNames($db, $table)
    {
        global $dbi;
        if (self::havePartitioning()) {
            return $dbi->fetchResult('SELECT DISTINCT `PARTITION_NAME` FROM `information_schema`.`PARTITIONS`' . " WHERE `TABLE_SCHEMA` = '" . $dbi->escapeString($db) . "' AND `TABLE_NAME` = '" . $dbi->escapeString($table) . "'");
        }
        return [];
    }
    /**
     * returns the partition method used by the table.
     *
     * @param string $db    database name
     * @param string $table table name
     *
     * @return string|null partition method
     */
    public static function getPartitionMethod($db, $table)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPartitionMethod") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php at line 191")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPartitionMethod:191@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Partition.php');
        die();
    }
    /**
     * checks if MySQL server supports partitioning
     *
     * @return bool
     *
     * @static
     * @staticvar boolean $have_partitioning
     * @staticvar boolean $already_checked
     * @access public
     */
    public static function havePartitioning()
    {
        global $dbi;
        static $have_partitioning = false;
        static $already_checked = false;
        if (!$already_checked) {
            if ($dbi->getVersion() < 50600) {
                if ($dbi->fetchValue('SELECT @@have_partitioning;')) {
                    $have_partitioning = true;
                }
            } elseif ($dbi->getVersion() >= 80000) {
                $have_partitioning = true;
            } else {
                // see https://dev.mysql.com/doc/refman/5.6/en/partitioning.html
                $plugins = $dbi->fetchResult('SHOW PLUGINS');
                foreach ($plugins as $value) {
                    if ($value['Name'] === 'partition') {
                        $have_partitioning = true;
                        break;
                    }
                }
            }
            $already_checked = true;
        }
        return $have_partitioning;
    }
}