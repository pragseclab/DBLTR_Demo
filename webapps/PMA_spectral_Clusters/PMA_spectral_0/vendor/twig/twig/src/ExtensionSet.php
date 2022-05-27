<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig;

use Twig\Error\RuntimeError;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\GlobalsInterface;
use Twig\Extension\InitRuntimeInterface;
use Twig\Extension\StagingExtension;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\TokenParser\TokenParserInterface;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
final class ExtensionSet
{
    private $extensions;
    private $initialized = false;
    private $runtimeInitialized = false;
    private $staging;
    private $parsers;
    private $visitors;
    private $filters;
    private $tests;
    private $functions;
    private $unaryOperators;
    private $binaryOperators;
    private $globals;
    private $functionCallbacks = array();
    private $filterCallbacks = array();
    private $lastModified = 0;
    public function __construct()
    {
        $this->staging = new StagingExtension();
    }
    /**
     * Initializes the runtime environment.
     *
     * @deprecated since Twig 2.7
     */
    public function initRuntime(Environment $env)
    {
        if ($this->runtimeInitialized) {
            return;
        }
        $this->runtimeInitialized = true;
        foreach ($this->extensions as $extension) {
            if ($extension instanceof InitRuntimeInterface) {
                $extension->initRuntime($env);
            }
        }
    }
    public function hasExtension(string $class) : bool
    {
        $class = ltrim($class, '\\');
        if (!isset($this->extensions[$class]) && class_exists($class, false)) {
            // For BC/FC with namespaced aliases
            $class = (new \ReflectionClass($class))->name;
        }
        return isset($this->extensions[$class]);
    }
    public function getExtension(string $class) : ExtensionInterface
    {
        $class = ltrim($class, '\\');
        if (!isset($this->extensions[$class]) && class_exists($class, false)) {
            // For BC/FC with namespaced aliases
            $class = (new \ReflectionClass($class))->name;
        }
        if (!isset($this->extensions[$class])) {
            throw new RuntimeError(sprintf('The "%s" extension is not enabled.', $class));
        }
        return $this->extensions[$class];
    }
    /**
     * @param ExtensionInterface[] $extensions
     */
    public function setExtensions(array $extensions)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setExtensions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 89")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setExtensions:89@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    /**
     * @return ExtensionInterface[]
     */
    public function getExtensions() : array
    {
        return $this->extensions;
    }
    public function getSignature() : string
    {
        return json_encode(array_keys($this->extensions));
    }
    public function isInitialized() : bool
    {
        return $this->initialized || $this->runtimeInitialized;
    }
    public function getLastModified() : int
    {
        if (0 !== $this->lastModified) {
            return $this->lastModified;
        }
        foreach ($this->extensions as $extension) {
            $r = new \ReflectionObject($extension);
            if (file_exists($r->getFileName()) && ($extensionTime = filemtime($r->getFileName())) > $this->lastModified) {
                $this->lastModified = $extensionTime;
            }
        }
        return $this->lastModified;
    }
    public function addExtension(ExtensionInterface $extension)
    {
        $class = \get_class($extension);
        if ($this->initialized) {
            throw new \LogicException(sprintf('Unable to register extension "%s" as extensions have already been initialized.', $class));
        }
        if (isset($this->extensions[$class])) {
            throw new \LogicException(sprintf('Unable to register extension "%s" as it is already registered.', $class));
        }
        // For BC/FC with namespaced aliases
        $class = (new \ReflectionClass($class))->name;
        $this->extensions[$class] = $extension;
    }
    public function addFunction(TwigFunction $function)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addFunction") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 136")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addFunction:136@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    /**
     * @return TwigFunction[]
     */
    public function getFunctions() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFunctions") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 146")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFunctions:146@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    /**
     * @return TwigFunction|false
     */
    public function getFunction(string $name)
    {
        if (!$this->initialized) {
            $this->initExtensions();
        }
        if (isset($this->functions[$name])) {
            return $this->functions[$name];
        }
        foreach ($this->functions as $pattern => $function) {
            $pattern = str_replace('\\*', '(.*?)', preg_quote($pattern, '#'), $count);
            if ($count && preg_match('#^' . $pattern . '$#', $name, $matches)) {
                array_shift($matches);
                $function->setArguments($matches);
                return $function;
            }
        }
        foreach ($this->functionCallbacks as $callback) {
            if (false !== ($function = $callback($name))) {
                return $function;
            }
        }
        return false;
    }
    public function registerUndefinedFunctionCallback(callable $callable)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("registerUndefinedFunctionCallback") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 179")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called registerUndefinedFunctionCallback:179@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    public function addFilter(TwigFilter $filter)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addFilter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 183")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addFilter:183@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    /**
     * @return TwigFilter[]
     */
    public function getFilters() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getFilters") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 193")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getFilters:193@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    /**
     * @return TwigFilter|false
     */
    public function getFilter(string $name)
    {
        if (!$this->initialized) {
            $this->initExtensions();
        }
        if (isset($this->filters[$name])) {
            return $this->filters[$name];
        }
        foreach ($this->filters as $pattern => $filter) {
            $pattern = str_replace('\\*', '(.*?)', preg_quote($pattern, '#'), $count);
            if ($count && preg_match('#^' . $pattern . '$#', $name, $matches)) {
                array_shift($matches);
                $filter->setArguments($matches);
                return $filter;
            }
        }
        foreach ($this->filterCallbacks as $callback) {
            if (false !== ($filter = $callback($name))) {
                return $filter;
            }
        }
        return false;
    }
    public function registerUndefinedFilterCallback(callable $callable)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("registerUndefinedFilterCallback") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 226")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called registerUndefinedFilterCallback:226@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    public function addNodeVisitor(NodeVisitorInterface $visitor)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addNodeVisitor") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 230")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addNodeVisitor:230@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    /**
     * @return NodeVisitorInterface[]
     */
    public function getNodeVisitors() : array
    {
        if (!$this->initialized) {
            $this->initExtensions();
        }
        return $this->visitors;
    }
    public function addTokenParser(TokenParserInterface $parser)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addTokenParser") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 247")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addTokenParser:247@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    /**
     * @return TokenParserInterface[]
     */
    public function getTokenParsers() : array
    {
        if (!$this->initialized) {
            $this->initExtensions();
        }
        return $this->parsers;
    }
    public function getGlobals() : array
    {
        if (null !== $this->globals) {
            return $this->globals;
        }
        $globals = [];
        foreach ($this->extensions as $extension) {
            if (!$extension instanceof GlobalsInterface) {
                continue;
            }
            $extGlobals = $extension->getGlobals();
            if (!\is_array($extGlobals)) {
                throw new \UnexpectedValueException(sprintf('"%s::getGlobals()" must return an array of globals.', \get_class($extension)));
            }
            $globals = array_merge($globals, $extGlobals);
        }
        if ($this->initialized) {
            $this->globals = $globals;
        }
        return $globals;
    }
    public function addTest(TwigTest $test)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addTest") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 285")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addTest:285@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    /**
     * @return TwigTest[]
     */
    public function getTests() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getTests") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php at line 295")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getTests:295@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/twig/twig/src/ExtensionSet.php');
        die();
    }
    /**
     * @return TwigTest|false
     */
    public function getTest(string $name)
    {
        if (!$this->initialized) {
            $this->initExtensions();
        }
        if (isset($this->tests[$name])) {
            return $this->tests[$name];
        }
        foreach ($this->tests as $pattern => $test) {
            $pattern = str_replace('\\*', '(.*?)', preg_quote($pattern, '#'), $count);
            if ($count) {
                if (preg_match('#^' . $pattern . '$#', $name, $matches)) {
                    array_shift($matches);
                    $test->setArguments($matches);
                    return $test;
                }
            }
        }
        return false;
    }
    public function getUnaryOperators() : array
    {
        if (!$this->initialized) {
            $this->initExtensions();
        }
        return $this->unaryOperators;
    }
    public function getBinaryOperators() : array
    {
        if (!$this->initialized) {
            $this->initExtensions();
        }
        return $this->binaryOperators;
    }
    private function initExtensions()
    {
        $this->parsers = [];
        $this->filters = [];
        $this->functions = [];
        $this->tests = [];
        $this->visitors = [];
        $this->unaryOperators = [];
        $this->binaryOperators = [];
        foreach ($this->extensions as $extension) {
            $this->initExtension($extension);
        }
        $this->initExtension($this->staging);
        // Done at the end only, so that an exception during initialization does not mark the environment as initialized when catching the exception
        $this->initialized = true;
    }
    private function initExtension(ExtensionInterface $extension)
    {
        // filters
        foreach ($extension->getFilters() as $filter) {
            $this->filters[$filter->getName()] = $filter;
        }
        // functions
        foreach ($extension->getFunctions() as $function) {
            $this->functions[$function->getName()] = $function;
        }
        // tests
        foreach ($extension->getTests() as $test) {
            $this->tests[$test->getName()] = $test;
        }
        // token parsers
        foreach ($extension->getTokenParsers() as $parser) {
            if (!$parser instanceof TokenParserInterface) {
                throw new \LogicException('getTokenParsers() must return an array of \\Twig\\TokenParser\\TokenParserInterface.');
            }
            $this->parsers[] = $parser;
        }
        // node visitors
        foreach ($extension->getNodeVisitors() as $visitor) {
            $this->visitors[] = $visitor;
        }
        // operators
        if ($operators = $extension->getOperators()) {
            if (!\is_array($operators)) {
                throw new \InvalidArgumentException(sprintf('"%s::getOperators()" must return an array with operators, got "%s".', \get_class($extension), \is_object($operators) ? \get_class($operators) : \gettype($operators) . (\is_resource($operators) ? '' : '#' . $operators)));
            }
            if (2 !== \count($operators)) {
                throw new \InvalidArgumentException(sprintf('"%s::getOperators()" must return an array of 2 elements, got %d.', \get_class($extension), \count($operators)));
            }
            $this->unaryOperators = array_merge($this->unaryOperators, $operators[0]);
            $this->binaryOperators = array_merge($this->binaryOperators, $operators[1]);
        }
    }
}
class_alias('Twig\\ExtensionSet', 'Twig_ExtensionSet');