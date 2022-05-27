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
/* navigation/tree/state.twig */
class __TwigTemplate_34ad98a4056606d1b894cc3354d7584dcffc390d623abedc0443f988b4ddbebf extends \Twig\Template
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
        echo $context["quick_warp"] ?? null;
        echo "\n\n<div class=\"clearfloat\"></div>\n\n<ul>\n  ";
        // line 6
        echo $context["fast_filter"] ?? null;
        echo "\n  ";
        // line 7
        echo $context["controls"] ?? null;
        echo "\n</ul>\n\n";
        // line 10
        echo $context["page_selector"] ?? null;
        echo "\n\n<div id='pma_navigation_tree_content'>\n  <ul>\n    ";
        // line 14
        echo $context["nodes"] ?? null;
        echo "\n  </ul>\n</div>\n";
    }
    public function getTemplateName()
    {
        return "navigation/tree/state.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(62 => 14, 55 => 10, 49 => 7, 45 => 6, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "navigation/tree/state.twig", "/var/www/html/phpMyAdmin/templates/navigation/tree/state.twig");
    }
}