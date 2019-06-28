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

/* admin/categories_add.html.twig */
class __TwigTemplate_8604d9f45c6c2409d5dcecf08ba5719ca4d46e1612f57feaeb2416d48b628425 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'title' => [$this, 'block_title'],
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
        $this->parent = $this->loadTemplate("master.html.twig", "admin/categories_add.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        echo "Add category";
    }

    // line 5
    public function block_content($context, array $blocks = [])
    {
        // line 6
        echo "
    ";
        // line 7
        if ((isset($context["errorList"]) ? $context["errorList"] : null)) {
            // line 8
            echo "        <ul>
            ";
            // line 9
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["errorList"]) ? $context["errorList"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 10
                echo "                <li>";
                echo twig_escape_filter($this->env, $context["error"], "html", null, true);
                echo "</li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 12
            echo "        </ul>
    ";
        }
        // line 14
        echo "
    <form method=\"post\" enctype=\"multipart/form-data\">
        Name: <input type=\"text\" name=\"name\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["v"]) ? $context["v"] : null), "name", []), "html", null, true);
        echo "\"><br>        
        Image: <input type=\"file\" name=\"image\">
        <input type=\"submit\" value=\"Add category\">
    </form>

";
    }

    public function getTemplateName()
    {
        return "admin/categories_add.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 16,  74 => 14,  70 => 12,  61 => 10,  57 => 9,  54 => 8,  52 => 7,  49 => 6,  46 => 5,  40 => 3,  30 => 1,);
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

{% block title %}Add category{% endblock %}

{% block content %}

    {% if errorList %}
        <ul>
            {% for error in errorList %}
                <li>{{error}}</li>
            {% endfor %}
        </ul>
    {% endif %}

    <form method=\"post\" enctype=\"multipart/form-data\">
        Name: <input type=\"text\" name=\"name\" value=\"{{v.name}}\"><br>        
        Image: <input type=\"file\" name=\"image\">
        <input type=\"submit\" value=\"Add category\">
    </form>

{% endblock content %}
", "admin/categories_add.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\admin\\categories_add.html.twig");
    }
}
