<?php

namespace App\Api\V1\Domain\Problem\Services;


use App\Api\V1\Domain\Problem\Entity\Problem;
use App\Api\V1\Domain\Problem\Param\ReadProblemParam;
use App\Api\V1\Domain\Problem\Repository\ProblemRepository;
use Illuminate\Contracts\Pagination\Paginator;

class ReadProblemService
{
    protected $repository;

    public function __construct(ProblemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function readMany(ReadProblemParam $param, int $limit): Paginator
    {
        return $this->repository->readMany($param, $limit);
    }

    public function readSingle(int $id): Problem
    {
        return $this->repository->readSingle($id);
    }
}