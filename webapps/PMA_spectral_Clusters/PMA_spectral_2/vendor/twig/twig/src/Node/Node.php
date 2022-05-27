<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig\Node;

use Twig\Compiler;
use Twig\Source;
/**
 * Represents a node in the AST.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Node implements \Countable, \IteratorAggregate
{
    protected $nodes;
    protected $attributes;
    protected $lineno;
    protected $tag;
    private $name;
    private $sourceContext;
    /**
     * @param array  $nodes      An array of named nodes
     * @param array  $attributes An array of attributes (should not be nodes)
     * @param int    $lineno     The line number
     * @param string $tag        The tag name associated with the Node
     */
    public function __construct(array $nodes = array(), array $attributes = array(), int $lineno = 0, string $tag = null)
    {
        foreach ($nodes as $name => $node) {
            if (!$node instanceof self) {
                throw new \InvalidArgumentException(sprintf('Using "%s" for the value of node "%s" of "%s" is not supported. You must pass a \\Twig\\Node\\Node instance.', \is_object($node) ? \get_class($node) : (null === $node ? 'null' : \gettype($node)), $name, static::class));
            }
        }
        $this->nodes = $nodes;
        $this->attributes = $attributes;
        $this->lineno = $lineno;
        $this->tag = $tag;
    }
    public function __toString()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__toString") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Node.php at line 49")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __toString:49@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Node.php');
        die();
    }
    public function compile(Compiler $compiler)
    {
        foreach ($this->nodes as $node) {
            $node->compile($compiler);
        }
    }
    public function getTemplateLine()
    {
        return $this->lineno;
    }
    public function getNodeTag()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getNodeTag") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Node.php at line 81")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getNodeTag:81@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Node.php');
        die();
    }
    /**
     * @return bool
     */
    public function hasAttribute($name)
    {
        return \array_key_exists($name, $this->attributes);
    }
    /**
     * @return mixed
     */
    public function getAttribute($name)
    {
        if (!\array_key_exists($name, $this->attributes)) {
            throw new \LogicException(sprintf('Attribute "%s" does not exist for Node "%s".', $name, static::class));
        }
        return $this->attributes[$name];
    }
    /**
     * @param string $name
     * @param mixed  $value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }
    public function removeAttribute($name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("removeAttribute") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Node.php at line 110")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called removeAttribute:110@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/twig/twig/src/Node/Node.php');
        die();
    }
    /**
     * @return bool
     */
    public function hasNode($name)
    {
        return isset($this->nodes[$name]);
    }
    /**
     * @return Node
     */
    public function getNode($name)
    {
        if (!isset($this->nodes[$name])) {
            throw new \LogicException(sprintf('Node "%s" does not exist for Node "%s".', $name, static::class));
        }
        return $this->nodes[$name];
    }
    public function setNode($name, self $node)
    {
        $this->nodes[$name] = $node;
    }
    public function removeNode($name)
    {
        unset($this->nodes[$name]);
    }
    public function count()
    {
        return \count($this->nodes);
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->nodes);
    }
    /**
     * @deprecated since 2.8 (to be removed in 3.0)
     */
    public function setTemplateName($name)
    {
        $triggerDeprecation = 2 > \func_num_args() || \func_get_arg(1);
        if ($triggerDeprecation) {
            @trigger_error('The ' . __METHOD__ . ' method is deprecated since version 2.8 and will be removed in 3.0. Use setSourceContext() instead.', E_USER_DEPRECATED);
        }
        $this->name = $name;
        foreach ($this->nodes as $node) {
            $node->setTemplateName($name, $triggerDeprecation);
        }
    }
    public function getTemplateName()
    {
        return $this->sourceContext ? $this->sourceContext->getName() : null;
    }
    public function setSourceContext(Source $source)
    {
        $this->sourceContext = $source;
        foreach ($this->nodes as $node) {
            $node->setSourceContext($source);
        }
        $this->setTemplateName($source->getName(), false);
    }
    public function getSourceContext()
    {
        return $this->sourceContext;
    }
}
class_alias('Twig\\Node\\Node', 'Twig_Node');
// Ensure that the aliased name is loaded to keep BC for classes implementing the typehint with the old aliased name.
class_exists('Twig\\Compiler');