<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use ArrayObject;
use PhpMyAdmin\Query\Utilities;
use function in_array;
/**
 * Generic list class
 *
 * @todo add caching
 * @abstract
 */
abstract class ListAbstract extends ArrayObject
{
    /** @var mixed   empty item */
    protected $itemEmpty = '';
    /**
     * defines what is an empty item (0, '', false or null)
     *
     * @return mixed   an empty item
     */
    public function getEmpty()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEmpty") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/ListAbstract.php at line 26")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getEmpty:26@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/ListAbstract.php');
        die();
    }
    /**
     * checks if the given db names exists in the current list, if there is
     * missing at least one item it returns false otherwise true
     *
     * @param mixed[] ...$params params
     *
     * @return bool true if all items exists, otherwise false
     */
    public function exists(...$params)
    {
        $this_elements = $this->getArrayCopy();
        foreach ($params as $result) {
            if (!in_array($result, $this_elements)) {
                return false;
            }
        }
        return true;
    }
    /**
     * @return array<int, array<string, bool|string>>
     */
    public function getList() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getList") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/ListAbstract.php at line 51")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getList:51@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/ListAbstract.php');
        die();
    }
    /**
     * returns default item
     *
     * @return string  default item
     */
    public function getDefault()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDefault") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/ListAbstract.php at line 68")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDefault:68@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/ListAbstract.php');
        die();
    }
    /**
     * builds up the list
     *
     * @return void
     */
    public abstract function build();
}