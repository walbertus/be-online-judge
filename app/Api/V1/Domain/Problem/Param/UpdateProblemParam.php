<?php
namespace App\Api\V1\Domain\Problem\Param;


use App\Api\V1\Domain\Problem\Entity\Problem;

class UpdateProblemParam
{
    const FROM_STATEMENT = 'statement';
    const FROM_GRADING = 'grading';

    const QUERY_PARAMS = [
        UpdateProblemParam::FROM_STATEMENT => [
            Problem::ATTRIBUTE_SLUG,
            Problem::ATTRIBUTE_TITLE,
            Problem::ATTRIBUTE_DESCRIPTION,
        ],
        UpdateProblemParam::FROM_GRADING => [
            Problem::ATTRIBUTE_MEMORY_LIMIT,
            Problem::ATTRIBUTE_TIME_LIMIT,
        ],
    ];

    const QUERY_PARAM_VALIDATION = [
        UpdateProblemParam::FROM_STATEMENT => [
            Problem::ATTRIBUTE_SLUG => [
                'required',
                'regex:/^[A-Z0-9]+(?:-[A-Z0-9]+)*$/',
            ],
            Problem::ATTRIBUTE_TITLE => 'string|required',
            Problem::ATTRIBUTE_DESCRIPTION => 'string|required',
        ],
        UpdateProblemParam::FROM_GRADING => [
            Problem::ATTRIBUTE_MEMORY_LIMIT => 'numeric|between:0,255|required',
            Problem::ATTRIBUTE_TIME_LIMIT => 'numeric|between:0,10000|required',
        ],
    ];

    protected $data = [];
    protected $problem = null;

    public function __construct(int $id)
    {
        $this->problem = Problem::find($id);
        $this->data[Problem::ATTRIBUTE_SLUG] = null;
        $this->data[Problem::ATTRIBUTE_TITLE] = null;
        $this->data[Problem::ATTRIBUTE_DESCRIPTION] = null;
        $this->data[Problem::ATTRIBUTE_MEMORY_LIMIT] = null;
        $this->data[Problem::ATTRIBUTE_TIME_LIMIT] = null;
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = null;
    }

    public function fromArray(array $array): void
    {
        $this->data[Problem::ATTRIBUTE_SLUG] = isset($array[Problem::ATTRIBUTE_SLUG])
            ? $array[Problem::ATTRIBUTE_SLUG]
            : $this->problem->slug;
        $this->data[Problem::ATTRIBUTE_TITLE] = isset($array[Problem::ATTRIBUTE_TITLE])
            ?$array[Problem::ATTRIBUTE_TITLE]
            : $this->problem->title;
        $this->data[Problem::ATTRIBUTE_DESCRIPTION] = isset($array[Problem::ATTRIBUTE_DESCRIPTION])
            ? $array[Problem::ATTRIBUTE_DESCRIPTION]
            : $this->problem->description;
        $this->data[Problem::ATTRIBUTE_MEMORY_LIMIT] = isset($array[Problem::ATTRIBUTE_MEMORY_LIMIT])
            ? $array[Problem::ATTRIBUTE_MEMORY_LIMIT]
            : $this->problem->memoty_limit;
        $this->data[Problem::ATTRIBUTE_TIME_LIMIT] = isset($array[Problem::ATTRIBUTE_TIME_LIMIT])
            ? $array[Problem::ATTRIBUTE_TIME_LIMIT]
            : $this->problem->time_limit;
        $this->data[Problem::ATTRIBUTE_OWNER_ID] = isset($array[Problem::ATTRIBUTE_OWNER_ID])
            ? $array[Problem::ATTRIBUTE_OWNER_ID]
            : $this->problem->owner_id;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}