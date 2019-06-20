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

/* people_add_success.html.twig */
class __TwigTemplate_f12e1e23c6d833c1dd79c05a096590fe7e46bfdd02d860792f071c2b967347b7 extends \Twig\Template
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
<p>Person added successfully</p>
";
    }

    public function getTemplateName()
    {
        return "people_add_success.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  30 => 2,);
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

<p>Person added successfully</p>
", "people_add_success.html.twig", "C:\\xampp\\htdocs\\ipd17\\slimfirst\\templates\\people_add_success.html.twig");
    }
}
