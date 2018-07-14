<?php

namespace App\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

class AccessDeniedException extends HttpException
{
    public function __construct(string $message = "Access denied")
    {
        parent::__construct(403, $message);
    }
}
