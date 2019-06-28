<?php

/* passreset_notfound_expired.html.twig */
class __TwigTemplate_fe45d82f6e23792bd1aefedace05c7e0d74619341eac55efbfa1ee9f9a823596 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "passreset_notfound_expired.html.twig", 1);
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
        echo "Failed reset";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "    
<h1>Failed reset</h1>

<p>Password reset token does not exist or has expired.</p>
<p>You may <a href=\"/passreset\">request a new token</a>.</p>

<a href=\"/\">Click to continue</a>

";
    }

    public function getTemplateName()
    {
        return "passreset_notfound_expired.html.twig";
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

{% block title %}Failed reset{% endblock %}

{% block content %}
    
<h1>Failed reset</h1>

<p>Password reset token does not exist or has expired.</p>
<p>You may <a href=\"/passreset\">request a new token</a>.</p>

<a href=\"/\">Click to continue</a>

{% endblock %}
";
    }
}
