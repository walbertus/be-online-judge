<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group([
        'middleware' => 'api',
        'namespace' => 'App\Api\V1\Controllers',
    ], function (Router $api) {
        $api->group(['prefix' => 'auth'], function (Router $api) {
            $api->post('login', 'AuthController@login');
            $api->post('logout', 'AuthController@logout');
            $api->post('refresh', 'AuthController@refresh');
            $api->get('me', 'AuthController@me');
        });
    });
});
