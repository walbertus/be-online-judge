<?php

namespace App\Api\V1\Domain\Problem\Transformer;

use App\Api\V1\Domain\Problem\Entity\Problem;
use League\Fractal\TransformerAbstract;

class ProblemTransformer extends TransformerAbstract
{
    protected $transformer;

    public function __construct(ProblemOwnerTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function transform(Problem $problem): array
    {
        $owner = $problem->getOwner();
        $owner = $this->transformer->transform($owner);

        return [
            Problem::ATTRIBUTE_ID => $problem->getAttribute(Problem::ATTRIBUTE_ID),
            Problem::ATTRIBUTE_SLUG => $problem->getAttribute(Problem::ATTRIBUTE_SLUG),
            Problem::ATTRIBUTE_TITLE => $problem->getAttribute(Problem::ATTRIBUTE_TITLE),
            Problem::ATTRIBUTE_DESCRIPTION => $problem->getAttribute(Problem::ATTRIBUTE_DESCRIPTION),
            Problem::ATTRIBUTE_TIME_LIMIT => $problem->getAttribute(Problem::ATTRIBUTE_TIME_LIMIT),
            Problem::ATTRIBUTE_MEMORY_LIMIT => $problem->getAttribute(Problem::ATTRIBUTE_MEMORY_LIMIT),
            Problem::ATTRIBUTE_SLUG => $problem->getAttribute(Problem::ATTRIBUTE_SLUG),
            'owner' => $owner
        ];
    }
}
