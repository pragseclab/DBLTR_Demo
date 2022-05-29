<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Interface to the improved MySQL extension (MySQLi)
 *
 * @package    PhpMyAdmin-DBI
 * @subpackage MySQLi
 */
namespace PMA\libraries\dbi;

use PMA\libraries\DatabaseInterface;
if (!defined('PHPMYADMIN')) {
    exit;
}
require_once 'libraries/dbi/DBIExtension.lib.php';
/**
 * MySQL client API
 */
PMA_defineClientAPI(mysqli_get_client_info());
/**
 * some PHP versions are reporting extra messages like "No index used in query"
 */
mysqli_report(MYSQLI_REPORT_OFF);
/**
 * some older mysql client libs are missing these constants ...
 */
if (!defined('MYSQLI_BINARY_FLAG')) {
    define('MYSQLI_BINARY_FLAG', 128);
}
/**
 * @see https://bugs.php.net/36007
 */
if (!defined('MYSQLI_TYPE_NEWDECIMAL')) {
    define('MYSQLI_TYPE_NEWDECIMAL', 246);
}
if (!defined('MYSQLI_TYPE_BIT')) {
    define('MYSQLI_TYPE_BIT', 16);
}
if (!defined('MYSQLI_TYPE_JSON')) {
    define('MYSQLI_TYPE_JSON', 245);
}
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Interface to the improved MySQL extension (MySQLi)
 *
 * @package    PhpMyAdmin-DBI
 * @subpackage MySQLi
 */
class DBIMysqli implements DBIExtension
{
    /**
     * connects to the database server
     *
     * @param string $user     mysql user name
     * @param string $password mysql user password
     * @param array  $server   host/port/socket/persistent
     *
     * @return mixed false on error or a mysqli object on success
     */
    public function connect($user, $password, $server)
    {
        if ($server) {
            $server['host'] = empty($server['host']) ? 'localhost' : $server['host'];
        }
        // NULL enables connection to the default socket
        $link = mysqli_init();
        if (defined('PMA_ENABLE_LDI')) {
            mysqli_options($link, MYSQLI_OPT_LOCAL_INFILE, true);
        } else {
            mysqli_options($link, MYSQLI_OPT_LOCAL_INFILE, false);
        }
        $client_flags = 0;
        /* Optionally compress connection */
        if ($server['compress'] && defined('MYSQLI_CLIENT_COMPRESS')) {
            $client_flags |= MYSQLI_CLIENT_COMPRESS;
        }
        /* Optionally enable SSL */
        if ($server['ssl']) {
            $client_flags |= MYSQLI_CLIENT_SSL;
            if (!is_null($server['ssl_key']) || !is_null($server['ssl_cert']) || !is_null($server['ssl_ca']) || !is_null($server['ssl_ca_path']) || !is_null($server['ssl_ciphers'])) {
                mysqli_ssl_set($link, $server['ssl_key'], $server['ssl_cert'], $server['ssl_ca'], $server['ssl_ca_path'], $server['ssl_ciphers']);
            }
            /*
             * disables SSL certificate validation on mysqlnd for MySQL 5.6 or later
             * @link https://bugs.php.net/bug.php?id=68344
             * @link https://github.com/phpmyadmin/phpmyadmin/pull/11838
             */
            if (!$server['ssl_verify']) {
                mysqli_options($link, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, $server['ssl_verify']);
                $client_flags |= MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT;
            }
        }
        if ($GLOBALS['cfg']['PersistentConnections']) {
            $host = 'p:' . $server['host'];
        } else {
            $host = $server['host'];
        }
        $return_value = mysqli_real_connect($link, $host, $user, $password, '', $server['port'], $server['socket'], $client_flags);
        if ($return_value === false || is_null($return_value)) {
            return false;
        }
        return $link;
    }
    /**
     * selects given database
     *
     * @param string $dbname database name to select
     * @param mysqli $link   the mysqli object
     *
     * @return boolean
     */
    public function selectDb($dbname, $link)
    {
        return mysqli_select_db($link, $dbname);
    }
    /**
     * runs a query and returns the result
     *
     * @param string $query   query to execute
     * @param mysqli $link    mysqli object
     * @param int    $options query options
     *
     * @return mysqli_result|bool
     */
    public function realQuery($query, $link, $options)
    {
        if ($options == ($options | DatabaseInterface::QUERY_STORE)) {
            $method = MYSQLI_STORE_RESULT;
        } elseif ($options == ($options | DatabaseInterface::QUERY_UNBUFFERED)) {
            $method = MYSQLI_USE_RESULT;
        } else {
            $method = 0;
        }
        return mysqli_query($link, $query, $method);
    }
    /**
     * Run the multi query and output the results
     *
     * @param mysqli $link  mysqli object
     * @param string $query multi query statement to execute
     *
     * @return mysqli_result collection | boolean(false)
     */
    public function realMultiQuery($link, $query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("realMultiQuery") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called realMultiQuery:197@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
        die();
    }
    /**
     * returns array of rows with associative and numeric keys from $result
     *
     * @param mysqli_result $result result set identifier
     *
     * @return array
     */
    public function fetchArray($result)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fetchArray") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 209")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fetchArray:209@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
        die();
    }
    /**
     * returns array of rows with associative keys from $result
     *
     * @param mysqli_result $result result set identifier
     *
     * @return array
     */
    public function fetchAssoc($result)
    {
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
    /**
     * returns array of rows with numeric keys from $result
     *
     * @param mysqli_result $result result set identifier
     *
     * @return array
     */
    public function fetchRow($result)
    {
        return mysqli_fetch_array($result, MYSQLI_NUM);
    }
    /**
     * Adjusts the result pointer to an arbitrary row in the result
     *
     * @param mysqli_result $result database result
     * @param integer       $offset offset to seek
     *
     * @return bool true on success, false on failure
     */
    public function dataSeek($result, $offset)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("dataSeek") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 246")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called dataSeek:246@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
        die();
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
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
        }
    }
    /**
     * Check if there are any more query results from a multi query
     *
     * @param mysqli $link the mysqli object
     *
     * @return bool true or false
     */
    public function moreResults($link)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("moreResults") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 272")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called moreResults:272@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
        die();
    }
    /**
     * Prepare next result from multi_query
     *
     * @param mysqli $link the mysqli object
     *
     * @return bool true or false
     */
    public function nextResult($link)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("nextResult") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 284")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called nextResult:284@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
        die();
    }
    /**
     * Store the result returned from multi query
     *
     * @param mysqli $link the mysqli object
     *
     * @return mixed false when empty results / result set when not empty
     */
    public function storeResult($link)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("storeResult") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 296")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called storeResult:296@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
        die();
    }
    /**
     * Returns a string representing the type of connection used
     *
     * @param resource $link mysql link
     *
     * @return string type of connection used
     */
    public function getHostInfo($link)
    {
        return mysqli_get_host_info($link);
    }
    /**
     * Returns the version of the MySQL protocol used
     *
     * @param resource $link mysql link
     *
     * @return integer version of the MySQL protocol used
     */
    public function getProtoInfo($link)
    {
        return mysqli_get_proto_info($link);
    }
    /**
     * returns a string that represents the client library version
     *
     * @return string MySQL client library version
     */
    public function getClientInfo()
    {
        return mysqli_get_client_info();
    }
    /**
     * returns last error message or false if no errors occurred
     *
     * @param resource $link mysql link
     *
     * @return string|bool $error or false
     */
    public function getError($link)
    {
        $GLOBALS['errno'] = 0;
        if (null !== $link && false !== $link) {
            $error_number = mysqli_errno($link);
            $error_message = mysqli_error($link);
        } else {
            $error_number = mysqli_connect_errno();
            $error_message = mysqli_connect_error();
        }
        if (0 == $error_number) {
            return false;
        }
        // keep the error number for further check after
        // the call to getError()
        $GLOBALS['errno'] = $error_number;
        return $GLOBALS['dbi']->formatError($error_number, $error_message);
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
        return @mysqli_num_rows($result);
    }
    /**
     * returns the number of rows affected by last query
     *
     * @param mysqli $link the mysqli object
     *
     * @return int
     */
    public function affectedRows($link)
    {
        return mysqli_affected_rows($link);
    }
    /**
     * returns metainfo for fields in $result
     *
     * @param mysqli_result $result result set identifier
     *
     * @return array meta info for fields in $result
     */
    public function getFieldsMeta($result)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFieldsMeta") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 401")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFieldsMeta:401@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
        die();
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
        return mysqli_num_fields($result);
    }
    /**
     * returns the length of the given field $i in $result
     *
     * @param mysqli_result $result result set identifier
     * @param int           $i      field
     *
     * @return int length of field
     */
    public function fieldLen($result, $i)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fieldLen") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 494")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fieldLen:494@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fieldName") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 507")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fieldName:507@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
        die();
    }
    /**
     * returns concatenated string of human readable field flags
     *
     * @param mysqli_result $result result set identifier
     * @param int           $i      field
     *
     * @return string field flags
     */
    public function fieldFlags($result, $i)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fieldFlags") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php at line 520")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fieldFlags:520@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/dbi/DBIMysqli.php');
        die();
    }
    /**
     * returns properly escaped string for use in MySQL queries
     *
     * @param mixed  $link database link
     * @param string $str  string to be escaped
     *
     * @return string a MySQL escaped string
     */
    public function escapeString($link, $str)
    {
        return mysqli_real_escape_string($link, $str);
    }
}