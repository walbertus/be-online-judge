<?php

use App\Api\V1\Domain\Problem\Entity\Problem;
use Illuminate\Database\Seeder;

class ProblemsTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(Problem::class, 5)->create();
    }
}
