<?php

/* cart.html.twig */
class __TwigTemplate_4c7e2ac78e570059a522cd91b2fea5965b90127e35c47f4c9878101ab3351c3a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "cart.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
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
    public function block_head($context, array $blocks = array())
    {
        // line 4
        echo "    <script>
        function increment(ID) {
            var value = \$(\"input[name=quantity\" + ID + \"]\").val();
            value++;
            \$(\"input[name=quantity\" + ID + \"]\").val(value);
            \$(\"#update\" + ID).show();
        }
        function decrement(ID) {
            var value = \$(\"input[name=quantity\" + ID + \"]\").val();
            if (value > 0) {
                value--;
            }
            \$(\"input[name=quantity\" + ID + \"]\").val(value);
            \$(\"#update\" + ID).show();
        }
        function update(e,ID) {
            e.preventDefault();
            var quantity = \$(\"input[name=quantity\" + ID + \"]\").val();
            \$.get(\"/cart/update/\" + ID + \"/\" + quantity, function() {
                console.log(\"quantity updated\");
                \$(\"#update\" + ID).hide();
            });
            if (quantity == 0) {
                \$(\"#itemrow\" + ID).hide();
            }
        }
        \$(document).ready(function () {
            \$(\".updateLink\").hide();
        });
    </script>
";
    }

    // line 36
    public function block_title($context, array $blocks = array())
    {
        echo "Cart";
    }

    // line 38
    public function block_content($context, array $blocks = array())
    {
        // line 39
        echo "    <table border=\"1\">
        ";
        // line 40
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["cartitemList"]) ? $context["cartitemList"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["ci"]) {
            // line 41
            echo "            <tr id=\"itemrow";
            echo twig_escape_filter($this->env, $this->getAttribute($context["ci"], "ID", array()), "html", null, true);
            echo "\">
                <td>";
            // line 42
            echo twig_escape_filter($this->env, $this->getAttribute($context["ci"], "name", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 43
            echo twig_escape_filter($this->env, $this->getAttribute($context["ci"], "price", array()), "html", null, true);
            echo "</td>
                <td><button onclick=\"decrement(";
            // line 44
            echo twig_escape_filter($this->env, $this->getAttribute($context["ci"], "ID", array()), "html", null, true);
            echo ")\">-</button>
                    <input type=\"number\" name=\"quantity";
            // line 45
            echo twig_escape_filter($this->env, $this->getAttribute($context["ci"], "ID", array()), "html", null, true);
            echo "\"
                           value=\"";
            // line 46
            echo twig_escape_filter($this->env, $this->getAttribute($context["ci"], "quantity", array()), "html", null, true);
            echo "\" style=\"width:30px;\">
                    <button onclick=\"increment(";
            // line 47
            echo twig_escape_filter($this->env, $this->getAttribute($context["ci"], "ID", array()), "html", null, true);
            echo ")\">+</button>
                    <a href=\"\" class=\"updateLink\" id=\"update";
            // line 48
            echo twig_escape_filter($this->env, $this->getAttribute($context["ci"], "ID", array()), "html", null, true);
            echo "\"
                          onclick=\"update(event,";
            // line 49
            echo twig_escape_filter($this->env, $this->getAttribute($context["ci"], "ID", array()), "html", null, true);
            echo ")\">update</a>
                </td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ci'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 53
        echo "    </table>
 
   <a href=\"/order\">Place order</a>
        
        
";
    }

    public function getTemplateName()
    {
        return "cart.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  126 => 53,  116 => 49,  112 => 48,  108 => 47,  104 => 46,  100 => 45,  96 => 44,  92 => 43,  88 => 42,  83 => 41,  79 => 40,  76 => 39,  73 => 38,  67 => 36,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSource()
    {
        return "{% extends \"master.html.twig\" %}

{% block head %}
    <script>
        function increment(ID) {
            var value = \$(\"input[name=quantity\" + ID + \"]\").val();
            value++;
            \$(\"input[name=quantity\" + ID + \"]\").val(value);
            \$(\"#update\" + ID).show();
        }
        function decrement(ID) {
            var value = \$(\"input[name=quantity\" + ID + \"]\").val();
            if (value > 0) {
                value--;
            }
            \$(\"input[name=quantity\" + ID + \"]\").val(value);
            \$(\"#update\" + ID).show();
        }
        function update(e,ID) {
            e.preventDefault();
            var quantity = \$(\"input[name=quantity\" + ID + \"]\").val();
            \$.get(\"/cart/update/\" + ID + \"/\" + quantity, function() {
                console.log(\"quantity updated\");
                \$(\"#update\" + ID).hide();
            });
            if (quantity == 0) {
                \$(\"#itemrow\" + ID).hide();
            }
        }
        \$(document).ready(function () {
            \$(\".updateLink\").hide();
        });
    </script>
{% endblock %}

{% block title %}Cart{% endblock %}

{% block content %}
    <table border=\"1\">
        {% for ci in cartitemList %}
            <tr id=\"itemrow{{ci.ID}}\">
                <td>{{ci.name}}</td>
                <td>{{ci.price}}</td>
                <td><button onclick=\"decrement({{ci.ID}})\">-</button>
                    <input type=\"number\" name=\"quantity{{ci.ID}}\"
                           value=\"{{ci.quantity}}\" style=\"width:30px;\">
                    <button onclick=\"increment({{ci.ID}})\">+</button>
                    <a href=\"\" class=\"updateLink\" id=\"update{{ci.ID}}\"
                          onclick=\"update(event,{{ci.ID}})\">update</a>
                </td>
            </tr>
        {% endfor %}
    </table>
 
   <a href=\"/order\">Place order</a>
        
        
{% endblock %}";
    }
}
