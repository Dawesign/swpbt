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
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], substr($_SERVER['HTTP_HOST'],0,9) == 'localhost' ? '/swpbt' :'' ));
	
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



$app->get('/impressum', function($request, $response, $path = null) {
	
	return $this->view->render($response, 'impressum.htm', [] );
    
})->setName('impressum');






$app->get('/product/{id}', function($request, $response, $path = null) {
    
    $id = $request->getAttribute('id');
    
    $filename = 'data/counter.txt';
    
    
    $fp = fopen( $filename.'.lock' ,'c+');
	flock( $fp, LOCK_SH );
    fclose($fp);
    
    $filedata = file_get_contents($filename);
	$data = empty($filedata) ? array() : unserialize( $filedata );		
	
	
	$votes = 0;
	if( is_array($data) ){
		$votes = (int) @$data[  $id ];
	}
	
    
    return $this->view->render($response, 'product_'. $id .'.htm', ['vote_number'=> $votes,
								'BACKBUTTON'=> '<a href="'. $request->getUri()->getBasePath() .'/"><i class="fa fa-arrow-left"></i> Zurück</a>'] );
    
})->setName('productpage');







$app->get('/count/{id}', function($request, $response, $path = null) {
    
        
	$id = $request->getAttribute('id');
	$id = (int) $id;
	
	$data = array();
	if( $id >= 0 && $id < 100 ){
		$filename = 'data/counter.txt';
		
		$fp = fopen( $filename.'.lock' ,'c+');
		flock( $fp, LOCK_EX );
			
			$file = file_get_contents($filename);
		
			
			$data = empty($file) ? array() : unserialize( $file );		
			
			if( ! is_array($data) ){
				$data = array();
			}
			
			if( isset($data[$id] )){
				
				$data[ $id ] = ((int) $data[ $id ])+1;
		
			}else{
				
				$data[ $id ] = 1;
		
			}
			
			file_put_contents( $filename, serialize($data) );

		flock( $fp, LOCK_UN );
		fclose($fp);
		
		/*
		 $this->get('cookies')->set('id_'.$id , [
			'value' => '1',
			'expires' => '28 days'
		]);
		*/
	
	}

    return $response->write('bana '. implode('  ', $data) );
});




$app->post('/subscribe', function($request, $response, $path = null) {
    
    
	$data = $request->getParsedBody();
    
    $error = array();
    
    // validate
    
    if( !isset($data['agb']) ){
		$error['agb'] = 'haken?';
	}
    
    if( strlen(@$data['mail']) > 3 ){
		if( !preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $data['mail'] ) ){
			$error['mail_err'] = 'fehlerhaft!';
		}
	}else{
		$error['mail_err'] = 'erforderlich.';
	}
	
    //  save
    if( empty($error) ){
		
		
		$filename = 'data/umfrage.txt';
		
		$fp = fopen( $filename.'.lock' ,'c+');
		flock( $fp, LOCK_EX );
				
			$filedata = file_get_contents($filename);
			$jsondata = empty($filedata) ? array() : json_decode( $filedata );
			
			if( !is_array($jsondata) ){
				$jsondata = array();
			}
			
			array_push($jsondata, $data);
			
			file_put_contents($filename, json_encode( $jsondata ) );
		
		
		flock( $fp, LOCK_UN );
		fclose($fp);
		
		return $this->view->render($response, 'thanks.htm', [] );	
	
	}
    
    return $this->view->render($response, 'umfragepage.htm', array_merge($data , $error) );
    
    
})->setName('subscribe');




// Run app
$app->run();



