<?php

namespace App\Api\V1\Domain\Problem\Param;


class ReadProblemParam
{
    const ATTRIBUTE_LIMIT = 'limit';

    const QUERY_PARAMS = [
        ReadProblemParam::ATTRIBUTE_LIMIT,
    ];

    protected $data;

    public function __construct()
    {
        $this->data[ReadProblemParam::ATTRIBUTE_LIMIT] = null;
    }

    public function fromArray(array $array) : void
    {
        $this->data[ReadProblemParam::ATTRIBUTE_LIMIT] = $array[ReadProblemParam::ATTRIBUTE_LIMIT];
    }

    public function getLimit() : int
    {
        return $this->data[ReadProblemParam::ATTRIBUTE_LIMIT];
    }
}