<?php

declare (strict_types=1);
namespace Williamdes\MariaDBMySQLKBS;

use stdClass;
class Search
{
    /**
     * Loaded data
     *
     * @var mixed
     */
    public static $data;
    /**
     * Data is loaded
     *
     * @var bool
     */
    public static $loaded = false;
    public const ANY = -1;
    public const MYSQL = 1;
    public const MARIADB = 2;
    public const DS = DIRECTORY_SEPARATOR;
    /**
     * The directory where the data is located
     *
     * @var string
     */
    public static $DATA_DIR = __DIR__ . self::DS . ".." . self::DS . "dist" . self::DS;
    /**
     * Load data from disk
     *
     * @return void
     * @throws KBException
     */
    public static function loadData() : void
    {
        if (Search::$loaded === false) {
            $filePath = Search::$DATA_DIR . "merged-ultraslim.json";
            $contents = @file_get_contents($filePath);
            if ($contents === false) {
                throw new KBException("{$filePath} does not exist !");
            }
            Search::$data = json_decode($contents);
            Search::$loaded = true;
        }
    }
    /**
     * Load test data
     *
     * @param SlimData $slimData The SlimData object
     * @return void
     */
    public static function loadTestData(SlimData $slimData) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("loadTestData") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/williamdes/mariadb-mysql-kbs/src/Search.php at line 57")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called loadTestData:57@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/williamdes/mariadb-mysql-kbs/src/Search.php');
        die();
    }
    /**
     * get the first link to doc available
     *
     * @param string $name Name of variable
     * @param int    $type (optional) Type of link Search::MYSQL/Search::MARIADB/Search::ANY
     * @return string
     * @throws KBException
     */
    public static function getByName(string $name, int $type = Search::ANY) : string
    {
        self::loadData();
        $kbEntries = self::getVariable($name);
        if (isset($kbEntries->a)) {
            foreach ($kbEntries->a as $kbEntry) {
                if ($type === Search::ANY) {
                    return Search::$data->urls[$kbEntry->u] . "#" . $kbEntry->a;
                } elseif ($type === Search::MYSQL) {
                    if ($kbEntry->t === Search::MYSQL) {
                        return Search::$data->urls[$kbEntry->u] . "#" . $kbEntry->a;
                    }
                } elseif ($type === Search::MARIADB) {
                    if ($kbEntry->t === Search::MARIADB) {
                        return Search::$data->urls[$kbEntry->u] . "#" . $kbEntry->a;
                    }
                }
            }
        }
        throw new KBException("{$name} does not exist for this type of documentation !");
    }
    /**
     * Get a variable
     *
     * @param string $name Name of variable
     * @return stdClass
     * @throws KBException
     */
    public static function getVariable(string $name) : stdClass
    {
        self::loadData();
        if (isset(Search::$data->vars->{$name})) {
            return Search::$data->vars->{$name};
        } else {
            throw new KBException("{$name} does not exist !");
        }
    }
    /**
     * get the type of the variable
     *
     * @param string $name Name of variable
     * @return string
     * @throws KBException
     */
    public static function getVariableType(string $name) : string
    {
        self::loadData();
        $kbEntry = self::getVariable($name);
        if (isset($kbEntry->t)) {
            return Search::$data->varTypes->{$kbEntry->t};
        } else {
            throw new KBException("{$name} does have a known type !");
        }
    }
    /**
     * Return the list of static variables
     *
     * @return array<int,string>
     */
    public static function getStaticVariables() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getStaticVariables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/williamdes/mariadb-mysql-kbs/src/Search.php at line 129")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getStaticVariables:129@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/williamdes/mariadb-mysql-kbs/src/Search.php');
        die();
    }
    /**
     * Return the list of dynamic variables
     *
     * @return array<int,string>
     */
    public static function getDynamicVariables() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDynamicVariables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/williamdes/mariadb-mysql-kbs/src/Search.php at line 138")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDynamicVariables:138@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/williamdes/mariadb-mysql-kbs/src/Search.php');
        die();
    }
    /**
     * Return the list of variables having dynamic = $dynamic
     *
     * @param bool $dynamic dynamic=true/dynamic=false
     * @return array<int,string>
     */
    public static function getVariablesWithDynamic(bool $dynamic) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getVariablesWithDynamic") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/williamdes/mariadb-mysql-kbs/src/Search.php at line 148")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getVariablesWithDynamic:148@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/williamdes/mariadb-mysql-kbs/src/Search.php');
        die();
    }
}