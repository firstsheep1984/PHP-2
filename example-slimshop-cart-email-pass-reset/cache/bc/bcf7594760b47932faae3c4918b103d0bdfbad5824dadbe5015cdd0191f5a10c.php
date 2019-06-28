<?php

/* email_passreset.html.twig */
class __TwigTemplate_d10e84e005347dd516df4097ab9ed343238b98369ea4373695c0f8a671f38e8d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo "<html>
    <body>
        <h1>Password reset request</h1>
        <p>Hi ";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo ",</p><br>
        <p>You have requested a password reset.</p>
        <p>Click on <a href=\"";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true);
        echo "\">this link</a> to reset your password
            or paste the following URL into a web brower.</p>
        <p>";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true);
        echo "</p>
    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "email_passreset.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  34 => 9,  29 => 7,  24 => 5,  19 => 2,);
    }

    public function getSource()
    {
        return "{# WARNING: this template is for an email, not an HTML page #}
<html>
    <body>
        <h1>Password reset request</h1>
        <p>Hi {{name}},</p><br>
        <p>You have requested a password reset.</p>
        <p>Click on <a href=\"{{url}}\">this link</a> to reset your password
            or paste the following URL into a web brower.</p>
        <p>{{url}}</p>
    </body>
</html>
";
    }
}
