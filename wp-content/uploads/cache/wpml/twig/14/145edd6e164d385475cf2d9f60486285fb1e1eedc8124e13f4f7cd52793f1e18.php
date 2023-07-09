<?php

/* table-nav-arrow.twig */
class __TwigTemplate_880af374f4ff53961c5f4c33f3369e4143cc91c2b2559ecaad16220e5c955fd9 extends Twig_Template
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
        $context["arrows"] = array("first-page" => "«", "previous-page" => "‹", "next-page" => "›", "last-page" => "»");
        // line 8
        echo "
";
        // line 9
        if ((isset($context["url"]) ? $context["url"] : null)) {
            // line 10
            echo "    <a class=\"";
            echo twig_escape_filter($this->env, (isset($context["class"]) ? $context["class"] : null), "html", null, true);
            echo "\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true);
            echo "\">
        <span class=\"screen-reader-text\">";
            // line 11
            echo twig_escape_filter($this->env, (isset($context["label"]) ? $context["label"] : null), "html", null, true);
            echo "</span><span aria-hidden=\"true\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["arrows"]) ? $context["arrows"] : null), (isset($context["class"]) ? $context["class"] : null), array(), "array"), "html", null, true);
            echo "</span>
    </a>
";
        } else {
            // line 14
            echo "    <span class=\"tablenav-pages-navspan\" aria-hidden=\"true\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["arrows"]) ? $context["arrows"] : null), (isset($context["class"]) ? $context["class"] : null), array(), "array"), "html", null, true);
            echo "</span>
";
        }
    }

    public function getTemplateName()
    {
        return "table-nav-arrow.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 14,  33 => 11,  26 => 10,  24 => 9,  21 => 8,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% set arrows = {
'first-page':     '«',
'previous-page':  '‹',
'next-page':      '›',
'last-page':      '»'
}
%}

{% if url %}
    <a class=\"{{ class }}\" href=\"{{ url }}\">
        <span class=\"screen-reader-text\">{{ label }}</span><span aria-hidden=\"true\">{{ arrows[ class ] }}</span>
    </a>
{% else %}
    <span class=\"tablenav-pages-navspan\" aria-hidden=\"true\">{{ arrows[ class ] }}</span>
{% endif %}", "table-nav-arrow.twig", "C:\\xampp\\htdocs\\wp\\wp-content\\plugins\\sitepress-multilingual-cms\\templates\\pagination\\table-nav-arrow.twig");
    }
}
