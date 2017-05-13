<?php


require 'vendor/autoload.php';


// Create app
$app = new \Slim\App();

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('tpl', [
       //  'cache' => 'cache'
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/swpbt');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};



// replace relative uris to absolute uris
$mw_body = function($request, $response, $next) { 
    $response = $next($request, $response);


    if ( !$_SERVER['HTTP_HOST'] =='trendiamo' ){
		
		$replacement = '="/';
	
	}else{
		
		$replacement = '="/swpbt/';
	
	}
	
    $body = $response->getBody();
    
    
    // TODO: ugly HACK for frontentdesign
	$body = str_replace('="../', $replacement  , $body );
    
    $body .= '<!-- hostname: '. $_SERVER['HTTP_HOST'] . ' -->';
    
    $newResp = new \Slim\Http\Response(); 
    $newResp->write($body);

    return $newResp; 
};

$app->add( $mw_body );


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
