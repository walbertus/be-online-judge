<?php

namespace App\Api\V1\Domain\User\Entity;

use App\Api\V1\Domain\Problem\Entity\Problem;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRolesAndAbilities;

    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_NAME = 'name';
    const ATTRIBUTE_EMAIL = 'email';
    const ATTRIBUTE_PASSWORD = 'password';
    const ATTRIBUTE_REMEMBER_TOKEN = 'remember_token';

    public function problems(): HasMany
    {
        return $this->hasMany(Problem::class, Problem::ATTRIBUTE_OWNER_ID, self::ATTRIBUTE_ID);
    }

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

    public function getRoles(): Collection
    {
        return $this->roles;
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
