<?php

namespace App\Api\V1\Domain\Problem\Param;


use App\Api\V1\Domain\Problem\Entity\Problem;

class UpdateProblemParam
{
    const QUERY_PARAMS = [
        Problem::ATTRIBUTE_SLUG,
        Problem::ATTRIBUTE_TITLE,
        Problem::ATTRIBUTE_DESCRIPTION,
        Problem::ATTRIBUTE_MEMORY_LIMIT,
        Problem::ATTRIBUTE_TIME_LIMIT,
        Problem::ATTRIBUTE_IS_PUBLIC,
    ];

    const QUERY_PARAM_VALIDATION = [
        Problem::ATTRIBUTE_SLUG => [
            'nullable',
            'regex:/^[A-Z0-9]+(?:-[A-Z0-9]+)*$/',
        ],
        Problem::ATTRIBUTE_TITLE => 'string|nullable',
        Problem::ATTRIBUTE_DESCRIPTION => 'string|nullable',
        Problem::ATTRIBUTE_MEMORY_LIMIT => 'numeric|between:0,255|nullable',
        Problem::ATTRIBUTE_TIME_LIMIT => 'numeric|between:0,10000|nullable',
        Problem::ATTRIBUTE_IS_PUBLIC => 'boolean|nullable',
    ];

    protected $data = [];

    public function __construct(int $id)
    {
        $this->data[Problem::ATTRIBUTE_SLUG] = null;
        $this->data[Problem::ATTRIBUTE_TITLE] = null;
        $this->data[Problem::ATTRIBUTE_DESCRIPTION] = null;
        $this->data[Problem::ATTRIBUTE_MEMORY_LIMIT] = null;
        $this->data[Problem::ATTRIBUTE_TIME_LIMIT] = null;
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = null;
        $this->data[Problem::ATTRIBUTE_IS_PUBLIC] = null;
    }

    public function fromArray(array $array): void
    {
        $this->data[Problem::ATTRIBUTE_SLUG] = isset($array[Problem::ATTRIBUTE_SLUG])
            ? $array[Problem::ATTRIBUTE_SLUG]
            : null;
        $this->data[Problem::ATTRIBUTE_TITLE] = isset($array[Problem::ATTRIBUTE_TITLE])
            ? $array[Problem::ATTRIBUTE_TITLE]
            : null;
        $this->data[Problem::ATTRIBUTE_DESCRIPTION] = isset($array[Problem::ATTRIBUTE_DESCRIPTION])
            ? $array[Problem::ATTRIBUTE_DESCRIPTION]
            : null;
        $this->data[Problem::ATTRIBUTE_MEMORY_LIMIT] = isset($array[Problem::ATTRIBUTE_MEMORY_LIMIT])
            ? $array[Problem::ATTRIBUTE_MEMORY_LIMIT]
            : null;
        $this->data[Problem::ATTRIBUTE_TIME_LIMIT] = isset($array[Problem::ATTRIBUTE_TIME_LIMIT])
            ? $array[Problem::ATTRIBUTE_TIME_LIMIT]
            : null;
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = isset($array[Problem::ATTRIBUTE_OWNER_ID])
            ? $array[Problem::ATTRIBUTE_OWNER_ID]
            : null;
        $this->data[Problem::ATTRIBUTE_IS_PUBLIC] = isset($array[Problem::ATTRIBUTE_IS_PUBLIC])
            ? $array[Problem::ATTRIBUTE_IS_PUBLIC]
            : null;
    }

    public function toArray(): array
    {
        $array = [];
        foreach (self::QUERY_PARAMS as $param) {
            if ($this->data[$param] !== null) {
                $array[$param] = $this->data[$param];
            }
        }
        return $array;
    }
}