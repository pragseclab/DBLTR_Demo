<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds the PMA\libraries\di\Container class
 *
 * @package PMA
 */
namespace PMA\libraries\di;

/**
 * Class Container
 *
 * @package PMA\libraries\di
 */
class Container
{
    /**
     * @var Item[] $content
     */
    protected $content = array();
    /**
     * @var Container
     */
    protected static $defaultContainer;
    /**
     * Create a dependency injection container
     *
     * @param Container $base Container
     */
    public function __construct(Container $base = null)
    {
        if (isset($base)) {
            $this->content = $base->content;
        } else {
            $this->alias('container', 'Container');
        }
        $this->set('Container', $this);
    }
    /**
     * Get an object with given name and parameters
     *
     * @param string $name   Name
     * @param array  $params Parameters
     *
     * @return mixed
     */
    public function get($name, $params = array())
    {
        if (isset($this->content[$name])) {
            return $this->content[$name]->get($params);
        }
        if (isset($GLOBALS[$name])) {
            return $GLOBALS[$name];
        }
        return null;
    }
    /**
     * Remove an object from container
     *
     * @param string $name Name
     *
     * @return void
     */
    public function remove($name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("remove") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/di/Container.php at line 73")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called remove:73@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/di/Container.php');
        die();
    }
    /**
     * Rename an object in container
     *
     * @param string $name    Name
     * @param string $newName New name
     *
     * @return void
     */
    public function rename($name, $newName)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("rename") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/di/Container.php at line 86")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called rename:86@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/di/Container.php');
        die();
    }
    /**
     * Set values in the container
     *
     * @param string|array $name  Name
     * @param mixed        $value Value
     *
     * @return void
     */
    public function set($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $val) {
                $this->set($key, $val);
            }
            return;
        }
        $this->content[$name] = new ValueItem($value);
    }
    /**
     * Register a service in the container
     *
     * @param string $name    Name
     * @param mixed  $service Service
     *
     * @return void
     */
    public function service($name, $service = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("service") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/di/Container.php at line 119")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called service:119@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/di/Container.php');
        die();
    }
    /**
     * Register a factory in the container
     *
     * @param string $name    Name
     * @param mixed  $factory Factory
     *
     * @return void
     */
    public function factory($name, $factory = null)
    {
        if (!isset($factory)) {
            $factory = $name;
        }
        $this->content[$name] = new FactoryItem($this, $factory);
    }
    /**
     * Register an alias in the container
     *
     * @param string $name   Name
     * @param string $target Target
     *
     * @return void
     */
    public function alias($name, $target)
    {
        // The target may be not defined yet
        $this->content[$name] = new AliasItem($this, $target);
    }
    /**
     * Get the global default container
     *
     * @return Container
     */
    public static function getDefaultContainer()
    {
        if (!isset(static::$defaultContainer)) {
            static::$defaultContainer = new Container();
        }
        return static::$defaultContainer;
    }
}