<?php

/**
 * Defines the core helper infrastructure of the library.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser;

use Exception;
class Core
{
    /**
     * Whether errors should throw exceptions or just be stored.
     *
     * @see static::$errors
     *
     * @var bool
     */
    public $strict = false;
    /**
     * List of errors that occurred during lexing.
     *
     * Usually, the lexing does not stop once an error occurred because that
     * error might be false positive or a partial result (even a bad one)
     * might be needed.
     *
     * @see Core::error()
     *
     * @var Exception[]
     */
    public $errors = array();
    /**
     * Creates a new error log.
     *
     * @param Exception $error the error exception
     *
     * @throws Exception throws the exception, if strict mode is enabled.
     */
    public function error($error)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("error") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Core.php at line 41")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called error:41@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Core.php');
        die();
    }
}