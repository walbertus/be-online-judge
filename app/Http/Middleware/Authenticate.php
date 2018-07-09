<?php

namespace App\Http\Middleware;

use App\Exceptions\AccessDeniedException;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    protected function authenticate(array $guards)
    {
        try {
            parent::authenticate($guards);
        } catch (AuthenticationException $exception) {
            // Change to part of HttpException so Dingo can catch it
            throw new AccessDeniedException("Unauthorized access");
        }
    }
}
