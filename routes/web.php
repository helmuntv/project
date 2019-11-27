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

$router->post('/login',['uses' => 'UsersController@getToken']);

$router->get('/authors',['uses' => 'AuthorController@index']);
$router->post('/authors',['uses' => 'AuthorController@store']);
$router->get('/authors/{id}',['uses' => 'AuthorController@show']);
$router->put('/authors/{id}',['uses' => 'AuthorController@update']);
$router->patch('/authors/{id}',['uses' => 'AuthorController@update']);
$router->delete('/authors',['uses' => 'AuthorController@destroy']);

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function(){
    return str_random(32);
});

$router->group(['middleware' => ['auth']], function() use ($router){
    $router->get('/users', ['uses' => 'UsersController@index']);
    $router->post('/users', ['uses' => 'UsersController@createUser']);
    $router->put('/users/{id}', ['uses' => 'UsersController@updateUser']);
    $router->delete('/users/{id}', ['uses' => 'UsersController@deleteUser']);
});



