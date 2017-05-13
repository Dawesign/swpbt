<?php

/* header.htm */
class __TwigTemplate_cb622b7fe36527e75662638b05e585465f8097c37c02cbdac4013e01b89b59da extends Twig_Template
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
        echo "<!DOCTYPE html>
<html lang=\"de\">
<head>
    <meta charset=\"UTF-8\">
    <title>Trendiamo</title>
    <script src=\"https://code.jquery.com/jquery-3.1.1.min.js\" integrity=\"sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=\" crossorigin=\"anonymous\"></script>
    <script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>
    <script src=\"https://cdn.jsdelivr.net/semantic-ui/2.2.7/semantic.min.js\"></script>
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/semantic-ui/2.2.7/semantic.min.css\" />
    <link rel=\"stylesheet\" href=\"http://fontawesome.io/assets/font-awesome/css/font-awesome.css\" />
    <link rel=\"stylesheet\" href=\"../css/main.css\">
    <meta name=\"viewport\" content=\"width=device-width\"/>
</head>
<body>
<div class=\"header\">
    <div class=\"logo_wrapper\">
        <img class=\"logo_img\" src=\"../src/trendiamo_logo.png\">
    </div>
    <div class=\"header_nav\">
        <div class=\"btn_menu\">
            ALLE
        </div>
        <div class=\"btn_menu\">
            TOP
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "header.htm";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "header.htm", "/Applications/MAMP/htdocs/swpbt/tpl/header.htm");
    }
}
