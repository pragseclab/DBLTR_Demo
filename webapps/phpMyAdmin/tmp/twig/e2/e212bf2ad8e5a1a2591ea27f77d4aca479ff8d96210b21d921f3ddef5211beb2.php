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
/* server/privileges/privileges_table.twig */
class __TwigTemplate_165f8c69dff425032243afcbac9bbaa4fa7650faf8dcf492292af0cb2c917b22 extends \Twig\Template
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
        if (!twig_test_empty($context["columns"] ?? null)) {
            // line 2
            echo "\n  <input type=\"hidden\" name=\"grant_count\" value=\"";
            // line 3
            echo twig_escape_filter($this->env, twig_length_filter($this->env, $context["row"] ?? null), "html", null, true);
            echo "\">\n  <input type=\"hidden\" name=\"column_count\" value=\"";
            // line 4
            echo twig_escape_filter($this->env, twig_length_filter($this->env, $context["columns"] ?? null), "html", null, true);
            echo "\">\n  <fieldset id=\"fieldset_user_priv\">\n    <legend data-submenu-label=\"";
            // line 6
            echo _gettext("Table");
            echo "\">\n      ";
            // line 7
            echo _gettext("Table-specific privileges");
            // line 8
            echo "    </legend>\n    <p>\n      <small><em>";
            // line 10
            echo _gettext("Note: MySQL privilege names are expressed in English.");
            echo "</em></small>\n    </p>\n\n    <div class=\"item\" id=\"div_item_select\">\n      <label for=\"select_select_priv\">\n        <code><dfn title=\"";
            // line 15
            echo _gettext("Allows reading data.");
            echo "\">SELECT</dfn></code>\n      </label>\n\n      <select id=\"select_select_priv\" name=\"Select_priv[]\" size=\"8\" multiple>\n        ";
            // line 19
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["columns"] ?? null);
            foreach ($context['_seq'] as $context["curr_col"] => $context["curr_col_privs"]) {
                // line 20
                echo "          <option value=\"";
                echo twig_escape_filter($this->env, $context["curr_col"], "html", null, true);
                echo "\"";
                echo (($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = $context["row"] ?? null) && is_array($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4) || $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 instanceof ArrayAccess ? $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4["Select_priv"] ?? null : null) == "Y" || (($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 = $context["curr_col_privs"]) && is_array($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144) || $__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 instanceof ArrayAccess ? $__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144["Select"] ?? null : null) ? " selected" : "";
                echo ">\n            ";
                // line 21
                echo twig_escape_filter($this->env, $context["curr_col"], "html", null, true);
                echo "\n          </option>\n        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['curr_col'], $context['curr_col_privs'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 24
            echo "      </select>\n\n      <em>";
            // line 26
            echo _gettext("Or");
            echo "</em>\n      <label for=\"checkbox_Select_priv_none\">\n        <input type=\"checkbox\" name=\"Select_priv_none\" id=\"checkbox_Select_priv_none\" title=\"";
            // line 29
            echo _pgettext("None privileges", "None");
            echo "\">\n        ";
            // line 30
            echo _pgettext("None privileges", "None");
            // line 31
            echo "      </label>\n    </div>\n\n    <div class=\"item\" id=\"div_item_insert\">\n      <label for=\"select_insert_priv\">\n        <code><dfn title=\"";
            // line 36
            echo _gettext("Allows inserting and replacing data.");
            echo "\">INSERT</dfn></code>\n      </label>\n\n      <select id=\"select_insert_priv\" name=\"Insert_priv[]\" size=\"8\" multiple>\n        ";
            // line 40
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["columns"] ?? null);
            foreach ($context['_seq'] as $context["curr_col"] => $context["curr_col_privs"]) {
                // line 41
                echo "          <option value=\"";
                echo twig_escape_filter($this->env, $context["curr_col"], "html", null, true);
                echo "\"";
                echo (($__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b = $context["row"] ?? null) && is_array($__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b) || $__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b instanceof ArrayAccess ? $__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b["Insert_priv"] ?? null : null) == "Y" || (($__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002 = $context["curr_col_privs"]) && is_array($__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002) || $__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002 instanceof ArrayAccess ? $__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002["Insert"] ?? null : null) ? " selected" : "";
                echo ">\n            ";
                // line 42
                echo twig_escape_filter($this->env, $context["curr_col"], "html", null, true);
                echo "\n          </option>\n        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['curr_col'], $context['curr_col_privs'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 45
            echo "      </select>\n\n      <em>";
            // line 47
            echo _gettext("Or");
            echo "</em>\n      <label for=\"checkbox_Insert_priv_none\">\n        <input type=\"checkbox\" name=\"Insert_priv_none\" id=\"checkbox_Insert_priv_none\" title=\"";
            // line 50
            echo _pgettext("None privileges", "None");
            echo "\">\n        ";
            // line 51
            echo _pgettext("None privileges", "None");
            // line 52
            echo "      </label>\n    </div>\n\n    <div class=\"item\" id=\"div_item_update\">\n      <label for=\"select_update_priv\">\n        <code><dfn title=\"";
            // line 57
            echo _gettext("Allows changing data.");
            echo "\">UPDATE</dfn></code>\n      </label>\n\n      <select id=\"select_update_priv\" name=\"Update_priv[]\" size=\"8\" multiple>\n        ";
            // line 61
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["columns"] ?? null);
            foreach ($context['_seq'] as $context["curr_col"] => $context["curr_col_privs"]) {
                // line 62
                echo "          <option value=\"";
                echo twig_escape_filter($this->env, $context["curr_col"], "html", null, true);
                echo "\"";
                echo (($__internal_d7fc55f1a54b629533d60b43063289db62e68921ee7a5f8de562bd9d4a2b7ad4 = $context["row"] ?? null) && is_array($__internal_d7fc55f1a54b629533d60b43063289db62e68921ee7a5f8de562bd9d4a2b7ad4) || $__internal_d7fc55f1a54b629533d60b43063289db62e68921ee7a5f8de562bd9d4a2b7ad4 instanceof ArrayAccess ? $__internal_d7fc55f1a54b629533d60b43063289db62e68921ee7a5f8de562bd9d4a2b7ad4["Update_priv"] ?? null : null) == "Y" || (($__internal_01476f8db28655ee4ee02ea2d17dd5a92599be76304f08cd8bc0e05aced30666 = $context["curr_col_privs"]) && is_array($__internal_01476f8db28655ee4ee02ea2d17dd5a92599be76304f08cd8bc0e05aced30666) || $__internal_01476f8db28655ee4ee02ea2d17dd5a92599be76304f08cd8bc0e05aced30666 instanceof ArrayAccess ? $__internal_01476f8db28655ee4ee02ea2d17dd5a92599be76304f08cd8bc0e05aced30666["Update"] ?? null : null) ? " selected" : "";
                echo ">\n            ";
                // line 63
                echo twig_escape_filter($this->env, $context["curr_col"], "html", null, true);
                echo "\n          </option>\n        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['curr_col'], $context['curr_col_privs'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 66
            echo "      </select>\n\n      <em>";
            // line 68
            echo _gettext("Or");
            echo "</em>\n      <label for=\"checkbox_Update_priv_none\">\n        <input type=\"checkbox\" name=\"Update_priv_none\" id=\"checkbox_Update_priv_none\" title=\"";
            // line 71
            echo _pgettext("None privileges", "None");
            echo "\">\n        ";
            // line 72
            echo _pgettext("None privileges", "None");
            // line 73
            echo "      </label>\n    </div>\n\n    <div class=\"item\" id=\"div_item_references\">\n      <label for=\"select_references_priv\">\n        <code><dfn title=\"";
            // line 78
            echo _gettext("Has no effect in this MySQL version.");
            echo "\">REFERENCES</dfn></code>\n      </label>\n\n      <select id=\"select_references_priv\" name=\"References_priv[]\" size=\"8\" multiple>\n        ";
            // line 82
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["columns"] ?? null);
            foreach ($context['_seq'] as $context["curr_col"] => $context["curr_col_privs"]) {
                // line 83
                echo "          <option value=\"";
                echo twig_escape_filter($this->env, $context["curr_col"], "html", null, true);
                echo "\"";
                echo (($__internal_01c35b74bd85735098add188b3f8372ba465b232ab8298cb582c60f493d3c22e = $context["row"] ?? null) && is_array($__internal_01c35b74bd85735098add188b3f8372ba465b232ab8298cb582c60f493d3c22e) || $__internal_01c35b74bd85735098add188b3f8372ba465b232ab8298cb582c60f493d3c22e instanceof ArrayAccess ? $__internal_01c35b74bd85735098add188b3f8372ba465b232ab8298cb582c60f493d3c22e["References_priv"] ?? null : null) == "Y" || (($__internal_63ad1f9a2bf4db4af64b010785e9665558fdcac0e8db8b5b413ed986c62dbb52 = $context["curr_col_privs"]) && is_array($__internal_63ad1f9a2bf4db4af64b010785e9665558fdcac0e8db8b5b413ed986c62dbb52) || $__internal_63ad1f9a2bf4db4af64b010785e9665558fdcac0e8db8b5b413ed986c62dbb52 instanceof ArrayAccess ? $__internal_63ad1f9a2bf4db4af64b010785e9665558fdcac0e8db8b5b413ed986c62dbb52["References"] ?? null : null) ? " selected" : "";
                echo ">\n            ";
                // line 84
                echo twig_escape_filter($this->env, $context["curr_col"], "html", null, true);
                echo "\n          </option>\n        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['curr_col'], $context['curr_col_privs'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 87
            echo "      </select>\n\n      <em>";
            // line 89
            echo _gettext("Or");
            echo "</em>\n      <label for=\"checkbox_References_priv_none\">\n        <input type=\"checkbox\" name=\"References_priv_none\" id=\"checkbox_References_priv_none\" title=\"";
            // line 92
            echo _pgettext("None privileges", "None");
            echo "\">\n        ";
            // line 93
            echo _pgettext("None privileges", "None");
            // line 94
            echo "      </label>\n    </div>\n\n    <div class=\"item\">\n      <div class=\"item\">\n        <input type=\"checkbox\" name=\"Delete_priv\" id=\"checkbox_Delete_priv\" value=\"Y\" title=\"";
            // line 100
            echo _gettext("Allows deleting data.");
            echo "\"";
            echo (($__internal_f10a4cc339617934220127f034125576ed229e948660ebac906a15846d52f136 = $context["row"] ?? null) && is_array($__internal_f10a4cc339617934220127f034125576ed229e948660ebac906a15846d52f136) || $__internal_f10a4cc339617934220127f034125576ed229e948660ebac906a15846d52f136 instanceof ArrayAccess ? $__internal_f10a4cc339617934220127f034125576ed229e948660ebac906a15846d52f136["Delete_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n        <label for=\"checkbox_Delete_priv\">\n          <code>\n            <dfn title=\"";
            // line 103
            echo _gettext("Allows deleting data.");
            echo "\">\n              DELETE\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        <input type=\"checkbox\" name=\"Create_priv\" id=\"checkbox_Create_priv\" value=\"Y\" title=\"";
            // line 112
            echo _gettext("Allows creating new tables.");
            echo "\"";
            echo (($__internal_887a873a4dc3cf8bd4f99c487b4c7727999c350cc3a772414714e49a195e4386 = $context["row"] ?? null) && is_array($__internal_887a873a4dc3cf8bd4f99c487b4c7727999c350cc3a772414714e49a195e4386) || $__internal_887a873a4dc3cf8bd4f99c487b4c7727999c350cc3a772414714e49a195e4386 instanceof ArrayAccess ? $__internal_887a873a4dc3cf8bd4f99c487b4c7727999c350cc3a772414714e49a195e4386["Create_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n        <label for=\"checkbox_Create_priv\">\n          <code>\n            <dfn title=\"";
            // line 115
            echo _gettext("Allows creating new tables.");
            echo "\">\n              CREATE\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        <input type=\"checkbox\" name=\"Drop_priv\" id=\"checkbox_Drop_priv\" value=\"Y\" title=\"";
            // line 124
            echo _gettext("Allows dropping tables.");
            echo "\"";
            echo (($__internal_d527c24a729d38501d770b40a0d25e1ce8a7f0bff897cc4f8f449ba71fcff3d9 = $context["row"] ?? null) && is_array($__internal_d527c24a729d38501d770b40a0d25e1ce8a7f0bff897cc4f8f449ba71fcff3d9) || $__internal_d527c24a729d38501d770b40a0d25e1ce8a7f0bff897cc4f8f449ba71fcff3d9 instanceof ArrayAccess ? $__internal_d527c24a729d38501d770b40a0d25e1ce8a7f0bff897cc4f8f449ba71fcff3d9["Drop_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n        <label for=\"checkbox_Drop_priv\">\n          <code>\n            <dfn title=\"";
            // line 127
            echo _gettext("Allows dropping tables.");
            echo "\">\n              DROP\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        <input type=\"checkbox\" name=\"Grant_priv\" id=\"checkbox_Grant_priv\" value=\"Y\" title=\"";
            // line 136
            echo _gettext("Allows user to give to other users or remove from other users the privileges that user possess yourself.");
            echo "\"";
            // line 137
            echo (($__internal_f6dde3a1020453fdf35e718e94f93ce8eb8803b28cc77a665308e14bbe8572ae = $context["row"] ?? null) && is_array($__internal_f6dde3a1020453fdf35e718e94f93ce8eb8803b28cc77a665308e14bbe8572ae) || $__internal_f6dde3a1020453fdf35e718e94f93ce8eb8803b28cc77a665308e14bbe8572ae instanceof ArrayAccess ? $__internal_f6dde3a1020453fdf35e718e94f93ce8eb8803b28cc77a665308e14bbe8572ae["Grant_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n        <label for=\"checkbox_Grant_priv\">\n          <code>\n            <dfn title=\"";
            // line 140
            echo _gettext("Allows user to give to other users or remove from other users the privileges that user possess yourself.");
            echo "\">\n              GRANT\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        <input type=\"checkbox\" name=\"Index_priv\" id=\"checkbox_Index_priv\" value=\"Y\" title=\"";
            // line 149
            echo _gettext("Allows creating and dropping indexes.");
            echo "\"";
            echo (($__internal_25c0fab8152b8dd6b90603159c0f2e8a936a09ab76edb5e4d7bc95d9a8d2dc8f = $context["row"] ?? null) && is_array($__internal_25c0fab8152b8dd6b90603159c0f2e8a936a09ab76edb5e4d7bc95d9a8d2dc8f) || $__internal_25c0fab8152b8dd6b90603159c0f2e8a936a09ab76edb5e4d7bc95d9a8d2dc8f instanceof ArrayAccess ? $__internal_25c0fab8152b8dd6b90603159c0f2e8a936a09ab76edb5e4d7bc95d9a8d2dc8f["Index_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n        <label for=\"checkbox_Index_priv\">\n          <code>\n            <dfn title=\"";
            // line 152
            echo _gettext("Allows creating and dropping indexes.");
            echo "\">\n              INDEX\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        <input type=\"checkbox\" name=\"Alter_priv\" id=\"checkbox_Alter_priv\" value=\"Y\" title=\"";
            // line 161
            echo _gettext("Allows altering the structure of existing tables.");
            echo "\"";
            echo (($__internal_f769f712f3484f00110c86425acea59f5af2752239e2e8596bcb6effeb425b40 = $context["row"] ?? null) && is_array($__internal_f769f712f3484f00110c86425acea59f5af2752239e2e8596bcb6effeb425b40) || $__internal_f769f712f3484f00110c86425acea59f5af2752239e2e8596bcb6effeb425b40 instanceof ArrayAccess ? $__internal_f769f712f3484f00110c86425acea59f5af2752239e2e8596bcb6effeb425b40["Alter_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n        <label for=\"checkbox_Alter_priv\">\n          <code>\n            <dfn title=\"";
            // line 164
            echo _gettext("Allows altering the structure of existing tables.");
            echo "\">\n              ALTER\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        <input type=\"checkbox\" name=\"Create_view_priv\" id=\"checkbox_Create_view_priv\" value=\"Y\" title=\"";
            // line 173
            echo _gettext("Allows creating new views.");
            echo "\"";
            echo (($__internal_98e944456c0f58b2585e4aa36e3a7e43f4b7c9038088f0f056004af41f4a007f = $context["row"] ?? null) && is_array($__internal_98e944456c0f58b2585e4aa36e3a7e43f4b7c9038088f0f056004af41f4a007f) || $__internal_98e944456c0f58b2585e4aa36e3a7e43f4b7c9038088f0f056004af41f4a007f instanceof ArrayAccess ? $__internal_98e944456c0f58b2585e4aa36e3a7e43f4b7c9038088f0f056004af41f4a007f["Create View_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n        <label for=\"checkbox_Create_view_priv\">\n          <code>\n            <dfn title=\"";
            // line 176
            echo _gettext("Allows creating new views.");
            echo "\">\n              CREATE VIEW\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        <input type=\"checkbox\" name=\"Show_view_priv\" id=\"checkbox_Show_view_priv\" value=\"Y\" title=\"";
            // line 185
            echo _gettext("Allows performing SHOW CREATE VIEW queries.");
            echo "\"";
            echo (($__internal_a06a70691a7ca361709a372174fa669f5ee1c1e4ed302b3a5b61c10c80c02760 = $context["row"] ?? null) && is_array($__internal_a06a70691a7ca361709a372174fa669f5ee1c1e4ed302b3a5b61c10c80c02760) || $__internal_a06a70691a7ca361709a372174fa669f5ee1c1e4ed302b3a5b61c10c80c02760 instanceof ArrayAccess ? $__internal_a06a70691a7ca361709a372174fa669f5ee1c1e4ed302b3a5b61c10c80c02760["Show view_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n        <label for=\"checkbox_Show_view_priv\">\n          <code>\n            <dfn title=\"";
            // line 188
            echo _gettext("Allows performing SHOW CREATE VIEW queries.");
            echo "\">\n              SHOW VIEW\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        <input type=\"checkbox\" name=\"Trigger_priv\" id=\"checkbox_Trigger_priv\" value=\"Y\" title=\"";
            // line 197
            echo _gettext("Allows creating and dropping triggers.");
            echo "\"";
            echo (($__internal_653499042eb14fd8415489ba6fa87c1e85cff03392e9f57b26d0da09b9be82ce = $context["row"] ?? null) && is_array($__internal_653499042eb14fd8415489ba6fa87c1e85cff03392e9f57b26d0da09b9be82ce) || $__internal_653499042eb14fd8415489ba6fa87c1e85cff03392e9f57b26d0da09b9be82ce instanceof ArrayAccess ? $__internal_653499042eb14fd8415489ba6fa87c1e85cff03392e9f57b26d0da09b9be82ce["Trigger_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n        <label for=\"checkbox_Trigger_priv\">\n          <code>\n            <dfn title=\"";
            // line 200
            echo _gettext("Allows creating and dropping triggers.");
            echo "\">\n              TRIGGER\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      ";
            // line 207
            if (twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "Delete versioning rows_priv", [], "array", true, true, false, 207) || twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "Delete_history_priv", [], "array", true, true, false, 207)) {
                // line 208
                echo "        <div class=\"item\">\n          <input type=\"checkbox\" name=\"Delete_history_priv\" id=\"checkbox_Delete_history_priv\" value=\"Y\" title=\"";
                // line 210
                echo _gettext("Allows deleting historical rows.");
                echo "\"";
                // line 211
                echo (($__internal_ba9f0a3bb95c082f61c9fbf892a05514d732703d52edc77b51f2e6284135900b = $context["row"] ?? null) && is_array($__internal_ba9f0a3bb95c082f61c9fbf892a05514d732703d52edc77b51f2e6284135900b) || $__internal_ba9f0a3bb95c082f61c9fbf892a05514d732703d52edc77b51f2e6284135900b instanceof ArrayAccess ? $__internal_ba9f0a3bb95c082f61c9fbf892a05514d732703d52edc77b51f2e6284135900b["Delete versioning rows_priv"] ?? null : null) == "Y" || (($__internal_73db8eef4d2582468dab79a6b09c77ce3b48675a610afd65a1f325b68804a60c = $context["row"] ?? null) && is_array($__internal_73db8eef4d2582468dab79a6b09c77ce3b48675a610afd65a1f325b68804a60c) || $__internal_73db8eef4d2582468dab79a6b09c77ce3b48675a610afd65a1f325b68804a60c instanceof ArrayAccess ? $__internal_73db8eef4d2582468dab79a6b09c77ce3b48675a610afd65a1f325b68804a60c["Delete_history_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n          <label for=\"checkbox_Delete_history_priv\">\n            <code>\n              <dfn title=\"";
                // line 214
                echo _gettext("Allows deleting historical rows.");
                echo "\">\n                DELETE HISTORY\n              </dfn>\n            </code>\n          </label>\n        </div>\n      ";
            }
            // line 221
            echo "    </div>\n    <div class=\"clearfloat\"></div>\n  </fieldset>\n\n";
        } else {
            // line 226
            echo "\n";
            // line 227
            $context["grant_count"] = 0;
            // line 228
            echo "<fieldset id=\"fieldset_user_global_rights\">\n  <legend data-submenu-label=\"";
            // line 230
            if ($context["is_global"] ?? null) {
                // line 231
                echo _gettext("Global");
            } elseif ($context["is_database"] ?? null) {
                // line 233
                echo _gettext("Database");
            } else {
                // line 235
                echo _gettext("Table");
            }
            // line 236
            echo "\">\n    ";
            // line 237
            if ($context["is_global"] ?? null) {
                // line 238
                echo "      ";
                echo _gettext("Global privileges");
                // line 239
                echo "    ";
            } elseif ($context["is_database"] ?? null) {
                // line 240
                echo "      ";
                echo _gettext("Database-specific privileges");
                // line 241
                echo "    ";
            } else {
                // line 242
                echo "      ";
                echo _gettext("Table-specific privileges");
                // line 243
                echo "    ";
            }
            // line 244
            echo "    <input type=\"checkbox\" id=\"addUsersForm_checkall\" class=\"checkall_box\" title=\"";
            echo _gettext("Check all");
            echo "\">\n    <label for=\"addUsersForm_checkall\">";
            // line 245
            echo _gettext("Check all");
            echo "</label>\n  </legend>\n  <p>\n    <small><em>";
            // line 248
            echo _gettext("Note: MySQL privilege names are expressed in English.");
            echo "</em></small>\n  </p>\n\n  <fieldset>\n    <legend>\n      <input type=\"checkbox\" class=\"sub_checkall_box\" id=\"checkall_Data_priv\" title=\"";
            // line 253
            echo _gettext("Check all");
            echo "\">\n      <label for=\"checkall_Data_priv\">";
            // line 254
            echo _gettext("Data");
            echo "</label>\n    </legend>\n\n    <div class=\"item\">\n      ";
            // line 258
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 259
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Select_priv\" id=\"checkbox_Select_priv\" value=\"Y\" title=\"";
            // line 260
            echo _gettext("Allows reading data.");
            echo "\"";
            echo (($__internal_d8ad5934f1874c52fa2ac9a4dfae52038b39b8b03cfc82eeb53de6151d883972 = $context["row"] ?? null) && is_array($__internal_d8ad5934f1874c52fa2ac9a4dfae52038b39b8b03cfc82eeb53de6151d883972) || $__internal_d8ad5934f1874c52fa2ac9a4dfae52038b39b8b03cfc82eeb53de6151d883972 instanceof ArrayAccess ? $__internal_d8ad5934f1874c52fa2ac9a4dfae52038b39b8b03cfc82eeb53de6151d883972["Select_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Select_priv\">\n        <code>\n          <dfn title=\"";
            // line 263
            echo _gettext("Allows reading data.");
            echo "\">\n            SELECT\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 271
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 272
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Insert_priv\" id=\"checkbox_Insert_priv\" value=\"Y\" title=\"";
            // line 273
            echo _gettext("Allows inserting and replacing data.");
            echo "\"";
            echo (($__internal_df39c71428eaf37baa1ea2198679e0077f3699bdd31bb5ba10d084710b9da216 = $context["row"] ?? null) && is_array($__internal_df39c71428eaf37baa1ea2198679e0077f3699bdd31bb5ba10d084710b9da216) || $__internal_df39c71428eaf37baa1ea2198679e0077f3699bdd31bb5ba10d084710b9da216 instanceof ArrayAccess ? $__internal_df39c71428eaf37baa1ea2198679e0077f3699bdd31bb5ba10d084710b9da216["Insert_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Insert_priv\">\n        <code>\n          <dfn title=\"";
            // line 276
            echo _gettext("Allows inserting and replacing data.");
            echo "\">\n            INSERT\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 284
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 285
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Update_priv\" id=\"checkbox_Update_priv\" value=\"Y\" title=\"";
            // line 286
            echo _gettext("Allows changing data.");
            echo "\"";
            echo (($__internal_bf0e189d688dc2ad611b50a437a32d3692fb6b8be90d2228617cfa6db44e75c0 = $context["row"] ?? null) && is_array($__internal_bf0e189d688dc2ad611b50a437a32d3692fb6b8be90d2228617cfa6db44e75c0) || $__internal_bf0e189d688dc2ad611b50a437a32d3692fb6b8be90d2228617cfa6db44e75c0 instanceof ArrayAccess ? $__internal_bf0e189d688dc2ad611b50a437a32d3692fb6b8be90d2228617cfa6db44e75c0["Update_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Update_priv\">\n        <code>\n          <dfn title=\"";
            // line 289
            echo _gettext("Allows changing data.");
            echo "\">\n            UPDATE\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 297
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 298
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Delete_priv\" id=\"checkbox_Delete_priv\" value=\"Y\" title=\"";
            // line 299
            echo _gettext("Allows deleting data.");
            echo "\"";
            echo (($__internal_674c0abf302105af78b0a38907d86c5dd0028bdc3ee5f24bf52771a16487760c = $context["row"] ?? null) && is_array($__internal_674c0abf302105af78b0a38907d86c5dd0028bdc3ee5f24bf52771a16487760c) || $__internal_674c0abf302105af78b0a38907d86c5dd0028bdc3ee5f24bf52771a16487760c instanceof ArrayAccess ? $__internal_674c0abf302105af78b0a38907d86c5dd0028bdc3ee5f24bf52771a16487760c["Delete_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Delete_priv\">\n        <code>\n          <dfn title=\"";
            // line 302
            echo _gettext("Allows deleting data.");
            echo "\">\n            DELETE\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    ";
            // line 309
            if ($context["is_global"] ?? null) {
                // line 310
                echo "      <div class=\"item\">\n        ";
                // line 311
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 312
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"File_priv\" id=\"checkbox_File_priv\" value=\"Y\" title=\"";
                // line 313
                echo _gettext("Allows importing data from and exporting data into files.");
                echo "\"";
                echo (($__internal_dd839fbfcab68823c49af471c7df7659a500fe72e71b58d6b80d896bdb55e75f = $context["row"] ?? null) && is_array($__internal_dd839fbfcab68823c49af471c7df7659a500fe72e71b58d6b80d896bdb55e75f) || $__internal_dd839fbfcab68823c49af471c7df7659a500fe72e71b58d6b80d896bdb55e75f instanceof ArrayAccess ? $__internal_dd839fbfcab68823c49af471c7df7659a500fe72e71b58d6b80d896bdb55e75f["File_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_File_priv\">\n          <code>\n            <dfn title=\"";
                // line 316
                echo _gettext("Allows importing data from and exporting data into files.");
                echo "\">\n              FILE\n            </dfn>\n          </code>\n        </label>\n      </div>\n    ";
            }
            // line 323
            echo "  </fieldset>\n\n  <fieldset>\n    <legend>\n      <input type=\"checkbox\" class=\"sub_checkall_box\" id=\"checkall_Structure_priv\" title=\"";
            // line 327
            echo _gettext("Check all");
            echo "\">\n      <label for=\"checkall_Structure_priv\">";
            // line 328
            echo _gettext("Structure");
            echo "</label>\n    </legend>\n\n    <div class=\"item\">\n      ";
            // line 332
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 333
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Create_priv\" id=\"checkbox_Create_priv\" value=\"Y\" title=\"";
            // line 334
            if ($context["is_database"] ?? null) {
                // line 335
                echo _gettext("Allows creating new databases and tables.");
            } else {
                // line 337
                echo _gettext("Allows creating new tables.");
            }
            // line 338
            echo "\"";
            echo (($__internal_a7ed47878554bdc32b70e1ba5ccc67d2302196876fbf62b4c853b20cb9e029fc = $context["row"] ?? null) && is_array($__internal_a7ed47878554bdc32b70e1ba5ccc67d2302196876fbf62b4c853b20cb9e029fc) || $__internal_a7ed47878554bdc32b70e1ba5ccc67d2302196876fbf62b4c853b20cb9e029fc instanceof ArrayAccess ? $__internal_a7ed47878554bdc32b70e1ba5ccc67d2302196876fbf62b4c853b20cb9e029fc["Create_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Create_priv\">\n        <code>\n          <dfn title=\"";
            // line 342
            if ($context["is_database"] ?? null) {
                // line 343
                echo _gettext("Allows creating new databases and tables.");
            } else {
                // line 345
                echo _gettext("Allows creating new tables.");
            }
            // line 346
            echo "\">\n            CREATE\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 354
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 355
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Alter_priv\" id=\"checkbox_Alter_priv\" value=\"Y\" title=\"";
            // line 356
            echo _gettext("Allows altering the structure of existing tables.");
            echo "\"";
            echo (($__internal_e5d7b41e16b744b68da1e9bb49047b8028ced86c782900009b4b4029b83d4b55 = $context["row"] ?? null) && is_array($__internal_e5d7b41e16b744b68da1e9bb49047b8028ced86c782900009b4b4029b83d4b55) || $__internal_e5d7b41e16b744b68da1e9bb49047b8028ced86c782900009b4b4029b83d4b55 instanceof ArrayAccess ? $__internal_e5d7b41e16b744b68da1e9bb49047b8028ced86c782900009b4b4029b83d4b55["Alter_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Alter_priv\">\n        <code>\n          <dfn title=\"";
            // line 359
            echo _gettext("Allows altering the structure of existing tables.");
            echo "\">\n            ALTER\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 367
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 368
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Index_priv\" id=\"checkbox_Index_priv\" value=\"Y\" title=\"";
            // line 369
            echo _gettext("Allows creating and dropping indexes.");
            echo "\"";
            echo (($__internal_9e93f398968fa0576dce82fd00f280e95c734ad3f84e7816ff09158ae224f5ba = $context["row"] ?? null) && is_array($__internal_9e93f398968fa0576dce82fd00f280e95c734ad3f84e7816ff09158ae224f5ba) || $__internal_9e93f398968fa0576dce82fd00f280e95c734ad3f84e7816ff09158ae224f5ba instanceof ArrayAccess ? $__internal_9e93f398968fa0576dce82fd00f280e95c734ad3f84e7816ff09158ae224f5ba["Index_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Index_priv\">\n        <code>\n          <dfn title=\"";
            // line 372
            echo _gettext("Allows creating and dropping indexes.");
            echo "\">\n            INDEX\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 380
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 381
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Drop_priv\" id=\"checkbox_Drop_priv\" value=\"Y\" title=\"";
            // line 382
            if ($context["is_database"] ?? null) {
                // line 383
                echo _gettext("Allows dropping databases and tables.");
            } else {
                // line 385
                echo _gettext("Allows dropping tables.");
            }
            // line 386
            echo "\"";
            echo (($__internal_0795e3de58b6454b051261c0c2b5be48852e17f25b59d4aeef29fb07c614bd78 = $context["row"] ?? null) && is_array($__internal_0795e3de58b6454b051261c0c2b5be48852e17f25b59d4aeef29fb07c614bd78) || $__internal_0795e3de58b6454b051261c0c2b5be48852e17f25b59d4aeef29fb07c614bd78 instanceof ArrayAccess ? $__internal_0795e3de58b6454b051261c0c2b5be48852e17f25b59d4aeef29fb07c614bd78["Drop_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Drop_priv\">\n        <code>\n          <dfn title=\"";
            // line 390
            if ($context["is_database"] ?? null) {
                // line 391
                echo _gettext("Allows dropping databases and tables.");
            } else {
                // line 393
                echo _gettext("Allows dropping tables.");
            }
            // line 394
            echo "\">\n            DROP\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 402
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 403
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Create_tmp_table_priv\" id=\"checkbox_Create_tmp_table_priv\" value=\"Y\" title=\"";
            // line 404
            echo _gettext("Allows creating temporary tables.");
            echo "\"";
            echo (($__internal_fecb0565c93d0b979a95c352ff76e401e0ae0c73bb8d3b443c8c6133e1c190de = $context["row"] ?? null) && is_array($__internal_fecb0565c93d0b979a95c352ff76e401e0ae0c73bb8d3b443c8c6133e1c190de) || $__internal_fecb0565c93d0b979a95c352ff76e401e0ae0c73bb8d3b443c8c6133e1c190de instanceof ArrayAccess ? $__internal_fecb0565c93d0b979a95c352ff76e401e0ae0c73bb8d3b443c8c6133e1c190de["Create_tmp_table_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Create_tmp_table_priv\">\n        <code>\n          <dfn title=\"";
            // line 407
            echo _gettext("Allows creating temporary tables.");
            echo "\">\n            CREATE TEMPORARY TABLES\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 415
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 416
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Show_view_priv\" id=\"checkbox_Show_view_priv\" value=\"Y\" title=\"";
            // line 417
            echo _gettext("Allows performing SHOW CREATE VIEW queries.");
            echo "\"";
            echo (($__internal_87570a635eac7f6e150744bd218085d17aff15d92d9c80a66d3b911e3355b828 = $context["row"] ?? null) && is_array($__internal_87570a635eac7f6e150744bd218085d17aff15d92d9c80a66d3b911e3355b828) || $__internal_87570a635eac7f6e150744bd218085d17aff15d92d9c80a66d3b911e3355b828 instanceof ArrayAccess ? $__internal_87570a635eac7f6e150744bd218085d17aff15d92d9c80a66d3b911e3355b828["Show_view_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Show_view_priv\">\n        <code>\n          <dfn title=\"";
            // line 420
            echo _gettext("Allows performing SHOW CREATE VIEW queries.");
            echo "\">\n            SHOW VIEW\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 428
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 429
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Create_routine_priv\" id=\"checkbox_Create_routine_priv\" value=\"Y\" title=\"";
            // line 430
            echo _gettext("Allows creating stored routines.");
            echo "\"";
            echo (($__internal_17b5b5f9aaeec4b528bfeed02b71f624021d6a52d927f441de2f2204d0e527cd = $context["row"] ?? null) && is_array($__internal_17b5b5f9aaeec4b528bfeed02b71f624021d6a52d927f441de2f2204d0e527cd) || $__internal_17b5b5f9aaeec4b528bfeed02b71f624021d6a52d927f441de2f2204d0e527cd instanceof ArrayAccess ? $__internal_17b5b5f9aaeec4b528bfeed02b71f624021d6a52d927f441de2f2204d0e527cd["Create_routine_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Create_routine_priv\">\n        <code>\n          <dfn title=\"";
            // line 433
            echo _gettext("Allows creating stored routines.");
            echo "\">\n            CREATE ROUTINE\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 441
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 442
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Alter_routine_priv\" id=\"checkbox_Alter_routine_priv\" value=\"Y\" title=\"";
            // line 443
            echo _gettext("Allows altering and dropping stored routines.");
            echo "\"";
            echo (($__internal_0db9a23306660395861a0528381e0668025e56a8a99f399e9ec23a4b392422d6 = $context["row"] ?? null) && is_array($__internal_0db9a23306660395861a0528381e0668025e56a8a99f399e9ec23a4b392422d6) || $__internal_0db9a23306660395861a0528381e0668025e56a8a99f399e9ec23a4b392422d6 instanceof ArrayAccess ? $__internal_0db9a23306660395861a0528381e0668025e56a8a99f399e9ec23a4b392422d6["Alter_routine_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Alter_routine_priv\">\n        <code>\n          <dfn title=\"";
            // line 446
            echo _gettext("Allows altering and dropping stored routines.");
            echo "\">\n            ALTER ROUTINE\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 454
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 455
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Execute_priv\" id=\"checkbox_Execute_priv\" value=\"Y\" title=\"";
            // line 456
            echo _gettext("Allows executing stored routines.");
            echo "\"";
            echo (($__internal_0a23ad2f11a348e49c87410947e20d5a4e711234ce49927662da5dddac687855 = $context["row"] ?? null) && is_array($__internal_0a23ad2f11a348e49c87410947e20d5a4e711234ce49927662da5dddac687855) || $__internal_0a23ad2f11a348e49c87410947e20d5a4e711234ce49927662da5dddac687855 instanceof ArrayAccess ? $__internal_0a23ad2f11a348e49c87410947e20d5a4e711234ce49927662da5dddac687855["Execute_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Execute_priv\">\n        <code>\n          <dfn title=\"";
            // line 459
            echo _gettext("Allows executing stored routines.");
            echo "\">\n            EXECUTE\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    ";
            // line 466
            if (twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "Create_view_priv", [], "array", true, true, false, 466)) {
                // line 467
                echo "      <div class=\"item\">\n        ";
                // line 468
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 469
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Create_view_priv\" id=\"checkbox_Create_view_priv\" value=\"Y\" title=\"";
                // line 470
                echo _gettext("Allows creating new views.");
                echo "\"";
                echo (($__internal_0228c5445a74540c89ea8a758478d405796357800f8af831a7f7e1e2c0159d9b = $context["row"] ?? null) && is_array($__internal_0228c5445a74540c89ea8a758478d405796357800f8af831a7f7e1e2c0159d9b) || $__internal_0228c5445a74540c89ea8a758478d405796357800f8af831a7f7e1e2c0159d9b instanceof ArrayAccess ? $__internal_0228c5445a74540c89ea8a758478d405796357800f8af831a7f7e1e2c0159d9b["Create_view_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Create_view_priv\">\n          <code>\n            <dfn title=\"";
                // line 473
                echo _gettext("Allows creating new views.");
                echo "\">\n              CREATE VIEW\n            </dfn>\n          </code>\n        </label>\n      </div>\n    ";
            }
            // line 480
            echo "\n    ";
            // line 481
            if (twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "Create View_priv", [], "array", true, true, false, 481)) {
                // line 482
                echo "      <div class=\"item\">\n        ";
                // line 483
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 484
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Create View_priv\" id=\"checkbox_Create View_priv\" value=\"Y\" title=\"";
                // line 485
                echo _gettext("Allows creating new views.");
                echo "\"";
                echo (($__internal_6fb04c4457ec9ffa7dd6fd2300542be8b961b6e5f7858a80a282f47b43ddae5f = $context["row"] ?? null) && is_array($__internal_6fb04c4457ec9ffa7dd6fd2300542be8b961b6e5f7858a80a282f47b43ddae5f) || $__internal_6fb04c4457ec9ffa7dd6fd2300542be8b961b6e5f7858a80a282f47b43ddae5f instanceof ArrayAccess ? $__internal_6fb04c4457ec9ffa7dd6fd2300542be8b961b6e5f7858a80a282f47b43ddae5f["Create View_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Create View_priv\">\n          <code>\n            <dfn title=\"";
                // line 488
                echo _gettext("Allows creating new views.");
                echo "\">\n              CREATE VIEW\n            </dfn>\n          </code>\n        </label>\n      </div>\n    ";
            }
            // line 495
            echo "\n    ";
            // line 496
            if (twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "Event_priv", [], "array", true, true, false, 496)) {
                // line 497
                echo "      <div class=\"item\">\n        ";
                // line 498
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 499
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Event_priv\" id=\"checkbox_Event_priv\" value=\"Y\" title=\"";
                // line 500
                echo _gettext("Allows to set up events for the event scheduler.");
                echo "\"";
                echo (($__internal_417a1a95b289c75779f33186a6dc0b71d01f257b68beae7dcb9d2d769acca0e0 = $context["row"] ?? null) && is_array($__internal_417a1a95b289c75779f33186a6dc0b71d01f257b68beae7dcb9d2d769acca0e0) || $__internal_417a1a95b289c75779f33186a6dc0b71d01f257b68beae7dcb9d2d769acca0e0 instanceof ArrayAccess ? $__internal_417a1a95b289c75779f33186a6dc0b71d01f257b68beae7dcb9d2d769acca0e0["Event_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Event_priv\">\n          <code>\n            <dfn title=\"";
                // line 503
                echo _gettext("Allows to set up events for the event scheduler.");
                echo "\">\n              EVENT\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        ";
                // line 511
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 512
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Trigger_priv\" id=\"checkbox_Trigger_priv\" value=\"Y\" title=\"";
                // line 513
                echo _gettext("Allows creating and dropping triggers.");
                echo "\"";
                echo (($__internal_af3439635eb343262861f05093b3dcce5d4dae1e20a47bc25a2eef28135b0d55 = $context["row"] ?? null) && is_array($__internal_af3439635eb343262861f05093b3dcce5d4dae1e20a47bc25a2eef28135b0d55) || $__internal_af3439635eb343262861f05093b3dcce5d4dae1e20a47bc25a2eef28135b0d55 instanceof ArrayAccess ? $__internal_af3439635eb343262861f05093b3dcce5d4dae1e20a47bc25a2eef28135b0d55["Trigger_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Trigger_priv\">\n          <code>\n            <dfn title=\"";
                // line 516
                echo _gettext("Allows creating and dropping triggers.");
                echo "\">\n              TRIGGER\n            </dfn>\n          </code>\n        </label>\n      </div>\n    ";
            }
            // line 523
            echo "  </fieldset>\n\n  <fieldset>\n    <legend>\n      <input type=\"checkbox\" class=\"sub_checkall_box\" id=\"checkall_Administration_priv\" title=\"";
            // line 527
            echo _gettext("Check all");
            echo "\">\n      <label for=\"checkall_Administration_priv\">";
            // line 528
            echo _gettext("Administration");
            echo "</label>\n    </legend>\n\n    ";
            // line 531
            if ($context["is_global"] ?? null) {
                // line 532
                echo "      <div class=\"item\">\n        ";
                // line 533
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 534
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Grant_priv\" id=\"checkbox_Grant_priv\" value=\"Y\" title=\"";
                // line 535
                echo _gettext("Allows adding users and privileges without reloading the privilege tables.");
                echo "\"";
                echo (($__internal_b16f7904bcaaa7a87404cbf85addc7a8645dff94eef4e8ae7182b86e3638e76a = $context["row"] ?? null) && is_array($__internal_b16f7904bcaaa7a87404cbf85addc7a8645dff94eef4e8ae7182b86e3638e76a) || $__internal_b16f7904bcaaa7a87404cbf85addc7a8645dff94eef4e8ae7182b86e3638e76a instanceof ArrayAccess ? $__internal_b16f7904bcaaa7a87404cbf85addc7a8645dff94eef4e8ae7182b86e3638e76a["Grant_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Grant_priv\">\n          <code>\n            <dfn title=\"";
                // line 538
                echo _gettext("Allows adding users and privileges without reloading the privilege tables.");
                echo "\">\n              GRANT\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        ";
                // line 546
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 547
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Super_priv\" id=\"checkbox_Super_priv\" value=\"Y\" title=\"";
                // line 548
                echo _gettext("Allows connecting, even if maximum number of connections is reached; required for most administrative operations like setting global variables or killing threads of other users.");
                echo "\"";
                // line 549
                echo (($__internal_462377748602ccf3a44a10ced4240983cec8df1ad86ab53e582fcddddb98fc88 = $context["row"] ?? null) && is_array($__internal_462377748602ccf3a44a10ced4240983cec8df1ad86ab53e582fcddddb98fc88) || $__internal_462377748602ccf3a44a10ced4240983cec8df1ad86ab53e582fcddddb98fc88 instanceof ArrayAccess ? $__internal_462377748602ccf3a44a10ced4240983cec8df1ad86ab53e582fcddddb98fc88["Super_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Super_priv\">\n          <code>\n            <dfn title=\"";
                // line 552
                echo _gettext("Allows connecting, even if maximum number of connections is reached; required for most administrative operations like setting global variables or killing threads of other users.");
                echo "\">\n              SUPER\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        ";
                // line 560
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 561
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Process_priv\" id=\"checkbox_Process_priv\" value=\"Y\" title=\"";
                // line 562
                echo _gettext("Allows viewing processes of all users.");
                echo "\"";
                echo (($__internal_be1db6a1ea9fa5c04c40f99df0ec5af053ca391863fc6256c5c4ee249724f758 = $context["row"] ?? null) && is_array($__internal_be1db6a1ea9fa5c04c40f99df0ec5af053ca391863fc6256c5c4ee249724f758) || $__internal_be1db6a1ea9fa5c04c40f99df0ec5af053ca391863fc6256c5c4ee249724f758 instanceof ArrayAccess ? $__internal_be1db6a1ea9fa5c04c40f99df0ec5af053ca391863fc6256c5c4ee249724f758["Process_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Process_priv\">\n          <code>\n            <dfn title=\"";
                // line 565
                echo _gettext("Allows viewing processes of all users.");
                echo "\">\n              PROCESS\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        ";
                // line 573
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 574
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Reload_priv\" id=\"checkbox_Reload_priv\" value=\"Y\" title=\"";
                // line 575
                echo _gettext("Allows reloading server settings and flushing the server's caches.");
                echo "\"";
                echo (($__internal_6e6eda1691934a8f5855a3221f5a9f036391304a5cda73a3a2009f2961a84c35 = $context["row"] ?? null) && is_array($__internal_6e6eda1691934a8f5855a3221f5a9f036391304a5cda73a3a2009f2961a84c35) || $__internal_6e6eda1691934a8f5855a3221f5a9f036391304a5cda73a3a2009f2961a84c35 instanceof ArrayAccess ? $__internal_6e6eda1691934a8f5855a3221f5a9f036391304a5cda73a3a2009f2961a84c35["Reload_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Reload_priv\">\n          <code>\n            <dfn title=\"";
                // line 578
                echo _gettext("Allows reloading server settings and flushing the server's caches.");
                echo "\">\n              RELOAD\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        ";
                // line 586
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 587
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Shutdown_priv\" id=\"checkbox_Shutdown_priv\" value=\"Y\" title=\"";
                // line 588
                echo _gettext("Allows shutting down the server.");
                echo "\"";
                echo (($__internal_51c633083c79004f3cb5e9e2b2f3504f650f1561800582801028bcbcf733a06b = $context["row"] ?? null) && is_array($__internal_51c633083c79004f3cb5e9e2b2f3504f650f1561800582801028bcbcf733a06b) || $__internal_51c633083c79004f3cb5e9e2b2f3504f650f1561800582801028bcbcf733a06b instanceof ArrayAccess ? $__internal_51c633083c79004f3cb5e9e2b2f3504f650f1561800582801028bcbcf733a06b["Shutdown_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Shutdown_priv\">\n          <code>\n            <dfn title=\"";
                // line 591
                echo _gettext("Allows shutting down the server.");
                echo "\">\n              SHUTDOWN\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        ";
                // line 599
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 600
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Show_db_priv\" id=\"checkbox_Show_db_priv\" value=\"Y\" title=\"";
                // line 601
                echo _gettext("Gives access to the complete list of databases.");
                echo "\"";
                echo (($__internal_064553f1273f2ea50405f85092d06733f3f2fe5d0fc42fda135e1fdc91ff26ae = $context["row"] ?? null) && is_array($__internal_064553f1273f2ea50405f85092d06733f3f2fe5d0fc42fda135e1fdc91ff26ae) || $__internal_064553f1273f2ea50405f85092d06733f3f2fe5d0fc42fda135e1fdc91ff26ae instanceof ArrayAccess ? $__internal_064553f1273f2ea50405f85092d06733f3f2fe5d0fc42fda135e1fdc91ff26ae["Show_db_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Show_db_priv\">\n          <code>\n            <dfn title=\"";
                // line 604
                echo _gettext("Gives access to the complete list of databases.");
                echo "\">\n              SHOW DATABASES\n            </dfn>\n          </code>\n        </label>\n      </div>\n    ";
            } else {
                // line 611
                echo "      <div class=\"item\">\n        ";
                // line 612
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 613
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Grant_priv\" id=\"checkbox_Grant_priv\" value=\"Y\" title=\"";
                // line 614
                echo _gettext("Allows user to give to other users or remove from other users the privileges that user possess yourself.");
                echo "\"";
                // line 615
                echo (($__internal_7bef02f75e2984f8c7fcd4fd7871e286c87c0fdcb248271a136b01ac6dd5dd54 = $context["row"] ?? null) && is_array($__internal_7bef02f75e2984f8c7fcd4fd7871e286c87c0fdcb248271a136b01ac6dd5dd54) || $__internal_7bef02f75e2984f8c7fcd4fd7871e286c87c0fdcb248271a136b01ac6dd5dd54 instanceof ArrayAccess ? $__internal_7bef02f75e2984f8c7fcd4fd7871e286c87c0fdcb248271a136b01ac6dd5dd54["Grant_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Grant_priv\">\n          <code>\n            <dfn title=\"";
                // line 618
                echo _gettext("Allows user to give to other users or remove from other users the privileges that user possess yourself.");
                echo "\">\n              GRANT\n            </dfn>\n          </code>\n        </label>\n      </div>\n    ";
            }
            // line 625
            echo "\n    <div class=\"item\">\n      ";
            // line 627
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 628
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"Lock_tables_priv\" id=\"checkbox_Lock_tables_priv\" value=\"Y\" title=\"";
            // line 629
            echo _gettext("Allows locking tables for the current thread.");
            echo "\"";
            echo (($__internal_d6ae6b41786cc4be7778386d06cb288c8e6ffd74e055cfed45d7a5c8854d0c8f = $context["row"] ?? null) && is_array($__internal_d6ae6b41786cc4be7778386d06cb288c8e6ffd74e055cfed45d7a5c8854d0c8f) || $__internal_d6ae6b41786cc4be7778386d06cb288c8e6ffd74e055cfed45d7a5c8854d0c8f instanceof ArrayAccess ? $__internal_d6ae6b41786cc4be7778386d06cb288c8e6ffd74e055cfed45d7a5c8854d0c8f["Lock_tables_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_Lock_tables_priv\">\n        <code>\n          <dfn title=\"";
            // line 632
            echo _gettext("Allows locking tables for the current thread.");
            echo "\">\n            LOCK TABLES\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    <div class=\"item\">\n      ";
            // line 640
            $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
            // line 641
            echo "      <input type=\"checkbox\" class=\"checkall\" name=\"References_priv\" id=\"checkbox_References_priv\" value=\"Y\" title=\"";
            // line 642
            echo _gettext("Has no effect in this MySQL version.");
            echo "\"";
            echo (($__internal_1dcdec7ec31e102fbfe45103ea3599c92c8609311e43d40ca0d95d0369434327 = $context["row"] ?? null) && is_array($__internal_1dcdec7ec31e102fbfe45103ea3599c92c8609311e43d40ca0d95d0369434327) || $__internal_1dcdec7ec31e102fbfe45103ea3599c92c8609311e43d40ca0d95d0369434327 instanceof ArrayAccess ? $__internal_1dcdec7ec31e102fbfe45103ea3599c92c8609311e43d40ca0d95d0369434327["References_priv"] ?? null : null) == "Y" ? " checked" : "";
            echo ">\n      <label for=\"checkbox_References_priv\">\n        <code>\n          ";
            // line 646
            echo "          <dfn title=\"";
            echo twig_escape_filter($this->env, $context["supports_references_privilege"] ?? null ? _gettext("Allows creating foreign key relations.") : ($context["is_mariadb"] ?? null ? _gettext("Not used on MariaDB.") : _gettext("Not used for this MySQL version.")), "html", null, true);
            echo "\">\n            REFERENCES\n          </dfn>\n        </code>\n      </label>\n    </div>\n\n    ";
            // line 653
            if ($context["is_global"] ?? null) {
                // line 654
                echo "      <div class=\"item\">\n        ";
                // line 655
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 656
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Repl_client_priv\" id=\"checkbox_Repl_client_priv\" value=\"Y\" title=\"";
                // line 657
                echo _gettext("Allows the user to ask where the slaves / masters are.");
                echo "\"";
                echo (($__internal_891ba2f942018e94e4bfa8069988f305bbaad7f54a64aeee069787f1084a9412 = $context["row"] ?? null) && is_array($__internal_891ba2f942018e94e4bfa8069988f305bbaad7f54a64aeee069787f1084a9412) || $__internal_891ba2f942018e94e4bfa8069988f305bbaad7f54a64aeee069787f1084a9412 instanceof ArrayAccess ? $__internal_891ba2f942018e94e4bfa8069988f305bbaad7f54a64aeee069787f1084a9412["Repl_client_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Repl_client_priv\">\n          <code>\n            <dfn title=\"";
                // line 660
                echo _gettext("Allows the user to ask where the slaves / masters are.");
                echo "\">\n              REPLICATION CLIENT\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        ";
                // line 668
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 669
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Repl_slave_priv\" id=\"checkbox_Repl_slave_priv\" value=\"Y\" title=\"";
                // line 670
                echo _gettext("Needed for the replication slaves.");
                echo "\"";
                echo (($__internal_694b5f53081640f33aab1567e85e28c247e6a7c4674010716df6de8eae4819e9 = $context["row"] ?? null) && is_array($__internal_694b5f53081640f33aab1567e85e28c247e6a7c4674010716df6de8eae4819e9) || $__internal_694b5f53081640f33aab1567e85e28c247e6a7c4674010716df6de8eae4819e9 instanceof ArrayAccess ? $__internal_694b5f53081640f33aab1567e85e28c247e6a7c4674010716df6de8eae4819e9["Repl_slave_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Repl_slave_priv\">\n          <code>\n            <dfn title=\"";
                // line 673
                echo _gettext("Needed for the replication slaves.");
                echo "\">\n              REPLICATION SLAVE\n            </dfn>\n          </code>\n        </label>\n      </div>\n\n      <div class=\"item\">\n        ";
                // line 681
                $context["grant_count"] = ($context["grant_count"] ?? null) + 1;
                // line 682
                echo "        <input type=\"checkbox\" class=\"checkall\" name=\"Create_user_priv\" id=\"checkbox_Create_user_priv\" value=\"Y\" title=\"";
                // line 683
                echo _gettext("Allows creating, dropping and renaming user accounts.");
                echo "\"";
                echo (($__internal_91b272a21580197773f482962c8b92637a641a749832ee390d7d386a58d1912e = $context["row"] ?? null) && is_array($__internal_91b272a21580197773f482962c8b92637a641a749832ee390d7d386a58d1912e) || $__internal_91b272a21580197773f482962c8b92637a641a749832ee390d7d386a58d1912e instanceof ArrayAccess ? $__internal_91b272a21580197773f482962c8b92637a641a749832ee390d7d386a58d1912e["Create_user_priv"] ?? null : null) == "Y" ? " checked" : "";
                echo ">\n        <label for=\"checkbox_Create_user_priv\">\n          <code>\n            <dfn title=\"";
                // line 686
                echo _gettext("Allows creating, dropping and renaming user accounts.");
                echo "\">\n              CREATE USER\n            </dfn>\n          </code>\n        </label>\n      </div>\n    ";
            }
            // line 693
            echo "  </fieldset>\n\n  ";
            // line 695
            if ($context["is_global"] ?? null) {
                // line 696
                echo "    <fieldset>\n      <legend>";
                // line 697
                echo _gettext("Resource limits");
                echo "</legend>\n      <p>\n        <small><em>";
                // line 699
                echo _gettext("Note: Setting these options to 0 (zero) removes the limit.");
                echo "</em></small>\n      </p>\n\n      <div class=\"item\">\n        <label for=\"text_max_questions\">\n          <code>\n            <dfn title=\"";
                // line 705
                echo _gettext("Limits the number of queries the user may send to the server per hour.");
                echo "\">\n              MAX QUERIES PER HOUR\n            </dfn>\n          </code>\n        </label>\n        <input type=\"number\" name=\"max_questions\" id=\"text_max_questions\" value=\"";
                // line 711
                twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_questions", [], "any", true, true, false, 711) && !(null === twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_questions", [], "any", false, false, false, 711)) ? print twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_questions", [], "any", false, false, false, 711), "html", null, true) : (print "0");
                echo "\" title=\"";
                // line 712
                echo _gettext("Limits the number of queries the user may send to the server per hour.");
                echo "\">\n      </div>\n\n      <div class=\"item\">\n        <label for=\"text_max_updates\">\n          <code>\n            <dfn title=\"";
                // line 718
                echo _gettext("Limits the number of commands that change any table or database the user may execute per hour.");
                echo "\">\n              MAX UPDATES PER HOUR\n            </dfn>\n          </code>\n        </label>\n        <input type=\"number\" name=\"max_updates\" id=\"text_max_updates\" value=\"";
                // line 724
                twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_updates", [], "any", true, true, false, 724) && !(null === twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_updates", [], "any", false, false, false, 724)) ? print twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_updates", [], "any", false, false, false, 724), "html", null, true) : (print "0");
                echo "\" title=\"";
                // line 725
                echo _gettext("Limits the number of commands that change any table or database the user may execute per hour.");
                echo "\">\n      </div>\n\n      <div class=\"item\">\n        <label for=\"text_max_connections\">\n          <code>\n            <dfn title=\"";
                // line 731
                echo _gettext("Limits the number of new connections the user may open per hour.");
                echo "\">\n              MAX CONNECTIONS PER HOUR\n            </dfn>\n          </code>\n        </label>\n        <input type=\"number\" name=\"max_connections\" id=\"text_max_connections\" value=\"";
                // line 737
                twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_connections", [], "any", true, true, false, 737) && !(null === twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_connections", [], "any", false, false, false, 737)) ? print twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_connections", [], "any", false, false, false, 737), "html", null, true) : (print "0");
                echo "\" title=\"";
                // line 738
                echo _gettext("Limits the number of new connections the user may open per hour.");
                echo "\">\n      </div>\n\n      <div class=\"item\">\n        <label for=\"text_max_user_connections\">\n          <code>\n            <dfn title=\"";
                // line 744
                echo _gettext("Limits the number of simultaneous connections the user may have.");
                echo "\">\n              MAX USER_CONNECTIONS\n            </dfn>\n          </code>\n        </label>\n        <input type=\"number\" name=\"max_user_connections\" id=\"text_max_user_connections\" value=\"";
                // line 750
                twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_user_connections", [], "any", true, true, false, 750) && !(null === twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_user_connections", [], "any", false, false, false, 750)) ? print twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "max_user_connections", [], "any", false, false, false, 750), "html", null, true) : (print "0");
                echo "\" title=\"";
                // line 751
                echo _gettext("Limits the number of simultaneous connections the user may have.");
                echo "\">\n      </div>\n    </fieldset>\n\n    <fieldset>\n      <legend>SSL</legend>\n      <div id=\"require_ssl_div\">\n        <div class=\"item\">\n          <input type=\"radio\" name=\"ssl_type\" id=\"ssl_type_NONE\" title=\"";
                // line 760
                echo _gettext("Does not require SSL-encrypted connections.");
                echo "\" value=\"NONE\"";
                // line 761
                echo twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "ssl_type", [], "any", false, false, false, 761) == "NONE" || twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "ssl_type", [], "any", false, false, false, 761) == "" ? " checked" : "";
                echo ">\n          <label for=\"ssl_type_NONE\">\n            <code>REQUIRE NONE</code>\n          </label>\n        </div>\n\n        <div class=\"item\">\n          <input type=\"radio\" name=\"ssl_type\" id=\"ssl_type_ANY\" title=\"";
                // line 769
                echo _gettext("Requires SSL-encrypted connections.");
                echo "\" value=\"ANY\"";
                // line 770
                echo twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "ssl_type", [], "any", false, false, false, 770) == "ANY" ? " checked" : "";
                echo ">\n          <label for=\"ssl_type_ANY\">\n            <code>REQUIRE SSL</code>\n          </label>\n        </div>\n\n        <div class=\"item\">\n          <input type=\"radio\" name=\"ssl_type\" id=\"ssl_type_X509\" title=\"";
                // line 778
                echo _gettext("Requires a valid X509 certificate.");
                echo "\" value=\"X509\"";
                // line 779
                echo twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "ssl_type", [], "any", false, false, false, 779) == "X509" ? " checked" : "";
                echo ">\n          <label for=\"ssl_type_X509\">\n            <code>REQUIRE X509</code>\n          </label>\n        </div>\n\n        <div class=\"item\">\n          <input type=\"radio\" name=\"ssl_type\" id=\"ssl_type_SPECIFIED\" value=\"SPECIFIED\"";
                // line 787
                echo twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "ssl_type", [], "any", false, false, false, 787) == "SPECIFIED" ? " checked" : "";
                echo ">\n          <label for=\"ssl_type_SPECIFIED\">\n            <code>SPECIFIED</code>\n          </label>\n        </div>\n\n        <div id=\"specified_div\" style=\"padding-left:20px;\">\n          <div class=\"item\">\n            <label for=\"text_ssl_cipher\">\n              <code>REQUIRE CIPHER</code>\n            </label>\n            <input type=\"text\" name=\"ssl_cipher\" id=\"text_ssl_cipher\" value=\"";
                // line 798
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "ssl_cipher", [], "any", false, false, false, 798), "html", null, true);
                echo "\" size=\"80\" title=\"";
                // line 799
                echo _gettext("Requires that a specific cipher method be used for a connection.");
                echo "\"";
                // line 800
                echo twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "ssl_type", [], "any", false, false, false, 800) != "SPECIFIED" ? " disabled" : "";
                echo ">\n          </div>\n\n          <div class=\"item\">\n            <label for=\"text_x509_issuer\">\n              <code>REQUIRE ISSUER</code>\n            </label>\n            <input type=\"text\" name=\"x509_issuer\" id=\"text_x509_issuer\" value=\"";
                // line 807
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "x509_issuer", [], "any", false, false, false, 807), "html", null, true);
                echo "\" size=\"80\" title=\"";
                // line 808
                echo _gettext("Requires that a valid X509 certificate issued by this CA be presented.");
                echo "\"";
                // line 809
                echo twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "ssl_type", [], "any", false, false, false, 809) != "SPECIFIED" ? " disabled" : "";
                echo ">\n          </div>\n\n          <div class=\"item\">\n            <label for=\"text_x509_subject\">\n              <code>REQUIRE SUBJECT</code>\n            </label>\n            <input type=\"text\" name=\"x509_subject\" id=\"text_x509_subject\" value=\"";
                // line 816
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "x509_subject", [], "any", false, false, false, 816), "html", null, true);
                echo "\" size=\"80\" title=\"";
                // line 817
                echo _gettext("Requires that a valid X509 certificate with this subject be presented.");
                echo "\"";
                // line 818
                echo twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "ssl_type", [], "any", false, false, false, 818) != "SPECIFIED" ? " disabled" : "";
                echo ">\n          </div>\n        </div>\n      </div>\n    </fieldset>\n  ";
            }
            // line 824
            echo "\n  <div class=\"clearfloat\"></div>\n</fieldset>\n<input type=\"hidden\" name=\"grant_count\" value=\"";
            // line 827
            echo twig_escape_filter($this->env, ($context["grant_count"] ?? null) - (twig_get_attribute($this->env, $this->source, $context["row"] ?? null, "Grant_priv", [], "array", true, true, false, 827) ? 1 : 0), "html", null, true);
            echo "\">\n\n";
        }
        // line 830
        echo "\n";
        // line 831
        if ($context["has_submit"] ?? null) {
            // line 832
            echo "  <fieldset id=\"fieldset_user_privtable_footer\" class=\"tblFooters\">\n    <input type=\"hidden\" name=\"update_privs\" value=\"1\">\n    <input class=\"btn btn-primary\" type=\"submit\" value=\"";
            // line 834
            echo _gettext("Go");
            echo "\">\n  </fieldset>\n";
        }
    }
    public function getTemplateName()
    {
        return "server/privileges/privileges_table.twig";
    }
    public function isTraitable()
    {
        return false;
    }
    public function getDebugInfo()
    {
        return array(1552 => 834, 1548 => 832, 1546 => 831, 1543 => 830, 1537 => 827, 1532 => 824, 1523 => 818, 1520 => 817, 1517 => 816, 1507 => 809, 1504 => 808, 1501 => 807, 1491 => 800, 1488 => 799, 1485 => 798, 1471 => 787, 1461 => 779, 1458 => 778, 1448 => 770, 1445 => 769, 1435 => 761, 1432 => 760, 1421 => 751, 1418 => 750, 1410 => 744, 1401 => 738, 1398 => 737, 1390 => 731, 1381 => 725, 1378 => 724, 1370 => 718, 1361 => 712, 1358 => 711, 1350 => 705, 1341 => 699, 1336 => 697, 1333 => 696, 1331 => 695, 1327 => 693, 1317 => 686, 1309 => 683, 1307 => 682, 1305 => 681, 1294 => 673, 1286 => 670, 1284 => 669, 1282 => 668, 1271 => 660, 1263 => 657, 1261 => 656, 1259 => 655, 1256 => 654, 1254 => 653, 1243 => 646, 1235 => 642, 1233 => 641, 1231 => 640, 1220 => 632, 1212 => 629, 1210 => 628, 1208 => 627, 1204 => 625, 1194 => 618, 1188 => 615, 1185 => 614, 1183 => 613, 1181 => 612, 1178 => 611, 1168 => 604, 1160 => 601, 1158 => 600, 1156 => 599, 1145 => 591, 1137 => 588, 1135 => 587, 1133 => 586, 1122 => 578, 1114 => 575, 1112 => 574, 1110 => 573, 1099 => 565, 1091 => 562, 1089 => 561, 1087 => 560, 1076 => 552, 1070 => 549, 1067 => 548, 1065 => 547, 1063 => 546, 1052 => 538, 1044 => 535, 1042 => 534, 1040 => 533, 1037 => 532, 1035 => 531, 1029 => 528, 1025 => 527, 1019 => 523, 1009 => 516, 1001 => 513, 999 => 512, 997 => 511, 986 => 503, 978 => 500, 976 => 499, 974 => 498, 971 => 497, 969 => 496, 966 => 495, 956 => 488, 948 => 485, 946 => 484, 944 => 483, 941 => 482, 939 => 481, 936 => 480, 926 => 473, 918 => 470, 916 => 469, 914 => 468, 911 => 467, 909 => 466, 899 => 459, 891 => 456, 889 => 455, 887 => 454, 876 => 446, 868 => 443, 866 => 442, 864 => 441, 853 => 433, 845 => 430, 843 => 429, 841 => 428, 830 => 420, 822 => 417, 820 => 416, 818 => 415, 807 => 407, 799 => 404, 797 => 403, 795 => 402, 785 => 394, 782 => 393, 779 => 391, 777 => 390, 770 => 386, 767 => 385, 764 => 383, 762 => 382, 760 => 381, 758 => 380, 747 => 372, 739 => 369, 737 => 368, 735 => 367, 724 => 359, 716 => 356, 714 => 355, 712 => 354, 702 => 346, 699 => 345, 696 => 343, 694 => 342, 687 => 338, 684 => 337, 681 => 335, 679 => 334, 677 => 333, 675 => 332, 668 => 328, 664 => 327, 658 => 323, 648 => 316, 640 => 313, 638 => 312, 636 => 311, 633 => 310, 631 => 309, 621 => 302, 613 => 299, 611 => 298, 609 => 297, 598 => 289, 590 => 286, 588 => 285, 586 => 284, 575 => 276, 567 => 273, 565 => 272, 563 => 271, 552 => 263, 544 => 260, 542 => 259, 540 => 258, 533 => 254, 529 => 253, 521 => 248, 515 => 245, 510 => 244, 507 => 243, 504 => 242, 501 => 241, 498 => 240, 495 => 239, 492 => 238, 490 => 237, 487 => 236, 484 => 235, 481 => 233, 479 => 232, 477 => 231, 475 => 230, 472 => 228, 470 => 227, 467 => 226, 460 => 221, 450 => 214, 444 => 211, 441 => 210, 438 => 208, 436 => 207, 426 => 200, 418 => 197, 407 => 188, 399 => 185, 388 => 176, 380 => 173, 369 => 164, 361 => 161, 350 => 152, 342 => 149, 331 => 140, 325 => 137, 322 => 136, 311 => 127, 303 => 124, 292 => 115, 284 => 112, 273 => 103, 265 => 100, 258 => 94, 256 => 93, 252 => 92, 247 => 89, 243 => 87, 234 => 84, 227 => 83, 223 => 82, 216 => 78, 209 => 73, 207 => 72, 203 => 71, 198 => 68, 194 => 66, 185 => 63, 178 => 62, 174 => 61, 167 => 57, 160 => 52, 158 => 51, 154 => 50, 149 => 47, 145 => 45, 136 => 42, 129 => 41, 125 => 40, 118 => 36, 111 => 31, 109 => 30, 105 => 29, 100 => 26, 96 => 24, 87 => 21, 80 => 20, 76 => 19, 69 => 15, 61 => 10, 57 => 8, 55 => 7, 51 => 6, 46 => 4, 42 => 3, 39 => 2, 37 => 1);
    }
    public function getSourceContext()
    {
        return new Source("", "server/privileges/privileges_table.twig", "/var/www/html/phpMyAdmin/templates/server/privileges/privileges_table.twig");
    }
}