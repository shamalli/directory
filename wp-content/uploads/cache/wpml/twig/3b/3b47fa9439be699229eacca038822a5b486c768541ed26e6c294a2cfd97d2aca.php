<?php

/* slot-subform-statics-footer.twig */
class __TwigTemplate_da0886c94d95aa264b21d0ea24906fbad68b28961433fc410811ba36f5166879 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->loadTemplate("preview.twig", "slot-subform-statics-footer.twig", 1)->display(array_merge($context, array("preview" => $this->getAttribute($this->getAttribute((isset($context["previews"]) ? $context["previews"] : null), "statics", array()), "footer", array()))));
        // line 2
        echo "
<div class=\"wpml-ls-subform-options\">

\t";
        // line 5
        $this->loadTemplate("dropdown-templates.twig", "slot-subform-statics-footer.twig", 5)->display(array_merge($context, array("id" => "in-footer", "name" => "statics[footer][template]", "value" => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 9
(isset($context["settings"]) ? $context["settings"] : null), "statics", array()), "footer", array()), "template", array()), "slot_type" => "footer")));
        // line 13
        echo "
\t";
        // line 14
        $this->loadTemplate("checkboxes-includes.twig", "slot-subform-statics-footer.twig", 14)->display(array_merge($context, array("name_base" => "statics[footer]", "slot_settings" => $this->getAttribute($this->getAttribute(        // line 17
(isset($context["settings"]) ? $context["settings"] : null), "statics", array()), "footer", array()), "template_slug" => $this->getAttribute(        // line 18
(isset($context["slot_settings"]) ? $context["slot_settings"] : null), "template", array()))));
        // line 21
        echo "
\t";
        // line 22
        $this->loadTemplate("panel-colors.twig", "slot-subform-statics-footer.twig", 22)->display(array_merge($context, array("id" => "static-footer", "name_base" => "statics[footer]", "slot_settings" => $this->getAttribute($this->getAttribute(        // line 26
(isset($context["settings"]) ? $context["settings"] : null), "statics", array()), "footer", array()))));
        // line 29
        echo "
</div>";
    }

    public function getTemplateName()
    {
        return "slot-subform-statics-footer.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 29,  40 => 26,  39 => 22,  36 => 21,  34 => 18,  33 => 17,  32 => 14,  29 => 13,  27 => 9,  26 => 5,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% include 'preview.twig' with {\"preview\": previews.statics.footer } %}

<div class=\"wpml-ls-subform-options\">

\t{% include 'dropdown-templates.twig'
\t\twith {
\t\t\t\"id\": \"in-footer\",
\t\t\t\"name\": \"statics[footer][template]\",
\t\t\t\"value\":     settings.statics.footer.template,
\t\t\t\"slot_type\": \"footer\",
\t\t}
\t%}

\t{% include 'checkboxes-includes.twig'
\t\twith {
\t\t\t\"name_base\": \"statics[footer]\",
\t\t\t\"slot_settings\": settings.statics.footer,
\t\t\t\"template_slug\": slot_settings.template,
\t\t}
\t%}

\t{% include 'panel-colors.twig'
\t\twith {
\t\t\t\"id\": \"static-footer\",
\t\t\t\"name_base\": \"statics[footer]\",
\t\t\t\"slot_settings\": settings.statics.footer,
\t\t}
\t%}

</div>", "slot-subform-statics-footer.twig", "C:\\xampp\\htdocs\\wp\\wp-content\\plugins\\sitepress-multilingual-cms\\templates\\language-switcher-admin-ui\\slot-subform-statics-footer.twig");
    }
}
