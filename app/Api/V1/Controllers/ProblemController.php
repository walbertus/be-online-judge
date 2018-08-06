<?php

namespace App\Api\V1\Controllers;


use App\Api\V1\Domain\Problem\Param\CreateProblemParam;
use App\Api\V1\Domain\Problem\Param\ReadProblemParam;
use App\Api\V1\Domain\Problem\Services\CreateProblemService;
use App\Api\V1\Domain\Problem\Services\ReadProblemService;
use App\Api\V1\Domain\Problem\Transformer\ProblemTransformer;
use App\Api\V1\Domain\User\Entity\User;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;

class ProblemController extends BaseController
{
    const QUERY_LIMIT = 'limit';
    const DEFAULT_LIMIT = 10;

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

    public function index(
        ProblemTransformer $problemTransformer,
        ReadProblemService $service,
        Request $request
    ): Response
    {
        $limit = $request->get(self::QUERY_LIMIT, self::DEFAULT_LIMIT);
        $fields = $request->only(ReadProblemParam::QUERY_PARAMS);

        $validation = $this->getValidationFactory()->make($fields, ReadProblemParam::QUERY_PARAMS_VALIDATION);
        $this->checkValidation($validation);

        $params = new ReadProblemParam();
        $params->fromArray($fields);

        $problems = $service->readMany($params, $limit);
        return $this->response->paginator($problems, $problemTransformer);
    }

    public function show(
        ProblemTransformer $problemTransformer,
        ReadProblemService $service,
        int $id
    ): Response
    {
        $problem = $service->readSingle($id);
        return $this->response->item($problem, $problemTransformer);
    }
}
