<?php

namespace App\Api\V1\Domain\Problem\Services;


use App\Api\V1\Domain\Problem\Repository\ProblemRepository;

class DeleteProblemService
{
    protected $repository;

    public function __construct(ProblemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}