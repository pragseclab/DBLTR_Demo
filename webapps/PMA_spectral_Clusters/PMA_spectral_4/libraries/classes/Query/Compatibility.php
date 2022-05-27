<?php

declare (strict_types=1);
namespace PhpMyAdmin\Query;

use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Util;
use function is_string;
use function strlen;
use function strpos;
use function strtoupper;
use function substr;
/**
 * Handles data compatibility from SQL query results
 */
class Compatibility
{
    public static function getISCompatForGetTablesFull(array $eachTables, string $eachDatabase) : array
    {
        foreach ($eachTables as $table_name => $_) {
            if (!isset($eachTables[$table_name]['Type']) && isset($eachTables[$table_name]['Engine'])) {
                // pma BC, same parts of PMA still uses 'Type'
                $eachTables[$table_name]['Type'] =& $eachTables[$table_name]['Engine'];
            } elseif (!isset($eachTables[$table_name]['Engine']) && isset($eachTables[$table_name]['Type'])) {
                // old MySQL reports Type, newer MySQL reports Engine
                $eachTables[$table_name]['Engine'] =& $eachTables[$table_name]['Type'];
            }
            // Compatibility with INFORMATION_SCHEMA output
            $eachTables[$table_name]['TABLE_SCHEMA'] = $eachDatabase;
            $eachTables[$table_name]['TABLE_NAME'] =& $eachTables[$table_name]['Name'];
            $eachTables[$table_name]['ENGINE'] =& $eachTables[$table_name]['Engine'];
            $eachTables[$table_name]['VERSION'] =& $eachTables[$table_name]['Version'];
            $eachTables[$table_name]['ROW_FORMAT'] =& $eachTables[$table_name]['Row_format'];
            $eachTables[$table_name]['TABLE_ROWS'] =& $eachTables[$table_name]['Rows'];
            $eachTables[$table_name]['AVG_ROW_LENGTH'] =& $eachTables[$table_name]['Avg_row_length'];
            $eachTables[$table_name]['DATA_LENGTH'] =& $eachTables[$table_name]['Data_length'];
            $eachTables[$table_name]['MAX_DATA_LENGTH'] =& $eachTables[$table_name]['Max_data_length'];
            $eachTables[$table_name]['INDEX_LENGTH'] =& $eachTables[$table_name]['Index_length'];
            $eachTables[$table_name]['DATA_FREE'] =& $eachTables[$table_name]['Data_free'];
            $eachTables[$table_name]['AUTO_INCREMENT'] =& $eachTables[$table_name]['Auto_increment'];
            $eachTables[$table_name]['CREATE_TIME'] =& $eachTables[$table_name]['Create_time'];
            $eachTables[$table_name]['UPDATE_TIME'] =& $eachTables[$table_name]['Update_time'];
            $eachTables[$table_name]['CHECK_TIME'] =& $eachTables[$table_name]['Check_time'];
            $eachTables[$table_name]['TABLE_COLLATION'] =& $eachTables[$table_name]['Collation'];
            $eachTables[$table_name]['CHECKSUM'] =& $eachTables[$table_name]['Checksum'];
            $eachTables[$table_name]['CREATE_OPTIONS'] =& $eachTables[$table_name]['Create_options'];
            $eachTables[$table_name]['TABLE_COMMENT'] =& $eachTables[$table_name]['Comment'];
            if (strtoupper($eachTables[$table_name]['Comment'] ?? '') === 'VIEW' && $eachTables[$table_name]['Engine'] == null) {
                $eachTables[$table_name]['TABLE_TYPE'] = 'VIEW';
            } elseif ($eachDatabase === 'information_schema') {
                $eachTables[$table_name]['TABLE_TYPE'] = 'SYSTEM VIEW';
            } else {
                /**
                 * @todo difference between 'TEMPORARY' and 'BASE TABLE'
                 * but how to detect?
                 */
                $eachTables[$table_name]['TABLE_TYPE'] = 'BASE TABLE';
            }
        }
        return $eachTables;
    }
    public static function getISCompatForGetColumnsFull(array $columns, string $database, string $table) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getISCompatForGetColumnsFull") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Query/Compatibility.php at line 64")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getISCompatForGetColumnsFull:64@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Query/Compatibility.php');
        die();
    }
    public static function isMySqlOrPerconaDb() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isMySqlOrPerconaDb") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Query/Compatibility.php at line 106")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isMySqlOrPerconaDb:106@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Query/Compatibility.php');
        die();
    }
    public static function isMariaDb() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isMariaDb") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Query/Compatibility.php at line 111")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isMariaDb:111@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Query/Compatibility.php');
        die();
    }
    public static function isCompatibleRenameIndex(int $serverVersion) : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isCompatibleRenameIndex") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Query/Compatibility.php at line 116")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isCompatibleRenameIndex:116@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Query/Compatibility.php');
        die();
    }
    public static function supportsReferencesPrivilege(DatabaseInterface $dbi) : bool
    {
        // See: https://mariadb.com/kb/en/grant/#table-privileges
        // Unused
        if ($dbi->isMariaDB()) {
            return false;
        }
        // https://dev.mysql.com/doc/refman/5.6/en/privileges-provided.html#priv_references
        // This privilege is unused before MySQL 5.6.22.
        // As of 5.6.22, creation of a foreign key constraint
        // requires at least one of the SELECT, INSERT, UPDATE, DELETE,
        // or REFERENCES privileges for the parent table.
        return $dbi->getVersion() >= 50622;
    }
}