<?php

namespace App\Api\V1\Domain\Problem\Transformer;


use App\Api\V1\Domain\User\Entity\User;
use League\Fractal\TransformerAbstract;

class ProblemOwnerTransformer extends TransformerAbstract
{
    public function transform(?User $owner): array
    {
        return [
            User::ATTRIBUTE_ID => $owner->getAttribute(User::ATTRIBUTE_ID),
            User::ATTRIBUTE_NAME => $owner->getAttribute(User::ATTRIBUTE_NAME),
        ];
    }
}
