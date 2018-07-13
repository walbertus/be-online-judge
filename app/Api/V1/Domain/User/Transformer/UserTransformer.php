<?php

namespace App\Api\V1\Domain\User\Transformer;

use App\Api\V1\Domain\User\Entity\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->getAttribute(User::ATTRIBUTE_ID),
            'name' => $user->getAttribute(User::ATTRIBUTE_NAME),
            'email' => $user->getAttribute(User::ATTRIBUTE_EMAIL),
        ];
    }
}
