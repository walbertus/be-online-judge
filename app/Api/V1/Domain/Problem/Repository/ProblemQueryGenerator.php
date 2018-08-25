<?php

namespace App\Api\V1\Domain\Problem\Repository;


use App\Api\V1\Domain\Problem\Entity\Problem;
use App\Api\V1\Domain\Problem\Param\ReadProblemParam;

class ProblemQueryGenerator
{
    public function buildQuery(ReadProblemParam $queryParams): array
    {
        $finalQuery = [];
        $finalQuery = $this->buildOwnerIdQuery($finalQuery, $queryParams);
        $finalQuery = $this->buildIsPublicQuery($finalQuery, $queryParams);

        return $finalQuery;
    }

    public function buildOwnerIdQuery(array $query, ReadProblemParam $queryParams): array
    {
        if ($queryParams->getOwnerId()) {
            $query[] = [Problem::ATTRIBUTE_OWNER_ID, $queryParams->getOwnerId()];
        }
        return $query;
    }

    public function buildIsPublicQuery(array $query, ReadProblemParam $queryParams): array
    {
        if ($queryParams->getIsPublic() && !$queryParams->getOwnerId()) {
            $query[] = [Problem::ATTRIBUTE_IS_PUBLIC, $queryParams->getIsPublic()];
        }
        return $query;
    }
}