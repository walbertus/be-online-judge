<?php
/**
 * Created by PhpStorm.
 * User: ferdinand
 * Date: 8/25/18
 * Time: 11:50 AM
 */

namespace App\Api\V1\Domain\Submission\Param;


use App\Api\V1\Domain\Submission\Entity\Submission;
use Illuminate\Support\Facades\Storage;

class CreateSubmissionParam
{
    const SUBMISSION_FILE_PARAM = 'submission_file';

    const QUERY_PARAMS = [
        Submission::ATTRIBUTE_USER_ID,
        Submission::ATTRIBUTE_PROBLEM_ID,
        Submission::ATTRIBUTE_CONTEST_ID,
        Submission::ATTRIBUTE_LANGUAGE_ID,
        self::SUBMISSION_FILE_PARAM,
    ];

    const QUERY_PARAMS_VALIDATION = [
        Submission::ATTRIBUTE_USER_ID => 'numeric|required',
        Submission::ATTRIBUTE_PROBLEM_ID => 'numeric|required',
        Submission::ATTRIBUTE_CONTEST_ID => 'numeric|nullable',
        Submission::ATTRIBUTE_LANGUAGE_ID => 'numeric|required',
        self::SUBMISSION_FILE_PARAM => 'file|required',
    ];

    protected $data = [];
    protected $submissionFile = null;

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
        $this->data[Submission::ATTRIBUTE_CONTEST_ID] = $array[Submission::ATTRIBUTE_CONTEST_ID];
        $this->data[Submission::ATTRIBUTE_LANGUAGE_ID] = $array[Submission::ATTRIBUTE_LANGUAGE_ID];
        $this->submissionFile = $array[self::SUBMISSION_FILE_PARAM];
    }

    public function saveSubmissionFile(): string
    {
        $contestPath = ($this->getContestId() !== null) ? 'contest/' . $this->getContestId() : '';

        $destinationPath = storage_path(
            $contestPath .
            '/problem/' . $this->getProblemId()
        );

        $this->checkDirectory($destinationPath);

        $filename = $this->getUserId() . now()->timestamp . $this->submissionFile->getClientOriginalName();

        Storage::putFileAs(
            self::SUBMISSION_FILE_PARAM,
            $this->submissionFile,
            $filename
        );

        return $destinationPath . $filename;
    }

    public function getContestId(): int
    {
        return $this->data[Submission::ATTRIBUTE_CONTEST_ID];
    }

    public function getProblemId(): int
    {
        return $this->data[Submission::ATTRIBUTE_PROBLEM_ID];
    }

    public function checkDirectory(string $path): void
    {
        if (is_dir($path)) {
            Storage::makeDirectory($path);
        }
    }

    public function getUserId(): int
    {
        return $this->data[Submission::ATTRIBUTE_USER_ID];
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