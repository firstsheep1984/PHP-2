<?php

/* master.html.twig */
class __TwigTemplate_2151dd0571b66da6f637c7673221ef0bf7851831336f1855e607cce09651fe2e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'head' => array($this, 'block_head'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
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
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js\"></script>
        ";
        // line 7
        $this->displayBlock('head', $context, $blocks);
        // line 9
        echo "    </head>
    <body>
        <div id=\"centerContent\">
            <a href=\"/cart\">View cart</a>
            <div id=\"content\">";
        // line 13
        $this->displayBlock('content', $context, $blocks);
        echo "</div>
            <div id=\"footer\">                
                    &copy; Copyright 2016 by <a href=\"http://domain.invalid/\">you</a>.
            </div>
        </div>
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85730230-1', 'auto');
  ga('send', 'pageview');

        </script>
    </body>
</html>";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
    }

    // line 7
    public function block_head($context, array $blocks = array())
    {
        // line 8
        echo "        ";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "master.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  74 => 13,  70 => 8,  67 => 7,  62 => 5,  41 => 13,  35 => 9,  33 => 7,  28 => 5,  22 => 1,);
    }

    public function getSource()
    {
        return "<!DOCTYPE html>
<html>
    <head>
        <link rel=\"stylesheet\" href=\"/styles.css\" />
        <title>{% block title %}{% endblock %}</title>
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js\"></script>
        {% block head %}
        {% endblock %}
    </head>
    <body>
        <div id=\"centerContent\">
            <a href=\"/cart\">View cart</a>
            <div id=\"content\">{% block content %}{% endblock %}</div>
            <div id=\"footer\">                
                    &copy; Copyright 2016 by <a href=\"http://domain.invalid/\">you</a>.
            </div>
        </div>
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85730230-1', 'auto');
  ga('send', 'pageview');

        </script>
    </body>
</html>";
    }
}
