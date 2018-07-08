<?php

namespace Tests\Feature\Api\V1;

use App\Api\V1\Domain\User\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FeatureTestCase;

class AuthControllerTest extends FeatureTestCase
{
    use RefreshDatabase;

    const USER_EMAIL = 'user@user.com';
    const USER_PASSWORD = 'secret';
    const USER_NAME = 'William AD';

    public function testRegisterSuccess(): void
    {
        $respone = $this->call('POST', 'api/auth/register', [
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ]);
        $respone->assertStatus(201);
    }

    public function testRegisterEmailAlreadyExist(): void
    {
        $this->createUser();
        $response = $this->call('POST', 'api/auth/register', [
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ]);
        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $jsonResponse);
        $this->assertArrayHasKey('email', $jsonResponse['errors']);
    }

    public function testRegisterValidationError(): void
    {
        $response = $this->call('POST', 'api/auth/register');
        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $jsonResponse);
        $this->assertArrayHasKey('email', $jsonResponse['errors']);
        $this->assertArrayHasKey('name', $jsonResponse['errors']);
        $this->assertArrayHasKey('password', $jsonResponse['errors']);

        $response = $this->call('POST', 'api/auth/register', [
            'name' => self::USER_NAME,
            'email' => 'qweasd',
            'password' => 'qwe',
        ]);
        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $jsonResponse);
        $this->assertArrayHasKey('password', $jsonResponse['errors']);
        $this->assertArrayHasKey('email', $jsonResponse['errors']);
    }

    protected function createUser(): void
    {
        factory(User::class)->create([
            User::ATTRIBUTE_EMAIL => self::USER_EMAIL,
        ]);
    }
}
