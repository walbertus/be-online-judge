<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\MessageBag;


class ValidationException extends Exception
{
    protected $messageBag;

    public function __construct(MessageBag $errorMassages)
    {
        $this->messageBag = $errorMassages;
        parent::__construct('validation error', 400);
    }

    public function getMessageBag(): MessageBag
    {
        return $this->messageBag;
    }
}
