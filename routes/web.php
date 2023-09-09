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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/list', 'ContaController@list');             // Lista que eu criei para orientação e visualização dos dados
$router->post('/conta', 'ContaController@create');          // O endpoint "/conta" deve criar e fornecer informações sobre o número da conta e o saldo
$router->get('/conta', 'ContaController@get');              // "
$router->post('/quinhentos', 'ContaController@quinhentos'); // Crie um endpoint na API que permita a criação de uma nova conta com um saldo inicial de R$500.
$router->post('/transacao', 'TransacaoController@create');  // O endpoint "/transacao" será responsável por realizar diversas operações financeiras.