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

/* internal_error.html.twig */
class __TwigTemplate_24a94e94d01261b509d9d13c66403649e18babe45eaa0902a16882be1fd0fc42 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("master.html.twig", "internal_error.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        echo "Problem";
    }

    // line 5
    public function block_content($context, array $blocks = [])
    {
        // line 6
        echo "    <h3>Internal error</h3>    
    <p>We've encountered an error. Our team of coding ninjas is already working
        on it. We apologize for the inconvenience.
        Please <a href=\"/\">click to continue</a></p>    
    <img src=\"/images/ninja.png\" width=\"200\">
";
    }

    public function getTemplateName()
    {
        return "internal_error.html.twig";
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

{% block title %}Problem{% endblock %}

{% block content %}
    <h3>Internal error</h3>    
    <p>We've encountered an error. Our team of coding ninjas is already working
        on it. We apologize for the inconvenience.
        Please <a href=\"/\">click to continue</a></p>    
    <img src=\"/images/ninja.png\" width=\"200\">
{% endblock content %}
", "internal_error.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\internal_error.html.twig");
    }
}
