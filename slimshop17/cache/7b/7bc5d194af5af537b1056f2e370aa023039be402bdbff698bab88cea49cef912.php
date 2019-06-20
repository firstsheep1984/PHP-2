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

/* admin/products_list.html.twig */
class __TwigTemplate_60c2d8a99efef82cb402210f52cca3563d2a26559c08733e32ec350de2a380d1 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("master.html.twig", "admin/products_list.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        echo "Access denied";
    }

    // line 5
    public function block_content($context, array $blocks = [])
    {
        // line 6
        echo "    <p><a href=\"/admin/products/add\">add product</a></p>
    <table border=\"1\">
        <tr><th>#</th><th>name</th><th>description</th><th>price</th><th>image</th><th>actions</th></tr>
        ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["list"]) ? $context["list"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["p"]) {
            // line 10
            echo "        <tr>
            <td>";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "id", []), "html", null, true);
            echo "</td>
            <td>";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "name", []), "html", null, true);
            echo "</td>
            <td>";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "description", []), "html", null, true);
            echo "</td>
            <td>";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "price", []), "html", null, true);
            echo "</td>
            <td>todo</td>
            <td>
                <!-- method 1 - simple h-ref text link -->
                <!-- <a href=\"/admin/products/edit/";
            // line 18
            echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "id", []), "html", null, true);
            echo "\">Edit</a> -->
                <!-- method 2 - button with javascript -->
                <button onclick=\"window.location='/admin/products/delete/";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "id", []), "html", null, true);
            echo "';\">Delete</button>
                <!-- method 3 - form with submit button -->
                <form action=\"/admin/products/edit/";
            // line 22
            echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "id", []), "html", null, true);
            echo "\">
                    <input type=\"submit\" value=\"Edit\">
                </form>
            </td>
        </tr>                
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['p'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        echo "    </table>
";
    }

    public function getTemplateName()
    {
        return "admin/products_list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  102 => 28,  90 => 22,  85 => 20,  80 => 18,  73 => 14,  69 => 13,  65 => 12,  61 => 11,  58 => 10,  54 => 9,  49 => 6,  46 => 5,  40 => 3,  30 => 1,);
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

{% block title %}Access denied{% endblock %}

{% block content %}
    <p><a href=\"/admin/products/add\">add product</a></p>
    <table border=\"1\">
        <tr><th>#</th><th>name</th><th>description</th><th>price</th><th>image</th><th>actions</th></tr>
        {% for p in list %}
        <tr>
            <td>{{p.id}}</td>
            <td>{{p.name}}</td>
            <td>{{p.description}}</td>
            <td>{{p.price}}</td>
            <td>todo</td>
            <td>
                <!-- method 1 - simple h-ref text link -->
                <!-- <a href=\"/admin/products/edit/{{p.id}}\">Edit</a> -->
                <!-- method 2 - button with javascript -->
                <button onclick=\"window.location='/admin/products/delete/{{p.id}}';\">Delete</button>
                <!-- method 3 - form with submit button -->
                <form action=\"/admin/products/edit/{{p.id}}\">
                    <input type=\"submit\" value=\"Edit\">
                </form>
            </td>
        </tr>                
        {% endfor %}
    </table>
{% endblock content %}
", "admin/products_list.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\admin\\products_list.html.twig");
    }
}
