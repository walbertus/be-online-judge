<?php

namespace App\Api\V1\Controllers;

use App\Exceptions\ValidationException;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthController extends BaseController
{
    const QUERY_EMAIL = 'email';
    const QUERY_PASSWORD = 'password';

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'login']);
    }

    public function login(Request $request): Response
    {
        $credentials = $request->only([self::QUERY_EMAIL, self::QUERY_PASSWORD]);

        $validation = $this->validateLogin($credentials);

        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new ResourceException('Validation error', $errors);
        }

        if (!$token = auth()->attempt($credentials)) {
            throw new BadRequestHttpException('Credential mismatch');
        }

        return $this->respondWithToken($token);
    }

    protected function validateLogin(array $param): Validator
    {
        return $this->getValidationFactory()->make($param, [
            self::QUERY_EMAIL => 'string|required|email',
            self::QUERY_PASSWORD => 'string|required',
        ]);
    }

    public function me(): Response
    {
        return response()->json(auth()->user());
    }

    public function logout(): Response
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): Response
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token): Response
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
