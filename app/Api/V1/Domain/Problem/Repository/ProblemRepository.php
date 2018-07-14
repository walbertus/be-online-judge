<?php

namespace App\Api\V1\Domain\Problem\Repository;

use App\Api\V1\Domain\Problem\Entity\Problem;

class ProblemRepository
{
    public function createOne(array $data): Problem
    {
        return Problem::create($data);
    }
}
