<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
/* javascript/display.twig */
class __TwigTemplate_151421d17c8298143ca503feaee68f8f6115ea7c5e7e3d08fb490186a43f99d7 extends \Twig\Template
{
    private $source;
    private $macros = array();
    public function __construct(Environment $env)
    {
        parent::__construct($env);
        $this->source = $this->getSourceContext();
        $this->parent = false;
        $this->blocks = [];
    }
    protected function doDisplay(array $context, array $blocks = array())
    {
        $macros = $this->macros;
        // line 1
        echo "<script type=\"text/javascript\">\n    if (typeof configInlineParams === 'undefined' || !Array.isArray(configInlineParams)) {\n        configInlineParams = [];\n    }\n    configInlineParams.push(function () {\n        ";
        // line 6
        echo twig_join_filter($context["js_array"] ?? null, ";\n");
        echo ";\n    });\n    if (typeof configScriptLoaded !== 'undefined' && configInlineParams) {\n        loadInlineConfig();\n    }\n</script>\n";
    }
    public function getTemplateName()
    {
        return "javascript/display.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(44 => 6, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "javascript/display.twig", "/var/www/html/phpMyAdmin/templates/javascript/display.twig");
    }
}