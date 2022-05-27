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

use Twig\Node\Expression\FilterExpression;
use Twig\Node\Node;
/**
 * Represents a template filter.
 *
 * @final since Twig 2.4.0
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @see https://twig.symfony.com/doc/templates.html#filters
 */
class TwigFilter
{
    private $name;
    private $callable;
    private $options;
    private $arguments = array();
    /**
     * Creates a template filter.
     *
     * @param string        $name     Name of this filter
     * @param callable|null $callable A callable implementing the filter. If null, you need to overwrite the "node_class" option to customize compilation.
     * @param array         $options  Options array
     */
    public function __construct(string $name, $callable = null, array $options = array())
    {
        if (__CLASS__ !== static::class) {
            @trigger_error('Overriding ' . __CLASS__ . ' is deprecated since Twig 2.4.0 and the class will be final in 3.0.', E_USER_DEPRECATED);
        }
        $this->name = $name;
        $this->callable = $callable;
        $this->options = array_merge(['needs_environment' => false, 'needs_context' => false, 'is_variadic' => false, 'is_safe' => null, 'is_safe_callback' => null, 'pre_escape' => null, 'preserves_safety' => null, 'node_class' => FilterExpression::class, 'deprecated' => false, 'alternative' => null], $options);
    }
    public function getName()
    {
        return $this->name;
    }
    /**
     * Returns the callable to execute for this filter.
     *
     * @return callable|null
     */
    public function getCallable()
    {
        return $this->callable;
    }
    public function getNodeClass()
    {
        return $this->options['node_class'];
    }
    public function setArguments($arguments)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setArguments") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/twig/twig/src/TwigFilter.php at line 65")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setArguments:65@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/twig/twig/src/TwigFilter.php');
        die();
    }
    public function getArguments()
    {
        return $this->arguments;
    }
    public function needsEnvironment()
    {
        return $this->options['needs_environment'];
    }
    public function needsContext()
    {
        return $this->options['needs_context'];
    }
    public function getSafe(Node $filterArgs)
    {
        if (null !== $this->options['is_safe']) {
            return $this->options['is_safe'];
        }
        if (null !== $this->options['is_safe_callback']) {
            return $this->options['is_safe_callback']($filterArgs);
        }
    }
    public function getPreservesSafety()
    {
        return $this->options['preserves_safety'];
    }
    public function getPreEscape()
    {
        return $this->options['pre_escape'];
    }
    public function isVariadic()
    {
        return $this->options['is_variadic'];
    }
    public function isDeprecated()
    {
        return (bool) $this->options['deprecated'];
    }
    public function getDeprecatedVersion()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDeprecatedVersion") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/twig/twig/src/TwigFilter.php at line 106")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDeprecatedVersion:106@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/twig/twig/src/TwigFilter.php');
        die();
    }
    public function getAlternative()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getAlternative") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/twig/twig/src/TwigFilter.php at line 110")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getAlternative:110@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/vendor/twig/twig/src/TwigFilter.php');
        die();
    }
}
// For Twig 1.x compatibility
class_alias('Twig\\TwigFilter', 'Twig_SimpleFilter', false);
class_alias('Twig\\TwigFilter', 'Twig_Filter');
// Ensure that the aliased name is loaded to keep BC for classes implementing the typehint with the old aliased name.
class_exists('Twig\\Node\\Node');