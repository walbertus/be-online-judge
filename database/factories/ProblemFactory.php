<?php

use App\Api\V1\Domain\Problem\Entity\Problem;
use App\Api\V1\Domain\User\Entity\User;
use Faker\Generator as Faker;

$factory->define(Problem::class, function (Faker $faker): array {
    return [
        Problem::ATTRIBUTE_SLUG => $faker->unique()->word,
        Problem::ATTRIBUTE_TITLE => $faker->word,
        Problem::ATTRIBUTE_DESCRIPTION => $faker->text,
        Problem::ATTRIBUTE_MEMORY_LIMIT => Problem::DEFAULT_MEMORY_LIMIT,
        Problem::ATTRIBUTE_TIME_LIMIT => Problem::DEFAULT_TIME_LIMIT,
        Problem::ATTRIBUTE_OWNER_ID => User::first()->getKey(),
    ];
});
