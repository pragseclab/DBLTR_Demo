<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Responsible for retrieving version information and notifiying about latest version
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use PMA\libraries\Util;
use stdClass;
if (!defined('PHPMYADMIN')) {
    exit;
}
/**
 * Responsible for retrieving version information and notifiying about latest version
 *
 * @package PhpMyAdmin
 *
 */
class VersionInformation
{
    /**
     * Returns information with latest version from phpmyadmin.net
     *
     * @return object JSON decoded object with the data
     */
    public function getLatestVersion()
    {
        if (!$GLOBALS['cfg']['VersionCheck']) {
            return null;
        }
        // Get response text from phpmyadmin.net or from the session
        // Update cache every 6 hours
        if (isset($_SESSION['cache']['version_check']) && time() < $_SESSION['cache']['version_check']['timestamp'] + 3600 * 6) {
            $save = false;
            $response = $_SESSION['cache']['version_check']['response'];
        } else {
            $save = true;
            $file = 'https://www.phpmyadmin.net/home_page/version.json';
            $response = Util::httpRequest($file, "GET");
        }
        $response = $response ? $response : '{}';
        /* Parse response */
        $data = json_decode($response);
        /* Basic sanity checking */
        if (!is_object($data) || empty($data->version) || empty($data->releases) || empty($data->date)) {
            return null;
        }
        if ($save) {
            $_SESSION['cache']['version_check'] = array('response' => $response, 'timestamp' => time());
        }
        return $data;
    }
    /**
     * Calculates numerical equivalent of phpMyAdmin version string
     *
     * @param string $version version
     *
     * @return mixed false on failure, integer on success
     */
    public function versionToInt($version)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("versionToInt") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/VersionInformation.php at line 79")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called versionToInt:79@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/VersionInformation.php');
        die();
    }
    /**
     * Returns the version and date of the latest phpMyAdmin version compatible
     * with the available PHP and MySQL versions
     *
     * @param array $releases array of information related to each version
     *
     * @return array containing the version and date of latest compatible version
     */
    public function getLatestCompatibleVersion($releases)
    {
        foreach ($releases as $release) {
            $phpVersions = $release->php_versions;
            $phpConditions = explode(",", $phpVersions);
            foreach ($phpConditions as $phpCondition) {
                if (!$this->evaluateVersionCondition("PHP", $phpCondition)) {
                    continue 2;
                }
            }
            // We evalute MySQL version constraint if there are only
            // one server configured.
            if (count($GLOBALS['cfg']['Servers']) == 1) {
                $mysqlVersions = $release->mysql_versions;
                $mysqlConditions = explode(",", $mysqlVersions);
                foreach ($mysqlConditions as $mysqlCondition) {
                    if (!$this->evaluateVersionCondition('MySQL', $mysqlCondition)) {
                        continue 2;
                    }
                }
            }
            return array('version' => $release->version, 'date' => $release->date);
        }
        // no compatible version
        return null;
    }
    /**
     * Checks whether PHP or MySQL version meets supplied version condition
     *
     * @param string $type      PHP or MySQL
     * @param string $condition version condition
     *
     * @return boolean whether the condition is met
     */
    public function evaluateVersionCondition($type, $condition)
    {
        $operator = null;
        $operators = array("<=", ">=", "!=", "<>", "<", ">", "=");
        // preserve order
        foreach ($operators as $oneOperator) {
            if (strpos($condition, $oneOperator) === 0) {
                $operator = $oneOperator;
                $version = substr($condition, strlen($oneOperator));
                break;
            }
        }
        $myVersion = null;
        if ($type == 'PHP') {
            $myVersion = $this->getPHPVersion();
        } elseif ($type == 'MySQL') {
            $myVersion = $this->getMySQLVersion();
        }
        if ($myVersion != null && $operator != null) {
            return version_compare($myVersion, $version, $operator);
        }
        return false;
    }
    /**
     * Returns the PHP version
     *
     * @return string PHP version
     */
    protected function getPHPVersion()
    {
        return PHP_VERSION;
    }
    /**
     * Returns the MySQL version
     *
     * @return string MySQL version
     */
    protected function getMySQLVersion()
    {
        return PMA_MYSQL_STR_VERSION;
    }
}