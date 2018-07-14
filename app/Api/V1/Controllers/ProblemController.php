<?php

namespace App\Api\V1\Controllers;


use App\Api\V1\Domain\Problem\Param\CreateProblemQueryParam;
use App\Api\V1\Domain\Problem\Services\CreateProblemService;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;

class ProblemController extends BaseController
{

    public function store(
        CreateProblemService $service,
        Request $request
    ): Response
    {
        $this->checkRole('problem-setter');
        $fields = $request->only(CreateProblemQueryParam::QUERY_PARAMS);

        $validation = $this->getValidationFactory()->make($fields, CreateProblemQueryParam::QUERY_PARAM_VALIDATION);
        $this->checkValidation($validation);

        $params = new CreateProblemQueryParam();
        $params->fromArray($fields);

        $service->createOne($params);
        return $this->response->created();
    }
}