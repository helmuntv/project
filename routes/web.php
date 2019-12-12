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

	$router->get('/posts', ['uses' => 'PostController@index']);
	$router->post('/posts', ['uses' => 'PostController@store']);
	$router->get('/posts/{id}', ['uses' => 'PostController@show']);
	$router->put('/posts/{id}', ['uses' => 'PostController@update']);
	$router->delete('/posts/{id}', ['uses' => 'PostController@destroy']);

$router->get('/', function () use ($router) {
	return $router->app->version();
});

$router->get('/key', function () {
	return str_random(32);
});

$router->group(['middleware' => ['auth']], function () use ($router) {
	/*
	* Users routes
	*/
	$router->get('/users', ['uses' => 'UserController@index']);
	$router->post('/users', ['uses' => 'UserController@store']);
	$router->get('/users/{id}', ['uses' => 'UserController@show']);
	$router->put('/users/{id}', ['uses' => 'UserController@update']);
	$router->delete('/users/{id}', ['uses' => 'UserController@destroy']);

	/*
	* Routes for authors
	*/
	$router->get('/authors', ['uses' => 'AuthorController@index']);
	$router->post('/authors', ['uses' => 'AuthorController@store']);
	$router->get('/authors/{id}', ['uses' => 'AuthorController@show']);
	$router->put('/authors/{id}', ['uses' => 'AuthorController@update']);
	$router->patch('/authors/{id}', ['uses' => 'AuthorController@update']);
	$router->delete('/authors/{id}', ['uses' => 'AuthorController@destroy']);

	/*
	* Routes for books
	*/
	$router->get('/books', ['uses' => 'BookController@index']);
	$router->post('/books', ['uses' => 'BookController@store']);
	$router->get('/books/{id}', ['uses' => 'BookController@show']);
	$router->put('/books/{id}', ['uses' => 'BookController@update']);
	$router->patch('/books/{id}', ['uses' => 'BookController@update']);
	$router->delete('/books/{id}', ['uses' => 'BookController@destroy']);
});
