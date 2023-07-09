<?php

/* batch-translation.twig */
class __TwigTemplate_2b4c31de9afdfa912178fc3034e5227b0a47640408b0c17f75face79b11c373e extends Twig_Template
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
        echo "<div id=\"batch-media-translation-wrap\" class=\"batch-media-translation-wrap notice otgs-notice notice-info otgs-is-dismissible\" style=\"display: none\">
    <span class=\"notice-dismiss js-close\"><span class=\"screen-reader-text\">";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "close", array()), "html", null, true);
        echo "</span></span>
    <form id=\"batch-media-translation-form\" method=\"post\" action=\"\">
        <input type=\"hidden\" name=\"action\" value=\"wpml_media_scan_prepare\" />
        <div class=\"usage\" style=\"display: none\">
            <p>";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "was_replaced", array()), "html", null, true);
        echo "</p>
            <ul class=\"batch-media-translation-post-list\"></ul>
            <p>";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "other_posts", array()), "html", null, true);
        echo "</p>
        </div>
        <div class=\"no-usage\" style=\"display: none\">
            <p>";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "without_usage", array()), "html", null, true);
        echo "</p>
        </div>
        <div class=\"batch-media-translation-action-wrap\">
        <ul class=\"batch-media-translation-action-list\">
            <li>
                <label>
                    <input type=\"radio\" name=\"global-scan-scope\" value=\"0\" checked/>";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "scan_for_this_media", array()), "html", null, true);
        echo "
                </label>
            </li>
            <li>
                <label>
                    <input type=\"radio\" name=\"global-scan-scope\" value=\"1\"/>";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "scan_for_all_media", array()), "html", null, true);
        echo "
                </label>
            </li>
        </ul>
        <p class=\"text-right\">
            <input type=\"submit\" class=\"button-primary\" value=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "button_label", array()), "html", null, true);
        echo "\"/>
        </p>
        </div>
    </form>
    <p class=\"status\"></p>
</div>";
    }

    public function getTemplateName()
    {
        return "batch-translation.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 27,  57 => 22,  49 => 17,  40 => 11,  34 => 8,  29 => 6,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div id=\"batch-media-translation-wrap\" class=\"batch-media-translation-wrap notice otgs-notice notice-info otgs-is-dismissible\" style=\"display: none\">
    <span class=\"notice-dismiss js-close\"><span class=\"screen-reader-text\">{{ strings.close }}</span></span>
    <form id=\"batch-media-translation-form\" method=\"post\" action=\"\">
        <input type=\"hidden\" name=\"action\" value=\"wpml_media_scan_prepare\" />
        <div class=\"usage\" style=\"display: none\">
            <p>{{ strings.was_replaced }}</p>
            <ul class=\"batch-media-translation-post-list\"></ul>
            <p>{{ strings.other_posts }}</p>
        </div>
        <div class=\"no-usage\" style=\"display: none\">
            <p>{{ strings.without_usage }}</p>
        </div>
        <div class=\"batch-media-translation-action-wrap\">
        <ul class=\"batch-media-translation-action-list\">
            <li>
                <label>
                    <input type=\"radio\" name=\"global-scan-scope\" value=\"0\" checked/>{{ strings.scan_for_this_media }}
                </label>
            </li>
            <li>
                <label>
                    <input type=\"radio\" name=\"global-scan-scope\" value=\"1\"/>{{ strings.scan_for_all_media }}
                </label>
            </li>
        </ul>
        <p class=\"text-right\">
            <input type=\"submit\" class=\"button-primary\" value=\"{{ strings.button_label }}\"/>
        </p>
        </div>
    </form>
    <p class=\"status\"></p>
</div>", "batch-translation.twig", "C:\\xampp\\htdocs\\wp\\wp-content\\plugins\\wpml-media-translation\\templates\\menus\\batch-translation.twig");
    }
}
