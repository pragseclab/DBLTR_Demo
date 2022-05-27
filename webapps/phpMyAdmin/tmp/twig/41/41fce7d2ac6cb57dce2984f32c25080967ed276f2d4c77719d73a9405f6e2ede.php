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
/* navigation/main.twig */
class __TwigTemplate_c2fc8cd8aa72b67cebfabe038d83bf55bf534a3d7957d3ad66ed51a812dfb09f extends \Twig\Template
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
            echo "  <div id=\"pma_navigation\">\n    <div id=\"pma_navigation_resizer\"></div>\n    <div id=\"pma_navigation_collapser\"></div>\n    <div id=\"pma_navigation_content\">\n      <div id=\"pma_navigation_header\">\n\n        ";
            // line 8
            if (twig_get_attribute($this->env, $this->source, $context["logo"] ?? null, "is_displayed", [], "any", false, false, false, 8)) {
                // line 9
                echo "          <div id=\"pmalogo\">\n            ";
                // line 10
                if (twig_get_attribute($this->env, $this->source, $context["logo"] ?? null, "has_link", [], "any", false, false, false, 10)) {
                    // line 11
                    echo "              <a href=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["logo"] ?? null, "link", [], "any", true, true, false, 11) ? _twig_default_filter(twig_get_attribute($this->env, $this->source, $context["logo"] ?? null, "link", [], "any", false, false, false, 11), "#") : "#", "html", null, true);
                    echo "\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["logo"] ?? null, "attributes", [], "any", false, false, false, 11), "html", null, true);
                    echo ">\n            ";
                }
                // line 13
                echo "            ";
                if (!twig_test_empty(twig_get_attribute($this->env, $this->source, $context["logo"] ?? null, "source", [], "any", false, false, false, 13))) {
                    // line 14
                    echo "              <img id=\"imgpmalogo\" src=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["logo"] ?? null, "source", [], "any", false, false, false, 14), "html", null, true);
                    echo "\" alt=\"phpMyAdmin\">\n            ";
                } else {
                    // line 16
                    echo "              <h1>phpMyAdmin</h1>\n            ";
                }
                // line 18
                echo "            ";
                if (twig_get_attribute($this->env, $this->source, $context["logo"] ?? null, "has_link", [], "any", false, false, false, 18)) {
                    // line 19
                    echo "              </a>\n            ";
                }
                // line 21
                echo "          </div>\n        ";
            }
            // line 23
            echo "\n        <div id=\"navipanellinks\">\n          <a href=\"";
            // line 25
            echo PhpMyAdmin\Url::getFromRoute("/");
            echo "\" title=\"";
            echo _gettext("Home");
            echo "\">";
            // line 26
            echo \PhpMyAdmin\Html\Generator::getImage("b_home", _gettext("Home"));
            // line 27
            echo "</a>\n\n          ";
            // line 29
            if (($context["server"] ?? null) != 0) {
                // line 30
                echo "            <a class=\"logout disableAjax\" href=\"";
                echo PhpMyAdmin\Url::getFromRoute("/logout");
                echo "\" title=\"";
                echo twig_escape_filter($this->env, ($context["auth_type"] ?? null) == "config" ? _gettext("Empty session data") : _gettext("Log out"), "html", null, true);
                echo "\">";
                // line 31
                echo \PhpMyAdmin\Html\Generator::getImage("s_loggoff", ($context["auth_type"] ?? null) == "config" ? _gettext("Empty session data") : _gettext("Log out"));
                // line 32
                echo "</a>\n          ";
            }
            // line 34
            echo "\n          <a href=\"";
            // line 35
            echo \PhpMyAdmin\Html\MySQLDocumentation::getDocumentationLink("index");
            echo "\" title=\"";
            echo _gettext("phpMyAdmin documentation");
            echo "\" target=\"_blank\" rel=\"noopener\">";
            // line 36
            echo \PhpMyAdmin\Html\Generator::getImage("b_docs", _gettext("phpMyAdmin documentation"));
            // line 37
            echo "</a>\n\n          <a href=\"";
            // line 39
            echo PhpMyAdmin\Util::getdocuURL($context["is_mariadb"] ?? null);
            echo "\" title=\"";
            echo twig_escape_filter($this->env, $context["is_mariadb"] ?? null ? _gettext("MariaDB Documentation") : _gettext("MySQL Documentation"), "html", null, true);
            echo "\" target=\"_blank\" rel=\"noopener noreferrer\">";
            // line 40
            echo \PhpMyAdmin\Html\Generator::getImage("b_sqlhelp", $context["is_mariadb"] ?? null ? _gettext("MariaDB Documentation") : _gettext("MySQL Documentation"));
            // line 41
            echo "</a>\n\n          <a id=\"pma_navigation_settings_icon\"";
            // line 43
            echo !($context["is_navigation_settings_enabled"] ?? null) ? " class=\"hide\"" : "";
            echo " href=\"#\" title=\"";
            echo _gettext("Navigation panel settings");
            echo "\">";
            // line 44
            echo \PhpMyAdmin\Html\Generator::getImage("s_cog", _gettext("Navigation panel settings"));
            // line 45
            echo "</a>\n\n          <a id=\"pma_navigation_reload\" href=\"#\" title=\"";
            // line 47
            echo _gettext("Reload navigation panel");
            echo "\">";
            // line 48
            echo \PhpMyAdmin\Html\Generator::getImage("s_reload", _gettext("Reload navigation panel"));
            // line 49
            echo "</a>\n        </div>\n\n        ";
            // line 52
            if (($context["is_servers_displayed"] ?? null) && twig_length_filter($this->env, $context["servers"] ?? null) > 1) {
                // line 53
                echo "          <div id=\"serverChoice\">\n            ";
                // line 54
                echo $context["server_select"] ?? null;
                echo "\n          </div>\n        ";
            }
            // line 57
            echo "\n        ";
            // line 58
            echo \PhpMyAdmin\Html\Generator::getImage("ajax_clock_small", _gettext("Loading…"), ["style" => "visibility: hidden; display:none", "class" => "throbber"]);
            // line 61
            echo "\n      </div>\n      <div id=\"pma_navigation_tree\" class=\"list_container";
            // line 63
            echo $context["is_synced"] ?? null ? " synced" : "";
            echo $context["is_highlighted"] ?? null ? " highlight" : "";
            echo $context["is_autoexpanded"] ?? null ? " autoexpand" : "";
            echo "\">\n";
        }
        // line 65
        echo "\n";
        // line 66
        if (!($context["navigation_tree"] ?? null)) {
            // line 67
            echo "  ";
            echo call_user_func_array($this->env->getFilter('error')->getCallable(), [_gettext("An error has occurred while loading the navigation display")]);
            echo "\n";
        } else {
            // line 69
            echo "  ";
            echo $context["navigation_tree"] ?? null;
            echo "\n";
        }
        // line 71
        echo "\n";
        // line 72
        if (!($context["is_ajax"] ?? null)) {
            // line 73
            echo "      </div>\n\n      <div id=\"pma_navi_settings_container\">\n        ";
            // line 76
            if ($context["is_navigation_settings_enabled"] ?? null) {
                // line 77
                echo "          ";
                echo $context["navigation_settings"] ?? null;
                echo "\n        ";
            }
            // line 79
            echo "      </div>\n    </div>\n\n    ";
            // line 82
            if ($context["is_drag_drop_import_enabled"] ?? null) {
                // line 83
                echo "      <div class=\"pma_drop_handler\">\n        ";
                // line 84
                echo _gettext("Drop files here");
                // line 85
                echo "      </div>\n      <div class=\"pma_sql_import_status\">\n        <h2>\n          ";
                // line 88
                echo _gettext("SQL upload");
                // line 89
                echo "          ( <span class=\"pma_import_count\">0</span> )\n          <span class=\"close\">x</span>\n          <span class=\"minimize\">-</span>\n        </h2>\n        <div></div>\n      </div>\n    ";
            }
            // line 96
            echo "  </div>\n";
        }
    }
    public function getTemplateName()
    {
        return "navigation/main.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(251 => 96, 242 => 89, 240 => 88, 235 => 85, 233 => 84, 230 => 83, 228 => 82, 223 => 79, 217 => 77, 215 => 76, 210 => 73, 208 => 72, 205 => 71, 199 => 69, 193 => 67, 191 => 66, 188 => 65, 181 => 63, 177 => 61, 175 => 58, 172 => 57, 166 => 54, 163 => 53, 161 => 52, 156 => 49, 154 => 48, 151 => 47, 147 => 45, 145 => 44, 140 => 43, 136 => 41, 134 => 40, 129 => 39, 125 => 37, 123 => 36, 118 => 35, 115 => 34, 111 => 32, 109 => 31, 103 => 30, 101 => 29, 97 => 27, 95 => 26, 90 => 25, 86 => 23, 82 => 21, 78 => 19, 75 => 18, 71 => 16, 65 => 14, 62 => 13, 54 => 11, 52 => 10, 49 => 9, 47 => 8, 39 => 2, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "navigation/main.twig", "/var/www/html/phpMyAdmin/templates/navigation/main.twig");
    }
}