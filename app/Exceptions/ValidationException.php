<?php

namespace App\Exceptions;


use Dingo\Api\Exception\ResourceException;
use Illuminate\Support\MessageBag;

class ValidationException extends ResourceException
{
    public function __construct(MessageBag $errors)
    {
        parent::__construct('Validation error', $errors);
    }
}
