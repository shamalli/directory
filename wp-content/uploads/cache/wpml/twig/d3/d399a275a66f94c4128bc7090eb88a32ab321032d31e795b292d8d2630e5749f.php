<?php

namespace WPML\Core;

use \WPML\Core\Twig\Environment;
use \WPML\Core\Twig\Error\LoaderError;
use \WPML\Core\Twig\Error\RuntimeError;
use \WPML\Core\Twig\Markup;
use \WPML\Core\Twig\Sandbox\SecurityError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedTagError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFilterError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFunctionError;
use \WPML\Core\Twig\Source;
use \WPML\Core\Twig\Template;

/* checkboxes-includes.twig */
class __TwigTemplate_da673559bf53aeeaa0e55c898e754d0c3663300a662434d9fe6beb332b92e6ae extends \WPML\Core\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $context["force"] = $this->getAttribute($this->getAttribute($this->getAttribute(($context["data"] ?? null), "templates", []), ($context["template_slug"] ?? null), [], "array"), "force_settings", []);
        // line 2
        $context["is_hierarchical"] = (($this->getAttribute(($context["slot_settings"] ?? null), "slot_group", []) == "menus") && $this->getAttribute(($context["slot_settings"] ?? null), "is_hierarchical", []));
        // line 3
        echo "
<h4>";
        // line 4
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", []), "title_what_to_include", []), "html", null, true);
        echo " ";
        $this->loadTemplate("tooltip.twig", "checkboxes-includes.twig", 4)->display(twig_array_merge($context, ["content" => $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "tooltips", []), "what_to_include", [])]));
        echo "</h4>
<ul class=\"js-wpml-ls-to-include\">
    <li>
        <label><input type=\"checkbox\" class=\"js-wpml-ls-setting-display_flags js-wpml-ls-trigger-update\"
                      name=\"";
        // line 8
        if (($context["name_base"] ?? null)) {
            echo \WPML\Core\twig_escape_filter($this->env, ($context["name_base"] ?? null), "html", null, true);
            echo "[display_flags]";
        } else {
            echo "display_flags";
        }
        echo "\"
                      ";
        // line 9
        if ($this->getAttribute(($context["force"] ?? null), "display_flags", [], "any", true, true)) {
            echo " disabled=\"disabled\"";
        }
        // line 10
        echo "                      value=\"1\"";
        if ($this->getAttribute(($context["slot_settings"] ?? null), "display_flags", [])) {
            echo " checked=\"checked\"";
        }
        echo "> ";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", []), "label_include_flag", []), "html", null, true);
        echo "</label>
    </li>
    <li>
        <label><input type=\"checkbox\" class=\"js-wpml-ls-setting-display_names_in_native_lang js-wpml-ls-trigger-update\"
                      name=\"";
        // line 14
        if (($context["name_base"] ?? null)) {
            echo \WPML\Core\twig_escape_filter($this->env, ($context["name_base"] ?? null), "html", null, true);
            echo "[display_names_in_native_lang]";
        } else {
            echo "display_names_in_native_lang";
        }
        echo "\"
                      ";
        // line 15
        if ($this->getAttribute(($context["force"] ?? null), "display_names_in_native_lang", [], "any", true, true)) {
            echo " disabled=\"disabled\"";
        }
        // line 16
        echo "                      value=\"1\"";
        if ($this->getAttribute(($context["slot_settings"] ?? null), "display_names_in_native_lang", [])) {
            echo " checked=\"checked\"";
        }
        echo "> ";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", []), "label_include_native_lang", []), "html", null, true);
        echo "</label>
    </li>
    <li>
        <label><input type=\"checkbox\" class=\"js-wpml-ls-setting-display_names_in_current_lang js-wpml-ls-trigger-update\"
                      name=\"";
        // line 20
        if (($context["name_base"] ?? null)) {
            echo \WPML\Core\twig_escape_filter($this->env, ($context["name_base"] ?? null), "html", null, true);
            echo "[display_names_in_current_lang]";
        } else {
            echo "display_names_in_current_lang";
        }
        echo "\"
                      ";
        // line 21
        if ($this->getAttribute(($context["force"] ?? null), "display_names_in_current_lang", [], "any", true, true)) {
            echo " disabled=\"disabled\"";
        }
        // line 22
        echo "                      value=\"1\"";
        if ((($this->getAttribute(($context["slot_settings"] ?? null), "display_names_in_current_lang", [], "any", true, true)) ? (\WPML\Core\_twig_default_filter($this->getAttribute(($context["slot_settings"] ?? null), "display_names_in_current_lang", []), 1)) : (1))) {
            echo " checked=\"checked\"";
        }
        echo "> ";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", []), "label_include_display_lang", []), "html", null, true);
        echo "</label>
    </li>
    <li>
        <label><input type=\"checkbox\" class=\"js-wpml-ls-setting-display_link_for_current_lang js-wpml-ls-trigger-update\"
                      name=\"";
        // line 26
        if (($context["name_base"] ?? null)) {
            echo \WPML\Core\twig_escape_filter($this->env, ($context["name_base"] ?? null), "html", null, true);
            echo "[display_link_for_current_lang]";
        } else {
            echo "display_link_for_current_lang";
        }
        echo "\"
                      ";
        // line 27
        if (($this->getAttribute(($context["force"] ?? null), "display_link_for_current_lang", [], "any", true, true) || ($context["is_hierarchical"] ?? null))) {
            echo " disabled=\"disabled\"";
        }
        // line 28
        echo "                      value=\"1\"";
        if ((($this->getAttribute(($context["slot_settings"] ?? null), "display_link_for_current_lang", [], "any", true, true)) ? (\WPML\Core\_twig_default_filter($this->getAttribute(($context["slot_settings"] ?? null), "display_link_for_current_lang", []), 1)) : (1))) {
            echo " checked=\"checked\"";
        }
        echo "> ";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", []), "label_include_current_lang", []), "html", null, true);
        echo "</label>
    </li>
</ul>";
    }

    public function getTemplateName()
    {
        return "checkboxes-includes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  136 => 28,  132 => 27,  123 => 26,  111 => 22,  107 => 21,  98 => 20,  86 => 16,  82 => 15,  73 => 14,  61 => 10,  57 => 9,  48 => 8,  39 => 4,  36 => 3,  34 => 2,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% set force           = data.templates[ template_slug ].force_settings %}
{% set is_hierarchical = slot_settings.slot_group == 'menus' and slot_settings.is_hierarchical %}

<h4>{{ strings.misc.title_what_to_include }} {% include 'tooltip.twig' with { \"content\": strings.tooltips.what_to_include } %}</h4>
<ul class=\"js-wpml-ls-to-include\">
    <li>
        <label><input type=\"checkbox\" class=\"js-wpml-ls-setting-display_flags js-wpml-ls-trigger-update\"
                      name=\"{% if name_base %}{{ name_base }}[display_flags]{% else %}display_flags{% endif %}\"
                      {% if force.display_flags is defined  %} disabled=\"disabled\"{% endif %}
                      value=\"1\"{% if slot_settings.display_flags %} checked=\"checked\"{% endif %}> {{ strings.misc.label_include_flag }}</label>
    </li>
    <li>
        <label><input type=\"checkbox\" class=\"js-wpml-ls-setting-display_names_in_native_lang js-wpml-ls-trigger-update\"
                      name=\"{% if name_base %}{{ name_base }}[display_names_in_native_lang]{% else %}display_names_in_native_lang{% endif %}\"
                      {% if force.display_names_in_native_lang is defined %} disabled=\"disabled\"{% endif %}
                      value=\"1\"{% if slot_settings.display_names_in_native_lang %} checked=\"checked\"{% endif %}> {{ strings.misc.label_include_native_lang }}</label>
    </li>
    <li>
        <label><input type=\"checkbox\" class=\"js-wpml-ls-setting-display_names_in_current_lang js-wpml-ls-trigger-update\"
                      name=\"{% if name_base %}{{ name_base }}[display_names_in_current_lang]{% else %}display_names_in_current_lang{% endif %}\"
                      {% if force.display_names_in_current_lang is defined %} disabled=\"disabled\"{% endif %}
                      value=\"1\"{% if slot_settings.display_names_in_current_lang|default(1) %} checked=\"checked\"{% endif %}> {{ strings.misc.label_include_display_lang }}</label>
    </li>
    <li>
        <label><input type=\"checkbox\" class=\"js-wpml-ls-setting-display_link_for_current_lang js-wpml-ls-trigger-update\"
                      name=\"{% if name_base %}{{ name_base }}[display_link_for_current_lang]{% else %}display_link_for_current_lang{% endif %}\"
                      {% if force.display_link_for_current_lang is defined or is_hierarchical %} disabled=\"disabled\"{% endif %}
                      value=\"1\"{% if slot_settings.display_link_for_current_lang|default(1) %} checked=\"checked\"{% endif %}> {{ strings.misc.label_include_current_lang }}</label>
    </li>
</ul>", "checkboxes-includes.twig", "C:\\xampp\\htdocs\\wp\\wp-content\\plugins\\sitepress-multilingual-cms\\templates\\language-switcher-admin-ui\\checkboxes-includes.twig");
    }
}
