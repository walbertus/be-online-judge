<?php

namespace App\Api\V1\Domain\Role\Entity;

use Silber\Bouncer\Database\Role as BouncerRole;


class Role extends BouncerRole
{
    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_NAME = 'name';
    const ATTRIBUTE_TITLE = 'title';
}
