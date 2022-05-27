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
namespace Twig\Node\Expression;

use Twig\Compiler;
class NameExpression extends AbstractExpression
{
    private $specialVars = array('_self' => '$this->getTemplateName()', '_context' => '$context', '_charset' => '$this->env->getCharset()');
    public function __construct(string $name, int $lineno)
    {
        parent::__construct([], ['name' => $name, 'is_defined_test' => false, 'ignore_strict_check' => false, 'always_defined' => false], $lineno);
    }
    public function compile(Compiler $compiler)
    {
        $name = $this->getAttribute('name');
        $compiler->addDebugInfo($this);
        if ($this->getAttribute('is_defined_test')) {
            if ($this->isSpecial()) {
                $compiler->repr(true);
            } elseif (\PHP_VERSION_ID >= 70400) {
                $compiler->raw('array_key_exists(')->string($name)->raw(', $context)');
            } else {
                $compiler->raw('(isset($context[')->string($name)->raw(']) || array_key_exists(')->string($name)->raw(', $context))');
            }
        } elseif ($this->isSpecial()) {
            $compiler->raw($this->specialVars[$name]);
        } elseif ($this->getAttribute('always_defined')) {
            $compiler->raw('$context[')->string($name)->raw(']');
        } else {
            if ($this->getAttribute('ignore_strict_check') || !$compiler->getEnvironment()->isStrictVariables()) {
                $compiler->raw('($context[')->string($name)->raw('] ?? null)');
            } else {
                $compiler->raw('(isset($context[')->string($name)->raw(']) || array_key_exists(')->string($name)->raw(', $context) ? $context[')->string($name)->raw('] : (function () { throw new RuntimeError(\'Variable ')->string($name)->raw(' does not exist.\', ')->repr($this->lineno)->raw(', $this->source); })()')->raw(')');
            }
        }
    }
    public function isSpecial()
    {
        return isset($this->specialVars[$this->getAttribute('name')]);
    }
    public function isSimple()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isSimple") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Node/Expression/NameExpression.php at line 52")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isSimple:52@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/vendor/twig/twig/src/Node/Expression/NameExpression.php');
        die();
    }
}
class_alias('Twig\\Node\\Expression\\NameExpression', 'Twig_Node_Expression_Name');