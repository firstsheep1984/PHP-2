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

/* hello.html.twig */
class __TwigTemplate_f244cd13d15612347897ba5964ed833cd862ee362d8e5d4d679b9c19aaecbcb6 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 2
        echo "
<p>Hello from Twig, you are ";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["nameQQQ"]) ? $context["nameQQQ"] : null), "html", null, true);
        echo " and
    you've been around for ";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["ageQQQ"]) ? $context["ageQQQ"] : null), "html", null, true);
        echo " years.</p>

";
    }

    public function getTemplateName()
    {
        return "hello.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  37 => 4,  33 => 3,  30 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{# empty Twig template #}

<p>Hello from Twig, you are {{nameQQQ}} and
    you've been around for {{ageQQQ}} years.</p>

", "hello.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimfirst\\templates\\hello.html.twig");
    }
}
