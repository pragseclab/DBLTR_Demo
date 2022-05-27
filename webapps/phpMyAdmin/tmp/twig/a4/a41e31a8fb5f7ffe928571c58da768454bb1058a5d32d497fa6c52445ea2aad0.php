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
/* footer.twig */
class __TwigTemplate_b8174d24517faff9c93d538d9688a465df5927e4145fa66eafd216f4f5e837f5 extends \Twig\Template
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
        if (!($context["is_ajax"] ?? null)) {
            // line 2
            echo "  </div>\n";
        }
        // line 4
        if (!($context["is_ajax"] ?? null) && !($context["is_minimal"] ?? null)) {
            // line 5
            echo "  ";
            echo $context["self_link"] ?? null;
            echo "\n\n  <div class=\"clearfloat\" id=\"pma_errors\">\n    ";
            // line 8
            echo $context["error_messages"] ?? null;
            echo "\n  </div>\n\n  ";
            // line 11
            echo $context["scripts"] ?? null;
            echo "\n\n  ";
            // line 13
            if ($context["is_demo"] ?? null) {
                // line 14
                echo "    <div id=\"pma_demo\">\n      ";
                // line 15
                echo $context["demo_message"] ?? null;
                echo "\n    </div>\n  ";
            }
            // line 18
            echo "\n  ";
            // line 19
            echo $context["footer"] ?? null;
            echo "\n";
        }
        // line 21
        if (!($context["is_ajax"] ?? null)) {
            // line 22
            echo "  </body>\n</html>\n";
        }
    }
    public function getTemplateName()
    {
        return "footer.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(84 => 22, 82 => 21, 77 => 19, 74 => 18, 68 => 15, 65 => 14, 63 => 13, 58 => 11, 52 => 8, 45 => 5, 43 => 4, 39 => 2, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "footer.twig", "/var/www/html/phpMyAdmin/templates/footer.twig");
    }
}