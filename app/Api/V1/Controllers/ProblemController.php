<?php

namespace App\Api\V1\Controllers;


use App\Api\V1\Domain\Problem\Param\CreateProblemParam;
use App\Api\V1\Domain\Problem\Param\ReadProblemParam;
use App\Api\V1\Domain\Problem\Param\UpdateProblemParam;
use App\Api\V1\Domain\Problem\Services\CreateProblemService;
use App\Api\V1\Domain\Problem\Services\DeleteProblemService;
use App\Api\V1\Domain\Problem\Services\ReadProblemService;
use App\Api\V1\Domain\Problem\Services\UpdateProblemService;
use App\Api\V1\Domain\Problem\Transformer\ProblemTransformer;
use App\Api\V1\Domain\User\Entity\User;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;

class ProblemController extends BaseController
{
    const QUERY_LIMIT = 'limit';
    const DEFAULT_LIMIT = 10;

    const QUERY_FROM = 'from';
    const FROM_STATEMENT = 'statement';
    const FROM_GRADING = 'grading';

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

    public function update(
        UpdateProblemService $service,
        Request $request,
        int $id
    ): Response
    {
        $this->checkRole('problem-setter');
        $sourcePost = $request->get(self::QUERY_FROM);
        $fields = $request->only(UpdateProblemParam::QUERY_PARAMS[$sourcePost]);

        $validation = $this->getValidationFactory()->make($fields,UpdateProblemParam::QUERY_PARAM_VALIDATION[$sourcePost]);
        $this->checkValidation($validation);

        $params = new UpdateProblemParam($id);
        $params->fromArray($fields);

        $service->update($id,$params);
        return $this->response->created();
    }

    public function delete(
        DeleteProblemService $service,
        int $id
    ): Response
    {
        $this->checkRole('problem-setter');
        $service->delete($id);
        return $this->response->created();
    }
}
