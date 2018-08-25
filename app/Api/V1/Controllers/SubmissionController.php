<?php

namespace App\Api\V1\Controllers;


use App\Api\V1\Domain\Submission\Param\CreateSubmissionParam;
use App\Api\V1\Domain\Submission\Services\CreateSubmissionService;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;

class SubmissionController extends BaseController
{
    public function store(
        CreateSubmissionService $service,
        Request $request
    ): Response
    {
        $fields = $request->only(CreateSubmissionParam::QUERY_PARAMS);

        $validation = $this->getValidationFactory()->make($fields, CreateSubmissionParam::QUERY_PARAMS_VALIDATION);
        $this->checkValidation($validation);

        $params = new CreateSubmissionParam();
        $params->fromArray($fields);

        $service->createOne($params);
        return $this->response->created();
    }
}