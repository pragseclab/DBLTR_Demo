<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * This library is used with the server IP allow/deny host authentication
 * feature
 *
 * @package PhpMyAdmin
 */
/**
 * Matches for IPv4 or IPv6 addresses
 *
 * @param string $testRange string of IP range to match
 * @param string $ipToTest  string of IP to test against range
 *
 * @return boolean    whether the IP mask matches
 *
 * @access  public
 */
function PMA_ipMaskTest($testRange, $ipToTest)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_ipMaskTest") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ip_allow_deny.lib.php at line 22")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_ipMaskTest:22@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ip_allow_deny.lib.php');
    die();
}
// end of the "PMA_ipMaskTest()" function
/**
 * Based on IP Pattern Matcher
 * Originally by J.Adams <jna@retina.net>
 * Found on <https://secure.php.net/manual/en/function.ip2long.php>
 * Modified for phpMyAdmin
 *
 * Matches:
 * xxx.xxx.xxx.xxx        (exact)
 * xxx.xxx.xxx.[yyy-zzz]  (range)
 * xxx.xxx.xxx.xxx/nn     (CIDR)
 *
 * Does not match:
 * xxx.xxx.xxx.xx[yyy-zzz]  (range, partial octets not supported)
 *
 * @param string $testRange string of IP range to match
 * @param string $ipToTest  string of IP to test against range
 *
 * @return boolean    whether the IP mask matches
 *
 * @access  public
 */
function PMA_ipv4MaskTest($testRange, $ipToTest)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_ipv4MaskTest") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ip_allow_deny.lib.php at line 58")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_ipv4MaskTest:58@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ip_allow_deny.lib.php');
    die();
}
// end of the "PMA_ipv4MaskTest()" function
/**
 * IPv6 matcher
 * CIDR section taken from https://stackoverflow.com/a/10086404
 * Modified for phpMyAdmin
 *
 * Matches:
 * xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx
 * (exact)
 * xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:[yyyy-zzzz]
 * (range, only at end of IP - no subnets)
 * xxxx:xxxx:xxxx:xxxx/nn
 * (CIDR)
 *
 * Does not match:
 * xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xx[yyy-zzz]
 * (range, partial octets not supported)
 *
 * @param string $test_range string of IP range to match
 * @param string $ip_to_test string of IP to test against range
 *
 * @return boolean    whether the IP mask matches
 *
 * @access  public
 */
function PMA_ipv6MaskTest($test_range, $ip_to_test)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_ipv6MaskTest") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ip_allow_deny.lib.php at line 133")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_ipv6MaskTest:133@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ip_allow_deny.lib.php');
    die();
}
// end of the "PMA_ipv6MaskTest()" function
/**
 * Runs through IP Allow/Deny rules the use of it below for more information
 *
 * @param string $type 'allow' | 'deny' type of rule to match
 *
 * @return bool   Whether rule has matched
 *
 * @access  public
 *
 * @see     PMA_getIp()
 */
function PMA_allowDeny($type)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("PMA_allowDeny") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ip_allow_deny.lib.php at line 229")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called PMA_allowDeny:229@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/ip_allow_deny.lib.php');
    die();
}
// end of the "PMA_AllowDeny()" function