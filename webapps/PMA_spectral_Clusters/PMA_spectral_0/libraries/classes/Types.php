<?php

/**
 * SQL data types definition
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use function array_diff;
use function array_merge;
use function array_push;
use function htmlspecialchars;
use function in_array;
use function mb_strtoupper;
use function sort;
use function sprintf;
use function strncasecmp;
/**
 * Class holding type definitions for MySQL and MariaDB.
 */
class Types
{
    /** @var DatabaseInterface Database interface */
    private $dbi;
    /**
     * @param DatabaseInterface $dbi Database interface instance
     */
    public function __construct($dbi)
    {
        $this->dbi = $dbi;
    }
    /**
     * Returns list of unary operators.
     *
     * @return string[]
     */
    public function getUnaryOperators()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getUnaryOperators") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 39")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getUnaryOperators:39@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Check whether operator is unary.
     *
     * @param string $op operator name
     *
     * @return bool
     */
    public function isUnaryOperator($op)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isUnaryOperator") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 50")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isUnaryOperator:50@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Returns list of operators checking for NULL.
     *
     * @return string[]
     */
    public function getNullOperators()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getNullOperators") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 59")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getNullOperators:59@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * ENUM search operators
     *
     * @return string[]
     */
    public function getEnumOperators()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEnumOperators") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 68")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getEnumOperators:68@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * TEXT search operators
     *
     * @return string[]
     */
    public function getTextOperators()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTextOperators") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 77")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTextOperators:77@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Number search operators
     *
     * @return string[]
     */
    public function getNumberOperators()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getNumberOperators") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 86")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getNumberOperators:86@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Returns operators for given type
     *
     * @param string $type Type of field
     * @param bool   $null Whether field can be NULL
     *
     * @return string[]
     */
    public function getTypeOperators($type, $null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTypeOperators") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 98")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTypeOperators:98@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Returns operators for given type as html options
     *
     * @param string $type             Type of field
     * @param bool   $null             Whether field can be NULL
     * @param string $selectedOperator Option to be selected
     *
     * @return string Generated Html
     */
    public function getTypeOperatorsHtml($type, $null, $selectedOperator = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTypeOperatorsHtml") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 123")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTypeOperatorsHtml:123@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Returns the data type description.
     *
     * @param string $type The data type to get a description.
     *
     * @return string
     */
    public function getTypeDescription($type)
    {
        $type = mb_strtoupper($type);
        switch ($type) {
            case 'TINYINT':
                return __('A 1-byte integer, signed range is -128 to 127, unsigned range is ' . '0 to 255');
            case 'SMALLINT':
                return __('A 2-byte integer, signed range is -32,768 to 32,767, unsigned ' . 'range is 0 to 65,535');
            case 'MEDIUMINT':
                return __('A 3-byte integer, signed range is -8,388,608 to 8,388,607, ' . 'unsigned range is 0 to 16,777,215');
            case 'INT':
                return __('A 4-byte integer, signed range is ' . '-2,147,483,648 to 2,147,483,647, unsigned range is 0 to ' . '4,294,967,295');
            case 'BIGINT':
                return __('An 8-byte integer, signed range is -9,223,372,036,854,775,808 ' . 'to 9,223,372,036,854,775,807, unsigned range is 0 to ' . '18,446,744,073,709,551,615');
            case 'DECIMAL':
                return __('A fixed-point number (M, D) - the maximum number of digits (M) ' . 'is 65 (default 10), the maximum number of decimals (D) is 30 ' . '(default 0)');
            case 'FLOAT':
                return __('A small floating-point number, allowable values are ' . '-3.402823466E+38 to -1.175494351E-38, 0, and 1.175494351E-38 to ' . '3.402823466E+38');
            case 'DOUBLE':
                return __('A double-precision floating-point number, allowable values are ' . '-1.7976931348623157E+308 to -2.2250738585072014E-308, 0, and ' . '2.2250738585072014E-308 to 1.7976931348623157E+308');
            case 'REAL':
                return __('Synonym for DOUBLE (exception: in REAL_AS_FLOAT SQL mode it is ' . 'a synonym for FLOAT)');
            case 'BIT':
                return __('A bit-field type (M), storing M of bits per value (default is 1, ' . 'maximum is 64)');
            case 'BOOLEAN':
                return __('A synonym for TINYINT(1), a value of zero is considered false, ' . 'nonzero values are considered true');
            case 'SERIAL':
                return __('An alias for BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE');
            case 'DATE':
                return sprintf(__('A date, supported range is %1$s to %2$s'), '1000-01-01', '9999-12-31');
            case 'DATETIME':
                return sprintf(__('A date and time combination, supported range is %1$s to %2$s'), '1000-01-01 00:00:00', '9999-12-31 23:59:59');
            case 'TIMESTAMP':
                return __('A timestamp, range is 1970-01-01 00:00:01 UTC to 2038-01-09 ' . '03:14:07 UTC, stored as the number of seconds since the epoch ' . '(1970-01-01 00:00:00 UTC)');
            case 'TIME':
                return sprintf(__('A time, range is %1$s to %2$s'), '-838:59:59', '838:59:59');
            case 'YEAR':
                return __('A year in four-digit (4, default) or two-digit (2) format, the ' . 'allowable values are 70 (1970) to 69 (2069) or 1901 to 2155 and ' . '0000');
            case 'CHAR':
                return __('A fixed-length (0-255, default 1) string that is always ' . 'right-padded with spaces to the specified length when stored');
            case 'VARCHAR':
                return sprintf(__('A variable-length (%s) string, the effective maximum length ' . 'is subject to the maximum row size'), '0-65,535');
            case 'TINYTEXT':
                return __('A TEXT column with a maximum length of 255 (2^8 - 1) characters, ' . 'stored with a one-byte prefix indicating the length of the value ' . 'in bytes');
            case 'TEXT':
                return __('A TEXT column with a maximum length of 65,535 (2^16 - 1) ' . 'characters, stored with a two-byte prefix indicating the length ' . 'of the value in bytes');
            case 'MEDIUMTEXT':
                return __('A TEXT column with a maximum length of 16,777,215 (2^24 - 1) ' . 'characters, stored with a three-byte prefix indicating the ' . 'length of the value in bytes');
            case 'LONGTEXT':
                return __('A TEXT column with a maximum length of 4,294,967,295 or 4GiB ' . '(2^32 - 1) characters, stored with a four-byte prefix indicating ' . 'the length of the value in bytes');
            case 'BINARY':
                return __('Similar to the CHAR type, but stores binary byte strings rather ' . 'than non-binary character strings');
            case 'VARBINARY':
                return __('Similar to the VARCHAR type, but stores binary byte strings ' . 'rather than non-binary character strings');
            case 'TINYBLOB':
                return __('A BLOB column with a maximum length of 255 (2^8 - 1) bytes, ' . 'stored with a one-byte prefix indicating the length of the value');
            case 'MEDIUMBLOB':
                return __('A BLOB column with a maximum length of 16,777,215 (2^24 - 1) ' . 'bytes, stored with a three-byte prefix indicating the length of ' . 'the value');
            case 'BLOB':
                return __('A BLOB column with a maximum length of 65,535 (2^16 - 1) bytes, ' . 'stored with a two-byte prefix indicating the length of the value');
            case 'LONGBLOB':
                return __('A BLOB column with a maximum length of 4,294,967,295 or 4GiB ' . '(2^32 - 1) bytes, stored with a four-byte prefix indicating the ' . 'length of the value');
            case 'ENUM':
                return __('An enumeration, chosen from the list of up to 65,535 values or ' . "the special '' error value");
            case 'SET':
                return __('A single value chosen from a set of up to 64 members');
            case 'GEOMETRY':
                return __('A type that can store a geometry of any type');
            case 'POINT':
                return __('A point in 2-dimensional space');
            case 'LINESTRING':
                return __('A curve with linear interpolation between points');
            case 'POLYGON':
                return __('A polygon');
            case 'MULTIPOINT':
                return __('A collection of points');
            case 'MULTILINESTRING':
                return __('A collection of curves with linear interpolation between points');
            case 'MULTIPOLYGON':
                return __('A collection of polygons');
            case 'GEOMETRYCOLLECTION':
                return __('A collection of geometry objects of any type');
            case 'JSON':
                return __('Stores and enables efficient access to data in JSON' . ' (JavaScript Object Notation) documents');
            case 'INET6':
                return __('Intended for storage of IPv6 addresses, as well as IPv4 ' . 'addresses assuming conventional mapping of IPv4 addresses ' . 'into IPv6 addresses');
        }
        return '';
    }
    /**
     * Returns class of a type, used for functions available for type
     * or default values.
     *
     * @param string $type The data type to get a class.
     *
     * @return string
     */
    public function getTypeClass($type)
    {
        $type = mb_strtoupper((string) $type);
        switch ($type) {
            case 'TINYINT':
            case 'SMALLINT':
            case 'MEDIUMINT':
            case 'INT':
            case 'BIGINT':
            case 'DECIMAL':
            case 'FLOAT':
            case 'DOUBLE':
            case 'REAL':
            case 'BIT':
            case 'BOOLEAN':
            case 'SERIAL':
                return 'NUMBER';
            case 'DATE':
            case 'DATETIME':
            case 'TIMESTAMP':
            case 'TIME':
            case 'YEAR':
                return 'DATE';
            case 'CHAR':
            case 'VARCHAR':
            case 'TINYTEXT':
            case 'TEXT':
            case 'MEDIUMTEXT':
            case 'LONGTEXT':
            case 'BINARY':
            case 'VARBINARY':
            case 'TINYBLOB':
            case 'MEDIUMBLOB':
            case 'BLOB':
            case 'LONGBLOB':
            case 'ENUM':
            case 'SET':
            case 'INET6':
                return 'CHAR';
            case 'GEOMETRY':
            case 'POINT':
            case 'LINESTRING':
            case 'POLYGON':
            case 'MULTIPOINT':
            case 'MULTILINESTRING':
            case 'MULTIPOLYGON':
            case 'GEOMETRYCOLLECTION':
                return 'SPATIAL';
            case 'JSON':
                return 'JSON';
        }
        return '';
    }
    /**
     * Returns array of functions available for a class.
     *
     * @param string $class The class to get function list.
     *
     * @return string[]
     */
    public function getFunctionsClass($class)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFunctionsClass") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 300")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFunctionsClass:300@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Returns array of functions available for a type.
     *
     * @param string $type The data type to get function list.
     *
     * @return string[]
     */
    public function getFunctions($type)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFunctions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 334")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFunctions:334@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Returns array of all functions available.
     *
     * @return string[]
     */
    public function getAllFunctions()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getAllFunctions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 344")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getAllFunctions:344@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Returns array of all attributes available.
     *
     * @return string[]
     */
    public function getAttributes()
    {
        return ['', 'BINARY', 'UNSIGNED', 'UNSIGNED ZEROFILL', 'on update CURRENT_TIMESTAMP'];
    }
    /**
     * Returns array of all column types available.
     *
     * VARCHAR, TINYINT, TEXT and DATE are listed first, based on
     * estimated popularity.
     *
     * @return array
     */
    public function getColumns() : array
    {
        $isMariaDB = $this->dbi->isMariaDB();
        $serverVersion = $this->dbi->getVersion();
        // most used types
        $ret = ['INT', 'VARCHAR', 'TEXT', 'DATE'];
        // numeric
        $ret[_pgettext('numeric types', 'Numeric')] = ['TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT', 'BIGINT', '-', 'DECIMAL', 'FLOAT', 'DOUBLE', 'REAL', '-', 'BIT', 'BOOLEAN', 'SERIAL'];
        // Date/Time
        $ret[_pgettext('date and time types', 'Date and time')] = ['DATE', 'DATETIME', 'TIMESTAMP', 'TIME', 'YEAR'];
        // Text
        $ret[_pgettext('string types', 'String')] = ['CHAR', 'VARCHAR', '-', 'TINYTEXT', 'TEXT', 'MEDIUMTEXT', 'LONGTEXT', '-', 'BINARY', 'VARBINARY', '-', 'TINYBLOB', 'BLOB', 'MEDIUMBLOB', 'LONGBLOB', '-', 'ENUM', 'SET'];
        $ret[_pgettext('spatial types', 'Spatial')] = ['GEOMETRY', 'POINT', 'LINESTRING', 'POLYGON', 'MULTIPOINT', 'MULTILINESTRING', 'MULTIPOLYGON', 'GEOMETRYCOLLECTION'];
        if ($isMariaDB && $serverVersion > 100207 || !$isMariaDB && $serverVersion >= 50708) {
            $ret['JSON'] = ['JSON'];
        }
        if ($isMariaDB && $serverVersion >= 100500) {
            array_push($ret[_pgettext('string types', 'String')], '-', 'INET6');
        }
        return $ret;
    }
    /**
     * Returns an array of integer types
     *
     * @return string[] integer types
     */
    public function getIntegerTypes()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getIntegerTypes") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 393")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getIntegerTypes:393@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
    /**
     * Returns the min and max values of a given integer type
     *
     * @param string $type   integer type
     * @param bool   $signed whether signed
     *
     * @return string[] min and max values
     */
    public function getIntegerRange($type, $signed = true)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getIntegerRange") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php at line 405")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getIntegerRange:405@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Types.php');
        die();
    }
}