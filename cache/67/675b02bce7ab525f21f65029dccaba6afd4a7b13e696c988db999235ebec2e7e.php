<?php

/* main.htm */
class __TwigTemplate_62b4c3c4889843fafb45a382102f7db012390fae6b7aabcc25c94d9ccefe4a8d extends Twig_Template
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
        // line 1
        $this->loadTemplate("header.htm", "main.htm", 1)->display($context);
        // line 2
        echo "
Kachel <br><br><br>
Kachel <br><br><br>
Kachel <br><br><br>
Kachel <br><br><br>
Kachel <br><br><br>
Kachel <br><br><br>
Kachel <br><br><br>
Kachel <br><br><br>

";
        // line 12
        $this->loadTemplate("footer.htm", "main.htm", 12)->display($context);
    }

    public function getTemplateName()
    {
        return "main.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  33 => 12,  21 => 2,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "main.htm", "/Applications/MAMP/htdocs/swpbt/tpl/main.htm");
    }
}
