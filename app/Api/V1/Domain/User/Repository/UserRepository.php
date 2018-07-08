<?php

namespace App\Api\V1\Domain\User\Repository;


use App\Api\V1\Domain\User\Entity\User;

class UserRepository
{
    public function create(string $name, string $email, string $password): ?User
    {
        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);

        return $user->save() ? $user : null;
    }

}
