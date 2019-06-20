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

/* admin/products_delete.html.twig */
class __TwigTemplate_56b182294957ee64074e5a2cecc61bfa287cd79c843e3ba75c5edc02f43364bd extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
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
        $this->parent = $this->loadTemplate("master.html.twig", "admin/products_delete.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "    <p>Are you sure you want to delete the following product?</p>
    <p>";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id", []), "html", null, true);
        echo ": ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "name", []), "html", null, true);
        echo " at ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "price", []), "html", null, true);
        echo "</p>
    <div>";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "description", []), "html", null, true);
        echo "</div>
    <br>
    <button style=\"margin-right: 20px\" onclick=\"window.location='/admin/products/list'\">Cancel</button>
    <form style=\"display:inline\" method=\"post\" action=\"/admin/products/delete/";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id", []), "html", null, true);
        echo "\">
        <input type=\"hidden\" name=\"confirmed\" value=\"true\">
        <input type=\"submit\" value=\"Delete forever\">
    </form>
";
    }

    public function getTemplateName()
    {
        return "admin/products_delete.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 9,  53 => 6,  45 => 5,  42 => 4,  39 => 3,  29 => 1,);
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

{% block content %}
    <p>Are you sure you want to delete the following product?</p>
    <p>{{item.id}}: {{item.name}} at {{item.price}}</p>
    <div>{{item.description}}</div>
    <br>
    <button style=\"margin-right: 20px\" onclick=\"window.location='/admin/products/list'\">Cancel</button>
    <form style=\"display:inline\" method=\"post\" action=\"/admin/products/delete/{{item.id}}\">
        <input type=\"hidden\" name=\"confirmed\" value=\"true\">
        <input type=\"submit\" value=\"Delete forever\">
    </form>
{% endblock %}
", "admin/products_delete.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\admin\\products_delete.html.twig");
    }
}
