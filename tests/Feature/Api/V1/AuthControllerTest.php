<?php

namespace Tests\Feature\Api\V1;

use App\Api\V1\Domain\User\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    const USER_PASSWORD_SHORT = 'sec';

    const URI_REGISTER = 'api/auth/register';

    public function testRegisterSuccess(): void
    {
        $respone = $this->call('POST', self::URI_REGISTER, [
            self::PARAM_NAME => self::USER_NAME,
            self::PARAM_EMAIL => self::USER_EMAIL,
            self::PARAM_PASSWORD => self::USER_PASSWORD,
        ]);
        $respone->assertStatus(201);
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
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $jsonResponse);
        $this->assertArrayHasKey(self::PARAM_EMAIL, $jsonResponse['errors']);
    }

    public function testRegisterValidationError(): void
    {
        $response = $this->call('POST', self::URI_REGISTER);
        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $jsonResponse);
        $this->assertArrayHasKey(self::PARAM_EMAIL, $jsonResponse['errors']);
        $this->assertArrayHasKey(self::PARAM_NAME, $jsonResponse['errors']);
        $this->assertArrayHasKey(self::PARAM_PASSWORD, $jsonResponse['errors']);

        $response = $this->call('POST', self::URI_REGISTER, [
            self::PARAM_NAME => self::USER_NAME,
            self::PARAM_EMAIL => self::USER_NAME,
            self::PARAM_PASSWORD => self::USER_PASSWORD_SHORT,
        ]);
        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $jsonResponse);
        $this->assertArrayHasKey(self::PARAM_PASSWORD, $jsonResponse['errors']);
        $this->assertArrayHasKey(self::PARAM_EMAIL, $jsonResponse['errors']);
    }

    protected function createUser(): void
    {
        factory(User::class)->create([
            User::ATTRIBUTE_EMAIL => self::USER_EMAIL,
        ]);
    }
}
