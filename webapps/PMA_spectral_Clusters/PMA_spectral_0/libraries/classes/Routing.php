<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;
use FastRoute\RouteParser\Std as RouteParserStd;
use FastRoute\DataGenerator\GroupCountBased as DataGeneratorGroupCountBased;
use FastRoute\Dispatcher\GroupCountBased as DispatcherGroupCountBased;
use FastRoute\RouteCollector;
use function htmlspecialchars;
use function mb_strlen;
use function rawurldecode;
use function sprintf;
use function is_writable;
use function file_exists;
use function is_array;
use RuntimeException;
use function var_export;
use function is_readable;
use function trigger_error;
use const E_USER_WARNING;
use function fopen;
use function fwrite;
use function fclose;
/**
 * Class used to warm up the routing cache and manage routing.
 */
class Routing
{
    public const ROUTES_CACHE_FILE = CACHE_DIR . 'routes.cache.php';
    public static function getDispatcher() : Dispatcher
    {
        $routes = (require ROOT_PATH . 'libraries/routes.php');
        return self::routesCachedDispatcher($routes);
    }
    public static function skipCache() : bool
    {
        global $cfg;
        return ($cfg['environment'] ?? '') === 'development';
    }
    public static function canWriteCache() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("canWriteCache") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Routing.php at line 45")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called canWriteCache:45@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Routing.php');
        die();
    }
    private static function routesCachedDispatcher(callable $routeDefinitionCallback) : Dispatcher
    {
        $skipCache = self::skipCache();
        // If skip cache is enabled, do not try to read the file
        // If no cache skipping then read it and use it
        if (!$skipCache && file_exists(self::ROUTES_CACHE_FILE)) {
            $dispatchData = (require self::ROUTES_CACHE_FILE);
            if (!is_array($dispatchData)) {
                throw new RuntimeException('Invalid cache file "' . self::ROUTES_CACHE_FILE . '"');
            }
            return new DispatcherGroupCountBased($dispatchData);
        }
        $routeCollector = new RouteCollector(new RouteParserStd(), new DataGeneratorGroupCountBased());
        $routeDefinitionCallback($routeCollector);
        /** @var RouteCollector $routeCollector */
        $dispatchData = $routeCollector->getData();
        $canWriteCache = self::canWriteCache();
        // If skip cache is enabled, do not try to write it
        // If no skip cache then try to write if write is possible
        if (!$skipCache && $canWriteCache) {
            $writeWorks = self::writeCache('<?php return ' . var_export($dispatchData, true) . ';');
            if (!$writeWorks) {
                trigger_error(sprintf(__('The routing cache could not be written, ' . 'you need to adjust permissions on the folder/file "%s"'), self::ROUTES_CACHE_FILE), E_USER_WARNING);
            }
        }
        return new DispatcherGroupCountBased($dispatchData);
    }
    public static function writeCache(string $cacheContents) : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("writeCache") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Routing.php at line 85")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called writeCache:85@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Routing.php');
        die();
    }
    public static function getCurrentRoute() : string
    {
        /** @var string $route */
        $route = $_GET['route'] ?? $_POST['route'] ?? '/';
        /**
         * See FAQ 1.34.
         *
         * @see https://docs.phpmyadmin.net/en/latest/faq.html#faq1-34
         */
        if (($route === '/' || $route === '') && isset($_GET['db']) && mb_strlen($_GET['db']) !== 0) {
            $route = '/database/structure';
            if (isset($_GET['table']) && mb_strlen($_GET['table']) !== 0) {
                $route = '/sql';
            }
        }
        return $route;
    }
    /**
     * Call associated controller for a route using the dispatcher
     */
    public static function callControllerForRoute(string $route, Dispatcher $dispatcher, ContainerInterface $container) : void
    {
        $routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], rawurldecode($route));
        if ($routeInfo[0] === Dispatcher::NOT_FOUND) {
            /** @var Response $response */
            $response = $container->get(Response::class);
            $response->setHttpResponseCode(404);
            echo Message::error(sprintf(__('Error 404! The page %s was not found.'), '<code>' . htmlspecialchars($route) . '</code>'))->getDisplay();
            return;
        }
        if ($routeInfo[0] === Dispatcher::METHOD_NOT_ALLOWED) {
            /** @var Response $response */
            $response = $container->get(Response::class);
            $response->setHttpResponseCode(405);
            echo Message::error(__('Error 405! Request method not allowed.'))->getDisplay();
            return;
        }
        if ($routeInfo[0] !== Dispatcher::FOUND) {
            return;
        }
        [$controllerName, $action] = $routeInfo[1];
        $controller = $container->get($controllerName);
        $controller->{$action}($routeInfo[2]);
    }
}