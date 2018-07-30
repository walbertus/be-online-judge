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
        $param = $param->toArray();

        $offset = $param[ReadProblemParam::ATTRIBUTE_PAGE]*$param[ReadProblemParam::ATTRIBUTE_LIMIT];
        $limit = $param[ReadProblemParam::ATTRIBUTE_LIMIT];

        return $this->repository->readMany($offset,$limit);
    }

    public function readSingle($id) : Problem
    {
        return $this->repository->readSingle($id);
    }
}