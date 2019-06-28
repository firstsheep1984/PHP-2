<?php

/* register_success.html.twig */
class __TwigTemplate_18687eec28003c7f6cda6070cb00a9b92b5def7dd00dbe961a443c58cec5eb55 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "register_success.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'head' => array($this, 'block_head'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "master.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Successful registration";
    }

    // line 5
    public function block_head($context, array $blocks = array())
    {
        // line 6
        echo "    <meta http-equiv=\"refresh\" content=\"5;url=/login\" />
    <!-- 
    <script>
        \$(document).ready(function () {
            window.setTimeout(function () {
                location.href = \"/login\";
            }, 5000);
        });
    </script> -->
";
    }

    // line 17
    public function block_content($context, array $blocks = array())
    {
        // line 18
        echo "    <h1>Registration successful</h1>
    <a href=\"/login\">Click to login</a> or you will be redirected in 5 seconds.
";
    }

    public function getTemplateName()
    {
        return "register_success.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 18,  52 => 17,  39 => 6,  36 => 5,  30 => 3,  11 => 1,);
    }

    public function getSource()
    {
        return "{% extends \"master.html.twig\" %}

{% block title %}Successful registration{% endblock %}

{% block head %}
    <meta http-equiv=\"refresh\" content=\"5;url=/login\" />
    <!-- 
    <script>
        \$(document).ready(function () {
            window.setTimeout(function () {
                location.href = \"/login\";
            }, 5000);
        });
    </script> -->
{% endblock %}

{% block content %}
    <h1>Registration successful</h1>
    <a href=\"/login\">Click to login</a> or you will be redirected in 5 seconds.
{% endblock %}
";
    }
}
