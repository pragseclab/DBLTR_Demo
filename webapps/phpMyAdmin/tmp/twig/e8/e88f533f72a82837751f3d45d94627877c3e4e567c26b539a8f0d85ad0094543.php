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
/* server/privileges/user_overview.twig */
class __TwigTemplate_3a889b83e01144f7e9ad951f892bb82fe6c78c77d96c20d9c603e78d10263e86 extends \Twig\Template
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
        echo "<div class=\"row\">\n  <div class=\"col-12\">\n    <h2>\n      ";
        // line 4
        echo \PhpMyAdmin\Html\Generator::getIcon("b_usrlist");
        echo "\n      ";
        // line 5
        echo _gettext("User accounts overview");
        // line 6
        echo "    </h2>\n  </div>\n</div>\n\n";
        // line 10
        echo $context["error_messages"] ?? null;
        echo "\n\n";
        // line 12
        echo $context["empty_user_notice"] ?? null;
        echo "\n\n";
        // line 14
        echo $context["initials"] ?? null;
        echo "\n\n";
        // line 16
        if (!twig_test_empty($context["users_overview"] ?? null)) {
            // line 17
            echo "  ";
            echo $context["users_overview"] ?? null;
            echo "\n";
        } elseif ($context["is_createuser"] ?? null) {
            // line 19
            echo "  <div class=\"row\">\n    <div class=\"col-12\">\n      <fieldset id=\"fieldset_add_user\">\n        <legend>";
            // line 22
            echo _pgettext("Create new user", "New");
            echo "</legend>\n        <a id=\"add_user_anchor\" href=\"";
            // line 23
            echo PhpMyAdmin\Url::getFromRoute("/server/privileges", ["adduser" => true]);
            echo "\">\n          ";
            // line 24
            echo \PhpMyAdmin\Html\Generator::getIcon("b_usradd", _gettext("Add user account"));
            echo "\n        </a>\n      </fieldset>\n    </div>\n  </div>\n";
        }
        // line 30
        echo "\n";
        // line 31
        echo $context["flush_notice"] ?? null;
        echo "\n";
    }
    public function getTemplateName()
    {
        return "server/privileges/user_overview.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(103 => 31, 100 => 30, 91 => 24, 87 => 23, 83 => 22, 78 => 19, 76 => 18, 71 => 17, 69 => 16, 64 => 14, 59 => 12, 54 => 10, 48 => 6, 46 => 5, 42 => 4, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "server/privileges/user_overview.twig", "/var/www/html/phpMyAdmin/templates/server/privileges/user_overview.twig");
    }
}