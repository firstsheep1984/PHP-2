<?php

/* register.html.twig */
class __TwigTemplate_6dcbfbef8680eb5749561f2918a57e1454486c76e390c1099c3f8ad5c10dc67f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "register.html.twig", 1);
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
        echo "Register user";
    }

    // line 5
    public function block_head($context, array $blocks = array())
    {
        // line 6
        echo "    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
    <script>
        
        function checkEmail() {
            var email = \$('input[name=email]').val();
            if (email != '') {
                //\$('#result').load('/emailexists/' + email);
                \$.ajax({
                    url: '/emailexists/' + email
                }).done(function (data) {
                    \$(\"#result\").html(data);
                });                
            } else {
                \$('#result').html(\"\");
            }
        }
        
        \$(document).ready(function() {
            \$('input[name=email]').keyup(function() {
                checkEmail();
            });
            \$('input[name=email]').bind('paste', function() {
                checkEmail();
            });
        });
    </script>
";
    }

    // line 35
    public function block_content($context, array $blocks = array())
    {
        // line 36
        echo "            
<h1>Register user</h1>

";
        // line 39
        if ((isset($context["errorList"]) ? $context["errorList"] : null)) {
            // line 40
            echo "    <ul>
    ";
            // line 41
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["errorList"]) ? $context["errorList"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 42
                echo "        <li>";
                echo twig_escape_filter($this->env, $context["error"], "html", null, true);
                echo "</li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 44
            echo "    </ul>
";
        }
        // line 46
        echo "
<form method=\"post\">
    Name: <input type=\"text\" name=\"name\" value=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["v"]) ? $context["v"] : null), "name", array()), "html", null, true);
        echo "\"><br>
    Email: <input type=\"text\" name=\"email\" value=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["v"]) ? $context["v"] : null), "email", array()), "html", null, true);
        echo "\">
            <span id=\"result\"></span><br>
    Password: <input type=\"password\" name=\"pass1\"><br>
    Password (repeated) <input type=\"password\" name=\"pass2\"><br>
    <input type=\"submit\" value=\"Register\">
</form>

";
    }

    public function getTemplateName()
    {
        return "register.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 49,  103 => 48,  99 => 46,  95 => 44,  86 => 42,  82 => 41,  79 => 40,  77 => 39,  72 => 36,  69 => 35,  39 => 6,  36 => 5,  30 => 3,  11 => 1,);
    }

    public function getSource()
    {
        return "{% extends \"master.html.twig\" %}

{% block title %}Register user{% endblock %}

{% block head %}
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
    <script>
        
        function checkEmail() {
            var email = \$('input[name=email]').val();
            if (email != '') {
                //\$('#result').load('/emailexists/' + email);
                \$.ajax({
                    url: '/emailexists/' + email
                }).done(function (data) {
                    \$(\"#result\").html(data);
                });                
            } else {
                \$('#result').html(\"\");
            }
        }
        
        \$(document).ready(function() {
            \$('input[name=email]').keyup(function() {
                checkEmail();
            });
            \$('input[name=email]').bind('paste', function() {
                checkEmail();
            });
        });
    </script>
{% endblock %}


{% block content %}
            
<h1>Register user</h1>

{% if errorList %}
    <ul>
    {% for error in errorList %}
        <li>{{ error }}</li>
    {% endfor %}
    </ul>
{% endif %}

<form method=\"post\">
    Name: <input type=\"text\" name=\"name\" value=\"{{v.name}}\"><br>
    Email: <input type=\"text\" name=\"email\" value=\"{{v.email}}\">
            <span id=\"result\"></span><br>
    Password: <input type=\"password\" name=\"pass1\"><br>
    Password (repeated) <input type=\"password\" name=\"pass2\"><br>
    <input type=\"submit\" value=\"Register\">
</form>

{% endblock %}
    ";
    }
}
