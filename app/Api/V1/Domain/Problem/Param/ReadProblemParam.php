<?php

namespace App\Api\V1\Domain\Problem\Param;


use App\Api\V1\Domain\Problem\Entity\Problem;

class ReadProblemParam
{
    const QUERY_PARAMS = [
        Problem::ATTRIBUTE_OWNER_ID,
        Problem::ATTRIBUTE_IS_PUBLIC,
    ];

    const QUERY_PARAMS_VALIDATION = [
        Problem::ATTRIBUTE_OWNER_ID => 'numeric|nullable',
        Problem::ATTRIBUTE_IS_PUBLIC => 'boolean|nullable',
    ];

    protected $data = [];

    public function __construct()
    {
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = null;
        $this->data[Problem::ATTRIBUTE_IS_PUBLIC] = null;
    }

    public function fromArray(array $array): void
    {
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = $array[Problem::ATTRIBUTE_OWNER_ID];
        $this->data[Problem::ATTRIBUTE_IS_PUBLIC] = $array[Problem::ATTRIBUTE_IS_PUBLIC];
    }

    public function getOwnerId(): ?int
    {
        return $this->data[Problem::ATTRIBUTE_OWNER_ID];
    }

    public function getIsPublic(): ?int
    {
        return $this->data[Problem::ATTRIBUTE_IS_PUBLIC];
    }
}