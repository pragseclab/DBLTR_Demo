<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig\Node\Expression;

use Twig\Compiler;
use Twig\Error\SyntaxError;
use Twig\Extension\ExtensionInterface;
use Twig\Node\Node;
abstract class CallExpression extends AbstractExpression
{
    private $reflector;
    protected function compileCallable(Compiler $compiler)
    {
        $callable = $this->getAttribute('callable');
        $closingParenthesis = false;
        $isArray = false;
        if (\is_string($callable) && false === strpos($callable, '::')) {
            $compiler->raw($callable);
        } else {
            list($r, $callable) = $this->reflectCallable($callable);
            if ($r instanceof \ReflectionMethod && \is_string($callable[0])) {
                if ($r->isStatic()) {
                    $compiler->raw(sprintf('%s::%s', $callable[0], $callable[1]));
                } else {
                    $compiler->raw(sprintf('$this->env->getRuntime(\'%s\')->%s', $callable[0], $callable[1]));
                }
            } elseif ($r instanceof \ReflectionMethod && $callable[0] instanceof ExtensionInterface) {
                // For BC/FC with namespaced aliases
                $class = (new \ReflectionClass(\get_class($callable[0])))->name;
                if (!$compiler->getEnvironment()->hasExtension($class)) {
                    // Compile a non-optimized call to trigger a \Twig\Error\RuntimeError, which cannot be a compile-time error
                    $compiler->raw(sprintf('$this->env->getExtension(\'%s\')', $class));
                } else {
                    $compiler->raw(sprintf('$this->extensions[\'%s\']', ltrim($class, '\\')));
                }
                $compiler->raw(sprintf('->%s', $callable[1]));
            } else {
                $closingParenthesis = true;
                $isArray = true;
                $compiler->raw(sprintf('call_user_func_array($this->env->get%s(\'%s\')->getCallable(), ', ucfirst($this->getAttribute('type')), $this->getAttribute('name')));
            }
        }
        $this->compileArguments($compiler, $isArray);
        if ($closingParenthesis) {
            $compiler->raw(')');
        }
    }
    protected function compileArguments(Compiler $compiler, $isArray = false)
    {
        $compiler->raw($isArray ? '[' : '(');
        $first = true;
        if ($this->hasAttribute('needs_environment') && $this->getAttribute('needs_environment')) {
            $compiler->raw('$this->env');
            $first = false;
        }
        if ($this->hasAttribute('needs_context') && $this->getAttribute('needs_context')) {
            if (!$first) {
                $compiler->raw(', ');
            }
            $compiler->raw('$context');
            $first = false;
        }
        if ($this->hasAttribute('arguments')) {
            foreach ($this->getAttribute('arguments') as $argument) {
                if (!$first) {
                    $compiler->raw(', ');
                }
                $compiler->string($argument);
                $first = false;
            }
        }
        if ($this->hasNode('node')) {
            if (!$first) {
                $compiler->raw(', ');
            }
            $compiler->subcompile($this->getNode('node'));
            $first = false;
        }
        if ($this->hasNode('arguments')) {
            $callable = $this->getAttribute('callable');
            $arguments = $this->getArguments($callable, $this->getNode('arguments'));
            foreach ($arguments as $node) {
                if (!$first) {
                    $compiler->raw(', ');
                }
                $compiler->subcompile($node);
                $first = false;
            }
        }
        $compiler->raw($isArray ? ']' : ')');
    }
    protected function getArguments($callable, $arguments)
    {
        $callType = $this->getAttribute('type');
        $callName = $this->getAttribute('name');
        $parameters = [];
        $named = false;
        foreach ($arguments as $name => $node) {
            if (!\is_int($name)) {
                $named = true;
                $name = $this->normalizeName($name);
            } elseif ($named) {
                throw new SyntaxError(sprintf('Positional arguments cannot be used after named arguments for %s "%s".', $callType, $callName), $this->getTemplateLine(), $this->getSourceContext());
            }
            $parameters[$name] = $node;
        }
        $isVariadic = $this->hasAttribute('is_variadic') && $this->getAttribute('is_variadic');
        if (!$named && !$isVariadic) {
            return $parameters;
        }
        if (!$callable) {
            if ($named) {
                $message = sprintf('Named arguments are not supported for %s "%s".', $callType, $callName);
            } else {
                $message = sprintf('Arbitrary positional arguments are not supported for %s "%s".', $callType, $callName);
            }
            throw new \LogicException($message);
        }
        list($callableParameters, $isPhpVariadic) = $this->getCallableParameters($callable, $isVariadic);
        $arguments = [];
        $names = [];
        $missingArguments = [];
        $optionalArguments = [];
        $pos = 0;
        foreach ($callableParameters as $callableParameter) {
            $names[] = $name = $this->normalizeName($callableParameter->name);
            if (\array_key_exists($name, $parameters)) {
                if (\array_key_exists($pos, $parameters)) {
                    throw new SyntaxError(sprintf('Argument "%s" is defined twice for %s "%s".', $name, $callType, $callName), $this->getTemplateLine(), $this->getSourceContext());
                }
                if (\count($missingArguments)) {
                    throw new SyntaxError(sprintf('Argument "%s" could not be assigned for %s "%s(%s)" because it is mapped to an internal PHP function which cannot determine default value for optional argument%s "%s".', $name, $callType, $callName, implode(', ', $names), \count($missingArguments) > 1 ? 's' : '', implode('", "', $missingArguments)), $this->getTemplateLine(), $this->getSourceContext());
                }
                $arguments = array_merge($arguments, $optionalArguments);
                $arguments[] = $parameters[$name];
                unset($parameters[$name]);
                $optionalArguments = [];
            } elseif (\array_key_exists($pos, $parameters)) {
                $arguments = array_merge($arguments, $optionalArguments);
                $arguments[] = $parameters[$pos];
                unset($parameters[$pos]);
                $optionalArguments = [];
                ++$pos;
            } elseif ($callableParameter->isDefaultValueAvailable()) {
                $optionalArguments[] = new ConstantExpression($callableParameter->getDefaultValue(), -1);
            } elseif ($callableParameter->isOptional()) {
                if (empty($parameters)) {
                    break;
                } else {
                    $missingArguments[] = $name;
                }
            } else {
                throw new SyntaxError(sprintf('Value for argument "%s" is required for %s "%s".', $name, $callType, $callName), $this->getTemplateLine(), $this->getSourceContext());
            }
        }
        if ($isVariadic) {
            $arbitraryArguments = $isPhpVariadic ? new VariadicExpression([], -1) : new ArrayExpression([], -1);
            foreach ($parameters as $key => $value) {
                if (\is_int($key)) {
                    $arbitraryArguments->addElement($value);
                } else {
                    $arbitraryArguments->addElement($value, new ConstantExpression($key, -1));
                }
                unset($parameters[$key]);
            }
            if ($arbitraryArguments->count()) {
                $arguments = array_merge($arguments, $optionalArguments);
                $arguments[] = $arbitraryArguments;
            }
        }
        if (!empty($parameters)) {
            $unknownParameter = null;
            foreach ($parameters as $parameter) {
                if ($parameter instanceof Node) {
                    $unknownParameter = $parameter;
                    break;
                }
            }
            throw new SyntaxError(sprintf('Unknown argument%s "%s" for %s "%s(%s)".', \count($parameters) > 1 ? 's' : '', implode('", "', array_keys($parameters)), $callType, $callName, implode(', ', $names)), $unknownParameter ? $unknownParameter->getTemplateLine() : $this->getTemplateLine(), $unknownParameter ? $unknownParameter->getSourceContext() : $this->getSourceContext());
        }
        return $arguments;
    }
    protected function normalizeName($name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("normalizeName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Expression/CallExpression.php at line 193")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called normalizeName:193@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Expression/CallExpression.php');
        die();
    }
    private function getCallableParameters($callable, bool $isVariadic) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCallableParameters") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Expression/CallExpression.php at line 197")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCallableParameters:197@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Expression/CallExpression.php');
        die();
    }
    private function reflectCallable($callable)
    {
        if (null !== $this->reflector) {
            return $this->reflector;
        }
        if (\is_array($callable)) {
            if (!method_exists($callable[0], $callable[1])) {
                // __call()
                return [null, []];
            }
            $r = new \ReflectionMethod($callable[0], $callable[1]);
        } elseif (\is_object($callable) && !$callable instanceof \Closure) {
            $r = new \ReflectionObject($callable);
            $r = $r->getMethod('__invoke');
            $callable = [$callable, '__invoke'];
        } elseif (\is_string($callable) && false !== ($pos = strpos($callable, '::'))) {
            $class = substr($callable, 0, $pos);
            $method = substr($callable, $pos + 2);
            if (!method_exists($class, $method)) {
                // __staticCall()
                return [null, []];
            }
            $r = new \ReflectionMethod($callable);
            $callable = [$class, $method];
        } else {
            $r = new \ReflectionFunction($callable);
        }
        return $this->reflector = [$r, $callable];
    }
}
class_alias('Twig\\Node\\Expression\\CallExpression', 'Twig_Node_Expression_Call');