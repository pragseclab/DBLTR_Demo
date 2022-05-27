<?php

/**
 * Handles adding and dispatching events
 *
 * @package Requests
 * @subpackage Utilities
 */
/**
 * Handles adding and dispatching events
 *
 * @package Requests
 * @subpackage Utilities
 */
class Requests_Hooks implements Requests_Hooker
{
    /**
     * Registered callbacks for each hook
     *
     * @var array
     */
    protected $hooks = array();
    /**
     * Constructor
     */
    public function __construct()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Hooks.php at line 28")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:28@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/Requests/Hooks.php');
        die();
    }
    /**
     * Register a callback for a hook
     *
     * @param string $hook Hook name
     * @param callback $callback Function/method to call on event
     * @param int $priority Priority number. <0 is executed earlier, >0 is executed later
     */
    public function register($hook, $callback, $priority = 0)
    {
        if (!isset($this->hooks[$hook])) {
            $this->hooks[$hook] = array();
        }
        if (!isset($this->hooks[$hook][$priority])) {
            $this->hooks[$hook][$priority] = array();
        }
        $this->hooks[$hook][$priority][] = $callback;
    }
    /**
     * Dispatch a message
     *
     * @param string $hook Hook name
     * @param array $parameters Parameters to pass to callbacks
     * @return boolean Successfulness
     */
    public function dispatch($hook, $parameters = array())
    {
        if (empty($this->hooks[$hook])) {
            return false;
        }
        foreach ($this->hooks[$hook] as $priority => $hooked) {
            foreach ($hooked as $callback) {
                call_user_func_array($callback, $parameters);
            }
        }
        return true;
    }
}