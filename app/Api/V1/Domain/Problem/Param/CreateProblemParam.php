<?php

namespace App\Api\V1\Domain\Problem\Param;

use App\Api\V1\Domain\Problem\Entity\Problem;

class CreateProblemParam
{
    const QUERY_PARAMS = [
        Problem::ATTRIBUTE_SLUG,
        Problem::ATTRIBUTE_TITLE,
        Problem::ATTRIBUTE_DESCRIPTION,
        Problem::ATTRIBUTE_MEMORY_LIMIT,
        Problem::ATTRIBUTE_TIME_LIMIT,
    ];

    const QUERY_PARAM_VALIDATION = [
        Problem::ATTRIBUTE_SLUG => [
            'required',
            'regex:/^[A-Z0-9]+(?:-[A-Z0-9]+)*$/',
            'unique:problems,slug'
        ],
        Problem::ATTRIBUTE_TITLE => 'string|required',
        Problem::ATTRIBUTE_DESCRIPTION => 'string|required',
        Problem::ATTRIBUTE_MEMORY_LIMIT => 'numeric|nullable|between:0,255',
        Problem::ATTRIBUTE_TIME_LIMIT => 'numeric|nullable|between:0,10000',
    ];

    protected $data = [];

    public function __construct()
    {
        $this->data[Problem::ATTRIBUTE_SLUG] = null;
        $this->data[Problem::ATTRIBUTE_TITLE] = null;
        $this->data[Problem::ATTRIBUTE_DESCRIPTION] = null;
        $this->data[Problem::ATTRIBUTE_MEMORY_LIMIT] = null;
        $this->data[Problem::ATTRIBUTE_TIME_LIMIT] = null;
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = null;
    }

    public function fromArray(array $array): void
    {
        $this->data[Problem::ATTRIBUTE_SLUG] = $array[Problem::ATTRIBUTE_SLUG];
        $this->data[Problem::ATTRIBUTE_TITLE] = $array[Problem::ATTRIBUTE_TITLE];
        $this->data[Problem::ATTRIBUTE_DESCRIPTION] = $array[Problem::ATTRIBUTE_DESCRIPTION];
        $this->data[Problem::ATTRIBUTE_MEMORY_LIMIT] = isset($array[Problem::ATTRIBUTE_MEMORY_LIMIT])
            ? $array[Problem::ATTRIBUTE_MEMORY_LIMIT]
            : Problem::DEFAULT_MEMORY_LIMIT;
        $this->data[Problem::ATTRIBUTE_TIME_LIMIT] = isset($array[Problem::ATTRIBUTE_TIME_LIMIT])
            ? $array[Problem::ATTRIBUTE_TIME_LIMIT]
            : Problem::DEFAULT_TIME_LIMIT;
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = isset($array[Problem::ATTRIBUTE_OWNER_ID])
            ? $array[Problem::ATTRIBUTE_OWNER_ID]
            : null;
    }

    public function setOwnerId(int $ownerId): void
    {
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = $ownerId;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}