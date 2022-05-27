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
/* header.twig */
class __TwigTemplate_0bb1d0c53618781ace3f7137fd50c25463fcbd4a3d76c0c186ca628934246062 extends \Twig\Template
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
        echo "<!doctype html>\n<html lang=\"";
        // line 2
        echo twig_escape_filter($this->env, $context["lang"] ?? null, "html", null, true);
        echo "\" dir=\"";
        echo twig_escape_filter($this->env, $context["text_dir"] ?? null, "html", null, true);
        echo "\">\n<head>\n  <meta charset=\"utf-8\">\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n  <meta name=\"referrer\" content=\"no-referrer\">\n  <meta name=\"robots\" content=\"noindex,nofollow\">\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=Edge\">\n  ";
        // line 9
        if (!($context["allow_third_party_framing"] ?? null)) {
            // line 10
            echo "<style id=\"cfs-style\">html{display: none;}</style>";
        }
        // line 12
        echo "\n  <link rel=\"icon\" href=\"favicon.ico\" type=\"image/x-icon\">\n  <link rel=\"shortcut icon\" href=\"favicon.ico\" type=\"image/x-icon\">\n  ";
        // line 15
        if ($context["is_print_view"] ?? null) {
            // line 16
            echo "    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            echo twig_escape_filter($this->env, $context["base_dir"] ?? null, "html", null, true);
            echo "print.css?";
            echo twig_escape_filter($this->env, $context["version"] ?? null, "html", null, true);
            echo "\">\n  ";
        } else {
            // line 18
            echo "    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            echo twig_escape_filter($this->env, $context["theme_path"] ?? null, "html", null, true);
            echo "/jquery/jquery-ui.css\">\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            // line 19
            echo twig_escape_filter($this->env, $context["base_dir"] ?? null, "html", null, true);
            echo "js/vendor/codemirror/lib/codemirror.css?";
            echo twig_escape_filter($this->env, $context["version"] ?? null, "html", null, true);
            echo "\">\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            // line 20
            echo twig_escape_filter($this->env, $context["base_dir"] ?? null, "html", null, true);
            echo "js/vendor/codemirror/addon/hint/show-hint.css?";
            echo twig_escape_filter($this->env, $context["version"] ?? null, "html", null, true);
            echo "\">\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            // line 21
            echo twig_escape_filter($this->env, $context["base_dir"] ?? null, "html", null, true);
            echo "js/vendor/codemirror/addon/lint/lint.css?";
            echo twig_escape_filter($this->env, $context["version"] ?? null, "html", null, true);
            echo "\">\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            // line 22
            echo twig_escape_filter($this->env, $context["theme_path"] ?? null, "html", null, true);
            echo "/css/theme";
            echo ($context["text_dir"] ?? null) == "rtl" ? "-rtl" : "";
            echo ".css?";
            echo twig_escape_filter($this->env, $context["version"] ?? null, "html", null, true);
            echo "&nocache=";
            // line 23
            echo twig_escape_filter($this->env, $context["unique_value"] ?? null, "html", null, true);
            echo twig_escape_filter($this->env, $context["text_dir"] ?? null, "html", null, true);
            if (!twig_test_empty($context["server"] ?? null)) {
                echo "&server=";
                echo twig_escape_filter($this->env, $context["server"] ?? null, "html", null, true);
            }
            echo "\">\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            // line 24
            echo twig_escape_filter($this->env, $context["theme_path"] ?? null, "html", null, true);
            echo "/css/printview.css?";
            echo twig_escape_filter($this->env, $context["version"] ?? null, "html", null, true);
            echo "\" media=\"print\" id=\"printcss\">\n  ";
        }
        // line 26
        echo "  <title>";
        echo twig_escape_filter($this->env, $context["title"] ?? null, "html", null, true);
        echo "</title>\n  ";
        // line 27
        echo $context["scripts"] ?? null;
        echo "\n  <noscript><style>html{display:block}</style></noscript>\n</head>\n<body";
        // line 30
        !twig_test_empty($context["body_id"] ?? null) ? print twig_escape_filter($this->env, " id=" . ($context["body_id"] ?? null), "html", null, true) : (print "");
        echo ">\n  ";
        // line 31
        echo $context["navigation"] ?? null;
        echo "\n  ";
        // line 32
        echo $context["custom_header"] ?? null;
        echo "\n  ";
        // line 33
        echo $context["load_user_preferences"] ?? null;
        echo "\n\n  ";
        // line 35
        if (!($context["show_hint"] ?? null)) {
            // line 36
            echo "    <span id=\"no_hint\" class=\"hide\"></span>\n  ";
        }
        // line 38
        echo "\n  ";
        // line 39
        if ($context["is_warnings_enabled"] ?? null) {
            // line 40
            echo "    <noscript>\n      ";
            // line 41
            echo call_user_func_array($this->env->getFilter('error')->getCallable(), [_gettext("Javascript must be enabled past this point!")]);
            echo "\n    </noscript>\n  ";
        }
        // line 44
        echo "\n  ";
        // line 45
        if (($context["is_menu_enabled"] ?? null) && ($context["server"] ?? null) > 0) {
            // line 46
            echo "    ";
            echo $context["menu"] ?? null;
            echo "\n    <span id=\"page_nav_icons\">\n      <span id=\"lock_page_icon\"></span>\n      <span id=\"page_settings_icon\">\n        ";
            // line 50
            echo \PhpMyAdmin\Html\Generator::getImage("s_cog", _gettext("Page-related settings"));
            echo "\n      </span>\n      <a id=\"goto_pagetop\" href=\"#\">";
            // line 52
            echo \PhpMyAdmin\Html\Generator::getImage("s_top", _gettext("Click on the bar to scroll to top of page"));
            echo "</a>\n    </span>\n  ";
        }
        // line 55
        echo "\n  ";
        // line 56
        echo $context["console"] ?? null;
        echo "\n\n  <div id=\"page_content\">\n    ";
        // line 59
        echo $context["messages"] ?? null;
        echo "\n\n    ";
        // line 61
        echo $context["recent_table"] ?? null;
        echo "\n";
    }
    public function getTemplateName()
    {
        return "header.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(204 => 61, 199 => 59, 193 => 56, 190 => 55, 184 => 52, 179 => 50, 171 => 46, 169 => 45, 166 => 44, 160 => 41, 157 => 40, 155 => 39, 152 => 38, 148 => 36, 146 => 35, 141 => 33, 137 => 32, 133 => 31, 129 => 30, 123 => 27, 118 => 26, 111 => 24, 102 => 23, 95 => 22, 89 => 21, 83 => 20, 77 => 19, 72 => 18, 64 => 16, 62 => 15, 57 => 12, 54 => 10, 52 => 9, 40 => 2, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "header.twig", "/var/www/html/phpMyAdmin/templates/header.twig");
    }
}