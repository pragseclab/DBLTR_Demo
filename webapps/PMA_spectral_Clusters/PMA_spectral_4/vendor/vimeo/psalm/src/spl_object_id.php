<?php

declare (strict_types=1);
/**
 * PHP Polyfill for spl_object_id() for PHP <= 7.1
 * This file will be included even in releases which will analyze PHP 7.2,
 * there aren't any major compatibilities preventing analysis of PHP 7.2 from running in PHP 7.1.
 */
if (!function_exists('spl_object_id')) {
    if (function_exists('runkit_object_id') && !(new ReflectionFunction('runkit_object_id'))->isUserDefined()) {
        /**
         * See https://github.com/runkit7/runkit_object_id for a faster native version for php <= 7.1
         *
         * @param object $object
         * @return int The object id
         */
        function spl_object_id($object) : int
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("spl_object_id") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/vimeo/psalm/src/spl_object_id.php at line 19")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called spl_object_id:19@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/vimeo/psalm/src/spl_object_id.php');
            die();
        }
    } elseif (PHP_INT_SIZE === 8) {
        /**
         * See https://github.com/runkit7/runkit_object_id for a faster native version for php <= 7.1
         *
         * @param object $object
         * @return int (The object id, XORed with a random number)
         */
        function spl_object_id($object) : int
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("spl_object_id") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/vimeo/psalm/src/spl_object_id.php at line 30")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called spl_object_id:30@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/vimeo/psalm/src/spl_object_id.php');
            die();
        }
    } else {
        /**
         * See https://github.com/runkit7/runkit_object_id for a faster native version for php <= 7.1
         *
         * @param object $object
         * @return int (The object id, XORed with a random number)
         */
        function spl_object_id($object) : int
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("spl_object_id") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/vimeo/psalm/src/spl_object_id.php at line 45")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called spl_object_id:45@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/vendor/vimeo/psalm/src/spl_object_id.php');
            die();
        }
    }
}