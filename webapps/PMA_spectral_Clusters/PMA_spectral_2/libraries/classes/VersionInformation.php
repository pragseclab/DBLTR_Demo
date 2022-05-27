<?php

/**
 * Responsible for retrieving version information and notifying about latest version
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Utils\HttpRequest;
use stdClass;
use const PHP_VERSION;
use function count;
use function explode;
use function intval;
use function is_numeric;
use function is_object;
use function json_decode;
use function preg_match;
use function strlen;
use function strpos;
use function substr;
use function time;
use function version_compare;
/**
 * Responsible for retrieving version information and notifying about latest version
 */
class VersionInformation
{
    /**
     * Returns information with latest version from phpmyadmin.net
     *
     * @return stdClass|null JSON decoded object with the data
     */
    public function getLatestVersion() : ?stdClass
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
            $httpRequest = new HttpRequest();
            $response = $httpRequest->create($file, 'GET');
        }
        $response = $response ?: '{}';
        /* Parse response */
        $data = json_decode($response);
        /* Basic sanity checking */
        if (!is_object($data) || empty($data->version) || empty($data->releases) || empty($data->date)) {
            return null;
        }
        if ($save) {
            $_SESSION['cache']['version_check'] = ['response' => $response, 'timestamp' => time()];
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
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("versionToInt") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/VersionInformation.php at line 71")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called versionToInt:71@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/libraries/classes/VersionInformation.php');
        die();
    }
    /**
     * Returns the version and date of the latest phpMyAdmin version compatible
     * with the available PHP and MySQL versions
     *
     * @param array $releases array of information related to each version
     *
     * @return array|null containing the version and date of latest compatible version
     */
    public function getLatestCompatibleVersion(array $releases)
    {
        // Maintains the latest compatible version
        $latestRelease = null;
        foreach ($releases as $release) {
            $phpVersions = $release->php_versions;
            $phpConditions = explode(',', $phpVersions);
            foreach ($phpConditions as $phpCondition) {
                if (!$this->evaluateVersionCondition('PHP', $phpCondition)) {
                    continue 2;
                }
            }
            // We evaluate MySQL version constraint if there are only
            // one server configured.
            if (count($GLOBALS['cfg']['Servers']) === 1) {
                $mysqlVersions = $release->mysql_versions;
                $mysqlConditions = explode(',', $mysqlVersions);
                foreach ($mysqlConditions as $mysqlCondition) {
                    if (!$this->evaluateVersionCondition('MySQL', $mysqlCondition)) {
                        continue 2;
                    }
                }
            }
            // To compare the current release with the previous latest release or no release is set
            if ($latestRelease !== null && !version_compare($latestRelease['version'], $release->version, '<')) {
                continue;
            }
            $latestRelease = ['version' => $release->version, 'date' => $release->date];
        }
        // no compatible version
        return $latestRelease;
    }
    /**
     * Checks whether PHP or MySQL version meets supplied version condition
     *
     * @param string $type      PHP or MySQL
     * @param string $condition version condition
     *
     * @return bool whether the condition is met
     */
    public function evaluateVersionCondition(string $type, string $condition)
    {
        $operator = null;
        $version = null;
        $operators = ['<=', '>=', '!=', '<>', '<', '>', '='];
        // preserve order
        foreach ($operators as $oneOperator) {
            if (strpos($condition, $oneOperator) === 0) {
                $operator = $oneOperator;
                $version = substr($condition, strlen($oneOperator));
                break;
            }
        }
        $myVersion = null;
        if ($type === 'PHP') {
            $myVersion = $this->getPHPVersion();
        } elseif ($type === 'MySQL') {
            $myVersion = $this->getMySQLVersion();
        }
        if ($myVersion !== null && $version !== null && $operator !== null) {
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
     * Returns the MySQL version if connected to a database
     *
     * @return string|null MySQL version
     */
    protected function getMySQLVersion()
    {
        global $dbi;
        if (isset($dbi)) {
            return $dbi->getVersionString();
        }
        return null;
    }
}