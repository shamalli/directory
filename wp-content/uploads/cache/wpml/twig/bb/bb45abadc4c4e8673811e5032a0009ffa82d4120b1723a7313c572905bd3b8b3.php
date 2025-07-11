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

/* table-nav-arrow.twig */
class __TwigTemplate_6d77f6c9d7bcff822a0d98e728017b5681408aabb4a629e830b3cfca9a5951a0 extends \WPML\Core\Twig\Template
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
        $context["arrows"] = ["first-page" => "«", "previous-page" => "‹", "next-page" => "›", "last-page" => "»"];
        // line 8
        echo "
";
        // line 9
        if (($context["url"] ?? null)) {
            // line 10
            echo "    <a class=\"";
            echo \WPML\Core\twig_escape_filter($this->env, ($context["class"] ?? null), "html", null, true);
            echo "\" href=\"";
            echo \WPML\Core\twig_escape_filter($this->env, ($context["url"] ?? null), "html", null, true);
            echo "\">
        <span class=\"screen-reader-text\">";
            // line 11
            echo \WPML\Core\twig_escape_filter($this->env, ($context["label"] ?? null), "html", null, true);
            echo "</span><span aria-hidden=\"true\">";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["arrows"] ?? null), ($context["class"] ?? null), [], "array"), "html", null, true);
            echo "</span>
    </a>
";
        } else {
            // line 14
            echo "    <span class=\"tablenav-pages-navspan\" aria-hidden=\"true\">";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["arrows"] ?? null), ($context["class"] ?? null), [], "array"), "html", null, true);
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
        return array (  54 => 14,  46 => 11,  39 => 10,  37 => 9,  34 => 8,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% set arrows = {
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
