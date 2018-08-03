<?php

namespace App\Api\V1\Domain\Problem\Param;


class ReadProblemParam
{
    const ATTRIBUTE_OWNER_ID = 'owner_id';

    const QUERY_PARAMS = [
        ReadProblemParam::ATTRIBUTE_OWNER_ID,
    ];

    const QUERY_PARAMS_VALIDATION = [
        ReadProblemParam::ATTRIBUTE_OWNER_ID => 'numeric|nullable',
    ];

    protected $data = [];

    public function __construct()
    {
        $this->data[ReadProblemParam::ATTRIBUTE_OWNER_ID] = null;
    }

    public function fromArray(array $array): void
    {
        $this->data[ReadProblemParam::ATTRIBUTE_OWNER_ID] = $array[ReadProblemParam::ATTRIBUTE_OWNER_ID];
    }

    public function getOwnerId(): ?int
    {
        return $this->data[ReadProblemParam::ATTRIBUTE_OWNER_ID];
    }
}