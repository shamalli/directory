<?php

/* table-slots.twig */
class __TwigTemplate_37c21ae5f54efb7a42765d3c0302e8dbbcbec5c3c5bf36498eff0d068ba78b3f extends Twig_Template
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
        if ((($context["slot_type"] ?? null) == "statics")) {
            // line 2
            echo "\t";
            $context["is_static"] = true;
            // line 3
            echo "\t";
            $context["table_id"] = ((("wpml-ls-slot-list-" . ($context["slot_type"] ?? null)) . "-") . ($context["slug"] ?? null));
        } else {
            // line 5
            echo "\t";
            $context["table_id"] = ("wpml-ls-slot-list-" . ($context["slot_type"] ?? null));
        }
        // line 7
        echo "
";
        // line 8
        if (twig_in_filter(($context["slug"] ?? null), array(0 => "footer", 1 => "post_translations"))) {
            // line 9
            echo "    ";
            $context["label_action"] = $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "label_action", array());
        } else {
            // line 11
            echo "    ";
            $context["label_action"] = $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "label_actions", array());
        }
        // line 13
        echo "
<table id=\"";
        // line 14
        echo twig_escape_filter($this->env, ($context["table_id"] ?? null), "html", null, true);
        echo "\" class=\"js-wpml-ls-slot-list wpml-ls-slot-list\"";
        if ( !($context["slots_settings"] ?? null)) {
            echo " style=\"display:none;\"";
        }
        echo ">
    <thead>
    <tr>
        <th>";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "label_preview", array()), "html", null, true);
        echo "</th>
        ";
        // line 18
        if ( !($context["is_static"] ?? null)) {
            echo "<th>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "label_position", array()), "html", null, true);
            echo "</th>";
        }
        // line 19
        echo "        <th";
        if ( !($context["is_static"] ?? null)) {
            echo " colspan=\"2\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, ($context["label_action"] ?? null), "html", null, true);
        echo "</th></tr>
    </thead>
    <tbody>
    ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["slots_settings"] ?? null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["slug"] => $context["slot_settings"]) {
            // line 23
            echo "        ";
            $this->loadTemplate("table-slot-row.twig", "table-slots.twig", 23)->display(array_merge($context, array("slug" =>             // line 25
$context["slug"], "slot_type" =>             // line 26
($context["slot_type"] ?? null), "slot_settings" =>             // line 27
$context["slot_settings"], "slots" =>             // line 28
($context["slots"] ?? null))));
            // line 31
            echo "    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['slug'], $context['slot_settings'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "    </tbody>
</table>";
    }

    public function getTemplateName()
    {
        return "table-slots.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 32,  103 => 31,  101 => 28,  100 => 27,  99 => 26,  98 => 25,  96 => 23,  79 => 22,  68 => 19,  62 => 18,  58 => 17,  48 => 14,  45 => 13,  41 => 11,  37 => 9,  35 => 8,  32 => 7,  28 => 5,  24 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% if slot_type == 'statics' %}
\t{% set is_static = true %}
\t{% set table_id = 'wpml-ls-slot-list-' ~ slot_type ~ '-' ~ slug %}
{% else %}
\t{% set table_id = 'wpml-ls-slot-list-' ~ slot_type %}
{% endif %}

{% if slug in ['footer', 'post_translations'] %}
    {% set label_action = strings.misc.label_action %}
{% else %}
    {% set label_action = strings.misc.label_actions %}
{% endif %}

<table id=\"{{ table_id }}\" class=\"js-wpml-ls-slot-list wpml-ls-slot-list\"{% if not slots_settings %} style=\"display:none;\"{% endif %}>
    <thead>
    <tr>
        <th>{{ strings.misc.label_preview }}</th>
        {% if not is_static %}<th>{{ strings.misc.label_position }}</th>{% endif %}
        <th{% if not is_static %} colspan=\"2\"{% endif %}>{{ label_action }}</th></tr>
    </thead>
    <tbody>
    {% for slug, slot_settings in slots_settings %}
        {% include 'table-slot-row.twig'
            with {
                \"slug\": slug,
                \"slot_type\": slot_type,
                \"slot_settings\": slot_settings,
                \"slots\": slots,
            }
        %}
    {% endfor %}
    </tbody>
</table>", "table-slots.twig", "C:\\xampp\\htdocs\\wp\\wp-content\\plugins\\sitepress-multilingual-cms\\templates\\language-switcher-admin-ui\\table-slots.twig");
    }
}
