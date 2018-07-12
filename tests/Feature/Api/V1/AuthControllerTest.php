<?php

namespace Tests\Feature\Api\V1;

use App\Api\V1\Domain\User\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\FeatureTestCase;

class AuthControllerTest extends FeatureTestCase
{
    use RefreshDatabase;

    const PARAM_NAME = 'name';
    const PARAM_EMAIL = 'email';
    const PARAM_PASSWORD = 'password';

    const USER_EMAIL = 'user@user.com';
    const USER_PASSWORD = 'secret';
    const USER_NAME = 'William AD';

    const USER_EMAIL_WRONG = 'w.albertusd@gmail.com';
    const USER_PASSWORD_SHORT = 'sec';
    const USER_PASSWORD_WRONG = 'secrets';

    const URI_REGISTER = 'api/auth/register';
    const URI_LOGIN = 'api/auth/login';
    const URI_ME = 'api/auth/me';

    public function testRegisterSuccess(): void
    {
        $response = $this->validRegister();
        $response->assertStatus(201);
    }

    protected function validRegister(): TestResponse
    {
        return $this->call('POST', self::URI_REGISTER, [
            self::PARAM_NAME => self::USER_NAME,
            self::PARAM_EMAIL => self::USER_EMAIL,
            self::PARAM_PASSWORD => self::USER_PASSWORD,
        ]);
    }

    public function testRegisterEmailAlreadyExist(): void
    {
        $this->createUser();
        $response = $this->call('POST', self::URI_REGISTER, [
            self::PARAM_NAME => self::USER_NAME,
            self::PARAM_EMAIL => self::USER_EMAIL,
            self::PARAM_PASSWORD => self::USER_PASSWORD,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                self::PARAM_EMAIL,
            ],
        ]);
    }

    public function testRegisterValidationError(): void
    {
        $response = $this->call('POST', self::URI_REGISTER);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                self::PARAM_EMAIL, self::PARAM_PASSWORD, self::PARAM_NAME,
            ],
        ]);

        $response = $this->call('POST', self::URI_REGISTER, [
            self::PARAM_NAME => self::USER_NAME,
            self::PARAM_EMAIL => self::USER_NAME,
            self::PARAM_PASSWORD => self::USER_PASSWORD_SHORT,
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                self::PARAM_PASSWORD, self::PARAM_EMAIL,
            ],
        ]);
    }

    public function testLoginSuccessful()
    {
        $this->validRegister();
        $response = $this->validLogin();
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token', 'token_type', 'expires_in',
        ]);
    }

    protected function validLogin(): TestResponse
    {
        return $this->call('POST', self::URI_LOGIN, [
            self::PARAM_EMAIL => self::USER_EMAIL,
            self::PARAM_PASSWORD => self::USER_PASSWORD,
        ]);
    }

    public function testLoginCredentialMismatchWrongPassword()
    {
        $this->createUser();
        $response = $this->call('POST', self::URI_LOGIN, [
            self::PARAM_EMAIL => self::USER_EMAIL,
            self::PARAM_PASSWORD => self::USER_PASSWORD_WRONG,
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'message',
            'status_code',
        ]);
        $jsonResponse = $this->responseToArray($response);
        $this->assertEquals($jsonResponse['message'], 'Credential mismatch');
        $this->assertEquals($jsonResponse['status_code'], 400);
    }

    public function testLoginCredentialMismatchWrongEmail()
    {
        $this->createUser();
        $response = $this->call('POST', self::URI_LOGIN, [
            self::PARAM_EMAIL => self::USER_EMAIL_WRONG,
            self::PARAM_PASSWORD => self::USER_PASSWORD,
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'message',
            'status_code',
        ]);
        $jsonResponse = $this->responseToArray($response);
        $this->assertEquals($jsonResponse['message'], 'Credential mismatch');
        $this->assertEquals($jsonResponse['status_code'], 400);
    }

    public function testLoginValidationError()
    {
        $this->createUser();
        $response = $this->callApi('POST', self::URI_LOGIN);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                self::PARAM_PASSWORD, self::PARAM_EMAIL,
            ],
        ]);
    }

    public function testMeSuccess()
    {
        $this->createUser();
        $loginResponse = $this->validLogin();
        $loginResponse = $this->responseToArray($loginResponse);
        $token = $loginResponse['access_token'];
        $header = [
            'Authorization' => "Bearer $token",
        ];
        $response = $this->callApi('GET', self::URI_ME, [], [], [], $header);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'name', 'email',
        ]);
    }

    public function testMeUnauthenticated()
    {
        $response = $this->callApi('GET', self::URI_ME);
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message', 'status_code',
        ]);
    }

    protected function createUser(): void
    {
        factory(User::class)->create([
            User::ATTRIBUTE_EMAIL => self::USER_EMAIL,
        ]);
    }
}
