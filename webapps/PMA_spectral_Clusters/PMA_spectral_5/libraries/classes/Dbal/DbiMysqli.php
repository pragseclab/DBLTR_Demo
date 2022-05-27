<?php

/**
 * Interface to the MySQL Improved extension (MySQLi)
 */
declare (strict_types=1);
namespace PhpMyAdmin\Dbal;

use mysqli;
use mysqli_result;
use mysqli_stmt;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Query\Utilities;
use stdClass;
use function mysqli_report;
use const E_USER_WARNING;
use const MYSQLI_ASSOC;
use const MYSQLI_AUTO_INCREMENT_FLAG;
use const MYSQLI_BLOB_FLAG;
use const MYSQLI_BOTH;
use const MYSQLI_CLIENT_COMPRESS;
use const MYSQLI_CLIENT_SSL;
use const MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT;
use const MYSQLI_ENUM_FLAG;
use const MYSQLI_MULTIPLE_KEY_FLAG;
use const MYSQLI_NOT_NULL_FLAG;
use const MYSQLI_NUM;
use const MYSQLI_NUM_FLAG;
use const MYSQLI_OPT_LOCAL_INFILE;
use const MYSQLI_OPT_SSL_VERIFY_SERVER_CERT;
use const MYSQLI_PART_KEY_FLAG;
use const MYSQLI_PRI_KEY_FLAG;
use const MYSQLI_REPORT_OFF;
use const MYSQLI_SET_FLAG;
use const MYSQLI_STORE_RESULT;
use const MYSQLI_TIMESTAMP_FLAG;
use const MYSQLI_TYPE_BIT;
use const MYSQLI_TYPE_BLOB;
use const MYSQLI_TYPE_DATE;
use const MYSQLI_TYPE_DATETIME;
use const MYSQLI_TYPE_DECIMAL;
use const MYSQLI_TYPE_DOUBLE;
use const MYSQLI_TYPE_ENUM;
use const MYSQLI_TYPE_FLOAT;
use const MYSQLI_TYPE_GEOMETRY;
use const MYSQLI_TYPE_INT24;
use const MYSQLI_TYPE_JSON;
use const MYSQLI_TYPE_LONG;
use const MYSQLI_TYPE_LONG_BLOB;
use const MYSQLI_TYPE_LONGLONG;
use const MYSQLI_TYPE_MEDIUM_BLOB;
use const MYSQLI_TYPE_NEWDATE;
use const MYSQLI_TYPE_NEWDECIMAL;
use const MYSQLI_TYPE_NULL;
use const MYSQLI_TYPE_SET;
use const MYSQLI_TYPE_SHORT;
use const MYSQLI_TYPE_STRING;
use const MYSQLI_TYPE_TIME;
use const MYSQLI_TYPE_TIMESTAMP;
use const MYSQLI_TYPE_TINY;
use const MYSQLI_TYPE_TINY_BLOB;
use const MYSQLI_TYPE_VAR_STRING;
use const MYSQLI_TYPE_YEAR;
use const MYSQLI_UNIQUE_KEY_FLAG;
use const MYSQLI_UNSIGNED_FLAG;
use const MYSQLI_USE_RESULT;
use const MYSQLI_ZEROFILL_FLAG;
use function define;
use function defined;
use function implode;
use function is_array;
use function is_bool;
use function mysqli_init;
use function stripos;
use function trigger_error;
/**
 * Interface to the MySQL Improved extension (MySQLi)
 */
class DbiMysqli implements DbiExtension
{
    /** @var array */
    private static $flagNames = [MYSQLI_NUM_FLAG => 'num', MYSQLI_PART_KEY_FLAG => 'part_key', MYSQLI_SET_FLAG => 'set', MYSQLI_TIMESTAMP_FLAG => 'timestamp', MYSQLI_AUTO_INCREMENT_FLAG => 'auto_increment', MYSQLI_ENUM_FLAG => 'enum', MYSQLI_ZEROFILL_FLAG => 'zerofill', MYSQLI_UNSIGNED_FLAG => 'unsigned', MYSQLI_BLOB_FLAG => 'blob', MYSQLI_MULTIPLE_KEY_FLAG => 'multiple_key', MYSQLI_UNIQUE_KEY_FLAG => 'unique_key', MYSQLI_PRI_KEY_FLAG => 'primary_key', MYSQLI_NOT_NULL_FLAG => 'not_null'];
    /**
     * connects to the database server
     *
     * @param string $user     mysql user name
     * @param string $password mysql user password
     * @param array  $server   host/port/socket/persistent
     *
     * @return mysqli|bool false on error or a mysqli object on success
     */
    public function connect($user, $password, array $server)
    {
        if ($server) {
            $server['host'] = empty($server['host']) ? 'localhost' : $server['host'];
        }
        mysqli_report(MYSQLI_REPORT_OFF);
        $mysqli = mysqli_init();
        $client_flags = 0;
        /* Optionally compress connection */
        if ($server['compress'] && defined('MYSQLI_CLIENT_COMPRESS')) {
            $client_flags |= MYSQLI_CLIENT_COMPRESS;
        }
        /* Optionally enable SSL */
        if ($server['ssl']) {
            $client_flags |= MYSQLI_CLIENT_SSL;
            if (!empty($server['ssl_key']) || !empty($server['ssl_cert']) || !empty($server['ssl_ca']) || !empty($server['ssl_ca_path']) || !empty($server['ssl_ciphers'])) {
                $mysqli->ssl_set($server['ssl_key'] ?? '', $server['ssl_cert'] ?? '', $server['ssl_ca'] ?? '', $server['ssl_ca_path'] ?? '', $server['ssl_ciphers'] ?? '');
            }
            /*
             * disables SSL certificate validation on mysqlnd for MySQL 5.6 or later
             * @link https://bugs.php.net/bug.php?id=68344
             * @link https://github.com/phpmyadmin/phpmyadmin/pull/11838
             */
            if (!$server['ssl_verify']) {
                $mysqli->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, $server['ssl_verify']);
                $client_flags |= MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT;
            }
        }
        if ($GLOBALS['cfg']['PersistentConnections']) {
            $host = 'p:' . $server['host'];
        } else {
            $host = $server['host'];
        }
        $return_value = $mysqli->real_connect($host, $user, $password, '', $server['port'], (string) $server['socket'], $client_flags);
        if ($return_value === false || $return_value === null) {
            /*
             * Switch to SSL if server asked us to do so, unfortunately
             * there are more ways MySQL server can tell this:
             *
             * - MySQL 8.0 and newer should return error 3159
             * - #2001 - SSL Connection is required. Please specify SSL options and retry.
             * - #9002 - SSL connection is required. Please specify SSL options and retry.
             */
            $error_number = $mysqli->connect_errno;
            $error_message = $mysqli->connect_error;
            if (!$server['ssl'] && ($error_number == 3159 || ($error_number == 2001 || $error_number == 9002) && stripos($error_message, 'SSL Connection is required') !== false)) {
                trigger_error(__('SSL connection enforced by server, automatically enabling it.'), E_USER_WARNING);
                $server['ssl'] = true;
                return self::connect($user, $password, $server);
            }
            return false;
        }
        if (defined('PMA_ENABLE_LDI')) {
            $mysqli->options(MYSQLI_OPT_LOCAL_INFILE, true);
        } else {
            $mysqli->options(MYSQLI_OPT_LOCAL_INFILE, false);
        }
        return $mysqli;
    }
    /**
     * selects given database
     *
     * @param string $databaseName database name to select
     * @param mysqli $mysqli       the mysqli object
     *
     * @return bool
     */
    public function selectDb($databaseName, $mysqli)
    {
        return $mysqli->select_db($databaseName);
    }
    /**
     * runs a query and returns the result
     *
     * @param string $query   query to execute
     * @param mysqli $mysqli  mysqli object
     * @param int    $options query options
     *
     * @return mysqli_result|bool
     */
    public function realQuery($query, $mysqli, $options)
    {
        if ($options == ($options | DatabaseInterface::QUERY_STORE)) {
            $method = MYSQLI_STORE_RESULT;
        } elseif ($options == ($options | DatabaseInterface::QUERY_UNBUFFERED)) {
            $method = MYSQLI_USE_RESULT;
        } else {
            $method = 0;
        }
        return $mysqli->query($query, $method);
    }
    /**
     * Run the multi query and output the results
     *
     * @param mysqli $mysqli mysqli object
     * @param string $query  multi query statement to execute
     *
     * @return bool
     */
    public function realMultiQuery($mysqli, $query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("realMultiQuery") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php at line 193")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called realMultiQuery:193@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php');
        die();
    }
    /**
     * returns array of rows with associative and numeric keys from $result
     *
     * @param mysqli_result $result result set identifier
     */
    public function fetchArray($result) : ?array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fetchArray") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php at line 202")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fetchArray:202@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php');
        die();
    }
    /**
     * returns array of rows with associative keys from $result
     *
     * @param mysqli_result $result result set identifier
     */
    public function fetchAssoc($result) : ?array
    {
        if (!$result instanceof mysqli_result) {
            return null;
        }
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    /**
     * returns array of rows with numeric keys from $result
     *
     * @param mysqli_result $result result set identifier
     */
    public function fetchRow($result) : ?array
    {
        if (!$result instanceof mysqli_result) {
            return null;
        }
        return $result->fetch_array(MYSQLI_NUM);
    }
    /**
     * Adjusts the result pointer to an arbitrary row in the result
     *
     * @param mysqli_result $result database result
     * @param int           $offset offset to seek
     *
     * @return bool true on success, false on failure
     */
    public function dataSeek($result, $offset)
    {
        return $result->data_seek($offset);
    }
    /**
     * Frees memory associated with the result
     *
     * @param mysqli_result $result database result
     *
     * @return void
     */
    public function freeResult($result)
    {
        if (!$result instanceof mysqli_result) {
            return;
        }
        $result->close();
    }
    /**
     * Check if there are any more query results from a multi query
     *
     * @param mysqli $mysqli the mysqli object
     *
     * @return bool true or false
     */
    public function moreResults($mysqli)
    {
        return $mysqli->more_results();
    }
    /**
     * Prepare next result from multi_query
     *
     * @param mysqli $mysqli the mysqli object
     *
     * @return bool true or false
     */
    public function nextResult($mysqli)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("nextResult") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php at line 277")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called nextResult:277@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php');
        die();
    }
    /**
     * Store the result returned from multi query
     *
     * @param mysqli $mysqli the mysqli object
     *
     * @return mysqli_result|bool false when empty results / result set when not empty
     */
    public function storeResult($mysqli)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("storeResult") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php at line 288")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called storeResult:288@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php');
        die();
    }
    /**
     * Returns a string representing the type of connection used
     *
     * @param mysqli $mysqli mysql link
     *
     * @return string type of connection used
     */
    public function getHostInfo($mysqli)
    {
        return $mysqli->host_info;
    }
    /**
     * Returns the version of the MySQL protocol used
     *
     * @param mysqli $mysqli mysql link
     *
     * @return string version of the MySQL protocol used
     */
    public function getProtoInfo($mysqli)
    {
        return $mysqli->protocol_version;
    }
    /**
     * returns a string that represents the client library version
     *
     * @param mysqli $mysqli mysql link
     *
     * @return string MySQL client library version
     */
    public function getClientInfo($mysqli)
    {
        return $mysqli->get_client_info();
    }
    /**
     * returns last error message or false if no errors occurred
     *
     * @param mysqli $mysqli mysql link
     *
     * @return string|bool error or false
     */
    public function getError($mysqli)
    {
        $GLOBALS['errno'] = 0;
        if ($mysqli !== null && $mysqli !== false) {
            $error_number = $mysqli->errno;
            $error_message = $mysqli->error;
        } else {
            $error_number = $mysqli->connect_errno;
            $error_message = $mysqli->connect_error;
        }
        if ($error_number == 0) {
            return false;
        }
        // keep the error number for further check after
        // the call to getError()
        $GLOBALS['errno'] = $error_number;
        return Utilities::formatError($error_number, $error_message);
    }
    /**
     * returns the number of rows returned by last query
     *
     * @param mysqli_result $result result set identifier
     *
     * @return string|int
     */
    public function numRows($result)
    {
        // see the note for tryQuery();
        if (is_bool($result)) {
            return 0;
        }
        return $result->num_rows;
    }
    /**
     * returns the number of rows affected by last query
     *
     * @param mysqli $mysqli the mysqli object
     *
     * @return int
     */
    public function affectedRows($mysqli)
    {
        return $mysqli->affected_rows;
    }
    /**
     * returns meta info for fields in $result
     *
     * @param mysqli_result $result result set identifier
     *
     * @return array|bool meta info for fields in $result
     */
    public function getFieldsMeta($result)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        // Issue #16043 - client API mysqlnd seem not to have MYSQLI_TYPE_JSON defined
        if (!defined('MYSQLI_TYPE_JSON')) {
            define('MYSQLI_TYPE_JSON', 245);
        }
        // Build an associative array for a type look up
        $typeAr = [];
        $typeAr[MYSQLI_TYPE_DECIMAL] = 'real';
        $typeAr[MYSQLI_TYPE_NEWDECIMAL] = 'real';
        $typeAr[MYSQLI_TYPE_BIT] = 'int';
        $typeAr[MYSQLI_TYPE_TINY] = 'int';
        $typeAr[MYSQLI_TYPE_SHORT] = 'int';
        $typeAr[MYSQLI_TYPE_LONG] = 'int';
        $typeAr[MYSQLI_TYPE_FLOAT] = 'real';
        $typeAr[MYSQLI_TYPE_DOUBLE] = 'real';
        $typeAr[MYSQLI_TYPE_NULL] = 'null';
        $typeAr[MYSQLI_TYPE_TIMESTAMP] = 'timestamp';
        $typeAr[MYSQLI_TYPE_LONGLONG] = 'int';
        $typeAr[MYSQLI_TYPE_INT24] = 'int';
        $typeAr[MYSQLI_TYPE_DATE] = 'date';
        $typeAr[MYSQLI_TYPE_TIME] = 'time';
        $typeAr[MYSQLI_TYPE_DATETIME] = 'datetime';
        $typeAr[MYSQLI_TYPE_YEAR] = 'year';
        $typeAr[MYSQLI_TYPE_NEWDATE] = 'date';
        $typeAr[MYSQLI_TYPE_ENUM] = 'unknown';
        $typeAr[MYSQLI_TYPE_SET] = 'unknown';
        $typeAr[MYSQLI_TYPE_TINY_BLOB] = 'blob';
        $typeAr[MYSQLI_TYPE_MEDIUM_BLOB] = 'blob';
        $typeAr[MYSQLI_TYPE_LONG_BLOB] = 'blob';
        $typeAr[MYSQLI_TYPE_BLOB] = 'blob';
        $typeAr[MYSQLI_TYPE_VAR_STRING] = 'string';
        $typeAr[MYSQLI_TYPE_STRING] = 'string';
        // MySQL returns MYSQLI_TYPE_STRING for CHAR
        // and MYSQLI_TYPE_CHAR === MYSQLI_TYPE_TINY
        // so this would override TINYINT and mark all TINYINT as string
        // see https://github.com/phpmyadmin/phpmyadmin/issues/8569
        //$typeAr[MYSQLI_TYPE_CHAR]        = 'string';
        $typeAr[MYSQLI_TYPE_GEOMETRY] = 'geometry';
        $typeAr[MYSQLI_TYPE_BIT] = 'bit';
        $typeAr[MYSQLI_TYPE_JSON] = 'json';
        $fields = $result->fetch_fields();
        if (!is_array($fields)) {
            return false;
        }
        foreach ($fields as $k => $field) {
            $fields[$k]->_type = $field->type;
            $fields[$k]->type = $typeAr[$field->type];
            $fields[$k]->_flags = $field->flags;
            $fields[$k]->flags = $this->fieldFlags($result, $k);
            // Enhance the field objects for mysql-extension compatibility
            //$flags = explode(' ', $fields[$k]->flags);
            //array_unshift($flags, 'dummy');
            $fields[$k]->multiple_key = (int) (bool) ($fields[$k]->_flags & MYSQLI_MULTIPLE_KEY_FLAG);
            $fields[$k]->primary_key = (int) (bool) ($fields[$k]->_flags & MYSQLI_PRI_KEY_FLAG);
            $fields[$k]->unique_key = (int) (bool) ($fields[$k]->_flags & MYSQLI_UNIQUE_KEY_FLAG);
            $fields[$k]->not_null = (int) (bool) ($fields[$k]->_flags & MYSQLI_NOT_NULL_FLAG);
            $fields[$k]->unsigned = (int) (bool) ($fields[$k]->_flags & MYSQLI_UNSIGNED_FLAG);
            $fields[$k]->zerofill = (int) (bool) ($fields[$k]->_flags & MYSQLI_ZEROFILL_FLAG);
            $fields[$k]->numeric = (int) (bool) ($fields[$k]->_flags & MYSQLI_NUM_FLAG);
            $fields[$k]->blob = (int) (bool) ($fields[$k]->_flags & MYSQLI_BLOB_FLAG);
        }
        return $fields;
    }
    /**
     * return number of fields in given $result
     *
     * @param mysqli_result $result result set identifier
     *
     * @return int field count
     */
    public function numFields($result)
    {
        return $result->field_count;
    }
    /**
     * returns the length of the given field $i in $result
     *
     * @param mysqli_result $result result set identifier
     * @param int           $i      field
     *
     * @return int|bool length of field
     */
    public function fieldLen($result, $i)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fieldLen") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php at line 469")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fieldLen:469@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php');
        die();
    }
    /**
     * returns name of $i. field in $result
     *
     * @param mysqli_result $result result set identifier
     * @param int           $i      field
     *
     * @return string name of $i. field in $result
     */
    public function fieldName($result, $i)
    {
        if ($i >= $this->numFields($result)) {
            return '';
        }
        /** @var stdClass $fieldDefinition */
        $fieldDefinition = $result->fetch_field_direct($i);
        if ($fieldDefinition !== false) {
            return $fieldDefinition->name;
        }
        return '';
    }
    /**
     * returns concatenated string of human readable field flags
     *
     * @param mysqli_result $result result set identifier
     * @param int           $i      field
     *
     * @return string|false field flags
     */
    public function fieldFlags($result, $i)
    {
        if ($i >= $this->numFields($result)) {
            return false;
        }
        /** @var stdClass|false $fieldDefinition */
        $fieldDefinition = $result->fetch_field_direct($i);
        if ($fieldDefinition === false) {
            return '';
        }
        $type = $fieldDefinition->type;
        $charsetNumber = $fieldDefinition->charsetnr;
        $fieldDefinitionFlags = $fieldDefinition->flags;
        $flags = [];
        foreach (self::$flagNames as $flag => $name) {
            if (!($fieldDefinitionFlags & $flag)) {
                continue;
            }
            $flags[] = $name;
        }
        // See https://dev.mysql.com/doc/refman/6.0/en/c-api-datatypes.html:
        // to determine if a string is binary, we should not use MYSQLI_BINARY_FLAG
        // but instead the charsetnr member of the MYSQL_FIELD
        // structure. Watch out: some types like DATE returns 63 in charsetnr
        // so we have to check also the type.
        // Unfortunately there is no equivalent in the mysql extension.
        if (($type == MYSQLI_TYPE_TINY_BLOB || $type == MYSQLI_TYPE_BLOB || $type == MYSQLI_TYPE_MEDIUM_BLOB || $type == MYSQLI_TYPE_LONG_BLOB || $type == MYSQLI_TYPE_VAR_STRING || $type == MYSQLI_TYPE_STRING) && $charsetNumber == 63) {
            $flags[] = 'binary';
        }
        return implode(' ', $flags);
    }
    /**
     * returns properly escaped string for use in MySQL queries
     *
     * @param mysqli $mysqli database link
     * @param string $string string to be escaped
     *
     * @return string a MySQL escaped string
     */
    public function escapeString($mysqli, $string)
    {
        return $mysqli->real_escape_string($string);
    }
    /**
     * Prepare an SQL statement for execution.
     *
     * @param mysqli $mysqli database link
     * @param string $query  The query, as a string.
     *
     * @return mysqli_stmt|false A statement object or false.
     */
    public function prepare($mysqli, string $query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php at line 560")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare:560@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Dbal/DbiMysqli.php');
        die();
    }
}