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

/* people_add.html.twig */
class __TwigTemplate_121bb775684f9906aaef5c3b8d0bdddeabbcc21dd8c09a7f2f333554cf73fd6c extends \Twig\Template
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
";
        // line 3
        if ((isset($context["errorList"]) ? $context["errorList"] : null)) {
            // line 4
            echo "    <ul>
        ";
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["errorList"]) ? $context["errorList"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 6
                echo "            <li>";
                echo twig_escape_filter($this->env, $context["error"], "html", null, true);
                echo "</li>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 8
            echo "    </ul>
";
        }
        // line 10
        echo "
<form method=\"post\">
    Name: <input type=\"text\" name=\"name\" value=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["v"]) ? $context["v"] : null), "name", []), "html", null, true);
        echo "\"><br>
    Age: <input type=\"number\" name=\"age\" value=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["v"]) ? $context["v"] : null), "age", []), "html", null, true);
        echo "\"><br>
    <input type=\"submit\" value=\"Add person\">
</form>

";
    }

    public function getTemplateName()
    {
        return "people_add.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 13,  59 => 12,  55 => 10,  51 => 8,  42 => 6,  38 => 5,  35 => 4,  33 => 3,  30 => 2,);
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

{% if errorList %}
    <ul>
        {% for error in errorList %}
            <li>{{error}}</li>
        {% endfor %}
    </ul>
{% endif %}

<form method=\"post\">
    Name: <input type=\"text\" name=\"name\" value=\"{{v.name}}\"><br>
    Age: <input type=\"number\" name=\"age\" value=\"{{v.age}}\"><br>
    <input type=\"submit\" value=\"Add person\">
</form>

", "people_add.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimfirst\\templates\\people_add.html.twig");
    }
}
