<?php

/* pagination.twig */
class __TwigTemplate_69594dca55ae9aa2aa55ba89acb1e83b0cd1e3f0b6125895d8e25bc44dbbce1b extends Twig_Template
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
        if ($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "total_items", array())) {
            // line 2
            echo "
    <h2 class=\"screen-reader-text\">";
            // line 3
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "strings", array()), "list_navigation", array()), "html", null, true);
            echo "</h2>

    <div class=\"tablenav-pages clearfix\">

        <span class=\"displaying-num\">";
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "total_items_text", array()), "html", null, true);
            echo "</span>

        ";
            // line 9
            if (($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "total_items", array()) > $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_items_per_page", array()))) {
                // line 10
                echo "
        <span class=\"pagination-links\">

            ";
                // line 13
                $this->loadTemplate("table-nav-arrow.twig", "pagination.twig", 13)->display(array_merge($context, array("url" => $this->getAttribute($this->getAttribute(                // line 15
(isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_first_page_url", array()), "class" => "first-page", "label" => $this->getAttribute($this->getAttribute(                // line 17
(isset($context["pagination_model"]) ? $context["pagination_model"] : null), "strings", array()), "first_page", array()))));
                // line 20
                echo "
            ";
                // line 21
                $this->loadTemplate("table-nav-arrow.twig", "pagination.twig", 21)->display(array_merge($context, array("url" => $this->getAttribute($this->getAttribute(                // line 23
(isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_previous_page_url", array()), "class" => "previous-page", "label" => $this->getAttribute($this->getAttribute(                // line 25
(isset($context["pagination_model"]) ? $context["pagination_model"] : null), "strings", array()), "previous_page", array()))));
                // line 28
                echo "
            <span class=\"paging-input\">
                ";
                // line 30
                if (((isset($context["nav_location"]) ? $context["nav_location"] : null) == "top")) {
                    // line 31
                    echo "                    <label for=\"current-page-selector-";
                    echo twig_escape_filter($this->env, (isset($context["nav_location"]) ? $context["nav_location"] : null), "html", null, true);
                    echo "\" class=\"screen-reader-text\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "strings", array()), "current_page", array()), "html", null, true);
                    echo "</label>
                    <input class=\"current-page\" id=\"current-page-selector-";
                    // line 32
                    echo twig_escape_filter($this->env, (isset($context["nav_location"]) ? $context["nav_location"] : null), "html", null, true);
                    echo "\" type=\"text\" name=\"paged\"
                           value=\"";
                    // line 33
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_current_page", array()), "html", null, true);
                    echo "\" size=\"";
                    echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_total_pages", array())), "html", null, true);
                    echo "\" aria-describedby=\"table-paging\">
                    <span class=\"tablenav-paging-text\"> ";
                    // line 34
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "strings", array()), "of", array()), "html", null, true);
                    echo " <span class=\"total-pages\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_total_pages", array()), "html", null, true);
                    echo "</span></span>
                ";
                } else {
                    // line 36
                    echo "                    <span class=\"tablenav-paging-text\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_current_page", array()), "html", null, true);
                    echo " ";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "strings", array()), "of", array()), "html", null, true);
                    echo "
                        <span class=\"total-pages\">";
                    // line 37
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_total_pages", array()), "html", null, true);
                    echo "</span>
                    </span>
                ";
                }
                // line 40
                echo "            </span>

            ";
                // line 42
                $this->loadTemplate("table-nav-arrow.twig", "pagination.twig", 42)->display(array_merge($context, array("url" => $this->getAttribute($this->getAttribute(                // line 44
(isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_next_page_url", array()), "class" => "next-page", "label" => $this->getAttribute($this->getAttribute(                // line 46
(isset($context["pagination_model"]) ? $context["pagination_model"] : null), "strings", array()), "next_page", array()))));
                // line 49
                echo "

            ";
                // line 51
                $this->loadTemplate("table-nav-arrow.twig", "pagination.twig", 51)->display(array_merge($context, array("url" => $this->getAttribute($this->getAttribute(                // line 53
(isset($context["pagination_model"]) ? $context["pagination_model"] : null), "pagination", array()), "get_last_page_url", array()), "class" => "last-page", "label" => $this->getAttribute($this->getAttribute(                // line 55
(isset($context["pagination_model"]) ? $context["pagination_model"] : null), "strings", array()), "last_page", array()))));
                // line 58
                echo "
        </span>

        ";
            }
            // line 62
            echo "
    </div>
";
        }
    }

    public function getTemplateName()
    {
        return "pagination.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  119 => 62,  113 => 58,  111 => 55,  110 => 53,  109 => 51,  105 => 49,  103 => 46,  102 => 44,  101 => 42,  97 => 40,  91 => 37,  84 => 36,  77 => 34,  71 => 33,  67 => 32,  60 => 31,  58 => 30,  54 => 28,  52 => 25,  51 => 23,  50 => 21,  47 => 20,  45 => 17,  44 => 15,  43 => 13,  38 => 10,  36 => 9,  31 => 7,  24 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% if pagination_model.total_items %}

    <h2 class=\"screen-reader-text\">{{ pagination_model.strings.list_navigation }}</h2>

    <div class=\"tablenav-pages clearfix\">

        <span class=\"displaying-num\">{{ pagination_model.total_items_text }}</span>

        {% if pagination_model.total_items > pagination_model.pagination.get_items_per_page %}

        <span class=\"pagination-links\">

            {% include 'table-nav-arrow.twig'
            with {
            'url': pagination_model.pagination.get_first_page_url,
            'class': 'first-page',
            'label': pagination_model.strings.first_page,
            }
            %}

            {% include 'table-nav-arrow.twig'
            with {
            'url': pagination_model.pagination.get_previous_page_url,
            'class': 'previous-page',
            'label': pagination_model.strings.previous_page,
            }
            %}

            <span class=\"paging-input\">
                {% if nav_location == 'top' %}
                    <label for=\"current-page-selector-{{ nav_location }}\" class=\"screen-reader-text\">{{ pagination_model.strings.current_page }}</label>
                    <input class=\"current-page\" id=\"current-page-selector-{{ nav_location }}\" type=\"text\" name=\"paged\"
                           value=\"{{ pagination_model.pagination.get_current_page }}\" size=\"{{ pagination_model.pagination.get_total_pages|length }}\" aria-describedby=\"table-paging\">
                    <span class=\"tablenav-paging-text\"> {{ pagination_model.strings.of }} <span class=\"total-pages\">{{ pagination_model.pagination.get_total_pages }}</span></span>
                {% else %}
                    <span class=\"tablenav-paging-text\">{{ pagination_model.pagination.get_current_page }} {{ pagination_model.strings.of }}
                        <span class=\"total-pages\">{{ pagination_model.pagination.get_total_pages }}</span>
                    </span>
                {% endif %}
            </span>

            {% include 'table-nav-arrow.twig'
            with {
            'url': pagination_model.pagination.get_next_page_url,
            'class': 'next-page',
            'label': pagination_model.strings.next_page,
            }
            %}


            {% include 'table-nav-arrow.twig'
            with {
            'url': pagination_model.pagination.get_last_page_url,
            'class': 'last-page',
            'label': pagination_model.strings.last_page,
            }
            %}

        </span>

        {% endif %}

    </div>
{% endif %}", "pagination.twig", "C:\\xampp\\htdocs\\wp\\wp-content\\plugins\\sitepress-multilingual-cms\\templates\\pagination\\pagination.twig");
    }
}
