<?php

/* order.html.twig */
class __TwigTemplate_00913d1e8adf079262af0d9c395d8da9dbebdc1171de8b22ad8d1eec30b5116f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "order.html.twig", 1);
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
        echo "Placing order";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "    <p>Total value before tax is ";
        echo twig_escape_filter($this->env, (isset($context["totalBeforeTax"]) ? $context["totalBeforeTax"] : null), "html", null, true);
        echo ".</p>
    <p>Shipping before tax is ";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["shippingBeforeTax"]) ? $context["shippingBeforeTax"] : null), "html", null, true);
        echo ".</p>
    <p>Taxes (GST/QST/HST) ";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["taxes"]) ? $context["taxes"] : null), "html", null, true);
        echo ". </p>
    <p>Final total with shipping and taxes (amount to be paid):
        <b>";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["totalWithShippingAndTaxes"]) ? $context["totalWithShippingAndTaxes"] : null), "html", null, true);
        echo "</b>.</p>
    <form method=\"POST\">
        Name: <input type=\"text\" name=\"name\" value=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["sessionUser"]) ? $context["sessionUser"] : null), "name", array()), "html", null, true);
        echo "\"><br>
        Address: <input type=\"text\" name=\"address\"><br>
        Postal code: <input type=\"text\" name=\"postalCode\"><br>
        Email: <input type=\"email\" name=\"email\" value=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["sessionUser"]) ? $context["sessionUser"] : null), "email", array()), "html", null, true);
        echo "\"><br>
        Phone number: <input type=\"text\" name=\"phoneNumber\"><br>
        <p><u>TODO: payment information</u></p>
        <input type=\"submit\" value=\"Place order\">
    </form>
";
    }

    public function getTemplateName()
    {
        return "order.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 15,  57 => 12,  52 => 10,  47 => 8,  43 => 7,  38 => 6,  35 => 5,  29 => 3,  11 => 1,);
    }

    public function getSource()
    {
        return "{% extends \"master.html.twig\" %}

{% block title %}Placing order{% endblock %}

{% block content %}
    <p>Total value before tax is {{ totalBeforeTax }}.</p>
    <p>Shipping before tax is {{ shippingBeforeTax }}.</p>
    <p>Taxes (GST/QST/HST) {{ taxes }}. </p>
    <p>Final total with shipping and taxes (amount to be paid):
        <b>{{ totalWithShippingAndTaxes }}</b>.</p>
    <form method=\"POST\">
        Name: <input type=\"text\" name=\"name\" value=\"{{sessionUser.name}}\"><br>
        Address: <input type=\"text\" name=\"address\"><br>
        Postal code: <input type=\"text\" name=\"postalCode\"><br>
        Email: <input type=\"email\" name=\"email\" value=\"{{sessionUser.email}}\"><br>
        Phone number: <input type=\"text\" name=\"phoneNumber\"><br>
        <p><u>TODO: payment information</u></p>
        <input type=\"submit\" value=\"Place order\">
    </form>
{% endblock %}";
    }
}
