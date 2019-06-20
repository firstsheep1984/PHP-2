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

/* admin/products_addedit.html.twig */
class __TwigTemplate_cc80d80ad3081f22c12f71305f67a1394357a38817590b6822dd31e454c941c8 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("master.html.twig", "admin/products_addedit.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "
    ";
        // line 5
        if ((isset($context["errorList"]) ? $context["errorList"] : null)) {
            // line 6
            echo "        <ul>
            ";
            // line 7
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["errorList"]) ? $context["errorList"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 8
                echo "                <li>";
                echo twig_escape_filter($this->env, $context["error"], "html", null, true);
                echo "</li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 10
            echo "        </ul>
    ";
        }
        // line 12
        echo "
    <form method=\"post\">
        Name: <input type=\"text\" name=\"name\" value=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["v"]) ? $context["v"] : null), "name", []), "html", null, true);
        echo "\"><br>
        Description: <textarea name=\"description\">";
        // line 15
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["v"]) ? $context["v"] : null), "description", []), "html", null, true);
        echo "</textarea><br>
        Price <input type=\"number\" step=\"0.01\" name=\"price\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["v"]) ? $context["v"] : null), "price", []), "html", null, true);
        echo "\"><br>
        <p>TODO: image upload</p>
        <input type=\"submit\" value=\"";
        // line 18
        if ($this->getAttribute((isset($context["v"]) ? $context["v"] : null), "id", [])) {
            echo "Save";
        } else {
            echo "Add";
        }
        echo " product\">
    </form>

";
    }

    public function getTemplateName()
    {
        return "admin/products_addedit.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 18,  79 => 16,  75 => 15,  71 => 14,  67 => 12,  63 => 10,  54 => 8,  50 => 7,  47 => 6,  45 => 5,  42 => 4,  39 => 3,  29 => 1,);
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

    {% if errorList %}
        <ul>
            {% for error in errorList %}
                <li>{{error}}</li>
            {% endfor %}
        </ul>
    {% endif %}

    <form method=\"post\">
        Name: <input type=\"text\" name=\"name\" value=\"{{v.name}}\"><br>
        Description: <textarea name=\"description\">{{v.description}}</textarea><br>
        Price <input type=\"number\" step=\"0.01\" name=\"price\" value=\"{{v.price}}\"><br>
        <p>TODO: image upload</p>
        <input type=\"submit\" value=\"{% if v.id %}Save{% else %}Add{% endif %} product\">
    </form>

{% endblock content %}
", "admin/products_addedit.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\admin\\products_addedit.html.twig");
    }
}
