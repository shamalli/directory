<?php

/* source-language.twig */
class __TwigTemplate_6a4ca8298729357b91ace3e1b66cc5f025a53e35ffefc977893fbe7fd53f859e extends Twig_Template
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
        echo "<div class=\"source_language\">
\t<label for=\"source-language-selector\">";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "sourceLanguageSelectorLabel", array()), "html", null, true);
        echo ":</label>
\t<select id=\"source-language-selector\">
\t\t";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["activeLanguages"]) ? $context["activeLanguages"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["activeLanguage"]) {
            // line 5
            echo "\t\t\t";
            $context["default"] = ($this->getAttribute($context["activeLanguage"], "code", array()) == (isset($context["defaultLanguage"]) ? $context["defaultLanguage"] : null));
            // line 6
            echo "\t\t\t";
            $context["showTranslated"] = ($this->getAttribute($context["activeLanguage"], "native_name", array(), "array") != $this->getAttribute($context["activeLanguage"], "translated_name", array(), "array"));
            // line 7
            echo "\t\t\t";
            $context["language"] = (((isset($context["showTranslated"]) ? $context["showTranslated"] : null)) ? (((($this->getAttribute($context["activeLanguage"], "translated_name", array(), "array") . " (") . $this->getAttribute($context["activeLanguage"], "native_name", array(), "array")) . ")")) : ($this->getAttribute($context["activeLanguage"], "native_name", array(), "array")));
            // line 8
            echo "\t\t\t<option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["activeLanguage"], "code", array()));
            echo "\"";
            if ((isset($context["default"]) ? $context["default"] : null)) {
                echo " selected=\"selected\" ";
            }
            echo ">";
            echo twig_escape_filter($this->env, (isset($context["language"]) ? $context["language"] : null), "html", null, true);
            echo "</option>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['activeLanguage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "\t</select>
\t<input type=\"hidden\" name=\"wpml_words_count_source_language_nonce\" value=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["nonces"]) ? $context["nonces"] : null), "wpml_words_count_source_language_nonce", array()));
        echo "\">
</div>";
    }

    public function getTemplateName()
    {
        return "source-language.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 11,  55 => 10,  40 => 8,  37 => 7,  34 => 6,  31 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"source_language\">
\t<label for=\"source-language-selector\">{{ strings.sourceLanguageSelectorLabel }}:</label>
\t<select id=\"source-language-selector\">
\t\t{% for activeLanguage in activeLanguages %}
\t\t\t{% set default = (activeLanguage.code == defaultLanguage) %}
\t\t\t{% set showTranslated = (activeLanguage['native_name'] != activeLanguage['translated_name']) %}
\t\t\t{% set language = showTranslated ? \"#{activeLanguage['translated_name']} (#{activeLanguage['native_name']})\" : activeLanguage['native_name'] %}
\t\t\t<option value=\"{{ activeLanguage.code|e }}\"{% if (default) %} selected=\"selected\" {% endif %}>{{ language }}</option>
\t\t{% endfor %}
\t</select>
\t<input type=\"hidden\" name=\"wpml_words_count_source_language_nonce\" value=\"{{ nonces.wpml_words_count_source_language_nonce|e }}\">
</div>", "source-language.twig", "C:\\xampp\\htdocs\\wp\\wp-content\\plugins\\wpml-translation-management\\templates\\words-count\\source-language.twig");
    }
}
