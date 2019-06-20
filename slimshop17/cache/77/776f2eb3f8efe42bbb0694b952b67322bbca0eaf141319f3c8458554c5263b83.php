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

/* master.html.twig */
class __TwigTemplate_b25f657bebba3ce9a1e09940df558670128dce631c67ab7394b7edabd4b6aced extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'headAdd' => [$this, 'block_headAdd'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <link rel=\"stylesheet\" href=\"/styles.css\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
        ";
        // line 7
        $this->displayBlock('headAdd', $context, $blocks);
        // line 8
        echo "    </head>
    <body>
        <div id=\"centerContent\">";
        // line 10
        $this->displayBlock('content', $context, $blocks);
        // line 11
        echo "            <div id=\"footer\"><br>
                &copy; Copyright 2019 by me.
        </div>
        </div>
    </body>
</html>";
    }

    // line 5
    public function block_title($context, array $blocks = [])
    {
    }

    // line 7
    public function block_headAdd($context, array $blocks = [])
    {
    }

    // line 10
    public function block_content($context, array $blocks = [])
    {
    }

    public function getTemplateName()
    {
        return "master.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  71 => 10,  66 => 7,  61 => 5,  52 => 11,  50 => 10,  46 => 8,  44 => 7,  39 => 5,  33 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>
    <head>
        <link rel=\"stylesheet\" href=\"/styles.css\" />
        <title>{% block title %}{% endblock %}</title>
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
        {% block headAdd %}{% endblock %}
    </head>
    <body>
        <div id=\"centerContent\">{% block content %}{% endblock %}
            <div id=\"footer\"><br>
                &copy; Copyright 2019 by me.
        </div>
        </div>
    </body>
</html>", "master.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimshop17\\templates\\master.html.twig");
    }
}
