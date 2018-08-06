<?php

namespace App\Api\V1\Domain\Problem\Repository;


use App\Api\V1\Domain\Problem\Param\ReadProblemParam;

class ProblemQueryGenerator
{
    public function buildQuery(ReadProblemParam $queryParams): array
    {
        $finalQuery = [];
        $finalQuery = ProblemQueryGenerator::buildOwnerIdQuery($finalQuery, $queryParams);

        return $finalQuery;
    }

    public function buildOwnerIdQuery(array $query, ReadProblemParam $queryParams): array
    {
        if ($queryParams->getOwnerId()) {
            $query[] = ['owner_id', $queryParams->getOwnerId()];
        }
        return $query;
    }
}