<?php

namespace App\Api\V1\Domain\Submission\Repository;


use App\Api\V1\Domain\Submission\Entity\Submission;

class SubmissionRepository
{
    public function createOne(array $data): Submission
    {
        return Submission::create($data);
    }
}