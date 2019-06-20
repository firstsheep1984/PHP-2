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

/* forbidden.html.twig */
class __TwigTemplate_28f6288d8e230c5dec9ca5f2efbf722c2dcdc98791558748d4d7ba0a2b1243ef extends \Twig\Template
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
        $this->parent = $this->loadTemplate("master.html.twig", "forbidden.html.twig", 1);
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
        echo "    <p>Access denied, <a href=\"/\">click to continue</a></p>    
";
    }

    public function getTemplateName()
    {
        return "forbidden.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 6,  46 => 5,  40 => 3,  30 => 1,);
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
    <p>Access denied, <a href=\"/\">click to continue</a></p>    
{% endblock content %}
", "forbidden.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\forbidden.html.twig");
    }
}
