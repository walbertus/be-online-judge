<?php

namespace App\Api\V1\Domain\Problem\Entity;

use App\Api\V1\Domain\User\Entity\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Problem extends Model
{
    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_OWNER_ID = 'owner_id';
    const ATTRIBUTE_SLUG = 'slug';
    const ATTRIBUTE_TITLE = 'title';
    const ATTRIBUTE_DESCRIPTION = 'description';
    const ATTRIBUTE_MEMORY_LIMIT = 'memory_limit';
    const ATTRIBUTE_TIME_LIMIT = 'time_limit';
    const ATTRIBUTE_IS_PUBLIC = 'is_public';

    const DEFAULT_MEMORY_LIMIT = 64;
    const DEFAULT_TIME_LIMIT = 1000;

    protected $fillable = [
        self::ATTRIBUTE_SLUG,
        self::ATTRIBUTE_DESCRIPTION,
        self::ATTRIBUTE_TITLE,
        self::ATTRIBUTE_MEMORY_LIMIT,
        self::ATTRIBUTE_TIME_LIMIT,
        self::ATTRIBUTE_OWNER_ID,
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, self::ATTRIBUTE_OWNER_ID, User::ATTRIBUTE_ID);
    }

    public function getOwner(): User
    {
        return $this->owner;
    }
}
