<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group([
        'middleware' => 'api',
        'namespace' => 'App\Api\V1\Controllers',
    ], function (Router $api) {
        $api->group(['prefix' => 'auth'], function (Router $api) {
            $api->post('register', 'AuthController@register');
            $api->post('login', 'AuthController@login');
            $api->post('logout', 'AuthController@logout');
            $api->post('refresh', 'AuthController@refresh');
            $api->get('me', 'AuthController@me');
        });

        $api->group(['prefix' => 'problems'], function (Router $api) {
            $api->post('/', 'ProblemController@store')->middleware('auth:api');
            $api->get('/','ProblemController@index')->middleware('auth:api');
            $api->get('/{id}','ProblemController@show')->middleware('auth:api');
            $api->post('/{id}','ProblemController@update')->middleware('auth:api');
            $api->delete('/{id}','ProblemController@delete')->middleware('auth:api');
        });
    });
});
