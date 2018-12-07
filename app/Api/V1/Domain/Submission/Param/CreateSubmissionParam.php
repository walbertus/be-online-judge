<?php

namespace App\Api\V1\Domain\Submission\Param;


use App\Api\V1\Domain\Submission\Entity\Submission;
use Illuminate\Support\Facades\Storage;

class CreateSubmissionParam
{
    const SUBMISSION_CODE_PARAM = 'submission_code';
    const DEFAULT_CONTEST_ID = 0;

    const QUERY_PARAMS = [
        Submission::ATTRIBUTE_USER_ID,
        Submission::ATTRIBUTE_PROBLEM_ID,
        Submission::ATTRIBUTE_CONTEST_ID,
        Submission::ATTRIBUTE_LANGUAGE_ID,
        self::SUBMISSION_CODE_PARAM,
    ];

    const QUERY_PARAMS_VALIDATION = [
        Submission::ATTRIBUTE_USER_ID => 'numeric|required',
        Submission::ATTRIBUTE_PROBLEM_ID => 'numeric|required',
        Submission::ATTRIBUTE_CONTEST_ID => 'numeric|nullable',
        Submission::ATTRIBUTE_LANGUAGE_ID => 'numeric|required',
        self::SUBMISSION_CODE_PARAM => 'string|required',
    ];

    protected $data = [];
    protected $submissionCode = null;

    public function __construct()
    {
        $this->data[Submission::ATTRIBUTE_USER_ID] = null;
        $this->data[Submission::ATTRIBUTE_PROBLEM_ID] = null;
        $this->data[Submission::ATTRIBUTE_CONTEST_ID] = null;
        $this->data[Submission::ATTRIBUTE_LANGUAGE_ID] = null;
        $this->data[Submission::ATTRIBUTE_FILENAME] = null;
    }

    public function fromArray(array $array): void
    {
        $this->data[Submission::ATTRIBUTE_USER_ID] = $array[Submission::ATTRIBUTE_USER_ID];
        $this->data[Submission::ATTRIBUTE_PROBLEM_ID] = $array[Submission::ATTRIBUTE_PROBLEM_ID];
        $this->data[Submission::ATTRIBUTE_CONTEST_ID] = isset($array[Submission::ATTRIBUTE_CONTEST_ID])
            ? $array[Submission::ATTRIBUTE_CONTEST_ID]
            : self::DEFAULT_CONTEST_ID;
        $this->data[Submission::ATTRIBUTE_LANGUAGE_ID] = $array[Submission::ATTRIBUTE_LANGUAGE_ID];
        $this->submissionCode = $array[self::SUBMISSION_CODE_PARAM];
    }

    public function checkDirectory(string $path): void
    {
        if (is_dir($path)) {
            Storage::makeDirectory($path);
        }
    }

    public function saveSubmissionCode(): string
    {
        $contestPath = ($this->getContestId() !== 0) ? 'contest/' . $this->getContestId() : '';

        $destinationPath = $contestPath . '/problem/' . $this->getProblemId() . '/' ;

        $this->checkDirectory($destinationPath);

        $filename = $destinationPath . $this->getUserId() . '_' . $this->getProblemId() . '_' . now()->timestamp . '_' .'solution.cpp';

        Storage::put($filename,$this->submissionCode);

        return $filename;
    }

    public function getContestId(): int
    {
        return $this->data[Submission::ATTRIBUTE_CONTEST_ID];
    }

    public function getProblemId(): int
    {
        return $this->data[Submission::ATTRIBUTE_PROBLEM_ID];
    }

    public function getUserId(): int
    {
        return $this->data[Submission::ATTRIBUTE_USER_ID];
    }

    public function getCode(): string
    {
        return $this->data[self::SUBMISSION_CODE_PARAM];
    }

    public function setFilename(string $filename): void
    {
        $this->data[Submission::ATTRIBUTE_FILENAME] = $filename;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}