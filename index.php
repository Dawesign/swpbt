<?php


require 'vendor/autoload.php';


// Create app
$app = new \Slim\App();

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('tpl', [
        'cache' => 'cache'
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/swpbt');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};



// catchall: '/[{path:.*}]' 

$app->get('/', function($request, $response, $path = null) {

    return $this->view->render($response, 'main.htm', [] );
    
})->setName('start');



$app->get('/product', function($request, $response, $path = null) {

    return $this->view->render($response, 'product.htm', [] );
    
})->setName('productpage');



// Run app
$app->run();





?>
