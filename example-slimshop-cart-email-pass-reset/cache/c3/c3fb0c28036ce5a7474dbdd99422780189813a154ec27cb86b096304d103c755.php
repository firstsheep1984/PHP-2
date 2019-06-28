<?php

/* passreset_success.html.twig */
class __TwigTemplate_ef5804922e0a648b5236d553fdf9f296fab1f487a7ea3d1f71bc71779fbc0e03 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "passreset_success.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
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
        echo "Password reset";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "    <h1>Password reset - email sent</h1>

    <p>Email with password reset code has been sent.
        Please allow the email a few minutes to arrive.
        <a href=\"/\">Click here to continue</a></p>

";
    }

    public function getTemplateName()
    {
        return "passreset_success.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  35 => 5,  29 => 3,  11 => 1,);
    }

    public function getSource()
    {
        return "{% extends \"master.html.twig\" %}

{% block title %}Password reset{% endblock %}

{% block content %}
    <h1>Password reset - email sent</h1>

    <p>Email with password reset code has been sent.
        Please allow the email a few minutes to arrive.
        <a href=\"/\">Click here to continue</a></p>

{% endblock %}
";
    }
}
