<?php

namespace App\Api\V1\Domain\Problem\Services;

use App\Api\V1\Domain\Problem\Entity\Problem;
use App\Api\V1\Domain\Problem\Param\CreateProblemQueryParam;
use App\Api\V1\Domain\Problem\Repository\ProblemRepository;

class CreateProblemService
{
    protected $repository;

    public function __construct(ProblemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOne(CreateProblemQueryParam $param): Problem
    {
        return $this->repository->createOne($param->toArray());
    }
}
