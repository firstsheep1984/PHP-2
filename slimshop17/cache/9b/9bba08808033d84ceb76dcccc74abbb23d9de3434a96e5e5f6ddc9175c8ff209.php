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

/* admin/products_addedit_success.html.twig */
class __TwigTemplate_07cba03d3c423f4ddfc5c10e7a12af492d1849eca01024e3d393e44a7e617901 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("master.html.twig", "admin/products_addedit_success.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "    <p>Product ";
        if ((isset($context["savedId"]) ? $context["savedId"] : null)) {
            echo "saved";
        } else {
            echo "added";
        }
        echo " successfully,
        <a href=\"/admin/products/list\">click to continue</a></p>
";
    }

    public function getTemplateName()
    {
        return "admin/products_addedit_success.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 4,  39 => 3,  29 => 1,);
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
    <p>Product {% if savedId %}saved{% else %}added{% endif %} successfully,
        <a href=\"/admin/products/list\">click to continue</a></p>
{% endblock %}
", "admin/products_addedit_success.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\admin\\products_addedit_success.html.twig");
    }
}
