<?php

namespace App\Api\V1\Domain\Submission\Entity;


use App\Api\V1\Domain\User\Entity\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_USER_ID = 'user_id';
    const ATTRIBUTE_PROBLEM_ID = 'problem_id';
    const ATTRIBUTE_CONTEST_ID = 'contest_id';
    const ATTRIBUTE_LANGUAGE_ID = 'language_id';
    const ATTRIBUTE_VERDICT = 'verdict';
    const ATTRIBUTE_FILENAME = 'filename';

    protected $fillable = [
        self::ATTRIBUTE_USER_ID,
        self::ATTRIBUTE_PROBLEM_ID,
        self::ATTRIBUTE_CONTEST_ID,
        self::ATTRIBUTE_LANGUAGE_ID,
        self::ATTRIBUTE_VERDICT,
        self::ATTRIBUTE_FILENAME,
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, self::ATTRIBUTE_USER_ID, User::ATTRIBUTE_ID);
    }

    public function getOwner(): User
    {
        return $this->owner;
    }
}