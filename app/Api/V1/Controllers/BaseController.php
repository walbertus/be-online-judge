<?php

namespace App\Api\V1\Controllers;

use App\Exceptions\AccessDeniedException;
use App\Exceptions\ValidationException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use ValidatesRequests, Helpers;

    protected function checkValidation(Validator $validation): void
    {
        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new ValidationException($errors);
        }
    }

    protected function checkRole(string $role)
    {
        $user = auth()->user();
        if (!$user->isA($role))
            throw new AccessDeniedException();
    }

}
