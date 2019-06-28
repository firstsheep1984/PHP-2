<?php

/* index.html.twig */
class __TwigTemplate_1186c061694f516e7af4a7485c8b569594e72e19577623afcaa9a52c61375f47 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "index.html.twig", 1);
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
        echo "e-shop";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "
    <h1>Welcome to e-shop</h1>

    ";
        // line 9
        if ((isset($context["sessionUser"]) ? $context["sessionUser"] : null)) {
            // line 10
            echo "        <p>Hello ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["sessionUser"]) ? $context["sessionUser"] : null), "name", array()), "html", null, true);
            echo " (";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["sessionUser"]) ? $context["sessionUser"] : null), "email", array()), "html", null, true);
            echo ").
            You may <a href=\"/logout\">logout</a>.</p>
        ";
        } else {
            // line 13
            echo "        <p>You may <a href=\"/login\">login</a> or <a href=\"/register\">register</a>.</p>
    ";
        }
        // line 15
        echo "
    ";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["productList"]) ? $context["productList"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
            // line 17
            echo "        <hr>
        <div>
            <h3>";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "name", array()), "html", null, true);
            echo "</h3>
            <img height=100 src=\"/images/";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "imagePath", array()), "html", null, true);
            echo "\">
            <p>";
            // line 21
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "description", array()), "html", null, true);
            echo "</p>
            <p>Price per unit ";
            // line 22
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "price", array()), "html", null, true);
            echo "</p>
            <form method=\"POST\" action=\"/cart\">
                Add to cart
                <input type=\"hidden\" name=\"productID\" value=\"";
            // line 25
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "ID", array()), "html", null, true);
            echo "\">
                <input type=\"number\" name=\"quantity\" value=\"1\" style=\"width:30px;\">
                <input type=\"submit\" value=\"Add to cart\">
            </form>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "
";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  99 => 31,  87 => 25,  81 => 22,  77 => 21,  73 => 20,  69 => 19,  65 => 17,  61 => 16,  58 => 15,  54 => 13,  45 => 10,  43 => 9,  38 => 6,  35 => 5,  29 => 3,  11 => 1,);
    }

    public function getSource()
    {
        return "{% extends \"master.html.twig\" %}

{% block title %}e-shop{% endblock %}

{% block content %}

    <h1>Welcome to e-shop</h1>

    {% if sessionUser %}
        <p>Hello {{sessionUser.name}} ({{sessionUser.email}}).
            You may <a href=\"/logout\">logout</a>.</p>
        {% else %}
        <p>You may <a href=\"/login\">login</a> or <a href=\"/register\">register</a>.</p>
    {% endif %}

    {% for product in productList %}
        <hr>
        <div>
            <h3>{{product.name}}</h3>
            <img height=100 src=\"/images/{{ product.imagePath }}\">
            <p>{{product.description}}</p>
            <p>Price per unit {{product.price}}</p>
            <form method=\"POST\" action=\"/cart\">
                Add to cart
                <input type=\"hidden\" name=\"productID\" value=\"{{product.ID}}\">
                <input type=\"number\" name=\"quantity\" value=\"1\" style=\"width:30px;\">
                <input type=\"submit\" value=\"Add to cart\">
            </form>
        </div>
    {% endfor %}

{% endblock %}
";
    }
}
