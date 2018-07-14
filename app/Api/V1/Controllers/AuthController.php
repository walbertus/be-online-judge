<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Domain\User\Services\CreateUserService;
use App\Api\V1\Domain\User\Transformer\UserTransformer;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthController extends BaseController
{
    const QUERY_EMAIL = 'email';
    const QUERY_PASSWORD = 'password';
    const QUERY_NAME = 'name';

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(
        CreateUserService $service,
        Request $request
    )
    {
        $fields = $request->only([self::QUERY_NAME, self::QUERY_EMAIL, self::QUERY_PASSWORD]);

        $validation = $this->validateRegister($fields);

        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new ValidationException($errors);
        }

        $name = $fields[self::QUERY_NAME];
        $email = $fields[self::QUERY_EMAIL];
        $password = $fields[self::QUERY_PASSWORD];

        $service->createOne($name, $email, $password);

        return $this->response->created();
    }

    protected function validateRegister(array $param): Validator
    {
        return $this->getValidationFactory()->make($param, [
            self::QUERY_NAME => 'string|max:255|required',
            self::QUERY_EMAIL => 'string|email|max:255|required|unique:users',
            self::QUERY_PASSWORD => 'required|between:6,255',
        ]);
    }

    public function login(Request $request): Response
    {
        $credentials = $request->only([self::QUERY_EMAIL, self::QUERY_PASSWORD]);

        $validation = $this->validateLogin($credentials);

        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new ValidationException($errors);
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

    public function me(UserTransformer $userTransformer): Response
    {
        $user = auth()->user();
        return $this->response->item($user, $userTransformer);
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
