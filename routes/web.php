<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

	
$router->get('/version', function () {
	return "api test V1 (Lemz)";
});

$router->group(['prefix' => 'usermain'], function() use ($router) {
	$router->post('login','AuthenticationController@login');
});

$router->get('/', function () {
	return view('main');
});

$router->group(['prefix' => 'user', 'middleware' => 'auth' ], function() use ($router){	

});

$router->group(['prefix' => 'galileo'], function() use ($router) {		
	$router->post('pathmap','GalileoController@galileo_pathmap');
});


$router->group(['prefix' => 'test'], function() use ($router) {		
	$router->get('test', function () {
		return "api test V1 (Lemz)";
	});
	$router->post('pathmap','GalileoController@post_test');
});




