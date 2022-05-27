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
/* error/generic.twig */
class __TwigTemplate_68bf449a7934965aa7152bc334b54f5dd8b875853c4a0fcca3db6752070730b6 extends \Twig\Template
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
        echo "<!DOCTYPE HTML>\n<html lang=\"";
        // line 2
        echo twig_escape_filter($this->env, $context["lang"] ?? null, "html", null, true);
        echo "\" dir=\"";
        echo twig_escape_filter($this->env, $context["dir"] ?? null, "html", null, true);
        echo "\">\n<head>\n    <link rel=\"icon\" href=\"favicon.ico\" type=\"image/x-icon\">\n    <link rel=\"shortcut icon\" href=\"favicon.ico\" type=\"image/x-icon\">\n    <title>phpMyAdmin</title>\n    <meta charset=\"utf-8\">\n    <style type=\"text/css\">\n        html {\n            padding: 0;\n            margin: 0;\n        }\n        body  {\n            font-family: sans-serif;\n            font-size: small;\n            color: #000000;\n            background-color: #F5F5F5;\n            margin: 1em;\n        }\n        h1 {\n            margin: 0;\n            padding: 0.3em;\n            font-size: 1.4em;\n            font-weight: bold;\n            color: #ffffff;\n            background-color: #ff0000;\n        }\n        p {\n            margin: 0;\n            padding: 0.5em;\n            border: 0.1em solid red;\n            background-color: #ffeeee;\n        }\n    </style>\n</head>\n<body>\n<h1>phpMyAdmin - ";
        // line 37
        echo _gettext("Error");
        echo "</h1>\n<p>";
        // line 38
        echo $context["error_message"] ?? null;
        echo "</p>\n</body>\n</html>\n";
    }
    public function getTemplateName()
    {
        return "error/generic.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(84 => 38, 80 => 37, 40 => 2, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "error/generic.twig", "/var/www/html/phpMyAdmin/templates/error/generic.twig");
    }
}