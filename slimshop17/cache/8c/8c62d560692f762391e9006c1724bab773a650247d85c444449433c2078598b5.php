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

/* ajax_products_page.html.twig */
class __TwigTemplate_61d0d4bd2def1147d4a50772077529ff1fdf4b231e226591de92781c03cff7b2 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["itemsList"]) ? $context["itemsList"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 2
            echo "    <div class=\"productBox\">
        <a href=\"/products/";
            // line 3
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "id", []), "html", null, true);
            echo "\"><h3>";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "name", []), "html", null, true);
            echo "</h3></a>
        <p>Price ";
            // line 4
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "price", []), "html", null, true);
            echo " </p>
        <div class=\"description\">";
            // line 5
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "description", []), "html", null, true);
            echo "</div>
        <img src=\"/";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "imagePath", []), "html", null, true);
            echo "\" width=\"200\">        
    </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "ajax_products_page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 6,  47 => 5,  43 => 4,  37 => 3,  34 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% for item in itemsList %}
    <div class=\"productBox\">
        <a href=\"/products/{{item.id}}\"><h3>{{item.name}}</h3></a>
        <p>Price {{item.price }} </p>
        <div class=\"description\">{{item.description}}</div>
        <img src=\"/{{item.imagePath}}\" width=\"200\">        
    </div>
{% endfor %}
", "ajax_products_page.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\ajax_products_page.html.twig");
    }
}
