<?php

namespace App\Api\V1\Domain\Problem\Repository;

use App\Api\V1\Domain\Problem\Entity\Problem;
use Illuminate\Contracts\Pagination\Paginator;

class ProblemRepository
{
    public function createOne(array $data): Problem
    {
        return Problem::create($data);
    }

    public function readMany(?int $ownerId, $limit): Paginator
    {
        if ($ownerId) {
            return Problem::where('owner_id', $ownerId)->paginate($limit);
        } else {
            return Problem::paginate($limit);
        }
    }

    public function readSingle(int $id): Problem
    {
        return Problem::find($id);
    }
}
