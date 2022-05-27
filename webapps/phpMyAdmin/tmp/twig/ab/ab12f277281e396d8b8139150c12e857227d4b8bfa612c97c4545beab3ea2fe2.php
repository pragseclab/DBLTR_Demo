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
/* config/form_display/tabs_top.twig */
class __TwigTemplate_78381290471c2400736c3d1d8f039adf53f7ef583fd9e9b9077d699e216fe722 extends \Twig\Template
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
        echo "<ul class=\"tabs responsivetable row\">\n  ";
        // line 2
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($context["tabs"] ?? null);
        foreach ($context['_seq'] as $context["id"] => $context["name"]) {
            // line 3
            echo "    <li><a href=\"#";
            echo twig_escape_filter($this->env, $context["id"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["name"], "html", null, true);
            echo "</a></li>\n  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['name'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 5
        echo "</ul>\n<div class=\"tabs_contents col\">\n";
    }
    public function getTemplateName()
    {
        return "config/form_display/tabs_top.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(55 => 5, 44 => 3, 40 => 2, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "config/form_display/tabs_top.twig", "/var/www/html/phpMyAdmin/templates/config/form_display/tabs_top.twig");
    }
}