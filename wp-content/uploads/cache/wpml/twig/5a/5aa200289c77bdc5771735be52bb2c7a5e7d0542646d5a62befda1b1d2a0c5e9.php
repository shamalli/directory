<?php

/* media-translation-table-row.twig */
class __TwigTemplate_13df8d2a1686c797ce71f61d81e177fdd7e221d663d83c48b3351844d3b7bec9 extends Twig_Template
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
        echo "<tr class=\"wpml-media-attachment-row\" data-attachment-id=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "post", array()), "ID", array()), "html", null, true);
        echo "\"
    data-language-code=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()), "html", null, true);
        echo "\"
    data-language-name=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["languages"]) ? $context["languages"] : null), $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()), array(), "array"), "name", array()), "html", null, true);
        echo "\"
    data-is-image=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "is_image", array()), "html", null, true);
        echo "\"
    data-thumb=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "thumb", array()), "src", array()), "html", null, true);
        echo "\"
    data-file-name=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "file_name", array()), "html", null, true);
        echo "\"
    data-mime-type=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "post", array()), "post_mime_type", array()), "html", null, true);
        echo "\"
    data-title=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "post", array()), "post_title", array()), "html", null, true);
        echo "\"
    data-caption=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "post", array()), "post_excerpt", array()), "html", null, true);
        echo "\"
    data-alt_text=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "alt", array()), "html", null, true);
        echo "\"
    data-description=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "post", array()), "post_content", array()), "html", null, true);
        echo "\"
    data-flag=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["languages"]) ? $context["languages"] : null), $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()), array(), "array"), "flag", array()), "html", null, true);
        echo "\">
    <td class=\"wpml-col-media-title\">
        <span title=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["languages"]) ? $context["languages"] : null), $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()), array(), "array"), "name", array()), "html", null, true);
        echo "\" class=\"wpml-media-original-flag js-wpml-popover-tooltip\"
              data-tippy-distance=\"-12\">
            <img src=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["languages"]) ? $context["languages"] : null), $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()), array(), "array"), "flag", array()), "html", null, true);
        echo "\" width=\"16\" height=\"12\" alt=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()), "html", null, true);
        echo "\">
        </span>
        <span class=\"wpml-media-wrapper\">
            <img src=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "thumb", array()), "src", array()), "html", null, true);
        echo "\" width=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "thumb", array()), "width", array()), "html", null, true);
        echo "\"
                 height=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "thumb", array()), "height", array()), "html", null, true);
        echo "\" alt=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()), "html", null, true);
        echo "\"
                 ";
        // line 21
        if ( !$this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "is_image", array())) {
            echo "class=\"is-non-image\"";
        }
        echo ">
        </span>
    </td>
    <td class=\"wpml-col-media-translations\">
        ";
        // line 25
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["languages"]) ? $context["languages"] : null));
        foreach ($context['_seq'] as $context["code"] => $context["language"]) {
            // line 26
            echo "            ";
            if ((twig_test_empty((isset($context["target_language"]) ? $context["target_language"] : null)) || ((isset($context["target_language"]) ? $context["target_language"] : null) == $context["code"]))) {
                // line 27
                echo "                ";
                if (($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()) == $context["code"])) {
                    // line 28
                    echo "                    <span class=\"js-wpml-popover-tooltip\" data-tippy-distance=\"-12\"
                          title=\"";
                    // line 29
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["languages"]) ? $context["languages"] : null), $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()), array(), "array"), "name", array()), "html", null, true);
                    echo ": ";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "original_language", array()), "html", null, true);
                    echo "\">
                                    <i class=\"otgs-ico-original\"></i>
                                </span>
                ";
                } else {
                    // line 33
                    echo "                    <span class=\"wpml-media-wrapper js-wpml-popover-tooltip\"
                          id=\"media-attachment-";
                    // line 34
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "post", array()), "ID", array()), "html", null, true);
                    echo "-";
                    echo twig_escape_filter($this->env, $context["code"], "html", null, true);
                    echo "\"
                          data-file-name=\"";
                    // line 35
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "file_name", array()), "html", null, true);
                    echo "\"
                          title=\"";
                    // line 36
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["languages"]) ? $context["languages"] : null), $context["code"], array(), "array"), "name", array()), "html", null, true);
                    echo ": ";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "statuses", array()), $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "status", array()), array(), "array"), "html", null, true);
                    echo "\"
                            ";
                    // line 37
                    if ( !$this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "media_is_translated", array())) {
                        // line 38
                        echo "                          data-tippy-distance=\"-12\"
                            ";
                    }
                    // line 40
                    echo "                          data-attachment-id=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "id", array()), "html", null, true);
                    echo "\"
                          data-language-code=\"";
                    // line 41
                    echo twig_escape_filter($this->env, $context["code"], "html", null, true);
                    echo "\"
                          data-language-name=\"";
                    // line 42
                    echo twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", array()), "html", null, true);
                    echo "\"
                          data-thumb=\"";
                    // line 43
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "thumb", array()), "src", array()), "html", null, true);
                    echo "\"
                          data-title=\"";
                    // line 44
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "title", array()), "html", null, true);
                    echo "\"
                          data-caption=\"";
                    // line 45
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "caption", array()), "html", null, true);
                    echo "\"
                          data-alt_text=\"";
                    // line 46
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "alt", array()), "html", null, true);
                    echo "\"
                          data-description=\"";
                    // line 47
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "description", array()), "html", null, true);
                    echo "\"
                          data-flag=\"";
                    // line 48
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["languages"]) ? $context["languages"] : null), $context["code"], array(), "array"), "flag", array()), "html", null, true);
                    echo "\"
                          data-media-is-translated=\"";
                    // line 49
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "media_is_translated", array()), "html", null, true);
                    echo "\">
                                    <a class=\"js-open-media-translation-dialog ";
                    // line 50
                    if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "media_is_translated", array())) {
                        echo "wpml-media-translation-image";
                    }
                    echo "\">
                                        <img src=\"";
                    // line 51
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "thumb", array()), "src", array()), "html", null, true);
                    echo "\"
                                             width=\"";
                    // line 52
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "thumb", array()), "width", array()), "html", null, true);
                    echo "\" height=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "thumb", array()), "height", array()), "html", null, true);
                    echo "\"
                                             alt=\"";
                    // line 53
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "language", array()), "html", null, true);
                    echo "\"
                                             ";
                    // line 54
                    if ( !$this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "is_image", array())) {
                        echo "class=\"is-non-image\"";
                    }
                    // line 55
                    echo "                                                ";
                    if ( !$this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "media_is_translated", array())) {
                        echo "style=\"display:none\"";
                    }
                    echo ">
                                        <i class=\"";
                    // line 56
                    if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "id", array())) {
                        echo "otgs-ico-edit";
                    } else {
                        echo "otgs-ico-add";
                    }
                    echo "\"
                                           ";
                    // line 57
                    if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["attachment"]) ? $context["attachment"] : null), "translations", array()), $context["code"], array(), "array"), "media_is_translated", array())) {
                        echo "style=\"display:none\"";
                    }
                    echo "></i>
                                    </a>
                                </span>
                ";
                }
                // line 61
                echo "            ";
            }
            // line 62
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['code'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 63
        echo "    </td>
</tr>";
    }

    public function getTemplateName()
    {
        return "media-translation-table-row.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  248 => 63,  242 => 62,  239 => 61,  230 => 57,  222 => 56,  215 => 55,  211 => 54,  207 => 53,  201 => 52,  197 => 51,  191 => 50,  187 => 49,  183 => 48,  179 => 47,  175 => 46,  171 => 45,  167 => 44,  163 => 43,  159 => 42,  155 => 41,  150 => 40,  146 => 38,  144 => 37,  138 => 36,  134 => 35,  128 => 34,  125 => 33,  116 => 29,  113 => 28,  110 => 27,  107 => 26,  103 => 25,  94 => 21,  88 => 20,  82 => 19,  74 => 16,  69 => 14,  64 => 12,  60 => 11,  56 => 10,  52 => 9,  48 => 8,  44 => 7,  40 => 6,  36 => 5,  32 => 4,  28 => 3,  24 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<tr class=\"wpml-media-attachment-row\" data-attachment-id=\"{{ attachment.post.ID }}\"
    data-language-code=\"{{ attachment.language }}\"
    data-language-name=\"{{ languages[attachment.language].name }}\"
    data-is-image=\"{{ attachment.is_image }}\"
    data-thumb=\"{{ attachment.thumb.src }}\"
    data-file-name=\"{{ attachment.file_name }}\"
    data-mime-type=\"{{ attachment.post.post_mime_type }}\"
    data-title=\"{{ attachment.post.post_title }}\"
    data-caption=\"{{ attachment.post.post_excerpt }}\"
    data-alt_text=\"{{ attachment.alt }}\"
    data-description=\"{{ attachment.post.post_content }}\"
    data-flag=\"{{ languages[attachment.language].flag }}\">
    <td class=\"wpml-col-media-title\">
        <span title=\"{{ languages[attachment.language].name }}\" class=\"wpml-media-original-flag js-wpml-popover-tooltip\"
              data-tippy-distance=\"-12\">
            <img src=\"{{ languages[attachment.language].flag }}\" width=\"16\" height=\"12\" alt=\"{{ attachment.language }}\">
        </span>
        <span class=\"wpml-media-wrapper\">
            <img src=\"{{ attachment.thumb.src }}\" width=\"{{ attachment.thumb.width }}\"
                 height=\"{{ attachment.thumb.height }}\" alt=\"{{ attachment.language }}\"
                 {% if not attachment.is_image %}class=\"is-non-image\"{% endif %}>
        </span>
    </td>
    <td class=\"wpml-col-media-translations\">
        {% for code, language in languages %}
            {% if target_language is empty or target_language == code %}
                {% if attachment.language == code %}
                    <span class=\"js-wpml-popover-tooltip\" data-tippy-distance=\"-12\"
                          title=\"{{ languages[attachment.language].name }}: {{ strings.original_language }}\">
                                    <i class=\"otgs-ico-original\"></i>
                                </span>
                {% else %}
                    <span class=\"wpml-media-wrapper js-wpml-popover-tooltip\"
                          id=\"media-attachment-{{ attachment.post.ID }}-{{ code }}\"
                          data-file-name=\"{{ attachment.translations[code].file_name }}\"
                          title=\"{{ languages[code].name }}: {{ strings.statuses[attachment.translations[code].status ] }}\"
                            {% if not attachment.translations[code].media_is_translated %}
                          data-tippy-distance=\"-12\"
                            {% endif %}
                          data-attachment-id=\"{{ attachment.translations[code].id }}\"
                          data-language-code=\"{{ code }}\"
                          data-language-name=\"{{ language.name }}\"
                          data-thumb=\"{{ attachment.translations[code].thumb.src }}\"
                          data-title=\"{{ attachment.translations[code].title }}\"
                          data-caption=\"{{ attachment.translations[code].caption }}\"
                          data-alt_text=\"{{ attachment.translations[code].alt }}\"
                          data-description=\"{{ attachment.translations[code].description }}\"
                          data-flag=\"{{ languages[code].flag }}\"
                          data-media-is-translated=\"{{ attachment.translations[code].media_is_translated }}\">
                                    <a class=\"js-open-media-translation-dialog {% if attachment.translations[code].media_is_translated %}wpml-media-translation-image{% endif %}\">
                                        <img src=\"{{ attachment.translations[code].thumb.src }}\"
                                             width=\"{{ attachment.thumb.width }}\" height=\"{{ attachment.thumb.height }}\"
                                             alt=\"{{ attachment.language }}\"
                                             {% if not attachment.is_image %}class=\"is-non-image\"{% endif %}
                                                {% if not attachment.translations[code].media_is_translated %}style=\"display:none\"{% endif %}>
                                        <i class=\"{% if attachment.translations[code].id %}otgs-ico-edit{% else %}otgs-ico-add{% endif %}\"
                                           {% if attachment.translations[code].media_is_translated %}style=\"display:none\"{% endif %}></i>
                                    </a>
                                </span>
                {% endif %}
            {% endif %}
        {% endfor %}
    </td>
</tr>", "media-translation-table-row.twig", "C:\\xampp\\htdocs\\wp\\wp-content\\plugins\\wpml-media-translation\\templates\\menus\\media-translation-table-row.twig");
    }
}
