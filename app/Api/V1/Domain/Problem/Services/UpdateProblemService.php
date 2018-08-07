<?php

namespace App\Api\V1\Domain\Problem\Services;


use App\Api\V1\Domain\Problem\Entity\Problem;
use App\Api\V1\Domain\Problem\Param\UpdateProblemParam;
use App\Api\V1\Domain\Problem\Repository\ProblemRepository;

class UpdateProblemService
{
    protected $repository;

    public function __construct(ProblemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(int $id,UpdateProblemParam $param): void
    {
        $this->repository->update($id,$param->toArray());
    }
}