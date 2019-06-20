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

/* login.html.twig */
class __TwigTemplate_95cc7a385968078320ce42ca371577f432c358a532a7ac4f1b550c564f6b453a extends \Twig\Template
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
        $this->parent = $this->loadTemplate("master.html.twig", "login.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "
    ";
        // line 5
        if ((isset($context["error"]) ? $context["error"] : null)) {
            // line 6
            echo "        <p>Invalid login credentials, try again or <a href=\"/register\">register</a></p>
    ";
        }
        // line 8
        echo "
    <form method=\"post\">
        Email: <input type=\"email\" name=\"email\"><br>
        Password: <input type=\"password\" name=\"password\"><br>
        <input type=\"submit\" value=\"Login\">
    </form>

";
    }

    public function getTemplateName()
    {
        return "login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 8,  47 => 6,  45 => 5,  42 => 4,  39 => 3,  29 => 1,);
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

    {% if error %}
        <p>Invalid login credentials, try again or <a href=\"/register\">register</a></p>
    {% endif %}

    <form method=\"post\">
        Email: <input type=\"email\" name=\"email\"><br>
        Password: <input type=\"password\" name=\"password\"><br>
        <input type=\"submit\" value=\"Login\">
    </form>

{% endblock content %}
", "login.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\login.html.twig");
    }
}
