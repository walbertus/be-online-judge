<?php
/**
 * Created by PhpStorm.
 * User: ferdinand
 * Date: 8/6/18
 * Time: 2:20 PM
 */

namespace App\Api\V1\Domain\Problem\Helper;


use App\Api\V1\Domain\Problem\Param\ReadProblemParam;

class ProblemQueryGenerator
{
    static public function buildQuery(ReadProblemParam $queryParams): array
    {
        $finalQuery = [];
        $finalQuery = ProblemQueryGenerator::buildOwnerIdQuery($finalQuery, $queryParams);

        return $finalQuery;
    }

    static public function buildOwnerIdQuery(array $query, ReadProblemParam $queryParams): array
    {
        if ($queryParams->getOwnerId()) {
            $query[] = ['owner_id', $queryParams->getOwnerId()];
        }
        return $query;
    }
}