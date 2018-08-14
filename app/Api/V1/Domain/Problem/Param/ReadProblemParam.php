<?php

namespace App\Api\V1\Domain\Problem\Param;


use App\Api\V1\Domain\Problem\Entity\Problem;

class ReadProblemParam
{
    const QUERY_PARAMS = [
        Problem::ATTRIBUTE_OWNER_ID,
    ];

    const QUERY_PARAMS_VALIDATION = [
        Problem::ATTRIBUTE_OWNER_ID => 'numeric|nullable',
    ];

    protected $data = [];

    public function __construct()
    {
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = null;
    }

    public function fromArray(array $array): void
    {
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = $array[Problem::ATTRIBUTE_OWNER_ID];
    }

    public function getOwnerId(): ?int
    {
        return $this->data[Problem::ATTRIBUTE_OWNER_ID];
    }
}