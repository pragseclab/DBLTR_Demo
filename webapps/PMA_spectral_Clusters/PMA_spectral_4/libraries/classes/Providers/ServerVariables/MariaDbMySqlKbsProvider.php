<?php

declare (strict_types=1);
namespace PhpMyAdmin\Providers\ServerVariables;

use Williamdes\MariaDBMySQLKBS\KBException;
use Williamdes\MariaDBMySQLKBS\Search as KBSearch;
class MariaDbMySqlKbsProvider implements ServerVariablesProviderInterface
{
    public function getVariableType(string $name) : ?string
    {
        try {
            return KBSearch::getVariableType($name);
        } catch (KBException $e) {
            return null;
        }
    }
    public function getStaticVariables() : array
    {
        return [];
    }
    public function getDocLinkByNameMariaDb(string $name) : ?string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDocLinkByNameMariaDb") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Providers/ServerVariables/MariaDbMySqlKbsProvider.php at line 24")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDocLinkByNameMariaDb:24@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Providers/ServerVariables/MariaDbMySqlKbsProvider.php');
        die();
    }
    public function getDocLinkByNameMysql(string $name) : ?string
    {
        try {
            return KBSearch::getByName($name, KBSearch::MYSQL);
        } catch (KBException $e) {
            return null;
        }
    }
}