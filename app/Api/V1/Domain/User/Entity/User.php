<?php

namespace App\Api\V1\Domain\User\Entity;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRolesAndAbilities;

    const ATTRIBUTE_NAME = 'name';
    const ATTRIBUTE_EMAIL = 'email';
    const ATTRIBUTE_PASSWORD = 'password';
    const ATTRIBUTE_REMEMBER_TOKEN = 'remember_token';

    public function setName(string $name): void
    {
        $this->setAttribute(self::ATTRIBUTE_NAME, $name);
    }

    public function setEmail(string $email): void
    {
        $this->setAttribute(self::ATTRIBUTE_EMAIL, $email);
    }

    public function setPassword(string $password): void
    {
        $hashedPassword = Hash::make($password);
        $this->setAttribute(self::ATTRIBUTE_PASSWORD, $hashedPassword);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    protected $fillable = [
        self::ATTRIBUTE_NAME,
        self::ATTRIBUTE_PASSWORD,
        self::ATTRIBUTE_EMAIL,
    ];

    protected $hidden = [
        self::ATTRIBUTE_PASSWORD,
        self::ATTRIBUTE_REMEMBER_TOKEN,
    ];
}
