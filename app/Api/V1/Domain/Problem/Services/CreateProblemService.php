<?php

namespace App\Api\V1\Domain\Problem\Services;

use App\Api\V1\Domain\Problem\Entity\Problem;
use App\Api\V1\Domain\Problem\Param\CreateProblemParam;
use App\Api\V1\Domain\Problem\Repository\ProblemRepository;

class CreateProblemService
{
    protected $repository;

    public function __construct(ProblemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOne(CreateProblemParam $param): Problem
    {
        return $this->repository->createOne($param->toArray());
    }
}
