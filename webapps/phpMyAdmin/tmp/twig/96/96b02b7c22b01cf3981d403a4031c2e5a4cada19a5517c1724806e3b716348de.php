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
/* message.twig */
class __TwigTemplate_e3442ac802855c6ce03f27e70cf168ebfac8f7334cefde8815c2a0e8cc861504 extends \Twig\Template
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
        echo "<div class=\"alert alert-";
        echo twig_escape_filter($this->env, $context["context"] ?? null, "html", null, true);
        echo "\" role=\"alert\">\n  ";
        // line 2
        echo $context["message"] ?? null;
        echo "\n</div>\n";
    }
    public function getTemplateName()
    {
        return "message.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(42 => 2, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "message.twig", "/var/www/html/phpMyAdmin/templates/message.twig");
    }
}