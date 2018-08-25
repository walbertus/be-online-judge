<?php

namespace App\Api\V1\Domain\Submission\Services;


use App\Api\V1\Domain\Submission\Entity\Submission;
use App\Api\V1\Domain\Submission\Param\CreateSubmissionParam;
use App\Api\V1\Domain\Submission\Repository\SubmissionRepository;

class CreateSubmissionService
{
    protected $repository;

    public function __construct(SubmissionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOne(CreateSubmissionParam $param): Submission
    {
        $filename = $param->saveSubmissionCode();
        $param->setFilename($filename);
        return $this->repository->createOne($param->toArray());
    }
}