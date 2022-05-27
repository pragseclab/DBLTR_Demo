<?php

/**
 * Exception for HTTP requests
 *
 * @package Requests
 */
/**
 * Exception for HTTP requests
 *
 * @package Requests
 */
class Requests_Exception extends Exception
{
    /**
     * Type of exception
     *
     * @var string
     */
    protected $type;
    /**
     * Data associated with the exception
     *
     * @var mixed
     */
    protected $data;
    /**
     * Create a new exception
     *
     * @param string $message Exception message
     * @param string $type Exception type
     * @param mixed $data Associated data
     * @param integer $code Exception numerical code, if applicable
     */
    public function __construct($message, $type, $data = null, $code = 0)
    {
        parent::__construct($message, $code);
        $this->type = $type;
        $this->data = $data;
    }
    /**
     * Like {@see getCode()}, but a string code.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getType()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getType") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/Requests/Exception.php at line 49")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getType:49@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/Requests/Exception.php');
        die();
    }
    /**
     * Gives any relevant data
     *
     * @codeCoverageIgnore
     * @return mixed
     */
    public function getData()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getData") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/Requests/Exception.php at line 59")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getData:59@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/Requests/Exception.php');
        die();
    }
}