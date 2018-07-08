<?php

namespace Tests;


use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithoutEvents;

class FeatureTestCase extends TestCase
{
    use WithoutEvents;

    protected function callApi(
        string $method,
        string $uri,
        array $parameters = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        ?string $content = null
    ): TestResponse
    {
        $server['HTTP_ACCEPT'] = 'application/json';
        return $this->call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }
}
