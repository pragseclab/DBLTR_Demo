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
/* login/footer.twig */
class __TwigTemplate_337dd59ee12050542221fef23794b8185e91f3842a8d5d6c8965ceac5a07e37b extends \Twig\Template
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
        echo "</div>\n";
        // line 2
        if (($context["check_timeout"] ?? null) == true) {
            // line 3
            echo "    </div>\n";
        }
    }
    public function getTemplateName()
    {
        return "login/footer.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(42 => 3, 40 => 2, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "login/footer.twig", "/var/www/html/phpMyAdmin/templates/login/footer.twig");
    }
}