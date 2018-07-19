<?php

namespace App\Api\V1\Controllers;


use App\Api\V1\Domain\Problem\Param\CreateProblemParam;
use App\Api\V1\Domain\Problem\Services\CreateProblemService;
use App\Api\V1\Domain\User\Entity\User;
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
        $fields = $request->only(CreateProblemParam::QUERY_PARAMS);

        $validation = $this->getValidationFactory()->make($fields, CreateProblemParam::QUERY_PARAM_VALIDATION);
        $this->checkValidation($validation);

        $params = new CreateProblemParam();
        $params->fromArray($fields);

        $user = $this->getCurrentUser();
        $params->setOwnerId($user->getAttribute(User::ATTRIBUTE_ID));

        $service->createOne($params);
        return $this->response->created();
    }
}
