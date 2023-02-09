<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->post('signup','UserController@register');
    $router->post('login','UserController@authenticate');
    $router->get('todo_notes','TodoNoteController@index');
    $router->get('todo_notes/search','TodoNoteController@search');
    $router->post('todo_notes', 'TodoNoteController@store');
    $router->delete('todo_notes/{id}', 'TodoNoteController@destroy');
    $router->patch('todo_notes/{id}/mark_complete', 'TodoNoteController@markComplete');
    $router->patch('todo_notes/{id}/mark_incomplete', 'TodoNoteController@markIncomplete');
});