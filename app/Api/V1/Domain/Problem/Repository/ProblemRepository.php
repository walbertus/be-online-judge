<?php

namespace App\Api\V1\Domain\Problem\Repository;

use App\Api\V1\Domain\Problem\Entity\Problem;
use App\Api\V1\Domain\Problem\Param\ReadProblemParam;
use Illuminate\Contracts\Pagination\Paginator;

class ProblemRepository
{
    protected $generator;

    public function __construct(ProblemQueryGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function createOne(array $data): Problem
    {
        return Problem::create($data);
    }

    public function readMany(ReadProblemParam $queryParams, int $limit): Paginator
    {
        $query = $this->generator->buildQuery($queryParams);
        return Problem::where($query)->paginate($limit);
    }

    public function readSingle(int $id): Problem
    {
        return Problem::find($id);
    }
}
