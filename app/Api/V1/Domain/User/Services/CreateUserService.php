<?php

namespace App\Api\V1\Domain\User\Services;


use App\Api\V1\Domain\User\Entity\User;
use App\Api\V1\Domain\User\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateUserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOne(string $name, string $email, string $password): User
    {
        $user = $this->repository->create($name, $email, $password);

        if ($user)
            return $user;

        throw new HttpException(500, 'Unable to create User');
    }
}
