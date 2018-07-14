<?php

namespace App\Api\V1\Domain\Role\Transformer;

use App\Api\V1\Domain\Role\Entity\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role): array
    {
        return [
            Role::ATTRIBUTE_NAME => $role->getAttribute(Role::ATTRIBUTE_NAME),
            Role::ATTRIBUTE_TITLE => $role->getAttribute(Role::ATTRIBUTE_TITLE),
        ];
    }
}
