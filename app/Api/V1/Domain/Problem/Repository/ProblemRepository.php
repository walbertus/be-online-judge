<?php

namespace App\Api\V1\Domain\Problem\Repository;

use App\Api\V1\Domain\Problem\Entity\Problem;
use Illuminate\Database\Eloquent\Collection;

class ProblemRepository
{
    public function createOne(array $data): Problem
    {
        return Problem::create($data);
    }

    public function readMany($offset, $limit): Collection
    {
        return Problem::skip($offset)->take($limit)->get();
    }

    public function readSingle($id): Problem
    {
        return Problem::find($id);
    }
}
