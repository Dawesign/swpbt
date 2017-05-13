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



/*
// replace relative uris to absolute uris
$mw_body = function($request, $response, $next) { 
    $response = $next($request, $response);


	$replacement = '="/swpbt/';
    if ( $_SERVER['HTTP_HOST'] =='trendiamo' ){	
		$replacement = '="/';
	}
	
    $body = $response->getBody();
    
    
    // TODO: ugly HACK for frontentdesign
	$body = str_replace('="../', $replacement  , $body );
    
    $newResp = new \Slim\Http\Body(''); 
    $newResp->write($body);
	
    return $response->withBody( $newResp );
    
};

$app->add( $mw_body );
*/


// catchall: '/[{path:.*}]'
$app->get('/', function($request, $response, $path = null) {
	
	return $this->view->render($response, 'main.htm', [] );
    
})->setName('start');




$app->get('/product/{id}', function($request, $response, $path = null) {
    
    return $this->view->render($response, 'product_'. $request->getAttribute('id') .'.htm', [] );
    
})->setName('productpage');







$app->get('/count/{id}', function($request, $response, $path = null) {
    
    
    
    if( empty($error) ){
		
		$id = $request->getAttribute('id');
		$id += 0;
		
		if( $id >= 0 && $id < 100 ){
			$filename = 'data/counter.txt';
			
			$fp = fopen( $filename.'.lock' ,'c+');
			flock( $fp, LOCK_EX );
				
				$filedata = file_get_contents($filename);
				$data = empty($filedata) ? array() : json_decode( $filedata );		
				$data[ $id ] = ($data[ $id ]+1);
				
				file_put_contents($filename, json_encode($data) );

			flock( $fp, LOCK_UN );
			
			/*
			 $this->get('cookies')->set('id_'.$id , [
				'value' => '1',
				'expires' => '28 days'
			]);
			*/
		
		}
		
	}
	
    return $response->write('bana');
});




$app->post('/subscribe', function($request, $response, $path = null) {
    
    
	$data = $app->request->post();
    
    $error = array();
    
    // validate
    if( !preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $data['mail'] ) ){
		$error['mail'] = 'fehlerhaft!';
	}
	
    // TODO: save
    if( empty($error) ){
		
		
		$filename = 'data/umfrage.txt';
		
		$filedata = file_get_contents($filename);
		$data = empty($filedata) ? array() : json_decode( $filedata );		
		file_put_contents($filename, json_encode($filename) );
		
		return $this->view->render($response, 'thanks.htm', [] );	
	
	}
    
    return $this->view->render($response, 'umfrage.htm', $error );
    
    
})->setName('subscribe');




// Run app
$app->run();



