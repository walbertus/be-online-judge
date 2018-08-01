<?php

namespace App\Api\V1\Domain\Problem\Services;


use App\Api\V1\Domain\Problem\Entity\Problem;
use App\Api\V1\Domain\Problem\Param\ReadProblemParam;
use App\Api\V1\Domain\Problem\Repository\ProblemRepository;
use Illuminate\Database\Eloquent\Collection;

class ReadProblemService
{
    protected $repository;

    public function __construct(ProblemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function readMany(ReadProblemParam $param) : Collection
    {
        $offset = $param->getOffset();
        $limit = $param->getLimit();

        return $this->repository->readMany($offset,$limit);
    }

    public function readSingle(int $id) : Problem
    {
        return $this->repository->readSingle($id);
    }
}