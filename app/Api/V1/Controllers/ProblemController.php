<?php

namespace App\Api\V1\Controllers;


use App\Api\V1\Domain\Problem\Param\CreateProblemQueryParam;
use App\Api\V1\Domain\Problem\Services\CreateProblemService;
use App\Api\V1\Domain\Problem\Transformer\ProblemTransformer;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;

class ProblemController extends BaseController
{

    public function store(
        CreateProblemService $service,
        Request $request,
        ProblemTransformer $transformer
    ): Response
    {
        $fields = $request->only(CreateProblemQueryParam::QUERY_PARAMS);

        $validation = $this->getValidationFactory()->make($fields, CreateProblemQueryParam::QUERY_PARAM_VALIDATION);
        $this->checkValidation($validation);

        $params = new CreateProblemQueryParam();
        $params->fromArray($fields);

        $problem = $service->createOne($params);

        return $this->response->item($problem, $transformer);
    }
}
