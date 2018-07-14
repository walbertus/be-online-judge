<?php

namespace App\Api\V1\Domain\User\Transformer;

use App\Api\V1\Domain\Role\Transformer\RoleTransformer;
use App\Api\V1\Domain\User\Entity\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    private $roleTransformer;

    public function __construct(RoleTransformer $roleTransformer)
    {
        $this->roleTransformer = $roleTransformer;
    }

    public function transform(User $user): array
    {
        $roles = $user->getRoles();
        $roles->transform(function ($role) {
            return $this->roleTransformer->transform($role);
        });

        return [
            'id' => $user->getAttribute(User::ATTRIBUTE_ID),
            'name' => $user->getAttribute(User::ATTRIBUTE_NAME),
            'email' => $user->getAttribute(User::ATTRIBUTE_EMAIL),
            'roles' => $roles,
        ];
    }
}
