<?php

namespace App\Api\V1\Domain\Problem\Param;


class ReadProblemParam
{
    const ATTRIBUTE_PAGE = 'page';
    const ATTRIBUTE_LIMIT = 'limit';

    const QUERY_INDEX_PARAMS = [
        ReadProblemParam::ATTRIBUTE_PAGE,
        ReadProblemParam::ATTRIBUTE_LIMIT,
    ];

    protected $data;

    public function __construct()
    {
        $this->data[ReadProblemParam::ATTRIBUTE_PAGE] = null;
        $this->data[ReadProblemParam::ATTRIBUTE_LIMIT] = null;
    }

    public function fromArray(array $array) : void
    {
        $this->data[ReadProblemParam::ATTRIBUTE_PAGE] = $array[ReadProblemParam::ATTRIBUTE_PAGE];
        $this->data[ReadProblemParam::ATTRIBUTE_LIMIT] = $array[ReadProblemParam::ATTRIBUTE_LIMIT];
    }

    public function toArray() : array
    {
        return $this->data;
    }
}