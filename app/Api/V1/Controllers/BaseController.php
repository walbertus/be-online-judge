<?php

namespace App\Api\V1\Controllers;

use App\Exceptions\ValidationException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use ValidatesRequests, Helpers;

    public function checkValidation(Validator $validation): void
    {
        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new ValidationException($errors);
        }
    }
}
