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


/*
 
$app->add(function ($request, $response, $next) use ($c) {
    // First execute anything else
    $response = $next($request, $response);

    // Check if the response should render a 404
    if (404 === $response->getStatusCode() &&
        0   === $response->getBody()->getSize()
    ) {
        // A 404 should be invoked
        $handler = $c['notFoundHandler'];
        return $handler($request, $response);
    }

    // Any other request, pass on current response
    return $response;
});
*/


$app->get('/[{path:.*}]', function($request, $response, $path = null) {

    return $this->view->render($response, 'main.htm', [] );
    
})->setName('start');



// Run app
$app->run();





?>
