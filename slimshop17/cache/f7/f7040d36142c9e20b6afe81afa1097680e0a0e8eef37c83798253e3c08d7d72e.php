<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* index.html.twig */
class __TwigTemplate_39d5cfe2db36f8d6bc7e2aca5feddf67e2d0798d90cf73891e92387fa518706a extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'headAdd' => [$this, 'block_headAdd'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "master.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("master.html.twig", "index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        echo "E-commerce index";
    }

    // line 5
    public function block_headAdd($context, array $blocks = [])
    {
        // line 6
        echo "    <script>
        function loadPage(pageNum) {
            \$(\"#productsView\").load('/ajax/products/page/' + pageNum);
        }        
        \$(document).ready(function() {
            loadPage(1);
        });
    </script>
";
    }

    // line 16
    public function block_content($context, array $blocks = [])
    {
        // line 17
        echo "    <p>We're selling today</p>
    <div id=\"productsView\">
        
    </div>
    <div id=\"pageNavigation\">
        ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(1, (isset($context["totalPages"]) ? $context["totalPages"] : null)));
        foreach ($context['_seq'] as $context["_key"] => $context["num"]) {
            // line 23
            echo "            <button onClick=\"loadPage(";
            echo twig_escape_filter($this->env, $context["num"], "html", null, true);
            echo ")\">";
            echo twig_escape_filter($this->env, $context["num"], "html", null, true);
            echo "</button>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['num'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo "     
    </div>
    
";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 24,  76 => 23,  72 => 22,  65 => 17,  62 => 16,  50 => 6,  47 => 5,  41 => 3,  31 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"master.html.twig\" %}

{% block title %}E-commerce index{% endblock %}

{% block headAdd %}
    <script>
        function loadPage(pageNum) {
            \$(\"#productsView\").load('/ajax/products/page/' + pageNum);
        }        
        \$(document).ready(function() {
            loadPage(1);
        });
    </script>
{% endblock %}

{% block content %}
    <p>We're selling today</p>
    <div id=\"productsView\">
        
    </div>
    <div id=\"pageNavigation\">
        {% for num in range(1, totalPages) %}
            <button onClick=\"loadPage({{num}})\">{{num}}</button>
        {% endfor %}     
    </div>
    
{% endblock content %}
", "index.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\index.html.twig");
    }
}
