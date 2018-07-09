<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    protected function authenticate(array $guards)
    {
        try {
            parent::authenticate($guards);
        } catch (AuthenticationException $exception) {
            // Change to part of HttpException so Dingo can catch it
            throw new UnauthorizedHttpException(null, "User is not logged in");
        }
    }
}
